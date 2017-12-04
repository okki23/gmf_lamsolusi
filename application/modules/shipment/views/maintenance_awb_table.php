<?php $timestamp = time();?>
<div id="info-maintenance-awb-<?php echo $timestamp; ?>"></div>


<script>
$(document).ready(function(){
	var ds_awbtbl = new kendo.data.DataSource({
			transport: {
				read: {
					type:"POST",
					dataType: "json",
					data:<?php echo json_encode($res); ?>,
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
		
	$('#info-maintenance-awb-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_awbtbl,
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
			{
				field:"awb",
				width:200, 
				title:"AWB",
				filterable: false,
				template:'<a href="javascript:void(0)" onclick="$(this).getDetail();" data-id="#: awb #"><strong>#: awb #</strong>'
			},
			{field:"ata_date",width:100,title:"ETA Date",filterable: false,},
			{field:"atd_date",width:100,title:"ETD Date",filterable: false,},
			<?php if($this->session->userdata('level')==USER_GMF){ ?>
				{field:"awb_status",width:100,title:"Status",filterable: false, },
				{field:"bc_no",width:100,title:"BC16 No",filterable: false, },
				{field:"bc_date",width:100,title:"BC16 Date",filterable: false, },
			<?php } ?>
			{field:"flight_schadule",width:200,title:"Flight Schadule",filterable: false, },
			{field:"origin_name",width:150,title:"Port Origin",filterable: false, },
			{field:"dest_name",width:150,title:"Port Dest",filterable: false, },
			{field:"reference",width:200,title:"Reference",filterable: false, },
		]
	});
	
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
					$(tr_parent).after('<tr class="sub_'+elmid+'"><td colspan="10" class="loader"></td><td style="display:none">&mdash;|</td></tr>');
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



<script id="shp-monitoring-row-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">
		#if(awb_status=='Clear'){# <tr class="bg-info" data-uid="#: awb #"> #}else{# <tr data-uid="#: awb #"> #}#
		<td style=" padding: 5px;">
			<a href="javascript:void(0)" onclick="$(this).getDetail();" data-id="#: awb #"><strong>#: awb #</strong>
		</td>
		<td style=" padding: 5px;">#: ata_date #</td>
		<td style=" padding: 5px;">#: atd_date #</td>
		<?php if($this->session->userdata('level')==USER_GMF){ ?>
			<td style=" padding: 5px;">#: awb_status #</td>
			<td style=" padding: 5px;">#: bc_no #</td>
			<td style=" padding: 5px;">#: bc_date #</td>
		<?php } ?>
		<td style=" padding: 5px;">#: flight_schadule #</td>
		<td style=" padding: 5px;">#: origin_name #</td>
		<td style=" padding: 5px;">#: dest_name #</td>
		<td style=" padding: 5px;">#: reference #</td>
	</tr>
</script>