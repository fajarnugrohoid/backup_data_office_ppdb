<?php
ini_set('max_execution_time', 10000);
ini_set("memory_limit","-1");
error_reporting(E_ERROR | E_ALL);
echo 'version 1.0<br/>';

	# connection

	include('connection.php');
	//include('get_age.php');

	//$getage = new Get_age();

	$time_start = microtime(true);
	function sorting(&$arr, $col_total,$col_skorjarak) {
		$sort_col_total = array();
		$sort_col_skorjarak = array();

		foreach ($arr as $key=> $row) {
			$sort_col_total[$key] = $row[$col_total];
			$sort_col_skorjarak[$key] = $row[$col_skorjarak];

		}
		array_multisort($sort_col_total, SORT_DESC,$sort_col_skorjarak,SORT_DESC, $arr);
	}

		$sql_statistik = "DELETE
		from ppdb_statistic
		where `option` in(
			SELECT a.id FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=1) and a.type='academic' and b.level='elementary') ";
	$truncate_statistic=$mysqli->query($sql_statistik) or die(mysql_error());

	# ambil data
	// $query_sekolah  = "SELECT distinct(b.id),a.kode_sekolah,b.jalur,b.kuota,b.kuota_seluruh, a.presentase_luar_kota, a.nama_sekolah,a.wilayah_batasan,a.presentase_luar_kota
	// 			FROM sekolah a
	// 			INNER JOIN pilihan b ON ( a.kode_sekolah = b.kode_sekolah )
	// 			where substring(a.kode_sekolah,1,1)=1
	// 			ORDER BY a.kode_sekolah, b.id";
				$query_sekolah  = "SELECT a.id as id,a.type,a.quota,b.name,b.is_border,substring(b.code,1,1) as code, a.over_quota, b.coordinat, a.inner_quota,a.total_quota, b.foreigner_pecentage
							FROM ppdb_option a
							inner join ppdb_school b on (a.school = b.id)
							where (substring(b.code,1,1)=1)
							ORDER BY b.code, a.id";
	$result_sekolah = $mysqli->query( $query_sekolah) or die(mysql_error());
	$update_tot_pendaftar='';
	while($row = mysql_fetch_array($result_sekolah)){ // sekolah

		//$query  = "SELECT *, CONCAT( 'RT/RW ', LPAD( rt, 2, '0' ) , '/', LPAD( rw, 2, '0' ) , ' ', kelurahan, ' ', kecamatan ) AS `alamat`  FROM daftar_sd where asal_pendaftar=1  and pilihan1 = '".$row['id']."'";
		$temp_total_pendaftar = 0;
		$temp_total_luar_kota = 0;
		$temp_passing_grade = 0;
		$query  = "SELECT * FROM ppdb_registration_elementary
					where first_choice = '".$row['id']." '
					and status='approved' and is_foreigner!=2";
		$resul2 = $mysqli->query($query) or die(mysql_error());
		$x=0;
		while($r = mysql_fetch_array($resul2)){

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
			$siswa[$x]['total'] 	= $r['score_age'] + $r['score_range1'];
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
			$siswa[$x]['skor_umur'] 	= $r['score_age'];
			$siswa[$x]['status'] 			= $siswa[$x]['diterima'];

			$x++;

		}


		// kuota seluryuh


		$listsekolah[$row['id']]['id'] = $row['id'];
		$listsekolah[$row['id']]['kuota'] = $row['quota'];
		$listsekolah[$row['id']]['presentase_luar_kota'] = $row['foreigner_pecentage'];
		$listsekolah[$row['id']]['kuota_seluruh'] = $row['total_quota'];

		$listsekolah[$row['id']]['dalam']['id'] = $row['id'];
		$listsekolah[$row['id']]['dalam']['nama_sekolah'] = $row['name'];
		$listsekolah[$row['id']]['dalam']['kuota'] = $row['quota'];
		$listsekolah[$row['id']]['dalam']['kuota_tambahan'] = $row['over_quota'];
		$listsekolah[$row['id']]['dalam']['inner_quota'] = $row['inner_quota'];
		$listsekolah[$row['id']]['dalam']['kuota_seluruh'] = $row['total_quota'];
		$listsekolah[$row['id']]['dalam']['kode_jenjang'] = $row['code'];
		$listsekolah[$row['id']]['dalam']['jalur'] = $row['type'];
		$listsekolah[$row['id']]['dalam']['wilayah_batasan'] = $row['is_border'];
		$listsekolah[$row['id']]['dalam']['coordinat'] = $row['coordinat'];
		$listsekolah[$row['id']]['dalam']['presentase_luar_kota'] = $row['foreigner_pecentage'];
		$listsekolah[$row['id']]['dalam']['passing_grade'] = $temp_passing_grade;

		if(isset($siswa)){
			$listsekolah[$row['id']]['dalam']['data'] = $siswa;
		}else{
			$listsekolah[$row['id']]['dalam']['data'] = array();
		}
		$listsekolah[$row['id']]['dalam']['status'] = 0;

		$temp_total_pendaftar = $temp_total_pendaftar +$x;
		@mysql_free_result($resul2);
		unset($siswa);

		$query  = "SELECT * FROM ppdb_registration_elementary
					where first_choice = '".$row['id']." '
					and status='approved'
					and is_foreigner=2
					";
		$resul2 = $mysqli->query($query) or die(mysql_error());
		$x=0;
		while($r = mysql_fetch_array($resul2)){
			$siswa2[$x]['id'] 		= $r['id'];
			$siswa2[$x]['jalur'] 		= $r['type'];
			$siswa2[$x]['nama'] 		= $r['name'];
			$siswa2[$x]['no_un'] 	= $r['no_un'];
			$siswa2[$x]['pilihan1'] 	= $r['first_choice'];
			$siswa2[$x]['pilihan2'] 	= $r['second_choice'];
			$siswa2[$x]['asal_pendaftar'] 	= $r['is_foreigner'];
			$siswa2[$x]['is_insentif'] 	= $r['is_insentif'];
			$siswa2[$x]['skor_jarak'] 		= $r['score_range1'];
			$siswa2[$x]['skor_jarak1'] 		= $r['score_range1'];
			$siswa2[$x]['skor_jarak2'] 		= $r['score_range2'];
			$siswa2[$x]['terima_disekolah'] 	= $r['first_choice'];
			$siswa2[$x]['bahasa'] 	= $r['score_bahasa'];
			$siswa2[$x]['english'] 	= $r['score_english'];
			$siswa2[$x]['matematika']= $r['score_math'];
			$siswa2[$x]['ipa'] 		= $r['score_physics'];
			$siswa2[$x]['total'] 	= $r['score_age'] + $r['score_range1'];
			$siswa2[$x]['total1'] 	= $r['score_total1'];
			$siswa2[$x]['total2'] 	= $r['score_total2'];
			$siswa2[$x]['score_achievement'] 	= $r['score_achievement'];
			$siswa2[$x]['score_poor'] 	= $r['score_poor'];
			$siswa2[$x]['address_district'] 	= $r['address_district'];
			$siswa2[$x]['address_subdistrict'] 	= $r['address_subdistrict'];
			$siswa2[$x]['distance'] 	= $r['distance'];
			$siswa2[$x]['score_distance_x'] 	= 0;
			$siswa2[$x]['diterima'] = '1';
			$siswa2[$x]['terima_disekolah'] 	= $r['first_choice'];
			$siswa2[$x]['skor_umur'] 	= $r['score_age'];
			$siswa2[$x]['status'] 			= $siswa2[$x]['diterima'];

			$x++;

		}
		$temp_total_pendaftar = $temp_total_pendaftar +$x;
		$temp_total_luar_kota = $temp_total_luar_kota +$x;


		$listsekolah[$row['id']]['luar']['id'] = $row['id'];
		$listsekolah[$row['id']]['luar']['nama_sekolah'] = $row['name'];
		$listsekolah[$row['id']]['luar']['kuota'] = $row['quota'];
		$listsekolah[$row['id']]['luar']['kuota_tambahan'] = $row['over_quota'];
		$listsekolah[$row['id']]['luar']['inner_quota'] = $row['inner_quota'];
		$listsekolah[$row['id']]['luar']['kuota_seluruh'] = $row['total_quota'];
		$listsekolah[$row['id']]['luar']['kode_jenjang'] = $row['code'];
		$listsekolah[$row['id']]['luar']['jalur'] = $row['type'];
		$listsekolah[$row['id']]['luar']['wilayah_batasan'] = $row['is_border'];
		$listsekolah[$row['id']]['luar']['coordinat'] = $row['coordinat'];
		$listsekolah[$row['id']]['luar']['presentase_luar_kota'] = $row['foreigner_pecentage'];

		if(isset($siswa2)){
			$listsekolah[$row['id']]['luar']['data'] = $siswa2;
		}else{
			$listsekolah[$row['id']]['luar']['data'] = array();
		}
		$listsekolah[$row['id']]['luar']['status'] = 0;
		$update_tot_pendaftar = "insert into ppdb_statistic (`id`, `option`, `registered_total`,`registered_foreigner`) values ('', '" . $row['id'] . "','" . $temp_total_pendaftar . "','" . $temp_total_luar_kota . "')";
		$result_update_tot_pendaftar = $mysqli->query($update_tot_pendaftar);

		mysql_free_result($resul2);
		@mysql_free_result($result_update_tot_pendaftar);

		unset($siswa2);
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

	$listsekolah['9999']['luar']['id'] = '9999';
	$listsekolah['9999']['luar']['nama']  = 'Buangan';
	$listsekolah['9999']['luar']['kuota'] = 0;
	$listsekolah['9999']['luar']['data'] = array();
	$listsekolah['9999']['luar']['status'] = 1;

	@mysql_free_result($result_sekolah);

	// kimochi END INIT DATA



	/* Init Kuota dan Cek Kuota*/
	#------- Proses
	foreach($listsekolah as $sekolah){

		echo $sekolah['id'] . '-' . $sekolah['kuota'] . '<br/>';

		$kuota_seluruh = (int) $sekolah['kuota'];
		$persentase = (int) $sekolah['presentase_luar_kota'];
		$kuota_luar = floor($kuota_seluruh * $persentase / 100);
		$kuota_dalam =$kuota_seluruh-$kuota_luar;

		$listsekolah[$sekolah['id']]['dalam']['kuota'] = $kuota_dalam;
		$listsekolah[$sekolah['id']]['luar']['kuota'] = $kuota_luar;


		echo 'kuota dalam : ' . $listsekolah[$sekolah['id']]['dalam']['kuota'] . '-';
		echo 'kuota luar : ' . $listsekolah[$sekolah['id']]['luar']['kuota'] . '<br/>';

		$t_pendaftar_dalam = count($listsekolah[$sekolah['id']]['dalam']['data']);
		$t_pendaftar_luar = count($listsekolah[$sekolah['id']]['luar']['data']);

		if($kuota_luar > $t_pendaftar_luar){
			$selisih = $kuota_luar - $t_pendaftar_luar;
			$listsekolah[$sekolah['id']]['dalam']['kuota'] = $kuota_dalam + $selisih;
			$listsekolah[$sekolah['id']]['luar']['kuota'] = $kuota_luar - $selisih;
		}

		echo 'pend dalam : ' . $t_pendaftar_dalam . '-';
		echo 'pend luar : ' . $t_pendaftar_luar. '<br/>';
		echo 'sesudah<br/>dalam : ' . $listsekolah[$sekolah['id']]['dalam']['kuota'] . '-';
		echo 'luar : ' . $listsekolah[$sekolah['id']]['luar']['kuota'];

		echo '<br/><br/>';
	}




	#------- Proses dalam
	$passgrad = TRUE;
	while($passgrad != FALSE){ // selama masih ada sekolah yg harus di sorting
		$passgrad = FALSE;

		foreach($listsekolah as $sekolah){ // sort tiap sekolah
			if($sekolah['id'] == '9999'){continue;}
			if($sekolah['dalam']['status'] == 0){
				# init
				$id = $sekolah['id'];

				# sort
				sorting($listsekolah[$id]['dalam']['data'], 'total', 'skor_jarak');
				// print_r($listsekolah[$id]['data']);
				// echo '<br>';

				# passing
				$jml_pend = count($listsekolah[$id]['dalam']['data']);

				if($jml_pend > $listsekolah[$id]['dalam']['kuota']){ /* potong berdasarkan kuota */
					// # lemparkan
					for($i = $jml_pend-1; $i>$sekolah['dalam']['kuota']-1; $i--){
						if($listsekolah[$id]['dalam']['data'][$i]['pilihan2'] != $sekolah['id']){ /* lempar ke pilihan 2 */

								$listsekolah[$id]['dalam']['data'][$i]['skor_jarak'] = $listsekolah[$id]['dalam']['data'][$i]['skor_jarak2']; /*lempar ke pilihan 2, skor jarak diganti ke skor jarak2*/
								$listsekolah[$id]['dalam']['data'][$i]['total'] = $listsekolah[$id]['dalam']['data'][$i]['skor_umur'] + $listsekolah[$id]['dalam']['data'][$i]['skor_jarak']; /*lempar ke pilihan 2, total diganti ke total2*/

							if ($listsekolah[$id]['dalam']['data'][$i]['pilihan2'] == 9999) {
								$listsekolah[$id]['dalam']['data'][$i]['diterima'] = 3;
								$listsekolah[$id]['dalam']['data'][$i]['terima_disekolah'] = 9999;


								array_push($listsekolah['9999']['dalam']['data'], $listsekolah[$id]['dalam']['data'][$i]);
								array_splice($listsekolah[$id]['dalam']['data'], $i, 1);

							}else{

								//cek id sekolah
								$xid = $listsekolah[$id]['dalam']['data'][$i]['pilihan2'];
								if (!isset( $listsekolah[$xid])){  //jika tidak ada, maka lempar ke pilihan 9999
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

	#------- Proses luar
	$passgrad = TRUE;
	while($passgrad != FALSE){ // selama masih ada sekolah yg harus di sorting
		$passgrad = FALSE;

		foreach($listsekolah as $sekolah){ // sort tiap sekolah
			if($sekolah['id'] == '9999'){continue;}
			if($sekolah['luar']['status'] == 0){
				# init
				$id = $sekolah['id'];

				# sort
				sorting($listsekolah[$id]['luar']['data'], 'total', 'skor_jarak');
				// print_r($listsekolah[$id]['data']);
				// echo '<br>';

				# passing
				$jml_pend = count($listsekolah[$id]['luar']['data']);
				//echo $sekolah['id'] . '--' . $jml_pend . '-'. $listsekolah[$id]['luar']['kuota'] . '<br/>';

				if($jml_pend > $listsekolah[$id]['luar']['kuota']){ /* potong berdasarkan kuota */
					// # lemparkan
					for($i = $jml_pend-1; $i>$sekolah['luar']['kuota']-1; $i--){
						if($listsekolah[$id]['luar']['data'][$i]['pilihan2'] != $sekolah['id']){ /* lempar ke pilihan 2 */

								$listsekolah[$id]['luar']['data'][$i]['skor_jarak'] = $listsekolah[$id]['luar']['data'][$i]['skor_jarak2']; /*lempar ke pilihan 2, skor jarak diganti ke skor jarak2*/
								$listsekolah[$id]['luar']['data'][$i]['total'] = $listsekolah[$id]['luar']['data'][$i]['skor_umur'] + $listsekolah[$id]['luar']['data'][$i]['skor_jarak']; /*lempar ke pilihan 2, total diganti ke total2*/

							if ($listsekolah[$id]['luar']['data'][$i]['pilihan2'] == 9999) {
								$listsekolah[$id]['luar']['data'][$i]['diterima'] = 3;
								$listsekolah[$id]['luar']['data'][$i]['terima_disekolah'] = 9999;


								array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
								array_splice($listsekolah[$id]['luar']['data'], $i, 1);

							}else{

								//cek id sekolah
								$xid = $listsekolah[$id]['luar']['data'][$i]['pilihan2'];
								if (!isset( $listsekolah[$xid])){  //jika tidak ada, maka lempar ke pilihan 9999
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
		for($i = $jml_pend-1; $i>0; $i--){
				// array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
				// array_splice($listsekolah[$id]['luar']['data'], $i, 1);
			if ($listsekolah[$sekolah['id']]['luar']['data'][$i]['total']<$listsekolah[$sekolah['id']]['dalam']['passing_grade']){
				array_push($listsekolah['9999']['luar']['data'], $listsekolah[$sekolah['id']]['luar']['data'][$i]);
				array_splice($listsekolah[$sekolah['id']]['luar']['data'], $i, 1);
			}

			//echo $listsekolah[$sekolah['id']]['luar']['data'][$i]['nama'] . '<br/>';
		}
	}


	echo 'dalam';




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
						<td>Diterima</td>
						</tr>
					</thead>
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
								<td><?=$siswa['total']?></td>
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
								<td><?=$siswa['total']?></td>
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
	//$result=$mysqli->query('TRUNCATE TABLE `ppdb_filtered_academic`') or die(mysql_error());

		$result=$mysqli->query('TRUNCATE TABLE `ppdb_filtered_elementary`') or die(mysql_error());
	@mysql_free_result($result);
	/*start insert dalam kota*/
		//$qpilihan  = "SELECT id, kuota, total_pendaftar FROM pilihan where (substring(kode_sekolah,1,1)=2 or substring(kode_sekolah,1,1)=3) and (jalur=1) ORDER BY id ASC";
		$qpilihan  = "SELECT a.id, a.quota,b.name FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=1)";
		$rpilihan = $mysqli->query( $qpilihan) or die(mysql_error());
		$j=1;
		$qfiltered='';
		while($row = mysql_fetch_array($rpilihan)){
			$passinggrade = 0.00;
			$passinggrade_luar = 0.00;
			$i=0;
			$j=0;
			$y=0;
			echo $row['id'] . "<br><br>";
			foreach($listsekolah[$row['id']]['dalam']['data'] as $r){
				$parts[] .="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "')";
				$passinggrade = $r['total'];



				if ($r['asal_pendaftar']==2){
					$y++;
					$passinggrade_luar = $r['total'];
				}

				if ($r['diterima']==2) {
					$i++;
				}

				$j++;
			}
			foreach($listsekolah[$row['id']]['luar']['data'] as $r){
				$parts[] .="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "')";
				//$passinggrade = $r['total'];



				if ($r['asal_pendaftar']==2){
					$y++;
					$passinggrade_luar = $r['total'];
				}

				if ($r['diterima']==2) {
					$i++;
				}

				$j++;
			}
			$filtered_total =count($listsekolah[$row['id']]['dalam']['data']) +count($listsekolah[$row['id']]['luar']['data']);
			$update_pg = "update ppdb_statistic set passing_grade ='" . $passinggrade . "',filtered_total='" . $filtered_total . "',filtered_foreigner='" . $y . "',passing_grade_foreigner='" . $passinggrade_luar . "'  where `option`='" . $row['id'] .  "'";

			$rupdate=$mysqli->query($update_pg);@mysql_free_result($rupdate);
		}

		mysql_free_result($rpilihan);
		if ($parts!=""){
		$qfiltered = "insert into ppdb_filtered_elementary (`registration`, `option`) values " . implode(', ', $parts);
		$result = $mysqli->query($qfiltered) or die(mysql_error());
		}
		unset($parts);

		$time_end = microtime(true);
		$time = $time_end - $time_start;
		/*$datetime_now = gmdate('Y-m-d H:i:s',time()+60*60*7); */
		$datetime_now = date('Y-m-d H:i:s');
		$qsignal = "insert into sys_signal (`id`, `signal`,`post_time`) values ('','filter_ok', '" . $datetime_now . "')";
		$res_signal = $mysqli->query($qsignal) or die(mysql_error());
		echo 'Filtered : '.$time . ' on ' . $datetime_now;
		echo '<br/>'.memory_get_usage();

	exit;

		$qpilihan  = "SELECT id, kuota,total_pendaftar  FROM pilihan where substring(kode_sekolah,1,1)=1 ORDER BY id ASC";
		$rpilihan = $mysqli->query( $qpilihan) or die(mysql_error());
		$j=1;
		$qfiltered='';
		while($row = mysql_fetch_array($rpilihan)){
			$passinggrade = 0.00;
			$i=0;

			foreach($listsekolah[$row['id']]['dalam']['data'] as $r){
				$parts[] ="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "', '" . $r['tanggal'] . "', '" . $r['jenjang'] . "',
				'" . $r['jalur'] . "','" . $r['asal_pendaftar'] . "','" . $r['no_pendaftaran'] . "','" . $r['tahun_lulus'] . "',
				'" . $r['no_un'] . "','" . mysql_real_escape_string($r['nama']) . "','" . $r['jk'] . "','" . mysql_real_escape_string($r['tmp_lahir']) . "',
				'" . $r['tgl_lahir'] . "','" . mysql_real_escape_string($r['alamat']) . "','" . mysql_real_escape_string($r['asal_sekolah']) . "','" . $r['pilihan1'] . "',
				'" . $r['pilihan2'] . "','" . $r['diterima'] . "','" . $r['skor_jarak1'] . "','" . $r['skor_jarak2'] . "',
				'" . $r['skor_umur'] . "','" . $r['total'] . "')";
				$passinggrade = $r['total'];

				if ($r['diterima']==2) {$i++;}
			}
			$total_pedaftar_limpahan=$row['total_pendaftar']+$i;
			/*if ($total_pedaftar_limpahan < $row['kuota']){
				$update_pg = "update pilihan set passing_grade = '0.00'  where id='" . $row['id'] .  "'";
				$rupdate=$mysqli->query($update_pg);@mysql_free_result($rupdate);
			}else{ */
				$update_pg = "update pilihan set passing_grade ='" . $passinggrade . "'  where id='" . $row['id'] .  "'";
				$rupdate=$mysqli->query($update_pg);@mysql_free_result($rupdate);
			//}


			if (isset($parts)!=""){
			//echo $row['id'] . '-';
			$qfiltered = "insert into filtered_sd1_dalam (
			`id_pendaftar`, `id_pilihan`,`tanggal`, `jenjang`,
			`jalur`, `asal_pendaftar`,`no_pendaftaran`, `tahun_lulus`,
			`no_un`, `nama`,`jk`, `tmp_lahir`,
			`tgl_lahir`, `alamat`,`asal_sekolah`, `pilihan1`,
			`pilihan2`, `status`,`skor_jarak1`, `skor_jarak2`,
			`skor_usia`,`total`) values " . implode(', ', $parts);

			//echo $qfiltered . '<br/><br/>';
			$result = $mysqli->query($qfiltered) or die(mysql_error());
			@mysql_free_result($result);
			}
			unset($parts);

		}
		@mysql_free_result($rpilihan);

		/*start 9999*/
		$qpilihan  = "SELECT id FROM pilihan where id=9999 ORDER BY id ASC";
		$rpilihan = $mysqli->query( $qpilihan) or die(mysql_error());
		$qfiltered='';
		while($row = mysql_fetch_array($rpilihan)){
			$passinggrade = 0.00;
			$i=0;

			foreach($listsekolah[$row['id']]['dalam']['data'] as $r){
				$parts[] ="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "', '" . $r['tanggal'] . "', '" . $r['jenjang'] . "',
				'" . $r['jalur'] . "','" . $r['asal_pendaftar'] . "','" . $r['no_pendaftaran'] . "','" . $r['tahun_lulus'] . "',
				'" . $r['no_un'] . "','" . mysql_real_escape_string($r['nama']) . "','" . $r['jk'] . "','" . mysql_real_escape_string($r['tmp_lahir']) . "',
				'" . $r['tgl_lahir'] . "','" . mysql_real_escape_string($r['alamat']) . "','" . $r['asal_sekolah'] . "','" . $r['pilihan1'] . "',
				'" . $r['pilihan2'] . "','" . $r['diterima'] . "','" . $r['skor_jarak1'] . "','" . $r['skor_jarak2'] . "',
				'" . $r['skor_umur'] . "','" . $r['total'] . "')";
				$passinggrade = $r['total'];
				if ($r['diterima']==2) {$i++;}
			}

			if ($parts!=""){
				$qfiltered = "insert into filtered_sd1_dalam (
				`id_pendaftar`, `id_pilihan`,`tanggal`, `jenjang`,
				`jalur`, `asal_pendaftar`,`no_pendaftaran`, `tahun_lulus`,
				`no_un`, `nama`,`jk`, `tmp_lahir`,
				`tgl_lahir`, `alamat`,`asal_sekolah`, `pilihan1`,
				`pilihan2`, `status`,`skor_jarak1`, `skor_jarak2`,
				`skor_usia`,`total`) values " . implode(', ', $parts);
				$result = $mysqli->query($qfiltered) or die(mysql_error());
				@mysql_free_result($result);
			}
			unset($parts);
		}
		mysql_free_result($rpilihan);
		/*end 9999*/

	echo 'truncate';

	/*start insert luar*/
	$result=$mysqli->query('TRUNCATE TABLE `filtered_sd1_luar`') or die(mysql_error());
	@mysql_free_result($result);

		$qpilihan  = "SELECT id, kuota,total_pendaftar  FROM pilihan where substring(kode_sekolah,1,1)=1 ORDER BY id ASC";
		$rpilihan = $mysqli->query( $qpilihan) or die(mysql_error());
		$j=1;
		$qfiltered='';
		while($row = mysql_fetch_array($rpilihan)){
			$passinggrade = 0.00;
			$i=0;

			foreach($listsekolah[$row['id']]['luar']['data'] as $r){
				$parts[] ="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "', '" . $r['tanggal'] . "', '" . $r['jenjang'] . "',
				'" . $r['jalur'] . "','" . $r['asal_pendaftar'] . "','" . $r['no_pendaftaran'] . "','" . $r['tahun_lulus'] . "',
				'" . $r['no_un'] . "','" . mysql_real_escape_string($r['nama']) . "','" . $r['jk'] . "','" . mysql_real_escape_string($r['tmp_lahir']) . "',
				'" . $r['tgl_lahir'] . "','" . mysql_real_escape_string($r['alamat']) . "','" . mysql_real_escape_string($r['asal_sekolah']) . "','" . $r['pilihan1'] . "',
				'" . $r['pilihan2'] . "','" . $r['diterima'] . "','" . $r['skor_jarak1'] . "','" . $r['skor_jarak2'] . "',
				'" . $r['skor_umur'] . "','" . $r['total'] . "')";
				$passinggrade = $r['total'];

				if ($r['diterima']==2) {$i++;}
			}
			$total_pedaftar_limpahan=$row['total_pendaftar']+$i;

				$update_pg = "update pilihan set passing_grade_luar	 ='" . $passinggrade . "'  where id='" . $row['id'] .  "'";
				$rupdate=$mysqli->query($update_pg);@mysql_free_result($rupdate);



			if (isset($parts)!=""){
			//echo $row['id'] . '-';
			$qfiltered = "insert into filtered_sd1_luar (
			`id_pendaftar`, `id_pilihan`,`tanggal`, `jenjang`,
			`jalur`, `asal_pendaftar`,`no_pendaftaran`, `tahun_lulus`,
			`no_un`, `nama`,`jk`, `tmp_lahir`,
			`tgl_lahir`, `alamat`,`asal_sekolah`, `pilihan1`,
			`pilihan2`, `status`,`skor_jarak1`, `skor_jarak2`,
			`skor_usia`,`total`) values " . implode(', ', $parts);

			//echo $qfiltered . '<br/><br/>';
			$result = $mysqli->query($qfiltered) or die(mysql_error());
			@mysql_free_result($result);
			}
			unset($parts);

		}
		@mysql_free_result($rpilihan);

		/*start 9999 luar*/

			$qpilihan  = "SELECT id FROM pilihan where id=9999 ORDER BY id ASC";
			$rpilihan = $mysqli->query( $qpilihan) or die(mysql_error());
			$qfiltered='';
			while($row = mysql_fetch_array($rpilihan)){
				$passinggrade = 0.00;
				$i=0;

				foreach($listsekolah[$row['id']]['luar']['data'] as $r){
					$parts[] ="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "', '" . $r['tanggal'] . "', '" . $r['jenjang'] . "',
					'" . $r['jalur'] . "','" . $r['asal_pendaftar'] . "','" . $r['no_pendaftaran'] . "','" . $r['tahun_lulus'] . "',
					'" . $r['no_un'] . "','" . mysql_real_escape_string($r['nama']) . "','" . $r['jk'] . "','" . mysql_real_escape_string($r['tmp_lahir']) . "',
					'" . $r['tgl_lahir'] . "','" . mysql_real_escape_string($r['alamat']) . "','" . $r['asal_sekolah'] . "','" . $r['pilihan1'] . "',
					'" . $r['pilihan2'] . "','" . $r['diterima'] . "','" . $r['skor_jarak1'] . "','" . $r['skor_jarak2'] . "',
					'" . $r['skor_umur'] . "','" . $r['total'] . "')";
					$passinggrade = $r['total'];
					if ($r['diterima']==2) {$i++;}
				}

				if ($parts!=""){
					$qfiltered = "insert into filtered_sd1_luar (
					`id_pendaftar`, `id_pilihan`,`tanggal`, `jenjang`,
					`jalur`, `asal_pendaftar`,`no_pendaftaran`, `tahun_lulus`,
					`no_un`, `nama`,`jk`, `tmp_lahir`,
					`tgl_lahir`, `alamat`,`asal_sekolah`, `pilihan1`,
					`pilihan2`, `status`,`skor_jarak1`, `skor_jarak2`,
					`skor_usia`,`total`) values " . implode(', ', $parts);
					$result = $mysqli->query($qfiltered) or die(mysql_error());
					@mysql_free_result($result);
				}
				unset($parts);
			}
			mysql_free_result($rpilihan);
		/*end 9999 luar*/

	/*end insert luar*/

	$time_end = microtime(true);
	$time = $time_end - $time_start;
	/*$datetime_now = gmdate('Y-m-d H:i:s',time()+60*60*7); */
	$datetime_now = date('Y-m-d H:i:s');
	echo 'Filtered : '.$time . ' on ' . $datetime_now;
	echo '<br/>'.memory_get_usage();


 ?>