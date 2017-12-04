<?php $timestamp = time();?>
<nav class="navbar navbar-default  no-margin" role="navigation" style="padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;">
	<div class="navbar-left">
		<div class="btn-group">
			<?php
				//echo'<button class="btn btn-info navbar-btn " id="distribute-'.$timestamp.'"><i class="glyphicon glyphicon-pencil"></i> Distribute </button> ';
			?>
		</div>
	</div>
	<div class="navbar-right">
		<button id="reload-<?php echo $timestamp; ?>" class="btn btn-default navbar-btn" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i>"><i class="glyphicon glyphicon-refresh"></i></button>
	</div>
</nav>

<div style=' padding-top:15px;'>
	<div id="shp-monitoring-<?php echo $timestamp; ?>"></div>
</div>


<script id="shp-monitoring-row-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">
	#if(awb_status=='Clear'){#
		<tr class="bg-info" data-uid="#: awb #" >
	#}else{#
		<tr data-uid="#: awb #">
	#}#
		<?php if($this->session->userdata('level')==USER_GMF || $this->session->userdata('level')==USER_GMF_IMPORT ){ ?>
			<td style=" padding: 5px;">
				# if( eta_date == '-' || flight_schadule=='-' || flight_schadule==''){ #
					<a href="javascript:void(0)" onclick="$(this).dialogEdit_ata();" data-id="#: awb #">
						<button class="btn btn-xs btn-info"> <i class="glyphicon glyphicon-pencil"></i> Edit ATA</button>
					</a>
				#}else{#
					#if(type != 'EXPORT' && type !='DOMESTIC DISTRIBUTION'){#
						<a href="javascript:void(0)" onclick="$(this).dialogEdit();" data-id="#: awb #">
								<button class="btn btn-xs btn-primary"> <i class="glyphicon glyphicon-pencil"></i> Edit BC16</button>
						</a>
					#}else{#
						<a href="javascript:void(0)" onclick="$(this).dialogEdit_ata();" data-id="#: awb #">
							<button class="btn btn-xs btn-info"> <i class="glyphicon glyphicon-pencil"></i> Edit ATA</button>
						</a>
					#}#
				#}#
			</td>
		<?php } ?>
		<td style=" padding: 5px;">
			<a href="javascript:void(0)" onclick="$(this).getDetail();" data-id="#: awb #"><strong>#: awb #</strong>
		</td>
		<td style=" padding: 5px;">#: ata_date #</td>
		<td style=" padding: 5px;"> </td>
		<td style=" padding: 5px;">#: flight_schadule #</td>
		<?php if($this->session->userdata('level')==USER_GMF || $this->session->userdata('level')==USER_GMF_IMPORT){ ?>
			<td style=" padding: 5px;">#: bc_no #</td>
			<td style=" padding: 5px;">#: bc_date #</td>
			<td style=" padding: 5px;">
				<a href="javascript:void(0)" onclick="$(this).getinfo();" data-id="#: awb #">
						<strong>#: awb_status #</strong>
				</a>
				<div id="proper-#:awb#"></div>
			</td>

		<?php } ?>
		<td style=" padding: 5px;">#: eta_date #</td>
		<td style=" padding: 5px;">#: etd_date #</td>
		<td style=" padding: 5px;">#: estimate_flight_schadule #</td>
		<td style=" padding: 5px;">#: origin_name #</td>
		<td style=" padding: 5px;">#: dest_name #</td>
		<td style=" padding: 5px;">#: reference #</td>
	</tr>
</script>

<div id="Modal-fwd-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form class="form-horizontal" id='form-fwd-<?php echo $timestamp; ?>' action='<?php echo site_url('shipment/monitoring/proses'); ?>' method='POST'>
			<input type="hidden" name='id' id="tex_id" readonly />
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo lang('form_mnts_title'); ?> <span id="info_id">[ID : ]</span></h4>
				</div>
				<div class="modal-body">
					<div class="form-group" >
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_mnts_bcn'); ?>  :</label>
						<div class="col-sm-8">
							<input name='bc_no' class='form-control'>
						</div>
					</div>

					<div class="form-group" >
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_mnts_bcdate'); ?>  :</label>
						<div class="col-sm-8">
							<input name='bc_date' class='datepicker form-control'>
						</div>
					</div>

					<div class="form-group" >
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_mnts_stat'); ?> :</label>
						<div class="col-sm-8">
							<select name='status' id="status">
								<option value='Open'>Open</option>
								<option value='Clear'>Clear</option>
							</select>
						</div>
					</div>

					<div class="form-group" >
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_mnts_reason'); ?>  :</label>
						<div class="col-sm-8">
							<textarea name='reason' class='form-control'></textarea>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<div style='float:left' id="pesan"></div>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('btn_close'); ?></button>
					<button type="submit" class="btn btn-primary" ><?php echo lang('btn_proses'); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>


