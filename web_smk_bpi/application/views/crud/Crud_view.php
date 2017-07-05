<html>
	<head>
		
	</head>
	
	<body>
	
		<h3>	INFO LELANG </h3>
		<div id="content">
		<div class="panel panel-default">
		

			<table id="myTable" class="table table-striped table-hover tablesorter" cellspacing="0">
				<thead>
				<tr>			
					<th>
						<div class="form-group has-feedback">
							<label for="search" class="sr-only">Search</label>
							
							<input type="text" class="form-control" name="search" id="search" placeholder="search"/>
							
						</div>
					</th>
				</tr>
				<tr>			
					<th>Nama Tender</th>
					<th>Agency</th>
					<th>Lokasi Pekerjaan</th>
					<th>Detail</th>
				</tr>
				</thead>
				<tbody id="table_content">
				<?php foreach($tender as $value){
				?>
					<tr>			
						<td><?php echo $value->nama_tender; ?></td>
						<td><?php echo $value->nama_instansi; ?></td>
						<td><?php echo $value->lokasi_pekerjaan; ?></td>
						<td>
							<a title="Detail" href="<?php echo base_url().'crud/detail_tender/'.$value->id_tender ?>" class="btn btn-primary">Detail</a>
						</td>
					</tr>
				<?php 
				}
				?>
				</tbody>
			</table>
		</div>
		<div id="pagination">
		<?php 
			if(!empty($pagination)){
				echo $pagination;
			}
		?>
		</div>
		</div>
	
	</body>
		
</html>