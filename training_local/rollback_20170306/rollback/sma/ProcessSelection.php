<?php
require 'InitializationData.php';
require 'Functions.php';
// base class with member properties and methods
class ProcessSelection extends InitializationData{

    public $initializationData;
    private $arrResultFunc=array();
    public $classConnection;
    public $conn;
    public $functions;
    public $history_idx = 0;
    public $historylist = array();
    public $listschool = array();
    //var $listsekolah = [];

    public function __construct()
    {
        $this->functions        = new Functions;
        $this->initializationData = new InitializationData;

        $this->listschool = $this->initializationData->getSchool();
        $this->historylist = $this->initializationData->history();
    }


    private function move_choice_student(&$listschool, $region_origin, $region_target, $accepted_school, $accepted_status, $school_idx, $student_idx){      
        $this->listschool[$school_idx][$region_origin]['data'][$student_idx]['accepted_status'] = $accepted_status;
        $this->listschool[$school_idx][$region_origin]['data'][$student_idx]['accepted_school'] = $accepted_school;
        array_push($this->listschool[$this->functions->getArrayIndex($this->listschool, $accepted_school)][$region_target]['data'], $this->listschool[$school_idx][$region_origin]['data'][$student_idx]);
        array_splice($this->listschool[$school_idx][$region_origin]['data'], $student_idx, 1);
    }

    private function cut_school_under_pg(&$listschool, $region_origin, $count_students, $quota, $active_school, $school_idx, $status){
        for ($student_idx = $count_students - 1; $student_idx > $quota - 1; $student_idx--) {
            
            $region_target = $region_origin;
            $second_choice = $this->listschool[$school_idx][$region_origin]['data'][$student_idx]['second_choice'];
            $is_insentif2 = $this->listschool[$school_idx][$region_origin]['data'][$student_idx]['is_insentif2'];
            //echo 'name:'. $this->listschool[$school_idx][$region_origin]['data'][$student_idx]['name'] . '-' . $second_choice . '!=' . $active_school . '<br/>';

            //pas di looping si sakola eta, pilihan dua'na sarua jeung sekolah nu keur active di looping
            if ($second_choice == $active_school) {
                $this->move_choice_student($this->listschool, $region_origin, $region_target, '9999','3', $school_idx, $student_idx);
            }else{ //move to second choice school
                
                $second_choice_idx = $this->functions->getArrayIndex($this->listschool, $second_choice);

                //second_choice==9999 or second choice is not exist -> buang
                if ( ($second_choice=='9999') || (!isset($this->listschool[$second_choice_idx]) ) ){
                    $this->move_choice_student($this->listschool,$region_origin, $region_target, '9999','3', $school_idx, $student_idx);

                }else{

                    if ( ($region_origin=='gw') && ($is_insentif2=='1')){
                        $region_target = 'dw';
                        $this->move_choice_student($this->listschool, $region_origin, $region_target, $second_choice,'2', $school_idx, $student_idx);
                        $this->listschool[$second_choice_idx][$region_target]['filtered'] = 0;
                    }else{
                        $this->move_choice_student($this->listschool, $region_origin, $region_target, $second_choice,'2', $school_idx, $student_idx);
                        $this->listschool[$second_choice_idx][$region_target]['filtered'] = 0;
                    }
                    
                    $status = false;
                }
                
            }

                
        } //end for
        return $status;
    }

    //cek nilai luar kota harus lebih dari bandung raya
    private function check_pg_lk_more_than_br(&$listschool, $region_origin, $count_students, $quota, $active_school, $school_idx, $pg_br){
        // echo 'pg_br:' . $pg_br . '<br/>';
        // echo '<pre>';
        // var_dump($this->listschool[$school_idx][$region_origin]); 
        // echo '</pre><br/>';
        for ($student_idx = $count_students - 1; $student_idx >= 0; $student_idx--) {
            
            $region_target = $region_origin;
            $second_choice = $this->listschool[$school_idx][$region_origin]['data'][$student_idx]['second_choice'];
            $total1 = $this->listschool[$school_idx][$region_origin]['data'][$student_idx]['total1'];
            //echo $total1 . '<' . $pg_br . '<br/>';
            if ($total1 < $pg_br){
                $this->move_choice_student($this->listschool,$region_origin, $region_target, '9999','3', $school_idx, $student_idx);
            }
        } //end for
    }

