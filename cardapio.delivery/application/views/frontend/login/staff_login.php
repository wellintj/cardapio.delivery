<?php $settings = settings(); ?>
<?php $dial_code = isset(admin()->dial_code) && !empty(admin()->dial_code) ? admin()->dial_code : ''; ?>
<section class="signupSection">
    <div class="login_wrapper loginWrap" style="background-image: url('<?= base_url('assets/frontend/images/login_banner2.jpg') ?>')">
        <div class="container">
            <div class="row h-full justify-content-center align-items-center ">
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6 position-relative">
                    <div class="_form_login">
                        <div class="topSigin">
                            <div class="login_content mt-0 pt-0">
                                <div class="user_login_header">
                                    <?php if (isset($type) && $type == "customer") : ?>
                                        <img src="<?= base_url(IMG_PATH . 'customer.svg'); ?>" alt="" />
                                        <h4 class="heading">Acessar</h4>
                                    <?php elseif (isset($type) && $type == "delivery") : ?>
                                        <img src="<?= base_url(IMG_PATH . 'delivery.svg'); ?>" alt="" />
                                        <h4 class="heading">Acesso Entregador</h4>
                                    <?php else : ?>
                                        <h4 class="heading"><?= !empty(lang('sign_in')) ? lang('sign_in') : "Acessar"; ?></h4>
                                    <?php endif; ?>

                                    <p><?= !empty(lang('sign_in_text')) ? lang('sign_in_text') : ""; ?></p>
                                </div>

                                <div class="form_content">
                                    <span class="reg_msg"></span>
                                    <form action="<?= base_url('staff/user_login/' . $type) ?>" class="" method="post" id="user_login_form" autocomplete="off">
                                        <?= csrf(); ?>
                                        <div class="login_form">
                                            <?php if ($type == 'staff') : ?>
                                                <div class="form-group">
                                                    <label>
                                                        <?= !empty(lang('email')) ? lang('email') : "email"; ?>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon fa_icon"><i class="icofont-email"></i></span>
                                                        <input type="text" name="phone" class="form-control usermail" placeholder="<?= !empty(lang('email')) ? lang('email') : "email"; ?>">
                                                    </div>
                                                </div>

                                            <?php elseif ($type == 'customer') : ?>
                                                <div class="form-group">
                                                    <label>
                                                        <i class="fa fa-phone"></i>
                                                        <?= lang('phone'); ?>
                                                        <span class="error">*</span>
                                                    </label>
                                                    <div class="customPhone">
                                                        <div class="ci-input-group">
                                                            <div class="ci-input-group-prepend w-30 text-center">
                                                                <span class="input-group-text" style="padding: 0.6rem 0;">+55</span>
                                                            </div>
                                                            <!-- Hidden dial_code field - automatically set to 55 (Brazil) -->
                                                            <input type="hidden" name="dial_code" value="55" />
                                                            <input type="text" name="phone" class="form-control" autocomplete="off" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" placeholder="00 0 0000 0000" />
                                                        </div>
                                                    </div>
                                                    <small>*<?= __("use_email_insist_of_phone") ?></small>
                                                </div>

                                            <?php elseif ($type == 'delivery') : ?>

                                                <div class="form-group">
                                                    <label>
                                                        <i class="fa fa-phone"></i>
                                                        <?= lang('phone'); ?>
                                                        <span class="error">*</span>
                                                    </label>
                                                    <div class="customPhone">
                                                        <div class="ci-input-group">
                                                            <div class="ci-input-group-prepend w-30 text-center">
                                                                <span class="input-group-text" style="padding: 0.6rem 0;">+55</span>
                                                            </div>
                                                            <!-- Hidden dial_code field - automatically set to 55 (Brazil) -->
                                                            <input type="hidden" name="dial_code" value="55" />
                                                            <input type="text" name="phone" class="form-control" autocomplete="off" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" placeholder="00 0 0000 0000" />
                                                        </div>
                                                    </div>
                                                    <small>*<?= __("use_email_insist_of_phone") ?></small>
                                                </div>

                                            <?php else : ?>
                                                <div class="form-group">
                                                    <label>
                                                        <i class="icofont-ui-touch-phone"></i>
                                                        <?= !empty(lang('phone')) ? lang('phone') : "phone"; ?>
                                                    </label>
                                                    <div class="customPhone">
                                                        <div class="ci-input-group">
                                                            <div class="ci-input-group-prepend w-30 text-center">
                                                                <span class="input-group-text" style="padding: 0.6rem 0;">+55</span>
                                                            </div>
                                                            <!-- Hidden dial_code field - automatically set to 55 (Brazil) -->
                                                            <input type="hidden" name="dial_code" value="55" />
                                                            <input type="text" name="phone" class="form-control" autocomplete="off" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" placeholder="00 0 0000 0000" />
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>

                                            <div class="form-group">
                                                <label>
                                                    <?= !empty(lang('password')) ? lang('password') : "password"; ?>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon fa_icon"><i class="fa fa-key"></i></span>
                                                    <input type="password" name="password" class="form-control pass" placeholder="<?= !empty(lang('password')) ? lang('password') : 'password'; ?>">
                                                </div>
                                                <?php if ($type == 'customer') : ?>
                                                    <div class="mt-1">
                                                        <a href="<?= base_url('customer/forgot/' . $type); ?>" class="forgot-link">
                                                            <?= !empty(lang('forgot_password_question')) ? lang('forgot_password_question') : 'Esqueceu a senha?'; ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group">
                                                <?php if (isset($settings['is_recaptcha']) && $settings['is_recaptcha'] == 1) : ?>
                                                    <?php if (isset($this->settings['recaptcha']->site_key) && !empty($this->settings['recaptcha']->site_key)) : ?>
                                                        <div class="g-recaptcha" data-sitekey="<?= $this->settings['recaptcha']->site_key; ?>"></div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-info _signIn_btn">
                                                    <i class="fa fa-sign-in"></i> &nbsp;
                                                    <?= !empty(lang('sign_in')) ? lang('sign_in') : "Sign In"; ?>
                                                </button>
                                            </div>

                                            <div class="form-group hidden">
                                                <p>
                                                    <?= !empty(lang('dont_have_account')) ? lang('dont_have_account') : "Don't have account"; ?>?
                                                    <a href="<?= base_url('sign-up'); ?>"><?= !empty(lang('sign-up')) ? lang('sign-up') : "Sign Up"; ?></a>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php if (is_demo() == 1) : ?>
                                    <div class="btns" style="display: flex; align-items: center; justify-content: center; margin-top: 35px; flex-wrap: wrap; margin-bottom: 5px;">
                                        <a href="javascript:;" data-user="alex@gmail.com" data-pas="1234" class="btn btn-info mr-1 loginBTN">Staff Login</a>
                                        <a href="javascript:;" data-user="01745419092" data-pas="1234" class="btn btn-info mr-1 loginBTN"> <i class="icofont-users-alt-4"></i> Customer</a>
                                        <a href="javascript:;" data-user="01745419091" data-pas="1234" class="btn btn-info mr-1 loginBTN"><i class="icofont-fast-delivery"></i> Delivery Guy</a>
                                    </div>
                                    <div class="user" style="display: flex; align-items: center; justify-content: center; margin-top: 35px; flex-wrap: wrap;">
                                        <div class="mr-10" style="margin-right: 30px;">
                                            <h4>Customer Access</h4>
                                            <code>
                                                phone: 01745419092 <br />
                                                password: 1234
                                            </code>
                                        </div>

                                        <div class="">
                                            <h4>Delivery Access</h4>
                                            <code>
                                                username: 01745419091 <br />
                                                password: 1234
                                            </code>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- othersLogin -->
                        <div class="othersLogin">
                            <ul>
                                <li>
                                    <a href="<?= base_url('staff-login/staff'); ?>">
                                        <i class="icofont-users-alt-4"></i>
                                        <?= lang('staff_login'); ?>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= base_url('staff-login/customer'); ?>">
                                        <i class="icofont-users-alt-4"></i>
                                        <?= !empty(lang('customer_login')) ? lang('customer_login') : "Customer Login"; ?>
                                    </a>
                                </li>
                                <?php if (check() == 1) : ?>
                                    <li>
                                        <a href="<?= base_url('staff-login/delivery'); ?>">
                                            <i class="icofont-fast-delivery"></i>
                                            <?= !empty(lang('delivery_guy_login')) ? lang('delivery_guy_login') : "Delivery Guy Login"; ?>
                                        </a>
                                    </li>
                                <?php endif ?>
                            </ul>
                        </div>
                        <!-- othersLogin -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>