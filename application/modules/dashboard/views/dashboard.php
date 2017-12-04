<?php
 
$pesan ='';
$time  = date('Hi');
if($time < 1200)
	$pesan ="Good morning";
else if($time<=1400)
	$pesan='Good Afternoon';
elseif($time<=1800)
	$pesan='A Good Afternoon';
elseif($time<=2400)
	$pesan='Good night';
?>

<header class="jumbotron hero-spacer">
	<h1>Welcome... </h1>
	
	<p><?php echo $pesan." ".str_replace("|"," ",$this->session->userdata('real_name')); ?>, The following are your activities that we summarize</p>
</header>
<?php
	if($this->session->userdata('level')==USER_PARTNER){
	?>
	
<div class="col-lg-3 col-md-6">
	<div class="panel panel-green">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-3">
					<i class="fa fa-tasks fa-5x"></i>
				</div>
				<div class="col-xs-9 text-right">
					<!--<div class="huge"><?php echo $open_awb; ?></div>-->
					<div class="huge"><?php echo "0"; ?></div>
					<!-- <div><?php echo lang('dash_open_awab'); ?></div> -->
					<div><?php echo "Open Request"; ?></div>
				</div>
			</div>
		</div>
		<a href="<?php echo site_url('shipment/request/index'); ?>">
			<div class="panel-footer">
				<span class="pull-left"><?php echo lang('dash_view_dtl'); ?></span>
				<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
</div>
	<?php
	}
	?>
<!--
<div class="col-lg-3 col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-3">
					<i class="fa fa-tasks fa-5x"></i>
				</div>
				<div class="col-xs-9 text-right">
					<div class="huge">12</div>
					<div>New Tasks!</div>
				</div>
			</div>
		</div>
		<a href="#">
			<div class="panel-footer">
				<span class="pull-left">View Details</span>
				<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
</div>

<div class="col-lg-3 col-md-6">
	<div class="panel panel-green">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-3">
					<i class="fa fa-tasks fa-5x"></i>
				</div>
				<div class="col-xs-9 text-right">
					<div class="huge">12</div>
					<div>New Tasks!</div>
				</div>
			</div>
		</div>
		<a href="#">
			<div class="panel-footer">
				<span class="pull-left">View Details</span>
				<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
</div>

<div class="col-lg-3 col-md-6">
	<div class="panel panel-yellow">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-3">
					<i class="fa fa-tasks fa-5x"></i>
				</div>
				<div class="col-xs-9 text-right">
					<div class="huge">12</div>
					<div>New Tasks!</div>
				</div>
			</div>
		</div>
		<a href="#">
			<div class="panel-footer">
				<span class="pull-left">View Details</span>
				<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
</div>

<div class="col-lg-3 col-md-6">
	<div class="panel panel-red">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-3">
					<i class="fa fa-tasks fa-5x"></i>
				</div>
				<div class="col-xs-9 text-right">
					<div class="huge">12</div>
					<div>New Tasks!</div>
				</div>
			</div>
		</div>
		<a href="#">
			<div class="panel-footer">
				<span class="pull-left">View Details</span>
				<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
</div>
-->
