<html>
	<head>
		<title>Rekap Absensi Siswa</title>
		
		
	<style>
		body {
                padding: 0;
                font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
                font-size: 12px;
            }
	</style>
	
		
	</head>
	
	<body>
	
		<div class="container" style="margin-top: 100px;">
		
			
			<div class="col-md-12">
			
				<h2 align="center"> Rekap Absensi </h2>
				<hr/>
				<?php 
				
				if ($jumlah>0){ ?>
					<table class="table">
					<thead>
						<tr>
							<th>Sakit</th>
							<th>Izin</th>
							<th>Alpha</th>
							<th>Terlambat</th>
							<th>Aksi</th>
						</tr>
					</thead>
						<?php
							$i = 1;
							foreach($siswa as $s){ 
						?>
						<tr>
							<td><?php echo $s->sakit ?></td>
							<td><?php echo $s->ijin ?></td>
							<td><?php echo $s->alpha ?></td>
							<td><?php echo $s->terlambat ?></td>
							<td> <a href="#tes" data-toggle="modal" alt=""> Lihat Detail </a> </td>
						</tr>
						<?php 
							$i++;}
						?>
					</table>
					
					<? }else{ ?>
					
											
						<h4 align="center"> Tidak ada daftar absen </h4>
					
					
					<?php } ?>
					
					
									
					<div class="modal fade" id="tes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 align="center" class="modal-title" id="myModalLabel">Detail</h4>
								</div>
								<div class="modal-body">
									
									<table class="table">
										<thead>
											<tr>
												<th> No. </th>
												<th> Tanggal </th>
												<th> Keterangan </th>
											</tr>
										</thead>
										
						<?php 
						$i=1;
						foreach ($detail as $list){ 
								
						?>
											<tr>
												<td> <?php echo $i; ?> </td>
												<td> <?php echo $list->tanggal; ?> </td>
												<td> <?php echo $list->keterangan; ?> </td>
											</tr>
											
						<?php 
							$i++;
						} 
						?>
												
									</table>
									
								</div>
					
						
								<div class="modal-footer">
				
								</div>
			
							</div>
						</div>
					</div>
					
			
			
			</div>
					
		</div>
	</body>
</html>