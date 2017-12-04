<?php $timestamp = time();?>
<nav class="navbar navbar-default  no-margin" role="navigation" style="padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;">
	<div class="navbar-left">
		<div class="btn-group">
				<?php
					echo'<button class="btn btn-info navbar-btn " id="edit-assign-'.$timestamp.'"><i class="glyphicon glyphicon-pencil"></i> Assign Price </button> ';
				?>
		</div>
	</div>
	<div class="navbar-right">
		<button id="reload-<?php echo $timestamp; ?>" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-refresh"></i></button>
	</div>
</nav>


<div style='overflow-x: scroll; padding-top:15px;'>
	<div id="info-lnm-<?php echo $timestamp; ?>"></div>
</div>

<?php $this->load->view('sales/assign_modal'); ?>
<script id="info-lnm-row-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">

	#if(status==3 || status==5){#
		<tr class="bg-danger text-white">
	#}else{#
		<tr>
	#}#
		<td style=" padding: 5px; text-align:center;">
			<input type="checkbox" class='requestId' name="requestId[]" value="#: id #">
		</td>
		<td style=" padding: 5px;">#: id #</td>
		<td style=" padding: 5px;">#: request_type #</td>
		<td style=" padding: 5px;">
			#
			 service = (service_charges > 0)? service_charges:0;
			 freight = (freight_charges > 0)? freight_charges:0;
			 transport = (transport_charges	 > 0)? transport_charges	:0;
			 dg = (dg_charges	 > 0)? dg_charges	:0;
			 cgx = (cgx_charges	 > 0)? cgx_charges	:0;
			 curency = (curency_carges		 > 0)? curency_carges		:0;

			 taotal_charge = service+freight+transport+dg+cgx+curency;
			#
			#if(status==1){# Open #}#
			#if(status==2){# Assigned #}#
			#if(status==3){# Reject #}#
			#if(status==4){# Cost Aproved #}#
			#if(status==5){# Reject by GMF #}#
			#if(status==6 && taotal_charge ==0){# Waiting LNM #}#
			#if(status==6 && taotal_charge > 0){# Processed by LNM #}#
		</td>
		#if(request_type =='IMPORT' || request_type =='EXPORT' || request_type =='DOMESTIC DISTRIBUTION'){#
			<td style=" padding: 5px;">#: nama_partner #</td>
			<td style=" padding: 5px;">#: date #</td>
			<td style=" padding: 5px;">#: origin_name #</td>
			<td style=" padding: 5px;">#: dest_name #</td>
			<td style=" padding: 5px;">#: inco_term #</td>
			<td style=" padding: 5px;">#: shipment_mode #</td>
		#}else{#
			<td style=" padding: 5px;" colspan='6'><b>Req Desc : </b>#: req_desc #</td>
		#}#
	</tr>
</script>

