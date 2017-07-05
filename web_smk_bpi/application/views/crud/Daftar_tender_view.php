<html>	
	<head>
		<title>Daftar Perusahaan</title>
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
	<div class="navbar navbar2 navbar-fixed-top move-me ">
		<div class="container">
			 <div class="navbar-header">
			 
			 </div>
		</div>
	</div>
	
	<div id="pantau">
		<div class="overlay">
			<div class="container">
				<div class="row ">
					<div class="col-lg-12 col-md-12">
				
						<h3 class="text-center"> <strong> Form Pendaftaran Tender</strong> </h3>
					
							<div class="well1 white">
							
	<div class="panel panel-default">
		<div class="panel-heading">Form Pendaftaran</div>
		<?php echo form_open_multipart('crud/daftar_tender/'.$tender->id_tender);?>
		<input type="hidden" name="id_tender" value="<?php echo $tender->id_tender;?>"/>
		<input type="hidden" name="id_pendaftar" value="<?php echo $this->session->userdata('id_user');?>"/>
		<table id="myTable" class="table table-striped table-hover tablesorter" cellspacing="0">
			<tr>
				<td>Nama Tender</td>
				<td>:</td>
				<td><?php echo $tender->nama_tender;?></td>
			</tr>
			<tr>
				<td>Pendaftar</td>
				<td>:</td>
				<td><?php echo $this->session->userdata('nama_instansi');?></td>
			</tr>
			<tr>
				<td>Upload Dokumen</td>
				<td>:</td>
				<td>
					<input type="file" id="userfile" name="userfile"/>
					<span style="font-size: 10pt;">ekstensi yang dijinkan (zip, rar) max 30MB</span>
				</td>
			</tr>
		</table>
	</div>
	<input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
	<?php echo form_close();?>
	
				</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</body>
</html>