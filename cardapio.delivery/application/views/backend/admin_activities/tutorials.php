<div class="row">
	<?php if(isset($is_create) && $is_create==1): ?>
		<div class="col-md-7">
			<form class="validForm" action="<?= base_url('admin/home/add_tutorials/') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
			<div class="">
				<div class="card">
					<div class="card-header">
						<h4><?= lang('tutorials'); ?></h4>
						
					</div>
					<div class="card-body">
						<div class="row p-15">
							<div class="row">
								<div class="form-group col-md-12">
									<label for="title"><?= !empty(lang('title'))?lang('title'):" Title";?> <span class="error">*</span></label>
									<input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"Title";?>" value="<?= !empty($data['title'])?html_escape($data['title']):""; ?>" required>
								</div>

								<div class="form-group col-md-12">
									<label for="page_title"><?= !empty(lang('page_title'))?lang('page_title'):" Title";?> <span class="error">*</span></label>
									<input type="text" name="page_title" id="page_title" class="form-control" placeholder="ex: Email Settings,General Settings...." value="<?= !empty($data['page_title'])?html_escape($data['page_title']):""; ?>" required>
								</div>

								<div class="form-group col-md-12">
									<label><?= lang('details');?> <span class="error">*</span></label>
									<textarea name="details" id="details" class="form-control textarea" cols="30" rows="10" required><?= !empty($data['details'])?html_escape($data['details']):""; ?></textarea>
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
			
	</div><!-- col-9 -->
<?php else: ?>
	<div class="col-md-8 ">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header space-between">
						<h4><?= lang('tutorials'); ?></h4>
						<div>
							<a href="<?= base_url("admin/home/create_tutorials");?>" class="btn btn-secondary"><i class="fa fa-plus"></i> <?= lang('add_new');?></a>
						</div>
					</div>
					<div class="card-body">
						<div class="row p-15">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
											<th><?= lang('title'); ?></th>
											<th><?= lang('page_title'); ?></th>
											<th><?= lang('status'); ?></th>
											<th><?= lang('action'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1; foreach ($question_list as $row): ?>
										<tr>
											<td><?= $i;?></td>
											<td><?= html_escape($row['title']); ?></td>
											<td><?= html_escape($row['page_title']); ?></td>
											<td>
												<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="admin_tutorial_list" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
											</td>
											<td>
												
												<a href="<?= base_url('admin/home/edit_tutorials/'.html_escape($row['id'])); ?>"  class="btn btn-sm btn-info"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>

												<a href="<?= base_url('admin/home/item_delete/'.html_escape($row['id']).'/admin_tutorial_list'); ?>" class=" action_btn btn btn-sm btn-danger" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>" ><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>

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
		</div>
	</div>	
<?php endif; ?>
</div>

