<?php $timestamp = time();?>
<form class="form-horizontal" id='form-copa-<?php echo $timestamp; ?>' action='<?php echo site_url('finance/copa_table'); ?>' method='POST'>
  <div class="col-sm-6" style="float: none; margin: 0 auto;">
    <fieldset>
      <legend><input id="filter_req_id" type="radio" name='filter' value='f_satu' checked> Filter By Request Number</legend>
      <div class="form-group">
        <label class="col-sm-4 control-label" for="">Request Number</label>
        <div class="col-sm-6">
          <input type='text' name='req_number'  class='form-control'/>
        </div>
      </div>
    </fieldset>

    <fieldset>
      <legend><input id="filter_req_id" type="radio" name='filter' value='f_dua'> Custom Filter</legend>
      <div class="form-group">
    		<label class="col-sm-4 control-label" for="">Reqeust Type:</label>
    		<div class="col-sm-8">
    			<input type='text' name='req_type' style="width:100%" class='kendodropdown form-control' placeholder='&mdash;&mdash;All Status&mdash;&mdash;'/>
    		</div>
    	</div>

      <div class="form-group">
    		<label class="col-sm-4 control-label" for="">Status COPA:</label>
    		<div class="col-sm-8">
    			<input type='text' name='status' style="width:100%" class='kendodropdown form-control' placeholder='&mdash;&mdash;All Status&mdash;&mdash;'/>
    		</div>
    	</div>
    </fieldset>

  	<div class="form-group">
  		<label class="col-sm-4 control-label" for="">&nbsp;</label>
  		<div class="col-sm-2">
  			<button type="submit" class="btn btn-primary" >Show Data</button>
  		</div>
  		<div  style ='float:left;' id='pesan'></div>
  	</div>
  </div>
</form>

<div>
  <nav id="btn_area" class="navbar navbar-default  no-margin" role="navigation" style="display:none; padding:5px 10px; border-width: 0 0 1px; border-top-width: 0px;border-right-width: 0px; border-bottom-width: 1px; border-left-width: 0px;">
  	<div class="navbar-left">
  		<div class="btn-group">
  			<?php
  				echo'<button class="btn btn-info navbar-btn " id="lock-copa"><i class="glyphicon glyphicon-folder-close"></i>  '.lang('btn_copa_lock').' </button> ';
  				echo'<button class="btn btn-primary navbar-btn " id="unlock-copa"><i class="glyphicon glyphicon-folder-open"></i>  &nbsp;'.lang('btn_copa_unlock').' </button> ';
  			?>
  		</div>
  	</div>
  </nav>

  <div style='padding-top:15px;'>
	   <div  id="info-copa-<?php echo $timestamp; ?>" ></div>
  </div>
</div>

<script>
  $(document).ready(function(){
    <?php echo $js_dropdown; ?>

    $('#form-copa-<?php echo $timestamp; ?>').submit(function(e){
      e.preventDefault();
      var sendItem = $(this).serialize();
      $.post($(this).attr('action'),sendItem,function(data){
        $('#btn_area').show();
        $('#info-copa-<?php echo $timestamp; ?>').html(data);
      });
    });

    $('#lock-copa').click(function(){
      var txt;
      var checkedVals = $('.requestId:checkbox:checked').map(function() {
        return this.value;
      }).get();
      if(checkedVals !=''){
          $(this).trigger('closeWindow');
          checkedVals.forEach(function(element){
            $("#"+element).hide('slow');
          });
          var requestId= checkedVals.join(",");
          $.post('<?php echo site_url('finance/copa_edit'); ?>',{id:requestId, type:'lock'},function(data){
                msg_box(data,['btnOK'],'Info!');
          });
      }else
        msg_box('No data Selected',['btnOK'],'Info!');
    });

    $('#unlock-copa').click(function(){
      var txt;
      var checkedVals = $('.requestId:checkbox:checked').map(function() {
        return this.value;
      }).get();
      if(checkedVals !=''){
          $(this).trigger('closeWindow');
          checkedVals.forEach(function(element){
            $("#"+element).hide('slow');
          });
          var requestId= checkedVals.join(",");
          $.post('<?php echo site_url('finance/copa_edit'); ?>',{id:requestId, type:'unlock'},function(data){
                msg_box(data,['btnOK'],'Info!');
          });
      }else
        msg_box('No data Selected',['btnOK'],'Info!');
    });

  });
</script>
