<!DOCTYPE html>
<html lang="en">
    <head>
		<title><?php echo $title; ?> - <?php echo $nama_log; ?></title>
		<!-- Standard Meta -->
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<title></title>
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script type="text/javascript" src="<?php echo base_url('asset/js/jquery.min.js');?>"></script>

		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.min.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-collapse.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-dropdown.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-transition.js');?>"></script>
		
		<!--CSS-->
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/packaged/css/semantic.css');?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/examples/homepage.css');?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/packaged/css/custom.css');?>">

		<!--Java Script-->
		<script src="<?php echo base_url('plugin/packaged/javascript/semantic.js');?>"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
		
		
		<!-- load bootstrap css -->
		<link href="<?php echo base_url('asset/css/bootstrap.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('asset/css/bootstrap.min.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('asset/css/bootstrap-theme.min.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('asset/css/bootstrap-responsive.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('asset/css/bootstrap-responsive.min.css');?>" rel="stylesheet">
		
		<!--Tiny MCE-->
		<!--<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>-->
		<script src="<?php echo base_url('asset/tinymce/js/tinymce/tinymce.min.js');?>"></script>
		<script src="<?php echo base_url('asset/tinymce/js/tinymce/tinymce.jquery.dev.js');?>"></script>
		<script src="<?php echo base_url('asset/tinymce/js/tinymce/tinymce.jquery.js');?>"></script>
		<script src="<?php echo base_url('asset/tinymce/js/tinymce/tinymce.jquery.min.js');?>"></script>
		<script src="<?php echo base_url('asset/tinymce/js/tinymce/tinymce.js');?>"></script>
		<script src="<?php echo base_url('asset/tinymce/js/tinymce/tinymce.dev.js');?>"></script>
		<script src="<?php echo base_url('asset/tinymce/js/tinymce/plugins/table/plugin.dev.js');?>"></script>
		<script src="<?php echo base_url('asset/tinymce/js/tinymce/plugins/paste/plugin.dev.js');?>"></script>
		<script src="<?php echo base_url('asset/tinymce/js/tinymce/plugins/spellchecker/plugin.dev.js');?>"></script>
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
						  <a href="<?php echo base_url('administrator/olah_artikel');?>" class="item">
							<i class="pencil icon"></i> Olah Artikel
						  </a>
						  <a href="<?php echo base_url('administrator/olah_bursa_kerja');?>" class="active item">
							<i class="pencil icon"></i> Olah Bursa Kerja
						  </a>
						  
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wrapper bottomabit">
		<div class="ui segment">
			<div class="row">
				<div class="sixteen wide column">
					<?php require_once('tinymce.php') ?>
					<?php echo validation_errors(); ?>
					<?php echo form_open_multipart('administrator/proses_edit_bursa_kerja');?>
					<div class="ui form">
						<h1>Ubah Bursa Kerja</h1>
						<div class="field">
							<label>Judul</label>
							<input type="text" name="judul" value="<?php echo $bursa_kerja->judul_bursa_kerja;?>" /required>
							<span class="help-block">Hanya diperbolehkan menggunakan karakter alfabet a-z, A-Z, 0-9, - (dash), _ (underscore), dan . (titik) serta boleh terdapat spasi.</span>
						</div>
						<div class="field">
							<label>Ubah Gambar Utama</label>
							<input type="file" name="gambar_utama">
							<span class="help-block"><i>format file gambar harus <b>*.png, *.jpg, *.jpeg, atau *.gif</b></i></span>
						</div>
						<div class="field">
							<label>Isi</label>
							<textarea name="isi"><?php echo $bursa_kerja->bursa_kerja;?></textarea>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="tanggal_baru" value="1"> Perbaharui Tanggal Posting<span class="help-block">tanggal dapat berganti jika ada perubahan isi dalam data</span>
							</label>
						</div>
						<input type="hidden" name="id_bursa_kerja" value="<?php echo $bursa_kerja->id_bursa_kerja;?>">
						<input type="hidden" name="tanggal_asle" value="<?php echo $tanggal_asle;?>">
						
						<input type="submit" class="ui green submit button" value="Simpan Bursa Kerja"/><br/><br/>
						<a href="<?php echo base_url('administrator/lihat_bursa_kerja_detail/'.$bursa_kerja->id_bursa_kerja);?>">Kembali</a>
					</div>
					</form><br/>
				</div>
			</div>
		</div>
	</div>
	
	</div>
	</div>
</div>
	</body>
</html>