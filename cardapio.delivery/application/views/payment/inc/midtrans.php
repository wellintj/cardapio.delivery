<?php $midtrans = isJson($shop['midtrans_config']) ? json_decode($shop['midtrans_config']) : ''; ?>
<?php if (!empty($midtrans->server_key)): ?>
    <div class="payment_content text-center <?= $pay['slug']; ?>">
        <div class="payment_icon payment">
           <img src="<?php echo base_url('assets/frontend/images/payout/midtrans.svg'); ?>" alt="" style="background:#002855;">
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
            <button type="button" id="pay-button" name="submit" class="btn btn-success buy_now"><?= !empty(lang('pay_now')) ? lang('pay_now') : "Pay Now" ?> &nbsp;(<?= isset($total_amount) ? currency_position(round($total_amount), $shop['id']) : ''; ?> )</button>
        <?php endif; ?>
    </div><!-- payment_content -->


    <?php $midtrans_init = $this->user_payment_m->midtrans_init($slug); ?>
    <?php if ($midtrans->is_midtrans_live == 1): ?>
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="<?= $midtrans->client_key; ?>"></script>
    <?php else: ?>
        <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<?= $midtrans->client_key; ?>"></script>
    <?php endif ?>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            snap.pay('<?= $midtrans_init ?>', {
                onSuccess: function(result) {
                    window.location.href = '<?= site_url('user_payment/midtrans') ?>' +
                        '?order_id=' + result.order_id +
                        '&status_code=' + result.status_code +
                        '&slug=' + `<?= $slug; ?>`;
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