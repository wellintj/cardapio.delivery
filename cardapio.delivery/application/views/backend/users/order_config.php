<div class="row resoponsiveRow">
    <?php include APPPATH . 'views/backend/users/inc/leftsidebar.php'; ?>
    <div class="col-md-8">
        <form class="email_setting_form" action="<?= base_url('admin/restaurant/add_configuration'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <?= csrf(); ?>
            <?php $guest = isJson(restaurant()->guest_config) ? json_decode(restaurant()->guest_config) : ''; ?>
            <div class="card">
                <div class="card-header">
                    <h4><?= lang('configuration'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control  orderConfig custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_order_qr" name="is_order_qr" class="switch-input " <?= isset(restaurant()->is_order_qr) && restaurant()->is_order_qr == 1 ? "checked" : ""; ?>>

                                    <label for="is_order_qr" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('order_qr')) ? lang('order_qr') : 'Order QR code'; ?>
                                        </label>

                                        <p class="text-muted">
                                            <small><?= lang('enable_to_allow'); ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">
                                        <?= is_new('3.2.6'); ?>
                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control  orderConfig custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_login" name="is_login" class="switch-input " <?= isset(restaurant()->is_login) && restaurant()->is_login == 1 ? "checked" : ""; ?>>

                                    <label for="is_login" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('login_btn')) ? lang('login_btn') : 'Login Button'; ?>
                                        </label>

                                        <p class="text-muted">
                                            <small><?= !empty(lang('login_btn_in_menu')) ? lang('login_btn_in_menu') : "Login button in menu bar"; ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">
                                        <?= is_new('3.1.6'); ?>
                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control  orderConfig custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_image" name="is_image" class="switch-input " <?= isset(restaurant()->is_image) && restaurant()->is_image == 1 ? "checked" : ""; ?>>

                                    <label for="is_image" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('hide_product_image')) ? lang('hide_product_image') : 'hide product image'; ?>
                                        </label>

                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow')) ? lang('enable_to_allow') : "Enable to allow "; ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">
                                        <?= is_new('3.1.4'); ?>
                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="custom-control custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_review" name="is_review" class="switch-input " <?= isset(restaurant()->is_review) && restaurant()->is_review == 1 ? "checked" : ""; ?>>

                                    <label for="is_review" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('reviews')) ? lang('reviews') : 'reviews'; ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow_in_your_system')) ? lang('enable_to_allow_in_your_system') : "Enable to allow in your system"; ?>.</small>
                                        </p>
                                    </div>
                                </div>
                            </div><!-- custom-control -->

                        </div>

                        <div class="col-md-6">
                            <div class="custom-control custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_language" name="is_language" class="switch-input " <?= isset(restaurant()->is_language) && restaurant()->is_language == 1 ? "checked" : ""; ?>>

                                    <label for="is_language" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('language_switcher')) ? lang('language_switcher') : 'language switcher'; ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow')) ? lang('enable_to_allow') : "Enable to allow "; ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">

                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>
                    </div><!-- row -->
                    <div class="row">

                        <div class="col-md-6">
                            <div class="custom-control custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_call_waiter" name="is_call_waiter" class="switch-input " <?= isset(restaurant()->is_call_waiter) && restaurant()->is_call_waiter == 1 ? "checked" : ""; ?>>

                                    <label for="is_call_waiter" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('call_waiter')) ? lang('call_waiter') : 'Call a waiter'; ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow_call_waiter')) ? lang('enable_to_allow_call_waiter') : "Enable to allow call waiter service"; ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">

                                    </div>
                                </div>
                            </div><!-- custom-control -->

                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_pin" name="is_pin" class="switch-input " <?= isset(restaurant()->is_pin) && restaurant()->is_pin == 1 ? "checked" : ""; ?>>

                                    <label for="is_pin" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= lang('security_pin'); ?></label>
                                        <p class="text-muted">
                                            <small><?= lang('enable_pin_when_customer_track_order'); ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">

                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>
                    </div><!-- row -->

                    <div class="row">

                        <div class="col-md-6">
                            <div class="custom-control  orderConfig custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_cart" name="is_cart" class="switch-input " <?= isset(restaurant()->is_cart) && restaurant()->is_cart == 1 ? "checked" : ""; ?>>

                                    <label for="is_cart" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('add_to_cart')) ? lang('add_to_cart') : 'Add to cart'; ?>
                                            <i class="fa fa-shopping-cart"></i></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow')) ? lang('enable_to_allow') : "Enable to allow "; ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">
                                        <?= is_new('3.1.1'); ?>
                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control  orderConfig custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_question" name="is_question" class="switch-input " <?= isset(restaurant()->is_question) && restaurant()->is_question == 1 ? "checked" : ""; ?>>

                                    <label for="is_question" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('enable_security_question')) ? lang('enable_security_question') : 'Enable Coupon'; ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow')) ? lang('enable_to_allow') : "Enable to allow "; ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">
                                        <?= is_new('3.0'); ?>
                                    </div>
                                </div>
                            </div><!-- custom-control -->

                        </div>
                    </div><!-- row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="stock_status" name="stock_status" class="switch-input " <?= isset(restaurant()->stock_status) && restaurant()->stock_status == 1 ? "checked" : ""; ?>>

                                    <label for="stock_status" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('stock_status')) ? lang('stock_status') : 'Stock Status'; ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow_in_your_system')) ? lang('enable_to_allow_in_your_system') : "Enable to allow in your system"; ?>.</small>
                                        </p>
                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_stock_count" name="is_stock_count" class="switch-input " <?= isset(restaurant()->is_stock_count) && restaurant()->is_stock_count == 1 ? "checked" : ""; ?>>

                                    <label for="is_stock_count" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('stock_counter')) ? lang('stock_counter') : 'Stock Counter'; ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow_in_your_system')) ? lang('enable_to_allow_in_your_system') : "Enable to allow in your system"; ?>.</small>
                                        </p>
                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>
                    </div> <!-- row -->


                    <div class="row">

                        <div class="col-md-6">
                            <div class="custom-control  orderConfig custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_coupon" name="is_coupon" class="switch-input " <?= isset(restaurant()->is_coupon) && restaurant()->is_coupon == 1 ? "checked" : ""; ?>>

                                    <label for="is_coupon" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('enable_coupon')) ? lang('enable_coupon') : 'Enable Coupon'; ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow')) ? lang('enable_to_allow') : "Enable to allow "; ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">

                                    </div>
                                </div>
                            </div><!-- custom-control -->

                        </div>
                        <div class="col-md-6">
                            <div class="custom-control  orderConfig custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_quick_access" name="is_quick_access" class="switch-input " <?= isset(restaurant()->is_quick_access) && restaurant()->is_quick_access == 1 ? "checked" : ""; ?>>

                                    <label for="is_quick_access" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('quick_access')) ? lang('quick_access') : 'Quick Access'; ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow')) ? lang('enable_to_allow') : "Enable to allow "; ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">
                                        <?= is_new('3.1.2'); ?>
                                    </div>
                                </div>
                            </div><!-- custom-control -->

                        </div>

                    </div><!-- row -->


                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control  orderConfig custom-switch prefrence-item ml-10">
                                <div class="gap">
                                    <input type="checkbox" id="is_tax" name="is_tax" class="switch-input " <?= isset(restaurant()->is_tax) && restaurant()->is_tax == 1 ? "checked" : ""; ?>>

                                    <label for="is_tax" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('item_tax_status')) ? lang('item_tax_status') : 'Item Tax Status'; ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow')) ? lang('enable_to_allow') : "Enable to allow "; ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">
                                        <?= is_new('3.0'); ?>
                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>


                        <div class="col-md-6 form-group">
                            <label for=""><?= lang('tax_fee'); ?></label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <select name="tax_status" class="" id="">
                                        <option value="+" <?= isset(restaurant()->tax_status) && restaurant()->tax_status == '+' ? "selected" : ""; ?>>
                                            +</option>
                                        <option value="-" <?= isset(restaurant()->tax_status) && restaurant()->tax_status == '-' ? "selected" : ""; ?>>
                                            -</option>
                                    </select>
                                </span>
                                <input type="text" name="tax_fee" class="form-control" value="<?= !empty(restaurant()->tax_fee) ? restaurant()->tax_fee : 0; ?>">
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row p-15" style="padding-bottom: 0!important;">

                        <div class="col-md-6 form-group">
                            <label for=""><?= lang('discount'); ?></label>
                            <div class="input-group">
                                <input type="text" name="discount" class="form-control" value="<?= !empty(restaurant()->discount) ? restaurant()->discount : 0; ?>">
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>



                        <div class="col-md-6 form-group">
                            <label for=""><?= lang('minimum_order'); ?></label>
                            <div class="input-group">
                                <input type="text" name="min_order" class="form-control" value="<?= !empty(restaurant()->min_order) ? restaurant()->min_order : 0; ?>">
                                <span class="input-group-addon"><?= restaurant()->icon; ?></span>
                            </div>
                        </div>


                        <div class="col-md-6 form-group">
                            <label for=""><?= lang('delivery_charge'); ?></label>
                            <input type="text" name="delivery_charge_in" class="form-control" value="<?= !empty(restaurant()->delivery_charge_in) ? restaurant()->delivery_charge_in : 0; ?>">
                        </div>


                    </div>



                    <div class="row p-15" style="padding-bottom: 0!important;">
                        <div class="col-md-12">
                            <label for=""><?= !empty(lang('default_prepared_time')) ? lang('default_prepared_time') : "Default Prepared Time"; ?></label>
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="text" name="es_time" class="form-control" value="<?= !empty(restaurant()->es_time) ? restaurant()->es_time : 0; ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <select name="time_slot" class="form-control" id="">
                                <option value="minutes" <?= restaurant()->time_slot == "minutes" ? "selected" : ""; ?>>
                                    <?= lang('minutes'); ?></option>
                                <option value="hours" <?= restaurant()->time_slot == "hours" ? "selected" : ""; ?>>
                                    <?= lang('hours'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="row p-15 pt-0">
                        <div class="col-md-6 form-group">
                            <label for=""><?= lang('security_pin'); ?></label>
                            <input type="text" name="pin_number" class="form-control" placeholder="<?= lang('security_pin'); ?>" value="<?= !empty(restaurant()->pin_number) ? restaurant()->pin_number : ''; ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-switch prefrence-item">
                                <div class="gap">
                                    <input type="checkbox" id="is_kds" name="is_kds" class="switch-input " <?= isset(restaurant()->is_kds) && restaurant()->is_kds == 1 ? "checked" : ""; ?>>

                                    <label for="is_kds" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= !empty(lang('kds')) ? lang('kds') : 'KDS'; ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow_in_your_system')) ? lang('enable_to_allow_in_your_system') : "Enable to allow in your system"; ?>.</small>
                                        </p>
                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>

                        <div class="col-md-6">
                            <div class="custom-control  orderConfig custom-switch prefrence-item">
                                <div class="gap">
                                    <input type="checkbox" id="is_kds_pin" name="is_kds_pin" class="switch-input " <?= isset(restaurant()->is_kds_pin) && restaurant()->is_kds_pin == 1 ? "checked" : ""; ?>>

                                    <label for="is_kds_pin" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                            <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                            <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                </div>
                                <div class="preText">
                                    <div class="">
                                        <label class="custom-control-label"><?= lang('kds_pin'); ?></label>
                                        <p class="text-muted">
                                            <small><?= !empty(lang('enable_to_allow')) ? lang('enable_to_allow') : "Enable to allow "; ?></small>
                                        </p>
                                    </div>
                                    <div class="float-right">
                                        <span class="custom_badge danger-light-active"><?= lang('new'); ?></span>
                                    </div>
                                </div>
                            </div><!-- custom-control -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= lang('kds_pin'); ?></label>
                                <input type="text" name="kds_pin" class="form-control" value="<?= isset(restaurant()->kds_pin) ? restaurant()->kds_pin : ''; ?>">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-20">
                        <div class="col-md-12">
                            <fieldset class="soft-bg">
                                <legend><?= !empty(lang('checkout_login')) ? lang('checkout_login') : 'Checkout login'; ?></legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="custom-control  orderConfig custom-switch prefrence-item ml-10">
                                            <div class="gap">
                                                <input type="checkbox" id="guest_login" name="guest_login" class="switch-input " <?= isset($guest->is_guest_login) && $guest->is_guest_login == 1 ? "checked" : ""; ?>>

                                                <label for="guest_login" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                                        <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                                        <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                            </div>
                                            <div class="preText">
                                                <div class="">
                                                    <label class="custom-control-label"><?= !empty(lang('guest_login')) ? lang('guest_login') : 'Guest Login'; ?></label>
                                                    <p class="text-muted">
                                                        <small><?= !empty(lang('enable_to_allow_guest_login_for_dine_in_pay_cash')) ? lang('enable_to_allow_guest_login_for_dine_in_pay_cash') : "Enable to allow "; ?></small>
                                                    </p>

                                                    <div class="allow_order_types">
                                                        <label class="custom-checkbox hidden"><input type="checkbox" name="is_dine_in" value="1" <?= isset($guest->is_dine_in) && $guest->is_dine_in == 1 ? "checked" : ""; ?> checked> <?= lang('dine-in'); ?></label>
                                                        <label class="custom-checkbox hidden"><input type="checkbox" name="is_pay_cash" value="1" <?= isset($guest->is_pay_cash) && $guest->is_pay_cash == 1 ? "checked" : ""; ?>>
                                                            <?= lang('pay_cash'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="float-right">
                                                    <?= is_new('3.1.7'); ?>
                                                </div>
                                            </div>
                                        </div><!-- custom-control -->
                                    </div>

                                    <?php $guestFields = isset($guest->guest_fields) && isJson($guest->guest_fields) ? json_decode($guest->guest_fields) : ''; ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= !empty(lang('guest_login_required_fields')) ? lang('guest_login_required_fields') : 'Guest login required fields'; ?></label>
                                            <div class="mt-10 d-flex gap-20">
                                                <label class="custom-checkbox"><input type="checkbox" name="guest_fields[name]" value="1" <?= isset($guestFields->name) && $guestFields->name == 1 ? "checked" : ""; ?>> <?= !empty(lang('name')) ? lang('name') : 'Name'; ?></label>

                                                <label class="custom-checkbox"><input type="checkbox" name="guest_fields[phone]" value="1" <?= isset($guestFields->phone) && $guestFields->phone == 1 ? "checked" : ""; ?>> <?= !empty(lang('phone')) ? lang('phone') : 'Phone'; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">


                                    <div class="col-md-12 mt-20">
                                        <label class="mb-10"><?= __('login'); ?></label>
                                        <div class="loginType">
                                            <label class="custom-radio label bg-danger-soft p-7 pl-10"><input type="radio" name="is_customer_login" value="0" <?= isset(restaurant()->is_customer_login) && restaurant()->is_customer_login == 0 ? "checked" : ""; ?>> <?= lang('off'); ?></label>

                                            <label class="custom-radio label bg-info-soft p-7 pl-10"><input type="radio" name="is_customer_login" value="1" <?= isset(restaurant()->is_customer_login) && restaurant()->is_customer_login == 1 ? "checked" : ""; ?>> <?= lang('system_based'); ?></label>

                                            <label class="custom-radio label bg-info-soft p-7 pl-10"><input type="radio" name="is_customer_login" value="2" <?= isset(restaurant()->is_customer_login) && restaurant()->is_customer_login == 2 ? "checked" : ""; ?>> <?= lang('email_otp'); ?></label>

                                            <label class="custom-radio label bg-info-soft p-7 pl-10"><input type="radio" name="is_customer_login" value="3" <?= isset(restaurant()->is_customer_login) && restaurant()->is_customer_login == 3 ? "checked" : ""; ?>> <?= lang('sms_otp'); ?></label>

                                        </div>
                                    </div>

                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset>
                                <legend><?= __('checkout'); ?></legend>
                                <div class="form-group">
                                    <label class="custom-checkbox"><input type="checkbox" name="is_checkout_mail" value="1" <?= isset(restaurant()->is_checkout_mail) && restaurant()->is_checkout_mail == 1 ? "checked" : ""; ?>><?= lang('enable_mail_in_checkout'); ?></label>

                                    <label class="custom-checkbox ml-20"><input type="checkbox" name="is_email_based" value="1" <?= isset(restaurant()->is_email_based) && restaurant()->is_email_based == 1 ? "checked" : ""; ?>><?= lang('email_based_customer_login'); ?></label>
                                </div>

                            </fieldset>

                        </div>
                    </div>
                    <hr>
                    <?php $merge_config = !empty(restaurant()->order_merge_config) ? json_decode(restaurant()->order_merge_config) : '' ?>
                    <fieldset>
                        <legend><?= __('order_merge'); ?></legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="custom-control  orderConfig custom-switch prefrence-item">
                                    <div class="gap">
                                        <input type="checkbox" id="is_order_merge" name="is_order_merge" class="switch-input " <?= isset($merge_config->is_order_merge) && $merge_config->is_order_merge == 1 ? "checked" : ""; ?>>

                                        <label for="is_order_merge" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i>
                                                <?= !empty(lang('on')) ? lang('on') : "On"; ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i>
                                                <?= !empty(lang('off')) ? lang('off') : "Off"; ?></span></label>

                                    </div>
                                    <div class="preText">
                                        <div class="">
                                            <label class="custom-control-label"><?= lang('order_merge'); ?></label>
                                            <p class="text-muted"><small><?= lang('enable_order_merge'); ?></small></p>
                                        </div>
                                        <div class="float-right">
                                            <span class="custom_badge danger-light-active"><?= lang('new'); ?></span>
                                        </div>
                                    </div>
                                </div><!-- custom-control -->
                            </div>
                            <div class="col-md-12 mt-20">

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="custom-radio"><input type="radio" name="is_system" value="1" <?= isset($merge_config->is_system) && $merge_config->is_system == 1 ? "checked" : ""; ?> checked><?= lang('merge_automatically'); ?></label>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="custom-radio"><input type="radio" name="is_system" value="2" <?= isset($merge_config->is_system) && $merge_config->is_system == 2 ? "checked" : ""; ?>><?= lang('allow_customers_to_select'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <?php $others = __others(restaurant()->id); ?>
                    <div class="row mt-20">
                        <div class="col-md-12">
                            <fieldset>
                                <legend><?= __('others'); ?></legend>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="custom-checkbox"><input type="checkbox" name="is_allergen_image" value="1" <?= isset($others->is_allergen_image) && $others->is_allergen_image == 1 ? "checked" : ""; ?>><?= lang('show_allergen_image'); ?></label>

                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="custom-checkbox"><input type="checkbox" name="is_kds_pending_orders" value="1" <?= isset($others->is_kds_pending_orders) && $others->is_kds_pending_orders == 1 ? "checked" : ""; ?>><?= lang('show_pending_order_in_kds'); ?></label>

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div><!-- card-body -->
                <div class="card-footer">
                    <input type="hidden" name="id" value="<?= isset(restaurant()->id) ? restaurant()->id : 0; ?>">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i>
                        &nbsp;<?= !empty(lang('save_change')) ? lang('save_change') : "Save Change"; ?></button>
                </div>
            </div><!-- card -->




        </form>
    </div><!-- col-9 -->

</div>