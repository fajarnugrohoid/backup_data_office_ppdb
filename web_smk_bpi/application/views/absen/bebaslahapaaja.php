<html>

	<head>
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
				
				var xmlhttp;
				
					if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}

					xmlhttp.onreadystatechange = function() {
						alert(xmlhttp.readyState);
						alert(XMLHttpRequest.DONE);
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
				alert('Oy');
					}
					
					xmlhttp.open("POST", "form_input", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				
					xmlhttp.send(null);
			}
			
			function coba(){
			}
			
		</script>
		
	</head>
	
	<body>
		<div class="col-md-12" style="margin-top: 20px;">	
			
				<ul class="nav nav-tabs nav-pills" role="tablist">
				  <li><button onclick="ambil_siswa()">Daftar Absen</button></li>
				  <li  class="active"><a href="<?php echo base_url('administrator/rekap_absensi'); ?>">Rekap Absen</a></li>
				</ul>
		</div>
		
		<div id="myDiv">
		</div>
		
	</body>
	
</html>