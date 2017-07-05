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
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-collapse.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-dropdown.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-transition.js');?>"></script>
	
	<!-- load bootstrap css -->
	<link href="<?php echo base_url('asset/css/bootstrap.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-theme.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-responsive.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-responsive.min.css');?>" rel="stylesheet">
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
			<div id="kepegawaian" class="panel-collapse collapse in">
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
			<div id="berita" class="panel-collapse collapse">
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
				<table class="table table-hover table-responsive">
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Username</th>
						<th>Password</th>
						<th>Level</th>
						<th>&nbsp;</th>
					</tr>
			<?php
				$i=$j;
				foreach ($list_user as $list){
					if ($list->level_user==1 and $level_user==1){
						$class="danger";
			?>
						<tr class="<?php echo $class; ?>">
							<td><?php echo $i; ?></td>
							<td><?php echo $list->nama_user; ?></td>
							<td><?php echo $list->username; ?></td>
							<td><?php echo "******************"; ?></td>
							<td><?php if ($list->level_user==1){
										echo "Admin";
									}elseif($list->level_user==2){
										echo "Outhor";
									}else{
										echo "Konstributor";
									}?></td>
							<td><a href="<?php echo base_url('administrator/edit_user')."/".$list->id_user; ?>" class="btn btn-info btn-xs" title="Ubah"><span class="glyphicon glyphicon-edit"></span></a></td>
						</tr>
			<?php
					$i++;
					}elseif($list->level_user!=1){
			?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $list->nama_user; ?></td>
							<td><?php echo $list->username; ?></td>
							<td><?php echo "******************"; ?></td>
							<td><?php if ($list->level_user==1){
										echo "Admin";
									}elseif($list->level_user==2){
										echo "Author";
									}elseif($list->level_user==3){
										echo "Kontributor";
									}elseif($list->level_user==4){
										echo "Pegawai Piket";
									}?></td>
							<td><a href="<?php echo base_url('administrator/edit_user')."/".$list->id_user; ?>" class="btn btn-info btn-xs" title="Ubah"><span class="glyphicon glyphicon-edit"></span></a> 
							<a data-toggle="modal" href="#hapus<?php echo $list->id_user; ?>" class="btn btn-info btn-xs" title="hapus"><span class="glyphicon glyphicon-trash"></span></a>
							</td>
						</tr>
						
						<div class="modal fade" id="hapus<?php echo $list->id_user; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">Hapus "<?php echo $list->username; ?>"?</h4>
								</div>
								<div class="modal-footer">
									<a href="<?php echo base_url('administrator/hapus_user')."/".$list->id_user; ?>" class="btn btn-danger btn-xs" title="Hapus"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</div>
						</div>
					</div>
			<?php
					$i++;
					}
			?>
			
			<?php
				}
			?>
				</table>
				<div class="pagination pagination-lg">
					<ul class="pagination">
					<?php
						echo $paginator;
					?>
					</ul>
				</div>

				<hr>
				<h2>Tambah data user</h2>
				<?php echo $this->session->flashdata('notification'); ?>
				<!-- form tambah mata pelajaran -->
				<?php echo form_open("administrator/proses_input_user", "class='form-horizontal' role='form'"); ?>
				<div class="control-group">
					<label for="nama_user" class="control-label">Nama user</label>
					<div class="controls"><?php echo form_input("nama_user", $this->session->flashdata('namauser'), "class='form-control' id='nama_user' placeholder='Nama user' required"); ?><span class="help-block">Isikan nama lengkap user beserta gelar akademik, contoh: Drs. Tung Thung Seng, M.Pd</span></div>
				</div>
				<div class="control-group">
					<label for="username" class="control-label">Username</label>
					<div class="controls"><?php echo form_input("username", "", "id='username' placeholder='Nama Pengguna' class='form-control' required" ); ?><span class="help-block">Username untuk login kedalam sistem. Hanya diperbolehkan menggunakan karakter alfabet a-z, A-Z, 0-9, - (dash), _ (underscore), dan . (titik) serta tidak boleh terdapat spasi.</span></div>
				</div>
				<div class="control-group">
					<label for="password" class="control-label">Password</label>
					<div class="controls"><?php echo form_password("password", "", "id='password' placeholder='Password' class='form-control' required maxlength='32'"); ?><span class="help-block">Maksimal 32 karakter.</span></div>
				</div>
				<div class="control-group">
					<label for="level" class="control-label">Level</label>
					<div class="controls">
						<select name="level" id="level">
							<option value="1">Admin</option>
							<option value="2">Author</option>
							<option value="3">Kontributor</option>
							<option value="4">Pegawai Piket</option>
						</select>
					</div>
				</div>
				<br/>
				<div class="form-action">	
					<?php echo form_submit("simpan", "Simpan Data", "class='btn btn-primary'"); ?>
					<?php echo form_reset("reset", "Bersihkan", "class='btn btn-warning'"); ?>
				</div>
				<?php echo form_close(); ?>
				<br/>
			</div>
		</div>
	</div>
</div>
</body>
</html>