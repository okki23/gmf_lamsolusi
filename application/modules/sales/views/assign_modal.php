<div id="Modal-assign" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<form class="form-horizontal" id='form-assign' action='<?php echo site_url('sales/assign'); ?>' method='POST'>
		<input type="hidden" name='id' id="tex_id" readonly />
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?php echo lang('title_asg'); ?> <span id="info_id">[ID : ]</span></h4>
			</div>
			<div class="modal-body">
				<div class="col-sm-6 type_two">
					<div class="form-group type_warehouse" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_incoming'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="estimate_incoming_lbl" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group type_warehouse" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_outgoing'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="estimate_outgoing_lbl" style='border:0px; box-shadow:none;'></strong></div>
					</div>


					<div class="form-group type_custom_clearence" style='margin-bottom:0px;'>
						<label class="col-sm-5 control-label" for=""><?php echo lang('form_shp_awbnumber'); ?> :</label>
						<div class="col-sm-7"><strong class='form-control' id="awb_number_lbl" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group type_custom_clearence" style='margin-bottom:0px;'>
						<label class="col-sm-5 control-label" for=""><?php echo lang('form_asg_estimate'); ?> :</label>
						<div class="col-sm-7"><strong class='form-control' id="estimate_time_label" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group type_custom_clearence" style='margin-bottom:0px;'>
						<label class="col-sm-5 control-label" for=""><?php echo lang('form_asg_copy_awb'); ?> :</label>
						<div class="col-sm-7" id='file_list_item'>	</div>
					</div>

					<div class="form-group type_internal_dist" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_shipfrom'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="ship_from" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group type_internal_dist" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_shipto'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="ship_to" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group type_internal_dist" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('tbl_asg_dtl_payment'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="payment_respon" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group type_internal_dist" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_exsec_date'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="eksec_date_lbl" style='border:0px; box-shadow:none;'></strong></div>
					</div>

				</div>
				<div class="col-sm-6 ">
					<div class="form-group type_one" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_shpname'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="partner" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group type_one" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_origin'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="origin" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group type_one" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_dest'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="destination" style='border:0px; box-shadow:none;'></strong></div>
					</div>

					<div class="form-group type_one" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_incoterm'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="incoterm" style='border:0px; box-shadow:none;'></strong></div>
					</div>

				</div>
				<div class="col-sm-6 ">
					<div class="form-group type_one" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_reference'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="reference" style='border:0px; box-shadow:none;'></strong></div>
					</div>
					<div class="form-group type_one" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_mode'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="shipment_mode" style='border:0px; box-shadow:none;'></strong></div>
					</div>
					<div class="form-group type_one" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_special'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="request" style='border:0px; box-shadow:none;'></strong></div>
					</div>
					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_date'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="date" style='border:0px; box-shadow:none;'></strong></div>
					</div>
					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_type'); ?> :</label>
						<div class="col-sm-8"><strong class='form-control' id="req-type" style='border:0px; box-shadow:none;'></strong></div>
					</div>
				</div><p>&nbsp;</p>

				<div class="col-sm-12 type_two">
					<div class="form-group" style='margin-bottom:0px;'>
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_asg_desc'); ?> :</label>
						<div class="col-sm-9"><span class='form-control' id="req_desc" style='border:0px; box-shadow:none;'></span></div>
					</div>
				</div>
				<div class="col-sm-12">
					<fieldset>
						<legend><?php echo lang('form_asg_price'); ?>  :</legend>
						<div class="col-sm-6">
							<div class="form-group" >
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_crc'); ?> :</label>
								<div class="col-sm-8"><input class='charges kendodropdown form-control'  name ='curency' style='width:200px;' id="curency_carges" /></div>
							</div>

							<div class="form-group" style='display:none;'>
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_pbth'); ?> :</label>
								<div class="col-sm-8">
										<input class='pbth kendodropdown form-control'  name ='pbth' id="pbth" />
								</div>
							</div>

							<div class="form-group ware_house_lease_no" >
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_freight'); ?> :</label>
								<div class="col-sm-8"><input class='propover charges form-control'  value='0' name='freight_charges' id="freight_charges"  onkeypress='numberOnly(event)'/></div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_cgk'); ?> :</label>
								<div class="col-sm-8"><input class='charges  form-control' value='0' name ='cgk_handling' id="cgk_handling" onkeypress='numberOnly(event)'/></div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_dg'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control'  value='0' name ='dg_charges' id="dg_charges" onkeypress='numberOnly(event)' /></div>
							</div>

							<div class="form-group import_only">
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_origin_charge'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control'  value='0' name ='origin_charge' id="Origin_charge" onkeypress='numberOnly(event)'/></div>
							</div>

							<!--
							<div class="form-group">
								<label class="col-sm-4 control-label" for=""><?php //echo lang('form_asg_curency'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control'  value='0' name ='curency_carges' id="curency_carges" /></div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label" for=""><?php //echo lang('form_asg_service'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control' value='0' name='service_charges' id="service_charges" /></div>
							</div>
						-->
						</div>
						<div class="col-sm-6">

							<div class="form-group export_only">
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_dest_charge'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control'  value='0' name ='dest_charges' id="dest_charges" onkeypress='numberOnly(event)'/></div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_warehouse'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control'  value='0' name ='warehouse_charge' id="warehouse_charge" onkeypress='numberOnly(event)'/></div>
							</div>

							<div class="form-group export_only">
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_packaging'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control'  value='0' name ='packaging_charge' id="packaging_charge" onkeypress='numberOnly(event)'/></div>
							</div>

							<div class="form-group ware_house_lease_no">
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_fumigation'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control'  value='0' name ='fumigation_charge' id="fumigation_charge" onkeypress='numberOnly(event)'/></div>
							</div>

							<div class="form-group ware_house_lease_no">
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_tax'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control'  value='0' name ='duty_charge' id="duty_charge" onkeypress='numberOnly(event)'/></div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_allin'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control'  value='0' name ='allin_charge' id="allin_charge" onkeypress='numberOnly(event)'/></div>
							</div>

						<!--
							<div class="form-group">
								<label class="col-sm-4 control-label" for=""><?php //echo lang('form_asg_transport'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control'  value='0' name ='transport_charges' id="transport_charges" /></div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label" for=""><?php //echo lang('form_asg_cgx'); ?> :</label>
								<div class="col-sm-8"><input class='charges form-control'  value='0' name ='cgx_charges' id="cgx_charges" /></div>
							</div>
						-->
						</div>
					</fieldset>
					<div class="col-sm-12 ">
						<div class="form-group">
							<label class="col-sm-4 control-label" for=""><?php echo lang('form_asg_total'); ?> :</label>
							<div class="col-sm-8"><strong><span class='total form-control'>-</span></strong></div>
						</div>
					</div>
				</div><p>&nbsp;</p>
				<div class="col-sm-12 type_one type_warehouse type_custom_clearence type_internal_dist" >
					<fieldset style='width:100%; overflow-x:auto;'>
						<legend><?php echo lang('form_asg_detail'); ?> :</legend>
						<table class="table table-hover table-bordered">
							<thead>
							  <tr>
								<th>No</th>
								<th><?php echo lang('tbl_asg_dtl_partno'); ?></th>
								<th><?php echo lang('tbl_asg_dtl_dsc'); ?></th>
								<th><?php echo lang('tbl_asg_dtl_qty'); ?></th>
								<th><?php echo lang('tbl_asg_dtl_weight'); ?></th>
								<th><?php echo lang('tbl_asg_dtl_uom'); ?></th>
								<th class='detail_warehouse_only' ><?php echo lang('tbl_asg_dtl_cemical'); ?></th>
								<th class='detail_import'><?php echo lang('tbl_asg_dtl_dimesi'); ?></th>
								<th class='detail_import'><?php echo lang('tbl_asg_dtl_pono'); ?></th>
								<th class='detail_import'><?php echo lang('tbl_asg_dtl_acreg'); ?></th>
								<th class='detail_import'><?php echo lang('tbl_asg_dtl_payment'); ?></th>
								<th class='detail_import'><?php echo lang('tbl_asg_dtl_goods'); ?></th>
								<th class='detail_import'><?php echo lang('tbl_asg_dtl_goodsctg'); ?></th>
								<th class='detail_import'><?php echo lang('tbl_asg_dtl_curency'); ?></th>
							  </tr>
							</thead>
							<tbody class='body_item'>
							</tbody>
						</table>
					</fieldset>
				</div><p>&nbsp;</p>
				<div class="alert alert-info" id='blok_notes'>
				</div>
				<div style='clear:both;'>&nbsp;</div>
			</div>
			<div class="modal-footer">
				<div style='float:left' id="pesan-asign"></div>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('btn_close'); ?></button>
				<button type="button" id='lnm-btn' class="btn btn-warning" ><?php echo lang('btn_asg_lnm'); ?></button>
				<button type="submit" id='asign-btn' class="btn btn-primary" ><?php echo lang('btn_asg_asgprice'); ?></button>
				<button type="button" id='edit-btn' class="btn btn-info" ><?php echo lang('btn_asg_upprice'); ?> </button>
			</div>
		</div>
	</form>
	</div>
</div>

<script>
$(document).ready(function(){
	$('#form-assign input').popover({
        title: ' ',
        trigger: 'focus',
        placement: 'right',
        html: 'true',
        container: 'body'
    }).on('keyup focus', function () {
        var element = $(this)
        var content = element.val();
        var noCaps = numberWithCommas(content);
        var msg = '<font size="3" color="red">' + noCaps + ' </font>';

        //This is the important stuff
        var popover = element.attr('data-content', msg).data('bs.popover');
        popover.setContent();
        popover.$tip.addClass(popover.options.placement);
    });
});

</script>
