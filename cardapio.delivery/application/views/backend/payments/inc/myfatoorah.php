<?php if (check() == 1): ?>
    <?php $myfatoorah = isJson($setting['myfatoorah_config']) ? json_decode($setting['myfatoorah_config']) : ''; ?>
    <?php if (!empty($myfatoorah->myfatoorah_api_key)): ?>
        <div class="payment_content text-center <?= is_package; ?>">
            <div class="payment_icon payment">
                <img src="<?php echo base_url('assets/frontend/images/payout/myfatoorah.png'); ?>" alt="">
            </div>
            <div class="payment_details">
                <h4> <?= isset($u_info['username']) ? html_escape($u_info['username']) : ''; ?></h4>
                <div class="">
                    <h2><?= get_currency('icon'); ?> <?= isset($total_price) ? html_escape($total_price) : ''; ?> / <?= !empty(lang($package['package_type'])) ? lang($package['package_type']) : $package['package_type'] ?></h2>
                    <p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']); ?></p>
                </div>
            </div>
            <?php if (is_demo() == 0): ?>
                <?php $myinit = $this->payment_m->myfatoorah_init($slug, $account_slug); ?>
                <button type="button" id="payBtn" data-link="<?= isset($myinit['payment_link']) && !empty($myinit['payment_link']) ? $myinit['payment_link'] : ''; ?>" class="btn btn-success buy_now"><?= !empty(lang('pay_now')) ? lang('pay_now') : "Pay Now" ?> &nbsp;( <?= admin_currency_position(isset($total_price) ? $total_price : ''); ?> )</button>
            <?php endif; ?>
        </div><!-- payment_content -->


        <script type="text/javascript">
           document.getElementById("payBtn").addEventListener("click", function() {
                const link = this.getAttribute("data-link"); 
                window.location.replace(link); 
            });
        </script>
    <?php else: ?>
        <div class="payment_content text-center">
            <h4><?= !empty(lang('credentials_not_found')) ? lang('credentials_not_found') : "Credentials not found"; ?></h4>
        </div>
    <?php endif; ?>

<?php endif; ?>