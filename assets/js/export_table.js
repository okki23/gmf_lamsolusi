(function(window, document, undefined) {
(function(factory) {
	"use strict";
	if (jQuery && !jQuery.fn.dataTable){
		factory(jQuery);
	}
}
(function($) {
	"use strict";
	var exportTable = function(init){
		this.each(function(){
			if(this.nodeName.toLowerCase()!= 'table'){
				alert('Tidak dapat mengekspor elemen '+this.nodeName);
				return;
			}
			
			var tSetting = $.extend({
				title	:"",
				header	:"",
				margin	:0,
				path	:"",
			}, init );
			var tId = this.id;
			
			var tTable = {};
			tTable.self = {};
			tTable.head = [];
			tTable.body = [];
			tTable.self.attr=[];
			$.each(this.attributes,function(i,a){
				tTable.self.attr[i]=a.nodeName.toLowerCase()+'="'+a.value+'"';
			});
			
			var _that=this;
			var _processor = undefined;
			var _busy = false;
			var _nrow = _that.rows.length;
			var _irow = 0;
			var _row,_col;
			
			var copyTable = function(button,retunFunction){
				if(_processor) clearInterval(_processor);
				if(tTable.body.length>0 && typeof retunFunction === 'function') return retunFunction(tTable);
				_processor = setInterval(function(){
					if(!_busy){
						_busy=true;
						if(_that.rows[_irow].nodeName.toLowerCase()=='tr' && _that.rows[_irow].cells[0].style.display!='none'){
							_row={'class':_that.rows[_irow].className,'col':[]};
							_col=[];
							$.each(_that.rows[_irow].children,function(_icol,_vcol){
								if(_vcol.nodeName.toLowerCase()=='th' || _vcol.nodeName.toLowerCase()=='td'){
									_col[_icol]={};
									_col[_icol].node=_vcol.nodeName.toLowerCase();
									_col[_icol].attr=[];
									_col[_icol].value=_vcol.innerHTML.replace(/<(|\/)[^(b|u|i)](|[^>]+)>/gi,'');
									$.each(_vcol.attributes,function(i,a){
										_col[_icol].attr[i]=a.nodeName.toLowerCase()+'="'+a.value+'"';
									});
								}
							});
							_row.col=_col;
							if(_that.rows[_irow].parentNode.nodeName.toLowerCase()=='tfoot')
								_row.class+=' spesial';
							if(_that.rows[_irow].parentNode.nodeName.toLowerCase()=='thead')
								tTable.head[tTable.head.length]=_row;
							else
								tTable.body[tTable.body.length]=_row;
						}
						_irow++;
						if(_irow>=_nrow){
							clearInterval(_processor);
							if(typeof retunFunction === 'function') {
								retunFunction(tTable);
							}
						}
						_busy = false;
					}
				},1);
			};
			
			var _timestamp=new Date().getTime();
			$(_that).before('<div style="padding:5px;position:relative"><button class="btn btn-success btn-exp-copy-'+_timestamp+'" id="btn-exp-copy-'+_timestamp+'">Copy</button> <button class="btn btn-success btn-exp-xls-'+_timestamp+'">Excel</button> <button class="btn btn-success btn-exp-pdf-'+_timestamp+'">PDF</button></div>');
			$('.btn-exp-pdf-'+_timestamp).click(function(){
				var button = this;
				$(button).html('Loading..');
				$(button).prop('disabled',true);
				copyTable(button,function(table){
					$.post(tSetting.path+'down-pdf.php','dtype=pdf&dtitle='+encodeURIComponent(tSetting.title)+'&dcontent='+encodeURIComponent(JSON.stringify(tTable))+'&dhead='+encodeURIComponent(tSetting.header)+(tSetting.margin>10?'&mtop='+_margin_top:'') ,function(rs){
						if(rs=='') alert('Gagal mengekspor data, id tidak diterima');
						else window.open(tSetting.path+'down-pdf.php?sid='+rs,'_down_pdf');
						$(button).html('PDF');
						$(button).prop('disabled',false);
					});
				});
			});
			$('.btn-exp-xls-'+_timestamp).click(function(){
				var button = this;
				$(button).html('Loading..');
				$(button).prop('disabled',true);
				copyTable(button,function(table){
					$.post(tSetting.path+'down-pdf.php','dtype=xls&dtitle='+encodeURIComponent(tSetting.title)+'&dcontent='+encodeURIComponent(JSON.stringify(tTable))+'&dhead='+encodeURIComponent(tSetting.header)+(tSetting.margin>10?'&mtop='+_margin_top:'') ,function(rs){
						if(rs=='') alert('Gagal mengekspor data, id tidak diterima');
						else window.open(tSetting.path+'down-pdf.php?sid='+rs,'_down_pdf');
					}).error(function(){
						alert('Server Timeout');
					}).done(function(){
						$(button).html('Excel');
						$(button).prop('disabled',false);
					});
				});
			});
			$('#btn-exp-copy-'+_timestamp).ready(function(){
				var zclip = new ZeroClipboard($('#btn-exp-copy-'+_timestamp));
				zclip.setText('');
				var htmlMD = function(a,b){
					zclip.setText('');zclip.setText(_that.outerHTML.replace(/<script(.*?)>([\s\S]*?)<\/script>|\t|\s\s|<(td|th) style="display:none">(.*?)<\/(td|th)>/gi,''));
				};
				zclip.addEventListener('mouseDown', htmlMD);
				zclip.addEventListener('complete', function(){
					alert('Selesai meng-copy data.');
				});
			});
		});
	};
	$.fn.exportTable = exportTable;
}));
}(window, document));