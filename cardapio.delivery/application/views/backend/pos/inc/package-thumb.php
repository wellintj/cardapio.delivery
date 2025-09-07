<?php foreach ($all_items as $key => $item) : ?>
    <div class="col-md-4 col-xs-6 col-lg-3 p-sm-5 p-0">
        <div class="singleProduct showModal" data-id="<?= $item['id']; ?>" data-type="packages">
            <div class="topImg">
                <?php if ($item['img_type'] == 1) : ?>
                    <img src="<?= base_url(!empty($item['thumb']) ? $item['thumb'] : EMPTY_IMG); ?>" alt="">
                <?php else : ?>
                    <img src="<?= !empty($item['img_url']) ? $item['img_url'] : base_url(EMPTY_IMG); ?>" alt="">
                <?php endif; ?>
            </div>
            <div class="itemDetails">
                <h4><?= character_limiter($item['package_name'], 10); ?></h4>
                <?php if (!empty($item['tax_fee'])) : ?>
                    <small> <?= __posTax(restaurant()->is_tax, $item['tax_fee'], $item['tax_status']) ?></small>
                <?php endif; ?>
                <?php if ($item['is_special'] == 0) : ?>
                    <label class="label btn-success-light-active"> <?= __('package') ?></label>
                <?php else : ?>
                    <label class="label bgActive"><?= lang('specialities'); ?></label>
                <?php endif; ?>
            </div>
        </div>

    </div>
<?php endforeach ?>