var zeroClip = null;
function zeroInit() {
	zeroClip = new ZeroClipboard.Client();
	zeroClip.setHandCursor( true );
	zeroClip.addEventListener('complete', function(client, text){
		alert(" Your alert goes gere : " + text + "\n Content already copied on clipboard !");
	});
}
function eksporTabel(tabel){
	var _path='down-pdf.php';
	var _title='';
	var _header='';
	var _margin_top=0;
	this._busy=false;
	var _processor=undefined;
	this.setPath=setPath;
	function setPath(path){_path=path;}
	this.setTitle=setTitle;
	function setTitle(title){_title=title;}
	this.setHeader=setHeader;
	function setHeader(header){_header=header;}
	this.setMarginTop=setMarginTop;
	function setMarginTop(margin){_margin_top=margin;}
	this.copyTable=copyTable;
	function copyTable(button,retunFunction){
		if (_processor) clearInterval(_processor);
		var jmlBaris = $(tabel+'>tbody tr').length;
		var jmlKaki = $(tabel+' tfoot').length;
		var jmlBatas = jmlBaris+jmlKaki;
		var _rows = '',i=0;
		$(button).html('Loading..');
		$(button).prop('disabled',true);
		_processor = setInterval(function(){
			if(!this._busy){
				this._busy=true;
				var i2=0;
				if(i<jmlKaki){
					i2 = jmlKaki-i-1;
					var _pfoot = $(tabel+' tfoot:eq('+i2+')').parent('table');
					$(tabel+' tfoot:eq('+i2+')').detach().appendTo(_pfoot);
				}else{
					i2 = i-jmlKaki;
					if(!($(tabel+'>tbody tr:eq('+i2+')>td:first').attr('colspan')>1 || $(tabel+'>tbody tr:eq('+i2+')').css('display')=='none') && $(tabel+'>tbody tr:eq('+i2+')').length>0){
						var pbaris = $(tabel+'>tbody tr:eq('+i2+')').parent().prop('tagName').toLowerCase();
						_rows+='<tr'+(pbaris=='tbody'?'':' class="spesial"')+'>'+$(tabel+'>tbody tr:eq('+i2+')').html()+'</tr>';
					}
				}
				i++;
				if(i>=jmlBatas){
					clearInterval(_processor);
					var _table = '<table class="table table-bordered">';
					_table	+= '<thead>'+$(tabel+'>thead:first').html()+'</thead>';
					_table	+= '<tbody>'+_rows+'<tr class="spesial">'+$(tabel+'>tfoot>tr:first').html()+'</tr></tbody></table>';
					_table = _table.replace(/<script(.*?)>([\s\S]*?)<\/script>|\t|\s\s|<(td|th) style="display:none">(.*?)<\/(td|th)>/gi,'');
					if(typeof retunFunction === 'function') {
						retunFunction(_table);
					}
				}
				this._busy = false;
			}
		},1);
	}
	var _timestamp=new Date().getTime();
	$(tabel).before('<div style="padding:5px;position:relative"><button class="btn btn-success btn-exp-copy-'+_timestamp+'" id="btn-exp-copy-'+_timestamp+'">Copy</button> <button class="btn btn-success btn-exp-xls-'+_timestamp+'">Excel</button> <button class="btn btn-success btn-exp-pdf-'+_timestamp+'">PDF</button></div>');
	$('.btn-exp-pdf-'+_timestamp).click(function(){
		button = this;
		copyTable(button,function(table){
			$.post(_path,'dtitle='+encodeURIComponent(_title)+'&dcontent='+encodeURIComponent(table)+'&dhead='+encodeURIComponent(_header)+(_margin_top>10?'&mtop='+_margin_top:'') ,function(rs){
				if(rs=='') alert('Gagal mengekspor data, id tidak diterima');
				else window.open(_path+'?sid='+rs,'_down_pdf');
				$(button).html('PDF');
				$(button).prop('disabled',false);
			});
		});
	});
	$('#btn-exp-copy-'+_timestamp).ready(function(){
	var zclip = new ZeroClipboard($('#btn-exp-copy-'+_timestamp));
	zclip.setText('');
	var htmlMD = function(a,b){
		copyTable('#btn-exp-copy-'+_timestamp,function(e){
			zclip.setText('');zclip.setText(e);
			/*/<((|\/)(table|thead|tbody)|(tr|th|td))(|[^>]+)>|\t/<\/(th|td)>/<\/tr>/*/
			$('#btn-exp-copy-'+_timestamp).html('Copy');
			$('#btn-exp-copy-'+_timestamp).prop('disabled',false);
			alert('Selesai meng-copy data.');
		});
    };
    zclip.addEventListener('mouseDown', htmlMD);
	});
}