<script>
$(document).ready(function(){
	<?php echo $js_cmb; ?>

	var ds_request = new kendo.data.DataSource({
		transport: {
			read: {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('customer/request/get'); ?>',
			}
		},
		schema: {
			parse: function(response){
				return response.data;
			},
		},
		pageSize: 100,
	});

	$('#info-lnm-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_request,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: false,
		rowTemplate: kendo.template($("#info-lnm-row-<?php echo $timestamp; ?>").html()),
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
			{title:"<input id='myCheckbox' type='checkbox' onClick='toggle(this)' /> All<br/>",width:20},
			{field:"id",width:300,title:"Request No"},
			{field:"request_type",width:500,title:"Request Type"},
			{field:"status",width:300,title:"Status",filterable: false},
			{field:"date",width:300, title:"Request Date",filterable: false},
			{field:"nama_partner",width:500,title:"Shiper Name",filterable: false},
			{field:"origin_name",width:300,title:"Port Origin",filterable: false, },
			{field:"dest_name",width:300,title:"Port Destination",filterable: false, },
			{field:"inco_term",width:300,title:"Incoterm",filterable: false, },
			//{field:"cpo",title:"Customer PO Reference ",filterable: false, },
			{field:"shipment_mode",width:300,title:"Shipment Mode",filterable: false},
			//{field:"special_request",title:"Special Request"},
		]
	});

	<?php if($this->session->userdata('level')==USER_SALES || $this->session->userdata('level')==USER_GMF_LNM ||$this->session->userdata('level')== USER_GMF_LNM ){ ?>
		cmb['pbth'].value('No');
		cmb['pbth'].bind('change',function(){
			var myval = cmb['pbth'].value();

			if(myval=='Yes'){
				$('#form-assign input[name=curency_carges]').attr('readonly', true);
				$('#service_charges').attr('readonly', true);
				$('#freight_charges').attr('readonly', true);
				$('#transport_charges').attr('readonly', true);
				$('#dg_charges').attr('readonly', true);
				$('#cgx_charges').attr('readonly', true);
				$('#cgk_handling').attr('readonly', true);
				$('#dg_charges').attr('readonly', true);
				$('#Origin_charge').attr('readonly', true);
				$('#dest_charges').attr('readonly', true);
				$('#warehouse_charge').attr('readonly', true);
				$('#packaging_charge').attr('readonly', true);
				$('#fumigation_charge').attr('readonly', true);
				$('#duty_charge').attr('readonly', true);
				$('#allin_charge').attr('readonly', true);

				$('#form-assign input[name=curency_carges]').val(0);
				$('#service_charges').val(0);
				$('#freight_charges').val(0);
				$('#transport_charges').val(0);
				$('#dg_charges').val(0);
				$('#cgx_charges').val(0);
				$('#Origin_charge').val(0);
				$('#cgk_handling').val(0);
				$('#dest_charges').val(0);
				$('#warehouse_charge').val(0);
				$('#packaging_charge').val(0);
				$('#fumigation_charge').val(0);
				$('#duty_charge').val(0);
				$('#allin_charge').val(0);
			}else{
				$('#form-assign input[name=curency_carges]').attr('readonly', false);
				$('#service_charges').attr('readonly', false);
				$('#freight_charges').attr('readonly', false);
				$('#transport_charges').attr('readonly', false);
				$('#dg_charges').attr('readonly', false);
				$('#cgx_charges').attr('readonly', false);
				$('#cgk_handling').attr('readonly', false);
				$('#dg_charges').attr('readonly', false);
				$('#Origin_charge').attr('readonly', false);
				$('#dest_charges').attr('readonly', false);
				$('#warehouse_charge').attr('readonly', false);
				$('#packaging_charge').attr('readonly', false);
				$('#fumigation_charge').attr('readonly', false);
				$('#duty_charge').attr('readonly', false);
				$('#allin_charge').attr('readonly', false);
			}
		});
	<?php } ?>

	$('#reload-<?php echo $timestamp; ?>').click(function(){
		ds_request.read();
	});


	$("#add-assign-<?php echo $timestamp; ?>, #edit-assign-<?php echo $timestamp; ?>").click(function(){
		$('#lnm-btn').hide();
		$('.detail_import').hide();
		var myId = $(this).attr('id');
		var txt;
		var rowtable='';
		var total_price_cek = 0;
		var services =0;
		var checkedVals = $('.requestId:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals.length ==1){

			$('#service_charges').val('0');
			$('#freight_charges').val('0');
			$('#transport_charges').val('0');
			$('#dg_charges').val('0');
			$('#cgx_charges').val('0');
			$('#curency_carges').val('0');
			$.ajax({
				url:'<?php echo site_url('customer/request/get'); ?>',
				data:'id='+checkedVals,
				type:'POST',
				dataType:'json',tail:1,
				beforeSend:function(){
					$('#pesan').addClass('loader');
					$('.modal-body').hide();
				},
				success:function(res){
					var services = (res.data[0].service_charges > 0 )?res.data[0].service_charges:0;
					var freight = (res.data[0].freight_charges > 0)?res.data[0].freight_charges:0;
					var transport =(res.data[0].transport_charges > 0)?res.data[0].transport_charges:0;
					var dg = (res.data[0].dg_charges > 0)?res.data[0].dg_charges:0;
					var cgx = (res.data[0].cgx_charges > 0)?res.data[0].cgx_charges:0;
					var curency = (res.data[0].curency_carges > 0 )?res.data[0].curency_carges:0;

					var origin_charges = (res.data[0].origin_charges > 0)?res.data[0].origin_charges:0;
					var dest_charge = (res.data[0].destination_charges > 0)?res.data[0].destination_charges:0;
					var warehouse = (res.data[0].warehouse_charge > 0)?res.data[0].warehouse_charge:0;
					var packaging = (res.data[0].packaging_charge > 0)?res.data[0].packaging_charge:0;
					var fumigation = (res.data[0].fumigation_charge > 0)?res.data[0].fumigation_charge:0;
					var duty_charges = (res.data[0].duty_charges > 0)?res.data[0].duty_charges:0;
					var allin = (res.data[0].allin_charges > 0)?res.data[0].allin_charges:0;
					var cgk_handling = (res.data[0].allin_charges > 0)?res.data[0].cgk_charges:0;

					total_price_cek = parseInt(services)+parseInt(freight)+parseInt(transport) + parseInt(dg);
					total_price_cek += parseInt(cgx) + parseInt(curency);
					total_price_cek += parseInt(origin_charges) + parseInt(dest_charge)+ parseInt(warehouse);
					total_price_cek += parseInt(packaging) + parseInt(fumigation)+ parseInt(duty_charges);
					total_price_cek += parseInt(allin)+parseInt(cgk_handling);

					if(res.data[0].status==2 && myId=='add-assign-<?php echo $timestamp; ?>'){
						msg_box('<?php echo lang('msg_asg_everasg'); ?>',['btnOK'],'Info!');
					}else{
						$('#Modal-assign').modal('show');
						var reqType = res.data[0].request_type;

						if(reqType=='IMPORT' || reqType=='EXPORT' || reqType=='DOMESTIC DISTRIBUTION'){
							$('.type_two').hide();
							$('.type_warehouse').hide();
							$('.type_custom_clearence').hide();
							$('.type_internal_dist').hide();
							$('.type_one').show();
						}else if(reqType=='INTERNAL DISTRIBUTION'){
							$('.type_warehouse').hide();
							$('.type_one').hide();
							$('.type_custom_clearence').hide();
							$('.type_internal_dist').show();
							$('.type_two').show();
						}else if(reqType=='CUSTOM CLEARANCE'){
							$('.type_one').hide();
							$('.type_internal_dist').hide();
							$('.type_warehouse').hide();
							$('.type_custom_clearence').show();
							$('.type_two').show();
						}else if(reqType=='WAREHOUSE LEASE'){
							$('.type_internal_dist').hide();
							$('.type_custom_clearence').hide();
							$('.type_one').hide();
							$('.type_warehouse').show();
							$('.type_two').show();
						}else{
							$('.type_internal_dist').hide();
							$('.type_custom_clearence').hide();
							$('.type_warehouse').hide();
							$('.type_one').hide();
							$('.type_two').show();
						}

						$("#info_id").show();
						$("#info_id").html('ID '+res.data[0].id);
						$('#form-assign input[name=id]').val(res.data[0].id);
						$('#partner').html(res.data[0].partner+'-'+res.data[0].nama_partner);
						$('#origin').html(res.data[0].port_origin+'-'+res.data[0].origin_name);
						$('#destination').html(res.data[0].port_dest+'-'+res.data[0].dest_name);
						$('#shipment_mode').html(res.data[0].shipment_mode);
						$('#incoterm').html(res.data[0].inco_term);
						$('#reference').html(res.data[0].cpo);
						$('#request').html(res.data[0].special_request);
						$('#date').html(res.data[0].date);
						$('#req_desc').html(res.data[0].req_desc);
						$('#req-type').html(res.data[0].request_type	);
						$('#ship_from').html(res.data[0].shp_from	);
						$('#ship_to').html(res.data[0].shp_to);
						$('#payment_respon').html(res.data[0].payment_res	);
						$('#eksec_date_lbl').html(res.data[0].exsec_date	);
						$('#awb_number_lbl').html(res.data[0].awb);
						$('#estimate_time_label').html(res.data[0].ata);
						$('#estimate_incoming_lbl').html(res.data[0].eid);
						$('#estimate_outgoing_lbl').html(res.data[0].eod);

						cmb['curency'].value(res.data[0].curency);
						if(myId=='edit-assign-<?php echo $timestamp; ?>'){
							if (res.data[0].service_charges > 0) $('#service_charges').val(res.data[0].service_charges);
							if (res.data[0].freight_charges > 0) $('#freight_charges').val(res.data[0].freight_charges);
							if (res.data[0].transport_charges > 0) $('#transport_charges').val(res.data[0].transport_charges);
							if (res.data[0].dg_charges > 0) $('#dg_charges').val(res.data[0].dg_charges);
							if (res.data[0].cgx_charges > 0) $('#cgx_charges').val(res.data[0].cgx_charges);
							if (res.data[0].curency_carges > 0) $('#curency_carges').val(res.data[0].curency_carges);

							if (res.data[0].origin_charges > 0) $('#Origin_charge').val(res.data[0].origin_charges);
							if (res.data[0].destination_charges > 0) $('#dest_charges').val(res.data[0].destination_charges);
							if (res.data[0].warehouse_charge > 0) $('#warehouse_charge').val(res.data[0].warehouse_charge);
							if (res.data[0].packaging_charge > 0) $('#packaging_charge').val(res.data[0].packaging_charge);
							if (res.data[0].fumigation_charge > 0) $('#fumigation_charge').val(res.data[0].fumigation_charge);
							if (res.data[0].duty_charges > 0) $('#duty_charge').val(res.data[0].duty_charges);
							if (res.data[0].allin_charges > 0) $('#allin_charge').val(res.data[0].allin_charges);

							$('#edit-btn').show();
							$('#asign-btn').hide();
						}else{
							$('#edit-btn').hide();
							$('#asign-btn').show();
						}


						$('.body_item').html('');
							var rowItem = res.data[0].item;
							var no=1;
							for (i = 0; i < rowItem.length; i++) {
								rowtable += '<tr>';
								rowtable += '<td>'+no+'</td>';
								rowtable += '<td>'+rowItem[i].part_number+'</td>';
								rowtable += '<td>'+rowItem[i].part_desc+'</td>';
								rowtable += '<td>'+rowItem[i].qty+'</td>';
								rowtable += '<td>'+rowItem[i].weight+'</td>';
								rowtable += '<td>'+rowItem[i].uom+'</td>';
								if(reqType=='IMPORT' || reqType=='EXPORT' || reqType=='DOMESTIC DISTRIBUTION'){
									$('.detail_import').show();
									rowtable += '<td>'+rowItem[i].dimensi+'</td>';
									rowtable += '<td>'+rowItem[i].ponumber+'</td>';
									rowtable += '<td>'+rowItem[i].acregis+'</td>';
									rowtable += '<td>'+rowItem[i].paymentres+'</td>';
									rowtable += '<td>'+rowItem[i].value_of_goods+'</td>';
									rowtable += '<td>'+rowItem[i].goods_category+'</td>';
									rowtable += '<td>'+rowItem[i].curency+'</td>';
								}
								rowtable += '</tr>';
								no++;
							}
						$('.body_item').append(rowtable);
					}
				}
			}).done(function(){
				$('.modal-body').show();
				$('#pesan').removeClass('loader2');
			});
		}else if(checkedVals.length >1){
			msg_box('Select Only One data',['btnOK'],'Info!');
		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});

	$('#edit-btn').click(function(e){
		e.preventDefault();
		$.ajax({
			url:'<?php echo site_url('lnm/edit_assign'); ?>',
			data:$('#form-assign').serialize(),
			type:'POST',
			dataType:'json',tail:1,
			beforeSend:function(){
				$('#pesan-asign').html('');
				$('#pesan-asign').addClass('loader2');
			},
			success:function(res){
				if(res.status){
					ds_request.read();
					msg_box(res.messages,['btnOK'],'Info!');
					$('#form-assign input[name=tax]').val('');
					$('#form-assign input[name=custom]').val('');
					$('#form-assign input[name=service_charges]').val('');
					$('#form-assign input[name=freight_charges]').val('');
					$('#form-assign input[name=transport_charges]').val('');
					$('#form-assign input[name=dg_charges]').val('');
					$('#form-assign input[name=cgx_charges]').val('');
					$('#form-assign input[name=curency_carges]').val('');
					$('#Modal-assign').modal('hide');
				}else
					$('#pesan-asign').html(res.messages);
			}
		}).done(function(){
			$('#pesan-asign').removeClass('loader2');
			setTimeout(function(){
				$("#pesan-asign").html("");
			}, 3000);
		});
	});

	$('.charges').keyup(function(){
		var freight = $('#freight_charges').val();
		var cgk_charge = $('#cgk_handling').val();
		var dg = $('#dg_charges').val();
		var origin = $('#Origin_charge').val();
		var destination = $('#dest_charges').val();
		var warehouse = $('#warehouse_charge').val();
		var packaging = $('#packaging_charge').val();
		var pumigation = $('#fumigation_charge').val();
		var duty = $('#duty_charge').val();
		var allin = $('#allin_charge').val();
		var total =0;

		total = parseInt(freight)+parseInt(cgk_charge)+parseInt(dg);
		total += parseInt(origin)+parseInt(destination)+parseInt(warehouse);
		total += parseInt(packaging)+parseInt(duty)+parseInt(allin)+parseInt(pumigation);

		$('.total').html(numberWithCommas(total));
	});

});
</script>
