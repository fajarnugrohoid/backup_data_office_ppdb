<!DOCTYPE html>
<html>
    <head>
		<title><?php echo $title; ?></title>
		<?php foreach($profilsekolah_pil as $sekolah){ ?>
		<link href="<?php echo base_url('asset/img/'.$sekolah->logo); ?>" rel='icon' type='image/x-icon'/>
		<?php } ?>
        <meta charset='utf-8' />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <link href="<?php echo base_url('asset/css/bootstrap.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('asset/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('asset/css/fullcalendar.css'); ?>" rel='stylesheet' />
        <link href="<?php echo base_url('asset/css/fullcalendar.print.css'); ?>" media='print' />
        <link href="<?php echo base_url('asset/css/bootstrapValidator.min.css') ?>" rel="stylesheet" />
        <link href="<?php echo base_url('asset/css/bootstrap-colorpicker.min.css') ?>" rel="stylesheet" />
        <link href="<?php echo base_url('asset/css/bootstrap-timepicker.min.css') ?>" rel="stylesheet" />
		
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
	
        <script src="<?php echo base_url('asset/js/moment.min.js') ?>"></script>
        <script src="<?php echo base_url('asset/js/jquery-1.11.3.min.js') ?>"></script>
        <script type="text/javascript" src= "<?php echo base_url('asset/js/bootstrapValidator.js') ?>"></script>
        <script type="text/javascript" src= "<?php echo base_url('asset/js/bootstrapValidator.min.js') ?>"></script>
        <script src="<?php echo base_url('asset/js/bootstrap.js'); ?>"></script>
        <script src="<?php echo base_url('asset/js/fullcalendar.min.js') ?>"></script>
        <script src="<?php echo base_url('asset/js/bootstrap-colorpicker.min.js') ?>"></script>
        <script src="<?php echo base_url('asset/js/bootstrap-timepicker.min.js') ?>"></script>
        <script>
			$(function(){
				$('#calendar').fullCalendar({
					timeFormat: 'H(:mm)',
					header: {
						left: 'prev, next, today',
						center: 'title',
						right: 'month, basicWeek, basicDay'
					},
					// Get all events stored in database
					events: '<?php echo site_url('Agenda/getEvents') ?>',
					// Handle Day Click
					dayClick: function(date, event, view) {
						currentDate = date.format();
						// Open modal to add event
						modal({
							// Available buttons when adding
							buttons: {
								add: {
									id: 'add-event', // Buttons id
									css: 'btn-success', // Buttons class
									label: 'Add' // Buttons label
								}
							},
							title: 'Add Event (' + date.format() + ')' // Modal title
						});
					},
					// Event Mouseover
					eventMouseover: function(calEvent, jsEvent, view){
						var tooltip = '<div class="event-tooltip">' + calEvent.description + '</div>';
						$("body").append(tooltip);
						$(this).mouseover(function(e) {
							$(this).css('z-index', 10000);
							$('.event-tooltip').fadeIn('500');

							$('.event-tooltip').fadeTo('10', 1.9);
						}).mousemove(function(e) {
								$('.event-tooltip').css('top', e.pageY + 10);
								$('.event-tooltip').css('left', e.pageX + 20);
							});
					},
					eventMouseout: function(calEvent, jsEvent) {
						$(this).css('z-index', 8);
						$('.event-tooltip').remove();
					},
					});
			});
		</script>
        <style>
            body {
                padding: 0;
               
                font-size: 14px;
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
        </style>
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
		<!-- load bootstrap css -->
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
					<li><a href="<?php echo base_url('welcome/input_feedback'); ?>" class="hvr-bounce-to-top">Kontak</a></li>
					<li class="dropdown">
						<a href="#" class="hvr-bounce-to-top">Profil <span class="glyphicon glyphicon-chevron-down"></span></a>
							<div class="dropdown-content">
								<a href="<?php echo base_url('welcome/lihat_profil'); ?>"> Profil Sekolah </a>
								<a href="<?php echo base_url('welcome/lihat_profiljurusan'); ?>"> Profil Jurusan </a>
							</div>
					</li>
					<li class="active"><a href="<?php echo base_url('Agenda/beranda') ?>" class="hvr-bounce-to-top">Agenda</a></li>
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
			
            <div class="row clearfix" style="margin-top: 30px;">
                <div class="col-md-12 column">
                        <div id='calendar'></div>
                </div>
            </div>
        </div>
	</div>
	
		<br/>
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



