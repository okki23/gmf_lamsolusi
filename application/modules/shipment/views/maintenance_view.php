<?php $timestamp = time();?>
<form class="form-horizontal" id='form-maintenance-<?php echo $timestamp; ?>' action='<?php echo site_url('shipment/maintenance/add'); ?>' method='POST'>
	<div class="form-group">
		<label class="col-sm-3 control-label" for=""><?php echo lang('form_shp_awbnumber'); ?> :</label>
		<div class="col-sm-3">
			<input type='text' name='awb' class='form-control'/>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label" for=""><?php echo lang('form_shp_etd_date'); ?> :</label>
		<div class="col-sm-9">
			<input type='text' name='date_atd' class='datepicker form-control' value="<?php echo date('Y-m-d'); ?>"/>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label" for=""><?php echo lang('form_shp_eta_date'); ?> :</label>
		<div class="col-sm-9">
			<input type='text' name='date_ata' class='datepicker form-control' value="<?php echo date('Y-m-d'); ?>"/>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label" for=""><?php echo lang('form_shp_origin'); ?> :</label>
		<div class="col-sm-4">
			<div class="input-group">
				<input type="text" name="origin" id="" class="form-control" placeholder="Port Origin" readonly>
				<span class="input-group-btn">
					<button type="button" id="find_origin" class="find btn btn-primary"><?php echo lang('btn_src'); ?></button>
				</span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label" for=""><?php echo lang('form_shp_dest'); ?> :</label>
		<div class="col-sm-4">
			<div class="input-group">
				<input type="text" name="destination" id="" class="form-control" placeholder="Port Destination" readonly>
				<span class="input-group-btn">
					<button type="button" id="find_dest" class="find btn btn-primary"><?php echo lang('btn_src'); ?></button>
				</span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label" for=""><?php echo lang('form_shp_flight'); ?> :</label>
		<div class="col-sm-4">
			<input type='text' name='schadule' class='form-control'/>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label" for="">Kilo/Colli :</label>
		<!--<label class="col-sm-3 control-label" for=""><?php echo lang('form_shp_kilo_colli'); ?> :</label>-->
		<div class="col-sm-4">
			<input type='text' name='kilo_colli' class='form-control'/>
		</div>
	</div>

	<div class="form-group">
		<!--<label class="col-sm-3 control-label" for=""><?php echo lang('form_shp_ref'); ?> :</label> -->
		<label class="col-sm-3 control-label" for=""><?php echo lang('form_shp_ref'); ?> :</label> 
		<div class="col-sm-9">
			<div class="input-group" style='width:500px;'>
				<input type="text" name="reference" id="" class="form-control" placeholder="Reference" readonly>
				<span class="input-group-btn">
					<button type="button" id="find_ref" class="btn btn-primary"><?php echo lang('btn_src'); ?></button>
				</span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label" for=""><?php echo lang('form_shp_ref_detail'); ?> :</label>
		<div class='col-sm-9'>
			<table class="table table-hover table-bordered">
				<thead>
				  <tr>
					<th><input id='myCheckbox2' type='checkbox' onClick='toggle2(this)' /> All<br/></th>
					<th>Request Number</th>
					<th>Part Number</th>
					<th>Part Desc</th>
					<th>qty</th>
					<th>Bonus</th>
					<th>Weigh</th>
					<th>Uom</th>
					<th>Dimensi</th>
				  </tr>
				</thead>
				<tbody class='body_item'>

				</tbody>
			</table>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label" for="">&nbsp;</label>
		<div class="col-sm-2">
			<button type="reset" class="btn btn-default" >Reset</button>
			<button type="submit" class="btn btn-primary" >Proses</button>
		</div>
		<div  style ='float:left;' id='pesan'></div>
	</div>
</form>

<script id="detail-nasabah" type="text/x-kendo-template">
	<div class="button"></div>
	<div class="myGrid"></div>
</script>

