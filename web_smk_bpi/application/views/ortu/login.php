<html>
	<head>
		<title> Login </title>
		<?php foreach($profilsekolah_pil as $sekolah){ ?>
			<link href="<?php echo base_url('asset/img/'.$sekolah->logo); ?>" rel='icon' type='image/x-icon'/>
		<?php } ?>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<!--CSS-->
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/packaged/css/semantic.css');?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/examples/homepage.css');?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/packaged/css/custom.css');?>">
		
		<link href="<?php echo base_url('asset/css/bootstrap.css'); ?>" rel='stylesheet' type='text/css' />
		<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css'); ?>" rel="stylesheet">
		<script src="<?php echo base_url('asset/js/jquery.min.js'); ?>"></script>
		
		<!---- start-smoth-scrolling---->
		<script type="text/javascript" src="<?php echo base_url('asset/js/move-top.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/easing.js'); ?>"></script>
		<link href="<?php echo base_url('asset/css/bootstrap-theme.min.css');?>" rel="stylesheet">
		
		<!--start-smoth-scrolling-->
		<script src="<?php echo base_url('asset/js/moment.min.js') ?>"></script>
        <script src="<?php echo base_url('asset/js/jquery-1.11.3.min.js') ?>"></script>
      
		<link href="<?php echo base_url('asset/css/style.css'); ?>" rel='stylesheet' type='text/css' />
		
		
		<!--Java Script-->
		<script src="<?php echo base_url('plugin/packaged/javascript/semantic.js');?>"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
		<style>
			.ui.blue.message,
			.ui.info.message {
			  background-color: #E6F4F9;
			  color: #4D8796;
			}
			.ui.red.message {
			  background-color: #F1D7D7;
			  color: #A95252;
			}
			.ui.message {
			  font-size: 1em;
			}
			.ui.message:first-child {
			  margin-top: 0em;
			}
			.ui.message:last-child {
			  margin-bottom: 0em;
			}
			.ui.message {
			  position: relative;
			  min-height: 18px;
			  margin: 1em 0em;
			  height: auto;
			  background-color: #EFEFEF;
			  padding: 1em;
			  line-height: 1.33;
			  color: rgba(0, 0, 0, 0.6);
			  -webkit-transition: opacity 0.1s ease, color 0.1s ease, background 0.1s ease, -webkit-box-shadow 0.1s ease;
			  -moz-transition: opacity 0.1s ease, color 0.1s ease, background 0.1s ease, box-shadow 0.1s ease;
			  transition: opacity 0.1s ease, color 0.1s ease, background 0.1s ease, box-shadow 0.1s ease;
			  -webkit-box-sizing: border-box;
			  -moz-box-sizing: border-box;
			  -ms-box-sizing: border-box;
			  box-sizing: border-box;
			  border-radius: 0.325em 0.325em 0.325em 0.325em;
			}
		</style>
		
		<style>
            body {
                padding: 0;
                font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
                font-size: 12px;
            }
            .fc th {
                padding: 10px 0px;
                vertical-align: middle;
                background:#F2F2F2;
            }
            .fc-day-grid-event>.fc-content {
                padding: 4px;
            }
            #calendar {
                max-width: 700px;
                max-height: 1000px;
                margin: 0 auto;
            }
            .error {
                color: #ac2925;
                margin-bottom: 15px;
            }
            .event-tooltip {
                width:150px;
                background: rgba(0, 0, 0, 0.85);
                color:#FFF;
                padding:10px;
                position:absolute;
                z-index:10001;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 11px;
            }
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
				<a class="navbar-brand" href="<?php echo base_url('welcome'); ?>"><img src="<?php echo base_url('asset/img/'.$list->logo); ?>" alt="" style="margin-top:0px;"/></a>
				
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
	
	<div class="col-md-12" style="margin-top: 100px;">
		<h1 align="center"> Daftar Absensi Siswa </h1>
		
		<div class="wrapper-login" style="margin-top:0px;">	
		
			<?php echo form_open("ortu/ortu/proses_login", "class='form-horizontal' role='form'"); ?>
			<?php echo $this->session->flashdata('notification'); ?>
			<div class="ui purple form segment">
				
				<div class="field">
					<label>Username</label>
					<div class="ui left labeled icon input">
					  <input name="username" type="text" required autofocus>
					  <i class="user icon"></i>
					  <div class="ui corner label">
						<i class="icon asterisk"></i>
					  </div>
					</div>
				</div>
				<div class="field">
					<label>Password</label>
					<div class="ui left labeled icon input">
					  <input name="password" type="password" required>
					  <i class="lock icon"></i>
					  <div class="ui corner label">
						<i class="icon asterisk"></i>
					  </div>
					</div>
				</div>
				
				<?php echo form_submit("login", "Login", "class='ui purple submit button'"); ?>
				<br/><br/>
				<font color="red"></font>
			</div>
			<?php echo form_close(); ?>
			
		</div>
	</div>
	
	</body>
</html>