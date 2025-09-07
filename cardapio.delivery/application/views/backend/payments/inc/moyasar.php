
<!-- Moyasar Styles -->
<link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.10.0/moyasar.css" />

<!-- Moyasar Scripts -->
<script src="https://polyfill.io/v3/polyfill.min.js?features=fetch"></script>
<script src="https://cdn.moyasar.com/mpf/1.10.0/moyasar.js"></script>


<div class="payment_content text-center">
    <div class="payment_icon payment">
        <img src="<?php echo base_url('assets/frontend/images/payout/moyasar.png'); ?>" alt="">
    </div>
    <?php $moyasar = isJson($setting['moyasar_config']) ? json_decode($setting['moyasar_config']) : ''; ?>
    <div class="payment_details">
        <h4> <?= isset($u_info['username']) ? html_escape($u_info['username']) : ''; ?></h4>
        <div class="">
            <h2><?= get_currency('icon'); ?> <?= isset($total_price) ? html_escape($total_price) : ''; ?> / <?= !empty(lang($package['package_type'])) ? lang($package['package_type']) : $package['package_type'] ?></h2>
            <p><b><?= !empty(lang('package_name')) ? lang('package_name') : "Package Name" ?> : </b> <?= html_escape($package['package_name']); ?></p>
        </div>
        <p class="payment_text">* <?= !empty(lang('payment_by')) ? lang('payment_by') : "Payment via" ?> <i class="fa fa-credit-card-alt"></i></p>
    </div>

    <form>
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

        <input type="hidden" name="email" id="email" value="<?= $u_info['email']; ?>" />
        <input type="hidden" id="amount" name="amount" value="<?= isset($total_price) ? html_escape($total_price) : ''; ?>" />
        <input type="hidden" id="username" name="username" value="<?= $u_info['username']; ?>" />
        <input type="hidden" id="currency" name="currency" value="<?= get_currency('currency_code'); ?>" />
        <input type="hidden" name="package_name" id="package_name" value="<?= $account_type; ?>">



        <div class="form-submit">
            <a href="#moyasarModal" data-toggle="modal" class="btn btn-success"> <?= !empty(lang('pay_now')) ? lang('pay_now') : "Pay Now" ?> &nbsp;( <?= isset($total_price) ? html_escape($total_price) : ''; ?> ) </a>
        </div>

    </form>

</div><!-- payment_content -->


<div class="modal fade" id="moyasarModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Moyasar</h4>
            </div>
            <div class="modal-body">
                <div class="mysr-form"></div>
            </div>
        </div>
    </div>
</div>

<?php
$grandPrice = $total_price * 100;
if(!empty(site_lang()) && site_lang()=='ar'){
    $lang = 'ar';
}else{
    $lang = 'en';
}
?>

<script>
    Moyasar.init({
        element: '.mysr-form',
        amount: `<?= $grandPrice; ?>`,
        currency: `<?= get_currency('currency_code'); ?>`,
        description: `<?= $u_info['username']; ?>`,
        publishable_api_key: `<?= isset($moyasar->moyasar_public_key) && !empty($moyasar->moyasar_public_key) ? $moyasar->moyasar_public_key : ''; ?>`,
        callback_url: `<?= base_url("payment/moyasar_callback/{$slug}/{$account_slug}"); ?>`,
        methods: ['creditcard'],
        language: `<?= $lang;?>`,
        // methods: ['creditcard', 'stcpay'],

        on_completed: function(payment) {
            return new Promise(function(resolve, reject) {
                var transactionURL = payment.source.transaction_url;
                if (typeof transactionURL !== 'undefined' && transactionURL !== null && transactionURL !== '') {
                    window.location.href = transactionURL;
                    resolve({
                        status: 'success',
                        message: 'Payment processed successfully'
                    });
                } else {
                    console.log(payment);
                    reject({
                        status: 'error',
                        message: 'Error processing payment'
                    });
                }
            });
        },
    })
</script>