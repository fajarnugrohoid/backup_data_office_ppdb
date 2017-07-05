<?php
ini_set('max_execution_time', 10000);
ini_set("memory_limit","-1");
error_reporting(E_ERROR | E_ALL);

	# connection
	include('connection.php');

	$time_start = microtime(true);
	function sorting(&$arr, $col_total,$col_total2, $col_n1, $col_n2, $col_n3, $col_n4, $col_skorjarak) {
		$sort_col_total = array();
		$sort_col_total2 = array();
		$sort_col_n1 = array();
		$sort_col_n2 = array();
		$sort_col_n3 = array();
		$sort_col_n4 = array();
		$sort_col_skorjarak = array();

		foreach ($arr as $key=> $row) {
			$sort_col_total[$key] = $row[$col_total];
			$sort_col_total2[$key] = $row[$col_total2];
			$sort_col_n1[$key] = $row[$col_n1];
			$sort_col_n2[$key] = $row[$col_n2];
			$sort_col_n3[$key] = $row[$col_n3];
			$sort_col_n4[$key] = $row[$col_n4];
			$sort_col_skorjarak[$key] = $row[$col_skorjarak];
		}
		array_multisort($sort_col_total, SORT_DESC,$sort_col_total2, SORT_DESC,$sort_col_n1, SORT_DESC,$sort_col_n2, SORT_DESC,$sort_col_n3, SORT_DESC,$sort_col_n4, SORT_DESC, $sort_col_skorjarak,SORT_DESC, $arr);
	}

	function simple_sorting(&$arr, $col_total) {
		$sort_col_total = array();
		foreach ($arr as $key=> $row) {
			$sort_col_total[$key] = $row[$col_total];
		}
		array_multisort($sort_col_total, SORT_DESC, $arr);
	}

	
	#ambil data
	$query_sch  = "SELECT a.id as id,a.type,a.quota,b.name,b.is_border,substring(b.code,1,1) as code, a.quota_dw,a.quota_gw, b.foreigner_percentage 	
							FROM ppdb_option a
							inner join ppdb_school b on (a.school = b.id)
							where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 ) and a.type='academic'
							ORDER BY b.code, a.id";
	/*$query_sch  = "SELECT a.id as id,a.type,a.quota,b.name,b.is_border,substring(b.code,1,1) as code, a.quota_dw,a.quota_gw, b.foreigner_percentage 	
							FROM ppdb_option a
							inner join ppdb_school b on (a.school = b.id)
							where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 ) and a.type='academic'
							ORDER BY b.code, a.id"; */

	$resul1 = $mysqli->query($query_sch) or die(mysqli_error($mysqli));
	$update_tot_pendaftar='';

	while($row = mysqli_fetch_array($resul1)){ // sekolah
		$temp_total_pendaftar = 0;
		$temp_total_luar_kota = 0;
		/*start push siswa dalam wilayah*/
		$query  = "SELECT * FROM ppdb_registration_academic
					where (type='academic')  and first_choice = '".$row['id']." '
					and status='approved'
					and is_insentif1='1'
					";


		$result = $mysqli->query($query) or die(mysqli_error($mysqli));

		$siswa_dw = [];
		$x=0;
		while($r = mysqli_fetch_array($result)){
			$siswa_dw[$x]['id'] 				= $r['id'];
			$siswa_dw[$x]['type'] 				= $r['type'];
			$siswa_dw[$x]['name'] 				= $r['name'];
			$siswa_dw[$x]['first_choice'] 		= $r['first_choice'];
			$siswa_dw[$x]['second_choice'] 		= $r['second_choice'];
			$siswa_dw[$x]['is_foreigner'] 		= $r['is_foreigner'];
			$siswa_dw[$x]['is_insentif1'] 		= $r['is_insentif1'];
			$siswa_dw[$x]['is_insentif2'] 		= $r['is_insentif2'];
			$siswa_dw[$x]['accepted_school'] 	= $r['first_choice'];

			$siswa_dw[$x]['total'] 				= $r['score_total1'];
			$siswa_dw[$x]['total1'] 				= $r['score_total1'];
			$siswa_dw[$x]['total2'] 				= $r['score_total2'];
			$siswa_dw[$x]['score_bahasa'] 				= $r['score_bahasa'];
			$siswa_dw[$x]['score_english'] 				= $r['score_english'];
			$siswa_dw[$x]['score_math'] 				= $r['score_math'];
			$siswa_dw[$x]['score_physics'] 				= $r['score_physics'];
			$siswa_dw[$x]['score_range'] 				= $r['score_range1'];
			$siswa_dw[$x]['score_range1'] 				= $r['score_range1'];
			$siswa_dw[$x]['score_range2'] 				= $r['score_range2'];
			$siswa_dw[$x]['range'] 						= $r['range1'];
			$siswa_dw[$x]['range1'] 				= $r['range1'];
			$siswa_dw[$x]['range2'] 				= $r['range2'];

			$siswa_dw[$x]['accepted_status'] 	= '1';
			$siswa_dw[$x]['filtered_is_foreigner'] = '0';
			$siswa_dw[$x]['status'] 			= $siswa_dw[$x]['accepted_status'];
			$x++;
		}
		$temp_total_pendaftar = $temp_total_pendaftar +$x;
		@mysqli_free_result($result);


		$listsekolah[$row['id']]['id'] 						= $row['id'];
		$listsekolah[$row['id']]['quota'] 					= $row['quota'];
		$listsekolah[$row['id']]['foreigner_percentage'] 	= $row['foreigner_percentage'];

		$listsekolah[$row['id']]['dalam']['id'] 			= $row['id'];
		$listsekolah[$row['id']]['dalam']['quota'] 			= $row['quota_dw'];
		$listsekolah[$row['id']]['dalam']['foreigner_percentage'] = $row['foreigner_percentage'];
		$listsekolah[$row['id']]['dalam']['passing_grade'] = 0;

		if(isset($siswa_dw)){
			$listsekolah[$row['id']]['dalam']['data'] 		= $siswa_dw;
		}else{
			$listsekolah[$row['id']]['dalam']['data'] 		= array();
		}
		$listsekolah[$row['id']]['dalam']['status'] 		= 0;
		unset($siswa_dw);



		/*start push siswa gabungan wilayah*/
		$query  = "SELECT * FROM ppdb_registration_academic
					where (type='academic')  and first_choice = '".$row['id']." '
					and status='approved' and is_insentif1='0' and is_foreigner<>'2' ";

		$temp_passing_grade = 0;
		$result_gw = $mysqli->query($query) or die(mysqli_error($mysqli));

		$siswa_gw = [];
		$x=0;
		while($r = mysqli_fetch_array($result_gw)){
			$siswa_gw[$x]['id'] 				= $r['id'];
			$siswa_gw[$x]['type'] 				= $r['type'];
			$siswa_gw[$x]['name'] 				= $r['name'];
			$siswa_gw[$x]['first_choice'] 		= $r['first_choice'];
			$siswa_gw[$x]['second_choice'] 		= $r['second_choice'];
			$siswa_gw[$x]['is_foreigner'] 		= $r['is_foreigner'];
			$siswa_gw[$x]['is_insentif1'] 		= $r['is_insentif1'];
			$siswa_gw[$x]['is_insentif2'] 		= $r['is_insentif2'];
			$siswa_gw[$x]['accepted_school'] 	= $r['first_choice'];
			$siswa_gw[$x]['total'] 				= $r['score_total1'];
			$siswa_gw[$x]['total1'] 				= $r['score_total1'];
			$siswa_gw[$x]['total2'] 				= $r['score_total2'];
			$siswa_gw[$x]['score_bahasa'] 				= $r['score_bahasa'];
			$siswa_gw[$x]['score_english'] 				= $r['score_english'];
			$siswa_gw[$x]['score_math'] 				= $r['score_math'];
			$siswa_gw[$x]['score_physics'] 				= $r['score_physics'];
			$siswa_gw[$x]['score_range'] 				= $r['score_range1'];
			$siswa_gw[$x]['score_range1'] 				= $r['score_range1'];
			$siswa_gw[$x]['score_range2'] 				= $r['score_range2'];
			$siswa_gw[$x]['range'] 				= $r['range1'];
			$siswa_gw[$x]['range1'] 				= $r['range1'];
			$siswa_gw[$x]['range2'] 				= $r['range2'];
			$siswa_gw[$x]['accepted_status'] 	= '1';
			$siswa_gw[$x]['filtered_is_foreigner'] = '1';
			$siswa_gw[$x]['status'] 			= $siswa_gw[$x]['accepted_status'];
			$x++;
		}

		$temp_total_pendaftar = $temp_total_pendaftar +$x;
		@mysqli_free_result($result_gw);

		$listsekolah[$row['id']]['gabungan']['id'] = $row['id'];
		$listsekolah[$row['id']]['gabungan']['quota'] = $row['quota_gw'];
		$listsekolah[$row['id']]['gabungan']['foreigner_percentage'] = $row['foreigner_percentage'];
		$listsekolah[$row['id']]['gabungan']['passing_grade'] = 0;

		if(isset($siswa_gw)){
			$listsekolah[$row['id']]['gabungan']['data'] = $siswa_gw;
		}else{
			$listsekolah[$row['id']]['gabungan']['data'] = array();
		}
		$listsekolah[$row['id']]['gabungan']['status'] = 0;

		unset($siswa_gw);
		/*end push siswa gabungan kota*/
		$temp_total_pendaftar = $temp_total_pendaftar +$x;
		$temp_total_luar_kota = $x;
		@mysqli_free_result($result_gw);


		/*start push siswa luar kota*/
		$query  = "SELECT * FROM ppdb_registration_academic
					where (type='academic')  and first_choice = '".$row['id']." '
					and status='approved' and is_insentif1='0' and is_foreigner='2'";

		$temp_passing_grade = 0;
		$result = $mysqli->query($query) or die(mysqli_error($mysqli));
		$siswa_luar = [];
		$x=0;
		while($r = mysqli_fetch_array($result)){
			$siswa_luar[$x]['id'] 					= $r['id'];
			$siswa_luar[$x]['type'] 				= $r['type'];
			$siswa_luar[$x]['name'] 				= $r['name'];
			$siswa_luar[$x]['first_choice'] 		= $r['first_choice'];
			$siswa_luar[$x]['second_choice'] 		= $r['second_choice'];
			$siswa_luar[$x]['is_foreigner'] 		= $r['is_foreigner'];
			$siswa_luar[$x]['is_insentif1'] 		= $r['is_insentif1'];
			$siswa_luar[$x]['is_insentif2'] 		= $r['is_insentif2'];
			$siswa_luar[$x]['accepted_school'] 		= $r['first_choice'];

			$siswa_luar[$x]['total'] 				= $r['score_total1'];
			$siswa_luar[$x]['total1'] 				= $r['score_total1'];
			$siswa_luar[$x]['total2'] 				= $r['score_total2'];
			$siswa_luar[$x]['score_bahasa'] 				= $r['score_bahasa'];
			$siswa_luar[$x]['score_english'] 				= $r['score_english'];
			$siswa_luar[$x]['score_math'] 				= $r['score_math'];
			$siswa_luar[$x]['score_physics'] 				= $r['score_physics'];
			$siswa_luar[$x]['score_range'] 				= $r['score_range1'];
			$siswa_luar[$x]['score_range1'] 				= $r['score_range1'];
			$siswa_luar[$x]['score_range2'] 				= $r['score_range2'];
			$siswa_luar[$x]['range'] 				= $r['range1'];
			$siswa_luar[$x]['range1'] 				= $r['range1'];
			$siswa_luar[$x]['range2'] 				= $r['range2'];

			$siswa_luar[$x]['accepted_status'] 		= '1';
			$siswa_luar[$x]['filtered_is_foreigner'] ='2';
			$siswa_luar[$x]['status'] 				= $siswa_luar[$x]['accepted_status'];
			$x++;
		}

		$temp_total_pendaftar = $temp_total_pendaftar +$x;
		@mysqli_free_result($result);

		$listsekolah[$row['id']]['luar']['id'] 						= $row['id'];
		$listsekolah[$row['id']]['luar']['quota'] 					= $row['quota'];
		$listsekolah[$row['id']]['luar']['foreigner_percentage']	= $row['foreigner_percentage'];
		$listsekolah[$row['id']]['luar']['passing_grade'] 			= 0;

		if(isset($siswa_luar)){
			$listsekolah[$row['id']]['luar']['data'] = $siswa_luar;
		}else{
			$listsekolah[$row['id']]['luar']['data'] = array();
		}
		$listsekolah[$row['id']]['luar']['status'] = 0;
		unset($siswa_luar);
		/*end push siswa luar kota*/

		$temp_total_pendaftar = $temp_total_pendaftar +$x;
		$temp_total_luar_kota = $x;
	}


	$listsekolah['9999']['id'] = '9999';
	$listsekolah['9999']['quota'] = 0;
	$listsekolah['9999']['presentase_luar_kota'] = 0;
	$listsekolah['9999']['kuota_seluruh'] = 0;

	$listsekolah['9999']['dalam']['id'] = '9999';
	$listsekolah['9999']['dalam']['nama']  = 'Buangan';
	$listsekolah['9999']['dalam']['quota'] = 0;
	$listsekolah['9999']['dalam']['data'] = array();
	$listsekolah['9999']['dalam']['status'] = 1;

	$listsekolah['9999']['gabungan']['id'] = '9999';
	$listsekolah['9999']['gabungan']['nama']  = 'Buangan';
	$listsekolah['9999']['gabungan']['quota'] = 0;
	$listsekolah['9999']['gabungan']['data'] = array();
	$listsekolah['9999']['gabungan']['status'] = 1;

	$listsekolah['9999']['luar']['id'] = '9999';
	$listsekolah['9999']['luar']['nama']  = 'Buangan';
	$listsekolah['9999']['luar']['quota'] = 0;
	$listsekolah['9999']['luar']['data'] = array();
	$listsekolah['9999']['luar']['status'] = 1;
	@mysqli_free_result($resul1);


	#------- Proses luar kota
	$passgrad = TRUE;
	while($passgrad != FALSE){ // selama masih ada sekolah yg harus di sorting
		$passgrad = FALSE;

		foreach($listsekolah as $sekolah){ // sort tiap sekolah
			if($sekolah['luar']['id'] == '9999'){continue;}
			if($sekolah['luar']['status'] == 0){
				# init
				$id = $sekolah['id'];

				# sort
				sorting($listsekolah[$id]['luar']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');

				$quota_luar_kota = ($listsekolah[$id]['luar']['quota'] * 0.1);
				$jml_pend = count($listsekolah[$id]['luar']['data']);

				if($jml_pend > $quota_luar_kota){ /* potong berdasarkan quota */

					// # lemparkan
					for($i = $jml_pend-1; $i>$quota_luar_kota-1; $i--){

						if($listsekolah[$id]['luar']['data'][$i]['second_choice'] != $sekolah['id']){ /* lempar ke pilihan 2 */

							if ($listsekolah[$id]['luar']['data'][$i]['is_insentif2']=='1'){
								if($listsekolah[$id]['luar']['data'][$i]['second_choice'] != '9999'){ //lempar ke pilihan 2	
									$listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['luar']['status'] = 0;
									$listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 2;
									$listsekolah[$id]['luar']['data'][$i]['accepted_school'] = $listsekolah[$id]['luar']['data'][$i]['second_choice'];
									array_push($listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['dalam']['data'], $listsekolah[$id]['luar']['data'][$i]);
									array_splice($listsekolah[$id]['luar']['data'], $i, 1); 
								}else{
									$listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
									$listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
									array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
									array_splice($listsekolah[$id]['luar']['data'], $i, 1);

								}
							}else{
								array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
								array_splice($listsekolah[$id]['luar']['data'], $i, 1);	
							}
						}else{ // tidak diterima dimana2
							$listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
							$listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
							array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
							array_splice($listsekolah[$id]['luar']['data'], $i, 1);
						}
					}
				}

				$listsekolah[$id]['luar']['status'] = 1;
			}
		}

		# cek sekolah, bisi aya nu can di sorting
		foreach($listsekolah as $sekolah){
			if($sekolah['luar']['status'] == 0){
				$passgrad = TRUE;
				break;
			}
		}
	}


	#process dalam & gabungan wilayah
	$passgrad = TRUE;
	while($passgrad != FALSE){ // selama masih ada sekolah yg harus di sorting
		$passgrad = FALSE;

		foreach($listsekolah as $sekolah){ // sort tiap sekolah
			if($sekolah['dalam']['id'] == '9999'){continue;}
			
				# init
				$id = $sekolah['id'];

				# sort
				sorting($listsekolah[$id]['dalam']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');
				sorting($listsekolah[$id]['gabungan']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');
				

				// print_r($listsekolah[$id]['data']);
				// echo '<br>';
				$jml_pend_dalam = count($listsekolah[$id]['dalam']['data']);
				echo $id . '-' .  $jml_pend_dalam . '-' . $listsekolah[$id]['dalam']['quota'] . '<br/>';
				//start dalam wilayah
				if($jml_pend_dalam > $listsekolah[$id]['dalam']['quota']){ /* potong berdasarkan kuota */
					// # lemparkan
					for($i = $jml_pend_dalam-1; $i>$listsekolah[$id]['dalam']['quota']-1; $i--){
						echo 'test_dalam:' . $listsekolah[$id]['dalam']['data'][$i]['name'] . '-' . $listsekolah[$id]['dalam']['data'][$i]['second_choice'] . '-' . $listsekolah[$id]['dalam']['data'][$i]['is_insentif2']  . ' - Sekolah :'. $sekolah['dalam']['id'] . '<br/>';
							$listsekolah[$id]['dalam']['data'][$i]['accepted_status'] = 1;
							//$listsekolah[$id]['dalam']['data'][$i]['accepted_school'] = $listsekolah[$id]['dalam']['data'][$i]['second_choice'];
							array_push($listsekolah[$id]['gabungan']['data'], $listsekolah[$id]['dalam']['data'][$i]);
							array_splice($listsekolah[$id]['dalam']['data'], $i, 1);
					}
				}

				sorting($listsekolah[$id]['dalam']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');
				sorting($listsekolah[$id]['gabungan']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');

				$jml_pend_gabungan = count($listsekolah[$id]['gabungan']['data']);
				if($jml_pend_gabungan > $listsekolah[$id]['gabungan']['quota']){ /* potong berdasarkan kuota */
					// # lemparkan
					for($i = $jml_pend_gabungan-1; $i>$listsekolah[$id]['gabungan']['quota']-1; $i--){
						echo 'test_gabungan:' . $listsekolah[$id]['gabungan']['data'][$i]['name'] . '-' . $listsekolah[$id]['gabungan']['data'][$i]['second_choice'] . '-' . $listsekolah[$id]['gabungan']['data'][$i]['is_insentif2']  . ' - Sekolah :'. $sekolah['gabungan']['id'] . '<br/>';
						
						if($listsekolah[$id]['gabungan']['data'][$i]['second_choice'] != $sekolah['gabungan']['id']){ //lempar ke pilihan 2	
							if ($listsekolah[$id]['gabungan']['data'][$i]['is_insentif2']=='1'){
								
								$listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['dalam']['status'] = 0;
								$listsekolah[$id]['gabungan']['data'][$i]['accepted_status'] = 2;
								$listsekolah[$id]['gabungan']['data'][$i]['accepted_school'] = $listsekolah[$id]['gabungan']['data'][$i]['second_choice'];
								array_push($listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['dalam']['data'], $listsekolah[$id]['gabungan']['data'][$i]);

							}else{
								$listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['gabungan']['status'] = 0;
								$listsekolah[$id]['gabungan']['data'][$i]['accepted_status'] = 2;
								$listsekolah[$id]['gabungan']['data'][$i]['accepted_school'] = $listsekolah[$id]['gabungan']['data'][$i]['second_choice'];
								array_push($listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['gabungan']['data'], $listsekolah[$id]['gabungan']['data'][$i]);
							}
							array_splice($listsekolah[$id]['gabungan']['data'], $i, 1);  
						}else{
							$listsekolah[$id]['gabungan']['data'][$i]['accepted_status'] = 3;
							$listsekolah[$id]['gabungan']['data'][$i]['accepted_school'] = 9999;
							array_push($listsekolah['9999']['gabungan']['data'], $listsekolah[$id]['gabungan']['data'][$i]);
							array_splice($listsekolah[$id]['gabungan']['data'], $i, 1);
						}	
					}
				}
				
				$listsekolah[$id]['dalam']['status'] = 1;
				$listsekolah[$id]['gabungan']['status'] = 1;


			
		}

		# cek sekolah, bisi aya nu can di sorting
		foreach($listsekolah as $sekolah){
			if($sekolah['dalam']['status'] == 0){
				$passgrad = TRUE;
				break;
			}
		}

		foreach($listsekolah as $sekolah){
			if($sekolah['gabungan']['status'] == 0){
				$passgrad = TRUE;
				break;
			}
		}

	}




	//get pg terendah antara dalam & gabungan, kemudian check siswa luar kota,seleksi jika ada yg nilainya kurang dari pg
	foreach ($listsekolah as $sekolah){
		$id = $sekolah['id'];
		$low_passing_grage = 0;
		$passing_grage_dw = 0;
		$passing_grage_gw = 0;
		foreach($sekolah['dalam']['data'] as $siswa){
			$passing_grage_dw=$siswa['total'];
		}
		foreach($sekolah['gabungan']['data'] as $siswa){
			$passing_grage_gw=$siswa['total'];
		}
		if ($passing_grage_dw <= $passing_grage_gw){
			$low_passing_grage = $passing_grage_dw;
		}else{
			$low_passing_grage = $passing_grage_gw;
		}

		$listsekolah[$id]['dalam']['passing_grade'] = $passing_grage_dw;
		$listsekolah[$id]['gabungan']['passing_grade'] = $passing_grage_gw;
		

		echo 'Sekolah ID:' . $id . ' Dalam-' . $passing_grage_dw;  
		echo '---- Gabungan-' . $passing_grage_gw;  
		echo '---- Lowest-' . $low_passing_grage;  
		echo '<br/>';echo '<br/>';

		$jml_pend = count($listsekolah[$id]['luar']['data']);
		for($i = $jml_pend-1; $i>=0; $i--){
			echo 'first luar kota : ' . $listsekolah[$id]['luar']['data'][$i]['name'] . '-' . $listsekolah[$id]['luar']['data'][$i]['total'] . '<br/>'; 
			if ($listsekolah[$id]['luar']['data'][$i]['total'] < $low_passing_grage){
			echo 'inner luar kota : ' . $listsekolah[$id]['luar']['data'][$i]['name'] . '-' . $listsekolah[$id]['luar']['data'][$i]['second_choice']  . '<br/>'; 
				if ($listsekolah[$id]['luar']['data'][$i]['is_insentif2']=='1'){
					if($listsekolah[$id]['luar']['data'][$i]['second_choice'] != '9999'){ //lempar ke pilihan 2	
						$listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['dalam']['status'] = 0;
						$listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 2;
						$listsekolah[$id]['luar']['data'][$i]['accepted_school'] = $listsekolah[$id]['luar']['data'][$i]['second_choice'];
						array_push($listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['dalam']['data'], $listsekolah[$id]['luar']['data'][$i]);
						array_splice($listsekolah[$id]['luar']['data'], $i, 1); 
					}else{
						$listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
						$listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
						array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
						array_splice($listsekolah[$id]['luar']['data'], $i, 1);
					}
				}else{
					$listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
					$listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
					array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
					array_splice($listsekolah[$id]['luar']['data'], $i, 1);	
				}
				
			} //end if
		}//end for


	}




	#process dalam & gabungan wilayah
	$passgrad = TRUE;
	while($passgrad != FALSE){ // selama masih ada sekolah yg harus di sorting
		$passgrad = FALSE;

		foreach($listsekolah as $sekolah){ // sort tiap sekolah
			if($sekolah['dalam']['id'] == '9999'){continue;}
			
				# init
				$id = $sekolah['id'];

				# sort
				sorting($listsekolah[$id]['dalam']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');
				sorting($listsekolah[$id]['gabungan']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');
				

				// print_r($listsekolah[$id]['data']);
				// echo '<br>';
				$jml_pend_dalam = count($listsekolah[$id]['dalam']['data']);
				echo $id . '-' .  $jml_pend_dalam . '-' . $listsekolah[$id]['dalam']['quota'] . '<br/>';
				//start dalam wilayah
				if($jml_pend_dalam > $listsekolah[$id]['dalam']['quota']){ /* potong berdasarkan kuota */
					// # lemparkan
					for($i = $jml_pend_dalam-1; $i>$listsekolah[$id]['dalam']['quota']-1; $i--){
						echo 'test_dalam:' . $listsekolah[$id]['dalam']['data'][$i]['name'] . '-' . $listsekolah[$id]['dalam']['data'][$i]['second_choice'] . '-' . $listsekolah[$id]['dalam']['data'][$i]['is_insentif2']  . ' - Sekolah :'. $sekolah['dalam']['id'] . '<br/>';
							$listsekolah[$id]['dalam']['data'][$i]['accepted_status'] = 1;
							//$listsekolah[$id]['dalam']['data'][$i]['accepted_school'] = $listsekolah[$id]['dalam']['data'][$i]['second_choice'];
							array_push($listsekolah[$id]['gabungan']['data'], $listsekolah[$id]['dalam']['data'][$i]);
							array_splice($listsekolah[$id]['dalam']['data'], $i, 1);
					}
				}

				sorting($listsekolah[$id]['dalam']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');
				sorting($listsekolah[$id]['gabungan']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');

				$jml_pend_gabungan = count($listsekolah[$id]['gabungan']['data']);
				if($jml_pend_gabungan > $listsekolah[$id]['gabungan']['quota']){ /* potong berdasarkan kuota */
					// # lemparkan
					for($i = $jml_pend_gabungan-1; $i>$listsekolah[$id]['gabungan']['quota']-1; $i--){
						echo 'test_gabungan:' . $listsekolah[$id]['gabungan']['data'][$i]['name'] . '-' . $listsekolah[$id]['gabungan']['data'][$i]['second_choice'] . '-' . $listsekolah[$id]['gabungan']['data'][$i]['is_insentif2']  . ' - Sekolah :'. $sekolah['gabungan']['id'] . '<br/>';
						
						if($listsekolah[$id]['gabungan']['data'][$i]['second_choice'] != $sekolah['gabungan']['id']){ //lempar ke pilihan 2	
							if ($listsekolah[$id]['gabungan']['data'][$i]['is_insentif2']=='1'){
								
								$listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['dalam']['status'] = 0;
								$listsekolah[$id]['gabungan']['data'][$i]['accepted_status'] = 2;
								$listsekolah[$id]['gabungan']['data'][$i]['accepted_school'] = $listsekolah[$id]['gabungan']['data'][$i]['second_choice'];
								array_push($listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['dalam']['data'], $listsekolah[$id]['gabungan']['data'][$i]);

							}else{
								$listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['gabungan']['status'] = 0;
								$listsekolah[$id]['gabungan']['data'][$i]['accepted_status'] = 2;
								$listsekolah[$id]['gabungan']['data'][$i]['accepted_school'] = $listsekolah[$id]['gabungan']['data'][$i]['second_choice'];
								array_push($listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['gabungan']['data'], $listsekolah[$id]['gabungan']['data'][$i]);
							}
							array_splice($listsekolah[$id]['gabungan']['data'], $i, 1);  
						}else{
							$listsekolah[$id]['gabungan']['data'][$i]['accepted_status'] = 3;
							$listsekolah[$id]['gabungan']['data'][$i]['accepted_school'] = 9999;
							array_push($listsekolah['9999']['gabungan']['data'], $listsekolah[$id]['gabungan']['data'][$i]);
							array_splice($listsekolah[$id]['gabungan']['data'], $i, 1);
						}	
					}
				}
				
				$listsekolah[$id]['dalam']['status'] = 1;
				$listsekolah[$id]['gabungan']['status'] = 1;


			
		}

		# cek sekolah, bisi aya nu can di sorting
		foreach($listsekolah as $sekolah){
			if($sekolah['dalam']['status'] == 0){
				$passgrad = TRUE;
				break;
			}
		}

		foreach($listsekolah as $sekolah){
			if($sekolah['gabungan']['status'] == 0){
				$passgrad = TRUE;
				break;
			}
		}

	}
	
	?>



	<?php
	
	foreach ($listsekolah as $sekolah){
		?>
			<?php echo 'id-' . $sekolah['id'];?>
			<table border="1">
					<thead>
						<tr>
						<td>No</td>
						<td>Nama</td>
						<td>Pilihan 1</td>
						<td>Pilihan 2</td>
						<td>Total</td>
						<td>asal_pendaftar</td>
						<td>Insentif1</td>
						<td>Insentif2</td>
						<td>Terima Di Wilayah</td>
						<td>Diterima Sekolah</td>
						<td>Status Diterima</td>
						</tr>
					</thead>
					<tr><td colspan="5">Luar Kota</td></tr>
					<?php
						$j=0;
						foreach($sekolah['luar']['data'] as $siswa){
						$j++;
							?>
								<tr>
									<td><?=$j?></td>
									<td><?=$siswa['name']?></td>
									<td><?=$siswa['first_choice']?></td>
									<td><?=$siswa['second_choice']?></td>
									<td><?=$siswa['total']?></td>
									<td><?=$siswa['is_foreigner']?></td>
									<td><?=$siswa['is_insentif1']?></td>
									<td><?=$siswa['is_insentif2']?></td>
									<td><?=$siswa['filtered_is_foreigner']?></td>
									<td><?=$siswa['accepted_school']?></td>
									<td><?=$siswa['accepted_status']?></td>
								</tr>
							<?php
						}
					?>
					<tr><td colspan="5">Dalam Wilayah</td></tr>
					<?php
						$j=0;
						foreach($sekolah['dalam']['data'] as $siswa){
						$j++;
							?>
								<tr>
									<td><?=$j?></td>
									<td><?=$siswa['name']?></td>
									<td><?=$siswa['first_choice']?></td>
									<td><?=$siswa['second_choice']?></td>
									<td><?=$siswa['total']?></td>
									<td><?=$siswa['is_foreigner']?></td>
									<td><?=$siswa['is_insentif1']?></td>
									<td><?=$siswa['is_insentif2']?></td>
									<td><?=$siswa['filtered_is_foreigner']?></td>
									<td><?=$siswa['accepted_school']?></td>
									<td><?=$siswa['accepted_status']?></td>
								</tr>
							<?php
						}
					?>
					<tr><td colspan="5">Gabungan wilayah</td></tr>
					<?php
						$j=0;
						foreach($sekolah['gabungan']['data'] as $siswa){
						$j++;
							?>
								<tr>
									<td><?=$j?></td>
									<td><?=$siswa['name']?></td>
									<td><?=$siswa['first_choice']?></td>
									<td><?=$siswa['second_choice']?></td>
									<td><?=$siswa['total']?></td>
									<td><?=$siswa['is_foreigner']?></td>
									<td><?=$siswa['is_insentif1']?></td>
									<td><?=$siswa['is_insentif2']?></td>
									<td><?=$siswa['filtered_is_foreigner']?></td>
									<td><?=$siswa['accepted_school']?></td>
									<td><?=$siswa['accepted_status']?></td>
								</tr>
							<?php
						}
					?>
				
			</table>
			<br/>
		<?php
	}
	$sql_del = "DELETE
		from ppdb_filtered_academic
		where `option` in (
			SELECT a.id FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 ) and (a.type='academic'))";
		$result=$mysqli->query($sql_del) or die(mysqli_error($mysqli));
		
	$qpilihan  = "SELECT a.id, a.quota,b.name FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3) and (a.type='academic')";
		$rpilihan = $mysqli->query( $qpilihan) or die(mysqli_error($mysqli));
		$j=1;
		$qfiltered='';
		while($row = mysqli_fetch_array($rpilihan)){
			$passinggrade = 0.00;
			$passinggrade_dalam_wilayah = 0.00;
			$passinggrade_luar_wilayah = 0.00;
			$passinggrade_luar = 0.00;
			$passinggrade_luar_kota = 0.00;
			$siswa_luar_wilayah = 0;
			$i=0;
			$j=0;
			$y=0;
			//print_r($listsekolah[$row['id']]['dalam']['data']);
			//echo $row['id'] . "<br><br>";

			foreach($listsekolah[$row['id']]['dalam']['data'] as $r){
			//	echo $r['id'] . '-' . $r['accepted_school'];
				$parts[] ="('" . $r['id'] . "', '" . $r['accepted_school'] . "', '0')";
				$passinggrade_dalam_wilayah = $r['total'];
			}
			//exit();
			foreach($listsekolah[$row['id']]['gabungan']['data'] as $r){
				$parts[] .="('" . $r['id'] . "', '" . $r['accepted_school'] . "', '1')";
				$passinggrade_luar_wilayah = $r['total'];
			}
			$y=0;
			foreach($listsekolah[$row['id']]['luar']['data'] as $r){
				$parts[] .="('" . $r['id'] . "', '" . $r['accepted_school'] . "', '2')";
				$passinggrade_luar_kota = $r['total'];
			}

			if ($passinggrade_luar_wilayah<$passinggrade_dalam_wilayah){
				$passinggrade =$passinggrade_luar_wilayah;
			}else{
				$passinggrade =$passinggrade_dalam_wilayah;
			}

			//$filtered_total = count($listsekolah[$row['id']]['inner']['data']) +count($listsekolah[$row['id']]['dalam']['data']) +count($listsekolah[$row['id']]['luar']['data']);
			//$total_pedaftar_limpahan=$row['registered_total']+$i;
			/*$update_pg = "update ppdb_statistic set passing_grade ='" . $passinggrade_dalam_wilayah . "',
			filtered_total='" . $filtered_total . "',
			filtered_foreigner='" . $y . "',
			passing_grade_foreigner='" . $passinggrade_luar_wilayah . "', passing_grade_foreigner_foreigner='" . $passinggrade_luar_kota . "'  where `option`='" . $row['id'] .  "'";

			$rupdate=$mysqli->query($update_pg);@mysqli_free_result($rupdate); */

		}

		mysqli_free_result($rpilihan);
		if ($parts!=""){
		$qfiltered = "insert into ppdb_filtered_academic (`registration`, `option`, `is_foreigner`) values " . implode(', ', $parts);
		$result = $mysqli->query($qfiltered) or die(mysqli_error($mysqli));
		}
		unset($parts);

 ?>
