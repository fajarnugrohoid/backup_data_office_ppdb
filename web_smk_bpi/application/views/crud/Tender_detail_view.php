<html>
		<head>
			<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		
		<!--  Bootstrap Style -->
		<link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" />
		<!--  Font-Awesome Style -->
		<link href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet" />
		<!--  Animation Style -->
		<link href="<?php echo base_url('assets/css/animate.css'); ?>" rel="stylesheet" />
		<!--  Pretty Photo Style -->
		<link href="<?php echo base_url('assets/css/prettyPhoto.css'); ?>" rel="stylesheet" />
		<!--  Google Font Style -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
		<!--  Custom Style -->
		<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" />
		<link href="<?php echo base_url('assets/css/custom.css'); ?>" rel="stylesheet" />
    
	
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
		<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		
		</head>
	
	<body>

			<h1> DETAIL TENDER </h1>

			<div class="panel panel-default">
				
				<table id="myTable" class="table table-striped table-hover tablesorter" cellspacing="0">
					<tr>			
						<th>
							<div class="form-group has-feedback">
								<label for="search" class="sr-only">Search</label>
								<input type="text" class="form-control" name="search" id="search" placeholder="search">
								
							</div>
						</th>
					</tr>
					<tr>
						<td>Nama tender</td>
						<td>:</td>
						<td><?php echo $tender->nama_tender;?></td>
					</tr>
					<tr>
						<td>Jenis Tender</td>
						<td>:</td>
						<td><?php echo $tender->kategori;?></td>
					</tr>
					<tr>
						<td>Agency</td>
						<td>:</td>
						<td><?php echo $tender->nama_instansi;?></td>
					</tr>
					<tr>
						<td>Metode Pengadaan</td>
						<td>:</td>
						<td><?php echo $tender->metode_pengadaan;?></td>
					</tr>
					<tr>
						<td>Metode Kualifikasi</td>
						<td>:</td>
						<td><?php echo $tender->metode_kualifikasi;?></td>
					</tr>
					<tr>
						<td>Metode Evaluasi</td>
						<td>:</td>
						<td><?php echo $tender->metode_evaluasi;?></td>
					</tr>
					<tr>
						<td>Metode Dokumen</td>
						<td>:</td>
						<td><?php echo $tender->metode_dokumen;?></td>
					</tr>
					<tr>
						<td>Anggaran</td>
						<td>:</td>
						<td><?php echo $tender->anggaran;?></td>
					</tr>
					<tr>
						<td>Nilai Pagu Paket</td>
						<td>:</td>
						<td>Rp. <?php echo number_format($tender->nilai_pagu_paket,'2',',','.');?></td>
					</tr>
					<tr>
						<td>Nilai HPS Paket</td>
						<td>:</td>
						<td>Rp. <?php echo number_format($tender->nilai_hps_paket,'2',',','.');?></td>
					</tr>
					<tr>
						<td>Jenis Kontrak</td>
						<td>:</td>
						<td>
							<tr>
								<td>Cara Pembayaran</td>
								<td>:</td>
								<td><?php echo $tender->cara_pembayaran;?></td>
							</tr>
							<tr>
								<td>Tahun Anggaran</td>
								<td>:</td>
								<td><?php echo $tender->jangka_waktu;?></td>
							</tr>
							<tr>
								<td>Sumber Pendanaan</td>
								<td>:</td>
								<td><?php echo $tender->sumber_pendanaan;?></td>
							</tr>
						</td>
					</tr>
					<tr>
						<td>Kualifikasi Usaha</td>
						<td>:</td>
						<td><?php echo $tender->kualifikasi_usaha;?></td>
					</tr>
					<tr>
						<td>Lokasi Pekerjaan</td>
						<td>:</td>
						<td><?php echo $tender->lokasi_pekerjaan;?></td>
					</tr>
					<tr>
						<td>Syarat Kualifikasi</td>
						<td>:</td>
						<td><?php echo $tender->syarat_kualifikasi;?></td>
					</tr>
					<tr>
						<td>Tanggal Mulai Proyek</td>
						<td>:</td>
						<td><?php echo date('d/m/Y',strtotime($tender->tgl_mulai));?></td>
					</tr>
					<tr>
						<td>Tanggal Akhir Proyek</td>
						<td>:</td>
						<td><?php echo date('d/m/Y',strtotime($tender->tgl_akhir));?></td>
					</tr>
					<tr>
						<td>Batas Akhir Pendaftaran</td>
						<td>:</td>
						<td><?php echo date('d/m/Y',strtotime($tender->tgl_deadline));?></td>
					</tr>
				</table>
			</div>
			<?php
			
				if(time() <= strtotime($tender->tgl_deadline)){
					if($daftar && $daftar->status == 0){
						echo "<span class='alert alert-success'>Anda Sudah Mendaftar</span>";	
					}else{
						echo '<a href="'.base_url().'crud/daftar_tender/'.$tender->id_tender.'" class="btn btn-primary" type="submit" name="submit" value="daftar">Daftar</a>';
					}
				}else{
					echo "<span class='alert alert-danger'>Pendaftaran sudah ditutup</span>";
				}
			?>
	</body>

</html>