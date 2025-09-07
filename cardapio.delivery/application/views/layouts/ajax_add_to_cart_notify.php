<?php if ($this->cart->total_items() > 0) : ?>
    <?php if (check_shop_open_status(@$shop_id) == 1) : ?>
        <?php if (empty(auth('is_pos')) && __cart()->is_pos == 0) : ?>
            <?php if (__cart()->shop_id == @$shop_id) : ?>
                <div class="cartNofify allow-lg">
                    <div class="leftNotify">
                        <p><strong><?= html_escape($name ?? ''); ?></strong> &nbsp; <?= lang('has_been_add_to_cart'); ?>. </p> <a href="javascript:;" class="navCart" data-slug="<?= $slug ?? ''; ?>"> </a>
                    </div>
                    <div class="rightNotify">
                        <a href="javascript:;" class="closeNotify"><i class="icofont-close-line"></i></a>
                    </div>
                </div>

                <div class="cartNofify notifyBadge allow-sm navCart" data-slug="<?= $slug ?? ''; ?>">
                    <div class="cartQty"> <?= $this->cart->total_items(); ?></div>
                    <div class="cartButton"> <?= lang('checkout'); ?> </div>
                    <div class="cartPrice"> <?= currency_position($this->cart->total(), $shop_id); ?> </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>