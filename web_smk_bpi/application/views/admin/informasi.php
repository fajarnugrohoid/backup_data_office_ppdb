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
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.min.js');?>"></script>
	
	<!-- load bootstrap css -->
	<link href="<?php echo base_url('asset/css/bootstrap.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-theme.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-responsive.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-responsive.min.css');?>" rel="stylesheet">
</head>
<body style="padding-top: 10px;">
	<div class="col-xs-12">
		<h3>Informasi Administrator</h3><hr>
		Selamat datang di halaman administrator website SMK BPI Bandung. Halaman ini digunakan untuk melakukan pengaturan terhadap konten website.
		<?php	if($level_user==3){ ?>
					<h5>Kelola Kabar dan Berita. Menu ini untuk digunakan untuk:</h5>
					<ul>
						<li>mengelola kategori artikel</li>
						<li>mengelola info PPDB</li>
						<li>mengelola Berita dan Artikel</li>
						<li>mengelola Agenda</li>
						<li>mengelola Galeri</li>
						<li>mengelola Bursa Kerja</li>
					</ul>
		<?php	}elseif($level_user==4){ ?>
					<h5>Kelola Siswa. Menu ini untuk digunakan untuk:</h5>
					<ul>
						<li>mengelola Kelas</li>
						<li>mengelola Siswa</li>
						<li>mengelola Absensi</li>
					</ul>
		<?php	}else{ ?>
					<ul>
						<li>Kelola Administrasi Sekolah<br>Menu ini digunakan untuk mengelola profil sekolah, visi dan misi, jurusan, dan unit kerja.</li>
						<li>Kelola Data Kepegawaian<br>Menu ini untuk digunakan mengelola data jabatan, data pegawai, dan pengguna.</li>
						<li>Kelola Kabar dan Berita<br>Menu ini untuk digunakan untuk mengelola artikel dan berita, galeri, agenda, info PPDB, serta bursa kerja.</li>
						<li>Kelola Data Akademik<br>Menu ini untuk digunakan untuk mengelola struktur kurikulm dan silabus.</li>
						<li>Kelola Siswa<br>Menu ini untuk digunakan untuk mengelola data kelas, siswa, dan absensi.</li>
						<li>Data Lainnya<br>Menu ini untuk digunakan untuk mengelola feedback dari pengguna.</li>
					</ul>
		<?php	} ?>
	</div>
</body>
</html