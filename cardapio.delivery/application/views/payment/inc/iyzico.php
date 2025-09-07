<?php $iyzico = isJson($shop['iyzico_config']) ? json_decode($shop['iyzico_config']) : ''; ?>
<?php if (!empty($iyzico->iyzico_api_key)): ?>
    <div class="payment_content text-center <?= $pay['slug']; ?>">
        <div class="payment_icon payment">
            <img src="<?php echo base_url('assets/frontend/images/payout/iyzico.png'); ?>" alt="">
        </div>
        <div class="payment_details">
            <div class="userInfo">
                <h4> <?= isset($payment['name']) ? html_escape($payment['name']) : ''; ?></h4>
                <p><?= lang('phone'); ?>: <?= isset($payment['phone']) ? html_escape($payment['phone']) : ''; ?></p>
            </div>
            <div class="">

                <h2> <?= isset($total_amount) ? currency_position($total_amount, $shop['id']) : ''; ?> </h2>

            </div>
        </div>
        <?php if (is_demo() == 0): ?>
            <button type="button" data-toggle="modal" data-target="#iyzicoModal" name="submit" class="btn btn-success"><?= !empty(lang('pay_now')) ? lang('pay_now') : "Pay Now" ?> &nbsp;(<?= isset($total_amount) ? currency_position($total_amount, $shop['id']) : ''; ?> )</button>
        <?php endif; ?>
    </div><!-- payment_content -->



    <div class="modal fade" id="iyzicoModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><?= __('iyzico'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <style>
                        .responsive img {
                            width: 24px !important;
                            height: auto !important;
                        }
                    </style>
                    <div id="iyzipay-checkout-form" class="responsive">
                        <?php csrf(); ?>
                        <?php echo $myinit = $this->user_payment_m->iyzico_init($slug); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php else: ?>
    <div class="payment_content text-center">
        <h4><?= !empty(lang('credentials_not_found')) ? lang('credentials_not_found') : "Credentials not found"; ?></h4>
    </div>
<?php endif; ?>