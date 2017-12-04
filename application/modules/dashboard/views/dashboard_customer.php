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


<div class="col-lg-3 col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-3">
					<i class="fa fa-tasks fa-5x"></i>
				</div>
				<div class="col-xs-9 text-right">
					<div class="huge"><?php echo number_format($open_request); ?></div>
					<div><?php echo lang('dash_open_req'); ?></div>
				</div>
			</div>
		</div>
		<a href="<?php echo site_url('customer/request'); ?>">
			<div class="panel-footer">
				<span class="pull-left"><?php echo lang('dash_view_dtl'); ?></span>
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
					<div class="huge"><?php echo number_format($approve_request); ?></div>
					<div><?php echo lang('dash_ppro_req'); ?></div>
				</div>
			</div>
		</div>
		<a href="<?php echo site_url('customer/approve'); ?>">
			<div class="panel-footer">
				<span class="pull-left"><?php echo lang('dash_view_dtl'); ?></span>
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
					<div class="huge"><?php echo number_format($mothly_request); ?></div>
					<div><?php echo lang('dash_in_req'); ?>&nbsp;<?php echo date('F,Y'); ?></div>
				</div>
			</div>
		</div>
		<a href="<?php echo site_url('rpt/index'); ?>">
			<div class="panel-footer">
				<span class="pull-left"><?php echo lang('dash_view_dtl'); ?></span>
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
					<div class="huge"><?php echo number_format($rejected_request); ?></div>
					<div><?php echo lang('dash_rejc_req'); ?></div>
				</div>
			</div>
		</div>
		<a href="<?php echo site_url('rpt/index'); ?>">
			<div class="panel-footer">
				<span class="pull-left"><?php echo lang('dash_view_dtl'); ?></span>
				<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
</div>
