<?php $shop_info = shop($shop_id); ?>
<?php $guest = isJson($shop_info->guest_config) ? json_decode($shop_info->guest_config) : ''; ?>

<?php $dial_code = $shop_info->dial_code ?? ''; ?>


<?php if (isset($guest->is_guest_login) && $guest->is_guest_login == 1 || (isset($guest->is_guest_login) && $guest->is_guest_login == 1 && !empty(temp('is_table')))) : ?>
    <div class="guestLoginArea">
        <div class="row">
            <div class="col-md-12">
                <label class="custom-checkbox"><input type="checkbox" name="is_guest_login" value="1"><?= lang('login_as_guest'); ?></label>
            </div>
        </div>
    </div><!-- guestLoginArea -->
    <div class="or"><?= lang('or'); ?></div>
<?php endif; ?>

<?php if (isset($s_info->is_customer_login) && in_array($s_info->is_customer_login, [2, 3])) : ?>

    <div class="otpLoginArea">
        <div class="row">
            <div class="col-md-12 mt-3">
                <a href="javascript:;" class="btn btn-primary btn-block _dcolorBtn" data-toggle="modal" data-target="#otpModal"><?= __('login_with_otp'); ?></a>
            </div>
        </div>
    </div><!-- guestLoginArea -->
<?php endif; ?>


<?php if (isset($s_info->is_customer_login) && $s_info->is_customer_login == 1) : ?>
    <div class="tabArea">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#registration"><i class="fa fa-user-plus"></i>
                    <?= !empty(lang('new_registration')) ? lang('new_registration') : "New Registration"; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#login"><i class="fas fa-user-check"></i>
                    <?= !empty(lang('already_have_account')) ? lang('already_have_account') : "Already have account"; ?></a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <span class="alertMsg reg_msg mb-10"></span>
            <div class="tab-pane container active" id="registration">
                <form action="<?= base_url('customer/registration/' . $shop_id); ?>" method="post" class="serviceRegistration">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="form-group">
                        <label for=""><?= lang('name'); ?></label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for=""><?= lang('phone'); ?></label>
                        <div class="customPhone">
                            <div class="ci-input-group">
                                <div class="ci-input-group-prepend w-30 text-center">
                                    <span class="input-group-text">+55</span>
                                </div>
                                <!-- Hidden dial_code field - automatically set to 55 (Brazil) -->
                                <input type="hidden" name="dial_code" value="55">
                                <input type="text" name="phone" class="form-control only_number" autocomplete="off" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" placeholder="11 9 1234 5678">
                            </div>
                        </div>
                    </div>
                    <?php if (isset($shop_info->is_email_based) && $shop_info->is_email_based == 1) : ?>
                        <div class="form-group">
                            <label><?= lang('email'); ?></label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                    <?php endif; ?>



                    <div class="form-group">
                        <label for=""><?= lang('password'); ?></label>
                        <input type="password" name="password" class="form-control password">
                    </div>
                    <div class="form-group">
                        <label for=""><?= lang('confirm_password'); ?></label>
                        <input type="password" name="cpassword" class="form-control">
                    </div>
                    <?php if (isset($shop_info->is_email_based) && $shop_info->is_email_based == 0) : ?>
                        <?php if (isset($shop_info->is_question) && $shop_info->is_question == 1) : ?>
                            <div class="form-group">
                                <label for=""><?= lang('security_question'); ?></label>
                                <?php $question_list = $this->admin_m->select('question_list'); ?>
                                <select name="question" class="form-control  question" id="">
                                    <option value=""><?= lang('select'); ?></option>
                                    <?php foreach ($question_list as $q) : ?>
                                        <option value="<?= $q['id']; ?>"><?= $q['title']; ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="questionAnswer mt-15 dis_none">
                                    <input type="text" name="answer" id="question_answer" class="form-control" placeholder="<?= lang('write_your_answer_here'); ?>">
                                </div>
                            </div>

                        <?php endif ?>
                    <?php endif ?>

                    <div class="form-group mt-15 text-center">
                        <input type="hidden" name="shop_id" value="<?= $shop_id; ?>">
                        <button type="submit" class="btn btn-primary submitBtn"><?= lang('registration'); ?> <i class="icofont-hand-drag1"></i></button>
                    </div>
                </form>

            </div><!-- registration -->
            <div class="tab-pane container fade" id="login">
                <form action="<?= base_url('customer/customer_login'); ?>" method="post" class="serviceLogin">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                    <?php if (isset($shop_info->is_email_based) && $shop_info->is_email_based == 1) : ?>
                        <div class="alert alert-info alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-info-circle"></i> <?= lang('login_with_email_or_phone'); ?></strong></i>
                        </div>

                        <!-- Tab panes -->
                        <div class="form-group">
                            <label for=""><?= lang('phone'); ?></label>
                            <div class="customPhone">
                                <div class="ci-input-group">
                                    <div class="ci-input-group-prepend w-30 text-center">
                                        <span class="input-group-text">+55</span>
                                    </div>
                                    <!-- Hidden dial_code field - automatically set to 55 (Brazil) -->
                                    <input type="hidden" name="dial_code" value="55">
                                    <input type="text" name="phone" class="form-control only_number" autocomplete="off" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" placeholder="11 9 1234 5678">
                                </div>
                            </div>
                            <small>*<?= __("use_email_insist_of_phone") ?></small>
                        </div>
                    <?php else : ?>
                        <div class="form-group">
                            <label for=""><?= lang('phone'); ?></label>
                            <div class="customPhone">
                                <div class="ci-input-group">
                                    <div class="ci-input-group-prepend w-30 text-center">
                                        <span class="input-group-text">+55</span>
                                    </div>
                                    <!-- Hidden dial_code field - automatically set to 55 (Brazil) -->
                                    <input type="hidden" name="dial_code" value="55">
                                    <input type="text" name="phone" class="form-control only_number" autocomplete="off" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" placeholder="11 9 1234 5678">
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for=""><?= lang('password'); ?> <a href="<?= base_url("customer/forgot/customer"); ?>" target="blank" class="text-info"> &nbsp; <?= lang('forgot'); ?></a></label>
                        <input type="password" name="password" class="form-control ">
                    </div>
                    <div class="form-group mt-15 text-center">
                        <button type="submit" class="btn btn-primary submitBtn"><?= lang('login'); ?> <i class="icofont-hand-drag1"></i></button>
                    </div>
                </form>

            </div><!-- registration -->
        </div>
    </div><!-- tabArea -->

<?php endif; ?>
<div class="otpSection">
    <?php include VIEWPATH . 'layouts/otp/otp_login_modal.php' ?>
</div>