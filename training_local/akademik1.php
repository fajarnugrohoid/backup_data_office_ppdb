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


	$sql_statistik = "DELETE
		from ppdb_statistic
		where `option` in(
			SELECT a.id FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 ) and a.type='academic') ";
	$truncate_statistic=$mysqli->query($sql_statistik) or die(mysqli_error($mysqli));



	#ambil data
	$query_sch  = "SELECT a.id as id,a.type,a.quota,b.name,b.is_border,substring(b.code,1,1) as code, a.inner_quota,a.total_quota, b.foreigner_pecentage
							FROM ppdb_option a
							inner join ppdb_school b on (a.school = b.id)
							where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 ) and a.type='academic'
							ORDER BY b.code, a.id";

	$resul1 = $mysqli->query($query_sch) or die(mysqli_error($mysqli));
	$update_tot_pendaftar='';

	while($row = mysqli_fetch_array($resul1)){ // sekolah
		$temp_total_pendaftar = 0;
		$temp_total_luar_kota = 0;
		$query  = "SELECT * FROM ppdb_registration_academic
					where (type='academic')  and first_choice = '".$row['id']." '
					and status='approved'
					and is_insentif='1'";


		$resul2 = $mysqli->query($query) or die(mysqli_error($mysqli));

		$x=0;
		while($r = mysqli_fetch_array($resul2)){
			$inner_siswa[$x]['id'] 					= $r['id'];
			$inner_siswa[$x]['jalur'] 				= $r['type'];
			$inner_siswa[$x]['nama'] 				= $r['name'];
			$inner_siswa[$x]['no_un'] 				= $r['no_un'];
			$inner_siswa[$x]['pilihan1'] 			= $r['first_choice'];
			$inner_siswa[$x]['pilihan2'] 			= $r['second_choice'];
			$inner_siswa[$x]['asal_pendaftar'] 		= $r['is_foreigner'];
			$inner_siswa[$x]['is_insentif'] 		= $r['is_insentif'];
			$inner_siswa[$x]['skor_jarak'] 			= $r['score_range1'];
			$inner_siswa[$x]['skor_jarak1'] 		= $r['score_range1'];
			$inner_siswa[$x]['skor_jarak2'] 		= $r['score_range2'];
			$inner_siswa[$x]['terima_disekolah'] 	= $r['first_choice'];
			$inner_siswa[$x]['bahasa'] 				= $r['score_bahasa'];
			$inner_siswa[$x]['english'] 			= $r['score_english'];
			$inner_siswa[$x]['matematika']			= $r['score_math'];
			$inner_siswa[$x]['ipa'] 				= $r['score_physics'];
			$inner_siswa[$x]['total'] 				= $r['score_total1'];
			$inner_siswa[$x]['total1'] 				= $r['score_total1'];
			$inner_siswa[$x]['total2'] 				= $r['score_total2'];
			$inner_siswa[$x]['score_achievement'] 	= $r['score_achievement'];
			$inner_siswa[$x]['score_poor'] 			= $r['score_poor'];
			$inner_siswa[$x]['address_district'] 	= $r['address_district'];
			$inner_siswa[$x]['address_subdistrict'] = $r['address_subdistrict'];
			$inner_siswa[$x]['distance'] 			= $r['distance'];
			$inner_siswa[$x]['score_distance_x'] 	= 0;
			$inner_siswa[$x]['diterima'] 			= '1';
			$inner_siswa[$x]['terima_disekolah'] 	= $r['first_choice'];
			$inner_siswa[$x]['filtered_is_foreigner'] = 0;

			if ($r['is_foreigner']==2){
				$inner_siswa[$x]['total'] 			= $r['score_total2'];
			}else{
				$inner_siswa[$x]['total'] 			= $r['score_total1'];
			}
			$inner_siswa[$x]['skor_jarak'] 			= $r['score_range1'];
			$inner_siswa[$x]['status'] 				= $inner_siswa[$x]['diterima'];

			$x++;

		}
		$temp_total_pendaftar = $temp_total_pendaftar +$x;
		@mysqli_free_result($resul2);


		$listsekolah[$row['id']]['id'] 						= $row['id'];
		$listsekolah[$row['id']]['kuota'] 					= $row['quota'];
		$listsekolah[$row['id']]['presentase_luar_kota'] 	= $row['foreigner_pecentage'];
		$listsekolah[$row['id']]['kuota_seluruh'] = $row['total_quota'];

		$listsekolah[$row['id']]['inner']['id'] 			= $row['id'];
		$listsekolah[$row['id']]['inner']['nama_sekolah'] 	= $row['name'];
		$listsekolah[$row['id']]['inner']['kuota'] 			= $row['quota'];
		//$listsekolah[$row['id']]['inner']['kuota_tambahan'] = $row['over_quota'];
		$listsekolah[$row['id']]['inner']['inner_quota'] 	= $row['inner_quota'];
		$listsekolah[$row['id']]['inner']['kuota_seluruh'] 	= $row['total_quota'];
		$listsekolah[$row['id']]['inner']['kode_jenjang'] 	= $row['code'];
		$listsekolah[$row['id']]['inner']['jalur'] 			= $row['type'];
		$listsekolah[$row['id']]['inner']['wilayah_batasan']= $row['is_border'];
		//$listsekolah[$row['id']]['inner']['coordinat'] = $row['coordinat'];
		$listsekolah[$row['id']]['inner']['presentase_luar_kota'] = $row['foreigner_pecentage'];

		if(isset($inner_siswa)){
			$listsekolah[$row['id']]['inner']['data'] 		= $inner_siswa;
		}else{
			$listsekolah[$row['id']]['inner']['data'] 		= array();
		}
		$listsekolah[$row['id']]['inner']['status'] 		= 0;

		/*
		$update_tot_pendaftar = "update pilihan  set total_pendaftar = '" . $x . "' where id='" . $row['id'] .  "';";
		$result_update_tot_pendaftar = $mysqli->query($update_tot_pendaftar);
		@mysqli_free_result($result_update_tot_pendaftar); */
		unset($inner_siswa);



		/*start push siswa dalam kota*/
		/*$query  = "SELECT *,CONCAT( 'RT/RW ', LPAD( rt, 2, '0' ) , '/', LPAD( rw, 2, '0' ) , ' ', kelurahan, ' ', kecamatan ) AS `alamat`
		FROM daftar_akademis where (jenjang=2 or jenjang=3) and jalur=1  and pilihan1 = '".$row['id']."' and asal_pendaftar=1"; */
		$query  = "SELECT * FROM ppdb_registration_academic
					where (type='academic')  and first_choice = '".$row['id']." '
					and status='approved'
					and (is_foreigner='0' or is_foreigner='1')  and is_insentif='0'
					";

		$temp_passing_grade = 0;
		$resul2 = $mysqli->query($query) or die(mysqli_error($mysqli));

		$x=0;
		while($r = mysqli_fetch_array($resul2)){
			$siswa[$x]['id'] 		= $r['id'];
			$siswa[$x]['jalur'] 		= $r['type'];
			$siswa[$x]['nama'] 		= $r['name'];
			$siswa[$x]['no_un'] 	= $r['no_un'];
			$siswa[$x]['pilihan1'] 	= $r['first_choice'];
			$siswa[$x]['pilihan2'] 	= $r['second_choice'];
			$siswa[$x]['asal_pendaftar'] 	= $r['is_foreigner'];
			$siswa[$x]['is_insentif'] 	= $r['is_insentif'];
			$siswa[$x]['skor_jarak'] 		= $r['score_range1'];
			$siswa[$x]['skor_jarak1'] 		= $r['score_range1'];
			$siswa[$x]['skor_jarak2'] 		= $r['score_range2'];
			$siswa[$x]['terima_disekolah'] 	= $r['first_choice'];
			$siswa[$x]['bahasa'] 	= $r['score_bahasa'];
			$siswa[$x]['english'] 	= $r['score_english'];
			$siswa[$x]['matematika']= $r['score_math'];
			$siswa[$x]['ipa'] 		= $r['score_physics'];
			$siswa[$x]['total'] 	= $r['score_total1'];
			$siswa[$x]['total1'] 	= $r['score_total1'];
			$siswa[$x]['total2'] 	= $r['score_total2'];
			$siswa[$x]['score_achievement'] 	= $r['score_achievement'];
			$siswa[$x]['score_poor'] 	= $r['score_poor'];
			$siswa[$x]['address_district'] 	= $r['address_district'];
			$siswa[$x]['address_subdistrict'] 	= $r['address_subdistrict'];
			$siswa[$x]['distance'] 	= $r['distance'];
			$siswa[$x]['score_distance_x'] 	= 0;
			$siswa[$x]['diterima'] = '1';
			$siswa[$x]['terima_disekolah'] 	= $r['first_choice'];
			$siswa[$x]['filtered_is_foreigner'] 	= 1;

			if ($r['is_foreigner']==2){
				$siswa[$x]['total'] 	= $r['score_total2'];
			}else{
				$siswa[$x]['total'] 	= $r['score_total1'];
			}
			$siswa[$x]['skor_jarak'] 	= $r['score_range1'];
			$siswa[$x]['status'] 		= $siswa[$x]['diterima'];
			$temp_passing_grade 		= $siswa[$x]['total1'];
			$x++;

		}
		$temp_total_pendaftar = $temp_total_pendaftar +$x;
		@mysqli_free_result($resul2);

		$listsekolah[$row['id']]['dalam']['id'] = $row['id'];
		$listsekolah[$row['id']]['dalam']['nama_sekolah'] = $row['name'];
		$listsekolah[$row['id']]['dalam']['kuota'] = $row['quota'];
		//$listsekolah[$row['id']]['dalam']['kuota_tambahan'] = $row['over_quota'];
		$listsekolah[$row['id']]['dalam']['inner_quota'] = $row['inner_quota'];
		$listsekolah[$row['id']]['dalam']['kuota_seluruh'] = $row['total_quota'];
		$listsekolah[$row['id']]['dalam']['temp_kuota'] = 0;
		$listsekolah[$row['id']]['dalam']['kode_jenjang'] = $row['code'];
		$listsekolah[$row['id']]['dalam']['jalur'] = $row['type'];
		$listsekolah[$row['id']]['dalam']['wilayah_batasan'] = $row['is_border'];
		//$listsekolah[$row['id']]['dalam']['coordinat'] = $row['coordinat'];
		$listsekolah[$row['id']]['dalam']['presentase_luar_kota'] = $row['foreigner_pecentage'];
		$listsekolah[$row['id']]['dalam']['passing_grade'] = $temp_passing_grade;

		if(isset($siswa)){
			$listsekolah[$row['id']]['dalam']['data'] = $siswa;
		}else{
			$listsekolah[$row['id']]['dalam']['data'] = array();
		}
		$listsekolah[$row['id']]['dalam']['status'] = 0;


		/*
		$update_tot_pendaftar = "update pilihan  set total_pendaftar = '" . $x . "' where id='" . $row['id'] .  "';";
		$result_update_tot_pendaftar = $mysqli->query($update_tot_pendaftar);
		@mysqli_free_result($result_update_tot_pendaftar); */
		unset($siswa);
		/*end push siswa dalam kota*/

		/*start push siswa luar kota*/
		$query  = "SELECT * FROM ppdb_registration_academic
					where (type='academic')  and first_choice = '".$row['id']." '
					and status='approved'
					and is_foreigner='2'  and is_insentif='0'";
		$resul2 = $mysqli->query($query) or die(mysqli_error($mysqli));
		$temp_total_luar_kota = 0;
		$x=0;
		while($r = mysqli_fetch_array($resul2)){
			$siswa_luar[$x]['id'] 		= $r['id'];
			$siswa_luar[$x]['jalur'] 		= $r['type'];
			$siswa_luar[$x]['nama'] 		= $r['name'];
			$siswa_luar[$x]['no_un'] 	= $r['no_un'];
			$siswa_luar[$x]['pilihan1'] 	= $r['first_choice'];
			$siswa_luar[$x]['pilihan2'] 	= $r['second_choice'];
			$siswa_luar[$x]['asal_pendaftar'] 	= $r['is_foreigner'];
			$siswa_luar[$x]['is_insentif'] 	= $r['is_insentif'];
			$siswa_luar[$x]['skor_jarak'] 		= $r['score_range1'];
			$siswa_luar[$x]['skor_jarak1'] 		= $r['score_range1'];
			$siswa_luar[$x]['skor_jarak2'] 		= $r['score_range2'];
			$siswa_luar[$x]['terima_disekolah'] 	= $r['first_choice'];
			$siswa_luar[$x]['bahasa'] 	= $r['score_bahasa'];
			$siswa_luar[$x]['english'] 	= $r['score_english'];
			$siswa_luar[$x]['matematika']= $r['score_math'];
			$siswa_luar[$x]['ipa'] 		= $r['score_physics'];

			$siswa_luar[$x]['total'] 	= $r['score_total1'];
			$siswa_luar[$x]['total1'] 	= $r['score_total1'];
			$siswa_luar[$x]['total2'] 	= $r['score_total2'];
			$siswa_luar[$x]['score_achievement'] 	= $r['score_achievement'];
			$siswa_luar[$x]['score_poor'] 	= $r['score_poor'];
			$siswa_luar[$x]['address_district'] 	= $r['address_district'];
			$siswa_luar[$x]['address_subdistrict'] 	= $r['address_subdistrict'];
			$siswa_luar[$x]['distance'] 	= $r['distance'];
			$siswa_luar[$x]['score_distance_x'] 	= 0;
			$siswa_luar[$x]['diterima'] = '1';
			$siswa_luar[$x]['terima_disekolah'] 	= $r['first_choice'];
			$siswa_luar[$x]['filtered_is_foreigner'] 	= 2;
			if ($r['is_foreigner']==2){
				$siswa_luar[$x]['total'] 	= $r['score_total2'];
			}else{
				$siswa_luar[$x]['total'] 	= $r['score_total1'];
			}
			$siswa_luar[$x]['skor_jarak'] 	= $r['score_range1'];
			$siswa_luar[$x]['status'] 		= $siswa_luar[$x]['diterima'];

			$x++;

		}
		$temp_total_pendaftar = $temp_total_pendaftar +$x;
		$temp_total_luar_kota = $x;
		@mysqli_free_result($resul2);

		$listsekolah[$row['id']]['luar']['id'] = $row['id'];
		$listsekolah[$row['id']]['luar']['nama_sekolah'] = $row['name'];
		$listsekolah[$row['id']]['luar']['kuota'] = $row['quota'];
		//$listsekolah[$row['id']]['luar']['kuota_tambahan'] = $row['over_quota'];
		$listsekolah[$row['id']]['luar']['inner_quota'] = $row['inner_quota'];
		$listsekolah[$row['id']]['luar']['kuota_seluruh'] = $row['total_quota'];
		$listsekolah[$row['id']]['luar']['kode_jenjang'] = $row['code'];
		$listsekolah[$row['id']]['luar']['jalur'] = $row['type'];
		$listsekolah[$row['id']]['luar']['wilayah_batasan'] = $row['is_border'];
		//$listsekolah[$row['id']]['luar']['coordinat'] = $row['coordinat'];
		$listsekolah[$row['id']]['luar']['presentase_luar_kota'] = $row['foreigner_pecentage'];


		if(isset($siswa_luar)){
			// if (($row['id']==530) || ($row['id']==534) || ($row['id']==646) || ($row['id']==650)){
			// 	$listsekolah[$row['id']]['dalam']['data'] = array_merge($listsekolah[$row['id']]['dalam']['data'],$siswa_luar);
			// }else{
			// 	$listsekolah[$row['id']]['luar']['data'] = $siswa_luar;
			// }
			$listsekolah[$row['id']]['luar']['data'] = $siswa_luar;
		}else{
			$listsekolah[$row['id']]['luar']['data'] = array();
		}
		// $listsekolah[$row['id']]['luar']['data'] = $siswa_luar;
		$listsekolah[$row['id']]['luar']['status'] = 0;
		$update_tot_pendaftar = "insert into ppdb_statistic (`id`, `option`, `registered_total`,`registered_foreigner`) values ('', '" . $row['id'] . "','" . $temp_total_pendaftar . "','" . $temp_total_luar_kota . "')";

		$result_update_tot_pendaftar = $mysqli->query($update_tot_pendaftar);
		@mysqli_free_result($result_update_tot_pendaftar);
		unset($siswa_luar);
		/*end push siswa luar kota*/

		/*if (($row['id']==530) || ($row['id']==534) || ($row['id']==646) || ($row['id']==650)){
			//print_r($listsekolah[$row['id']]['dalam']['data']);
			//echo $row['id'] . '-' . count($listsekolah[$row['id']]['dalam']['data']) . '<br/><br/>';
		}*/
	}




	foreach($listsekolah as $row){
	//	var_dump($row['luar']['data'][0]);
		echo '<br><br>cek kuota init<br>';
		echo 'id : '.$row['id'].'<br>';
		echo 'inner : '.count($row['inner']['data']).'<br>';
		echo 'Dalam : '.count($row['dalam']['data']).'<br>';
		echo 'Luar : '.count($row['luar']['data']);
		echo '<br><br>';


	}





	/* Init Kuota dan Cek Kuota*/
	#------- Proses
	foreach($listsekolah as $sekolah){
		echo  $sekolah['id'] . '<br/>';
		$kuota_seluruh = (int) $sekolah['kuota_seluruh'];
		$persentase = (int) $sekolah['presentase_luar_kota'] ;
		$luar_kota = floor($kuota_seluruh * $persentase / 100);
		$kuota_luar_wilayah =  $sekolah['kuota'];


		echo 'Pendf dalam wilayah : '.count($sekolah['inner']['data']);
		echo '-Pendf luar wilayah : '.count($sekolah['dalam']['data']);
		echo '-Pendf Luar Kota: '.count($sekolah['luar']['data']).'<br/>';

		echo '-kouta seluruh:' . $kuota_seluruh = (int) $sekolah['kuota_seluruh'] . '<br/>';
		echo '-presentase:' . $persentase = (int) $sekolah['presentase_luar_kota'] . '<br/>';
		$luar_kota = floor($kuota_seluruh * $persentase / 100);
		echo '-luar kota:' .$luar_kota . '<br/>';
		echo '-kuota luar wilayah:' . $kuota =  $sekolah['kuota'] . '<br/>';

		//$kuota_dalam = $kuota - $kuota_luar;
		//echo '-kuota_dalam:' . $kuota_dalam;

		$listsekolah[$sekolah['id']]['dalam']['kuota'] = $listsekolah[$sekolah['id']]['kuota'];
		$listsekolah[$sekolah['id']]['luar']['kuota'] = $luar_kota;
		//$listsekolah[$sekolah['id']]['luar']['kuota'] = $kuota_luar;

		//echo 'kuota_akademis' . $kuota . '<br/>';
		$t_pendaftar_luar = count($listsekolah[$sekolah['id']]['luar']['data']);
		if($luar_kota > $t_pendaftar_luar){
			echo '<br/>';
			$selisih = $luar_kota - $t_pendaftar_luar;
			echo 'selisih' . $selisih;
			echo '<br/>';
			//$listsekolah[$sekolah['id']]['dalam']['kuota'] = $listsekolah[$sekolah['id']]['dalam']['kuota'];
			echo '<br/>';
			echo 'kuota_luar:::' . $luar_kota .'+'. $selisih . '<br/>';
			$listsekolah[$sekolah['id']]['dalam']['kuota'] = $kuota_luar_wilayah + $selisih;
			$listsekolah[$sekolah['id']]['luar']['kuota'] = $t_pendaftar_luar;

		}



		echo 'kuota dalam wilayah : '.$listsekolah[$sekolah['id']]['inner']['inner_quota'].'<br>';
		echo 'kuota luar wilayah: '.$listsekolah[$sekolah['id']]['dalam']['kuota'].'<br>';
		echo 'luar kota : '.$listsekolah[$sekolah['id']]['luar']['kuota'].'<br>';
		echo '<br/><br/>';

	}

	$listsekolah['9999']['id'] = '9999';
	$listsekolah['9999']['kuota'] = 0;
	$listsekolah['9999']['presentase_luar_kota'] = 0;
	$listsekolah['9999']['kuota_seluruh'] = 0;

	$listsekolah['9999']['dalam']['id'] = '9999';
	$listsekolah['9999']['dalam']['nama']  = 'Buangan';
	$listsekolah['9999']['dalam']['kuota'] = 0;
	$listsekolah['9999']['dalam']['data'] = array();
	$listsekolah['9999']['dalam']['status'] = 1;

	$listsekolah['9999']['inner']['id'] = '9999';
	$listsekolah['9999']['inner']['nama']  = 'Buangan';
	$listsekolah['9999']['inner']['kuota'] = 0;
	$listsekolah['9999']['inner']['data'] = array();
	$listsekolah['9999']['inner']['status'] = 1;

	$listsekolah['9999']['luar']['id'] = '9999';
	$listsekolah['9999']['luar']['nama']  = 'Buangan';
	$listsekolah['9999']['luar']['kuota'] = 0;
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

					sorting($listsekolah[$id]['luar']['data'], 'total','total2','bahasa','english','matematika','ipa','skor_jarak');

				// print_r($listsekolah[$id]['data']);
				// echo '<br>';

				# passing



				$jml_pend = count($listsekolah[$id]['luar']['data']);

				if($jml_pend > $listsekolah[$id]['luar']['kuota']){ /* potong berdasarkan kuota */

					// # lemparkan
					for($i = $jml_pend-1; $i>$sekolah['luar']['kuota']-1; $i--){
						//echo $listsekolah[$id]['luar']['data'][$i]['total'] . '---' . $listsekolah[$id]['dalam']['passing_grade'] . '<br/>';

						if($listsekolah[$id]['luar']['data'][$i]['pilihan2'] != $sekolah['id']){ /* lempar ke pilihan 2 */



							$listsekolah[$id]['luar']['data'][$i]['total'] = $listsekolah[$id]['luar']['data'][$i]['total']; /*lempar ke pilihan 2, total diganti ke total2*/
							$listsekolah[$id]['luar']['data'][$i]['skor_jarak'] = $listsekolah[$id]['luar']['data'][$i]['skor_jarak2']; /*lempar ke pilihan 2, skor jarak diganti ke skor jarak2*/



							if ($listsekolah[$id]['luar']['data'][$i]['pilihan2'] == 9999) {
								$listsekolah[$id]['luar']['data'][$i]['diterima'] = 3;
								$listsekolah[$id]['luar']['data'][$i]['terima_disekolah'] = 9999;


								array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
								array_splice($listsekolah[$id]['luar']['data'], $i, 1);

							}else{

								$xid = $listsekolah[$id]['luar']['data'][$i]['pilihan2'];  //cek id sekolah
								if (!isset( $listsekolah[$xid])){ //cek id sekolah, jika tidak ada lempar ke pilihan 9999
										echo 'id sekolah tidak ada = '.$xid.'<br/>';
										$listsekolah[$id]['luar']['data'][$i]['diterima'] = 3;
										$listsekolah[$id]['luar']['data'][$i]['terima_disekolah'] = 9999;
										array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
										array_splice($listsekolah[$id]['luar']['data'], $i, 1);
								}else{
									$listsekolah[$id]['luar']['data'][$i]['diterima'] = 2;
									$listsekolah[$id]['luar']['data'][$i]['terima_disekolah'] = $listsekolah[$id]['luar']['data'][$i]['pilihan2'];
									$listsekolah[$listsekolah[$id]['luar']['data'][$i]['pilihan2']]['luar']['status'] = 0;
									array_push($listsekolah[$listsekolah[$id]['luar']['data'][$i]['pilihan2']]['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
									array_splice($listsekolah[$id]['luar']['data'], $i, 1);
								}
							}
						}else{ // tidak diterima dimana2
							$listsekolah[$id]['luar']['data'][$i]['diterima'] = 3;
							$listsekolah[$id]['luar']['data'][$i]['terima_disekolah'] = 9999;
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




	#------- Proses
	$passgrad = TRUE;
	while($passgrad != FALSE){ // selama masih ada sekolah yg harus di sorting
		$passgrad = FALSE;

		foreach($listsekolah as $sekolah){ // sort tiap sekolah

			/*$siswa_luar_kota=count($listsekolah[$sekolah['id']]['luar']['data']);
			$kuota_luar_kota=count($listsekolah[$sekolah['id']]['luar']['kuota']);

			if ($listsekolah[$sekolah['id']]['dalam']['temp_kuota']==0){
				$listsekolah[$sekolah['id']]['dalam']['temp_kuota']=$listsekolah[$sekolah['id']]['dalam']['kuota'];
			}

			echo $sekolah['id'] . 'siswa_luar_kota' . $siswa_luar_kota . '<br/>';
			echo $sekolah['id'] . 'kuota' . $kuota_luar_kota . '<br/>';
			if ($kuota_luar_kota>0){
				$listsekolah[$sekolah['id']]['dalam']['kuota'] = $listsekolah[$sekolah['id']]['dalam']['temp_kuota'] + $kuota_luar_kota;
			}

			echo $sekolah['id'] . 'kuota' . $listsekolah[$sekolah['id']]['dalam']['kuota'] . '<br/>';*/

			if($sekolah['dalam']['id'] == '9999'){continue;}
			if($sekolah['dalam']['status'] == 0){
				# init
				$id = $sekolah['id'];

				# sort
				sorting($listsekolah[$id]['inner']['data'], 'total','total2','bahasa','english','matematika','ipa','skor_jarak');
				sorting($listsekolah[$id]['dalam']['data'], 'total','total2','bahasa','english','matematika','ipa','skor_jarak');

				// print_r($listsekolah[$id]['data']);
				// echo '<br>';

				# passing


				/*$lokasi_kota10 = floor($sekolah['kuota'] * 0.1);
				$lokasi_batasan25 = floor($sekolah['kuota'] * 0.25);*/

				/*if ($sekolah['kuota_seluruh']==0){
					$sekolah['kuota_seluruh'] = $sekolah['kuota'];
				}else{
				$kuota_luarkota = floor($sekolah['kuota_seluruh'] * ($sekolah['presentase_luar_kota']/100)); } */

				$jml_pend = count($listsekolah[$id]['inner']['data']);
				//start dalam wilayah
				if($jml_pend > $listsekolah[$id]['inner']['inner_quota']){ /* potong berdasarkan kuota */

					// # lemparkan
					for($i = $jml_pend-1; $i>$listsekolah[$id]['inner']['inner_quota']-1; $i--){
						//if($listsekolah[$id]['inner']['data'][$i]['pilihan2'] != $sekolah['inner']['id']){ // lempar ke luar wilayah

							$listsekolah[$id]['inner']['data'][$i]['filtered_is_foreigner'] = 1;
							array_push($listsekolah[$id]['dalam']['data'], $listsekolah[$id]['inner']['data'][$i]);
							array_splice($listsekolah[$id]['inner']['data'], $i, 1);

						//}
					}
				}


				sorting($listsekolah[$id]['dalam']['data'], 'total','total2','bahasa','english','matematika','ipa','skor_jarak');

				//start luar wilayah
				$jml_pend = count($listsekolah[$id]['dalam']['data']);
				//echo '-' . $listsekolah[$id]['dalam']['kuota'] . '<br/>';
				if($jml_pend > $listsekolah[$id]['dalam']['kuota']){ /* potong berdasarkan kuota */

					// # lemparkan
					for($i = $jml_pend-1; $i>$listsekolah[$id]['dalam']['kuota']-1; $i--){
						if($listsekolah[$id]['dalam']['data'][$i]['pilihan2'] != $sekolah['dalam']['id']){ /* lempar ke pilihan 2 */

							$listsekolah[$id]['dalam']['data'][$i]['total'] = $listsekolah[$id]['dalam']['data'][$i]['total']; /*lempar ke pilihan 2, total diganti ke total2*/
							$listsekolah[$id]['dalam']['data'][$i]['skor_jarak'] = $listsekolah[$id]['dalam']['data'][$i]['skor_jarak2']; /*lempar ke pilihan 2, skor jarak diganti ke skor jarak2*/

							if ($listsekolah[$id]['dalam']['data'][$i]['pilihan2'] == 9999) {
								$listsekolah[$id]['dalam']['data'][$i]['diterima'] = 3;
								$listsekolah[$id]['dalam']['data'][$i]['terima_disekolah'] = 9999;


								array_push($listsekolah['9999']['dalam']['data'], $listsekolah[$id]['dalam']['data'][$i]);
								array_splice($listsekolah[$id]['dalam']['data'], $i, 1);

							}else{

								$xid = $listsekolah[$id]['dalam']['data'][$i]['pilihan2'];  //cek id sekolah
								if (!isset( $listsekolah[$xid])){ //cek id sekolah, jika tidak ada lempar ke pilihan 9999
										//echo 'id sekolah tidak ada = '.$xid.'<br/>';
										$listsekolah[$id]['dalam']['data'][$i]['diterima'] = 3;
										$listsekolah[$id]['dalam']['data'][$i]['terima_disekolah'] = 9999;
										array_push($listsekolah['9999']['dalam']['data'], $listsekolah[$id]['dalam']['data'][$i]);
										array_splice($listsekolah[$id]['dalam']['data'], $i, 1);
								}else{
									$listsekolah[$id]['dalam']['data'][$i]['diterima'] = 2;
									$listsekolah[$id]['dalam']['data'][$i]['terima_disekolah'] = $listsekolah[$id]['dalam']['data'][$i]['pilihan2'];
									$listsekolah[$listsekolah[$id]['dalam']['data'][$i]['pilihan2']]['dalam']['status'] = 0;
									array_push($listsekolah[$listsekolah[$id]['dalam']['data'][$i]['pilihan2']]['dalam']['data'], $listsekolah[$id]['dalam']['data'][$i]);
									array_splice($listsekolah[$id]['dalam']['data'], $i, 1);
								}


							}
						}else{ // tidak diterima dimana2
							$listsekolah[$id]['dalam']['data'][$i]['diterima'] = 3;
							$listsekolah[$id]['dalam']['data'][$i]['terima_disekolah'] = 9999;
							array_push($listsekolah['9999']['dalam']['data'], $listsekolah[$id]['dalam']['data'][$i]);
							array_splice($listsekolah[$id]['dalam']['data'], $i, 1);
						}


					}
				}
				$listsekolah[$id]['dalam']['status'] = 1;


			}
		}

		# cek sekolah, bisi aya nu can di sorting
		foreach($listsekolah as $sekolah){
			if($sekolah['dalam']['status'] == 0){
				$passgrad = TRUE;
				break;
			}
		}


	}
	/*
	foreach($listsekolah as $row){
	//	var_dump($row['luar']['data'][0]);
		echo '<br><br>Kuota dalam hasil filter<br>';
		echo 'id : '.$row['id'].'<br>';
		echo 'siswa Dalam : '.count($row['dalam']['data']).'<br>';
		echo 'kuota Dalam : '.$row['dalam']['kuota'].'<br>';
		//echo 'Luar : '.count($row['luar']['data']);
		echo '<br><br>';

	}

	*/
	//get passing grade luar wilayah





	foreach ($listsekolah as $sekolah){
		foreach($sekolah['dalam']['data'] as $siswa){
			$temp_passing_grade=$siswa['total1'];
		}

		$listsekolah[$sekolah['id']]['dalam']['passing_grade'] = $temp_passing_grade;

		// foreach($sekolah['luar']['data'] as $siswa_luar){
		// 	if ($listsekolah[$sekolah['id']]['dalam']['passing_grade']> $listsekolah[$sekolah['id']]['luar'])
		// 		$siswa_luar['total']
		// }
		echo $jml_pend = count($listsekolah[$sekolah['id']]['luar']['data']) . '<br/>';
		for($i = $jml_pend-1; $i>=0; $i--){
				// array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
				// array_splice($listsekolah[$id]['luar']['data'], $i, 1);
			if ($listsekolah[$sekolah['id']]['luar']['data'][$i]['total']<$listsekolah[$sekolah['id']]['dalam']['passing_grade']){
				array_push($listsekolah['9999']['luar']['data'], $listsekolah[$sekolah['id']]['luar']['data'][$i]);
				array_splice($listsekolah[$sekolah['id']]['luar']['data'], $i, 1);
			}

			//echo $listsekolah[$sekolah['id']]['luar']['data'][$i]['nama'] . '<br/>';
		}
	}

echo "<br/><br/>";

	//sorting($listsekolah[$id]['luar']['data'], 'total','total2','bahasa','english','matematika','ipa','skor_jarak');
	/*
	$temp_pilihan1 = '';
	$j=0;
	?>
		<table border="1">
	<?php
	foreach ($listsekolah[9999]['dalam']['data'] as $siswa){
		?><tr>
					<td><?=$siswa['nama']?></td>
								<td><?=$siswa['pilihan1']?></td>
								<td><?=$siswa['pilihan2']?></td>
								<td><?=$siswa['total1']?></td>
								<td><?=$siswa['total2']?></td>
								<td><?=$siswa['skor_jarak1']?></td>
								<td><?=$siswa['skor_jarak2']?></td>
								<td><?=$siswa['total']?></td>
								<td><?=$siswa['bahasa']?></td>
								<td><?=$siswa['english']?></td>
								<td><?=$siswa['matematika']?></td>
								<td><?=$siswa['ipa']?></td>
								<td><?=$siswa['skor_jarak']?></td>
								<td><?=$siswa['asal_pendaftar']?></td>
								<td><?=$siswa['is_insentif']?></td>
								<td><?=$siswa['filtered_is_foreigner']?></td>
								<td><?=$siswa['diterima']?></td></tr>
		<?php
	}

	//echo '<br/>'.$j;
	*/

	?>

	<?php

	//echo '</table>';


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
						<td>Total 1</td>
						<td>Total 2</td>
						<td>Skor Jarak 1</td>
						<td>Skor Jarak 2</td>
						<td>Total Nilai</td>
						<td>Bahasa</td>
						<td>English</td>
						<td>Mtk</td>
						<td>IPA</td>
						<td>Skor Jarak</td>
						<td>asal_pendaftar</td>
						<td>Insentif</td>
						<td>Terima Di Wilayah</td>
						<td>Diterima</td>
						</tr>
					</thead>
					<tr><td colspan="5">inner</td></tr>
				<?php
					$j=0;
					foreach($sekolah['inner']['data'] as $siswa){
					$j++;
						?>
							<tr>
								<td><?=$j?></td>
								<td><?=$siswa['nama']?></td>
								<td><?=$siswa['pilihan1']?></td>
								<td><?=$siswa['pilihan2']?></td>
								<td><?=$siswa['total1']?></td>
								<td><?=$siswa['total2']?></td>
								<td><?=$siswa['skor_jarak1']?></td>
								<td><?=$siswa['skor_jarak2']?></td>
								<td><?=$siswa['total']?></td>
								<td><?=$siswa['bahasa']?></td>
								<td><?=$siswa['english']?></td>
								<td><?=$siswa['matematika']?></td>
								<td><?=$siswa['ipa']?></td>
								<td><?=$siswa['skor_jarak']?></td>
								<td><?=$siswa['asal_pendaftar']?></td>
								<td><?=$siswa['is_insentif']?></td>
								<td><?=$siswa['filtered_is_foreigner']?></td>
								<td><?=$siswa['diterima']?></td>
							</tr>
						<?php
					}
				?>
				<tr><td colspan="5">luar wilayah</td></tr>
				<?php
					$j=0;
					foreach($sekolah['dalam']['data'] as $siswa){
					$j++;
						?>
							<tr>
								<td><?=$j?></td>
								<td><?=$siswa['nama']?></td>
								<td><?=$siswa['pilihan1']?></td>
								<td><?=$siswa['pilihan2']?></td>
								<td><?=$siswa['total1']?></td>
								<td><?=$siswa['total2']?></td>
								<td><?=$siswa['skor_jarak1']?></td>
								<td><?=$siswa['skor_jarak2']?></td>
								<td><?=$siswa['total']?></td>
								<td><?=$siswa['bahasa']?></td>
								<td><?=$siswa['english']?></td>
								<td><?=$siswa['matematika']?></td>
								<td><?=$siswa['ipa']?></td>
								<td><?=$siswa['skor_jarak']?></td>
								<td><?=$siswa['asal_pendaftar']?></td>
								<td><?=$siswa['is_insentif']?></td>
								<td><?=$siswa['filtered_is_foreigner']?></td>
								<td><?=$siswa['diterima']?></td>
							</tr>
						<?php
					}
				?>
				<tr><td colspan="5"><?php echo $sekolah['dalam']['passing_grade'] ?></td></tr>
				<tr><td colspan="5">luar kota</td></tr>
				<?php
					$j=0;
					foreach($sekolah['luar']['data'] as $siswa){
					$j++;
						?>
							<tr>
								<td><?=$j?></td>
								<td><?=$siswa['nama']?></td>
								<td><?=$siswa['pilihan1']?></td>
								<td><?=$siswa['pilihan2']?></td>
								<td><?=$siswa['total1']?></td>
								<td><?=$siswa['total2']?></td>
								<td><?=$siswa['skor_jarak1']?></td>
								<td><?=$siswa['skor_jarak2']?></td>
								<td><?=$siswa['total']?></td>
								<td><?=$siswa['bahasa']?></td>
								<td><?=$siswa['english']?></td>
								<td><?=$siswa['matematika']?></td>
								<td><?=$siswa['ipa']?></td>
								<td><?=$siswa['skor_jarak']?></td>
								<td><?=$siswa['asal_pendaftar']?></td>
								<td><?=$siswa['is_insentif']?></td>
								<td><?=$siswa['filtered_is_foreigner']?></td>
								<td><?=$siswa['diterima']?></td>
							</tr>
						<?php
					}
				?>
			</table>
			<br/>
		<?php
	}

	echo "<br/><br/>";

	//exit;
	//$result=$mysqli->query('TRUNCATE TABLE `ppdb_filtered_academic`') or die(mysqli_error($mysqli));
	$sql_del = "DELETE
		from ppdb_filtered_academic
		where `option` in (
			SELECT a.id FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 ) and (a.type='academic'))";
		$result=$mysqli->query($sql_del) or die(mysqli_error($mysqli));

	/*start insert dalam kota*/
		//$qpilihan  = "SELECT id, kuota, total_pendaftar FROM pilihan where (substring(kode_sekolah,1,1)=2 or substring(kode_sekolah,1,1)=3) and (jalur=1) ORDER BY id ASC";
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
			echo $row['id'] . "<br><br>";
			foreach($listsekolah[$row['id']]['inner']['data'] as $r){
				$parts[] ="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "', '0')";
				$passinggrade_dalam_wilayah = $r['total'];



				if ($r['asal_pendaftar']==2){
					$y++;
					$passinggrade_luar_kota = $r['total'];
				}

				if ($r['diterima']==2) {
					$i++;
				}

				$j++;
			}
			foreach($listsekolah[$row['id']]['dalam']['data'] as $r){
				$parts[] .="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "', '1')";
				//$passinggrade = $r['total'];
				$passinggrade_luar_wilayah = $r['total'];


				if ($r['asal_pendaftar']==2){
					$y++;
					$passinggrade_luar_kota = $r['total'];
				}

				if ($r['diterima']==2) {
					$i++;
				}
				$siswa_luar_wilayah++;
				$j++;
			}
			$y=0;
			foreach($listsekolah[$row['id']]['luar']['data'] as $r){
				$parts[] .="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "', '2')";
				$passinggrade_luar_kota = $r['total'];



				if ($r['asal_pendaftar']==2){
					$y++;
					$passinggrade_luar_kota = $r['total'];
				}

				if ($r['diterima']==2) {
					$i++;
				}

				$j++;
			}

			if ($passinggrade_luar_wilayah<$passinggrade_dalam_wilayah){
				$passinggrade =$passinggrade_luar_wilayah;
			}else{
				$passinggrade =$passinggrade_dalam_wilayah;
			}

			$filtered_total = count($listsekolah[$row['id']]['inner']['data']) +count($listsekolah[$row['id']]['dalam']['data']) +count($listsekolah[$row['id']]['luar']['data']);
			//$total_pedaftar_limpahan=$row['registered_total']+$i;
			$update_pg = "update ppdb_statistic set passing_grade ='" . $passinggrade_dalam_wilayah . "',
			filtered_total='" . $filtered_total . "',
			filtered_foreigner='" . $y . "',
			passing_grade_foreigner='" . $passinggrade_luar_wilayah . "', passing_grade_foreigner_foreigner='" . $passinggrade_luar_kota . "'  where `option`='" . $row['id'] .  "'";

			$rupdate=$mysqli->query($update_pg);@mysqli_free_result($rupdate);

		}

		mysqli_free_result($rpilihan);
		if ($parts!=""){
		$qfiltered = "insert into ppdb_filtered_academic (`registration`, `option`, `is_foreigner`) values " . implode(', ', $parts);
		$result = $mysqli->query($qfiltered) or die(mysqli_error($mysqli));
		}
		unset($parts);

		$time_end = microtime(true);
		$time = $time_end - $time_start;
		/*$datetime_now = gmdate('Y-m-d H:i:s',time()+60*60*7); */
		$datetime_now = date('Y-m-d H:i:s');
		$qsignal = "insert into sys_signal (`id`, `signal`,`post_time`) values ('','filter_ok', '" . $datetime_now . "')";
		$res_signal = $mysqli->query($qsignal) or die(mysqli_error($mysqli));
		echo 'Filtered : '.$time . ' on ' . $datetime_now;
		echo '<br/>'.memory_get_usage();


 ?>
