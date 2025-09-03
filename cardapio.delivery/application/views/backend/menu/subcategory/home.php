<div class="row">
	<div class="col-md-5">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"> <?= lang('sub_category'); ?></h3>

			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/menu/add_sub_category') ?>" method="post" class="validForm" enctype="multipart/form-data">
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
							<label for="title"><?= !empty(lang('category')) ? lang('category') : "category"; ?></label>
							<select name="category_id" class="form-control">
								<option value=""><?= lang('select'); ?></option>
								<?php foreach ($menu_type as $key => $cat) : ?>
									<option value="<?= $cat['category_id']; ?>" <?= isset($data['category_id']) && $data['category_id'] == $cat['category_id'] ? "selected" : ""; ?>><?= $cat['name']; ?></option>
								<?php endforeach ?>
							</select>
						</div>



						<div class="form-group col-md-12">
							<label for="title"><?= !empty(lang('sub_category_name')) ? lang('sub_category_name') : "Sub Category Name"; ?> <span class="error">*</span></label>
							<input type="text" name="sub_category_name" id="sub_category_name" class="form-control" placeholder="<?= !empty(lang('sub_category_name')) ? lang('sub_category_name') : "Category Name"; ?>" value="<?= !empty($data['sub_category_name']) ? html_escape($data['sub_category_name']) : set_value('sub_category_name'); ?>">
						</div>


						<div class="form-group col-md-12 hidden">
							<label for="title"><?= !empty(lang('order')) ? lang('order') : "order"; ?></label>
							<input type="text" name="orders" class="form-control" value="<?= !empty($data['orders']) ? html_escape($data['orders']) : 0; ?>">
						</div>


					</div>
					<div class="row">
						<div class="col-md-6">
							<label class="defaultImg square">
								<?php if (isset($data['id']) && !empty($data['id'])) : ?>
									<a href="<?= base_url('admin/restaurant/delete_img/' . $data['id'] . '/items'); ?>" class="deleteImg <?= isset($data['thumb']) && !empty($data['thumb']) ? "" : "opacity_0" ?>" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>"><i class="fa fa-close"></i></a>
								<?php endif; ?>

								<img src="<?= isset($data['thumb']) && !empty($data['thumb']) ? base_url($data['thumb']) : "" ?>" alt="" class="imgPreview <?= isset($data['thumb']) && !empty($data['thumb']) ? "" : "opacity_0" ?>">

								<div class="imgPreviewDiv <?= isset($data['thumb']) && !empty($data['thumb']) ? "opacity_0" : "" ?>">
									<i class="fa fa-upload"></i>
									<h4><?= lang('upload_image'); ?></h4>
									<p class="fw_normal mt-3"><?= lang('max'); ?>: 500 x 500 px</p>
								</div>

								<input type="file" name="file[]" class="imgFile opacity_0" data-width="0" data-height="0">
							</label>
							<span class="img_error"></span>
						</div>
					</div>

				</div><!-- /.box-body -->
				<div class="box-footer">

					<input type="hidden" name="language" value="<?= site_lang() ?? 'english'; ?>">

					<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] != 0 ? html_escape($data['id']) : 0 ?>">
					<div class="pull-left">
						<a href="<?= base_url('admin/menu/sub_category'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel')) ? lang('cancel') : "cancel"; ?></a>
					</div>
					<div class="pull-right">
						<button type="submit" name="register" class="btn btn-secondary btn-block btn-flat"><?= !empty(lang('submit')) ? lang('submit') : "submit"; ?></button>
					</div>
				</div>
			</form>
		</div>
	</div> <!-- col-5 -->
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= lang('sub_categories'); ?> &nbsp; &nbsp;

				</h3>
				<div class="box-tools pull-right">

				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="upcoming_events">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= !empty(lang('sl')) ? lang('sl') : "sl"; ?></th>
									<th><?= lang('image'); ?></th>
									<th><?= lang('category_name'); ?></th>
									<th><?= lang('title'); ?></th>
									<th><?= lang('status'); ?></th>
									<th><?= lang('action'); ?></th>
								</tr>
							</thead>
							<tbody id="sortable" class="sortable sorting">
								<?php $i = 1;
								foreach ($sub_category_list as $row) : ?>
									<tr id='<?= $row['id']; ?>'>
										<td class="handle"><?= $i; ?></td>
										<td class="handle">
											<div class="serviceImgs">
												<img src="<?= get_img($row['thumb'], '', 1); ?>" alt="">
											</div>

										</td>
										<td class="handle"><?= html_escape($row['category_name']); ?></td>

										<td>
											<?= $row['sub_category_name']; ?>
										</td>
										<td>
											<?php if (is_access('change-status') == 1) : ?>
												<a href="javascript:;" data-id="<?= html_escape($row['id']); ?>" data-status="<?= html_escape($row['status']); ?>" data-table="sub_category_list" class="label <?= $row['status'] == 1 ? 'label-success' : 'label-danger' ?> change_status"> <i class="fa <?= $row['status'] == 1 ? 'fa-check' : 'fa-close' ?>"></i>&nbsp; <?= $row['status'] == 1 ? (!empty(lang('live')) ? lang('live') : "Live") : (!empty(lang('hide')) ? lang('hide') : "Hide"); ?></a>
											<?php endif; ?>
										</td>

										<td>

											<div class="btn-group">
												<a href="javascript:;" class="dropdown-btn dropdown-toggle btn btn-primary btn-sm btn-flat" data-toggle="dropdown" aria-expanded="false">
													<span class="drop_text"><?= lang('action'); ?> </span> <span class="caret"></span>
												</a>

												<ul class="dropdown-menu dropdown-ul" role="menu">

													<?php if (is_access('update') == 1) : ?>
														<li class="cl-info-soft"><a href="<?= base_url('admin/menu/edit_sub_category/' . html_escape($row['id'])); ?>"><i class="fa fa-edit"></i> <?= !empty(lang('edit')) ? lang('edit') : "edit"; ?></a></li>
													<?php endif; ?>
													<?php if (is_access('delete') == 1) : ?>
														<li class="cl-danger-soft"><a href="<?= base_url('delete-item/' . html_escape($row['id']) . '/sub_category_list'); ?>" class=" action_btn" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete')) ? lang('delete') : "Delete"; ?></a></li>
													<?php endif; ?>


												</ul>
											</div><!-- button group -->

										</td>
									</tr>
								<?php $i++;
								endforeach ?>
								<a href="javascript:;" data-id="sub_category_list" id="tables"></a>
							</tbody>
						</table>
					</div>
				</div>
			</div><!-- /.box-body -->
			<div class="box-footer makeChanges text-right" style="display:none;">
				<a href="javascript:;" class="btn btn-secondary reload"><?= lang('save'); ?></a>
			</div>
		</div>
	</div>
</div><!-- row -->