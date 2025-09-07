<?php $moyasar = isJson($shop['moyasar_config']) ? json_decode($shop['moyasar_config']) : ''; ?>
<?php if (!empty($moyasar->moyasar_public_key)) : ?>
    <!-- Moyasar Styles -->
    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.10.0/moyasar.css" />

    <!-- Moyasar Scripts -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=fetch"></script>
    <script src="https://cdn.moyasar.com/mpf/1.10.0/moyasar.js"></script>

    <div class="payment_content text-center <?= $pay['slug']; ?>">
        <div class="payment_icon payment">
            <img src="<?php echo base_url('assets/frontend/images/payout/moyasar.png'); ?>" alt="">
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
        <form id="paymentForm">
            <?= csrf();; ?>
            <input type="hidden" name="email" id="email" value="<?= $user['email']; ?>" />
            <input type="hidden" id="amount" name="amount" value="<?= round($total_amount); ?>" />
            <input type="hidden" id="username" name="username" value="<?= $user['username']; ?>" />
            <input type="hidden" id="currency" name="currency" value="<?= $shop['currency_code']; ?>" />
            <input type='hidden' name='slug' value='<?= $user['username']; ?>' class='form-control' />


            <?php if (is_demo() == 0) : ?>
                <a href="#moyasarModal" data-toggle="modal" class="btn btn-success"> <?= !empty(lang('pay_now')) ? lang('pay_now') : "Pay Now" ?> &nbsp;( <?= isset($total_amount) ? currency_position($total_amount, $shop['id']) : ''; ?> ) </a>

            <?php endif; ?>
        </form>

    </div><!-- payment_content -->


    <div class="modal" id="moyasarModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Moyasar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mysr-form"></div>
                </div>
            </div>
        </div>
    </div>


    <?php
    $grandPrice = $total_amount * 100;
    $slug = $user['username'];
    $currency = $shop['currency_code'];
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
            currency: `<?= $currency; ?>`,
            description: `<?= $slug; ?>`,
            publishable_api_key: `<?= isset($moyasar->moyasar_public_key) && !empty($moyasar->moyasar_public_key) ? $moyasar->moyasar_public_key : ''; ?>`,
            callback_url: `<?= base_url('user_payment/moyasar/' . $slug); ?>`,
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


<?php else : ?>
    <div class="payment_content text-center">
        <h4><?= !empty(lang('credentials_not_found')) ? lang('credentials_not_found') : "Credentials not found"; ?></h4>
    </div>
<?php endif; ?>