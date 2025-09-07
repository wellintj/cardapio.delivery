<div class="row resoponsiveRow">
    <?php include APPPATH . 'views/backend/users/inc/leftsidebar.php'; ?>
    <?php $smtp = json_decode(!empty($settings['smtp_config']) ? $settings['smtp_config'] : '', TRUE); ?>
    <?php if ((isset($settings['sendgrid_api_key']) && !empty($settings['sendgrid_api_key'])) || isset($smtp['smtp_password']) && (!empty($smtp['smtp_password']))) : ?>
        <div class="col-md-8">
            <form action="<?= base_url("admin/auth/order_mail_config"); ?>" method="post" class="validForm">
                <?= csrf(); ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0 mr-4"> <?= lang('order_mail'); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <?php $mail = !empty($settings['order_mail_config']) ? json_decode(@$settings['order_mail_config']) : ''; ?>

                            <div class="custom-control custom-switch prefrence-item m-0">
                                <div class="gap">
                                    <input type="checkbox" id="is_order_mail" name="is_order_mail" class="switch-input " <?= isset($mail->is_order_mail) && $mail->is_order_mail == 1 ? "checked" : ""; ?>>

                                    <label for="is_order_mail" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= lang('order_mail'); ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow_in_your_system')) ? lang('enable_to_allow_in_your_system') : "Enable to allow in your system"; ?>.</small>
                                        </p>
                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>
                        <div class="form-group">
                            <label><?= lang('subject'); ?> <span class="error">*</span></label>
                            <input type="text" name="subject" class="form-control" value="<?= !empty($mail->subject) ? $mail->subject : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label><?= lang('order_receive_mail'); ?> <span class="error">*</span></label>
                            <input type="text" name="order_receiver_mail" class="form-control" value="<?= !empty($mail->order_receiver_mail) ? $mail->order_receiver_mail : $settings['smtp_mail']; ?>" required>
                        </div>
                        <div class="form-group">
                            <div class="form-group">

                                <label><?= lang('orders_mail'); ?> <span class="error">*</span></label>
                                <div class="mb-5">
                                    <code>{CUSTOMER_NAME}, {ORDER_ID}, {ITEM_LIST}, {SHOP_NAME}, {SHOP_ADDRESS}</code>
                                </div>
                                <textarea name="message" class="form-control data_textarea" cols="5" rows="15" required><?= !empty($mail->message) ? json_decode($mail->message) : ''; ?></textarea>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class="form-group">

                                <label class="custom-checkbox"><input type="checkbox" name="is_welcome_msg" id="is_welcome_msg" value="1" <?= isset($mail->is_welcome_msg) && $mail->is_welcome_msg == 1 ? "checked" : ""; ?>> <?= lang('welcome_message'); ?> <span class="error">*</span></label>
                                <div class="mb-5">
                                    <code>{CUSTOMER_NAME}, {ORDER_ID}, {ITEM_LIST}, {SHOP_NAME}, {SHOP_ADDRESS}</code>
                                </div>
                                <textarea name="welcome_mail" class="form-control data_textarea" cols="5" rows="15" required><?= !empty($mail->welcome_mail) ? json_decode($mail->welcome_mail) : ''; ?></textarea>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group">

                                <div class="mb-5">
                                    <code>{OTP}, {EMAIL}, {SHOP_NAME}</code>
                                </div>
                                <textarea name="otp_mail" class="form-control data_textarea" cols="5" rows="15" required><?= !empty($mail->otp_mail) ? json_decode($mail->otp_mail) : ''; ?></textarea>

                            </div>
                        </div>

                        <div class="form-group">
                            <label><?= lang('enable_mail'); ?></label>
                            <div class="mt-5 flex-gap gap-30">
                                <label class="custom-checkbox"><input type="checkbox" name="is_owner_mail" id="is_owner_mail" value="1" <?= isset($mail->is_owner_mail) && $mail->is_owner_mail == 1 ? "checked" : "";; ?>>
                                    <?= lang('restaurant_owner'); ?></label>

                                <label class="custom-checkbox"><input type="checkbox" name="is_dboy_mail" id="is_dboy_mail" value="1" <?= isset($mail->is_dboy_mail) && $mail->is_dboy_mail == 1 ? "checked" : "";; ?>>
                                    <?= lang('delivery_staff'); ?></label>

                                <label class="custom-checkbox"><input type="checkbox" name="is_customer_mail" id="is_customer_mail" value="1" <?= isset($mail->is_customer_mail) && $mail->is_customer_mail == 1 ? "checked" : "";; ?>>
                                    <?= lang('customer_mail'); ?></label>
                            </div>
                        </div>
                        <hr>


                        <div class="reservationMailSection fill-background">
                            <div class="form-group">
                                <u>
                                    <h4><?= lang('reservation'); ?></h4>
                                </u>
                            </div>
                            <div class="form-group">
                                <label><?= lang('subject'); ?> <span class="error">*</span></label>
                                <input type="text" name="rev_subject" class="form-control" value="<?= !empty($mail->rev_subject) ? $mail->rev_subject : ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <div class="form-group">

                                    <label><?= lang('reservation_mail'); ?> <span class="error">*</span></label>
                                    <div class="mb-5">
                                        <code>{CUSTOMER_NAME}, {ORDER_ID}, {RESERVATION_DETAILS}, {SHOP_NAME}, {SHOP_ADDRESS}</code>
                                    </div>
                                    <textarea name="reservation_message" class="form-control data_textarea" cols="5" rows="15" required><?= !empty($mail->reservation_message) ? json_decode($mail->reservation_message) : ''; ?></textarea>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="form-group">

                                    <label><?= lang('welcome_message'); ?> <span class="error">*</span></label>
                                    <div class="mb-5">
                                        <code>{CUSTOMER_NAME}, {ORDER_ID}, {RESERVATION_DETAILS}, {SHOP_NAME}, {SHOP_ADDRESS}</code>
                                    </div>
                                    <textarea name="welcome_reservation_message" class="form-control data_textarea" cols="5" rows="15" required><?= !empty($mail->welcome_reservation_message) ? json_decode($mail->welcome_reservation_message) : ''; ?></textarea>

                                </div>
                            </div>

                            <div class="form-group">
                                <label><?= lang('enable_reservation_mail'); ?></label>
                                <div class="mt-5 flex-gap gap-30">
                                    <label class="custom-checkbox"><input type="checkbox" name="is_rev_owner_mail" id="is_rev_owner_mail" value="1" <?= isset($mail->is_rev_owner_mail) && $mail->is_rev_owner_mail == 1 ? "checked" : "";; ?>>
                                        <?= lang('restaurant_owner'); ?></label>

                                    <label class="custom-checkbox"><input type="checkbox" name="is_rev_customer_mail" id="is_rev_customer_mail" value="1" <?= isset($mail->is_rev_customer_mail) && $mail->is_rev_customer_mail == 1 ? "checked" : "";; ?>>
                                        <?= lang('customer_mail'); ?></label>
                                </div>
                            </div>


                        </div><!-- reservationMailSection -->


                    </div><!-- card-body -->
                    <div class="card-footer text-right">
                        <input type="hidden" name="id" value="<?= !empty($settings['id']) ? $settings['id'] : 0; ?>">
                        <button class="btn btn-secondary" type="submit"><?= lang('save_change'); ?></button>
                    </div>
                </div><!-- card -->
            </form>
        </div>
    <?php else : ?>
        <div class="empty">
            <?= lang('please_configure_the_mail_first'); ?>
        </div>
    <?php endif; ?>

</div>