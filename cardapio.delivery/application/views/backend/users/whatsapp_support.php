<?php $app = !empty($restaurant['whatsapp_support']) && isJson($restaurant['whatsapp_support'])?json_decode($restaurant['whatsapp_support']):[]; ?>
<div class="row">
	<div class="col-md-6">
		<form class="validForm" action="<?= base_url('admin/auth/add_whatsapp_support');?>" method="post" enctype= "multipart/form-data" autocomplete="off">
			<?= csrf();?>
			<div class="card">
				<div class="card-header">
					<h4><?= lang('whatsapp_support'); ?></h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="form-group col-md-12">
							<label><?= !empty(lang('whatsapp_number'))?lang('whatsapp_number'):"Whatsapp Number";?>  <span class="error">*</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-whatsapp"></i> <input type="text" name="dial_code" class="dial-code" value="<?= isset($app->dial_code) && !empty($app->dial_code)?$app->dial_code :restaurant()->dial_code;?>"></span>
								<input type="text" name="whatsapp_number"  class="form-control" placeholder="<?= !empty(lang('whatsapp_number'))?lang('whatsapp_number'):"Whatsapp Number";?>" value="<?= isset($app->whatsapp_number) && !empty($app->whatsapp_number)?$app->whatsapp_number : "" ;?>" required>
							</div>

						</div>


						<div class="form-group col-md-12">
							
							<label><?= !empty(lang('welcome_message'))?lang('welcome_message'):"Welcome message";?>  <span class="error">*</label>
								<textarea name="welcome_message" class="form-control data_textarea" cols="5" rows="5" required><?= isset($app->welcome_message) && !empty($app->welcome_message)?$app->welcome_message: "" ;?></textarea>

						</div>

						<div class="col-md-12">
							<label><?= lang('status');?></label>
							<div class="">
								<label class="custom-radio"><input type="radio" name="status" value="1" <?= isset($app->status) && $app->status==1?"checked":"";?>><?= lang('enable');?></label>
								<label class="custom-radio"><input type="radio" name="status" value="0" <?= isset($app->status) && $app->status==0?"checked":"";?>><?= lang('disable');?></label>
							</div>
						</div>

						

					</div><!-- row -->
				</div><!-- card-body -->
				<div class="card-footer text-right">
					<input type="hidden" name="id" value="<?= isset($restaurant['id'])?html_escape($restaurant['id']):0; ?>">
					<button type="submit" class="btn btn-secondary"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</form>
	</div><!-- col-9 -->
	
		
</div>
