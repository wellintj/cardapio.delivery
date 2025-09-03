<style>
	#cropImg {
		display: block;
		max-width: 100%;

	}

	.cropingArea {
		height: 400px;
		width: 100%;
		position: relative;
	}

	.showCroppingArea {
		width: 100%;
		height: 100%;
	}
</style>
<?php $get = $this->input->get(null, true); ?>
<?php $multilang = isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1 ? 1 : 0; ?>
<?php if ($this->admin_m->count_table_user_id('menu_type') == 0) : ?>
	<div class="row">
		<div class="col-md-6">
			<div class="single_alert alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<div class="d_flex_alert">
					<h4><i class="icon fas fa-warning"></i> <?= lang('warning'); ?></h4>
					<div class="double_text">
						<div class="text-left">
							<h5><?= lang('insert_category'); ?></h5>
						</div>
						<a href="<?= base_url('admin/menu/category/'); ?>" class="re_url"><?= lang('click_here'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if ($this->admin_m->count_table_user_id('item_sizes') == 0) : ?>
	<div class="row hidden">
		<div class="col-md-6">
			<div class="single_alert alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<div class="d_flex_alert">
					<h4><i class="icon fas fa-warning"></i> <?= lang('warning'); ?></h4>
					<div class="double_text">
						<div class="text-left">
							<h5><?= lang('insert_item_size'); ?></h5>
							<p><?= lang('insert_item_size_msg'); ?></p>
						</div>
						<a href="<?= base_url('admin/menu/category/'); ?>" class="re_url"><?= lang('click_here'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="row">
	<?php include 'inc/limit_counter.php'; ?>
</div>
<?php if (isset($get['action']) && $get['action'] == 'copy') : ?>
	<div class="row">
		<?php if ($multilang == 1) : ?>
			<?php
			$controller = $this->uri->rsegment(1); // The Controller
			$function = $this->uri->rsegment(2);
			$params = $this->uri->rsegment(3);

			?>

			<div class="col-md-3">
				<div class="card">
					<select name="lang" class="form-control" onchange="location=this.value">
						<?php foreach (shop_languages(auth('id')) as $key => $row) : ?>
							<option value="<?= base_url("admin/{$controller}/{$function}/{$params}?action=copy&lang={$row->slug}"); ?>" <?= $lang == $row->slug ? "selected" : ""; ?>><?= $row->lang_name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endif ?>
<?php $lang = isset($get['lang']) ? $get['lang'] : site_lang(); ?>
<div class="row">
	<div class="col-md-7">
		<div class="card box-primary">
			<div class="card-header with-border">
				<h4 class="card-title"><?= !empty(lang('add_items')) ? lang('add_items') : "add items"; ?> - <small class="text-purple"><i class="fa fa-language"></i> <?= lang_slug($get['lang'] ?? site_lang()); ?></small></h4>

			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/menu/add_items') ?>" method="post" class="form-submit" enctype="multipart/form-data">
				<div class="card-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<?php
					if (isset($get['cat']) && !empty($get['cat'])) :
						$cat_id = $get['cat'];
					endif;
					?>
					<div class="row">
						<div class="form-group col-md-6">
							<label for=""><?= !empty(lang('categories')) ? lang('categories') : "categories"; ?> <span class="error">*</span></label>
							<select name="cat_id" class="form-control" required>
								<option value=""><?= lang('select_category'); ?></option>
								<?php foreach ($menu_type as $key => $type) : ?>
									<option data-type="<?= html_escape($type['type']); ?>" <?= isset($data['cat_id']) && $data['cat_id'] == $type['category_id'] ? "selected" : ""; ?> <?= isset($cat_id) && $cat_id == md5($type['category_id']) ? "selected" : ""; ?> value="<?= $type['category_id']; ?>"><?= $type['name']; ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<?php if (__sub() == 1) : ?>
							<div class="form-group col-md-6">
								<label for=""><?= !empty(lang('sub_categories')) ? lang('sub_categories') : "sub_categories"; ?></label>
								<select name="sub_category_id" class="form-control" id="sub_category">
									<?php if (isset($data['cat_id'])): ?>
										<?php $sub_category_list = $this->admin_m->get_subcategories_by_cat_id($data['cat_id'], $_ENV['ID'], $is_md5 = false); ?>
									<?php endif ?>
									<?php if (isset($sub_category_list) && sizeof($sub_category_list) > 0) : ?>
										<?php foreach ($sub_category_list as $sub_cat) : ?>
											<option value="<?= $sub_cat['id']; ?>" <?= isset($sub_cat['id']) && $sub_cat['id'] == $data['sub_category_id'] ? "selected" : ""; ?>><?= $sub_cat['sub_category_name']; ?></option>
										<?php endforeach ?>
									<?php else : ?>
										<option value=""><?= lang('select_category'); ?></option>
									<?php endif; ?>
								</select>
							</div>
						<?php endif; ?>


					</div>

					<div class="row">
						<?php restaurant()->stock_status == 1 ? $is_stock = 1 : $is_stock = 0; ?>
						<div class="form-group <?= $is_stock == 1 ? "col-md-6" : "col-md-12"; ?>">
							<label for="title"><?= !empty(lang('title')) ? lang('title') : "Title"; ?> <span class="error">*</span></label>
							<input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('item_name')) ? lang('item_name') : "item name"; ?>" value="<?= !empty($data['title']) ? html_escape($data['title']) : set_value('title'); ?>" required>
						</div>
						<?php if ($is_stock == 1) : ?>
							<div class="form-group <?= $is_stock == 1 ? "col-md-6" : "col-md-12"; ?>">
								<label><?= !empty(lang('in_stock')) ? lang('in_stock') : "in stock"; ?> <span class="error">*</span></label>

								<input type="text" name="in_stock" class="form-control" placeholder="<?= !empty(lang('in_stock')) ? lang('in_stock') : "in stock"; ?>" value="<?= !empty($data['in_stock']) ? html_escape($data['in_stock']) : 0; ?>">
							</div>
						<?php endif; ?>
					</div>


					<div class="row">
						<div class="form-group col-md-12 size_tag">
							<div class="d_flex_center">
								<label class="pointer label label bg-light-purple-soft vegs "><input <?= isset($data['is_size']) && $data['is_size'] == 1 ? 'checked' : ''; ?> type="checkbox" name="is_size" class="is_size defaultToggle" value="1">&nbsp; <?= !empty(lang('is_variants')) ? lang('is_variants') : "Is variants"; ?></label>
							</div>
						</div>
						<div class="rows show_price <?= isset($data['is_size']) && $data['is_size'] == 1 ? 'hidden' : ''; ?>">
							<div class="form-group col-md-6  ">
								<label for="price"><?= !empty(lang('current_price')) ? lang('current_price') : "Current price"; ?></label>
								<input type="text" name="price" id="price" class="form-control number" placeholder="<?= !empty(lang('price')) ? lang('price') : "price"; ?>" value="<?= !empty($data['price']) ? html_escape($data['price']) : set_value('price'); ?>">
							</div>
							<div class="form-group col-md-6">
								<label><?= __('previous_price'); ?></label>
								<input type="text" name="previous_price" class="form-control number" value="<?= !empty($data['previous_price']) ? html_escape($data['previous_price']) : set_value('previous_price'); ?>">
							</div>
						</div>

						<div class="col-md-12 show_size_price <?= isset($data['is_size']) && $data['is_size'] == 1 ? '' : 'hidden'; ?>">
							<div class="card mb-20">
								<div class="card-header space-between border-0">
									<h4><?= lang('variants'); ?></h4>
									<a href="#variantModal" data-toggle="modal" class="btn btn-secondary"><i class="fa fa-plus"></i><?= lang('add_variants'); ?></a>
								</div>
								<div class="card-body variant_body border-0 p-0">
									<div class="variantsLoad">
										<?php include APPPATH . 'views/backend/menu/inc/ajax_update_variants.php' ?>
									</div>
								</div>
							</div>
						</div>
					</div>


					<?php if (isset(restaurant()->is_tax) && restaurant()->is_tax == 1) : ?>
						<div class="row">
							<div class="form-group col-md-12 ml-0">
								<label><?= lang('tax_fee'); ?></label>
								<div class="row">

									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
												+
												<input type="hidden" name="tax_status" value="+">
											</span>
											<input type="number" name="tax_fee" id="tax_fee" class="form-control" placeholder="<?= !empty(lang('tax_fee')) ? lang('tax_fee') : "tax_fee"; ?>" value="<?= !empty($data['tax_fee']) ? html_escape($data['tax_fee']) : restaurant()->tax_fee; ?>">
											<span class="input-group-addon">%</span>
										</div>

									</div>
									<div class="col-md-12 ">
										<small><?= lang('price_tax_msg'); ?></small>
									</div>
								</div>
							</div>
						</div>
					<?php endif ?>

					<div class="row">
						<div class="form-group col-md-6">
							<label for=""><?= !empty(lang('veg_type')) ? lang('veg_type') : "Veg type"; ?></label>
							<div class="d_flex_center">
								<label class="pointer label success-light vegs"><input <?= isset($data['veg_type']) && $data['veg_type'] == 1 ? 'checked' : ''; ?> type="radio" name="veg_type" value="1">&nbsp; <?= !empty(lang('veg')) ? lang('veg') : "Veg"; ?></label>
								<label class="pointer label danger-light vegs"><input <?= isset($data['veg_type']) && $data['veg_type'] == 2 ? 'checked' : ''; ?> type="radio" name="veg_type" value="2">&nbsp; <?= !empty(lang('non_veg')) ? lang('non_veg') : "Non veg"; ?></label>

								<label class="pointer label default-light vegs"><input <?= isset($data['veg_type']) && $data['veg_type'] == 0 ? 'checked' : ''; ?> type="radio" name="veg_type" value="0">&nbsp; <?= lang('none'); ?></label>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-12">
							<label for=""><?= !empty(lang('allergens')) ? lang('allergens') : "allergens"; ?></label>
							<select name="allergen_id[]" class="form-control select2" id="" multiple style="min-height: 47px;">
								<option value=""><?= lang('select'); ?></option>
								<?php foreach ($allergens as $key => $value) : ?>
									<?php if (is_array(json_decode($data['allergen_id']))) : ?>
										<option <?= isset($data['allergen_id']) && in_array($value['id'], json_decode($data['allergen_id'])) == 1 ? "selected" : ""; ?> value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
									<?php else : ?>
										<option <?= isset($data['allergen_id']) && $data['allergen_id'] == $value['id'] ? "selected" : ""; ?> value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
									<?php endif; ?>
								<?php endforeach; ?>

							</select>
						</div>
					</div>

					<div class="row">
						<div class=" form-group col-md-12">
							<label><?= !empty(lang('small_description')) ? lang('small_description') : "small description"; ?> (<span class="characters small"></span>) <span class="error">*</span> </label>
							<textarea name="overview" id="" cols="5" rows="5" data-max="150" class="form-control count_text"><?= !empty($data['overview']) ? html_escape($data['overview']) : set_value('overview'); ?></textarea>
						</div>

						<div class="col-md-12">
							<label><?= !empty(lang('details')) ? lang('details') : "details"; ?></label>
							<textarea name="details" id="" cols="5" rows="5" class="form-control data_textarea"><?= !empty($data['details']) ? html_escape($data['details']) : set_value('details'); ?></textarea>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">

							<label class="label label-info pointer label_input custom-checkbox mr-10"><input type="checkbox" name="is_features" <?= isset($data['is_features']) && $data['is_features'] == 1 ? 'checked' : ""; ?> value="1"> <?= lang('show_in_homepage'); ?></label>

							<?php if (isset($get['action'])) : ?>
								<label class="label label-warning pointer label_input custom-checkbox ml-20"> <input type="checkbox" name="is_copy_extra" value="1"> <?= lang('add_those_extras_also'); ?></label>
							<?php endif; ?>
						</div>

						<div class="form-group col-md-12 mt-10">
							<label class="label success-light-active pl-3 label_input custom-radio"><input type="radio" name="is_pos_only" <?= isset($data['is_pos_only']) && $data['is_pos_only'] == 0 ? 'checked' : ""; ?> value="0" checked> <?= lang('all'); ?></label>
							<?php if (is_pos() == 1) : ?>
								<label class="label bg-purple-soft-active pl-3 label_input custom-radio"><input type="radio" name="is_pos_only" <?= isset($data['is_pos_only']) && $data['is_pos_only'] == 1 ? 'checked' : ""; ?> value="1"> <?= lang('only_for_pos'); ?></label>
							<?php endif ?>

							<label class="label primary-light-active pl-3 label_input custom-radio ml-10 <?= isset($data['is_size']) && $data['is_size'] == 1 ? "" : "hideArea" ?>"><input type="radio" name="is_pos_only" <?= isset($data['is_pos_only']) && $data['is_pos_only'] == 2 ? 'checked' : ""; ?> value="2"> <?= lang('only_for_package'); ?></label>

						</div>


					</div>


					<div class="row mt-15">
						<div class="col-md-12 col-lg-12 col-sm-12">

							<ul class="nav nav-tabs">
								<li class="<?= !empty($data) ? "" : "active"; ?> <?= isset($data['img_type']) && $data['img_type'] == 1 ? 'active' : ''; ?>"><a data-toggle="tab" class="tab_li" href="#image_tab" data-value="img"><?= lang('image'); ?></a></li>
								<li class="<?= isset($data['img_type']) && $data['img_type'] == 2 ? 'active' : ''; ?>"><a data-toggle="tab" href="#link_tab" class="tab_li" data-value="link"><?= !empty(lang('img_url')) ? lang('img_url') : "Image URL"; ?></a></li>
							</ul>
							<div class="tab-content pt-10">
								<div id="image_tab" class="tab-pane <?= !empty($data) ? "" : "fade in active"; ?> <?= isset($data['img_type']) && $data['img_type'] == 1 ? 'fade in active' : ''; ?>">
									<div class="imgTab">
										<label class="defaultImg defultUpload">
											<?php if (!isset($get['action'])) : ?>
												<?php if (isset($data['id']) && !empty($data['id'])) : ?>
													<a href="<?= base_url('admin/restaurant/delete_img/' . $data['id'] . '/items'); ?>" class="deleteImg <?= isset($data['thumb']) && !empty($data['thumb']) ? "" : "opacity_0" ?>" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>"><i class="fa fa-close"></i></a>
												<?php endif; ?>
											<?php endif; ?>

											<img src="<?= isset($data['thumb']) && !empty($data['thumb']) ? base_url($data['thumb']) : "" ?>" alt="" class="imgPreview <?= isset($data['thumb']) && !empty($data['thumb']) ? "" : "opacity_0" ?>">

											<div class="imgPreviewDiv  <?= isset($data['thumb']) && !empty($data['thumb']) ? "opacity_0" : "" ?>">
												<i class="fa fa-upload"></i>
												<h4><?= lang('upload_image'); ?></h4>
												<p class="fw_normal mt-3"><?= lang('max'); ?>: 1000 x 900 px</p>
											</div>

											<input type="file" name="file[]" class="imgFile opacity_0" data-width="1000" data-height="900">
										</label>
										<!-- open with cropper -->
										<label class="defaultImg cropModalOpen <?= isset($data['thumb']) && !empty($data['thumb']) ? "opacity_0" : "" ?>">
											<?php if (!isset($get['action'])) : ?>
												<?php if (isset($data['id']) && !empty($data['id'])) : ?>
													<a href="<?= base_url('admin/restaurant/delete_img/' . $data['id'] . '/items'); ?>" class="deleteImg <?= isset($data['thumb']) && !empty($data['thumb']) ? "" : "opacity_0" ?>" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>"><i class="fa fa-close"></i></a>
												<?php endif; ?>
											<?php endif; ?>

											<img src="<?= isset($data['thumb']) && !empty($data['thumb']) ? base_url($data['thumb']) : "" ?>" alt="" class="imgPreview imgPreviewCrop <?= isset($data['thumb']) && !empty($data['thumb']) ? "" : "opacity_0" ?>">

											<div class="imgPreviewDiv imgPreviewDivCrop <?= isset($data['thumb']) && !empty($data['thumb']) ? "opacity_0" : "" ?>">
												<i class="fa fa-crop"></i>
												<h4><?= lang('upload_image'); ?></h4>
												<p class="fw_normal mt-3"><?= lang('upload_by_cropper'); ?></p>
											</div>


										</label>
										<!-- open with cropper -->

									</div>
									<span class="img_error"></span>
								</div>
								<div id="link_tab" class="tab-pane fade <?= isset($data['img_type']) && $data['img_type'] == 2 ? 'fade in active' : ''; ?>">
									<?php if (!empty($data['img_url'])) : ?>
										<img src="<?= $data['img_url']; ?>" alt="" class="urlimgPreview">
									<?php endif; ?>
									<div class="form-group">
										<label><?= !empty(lang('img_url')) ? lang('img_url') : "Image URL"; ?></label>
										<input type="text" name="img_url" class="form-control" value="<?= !empty($data['img_url']) ? $data['img_url'] : ""; ?>">
									</div>
								</div>
								<input type="hidden" name="img_type" class="img_type" value="<?= isset($data['img_type']) ? $data['img_type'] : 1; ?>">
							</div><!-- Tab content -->


						</div>
					</div>

				</div><!-- /.box-body -->
				<div class="card-footer">


					<?php if (isset($lang) && !empty($lang)) : ?>
						<input type="hidden" name="language" value="<?= $lang; ?>">
					<?php else : ?>
						<input type="hidden" name="language" value="english">
					<?php endif; ?>


					<?php if (isset($get['action']) && $get['action'] == "copy") : ?>
						<input type="hidden" name="is_copy" value="1">
						<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] != 0 ? html_escape($data['id']) : 0 ?>">
						<input type="hidden" name="images" value="<?= isset($data['images']) && !empty($data['images']) ? $data['images'] : "" ?>">
						<input type="hidden" name="thumb" value="<?= isset($data['thumb']) && !empty($data['thumb']) ? $data['thumb'] : "" ?>">

					<?php else : ?>
						<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] != 0 ? html_escape($data['id']) : 0 ?>">
					<?php endif; ?>
					<div class="pull-left">
						<a href="<?= base_url('admin/menu/item'); ?>" class="btn btn-secondary btn-block btn-flat"><?= !empty(lang('cancel')) ? lang('cancel') : "cancel"; ?></a>
					</div>



					<?php if (isset($data['id']) && $data['id'] != 0) : ?>
						<div class="pull-right">

							<button type="submit" name="register" class="btn btn-primary c_btn btn-flat"><?= !empty(lang('submit')) ? lang('submit') : "submit"; ?></button>
						</div>
					<?php else : ?>
						<?php if (isset($active) && $active == 1) : ?>
							<div class="pull-right">
								<button type="submit" name="register" class="btn btn-primary c_btn btn-flat"><?= !empty(lang('submit')) ? lang('submit') : "submit"; ?></button>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<!-- modal -->
				<div id="imageCropperModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="modalLabel"><?= lang('upload_image'); ?></h4>
							</div>
							<div class="modal-body">

								<div class="cropingArea">
									<div class="showCroppingArea">

									</div>
									<input type="file" name="cropper[]" id="inputImage">
								</div>

								<div class="form-group ratioArea mt-40 dis_none">
									<div class="">
										<label for=""><?= lang('orientation'); ?></label>
									</div>
									<label class="custom-radio"> <input type="radio" name="ration" value="1" checked> <span class="landscape"></span></label>
									<label class="custom-radio"> <input type="radio" name="ration" value="2"> <span class="square"></span></label>
									<label class="custom-radio"> <input type="radio" name="ration" value="3"> <span class="rectangle"></span></label>
								</div>

							</div>
							<div class="modal-footer">

								<input type="hidden" name="cropData" id="cropData" value="">
								<a href="javascript:;" id="cropBtn" class="btn btn-secondary "><?= lang('crop'); ?></a>
							</div>
						</div>
					</div>
				</div>
				<!-- modal -->
			</form>
		</div>
	</div>

	<?php if (isset($data['id']) && $data['id'] != 0) : ?>
		<?php if (!isset($get['action'])) : ?>
			<div class="col-md-5">
				<div class="box box-success">
					<div class="box-header with-border dflex">
						<h3 class="box-title w_100"><?= !empty(lang('images')) ? lang('images') : "images"; ?></h3>
						<a href="#addimgModal" data-toggle="modal" class="addnewBtn btn btn-success btn-flat"><i class="fa fa-plus"></i> &nbsp;<?= lang('add_more_image'); ?></a>

					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="extraImages">
							<?php if (!empty($data['extra_images'])) : ?>
								<?php $i = 1;
								foreach (json_decode($data['extra_images'], true) as $key => $img) : ?>
									<div class="singleEximg" id="hide_<?= $key;; ?>">
										<img src="<?= base_url($img['thumb']); ?>" alt="">
										<a href="<?= base_url('admin/menu/delete_extra_img/' . $data['id'] . '?img=' . $key); ?>" data-id="<?= $key; ?>" class="delete-img action_btn" data-msg="<?= lang('want_to_delete'); ?>"><i class="fa fa-trash"></i></a>
									</div>
								<?php $i++;
								endforeach ?>
							<?php endif; ?>
						</div>


					</div><!-- /.box-body -->
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>


