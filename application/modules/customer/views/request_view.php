<?php $timestamp = time();?>
<nav class="navbar navbar-default  no-margin" role="navigation" style="padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;">
	<div class="navbar-left">
		<div class="btn-group">
			<?php
			if($this->session->userdata('level')==USER_CUSTOMER){
				echo'<button class="btn btn-success navbar-btn " id="add-request-'.$timestamp.'"><i class="glyphicon glyphicon-plus"></i> Add Request</button> ';
				echo '<button class="btn btn-info navbar-btn " id="edit-'.$timestamp.'" ><i class="glyphicon glyphicon-pencil"></i> Edit Request </button> ';
				echo '<button class="btn btn-danger navbar-btn " id="delete-'.$timestamp.'"><i class="glyphicon glyphicon-remove"></i> Reject</button> ';
			}

			if($this->session->userdata('level')==USER_SALES){
				echo'<button class="btn btn-info navbar-btn " id="add-assign-'.$timestamp.'"><i class="glyphicon glyphicon-pencil"></i> Assign Price </button> ';
				echo'<button class="btn btn-warning navbar-btn " id="edit-assign-'.$timestamp.'"><i class="glyphicon glyphicon-pencil"></i> Edit Price </button> ';
			}
			?>
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


<?php if($this->session->userdata('level')==USER_SALES || $this->session->userdata('level')==USER_GMF_LNM ||$this->session->userdata('level')== USER_GMF_LNM ){
	$this->load->view('sales/assign_modal');
	//$this->load->view('sales/edit_assign_modal');
}?>
<!-- Dialog Form Add Request -->
<div id="Modal-request-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Form Request <span id="info_id">[ID : ]</span></h4>
      </div>
	  <form class="form-horizontal" id='form-request-<?php echo $timestamp; ?>' action='<?php echo site_url('customer/request/proses'); ?>' method='POST'>
		  <input type="hidden" name='id' id="tex_id" readonly />
		  <div class="modal-body">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="col-sm-4 control-label" for="">Request Type :</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input name='request_type' class='request_type kendodropdown form-control'  style="width: 250px;" />
						</div>
					</div>
				</div>
				<div class="form-group request_one">
					<label class="col-sm-4 control-label" id='label_mitra'>Shiper Name :</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" name="partner" id="" class="form-control" placeholder="Partner Name" readonly>
							<span class="input-group-btn">
								<button type="button" id="find_partner" class="find btn btn-primary">Find</button>
							</span>
						</div>
					</div>
				</div>

				<div class="form-group request_one">
					<label class="col-sm-4 control-label" for="">Port Origin :</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" name="origin" id="" class="form-control" placeholder="Port Origin" readonly>
							<span class="input-group-btn">
								<button type="button" id="find_origin" class="find btn btn-primary">Find</button>
							</span>
						</div>
					</div>
				</div>

				<div class="form-group request_one">
					<label class="col-sm-4 control-label" for="">Port Destination :</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" name="destination" id="" class="form-control" placeholder="Port Destination" readonly>
							<span class="input-group-btn">
								<button type="button" id="find_dest" class="find btn btn-primary">Find</button>
							</span>
						</div>
					</div>
				</div>

				<div class="form-group request_one">
					<label class="col-sm-4 control-label" for="">Incoterm:</label>
					<div class="col-sm-8">
						<input name='incoterm' class='kendodropdown form-control' style="width: 100%;" />
					</div>
				</div>

				<div class="form-group request_one_clearance" style='display:none;'>
					<label class="col-sm-4 control-label" for="">Awb Number:</label>
					<div class="col-sm-8">
						<input type='text' name='awb' class='form-control'/>
					</div>
				</div>

				<div class="form-group request_one_clearance" style='display:none;'>
					<label class="col-sm-4 control-label" for="">Estimate Time Arrival:</label>
					<div class="col-sm-8">
						<input type='text' name='ata' class='datepicker form-control' value='<?php echo date('Y-m-d'); ?>'/>
					</div>
				</div>

				<div class="form-group request_one_gudang" style='display:none;'>
					<label class="col-sm-4 control-label" for="">Estimased Incoming Date:</label>
					<div class="col-sm-8">
						<input type='text' name='eid' class='form-control datepicker' value='<?php echo date('Y-m-d'); ?>'/>
					</div>
				</div>

				<div class="form-group request_one_gudang" style='display:none;'>
					<label class="col-sm-4 control-label" for="">Estimated Outgoing Date:</label>
					<div class="col-sm-8">
						<input type='text' name='eod' class='form-control datepicker' value='<?php echo date('Y-m-d'); ?>'/>
					</div>
				</div>

				<div class="form-group request_one_internal" style='display:none;'>
					<label class="col-sm-4 control-label" for="">Ship From :</label>
					<div class="col-sm-8">
						<input type='text' name='shp_from' class='form-control'/>
					</div>
				</div>

				<div class="form-group request_one_internal" style='display:none;'>
					<label class="col-sm-4 control-label" for="">Ship To :</label>
					<div class="col-sm-8">
						<input type='text' name='shp_to' class='form-control'/>
					</div>
				</div>

				<div class="form-group request_one_internal" style='display:none;'>
					<label class="col-sm-4 control-label" for="">Payment Responsibility :</label>
					<div class="col-sm-8">
						<input type='text' name='paymen_res' class='form-control'/>
					</div>
				</div>

				<div class="form-group request_one_internal" style='display:none;'>
					<label class="col-sm-4 control-label" for="">Execution Date :</label>
					<div class="col-sm-8">
						<input type='text' name='eksec_date' class='datepicker form-control' value='<?php echo date('Y-m-d'); ?>'/>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group request_one">
					<label class="col-sm-4 control-label" for="">Reference:</label>
					<div class="col-sm-6">
						<input type='text' name='cpo' class='form-control'/>
					</div>
				</div>

				<div class="form-group request_one">
					<label class="col-sm-4 control-label" for="">Shipment Mode:</label>
					<div class="col-sm-8">
						<input name='shipment_mode' class='kendodropdown form-control' style="width: 100%;" />
					</div>
				</div>

				<div class="form-group request_one">
					<label class="col-sm-4 control-label" for="">Special Request:</label>
					<div class="col-sm-8">
						<input type='text' name='special_request' class='form-control'/>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label" for="">Request Date:</label>
					<div class="col-sm-8">
						<input type='text' name='date' class='sdatepicker form-control' value='<?php echo date('Y-m-d'); ?>' readonly/>
					</div>
				</div>

				<div class="form-group request_one_import">
					<label class="col-sm-4 control-label" for="">Shipment Priority:</label>
					<div class="col-sm-8">
						<input type='text' name='shipment_priority' class='form-control kendodropdown'/>
					</div>
				</div>

				<?php if($this->session->userdata('pbth')=='Yes'){ ?>
					<div class="form-group request_one_import">
						<label class="col-sm-4 control-label" for="">&nbsp;</label>
						<div class="col-sm-8">
							<input id="pbth"  name="pbth" value='Yes' type="checkbox"> &nbsp; Subjected PBTH
						</div>
					</div>
				<?php } ?>

			</div>
			<div class='col-sm-12'>
				<div class="form-group request_one_clearance" style='display:none;'>
					<label class="col-sm-2 control-label" for="">Copy Of AWB:</label>
					<div class="col-sm-10">
						<div class="file_item"></div>
						<div id='upload-file' class="dropzone"></div>
						<small>accept type files : .pdf, .doc, .docx</small>
					</div>
				</div>
			</div>
			<div class="col-sm-12 request_one request_one_clearance  ">
				<fieldset>
					<legend>Item to send:</legend>
				</fieldset>
				<div id="item-<?php echo $timestamp; ?>">&nbsp;</div>
			</div>
			<div class="col-sm-12   request_one_gudang request_one_internal" style="display:none;">
				<fieldset>
					<legend>Item to send:</legend>
				</fieldset>
				<div id="item_dua-<?php echo $timestamp; ?>">&nbsp;</div>
			</div>
			<div style='clear:both;'>&nbsp;</div>
			<div class="col-sm-12 request_two">
				<fieldset>
					<legend>Request Description:</legend>
				</fieldset>
				<textarea name='request_desc' class='form-control'></textarea>
			</div>
			<div style='clear:both;'>&nbsp;</div>
		  </div>
		  <div class="modal-footer">
			<div style='float:left' id="pesan"></div>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary" >Proses</button>
		  </div>
			<input type='hidden' id='upload_file' name='upload_file' value='' readonly>
	  </form>
    </div>

  </div>