    private function merge(&$listschool,$region_origin){
        $status = true;
        
        for($school_idx=0;$school_idx<count($this->listschool);$school_idx++){
            if ($this->listschool[$school_idx][$region_origin]['filtered']==0){
                $this->functions->sorting($this->listschool[$school_idx][$region_origin]['data'], 'total1', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

                $quota = $this->listschool[$school_idx][$region_origin]['quota'];
                $active_school = $this->listschool[$school_idx][$region_origin]['id'];
                $count_students = count($this->listschool[$school_idx][$region_origin]['data']);

                if ($count_students > $quota) {
                    $status=$this->cut_school_under_pg($this->listschool, $region_origin, $count_students, $quota, $active_school, $school_idx, $status);
                } // end if potong siswa

                $this->listschool[$school_idx][$region_origin]['filtered'] = 1;    
            } //end if check filtered
            
            //echo 'idx school:' . $school_idx . '-school_id:' . $this->listschool[$school_idx][$region_origin]['id'] . '-filtered:' . $this->listschool[$school_idx][$region_origin]['filtered'] . '<br/><br/>';
        } //end of for school loop

        if ($status==false){
            $this->merge($this->listschool, $region_origin);
        }

    }

    private function get_pg($listschool, $region_origin, $target_school){
        // echo '<br>' . $target_school . '-' . $region_origin . '<pre>';
        // var_dump($listschool[$this->functions->getArrayIndex($listschool, $target_school)][$region_origin]['data']);
        // echo '</pre><br/>';
        $pg = 0;
        $last_index = end($this->listschool[$this->functions->getArrayIndex($this->listschool, $target_school)][$region_origin]['data']);
        if ($last_index!=false){
            $pg=$last_index['total1'];   
        }
        return $pg;
    }

    private function merge_br_lk(&$listschool){
        $status_br = true;
        $status_lk = true;
        
        $this->history_idx++;


        for($school_idx=0;$school_idx<count($this->listschool);$school_idx++){
            
            $this->functions->sorting($this->listschool[$school_idx]['br']['data'], 'total1', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

            $quota = $this->listschool[$school_idx]['br']['quota'];
            
            if ($this->listschool[$school_idx]['br']['filtered']==0){
                $this->functions->sorting($this->listschool[$school_idx]['br']['data'], 'total1', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

                $active_school = $this->listschool[$school_idx]['br']['id'];
                $count_students = count($this->listschool[$school_idx]['br']['data']);

                if ($count_students > $quota) {
                    $status_br=$this->cut_school_under_pg($this->listschool, 'br', $count_students, $quota, $active_school, $school_idx, $status_br);
                } // end if potong siswa

                $this->listschool[$school_idx]['br']['filtered'] = 1; 
            } //end if check filtered

            //echo $this->listschool[$school_idx]['br']['id'] . ':'. $quota . '-' . count($this->listschool[$school_idx]['br']['data']) . '<br/>';
            $remaining_quota = $quota - count($this->listschool[$school_idx]['br']['data']);
            echo '<br/>remaining_quota:' . $remaining_quota .  '-quota:' . $quota . '-data_br:' . count($this->listschool[$school_idx]['br']['data']) . '<br/><br/>';
            $quota = $remaining_quota;
            $count_students = count($this->listschool[$school_idx]['lk']['data']);
            $active_school = $this->listschool[$school_idx]['lk']['id'];
             $pg=$this->get_pg($this->listschool, 'br', $active_school);
                    echo $active_school . '-pg:' . $pg . '<br/>';



            echo $active_school . '-remaining_quota:' . $remaining_quota . '<br/>';
            if ($remaining_quota > 0){

                if ($this->listschool[$school_idx]['lk']['filtered']==0){
                    $this->functions->sorting($this->listschool[$school_idx]['lk']['data'], 'total1', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

                    //$quota = $this->listschool[$school_idx]['lk']['quota'];
                    echo 'cut_school_under_pg:' . $active_school . '-' . $count_students . '>' . $quota . '<br/>';
                    if ($count_students > $quota) {
                        $status_lk=$this->cut_school_under_pg($this->listschool, 'lk', $count_students, $quota, $active_school, $school_idx, $status_lk);
                    } // end if potong siswa

                    $count_students = count($this->listschool[$school_idx]['lk']['data']);
                    if ($pg!=0){
                        $this->check_pg_lk_more_than_br($this->listschool, 'lk', $count_students, $quota, $active_school, $school_idx, $pg);  
                    }

                    $this->listschool[$school_idx]['lk']['filtered'] = 1;    
                } //end if check filtered

            }else{
                //$status=$this->cut_school_under_pg($this->listschool, 'lk', $count_students, $quota, $active_school, $school_idx, $status);
                if ($count_students > 0){
                    for ($student_idx = $count_students - 1; $student_idx > $quota - 1; $student_idx--) {
                        $this->move_choice_student($this->listschool, 'lk', 'lk', '9999','3', $school_idx, $student_idx);
                    } //end for
                    $this->listschool[$school_idx]['lk']['filtered'] = 1;
                }
            }


            //echo 'listschool:'; var_dump($this->listschool[$school_idx]['br']['data']); echo '<br/>';
            $this->historylist[$this->history_idx][$school_idx]['br']['id'] = $this->listschool[$school_idx]['br']['id'];
            $this->historylist[$this->history_idx][$school_idx]['lk']['id'] = $this->listschool[$school_idx]['lk']['id'];
            $this->historylist[$this->history_idx][$school_idx]['br']['data'] = $this->listschool[$school_idx]['br']['data'];
            $this->historylist[$this->history_idx][$school_idx]['lk']['data'] = $this->listschool[$school_idx]['lk']['data'];
            echo 'historylist:' . $this->history_idx . '<br/>';
            
            $count_br_lk_students=count($this->listschool[$school_idx]['br']['data']) + count($this->listschool[$school_idx]['lk']['data']);
            if ($count_br_lk_students < $quota){
                $this->listschool[$school_idx]['gw']['quota'] = (int)$this->listschool[$school_idx]['gw']['quota']+1;
                $this->listschool[$school_idx]['br']['quota'] = (int)$this->listschool[$school_idx]['br']['quota']-1;
                $this->listschool[$school_idx]['lk']['quota'] = (int)$this->listschool[$school_idx]['lk']['quota']-1;

                $this->listschool[$school_idx]['dw']['filtered'] = 0;
                $this->listschool[$school_idx]['gw']['filtered'] = 0;
                $this->check_filtered($this->listschool,$school_idx, true, true);
            }
                        
            // echo 'idx school:' . $school_idx . '-school_id:' . $this->listschool[$school_idx]['lk']['id'] . '-filtered:' . $this->listschool[$school_idx]['lk']['filtered'] . '<br/><br/>';
        } //end of for school loop

        if (($status_br==false) ||  ($status_lk==false)){
            $this->merge_br_lk($this->listschool);
        }

    }

    private function merge_dw_gw(&$listschool){
        $status_dw = true;
        $status_gw = true;

        $this->history_idx++;

        for($school_idx=0;$school_idx<count($this->listschool);$school_idx++){
            //check for school accordance dw (dalam wilayah)
            $this->check_filtered($this->listschool,$school_idx, $status_dw, $status_gw);
        } //end of for school loop

        if (($status_dw==false) || ($status_gw==false)){
            $this->merge_dw_gw($this->listschool);
        }
    }

    function check_filtered(&$listschool,$school_idx, $status_dw, $status_gw){
        if ($this->listschool[$school_idx]['dw']['filtered']==0){
            $this->functions->sorting($this->listschool[$school_idx]['dw']['data'], 'total1', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

            $quota = $this->listschool[$school_idx]['dw']['quota'];
            $active_school = $this->listschool[$school_idx]['dw']['id'];
            $count_students = count($this->listschool[$school_idx]['dw']['data']);

            if ($count_students > $quota) {
                for ($i = $count_students - 1; $i > $quota - 1; $i--) {

                        $first_choice = $this->listschool[$school_idx]['dw']['data'][$i]['first_choice'];

                        $this->move_choice_student($this->listschool, 'dw', 'gw', $first_choice,'1', $school_idx, $i);
                        
                        $this->listschool[$school_idx]['gw']['filtered'] = 0;
                        $status_dw = false;
                            
                    } //end for
            } // end if potong siswa

            $this->listschool[$school_idx]['dw']['filtered'] = 1;    
        } //end if check filtered
        
        echo 'idx school:' . $school_idx . '-school_id:' . $this->listschool[$school_idx]['dw']['id'] . '-filtered:' . $this->listschool[$school_idx]['dw']['filtered'] . '<br/><br/>';

        //check for school accordance gw (gabungan wilayah)
        if ($this->listschool[$school_idx]['gw']['filtered']==0){
            $this->functions->sorting($this->listschool[$school_idx]['gw']['data'], 'total1', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

            $quota = $this->listschool[$school_idx]['gw']['quota'];
            $active_school = $this->listschool[$school_idx]['gw']['id'];
            $count_students = count($this->listschool[$school_idx]['gw']['data']);
            
            if ($count_students > $quota) {

                $status_gw=$this->cut_school_under_pg($this->listschool, 'gw', $count_students, $quota, $active_school, $school_idx, $status_gw);
                
            } // end if potong siswa

            $this->listschool[$school_idx]['gw']['filtered'] = 1;    
        } //end if check filtered

        $this->historylist[$this->history_idx][$school_idx]['dw']['id'] = $this->listschool[$school_idx]['dw']['id'];
        $this->historylist[$this->history_idx][$school_idx]['gw']['id'] = $this->listschool[$school_idx]['gw']['id'];
        $this->historylist[$this->history_idx][$school_idx]['dw']['data'] = $this->listschool[$school_idx]['dw']['data'];
        $this->historylist[$this->history_idx][$school_idx]['gw']['data'] = $this->listschool[$school_idx]['gw']['data'];

    }


    public function resultSelection(){
        $this->initializationData = new InitializationData;
        

        //$this->historylist;

        //$this->check_filtered($this->listschool, 0);
        //$listfiltered = $this->check_filtered($this->listschool, 0);
        //$listfiltered = $this->process_sort($this->listschool, 0);
        //$listfiltered = $this->process_sort($this->listschool, 0);
        $this->merge_br_lk($this->listschool,'br');
        $this->merge_dw_gw($this->listschool);
        //$this->merge($this->listschool,'lk');

        //var_dump($this->historylist[3]);
        echo json_encode($this->historylist, JSON_PRETTY_PRINT);
        // for($i=0;$i<count($this->historylist);$i++){
        //     echo json_encode($this->historylist[$i], JSON_PRETTY_PRINT);
        //     echo '<br/><br/><br/>';
        // }

        return $this->listschool;
        
    }

} // end of class ProcessSelection
