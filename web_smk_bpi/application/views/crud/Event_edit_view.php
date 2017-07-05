<body>
	<div class="col-lg-4">
		<div class="panel-heading"><b>Edit Timeline</b></div>
		<?php echo form_open('crud/edit_event/'.$event->id_timeline);?>
			<input type="hidden" name="id_timeline" value="<?php echo $event->id_timeline;?>"/>
			<span>Judul </span>: <input type="text" name="judul" value="<?php echo $event->judul;?>" required/></br></br>
			<span>Tanggal Mulai </span>: <input class="date" type="text" name="tgl_mulai" value="<?php echo date('Y/m/d', strtotime($event->tgl_mulai));?>" required/></br></br>
			<span>Tanggal Akhir </span>: <input class="date" type="text" name="tgl_akhir" value="<?php echo date('Y/m/d', strtotime($event->tgl_akhir));?>" required/></br></br>
			<span>Deskripsi </span>: <textarea name="deskripsi" required><?php echo $event->deskripsi;?></textarea></br></br>
			<input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
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
	            header: {
	                left: 'prev,next today',
	                center: 'title',
	                right: 'month'
	            },
	            editable: false,
	            timeFormat: '',
	            events: [
	                <?php foreach($event_timeline as $row): ?>
	                    {
	                        title : '<?php echo $row->judul;?>',
	                        start : new Date(<?php echo date("Y, m-1, d,H,i", strtotime($row->tgl_mulai)); ?>),
	                        end : new Date(<?php echo date("Y, m-1, d+1,H,i", strtotime($row->tgl_akhir)); ?>),
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
</body>