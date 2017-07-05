<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php echo $title; ?> - Administrasi</title>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.js');?>"></script>
	
	<!-- Include all compiled plugins (below), or include individual files as needed -->
		 <script src="<?php echo base_url('asset/js/jquery-1.11.3.min.js') ?>"></script>
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
	
	 <link href="<?php echo base_url('asset/css/fullcalendar.css'); ?>" rel='stylesheet' />
     <link href="<?php echo base_url('asset/css/fullcalendar.print.css'); ?>" media='print' />
     <link href="<?php echo base_url('asset/css/bootstrapValidator.min.css') ?>" rel="stylesheet" />
     <link href="<?php echo base_url('asset/css/bootstrap-colorpicker.min.css') ?>" rel="stylesheet" />
     <link href="<?php echo base_url('asset/css/bootstrap-timepicker.min.css') ?>" rel="stylesheet" />
	 <script src="<?php echo base_url('asset/js/moment.min.js') ?>"></script>
    <script type="text/javascript" src= "<?php echo base_url('asset/js/bootstrapValidator.js') ?>"></script>
    <script type="text/javascript" src= "<?php echo base_url('asset/js/bootstrapValidator.min.js') ?>"></script>
	<script src="<?php echo base_url('asset/js/fullcalendar.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/bootstrap-colorpicker.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/bootstrap-timepicker.min.js') ?>"></script>
	
	<script>
	$(function(){
		var currentDate; // Holds the day clicked when adding a new event
		var currentEvent; // Holds the event object when editing an event
		$('#color').colorpicker(); // Colopicker
		$('#time').timepicker({
			minuteStep: 5,
			showInputs: false,
			disableFocus: true,
			showMeridian: false
		});  // Timepicker
		// Fullcalendar
		$('#calendar').fullCalendar({
			timeFormat: 'H(:mm)',
			header: {
				left: 'prev, next, today',
				center: 'title',
				right: 'month, basicWeek, basicDay'
			},
			// Get all events stored in database
			events: '<?php echo base_url('Administrator/getEvents') ?>',
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
			// Handle Existing Event Click
			eventClick: function(calEvent, jsEvent, view) {
				// Set currentEvent variable according to the event clicked in the calendar
				currentEvent = calEvent;
				// Open modal to edit or delete event
				modal({
					// Available buttons when editing
					buttons: {
						delete: {
							id: 'delete-event',
							css: 'btn-danger',
							label: 'Delete'
						},
						update: {
							id: 'update-event',
							css: 'btn-success',
							label: 'Update'
						}
					},
					title: 'Edit Event "' + calEvent.title + '"',
					event: calEvent
				});
			}
		});
		// Prepares the modal window according to data passed
		function modal(data) {
			// Set modal title
			$('.modal-title').html(data.title);
			// Clear buttons except Cancel
			$('.modal-footer button:not(".btn-default")').remove();
			// Set input values
			$('#title').val(data.event ? data.event.title : '');
			
			if(!data.event){
				var today = currentDate;
				var today2 = currentDate;
			}
			else{
				var start = data.event.start;
				var coba = new Date(start);
				var day = ("0"+coba.getDate()).slice(-2);
				var month = ("0"+coba.getMonth()+1).slice(-2);
				
				var today = coba.getFullYear()+"-"+(month)+"-"+(day);
				
				var end = data.event.end;
				var coba = new Date(end);
				var day = coba.getDate()-1;
				var day1 = ("0"+day).slice(-2);
				var month = ("0"+coba.getMonth()+1).slice(-2);
				
				var today2 = coba.getFullYear()+"-"+(month)+"-"+(day1);
			}
			
			$('#times').val(today);
			$('#timee').val(today2);
			$('#description').val(data.event ? data.event.description : '');
			$('#color').val(data.event ? data.event.color : '#3a87ad');
			// Create Butttons
			$.each(data.buttons, function(index, button){
				$('.modal-footer').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>')
			})
			//Show Modal
			$('.modal').modal('show');
		}
		// Handle Click on Add Button
		$('.modal').on('click', '#add-event',  function(e){
			if(validator(['title', 'description'])) {
				$.post("<?php echo base_url('Administrator/addEvent') ?>", {
					title: $('#title').val(),
					description: $('#description').val(),
					color: $('#color').val(),
					start: $('#times').val(),
					end: $('#timee').val()
				}, function(result){
					$('.modal').modal('hide');
					$('#calendar').fullCalendar("refetchEvents");
				});
			}
		});
		// Handle click on Update Button
		$('.modal').on('click', '#update-event',  function(e){
			if(validator(['title', 'description'])) {
				$.post("<?php echo base_url('Administrator/updateEvent') ?>", {
					id: currentEvent._id,
					title: $('#title').val(),
					description: $('#description').val(),
					start: $('#times').val(),
					end: $('#timee').val()
				}, function(result){
					$('.modal').modal('hide');
					$('#calendar').fullCalendar("refetchEvents");
				});
			}
		});
		// Handle Click on Delete Button
		$('.modal').on('click', '#delete-event',  function(e){
			$.get("<?php echo base_url('Administrator/deleteEvent/');echo "/" ?>" + currentEvent._id, function(result){
				$('.modal').modal('hide');
				$('#calendar').fullCalendar("refetchEvents");
			});
		});
		// Get Formated Time From Timepicker
		function getTime() {
			var time = $('#time').val();
			return (time.indexOf(':') == 1 ? '0' + time : time) + ':00';
		}
		// Dead Basic Validation For Inputs
		function validator(elements) {
			var errors = 0;
			$.each(elements, function(index, element){
				if($.trim($('#' + element).val()) == '') errors++;
			});
			if(errors) {
				$('.error').html('Please insert title and description');
				return false;
			}
			return true;
		}
	});
	</script>
	<style>
		body {
			margin: 40px 10px;
			padding: 0;
			font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
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
			max-width: 900px;
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
</head>
<body style="padding-top: 10px;">

<div class="container">

	<ul class="nav navbar-nav navbar-right">
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $nama_log; ?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo base_url('administrator/ganti_password'); ?>">Ganti Password</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url('administrator/keluar'); ?>">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</ul>
	
	<h1><?php echo $title ?></h1>
	
	<div class="col-md-3">
	<ul class="nav nav-pills nav-stacked">
	<div class="panel-group" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><li><a data-toggle="collapse" data-parent="#accordion" href="#informasi"><span class="glyphicon glyphicon-list"></span> Informasi</a></li></h4>
			</div>
			<div id="informasi" class="panel-collapse collapse">
				<div class="panel-body">
					<li><a href="<?php echo base_url('administrator'); ?>" class="active"><span class="glyphicon glyphicon-book"></span> Informasi Administrator</a></li>
				</div>
			</div>
		</div>
<?php
	if($level_user!=3 and $level_user!=4){
?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><li><a data-toggle="collapse" data-parent="#accordion" href="#administrasi"><span class="glyphicon glyphicon-list"></span> Kelola Administrasi Sekolah</a></li></h4>
			</div>
			<div id="administrasi" class="panel-collapse collapse">
				<div class="panel-body">
					<li><a href="<?php echo base_url('administrator/edit_profilsekolah'); ?>" ><span class="glyphicon glyphicon-book"></span> Pengaturan Profil Sekolah</a></li><br>
					<li><a href="<?php echo base_url('administrator/edit_visimisi'); ?>" ><span class="glyphicon glyphicon-list-alt"></span> Pengaturan Visi Misi Sekolah</a></li><br>
					<li><a href="<?php echo base_url('administrator/input_profiljurusan'); ?>" ><span class="glyphicon glyphicon-file"></span> Kelola Profil Jurusan</a></li><br>
					<li><a href="<?php echo base_url('administrator/input_unitkerja'); ?>" ><span class="glyphicon glyphicon-print"></span> Kelola Unit Kerja</a></li><br>
					<li><a href="<?php echo base_url('administrator/input_ekstrakulikuler'); ?>" ><span class="glyphicon glyphicon-tower"></span> Kelola Data Ekstrakurikuler</a></li>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><li><a data-toggle="collapse" data-parent="#accordion" href="#kepegawaian"><span class="glyphicon glyphicon-list"></span> Kelola Data Kepegawaian</a></li></h4>
			</div>
			<div id="kepegawaian" class="panel-collapse collapse">
				<div class="panel-body">
					<li><a href="<?php echo base_url('administrator/input_jabatan'); ?>" ><span class="glyphicon glyphicon-briefcase"></span> Kelola Data Jabatan</a></li><br>
					<li><a href="<?php echo base_url('administrator/input_kepegawaian'); ?>" ><span class="glyphicon glyphicon-star"></span> Kelola Data Pegawai</a></li><br>
					<li><a href="<?php echo base_url('administrator/input_user'); ?>" ><span class="glyphicon glyphicon-user"></span> Pengaturan Pengguna</a></li>
				</div>
			</div>
		</div>
<?php
	}
	if($level_user!=4){
?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><li><a data-toggle="collapse" data-parent="#accordion" href="#berita"><span class="glyphicon glyphicon-list"></span> Kelola Kabar dan Berita</a></li></h4>
			</div>
			<div id="berita" class="panel-collapse collapse in">
				<div class="panel-body">
					<li><a href="<?php echo base_url('administrator/input_kategoriartikel'); ?>" ><span class="glyphicon glyphicon-align-center"></span> Kelola Kategori Artikel</a></li><br>
					<li><a href="<?php echo base_url('administrator/input_infoppdb'); ?>" ><span class="glyphicon glyphicon-bell"></span> Kelola Info PPDB</a></li><br>
					<li><a href="<?php echo base_url('administrator/olah_berita'); ?>" ><span class="glyphicon glyphicon-list-alt"></span> Kelola Berita, Artikel, dan Bursa Kerja</a></li><br>
					<li><a href="<?php echo base_url('administrator/input_agenda'); ?>" ><span class="glyphicon glyphicon-calendar"></span> Kelola Agenda</a></li><br>
					<li><a href="<?php echo base_url('administrator/input_galeri'); ?>" ><span class="glyphicon glyphicon-picture"></span> Kelola Galeri</a></li><br>
				</div>
			</div>
		</div>
<?php
	}
	if($level_user!=3 and $level_user!=4){
?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><li><a data-toggle="collapse" data-parent="#accordion" href="#akademik"><span class="glyphicon glyphicon-list"></span> Kelola Data Akademik</a></li></h4>
			</div>
			<div id="akademik" class="panel-collapse collapse">
				<div class="panel-body">
					<li><a href="<?php echo base_url('administrator/input_strukturkurikulum'); ?>" ><span class="glyphicon glyphicon-upload"></span> Upload Struktur Kurikulum</a></li><br/>
					<li><a href="<?php echo base_url('administrator/input_silabus'); ?>" ><span class="glyphicon glyphicon-folder-close"></span> Upload Silabus</a></li><br/>
					<li><a href="<?php echo base_url('administrator/input_other'); ?>" ><span class="glyphicon glyphicon-plus"></span> Upload File Download</a></li>
				</div>
			</div>
		</div>
<?php
	}
	if($level_user!=3){
?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><li><a data-toggle="collapse" data-parent="#accordion" href="#absensi"><span class="glyphicon glyphicon-list"></span> Kelola Absensi</a></li></h4>
			</div>
			<div id="absensi" class="panel-collapse collapse">
				<div class="panel-body">
					<li><a href="<?php echo base_url('administrator/input_kelas'); ?>" ><span class="glyphicon glyphicon-plus"></span> Kelola Kelas </a></li><br/>
					<li><a href="<?php echo base_url('administrator/siswa'); ?>" ><span class="glyphicon glyphicon-plus"></span> Kelola Siswa</a></li><br/>
				</div>
			</div>
		</div>
<?php
	}
	if($level_user!=3 and $level_user!=4){
?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><li><a data-toggle="collapse" data-parent="#accordion" href="#lainnya"><span class="glyphicon glyphicon-list"></span> Data Lainnya</a></li></h4>
			</div>
			<div id="lainnya" class="panel-collapse collapse">
				<div class="panel-body">
					<li><a href="<?php echo base_url('administrator/lihat_feedback'); ?>" ><span class="glyphicon glyphicon-comment"></span> Feedback</a></li>
				</div>
			</div>
		</div>
<?php
	}
?>	
	</div>
	</ul>
	</div>

	<div class="col-md-9">
		<div style="width:100%; float:left; border:1px solid;">
			<div class="col-xs-12">
				<div class="col-xs-12">
				<br/>
					<div class="row clearfix">
						<div class="col-md-12 column">
								<div id='calendar'></div>
						</div>
					</div>
				<br/>
				</div>
				<div class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<h4 class="modal-title"></h4>
							</div>
							<div class="modal-body">
								<div class="error"></div>
								<form class="form-horizontal" id="crud-form">
									<div class="form-group">
										<label class="col-md-4 control-label" for="title">Title</label>
										<div class="col-md-4">
											<input id="title" name="title" type="text" class="form-control input-md" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" for="times">Time Start</label>
										<div class="col-md-4 input-append bootstrap-timepicker">
											<input id="times" name="times" type="date" class="form-control input-md" />
										</div>
									</div> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="timee">Time End</label>
										<div class="col-md-4 input-append bootstrap-timepicker">
											<input id="timee" name="timee" type="date" class="form-control input-md" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" for="description">Description</label>
										<div class="col-md-4">
											<textarea class="form-control" id="description" name="description"></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" for="color">Color</label>
										<div class="col-md-4">
											<input id="color" name="color" type="text" class="form-control input-md" readonly="readonly" />
											<span class="help-block">Click to pick a color</span>
										</div>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html