<?php $timestamp = time();?>
<div id="info-rpt-detail-<?php echo $timestamp; ?>"></div>


<script>
$(document).ready(function(){
	var ds_rpt_detail = new kendo.data.DataSource({
			transport: {
				read: {
					type:"POST",
					dataType: "json",
					data:<?php echo json_encode($res); ?>,
					url: '<?php echo site_url('rpt/customer_detail_get'); ?>',
				}
			},
			schema: {
				parse: function(response){
					return response.data;
				},
			},
			pageSize: 100,
		});
		
	$('#info-rpt-detail-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_rpt_detail,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: true,
		filterable: false,
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
			{field:'part_number',title:"Part Number", width:50,filterable: false},
			{field:'part_desc',title:"Part Desc", width:150,filterable: false},
			{field:'qty',title:"Qty", width:50,filterable: false},
			{field:'weight',title:"Weight", width:80,filterable: false},
			{field:'uom',title:"UOM", width:80,filterable: false},
			{field:'dimensi',title:"Dimensi", width:100,filterable: false},
		]
	});
});