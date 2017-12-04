<form role="form" id="f_change_password" class="form-horizontal no-margin" method="post" action="<?php echo site_url("user/password"); ?>" style="width:550px;">
	<div class="control-group form-group no-margin margin_b1">
		<label class="col-sm-5 control-label" for="t_password_new">Password Baru:</label>
		<div class="col-sm-7 controls">
			<input type="password" name="t_password_new" id="t_password_new" class="form-control" required="required" autofocus>
		</div>
	</div>
	<div class="control-group form-group no-margin margin_b2">
		<label class="col-sm-5 control-label" for="t_password_confirm">Konfirmasi Password Baru:</label>
		<div class="col-sm-7 controls">
			<input type="password" name="t_password_confirm" id="t_password_confirm" class="form-control" required="required">
		</div>
	</div>
	<div class="control-group form-group no-margin margin_b1">
		<label class="col-sm-5 control-label" for="t_password_old">Password Lama:</label>
		<div class="col-sm-7 controls">
			<input type="password" name="t_password_old" id="t_password_old" class="form-control" required="required">
		</div>
	</div>
	<div class="control-group form-group no-margin margin_b2">
		<label class="col-sm-5 control-label"></label>
		<div class="col-sm-7 controls">
			<input type="submit" name="t_submit" id="t_submit" value="Ganti Password" class="btn btn-primary">
			<input type="reset" name="t_reset" id="t_reset" value="Batal" class="btn btn-primary">
		</div>
	</div>
</form>
