<?php if (check() == 1): ?>
    <?php $cashfree = isJson($setting['cashfree_config']) ? json_decode($setting['cashfree_config']) : ''; ?>
    <?php if (!empty($cashfree->cashfree_app_id)): ?>
        <div class="payment_content text-center <?= is_package; ?>">
            <div class="payment_icon payment">
                <img src="<?php echo base_url('assets/frontend/images/payout/cashfree.png'); ?>" alt="" style="background:#240253;">
            </div>
            <div class="payment_details">
                <h4> <?= isset($u_info['username']) ? html_escape($u_info['username']) : ''; ?></h4>
                <div class="">
                    <h2><?= get_currency('icon'); ?> <?= isset($total_price) ? html_escape($total_price) : ''; ?> / <?= !empty(lang($package['package_type'])) ? lang($package['package_type']) : $package['package_type'] ?></h2>
                    <p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']); ?></p>
                </div>
            </div>
            <?php if (is_demo() == 0): ?>

                <button type="button" id="renderBtn" class="btn btn-success buy_now"><?= !empty(lang('pay_now')) ? lang('pay_now') : "Pay Now" ?> &nbsp;( <?= admin_currency_position(isset($total_price) ? $total_price : ''); ?> )</button>
            <?php endif; ?>
        </div><!-- payment_content -->

        <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>


        <script type="text/javascript">
            const cashfree = Cashfree({
                mode: `<?= isset($cashfree->is_cashfree_live) && $cashfree->is_cashfree_live == 1 ? "production" : "sandbox"; ?>`,
            });
            document.getElementById("renderBtn").addEventListener("click", () => {
                cashfree.checkout({
                    paymentSessionId: "<?php echo $payment_session_id; ?>"
                });
            });
        </script>
    <?php else: ?>
        <div class="payment_content text-center">
            <h4><?= !empty(lang('credentials_not_found')) ? lang('credentials_not_found') : "Credentials not found"; ?></h4>
        </div>
    <?php endif; ?>

<?php endif; ?>