<?php $timestamp = time();?>
<nav class="navbar navbar-default  no-margin" role="navigation" style="padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;
">
	<div class="navbar-left">
		<div class="btn-group">
			<?php
			echo'<button class="btn btn-success navbar-btn " id="add-customer-'.$timestamp.'">
						<i class="glyphicon glyphicon-plus"></i> '.lang('btn_port_add').'
				</button> ';
			echo '<button class="btn btn-info navbar-btn " id="edit-'.$timestamp.'" ><i class="glyphicon glyphicon-pencil"></i> '.lang('btn_port_edit').'</button> ';
			echo '<button class="btn btn-danger navbar-btn " id="delete-'.$timestamp.'"><i class="glyphicon glyphicon-remove"></i> '.lang('btn_port_del').' </button> ';
			?>
		</div>
	</div>
	<div class="navbar-right">
		<button id="reload-<?php echo $timestamp; ?>" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-refresh"></i></button>
	</div>
</nav>

<div style='overflow-x: scroll; padding-top:15px;'>
	<div id="info-customer-<?php echo $timestamp; ?>"></div>
</div>

<!-- Dialog Form sales Actifity -->
<div id="Modal-customer-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('form_cst_title'); ?></h4>
      </div>
	  <form class="form-horizontal" id='form-customer-<?php echo $timestamp; ?>' action='<?php echo site_url('master/port/proses'); ?>' method='POST'>
			<input type='hidden' name='edit_id' readonly/>
			<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_port_id'); ?> :</label>
						<div class="col-sm-3">
							<input type='text' name='id' class='form-control' style="text-transform: uppercase;" maxlength="3"/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for=""> <?php echo lang('form_port_name'); ?> :</label>
						<div class="col-sm-9">
							<input type='text' name='nama' class='form-control'/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_port_country'); ?> :</label>
						<div class="col-sm-9">
							 <input name='country' class='kendodropdown form-control' style="width: 100%;" />
						</div>
					</div>

			</div>
		  <div class="modal-footer">
			<div style='float:left' id='pesan'></div> <!--loader2-->
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('btn_close'); ?></button>
			<button type="submit" class="btn btn-primary" ><?php echo lang('btn_proses'); ?></button>
		  </div>
	  </form>
    </div>
  </div>
</div>

<script id="info-customer-row-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">
	<tr id="#: id #">
		<td style=" padding: 5px; text-align:center;">
			<input type="checkbox" class='customerid' name="cusid[]" value="#: id #">
		</td>
		<td>#: id #</td>
		<td>#: port_name #</td>
		<td>#: port_country #</td>
	</tr>
</script>

