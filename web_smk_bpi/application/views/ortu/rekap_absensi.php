<html>
	<head>
		<title>Rekap Absensi Siswa</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.js');?>"></script>
	
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-collapse.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-dropdown.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-transition.js');?>"></script>
	
	<!-- load bootstrap css -->
	<link href="<?php echo base_url('asset/css/bootstrap.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-theme.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-responsive.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-responsive.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/style.css'); ?>" rel='stylesheet' type='text/css' />
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/packaged/css/semantic.css');?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/examples/homepage.css');?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/packaged/css/custom.css');?>">
		
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
	
	
		
	<script>
			function ambil_siswa(bulan, tahun) {
				var xmlhttp;
					if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}

					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
						   if(xmlhttp.status == 200){
							   document.getElementById("myDiv").innerHTML = xmlhttp.responseText;
						   }
						   else if(xmlhttp.status == 400) {
							  alert('There was an error 400')
						   }
						   else {
							   alert('something else other than 200 was returned')
						   }
						}
					}
					var params = "bulan="+bulan+"&tahun="+tahun;
					xmlhttp.open("POST", "rekap_absen2", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					
					xmlhttp.send(params);
				
			}
			function proses(){
				var tahun = document.getElementById("tahun").value;
				var bulan = document.getElementById("bulan").value;
				
				if(tahun != "" && bulan != ""){
					ambil_siswa(bulan, tahun);
				}
			}
		</script>
		
	</head>
	
	<body>
	
	
			
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
				<a class="navbar-brand" href="<?php echo base_url('welcome'); ?>"><img src="<?php echo base_url('asset/img/'.$list->logo); ?>" alt="" style="margin-top: 0px;"/></a>
				
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
					<!--<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
							<li class="divider"></li>
							<li><a href="#">One more separated link</a></li>
						</ul>
					</li>-->
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
								<a target="_blank" href="<?php echo base_url('ortu/ortu'); ?>"> Absensi </a>
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
	
		<div class="container" >
		
			<div class="col-md-12" style="font-size: 14px;">
			
			<form>
				<select id = "bulan" name = "bulan" onchange = "proses()" >
					<option value = "">--Pilih Bulan--</option>
					<option value = "1">Januari</option>
					<option value = "2">Februari</option>
					<option value = "3">Maret</option>
					<option value = "4">April</option>
					<option value = "5">Mei</option>
					<option value = "6">Juni</option>
					<option value = "7">Juli</option>
					<option value = "8">Agustus</option>
					<option value = "9">September</option>
					<option value = "10">Oktober</option>
					<option value = "11">November</option>
					<option value = "12">Desember</option>
				</select>
			
			
				<select id = "tahun" name = "tahun" onchange = "proses()" >
					<option value = "">--Pilih Tahun--</option>
					<?php 
						$i = date('Y');
						$j = 0;
						for($j=0;$j<3;$j++){
					?>
					<option value = "<?php echo $i ?>"><?php echo $i ?></option>
					<?php
							$i = $i-1;
						}
					?>
				</select>
				
			</form>
			
			</div>
			
			
			<div id = "myDiv">
			</div>
		
		</div>
		
		
		<div class="col-md-12" >
				<div style="float:left; margin-left: 100px; margin-top: 20px;">
					<div class="panel-heading">
						<a href="<?php echo base_url('ortu/ortu/rekap_absen'); ?>" class="ui purple submit button"> Rekap Hari Ini </a>
					</div>
				</div>
			</div>
			
	</body>
</html>