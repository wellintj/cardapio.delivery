<div class="row">
	<div class="col-md-6">
		<?php
		$total = $this->admin_m->count_packages_user_id('item_packages', $is_special = 1);;
		$limit = limit(auth('id'), 1);
		?>
		<?php if ($limit == 0) : ?>
			<div class="single_alert alert alert-info alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<div class="d_flex_alert ">
					<h4><i class="fas fa-exclamation-triangle"></i> <?= lang('info'); ?></h4>
					<div class="double_text">
						<div class="text-left">
							<h5><?= lang('you_can_add'); ?> <b class="underline"> <?= lang('unlimited'); ?> </b> <?= lang('items'); ?></h5>
						</div>

					</div>
				</div>
			</div>
			<?php $active = 1; ?>
		<?php elseif ($total >= $limit) : ?>
			<div class="single_alert alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<div class="d_flex_alert ">
					<h4> <i class="fas fa-exclamation-triangle"></i> <?= lang('alert'); ?></h4>
					<div class="double_text">
						<div class="text-left">
							<h5> <b><?= lang('sorry'); ?></b></h5>
							<p><?= lang('you_reached_max_limit'); ?>: <?= $limit; ?></p>
						</div>

					</div>
				</div>
			</div>
			<?php $active = 0; ?>
		<?php else : ?>
			<div class="single_alert alert alert-info alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<div class="d_flex_alert ">
					<h4><i class="fas fa-exclamation-triangle"></i> <?= lang('info'); ?></h4>
					<div class="double_text">
						<div class="text-left">
							<h5><?= lang('you_have_remaining'); ?> <b class="underline"> &nbsp; <?= ($limit - $total); ?> &nbsp;</b> <?= lang('out_of'); ?> <b class="underline"> &nbsp; <?= ($limit); ?> &nbsp;</b></h5>
						</div>

					</div>
				</div>
			</div>
			<?php $active = 1; ?>
		<?php endif; ?>
	</div>
</div>
<div class="row">


	<div class="col-md-12">
		<div class="card">
			<div class="card-header space-between">
				<h4 class="box-title"><?= lang('specialties'); ?></h4>
				<div class="box-tools pull-right">
					<?php if (isset($active) && $active == 1) : ?>
						<?php if (is_access('add') == 1) : ?>
							<a href="<?= base_url('admin/menu/create_specialties?lang=' . site_lang()); ?>" class="btn btn-secondary "><i class="fa fa-plus"></i> &nbsp;<?= !empty(lang('add_new')) ? lang('add_new') : "Add New"; ?> </a>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="card-body">
				<div class="upcoming_events">
					<div class="table-responsive responsiveTable">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= !empty(lang('sl')) ? lang('sl') : "sl"; ?></th>
									<th><?= lang('images'); ?></th>
									<th><?= lang('name'); ?></th>
									<th><?= lang('price'); ?></th>
									<th><?= lang('languages'); ?></th>
									<?php if (restaurant()->stock_status == 1) : ?>
										<th><?= !empty(lang('stock_status')) ? lang('stock_status') : "stock status"; ?></th>
									<?php endif; ?>
									<th><?= lang('status'); ?></th>
									<th><?= lang('action'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;
								foreach ($specialties as $row) : ?>
									<tr>
										<td data-label="#"><?= $i; ?></td>
										<td data-label="<?= lang('images'); ?>">
											<div class="serviceImgs">
												<img src="<?= base_url($row['thumb']); ?>" alt="">
											</div>
										</td>
										<td data-label="<?= lang('name'); ?>"><?= html_escape($row['package_name']); ?>
											<?php if ($row['is_home'] == 1) : ?>
												&nbsp; <label class="label label-success" title="show in home page"><i class="fa fa-home"></i></label>
											<?php endif; ?>
											<?= __taxStatus(restaurant()->is_tax, $row); ?>
										</td>
										<td data-label="<?= lang('price'); ?>">
											<?= currency_position($row['final_price'], restaurant()->id); ?>
											<?php if ($row['is_discount'] == 1) : ?>
												<span class="price_discount">
													<?= currency_position($row['price'], restaurant()->id); ?>
												</span> &nbsp;
												<label class="label default-light-active"><?= html_escape($row['discount']); ?> %</label>
											<?php endif; ?>
										</td>
										<td data-label="<?= lang('languages'); ?>"><?= html_escape($row['language']); ?></td>

										<?php if (restaurant()->stock_status == 1) : ?>
											<td data-label="<?= __('stock_status'); ?>">
												<span class="label default-light"><?= lang('in_stock'); ?> <?= $row['in_stock']; ?></span>
												<span class="label default-light"><?= lang('remaining'); ?> <?= $row['in_stock'] - $row['remaining']; ?></span>
											</td>
										<?php endif; ?>

										<td data-label="<?= lang('status'); ?>">
											<?php if (is_access('change-status') == 1) : ?>
												<a href="javascript:;" data-id="<?= html_escape($row['id']); ?>" data-status="<?= html_escape($row['status']); ?>" data-table="item_packages" class="label <?= $row['status'] == 1 ? 'label-success' : 'label-danger' ?> change_status"> <i class="fa <?= $row['status'] == 1 ? 'fa-check' : 'fa-close' ?>"></i>&nbsp; <?= $row['status'] == 1 ? (!empty(lang('live')) ? lang('live') : "Live") : (!empty(lang('hide')) ? lang('hide') : "Hide"); ?></a>
											<?php endif; ?>

										</td>

										<td data-label="<?= lang('action'); ?>" class="action">
											<a href="<?= base_url('admin/menu/edit_specialties/' . html_escape($row['package_id'])); ?>?action=clone" class="btn btn-secondary btn-sm"><i class="fa fa-clone"></i></a>
											<div class="btn-group">
												<a href="javascript:;" class="dropdown-btn dropdown-toggle btn btn-danger btn-sm btn-flat" data-toggle="dropdown" aria-expanded="false">
													<span class="drop_text"><?= lang('action'); ?> </span> <span class="caret"></span>
												</a>

												<ul class="dropdown-menu dropdown-ul" role="menu">
													<?php if (is_access('update') == 1) : ?>
														<li class="cl-info-soft"><a href="<?= base_url('admin/menu/edit_specialties/' . html_escape($row['id'])); ?>"><i class="fa fa-edit"></i> <?= !empty(lang('edit')) ? lang('edit') : "edit"; ?></a></li>
													<?php endif; ?>

													<?php if (restaurant()->stock_status == 1) : ?>
														<?php if (is_access('update') == 1) : ?>
															<li class="cl-danger-soft"><a href="<?= base_url('admin/menu/reset_count/' . $row['id'] . '/item_packages'); ?>" class=" action_btn" data-msg="<?= lang('reset_stock_count'); ?>"> <i class="icofont-refresh"></i> <?= !empty(lang('reset_count')) ? lang('reset_count') : "Reset Count"; ?></a></li>
														<?php endif; ?>
													<?php endif; ?>
													<?php if (is_access('delete') == 1) : ?>
														<li class="cl-danger-soft"><a href="<?= base_url('delete-item/' . html_escape($row['id']) . '/item_packages'); ?>" class=" action_btn" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete')) ? lang('delete') : "Delete"; ?></a></li>
													<?php endif; ?>
												</ul>
											</div><!-- button group -->

										</td>
									</tr>
								<?php $i++;
								endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>



</div>
<!-- end menu type -->