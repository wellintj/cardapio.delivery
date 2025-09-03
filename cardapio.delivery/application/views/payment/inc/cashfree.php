<?php $cashfree = isJson($shop['cashfree_config']) ? json_decode($shop['cashfree_config']) : ''; ?>
<?php if (!empty($cashfree->cashfree_app_id)): ?>
    <div class="payment_content text-center <?= $pay['slug']; ?>">
        <div class="payment_icon payment">
           <img src="<?php echo base_url('assets/frontend/images/payout/cashfree.png'); ?>" alt="" style="background:#240253;">
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
            <button type="button" id="renderBtn" name="submit" class="btn btn-success buy_now"><?= !empty(lang('pay_now')) ? lang('pay_now') : "Pay Now" ?> &nbsp;(<?= isset($total_amount) ? currency_position($total_amount, $shop['id']) : ''; ?> )</button>
        <?php endif; ?>
    </div><!-- payment_content -->


    <?php $cashfree_init = $this->user_payment_m->cashfree_init($slug); ?>

    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>

   <script type="text/javascript">
            const cashfree = Cashfree({
                mode: `<?= isset($cashfree->is_cashfree_live) && $cashfree->is_cashfree_live == 1 ? "production" : "sandbox"; ?>`,
            });
            document.getElementById("renderBtn").addEventListener("click", () => {
                cashfree.checkout({
                    paymentSessionId: "<?php echo $cashfree_init['payment_session_id']; ?>"
                });
            });
        </script>

<?php else: ?>
    <div class="payment_content text-center">
        <h4><?= !empty(lang('credentials_not_found')) ? lang('credentials_not_found') : "Credentials not found"; ?></h4>
    </div>
<?php endif; ?>