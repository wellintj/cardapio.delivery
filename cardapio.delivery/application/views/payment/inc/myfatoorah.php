<?php $myfatoorah = isJson($shop['myfatoorah_config']) ? json_decode($shop['myfatoorah_config']) : ''; ?>
<?php if (!empty($myfatoorah->myfatoorah_api_key)): ?>
    <div class="payment_content text-center <?= $pay['slug']; ?>">
        <div class="payment_icon payment">
            <img src="<?php echo base_url('assets/frontend/images/payout/myfatoorah.png'); ?>" alt="">
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

        <?php $myfatoorah_init = $this->user_payment_m->myfatoorah_init($slug); ?>
            <button type="button" id="payBtn" data-link="<?= isset($myfatoorah_init['payment_link']) && !empty($myfatoorah_init['payment_link']) ? $myfatoorah_init['payment_link'] : ''; ?>"  class="btn btn-success buy_now"><?= !empty(lang('pay_now')) ? lang('pay_now') : "Pay Now" ?> &nbsp;(<?= isset($total_amount) ? currency_position($total_amount, $shop['id']) : ''; ?> )</button>
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