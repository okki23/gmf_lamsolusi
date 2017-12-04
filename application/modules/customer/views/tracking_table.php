<?php $timestamp = time();?>
<div id="info-tracking_table-<?php echo $timestamp; ?>"></div>
<script>
$(document).ready(function(){
	var ds_tracking = new kendo.data.DataSource({
			transport: {
				read: {
					type:"POST",
					dataType: "json",
					data:<?php echo json_encode($res); ?>,
					url: '<?php echo site_url('customer/tracking/by_request'); ?>',
				}
			},
			schema: {
				parse: function(response){
					return response.data;
				},
			},
			pageSize: 100,
		});
		
	$('#info-tracking_table-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_tracking,
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
			{field:'awb',title:"AWB", width:20,filterable: false},
			{field:"atd_date",title:"ETD",filterable: false},
			{field:'ata_date',title:"ETA",filterable: false},
			//{field:'',title:"Weight",filterable: false},
			//{field:'',title:"Dimension",filterable: false},
			{field:'flight_schadule',title:"Flight Schadule",filterable: false},
			{field:'',title:"Other",template:'Port Origin : #: origin_name #, Port dest: #:dest_name #',filterable: false},
		]
	});
});
</script>