<div id="Modal-eta-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form class="form-horizontal" id='form-eta-<?php echo $timestamp; ?>' action='<?php echo site_url('shipment/monitoring/proses_ata'); ?>' method='POST'>
			<input type="hidden" name='id' id="tex_id2" readonly />
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo lang('form_mnts_title'); ?> <span id="info_id2">[ID : ]</span></h4>
				</div>
				<div class="modal-body">
					<div class="form-group" >
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_mnts_aadate'); ?> :</label>
						<div class="col-sm-8">
							<input name='ata_date' class='datepicker form-control'>
						</div>
					</div>

					<div class="form-group" >
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_mnts_addate'); ?>  :</label>
						<div class="col-sm-8">
							<input name='atd_date' class='datepicker form-control'>
						</div>
					</div>

					<div class="form-group" >
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_mnts_flight'); ?>  :</label>
						<div class="col-sm-8">
							<input name='flight' class=' form-control'>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div style='float:left' id="pesan"></div>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('btn_close'); ?></button>
					<button type="submit" class="btn btn-primary" ><?php echo lang('btn_proses'); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
var datepicker = $(".datepicker").data("kendoDatePicker");

$(document).ready(function(){
	$("#status").kendoDropDownList();
	$("#hide").hide();
	var ds_shp = new kendo.data.DataSource({
		transport: {
			read: {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('shipment/monitoring/get'); ?>',
			}
		},
		schema: {
			parse: function(response){
				return response.data;
			},
		},
		pageSize: 100,
	});

	$('#shp-monitoring-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_shp,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: true,
		resizable: true,
		rowTemplate: kendo.template($("#shp-monitoring-row-<?php echo $timestamp; ?>").html()),
		filterable: {
			extra: false,
			operators: {
				string: {
					startswith: "Like",
					eq: "=",
					neq: "!="
				},
			}
		},
		dataBound: function(e) {
			this.collapseRow(this.tbody.find("tr.k-master-row").first());
			var grid = e.sender;
			if (grid.dataSource.total() == 0) {
				var colCount = grid.columns.length;
				$(e.sender.wrapper)
					.find('tbody')
					.append('<tr class="kendo-data-row"><td colspan="' + colCount + '" class="no-data" style="text-align:center">&mdash;&mdash; Data Kosong &mdash;&mdash;</td></tr>');
			}
		},
		columns: [
			<?php if($this->session->userdata('level')==USER_GMF || $this->session->userdata('level')==USER_GMF_IMPORT){ ?>
				{title:"Aksi",width:100},
			<?php } ?>
			{field:"awb",width:200, title:"<?php echo lang('tbl_mnts_awb'); ?>"},
			{field:"ata_date",width:100,title:"<?php echo lang('tbl_mnts_ata'); ?>",filterable: false,},
			{field:"",width:100,title:"Kilo/Colli",filterable: false,},
			{field:"flight_schadule",width:200,title:"<?php echo lang('tbl_mnts_flight'); ?>",filterable: false, },
			<?php if($this->session->userdata('level')==USER_GMF || $this->session->userdata('level')==USER_GMF_IMPORT){ ?>
				{field:"bc_no",width:100,title:"<?php echo lang('tbl_mnts_bcno'); ?>",filterable: false, },
				{field:"bc_date",width:100,title:"<?php echo lang('tbl_mnts_bcdate'); ?>",filterable: false, },
				{field:"awb_status",width:100,title:"<?php echo lang('tbl_mnts_status'); ?>",filterable: false, },
			<?php } ?>
			{field:"eta_date",width:100,title:"<?php echo lang('tbl_mnts_eta'); ?>",filterable: false,},
			{field:"etd_date",width:100,title:"<?php echo lang('tbl_mnts_etd'); ?>",filterable: false,},
			{field:"estimate_flight_schadule",width:200,title:"<?php echo lang('tbl_mnts_estflight'); ?>",filterable: false, },
			{field:"origin_name",width:150,title:"<?php echo lang('tbl_mnts_origin'); ?>",filterable: false, },
			{field:"dest_name",width:150,title:"<?php echo lang('tbl_mnts_dest'); ?>",filterable: false, },
			{field:"reference",width:200,title:"<?php echo lang('tbl_mnts_ref'); ?>",filterable: false, },
		]
	});

	$('#reload-<?php echo $timestamp; ?>').click(function(){
		 var $this = $(this);
		 <?php if($this->session->userdata('level')==USER_SADMIN){ ?>
			$.ajax({
				url:'<?php echo site_url('sync'); ?>',
				data:'data=1',
				type:'POST',
				dataType:'json',tail:1,
				beforeSend:function(){
					$this.button('loading');
					//$('#pesan').html('');
					//$('#pesan').addClass('loader2');
				},
				success:function(res){
					 $this.button('reset');
					msg_box(res.messages,['btnOK'],'Info!');
				}
			}).done(function(){
				ds_shp.read();
			});
		<?php }else{ ?>
			ds_shp.read();
		<?php } ?>

	});

	$.fn.getinfo=function(){
		var element = $(this).data('id');
		$.ajax({
			url: '<?php echo site_url('shipment/monitoring/get_reason'); ?>',
			type: 'POST',
			data: 'id='+element,
			dataType: 'json',
			success: function(res) {
				$("#proper-"+element).popover({
					container: 'body',
					html: true,
					title:"AWB Number "+element,
					content: res.data[0].reason
				});
				$("#proper-"+element).popover('toggle');
			}
		});

	}


	$('#form-fwd-<?php echo $timestamp; ?>').submit(function(e){
		e.preventDefault();
		$.ajax({
			url:$(this).attr('action'),
			data:$(this).serialize(),
			type:'POST',
			dataType:'json',tail:1,
			beforeSend:function(){
				$('#pesan').html('');
				$('#pesan').addClass('loader2');
			},
			success:function(res){
				$('#pesan').html(res.messages);
				if(res.status){
					ds_shp.read();
					$('#form-fwd-<?php echo $timestamp; ?> input[name=bc_no]').val('');
					$('#form-fwd-<?php echo $timestamp; ?> input[name=bc_date]').val('');
					$('#Modal-fwd-<?php echo $timestamp; ?>').modal('hide');
				}
			}
		}).done(function(){
			$('#pesan').removeClass('loader2');
			setTimeout(function(){
				$("#pesan").html("");
			}, 3000);
		});
	});

	$('#form-eta-<?php echo $timestamp; ?>').submit(function(e){
		e.preventDefault();
		$.ajax({
			url:$(this).attr('action'),
			data:$(this).serialize(),
			type:'POST',
			dataType:'json',tail:1,
			beforeSend:function(){
				$('#pesan').html('');
				$('#pesan').addClass('loader2');
			},
			success:function(res){
				if(res.status){
					msg_box(res.messages,['btnOK'],'Info!');
					ds_shp.read();
					$("#form-eta-<?php echo $timestamp; ?> input[name=ata_date]").val('');
					$("#form-eta-<?php echo $timestamp; ?> input[name=atd_date]").val('');
					$("#form-eta-<?php echo $timestamp; ?> input[name=flight]").val('');
					$('#Modal-eta-<?php echo $timestamp; ?>').modal('hide');
				}else
					$('#pesan').html(res.messages);
			}
		}).done(function(){
			$('#pesan').removeClass('loader2');
			setTimeout(function(){
				$("#pesan").html("");
			}, 3000);
		});
	});

	$.fn.dialogEdit = function() {
		var fwdid = $(this).data('id');
		$('#Modal-fwd-<?php echo $timestamp; ?>').modal('show');
		$("#info_id").show();
		$("#info_id").html('[ '+fwdid+' ]');
		$("#tex_id").val(fwdid);
	}

	$.fn.dialogEdit_ata=function(){
		var fwdid = $(this).data('id');
		$('#Modal-eta-<?php echo $timestamp; ?>').modal('show');
		$("#info_id2").show();
		$("#info_id2").html(' [ '+fwdid+' ]');
		$("#tex_id2").val(fwdid);

		$.ajax({
			url:'<?php echo site_url('shipment/monitoring/get');?>',
			data:'awbid='+fwdid,
			type:'POST',
			dataType:'json',tail:1,
			success:function(res){
				$("#form-eta-<?php echo $timestamp; ?> input[name=ata_date]").val(res.data[0].eta_date);
				$("#form-eta-<?php echo $timestamp; ?> input[name=atd_date]").val(res.data[0].etd_date);
				$("#form-eta-<?php echo $timestamp; ?> input[name=flight]").val(res.data[0].estimate_flight_schadule);
			}
		});

	}

	$.fn.getDetail=function(){
		var reqID = $(this).data('id');
		var tr_parent = $(this).parent('td').parent('tr');
		var elmid = tr_parent.data('uid');
		if(tr_parent.hasClass('open')){
			tr_parent.removeClass('open');
			$('tr.sub_'+elmid).remove();
		}else{
			tr_parent.addClass('open');
			$.ajax({
				url: '<?php echo site_url('shipment/monitoring/get_awb_detail'); ?>',
				data: 'id='+reqID,
				type:'POST',
				dataType: 'html',
				beforeSend: function(){
					$(tr_parent).after('<tr class="sub_'+elmid+'"><td colspan="14" class="loader"></td><td style="display:none">&mdash;|</td></tr>');
				},
				success:function(result){
					$('tr.sub_'+elmid).addClass('alert-success');
					$('tr.sub_'+elmid+'>td:eq(0)').html(result);
				}
			}).done(function(){
				$('tr.sub_'+elmid+'>:eq(0)').removeClass('loader');
			});
		}
	}
});
</script>
