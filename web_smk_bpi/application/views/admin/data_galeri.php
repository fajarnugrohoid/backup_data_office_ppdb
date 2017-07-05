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
	<script src="<?php echo base_url('asset/js/bootstrap-carousel.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-collapse.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-dropdown.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap-transition.js');?>"></script>
	
	<!-- load bootstrap css -->
	<link href="<?php echo base_url('asset/css/bootstrap.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-theme.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('asset/css/bootstrap-responsive.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('plugin/packaged/css/custom.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('plugin/packaged/css/semantic.css');?>" rel="stylesheet">
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
?>		</div>
	</ul>
	</div>

	<div class="col-md-9">
		<div style="width:100%; float:left; border:1px solid;">
			<div class="col-xs-12">
				<div class="col-xs-12">
					<?php echo $this->session->flashdata('notifikasi');?>
						
					<div class="wrapper tinggigaleri bottomabit">
						<div class="ui grid">
						<?php
							$i=0;
							$j=0;
							foreach($list_galeri as $g){
								if($i==0){
									$i++; ?><div class="row"><?php
								}else{
									$i++;
								}
						?>
								<div class="four wide column">
									<div class="ui segment fotogaleri">
										<a href="#<?php echo $g->id_galeri; ?>"  class="big-link" data-toggle="modal" alt="" ><img width="100%" src="<?php echo base_url('asset/img/'.$g->foto); ?>" alt=""></img></a>
										<center><a href="<?php echo base_url('administrator/edit_galeri')."/".$g->id_galeri."/". $g->tgl_posting; ?>" class="btn btn-info btn-xs" title="Ubah"><span class="glyphicon glyphicon-edit"></span></a> 
										<a data-toggle="modal" href="#hapus<?php echo $g->id_galeri; ?>" data-dismiss="modal" class="btn btn-info btn-xs" title="Hapus"><span class="glyphicon glyphicon-trash"></span></a></center>
									</div>
								</div>
							<?php
									if($i==4){
										$i=0;?></div><?php
									}
								}
								
								if($i!=5 && $i!=0){
									?></div><?php
								}
							?>
					</div>
					<div class="col-xs-12">
						<div class="pagination pagination-lg">
							<ul class="pagination">
							<?php
								echo $paginator;
							?>
							</ul>
						</div>
					</div>
				</div>
				
				<div class="col-xs-12">
				<br/>
				<hr/>
				<h2>Tambah Galeri</h2>
					
					<?php echo form_open_multipart("administrator/proses_input_galeri", "class='form-horizontal' role='form'"); ?>
					<div class="control-group">
						<label for="judul_galeri" class="control-label">Judul Galeri</label>
						<div class="controls"><?php echo form_input("judul_galeri", $this->session->flashdata('judul'), "class='form-control' id='judul_galeri' placeholder=''"); ?><span class="help-block">Hanya diperbolehkan menggunakan karakter alfabet a-z, A-Z, 0-9, - (dash), _ (underscore), dan . (titik) serta boleh terdapat spasi.</span></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="foto">Foto</label>
						<div class="controls"><input type="file" name="foto_upload"><span class="help-block"><i>format file gambar harus <b>*.png, *.jpg, *.jpeg, atau *.gif</b></i></span></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="deskripsi">Deskripsi</label>
						<div class="controls"><?php echo form_textarea('deskripsi', $this->session->flashdata('deskripsi'), 'placeholder="" id="deskripsi" class="form-control" /required'); ?></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="kategori">Kategori</label>
						<div class="controls">
						<select name="kategori">
							<?php
							if(strcmp($this->session->flashdata('id_kategori'),"")==0){
									foreach($kategori_pil as $kat){
							?>
										<option value="<?php echo $kat->id_kategori_artikel; ?>"><?php echo $kat->kategori_artikel; ?></option>
							<?php	} 
							}else{
									foreach($kategori_pil as $kat){
										if($kat->id_kategori_artikel==$this->session->flashdata('id_kategori')){?>
											<option value="<?php echo $kat->id_kategori_artikel; ?>" selected><?php echo $kat->kategori_artikel; ?></option>
							<?php 
										}else{?>
											<option value="<?php echo $kat->id_kategori_artikel; ?>"><?php echo $kat->kategori_artikel; ?></option>
							<?php		}
									}
							}?>
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
</div>
</div>
<?php
		$i=1;
		foreach($list_galeri as $list){
	?>
			<!-- Modal -->
			<div class="modal fade" id="<?php echo $list->id_galeri; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Galeri Foto</h4>
						</div>
						<div class="modal-body">
							<center><?php if($list->foto!=NULL){ ?>
							<img width="50%" src="<?php echo base_url('asset/img/'.$list->foto);?>" alt="" />
							<?php } ?></center>
							<table class="table table-hover table-responsive">
								<tr>
									<td>Judul</td>
									<td><?php echo $list->judul_galeri; ?></td>
								</tr>
								<tr>
									<td>Kategori</td>
									<td><?php echo $list->kategori_artikel; ?></td>
									
								</tr>
								<tr>
									<td>Tanggal</td>
									<td><?php echo $list->tgl_posting; ?></td>
								</tr>
								<tr>
									<td>Deskripsi</td>
									<td><?php echo $list->deskripsi; ?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="hapus<?php echo $list->id_galeri; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Hapus "<?php echo $list->judul_galeri; ?>"?</h4>
						</div>
						<div class="modal-footer">
							<a href="<?php echo base_url('administrator/hapus_galeri')."/".$list->id_galeri; ?>" class="btn btn-danger btn-xs" title="Hapus"><span class="glyphicon glyphicon-trash"></span></a>
						</div>
					</div>
				</div>
			</div>
	<?php
		$i++;
		}
	?>
</body>
</html>