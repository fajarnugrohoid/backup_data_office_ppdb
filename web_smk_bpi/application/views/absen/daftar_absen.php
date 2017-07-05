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
			function ambil_siswa() {
				var kelas = document.getElementById("kelas").value;
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
					var params = "id_kelas="+kelas;
					xmlhttp.open("POST", "load_absen", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					
					xmlhttp.send(params);
				}
			}
			function ambil_siswa2(){
				var kelas = document.getElementById("kelas").value;
				var cari = document.getElementById("cari").value;
				var xmlhttp;
				if(kelas != "" && cari != ""){
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
					var params = "cari="+cari+"&id_kelas="+kelas;;
					xmlhttp.open("POST", "load_absen", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					
					xmlhttp.send(params);
				}
			}
			
			function rekap_absen(){
				var xmlhttp;
				if(kelas != "" && cari != ""){
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
							   document.getElementById("rekap").innerHTML = xmlhttp.responseText;
						   }
						   else if(xmlhttp.status == 400) {
							  alert('There was an error 400')
						   }
						   else {
							   alert('something else other than 200 was returned')
						   }
						}
					}
					xmlhttp.open("POST", "rekap_absen", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					
					xmlhttp.send();
				}
			}
		</script>
	</head>
	
	<body onload = "rekap_absen()">
		<div class="container" style="margin-top: 50px; margin-left: 20px;">
			
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
				  <li class="active"><a href="<?php echo base_url('administrator/daftar_absen'); ?>">Daftar Absen</a></li>
				  <li><a href="<?php echo base_url('administrator/rekap_absensi'); ?>">Rekap Absen</a></li>
				</ul>
		</div>
		
			<div class="col-md-7" style="margin-top: 50px; border-right: 1px solid #e3e1e1"> 
			
			<div class="col-md-2">
				<select id = "kelas" onclick = "ambil_siswa()">
					<option value = "0">--PILIH KELAS--</option>
				<?php foreach($kelas as $k){ ?>
					<option value = "<?php echo $k->id_kelas ?>"><?php echo $k->kelas ?></option>
				<?php } ?>
				</select>
			</div>
			<div class="col-md-7">
				<form class="form-search col-md-7">
					<input type = "text" id = "cari" onkeyup = "ambil_siswa2()" class="span3" placeholder="Cari nama siswa">
				</form>
			</div>
			
			<div class="col-md-12" >
				<div id = "myDiv" class="table table-striped">
				</div>
			</div>
			
			</div>
			
			
			<div class="col-md-5">	
				<div id = "rekap"></div>

			</div>
			
			
		</div>
	</body>
</html>