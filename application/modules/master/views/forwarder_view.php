<?php $timestamp = time();?>
<nav class="navbar navbar-default  no-margin" role="navigation" style="padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;
">
	<div class="navbar-left">
		<div class="btn-group">
			<?php
			echo'<button class="btn btn-success navbar-btn " id="add-forwarder-'.$timestamp.'">
						<i class="glyphicon glyphicon-plus"></i> '.lang('btn_fwd_add').'
				</button> ';
			echo '<button class="btn btn-info navbar-btn " id="edit-'.$timestamp.'" ><i class="glyphicon glyphicon-pencil"></i> '.lang('btn_fwd_edit').' </button> ';
			echo '<button class="btn btn-danger navbar-btn " id="delete-'.$timestamp.'"><i class="glyphicon glyphicon-remove"></i> '.lang('btn_fwd_del').' </button> ';
			?>
		</div>
	</div>
	<div class="navbar-right">
		<button id="reload-<?php echo $timestamp; ?>" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-refresh"></i></button>
	</div>
</nav>

<div style='overflow-x: scroll; padding-top:15px;'>
	<div id="info-forwarder-<?php echo $timestamp; ?>"></div>
</div>

<!-- Dialog Form sales Actifity -->
<div id="Modal-forwarder-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('form_fwd_title'); ?></h4>
      </div>
	  <form class="form-horizontal" id='form-forwarder-<?php echo $timestamp; ?>' action='<?php echo site_url('master/forwarder/proses'); ?>' method='POST'>
			<div class="modal-body">
			<fieldset>
					<legend><?php echo lang('form_fwd_blok_crp'); ?> :</legend>
					<div class="form-group" id='text_id'>
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_fwd_id'); ?> :</label>
						<div class="col-sm-9">
							<input type='text' name='id' class='form-control' readonly />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_fwd_name'); ?> :</label>
						<div class="col-sm-9">
							<input type='text' name='nama' class='form-control'/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_fwd_adres'); ?> :</label>
						<div class="col-sm-9">
							<textarea name='alamat' class='form-control'></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for=""><?php echo lang('form_fwd_country'); ?> :</label>
						<div class="col-sm-9">
							 <input name='country' class='kendodropdown form-control' style="width: 100%;" />
						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend><?php echo lang('form_fwd_blok_cp'); ?> :</legend>
						<div class="form-group">
							<label class="col-sm-3 control-label" for=""><?php echo lang('form_fwd_sal'); ?> :</label>
							<div class="col-sm-9">
								<input type='text' name='salutatsion' class='kendodropdown form-control'/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label" for=""><?php echo lang('form_fwd_firt'); ?> :</label>
							<div class="col-sm-9">
								<input type='text' name='first_name' class='form-control'/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label" for=""><?php echo lang('form_fwd_last'); ?> :</label>
							<div class="col-sm-9">
								<input type='text' name='last_name' class='form-control'/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label" for=""><?php echo lang('form_fwd_phone'); ?> :</label>
							<div class="col-sm-9">
								<input type='text' name='phone' class='form-control'/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label" for=""><?php echo lang('form_fwd_email'); ?> :</label>
							<div class="col-sm-9">
								<input type='email' name='email' class='form-control'/>
							</div>
						</div>
				</fieldset>

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

<script id="info-forwarder-row-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">
	#nama= cp.replace("|"," ")#
	<tr id="#: id #">
		<td style=" padding: 5px; text-align:center;">
			<input type="checkbox" class='forwarderid' name="cusid[]" value="#: id #">
		</td>
		<td>#: id #</td>
		<td>#: nama_forwrder#</td>
		<td>#: nama.replace("|"," ") #</td>
		<td>#: phone #</td>
		<td>#: email #</td>
		<td>#: alamat #</td>
	</tr>
</script>

