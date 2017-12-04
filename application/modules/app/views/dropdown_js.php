var myCmb={
		<?php foreach($cmbRequest as $row){ ?>
			'<?php echo $row->name; ?>':{url:'<?php echo site_url($row->url);?>',data:{}},
		<?php } ?>
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
