<?php
ini_set('max_execution_time', 10000);
ini_set("memory_limit","-1");
error_reporting(E_ERROR | E_ALL);

	require('connection.php');

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
		array_multisort($sort_col_total, SORT_DESC,$sort_col_total2, SORT_DESC,$sort_col_n1, SORT_DESC,$sort_col_n2, SORT_DESC,$sort_col_n3, SORT_DESC,$sort_col_n4, SORT_DESC, $sort_col_skorjarak,SORT_ASC, $arr);
	}
	# connection

	$sql_statistik = "DELETE
		from ppdb_statistic
		where `option` in(
			SELECT a.id FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=4 ) and a.type='academic' and b.level='vocational') ";
	$truncate_statistic=mysql_query($sql_statistik) or die(mysql_error());

	# ambil data
	// $query  = "SELECT distinct(b.id),a.kode_sekolah,b.jalur,b.kuota,b.kuota_seluruh,a.nama_sekolah,a.wilayah_batasan, substring(a.kode_sekolah,1,1) as kode_jenjang, a.presentase_luar_kota
	// 			FROM sekolah a
	// 			INNER JOIN pilihan b ON ( a.kode_sekolah = b.kode_sekolah )
	// 			where substring(a.kode_sekolah,1,1)=4 and b.jalur=1
	// 			ORDER BY a.kode_sekolah, b.id";
	$query  = "SELECT a.id as id,a.type,a.quota,b.name,b.is_border,substring(b.code,1,1) as code, a.over_quota, b.coordinat, a.inner_quota, b.foreigner_pecentage
							FROM ppdb_option a
							inner join ppdb_school b on (a.school = b.id)
							where (substring(b.code,1,1)=4) and a.type='academic' and b.level='vocational'
							ORDER BY b.code, a.id";
	$resul1 = mysql_query( $query) or die(mysql_error());
	$update_tot_pendaftar='';
	while($row = mysql_fetch_array($resul1)){ // sekolah

		//$query  = "SELECT *,CONCAT( 'RT/RW ', LPAD( rt, 2, '0' ) , '/', LPAD( rw, 2, '0' ) , ' ', kelurahan, ' ', kecamatan ) AS `alamat` FROM daftar_akademis where (jenjang=2 or jenjang=3) and jalur=1  and pilihan1 = '".$row['id']."'";
		$query  = "SELECT * FROM ppdb_registration_academic
					where (type='academic')  and first_choice = '".$row['id']." '
					and status='approved'";
		$resul2 = mysql_query($query) or die(mysql_error());

		$x=0;
		$y=0; //y=luar_kota
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
			if ($siswa[$x]['asal_pendaftar']=='2'){
				$y++;
			}
			$x++;

		}
		@mysql_free_result($resul2);

		$listsekolahsmk[$row['id']]['id'] = $row['id'];
		$listsekolahsmk[$row['id']]['kuota'] = $row['quota'];
		$listsekolahsmk[$row['id']]['presentase_luar_kota'] = $row['foreigner_pecentage'];
		$listsekolahsmk[$row['id']]['kuota_seluruh'] = 0;

		if(isset($siswa)){
			$listsekolahsmk[$row['id']]['data'] = $siswa;
		}else{
			$listsekolahsmk[$row['id']]['data'] = array();
		}
		$listsekolahsmk[$row['id']]['status'] = 0;

		//$update_tot_pendaftar = "update pilihan  set total_pendaftar = '" . $x . "' where id='" . $row['id'] .  "';";
		$update_tot_pendaftar = "insert into ppdb_statistic (`id`, `option`, `registered_total`,`registered_foreigner`) values ('', '" . $row['id'] . "','" . $x . "','" . $y . "')";
		$result_update_tot_pendaftar = mysql_query($update_tot_pendaftar);
		@mysql_free_result($result_update_tot_pendaftar);

		unset($siswa);
	}

	$listsekolahsmk['9999']['id'] = '9999';
	$listsekolahsmk['9999']['nama']  = 'Buangan';
	$listsekolahsmk['9999']['kuota'] = 0;
	$listsekolahsmk['9999']['data'] = array();
	$listsekolahsmk['9999']['status'] = 1;
	@mysql_free_result($resul1);

	#------- Proses
	$passgrad = TRUE;
	while($passgrad != FALSE){ // selama masih ada sekolah yg harus di sorting
		$passgrad = FALSE;

		foreach($listsekolahsmk as $sekolah){ // sort tiap sekolah
			if($sekolah['id'] == '9999'){continue;}
			if($sekolah['status'] == 0){
				# init
				$id = $sekolah['id'];

				# sort
				sorting($listsekolahsmk[$id]['data'], 'total','total2','bahasa','english','matematika','ipa','skor_jarak');
				// print_r($listsekolahsmk[$id]['data']);
				// echo '<br>';

				# passing

				$jml_pend = count($listsekolahsmk[$id]['data']);
				/*$lokasi_kota10 = floor($sekolah['kuota'] * 0.1);
				$lokasi_batasan25 = floor($sekolah['kuota'] * 0.25);*/
				if ($sekolah['kuota_seluruh']==0){
					$sekolah['kuota_seluruh'] = $sekolah['kuota'];
				}else{
				$kuota_luarkota = floor($sekolah['kuota_seluruh'] * ($sekolah['presentase_luar_kota']/100)); }

				$luarkota=0;



				$jml_pend = count($listsekolahsmk[$id]['data']);

				if($jml_pend > $sekolah['kuota']){ /* potong berdasarkan kuota */

					// # lemparkan
					for($i = $jml_pend-1; $i>$sekolah['kuota']-1; $i--){
						if($listsekolahsmk[$id]['data'][$i]['pilihan2'] != $sekolah['id']){ /* lempar ke pilihan 2 */

							$listsekolahsmk[$id]['data'][$i]['total'] = $listsekolahsmk[$id]['data'][$i]['total2']; /*lempar ke pilihan 2, total diganti ke total2*/
								$listsekolahsmk[$id]['data'][$i]['skor_jarak'] = $listsekolahsmk[$id]['data'][$i]['skor_jarak2']; /*lempar ke pilihan 2, skor jarak diganti ke skor jarak2*/

							if ($listsekolahsmk[$id]['data'][$i]['pilihan2'] == 9999) {
								$listsekolahsmk[$id]['data'][$i]['diterima'] = 3;
								$listsekolahsmk[$id]['data'][$i]['terima_disekolah'] = 9999;


								array_push($listsekolahsmk['9999']['data'], $listsekolahsmk[$id]['data'][$i]);
								array_splice($listsekolahsmk[$id]['data'], $i, 1);

							}else{

								$xid = $listsekolahsmk[$id]['data'][$i]['pilihan2'];  //cek id sekolah
								if (!isset( $listsekolahsmk[$xid])){ //cek id sekolah, jika tidak ada lempar ke pilihan 9999
										echo 'id sekolah tidak ada = '.$xid.'<br/>';
										$listsekolahsmk[$id]['data'][$i]['diterima'] = 3;
										$listsekolahsmk[$id]['data'][$i]['terima_disekolah'] = 9999;
										array_push($listsekolahsmk['9999']['data'], $listsekolahsmk[$id]['data'][$i]);
										array_splice($listsekolahsmk[$id]['data'], $i, 1);
								}else{
									$listsekolahsmk[$id]['data'][$i]['diterima'] = 2;
									$listsekolahsmk[$id]['data'][$i]['terima_disekolah'] = $listsekolahsmk[$id]['data'][$i]['pilihan2'];
									$listsekolahsmk[$listsekolahsmk[$id]['data'][$i]['pilihan2']]['status'] = 0;
									array_push($listsekolahsmk[$listsekolahsmk[$id]['data'][$i]['pilihan2']]['data'], $listsekolahsmk[$id]['data'][$i]);
									array_splice($listsekolahsmk[$id]['data'], $i, 1);
								}


							}
						}else{ // tidak diterima dimana2
							$listsekolahsmk[$id]['data'][$i]['diterima'] = 3;
							$listsekolahsmk[$id]['data'][$i]['terima_disekolah'] = 9999;
							array_push($listsekolahsmk['9999']['data'], $listsekolahsmk[$id]['data'][$i]);
							array_splice($listsekolahsmk[$id]['data'], $i, 1);
						}
					}
				}
				$listsekolahsmk[$id]['status'] = 1;

			}
		}

		# cek sekolah, bisi aya nu can di sorting
		foreach($listsekolahsmk as $sekolah){
			if($sekolah['status'] == 0){
				$passgrad = TRUE;
				break;
			}
		}
	}


	$temp_sum = 0;
				foreach ($listsekolahsmk as $sekolah){
					?>
						<?php echo $sekolah['id'] . ' -- '; ?>
						<table border="1">
								<thead>
									<tr>
									<td>No</td>
									<td>Nama</td>
									<td>Sekolah Pilihan 1</td>
									<td>Sekolah Pilihan 2</td>
									<td>Asal Pendaftar</td>
									<td>Total Nilai</td>
									<td>Total Nilai 1</td>
									<td>Total Nilai 2</td>
									<td>Bahasa</td>
									<td>English</td>
									<td>Mtk</td>
									<td>IPA</td>
									<td>Skor Jarak</td>
									<td>Jarak 1</td>
									<td>Jarak 2</td>
									<td>Total Nilai</td>
									<td>Skor Jarak</td>
									<td>Diterima Option</td>
									<td>Diterima di</td>
									</tr>
								</thead>
							<?php
								$no= 1;
								foreach($sekolah['data'] as $siswa){

									?>
										<tr>
											<td><?=$no?></td>
											<td><?=$siswa['nama']?></td>
											<td><?=$siswa['pilihan1']?></td>
											<td><?=$siswa['pilihan2']?></td>
											<td><?=$siswa['asal_pendaftar']?></td>
											<td><?=$siswa['total']?></td>
											<td><?=$siswa['total1']?></td>
											<td><?=$siswa['total2']?></td>
											<td><?=$siswa['bahasa']?></td>
											<td><?=$siswa['english']?></td>
											<td><?=$siswa['matematika']?></td>
											<td><?=$siswa['ipa']?></td>
											<td><?=$siswa['skor_jarak']?></td>
											<td><?=$siswa['skor_jarak1']?></td>
											<td><?=$siswa['skor_jarak2']?></td>
											<td><?=$siswa['total']?></td>
											<td><?=$siswa['skor_jarak']?></td>
											<td><?=$siswa['terima_disekolah']?></td>
											<td><?=$siswa['diterima']?></td>
										</tr>
									<?php
									$no++;
								}
							?>
						</table>
						<br/>
					<?php
					$temp_sum = $temp_sum+count($sekolah['data']);


				}

				echo '<br/>';



	$sql_del = "DELETE
		from ppdb_filtered_academic
		where `option` in (
			SELECT a.id FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=4) and (a.type='academic') and b.level='vocational' )";
		$result=mysql_query($sql_del) or die(mysql_error());

		$qpilihan  = "SELECT a.id, a.quota,b.name FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=4) and (a.type='academic') and b.level='vocational'";
		$rpilihan = mysql_query( $qpilihan) or die(mysql_error());


		$qfiltered='';
		while($row = mysql_fetch_array($rpilihan)){
			$passinggrade = 0.00;
			$passinggrade_luar = 0.00;
			$i=0;
			$j=0;
			$y=0;
			echo $row['id'] . "<br><br>";
			foreach($listsekolahsmk[$row['id']]['data'] as $r){
				$parts[] ="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "')";


				if ($r['jalur']=='kp4'){
					$passinggrade = $r['skor_jarak'];
				}else{
					$passinggrade = $r['total'];
				}


				if ($r['asal_pendaftar']==2){
					$y++;
					$passinggrade_luar = $r['total'];
				}

				if ($r['diterima']==2) {
					$i++;
				}

				$j++;
			}
			//$total_pedaftar_limpahan=$row['registered_total']+$i;
			$update_pg = "update ppdb_statistic set passing_grade ='" . $passinggrade . "',filtered_total='" . count($listsekolahsmk[$row['id']]['data']) . "',filtered_foreigner='" . $y . "',passing_grade_foreigner='" . $passinggrade_luar . "'  where `option`='" . $row['id'] .  "'";

			$rupdate=mysql_query($update_pg);@mysql_free_result($rupdate);
		}
		mysql_free_result($rpilihan);
		if ($parts!=""){
		$qfiltered = "insert into ppdb_filtered_academic (`registration`, `option`) values " . implode(', ', $parts);
		$result = mysql_query($qfiltered) or die(mysql_error());
		}
		unset($parts);

	$time_end = microtime(true);
	$time = $time_end - $time_start;
	/*$datetime_now = gmdate('Y-m-d H:i:s',time()+60*60*7); */
	$datetime_now = date('Y-m-d H:i:s');
	$qsignal = "insert into sys_signal (`id`, `signal`,`post_time`) values ('','filter_ok', '" . $datetime_now . "')";
	$res_signal = mysql_query($qsignal) or die(mysql_error());
	echo 'Filtered : '.$time . ' on ' . $datetime_now;
	echo '<br/>'.memory_get_usage();


	exit;

		//$qpilihan  = "SELECT id, kuota, total_pendaftar FROM pilihan where  substring(kode_sekolah,1,1)=4 and jalur=1 ORDER BY id ASC";
		$qpilihan  = "SELECT a.id, a.quota,b.name FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=4) and (a.type='academic') and b.level='vocational'";
		$rpilihan = mysql_query( $qpilihan) or die(mysql_error());
		$j=1;
		$qfiltered='';
		while($row = mysql_fetch_array($rpilihan)){
			$passinggrade = 0.00;
			$i=0;


				foreach($listsekolahsmk[$row['id']]['data'] as $r){
					$parts[] ="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "',
					'" . $r['tanggal'] . "','" . $r['jenjang'] . "','" . $r['jalur'] . "','" . $r['asal_pendaftar'] . "',
					'" . $r['no_pendaftaran'] . "','" . $r['tahun_lulus'] . "','" . $r['no_un'] . "','" . mysql_real_escape_string($r['nama']) . "',
					'" . $r['jk'] . "','" . mysql_real_escape_string($r['tmp_lahir']) . "','" . $r['tgl_lahir'] . "','" . mysql_real_escape_string($r['alamat']) . "',
					'" . mysql_real_escape_string($r['asal_sekolah']) . "','" . $r['bahasa'] . "','" . $r['english'] . "','" . $r['matematika'] . "',
					'" . $r['ipa'] . "','" . $r['total1'] . "','" . $r['total2'] . "','" . $r['skor_jarak1'] . "',
					'" . $r['skor_jarak2'] . "','" . $r['prestasi'] . "','" . $r['skor_prestasi'] . "','" . $r['warga_miskin'] . "',
					'" . $r['skor_warga_miskin'] . "','" . $r['skor_usia'] . "','" . $r['pilihan1'] . "','" . $r['pilihan2'] . "',
					'" . $r['diterima'] . "'
					)";
					$passinggrade = $r['total'];
					if ($r['diterima']==2) {$i++;}
				}

			$total_pedaftar_limpahan=$row['total_pendaftar']+$i;
			echo $row['id'] . '-total_pendaftar:' . $total_pedaftar_limpahan . '<br/>';

				$update_pg = "update pilihan set passing_grade ='" . $passinggrade . "'  where id='" . $row['id'] .  "'";
				$rupdate=mysql_query($update_pg);@mysql_free_result($rupdate);

			if (isset($parts)!=""){
				$qfiltered = "insert into filtered_akademis1_dalam(
				`id_pendaftar`, `id_pilihan`,
				`tanggal`, `jenjang`, `jalur`, `asal_pendaftar`,
				`no_pendaftaran`, `tahun_lulus`, `no_un`, `nama`,
				`jk`, `tmp_lahir`, `tgl_lahir`, `alamat`,
				`asal_sekolah`, `bahasa`, `english`, `matematika`,
				`ipa`, `total1`, `total2`, `skor_jarak1`,
				`skor_jarak2`, `prestasi`, `skor_prestasi`, `warga_miskin`,
				`skor_warga_miskin`, `skor_usia`, `pilihan1`, `pilihan2`,
				`status`
				) values " . implode(', ', $parts);
				$result = mysql_query($qfiltered) or die(mysql_error());

				@mysql_free_result($result);
				unset($parts);
				//@mysql_close($conn);
				//$conn=@mysql_connect('localhost','root','') or die("Koneksi gagal");
				//$db=@mysql_select_db('ppdb2014_server') or die("Database tidak bisa dibuka");

			}
		}
		@mysql_free_result($rpilihan);

	/*start 9999*/
		$qpilihan  = "SELECT id FROM pilihan where id=9999 ORDER BY id ASC";
		$rpilihan = mysql_query( $qpilihan) or die(mysql_error());
		$j=1;
		$qfiltered='';
		while($row = mysql_fetch_array($rpilihan)){
			$passinggrade = 0.00;
			$i=0;
			//print_r($listsekolahsmk['9999']['data']);

			//foreach($listsekolahsmk[$row['9999']]['data'] as $r){
			$k=0;
			foreach($listsekolahsmk[9999]['data'] as $r){
				$k++;

				$parts[] ="('" . $r['id'] . "', '" . $r['terima_disekolah'] . "',
				'" . $r['tanggal'] . "','" . $r['jenjang'] . "','" . $r['jalur'] . "','" . $r['asal_pendaftar'] . "',
				'" . $r['no_pendaftaran'] . "','" . $r['tahun_lulus'] . "','" . $r['no_un'] . "','" . mysql_real_escape_string($r['nama']) . "',
				'" . $r['jk'] . "','" . mysql_real_escape_string($r['tmp_lahir']) . "','" . $r['tgl_lahir'] . "','" . mysql_real_escape_string($r['alamat']) . "',
				'" . mysql_real_escape_string($r['asal_sekolah']) . "','" . $r['bahasa'] . "','" . $r['english'] . "','" . $r['matematika'] . "',
				'" . $r['ipa'] . "','" . $r['total1'] . "','" . $r['total2'] . "','" . $r['skor_jarak1'] . "',
				'" . $r['skor_jarak2'] . "','" . $r['prestasi'] . "','" . $r['skor_prestasi'] . "','" . $r['warga_miskin'] . "',
				'" . $r['skor_warga_miskin'] . "','" . $r['skor_usia'] . "','" . $r['pilihan1'] . "','" . $r['pilihan2'] . "',
				'" . $r['diterima'] . "'
				)";
				if ($k%100){
					if (isset($parts)!=""){
						$qfiltered = "insert into filtered_akademis1_dalam (
						`id_pendaftar`, `id_pilihan`,
						`tanggal`, `jenjang`, `jalur`, `asal_pendaftar`,
						`no_pendaftaran`, `tahun_lulus`, `no_un`, `nama`,
						`jk`, `tmp_lahir`, `tgl_lahir`, `alamat`,
						`asal_sekolah`, `bahasa`, `english`, `matematika`,
						`ipa`, `total1`, `total2`, `skor_jarak1`,
						`skor_jarak2`, `prestasi`, `skor_prestasi`, `warga_miskin`,
						`skor_warga_miskin`, `skor_usia`, `pilihan1`, `pilihan2`,
						`status`
						) values " . implode(', ', $parts);
						$res9999 = mysql_query($qfiltered) or die(mysql_error());
						@mysql_free_result($res9999);
						unset($parts);
					}
				}
			}

		}
		@mysql_free_result($rpilihan);


	/*end 9999*/


 ?>
