<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $title; ?></title>
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
	
	<!--maps-->
	<script src="http://maps.googleapis.com/maps/api/js">
	</script>
	
	<script>
	var map;
	var myCenter=new google.maps.LatLng(-6.924095,107.619103);

	function initialize()
	{
	var mapProp = {
	  center:myCenter,
	  zoom:16,
	  mapTypeId:google.maps.MapTypeId.ROADMAP
	  };

	  map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

	  var marker=new google.maps.Marker({
	  position:myCenter,
	  });
	  
	  marker.setMap(map);
	  
	  google.maps.event.addListener(map, 'click', function(event) {
		placeMarker(event.latLng);
	  });
	  
	  var infowindow = new google.maps.InfoWindow({
		content:"SMK BPI Bandung<br>Jalan Burangrang No. 8"
	  });
	  
	  infowindow.open(map, marker);
	}


	function placeMarker(location) {
	  var marker = new google.maps.Marker({
		position: location,
		map: map,
	  });
	  var infowindow = new google.maps.InfoWindow({
		content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
	  });
	  infowindow.open(map,marker);
	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>
<link href="<?php echo base_url('asset/css/bootstrap-theme.min.css');?>" rel="stylesheet">
	
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
				<?php } ?>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse new" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav new">
					<li><a href="<?php echo base_url('welcome'); ?>" class="hvr-bounce-to-top">Beranda <span class="sr-only"></span></a></li>
					<li><a href="<?php echo base_url('welcome/lihat_unitkerja'); ?>" class="hvr-bounce-to-top">Unit Kerja</a></li>
					<li><a href="<?php echo base_url('welcome/lihat_pegawai'); ?>" class="hvr-bounce-to-top">Kepegawaian</a></li>
					<li><a href="<?php echo base_url('welcome/lihat_ekstrakulikuler'); ?>" class="hvr-bounce-to-top">Ekstrakurikuler</a></li>
					<li class="active"><a href="<?php echo base_url('welcome/input_feedback'); ?>" class="hvr-bounce-to-top">Kontak</a></li>
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
	
	<div class="services">
		<div class="container">
			<div class="services-top heading">
				<h1><?php echo $title; ?></h1>
			</div>
			<hr/>
			<div class="panel-group" id="accordion">
				<center>
					<div id="googleMap" style="width:800px;height:600px;"></div>
				</center>
				
				<br/>
				<center>
				<?php foreach($profilsekolah_pil as $list){ ?>
					<p><span class="glyphicon glyphicon-home"></span><?php echo "  ".$list->alamat."  |  "; ?><span class="glyphicon glyphicon-phone-alt"></span><?php echo "  ".$list->no_kontak."  |  "; ?><span class="glyphicon glyphicon-envelope"></span><?php echo "  ".$list->email; ?></p>
				<?php } ?>
				</center>
				
			</div>
				
			<div class="col-md-11">
			
			<hr>
			
			<h2><b>Formulir Komentar</b></h2>
			<!-- form tambah feedback -->
			<?php echo form_open("welcome/proses_input_feedback", "class='form-horizontal' role='form'"); ?>
			<div class="col-md-6">
			
				<div class="control-group col-md-12">
					<label for="nama" class="control-label">Nama</label>
					<div class="controls"><?php echo form_input('nama', "", 'placeholder="Nama Lengkap" class="input-xxlarge col-md-11" id="nama" /required'); ?></div>
				</div>
				<div class="control-group col-md-12">
					<label for="instansi" class="control-label">Instansi</label>
					<div class="controls"><?php echo form_input('instansi', "", 'placeholder="Asal / Instansi" class="input-xxlarge col-md-11" id="instansi" /required'); ?></div>
				</div>
				<div class="control-group col-md-12">
					<label class="control-label" for="kontak">Nomor HP/Telpon</label>
					<div class="controls"><?php echo form_input('kontak', "", 'placeholder="Masukan No Telp/HP" id="kontak" class="input-xxlarge col-md-11" /required'); ?></div>
				</div>
				<div class="control-group col-md-12">
					<label class="control-label" for="email">Email</label>
					<div class="controls"><?php echo form_input('email', "", 'placeholder="Email" class="input-xxlarge col-md-11" id="email" /required'); ?><span class="help-block col-md-12">Masukkan E-mail yang aktif untuk mendapatkan balasan komentar. contoh: varit.solution@gmail.com</span></div>
				</div>
			
			</div>
			
			<div class="col-md-6">
			
			<div class="control-group col-md-12">
				<label class="control-label" for="komentar">Komentar</label>
				<div class="controls"><?php echo form_textarea('komentar', "", 'placeholder="Masukan komentar" id="komentar" class="input-xxlarge col-md-12" /required'); ?></div>
			</div>
			<input type="hidden" name="tanggal" value="<?php date("Y-n-j, H:i:s");?>">
			<div class="form-action col-md-12">
				<br/>
				<?php echo form_submit("simpan", "Simpan Data", "class='btn btn-primary'"); ?>
				<?php echo form_reset("reset", "Bersihkan", "class='btn btn-warning'"); ?>
			</div>
			<?php echo form_close(); ?>
			
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
					<p class="footer-class">© Alamat Email<span> E-mail: <?php foreach($profilsekolah_pil as $sekolah){ echo $sekolah->email;?></span> <span>Website:  <?php echo base_url(); }?> </span></p>
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