<script>
$(document).ready(function(){
	$("#text_id").hide();
	var myCmb={
		'country':{url:'<?php echo site_url('app/country');?>',data:{}},
	},cmb={};

	$(".kendodropdown").kendoDropDownList({
		dataTextField: "text",
		dataValueField: "text",
	}).each(function(){
			var name = $(this).attr('name'),
			placeholder = $(this).attr('placeholder'),
			alias = name,init = {};
			init = myCmb[name];

			cmb[alias] = $(this).data('kendoDropDownList');
			if(placeholder!=undefined)
				placeholder = {id:'-1',text:placeholder};
			var opt = {
				type: "data",
				transport: {
					read: {
						url: init.url,
						type:'POST',
						dataType:'json'
					}
				},
				schema:{
					parse:function(rs){
						if(placeholder!=undefined)
							rs.data.unshift(placeholder);
						return rs.data;
					}
				}
			};

			cmb[alias].setDataSource(new kendo.data.DataSource(opt));
	}).bind('change',function(){

		var name = $(this).attr('name'), init = {}, data=(name=='prov')?{prov:$(this).val()} : {kab:$(this).val()};
		init = myCmb[name];
		nCmb=init.flow;
		nInit = myCmb[nCmb];

		if(cmb[nCmb] !=undefined){
			cmb[nCmb].dataSource.transport.options.read.url =nInit.url;
			cmb[nCmb].dataSource.read(data);

			xCmb = nInit.flow;
			if(xCmb !=undefined){
				nInitn = myCmb[xCmb];
				cmb[xCmb].dataSource.transport.options.read.url =nInitn.url;
				cmb[xCmb].dataSource.read(data);
			}
		}

	});


	$('#form-customer-<?php echo $timestamp; ?>').submit(function(e){
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
					ds_customer.read();
					$('#form-customer-<?php echo $timestamp; ?> input[name=id]').val('');
					$('#form-customer-<?php echo $timestamp; ?> input[name=nama]').val('');
					$('#form-customer-<?php echo $timestamp; ?> input[name=edit_id]').val('');
					cmb['country'].value('-1');
				}else
					$('#pesan').html(res.messages);
			}
		}).done(function(){
			$('#pesan').removeClass('loader2');
			$("#text_id").hide();
			setTimeout(function(){
				$("#pesan").html("");
			}, 3000);
		});
	});

	$('#reload-<?php echo $timestamp; ?>').click(function(){
		ds_customer.read();
	});

	$("#add-customer-<?php echo $timestamp; ?>").click(function(){
		$('#form-customer-<?php echo $timestamp; ?> input[name=id]').attr('readonly', false);
		$('#Modal-customer-<?php echo $timestamp; ?>').modal('show');
		$('#form-customer-<?php echo $timestamp; ?> input[name=id]').val('');
		$('#form-customer-<?php echo $timestamp; ?> input[name=nama]').val('');
		$('#form-customer-<?php echo $timestamp; ?> input[name=edit_id]').val('');
		cmb['country'].value('-1');

	});

	$('#delete-<?php echo $timestamp; ?>').click(function(){
		var txt;
		var checkedVals = $('.customerid:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals !=''){
			var r = confirm("Delete this record ("+checkedVals+")...?");
			if (r == true) {
				checkedVals.forEach(function(element) {
					$("#"+element).hide('slow');
				});
				var customerId= checkedVals.join(",");
				$.post('<?php echo site_url('master/port/hapus'); ?>',{id:customerId},function(){
					ds_customer.read();
				});
			}
		}else
			alert('No data Selected');
	});

	$("#edit-<?php echo $timestamp; ?>").click(function(){
		var txt;
		var checkedVals = $('.customerid:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals.length ==1){
			$('#Modal-customer-<?php echo $timestamp; ?>').modal('show');
			$.ajax({
				url:'<?php echo site_url('master/port/get'); ?>',
				data:'id='+checkedVals,
				type:'POST',
				dataType:'json',tail:1,
				beforeSend:function(){
					$('#pesan').addClass('loader2');
					$('.modal-body').hide();
				},
				success:function(res){
					$('#form-customer-<?php echo $timestamp; ?> input[name=id]').attr('readonly', true);
					$('#form-customer-<?php echo $timestamp; ?> input[name=id]').val(res.data[0].id);
					$('#form-customer-<?php echo $timestamp; ?> input[name=edit_id]').val(res.data[0].id);
					$('#form-customer-<?php echo $timestamp; ?> input[name=nama]').val(res.data[0].port_name);
					cmb['country'].value(res.data[0].port_country);
				}
			}).done(function(){
				$('.modal-body').show();
				//$("#text_id").hide();
				$('#pesan').removeClass('loader2');
			});
		}else if(checkedVals.length >1){
			msg_box('Select Only One data',['btnOK'],'Info!');
		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});

	var ds_customer = new kendo.data.DataSource({
		transport: {
			read: {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('master/port/get'); ?>',
			}
		},
		schema: {
			parse: function(response){
				return response.data;
			},
		},
		pageSize: 100,
	});

	$('#info-customer-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_customer,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: false,
		rowTemplate: kendo.template($("#info-customer-row-<?php echo $timestamp; ?>").html()),
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
			{field:"id",title:"<?php echo lang('tbl_port_id'); ?>"},
			{field:"port_name",title:"<?php echo lang('tbl_port_name'); ?>"},
			{field:"port_country",title:"<?php echo lang('tbl_port_country'); ?>" },
		]
	});
});

function toggle(source) {
  checkboxes = document.getElementsByClassName('customerid');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
