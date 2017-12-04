<?php $timestamp = time();?>
<form class="form-horizontal" id='form-reqrpt-<?php echo $timestamp; ?>' action='<?php echo site_url('rpt/request_submit'); ?>' method='POST'>

	<div class="form-group">
		<label class="col-sm-3 control-label" for="">Services Type:</label>
		<div class="col-sm-8">
			<input type='text' name='type' class='kendodropdown form-control' placeholder='&mdash;&mdash;Select Request Type&mdash;&mdash;' style="width: 40%;"/>
		</div>
	</div>
	
	<div class="import_export_only">
		<div class="form-group">
			<label class="col-sm-3 control-label" for="">Service Level:</label>
			<div class="col-sm-8">
				<label class="checkbox-inline"><input type="checkbox" name="cb_normal" value="Normal">&nbsp;Normal</label>
				<label class="checkbox-inline"><input type="checkbox" name="cb_aog" value="AOG">&nbsp;AOG</label>
			</div>
		</div>
		
	</div>
	
	<!--<div class="leanse">
		<div class="form-group">
			<label class="col-sm-3 control-label" for="">Filter by:</label>
			<div class="col-sm-8">
				<label class="checkbox-inline"><input type="checkbox" name="cb_incoming" value="incoming_date">&nbsp;Incoming Date</label>
				<label class="checkbox-inline"><input type="checkbox" name="cb_outgoing" value="outgoing_date">&nbsp;Outgoing Date</label>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="">Incoming / Outgoing Date:</label>
			<div class="col-sm-8">
				<input type='text' name='leanse_date_start' value='<?php echo date('Y-m-d'); ?>' class='datepicker form-control'/> s/d
				<input type='text' name='leanse_date_end' value='<?php echo date('Y-m-d'); ?>' class='datepicker form-control'/>
			</div>
		</div>
	</div> -->
	

	<div class="form-group">
		<label class="col-sm-3 control-label" for="">Request Date:</label>
		<div class="col-sm-8">
			<input type='text' name='date_start' value='<?php echo date('Y-m-d'); ?>' class='datepicker form-control'/> s/d
			<input type='text' name='date_end' value='<?php echo date('Y-m-d'); ?>' class='datepicker form-control'/>
		</div>
	</div>

	
	
	<div class="form-group">
		<label class="col-sm-3 control-label" for="">&nbsp;</label>
		<div class="col-sm-9">
			<button type="submit" class="btn btn-primary" >Proses</button>
			<?php echo anchor("rpt/request",'<button type="button" class="btn btn-default" >Reset</button>'); ?>
		</div>
		<div  style ='float:left;' id='pesan'></div>
	</div>

</form>

<div style='padding-top:15px;'>
	<div  id="info-rptreq-<?php echo $timestamp; ?>"></div>
</div>

<script>
	$(document).ready(function(){
		<?php
			$combo = array(
				array('name'=>'type', 'url'=>'app/cmb_requestType_report'),
			);
			echo $this->app->dropdown_kendo($combo);
		?>
		cmb['type'].value('-1');
		
		$('.import_export_only, .clearence_ony, .leanse, .else').hide();
		cmb['type'].bind('change',function(){
			$('.import_export_only, .clearence_ony, .leanse, .else').hide();
			var myVal =cmb['type'].value();
			$('#info-rptreq-<?php echo $timestamp; ?>').html('');
			if(myVal=='IMPORT,EXPORT') 	$('.import_export_only').show();
			if(myVal=='CUSTOM CLEARANCE') $('.clearence_ony').show();
			if(myVal=='WAREHOUSE LEASE') $('.leanse').show();
			
			if(myVal!='IMPORT,EXPORT' && myVal !='CUSTOM CLEARANCE' && myVal !='WAREHOUSE LEASE')
				$('.else').show();
		});
		
		$('#form-reqrpt-<?php echo $timestamp; ?>').submit(function(e){
			e.preventDefault();
			$.ajax({
				url:$(this).attr('action'),
				data:$(this).serialize(),
				type:'POST',
				dataType: 'html',
				beforeSend:function(){
					$('#info-rptreq-<?php echo $timestamp; ?>').html('');
					$('#info-rptreq-<?php echo $timestamp; ?>').addClass('loader');
				},
				success:function(res){
				 
					$('#info-rptreq-<?php echo $timestamp; ?>').html(res);
				}
			}).done(function(){
				$('#info-rptreq-<?php echo $timestamp; ?>').removeClass('loader');
			});
		});
	});
</script>