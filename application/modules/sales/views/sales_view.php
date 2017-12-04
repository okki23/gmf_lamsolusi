<?php $timestamp = time();?>
<nav class="navbar navbar-default  no-margin" role="navigation" style="padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;">
	<div class="navbar-left">
		<div class="btn-group">
			<?php 
			echo'<button class="btn btn-success navbar-btn " id="add-act-'.$timestamp.'"><i class="glyphicon glyphicon-folder-open"></i> Add Actifity Ticket</button> ';
			echo '<button class="btn btn-info navbar-btn " id="edit-'.$timestamp.'" ><i class="glyphicon glyphicon-pencil"></i> Edit Actifity Ticket </button> ';
			echo '<button class="btn btn-danger navbar-btn " id="delete-'.$timestamp.'"><i class="glyphicon glyphicon-remove"></i> Delete Actifity</button> ';
			echo '<button class="btn btn-primary navbar-btn " id="foloup-'.$timestamp.'" ><i class="glyphicon glyphicon-list"></i> Folow Up Ticket </button> ';
			echo '<button class="btn btn-warning navbar-btn " id="close-'.$timestamp.'" ><i class="glyphicon glyphicon-folder-close"></i> Mark as Close</button> ';
			?>
		</div>
	</div>
	<div class="navbar-right">
		<button id="reload-<?php echo $timestamp; ?>" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-refresh"></i></button>
	</div>
</nav>

<div style='padding-top:15px;'>
	<div id="info-Activity-<?php echo $timestamp; ?>"></div>
</div>
<!-- Dialog Form sales Actifity -->
<div id="Modal-Activity-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Form Activity <span id="actshow"></span></h4>
      </div>
	  <form class="form-horizontal" id='form-activity-<?php echo $timestamp; ?>' action='<?php echo site_url('sales/acktifity_proses'); ?>' method='POST'>
			<input type='hidden' name='id' readonly>
			<div class="modal-body">
				<div class="form-group">
					<label class="col-sm-3 control-label" for="">Customer Name :</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="customer" id="" class="form-control" placeholder="Customer Name" readonly>
							<span class="input-group-btn">
								<button type="button" id="" class="find btn btn-primary">Find</button>
							</span>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" for="">Activity Date:</label>
					<div class="col-sm-9">
						<input type='text' name='date' class='datepicker form-control'/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" for="">Activity Type:</label>
					<div class="col-sm-9">
						<input type='text' name='actifity' class='kendodropdown form-control'/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" for="">Remarks:</label>
					<div class="col-sm-9">
						<input type='text' name='remarks' class='form-control'/>
					</div>
				</div>
			</div>
		  <div class="modal-footer">
			<div style='float:left' id='pesan'></div>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary" >Proses</button>
		  </div>
	  </form>
    </div>
  </div>
</div>


<div id="Modal-foloup-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Follow Up Activity <span id="actshow"></span></h4>
      </div>
	   <form class="form-horizontal" id='form-sub-activity-<?php echo $timestamp; ?>' action='<?php echo site_url('sales/acktifity_item_proses'); ?>' method='POST'>
		<input type='hidden' name='id' id='act_id'> 
		<input type='hidden' name='act_id_onsub' id='act_id_onsub'> 
		<div class="modal-body">
			<div class="form-group">
				<label class="col-sm-3 control-label" for="">Date of activity :</label>
				<div class="col-sm-9">
					<input type='text' name='date' class='datepicker form-control'/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="">Hours of activity:</label>
				<div class="col-sm-3">
					<input type='text' name='hours' class='timepicker form-control' />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="">Activities:</label>
				<div class="col-sm-9">
					<textarea name='actifity' class='form-control'></textarea>
				</div>
			</div>
			<div style="clear:both;">&nbsp;</div>
      </div>
	  <div class="modal-footer">
		<div style='float:left' id='pesan'></div>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary" >Proses</button>
	  </div>
	  </form>
    </div>
  </div>
</div>

