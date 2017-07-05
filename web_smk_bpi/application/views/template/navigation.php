 <nav class="navbar navbar2">
		<div class="container-fluid">
			<div class="navbar-header">
			<a class="navbar-brand" href="#"></a>
			 <ul class="nav navbar-nav">
				<li><a href="<?php echo base_url();?>crud">Info Lelang</a></li>
				<li><a href="<?php echo base_url();?>crud/tender_kerja/<?php echo $this->session->userdata('id_user');?>">Tender yang dikerjakan</a></li>
				
			</ul>
			</div>
			<br/>
			<a style="float: right;" href="<?php echo base_url().'auth/logout';?>" class="btn btn-danger" role="button">Logout</a>
		</div>
</nav>