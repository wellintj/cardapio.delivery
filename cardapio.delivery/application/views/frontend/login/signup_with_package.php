<?php $ref_id = isset($_GET['ref']) && !empty($_GET['ref']) ? '?ref=' . $_GET['ref'] : ''; ?>
<section class="signupSection">
    <div class="login_wrapper">
        <div class="container">
            <div class="row flex_common xs-reverse">
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                    <div class="right_form_login signup">
                        <div class="login_content">
                            <div class="user_login_header" data-aos="fade-down" data-aos-delay="100">
                                <h4 class="heading"><?= !empty(lang('sign-up')) ? lang('sign-up') : "sign up"; ?></h4>
                                <p><?= !empty(lang('sign_up_text')) ? lang('sign_up_text') : ""; ?></p>

                            </div>
                            <div class="form_content signup with_package">

                                <div class="left_package_details_signup with_package pricing_3 w_100">
                                    <div class="card mb-5 mb-lg-0 signupCard col-md-4">
                                        <div class="card-body">
                                            <h5 class="card-title text-muted text-uppercase text-center">
                                                <?= html_escape($package['package_name']); ?></h5>
                                            <?php if ($package['package_type'] == 'free') : ?>
                                                <h6 class="card-price text-center">
                                                    <?= !empty(lang('free')) ? lang('free') : 'Free'; ?></h6>
                                            <?php elseif ($package['package_type'] == 'trial') : ?>
                                                <h6 class="card-price text-center">
                                                    <?= !empty(lang('free')) ? lang('free') : 'Free'; ?><span class="period">/<?= !empty(lang('month')) ? lang('month') : 'month'; ?></span>
                                                </h6>

                                            <?php else : ?>
                                                <h6 class="card-price text-center">
                                                    <?= admin_currency_position(html_escape($package['price'])); ?><span class="period"> /
                                                        <?= !empty($package['package_type']) ? get_package_type($package['package_type'], $package['duration'], $package['duration_period']) : get_package_type($package['package_type'], $package['duration'], $package['duration_period']); ?></span>
                                                </h6>
                                            <?php endif; ?>
                                            <hr>
                                            <ul class="fa-ul">
                                                <?php foreach ($all_features as $key2 => $feature) : ?>
                                                    <?php $feature_id = get_price_feature_id($feature['id'], $package['id']); ?>
                                                    <?php if (isset($feature_id['feature_id']) && $feature_id['feature_id'] == $feature['id']) : ?>
                                                        <li><span class="fa-li"><i class="fas fa-check c_green"></i></span>
                                                            <?= change_name($feature['slug']); ?></li>
                                                    <?php else : ?>
                                                        <li class="text-muted"><span class="fa-li"><i class="fas fa-times c_red"></i></span>
                                                            <?= change_name($feature['slug']); ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach ?>

                                                <?php $customFields = isset($package['custom_fields_config']) && !empty($package['custom_fields_config']) ? json_decode($package['custom_fields_config'], true) : []; ?>

                                                <?php if (is_array($customFields) && !empty($customFields)) : ?>
                                                    <?php foreach ($customFields as $fields) : ?>
                                                        <?php if (!empty($fields)) : ?>
                                                            <li><span class="fa-li"><i class="fas fa-check c_green"></i></span> <?= $fields; ?></li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </ul>
                                            <?php $order_list = isset($package['order_types']) && isJson($package['order_types']) ? json_decode($package['order_types'], true) : []; ?>
                                            <?php if (!empty($order_list)): ?>
                                                <div class="orderTypeBody package_type_body">
                                                    <fieldset>
                                                        <legend class="mb-0"><?= lang('order_types'); ?></legend>
                                                        <ul class="mt-0 pl-0 ml-0 fa-ul order_type_list">

                                                            <?php foreach ($order_types as  $key => $order): ?>
                                                                <li><i class="fas <?= in_array($order['id'], $order_list) ? 'fa-check c_green' : 'fa-times c_red'; ?> "></i> <?= $order['name']; ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </fieldset>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-8 bg_white">
                                        <form action="<?= base_url('login/user_registration/' . $slug) . $ref_id; ?>" method="post" class="form-submit">
                                            <?= csrf(); ?>
                                            <span class="reg_msg"></span>
                                            <div class="login_form">
                                                <div class="form-group">
                                                    <label><i class="fa fa-user-secret"></i>
                                                        <?= !empty(lang('restaurant_username')) ? lang('restaurant_username') : "Restaurant username"; ?></label>
                                                    <input type="text" name="username" id="username" class="form-control" placeholder="<?= !empty(lang('restaurant_username')) ? lang('restaurant_username') : "Restaurant username"; ?>" autocomplete="off">
                                                    <div class="alert_msg"></div>
                                                    <div class="register_loader" style="display:none ;">
                                                        <div class="searching"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label><i class="fa fa-user-circle"></i>
                                                        <?= !empty(lang('owner_name')) ? lang('owner_name') : "Owner Name"; ?></label>
                                                    <input type="text" name="name" class="form-control" placeholder="<?= !empty(lang('owner_name')) ? lang('owner_name') : "Owner Name"; ?>" autocomplete="off">
                                                </div>

                                                <div class="form-group">
                                                    <label><i class="fa fa-envelope-o"></i>
                                                        <?= !empty(lang('email')) ? lang('email') : "email"; ?></label>
                                                    <input type="text" name="email" class="form-control" placeholder="<?= !empty(lang('email')) ? lang('email') : "email"; ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label><i class="fa fa-phone"></i>
                                                        <?= !empty(lang('phone')) ? lang('phone') : "phone"; ?></label>
                                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="<?= !empty(lang('phone')) ? lang('phone') : "phone"; ?>">
                                                    <input type="hidden" name="country_code" class="country_code" value="">
                                                    <input type="hidden" name="dial_code" class="dial_code" value="">
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6 card-pr-5">
                                                        <label><i class="fa fa-key"></i>
                                                            <?= !empty(lang('password')) ? lang('password') : "password"; ?>
                                                        </label>
                                                        <input type="password" name="password" class="form-control" placeholder="<?= !empty(lang('password')) ? lang('password') : "password"; ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 card-pl-5">
                                                        <label><i class="fa fa-key"></i>
                                                            <?= !empty(lang('confirm_password')) ? lang('confirm_password') : "confirm password"; ?>
                                                        </label>
                                                        <input type="password" name="cpassword" class="form-control" placeholder="<?= !empty(lang('confirm_password')) ? lang('confirm_password') : "confirm password"; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <?php if (isset($this->settings['is_recaptcha']) && $this->settings['is_recaptcha'] == 1) : ?>
                                                        <?php if (isset($this->settings['recaptcha']->site_key) && !empty($this->settings['recaptcha']->site_key)) : ?>
                                                            <div class="g-recaptcha" data-sitekey="<?= $this->settings['recaptcha']->site_key; ?>">
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="form-group">
                                                    <label class="pointer"> <input type="checkbox" name="terms" value="1">&nbsp; <?= lang('read_terms'); ?><a href="<?= base_url('terms-conditions') ?>"><?= lang('terms_condition'); ?></a>
                                                        <?= lang('accept_them'); ?></label>
                                                </div>


                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info reg_btn"><i class="fa fa-user-plus"></i> &nbsp;
                                                        <?= !empty(lang('sign-up')) ? lang('sign-up') : "sign up"; ?></button>
                                                </div>


                                                <div class="form-group">
                                                    <p><?= !empty(lang('already_member')) ? lang('already_member') : "Already a Member?"; ?>
                                                        <a href="<?= base_url('login'); ?>"><?= !empty(lang('sign_in')) ? lang('sign_in') : "sign in"; ?></a>
                                                    </p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>