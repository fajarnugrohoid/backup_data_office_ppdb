<?php
ini_set('memory_limit', '1024M');
//require 'ViewData.php';
require 'InitializationData.php';

/*$viewData = new ViewData;
$viewData->showData();*/

/*$InitializationData = new InitializationData;
$listschool=$InitializationData->getSchool();*/

class Main extends InitializationData
{

	public $classConnection;
    public $conn;
    //var $listschool = [];

    public function __construct()
    {
        $this->initializationData = new InitializationData;
        
    }

    public function sorting(&$arr, $col_total, $col_total2, $col_n1, $col_n2, $col_n3, $col_n4, $col_skorjarak, $col_range)
    {
        $sort_col_total     = array();
        $sort_col_total2    = array();
        $sort_col_n1        = array();
        $sort_col_n2        = array();
        $sort_col_n3        = array();
        $sort_col_n4        = array();
        $sort_col_skorjarak = array();
        $sort_col_range = array();

        foreach ($arr as $key => $row) {
            $sort_col_total[$key]     = $row[$col_total];
            $sort_col_total2[$key]    = $row[$col_total2];
            $sort_col_n1[$key]        = $row[$col_n1];
            $sort_col_n2[$key]        = $row[$col_n2];
            $sort_col_n3[$key]        = $row[$col_n3];
            $sort_col_n4[$key]        = $row[$col_n4];
            $sort_col_skorjarak[$key] = $row[$col_skorjarak];
            $sort_col_range[$key] = $row[$col_range];
        }
        array_multisort($sort_col_total, SORT_DESC, $sort_col_total2, SORT_DESC, $sort_col_n1, SORT_DESC, $sort_col_n2, SORT_DESC, $sort_col_n3, SORT_DESC, $sort_col_n4, SORT_DESC, $sort_col_skorjarak, SORT_DESC, $sort_col_range, SORT_ASC,$arr);
    }


	function simple_sorting(&$arr, $col_total){
	    $sort_col_total = array();
	    foreach ($arr as $key => $row) {
	        $sort_col_total[$key] = $row[$col_total];
	    }
	    array_multisort($sort_col_total, SORT_DESC, $arr);
	}

	function faktorial($school_id){

		//$this->simple_sorting($school_id['data'], 'total');
		echo $school_id . '<br/>';
		print_r($school_id);
			/*foreach ($school_id['data'] as $students) {
				echo  $students['total']  . '-' . $students['name']  .  '<br/>';
			} */
		//$this->faktorial($a);

	}

	function getArrayIndex($array, $target){
		$indexArr = '';
		foreach ($array as $key => $value) {
			if ($value['id']==$target){
				$indexArr = $key;
				break;
			}
		}
		
		return $indexArr;
	}


	function move_choice_student(&$listschool, $region, $accepted_school, $accepted_status, $school_idx, $student_idx){
		$listschool[$school_idx][$region]['data'][$student_idx]['accepted_status'] = $accepted_status;
        $listschool[$school_idx][$region]['data'][$student_idx]['accepted_school'] = $accepted_school;
        array_push($listschool[$this->getArrayIndex($listschool, $accepted_school)]['data'], $listschool[$school_idx][$region]['data'][$student_idx]);
        array_splice($listschool[$school_idx][$region]['data'], $student_idx, 1);
	}

