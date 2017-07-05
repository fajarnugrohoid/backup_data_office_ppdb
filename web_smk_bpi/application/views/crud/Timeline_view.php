<html>
	<head>
		<title> TIMELINE </title>
		<!--  Custom Style -->
		<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" />
	</head>
	<body>
		<div class="col-lg-4">
			<div class="panel-heading"><b><h3>Tambah Rencana Timeline</h3></b></div>
			<?php echo form_open('crud/isi_timeline');?>
				<input type="hidden" name="id_tender" value="<?php //echo $tender->id_tender;?>"/>
				 <div class="form-group">
					<span>Judul </span>: <input type="text" name="judul" class="form-control" required="required" />
				</div>
				<div class="form-group">
					<span>Tanggal Mulai </span>: <input class="date" type="text" name="tgl_mulai"  class="form-control" required="required"/>
				</div>
				<div class="form-group">
					<span>Tanggal Akhir </span>: <input class="date" type="text" name="tgl_akhir"  class="form-control" required="required"/>
				</div>
				<div class="form-group">
					<span>Deskripsi </span>: <textarea name="deskripsi"  class="form-control" required="required"></textarea>
				</div>
				<div class="form-group">
					<input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
				</div>
			<?php echo form_close();?>
		</div>
		<div class="col-lg-8">
			<div id="calendar"></div>
		</div>
		<script>
			$(document).ready(function() {
				var date = new Date();
				var d = date.getDate();
				var m = date.getMonth();
				var y = date.getFullYear();

				$('#calendar').fullCalendar({
			  //   	eventClick: function(event) {

					//     if (event.url) {
		   //                  $('#detail_event')
		   //                      .load(event.url)
		   //                      .dialog({
		   //                          width: 500,
		   //                          modal:true
		   //                      });
		   //                  return false;
		   //              }

					// },
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month'
					},
					editable: false,
					timeFormat: '',
					events: [
						<?php foreach($event as $row): ?>
							{
								title : '<?php echo $row->judul;?>',
								start : new Date(<?php echo date("Y, m-1, d,H,i", strtotime($row->tgl_mulai)); ?>),
								end : new Date(<?php echo date("Y, m-1, d+1,H,i", strtotime($row->tgl_akhir)); ?>),
								<?php if($row->tgl_realisasi == ""){?>
									url : '<?php echo base_url();?>crud/detail_event/<?php echo $row->id_timeline;?>',
								<?php 
									}else{
										echo "backgroundColor : '#449D44',";
									}
								?>
								allDay : false
							},
						<?php endforeach; ?>
					],
				});

				$(".date").datepicker({
					format: 'yyyy/mm/dd',
					startDate: '<?php echo $tender->tgl_mulai;?>',
					endDate: '<?php echo $tender->tgl_akhir;?>'
				});
			});
		</script>
		<div id="detail_event"></div>
	</body>
</html>