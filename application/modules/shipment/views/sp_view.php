<?php $timestamp = time();?>
<nav class="navbar navbar-default  no-margin" role="navigation" style="padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;">
	<div class="navbar-left">
		<div class="btn-group">
			<?php
				if(in_array($this->session->userdata('level'), array(USER_GMF,USER_GMF_IMPORT))){
					echo'<button class="btn btn-success navbar-btn " id="generatesp-'.$timestamp.'"><i class="glyphicon glyphicon-pencil"></i> '.lang('btn_gsp_generate').' </button> ';
					echo'<button class="btn btn-warning navbar-btn " id="print-'.$timestamp.'"><i class="glyphicon glyphicon-print"></i> '.lang('btn_gsp_print').' </button> ';
				}

				if(in_array($this->session->userdata('level'), array(USER_GMF_RECEIVING,USER_GMF)))
					echo'<button class="btn btn-info navbar-btn " id="confirmsp-'.$timestamp.'"><i class="glyphicon glyphicon-pencil"></i> '.lang('btn_gsp_confirm').' </button> ';
			?>
		</div>
	</div>
	<div class="navbar-right">
		<button id="reload-<?php echo $timestamp; ?>" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-refresh"></i></button>
	</div>
</nav>

<div style=' padding-top:15px;'>
	<div id="info-sp-<?php echo $timestamp; ?>"></div>
</div>

<script id="info-sprow-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">

	#if(status =='2'){#
		<tr class="bg-success text-white" data-uid="#: sp_id #">
	#}else{#
		<tr data-uid="#: sp_id #">
	#}#
		<td style=" padding: 5px; text-align:center;">
			<input type="checkbox" class="spid" name="spid[]" value="#: sp_id #">
		</td>
		<td style=" padding: 5px;">
			<a href="javascript:void(0)" onclick="$(this).getAwb();" data-id="#: sp_id #"><strong>#: sp_id #</strong>
		</td>
		<td style=" padding: 5px;">#: date #</td>
		<td style=" padding: 5px;"> </td>
		<td style=" padding: 5px;">#: delivery_to #</td>
		<td style=" padding: 5px;">#if(status==1){# Open #}else{# Close #}#</td>
		<td style=" padding: 5px;"> </td>
	</tr>
</script>


