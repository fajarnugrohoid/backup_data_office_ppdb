<body>
<div class="panel panel-default">
    <div class="panel-heading">Event Selesai</div>
	<?php echo form_open_multipart('crud/event_selesai/'.$event->id_timeline);?>
	<input type="hidden" name="id_tender" value="<?php echo $tender->id_tender;?>"/>
	<input type="hidden" name="id_pendaftar" value="<?php echo $this->session->userdata('id_user');?>"/>
	<table id="myTable" class="table table-striped table-hover tablesorter" cellspacing="0">
		<tr>
			<td>Upload Bukti Dokumentasi</td>
			<td>:</td>
			<td>
				<input type="file" id="userfile" name="userfile"/>
				<span style="font-size: 10pt;">ekstensi yang dijinkan (file gambar & file arsip) max 10MB</span>
			</td>
		</tr>
	</table>
</div>
<input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
<?php echo form_close();?>
</body>