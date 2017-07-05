<html>
	<head>
		<title></title>
	</head>
	
	<body>
		<table style="font-size: 12px;" class="table table-responsive table-striped">
			<tr>
			<thead align="center">
				<th>No</th>
				<th>NIS</th>
				<th>Nama</th>
				<th>Jenis Kelamin</th>
				<th>Kelas</th>
				<th colspan = 5 align = "center">Aksi</th>
			</thead>
			</tr>
			<?php
				$i = 1;
				
				foreach($siswa as $s){ 
			?>
			<tr>
				<td><?php echo $i ?></td>
				<td><?php echo $s->nis ?></td>
				<td><?php echo $s->nama ?></td>
				<td><?php echo $s->jenis_kelamin ?></td>
				<td><?php echo $s->kelas ?></td>
				<td><a href = "<?php echo site_url('administrator/input_absen/'.$s->nis.'/1') ?>">Sakit</a></td>
				<td><a href = "<?php echo site_url('administrator/input_absen/'.$s->nis.'/2') ?>">Izin</a></td>
				<td><a href = "<?php echo site_url('administrator/input_absen/'.$s->nis.'/3') ?>">Alpha</a></td>
				<td><a href = "<?php echo site_url('administrator/input_absen/'.$s->nis.'/4') ?>">Terlambat</a></td>
				<td><a href = "#<?php echo $s->nis;?>" data-toggle="modal" alt="">Izin Pulang</a></td>
			</tr>
			<?php 
				$i++;}
				//echo $this->pagination->create_links();
			?>
		</table>
		
		<?php 
			foreach($siswa as $s){
		?>
		
			<div class="modal fade" id="<?php echo $s->nis; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 align="center" class="modal-title" id="myModalLabel">Detail</h4>
						</div>
						<?php echo form_open('Administrator/input_absen2') ?>
						<input type = "hidden" name = "nis" id = "nis" value = "<?php echo $s->nis ?>">
						<div class="modal-body">
							<div class="col-md-9">	
								NIS : <?php echo $s->nis; ?>
								<label class="radio">
									<input type="radio" name="izin" id="i" value="1">
									  Sakit
								</label>
								<label class="radio">
									  <input type="radio" name="izin" id="i" value="2">
									 Izin
								</label>
								Keterangan : 
								<input type="text" name="keterangan" />
							</div>
							<div class="col-md-9">
								<div class="col-md-1 btn-inverse" style="float: right">
									<input type="submit" name="submit" value="Submit" />
								</div>
							</div>
							
						</div>
						<?php echo form_close() ?>
							
						<div class="modal-footer">
					
						</div>
				
					</div>
				</div>
			</div>
		
		<?php
			}
		?>
		
	</body>
</html>