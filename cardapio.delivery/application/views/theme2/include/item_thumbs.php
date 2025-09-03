 <div class="homeSingle_item <?= is_image($row['shop_id']); ?> style__2 quick_view" class="quick_view" data-id="<?= html_escape($row['item_id']); ?>" data-offer="<?= isset($offer_discount) ? $offer_discount : 0; ?>" data-type="item">
 	<?php if (is_image($row['shop_id']) == 0) : ?>
 		<div class="homeSingleImg menu-img img bg_loader" data-src="<?= get_img($row['thumb'], $row['img_url'], $row['img_type']); ?>" style="background: url(<?= img_loader(); ?>);">
 			<?php if (isset($row['veg_type']) && $row['veg_type'] != 0) : ?> <i class="fa fa-circle veg_type <?= $row['veg_type'] == 1 ? 'c_green' : 'c_red'; ?> style2" data-placement="top" data-toggle="tooltip" title="<?= lang(veg_type($row['veg_type'])); ?>"></i><?php endif; ?>
 		</div>
 	<?php endif; ?>

 	<div class="homeItemDetails list_view is_size_0">
 		<div class="homeItem_left">
 			<div class="topTitle">
 				<?php if ($row['is_size'] == 0) : ?>
 					<p class="mb-4 is_size_0">
 						<?= currency_position($row['price'], $shop_id); ?>
 					</p>
 				<?php endif; ?>
 				<h4><?= html_escape($row['title']); ?></h4>
 			</div>
 			<div class="price_section">
 				<p class="details">
 					<?= character_limiter(html_escape($row['overview']), 120); ?>
 				</p>

 			</div>
 			<div class="port_d_flex home_view space-between">
 				<div class="homeItem_right is_size_0">
 					<?= __price($row, $shop_id, '', isset($offer_discount) ? $offer_discount : 0); ?>
 				</div>
 				<?php if (shop($row['shop_id'])->is_cart == 1) : ?>
 					<a href="javascript:;" class="quick_view" data-id="<?= html_escape($row['item_id']); ?>" data-offer="<?= isset($offer_discount) ? $offer_discount : 0; ?>" data-type="item" data-placement="top" data-toggle="" title="<?= lang('add_to_cart'); ?>"> <i class="fa-solid fa-bag-shopping"></i> <?= lang('add'); ?></a>
 				<?php endif; ?>
 			</div>
 		</div>


 	</div>


 </div>