	function cut_school_under_pg(&$listschool, $region, $count_students, $quota, $active_school, $school_idx, $status){
		for ($i = $count_students - 1; $i > $quota - 1; $i--) {

            $first_choice = $listschool[$school_idx][$region]['data'][$i]['first_choice'];
            $second_choice = $listschool[$school_idx][$region]['data'][$i]['second_choice'];
            echo 'name:'. $listschool[$school_idx][$region]['data'][$i]['name'] . '-' . $second_choice . '!=' . $active_school . '<br/>';

            //pas di looping si sakola eta, pilihan dua'na sarua jeung sekolah nu keur active di looping
            if ($second_choice == $active_school) {
            	$this->move_choice_student($listschool, $region, '9999','3', $school_idx, $i);
            }else{ //move to second choice school
            	
            	$second_choice_idx = $this->getArrayIndex($listschool, $second_choice);

            	//second_choice==9999 or second choice is not exist -> buang
                if ( ($second_choice=='9999') || (!isset($listschool[$second_choice_idx]) ) ){
                	$this->move_choice_student($listschool,$region, '9999','3', $school_idx, $i);

                }else{
                	if ($region=='dw'){
                		$this->move_choice_student($listschool, 'gw', $first_choice,'1', $school_idx, $i);	
                	}
                	$this->move_choice_student($listschool, $region, $second_choice,'2', $school_idx, $i);
                    $listschool[$second_choice_idx][$region]['filtered'] = 0;
                    $status = false;
                }

            	
            }

            	
        } //end for
        return $status;
	}

	function merge(&$listschool,$region){
		$status = true;
		for($school_idx=0;$school_idx<count($listschool);$school_idx++){
			if ($listschool[$school_idx][$region]['filtered']==0){
				$this->simple_sorting($listschool[$school_idx][$region]['data'], 'total');

				$quota = $listschool[$school_idx][$region]['quota'];
				$active_school = $listschool[$school_idx][$region]['id'];
				$count_students = count($listschool[$school_idx][$region]['data']);

				if ($count_students > $quota) {
					$status=$this->cut_school_under_pg($listschool, $region, $count_students, $quota, $active_school, $school_idx, $status);
	            } // end if potong siswa

	        	$listschool[$school_idx][$region]['filtered'] = 1;    
			} //end if check filtered
			
			echo 'idx school:' . $school_idx . '-school_id:' . $listschool[$school_idx][$region]['id'] . '-filtered:' . $listschool[$school_idx][$region]['filtered'] . '<br/><br/>';
		} //end of for school loop

		if ($status==false){
			$this->merge($listschool);
		}

	}

