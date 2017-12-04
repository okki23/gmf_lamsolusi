<?php $timestamp = time();?>
<form class="form-horizontal" id='form-userrpt-<?php echo $timestamp; ?>' action='<?php echo site_url('rpt/customer'); ?>' method='POST'>

	<div class="form-group">
		<label class="col-sm-4 control-label" for="">Request Date Start:</label>
		<div class="col-sm-6">
			<input type='text' name='tgl_req_start' value='<?php echo date('Y-m')."-1"; ?>' class='datepicker form-control'/>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4 control-label" for="">Request Date End:</label>
		<div class="col-sm-6">
			<input type='text' name='tgl_req_end' value='<?php echo date('Y-m-d'); ?>' class='datepicker form-control'/>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4 control-label" for="">Request Status:</label>
		<div class="col-sm-6">
			<input type='text' name='status' class='kendodropdown form-control' placeholder='&mdash;&mdash;All Status&mdash;&mdash;'/>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4 control-label" for="">&nbsp;</label>
		<div class="col-sm-2">
			<button type="reset" class="btn btn-default" >Reset</button>
			<button type="submit" class="btn btn-primary" >Proses</button>
		</div>
		<div  style ='float:left;' id='pesan'></div>
	</div>

</form>

<div style='padding-top:15px;'>
	<div  id="info-userrpt-<?php echo $timestamp; ?>"></div>
</div>

<script>
	$(document).ready(function(){
		<?php
			$combo = array(
				array('name'=>'status', 'url'=>'app/request_status'),
			);
			echo $this->app->dropdown_kendo($combo);
		?>
		cmb['status'].value('-1');

		var tgl_req_start	= $('input[name=tgl_req_start]').val();
		var tgl_req_end = $('input[name=tgl_req_end]').val();
		var status = '-1';

		$.ajax({
			url : $('#form-userrpt-<?php echo $timestamp; ?>').attr('action'),
			data: {"tgl_req_start":tgl_req_start, "tgl_req_end":tgl_req_end, "status":status},
			dataType: 'html',
			type:'POST',
			tail:1,
			beforeSend:function(){
				$('#info-userrpt-<?php echo $timestamp; ?>').html('');
				$('#info-userrpt-<?php echo $timestamp; ?>').addClass('loader');
			},
			success:function(res){
				$('#info-userrpt-<?php echo $timestamp; ?>').html(res);
			}
		}).done(function(){
			$('#info-userrpt-<?php echo $timestamp; ?>').removeClass('loader');
		});

		$('#form-userrpt-<?php echo $timestamp; ?>').submit(function(e){
			e.preventDefault();
			$.ajax({
				url : $(this).attr('action'),
				data: $(this).serialize(),
				dataType: 'html',
				type:'POST',
				tail:1,
				beforeSend:function(){
					$('#info-userrpt-<?php echo $timestamp; ?>').html('');
					$('#info-userrpt-<?php echo $timestamp; ?>').addClass('loader');
				},
				success:function(res){
					$('#info-userrpt-<?php echo $timestamp; ?>').html(res);
				}
			}).done(function(){
				$('#info-userrpt-<?php echo $timestamp; ?>').removeClass('loader');
			});
		});
	});
</script>