<div id="Modal-sp-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?php echo lang('form_gsp_title'); ?></h4>
			</div>
			<form class="form-horizontal" id='form-sp-<?php echo $timestamp; ?>' action='<?php echo site_url('shipment/generatesp_add'); ?>' method='POST'>
				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_gsp_date'); ?> :</label>
						<div class="col-sm-9">
							<input type='text' name='date' class='datepicker form-control' value='<?php echo date('Y-m-d'); ?>'/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_gsp_ata_date'); ?> :</label>
						<div class="col-sm-9">
							<input type='text' name='ata' class='form-control'/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_gsp_delivery'); ?> :</label>
						<div class="col-sm-9">
							<input type='text' name='delivery' class='form-control'/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_gsp_awb_no'); ?> :</label>
						<div class="col-sm-9">
							<div class="input-group">
								<span class="input-group-btn">
									<button type="button" id="awb_cari_dialog" class="find btn btn-primary"><?php echo lang('btn_src'); ?></button>
								</span>
								<input type="text" name="awb" id="awb" class="form-control" placeholder="Awb">
								<span class="input-group-btn">
									<button type="button" id="awb_find" class="find btn btn-primary"><?php echo lang('btn_add_awb'); ?></button>
								</span>
							</div>
						</div>
					</div>

					<div class="col-sm-12">
						<fieldset>
							<legend><?php echo lang('form_gsp_blok_detail'); ?>:</legend>
						</fieldset>
						<div id="awbsp-<?php echo $timestamp; ?>">&nbsp;</div>
					</div>
					<div style='clear:both;'>&nbsp;</div>
				</div>
				<div class="modal-footer">
					<div style='float:left' id="pesan"></div>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('btn_close'); ?></button>
					<button type="submit" class="btn btn-primary" ><?php echo lang('btn_proses'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="Modal-spconfirm-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?php echo lang('form_gsp_title'); ?><span id="spnumber" ></span></h4>
			</div>
			<form class="form-horizontal" id='form-spconfirm-<?php echo $timestamp; ?>' action='<?php echo site_url('shipment/sp_confirm_proses'); ?>' method='POST'>
				<input type='hidden' name='sp_id'>
				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_gsp_awb_no'); ?> :</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="text" name="awb_find_text" id="awb_find_text" onkeyup="$(this).findCekedAwb()" class="form-control">
								<span class="input-group-btn">
									<button type="button" id="awb_find_btn" onclick="$(this).findCekedAwb()" class="find btn btn-primary"><?php echo lang('btn_src'); ?> </button>
								</span>
							</div>
						</div>
					</div>
					<table class="table table-hover table-bordered">
						<thead>
						  <tr>
							<th>No</th>
							<th>AWB</th>
							<th>ATA Date</th>
							<th>BC16 Number</th>
							<th>BC16 Date</th>
							<th>Receipt</th>
						  </tr>
						</thead>
						<tbody class='body_awb'>

						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<div style='float:left' id="pesan-<?php echo $timestamp; ?>"></div>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('btn_close'); ?></button>
					<button type="submit" class="btn btn-primary" ><?php echo lang('btn_proses'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>


<script>
var record=0;
$(document).ready(function(){

	var ds_awb = new kendo.data.DataSource({
		transport: {
			read: {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('shipment/get_awb_sp'); ?>',
			}
		},
		schema: {
			parse: function(response){
				return response.data;
			},
		},
		pageSize: 100,
	});

	var ds_sp = new kendo.data.DataSource({
		transport: {
			read: {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('shipment/get_sp'); ?>',
			}
		},
		schema: {
			parse: function(response){
				return response.data;
			},
		},
		pageSize: 100,
	});

	$('#awbsp-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_awb,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: false,
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
		dataBinding: function() {
		  record = (this.dataSource.page() -1) * this.dataSource.pageSize();
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
			{title:"Aksi",width:50,filterable: false,template: '<a href="javascript:void(0)" onclick="$(this).delete();" data-id="#: no #"><i class="glyphicon glyphicon-trash"></i></a>',},
			{field:"awb",width:150,title:"<?php echo lang('tbl_gsp_number'); ?>",filterable: false},
			{field:"ata_date",width:100,title:"<?php echo lang('tbl_gsp_date'); ?>",filterable: false},
			{field:"bc_number",width:100,title:"<?php echo lang('tbl_gsp_bcno'); ?>r",filterable: false},
			{field:"bc_date",width:100,title:"<?php echo lang('tbl_gsp_bcdate'); ?>",filterable: false},
		]
	});



	$('#info-sp-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_sp,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: true,
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
		dataBinding: function() {
		  record = (this.dataSource.page() -1) * this.dataSource.pageSize();
		},
		rowTemplate: kendo.template($("#info-sprow-<?php echo $timestamp; ?>").html()),
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
			{
				title:"<input id='myCheckbox' type='checkbox' onClick='toggle(this)' /> All<br/>",
				width:20,filterable: false,
				template: '<input type="checkbox" class="spid" name="spid[]" value="#: sp_id #">'
			},
			{field:"sp_id",width:100,title:"<?php echo lang('tbl_gsp_number'); ?>",filterable: false},
			{field:"date",width:100,title:"<?php echo lang('form_gsp_date'); ?>    ",filterable: false},
			{field:"delivery_to",width:100,title:"  Kilo/Colli ",filterable: false},
			{field:"delivery_to",width:100,title:"<?php echo lang('form_gsp_delivery'); ?>",filterable: false},
			{field:"status",width:100,title:"<?php echo lang('form_gsp_status'); ?>",filterable: false},
			{field:"status",width:100,title:"Received Date",filterable: false},
		]
	});

	$('#awb_find').click(function(){
		$.ajax({
			url:'<?php echo site_url('shipment/add_awb_sp'); ?>',
			data:$('#form-sp-<?php echo $timestamp; ?>').serialize(),
			dataType:'json',
			type:'POST',
			tail:1,
			success:function(res){
				if(res.status){
					ds_awb.read();
					$('#form-sp-<?php echo $timestamp; ?> input[name=awb]').val('');
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

	$.fn.delete=function() {
		var no = $(this).data('id');
		$.ajax({
			url:'<?php echo site_url('shipment/delete_awb_sp'); ?>',
			data:'id='+no,
			dataType:'json',
			type:'POST',
			tail:1,
			success:function(res){
				if(res.status){
					ds_awb.read();
				}else
					$('#pesan').html(res.messages);
			}
		}).done(function(){
			$('#pesan').removeClass('loader2');
			setTimeout(function(){
				$("#pesan").html("");
			}, 3000);
		});
	}

	$('#generatesp-<?php echo $timestamp; ?>').click(function(){
		$('#Modal-sp-<?php echo $timestamp; ?>').modal('show');
	});

	$('#reload-<?php echo $timestamp; ?>').click(function(){
		ds_sp.read();
	});


	$('#print-<?php echo $timestamp; ?>').click(function(){
		var checkedVals = $('.spid:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals.length ==1){
			var printId= checkedVals.join(",");
			$.post('<?php echo site_url('shipment/sp_enc'); ?>',{id:printId},function(res){
				window.open('<?php echo site_url('shipment/sp_print'); ?>/'+res,'_blank');
			});
		}else if(checkedVals.length >1){
			msg_box('Select Only One data',['btnOK'],'Info!');
		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});



	$("#form-sp-<?php echo $timestamp; ?>").submit(function(e){
		e.preventDefault();
		$.ajax({
			url:$(this).attr('action'),
			data:$(this).serialize(),
			dataType:'json',
			type:'POST',
			tail:1,
			success:function(res){
				if(res.status){
					ds_awb.read();
					ds_sp.read();
					$('#form-sp-<?php echo $timestamp; ?> input[name=awb]').val('');
					$('#form-sp-<?php echo $timestamp; ?> input[name=date]').val('');
					$('#form-sp-<?php echo $timestamp; ?> input[name=ata]').val('');
					$('#form-sp-<?php echo $timestamp; ?> input[name=delivery]').val('');

					msg_box(res.messages+", Cetak SP sekarang...?",[{'btnYES':function(){
						$(this).trigger('closeWindow');
						$.post('<?php echo site_url('shipment/sp_enc'); ?>',{id:res.spid},function(response){
							window.open('<?php echo site_url('shipment/sp_print'); ?>/'+response,'_blank');
						});
					}},'btnNO'],'Konfirmasi');
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

	$('#confirmsp-<?php echo $timestamp; ?>').click(function(e){
		e.preventDefault();
		var rowtable ='';
		var checkedVals = $('.spid:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals.length ==1){
			var printId= checkedVals.join(",");

			$('#spnumber').html(' [ '+printId+' ]');
			$('#form-spconfirm-<?php echo $timestamp; ?> [name=sp_id]').val(printId);

			$.post('<?php echo site_url('shipment/shipment_cek_status_sp'); ?>',{spid:printId},function(resData){
					if(resData=='TRUE'){
						$('#Modal-spconfirm-<?php echo $timestamp; ?>').modal('show');
						$.ajax({
							url:'<?php echo site_url('shipment/sp_confirm'); ?>',
							data:'id='+printId,
							dataType:'json',
							type:'POST',
							tail:1,
							success:function(res){
								$('.body_awb').html('');
								var rowItem = res.data;
								var no=1;
								for (i = 0; i < rowItem.length; i++) {
									var cheked = '';
									if(rowItem[i].sp_cek==1)
										cheked = 'checked';
									rowtable += '<tr>';
									rowtable += '<td>'+no+'</td>';
									rowtable += '<td>'+rowItem[i].awb+'</td>';
									rowtable += '<td>'+rowItem[i].ata_date+'</td>';
									rowtable += '<td>'+rowItem[i].bc_no+'</td>';
									rowtable += '<td>'+rowItem[i].bc_date+'</td>';
									rowtable += '<td><input type="checkbox" class="spcek_awbid" name="spcek_awbid[]" value="'+rowItem[i].awb+'" '+cheked+'></td>';
									rowtable += '</tr>';
									no++;
								}
								$('.body_awb').append(rowtable);
							}
						}).done(function(){
							$('#pesan').removeClass('loader2');
							setTimeout(function(){
								$("#pesan").html("");
							}, 3000);
						});
					}else{
						var msg 		= '<?php echo lang('msg_confirm_sp_false'); ?>';
						var msg_f		= msg.replace("-spid-", printId);
						msg_box(msg_f,['btnOK'],'Info!');
					}
			});

		}else if(checkedVals.length >1){
			msg_box('Select Only One data',['btnOK'],'Info!');
		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});

	$('#form-spconfirm-<?php echo $timestamp; ?>').submit(function(e){
		e.preventDefault();
		$.ajax({
				url:$(this).attr('action'),
				data:$(this).serialize(),
				dataType:'json',
				type:'POST',
				tail:1,
				success:function(res){
					if(res.status){
						$('#Modal-spconfirm-<?php echo $timestamp; ?>').modal('hide');
						ds_sp.read();
					}else
						$('#pesan-<?php echo $timestamp; ?>').html(res.messages);
				}
			}).done(function(){
				$('#pesan-<?php echo $timestamp; ?>').removeClass('loader2');
				setTimeout(function(){
					$("#pesan-<?php echo $timestamp; ?>").html("");
				}, 3000);
			});
	});

	$.fn.getAwb=function(){
		var reqID = $(this).data('id');
		var tr_parent = $(this).parent('td').parent('tr');
		var elmid = tr_parent.data('uid');
		if(tr_parent.hasClass('open')){
			tr_parent.removeClass('open');
			$('tr.sub_'+elmid).remove();
		}else{
			tr_parent.addClass('open');
			$.ajax({
				url: '<?php echo site_url('shipment/monitoring/get_awb'); ?>',
				data: 'spID='+reqID,
				type:'POST',
				dataType: 'html',
				beforeSend: function(){
					$(tr_parent).after('<tr class="sub_'+elmid+'"><td colspan="5" class="loader"></td><td style="display:none">&mdash;|</td></tr>');
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

	$.fn.findCekedAwb=function(){
		var awbID = $('#awb_find_text').val();
		$('#awb_find_btn').addClass('loader');

		$(":checkbox").filter(function() {
			return this.value == awbID;
		}).prop("checked", "true");

		setTimeout(function(){
			$('#awb_find_text').val('');
			$('#awb_find_btn').removeClass('loader');
		}, 1000);


	}

	kendoWindow = $("<div />").kendoWindow({
		title: "<?php echo lang('window_src'); ?>",
		width: "800px",
		height: "450px",
		resizable: false,
		modal: true,
	});

	$('#awb_cari_dialog').click(function(){
		kendoWindow.data("kendoWindow")
			.content($("#detail-nasabah").html())
			.center().open();

			var ds_find_awb = new kendo.data.DataSource({
				transport: {
					read: {
						type:"POST",
						dataType: "json",
						url: '<?php echo site_url('shipment/getClearAwb'); ?>',
					}
				},
				//group:[{field: "awb"}],
				//serverGrouping: true,
				schema: {
					parse: function(response){
						return response.data;
					},
				},
				pageSize: 100,
			});

			kendoWindow.find('.myGrid').kendoGrid({
				dataSource: ds_find_awb,
				filterable: true,
				sortable: true,
				pageable: true,
				height: "400px",
				scrollable: false,
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
					{
						title:"PILIH",
						width:20,
						template: '<button  onClick="selectItem(this.id);" id="#: awb #" class="pilih btn btn-xs btn-primary">PILIH</button>',
					},
					{field:"awb",width:200, title:"<?php echo lang('tbl_mnts_awb'); ?>"},
					{field:"awb_status",width:100,title:"<?php echo lang('tbl_mnts_status'); ?>",filterable: false, },
					{field:"type",width:100,title:"<?php echo lang('tbl_dst_req_type'); ?>",filterable: false, }
				]
			});
	});

});

function selectItem(id){
	$("#awb").val(id);
	kendoWindow.data("kendoWindow").close();
}

function toggle(source) {
  checkboxes = document.getElementsByClassName('spid');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<script id="detail-nasabah" type="text/x-kendo-template">
	<div class="myGrid"></div>
</script>
