<!DOCTYPE html>
<html>
	<head>
	<title>Rekap Absen</title>
	<?php foreach($profilsekolah_pil as $sekolah){ ?>
		<link href="<?php echo base_url('asset/img/'.$sekolah->logo); ?>" rel='icon' type='image/x-icon'/>
	<?php } ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Tutoring Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<link href="<?php echo base_url('asset/css/bootstrap.css'); ?>" rel='stylesheet' type='text/css' />
	<link href="<?php echo base_url('asset/css/style.css'); ?>" rel='stylesheet' type='text/css' />
	<script src="<?php echo base_url('asset/js/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('asset/js/bootstrap.js'); ?>"></script>
	<!---- start-smoth-scrolling---->
	<script type="text/javascript" src="<?php echo base_url('asset/js/move-top.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/easing.js'); ?>"></script>
	<script type="text/javascript">
				jQuery(document).ready(function($) {
					$(".scroll").click(function(event){		
						event.preventDefault();
						$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
					});
				});
			</script>
	<!--start-smoth-scrolling-->
	<!-- load bootstrap css -->
	<link href="<?php echo base_url('asset/css/bootstrap-theme.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('plugin/packaged/css/semantic.css');?>" rel="stylesheet">
	<style>
					.dropbtn{
						background-color: #4d517e;
						color: white;
						padding: 16px;
						border: none;
						cursor: pointer;
						min-width: 200px;
					}
					.dropbtn2{
						
						color: #4d517e;
						padding: 16px;
						padding-bottom: 12px;
						border: none;
						cursor: pointer;
						min-width: 200px;
					}
					.dropdown{
						position: relative;
						display: inline-block;
					}
					.dropdown-content{
						display: none;
						position: absolute;
						background-color: #4d517e;
						opacity: 0.8;
						min-width: 220px;
						border: 0px solid black;
						text-transform: uppercase;
						font-family:'Play-Regular';
						font-size: 15px;
					}
					.dropdown-content2{
						display: none;
						position: absolute;
						opacity: 0.8;
						min-width: 220px;
						border: 0px solid black;
						font-family:'Play-Regular';
						font-size: 15px;
					}
					.dropdown-content a{
						color: white;
						padding: 12px 16px;
						text-decoration: none;
						display: block;
					}
					.dropdown-content2 a{
						color: black;
						padding: 12px 12px;
						text-decoration: none;
						display: block;
					}
					.dropdown-content2 a:hover{
						background-color: #545e94;
						color: white;
						opacity: 0.8;
					}
					.dropdown-content a:hover{
						background-color: #545e94;
						opacity: 1;
					}
					.dropdown:hover .dropdown-content{
						display: block;
					}
					.dropdown:hover .dropdown-content2{
						display: block;
					}
					.dropdown:hover .dropbtn{
						background-color: #545e94;
					}

				</style>
				
</head>
<body>
	<!--start-header-->
	<div class="header" id="home">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<?php foreach ($profilsekolah_pil as $list){ ?>
				<a class="navbar-brand" href="<?php echo base_url('welcome'); ?>"><img src="<?php echo base_url('asset/img/'.$list->logo); ?>" alt="" /></a>
				
				<?php } ?>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse new" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav new">
					<li><a href="<?php echo base_url('welcome'); ?>" class="hvr-bounce-to-top">Beranda <span class="sr-only"></span></a></li>
					<li><a href="<?php echo base_url('welcome/lihat_unitkerja'); ?>" class="hvr-bounce-to-top">Unit Kerja</a></li>
					<li><a href="<?php echo base_url('welcome/lihat_pegawai'); ?>" class="hvr-bounce-to-top">Kepegawaian</a></li>
					<li><a href="<?php echo base_url('welcome/lihat_ekstrakulikuler'); ?>" class="hvr-bounce-to-top">Ekstrakurikuler</a></li>
					<li><a href="<?php echo base_url('welcome/input_feedback'); ?>" class="hvr-bounce-to-top">Kontak</a></li>
					<li class="dropdown">
						<a href="#" class="hvr-bounce-to-top">Profil <span class="glyphicon glyphicon-chevron-down"></span></a>
							<div class="dropdown-content">
								<a href="<?php echo base_url('welcome/lihat_profil'); ?>"> Profil Sekolah </a>
								<a href="<?php echo base_url('welcome/lihat_profiljurusan'); ?>"> Profil Jurusan </a>
							</div>
					</li>
					<li><a href="<?php echo base_url('Agenda/beranda') ?>" class="hvr-bounce-to-top">Agenda</a></li>
					<li><a href="<?php echo base_url('welcome/lihat_galeri'); ?>" class="hvr-bounce-to-top">Galeri</a></li>
					<li class="dropdown">
						<a href="#" class="hvr-bounce-to-top">Download <span class="glyphicon glyphicon-chevron-down"></span></a>
							<div class="dropdown-content">
								<a href="<?php echo base_url('welcome/lihat_kurikulum'); ?>"> Kurikulum </a>
								<a href="<?php echo base_url('welcome/lihat_silabus'); ?>"> Silabus </a>
								<a href="<?php echo base_url('welcome/lihat_download'); ?>"> Lainnya </a>
							</div>
					</li>
					<li class="dropdown active">
						<a href="#" class="hvr-bounce-to-top">Info <span class="glyphicon glyphicon-chevron-down"></span></a>
							<div class="dropdown-content">
								<a href="<?php echo base_url('welcome/lihat_bursakerja'); ?>" class="hvr-bounce-to-top">Bursa Kerja</a>
								<a href="<?php echo base_url('ortu/ortu'); ?>"> Absensi </a>
							</div>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
	</div>
	<!--end-header-->
	
	<div class="col-md-12" style=" margin-top: 120px; margin-bottom: 70px;">	
		<div class="col-md-2" style="float: right;  ">		
				<ul class="dropbtn2">
					<li class="dropdown">
						<a href="<?php echo base_url('ortu/ortu/rekap_absen') ?>"><?php  echo $nama;?> &nbsp; <span class="glyphicon glyphicon-chevron-down"></span></a>
							<div class="dropdown-content2">
								<a href="<?php echo base_url('ortu/ortu/ganti_password'); ?>">Ganti Password</a>
								<a href="<?php echo base_url('ortu/ortu/logout'); ?>"> Logout </a> 
							</div>
					</li>
				</ul>	
		</div>
	</div>
	
	<!--start-what-->
	<div class="col-md-12" >
		<div class="container">
			<div class="col-md-12">
			
				<h2 align="center"> Rekap Absensi Hari Ini  </h2>
				<hr/>
				<?php 
				
				if ($jumlah>0){ ?>
					<table class="table">
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
							<td><?php echo $s->keterangan ?></td>
							<td><?php echo $s->detail ?></td>
							<td><?php echo $s->jam ?></td>
							<td><?php echo $s->tanggal ?></td>
						</tr>
						<?php 
							$i++;}
						?>
					</table>
					
					<? }else{ ?>
					
											
						<h4 align="center"> Tidak ada daftar absen </h4>
					
					
					<?php } ?>
					
				
			
			</div>
			
			<div class="col-md-12" >
				
					<div style="float: left;" >
					
						<div class="panel-heading">
							<a href="<?php echo base_url('ortu/ortu/rekap_absensi'); ?>" class="ui purple submit button "> Lihat Rekap </a>
						</div>
						
					</div>
				
			</div>
			
		</div>
	</div>
	<!--end-what-->
	
	
</body>
</html>

<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
