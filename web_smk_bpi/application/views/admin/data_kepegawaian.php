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

	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url('plugin/modal/reveal.css');?>">
	<script type="text/javascript" src="<?php echo base_url('plugin/modal/jquery.reveal.js');?>"></script>
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
	<?php
		//mapel
	?>

	<div class="col-md-9">
		<div style="width:100%; float:left; border:1px solid;">
			<div class="col-xs-12">
				<div class="col-xs-12">
				<?php echo $this->session->flashdata('notifikasi'); ?>
				<table class="table table-hover table-responsive">
					<tr>
						<th>No</th>
						<th>Foto</th>
						<th>NIP</th>
						<th>Nama</th>
						<th>Jabatan</th>
						<th>No. Kontak</th>
						<th>&nbsp;</th>
					</tr>
					
					<?php
						$i=$j;
						foreach ($list_kepegawaian as $list){
					?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php 	if(strcmp($list->foto,"")==0){
												echo "&nbsp;";
											}else{ ?>
												<img height="100px" width="100px" src="<?php echo base_url('asset/img/'.$list->foto); ?>" class="hvr-shutter-out-horizontal" data-toggle="modal" href="#<?php echo $list->id_pegawai; ?>" alt=""/></td>
								<?php		}
								?>
								
								<td><?php echo $list->nip; ?></td>
								<td><?php echo $list->nama; ?></td>
								<td><?php echo $list->jabatan; ?></td>
								<td><?php echo $list->no_kontak; ?></td>
								<td><a data-toggle="modal" href="#<?php echo $list->id_pegawai; ?>" class="btn btn-info btn-xs" title="Detail"><span class="glyphicon glyphicon-eye-open"></span></a> <a data-toggle="modal" href="#hapus<?php echo $list->id_pegawai; ?>" data-dismiss="modal" class="btn btn-info btn-xs" title="Hapus"><span class="glyphicon glyphicon-trash"></span></a></td>
							</tr>
					<?php	
						$i++;
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
				</div>

				<hr/>
				<h2>Tambah data Kepegawaian</h2>
				
					<?php echo form_open_multipart("administrator/proses_input_kepegawaian", "class='form-horizontal' role='form'");?>
					<div class="control-group">
						<label class="control-label" for="foto">Upload Foto</label>
						<div class="controls"><input type="file" name="foto"></input><span class="help-block"><i>format file gambar harus <b>*.png, *.jpg, *.jpeg, atau *.gif</b></i></span></div>
					</div>
					<div class="control-group">
						<label for="nip" class="control-label">NIP/NUPTK</label>
						<div class="controls"><?php echo form_input("nip", "", "type='number' class='form-control' id='nip' placeholder='NIP/NUPTK'"); ?>
						<span class="help-block">Isikan NIP/NUPTK kepegawaian, jika belum silakan dikosongkan, akan otomatis menjadi N/A.</span></div>
					</div>
					<div class="control-group">
						<label for="nama" class="control-label">Nama</label>
						<div class="controls"><?php echo form_input("nama", "", "class='form-control'' id='nama' placeholder='Nama Pegawai' /required"); ?><span class="help-block">Isikan nama lengkap pegawai beserta gelar akademik, contoh: Drs. Tung Thung Seng, M.Pd</span></div>
					</div>
					<div class="control-group">
						<label for="jenis_kelamin" class="control-label">Jenis Kelamin</label>&nbsp;&nbsp;&nbsp;
						<input type="radio" name="jenis_kelamin" value="L" selected>&nbsp;Laki-Laki</input>&nbsp;&nbsp;
						<input type="radio" name="jenis_kelamin" value="P">&nbsp;Perempuan</input>
						<span class="help-block"></span>
					</div>
					<div class="control-group">
						<label class="control-label" for="alamat">Alamat</label>
						<div class="controls"><?php echo form_textarea('alamat', "", 'class="form-control" rows="3" placeholder="Masukan alamat" id="alamat" class="input-xxlarge" /required'); ?></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="jabatan">Jabatan</label>
						<div class="controls">
						<select name="jabatan">
						<?php
							if(strcmp($jabatan_peg,"0")===0){
								foreach($jabatan_pil as $jab){
						?>
									<option value="<?php echo $jab->id_jabatan; ?>"><?php echo $jab->jabatan; ?></option>
						<?php
								}
							}else{
								$i=1;
								foreach($jabatan_peg as $peg){
									$array_peg[$i]=$peg->jabatan;
									$i++;
								}
								foreach($jabatan_pil as $jab){
									if($jab->status==0){
						?>
										<option value="<?php echo $jab->id_jabatan; ?>"><?php echo $jab->jabatan; ?></option>
						<?php	
									}elseif($jab->status==1){
										$a=0;
										for($j=1;$j<=count($array_peg);$j++){
											if(strcmp($jab->jabatan,$array_peg[$j])!==0){
												$a++;
											}
											if($a==count($array_peg)){
						?>
												<option value="<?php echo $jab->id_jabatan; ?>"><?php echo $jab->jabatan; ?></option>
						<?php
											}
										}
									}
								}
							}
						?>
						
						</select>
						<span class="help-block">Pilih Jabatan yang sesuai dengan Anda.</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="no_kontak">Nomor HP/Telpon</label>
						<div class="controls"><?php echo form_input('no_kontak', "", 'type="number" placeholder="Masukan No Telp/HP" id="no_kontak" class="form-control" /required'); ?></div>
						<span class="help-block">Isikan No Kontak, dengan format: 085723546538</span>
					</div>
					<div class="control-group">
						<label class="control-label" for="sosmed">Sosial Media</label>
						<div class="controls"><?php echo form_input('sosmed', "", 'placeholder="Masukan Sosial Media" id="sosmed" class="form-control"'); ?><span class="help-block">Isikan Sosial Media yang dimiliki, dengan contoh format: instagram.com/solution.varit atau twitter.com/var_IT</span></div>
					</div>
					<div class="control-group">
						<label class="control-label" for="mapel">Mata Pelajaran</label>
						<div class="controls"><?php echo form_input('mapel', "", 'placeholder="Masukan Mata Pelajaran" id="mapel" class="form-control" /required'); ?><span class="help-block">Isikan Mata Pelajaran yang diampuh</span></div>
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
		<?php
		$i=1;
		foreach ($list_kepegawaian as $list){
		?>
		<!-- Modal -->
		<div class="modal fade" id="<?php echo $list->id_pegawai; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">Data Pegawai</h4>
					</div>
					<div class="modal-body">
						<table class="table table-hover table-responsive">
							<tr>
								<td colspan="3"><center>
								<?php if($list->foto!=NULL){ ?>
									<img width="50%" src="<?php echo base_url('asset/img/'.$list->foto);?>" alt="" />
								<?php } ?>
								</center></td>
							</tr>
							<tr><td>Nama</td><td>:</td><td><?php echo $list->nama; ?></td></tr>
							<tr><td>NIP/NUPTK</td><td>:</td><td><?php echo $list->nip; ?></td></tr>
							<tr><td>Jabatan</td><td>:</td><td><?php echo $list->jabatan; ?></td></tr>
							<tr><td>Jenis Kelamin</td><td>:</td><td><?php echo $list->jenis_kelamin; ?></td></tr>
							<tr><td>Kontak</td><td>:</td><td><?php echo $list->no_kontak; ?></td></tr>
							<tr><td>Alamat</td><td>:</td><td><?php echo $list->alamat; ?></td></tr>
							<tr><td>Sosial Media</td><td>:</td><td><?php echo $list->sosmed; ?></td></tr>
							<tr><td>Mata Pelajaran</td><td>:</td><td><?php echo $list->mata_pelajaran; ?></td></tr>
						</table>
					</div>
					<div class="modal-footer">
						<a href="<?php echo base_url('administrator/edit_kepegawaian')."/".$list->id_pegawai; ?>" class="btn btn-info btn-xs" title="Ubah"><span class="glyphicon glyphicon-edit"></span></a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="hapus<?php echo $list->id_pegawai; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">Hapus "<?php echo $list->nama; ?>"?</h4>
					</div>
					<div class="modal-footer">
						<a href="<?php echo base_url('administrator/hapus_kepegawaian')."/".$list->id_pegawai; ?>" class="btn btn-danger btn-xs" title="Hapus"><span class="glyphicon glyphicon-trash"></span></a>
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