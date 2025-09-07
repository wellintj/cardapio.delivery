<?php if(isset(restaurant()->is_multi_lang)): ?>
<div class="row">
	<?php $multilang = isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang==1?1:0; ?>
	<?php if($multilang==0): ?>
		<div class="col-md-8">
			<div class="card">
				<div class="card-body flex_between">
					<h4><?= lang('enable_multi_lang_category_items');?></h4> <a href="<?= base_url("admin/auth/enable_category");?>" class="btn btn-secondary action_btn"><?= lang('enable');?></a>
				</div>
			</div>
		</div>
		<?php $add_new_url = base_url("admin/menu/create_item"); ?>
		<?php $lang = isset($_GET['lang'])?$_GET['lang']:"english"; ?>
	<?php else: ?>
		<?php 
		$controller = $this->uri->rsegment(1); // The Controller
		$function = $this->uri->rsegment(2);
		$params = $this->uri->rsegment(3);
		$lang = isset($_GET['lang'])?$_GET['lang']:site_lang();
		?>
		<?php if(isset($is_create) && $is_create==0): ?>
			<?php //include 'language_dropdown.php'; ?>
		<?php endif; ?>
		
		<?php $add_new_url = base_url("admin/menu/create_item/?lang={$lang}"); ?>
	<?php endif; ?>
</div>
<?php else: ?>
	<?php $lang = isset($_GET['lang'])?$_GET['lang']:site_lang(); ?>
<?php endif; ?>

<div class="row ">
	<?php include 'inc/limit_counter.php'; ?>
	
<div class="col-md-12">
	<div class="card">
		<div class="card-header space-between with-border">
			<h3 class="box-title"><?= !empty(lang('items'))?lang('items'):"items";?> &nbsp; &nbsp; 
				
			</h3>
			<div class="box-tools pull-right">
				<?php if(isset($active) && $active==1): ?>
					<?php if(is_access('add')==1): ?>
						<a href="<?= $add_new_url??'' ;?>" class="btn btn-secondary btn-flat"><i class="fa fa-plus"></i> &nbsp;<?= !empty(lang('add_new_item'))?lang('add_new_item'):"Add New Item";?> </a>
					<?php endif;?>
				<?php endif;?>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="card-body bg_gray">
			<div class="table-responsives">
				<div class="row">
					<?php foreach ($menu_type as $key => $cat): ?>
						<div class="col-md-3 <?= multi_lang(auth('id'),$cat);?>">
							<a href="<?= base_url("admin/menu/item_list/".multi_lang(auth('id'),$cat)."?lang={$lang}"); ?>">
								<div class="single_cat">
									<img src="<?= get_img($cat['thumb'],'',1) ;?>" alt="">
									<div class="catDetails">
										<h4><?= $cat['name'] ;?></h4>
										
										<div class="mt-10">
											<label class="label default-light-soft-active fz-14">
												<?php if(isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang==1): ?>
													<?= $this->admin_m->get_total_item_by_cat_id_ln(multi_lang(auth('id'),$cat),$lang) ;?>
												<?php else: ?>
													<?= $this->admin_m->get_total_item_by_cat_id($cat['id']) ;?>
												<?php endif; ?>

												 <i class="icofont-cherry"></i></label>
										</div>
									</div>
								</div>
							</a>
						</div>
					<?php endforeach ?>
				</div>

			</div>
		</div><!-- /.box-body -->
	</div>
</div>
</div>