</div>





<?php $dataPrice = !empty($data['price']) && isJson($data['price']) ? json_decode($data['price']) : ''; ?>
<!-- Modal -->
<div id="variantModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form action="<?= base_url('admin/menu/create_product_variants') ?>" method="post" enctype="multipart/form-data" class="productVariants">
			<!-- csrf token -->
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?= lang('add_variants'); ?></h4>
				</div>
				<div class="modal-body">
					<div class="variantModalBoday">
						<div class="form-group">
							<label><?= lang('variant_name'); ?></label>
							<input type="text" name="variant_name" class="form-control" placeholder="<?= __('variant_name_details') ?>" value="<?= isset($dataPrice->variant_name) && !empty($dataPrice->variant_name) ? $dataPrice->variant_name : ''; ?>">
						</div>
						<div class="form-group">
							<label> <?= lang('variant_options'); ?></label>
							<input type="text" name="variant_options" class="form-control" placeholder="<?= __('variant_description') ?>" value="">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-secondary"><?= lang('submit'); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>


<div id="addimgModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form action="<?= base_url('admin/menu/add_images/' . $data['id']) ?>" method="post" enctype="multipart/form-data">
			<!-- csrf token -->
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?= lang('add_new_images'); ?></h4>
				</div>
				<div class="modal-body">
					<div class="extrasBody">
						<div class="form-group">
							<input type="file" accept="image/*" class="info_file image_upload" name="file[]" multiple />
						</div>
					</div>
					<div class="img_progress">
						<div class="show_progress" style="display: none;">
							<div class="progress">
								<div class="progress-bar progress-bar-success progress-bar-striped myprogress" role="progressbar" style="width:0%">0%</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-default"><?= lang('save'); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>