<script>
$(document).ready(function(){
	$("#text_id").hide();
	var myCmb={
		'country':{url:'<?php echo site_url('app/country');?>',data:{}},
		'salutatsion':{url:'<?php echo site_url('app/salutasi');?>',data:{}},
	},cmb={};

	$(".kendodropdown").kendoDropDownList({
		dataTextField: "text",
		dataValueField: "id",
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


	$('#form-forwarder-<?php echo $timestamp; ?>').submit(function(e){
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
					ds_forwarder.read();
					$('#form-forwarder-<?php echo $timestamp; ?> input[name=id]').val('');
					$('#form-forwarder-<?php echo $timestamp; ?> input[name=nama]').val('');
					$('#form-forwarder-<?php echo $timestamp; ?> input[name=first_name]').val('');
					$('#form-forwarder-<?php echo $timestamp; ?> input[name=last_name]').val('');
					$('#form-forwarder-<?php echo $timestamp; ?> input[name=phone]').val('');
					$('#form-forwarder-<?php echo $timestamp; ?> input[name=email]').val('');
					$('#form-forwarder-<?php echo $timestamp; ?> textarea[name=alamat]').val('');
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
		ds_forwarder.read();
	});

	$("#add-forwarder-<?php echo $timestamp; ?>").click(function(){
		$("#text_id").hide();
		$('#Modal-forwarder-<?php echo $timestamp; ?>').modal('show');
		$('#form-forwarder-<?php echo $timestamp; ?> input[name=id]').val('');
		$('#form-forwarder-<?php echo $timestamp; ?> input[name=nama]').val('');
		$('#form-forwarder-<?php echo $timestamp; ?> input[name=first_name]').val('');
		$('#form-forwarder-<?php echo $timestamp; ?> input[name=last_name]').val('');
		$('#form-forwarder-<?php echo $timestamp; ?> input[name=phone]').val('');
		$('#form-forwarder-<?php echo $timestamp; ?> input[name=email]').val('');
		$('#form-forwarder-<?php echo $timestamp; ?> textarea[name=alamat]').val('');
	});

	$('#delete-<?php echo $timestamp; ?>').click(function(){
		var txt;
		var checkedVals = $('.forwarderid:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals !=''){
			msg_box("Hapus data Forwarder Id ("+checkedVals+")...?",[{'btnYES':function(){
				$(this).trigger('closeWindow');
				checkedVals.forEach(function(element) {
					$("#"+element).hide('slow');
				});
				var forwarderId= checkedVals.join(",");
				$.post('<?php echo site_url('master/forwarder/hapus'); ?>',{id:forwarderId},function(){
					ds_forwarder.read();
				});
			}},'btnNO'],'Konfirmasi');
		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});

	$("#edit-<?php echo $timestamp; ?>").click(function(){
		var txt;
		var checkedVals = $('.forwarderid:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals.length ==1){
			$('#Modal-forwarder-<?php echo $timestamp; ?>').modal('show');
			$.ajax({
				url:'<?php echo site_url('master/forwarder/get'); ?>',
				data:'id='+checkedVals,
				type:'POST',
				dataType:'json',tail:1,
				beforeSend:function(){
					$('#pesan').addClass('loader2');
					$('.modal-body').hide();
				},
				success:function(res){
					$("#text_id").show();
					var name = res.data[0].cp;
					var ar_name = name.split("|");

					$('#form-forwarder-<?php echo $timestamp; ?> input[name=id]').val(res.data[0].id);
					$('#form-forwarder-<?php echo $timestamp; ?> input[name=nama]').val(res.data[0].nama_forwrder);
					$('#form-forwarder-<?php echo $timestamp; ?> input[name=first_name]').val(ar_name[1]);
					$('#form-forwarder-<?php echo $timestamp; ?> input[name=last_name]').val(ar_name[2]);
					$('#form-forwarder-<?php echo $timestamp; ?> input[name=phone]').val(res.data[0].phone);
					$('#form-forwarder-<?php echo $timestamp; ?> input[name=email]').val(res.data[0].email);
					$('#form-forwarder-<?php echo $timestamp; ?> textarea[name=alamat]').val(res.data[0].alamat);
					cmb['country'].value(res.data[0].country);
					cmb['salutatsion'].value(ar_name[0]);
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

	var ds_forwarder = new kendo.data.DataSource({
		transport: {
			read: {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('master/forwarder/get'); ?>',
			}
		},
		schema: {
			parse: function(response){
				return response.data;
			},
		},
		pageSize: 100,
	});

	$('#info-forwarder-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_forwarder,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: false,
		rowTemplate: kendo.template($("#info-forwarder-row-<?php echo $timestamp; ?>").html()),
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
			{field:"id",title:"<?php echo lang('tbl_fwd_id'); ?>"},
			{field:"forwarder",title:"<?php echo lang('tbl_fwd_name'); ?>"},
			{field:"cp",title:"<?php echo lang('tbl_fwd_cp'); ?>",filterable: false, },
			{field:"phone",title:"<?php echo lang('tbl_fwd_phone'); ?>",filterable: false, },
			{field:"email",title:"<?php echo lang('tbl_fwd_email'); ?>",filterable: false, },
			{field:"alamat",title:"<?php echo lang('tbl_fwd_adress'); ?>",filterable: false, },
		]
	});
});

function toggle(source) {
  checkboxes = document.getElementsByClassName('forwarderid');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
