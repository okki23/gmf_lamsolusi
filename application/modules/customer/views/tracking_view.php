<?php $timestamp = time();?>
<form class="form-horizontal" id='form-tracking-<?php echo $timestamp; ?>' action='<?php echo site_url('customer/tracking/get'); ?>' method='POST'>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="">AWB / Request Number :</label>
		<div class="col-sm-4">
			<div class="input-group">
				<input type="text" name="filter" id="" class="form-control" placeholder="AWB / Request Number">
				<span class="input-group-btn">
					<button type="submit" id="filter" class="find btn btn-primary">Reload</button>
				</span>
			</div>
		</div>
	</div>
</form>

<div style=' padding-top:15px;'>
	<div  id="info-tracking-<?php echo $timestamp; ?>"></div>
</div>


<script>
	$(document).ready(function(){
		$('#form-tracking-<?php echo $timestamp; ?>').submit(function(e){
			e.preventDefault();
			$.ajax({
				url:$(this).attr('action'),
				data:$(this).serialize(),
				type:'POST',
				beforeSend:function(){
					$('#info-tracking-<?php echo $timestamp; ?>').addClass('loader');
				},success:function(res){
					$('#info-tracking-<?php echo $timestamp; ?>').removeClass('loader');
					$('#info-tracking-<?php echo $timestamp; ?>').html(res);
				}
			});
		});
		
	});
</script>