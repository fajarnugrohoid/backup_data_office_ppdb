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

	function process_sort(&$listschool, $idx){
		
		if ($idx < count($listschool)){

			if ($listschool[$idx]['filtered']==0){
				
				$this->simple_sorting($listschool[$idx]['data'], 'total');

				$quota = $listschool[$idx]['quota'];
				$active_school = $listschool[$idx]['id'];
				
				$count_students = count($listschool[$idx]['data']);


	            if ($count_students > $quota) {
	            	//echo $count_students . '>'  . $quota . '<br/>';
	            	for ($i = $count_students - 1; $i > $quota - 1; $i--) {
	            		$second_choice = $listschool[$idx]['data'][$i]['second_choice'];
	            		//echo 'pil2:' . $second_choice . '<br/>';
	            		$idx_second_choice = $this->getArrayIndex($listschool, $second_choice);
	            		//echo 'idx:' . $idx_second_choice . '-second_choice:' . $second_choice . '-active_school:' . $active_school.'<br/>';
	            		//echo '-' . $listschool[$idx]['data'][$i]['name'] . 'if pil2:' . $second_choice . '!=' . $active_school . '<br/>';

	            		$listschool[$idx]['data'][$i]['accepted_status'] = '2';
	                    $listschool[$idx]['data'][$i]['accepted_school'] = $second_choice;
	                    array_push($listschool[$idx_second_choice]['data'], $listschool[$idx]['data'][$i]);
	                    array_splice($listschool[$idx]['data'], $i, 1);
	                    $listschool[$idx_second_choice]['filtered'] = 0;
	                    $status = false;
	                    if ($second_choice != $active_school) {
	                    	
	                    	//echo '--!isset-' . $idx_second_choice . '<br/>';

	                    	if (!empty($listschool[$idx_second_choice])){
	                    		//echo '====!isset-' . $second_choice .'<br/>';
	                    		$listschool[$idx]['data'][$i]['accepted_status'] = '3';
	                            $listschool[$idx]['data'][$i]['accepted_school'] = '9999';
	                            array_push($listschool[$this->getArrayIndex($listschool, '9999')]['data'], $listschool[$idx]['data'][$i]);
	                            array_splice($listschool[$idx]['data'], $i, 1);
	                       }
	                    }     $listschool[$this->getArrayIndex($listschool, '9999')]['filtered'] = 1;
	                    	
	                }
	            }

				$listschool[$idx]['filtered'] = 1;
				echo 'looping schoolidx:' . $idx . '<br/>';

				$idx++;
				$this->process_sort($listschool, $idx);	
				
			}
		}

		for($i=0;$i<count($listschool);$i++){
			if ($listschool[$i]['filtered']==0) $this->process_sort($listschool, $i);	
		}


	}


	function move_choice_student(&$listschool, $accepted_school, $accepted_status, $school_idx, $student_idx){
		$listschool[$school_idx]['data'][$student_idx]['accepted_status'] = $accepted_status;
        $listschool[$school_idx]['data'][$student_idx]['accepted_school'] = $accepted_school;
        array_push($listschool[$this->getArrayIndex($listschool, $accepted_school)]['data'], $listschool[$school_idx]['data'][$student_idx]);
        array_splice($listschool[$school_idx]['data'], $student_idx, 1);
	}

	function cut_school_under_pg(&$listschool, $count_students, $quota, $active_school, $school_idx, $status){
		for ($i = $count_students - 1; $i > $quota - 1; $i--) {

            $second_choice = $listschool[$school_idx]['data'][$i]['second_choice'];
            echo 'name:'. $listschool[$school_idx]['data'][$i]['name'] . '-' . $second_choice . '!=' . $active_school . '<br/>';

            //pas di looping si sakola eta, pilihan dua'na sarua jeung sekolah nu keur active di looping
            if ($second_choice == $active_school) {
            	$this->move_choice_student($listschool, '9999','3', $school_idx, $i);
            }else{ //move to second choice school
            	
            	$second_choice_idx = $this->getArrayIndex($listschool, $second_choice);

            	//second_choice==9999 or second choice is not exist -> buang
                if ( ($second_choice=='9999') || (!isset($listschool[$second_choice_idx]) ) ){
                	$this->move_choice_student($listschool, '9999','3', $school_idx, $i);

                }else{
                	$this->move_choice_student($listschool, $second_choice,'2', $school_idx, $i);
                    $listschool[$second_choice_idx]['filtered'] = 0;
                    $status = false;
                }

            	
            }

            	
        } //end for
        return $status;
	}

	function merge(&$listschool){
		$status = true;
		for($idx=0;$idx<count($listschool);$idx++){
			if ($listschool[$idx]['filtered']==0){
				$this->simple_sorting($listschool[$idx]['data'], 'total');

				$quota = $listschool[$idx]['quota'];
				$active_school = $listschool[$idx]['id'];
				$count_students = count($listschool[$idx]['data']);

				if ($count_students > $quota) {
					$status=$this->cut_school_under_pg($listschool, $count_students, $quota, $active_school, $idx, $status);
	            } // end if potong siswa

	        	$listschool[$idx]['filtered'] = 1;    
			} //end if check filtered
			
			echo 'idx school:' . $idx . '-school_id:' . $listschool[$idx]['id'] . '-filtered:' . $listschool[$idx]['filtered'] . '<br/><br/>';
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
		$this->merge($listschool);


		echo '<br/>';
		for($i=0;$i<count($listschool);$i++){
			echo 'idx:' . $i . '-schoolid:' . $listschool[$i]['id'] . '-filtered:' . $listschool[$i]['filtered'];
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
            $i=0;
	        foreach ($sekolah['data'] as $siswa) {
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