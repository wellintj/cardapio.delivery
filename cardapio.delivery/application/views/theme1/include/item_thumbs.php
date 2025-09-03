	<div class="homeSingle_item <?= is_image($row['shop_id']); ?>">
		<?php if (is_image($row['shop_id']) == 0) : ?>
			<div class="item_images quick_view" data-id="<?= html_escape($row['item_id']); ?>" data-offer="<?= isset($offer_discount) ? $offer_discount : 0; ?>" data-type="item">
				<div class="homeSingleImg menu-img img bg_loader" data-src="<?= get_img($row['thumb'], $row['img_url'], $row['img_type']); ?>" style="background: url(<?= img_loader(); ?>);"></div>
			</div>
		<?php endif; ?>

		<div class="homeItemDetails list_view">
			<div class="homeItem_left">
				<div class="topTitle">
					<div class="top___title">
						<h4><?= html_escape($row['title']); ?> </h4>
						<?php if (isset($row['veg_type']) && $row['veg_type'] != 0) : ?> <i class="fa fa-circle veg_type <?= $row['veg_type'] == 1 ? 'c_green' : 'c_red'; ?>" data-placement="top" data-toggle="tooltip" title="<?= lang(veg_type($row['veg_type'])); ?>"></i><?php endif; ?>
					</div>
				</div>
				<div class="price_section ">
					<p class="details <?= $row['is_size'] == 0 ? "not_is_size" : "is_size"; ?>">
						<?= character_limiter(html_escape($row['overview']), 120); ?>
					</p>
				</div>
				<div class="port_d_flex home_view space-between">
					<?= __price($row, $row['shop_id'], '', isset($offer_discount) ? $offer_discount : 0); ?>
					<?php if (shop($row['shop_id'])->is_cart == 1) : ?>
						<a href="javascript:;" class="quick_view" data-id="<?= html_escape($row['item_id']); ?>" data-offer="<?= isset($offer_discount) ? $offer_discount : 0; ?>" data-type="item" data-placement="top" data-toggle="" title="<?= lang('add_to_cart'); ?>"><i class="fa-solid fa-bag-shopping"></i> <span><?= lang('add'); ?></span></a>
					<?php endif; ?> <!-- is cart -->

				</div>
			</div>
		</div>


	</div>