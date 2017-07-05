<html>
	<head>
		<title>jhkjhkjhkh</title>
	</head>
	
	<body>
		<table border = 1>
			<tr>
				<td>No</td>
				<td>NIS</td>
				<td>Nama</td>
				<td>Jenis Kelamin</td>
				<td>Kelas</td>
				<td colspan = 2 align = "center">Aksi</td>
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
				<td><a href = "<?php echo site_url('absen/absensi/edit_siswa/'.$s->nis) ?>">Edit</a></td>
				<td><a href = "<?php echo site_url('absen/absensi/delete_siswa/'.$s->nis) ?>">Delete</a></td>
			</tr>
			<?php 
				$i++;} 
				echo $this->pagination->create_links();
			?>
		</table>
		<a href = "<?php echo site_url('absen/absensi/form_input') ?>">Tambah Siswa</a>
	</body>
</html>