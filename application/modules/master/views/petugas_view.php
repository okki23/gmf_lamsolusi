<?php $timestamp = time();?>
<nav class="navbar navbar-default  no-margin" role="navigation" style="padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;">
	<div class="navbar-left">
		<div class="btn-group">
			<?php
			echo'<button class="btn btn-success navbar-btn " id="add-petugas-'.$timestamp.'">
						<i class="glyphicon glyphicon-plus"></i> '.lang('btn_ptg_add').'
				</button> ';
			echo '<button class="btn btn-info navbar-btn " id="edit-'.$timestamp.'" ><i class="glyphicon glyphicon-pencil"></i> '.lang('btn_ptg_edit').' </button> ';
			echo '<button class="btn btn-danger navbar-btn " id="delete-'.$timestamp.'"><i class="glyphicon glyphicon-remove"></i> '.lang('btn_ptg_del').' </button> ';
			echo '<button class="btn btn-primary navbar-btn " id="clear-'.$timestamp.'"><i class="glyphicon glyphicon-trash"></i> '.lang('btn_ptg_clear').' </button> ';
			?>
		</div>
	</div>
	<div class="navbar-right">
		<button id="reload-<?php echo $timestamp; ?>" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-refresh"></i></button>
	</div>
</nav>

<div style='overflow-x: scroll; padding-top:15px;'>
	<div id="info-petugas-<?php echo $timestamp; ?>"></div>
</div>

<div id='window'></div>

<div id="Modal-petugas-<?php echo $timestamp; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('form_ptg_title'); ?></h4>
      </div>
	  <form class="form-horizontal" id='form-petugas-<?php echo $timestamp; ?>' action='<?php echo site_url('master/petugas/proses'); ?>' method='POST'>
		<input type='hidden' value='add' name='mode'/>
		<div class="modal-body">
			<div class="form-group">
				<label class="col-sm-3 control-label" for=""><?php echo lang('form_ptg_type'); ?> :</label>
				<div class="col-sm-9">
					<input type='text' name='jenis' class='kendodropdown form-control' style='width:100%'/>
				</div>
			</div>

			<div class="form-group" id='alias_form'>
				<label class="col-sm-3 control-label" for=""><?php echo lang('form_ptg_limit'); ?> :</label>
				<div class="col-sm-9">
					<div class="input-group" style='width:100%;'>
						<input type="text" name="alias" id="alias" class="form-control" readonly>
						<span class="input-group-btn">
							<button type="button" id="find" class="btn btn-primary"><?php echo lang('btn_src'); ?></button>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label" for=""><?php echo lang('form_ptg_sal'); ?> :</label>
				<div class="col-sm-9">
					<input type='text' name='salutatsion' class='kendodropdown form-control'/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label" for=""><?php echo lang('form_ptg_first'); ?>  :</label>
				<div class="col-sm-9">
					<input type='text' name='first_name' class='form-control'/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label" for=""><?php echo lang('form_ptg_last'); ?> :</label>
				<div class="col-sm-9">
					<input type='text' name='last_name' class='form-control'/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label" for=""><?php echo lang('form_ptg_email'); ?> :</label>
				<div class="col-sm-9">
					<input type='email' name='email' class='form-control'/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label" for=""><?php echo lang('form_ptg_uname'); ?>  :</label>
				<div class="col-sm-9">
					<input type='text' name='uname' class='form-control' />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label" for=""><?php echo lang('form_ptg_pass'); ?>  :</label>
				<div class="col-sm-9">
					<input type="password" id="password" name="password" class="form-control" data-toggle="password">
					<small id='smallText'><?php echo lang('msg_info_blank_pass'); ?></small>
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