<script>
$(document).ready(function(){
	kendoWindow = $("<div />").kendoWindow({
		title: "<?php echo lang('window_src'); ?>",
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

		if(ceksum=='find_origin'){
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
		kendoWindow.find('.button').html('');

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



	$('#form-maintenance-<?php echo $timestamp; ?>').submit(function(e){
		e.preventDefault();
		$.ajax({
			url:$(this).attr('action'),
			data:$(this).serialize(),
			type:'POST',
			dataType:'json',tail:1,
			beforeSend:function(){
				$('#pesan').addClass('loader2');
			},
			success:function(res){

				if(res.status){
					msg_box(res.messages,['btnOK'],'Info!');

					$('#form-maintenance-<?php echo $timestamp; ?> input[name=awb]').val('');
					$('#form-maintenance-<?php echo $timestamp; ?> input[name=date_atd]').val('');
					$('#form-maintenance-<?php echo $timestamp; ?> input[name=date_ata]').val('');
					$('#form-maintenance-<?php echo $timestamp; ?> input[name=origin]').val('');
					$('#form-maintenance-<?php echo $timestamp; ?> input[name=dest]').val('');
					$('#form-maintenance-<?php echo $timestamp; ?> input[name=schadule]').val('');
					$('#form-maintenance-<?php echo $timestamp; ?> input[name=reference]').val('');
					$('.body_item').html('');
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


	$('#find_ref').click(function(){
		var origin 			= $('#form-maintenance-<?php echo $timestamp?> input[name=origin]').val();
		var destination = $('#form-maintenance-<?php echo $timestamp?> input[name=destination]').val();

		if(origin==''){
			msg_box('<?php echo lang('msg_shp_origin'); ?>',['btnOK'],'Info!');
		}else if(destination==''){
			msg_box('<?php echo lang('msg_shp_dest'); ?>',['btnOK'],'Info!');
		} else{
			kendoWindow.data("kendoWindow")
				.content($("#detail-nasabah").html())
				.center().open();

			var ds_find_ref = new kendo.data.DataSource({
				transport: {
					read: {
						type:"POST",
						dataType: "json",
						data:{
								'origin':origin,
								'destination': destination
							},
						url: '<?php echo site_url('shipment/maintenance/getReference'); ?>',
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
				dataSource: ds_find_ref,
				//filterable: true,
				filterable: {
            extra: false,
            operators: {
                string: {
                    startswith: "Starts with",
                    eq: "==",
                    neq: "!="
                }
            }
        },
				sortable: true,
				pageable: true,
				height: "380px",
				resizable: true,
				scrollable: true,
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
						title:"<input id='myCheckbox' type='checkbox' onClick='toggle(this)' /> All<br/>",
						width:60,
						template: '<input type="checkbox" class="requestId" name="requestId[]" value="#: id #">',
					},
					{field:"id",width:100,title:"ID", filterable:false},
					{
						field:"request_type",
						width:200,
						title:"Request Type",
						filterable: {
              ui: typeFilter
           	}
					},
					{field:"origin_name",width:150,title:"Port Origin", filterable:false},
					{field:"dest_name",width:150,title:"Port Destination", filterable:false},
					{field:"shipment_mode",width:80,title:"Shipment Mode", filterable:false},
				]
			});

			kendoWindow.find('.button').html('<button type="button" class="btn btn-primary" >Pilih Data</button><br>&nbsp;');


			kendoWindow.find('.button button').click(function(){
				var checkedVals = $('.requestId:checkbox:checked').map(function() {
					return this.value;
				}).get();
				var requestID= checkedVals.join(",");
				if(checkedVals !=''){

					var rowtable='';
					var rowItem='';
					$.ajax({
						url	:'<?php echo site_url('shipment/maintenance/referenceItem'); ?>',
						data:'id='+requestID,
						type:'POST',
						dataType:'json',tail:1,
						success:function(res){
							$('.body_item').html('');
							if(res.status){
								$('#form-maintenance-<?php echo $timestamp; ?> input[name=reference]').val(requestID);
								var no=1;
								for (i = 0; i < res.data.length; i++) {
									rowtable += '<tr>';
									rowtable += '<td> <input type="checkbox" class="item_id" name="item_id['+i+']" value="'+res.data[i].item_id+'"></td>';
									rowtable += '<td> <input type="hidden" name="request_id['+i+']" value="'+res.data[i].request_id+'"> '+res.data[i].request_id+'-'+res.data[i].item_id+'</td>';
									rowtable += '<td> <input type="hidden" name="part_number['+i+']" value="'+res.data[i].part_number+'"> '+res.data[i].part_number+'</td>';
									rowtable += '<td> <input type="hidden" name="part_desc['+i+']" value="'+res.data[i].part_desc+'">'+res.data[i].part_desc+'</td>';
									rowtable += '<td style="padding:0px;" ><input style="border-radius:0px;" size="2" type="text" class="form-control" name="qty['+i+']" value="'+res.data[i].qty+'"</td>';
									rowtable += '<td style="padding:0px;"> <select style="border-radius:0px;"  class="form-control" name="bonus['+i+']"><option value="no">NO</option><option value="yes">YES</option></select></td>';
									rowtable += '<td> <input type="hidden" name="weight['+i+']" value="'+res.data[i].weight+'">'+res.data[i].weight+'</td>';
									rowtable += '<td> <input type="hidden" name="uom['+i+']" value="'+res.data[i].uom+'">'+res.data[i].uom+'</td>';
									rowtable += '<td> <input type="hidden" name="dimensi['+i+']" value="'+res.data[i].dimensi+'">'+res.data[i].dimensi+'</td>';
									rowtable += '</tr>';
									no++;
								}
								$('.body_item').append(rowtable);
							}else
								msg_box(res.messages,['btnOK'],'Info!');
						}
					});
					kendoWindow.data("kendoWindow").close();
				}else
					msg_box('<?php echo lang('msg_null_select'); ?>',['btnOK'],'Info!');
			});
		}
		});

});

function selectItem(id){
	var record = id.split('-');
	var valls = record[1]+'-'+record[2];

	if(record[0]=='ORIGIN')
		$('#form-maintenance-<?php echo $timestamp; ?> input[name=origin]').val(valls);
	else if(record[0]=='DEST')
		$('#form-maintenance-<?php echo $timestamp; ?> input[name=destination]').val(valls);

	kendoWindow.data("kendoWindow").close();
}

function toggle(source) {
  checkboxes = document.getElementsByClassName('requestId');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

function toggle2(source) {
  checkboxes = document.getElementsByClassName('item_id');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

var data = <?php echo json_encode($this->config->item('request_type')); ?>;
function typeFilter(element) {
    element.kendoDropDownList({
        dataSource: data,
        optionLabel: "--Select Value--"
    });
}
</script>
