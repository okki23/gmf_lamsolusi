<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?><!DOCTYPE html>
<html>
<head>
<title><?php echo $template['title']; ?></title>
<?php echo $template['metadata']; ?>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap.simplex.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>themes/default/css/style.css">
<link rel="shortcut icon" href="<?php echo $this->config->base_url();?>themes/default/images/icon.png" type="image/x-icon">
</head>
<body id="html-body-login">
<div id="wrapper">
	<div class="container">
		<div id="header" style="text-align:center">
			<img src="<?php echo $this->config->base_url();?>themes/default/images/logo.png" alt="Logo">
		</div>
		<div id="main">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Login</h3>
				</div>
				<div class="panel-body">
					<?php 
					$alert_message = $this->session->flashdata('alert_message');
					$alert_type = $this->session->flashdata('alert_type');
					echo $alert_message == '' ? '' : '<div class="alert alert-'.$alert_type.'"><button type="button" class="close" data-dismiss="alert">&times;</button>
					<p>'.$alert_message.'</p>
					</div><script>$(".alert").bind("close", function(){$(this).addClass("fade out");});$(".alert").alert();</script>';
					?>
					<?php echo $template['body']; ?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
