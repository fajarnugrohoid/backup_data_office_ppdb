<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php echo $title; ?> - Administrasi</title>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.js');?>"></script>
	
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.min.js');?>"></script>
	
	<!-- load bootstrap css -->
	<link href="<?php echo base_url('asset/css/bootstrap.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-theme.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-responsive.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-responsive.min.css');?>" rel="stylesheet">
</head>
<body style="padding-top: 10px;">
<div class="container">
	<h1><a href="<?php echo base_url(); ?>" title="Kembali" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></a> <?php echo $title ?></h1>
	<h2>Masukan Nama Pengguna dan Password</h2>
	<!-- form tambah mata pelajaran -->
	<?php echo form_open("administrator/proses_auth", "class='form-horizontal' role='form'"); ?>
	<?php echo $this->session->flashdata('notification'); ?>
	<div class="control-group">
		<label for="username" class="control-label">Nama Pengguna</label>
		<div class="controls"><?php echo form_input("username", "", "class='input-xxlarge' id='username' placeholder='Nama Pengguna' required"); ?></div>
	</div>
	<div class="control-group">
		<label for="n_gr" class="control-label">Password</label>
		<div class="controls"><?php echo form_password("password", "", "class='input-xxlarge' id='password' placeholder='Password' required"); ?></div>
	</div>
	<div class="form-action">	
		<?php echo form_submit("login", "Login", "class='btn btn-primary'"); ?>
		<?php echo form_reset("reset", "Bersihkan", "class='btn btn-warning'"); ?>
	</div>
	<?php echo form_close(); ?>
</div>
</body>
</html