
<a href="javascript:;" class="quick_view" data-id="<?= html_escape($row['item_id']); ?>" data-offer="<?= isset($offer_discount) ? $offer_discount : 0; ?>"  data-type="item">
	<div class="homeSingle_item <?= is_image($row['shop_id']); ?>">
		<?php if (is_image($row['shop_id']) == 0) : ?>
			<div class="item_images ">
				<div class="homeSingleImg menu-img img bg_loader" data-src="<?= get_img($row['thumb'], $row['img_url'], $row['img_type']); ?>" style="background: url(<?= img_loader(); ?>);"></div>
			</div>
		<?php endif; ?>

		<div class="item__details">
			<div class="itemDetailsLeft">
				<div class="topTitle itemDetailsInfo">
					<h4><?= html_escape($row['title']); ?> <?php if (isset($row['veg_type']) && $row['veg_type'] != 0) : ?> <i class="fa fa-circle veg_type <?= $row['veg_type'] == 1 ? 'c_green' : 'c_red'; ?>" data-placement="top" data-toggle="tooltip" title="<?= lang(veg_type($row['veg_type'])); ?>"></i><?php endif; ?></h4>

					<div class="homeItem_right">
						<?= __price($row, $row['shop_id'], '', isset($offer_discount) ? $offer_discount : 0); ?>
					</div>
					<div class="price_section">
						<p class="details">
							<?= html_escape($row['overview']); ?>
						</p>
					</div>
				</div>
			</div>
			<div class="addIcon color-soft">
				<i>&#43;</i>
			</div>
		</div>
	</div>
</a>