<script id="info-petugas-row-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">
	<tr id="#: id #" data-uid="#: id #">
		<td style=" padding: 5px; text-align:center;">
			<input type="checkbox" class='petugasid' name="petugasid[]" value="#: id #">
		</td>
		<td> #: id #</td>
		<td>
			#xalias = alias.substring(0,3); if(xalias =='FWD' || xalias=='CST'){ #
				<a href="javascript:void(0)" onclick="$(this).getinfo();" data-id="#: alias #">
					<strong>#: alias #</strong>
				</a>
			#}else{#
				<strong>#: alias #</strong>
			#}#
			<div id="proper-#:alias#"></div>
		</td>
		<td>#nama = nama_petugas.replace('|',' ');# #: nama.replace('|',' ') #</td>
		<td>#: email #</td>
		<td>#: jenis_petugas #</td>
		<td>
			#if(status_petugas=='Aktif'){#
				<span class="label label-success">#: status_petugas #</span>
			#}else{#
				<span class="label label-danger">#: status_petugas #</span>
			#}#

			#if(logged==1){#
				<span class="label label-success">Logged</span>
			#}else{#
				<span class="label label-danger">Un Logged</span>
			#}#


		</td>
	</tr>
</script>

<script>
var kendoWindow;
$(document).ready(function(){
	$('#alias_form').hide();
	$('#smallText').hide();
	var myCmb={
		'jenis':{url:'<?php echo site_url('app/petugas');?>',data:{}},
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
		if(name=='jenis'){
			var myVal = $(this).val();
			if(myVal=='<?php echo USER_SALES; ?>' || myVal=='<?php echo USER_CUSTOMER; ?>' || myVal=='<?php echo USER_PARTNER; ?>')
				$('#alias_form').show();
			else
				$('#alias_form').hide();
		}

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

	var ds_petugas = new kendo.data.DataSource({
		transport: {
			read: {
				type:"POST",
				dataType: "json",
				url: '<?php echo site_url('master/petugas/get'); ?>',
			}
		},
		schema: {
			parse: function(response){
				return response.data;
			},
		},
		pageSize: 100,
	});

	kendoWindow = $("<div />").kendoWindow({
		title: "Dialog Pencarian",
		width: "500px",
		height: "450px",
		resizable: false,
		modal: true,
	});

	$('#info-petugas-<?php echo $timestamp; ?>').kendoGrid({
		dataSource: ds_petugas,
		filterable: true,
		sortable: true,
		pageable: true,
		scrollable: false,
		rowTemplate: kendo.template($("#info-petugas-row-<?php echo $timestamp; ?>").html()),
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
			{field:"id",title:"<?php echo lang('tbl_ptg_id'); ?>"},
			{field:"alias",title:"<?php echo lang('tbl_ptg_limit'); ?>"},
			{field:"nama_petugas",title:"<?php echo lang('tbl_ptg_name'); ?>"},
			{field:"email",title:"<?php echo lang('tbl_ptg_email'); ?>"},
			{field:"jenis_petugas",title:"<?php echo lang('tbl_ptg_type'); ?>", },
			{field:"status_petugas",title:"<?php echo lang('tbl_ptg_sts'); ?>", }
		]
	});


	$('#reload-<?php echo $timestamp; ?>').click(function(){
		ds_petugas.read();
	});

	$("#form-petugas-<?php echo $timestamp; ?>").submit(function(e){
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
					$('#smallText').hide();
					$('#alias_form').hide();
					$('#Modal-petugas-<?php echo $timestamp; ?>').modal('show');
					$('#form-petugas-<?php echo $timestamp; ?> input[name=mode]').val('add');
					$('#form-petugas-<?php echo $timestamp; ?> input[name=alias]').val('');
					$('#form-petugas-<?php echo $timestamp; ?> input[name=first_name]').val('');
					$('#form-petugas-<?php echo $timestamp; ?> input[name=last_name]').val('');
					$('#form-petugas-<?php echo $timestamp; ?> input[name=password]').val('');
					$('#form-petugas-<?php echo $timestamp; ?> input[name=uname]').val('');
					$('#form-petugas-<?php echo $timestamp; ?> input[name=email]').val('');
					ds_petugas.read();
					cmb['jenis'].select(0);
					cmb['salutatsion'].select(0);
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
		var checkedVals = $('.petugasid:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals !=''){
			msg_box("Hapus data Petugas Id ("+checkedVals+")...?",[{'btnYES':function(){
				$(this).trigger('closeWindow');
				checkedVals.forEach(function(element){
					$("#"+element).hide('slow');
				});
				var petugasId= checkedVals.join(",");
				$.post('<?php echo site_url('master/petugas/hapus'); ?>',{id:petugasId},function(){
					ds_petugas.read();

				});
			}},'btnNO'],'Konfirmasi');
		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});

	$("#edit-<?php echo $timestamp; ?>").click(function(){
		$('#smallText').show();
		var checkedVals = $('.petugasid:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals.length ==1){
			$('#Modal-petugas-<?php echo $timestamp; ?>').modal('show');
			$.ajax({
				url:'<?php echo site_url('master/petugas/get'); ?>',
				data:'id='+checkedVals,
				type:'POST',
				dataType:'json',tail:1,
				beforeSend:function(){
					$('#pesan').addClass('loader2');
					$('.modal-body').hide();
				},
				success:function(res){
					var name = res.data[0].nama_petugas;
					var rname = name.split('|');
					var t_alias = res.data[0].alias+"-"+res.data[0].company_name;
					var myVal = res.data[0].jenis_id;

					$("#form-petugas-<?php echo $timestamp; ?> input[name=uname]").prop("readonly", true);
					$('#form-petugas-<?php echo $timestamp; ?> input[name=mode]').val('edit');
					$('#form-petugas-<?php echo $timestamp; ?> input[name=alias]').val(t_alias);
					$('#form-petugas-<?php echo $timestamp; ?> input[name=uname]').val(res.data[0].id);
					$('#form-petugas-<?php echo $timestamp; ?> input[name=email]').val(res.data[0].email);
					$('#form-petugas-<?php echo $timestamp; ?> input[name=first_name]').val(rname[1]);
					$('#form-petugas-<?php echo $timestamp; ?> input[name=last_name]').val(rname[2]);
					if(myVal=='<?php echo USER_SALES; ?>' || myVal=='<?php echo USER_CUSTOMER; ?>' || myVal=='<?php echo USER_PARTNER; ?>')
						$('#alias_form').show();
					else
						$('#alias_form').hide();
					cmb['salutatsion'].value(rname[0]);
					cmb['jenis'].value(res.data[0].jenis_id);
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

	$('#clear-<?php echo $timestamp; ?>').click(function(){
		var txt;
		var checkedVals = $('.petugasid:checkbox:checked').map(function() {
			return this.value;
		}).get();
		if(checkedVals !=''){
			msg_box("Hapus data sessi petugas Id ("+checkedVals+")...?",[{'btnYES':function(){
				$(this).trigger('closeWindow');
				var petugasId= checkedVals.join(",");
				$.post('<?php echo site_url('master/petugas/clear'); ?>',{id:petugasId},function(){
					ds_petugas.read();

				});
			}},'btnNO'],'Konfirmasi');
		}else
			msg_box('No data Selected',['btnOK'],'Info!');
	});

	$("#add-petugas-<?php echo $timestamp; ?>").click(function(){
		$('#smallText').hide();
		$('#alias_form').hide();
		cmb['jenis'].select(0);
		cmb['salutatsion'].select(0);
		$("#form-petugas-<?php echo $timestamp; ?> input[name=uname]").prop("readonly", false);
		$('#Modal-petugas-<?php echo $timestamp; ?>').modal('show');
		$('#form-petugas-<?php echo $timestamp; ?> input[name=mode]').val('add');
		$('#form-petugas-<?php echo $timestamp; ?> input[name=alias]').val('');
		$('#form-petugas-<?php echo $timestamp; ?> input[name=password]').val('');
		$('#form-petugas-<?php echo $timestamp; ?> input[name=uname]').val('');
		$('#form-petugas-<?php echo $timestamp; ?> input[name=email]').val('');
		$('#form-petugas-<?php echo $timestamp; ?> input[name=alias]').val('');
		$('#form-petugas-<?php echo $timestamp; ?> input[name=first_name]').val('');
		$('#form-petugas-<?php echo $timestamp; ?> input[name=last_name]').val('');
	});

	$('#find').click(function(){
		kendoWindow.data("kendoWindow")
			.content($("#detail-nasabah").html())
			.center().open();
		var ceksum = cmb['jenis'].value(), curUrl = '',titleId='',fieldCstm='';

		if(ceksum=='<?php echo USER_SALES; ?>'){
			curUrl ='<?php echo site_url('master/sales/get'); ?>';
			titleId ='Sales';
			fieldCstm ='sales';
		}else if(ceksum=='<?php echo USER_CUSTOMER; ?>'){
			curUrl ='<?php echo site_url('master/customer/get'); ?>';
			titleId ='Customer';
			fieldCstm ='customer';
		}else{
			curUrl ='<?php echo site_url('master/forwarder/get'); ?>';
			titleId ='Forwarder';
			fieldCstm ='nama_forwrder';
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
					template: '<button  onclick="$(this).selectItem();" data-id="#: id #-#: '+fieldCstm+' #" class="pilih btn btn-xs btn-primary">PILIH</button>',
				},{field:"id",title:titleId+" ID"},
				{field:fieldCstm,title:titleId+" Name"},
			]
		});


	});

	$.fn.getinfo=function(){
		var element = $(this).data('id');
		var jenis = element.substring(0,3);
		var url =(jenis=='FWD')?'<?php echo site_url('master/forwarder/get'); ?>':'<?php echo site_url('master/customer/get'); ?>';

		$.ajax({
			url: url,
			type: 'POST',
			data: 'id='+element,
			dataType: 'json',
			success: function(res) {
				if(jenis=='FWD'){
					$("#proper-"+element).popover({
						container: 'body',
						html: true,
						title:res.data[0].nama_forwrder,
						content: res.data[0].alamat
					});

				}else{
					$("#proper-"+element).popover({
						container: 'body',
						html: true,
						title:res.data[0].customer,
						content: res.data[0].alamat
					});
				}

				$("#proper-"+element).popover('toggle');
			}
		});
	}

	$.fn.selectItem = function (){
		var id 			= $(this).data('id');
		var uid 		= id.split("-");
		var url			= '';
		var jenis 		= id.substring(0,3);
		var first_name	= '';
		var last_name	= '';

		if(jenis=='SLS'){
			url='<?php echo site_url('master/sales/get'); ?>';
		}else if(jenis=='FWD'){
			url='<?php echo site_url('master/forwarder/get'); ?>';
		}else{
			url='<?php echo site_url('master/customer/get'); ?>';
		}

		$("#alias").val(id);
		$.ajax({
			url:url,
			data:'id='+uid[0],
			dataType:'json',
			type:'POST',
			success:function(res){
				if(jenis=='CST' || jenis=='FWD'){
					var rname = res.data[0].cp;
					var name = rname.split('|');
					first_name=name[1];
					last_name=name[2];
				}

				if(jenis=='SLS'){
					var rname = res.data[0].sales;
					var name = rname.split('|');
					first_name=name[1];
					last_name=name[2];
				}

				cmb['salutatsion'].value(name[0]);
				$('#form-petugas-<?php echo $timestamp; ?> input[name=first_name]').val(first_name);
				$('#form-petugas-<?php echo $timestamp; ?> input[name=last_name]').val(last_name);
				$('#form-petugas-<?php echo $timestamp; ?> input[name=email]').val(res.data[0].email);
			}
		});
		kendoWindow.data("kendoWindow").close();
	}

});



function toggle(source) {
  checkboxes = document.getElementsByClassName('petugasid');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<script id="detail-nasabah" type="text/x-kendo-template">
	<div class="myGrid"></div>
</script>
