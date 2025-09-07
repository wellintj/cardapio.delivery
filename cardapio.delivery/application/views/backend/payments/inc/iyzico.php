<?php if (check() == 1): ?>
    <?php $iyzico = isJson($setting['iyzico_config']) ? json_decode($setting['iyzico_config']) : ''; ?>
    <?php if (!empty($iyzico->iyzico_api_key)): ?>
        <div class="payment_content text-center <?= is_package; ?>">
            <div class="payment_icon payment">
                <img src="<?php echo base_url('assets/frontend/images/payout/iyzico.png'); ?>" alt="">
            </div>
            <div class="payment_details">
                <h4> <?= isset($u_info['username']) ? html_escape($u_info['username']) : ''; ?></h4>
                <div class="">
                    <h2><?= get_currency('icon'); ?> <?= isset($total_price) ? html_escape($total_price) : ''; ?> / <?= !empty(lang($package['package_type'])) ? lang($package['package_type']) : $package['package_type'] ?></h2>
                    <p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']); ?></p>
                </div>
            </div>
            <?php if (is_demo() == 0): ?>
                <a href="javascript:;" data-target="#izyicoModal" data-toggle="modal" class="btn btn-success"><?= !empty(lang('pay_now')) ? lang('pay_now') : "Pay Now" ?> &nbsp;( <?= admin_currency_position(isset($total_price) ? $total_price : ''); ?> )</a>
            <?php endif; ?>
        </div><!-- payment_content -->

        <div id="izyicoModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
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
                            <?= $this->payment_m->iyzico_init($slug, $account_slug); ?>
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

<?php endif; ?>