<html>
	<head>
		<title> Rekap Absensi Siswa </title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="<?php echo base_url('assets/css/bootstrap.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/bootstrap-responsive.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/docs.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
		
		<link href="<?php echo base_url('assets/js/google-code-prettify/prettify.css');?>" rel="stylesheet">
		
	</head>
	
	<body>
		
				
			<div class="col-md-12">
			
			<hr/>
				<table class="table">
				<thead>
					<tr>
						<th>No</th>
						<th>NIS</th>
						<th>Nama</th>
						<th>Jenis Kelamin</th>
						<th>Kelas</th>
						<th>Sakit</th>
						<th>Izin</th>
						<th>Alpha</th>
						<th>Terlambat</th>
						<th>Detail</th>
					</tr>
				</thead>
					<?php
						$i = 1;
						foreach($siswa as $s){ 
					?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $s->a ?></td>
						<td><?php echo $s->nama ?></td>
						<td><?php echo $s->jenis_kelamin ?></td>
						<td><?php echo $s->kelas ?></td>
						<td><?php echo $s->sakit ?></td>
						<td><?php echo $s->ijin ?></td>
						<td><?php echo $s->alpha ?></td>
						<td><?php echo $s->terlambat ?></td>
						<td><a href="detail_absen/<?php echo $s->a ?>/<?php echo $bulan ?>/<?php echo $tahun ?>"> Lihat Detail </a></td>
					</tr>
					<?php 
						$i++;}
					?>
				</table>
			
			</div>
					
	</body>
</html>