</div>


<script type="text/javascript">
var record=0;
var viewModel= {'param': { 'id':''}};

function removeFile(fileName){
	var text 		= $('#upload_file').val();
	var ar_text 	= text.split('|');
	var obj		 	= '';

	for(i=0; i< ar_text.length; i++ ){
		if(ar_text[i] !=fileName && ar_text[i] !=''){
			obj += "|"+ar_text[i];
		}
	}
	var repid = fileName.replace('.','_');
	$('.'+repid).hide();
	$('#upload_file').val(obj);
}


$(document).ready(function(){

	<?php echo $js_cmb; ?>

	var fileList = new Array;
	var i = 0;
	$("#upload-file").dropzone({
	 	url: "<?php echo site_url('app/upload'); ?>",
		addRemoveLinks:true,
		acceptedFiles: ".pdf, .doc, .docx",
		success: function(file, response){
			data = JSON.parse(response);
			var obj = $('#upload_file').val();
			var new_obj = obj+"|"+data.file;
			$('#upload_file').val(new_obj);
			$(file.previewTemplate).append('<span class="server_file" style="display:none;">'+data.file+'</span>');
		},removedfile: function(file) {
			var server_file = $(file.previewTemplate).children('.server_file').text();
			removeFile(server_file);
			var del_file = file.name;
			$.post('<?php echo site_url('app/remove_file'); ?>',{"file":server_file},function(res){

			});
			var previewElement;
			return (previewElement = file.previewElement) != null ? (previewElement.parentNode.removeChild(file.previewElement)) : (void 0);

		},init: function() {

		}
	});


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

	$('#info-request-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_request,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: false,
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
			{title:"<input id='myCheckbox' type='checkbox' onClick='toggle(this)' /> All<br/>",width:20},
			{field:"id",width:300,title:"Request No"},
			{field:"request_type",width:500,title:"Request Type"},
			{field:"status",width:300,title:"Status",filterable: false},
			{field:"date",width:300, title:"Request Date",filterable: false},
			{field:"nama_partner",width:500,title:"Shiper Name",filterable: false},
			{field:"origin_name",width:300,title:"Port Origin",filterable: false, },
			{field:"dest_name",width:300,title:"Port Destination",filterable: false, },
			{field:"inco_term",width:300,title:"Incoterm",filterable: false, },
			{field:"shipment_mode",width:300,title:"Shipment Mode",filterable: false},
		]
	});




	var ds_detail = new kendo.data.DataSource({
		transport: {
			read:  {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('customer/request/request_item'); ?>',
				data: function() { return JSON.parse(JSON.stringify(viewModel.param)); }

			},
			create: {
				url: '<?php echo site_url('customer/request/proses_item'); ?>',
				type:"POST",
				dataType: "json"
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
					qty: { type: "number", validation: { required: true, min: 1} },
					weight: { type: "number", validation: { required: true, min: 1} },
					acregis: {  type: "text", validation: { required: true} },
					paymentres: {  type: "text", validation: { required: true} },
					uom: { defaultValue: { id: 'KG', uom: "KG"} },
					packaging: { defaultValue: { id: '', packaging: ""} },
					cat_packaging: { defaultValue: { id: 'Non DG', cat_packaging: "Non DG"} },
				}
			}
		}
	});

	var ds_detail_dua = new kendo.data.DataSource({
		transport: {
			read:  {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('customer/request/request_item'); ?>',
				data: function() { return JSON.parse(JSON.stringify(viewModel.param)); }

			},
			create: {
				url: '<?php echo site_url('customer/request/proses_item_dua'); ?>',
				type:"POST",
				dataType: "json"
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
					qty: { type: "number", validation: { required: true, min: 1} },
					uom: { defaultValue: { id: 'KG', uom: "KG"} },
					cemical: { defaultValue: { id: '', cemical: ""} },
				}
			}
		}
	});

	$("#item-<?php echo $timestamp; ?>").kendoGrid({
		dataSource: ds_detail,
		pageable: false,
		scrollable: true,
		height: 300,
		toolbar: ["create"],
		dataBinding: function() {
		  record = (this.dataSource.page() -1) * this.dataSource.pageSize();
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
		//editable: true,
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
			{
				filterable: false,
				template: "#: ++record #",
				width: 50,
				title:"NO"
			},
			{field:"part_number",width: 300, title:"Part Number",filterable: false},
			{field:"part_desc",width: 300,title:"Part Desc",filterable: false},
			{field:"qty",title:"Qty",width: 100,filterable: false},
			{field:"uom.uom",title:"Uom",width: 220, editor: categoryDropDownEditor},
			{field:"weight",title:"Weight",width: 100,filterable: false},
			{field:"dimensi",title:"Dimensi",width: 100,filterable: false},
			{field:"ponumber",title:"PO Number",width: 100,filterable: false},
			{field:"remark",title:"Remark",width: 100,filterable: false},
			{field:"acregis",title:"A/C Registrasi",width: 100,filterable: false},
			{field:"paymentres",title:"Payment Responsibility",width: 300,filterable: false},
			{field:"value_of_goods",title:"Value of Goods",width: 250,filterable: false},
			{field:"curency",title:"Currency",width: 100,filterable: false},
			{field:"packaging.packaging",title:"Packaging",width: 220, editor:cmb_packaging},
			{field:"cat_packaging.cat_packaging",title:"Goods Category",width: 220, editor:cmb_kategoridg},
			{ command: ["destroy"], title: "&nbsp;", width: "250px" },
		]
	});


	$("#item_dua-<?php echo $timestamp; ?>").kendoGrid({
		dataSource: ds_detail_dua,
		pageable: false,
		scrollable: true,
		height: 300,
		toolbar: ["create"],
		dataBinding: function() {
		  record = (this.dataSource.page() -1) * this.dataSource.pageSize();
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
		//editable: true,
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
			{
				filterable: false,
				template: "#: ++record #",
				width: 50,
				title:"NO"
			},
			{field:"part_number",width: 300, title:"Part Number",filterable: false},
			{field:"part_desc",width: 300,title:"Part Desc",filterable: false},
			{field:"qty",title:"Qty",width: 100,filterable: false},
			{field:"dimensi",title:"Dimensi",width: 100,filterable: false},
			{field:"uom.uom",title:"Uom",width: 220, editor: categoryDropDownEditor},
			{field:"remark",title:"Remark",width: 100,filterable: false},
			{field:"cemical.cemical",title:"Material Type",width: 220,editor: cemical},
			{ command: ["destroy"], title: "&nbsp;", width: "250px" },
		]
	});


	kendoWindow = $("<div />").kendoWindow({
		title: "Dialog Pencarian",
		width: "500px",
		height: "450px",
		resizable: false,
		modal: true,
	});


	$('.find').click(function(){
		 kendoWindow.data("kendoWindow")
			.content($("#detail-nasabah").html())
			.center().open();
		var ceksum = $(this).attr('id'), curUrl = '',titleId='',fieldCstm='',type='';

		if(ceksum=='find_partner'){
			curUrl ='<?php echo site_url('master/partner/get'); ?>';
			titleId ='Partner';
			fieldCstm ='partner';
			type ='PARTNER';
		}else if(ceksum=='find_origin'){
			curUrl ='<?php echo site_url('app/port'); ?>';
			titleId ='Port';
			type ='ORIGIN';
			fieldCstm ='port_name';
		}else{
			curUrl ='<?php echo site_url('app/port'); ?>';
			titleId ='Port';
			type ='DEST';
			fieldCstm ='port_name';
		}

		var ds_find = new kendo.data.DataSource({
			transport: {
				read: {
					type:"POST",
					dataType: "json",
					url: curUrl,
				}
			},
			schema: {
				parse: function(response){
					return response.data;
				},
			},
			pageSize: 100,
		});

		kendoWindow.find('.myGrid').kendoGrid({
			dataSource: ds_find,
			filterable: true,
			sortable: true,
			pageable: true,
			height: "400px",
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
					title:"PILIH",
					width:20,
					template: '<button  onClick="selectItem(this.id);" id="'+type+'-#: id #-#: '+fieldCstm+' #" class="pilih btn btn-xs btn-primary">PILIH</button>',
				},{field:"id",title:titleId+" ID"},
				{field:fieldCstm,title:titleId+" Name"},
			]
		});
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

	$('.request_two').hide();
	$('.request_one_clearance').hide();
	$('.request_one').show();
	cmb['request_type'].bind('change',function(){
		var myval =cmb['request_type'].value();
		if(myval=='IMPORT')
			$('#label_mitra').html('Shiper Name');
		else
			$('#label_mitra').html('Consignee Name');

		if(myval=='EXPORT' || myval=='DOMESTIC DISTRIBUTION'){
			$('.request_one_clearance').hide();
			$('.request_one_gudang').hide();
			$('.request_one_internal').hide();
			$('.request_one_import').hide();
			$('.request_two').hide();
			$('.request_one').show();
		}else if(myval=='IMPORT'){
			$('.request_one_clearance').hide();
			$('.request_one_gudang').hide();
			$('.request_one_internal').hide();
			$('.request_two').hide();
			$('.request_one').show();
			$('.request_one_import').show();
		}else if(myval=='CUSTOM CLEARANCE'){
			$('.request_one').hide();
			$('.request_one_import').hide();
			$('.request_one_internal').hide();
			$('.request_one_gudang').hide();
			$('.request_two').show();
			$('.request_one_clearance').show();
		}else if(myval=='WAREHOUSE LEASE'){
			$('.request_one').hide();
			$('.request_one_internal').hide();
			$('.request_one_clearance').hide();
			$('.request_one_import').hide();
			$('.request_two').show();
			$('.request_one_gudang').show();
		}else if(myval=='INTERNAL DISTRIBUTION'){
			$('.request_one').hide();
			$('.request_one_clearance').hide();
			$('.request_one_gudang').hide();
			$('.request_one_import').hide();
			$('.request_two').show();
			$('.request_one_internal').show();
		}else{
			$('.request_one_internal').hide();
			$('.request_one_clearance').hide();
			$('.request_one_gudang').hide();
			$('.request_one_import').hide();
			$('.request_one').hide();
			$('.request_two').show();
		}


	});

	$('#additem-<?php echo $timestamp; ?>').click(function(e){
		e.preventDefault();
		$.ajax({
			url:'<?php echo site_url('customer/request/add_item'); ?>',
			data:$('#form-request-<?php echo $timestamp; ?>').serialize(),
			type:'POST',
			dataType:'json',tail:1,
			beforeSend:function(){
				$('#pesan').html('');
				$('#pesan').addClass('loader2');
			},
			success:function(res){
				ds_detail.read();
				$('#pesan').html(res.messages);
				$('#form-request-<?php echo $timestamp; ?> input[name=weight_item]').val('');
				$('#form-request-<?php echo $timestamp; ?> input[name=item]').val('');
			}
		}).done(function(){
			$('#pesan').removeClass('loader2');
			setTimeout(function(){
				$("#pesan").html("");
			}, 3000);
		});
	});

	$('#reload-<?php echo $timestamp; ?>').click(function(){
		ds_request.read();
	});

	$("#add-request-<?php echo $timestamp; ?>").click(function(){
		$("#info_id").hide();
		$("#text_id").html('');
		$(".file_item").html('');
		$('#form-request-<?php echo $timestamp; ?> input[name=weight_item]').val('');
		$('#form-request-<?php echo $timestamp; ?> input[name=item]').val('');
		$('#form-request-<?php echo $timestamp; ?> input[name=partner]').val('');
		$('#form-request-<?php echo $timestamp; ?> input[name=origin]').val('');
		$('#form-request-<?php echo $timestamp; ?> input[name=destination]').val('');
		$('#form-request-<?php echo $timestamp; ?> input[name=cpo]').val('');
		$('#form-request-<?php echo $timestamp; ?> input[name=special_request]').val('');
		$('#form-request-<?php echo $timestamp; ?> textarea[name=request_desc]').val('');
		$('#form-request-<?php echo $timestamp; ?> input[name=awb]').val('');
		$('#form-request-<?php echo $timestamp; ?> input[name=ata]').val('<?php echo date('Y-m-d'); ?>');
		$('#form-request-<?php echo $timestamp; ?> input[name=upload_file]').val('');
		$('#form-request-<?php echo $timestamp; ?> input[name=shp_from]').val('');
		$('#form-request-<?php echo $timestamp; ?> input[name=shp_to]').val('');
		$('#form-request-<?php echo $timestamp; ?> input[name=paymen_res]').val('');
		//$('#form-request-<?php echo $timestamp; ?> input[type=text]').val('');
		//cmb['request_type'].value('IMPORT');
		viewModel= {'param': { 'id':''}};
		ds_detail.read();
		$('#Modal-request-<?php echo $timestamp; ?>').modal('show');
		$('#form-request-<?php echo $timestamp; ?> input[name=id]').val('');
	});

	$("#form-request-<?php echo $timestamp; ?>").submit(function(e){
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
					ds_request.read();
					var myval =cmb['request_type'].value();
					if(myval=='IMPORT' || myval=='EXPORT'  ||  myval=='DOMESTIC DISTRIBUTION'|| myval=='CUSTOM CLEARANCE'){
						ds_detail.sync();
						viewModel= {'param': { 'id':''}};
						ds_detail.read();
					}

					if(myval=='INTERNAL DISTRIBUTION' ||  myval=='WAREHOUSE LEASE'){
						ds_detail_dua.sync();
						viewModel= {'param': { 'id':''}};
						ds_detail_dua.read();
					}

					msg_box(res.messages,['btnOK'],'Info!');
					if(myval=='CUSTOM CLEARANCE'){
						$('#upload-file').html('<div class="dz-default dz-message"><span>Drop files here to upload</span></div>');
					}

					$('#form-request-<?php echo $timestamp; ?> input[name=weight_item]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=item]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=partner]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=origin]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=destination]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=cpo]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=special_request]').val('');
					$('#form-request-<?php echo $timestamp; ?> textarea[name=request_desc]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=awb]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=ata]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=upload_file]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=shp_from]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=shp_to]').val('');
					$('#form-request-<?php echo $timestamp; ?> input[name=paymen_res]').val('');

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

	$('#delete-<?php echo $timestamp; ?>').click(function(){
		var txt;
		var checkedVals = $('.requestId:checkbox:checked').map(function() {
			return this.value;
		}).get();


		if(checkedVals !=''){
			msg_box("Reject data Request Id ("+checkedVals+")...?",[{'btnYES':function(){
				var customerId= checkedVals.join(",");
				$(this).trigger('closeWindow');
				$.ajax({
					url:'<?php echo site_url('customer/request/reject'); ?>',
					data:'id='+customerId,
					type:'POST',
					dataType:'json',tail:1,
					beforeSend:function(){
						//$('#pesan').addClass('loader2');
					},
					success:function(res){
						if(res.status){
							ds_request.read();
						}
						msg_box(res.messages,['btnOK'],'Info!');
					}
				});

			}},'btnNO'],'Konfirmasi');

		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});


	$("#add-assign-<?php echo $timestamp; ?>, #edit-assign-<?php echo $timestamp; ?>").click(function(){
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
			$('#cgk_handling').val('0');
			$('#origin_charge').val('0');
			$('#dest_charges').val('0');
			$('#warehouse_charge').val('0');
			$('#packaging_charge').val('0');
			$('#fumigation_charge').val('0');
			$('#duty_charge').val('0');
			$('#allin_charge').val('0');
			$('.export_only').hide();
			$('.import_only').hide();
			$('.ware_house_lease_no').hide();

			$.ajax({
				url:'<?php echo site_url('customer/request/get'); ?>',
				data:'id='+checkedVals,
				type:'POST',
				dataType:'json',tail:1,
				beforeSend:function(){
					$('#pesan').addClass('loader2');
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

					//if(total_price_cek > 0){
						$('#service_charges').val(services);
						$('#freight_charges').val(freight);
						$('#transport_charges').val(transport);
						$('#dg_charges').val(dg);
						$('#cgx_charges').val(cgx);
						$('#curency_carges').val(curency);

						$('#Origin_charge').val(origin_charges);
						$('#dest_charges').val(dest_charge);
						$('#warehouse_charge').val(warehouse);
						$('#packaging_charge').val(packaging);
						$('#fumigation_charge').val(fumigation);
						$('#duty_charge').val(duty_charges);
						$('#allin_charge').val(allin);
						$('#cgk_handling').val(cgk_handling);

						$('.total').html(total_price_cek);
					//}
					if(res.data[0].status==1 && myId=='edit-assign-<?php echo $timestamp; ?>' || res.data[0].status==6 && myId=='edit-assign-<?php echo $timestamp; ?>'){
						msg_box('<?php echo lang('msg_asg_neverasg'); ?>',['btnOK'],'Info!');
					}else if(res.data[0].status==2 && myId=='add-assign-<?php echo $timestamp; ?>'){
						msg_box('<?php echo lang('msg_asg_everasg'); ?>',['btnOK'],'Info!');
					}else if(res.data[0].status==6 && total_price_cek ==0){
						msg_box('<?php echo lang('msg_asg_waiting'); ?>',['btnOK'],'Info!');
					}else{
						$('#Modal-assign').modal('show');
						var reqType = res.data[0].request_type;
						if(reqType=='IMPORT' || reqType=='EXPORT' || reqType=='DOMESTIC DISTRIBUTION'){
							$('.type_two').hide();
							$('.type_warehouse').hide();
							$('.type_custom_clearence').hide();
							$('.type_internal_dist').hide();
							$('.ware_house_lease_no').show();
							$('.type_one').show();
							if(reqType=='EXPORT')
								$('.export_only').show();
							if(reqType=='IMPORT')
								$('.import_only').show();

						}else if(reqType=='INTERNAL DISTRIBUTION'){
							$('.type_warehouse').hide();
							$('.type_one').hide();
							$('.type_custom_clearence').hide();
							$('.ware_house_lease_no').show();
							$('.type_internal_dist').show();
							$('.type_two').show();
						}else if(reqType=='CUSTOM CLEARANCE'){
							$('.type_one').hide();
							$('.type_internal_dist').hide();
							$('.type_warehouse').hide();
							$('.ware_house_lease_no').hide();
							$('.type_custom_clearence').show();
							$('.type_two').show();
						}else if(reqType=='WAREHOUSE LEASE'){
							$('.type_internal_dist').hide();
							$('.type_custom_clearence').hide();
							$('.ware_house_lease_no').hide();
							$('.type_one').hide();
							$('.type_warehouse').show();
							$('.type_two').show();
						}else{
							$('.type_internal_dist').hide();
							$('.type_custom_clearence').hide();
							$('.type_warehouse').hide();
							$('.type_one').hide();
							$('.ware_house_lease_no').show();
							$('.type_two').show();
						}


						if(reqType=='CUSTOM CLEARANCE'){
							var myFile = res.data[0].awb_file;
							var ar_file = myFile.split('|');
							var file_item = '';

							for (var i = 0; i < ar_file.length; i++) {
								if(ar_file[i] !='')
									file_item +="<p><strong><a href='<?php echo base_url('uploads');?>/"+ar_file[i]+"' target='_blank'><i class='fa fa-paperclip' aria-hidden='true'></i>&nbsp;&nbsp;"+ar_file[i]+" </a></strong></p>";
							}
							$('#file_list_item').html(file_item);
						}

						$('#blok_notes').hide();
						if(res.data[0].user_notes !=''){
							$('#blok_notes').show();
							$('#blok_notes').html("<strong>Customer Notes ! </strong>&nbsp; "+res.data[0].user_notes);
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
						$('#lnm-btn').show();
						cmb['curency'].value(res.data[0].curency);
						//cmb['shipment_priority'].value(res.data[0].shp_priority);

						if(myId=='edit-assign-<?php echo $timestamp; ?>'){
							$('#lnm-btn').hide();
							$('#service_charges').val(res.data[0].service_charges);
							$('#freight_charges').val(res.data[0].freight_charges);
							$('#transport_charges').val(res.data[0].transport_charges);
							$('#dg_charges').val(res.data[0].dg_charges);
							$('#cgx_charges').val(res.data[0].cgx_charges);
							$('#curency_carges').val(res.data[0].curency_carges);

							$('#Origin_charge').val(res.data[0].origin_charges);
							$('#dest_charges').val(res.data[0].destination_charges);
							$('#warehouse_charge').val(res.data[0].warehouse_charge);
							$('#packaging_charge').val(res.data[0].packaging_charge);
							$('#fumigation_charge').val(res.data[0].fumigation_charge);
							$('#duty_charge').val(res.data[0].duty_charges);
							$('#allin_charge').val(res.data[0].allin_charges);

							$('#edit-btn').show();
							$('#asign-btn').hide();
						}else{
							$('#edit-btn').hide();
							$('#asign-btn').show();
						}

						$('.detail_import').hide();
						$('.detail_warehouse_only').hide();
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
								if(reqType=='WAREHOUSE LEASE'){
									$('.detail_warehouse_only').show();
									rowtable +='<td>'+rowItem[i].material_type+'</td>';
								}
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

	$('#lnm-btn').click(function(){
			$.ajax({
				url : '<?php echo site_url('sales/send_lnm');?>',
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


	$('#form-request-<?php echo $timestamp; ?>').bind("keypress", function(e) {
	  if (e.keyCode == 13) {
		e.preventDefault();
		return false;
	  }
	});

	$('#edit-<?php echo $timestamp; ?>').click(function(){
		var checkedVals = $('.requestId:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals.length ==1){
			var editId= checkedVals.join(",");
			$('#Modal-request-<?php echo $timestamp; ?>').modal('show');
			$.ajax({
				url:'<?php echo site_url('customer/request/get'); ?>',
				data:'id='+editId,
				type:'POST',
				dataType:'json',tail:1,
				beforeSend:function(){
					$('#pesan').addClass('loader2');
					$('.modal-body').hide();
				},
				success:function(res){
					var reqType = res.data[0].request_type;

					if(reqType=='EXPORT' || reqType=='DOMESTIC DISTRIBUTION'){
						$('.request_one_clearance').hide();
						$('.request_one_gudang').hide();
						$('.request_one_internal').hide();
						$('.request_one_import').hide();
						$('.request_two').hide();
						$('.request_one').show();
					}else if(reqType=='IMPORT'){
						$('.request_one_clearance').hide();
						$('.request_one_gudang').hide();
						$('.request_one_internal').hide();
						$('.request_two').hide();
						$('.request_one').show();
						$('.request_one_import').show();
					}else if(reqType=='CUSTOM CLEARANCE'){
						$('.request_one').hide();
						$('.request_one_import').hide();
						$('.request_one_internal').hide();
						$('.request_one_gudang').hide();
						$('.request_two').show();
						$('.request_one_clearance').show();
					}else if(reqType=='WAREHOUSE LEASE'){
						$('.request_one').hide();
						$('.request_one_internal').hide();
						$('.request_one_clearance').hide();
						$('.request_one_import').hide();
						$('.request_two').show();
						$('.request_one_gudang').show();
					}else if(reqType=='INTERNAL DISTRIBUTION'){
						$('.request_one').hide();
						$('.request_one_clearance').hide();
						$('.request_one_gudang').hide();
						$('.request_one_import').hide();
						$('.request_two').show();
						$('.request_one_internal').show();
					}else{
						$('.request_one_internal').hide();
						$('.request_one_clearance').hide();
						$('.request_one_gudang').hide();
						$('.request_one_import').hide();
						$('.request_one').hide();
						$('.request_two').show();
					}

					$('#info_id').html(res.data[0].id);
					$('#form-request-<?php echo $timestamp; ?> input[name=id]').val(res.data[0].id);
					$('#form-request-<?php echo $timestamp; ?> input[name=partner]').val(res.data[0].partner+"-"+res.data[0].nama_partner);
					$('#form-request-<?php echo $timestamp; ?> input[name=origin]').val(res.data[0].port_origin+"-"+res.data[0].origin_name);
					$('#form-request-<?php echo $timestamp; ?> input[name=destination]').val(res.data[0].port_dest+"-"+res.data[0].dest_name);
					$('#form-request-<?php echo $timestamp; ?> input[name=cpo]').val(res.data[0].cpo);
					$('#form-request-<?php echo $timestamp; ?> input[name=special_request]').val(res.data[0].special_request);
					$('#form-request-<?php echo $timestamp; ?> textarea[name=request_desc]').val(res.data[0].req_desc);
					$('#form-request-<?php echo $timestamp; ?> input[name=date]').val(res.data[0].date);
					$('#form-request-<?php echo $timestamp; ?> input[name=awb]').val(res.data[0].awb);
					$('#form-request-<?php echo $timestamp; ?> input[name=ata]').val(res.data[0].ata);
					$('#form-request-<?php echo $timestamp; ?> input[name=upload_file]').val(res.data[0].awb_file);
					$('#form-request-<?php echo $timestamp; ?> input[name=shp_from]').val(res.data[0].shp_from);
					$('#form-request-<?php echo $timestamp; ?> input[name=shp_to]').val(res.data[0].shp_to);
					$('#form-request-<?php echo $timestamp; ?> input[name=paymen_res]').val(res.data[0].payment_res);
					$('#form-request-<?php echo $timestamp; ?> input[name=eksec_date]').val(res.data[0].exsec_date);
					cmb['incoterm'].value(res.data[0].inco_term);
					cmb['shipment_mode'].value(res.data[0].shipment_mode);
					cmb['request_type'].value(res.data[0].request_type);
					cmb['shipment_priority'].value(res.data[0].shp_priority);

					viewModel = kendo.observable({
						param: {
							id: res.data[0].id
						}
					});

					if(reqType=='INTERNAL DISTRIBUTION' ||  reqType=='WAREHOUSE LEASE'){
						ds_detail_dua.read();
					}else{
						ds_detail.read();
					}

					if(reqType=='CUSTOM CLEARANCE'){
						var myFile = res.data[0].awb_file;
						var ar_file = myFile.split('|');
						var file_item = '';

						for (var x = 0; x < ar_file.length; x++) {
							if(ar_file[x] !=''){
								var repid = ar_file[x].replace('.','_');
								file_item += '<div class="'+repid+'"> <button type="button"  id="'+ar_file[x]+'" onClick="removeFile(this.id)" class="dellist_file btn btn-default btn-sm">     <span class="glyphicon glyphicon-trash"></span> Delete      </button>  &nbsp; <a href="<?php echo base_url(); ?>/uploads/'+ar_file[x]+'" target="_blank">'+ar_file[x]+'</a></div>';
							}
						}
						$('.file_item').html(file_item);
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

	<?php if($this->session->userdata('level')==USER_SALES){ ?>
		$('#form-assign').submit(function(e){
			e.preventDefault();
			$.ajax({
				url:$(this).attr('action'),
				data:$(this).serialize(),
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

		$('#edit-btn').click(function(e){
			e.preventDefault();
			$.ajax({
				url:'<?php echo site_url('sales/edit_assign'); ?>',
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
	<?php } ?>
});

function toggle(source) {
  checkboxes = document.getElementsByClassName('requestId');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

function deleteItem(id){
	msg_box('Modeule sedang dalam proses',['btnOK'],'Info!');
}

function categoryDropDownEditor(container, options) {
	$('<input required name="' + options.field + '" style="width: 200px;" />')
		.appendTo(container)
		.kendoDropDownList({
			autoBind: false,
			//filter: "startswith",
			dataTextField: "uom",
			dataValueField: "id",
			dataSource: {
				serverFiltering: true,
				transport: {
					read: {
						dataType: "jsonp",
						url: "<?php echo site_url('app/uom'); ?>",
					}
				}
			}
		});
}

function cemical(container, options) {
	$('<input required name="' + options.field + '" style="width: 200px;" />')
		.appendTo(container)
		.kendoDropDownList({
			autoBind: false,
			dataTextField: "cemical",
			dataValueField: "id",
			dataSource: {
				serverFiltering: true,
				transport: {
					read: {
						dataType: "jsonp",
						url: "<?php echo site_url('app/cemical'); ?>",
					}
				}
			}
		});
}

function cmb_packaging(container, options) {
	$('<input required name="' + options.field + '" style="width: 200px;" />')
		.appendTo(container)
		.kendoDropDownList({
			autoBind: false,
			//filter: "startswith",
			dataTextField: "packaging",
			dataValueField: "id",
			dataSource: {
				//serverFiltering: true,
				transport: {
					read: {
						dataType: "jsonp",
						url: "<?php echo site_url('app/packaging'); ?>",
					}
				}
			}
		});
}


function cmb_kategoridg(container, options) {
	$('<input required name="' + options.field + '" style="width: 200px;" />')
		.appendTo(container)
		.kendoDropDownList({
			autoBind: false,
			//filter: "startswith",
			dataTextField: "cat_packaging",
			dataValueField: "id",
			dataSource: {
				//serverFiltering: true,
				transport: {
					read: {
						dataType: "jsonp",
						url: "<?php echo site_url('app/category_packaging'); ?>",
					}
				}
			}
		});
}

function selectItem(id){
	var record = id.split('-');
	var valls = record[1]+'-'+record[2];

	 if(record[0]=='PARTNER')
		$('#form-request-<?php echo $timestamp; ?> input[name=partner]').val(valls);
	else if(record[0]=='ORIGIN')
		$('#form-request-<?php echo $timestamp; ?> input[name=origin]').val(valls);
	else if(record[0]=='DEST')
		$('#form-request-<?php echo $timestamp; ?> input[name=destination]').val(valls);

	kendoWindow.data("kendoWindow").close();
}
</script>

<script id="detail-nasabah" type="text/x-kendo-template">
	<div class="myGrid"></div>
</script>

<style>
@media (min-width: 768px) {
  .modal-xl {
    width: 90%;
   max-width:1200px;
  }
}
</style>
