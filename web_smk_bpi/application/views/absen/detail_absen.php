<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

			
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- load bootstrap css -->
		<link href="<?php echo base_url('asset/css/bootstrap.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('asset/css/bootstrap.min.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('asset/css/bootstrap-theme.min.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('asset/css/bootstrap-responsive.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('asset/css/bootstrap-responsive.min.css');?>" rel="stylesheet">
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.min.js');?>"></script>
			
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.min.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-collapse.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-dropdown.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-transition.js');?>"></script>
	</head>
	
	<body>
	
	<div class="container" style="margin-top: 50px;">
		
		<ul class="nav navbar-nav navbar-right">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $nama_log; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
						
							<li><a href="<?php echo base_url('administrator/keluar'); ?>">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</ul>
		
		<h3> Detail </h3>
		
			<div class="col-md-12" style="margin-top: 20px;">	
			
				<ul class="nav nav-tabs nav-pills" role="tablist">
				  <li><a href="<?php echo base_url('administrator/daftar_absen'); ?>">Daftar Absen</a></li>
				  <li  class="active"><a href="<?php echo base_url('administrator/rekap_absensi'); ?>">Rekap Absen</a></li>
				</ul>
		</div>
		
		<div class="col-md-12" style="margin-top: 20px;">
		
		<table class="table">
			<tr>
				<td>No</td>
				<td>Keterangan</td>
				<td>Tanggal</td>
			</tr>
	<?php
		$i = 1;
		foreach($detail as $d){
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo ucwords($d->keterangan); ?></td>
				<td><?php echo $d->tanggal; ?></td>
			</tr>
	<?php
			$i++;
		}
	?>
		</table>
		<a href = "<?php echo base_url('administrator/rekap_absensi') ?>">Kembali</a>
		
		</div>
		
	</div>
	
	</body>
	
</html>