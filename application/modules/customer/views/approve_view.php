<?php $timestamp = time();?>
<nav class="navbar navbar-default  no-margin" role="navigation" style="padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;">
	<div class="navbar-left">
		<div class="btn-group">
			&nbsp;
		</div>
	</div>
	<div class="navbar-right">
		<button id="reload-<?php echo $timestamp; ?>" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-refresh"></i></button>
	</div>
</nav>

<div style='overflow-x: scroll; padding-top:15px;'>
	<div id="info-request-<?php echo $timestamp; ?>"></div>
</div>

<script id="info-request-row-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">

	#if(status==3 || status==4){#
		<tr class="bg-danger text-white">
	#}else{#
		<tr>
	#}#
		<td style=" padding: 5px; text-align:center;">#: ++record #</td>
		<td style=" padding: 5px;">
			<a href="javascript:void(0)" onclick="$(this).dialogApprove();" data-id="#: id #">
				<strong>#: id #</strong>
			</a>
		</td>
		<td style=" padding: 5px;">#: date #</td>
		<td style=" padding: 5px;">#: request_type #</td>
		<td style=" padding: 5px;">#: origin_name #</td>
		<td style=" padding: 5px;">#: dest_name #</td>
		<td style=" padding: 5px;">#: inco_term #</td>
		<td style=" padding: 5px;">#: shipment_mode #</td>
		#total = parseInt(freight_charges) + parseInt(cgk_charges) + parseInt(dg_charges)	#
		#total += parseInt(origin_charges) + parseInt(destination_charges) + parseInt(warehouse_charge)	#
		#total += parseInt(packaging_charge) + parseInt(fumigation_charge) + parseInt(duty_charges) + parseInt(allin_charges)	#

		<td style=" padding: 5px;">#: kendo.toString(parseInt(total),'n0') #</td>
	</tr>
</script>