	function merge_dw_gw(&$listschool,$region){
		$status = true;
		for($school_idx=0;$school_idx<count($listschool);$school_idx++){
			if ($listschool[$school_idx][$region]['filtered']==0){
				$this->sorting($listschool[$school_idx][$region]['data'], 'total1', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

				$quota = $listschool[$school_idx][$region]['quota'];
				$active_school = $listschool[$school_idx][$region]['id'];
				$count_students = count($listschool[$school_idx][$region]['data']);

				if ($count_students > $quota) {
					$status=$this->cut_school_under_pg($listschool, $region, $count_students, $quota, $active_school, $school_idx, $status);
	            } // end if potong siswa

	        	$listschool[$school_idx][$region]['filtered'] = 1;    
			} //end if check filtered
			
			echo 'idx school:' . $school_idx . '-school_id:' . $listschool[$school_idx][$region]['id'] . '-filtered:' . $listschool[$school_idx][$region]['filtered'] . '<br/><br/>';
		} //end of for school loop

		if ($status==false){
			$this->merge($listschool);
		}
	}

	function select_school(){
		$this->initializationData = new InitializationData;
		$listschool = $this->initializationData->getSchool();
		//$this->check_filtered($listschool, 0);
		//$listfiltered = $this->check_filtered($listschool, 0);
		//$listfiltered = $this->process_sort($listschool, 0);
		//$listfiltered = $this->process_sort($listschool, 0);
		$this->merge($listschool,'dw');
		$this->merge($listschool,'gw');
		$this->merge($listschool,'br');
		$this->merge($listschool,'lk');

		echo '<br/>';
		for($i=0;$i<count($listschool);$i++){
			echo 'idx:' . $i . '-schoolid:' . $listschool[$i]['dw']['id'] . '-filtered:' . $listschool[$i]['dw']['filtered'];
			echo '<br/>';
		}
		
		foreach ($listschool as $sekolah) {
            echo '<br/>id-' . $sekolah['id'] . '-' . $sekolah['name'] . '-Quota:' . $sekolah['quota'];
            echo '<table border="1">'
                . '<thead>'
                . '<tr bgcolor="#00ff00">'
                . '<td>No</td>'
                . '<td>Nama</td>'
                . '<td>Pilihan 1</td>'
                . '<td>Pilihan 2</td>'
                . '<td>Nilai1</td>'
                . '<td>Status Diterima</td>'
                . '</tr>'
                . '</thead>';
            echo '<tbody>';
            	
            	echo '<tr>' . 
            			'<td>DW</td>' . 
            			'<td colspan="5">Quota : ' . $sekolah['dw']['quota'] . '</td>' . 
            		'</tr>';

            	$i=0;
	        	foreach ($sekolah['dw']['data'] as $siswa) {
	                $i++;
	                echo '<tr>'
	                    . '<td>' . $i . '</td>'
	                    . '<td>' . $siswa['name'] . '</td>'
	                    . '<td>' . $siswa['first_choice'] . '</td>'
	                    . '<td>' . $siswa['second_choice'] . '</td>'
	                    . '<td>' . $siswa['total1'] . '</td>'
	                    . '<td>' . $siswa['accepted_status'] . '</td>'
	                    . '</tr>';
	            }

	            echo '<tr>' . 
            			'<td>GW</td>' . 
            			'<td colspan="5">Quota : ' . $sekolah['gw']['quota'] . '</td>' . 
            		'</tr>';
	            $i=0;
	            foreach ($sekolah['gw']['data'] as $siswa) {
	                $i++;
	                echo '<tr>'
	                    . '<td>' . $i . '</td>'
	                    . '<td>' . $siswa['name'] . '</td>'
	                    . '<td>' . $siswa['first_choice'] . '</td>'
	                    . '<td>' . $siswa['second_choice'] . '</td>'
	                    . '<td>' . $siswa['total1'] . '</td>'
	                    . '<td>' . $siswa['accepted_status'] . '</td>'
	                    . '</tr>';
	            }

	        	echo '<tr>' . 
            			'<td>BR</td>' . 
            			'<td colspan="5">Quota : ' . $sekolah['br']['quota'] . '</td>' . 
            		'</tr>';
	            $i=0;
	            foreach ($sekolah['br']['data'] as $siswa) {
	                $i++;
	                echo '<tr>'
	                    . '<td>' . $i . '</td>'
	                    . '<td>' . $siswa['name'] . '</td>'
	                    . '<td>' . $siswa['first_choice'] . '</td>'
	                    . '<td>' . $siswa['second_choice'] . '</td>'
	                    . '<td>' . $siswa['total1'] . '</td>'
	                    . '<td>' . $siswa['accepted_status'] . '</td>'
	                    . '</tr>';
	            }

				echo '<tr>' . 
            			'<td>LK</td>' . 
            			'<td colspan="5">Quota : ' . $sekolah['lk']['quota'] . '</td>' . 
            		'</tr>';           
	            $i=0;
	            foreach ($sekolah['lk']['data'] as $siswa) {
	                $i++;
	                echo '<tr>'
	                    . '<td>' . $i . '</td>'
	                    . '<td>' . $siswa['name'] . '</td>'
	                    . '<td>' . $siswa['first_choice'] . '</td>'
	                    . '<td>' . $siswa['second_choice'] . '</td>'
	                    . '<td>' . $siswa['total1'] . '</td>'
	                    . '<td>' . $siswa['accepted_status'] . '</td>'
	                    . '</tr>';
	            }
            echo '</tbody>';
            echo '</table>';
            echo '<br/><br/>';
        }
		/*foreach ($listschool as $schools) {
			$this->faktorial($schools['id']);
			
			echo '<br/><br/>';
		}*/
	}


}

$main = new Main;
$main->select_school();
//$main->splFixedArray();


?>