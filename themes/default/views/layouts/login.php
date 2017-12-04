<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?><!DOCTYPE html>
<html>
<head>
<title><?php echo $template['title']; ?></title>
<?php echo $template['metadata']; ?>
<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap.paper.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>themes/default/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>assets/css/style4.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/animate.css"  />

<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url();?>assets/js/modernizr.custom.86080.js"></script>

<link rel="shortcut icon" href="<?php echo $this->config->base_url();?>themes/default/images/icon.png" type="image/x-icon">
</head>
<style>
.container{
	position: relative;
}
</style>

<body id="html-body-login">
<ul class="cb-slideshow" style="list-style:none;">
            <li><span>Image 01</span><div><h3>&nbsp;</h3></div></li>
            <li><span>Image 02</span><div><h3>&nbsp;</h3></div></li>
            <li><span>Image 03</span><div><h3>&nbsp;</h3></div></li>
            <li><span>Image 04</span><div><h3>&nbsp;</h3></div></li>
            <li><span>Image 05</span><div><h3>&nbsp;</h3></div></li>
            <li><span>Image 06</span><div><h3>&nbsp;</h3></div></li>
        </ul>
<?php 
	$animate=array("bounce","flash","pulse","bounceInDown","bounceInLeft","bounceInRight","fadeInLeft","flipInY");
	$random_animate=array_rand($animate,2);
?>		
<div id="wrapper">
	<div class="container">
		<div id="header" style="text-align:center" class="animated <?php echo $animate[$random_animate[0]]; ?>">
			<img src="<?php echo $this->config->base_url();?>themes/default/images/logo.png" alt="Logo">
		</div>
		<div id="main" class="animated <?php echo $animate[$random_animate[1]]; ?>">
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
