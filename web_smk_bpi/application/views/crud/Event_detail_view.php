<body>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Detail Timeline</h4></div>
	<table id="myTable" class="table table-striped table-hover tablesorter" cellspacing="0">
		<tr>
			<td>Judul</td>
			<td>:</td>
			<td><?php echo $event->judul;?></td>
		</tr>
		<tr>
			<td>Tanggal Mulai</td>
			<td>:</td>
			<td><?php echo $event->tgl_mulai;?></td>
		</tr>
		<tr>
			<td>Tanggal Akhir</td>
			<td>:</td>
			<td><?php echo $event->tgl_akhir;?></td>
		</tr>
		<tr>
			<td>Deskripsi</td>
			<td>:</td>
			<td><?php echo $event->deskripsi;?></td>
		</tr>
	</table>
</div>
<a class="btn btn-primary" href="<?php echo base_url();?>crud/edit_event/<?php echo $event->id_timeline;?>">Edit</a>
<a class="btn btn-danger" href="<?php echo base_url();?>crud/delete_event/<?php echo $event->id_timeline;?>" onClick="return confirm('Hapus dari Timeline?')">Delete</a>
<a class="btn btn-success"href="<?php echo base_url();?>crud/event_selesai/<?php echo $event->id_timeline;?>">Event Selesai</a>
</body>