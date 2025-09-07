<div class="row">
	<div class="col-md-6">
		<div class="card card-primary">
			<div class="card-header with-border">
				<h3 class="card-title"><?= !empty(lang('create_page')) ? lang('create_page') : "Create Page"; ?></h3>
			</div>
			<!-- /.card-header -->
			<form action="<?= base_url('admin/pages/create_page') ?>" method="post" enctype="multipart/form-data">
				<div class="card-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
							<label for="heading"><?= !empty(lang('title')) ? lang('title') : "title"; ?> <span class="error">*</span></label>
							<input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('title')) ? lang('title') : "package / pricing"; ?>" value="<?= !empty($data['title']) ? html_escape($data['title']) : set_value('title'); ?>">
						</div>

						<div class="form-group col-md-12">
							<label for="heading"><?= !empty(lang('slug')) ? lang('slug') : "slug"; ?><span class="error alert_text">* <?= lang('must_unique_english'); ?></span></label>
							<input type="text" name="slug" id="title" class="form-control" placeholder="<?= !empty(lang('slug')) ? lang('slug') : "package / pricing"; ?>" value="<?= !empty($data['slug']) ? html_escape($data['slug']) : set_value('slug'); ?>">
						</div>

						<div class="form-group col-md-12">
							<label for="price"><?= !empty(lang('details')) ? lang('details') : "details"; ?><span class="error">*</span></label>
							<textarea name="details" id="" class="form-control textarea" cols="30" rows="10"><?= !empty($data['details']) ? $data['details'] : set_value('details'); ?></textarea>

						</div>

						<div class="form-group col-md-6">
							<label for="title"><?= lang('languages'); ?> <span class="error">*</span></label>
							<?php languageDropdown($data); ?>
						</div>

						<div class="form-group col-md-12">
							<div class="">
								<label class="custom-checkbox"> <input type="checkbox" name="is_menu_bar" value="1" <?= isset($data['is_menu_bar']) && html_escape($data['is_menu_bar']) == "1" ? "checked" : ''; ?>><?= lang('show_in_menu_bar'); ?></label>
							</div>
						</div>


						<div class="form-group col-md-12">
							<label><?= !empty(lang('status')) ? lang('status') : "status"; ?></label>
							<div class="">
								<label class="text_direction custom-radio"><input type="radio" class="" name="status" value="1" <?= isset($data['status']) && html_escape($data['status']) == "1" ? "checked" : ''; ?> checked> &nbsp;<?= !empty(lang('live')) ? lang('live') : "live"; ?></label> &nbsp;&nbsp;
								<label class="text_direction custom-radio"><input type="radio" class="" name="status" value="0" <?= isset($data['status']) && html_escape($data['status']) == "0" ? "checked" : ''; ?>> &nbsp;<?= !empty(lang('hide')) ? lang('hide') : "hide"; ?></label>
								&nbsp;&nbsp;

							</div>
						</div>





					</div>
					<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] != 0 ? $data['id'] : 0 ?>">
				</div><!-- /.card-body -->
				<div class="card-footer">
					<?php if (isset($data['id']) && $data['id'] != 0) { ?>
						<div class="pull-left">
							<a href="<?= base_url('admin/pages'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel')) ? lang('cancel') : "cancel"; ?></a>
						</div>
					<?php } ?>
					<div class="pull-right">
						<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit')) ? lang('submit') : "submit"; ?></button>
					</div>
				</div>
			</form>
		</div>

	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header with-border">
				<h3 class="card-title"><?= !empty(lang('all_pages')) ? lang('all_pages') : "All Pages"; ?></h3>
				
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<div class="upcoming_events">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th><?= !empty(lang('sl')) ? lang('sl') : "Sl"; ?></th>
									<th><?= !empty(lang('title')) ? lang('title') : "Title"; ?></th>
									<th><?= !empty(lang('slug')) ? lang('slug') : "Slug"; ?></th>
									<th><?= !empty(lang('language')) ? lang('language') : "language"; ?></th>
									<th><?= !empty(lang('status')) ? lang('status') : "Status"; ?></th>
									<th><?= !empty(lang('action')) ? lang('action') : "action"; ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;
								foreach ($pages as $row): ?>
									<tr>

										<td><?= $i; ?></td>
										<td><?= html_escape($row['title']); ?></td>
										<td> <?= html_escape($row['slug']); ?></td>
										<td> <?= html_escape($row['language']); ?></td>

										<td>
											<?php if ($row['is_menu_bar'] == 1): ?>
												<label class="label label-primary"><i class="fa fa-home"></i></label>
											<?php endif ?>
											<a href="javascript:;" data-id="<?= html_escape($row['id']); ?>" data-status="<?= html_escape($row['status']); ?>" data-table="vendor_page_list" class="label <?= $row['status'] == 1 ? 'label-success' : 'label-danger' ?> change_status"> <i class="fa <?= $row['status'] == 1 ? 'fa-check' : 'fa-close' ?>"></i>&nbsp; <?= $row['status'] == 1 ? (!empty(lang('live')) ? lang('live') : "Live") : (!empty(lang('hide')) ? lang('hide') : "Hide"); ?></a>
										</td>
										<td><a href="<?= base_url('admin/pages/edit_page/' . html_escape($row['id'])); ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> </a>
											<a href="<?= base_url('delete-item/' . html_escape($row['id']) . '/vendor_page_list'); ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
										</td>
									<tr></tr>
									<tr>
										<td colspan="6"><?= lang('url'); ?> : <?= base_url('page/' . auth('username') . '/' . $row['slug']); ?></td>
									</tr>
									</tr>
								<?php $i++;
								endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div><!-- /.card-body -->
		</div>

	</div>
</div>