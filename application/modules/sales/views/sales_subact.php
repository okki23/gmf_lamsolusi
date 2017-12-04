<?php $timestamp = time();?>
<div id="info-sub-act-<?php echo $timestamp; ?>"></div>
<script>
var record2=0;
$(document).ready(function(){
	var ds_tracking = new kendo.data.DataSource({
			transport: {
				read: {
					type:"POST",
					dataType: "json",
					data:<?php echo json_encode($res); ?>,
					url: '<?php echo site_url('sales/actifity_sub'); ?>',
				}
			},
			schema: {
				parse: function(response){
					return response.data;
				},
			},
			pageSize: 100,
		});
		
	$('#info-sub-act-<?php echo $timestamp; ?>').kendoGrid({
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
		dataBinding: function() {
		  record2 = (this.dataSource.page() -1) * this.dataSource.pageSize();
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
				filterable: false,
				template: "#: ++record2 #",
				width: 50,
				title:"NO"
			},
			{field:"actifity_date",title:"Date",width: 100,filterable: false},
			{field:"actifity_time",title:"Time",width: 100,filterable: false},
			{field:"description",title:"Actifity",width: 200,filterable: false},
		]
	});
});
</script>