<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $template['title']; ?></title>
<?php echo $template['metadata']; ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>assets/css/kendo.common.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>assets/css/kendo.material.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>assets/css/redmond/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap.simplex.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>themes/default/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>assets/css/kendo.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>assets/css/kendo.common-bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>assets/css/dashboard.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>assets/css/wickedpicker.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>assets/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/dropzone/dropzone.min.css"  />

<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/kendo.all.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-show-password.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/msg_box.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/wickedpicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dropzone/dropzone.min.js"></script>

</head>
<body>
<div id="header" class="navbar navbar-default" role="banner">
	<div class="container">
		<div class="navbar-header">
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?php echo $this->config->base_url();?>" id="logo" class="navbar-brand white"></a>
		</div>
		<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
			<ul class="nav navbar-nav">
				<?php
				$iclass=false;
				foreach($this->config->item('list_menu') as $link=>$caption){
					if($iclass==false && uri_string()==$link){
						$iclass=true;
						$aclass='active';
					}else{
						$aclass='';
					}
					$user = $this->session->userdata('level');
					if(in_array($user,$caption[1])){
						if(!isset($caption[2])){
							echo '<li class="'.$aclass.'">'.anchor($link,$caption[0]).'</li>';
						}else{
							echo '<li class="dropdown '.$aclass.' '.($caption[0]==''?'visible-md visible-lg':'').'">'.anchor('#',$caption[0].'<span class="sr-only">Toggle Dropdown</span> <b class="caret"></b>',' class="dropdown-toggle" data-toggle="dropdown"').'
							<ul class="dropdown-menu">';
							foreach($caption[2] as $slink=>$scaption){
								if(in_array($user,$scaption[1])){
									echo '<li>'.anchor($slink,$scaption[0]).'</li>';
								}
							}
							echo '</ul></li>';
							if($caption[0]==''){
								foreach($caption[2] as $slink=>$scaption){
									if(in_array($user,$scaption[1])){
										echo '<li class="'.$aclass.' hidden-md hidden-lg">'.anchor($slink,$scaption[0]).'</li>';
									}
								}
							}
						}
					}
				}
				?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<?php echo anchor('#',str_replace("|"," ",$this->session->userdata('real_name')).' <b class="caret"></b>',' class="dropdown-toggle" data-toggle="dropdown"');?>
					<ul class="dropdown-menu">
						<li><?php echo anchor('user/password','Ganti Password'); ?></li>
						<li><?php echo anchor('user/log/out','Log Out'); ?></li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
</div>
<div id="wrapper">
	<div class="container">
		<div id="main">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $template['title']; ?></h3>
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
<script>
	kendo.culture("de-DE");
	 var todayDate = kendo.toString(kendo.parseDate(new Date()), 'yyyy-MM-dd');
	$(".datepicker").kendoDatePicker({
		format: "yyyy-MM-dd",
		value:todayDate
	});

	$('.timepicker').wickedpicker({
		twentyFour: true,
		showSeconds: true,
	});

	function numberWithCommas(x) {
		x = x.toString();
		var pattern = /(-?\d+)(\d{3})/;
		while (pattern.test(x))
			x = x.replace(pattern, "$1,$2");
		return x;
	}
</script>
<style>
.loader2 {
  border: 5px solid #f3f3f3;
  border-radius: 50%;
  border-top: 5px solid #3498db;
  width: 30px;
  height: 30px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