<style>
	#crop-image {
		display: block;

		/* This rule is very important, please don't ignore this */
		max-width: 100%;
	}
</style>


<script>
	$(document).ready(function() {

		$(document).on('click', '.cropModalOpen', function() {
			$('#imageCropperModal').modal('show');
		});


		$('#inputImage').on('change', function(e) {

			var input = e.target;
			var reader = new FileReader();



			reader.onload = function() {

				// Display the image in the modal
				$('.showCroppingArea').html('<img src="' + reader.result + '" id="cropImg" alt="Croppable Image" />');
				crop('cropImg');
				$('.ratioArea').slideDown();

			};
			// console.log(input.files[0]);
			// Read the selected file as a data URL
			reader.readAsDataURL(input.files[0]);



		});

		function crop(ids) {
			var cropperElement = $('#' + ids);
			// Initialize Cropper.js on the displayed image


			if (cropperElement.length > 0) {
				var cropper = new Cropper(cropperElement[0], {
					aspectRatio: 16 / 9, // Set the aspect ratio (width/height)
				});

				var newRation = 16 / 9;
				$('[name="ration"]').on('click', function() {
					var value = $(this).val();
					if (value == 1) {
						newRation = 16 / 9;
					} else if (value == 2) {
						newRation = 1;
					} else {
						newRation = 4 / 3;
					}

					cropper.setAspectRatio(newRation);
				});

				// Handle crop button click
				$('#cropBtn').on('click', function() {
					// Get the cropped canvas
					var croppedCanvas = cropper.getCroppedCanvas();

					// Convert the canvas to a data URL
					var croppedDataUrl = croppedCanvas.toDataURL('image/jpeg');

					$('.imgPreviewCrop').attr('src', croppedDataUrl);
					$('#cropData').val(croppedDataUrl);
					$('.imgPreviewDivCrop').slideUp();
					$('.imgPreviewCrop').slideDown().removeClass('opacity_0');
					$('.defultUpload').slideUp();
					// Close the modal
					$('#imageCropperModal').modal('hide');
				});
			}
		}
	});
</script>