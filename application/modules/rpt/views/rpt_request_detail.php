<?php $timestamp = time();?>
<div id="info-rpt-detail-<?php echo $timestamp; ?>"></div>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jszip.min.js"></script>
<script>
$(document).ready(function(){
	var ds_rpt_detail = new kendo.data.DataSource({
			transport: {
				read: {
					type:"POST",
					dataType: "json",
					data:<?php echo json_encode($res); ?>,
					url: '<?php echo site_url('rpt/request_submit_get'); ?>',
				}
			},
			schema: {
				parse: function(response){
					return response.data;
				},
			},
			//pageSize: 100,
		});
		
	$('#info-rpt-detail-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_rpt_detail,
		sortable: true,
		pageable: false,
		scrollable: true,
		filterable: false,
		toolbar: ["excel"],
		excel: {
			fileName: "GMF LOGISTIK- Report <?php echo date('y-m-d'); ?>.xlsx"
		},
		rowTemplate: kendo.template($("#info-reaq-row-<?php echo $timestamp; ?>").html()),
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
			{field:'customer_id',title:"CUSTOMER ID", width:150,filterable: false},
			{field:'request_id	',title:"REQ Number", width:100,filterable: false},
			{field:'request_type',title:"SERVICE", width:150,filterable: false},
			
		<?php if($this->input->post('type')=='IMPORT,EXPORT'){ ?>
			{field:'payment_trm',title:"TERM of PAYMENT", width:250,filterable: false},
			{field:'shp_priority',title:"SERVICE LEVEL", width:200,filterable: false},
			{field:'port_origin',title:"ORIGIN", width:80,filterable: false},
			{field:'port_dest',title:"DESTINATION", width:150,filterable: false},
			{field:'ponumber	',title:"PO", width:80,filterable: false},
			{field:'awb',title:"AWB", width:150,filterable: false},
			{field:'etd',title:"ETD", width:150,filterable: false},
			{field:'eta',title:"ETA", width:150,filterable: false},
			{field:'part_number',title:"PART NUMBER", width:200,filterable: false},
			{field:'part_desc',title:"PART DESCRIPTION", width:200,filterable: false},
			{field:'acregis',title:"A/C REGISTRATION", width:200,filterable: false},
			{field:'price_asign',title:"PRICE ASSIGN", width:200,filterable: false},
			{field:'status',title:"STATUS", width:100,filterable: false},
			{field:'sp_number',title:"SP NUMBER", width:150,filterable: false},
		<?php } ?>
		
		<?php if($this->input->post('type')=='CUSTOM CLEARANCE'){ ?>
			{field:'awb_custom',title:"AWB", width:100,filterable: false},
			{field:'ata',title:"ATA CGK", width:100,filterable: false},
			{field:'sp_number',title:"SP NUMBER", width:150,filterable: false},
			{field:'sp_date',title:"SP DATE", width:100,filterable: false},

		<?php } ?>
		
		<?php if($this->input->post('type')=='WAREHOUSE LEASE'){ ?>
			{field:'eid',title:"INCOMING DATE", width:200,filterable: false},
			{field:'eod',title:"OUTGOING DATE", width:200,filterable: false},
			{field:'part_desc',title:"PART DESCIPTION", width:200,filterable: false},
			{field:'dimensi',title:"DIMS", width:80,filterable: false},
			{field:'weight',title:"WEIGHT (kg)", width:200,filterable: false},
		<?php } ?>
		
		<?php if($this->input->post('type')=='INTERNAL DISTRIBUTION'){ ?>
			{field:'shp_from',title:"FROM", width:100,filterable: false},
			{field:'shp_to',title:"TO", width:100,filterable: false},
			{field:'exsec_date',title:"ACTIVITY DATE", width:200,filterable: false},
			{field:'part_desc',title:"PART DESCIPTION", width:200,filterable: false},
			{field:'dimensi',title:"DIMS", width:100,filterable: false},
			{field:'weight',title:"WEIGHT (kg)", width:100,filterable: false},
		<?php } ?>
		
		<?php if($this->input->post('type') =='PACKAGING'){ ?>
			{field:'req_desc',title:"REQUEST DESC", width:250,filterable: false},
		<?php } ?>
			{field:'paymentres',title:"PAYMENT RESPONSIBILITY", width:250,filterable: false},
		]
	});
});

</script>


<script id="info-reaq-row-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">
	<tr>
		<td>#: customer_id #</td>
		<td>#: request_id #</td>
		<td>#: request_type #</td>
		<?php if($this->input->post('type')=='IMPORT,EXPORT'){ ?>
			<td>#: payment_trm #</td>
			<td>#: shp_priority #</td>
			<td>#: port_origin #</td>
			<td>#: port_dest #</td>
			<td>#: ponumber #</td>
			<td>#: awb #</td>
			<td>#: etd #</td>
			<td>#: eta #</td>
			<td>#: part_number #</td>
			<td>#: part_desc #</td>
			<td>#: acregis #</td>
			<td>#: price_asign #</td>
			<td>
				#if(status==1){# Open #}#
				#if(status==2){# Assigned #}#
				#if(status==3 || status==5){# Reject #}#
				#if(status==4){# Cost Aproved #}#
				#if(status==6 && price_asign ==0){# Waiting LNM #}#
				#if(status==6 && price_asign > 0){# Processed by LNM #}#
				#if(status==7){# Done #}#
			</td>
			<td>#: sp_number #</td>
		<?php } ?>
		
		<?php if($this->input->post('type')=='CUSTOM CLEARANCE'){ ?>
			<td>#: awb_custom #</td>
			<td>#: ata #</td>
			<td>#: sp_number #</td>
			<td>#: sp_date #</td>
		<?php } ?>
		
		<?php if($this->input->post('type')=='WAREHOUSE LEASE'){ ?>
			<td>#: eid #</td>
			<td>#: eod #</td>
			<td>#: part_desc #</td>
			<td>#: dimensi #</td>
			<td>#: weight #</td>
		<?php } ?>
		
		<?php if($this->input->post('type')=='INTERNAL DISTRIBUTION'){ ?>
			<td>#: shp_from #</td>
			<td>#: shp_to #</td>
			<td>#: exsec_date #</td>
			<td>#: part_desc #</td>
			<td>#: dimensi #</td>
			<td>#: weight #</td>
		<?php } ?>
		
		<?php if($this->input->post('type') =='PACKAGING'){ ?>
			<td>#: req_desc #</td>
		<?php } ?>
		
		<td>#: paymentres #</td>
	</tr>
</script>
