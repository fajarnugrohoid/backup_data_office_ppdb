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
	function process_sort(&$arr, $col_skor_komulatif, $col_total, $col_skorjarak, $col_limit, $col_range){

		$sort_col_skor_komulatif = array();
		$sort_col_total = array();
		$sort_col_skorjarak = array();
		$sort_col_limit = array();
		$sort_col_range = array();

		foreach ($arr as $key=> $row) {
			$sort_col_skor_komulatif[$key] = $row[$col_skor_komulatif];
			$sort_col_total[$key] = $row[$col_total];
			$sort_col_skorjarak[$key] = $row[$col_skorjarak];
			$sort_col_limit[$key] = $row[$col_limit];
			$sort_col_range[$key] = $row[$col_range];
		}
		array_multisort($sort_col_skor_komulatif, SORT_DESC,$sort_col_total, SORT_DESC, $sort_col_skorjarak,SORT_DESC, $sort_col_limit, SORT_DESC ,$sort_col_range, SORT_ASC, $arr);
	}

	//empty ppdb_statistic
	$truncate_statistic=$mysqli->query('TRUNCATE TABLE `ppdb_statistic`') or die(mysqli_error($mysqli));



	# ambil data
	$query  = "SELECT distinct(b.id),a.code,b.type,b.quota,a.name,a.is_border,substring(a.code,1,1) as code
				FROM ppdb_school a
				INNER JOIN ppdb_option b ON ( a.id = b.school )
				where (substring(a.code,1,1)=2 or substring(a.code,1,1)=3 or substring(a.code,1,1)=4) and (b.type='achievement' or b.type='rmp' or b.type='mou' or b.type='uu_guru' or b.type='inklusif')
				ORDER BY a.code, b.id";
	$resul1 = $mysqli->query( $query) or die(mysqli_error($mysqli));
	$update_tot_pendaftar='';
	while($row = mysqli_fetch_array($resul1)){ // sekolah

		$query  = "SELECT * FROM ppdb_registration_nonacademic
		where (type='achievement' or type='rmp' or type='mou' or type='uu_guru' or type='inklusif')  and first_choice = '".$row['id']." '
		and status='approved'
		";
		$resul2 = $mysqli->query($query) or die(mysqli_error($mysqli));

		$x=0;
		$y=0; //y=luar_kota
		while($r = mysqli_fetch_array($resul2)){
			$siswa[$x]['id'] 					= $r['id'];
			$siswa[$x]['type'] 				= $r['type'];
			$siswa[$x]['name'] 					= $r['name'];
			$siswa[$x]['first_choice'] 			= $r['first_choice'];
			$siswa[$x]['second_choice'] 		= $r['second_choice'];
			$siswa[$x]['score_range'] 			= $r['score_range1'];
			$siswa[$x]['score_range1'] 			= $r['score_range1'];
			$siswa[$x]['score_range2'] 			= $r['score_range2'];
			$siswa[$x]['range'] 				= $r['range1'];
			$siswa[$x]['range1'] 				= $r['range1'];
			$siswa[$x]['range2'] 				= $r['range2'];
			$siswa[$x]['accepted_school'] 		= $r['first_choice'];
			$siswa[$x]['score_total'] 			= $r['score_total1'];
			$siswa[$x]['score_total1'] 			= $r['score_total1'];
			$siswa[$x]['score_total2'] 			= $r['score_total2'];
			$siswa[$x]['score_achievement'] 	= $r['score_achievement'];
			$siswa[$x]['score_poor'] 			= $r['score_poor'];
			$siswa[$x]['accepted_status'] 		= '1';
			$siswa[$x]['score_limit']			=0;
			$siswa[$x]['score_cumulative']		=0;
			if ($r['type']=='achievement'){
				$siswa[$x]['score_cumulative'] 	=$r['score_achievement'];
			}elseif($r['type']=='rmp'){
				$siswa[$x]['score_cumulative'] 	=$r['score_poor'];
				$siswa[$x]['score_limit']		=($r['score_range1']*0.7) + ($r['score_total1']*0.3) ;
			}elseif($r['type']=='uu_guru'){
				$siswa[$x]['score_cumulative'] 	=$r['score_range1'];
			}elseif($r['type']=='inklusif'){
				$siswa[$x]['score_cumulative'] 	= $r['score_range1'];
			}
			$siswa[$x]['is_foreigner'] 			= $r['is_foreigner'];
			if ($siswa[$x]['is_foreigner']=='2'){
				$y++;
			}

			$x++;

		}
		mysqli_free_result($resul2);
		$listsekolah[$row['id']]['id'] = $row['id'];
		$listsekolah[$row['id']]['quota'] = $row['name'];
		$listsekolah[$row['id']]['quota'] = $row['quota'];
		$listsekolah[$row['id']]['code'] = $row['code'];
		$listsekolah[$row['id']]['type'] = $row['type'];
		$listsekolah[$row['id']]['is_border'] = $row['is_border'];
		if(isset($siswa)){
			$listsekolah[$row['id']]['data'] = $siswa;
		}else{
			$listsekolah[$row['id']]['data'] = array();
		}
		$listsekolah[$row['id']]['status'] = 0;
		$update_tot_pendaftar = "insert into ppdb_statistic (`id`, `option`, `registered_total`,`registered_foreigner`) values ('', '" . $row['id'] . "','" . $x . "','" . $y . "')";
		$result_update_tot_pendaftar = $mysqli->query($update_tot_pendaftar);
		@mysqli_free_result($result_update_tot_pendaftar);
		unset($siswa);
	}

	$listsekolah['9999']['id'] = '9999';
	$listsekolah['9999']['name']  = 'Buangan';
	$listsekolah['9999']['quota'] = 0;
	$listsekolah['9999']['data'] 	= array();
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

				# sortscore_cumulative
				process_sort($listsekolah[$id]['data'], 'score_cumulative','score_total','score_range', 'score_limit', 'range');

				$jml_pend = count($listsekolah[$id]['data']);
				$lokasi_kota10 = floor($sekolah['quota'] * 0.1);
				$lokasi_kota_prestasi = floor($sekolah['quota'] * 0.50);

				$luarkota=0;
				if (($listsekolah[$id]['code']!=4) || ($listsekolah[$id]['type']!='rmp')){
					$kuota_luarkota = $lokasi_kota_prestasi;

					for($e = 0; $e<$jml_pend; $e++){
						if ($listsekolah[$id]['data'][$e]['is_foreigner']==2){
							$luarkota++;

							if ($luarkota>$kuota_luarkota){
								if($listsekolah[$id]['data'][$e]['second_choice'] != $sekolah['id']){ /* lempar ke pilihan 2 */
									$listsekolah[$id]['data'][$e]['score_total'] = $listsekolah[$id]['data'][$e]['score_total2']; /*lempar ke pilihan 2, score_total diganti ke total2*/
									$listsekolah[$id]['data'][$e]['score_range'] = $listsekolah[$id]['data'][$e]['score_range2']; /*lempar ke pilihan 2, skor jarak diganti ke skor jarak2*/
									$listsekolah[$id]['data'][$e]['range']=$listsekolah[$id]['data'][$e]['range2'];

									if ($listsekolah[$id]['data'][$e]['second_choice'] == 9999) {
										$listsekolah[$id]['data'][$e]['accepted_status'] = 3;
										$listsekolah[$id]['data'][$e]['accepted_school'] = 9999;
										array_push($listsekolah['9999']['data'], $listsekolah[$id]['data'][$e]);
										array_splice($listsekolah[$id]['data'], $e, 1);
									}else{
										$xid = $listsekolah[$id]['data'][$i]['second_choice'];  //cek id sekolah
										if (!isset( $listsekolah[$xid])){ //cek id sekolah, jika tidak ada lempar ke pilihan 9999
											$listsekolah[$id]['data'][$e]['accepted_status'] = 3;
											$listsekolah[$id]['data'][$e]['accepted_school'] = 9999;
											array_push($listsekolah['9999']['data'], $listsekolah[$id]['data'][$e]);
											array_splice($listsekolah[$id]['data'], $e, 1);
										}else{
											$listsekolah[$id]['data'][$e]['accepted_status'] = 2;
											$listsekolah[$id]['data'][$e]['accepted_school'] = $listsekolah[$id]['data'][$e]['second_choice'];
											$listsekolah[$listsekolah[$id]['data'][$e]['second_choice']]['status'] = 0;

											array_push($listsekolah[$listsekolah[$id]['data'][$e]['second_choice']]['data'], $listsekolah[$id]['data'][$e]);
											array_splice($listsekolah[$id]['data'], $e, 1);
										}
									}

								}else{ /* tidak diterima dimana2 */
									$listsekolah[$id]['data'][$e]['accepted_status'] = 3;
									$listsekolah[$id]['data'][$e]['accepted_school'] = 9999;
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

				if($jml_pend > $sekolah['quota']){ /* potong berdasarkan kuota */

					// # lemparkan
					for($i = $jml_pend-1; $i>$sekolah['quota']-1; $i--){
						if($listsekolah[$id]['data'][$i]['second_choice'] != $sekolah['id']){ /* lempar ke pilihan 2 */

							$listsekolah[$id]['data'][$i]['score_total'] = $listsekolah[$id]['data'][$i]['score_total2']; /*lempar ke pilihan 2, score_total diganti ke score_total2*/
							$listsekolah[$id]['data'][$i]['score_range'] = $listsekolah[$id]['data'][$i]['score_range2']; /*lempar ke pilihan 2, skor jarak diganti ke skor jarak2*/
							$listsekolah[$id]['data'][$i]['range']=$listsekolah[$id]['data'][$i]['range2'];

							if($listsekolah[$id]['type']=='rmp'){ /*tidak mampu*/
								/*if ($listsekolah[$id]['kode_jenjang']==4){
									$listsekolah[$id]['data'][$i]['score_cumulative'] = $listsekolah[$id]['data'][$i]['skor_na']; //tidak_mampu lempar ke pilihan 2, skor komulatif diisi oleh skor na saja krn smk
								}else{
									$listsekolah[$id]['data'][$i]['score_cumulative'] = $listsekolah[$id]['data'][$i]['skor_na'] + $listsekolah[$id]['data'][$i]['score_range2']; //tidak_mampu lempar ke pilihan 2, skor komulatif diisi oleh skor non akademis+skor jarak2 krn sma & smp
								}*/
								$listsekolah[$id]['data'][$i]['score_limit'] = ($listsekolah[$id]['data'][$i]['score_range2']*0.7) + ($listsekolah[$id]['data'][$i]['score_total2']*0.3);
							}

							if ($listsekolah[$id]['data'][$i]['second_choice'] == 9999) {
								$listsekolah[$id]['data'][$i]['accepted_status'] = 3;
								$listsekolah[$id]['data'][$i]['accepted_school'] = 9999;


								array_push($listsekolah['9999']['data'], $listsekolah[$id]['data'][$i]);
								array_splice($listsekolah[$id]['data'], $i, 1);

							}else{



								$xid = $listsekolah[$id]['data'][$i]['second_choice'];  //cek id sekolah
								if (!isset( $listsekolah[$xid])){ //cek id sekolah, jika tidak ada lempar ke pilihan 9999
										echo 'id sekolah tidak ada = '.$xid.'<br/>';
										$listsekolah[$id]['data'][$i]['accepted_status'] = 3;
										$listsekolah[$id]['data'][$i]['accepted_school'] = 9999;
										array_push($listsekolah['9999']['data'], $listsekolah[$id]['data'][$i]);
										array_splice($listsekolah[$id]['data'], $i, 1);
								}else{
									$listsekolah[$id]['data'][$i]['accepted_status'] = 2;
									$listsekolah[$id]['data'][$i]['accepted_school'] = $listsekolah[$id]['data'][$i]['second_choice'];
									$listsekolah[$listsekolah[$id]['data'][$i]['second_choice']]['status'] = 0;


									array_push($listsekolah[$listsekolah[$id]['data'][$i]['second_choice']]['data'], $listsekolah[$id]['data'][$i]);
									array_splice($listsekolah[$id]['data'], $i, 1);
								}


							}
						}else{ // tidak accepted_status dimana2
							$listsekolah[$id]['data'][$i]['accepted_status'] = 3;
							$listsekolah[$id]['data'][$i]['accepted_school'] = 9999;
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
						<td>Skor Komulatif</td>
						<td>Jarak 1</td>
						<td>Jarak 2</td>
						<td>Score Limit</td>
						<td>Total Nilai</td>
						<td>Diterima</td>
						<td>type</td>
						</tr>
					</thead>
				<?php
					foreach($sekolah['data'] as $siswa){
						?>
							<tr>
								<td><?=$siswa['name']?></td>
								<td><?=$siswa['first_choice']?></td>
								<td><?=$siswa['second_choice']?></td>
								<td><?=$siswa['score_total1']?></td>
								<td><?=$siswa['score_total2']?></td>
								<td><?=$siswa['score_poor']?></td>
								<td><?=$siswa['score_achievement']?></td>
								<td>
									<?php 
										if ($siswa['type']=='rmp'){
										echo $siswa['score_range'];	
										}
									?>
								</td>
								<td><?=$siswa['score_cumulative']?></td>
								<td><?=$siswa['score_range1']?></td>
								<td><?=$siswa['score_range2']?></td>
								<td><?=$siswa['score_limit']?></td>
								<td><?=$siswa['score_total']?></td>
								<td><?=$siswa['accepted_status']?></td>
								<td><?=$siswa['type']?></td>
							</tr>
						<?php
					}
				?>
			</table>
			<br/>
		<?php
	}
	$parts = [];
	$result=$mysqli->query('TRUNCATE TABLE `ppdb_filtered_nonacademic`') or die(mysqli_error($mysqli));

		$qpilihan  = "SELECT a.id, a.quota FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 or substring(b.code,1,1)=4) and (a.type='achievement' or a.type='rmp' or b.type='mou' or b.type='uu_guru' or b.type='inklusif') ORDER BY a.id ASC";
		$rpilihan = $mysqli->query( $qpilihan) or die(mysqli_error($mysqli));
		$j=1;
		$qfiltered='';
		while($row = mysqli_fetch_array($rpilihan)){
			$passinggrade = 0.00;
			$i=0;
			foreach($listsekolah[$row['id']]['data'] as $r){
				$parts[] ="('" . $r['id'] . "', '" . $r['accepted_school'] . "')";
				$passinggrade = $r['score_total'];

				if ($r['accepted_status']==2) {$i++;}
			}
		}
		mysqli_free_result($rpilihan);
		if ($parts!=""){
		$qfiltered = "insert into ppdb_filtered_nonacademic (`registration`, `option`) values " . implode(', ', $parts);
		$result = $mysqli->query($qfiltered) or die(mysqli_error($mysqli));
		}
		unset($parts);

	$time_end = microtime(true);
	$time = $time_end - $time_start;
	/*$datetime_now = gmdate('Y-m-d H:i:s',time()+60*60*7); */
	$datetime_now = date('Y-m-d H:i:s');
	$qsignal = "insert into sys_signal (`id`, `signal`,`params`,`created_at`, `updated_at`) values ('','filter_ok', '" . $datetime_now . "','selection','" . date("Y-m-d") . "')";
	$res_signal = $mysqli->query($qsignal) or die(mysqli_error($mysqli));
	echo 'Filtered : '.$time . ' on ' . $datetime_now;
	echo '<br/>'.memory_get_usage();

 ?>
