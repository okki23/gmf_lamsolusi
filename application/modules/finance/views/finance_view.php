<?php $timestamp = time();?>
<nav class="navbar navbar-default  no-margin" role="navigation" style="padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;">
	<div class="navbar-left">
		<div class="btn-group">
			<?php
				echo'<button class="btn btn-info navbar-btn " id="update-copa-'.$timestamp.'"><i class="glyphicon glyphicon-pencil"></i> '.lang('btn_copa_set').' </button> ';
			?>
		</div>
	</div>
	<div class="navbar-right">
		<button id="reload-<?php echo $timestamp; ?>" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-refresh"></i></button>
	</div>
</nav>

<div style=' padding-top:15px;'>
	<div id="info-copa-table-<?php echo $timestamp; ?>"></div>
</div>

<script>
var record=0;
var viewModel= {'param': { 'id':''}};

	$(document).ready(function(){

		$('#reload-<?php echo $timestamp; ?>').click(function(){
			ds_copa_lock.read();
		});

		$('#update-copa-<?php echo $timestamp ?>').click(function(){
			ds_copa_lock.sync();
		});

		var ds_copa_lock = new kendo.data.DataSource({
			transport: {
				read:  {
					type:"POST",
					dataType: "json",
					url: '<?php echo site_url('finance/get_unlock_copa'); ?>',
					data: function() { return JSON.parse(JSON.stringify(viewModel.param)); }
				},
				create: {
					url: '<?php echo site_url('finance/set_copa'); ?>',
					type:"POST",
					dataType: "json",
					complete: function(e) {
						ds_copa_lock.read();
					}
				}
			},
			batch: true,
			pageSize: 100,
			schema: {
				parse: function(response){
					return response.data;
				},
				model: {
					fields: {
						request_id: { editable: false },
			      request_type: { editable: false },
			      request_date: { editable: false },
			      curency: { editable: false },
			      total_cost: { editable: false },
			      pbth: { editable: false },
			      copa: { type: "number", editable: true }
					}
				}
			}
		});

		$('#info-copa-table-<?php echo $timestamp; ?>').kendoGrid({
			dataSource: ds_copa_lock,
			filterable: true,
			sortable: true,
			pageable: true,
			scrollable: true,
			filterable: false,
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
			editable: {
				createAt: 'bottom'
			},
			edit: function onEdit(e) {
			  var grid = this;
			  var cellIndex = e.container.index();
			  var nextCell = e.container.closest("tr").next("tr[role='row']").find("td").eq(cellIndex);

			  if (nextCell) {
				  e.container.find("input").on("keydown", function (e) {
					  if (e.which === 9) {
						  e.preventDefault();
						  e.stopImmediatePropagation();

							$(this).trigger("change");
						  grid.closeCell();
							grid.editCell(nextCell);
					  }
				  });
			  }
		  },
			columns: [
				{field:'request_id',title:"Request ID", width:50,filterable: false},
				{field:'request_type',title:"Request Type", width:150,filterable: false},
				{field:'request_date',title:"Request Date", width:60,filterable: false},
				{field:'curency',title:"Curency", width:80,filterable: false},
				{field:'pbth',title:"PBTH", width:50,filterable: false},
				{field:'total_cost',title:"Selling Price", width:80,filterable: false},
				{field:'copa',title:"COPA", width:100,filterable: false},
			]
		});
	});
</script>
