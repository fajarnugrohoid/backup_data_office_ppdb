<?php

	ini_set('max_execution_time', 10000);
	ini_set("memory_limit","-1");
	error_reporting(E_ERROR | E_ALL);


	# connection
	/*kuota prestasi = 5%*/
	/*kuota luar kota prestasi = 2.5%*/
	/*kouta kurang_mampu tidak ada luar kota*/
	/*prestasi : total kejuaraan dijumlahkan*/
	/*kurang_mampu : db + jarak_tempuh*/ /*jika smk maka afirmasi kurang mampu tidak diitung jarak*/
	/*batas quota prestasi : un,b.indo,b.inggrs,mtk,ipa,jarak*/
	/*batas quota tidak mampu : jarak, baru nilai un, b.indo, b.inggrs, mtk, ipa, jaraka*/

	include('connection.php');

	$time_start = microtime(true);
	function sorting_prestasi(&$arr, $col_skor_komulatif, $col_total, $col_n1, $col_n2, $col_n3, $col_n4, $col_skorjarak) {
		$sort_col_skor_komulatif = array();
		$sort_col_total = array();
		$sort_col_n1 = array();
		$sort_col_n2 = array();
		$sort_col_n3 = array();
		$sort_col_n4 = array();
		$sort_col_skorjarak = array();

		foreach ($arr as $key=> $row) {
			$sort_col_skor_komulatif[$key] = $row[$col_skor_komulatif];
			$sort_col_total[$key] = $row[$col_total];
			$sort_col_n1[$key] = $row[$col_n1];
			$sort_col_n2[$key] = $row[$col_n2];
			$sort_col_n3[$key] = $row[$col_n3];
			$sort_col_n4[$key] = $row[$col_n4];
			$sort_col_skorjarak[$key] = $row[$col_skorjarak];
		}
		array_multisort($sort_col_skor_komulatif, SORT_DESC,$sort_col_total, SORT_DESC,$sort_col_n1, SORT_DESC,$sort_col_n2, SORT_DESC,$sort_col_n3, SORT_DESC,$sort_col_n4, SORT_DESC, $sort_col_skorjarak,SORT_DESC, $arr);
	}
	function sorting_kurangmampu(&$arr, $col_skor_komulatif,$col_skorjarak, $col_total, $col_n1, $col_n2, $col_n3, $col_n4) {
		$sort_col_skor_komulatif = array();
		$sort_col_skorjarak = array();
		$sort_col_total = array();
		$sort_col_n1 = array();
		$sort_col_n2 = array();
		$sort_col_n3 = array();
		$sort_col_n4 = array();


		foreach ($arr as $key=> $row) {
			$sort_col_skor_komulatif[$key] = $row[$col_skor_komulatif];
			$sort_col_skorjarak[$key] = $row[$col_skorjarak];
			$sort_col_total[$key] = $row[$col_total];
			$sort_col_n1[$key] = $row[$col_n1];
			$sort_col_n2[$key] = $row[$col_n2];
			$sort_col_n3[$key] = $row[$col_n3];
			$sort_col_n4[$key] = $row[$col_n4];
		}
		array_multisort($sort_col_skor_komulatif, SORT_DESC,$sort_col_skorjarak,SORT_DESC, $sort_col_total, SORT_DESC,$sort_col_n1, SORT_DESC,$sort_col_n2, SORT_DESC,$sort_col_n3, SORT_DESC,$sort_col_n4, SORT_DESC,  $arr);
	}

	function process_sort(&$arr, $col_skor_komulatif, $col_total, $col_skorjarak){

		$sort_col_skor_komulatif = array();
		$sort_col_total = array();
		$sort_col_skorjarak = array();

		foreach ($arr as $key=> $row) {
			$sort_col_skor_komulatif[$key] = $row[$col_skor_komulatif];
			$sort_col_total[$key] = $row[$col_total];
			$sort_col_skorjarak[$key] = $row[$col_skorjarak];
		}
		array_multisort($sort_col_skor_komulatif, SORT_DESC,$sort_col_total, SORT_DESC, $sort_col_skorjarak,SORT_DESC, $arr);
	}

	//empty ppdb_statistic
	$truncate_statistic=$mysqli->query('TRUNCATE TABLE `ppdb_statistic`') or die(mysqli_error());



	# ambil data
	$query  = "SELECT distinct(b.id),a.code,b.type,b.quota,a.name,a.is_border,substring(a.code,1,1) as code
				FROM ppdb_school a
				INNER JOIN ppdb_option b ON ( a.id = b.school )
				where (substring(a.code,1,1)=2 or substring(a.code,1,1)=3 or substring(a.code,1,1)=4) and (b.type='achievement' or b.type='rmp')
				ORDER BY a.code, b.id";
	$resul1 = $mysqli->query( $query) or die(mysqli_error());
	$update_tot_pendaftar='';
	while($row = mysqli_fetch_array($resul1)){ // sekolah

		$query  = "SELECT * FROM ppdb_registration_nonacademic
		where (type='achievement' or type='rmp')  and first_choice = '".$row['id']." '
		and status='approved'
		";
		$resul2 = $mysqli->query($query) or die(mysqli_error());

		$x=0;
		$y=0; //y=luar_kota
		while($r = mysqli_fetch_array($resul2)){
			$siswa[$x]['id'] 					= $r['id'];
			$siswa[$x]['jalur'] 				= $r['type'];
			$siswa[$x]['nama'] 					= $r['name'];
			$siswa[$x]['no_un'] 				= $r['no_un'];
			$siswa[$x]['pilihan1'] 				= $r['first_choice'];
			$siswa[$x]['pilihan2'] 				= $r['second_choice'];
			$siswa[$x]['skor_jarak'] 			= $r['score_range1'];
			$siswa[$x]['skor_jarak1'] 			= $r['score_range1'];
			$siswa[$x]['skor_jarak2'] 			= $r['score_range2'];
			$siswa[$x]['terima_disekolah'] 		= $r['first_choice'];
			$siswa[$x]['total'] 				= $r['score_total1'];
			$siswa[$x]['total1'] 				= $r['score_total1'];
			$siswa[$x]['total2'] 				= $r['score_total2'];
			$siswa[$x]['score_achievement'] 	= $r['score_achievement'];
			$siswa[$x]['score_poor'] 			= $r['score_poor'];
			$siswa[$x]['diterima'] = '1';
			if ($r['type']=='achievement'){
				$siswa[$x]['skor_na']			=$r['score_achievement'];
				$siswa[$x]['skor_komulatif'] 	= $siswa[$x]['skor_na'];
				$siswa[$x]['score_limit']=0;
			}elseif($r['type']=='rmp'){
				$siswa[$x]['skor_na']			=$r['score_poor'] ;
				$siswa[$x]['score_range']		=$r['score_range1'] ;
				$siswa[$x]['skor_komulatif'] 	= $siswa[$x]['skor_na'];
				$siswa[$x]['score_limit']		=($r['score_range1']*0.7) + ($r['score_total1']*0.3) ;
			}elseif($r['type']=='uu_guru'){
				$siswa[$x]['skor_na']			=$r['score_range1'] ;
				$siswa[$x]['skor_komulatif'] 	= $siswa[$x]['skor_na'];
				$siswa[$x]['score_limit']		=0;
			}


			$siswa[$x]['asal_pendaftar'] 	= $r['is_foreigner'];
			if ($siswa[$x]['asal_pendaftar']=='2'){
				$y++;
			}

			$x++;

		}
		mysqli_free_result($resul2);
		$listsekolah[$row['id']]['id'] = $row['id'];
		$listsekolah[$row['id']]['nama_sekolah'] = $row['name'];
		$listsekolah[$row['id']]['kuota'] = $row['quota'];
		$listsekolah[$row['id']]['kode_jenjang'] = $row['code'];
		$listsekolah[$row['id']]['jalur'] = $row['type'];
		$listsekolah[$row['id']]['wilayah_batasan'] = $row['is_border'];
		if(isset($siswa)){
			$listsekolah[$row['id']]['data'] = $siswa;
		}else{
			$listsekolah[$row['id']]['data'] = array();
		}
		$listsekolah[$row['id']]['status'] = 0;
		/*$update_tot_pendaftar = "update pilihan  set total_pendaftar = '" . $x . "' where id='" . $row['id'] .  "';";*/
		$update_tot_pendaftar = "insert into ppdb_statistic (`id`, `option`, `registered_total`,`registered_foreigner`) values ('', '" . $row['id'] . "','" . $x . "','" . $y . "')";
		$result_update_tot_pendaftar = $mysqli->query($update_tot_pendaftar);
		@mysqli_free_result($result_update_tot_pendaftar);

		unset($siswa);
	}

	$listsekolah['9999']['id'] = '9999';
	$listsekolah['9999']['nama']  = 'Buangan';
	$listsekolah['9999']['kuota'] = 0;
	$listsekolah['9999']['data'] = array();
	$listsekolah['9999']['status'] = 1;
	mysqli_free_result($resul1);



	#------- Proses
	$passgrad = TRUE;
	while($passgrad != FALSE){ // selama masih ada sekolah yg harus di sorting
		$passgrad = FALSE;

		foreach($listsekolah as $sekolah){ // sort tiap sekolah
			if($sekolah['id'] == '9999'){continue;}
			if($sekolah['status'] == 0){
				# init
				$id = $sekolah['id'];

				# sort
				/*if ($listsekolah[$id]['jalur']==2) sorting_prestasi($listsekolah[$id]['data'], 'skor_komulatif','total','skor_jarak');
				else sorting_kurangmampu($listsekolah[$id]['data'], 'skor_komulatif','total','skor_jarak');*/
				process_sort($listsekolah[$id]['data'], 'skor_komulatif','total','skor_jarak', 'score_limit');
				// print_r($listsekolah[$id]['data']);
				// echo '<br>';

				# passing

				$jml_pend = count($listsekolah[$id]['data']);
				$lokasi_kota10 = floor($sekolah['kuota'] * 0.1);
				$lokasi_kota_prestasi = floor($sekolah['kuota'] * 0.50);
				//$lokasi_batasan25 = floor($sekolah['kuota'] * 0.25);

				$luarkota=0;

				if (($listsekolah[$id]['kode_jenjang']!=4) || ($listsekolah[$id]['jalur']!='rmp')){
					$kuota_luarkota = $lokasi_kota_prestasi;

					for($e = 0; $e<$jml_pend; $e++){
						if ($listsekolah[$id]['data'][$e]['asal_pendaftar']==2){
							$luarkota++;

							if ($luarkota>$kuota_luarkota){
								if($listsekolah[$id]['data'][$e]['pilihan2'] != $sekolah['id']){ /* lempar ke pilihan 2 */

									$listsekolah[$id]['data'][$e]['total'] = $listsekolah[$id]['data'][$e]['total2']; /*lempar ke pilihan 2, total diganti ke total2*/
									$listsekolah[$id]['data'][$e]['skor_jarak'] = $listsekolah[$id]['data'][$e]['skor_jarak2']; /*lempar ke pilihan 2, skor jarak diganti ke skor jarak2*/
									$listsekolah[$id]['data'][$e]['skor_komulatif'] = $listsekolah[$id]['data'][$e]['skor_na']; /*lempar ke pilihan 2, skor komulatif diisi oleh skor non akademis karena prestasi*/
									$listsekolah[$id]['data'][$e]['score_range']=$listsekolah[$id]['data'][$e]['skor_jarak2'];

									if ($listsekolah[$id]['data'][$e]['pilihan2'] == 9999) {
										$listsekolah[$id]['data'][$e]['diterima'] = 3;


										$listsekolah[$id]['data'][$e]['terima_disekolah'] = 9999;
										array_push($listsekolah['9999']['data'], $listsekolah[$id]['data'][$e]);
										array_splice($listsekolah[$id]['data'], $e, 1);
									}else{
										$xid = $listsekolah[$id]['data'][$i]['pilihan2'];  //cek id sekolah
										if (!isset( $listsekolah[$xid])){ //cek id sekolah, jika tidak ada lempar ke pilihan 9999
											$listsekolah[$id]['data'][$e]['diterima'] = 3;
											$listsekolah[$id]['data'][$e]['terima_disekolah'] = 9999;
											array_push($listsekolah['9999']['data'], $listsekolah[$id]['data'][$e]);
											array_splice($listsekolah[$id]['data'], $e, 1);
										}else{
											$listsekolah[$id]['data'][$e]['diterima'] = 2;
											$listsekolah[$id]['data'][$e]['terima_disekolah'] = $listsekolah[$id]['data'][$e]['pilihan2'];
											$listsekolah[$listsekolah[$id]['data'][$e]['pilihan2']]['status'] = 0;

											array_push($listsekolah[$listsekolah[$id]['data'][$e]['pilihan2']]['data'], $listsekolah[$id]['data'][$e]);
											array_splice($listsekolah[$id]['data'], $e, 1);
										}
									}

								}else{ /* tidak diterima dimana2 */
									$listsekolah[$id]['data'][$e]['diterima'] = 3;
									$listsekolah[$id]['data'][$e]['terima_disekolah'] = 9999;
									array_push($listsekolah['9999']['data'], $listsekolah[$id]['data'][$e]);
									array_splice($listsekolah[$id]['data'], $e, 1);

								}

								$jml_pend--;
								$e--;
							}
						}
					}
				}

				$jml_pend = count($listsekolah[$id]['data']);

				if($jml_pend > $sekolah['kuota']){ /* potong berdasarkan kuota */

					// # lemparkan
					for($i = $jml_pend-1; $i>$sekolah['kuota']-1; $i--){
						if($listsekolah[$id]['data'][$i]['pilihan2'] != $sekolah['id']){ /* lempar ke pilihan 2 */

							$listsekolah[$id]['data'][$i]['total'] = $listsekolah[$id]['data'][$i]['total2']; /*lempar ke pilihan 2, total diganti ke total2*/
							$listsekolah[$id]['data'][$i]['skor_jarak'] = $listsekolah[$id]['data'][$i]['skor_jarak2']; /*lempar ke pilihan 2, skor jarak diganti ke skor jarak2*/

							$listsekolah[$id]['data'][$i]['score_range']=$listsekolah[$id]['data'][$i]['skor_jarak2'];

							if ($listsekolah[$id]['jalur']=='achievement'){ /*prestasi*/
								$listsekolah[$id]['data'][$i]['skor_komulatif'] = $listsekolah[$id]['data'][$i]['skor_na']; /*lempar ke pilihan 2, skor komulatif diisi oleh skor_na prestasi*/
							}elseif($listsekolah[$id]['jalur']=='rmp'){ /*tidak mampu*/
								/*if ($listsekolah[$id]['kode_jenjang']==4){
									$listsekolah[$id]['data'][$i]['skor_komulatif'] = $listsekolah[$id]['data'][$i]['skor_na']; //tidak_mampu lempar ke pilihan 2, skor komulatif diisi oleh skor na saja krn smk
								}else{
									$listsekolah[$id]['data'][$i]['skor_komulatif'] = $listsekolah[$id]['data'][$i]['skor_na'] + $listsekolah[$id]['data'][$i]['skor_jarak2']; //tidak_mampu lempar ke pilihan 2, skor komulatif diisi oleh skor non akademis+skor jarak2 krn sma & smp
								}*/

								//$listsekolah[$id]['data'][$i]['skor_komulatif'] = $listsekolah[$id]['data'][$i]['skor_na'] + get_score_range($listsekolah[$id]['data'][$i]['skor_jarak2']);
								$listsekolah[$id]['data'][$i]['skor_komulatif'] = $listsekolah[$id]['data'][$i]['skor_na'];
							}

							if ($listsekolah[$id]['data'][$i]['pilihan2'] == 9999) {
								$listsekolah[$id]['data'][$i]['diterima'] = 3;
								$listsekolah[$id]['data'][$i]['terima_disekolah'] = 9999;


								array_push($listsekolah['9999']['data'], $listsekolah[$id]['data'][$i]);
								array_splice($listsekolah[$id]['data'], $i, 1);

							}else{



								$xid = $listsekolah[$id]['data'][$i]['pilihan2'];  //cek id sekolah
								if (!isset( $listsekolah[$xid])){ //cek id sekolah, jika tidak ada lempar ke pilihan 9999
										echo 'id sekolah tidak ada = '.$xid.'<br/>';
										$listsekolah[$id]['data'][$i]['diterima'] = 3;
										$listsekolah[$id]['data'][$i]['terima_disekolah'] = 9999;
										array_push($listsekolah['9999']['data'], $listsekolah[$id]['data'][$i]);
										array_splice($listsekolah[$id]['data'], $i, 1);
								}else{
									$listsekolah[$id]['data'][$i]['diterima'] = 2;
									$listsekolah[$id]['data'][$i]['terima_disekolah'] = $listsekolah[$id]['data'][$i]['pilihan2'];
									$listsekolah[$listsekolah[$id]['data'][$i]['pilihan2']]['status'] = 0;


									array_push($listsekolah[$listsekolah[$id]['data'][$i]['pilihan2']]['data'], $listsekolah[$id]['data'][$i]);
									array_splice($listsekolah[$id]['data'], $i, 1);
								}


							}
						}else{ // tidak diterima dimana2
							$listsekolah[$id]['data'][$i]['diterima'] = 3;
							$listsekolah[$id]['data'][$i]['terima_disekolah'] = 9999;
							array_push($listsekolah['9999']['data'], $listsekolah[$id]['data'][$i]);
							array_splice($listsekolah[$id]['data'], $i, 1);
						}
					}
				}
				$listsekolah[$id]['status'] = 1;

			}
		}


		# cek sekolah, bisi aya nu can di sorting
		foreach($listsekolah as $sekolah){
			if($sekolah['status'] == 0){
				$passgrad = TRUE;
				break;
			}
		}
	}

	foreach ($listsekolah as $sekolah){
		?>
			<?php echo $sekolah['id']; ?>
			<table border="1">
					<thead>
						<tr>
						<td>Nama</td>
						<td>Sekolah Pilihan 1</td>
						<td>Sekolah Pilihan 2</td>
						<td>Total Nilai 1</td>
						<td>Total Nilai 2</td>
						<td>Skor Poor</td>
						<td>Skor Achievement</td>
						<td>Skor Jarak</td>
						<td>Skor NA</td>
						<td>Skor Komulatif</td>
						<td>Jarak 1</td>
						<td>Jarak 2</td>
						<td>Score Limit</td>
						<td>Total Nilai</td>
						<td>Diterima</td>
						<td>Jalur</td>
						</tr>
					</thead>
				<?php
					foreach($sekolah['data'] as $siswa){
						?>
							<tr>
								<td><?=$siswa['nama']?></td>
								<td><?=$siswa['pilihan1']?></td>
								<td><?=$siswa['pilihan2']?></td>
								<td><?=$siswa['total1']?></td>
								<td><?=$siswa['total2']?></td>
								<td><?=$siswa['score_poor']?></td>
								<td><?=$siswa['score_achievement']?></td>
								<td>
									<?php 
										if ($siswa['jalur']=='rmp'){
										echo $siswa['score_range'];	
										}
									?>
								</td>
								<td><?=$siswa['skor_na']?></td>
								<td><?=$siswa['skor_komulatif']?></td>
								<td><?=$siswa['skor_jarak1']?></td>
								<td><?=$siswa['skor_jarak2']?></td>
								<td><?=$siswa['score_limit']?></td>
								<td><?=$siswa['total']?></td>
								<td><?=$siswa['diterima']?></td>
								<td><?=$siswa['jalur']?></td>
							</tr>
						<?php
					}
				?>
			</table>
			<br/>
		<?php
	}
	$parts = [];
	$result=$mysqli->query('TRUNCATE TABLE `ppdb_filtered_nonacademic`') or die(mysqli_error());

		$qpilihan  = "SELECT a.id, a.quota FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 or substring(b.code,1,1)=4) and (a.type='achievement' or a.type='rmp') ORDER BY a.id ASC";
		$rpilihan = $mysqli->query( $qpilihan) or die(mysqli_error());
		$j=1;
		$qfiltered='';
		while($row = mysqli_fetch_array($rpilihan)){
			$passinggrade = 0.00;
			$i=0;
			foreach($listsekolah[$row['id']]['data'] as $r){
				$parts[] ="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "')";
				$passinggrade = $r['total'];

				if ($r['diterima']==2) {$i++;}
			}
			/*$total_pedaftar_limpahan=$row['registered_total']+$i;
			if ($total_pedaftar_limpahan < $row['quota']){
				//$update_pg = "update pilihan set passing_grade = '0.00'  where id='" . $row['id'] .  "'";
				$update_pg = "insert into ppdb_statistic (id,registered_total, passing_grade) values ('" . $row['id'] . "','0','" . $passinggrade . "')";
				$rupdate=$mysqli->query($update_pg);@mysqli_free_result($rupdate);
			}else{
				$update_pg = "update pilihan set passing_grade ='" . $passinggrade . "'  where id='" . $row['id'] .  "'";
				$rupdate=$mysqli->query($update_pg);@mysqli_free_result($rupdate);
			}*/
		}
		mysqli_free_result($rpilihan);
		if ($parts!=""){
		$qfiltered = "insert into ppdb_filtered_nonacademic (`registration`, `option`) values " . implode(', ', $parts);
		$result = $mysqli->query($qfiltered) or die(mysqli_error());
		}
		unset($parts);

	$time_end = microtime(true);
	$time = $time_end - $time_start;
	/*$datetime_now = gmdate('Y-m-d H:i:s',time()+60*60*7); */
	$datetime_now = date('Y-m-d H:i:s');
	$qsignal = "insert into sys_signal (`id`, `signal`,`params`,`created_at`, `updated_at`) values ('','filter_ok', '" . $datetime_now . "','selection','" . date("Y-m-d") . "')";
	$res_signal = $mysqli->query($qsignal) or die(mysqli_error());
	echo 'Filtered : '.$time . ' on ' . $datetime_now;
	echo '<br/>'.memory_get_usage();

 ?>
