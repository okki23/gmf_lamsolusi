var msg_box = function(msg,btn,title){
	if(btn==undefined) btn=['btnOK'];
	if(title==undefined) title='Informasi:';
	var wdwBox = $('<div />').kendoWindow({
		title: title,
		actions: ['Close'],
		modal: true,
		pinned: true,
		resizable: false,
		width: "400px",
		open:function(){
			var _wdoc = $(window).width();
			var _left = _wdoc/2-200;
			this.wrapper.css({top:'150px',left:_left+'px','padding-top':'35px'}).find('.k-window-titlebar.k-header').css({'margin-top':'-35px'});
		},close:function(){
			wdwBox.data('kendoWindow').destroy();
		}
	});
	var addBtn = function(t,f){
		var tmp='';
		if(t=='btnOK')
			tmp = ' <button type="button" class="btn btn-primary '+t+'">OK</button>';
		if(t=='btnYES')
			tmp = ' <button type="button" class="btn btn-success '+t+'">YES</button>';
		if(t=='btnCANCEL')
			tmp = ' <button type="button" class="btn btn-warning '+t+'">Cancel</button>';
		if(t=='btnNO')
			tmp = ' <button type="button" class="btn btn-danger '+t+'">No</button>';
		if(tmp!=''){
			wdwBox.find('div.btn-wrapper').append(tmp);
			wdwBox.find('.'+t).bind('closeWindow',function(){
				wdwBox.data('kendoWindow').destroy();
			});
			wdwBox.find('.'+t).click(f);
		}
	};
	wdwBox.data("kendoWindow").content('<p class="content"></p><div class="btn-wrapper pull-right"></div><div class="k-overlay loader loader-center loader-black" style="opacity: 0.5;"></div>').center().open();
    wdwBox.find('p.content').html(msg);
    wdwBox.find('div.btn-wrapper').html();
	$.each(btn,function(i,v){
		if(typeof v == 'string')
			addBtn(v,function(){
				$(this).trigger('closeWindow');
			});
		if(typeof v == 'object'){
			$.each(v,function(o,f){
				addBtn(o,f);
			});
		}
	});
};