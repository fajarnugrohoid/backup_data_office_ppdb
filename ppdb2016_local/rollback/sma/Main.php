<?php
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

	function process_sort($listschool, $idx){
		
		if ($listschool[$idx]['filtered']==0){
			
			$this->simple_sorting($listschool[$idx]['data'], 'total');

			$quota = $listschool[$idx]['quota'];
			$active_school = $listschool[$idx]['id'];
			
			$count_students = count($listschool[$idx]['data']);


            if ($count_students > $quota) {
            	echo $count_students . '>'  . $quota . '<br/>';
            	for ($i = $count_students - 1; $i > $quota - 1; $i--) {
            		$second_choice = $listschool[$idx]['data'][$i]['second_choice'];
            		echo 'pil2:' . $second_choice . '<br/>';
            		$idx_second_choice = $this->getArrayIndex($listschool, $second_choice);

            		
                    if ($second_choice != $active_school) {
                    	echo '-' . $listschool[$idx]['data'][$i]['name'] . 'if pil2:' . $second_choice . '!=' . $active_school . '<br/>';
                    	echo '--!isset-' . $idx_second_choice . '<br/>';
                    	if (!isset($listschool[$idx_second_choice])){
                    		echo '====!isset-' . $second_choice . '-'  . $listschool[$idx_second_choice] . '<br/>';
                    		$listschool[$idx]['data'][$i]['accepted_status'] = '3';
                            $listschool[$idx]['data'][$i]['accepted_school'] = '9999';
                            array_push($listschool[$this->getArrayIndex($listschool, '9999')]['data'], $listschool[$idx]['data'][$i]);
                            array_splice($listschool[$idx]['data'], $i, 1);

                    	}
                    }
                }
            }


			
			
			$listschool[$idx]['filtered'] = 1;

			echo $active_school . '<br/>';

			$idx++;
			$this->process_sort($listschool, $idx);
		} 

		return $listschool;

	}

	function select_school(){
		$this->initializationData = new InitializationData;
		$listschool = $this->initializationData->getSchool();
		
		$listfiltered = $this->process_sort($listschool, 0);

		foreach ($listfiltered as $sekolah) {
            echo '<br/>id-' . $sekolah['id'] . '-' . $sekolah['name'];
            echo '<table border="1">'
                . '<thead>'
                . '<tr bgcolor="#00ff00">'
                . '<td>No</td>'
                . '<td>Nama</td>'
                . '<td>Pilihan 1</td>'
                . '<td>Pilihan 2</td>'
                . '<td>Nilai1</td>'
                . '<td>Nilai2</td>'
                . '<td>Bahasa</td>'
                . '<td>English</td>'
                . '<td>Math</td>'
                . '<td>Physics</td>'
                . '<td>Range1</td>'
                . '<td>Range2</td>'
                . '<td>Asal Pendaftar</td>'
                . '<td>IsIntensif1</td>'
                . '<td>IsIntensif2</td>'
                . '<td>Terima Di Wilayah (Is Foreigner)</td>'
                . '<td>Diterima Sekolah</td>'
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
	                    . '<td></td>'
	                    . '<td></td>'
	                    . '<td></td>'
	                    . '<td></td>'
	                    . '<td></td>'
	                    . '<td></td>'
	                    . '<td></td>'
	                    . '<td></td>'
	                    . '<td></td>'
	                    . '<td></td>'
	                    . '<td></td>'
	                    . '<td></td>'
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




?>