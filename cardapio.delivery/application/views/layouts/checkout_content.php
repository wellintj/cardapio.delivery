<?php if (count($this->cart->contents()) > 0 && $shop_id == __cart()->shop_id) : ?>
    <?php $s_info =  shop($shop_id); ?>
    <?php $isCustomer = (auth('is_customer') == TRUE  || auth('is_otp_login', 'customer_info')); ?>
    <div class="row flex-row-reverse justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-4 singlePage style_2">
            <div class="row">

                <div class="col-md-12 total_sum_area">
                    <div class="total_sum showCheckoutTotal">
                        <?php include 'inc/checkout_total_area.php'; ?>
                    </div>
                </div>

            </div>
        </div><!--  -->
        <div class="col-md-12 col-sm-12 col-lg-6">
            <div class="step_1">
                <div class="singlePage style_2">
                    <ul>
                        <?php include APPPATH . 'views/layouts/ajax_cart_item.php'; ?>
                    </ul>
                </div>
            </div>

            <div class="cartItemDetails">
                <?php if (isset($s_info->is_customer_login) && in_array($s_info->is_customer_login, [1, 2, 3])) : ?>

                    <div class="order_page">
                        <div class="loginSection">
                            <div class="ModalCustomerInfo <?= $isCustomer ? '' : "dis_none"; ?>">
                                <div class="flex flex-column w_100">
                                    <h4 class="bb_1_dashed w_100 pb-7"><?= lang('customer_info'); ?> <a href="javascript:;" class="customerRemove ml-20 text-danger"><i class="icofont-close-line "></i></a>
                                    </h4>
                                    <?php if (auth('is_customer') == TRUE): ?>
                                        <div class="customerInfoModal">
                                            <h4 class="pb-7 pt-5 fz-14 pt-10"><i class="icofont-users-alt-4"></i>
                                                &nbsp;<?= auth('customer_name'); ?></h4>

                                            <?php if (auth('is_email_login') == 1) : ?>
                                                <p class="fz-14"><i class="icofont-ui-call"></i> <?= auth('customer_phone'); ?></p>
                                                <p class="fz-14 mt-10"><i class="far fa-envelope"></i> <?= auth('customer_email'); ?></p>
                                            <?php else : ?>
                                                <p class="fz-14"><i class="icofont-ui-call"></i> <?= auth('customer_phone'); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (auth('is_otp_login', 'customer_info') == 1): ?>
                                        <?php $customer_info = s_id(auth('customer_id', 'customer_info'), 'customer_list'); ?>
                                        <div class="customerInfoModal">
                                            <h4 class="pb-7 pt-5 fz-14 pt-10"><i class="icofont-users-alt-4"></i>
                                                &nbsp;<?= !empty($customer_info->customer_name) ? $customer_info->customer_name : ''; ?></h4>

                                            <?php if (!empty($customer_info->phone)): ?>
                                                <p class="fz-14"><i class="icofont-ui-call"></i> <?= isset($customer_info->dial_code) && !empty($customer_info->dial_code) ? "+" . ltrim($customer_info->dial_code, '+') : "" ?> <?= $customer_info->phone; ?></p>
                                            <?php endif; ?>
                                            <?php if (!empty($customer_info->email)): ?>
                                                <p class="fz-14 mt-10"><i class="far fa-envelope"></i> <?= $customer_info->email; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if (empty(auth('is_otp_login', 'customer_info'))): ?>
                                    <div class="customerEdit">
                                        <a href="#customereditModal" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="showUserlogin <?= $isCustomer ? 'dis_none' : ""; ?>">
                                <div class="singlePageLogin">
                                    <?php include APPPATH . "views/layouts/inc/userLogin.php"; ?>
                                </div>
                            </div>
                        </div><!-- LoginSection -->
                        <div id="loadCustomer"></div>
                    </div><!-- order_page -->
                <?php endif; ?>



                <form action="<?= base_url('profile/add_order/2'); ?>" method="post" class="order_form" autocomplete="off">
                    <!-- csrf token -->
                    <?= csrf(); ?>
                    <?php if (isset($s_info->is_customer_login) && in_array($s_info->is_customer_login, [1, 2, 3])) : ?>
                        <div class="order_page orderInfoArea <?= $isCustomer ? "" : "dis_none" ?>">
                            <div class="order_input_area">
                                <?php include APPPATH . "views/layouts/inc/order_info_form.php"; ?>
                            </div><!--  -->
                        </div><!-- order_page -->
                    <?php else : ?>
                        <div class="order_page orderInfoArea">
                            <div class="order_input_area">
                                <?php include APPPATH . "views/layouts/inc/order_info_form.php"; ?>
                            </div><!--  -->
                        </div><!-- order_page -->
                    <?php endif; ?>
                    <?php if (isset($s_info->is_customer_login) && in_array($s_info->is_customer_login, [1, 2, 3])) : ?>
                        <input type="hidden" name="is_guest_login" class="is_guest_login" value="0">
                    <?php endif ?>
                </form>


            </div><!-- cartItemDetails -->
        </div><!-- col-6 -->




    </div>
    <script type="text/javascript" src="<?= asset_url(); ?>assets/frontend/plugins/datetime_picker/datetime.js"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
    </script>



    <!-- Modal -->
    <div class="modal fade customerpopup" id="customereditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="customerData">
                <?php include APPPATH . 'views/layouts/inc/customer_info_modal.php'; ?>
            </div>
        </div>
    </div>
    <?php if (isset($s_info->is_customer_login) && in_array($s_info->is_customer_login, [1, 2, 3])) : ?>
        <script>
            $(document).on('change', '[name="is_guest_login"]', function() {
                if ($(this).is(':checked')) {
                    $('.tabArea, .or, .otpLoginArea').slideUp();
                    $('.orderInfoArea, .cod_phone').slideDown();
                    $('.is_guest_login').val(1);
                } else {
                    $('.tabArea, .or, .otpLoginArea').slideDown();
                    $('.orderInfoArea, .cod_phone').slideUp();
                    $('.is_guest_login').val(0);
                }
            });
        </script>
    <?php else : ?>
        <script>
            $(document).on('change', '[name="is_guest_login"]', function() {
                if ($(this).is(':checked')) {
                    $('.customerInfo, .or,  .otpLoginArea').slideUp();
                    $('.cod_phone').slideDown()
                } else {
                    $('.customerInfo, .or,  .otpLoginArea').slideDown();
                    $('.cod_phone').slideUp()
                }
            });
        </script>

    <?php endif; ?>

<?php else : ?>
    <script>
        location.reload();
    </script>
<?php endif; ?>