<div id="Modal-approve-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<form class="form-horizontal" id='form-approve-<?php echo $timestamp; ?>' action='<?php echo site_url('customer/approve/proses'); ?>' method='POST'>
		<input type="hidden" name='id' id="tex_id" readonly />
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Approve <span id="info_id">[ID : ]</span></h4>
			</div>
			<div class="modal-body">
				<div class="col-sm-6 internal_dist">
					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_shipfrom'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="intern_from" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_shipto'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="intern_to" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('tbl_asg_dtl_payment'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="intern_payment" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('frm_shp_exsec'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="intern_exsec" style='border:0px; box-shadow:none;'></strong></div>
					</div>
				</div>

				<div class="col-sm-6 request_one">
					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for="">Partner Name :</label>
						<div class="col-sm-8"><strong class='form-control' id="partner" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for="">Port Origin :</label>
						<div class="col-sm-8"><strong class='form-control' id="origin" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for="">Port Destination :</label>
						<div class="col-sm-8"><strong class='form-control' id="destination" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for="">Incoterm:</label>
						<div class="col-sm-8"><strong class='form-control' id="incoterm" style='border:0px; box-shadow:none;'></strong></div>
					</div>
				</div>
				<div class="col-sm-6 request_one">
					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for="">Reference:</label>
						<div class="col-sm-8"><strong class='form-control' id="reference" style='border:0px; box-shadow:none;'></strong></div>
					</div>
					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for="">Shipment Mode:</label>
						<div class="col-sm-8"><strong class='form-control' id="shipment_mode" style='border:0px; box-shadow:none;'></strong></div>
					</div>
					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for="">Special Request:</label>
						<div class="col-sm-8"><strong class='form-control' id="request" style='border:0px; box-shadow:none;'></strong></div>
					</div>
					<!--<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for="">Request Date:</label>
						<div class="col-sm-8"><strong class='form-control' id="date" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for="">Request Type:</label>
						<div class="col-sm-8"><strong class='form-control' id="req_type" style='border:0px; box-shadow:none;'></strong></div>
					</div>-->
				</div>

				<div class="col-sm-6" >
					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for="">Request Date:</label>
						<div class="col-sm-8"><strong class='form-control' id="date" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for="">Request Type:</label>
						<div class="col-sm-8"><strong class='form-control' id="req_type" style='border:0px; box-shadow:none;'></strong></div>
					</div>
				</div>

				<div class="col-sm-12 request_two">
					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-2 control-label" for="">Request description :</label>
						<div class="col-sm-10"><span class='form-control' id="req_desc" style='border:0px; box-shadow:none;'></span></div>
					</div>
				</div>

				<p>&nbsp;</p>
				<div class="col-sm-12">
					<fieldset>
						<legend>Price Information:</legend>
						<div class="col-sm-6" >
							<div class="form-group ware_house_lease_no" style='margin-bottom:0px;'>
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_freight'); ?> :</label>
								<div class="col-sm-8"><strong class='form-control' id="freight_charges" style='border:0px; box-shadow:none;'></strong></div>
							</div>
							<div class="form-group" style='margin-bottom:0px;'>
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_cgk'); ?> :</label>
								<div class="col-sm-8"><strong class='form-control' id="cgk_charge" style='border:0px; box-shadow:none;'></strong></div>
							</div>
							<div class="form-group" style='margin-bottom:0px;'>
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_dg'); ?> :</label>
								<div class="col-sm-8"><strong class='form-control' id="dg_charge" style='border:0px; box-shadow:none;'></strong></div>
							</div>
							<div class="form-group import_only" style='margin-bottom:0px; display:none;'>
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_origin_charge'); ?> :</label>
								<div class="col-sm-8"><strong class='form-control' id="origin_charge" style='border:0px; box-shadow:none;'></strong></div>
							</div>
							<div class="form-group export_only" style='margin-bottom:0px; display:none;'>
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_dest_charge'); ?> :</label>
								<div class="col-sm-8"><strong class='form-control' id="destination_charge" style='border:0px; box-shadow:none;'></strong></div>
							</div>
						</div>

						<div class="col-sm-6" >
							<div class="form-group" style='margin-bottom:0px;'>
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_warehouse'); ?> :</label>
								<div class="col-sm-8"><strong class='form-control' id="Warehouse_charge" style='border:0px; box-shadow:none;'></strong></div>
							</div>

							<div class="form-group export_only" style='margin-bottom:0px; display:none;'>
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_packaging'); ?>:</label>
								<div class="col-sm-8"><strong class='form-control' id="packaging_charge" style='border:0px; box-shadow:none;'></strong></div>
							</div>
							<div class="form-group ware_house_lease_no" style='margin-bottom:0px;'>
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_fumigation'); ?>:</label>
								<div class="col-sm-8"><strong class='form-control' id="fumigation_charge" style='border:0px; box-shadow:none;'></strong></div>
							</div>
							<div class="form-group ware_house_lease_no" style='margin-bottom:0px;'>
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_tax'); ?> :</label>
								<div class="col-sm-8"><strong class='form-control' id="duty_tax_charge" style='border:0px; box-shadow:none;'></strong></div>
							</div>
							<div class="form-group" style='margin-bottom:0px;'>
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_allin'); ?> :</label>
								<div class="col-sm-8"><strong class='form-control' id="allin_charge" style='border:0px; box-shadow:none;'></strong></div>
							</div>
						</div>



						<div class="col-sm-6" >
							<div class="form-group" style='margin-bottom:0px;'>
								<label class="col-sm-4 control-label" for="">Total:</label>
								<div class="col-sm-8"><strong class='form-control' id="total" style='font-size:14px; border:0px; box-shadow:none;'></strong></div>
							</div>
						</div>
					</fieldset>
				</div><p>&nbsp;</p>
				<div class="col-sm-12 request_one internal_dist">
					<fieldset>
						<legend>Item detail:</legend>
						<table class="table table-hover table-bordered">
							<thead>
							  <tr>
								<th>No</th>
								<th>Part Number</th>
								<th>Part Desc</th>
								<th>qty</th>
								<th>Weigh</th>
								<th>Uom</th>
								<th class="item_label" >Dimensi</th>
							  </tr>
							</thead>
							<tbody class='body_item'>

							</tbody>
						</table>
					</fieldset>
				</div><p>&nbsp;</p>
				<div class="col-sm-12">
					<fieldset>
						<legend>Notes:</legend>
							<div class="form-group">
								<div class="col-sm-12">
									<textarea class='form-control' name='note'></textarea>
								</div>
							</div>
					</fieldset>
				</div>
				<div style='clear:both;'>&nbsp;</div>
			</div>
			<div class="modal-footer">
				<div style='float:left' id="pesan"></div>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="reject<?php echo $timestamp; ?>" class="btn btn-info" >Reject</button>
				<button type="submit" class="btn btn-primary" >Approve</button>
			</div>
		</div>
	</form>
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
				url: '<?php echo site_url('customer/approve/get'); ?>',
			}
		},
		schema: {
			parse: function(response){
				return response.data;
			},
			model: {
				fields: {
					service_charges: { type: "number" },
					freight_charges: { type: "number" },
					transport_charges: { type: "number" },
					dg_charges: { type: "number" },
					cgx_charges: { type: "number" },
					curency_carges: { type: "number" }
				}
			}
		},
		pageSize: 100,

	});

	$('#info-request-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_request,
		filterable: true,
		sortable: true,
		//pageable: true,
		pageable: {
			refresh: true,
		},
		scrollable: false,
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
				template: "#: ++record #",
				width: 10,
				title:"NO"
			},
			{field:"id",width:300,title:"Request No"},
			{field:"date",width:300, title:"Request Date",filterable: false},
			{field:"request_type",width:300,title:"Request Type",filterable: false},
			{field:"origin_name",width:300,title:"Port Origin",filterable: false, },
			{field:"dest_name",width:300,title:"Port Destination",filterable: false, },
			{field:"inco_term",width:300,title:"Incoterm",filterable: false},
			{field:"curency_carges",width:300,title:"Shipment Mode",filterable: false},
			{width:300,title:"Total Price",filterable: false, },
		]
	});

	$('#reload-<?php echo $timestamp; ?>').click(function(){
		ds_request.read();
	});


	$('.request_one').hide();
	$('.request_two').hide();
	$.fn.dialogApprove = function() {
		var reqID = $(this).data('id');
		var rowtable ='';
		$('#Modal-approve-<?php echo $timestamp; ?>').modal('show');
		$.ajax({
			url:'<?php echo site_url('customer/request/get'); ?>',
			data:'id='+reqID,
			type:'POST',
			dataType:'json',tail:1,
			beforeSend:function(){
				$('#pesan').addClass('loader2');
				$('.modal-body').hide();
			},
			success:function(res){
				$(".import_only").hide();
				$(".export_only").hide();
				$('.internal_dist').hide();
				$('.ware_house_lease_no').hide();

				var req_type = res.data[0].request_type;

				if(req_type=='IMPORT')
					$(".import_only").show();

				if(req_type=='EXPORT')
					$(".export_only").show();

				if(res.data[0].request_type=='IMPORT' ||res.data[0].request_type=='EXPORT' ||res.data[0].request_type=='DOMESTIC DISTRIBUTION' ){
					$('.request_one').show();
					$('.request_two').hide();
				}else{
					$('.request_one').hide();
					$('.request_two').show();
				}


				if(res.data[0].request_type=='INTERNAL DISTRIBUTION'){
					$('.internal_dist').show();
				}

				if(res.data[0].request_type != 'WAREHOUSE LEASE' || res.data[0].request_type != 'CUSTOM CLEARANCE')
					$('.ware_house_lease_no').show();

				$("#info_id").show();
				$("#info_id").html('ID '+res.data[0].id);
				$('#form-approve-<?php echo $timestamp; ?> input[name=id]').val(res.data[0].id);
				$('#partner').html(res.data[0].partner+'-'+res.data[0].nama_partner);
				$('#req_desc').html(res.data[0].req_desc);
				$('#origin').html(res.data[0].port_origin+'-'+res.data[0].origin_name);
				$('#destination').html(res.data[0].port_dest+'-'+res.data[0].dest_name);
				$('#shipment_mode').html(res.data[0].shipment_mode);
				$('#incoterm').html(res.data[0].inco_term);
				$('#reference').html(res.data[0].cpo);
				$('#request').html(res.data[0].special_request);
				$('#date').html(res.data[0].date);
				var cr = res.data[0].curency;
				// $('#service_charges').html(cr+" "+numberWithCommas(res.data[0].service_charges));
				// $('#freight_charges').html(cr+" "+numberWithCommas(res.data[0].freight_charges));
				// $('#transport_charges').html(cr+" "+numberWithCommas(res.data[0].transport_charges));
				// $('#dg_charge').html(cr+" "+numberWithCommas(res.data[0].dg_charges));
				// $('#cgx_charges').html(cr+" "+numberWithCommas(res.data[0].cgx_charges));
				// $('#curency_charges').html(cr+" "+numberWithCommas(res.data[0].curency_carges));

				$('#freight_charges').html(cr+" "+numberWithCommas(res.data[0].freight_charges));
				$('#cgk_charge').html(cr+" "+numberWithCommas(res.data[0].cgk_charges));
				$('#dg_charge').html(cr+" "+numberWithCommas(res.data[0].dg_charges));
				$('#origin_charge').html(cr+" "+numberWithCommas(res.data[0].origin_charges));
				$('#destination_charge').html(cr+" "+numberWithCommas(res.data[0].destination_charges));
				$('#Warehouse_charge').html(cr+" "+numberWithCommas(res.data[0].warehouse_charge));
				$('#packaging_charge').html(cr+" "+numberWithCommas(res.data[0].packaging_charge	));
				$('#fumigation_charge').html(cr+" "+numberWithCommas(res.data[0].fumigation_charge));
				$('#duty_tax_charge').html(cr+" "+numberWithCommas(res.data[0].duty_charges));
				$('#allin_charge').html(cr+" "+numberWithCommas(res.data[0].allin_charges));


				$('#req_type').html(res.data[0].request_type);

				$('#intern_from').html(res.data[0].shp_from);
				$('#intern_to').html(res.data[0].shp_to);
				$('#intern_payment').html(res.data[0].payment_res);
				$('#intern_exsec').html(res.data[0].exsec_date);


				var total = parseInt(res.data[0].freight_charges)+parseInt(res.data[0].cgk_charges);
				total += parseInt(res.data[0].dg_charges)+parseInt(res.data[0].origin_charges);
				total +=  parseInt(res.data[0].destination_charges)+parseInt(res.data[0].warehouse_charge);
				total +=  parseInt(res.data[0].packaging_charge)+parseInt(res.data[0].fumigation_charge);
				total +=  parseInt(res.data[0].duty_charges)+parseInt(res.data[0].duty_charges)+parseInt(res.data[0].allin_charges);

				$('#total').html(cr+" "+numberWithCommas(total));

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

					if(res.data[0].request_type=='INTERNAL DISTRIBUTION'){
						rowtable += '<td >'+rowItem[i].remaark+'</td>';
						$('.item_label').html('Remark');
					}else{
						rowtable += '<td >'+rowItem[i].dimensi+'</td>';
						$('.item_label').html('Dimensi');
					}


					rowtable += '</tr>';
					no++;
				}
				$('.body_item').append(rowtable);
			}
		}).done(function(){
			$('.modal-body').show();
			$('#pesan').removeClass('loader2');
		});
	}

	$('#form-approve-<?php echo $timestamp; ?>').submit(function(e){
		e.preventDefault();
		$.ajax({
			url:$(this).attr('action'),
			data:$(this).serialize(),
			type:'POST',
			dataType:'json',tail:1,
			beforeSend:function(){
				$('#pesan').html('');
				$('#pesan').addClass('loader2');
			},
			success:function(res){
				if(res.status){
					msg_box(res.messages,['btnOK'],'Info!');
					ds_request.read();
					$('#form-approve-<?php echo $timestamp; ?> textarea[name=note]').val('');
					$('#Modal-approve-<?php echo $timestamp; ?>').modal('hide');
				}else
					$('#pesan').html(res.messages);
			}
		}).done(function(){
			$('#pesan').removeClass('loader2');
			setTimeout(function(){
				$("#pesan").html("");
			}, 3000);
		});
	});

	$('#reject<?php echo $timestamp; ?>').click(function(e){
		e.preventDefault();
		$.ajax({
			url:'<?php echo site_url('customer/approve/reject'); ?>',
			data:$('#form-approve-<?php echo $timestamp; ?>').serialize(),
			type:'POST',
			dataType:'json',tail:1,
			beforeSend:function(){
				$('#pesan').html('');
				$('#pesan').addClass('loader2');
			},
			success:function(res){
				if(res.status){
					msg_box(res.messages,['btnOK'],'Info!');
					ds_request.read();
					$('#form-approve-<?php echo $timestamp; ?> textarea[name=note]').val('');
					$('#Modal-approve-<?php echo $timestamp; ?>').modal('hide');
				}else
					$('#pesan').html(res.messages);
			}
		}).done(function(){
			$('#pesan').removeClass('loader2');
			setTimeout(function(){
				$("#pesan").html("");
			}, 3000);
		});
	});

});
</script>
