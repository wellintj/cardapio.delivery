<?php if (check() == 1): ?>
    <?php $midtrans = isJson($setting['midtrans_config']) ? json_decode($setting['midtrans_config']) : ''; ?>
    <?php if (!empty($midtrans->server_key)): ?>
        <div class="payment_content text-center <?= is_package; ?>">
            <div class="payment_icon payment">
                <img src="<?php echo base_url('assets/frontend/images/payout/midtrans.svg'); ?>" alt="" style="background:#002855;">
            </div>
            <div class="payment_details">
                <h4> <?= isset($u_info['username']) ? html_escape($u_info['username']) : ''; ?></h4>
                <div class="">
                    <h2><?= get_currency('icon'); ?> <?= isset($total_price) ? html_escape($total_price) : ''; ?> / <?= !empty(lang($package['package_type'])) ? lang($package['package_type']) : $package['package_type'] ?></h2>
                    <p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']); ?></p>
                </div>
            </div>
            <?php if (is_demo() == 0): ?>

                <button type="button" id="pay-button" name="submit" class="btn btn-success buy_now"><?= !empty(lang('pay_now')) ? lang('pay_now') : "Pay Now" ?> &nbsp;( <?= admin_currency_position(isset($total_price) ? round($total_price) : ''); ?> )</button>
            <?php endif; ?>
        </div><!-- payment_content -->
        <?php if($midtrans->is_midtrans_live == 1): ?>
           <script src="https://app.midtrans.com/snap/snap.js" data-client-key="<?= $midtrans->client_key; ?>"></script>
       <?php else: ?>
         
        <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?= $midtrans->client_key; ?>"></script>
    <?php endif ?>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            snap.pay('<?= $token ?>', {
                onSuccess: function(result) {
                    window.location.href = '<?= site_url('payment/midtrans') ?>' +
                    '?order_id=' + result.order_id +
                    '&status_code=' + result.status_code +
                    '&slug=' + `<?= $slug; ?>` +
                    '&account_slug=' + `<?= $account_slug; ?>`;
                },
                onPending: function(result) {
                    alert("Payment pending. Please complete your payment.");
                },
                onError: function(result) {
                    alert("Payment failed!");
                }
            });
        });
    </script>
<?php else: ?>
    <div class="payment_content text-center">
        <h4><?= !empty(lang('credentials_not_found')) ? lang('credentials_not_found') : "Credentials not found"; ?></h4>
    </div>
<?php endif; ?>

<?php endif; ?>