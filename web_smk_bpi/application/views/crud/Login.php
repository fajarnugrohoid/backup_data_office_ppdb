<html>
	<head>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
		<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		<title>
			Login
		</title>
		
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
	
	<div id="login">
	
	<div class="col-lg-8 col-md-8">
		<div id="wrapper">
		  <?php echo form_open('auth/login');?>
			<h2 class="form-signin-heading" align="center">Login</h2>
			<label class="sr-only">Email address</label>
			<input placeholder="username" class="form-control" type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" />
			<label class="sr-only">Password</label>
			<input placeholder="password" class="form-control" type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" />
			<div class="checkbox">
			  <label>
				<input type="checkbox" value="remember-me"> Remember me
			  </label>
			  <br/>
			<a href = "<?php echo site_url('C_tender/daftar') ?>">DAFTAR AKUN BARU</a>

			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		  <?php echo form_close();?>
		</div>
	</div>
		<!-- /container -->
	</div>
	</body>
</html>
