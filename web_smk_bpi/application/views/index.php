<!DOCTYPE html>
<html lang="en">
<head>
	<title>SMK BPI BANDUNG</title>
	<?php foreach($profilsekolah_pil as $sekolah){ ?>
		<link href="<?php echo base_url('asset/img/'.$sekolah->logo); ?>" rel='icon' type='image/x-icon'/>
	<?php } ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Tutoring Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<link href="<?php echo base_url('asset/css/bootstrap.css'); ?>" rel='stylesheet' type='text/css' />
	<link href="<?php echo base_url('asset/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/css/bootstrap-responsive.min.css'); ?>" rel="stylesheet">
	<script src="<?php echo base_url('asset/js/jquery.min.js'); ?>"></script>
	
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
        <script src="<?php echo base_url('asset/js/bootstrap-carousel.js'); ?>"></script>
        <script src="<?php echo base_url('asset/js/fullcalendar.min.js') ?>"></script>
        <script src="<?php echo base_url('asset/js/bootstrap-colorpicker.min.js') ?>"></script>
        <script src="<?php echo base_url('asset/js/bootstrap-timepicker.min.js') ?>"></script>
		<link href="<?php echo base_url('asset/css/fullcalendar.css'); ?>" rel='stylesheet' />
		<link href="<?php echo base_url('asset/css/fullcalendar.print.css'); ?>" media='print' />
		<link href="<?php echo base_url('asset/css/bootstrapValidator.min.css') ?>" rel="stylesheet" />
		<link href="<?php echo base_url('asset/css/bootstrap-colorpicker.min.css') ?>" rel="stylesheet" />
		<link href="<?php echo base_url('asset/css/bootstrap-timepicker.min.css') ?>" rel="stylesheet" />
		<link href="<?php echo base_url('asset/css/style.css'); ?>" rel='stylesheet' type='text/css' />
		

		
		<script src="<?php echo base_url('asset/js/jquery-2.1.3.min.js'); ?>"></script>
		

		
        <script>
			$(function(){
				$('#calendar').fullCalendar({
					timeFormat: 'H(:mm)',
					// header: {
						// left: 'prev, next, today',
						// center: 'title',
						// right: 'month, basicWeek, basicDay'
					// },
					// Get all events stored in database
					events: '<?php echo site_url('Agenda/getEvents') ?>',
					// Handle Day Click
					dayClick: function(date, event, view) {
						currentDate = date.format();
						// Open modal to add event
						modal({
							// Available buttons when adding
							// buttons: {
								// add: {
									// id: 'add-event', // Buttons id
									// css: 'btn-success', // Buttons class
									// label: 'Add' // Buttons label
								// }
							// },
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
					<li class="active"><a href="<?php echo base_url('welcome'); ?>" class="hvr-bounce-to-top">Beranda <span class="sr-only"></span></a></li>
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
					<li class="dropdown">
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
	<!--start-banner-->
	<div class="banner">
	

		    <!--<ul class="t-menu red" style="position: fixed;">
                <li><a href="#" class="dropdown-toggle"></a>
                    <ul class="t-menu horizontal" data-role="dropdown">
                        <li><a href="#"><h5 style="color: white;"> <strong> TRYOUT ONLINE </strong> </h5> </li>
                        
                    </ul>
                </li>

            </ul>-->
			
		<div style="background-color: #8580f9; position: fixed; padding: 5px;">
			<h5 align="center" style="color: white;"> <strong>  CLICK ME! </strong> </h5>
			<h5 align="center"style="color: white;"> <strong>  TRYOUT ONLINE </strong> </h5>
		</div>
			
		<section class="slider">
			<div class="flexslider">
				<ul class="slides" style="color: white; background:#000;opacity:0.4;filter:alpha(opacity=40); margin-top: 30px;">
					<li style="max-height: 530px">
						<div class="slide-top">
							<div class="container" style="padding-left: 20%;">
							<blockquote><h1>Info PPDB  <span class="glyphicon glyphicon-thumbs-up"></span></h1>
							<h3>Daftar informasi mengenai Penerimaan Peserta Didik Baru</h3>
							<div class="bnr-btn" style="padding-left: 60%;">
								<h4><a href="<?php echo base_url('welcome/list_infoppdb'); ?>" class="hvr-shutter-out-horizontal" data-toggle="modal" >LIHAT</a></h4>
							</div></blockquote>
							</div>
						</div>
					</li>
					<li style="max-height: 530px">
						<div class="slide-top">
							<div class="container" style="padding-left: 25%;">
							<blockquote><h1>Berita  <span class="glyphicon glyphicon-thumbs-up"></span></h1>
							<h3>Daftar berita terkait SMK BPI Bandung</h3>
							<div class="bnr-btn" style="padding-left: 40%;">
								<a href="<?php echo base_url('welcome/list_berita'); ?>" class="hvr-shutter-out-horizontal">LIHAT</a>
							</div>
							</blockquote>
							</div>
						</div>
					</li>
					<li style="max-height: 530px">
						<div class="slide-top">
							<div class="container" style="padding-left: 20%;">
							<blockquote><h1>Artikel  <span class="glyphicon glyphicon-thumbs-up"></span></h1>
							<h3>Daftar artikel menarik yang dapat menambah wawasan</h3>
							<div class="bnr-btn" style="padding-left: 55%;">
								<a href="<?php echo base_url('welcome/list_artikel'); ?>" class="hvr-shutter-out-horizontal">LIHAT</a>
							</div>
							</blockquote>
							</div>
						</div>
					</li>
					<li style="max-height: 530px">
						<div class="slide-top">
							<div class="container" style="padding-left: 25%;">
							<blockquote><h1>Bursa Kerja  <span class="glyphicon glyphicon-thumbs-up"></span></h1>
							<h3>Daftar Lowongan Kerja untuk alumni</h3>
							<div class="bnr-btn" style="padding-left: 40%;">
								<a href="<?php echo base_url('welcome/lihat_bursakerja'); ?>" class="hvr-shutter-out-horizontal">LIHAT</a>
							</div>
							</blockquote>
							</div>
						</div>
					</li>
					<li style="max-height: 530px">
						<div class="slide-top">
							<div class="container" style="padding-left: 10%;">
							<blockquote><h1>Latihan Ujian Masuk  <span class="glyphicon glyphicon-thumbs-up"></span></h1>
							<h3>Latihan soal sebelum tes masuk untuk Calon Peserta Didik SMK BPI Bandung</h3>
							<div class="bnr-btn" style="padding-left: 80%;">
								<a href="#" class="hvr-shutter-out-horizontal">LIHAT</a>
							</div>
							</blockquote>
							</div>
						</div>
					</li>	
				</ul>
			</div>
		</section>
	</div>
	<!--end-banner-->
	

	
	<!--FlexSlider-->
	<link rel="stylesheet" href="<?php echo base_url('asset/css/flexslider.css'); ?>" type="text/css" media="screen" />
	<script defer src="<?php echo base_url('asset/js/jquery.flexslider.js'); ?>"></script>
	<script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
			flexslider = slider;
          $('body').removeClass('loading');
        }
      });
    });
  </script>
	
	<!--end-provide-->
	<!--start-welcome-->
	<div class="join">
		<div class="container">
			<div class="join-main">
				<h1 align="center"> <marquee> Mengedepankan Pendidikan Kepribadian dan Akhlak Mulia Berbasis Penilaian Holistik </marquee> </h1>
				<div class="clearfix">
				</div>
			</div>
		</div>
	</div>
	<!--end-welcome-->
	<!--start-join-->
	<div class="welcome">
		<div class="container">
			<div class="welcome-top">
				<?php 
				foreach($data as $key){?>
				<div class="col-md-4 welcome-left">
					<h3><a href="<?php echo base_url('welcome/'); ?>"><?php echo $key->judul_artikel; ?></a></h3>
					<h5><?php echo date("d F Y", strtotime($key->tgl_posting)); ?></h5>
					<p><?php
					 $position=300; // Define how many character you want to display.
					 $text=$key->artikel; $text=character_limiter($text, 100);
					 $message= $text;
					 $post = substr($message, 12, $position); 
					 echo $post;
					?></p>
					<div class="w-btn">
						<a href="<?php echo base_url('welcome/artikel/'.$key->id_artikel); ?>" target="_blank" class="hvr-shutter-out-horizontal">Selengkapnya</a>
					</div>
				</div>
				<?php
				}
				?>
			
				<div class="clearfix"></div>
				
				<div class="col-md-12" style="text-align: right;">
					<h5> <a href="<?php echo base_url('welcome/list_artikel'); ?>" target="_blank"> Artikel Lainnya >> </a> </h3>
				</div>
				
			</div>
		</div>
	</div>
	<!--end-join-->
	<!--start-news-->
	<div class="news">
		<div class="container">
		
			<div class="news-top">
				<div class="col-md-8 news-left">
					<div class="news-heading">
						<h3>BERITA TERKINI</h3>
					</div>
					<div class="news-bottom">
					
						<?php foreach ($berita as $b){ ?>
						
						<div class="news-one">
							<?php 	if(strcmp($b->gambar_utama,"")==0){
										$kelasberita="news-one";
										$panjangteks=500;
									}else{ 
							?>
										<div class="news-one-left">
											<img src="<?php echo base_url('asset/images/'.$b->gambar_utama) ?>" alt="" />
										</div>
							<?php
										$kelasberita="news-one-right";
										$panjangteks=300;
									}
							?>
							<div class="<?php echo $kelasberita; ?>">
								<h4><?php echo $b->judul_berita; ?></h4>
								<?php echo date("d F Y", strtotime($b->tgl_posting)); ?>
								<p><?php $text=$b->berita; $text=character_limiter($text, $panjangteks); echo $text;?></p>
							</div>
							
							<div class="col-md-12" style="padding-left: 50%;  ">
								<div class="news-one-right w-btn footer-right" style="float: right; ">
									<a href="<?php echo base_url('welcome/berita/'.$b->id_berita); ?>" target="_blank" class="hvr-shutter-out-horizontal">Selengkapnya</a>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<?php } ?>
						
						<br/>
						<hr/>
						<div class="col-md-12" style="text-align: right;">
							<h5> <a href="<?php echo base_url('welcome/list_berita'); ?>" target="_blank"> Berita Lainnya >> </a> </h3>
						</div>
						
					</div>
				</div>
				<div class="col-md-4 news-right">
					<div class="news-heading">
						<h3> <a href="<?php echo base_url('Agenda/beranda') ?>"> Kalender</a> </h3>
					</div>
						<div class="row clearfix" style="margin-top: 30px;">
							<div class="col-md-12">
									<div id='calendar' style="margin-bottom: 20px; "></div>
							</div>
						</div>
					<br/>
					
					<div class="news-heading" style="height: 400px; ">
						<h3>TWITTER</h3>
						<hr/>
						
							 <a class="twitter-timeline" href="https://twitter.com/smkbpibdg" data-widget-id="693025451225260032">Tweets by @smkbpibdg</a>
							 <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			
					</div>
				</div>
				
				<div class="col-md-4 news-right">				
					<div class="news-heading" style="height: 300px; ">
						<h3>Info PPDB</h3>
						<hr/>
					
						<table>
						
						<?php 
							$no = 1;
							
							foreach($info as $i){ ?>
							
								<tr>
									<td> <h4> <?php echo $no; ?> &nbsp; </h4> </td>
									
									<td> <h4><a href="#<?php echo $i->id_info_ppdb; ?>" data-toggle="modal"> <?php echo $i->judul_info_ppdb; ?></a></h4> 
									</td>
								</tr>
								
						<?php
								$no++;
							}
						?>
						
						</table>

					</div>
				</div>
				
				<div class="col-md-4 news-right">				
					<div class="news-heading" style="height: 300px; ">
						<h3>Download</h3>
						<hr/>
					
						<table>
						
						<?php 
							$no = 1;
							
							foreach($down as $d){ ?>
							
								<tr>
									<td> <h4> <?php echo $no; ?> &nbsp; </h4> </td>
									<td> <h4><a href="<?php echo base_url('welcome/download')."/".$d->file_upload; ?>" title="Unduh &quot;<?php echo $d->judul_upload; ?>&quot;"><?php echo $d->judul_upload; ?></a></h4> 
									</td>
								</tr>
								
						<?php
								$no++;
							}
						?>
						
						</table>

					</div>
				</div>
				
				<div class="col-md-4 news-right">				
					<div class="news-heading" style="height: 300px; ">
						<h3>Bursa Kerja</h3>
						<hr/>
					
						<table>
						
						<?php 
							$no = 1;
							
							foreach($bursa as $kerja){ ?>
							
								<tr>
									<td> <h4> <?php echo $no; ?> &nbsp; </h4> </td>
									
									<td> <h4><a href="<?php echo base_url('welcome/bursa_kerja/'.$kerja->id_bursa_kerja); ?>"> <?php echo $kerja->judul_bursa_kerja; ?></a></h4> 
									</td>
								</tr>
								
						<?php
								$no++;
							}
						?>
						
						</table>

					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--end-news-->
	<?php foreach($info as $i){  ?>
	
	<div class="modal fade" id="<?php echo $i->id_info_ppdb; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h1 align="center" class="modal-title" id="myModalLabel"><?php echo $i->judul_info_ppdb; ?></h1>
			</div>
			<div class="modal-body">
				
				<p align="center"><?php echo $i->info_ppdb; ?></p>
				<br/>
				<hr/>
								
				<p style="font-size: 12px; ">
	
					Tanggal Posting:
					<?php echo date("d F Y", strtotime($i->tgl_posting)); ?>
					</br>
				</p>
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	  </div>
	</div>
	
	<?php } ?>
	
<!--start-footer-->
	<div class="footer">
		<div class="container">
			<div class="footer-main">
				<div class="col-md-4 footer-left">
					<a href="<?php echo base_url('welcome/input_feedback'); ?>"><span class="glyphicon glyphicon-map-marker map-marker" aria-hidden="true"></span>
					<p>Kampus SMK Badan Perguruan Indonesia (BPI) <span>Jln.Burangrang No.8</span>  Kota Bandung</p></a>
				</div>
				<div class="col-md-4 footer-left">
					<span class="glyphicon glyphicon-phone map-marker" aria-hidden="true"></span>
					<p>(022) 7301739 <span>(022) 7305735</span> </p>
				</div>
				<div class="col-md-4 footer-left">
					<p class="footer-class">© Alamat Email<span> E-mail: smk@bpischool-bdg.com</span> <span>Website: www.bpischool-bdg.com </span></p>
					<ul>
						<li><a target="_blank" href="http://facebook.com/SmkBpiBandung"><span class="fb"></span></a></li>
						<li><a target="_blank" href="http://twitter.com/smkbpibdg"><span class="twit"></span></a></li>
					</ul>
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

<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
