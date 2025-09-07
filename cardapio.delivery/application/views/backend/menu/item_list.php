<div class="row">
	<?php $lang = isset($_GET['lang']) ? $_GET['lang'] : site_lang(); ?>
	<?php $multilang = isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1 ? 1 : 0; ?>
	<?php if ($multilang == 0) : ?>
		<div class="col-md-8">
			<div class="card">
				<div class="card-body flex_between">
					<h4><?= lang('enable_multi_lang_category_items'); ?></h4> <a href="<?= base_url("admin/auth/enable_category"); ?>" class="btn btn-secondary action_btn"><?= lang('enable'); ?></a>
				</div>
			</div>
		</div>
		<?php $lang = 'english'; ?>
		<?php $add_new_url = base_url("admin/menu/create_category"); ?>
	<?php else : ?>
		<?php
		$controller = $this->uri->rsegment(1); // The Controller
		$function = $this->uri->rsegment(2);
		$params = $this->uri->rsegment(3);

		?>
		<?php if (isset($is_create) && $is_create == 0) : ?>
			<?php //include 'language_dropdown.php'; 
			?>
		<?php endif; ?>

		<?php $add_new_url = base_url("admin/menu/create_category/?lang={$lang}"); ?>
	<?php endif; ?>
</div>
<div class="row ">
	<?php include 'inc/limit_counter.php'; ?>

	<div class="col-md-11">
		<?php $i = 1;
		foreach ($all_items as $key => $value) : ?>
			<?php
			if ($multilang == 0) :
				$add_item_url = base_url("admin/menu/create_item?cat=" . md5(multi_lang(auth('id'), $value)));
			else :
				$add_item_url = base_url("admin/menu/create_item?cat=" . md5(multi_lang(auth('id'), $value)) . "&lang={$lang}");
			endif;

			$category_name = $value['name'];
			$category_id = multi_lang(auth('id'), $value);
			?>

			<div class="card itemListTable">
				<div class="card-header justify-content-between buttonGroup">
					<div class="left <?= multi_lang(auth('id'), $value); ?>">
						<a href="<?= base_url("admin/menu/item"); ?>" class="pull-left d_color mr-15">
							<h3><i class="icofont-double-left"></i> <?= html_escape($value['name']); ?> - <?= lang('id'); ?> : <?= multi_lang(auth('id'), $value); ?></h3>
						</a>
						<?php if (isset($active) && $active == 1) : ?>
							<?php if (is_access('add') == 1) : ?>
								<a href="<?= $add_item_url; ?>" class="btn btn-secondary pull-right"><i class="fa fa-plus"></i> <?= lang('add_new'); ?></a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<div class="right">

						<a href="#lnModal_<?= $lang; ?>" data-toggle="modal" class="btn btn-success btn-sm"><i class="icofont-upload"></i> <?= lang('import'); ?> </a>
						<a href="<?= base_url("admin/menu/exportcvs/{$lang}"); ?>" class="btn btn-secondary btn-sm"> <i class="icofont-download"></i> <?= lang('template'); ?></a>
						<a href="#infoModal" data-toggle="modal" class="btn btn-info btn-sm"> <i class="icofont-question-circle"></i> </a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive responsiveTable">
						<table class="table table-condensed table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th><?= !empty(lang('images')) ? lang('images') : "images"; ?> </th>
									<th width="20%"><?= !empty(lang('title')) ? lang('title') : "title"; ?></th>
									<th width="35%"><?= !empty(lang('price')) ? lang('price') : "price"; ?> </th>
									<th><?= !empty(lang('extra')) ? lang('extra') : "extra"; ?></th>
									<?php if (restaurant()->stock_status == 1) : ?>
										<th><?= !empty(lang('stock_status')) ? lang('stock_status') : "stock status"; ?></th>
									<?php endif; ?>
									<th><?= !empty(lang('status')) ? lang('status') : "status"; ?></th>
									<th width="10%"><?= !empty(lang('action')) ? lang('action') : "action"; ?></th>
								</tr>
							</thead>
							<tbody id="sortable" class="sortable sorting">
								<?php $j = 1;
								foreach ($value['items'] as $row) : ?>


									<tr id='<?= $row['id']; ?>'>
										<td data-label="#" class="handle"><?= $j; ?></td>
										<td data-label="<?= lang('images'); ?>" class="handle">
											<div class="serviceImgs">
												<?php if ($row['img_type'] == 1) : ?>
													<img src="<?= base_url(!empty($row['thumb']) ? $row['thumb'] : EMPTY_IMG); ?>" alt="">
												<?php else : ?>
													<img src="<?= !empty($row['img_url']) ? $row['img_url'] : base_url(EMPTY_IMG); ?>" alt="">
												<?php endif; ?>
											</div>
										</td>
										<td data-label="<?= lang('title'); ?>" class="handle">
											<?= html_escape($row['title']); ?>
											<?php if ($row['veg_type'] == 1) : ?>
												<label class="label" data-toggle="tooltip" title="<?= !empty(lang('veg')) ? lang('veg') : "veg"; ?>"><i class="fa fa-circle veg_type c_green"></i></label>
											<?php elseif ($row['veg_type'] == 2) : ?>
												<label class="label" data-toggle="tooltip" title="<?= !empty(lang('non_veg')) ? lang('non_veg') : "Non veg"; ?>"><i class="fa fa-circle veg_type c_red"></i></label>
											<?php endif; ?>
											<?= __taxStatus(restaurant()->is_tax, $row); ?>


											<?php if (isset($row['sub_category_id']) && !empty($row['sub_category_id']) && __sub() == 1) : ?>
												<div class="mt-5">
													<small class="subcat"><?= lang('sub_category'); ?> : <?= subcat($row['sub_category_id']); ?></small>
												</div>
											<?php endif; ?>

										</td>
										<td data-label="<?= lang('price'); ?>">
											<?php if ($row['is_size'] == 0) : ?>
												<?= __price($row, restaurant()->id); ?>
											<?php else : ?>
												<?php
												$price = json_decode($row['price']); ?>
												<div class="sizeTags">

													<?php if (isset($price->variant_name) && !empty($price->variant_name)) : ?>
														<p class="m-0 w_100"><?= lang('variant_name'); ?> : <?= $price->variant_name; ?></p>
														<?php foreach ($price->variant_options as $key => $value) : ?>
															<label class="label default-light-soft-active mb-3"><?= $value->name; ?> : <?= currency_position($value->price, restaurant()->id); ?></label>
														<?php endforeach; ?>


													<?php else : ?>


														<?php
														foreach ($price as $key => $value) :
															if (!empty($value)) :
														?>
																<label class="label default-light-soft-active mb-3"><?= $this->admin_m->get_size_by_slug($key, auth('id')); ?> : <?= currency_position($value, restaurant()->id); ?></label>
														<?php
															endif;
														endforeach;
														?>
													<?php endif; ?>
												</div>
											<?php endif; ?>
										</td>
										<td data-label="<?= lang('extras'); ?>">
											<?php if (isJson($row['allergen_id'])) : ?>
												<label class="label bg-primary-soft text-wrap-wrap"><?= lang('allergens'); ?> : <?= is_array(json_decode($row['allergen_id'])) ? allergens(json_decode($row['allergen_id'])) : ''; ?></label>
											<?php endif; ?>

											<div class="mt-5 gap-5">
												<?php if ($row['is_features'] == 1) : ?>
													<label class="label bg-success-soft" data-toggle="tooltip" title="show in home page"><i class="fa fa-home"></i></label>
												<?php endif; ?>

												<?php if ($row['is_pos_only'] == 1) : ?>
													<label class="label bg-purple-soft-active" data-toggle="tooltip" title="<?= __('only_for_pos') ?>"><i class="fas fa-shopping-basket"></i></label>
												<?php endif; ?>

												<?php if ($row['is_pos_only'] == 2) : ?>
													<label class="label primary-light-active" data-toggle="tooltip" title="<?= __('only_for_package') ?>"><i class="fas fa-box-open"></i></label>
												<?php endif; ?>
												<?php $is_extra = $this->admin_m->get_my_addons($row['id'], $row['shop_id']); ?>

												<?php if (sizeof($is_extra) > 0) : ?>
													<label class="label info-light-active" data-toggle="tooltip" title="<?= __('extras') ?>"><i class="icofont-library"></i></label>
												<?php endif ?>




											</div>
										</td>
										<?php if (restaurant()->stock_status == 1) : ?>
											<td data-label="<?= lang('stock_status'); ?>">
												<span class="label default-light-active"><?= lang('in_stock'); ?> <?= $row['in_stock']; ?></span>
												<div class="mt-5">
													<span class="label bg-success-soft"><?= lang('remaining'); ?> <?= $row['in_stock'] - $row['remaining']; ?></span>
												</div>
											</td>
										<?php endif; ?>

										<td data-label="<?= lang('status'); ?>">
											<?php if (is_access('change-status') == 1) : ?>
												<a href="javascript:;" data-id="<?= html_escape($row['id']); ?>" data-status="<?= html_escape($row['status']); ?>" data-table="items" class="label <?= $row['status'] == 1 ? 'label-success' : 'label-danger' ?> change_status"> <i class="fa <?= $row['status'] == 1 ? 'fa-check' : 'fa-close' ?>"></i>&nbsp; <?= $row['status'] == 1 ? (!empty(lang('live')) ? lang('live') : "Live") : (!empty(lang('hide')) ? lang('hide') : "Hide"); ?></a>
											<?php endif; ?>

										</td>
										<td data-label="<?= lang('action'); ?>" class="text-left action">
											<div class="btn-group d-flex gap-5">
												<?php if (is_access('update') == 1) : ?>
													<?php if ($multilang == 0) :
														$clone_url = base_url("admin/menu/edit_item/{$row['id']}?action=copy");
													else :
														$clone_url = base_url("admin/menu/edit_item/{$row['id']}?action=copy&lang={$lang}");
													endif; ?>
													<a href="<?= $clone_url; ?>" class="btn btn-sm bg-info-soft mr-10"><i class="fa fa-clone"></i> <?= lang('clone'); ?></a>

												<?php endif; ?>

												<?php if (is_access('update') == 1) : ?>
													<?php if ($multilang == 0) :
														$edit = base_url("admin/menu/edit_item/{$row['id']}");
													else :
														$edit = base_url("admin/menu/edit_item/{$row['id']}?lang={$lang}");
													endif; ?>

													<a href="<?= $edit; ?>" class="btn btn-sm btn-info" data-toggle="tooltip" data-title="<?= !empty(lang('edit')) ? lang('edit') : "edit"; ?>"><i class="fa fa-edit"></i> </a>
												<?php endif; ?>


												<?php if (is_access('update') == 1 || is_access('add') == 1) : ?>
													<a href="<?= base_url("admin/menu/addons/{$row['id']}"); ?>" class="btn btn-sm btn-warning" data-title="<?= lang('add_extra'); ?> / <?= lang("addons") ?>" data-toggle="tooltip"><i class="icofont-library"></i> </a>
												<?php endif; ?>


												<?php if (restaurant()->stock_status == 1) : ?>
													<?php if (is_access('update') == 1) : ?>
														<a href="<?= base_url('admin/menu/reset_count/' . $row['id'] . '/items'); ?>" class=" action_btn btn btn-sm btn-danger" data-msg="<?= lang('reset_stock_count'); ?>"><i class="icofont-refresh"></i> <?= !empty(lang('reset_count')) ? lang('reset_count') : "Reset Count"; ?></a></li>
													<?php endif; ?>
												<?php endif; ?>

												<?php if (is_access('delete') == 1) : ?>
													<a href="<?= base_url('delete-item/' . html_escape($row['product_id']) . '/items'); ?>" class=" action_btn btn-sm btn btn-danger" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>" data-toggle="tooltip" data-title="<?= !empty(lang('delete')) ? lang('delete') : "Delete"; ?>"><i class="fa fa-trash"></i> </a>
												<?php endif; ?>



											</div>
											<!-- button group -->
										</td>
									</tr>
								<?php $j++;
								endforeach ?>

							</tbody>
						</table>

					</div>
				</div><!-- card-body -->
				<div class="card-footer makeChanges text-right" style="display:none;">
					<a href="javascript:;" class="btn btn-secondary reload"><?= lang('save'); ?></a>
				</div>
			</div><!-- card -->
		<?php $i++;
		endforeach ?>
		<a href="javascript:;" data-id="items" id="tables"></a>
	</div>
</div>


<div id="lnModal_<?= $lang; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?= $category_name ?? ''; ?> - <?= $lang; ?></h4>
			</div>
			<form action="<?= base_url("admin/menu/import/{$category_id}"); ?>" enctype="multipart/form-data" method="post">
				<?= csrf(); ?>
				<div class="modal-body">
					<input type="file" name="file" required accept=".csv,vnd.ms-excel">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success"><?= lang('submit'); ?></button>
				</div>
		</div>
		</form>

	</div>
</div>


<div id="infoModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Info</h4>
			</div>
			<div class="modal-body">
				<ol class="infoUl">
					<li><span>Image / thumb : </span>
						<p>uploaded image path in this script</p>
					</li>
					<li><span>is_feature : </span>
						<p>1 = show in home page / landing page.</p>
					</li>
					<li><span>veg_type : </span>
						<p> 1 = veg; 2 = non veg; 0 = none;</p>
					</li>
					<li><span>img_type : </span>
						<p>1 = if image is uploaded in this script; 2 = link from others sites</p>
					</li>
					<li><span>img_url : </span>
						<p>Extanal image link</p>
					</li>
				</ol>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal"><?= lang('close'); ?></button>
			</div>
		</div>

	</div>
</div>