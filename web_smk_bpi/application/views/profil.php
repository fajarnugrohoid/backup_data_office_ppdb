<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $title; ?></title>
	<?php foreach($profilsekolah_pil as $sekolah){ ?>
		<link href="<?php echo base_url('asset/img/'.$sekolah->logo); ?>" rel='icon' type='image/x-icon'/>
	<?php } ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Tutoring Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<link href="<?php echo base_url('asset/css/bootstrap.css'); ?>" rel='stylesheet' type='text/css' />
	<link href="<?php echo base_url('asset/js/bootstrap.min.js'); ?>" rel='stylesheet' type='text/css' />
	<script src="<?php echo base_url('asset/js/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('asset/js/bootstrap.js'); ?>"></script>
	<link href="<?php echo base_url('plugin/packaged/css/custom.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('plugin/packaged/css/semantic.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/style.css'); ?>" rel='stylesheet' type='text/css' />
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
	<style>
		.dropbtn{
			background-color: #4d517e;
			color: white;
			padding: 16px;
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
			min-width: 220px;
			border: 0px solid black;
			text-transform: uppercase;
			font-family:'Play-Regular';
			font-size: 15px;
			opacity: 0.8;
		}
		.dropdown-content a{
			color: white;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
		}
		.dropdown-content a:hover{
			background-color: #545e94;
			opacity: 1;
		}
		.dropdown:hover .dropdown-content{
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
				<style>
					.banner{
						background:url(<?php echo base_url('asset/img/'.$list->foto_profil); ?>) no-repeat;
						background-size:cover;
						-webkit-background-size:cover;
						-moz-background-size:cover;
						-o-background-size:cover;
						-ms-background-size:cover;
						min-height:550px;
						max-height:550px;
					}
					.banner-top {
						text-align: left;
						margin-top: 10%;
					}
					.banner-top p {
						color: #fff;
						font-size: 15px;
						line-height:1.6em;
						margin: 18px 0 0 0;
						font-family: 'Play-Regular';
						-width: 78%;
						min-height:155px;
						max-height:155px;
					}
					.slide-top {
						text-align: left;
						
					}
					.slider {
						padding-top: 10%;
					}
					body{
						font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
					}
				</style>
				<?php } ?>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse new" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav new">
					<li class=""><a href="<?php echo base_url('welcome'); ?>" class="hvr-bounce-to-top">Beranda <span class="sr-only"></span></a></li>
					<li><a href="<?php echo base_url('welcome/lihat_unitkerja'); ?>" class="hvr-bounce-to-top">Unit Kerja</a></li>
					<li><a href="<?php echo base_url('welcome/lihat_pegawai'); ?>" class="hvr-bounce-to-top">Kepegawaian</a></li>
					<li><a href="<?php echo base_url('welcome/lihat_ekstrakulikuler'); ?>" class="hvr-bounce-to-top">Ekstrakurikuler</a></li>
					<li><a href="<?php echo base_url('welcome/input_feedback'); ?>" class="hvr-bounce-to-top">Kontak</a></li>
					<li class="dropdown active">
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
					<li class="dropdown">
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
	
	<div class="services" style="margin-top: 50px;">
		<div class="container">
			<div class="col-xs-12">
			<?php foreach ($profilsekolah_pil as $list){ ?>
				<center><img width="800px" align="center" height="500px" src="<?php echo base_url('asset/img/'.$list->foto_profil); ?>"></img></center>
			<?php } ?>
			<hr/>
			<?php foreach ($visimisi_pil as $list){ ?>	
			<div class="col-md-12">
				<div style="margin-top: 10px;">
					<h2> VISI </h2>	
				</div>
				<hr/>
			
				<div class="col-md-12" style="margin-bottom: 30px; ">
					<p><?php echo $list->visi; ?> </p> 
				</div>
				
				<div style="margin-top: 10px;">
					<h2> MISI </h2>	
				</div>
				<hr/>
				
				<div class="col-md-12" style="margin-bottom: 30px; ">
					<p><?php echo $list->misi; ?> </p> 
				</div>
			
			</div>
			<?php } ?>
			<hr/>
			
			<div class="col-md-12" style="margin-top: 10px;">
			
			<div >
				<h2><?php echo $title; ?></h2>
			</div><hr/><br/>
			<table class="table table-responsive">
			<?php foreach ($profilsekolah_pil as $list){ ?>
				<br/>
				<tr>
					<td>Nama</td>
					<td><?php echo $list->nama_sekolah; ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td><?php echo $list->alamat; ?></td>
				</tr>
				<tr>
					<td>Kontak</td>
					<td><?php echo $list->no_kontak; ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?php echo $list->email; ?></td>
				</tr>
			</table>
			
			</div>
			
			<div class="col-md-12" style="margin-top: 10px;">
			
			<div style="margin-top: 10px;">
				<h2> Sambutan Kepala Sekolah </h2>	
			</div>
			<hr/>
			
			<div class="col-md-12" style="margin-bottom: 30px; ">
				<p> <?php echo $list->sambutan_kepsek; ?> </p> 
			</div>
			
			<div style="margin-top: 10px;">
				<h2> Deskripsi Sekolah </h2>	
			</div>
			<hr/>
			
			<div class="col-md-12" style="margin-bottom: 30px; ">
				<p> <?php echo $list->deskripsi; ?> </p> 
			</div>
		
			<?php } ?>
			
			</div>
			
			</div>
		</div>
	</div>
	</div>

	<!--start-footer-->
	<div class="footer">
		<div class="container">
			<div class="footer-main" >
				<div class="col-md-4 footer-left" style="font-size: 16px; font-style: strong;">
					<b> <p style="strong"><a href="<?php echo base_url(); ?>" target="_blank"><i  class="glyphicon glyphicon-list-alt"></i> &nbsp; Try Out Online </a></p> </b>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					
					<p class="footer-class"><a href="http://www.instagram.com/solution.varit" target="_blank"><i class="glyphicon glyphicon-briefcase"></i> Developer</a></p>
				</div>
				<div class="col-md-4 footer-left">
					<a href="<?php echo base_url('welcome/input_feedback'); ?>"><span class="glyphicon glyphicon-map-marker map-marker" aria-hidden="true"></span>
					<p>Kampus SMK Badan Perguruan Indonesia (BPI) <span>Jln.Burangrang No.8</span>  Kota Bandung</p></a>
					<br/>
					<br/>
					<span class="glyphicon glyphicon-phone map-marker" aria-hidden="true"></span>
					<p>(022) 7301739 <span>(022) 7305735</span> </p>
				</div>
				<div class="col-md-4 footer-left">
					<p class="footer-class">� Alamat Email<span> E-mail: <?php foreach($profilsekolah_pil as $sekolah){ echo $sekolah->email;?></span> <span>Website:  <?php echo base_url(); }?> </span></p>
					<ul>
						<li><a target="_blank" href="http://facebook.com/SmkBpiBandung"><span class="fb"></span></a></li>
						<li><a target="_blank" href="http://twitter.com/smkbpibdg"><span class="twit"></span></a></li>
					</ul>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-4"></div>
					<div class="col-xs-6 col-md-4 footer-left"></div>
					<div class="col-xs-6 col-md-4"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<script type="text/javascript">
									$(document).ready(function() {
										/*
										var defaults = {
								  			containerID: 'toTop', // fading element id
											containerHoverID: 'toTopHover', // fading element hover id
											scrollSpeed: 1200,
											easingType: 'linear' 
								 		};
										*/
										
										$().UItoTop({ easingType: 'easeOutQuart' });
										
									});
								</script>
		<a href="#home" id="toTop" class="scroll" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	</div>
	<!--end-footer-->
</body>
</html>