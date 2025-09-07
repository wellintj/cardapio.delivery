<div class="onlinePaymentList dis_none mt-10">
    <ul>
        <?php foreach (payment_methods() as $key => $pay) : ?>
            <?php if ($shop[$pay['active_slug']] == 1 && $shop[$pay['status_slug']] == 1) : ?>
                <li>
                    <label class="custom-radio-2"><input type="radio" name="method" value="<?= $pay['slug'];?>"> <span class="payout_img" style="background:url(<?= base_url(IMG_PATH . 'payout/' . $pay['slug'] . '.png'); ?>)"></span> <?= lang($pay['slug']); ?></label>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

</div>