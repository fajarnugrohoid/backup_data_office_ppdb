<html>
	<head>
		<title>Daftar Absensi Siswa</title>
		
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
		
		<script>
			function ambil_siswa(bulan, tahun, kelas) {
				var xmlhttp;
				if(kelas != ""){
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
					var params = "bulan="+bulan+"&tahun="+tahun+"&kelas="+kelas;
					xmlhttp.open("POST", "rekap_absen2", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					
					xmlhttp.send(params);
				}
			}
			function proses(){
				var kelas = document.getElementById("kelas").value;
				var tahun = document.getElementById("tahun").value;
				var bulan = document.getElementById("bulan").value;
				
				if(kelas != "" && tahun != "" && bulan != ""){
					ambil_siswa(bulan, tahun, kelas);
				}
			}
		</script>
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
		
		<h1> Daftar Absen </h1>
		
		<div class="col-md-12" style="margin-top: 20px;">	
			
				<ul class="nav nav-tabs nav-pills" role="tablist">
				  <li><a href="<?php echo base_url('administrator/daftar_absen'); ?>">Daftar Absen</a></li>
				  <li  class="active"><a href="<?php echo base_url('administrator/rekap_absensi'); ?>">Rekap Absen</a></li>
				</ul>
		</div>
			
		<div class="col-md-12" style="margin-top: 20px;">
			
				<div class="col-md-12" >
				<h4> Lihat Rekap : </h4> 
				<?php echo form_open('administrator/rekap_absen2') ?>
				<select id = "bulan" name = "bulan" onchange = "proses()">
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
			
			
				<select id = "tahun" name = "tahun" onchange = "proses()">
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
				
				<select id = "kelas" name = "kelas" onchange = "proses()">
					<option value = "">--Pilih Kelas--</option>
					<?php foreach($kelas as $k){ ?>
					<option value = "<?php echo $k->id_kelas ?>"><?php echo $k->kelas ?></option>
					<?php } ?>
					
				</select>
				
				<?php echo form_close() ?>
				
				
				<div id = "myDiv">
				</div>
				</div>
				
			
		</div>
			
			
		</div>
	</body>
</html>