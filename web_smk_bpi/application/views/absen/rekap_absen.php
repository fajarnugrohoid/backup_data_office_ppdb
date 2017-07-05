<html>
	<head>
		<title> Rekap Absensi </title>
		
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
				
				<h3 align="center"> Rekap Absensi Hari Ini </h3>
				<br/>
				
				<table class="table" style="font-size: 12px;">
				<thead>	
					<tr>
						<th>No</th>
						<th>NIS</th>
						<th>Nama</th>
						<th>Jenis Kelamin</th>
						<th>Kelas</th>
						<th>Keterangan</th>
						<th>Detail</th>
						<th>Waktu</th>
						<th>Tanggal</th>
						<th>Aksi</th>
					</tr>
				</thead>
					<?php
						$i = 1;
						foreach($siswa as $s){ 
					?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $s->nis ?></td>
						<td><?php echo $s->nama ?></td>
						<td><?php echo $s->jenis_kelamin ?></td>
						<td><?php echo $s->kelas ?></td>
						<td><?php echo ucwords($s->keterangan) ?></td>
						<td><?php echo $s->detail ?></td>
						<td><?php echo $s->jam ?></td>
						<td><?php echo $s->tanggal ?></td>
						<td><a href = "<?php echo site_url('administrator/delete_rekap_absen/'.$s->id_absensi) ?>">Delete</a></td>
					</tr>
					<?php 
						$i++;}
					?>
				</table>
			</div>
	</body>
</html>