<div class="row resoponsiveRow">
	<?php include APPPATH.'views/backend/common/inc/leftsidebar.php'; ?>
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-5">
				<form class="email_setting_form" action="<?= base_url('admin/restaurant/add_questions/') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
					<div class="">
						<div class="card">
							<div class="card-header">
								<h4><?= lang('add_reason'); ?></h4>
							</div>
							<div class="card-body">
								<div class="row p-15">
									<div class="row">
										<div class="form-group col-md-12">
											<label for="title"><?= !empty(lang('title'))?lang('title'):" Title";?> <span class="error">*</span></label>
											<input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"Title";?>" value="<?= !empty($data['title'])?html_escape($data['title']):""; ?>">
										</div>
										<div class="form-group col-md-12">
											<label for="title"><?= !empty(lang('type'))?lang('type'):" type";?> <span class="error">*</span></label>
											<select name="type" class="form-control" id="type">
												<option value="order_reject"><?= lang('order_reject');?></option>
											</select>
										</div>

										<div class="form-group col-md-12">
											<label for="title"><?= lang('access_for');?> <span class="error">*</span></label>
											<select name="access_for" class="form-control" id="type">
												<option value="vendor" <?= isset($data['access_for']) && $data['access_for']=="vendor"?"selected":"";?>><?= lang('vendor');?></option>
												<option value="dboy" <?= isset($data['access_for']) && $data['access_for']=="dboy"?"selected":"";?>><?= lang('delivery_guy');?></option>
											</select>
										</div>

										<div class="form-group col-md-12">
											<label for="language"><?= !empty(lang('language'))?lang('language'):" language";?> <span class="error">*</span></label>
											<?php languageDropdown($data); ?>
										</div>
									</div>
								</div><!-- row -->

							</div><!-- card-body -->
							<div class="card-footer">
								<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>">
								<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
							</div>
						</div><!-- card -->
					</div><!-- col-9 -->
				</form>
			</div>
			<div class="col-md-7">
				<div class="card">
					<div class="card-header">
						<h4><?= lang('reason_list'); ?></h4>
					</div>
					<div class="card-body p-10">
						<div class="row p-15">
							<div class="table-responsive">
								<table class="table table-striped data_tables">
									<thead>
										<tr>
											<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
											<th><?= lang('title'); ?></th>
											<th><?= lang('type'); ?></th>
											<th><?= lang('access_for'); ?></th>
											<th><?= lang('action'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1; foreach ($question_list as $row): ?>
										<tr>
											<td><?= $i;?></td>
											<td><?= html_escape($row->title); ?></td>
											<td><?= !empty($row->type)?lang($row->type):$row->type; ?></td>
											<td><?= !empty($row->access_for)?lang($row->access_for):$row->access_for; ?></td>
											<td>
												
												<a href="<?= base_url('admin/restaurant/edit_question/'.html_escape($row->id)); ?>"  class="btn btn-sm btn-info"><i class="fa fa-edit"></i> </a>

												<a href="<?= base_url('item-delete/'.html_escape($row->id).'/vendor_question_list'); ?>" class=" action_btn btn btn-sm btn-danger" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>" ><i class="fa fa-trash"></i></a>

											</td>
										</tr>
										<?php $i++; endforeach ?>
									</tbody>
								</table>
							</div>
						</div><!-- row -->
						
					</div><!-- card-body -->
				</div><!-- card -->
			</div>
		</div><!-- row -->

	</div><!-- col-9 -->
	
</div>

