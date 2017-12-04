<?php
 $timestamp = time();?>
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
	<div id="shp-req_open-<?php echo $timestamp; ?>"></div>
</div>

<script type="text/jscript">
$(document).ready(function(){

	$('#reload-<?php echo $timestamp; ?>').click(function(){
		ds_shp_req_open.read();
	});


  var ds_shp_req_open = new kendo.data.DataSource({
		transport: {
			read: {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('shipment/request/getReference'); ?>',
			}
		},
		schema: {
			parse: function(response){
				return response.data;
			},
		},
		pageSize: 100,
	});


	$('#shp-req_open-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_shp_req_open,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: true,
		resizable: true,
		//rowTemplate: kendo.template($("#shp-monitoring-row-<?php echo $timestamp; ?>").html()),
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
			{field:"id",width:200, title:"<?php echo lang('tbl_dst_req_no'); ?>"},
			{field:"origin_name",width:200, title:"<?php echo lang('tbl_dst_origin'); ?>"},
			{field:"dest_name",width:200, title:"<?php echo lang('tbl_dst_dest'); ?>"},
			{field:"shipment_mode",width:200, title:"<?php echo lang('tbl_dst_shpmod'); ?>"},
			{field:"request_type",width:200, title:"<?php echo lang('tbl_dst_req_type'); ?>"},
			{field:"request_type",width:200, title:"Kilo/Collie"},
		]
	});

});
</script>
