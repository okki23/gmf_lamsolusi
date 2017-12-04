  <form role="form" id="f_change_email_csm" class="form-horizontal no-margin" method="post" action="<?php echo site_url("app/csm_mail_update"); ?>">
  	<div class="control-group form-group no-margin margin_b1">
  		<label class="col-sm-2 control-label" for="t_csm_email"><?php echo lang('form_cfg_csm_mail'); ?>:</label>
  		<div class="col-sm-8 controls">
  			<input type="text" value="<?php echo $csm_email; ?>" name="csm_email" id="t_csm_email" class="form-control" required="required" autofocus>
        <small id='smallText'><?php echo lang('msg_info_sperator'); ?></small>
      </div>
  	</div>

  	<div class="control-group form-group no-margin margin_b2">
  		<label class="col-sm-2 control-label"></label>
  		<div class="col-sm-9 controls">
  			<input type="submit" name="t_submit" id="t_submit" value="<?php echo lang('btn_proses'); ?>" class="btn btn-primary">
  			<input type="reset" name="t_reset" id="t_reset" value="<?php echo lang('btn_cancel'); ?>" class="btn btn-danger">
        <div id='pesan'></div>
  		</div>
  	</div>
  </form>

<script>
  $(document).ready(function(){
    $('#f_change_email_csm').submit(function(e){
      e.preventDefault();
      $.ajax({
        url :$(this).attr('action'),
        data:$(this).serialize(),
        type:'POST',
				dataType:'json',tail:1,
        beforeSend:function(){
					$('#pesan').addClass('loader2');
				},
				success:function(res){
          msg_box(res.messages,['btnOK'],'Info!');
        }
      }).done(function(){
        $('#pesan').removeClass('loader2');
      });
    });

  });
</script>
