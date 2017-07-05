<!DOCTYPE html>
<html lang="en">
    <head>
		<!-- Standard Meta -->
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<title>Admin SMK BPI</title>
		
		<!--CSS-->
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/packaged/css/semantic.css');?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/examples/homepage.css');?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugin/packaged/css/custom.css');?>">
		
		
		<!--Java Script-->
		<script src="<?php echo base_url('plugin/packaged/javascript/semantic.js');?>"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
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
    <body>
		<div class="wrapper-login">
			<?php echo form_open("administrator/proses_auth", "class='form-horizontal' role='form'"); ?>
			<?php echo $this->session->flashdata('notification'); ?>
			<div class="ui green form segment">
				<h1>Login Admin</h1>
				<div class="field">
					<label>Username</label>
					<div class="ui left labeled icon input">
					  <input name="username" type="text" required autofocus>
					  <i class="user icon"></i>
					  <div class="ui corner label">
						<i class="icon asterisk"></i>
					  </div>
					</div>
				</div>
				<div class="field">
					<label>Password</label>
					<div class="ui left labeled icon input">
					  <input name="password" type="password" required>
					  <i class="lock icon"></i>
					  <div class="ui corner label">
						<i class="icon asterisk"></i>
					  </div>
					</div>
				</div>
				
				<?php echo form_submit("login", "Login", "class='ui green submit button'"); ?>
				<br/><br/>
				<font color="red"></font>
			</div>
			<?php echo form_close(); ?>
			</form>
		</div>
	</body>
</html>