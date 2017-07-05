<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?> - <?php echo $nama_log; ?></title>
	 <!-- Standard Meta -->
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	
	 <!-- Site Properities -->
	<title>Admin SMK BPI</title>

	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css'>

	<!--CSS-->
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/packaged/css/semantic.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/examples/homepage.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/packaged/css/custom.css');?>">
	
	<!--Java Script-->
	<script src="<?php echo base_url('plugin/packaged/javascript/semantic.js');?>"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
	
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-collapse.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-transition.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-dropdown.js');?>"></script>
	
	<!-- load bootstrap css -->
	<link href="<?php echo base_url('asset/css/bootstrap.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-theme.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-responsive.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-responsive.min.css');?>" rel="stylesheet">
	
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
	
	<h1>Menu Administrator</h1>
	
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
			<div class="top-header">
				<div class="wrapper">
					<div class="ui grid">
						<div class="row">
							<div class="three wide column">
								
							</div>
							<div class="thirteen wide column">
								<div class="ui inverted menu ratakanan">
								   <a href="<?php echo base_url('administrator/olah_berita');?>" class="item">
									<i class="book icon"></i> Olah Berita
								  </a>
								  <a href="<?php echo base_url('administrator/olah_artikel');?>" class="active item">
									<i class="pencil icon"></i> Olah Artikel
								  </a>
						  <a href="<?php echo base_url('administrator/olah_bursa_kerja');?>" class="item">
							<i class="pencil icon"></i> Olah Bursa Kerja
						  </a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="wrapper bottomabit upabit">
				<div class="ui grid">
					<div class="row">
						<div class="eleven wide column">
							<div class="ui segment">
								<h2><?php echo $artikel->judul_artikel;?></h2>
								<?php if($artikel->gambar_utama!=""){ ?>
									<img width="100%" src="<?php echo base_url('asset/images/'.$artikel->gambar_utama);?>"><br/>
								<?php } ?>
								<?php echo $artikel->artikel;?>
								<br/>
								<p>
									<i class="user icon"></i> Diposkan oleh : <?php echo $artikel->nama_user;?> |
									<i class="book icon"></i> Kategori : <?php echo $artikel->kategori_artikel;?> |
									<i class="calendar icon"></i> Pada : <?php echo $artikel->tgl_posting;?>
								</p>
							</div>
						</div>
						<div class="five wide column">
							<div class="ui segment">
								<h1>Aksi</h1>
								<table>
									<tr>
										<td>
											<a href="<?php echo base_url('administrator/edit_artikel/'.$artikel->id_artikel.'/'.$artikel->tgl_posting);?>" class="ui blue left labeled icon button">
											  <i class="edit icon"></i>
											  Edit Artikel
											</a>
										</td>
									</tr>
									<tr>
										<td><br/>
											<a data-toggle="modal" href="#artikel<?php echo $artikel->id_artikel; ?>" class="btn btn-info btn-xs"  title="hapus">
											  <i class="trash icon"></i>
											  Hapus Artikel
											</button>
										</td>
									</tr>
									<tr>
										<td><br/>
											<a href="<?php echo base_url('administrator/olah_artikel');?>" class="ui green left labeled icon button" href="">
											  <i class="left arrow icon"></i>
											  Kembali
											</a>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div class="modal fade" id="artikel<?php echo $artikel->id_artikel; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">Hapus "<?php echo $artikel->judul_artikel; ?>"?</h4>
								</div>
								<div class="modal-footer">
									<a href="<?php echo base_url('administrator/hapus_artikel')."/".$artikel->id_artikel; ?>" class="btn btn-danger btn-xs" title="Hapus"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
				$('.ui.modal')
				  .modal('attach events', '.test.button', 'show')
				;
			</script>
		</div>
	</div>
</div>
	</body>
</html>