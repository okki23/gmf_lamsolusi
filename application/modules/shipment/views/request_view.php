<?php $timestamp = time();?>
<nav class="navbar navbar-default  no-margin" role="navigation" style="padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;">
	<div class="navbar-left">
		<div class="btn-group">
			<?php
				echo'<button class="btn btn-info navbar-btn " id="distribute-'.$timestamp.'"><i class="glyphicon glyphicon-pencil"></i> '.lang('btn_dst_send').' </button> ';
			?>
		</div>
	</div>
	<div class="navbar-right">
		<button id="reload-<?php echo $timestamp; ?>" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-refresh"></i></button>
	</div>
</nav>

<div style=' padding-top:15px;'>
	<div id="info-request-<?php echo $timestamp; ?>"></div>
</div>

<script id="info-request-row-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">

	#if(forwarder_name !=''){#
		<tr class="bg-success text-white">
	#}else{#
		<tr>
	#}#
		<td style=" padding: 5px; text-align:center;">
			<input type="checkbox" class='requestId' name="requestId[]" value="#: id #">
		</td>
		<td style=" padding: 5px;">#: id #</td>
		<td style=" padding: 5px;">#: nama_partner #</td>
		<td style=" padding: 5px;">#: date #</td>
		<td style=" padding: 5px;">#: forwarder_name #</td>
		<td style=" padding: 5px;">#: request_type #</td>
		<td style=" padding: 5px;">#: origin_name #</td>
		<td style=" padding: 5px;">#: dest_name #</td>
		<td style=" padding: 5px;">#: shipment_mode #</td>
		<td style=" padding: 5px;">#: inco_term #</td>
		<td style=" padding: 5px;">#: special_request #</td>
	</tr>
</script>


<div id="Modal-distribute-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('form_dst_title'); ?></h4>
      </div>
	  <form class="form-horizontal" id='form-distribute-<?php echo $timestamp; ?>' action='<?php echo site_url('shipment/proses'); ?>' method='POST'>
		  <div class="modal-body">
				<div class="form-group">
					<label class="col-sm-3 control-label" for=""><?php echo lang('form_dst_req_no'); ?> :</label>
					<div class="col-sm-9">
						<textarea name='requestid_all' class='requestid_all form-control' readonly='readonly'></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" for=""><?php echo lang('form_dst_fwd'); ?> :</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="forwarder" id="forwarder-name" class="form-control" placeholder="Forwarder" readonly>
							<span class="input-group-btn">
								<button type="button" id="find_forwarder" class="find btn btn-primary"><?php echo lang('btn_src'); ?></button>
							</span>
						</div>
					</div>
				</div>
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





<script>
var record=0;
$(document).ready(function(){
	var ds_request = new kendo.data.DataSource({
		transport: {
			read: {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('shipment/get'); ?>',
			}
		},
		schema: {
			parse: function(response){
				return response.data;
			},
		},
		pageSize: 100,

	});

	$('#info-request-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_request,
		filterable: true,
		sortable: true,
		//pageable: true,
		pageable: true,
		scrollable: true,
		dataBinding: function() {
		  record = (this.dataSource.page() -1) * this.dataSource.pageSize();
		},
		rowTemplate: kendo.template($("#info-request-row-<?php echo $timestamp; ?>").html()),
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
				filterable: false,
				title:"<input id='myCheckbox' type='checkbox' onClick='toggle(this)' /> All<br/>",
				width: 50,
			},
			{field:"id",width:150,title:"<?php echo lang('tbl_dst_req_no'); ?>"},
			{field:"nama_partner",width:300,title:"<?php echo lang('tbl_dst_shp_name'); ?>"},
			{field:"date",width:150,title:"<?php echo lang('tbl_dst_req_date'); ?>",filterable: false},
			{field:"forwarder_name",width:150,title:"<?php echo lang('tbl_dst_fwd'); ?>"},
			{field:"request_type",width:100,title:"<?php echo lang('tbl_dst_req_type'); ?>",filterable: false},
			{field:"origin_name",width:100,title:"<?php echo lang('tbl_dst_origin'); ?>",filterable: false, },
			{field:"dest_name",width:150,title:"<?php echo lang('tbl_dst_dest'); ?>",filterable: false, },
			{field:"shipment_mode",width:150,title:"<?php echo lang('tbl_dst_shpmod'); ?>",filterable: false},
			{field:"inco_term",width:100,title:"<?php echo lang('tbl_dst_incoterm'); ?>",filterable: false, },
			{field:"special_request",width:300,title:"<?php echo lang('tbl_dst_special'); ?>",filterable: false, },
		]
	});

	$('#reload-<?php echo $timestamp; ?>').click(function(){
		ds_request.read();
	});

	$('#distribute-<?php echo $timestamp; ?>').click(function(){
		var txt;
		var checkedVals = $('.requestId:checkbox:checked').map(function() {
			return this.value;
		}).get();

		if(checkedVals !=''){
			var requestId= checkedVals.join(",");
			$('#Modal-distribute-<?php echo $timestamp; ?>').modal('show');
			$('.requestid_all').val(requestId);
		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});

	kendoWindow = $("<div />").kendoWindow({
		title: "<?php echo lang('window_src'); ?>",
		width: "500px",
		height: "450px",
		resizable: false,
		modal: true,
	});

	$('#find_forwarder').click(function(){
		kendoWindow.data("kendoWindow")
			.content($("#detail-nasabah").html())
			.center().open();

		var ds_find = new kendo.data.DataSource({
				transport: {
					read: {
						type:"POST",
						dataType: "json",
						url: '<?php echo site_url('master/forwarder/get'); ?>',
					}
				},
				schema: {
					parse: function(response){
						return response.data;
					},
				},
				pageSize: 100,
			});

		kendoWindow.find('.myGrid').kendoGrid({
			dataSource: ds_find,
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
			dataBound: function(e){
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
					template: '<button  onClick="selectItem(this.id);" id="#: id #-#: nama_forwrder #" class="pilih btn btn-xs btn-primary">PILIH</button>',
				},{field:"id",title:"<?php echo lang('tbl_fwd_id'); ?>"},
				{field:"nama_forwrder",title:"<?php echo lang('tbl_fwd_name'); ?>"},
			]
		});
	});

	$('#form-distribute-<?php echo $timestamp; ?>').submit(function(e){
		e.preventDefault();
		$.ajax({
			url:$(this).attr('action'),
			data:$(this).serialize(),
			type:'POST',
			dataType:'json',tail:1,
			beforeSend:function(){
				$('#pesan').addClass('loader2');
			},
			success:function(res){
				$('#pesan').html(res.messages);
				if(res.status){
					$('#Modal-distribute-<?php echo $timestamp; ?>').modal('hide');
					$('#form-distribute-<?php echo $timestamp; ?> input[name=forwarder]').val('');
					$('#form-distribute-<?php echo $timestamp; ?> textarea[name=requestid]').val('');
					ds_request.read();
				}
			}
		}).done(function(){
			$('#pesan').removeClass('loader2');
			setTimeout(function(){
				$("#pesan").html("");
			}, 3000);
		});
	});

});

function selectItem(id){
	$("#forwarder-name").val(id);
	kendoWindow.data("kendoWindow").close();
}

function toggle(source) {
  checkboxes = document.getElementsByClassName('requestId');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<script id="detail-nasabah" type="text/x-kendo-template">
	<div class="myGrid"></div>
</script>