<script id="info-Activity-row-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">
	<tr data-uid="#: id #">
		<td style=" padding: 5px; text-align:center;">
			<input type="checkbox" class='actifityId' name="actId[]" value="#: id #">
		</td>
		<td style=" padding: 5px;">
			<a href="javascript:void(0)" onclick="$(this).getDetail();" data-id="#: id #"><strong>#: id #</strong></a>
		</td>
		<td style=" padding: 5px;">#: cst_name#</td>
		<td style=" padding: 5px;">#: type #</td>
		<td style=" padding: 5px;">#: date #</td>
		<td style=" padding: 5px;">#: status #</td>
		<td style=" padding: 5px;">#: remark #</td>
	</tr>
</script>





<script>
$(document).ready(function(){
	
	<?php 
		$dropdown=array(
			array('name'=>'actifity','url'=>'app/actifity_type')
		);
		echo $this->app->dropdown_kendo($dropdown);
	?>
	
	var ds_activity = new kendo.data.DataSource({
		transport: {
			read: {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('sales/acktifity_get'); ?>',
			}
		},
		schema: {
			parse: function(response){
				return response.data;
			},
		},
		pageSize: 100,
	});
	
	$('#info-Activity-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_activity,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: true,
		rowTemplate: kendo.template($("#info-Activity-row-<?php echo $timestamp; ?>").html()),
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
			{title:"<input id='myCheckbox' type='checkbox' onClick='toggle(this)' /> All<br/>",width: 50},
			{field:"id",title:"Actifity ID",filterable: false,width: 150},
			{field:"cst_name",title:"Customer Name",filterable: false,width: 200},
			{field:"type",title:"Actifity Type",filterable: false,width: 100},
			{field:"date",title:"Actifity Date",filterable: false,width: 100},
			{field:"status",title:"Status",filterable: false, width: 100},
			{field:"remark",title:"Remark",filterable: false, width: 200},
		]
	});
	
	$('#reload-<?php echo $timestamp; ?>').click(function(){
		ds_activity.read();
	});
	
	$("#add-act-<?php echo $timestamp; ?>").click(function(){
		$('#Modal-Activity-<?php echo $timestamp; ?>').modal('show');
		$('#actshow').html('');
		$('#form-activity-<?php echo $timestamp; ?> input[name=id]').val('');
		$('#form-activity-<?php echo $timestamp; ?> input[name=customer]').val('');
		$('#form-activity-<?php echo $timestamp; ?> input[name=date]').val('');
		$('#form-activity-<?php echo $timestamp; ?> input[name=remarks]').val('');

	});
	
	$("#foloup-<?php echo $timestamp; ?>").click(function(){
		var txt;
		var checkedVals = $('.actifityId:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals.length ==1){
			$('#Modal-foloup-<?php echo $timestamp; ?>').modal('show'); 
			$('#form-sub-activity-<?php echo $timestamp; ?> input[name=act_id_onsub]').val(checkedVals); 
		}else if(checkedVals.length >1){
			msg_box('Select Only One data',['btnOK'],'Info!');
		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});
	
	$("#edit-<?php echo $timestamp; ?>").click(function(){
		var txt;
		var checkedVals = $('.actifityId:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals.length ==1){
			$('#Modal-Activity-<?php echo $timestamp; ?>').modal('show'); 
			
			$.ajax({
				url:'<?php echo site_url('sales/acktifity_get'); ?>',
				data:'id='+checkedVals,
				type:'POST',
				dataType:'json',tail:1,
				beforeSend:function(){
					$('#pesan').addClass('loader2');
					$('.modal-body').hide();
				},
				success:function(res){
					$('#actshow').html(checkedVals);
					$('#form-activity-<?php echo $timestamp; ?> input[name=id]').val(res.data[0].id);
					$('#form-activity-<?php echo $timestamp; ?> input[name=customer]').val(res.data[0].customer_id+"-"+res.data[0].cst_name);
					$('#form-activity-<?php echo $timestamp; ?> input[name=date]').val(res.data[0].date);
					$('#form-activity-<?php echo $timestamp; ?> input[name=remarks]').val(res.data[0].remark);
					cmb['actifity'].value(res.data[0].type);
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
	
	$('#form-sub-activity-<?php echo $timestamp; ?>').submit(function(e){
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
					$('#form-sub-activity-<?php echo $timestamp; ?> input[name=sub_act_id]').val(''); 
					$('#form-sub-activity-<?php echo $timestamp; ?> input[name=act_id_onsub]').val(''); 
					$('#form-sub-activity-<?php echo $timestamp; ?> input[name=hours]').val(''); 
					$('#form-sub-activity-<?php echo $timestamp; ?> textarea[name=actifity]').val(''); 
					msg_box(res.messages,['btnOK'],'Info!');
					ds_activity.read();
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
	
	$("#delete-<?php echo $timestamp; ?>").click(function(){
		var txt;
		var checkedVals = $('.actifityId:checkbox:checked').map(function() {
			return this.value;
		}).get();
		var actId= checkedVals.join(",");
		if(checkedVals !=''){
			$.ajax({
				url:'<?php echo site_url('sales/acktifity_delete'); ?>',
				data:'id='+actId,
				type:'POST',
				dataType:'json',tail:1,
				success:function(res){
					ds_activity.read();
				}
			});
		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});
	
	
	$("#close-<?php echo $timestamp; ?>").click(function(){
		var txt;
		var checkedVals = $('.actifityId:checkbox:checked').map(function() {
			return this.value;
		}).get();
		var actId= checkedVals.join(",");
		if(checkedVals !=''){
			$.ajax({
				url:'<?php echo site_url('sales/acktifity_close'); ?>',
				data:'id='+actId,
				type:'POST',
				dataType:'json',tail:1,
				success:function(res){
					ds_activity.read();
					msg_box(res.messages,['btnOK'],'Info!');
				}
			});
		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});
	
	
	$('#form-activity-<?php echo $timestamp; ?>').submit(function(e){
		e.preventDefault();
		
		$.ajax({
			url : $(this).attr('action'),
			data: $(this).serialize(),
			type: 'POST',
			dataType:'json',
			beforeSend:function(){
				$('#pesan').addClass('loader2');
			},success:function(res){
				$('#pesan').removeClass('loader2');
				$("#pesan").html(res.messages);
				if(res.status){
					ds_activity.read();
					$('#actshow').html('');
					$('#form-activity-<?php echo $timestamp; ?> input[name=id]').val('');
					$('#form-activity-<?php echo $timestamp; ?> input[name=customer]').val('');
					$('#form-activity-<?php echo $timestamp; ?> input[name=date]').val('');
					$('#form-activity-<?php echo $timestamp; ?> input[name=remarks]').val('');
					cmb['actifity'].select(0);
				}
			}
		}).done(function(){
			$('#pesan').removeClass('loader2');
			setTimeout(function(){ 
				$("#pesan").html("");
			}, 3000);
		});
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
		
		var ds_find = new kendo.data.DataSource({
			transport: {
				read: {
					type:"POST",
					dataType: "json",
					url: '<?php echo site_url('master/customer/get'); ?>',
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
					template: '<button  onClick="selectItem(this.id);" id="#: id #-#: customer #" class="pilih btn btn-xs btn-primary">PILIH</button>',
				},{field:"id",title:" Customer ID"},
				{field:'customer',title:" Name"},
			]
		});
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
				url: '<?php echo site_url('sales/actifity_sub_table'); ?>',
				data: 'id='+reqID,
				type:'POST',
				dataType: 'html',
				beforeSend: function(){
					$(tr_parent).after('<tr class="sub_'+elmid+'"><td colspan="7" class="loader"></td><td style="display:none">&mdash;|</td></tr>');
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

function selectItem(id){
	var record = id.split('-');
	var valls = record[0]+'-'+record[1];
	
	$('#form-activity-<?php echo $timestamp; ?> input[name=customer]').val(valls);

	kendoWindow.data("kendoWindow").close();
}

function toggle(source) {
  checkboxes = document.getElementsByClassName('actifityId');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<script id="detail-nasabah" type="text/x-kendo-template">
	<div class="myGrid"></div>
</script>
