<?php $timestamp = time();?>
<div id="info-rpt_table_table-<?php echo $timestamp; ?>"></div>

<script id="info-rpt-tmp-row-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">
	<tr data-uid="#: id #">
		<td style=" padding: 5px; text-align:center;">
			<a href="javascript:void(0)" onclick="$(this).getitem();" data-id="#: id #"><strong>#: id #</strong></a>
		</td>
		<td style=" padding: 5px;">#: request_type #</td>
		#if(request_type =='IMPORT' || request_type =='EXPORT' || request_type =='DOMESTIC DISTRIBUTION'){#
			<td style=" padding: 5px;">#: origin_name#</td>
			<td style=" padding: 5px;">#: dest_name #</td>
			<td style=" padding: 5px;">#: inco_term #</td>
			<td style=" padding: 5px;">#: shipment_mode #</td>
			<td style=" padding: 5px;">#: cpo #</td>
			<td style=" padding: 5px;">#: special_request #</td>
		#}else{#
			<td style=" padding: 5px;" colspan='6'><b>Req Desc : </b>#: req_desc #</td>
		#}#
		<td style=" padding: 5px;">
			#if(status==1){# Open #}#
			#if(status==2){# Assigned #}#
			#if(status==3){# Reject #}#
			#if(status==4){# Cost Aproved #}#
			#if(status==5){# Reject by GMF #}#
			#if(status==7){# Request Done #}#
			#if(status==6 && taotal_charge ==0){# Waiting LNM #}#
			#if(status==6 && taotal_charge > 0){# Processed by LNM #}#
		</td>
	</tr>
</script>


<script>
$(document).ready(function(){
	var ds_rpt = new kendo.data.DataSource({
			transport: {
				read: {
					type:"POST",
					dataType: "json",
					data:<?php echo json_encode($res); ?>,
					url: '<?php echo site_url('rpt/customer_get'); ?>',
				}
			},
			schema: {
				parse: function(response){
					return response.data;
				},
			},
			pageSize: 100,
		});

	$('#info-rpt_table_table-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_rpt,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: true,
		filterable: false,
		rowTemplate: kendo.template($("#info-rpt-tmp-row-<?php echo $timestamp; ?>").html()),
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
				field:'id',
				title:"Request ID",
				width:100,
				filterable: false,
				template:'<a href="javascript:void(0)" onclick="$(this).getitem();" data-id="#: id #"><strong>#: id #</strong></a>',
			},
			{field:'request_type',title:"TYPE", width:150,filterable: false},
			{field:'origin_name',title:"Port Origin", width:100,filterable: false},
			{field:'dest_name',title:"Port Dest", width:100,filterable: false},
			{field:'inco_term',title:"Incoterm", width:80,filterable: false},
			{field:'shipment_mode',title:"Shiper Mode", width:100,filterable: false},
			{field:'cpo',title:"Customer PO Ref", width:100,filterable: false},
			{field:'special_request',title:"Special Request", width:100,filterable: false},
			{field:'status',title:"Status Request", width:100,filterable: false},
		]
	});

	$.fn.getitem=function(){
		var reqID = $(this).data('id');
		var tr_parent = $(this).parent('td').parent('tr');
		var elmid = tr_parent.data('uid');
		if(tr_parent.hasClass('open')){
			tr_parent.removeClass('open');
			$('tr.sub_'+elmid).remove();
		}else{
			tr_parent.addClass('open');
			$.ajax({
				url: '<?php echo site_url('rpt/customer_detail'); ?>',
				data: 'id='+reqID,
				type:'POST',
				dataType: 'html',
				beforeSend: function(){
					$(tr_parent).after('<tr class="sub_'+elmid+'"><td colspan="9" class="loader"></td><td style="display:none">&mdash;|</td></tr>');
				},
				success:function(result){
					$('tr.sub_'+elmid).addClass('alert-success');
					$('tr.sub_'+elmid+'>td:eq(0)').html(result);
				}
			}).done(function(){
				$('tr.sub_'+elmid+'>:eq(0)').removeClass('loader');
			});
		}
		//alert(reqID);
	}

});
</script>
