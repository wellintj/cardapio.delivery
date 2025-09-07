<div class="row resoponsiveRow">
    <?php include APPPATH . 'views/backend/users/inc/leftsidebar.php'; ?>

    <div class="col-md-8">
        <form class="email_setting_form" action="<?= base_url('admin/auth/add_email_settings') ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <?= csrf(); ?>
            <div class="card">
                <div class="card-body">
                    <div class="row p-15">
                        <div class="email_areas">
                            <div class="email_content">
                                <div class="row">
                                
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label class=""><?= lang('contact_email'); ?></label>
                                            <div class="">
                                                <input type="text" name="smtp_mail" placeholder="<?= lang('contact_email'); ?>" class="form-control" value="<?= !empty($settings['smtp_mail']) ? html_escape($settings['smtp_mail']) : '';  ?>">
                                                <span class="error"><?= form_error('email'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class=""><?= !empty(lang('default_email')) ? lang('default_email') : "Default Email"; ?></label>
                                        <div class="">
                                            <select name="email_type" class="form-control email_option">
                                                <option value="2" <?= isset($settings['email_type']) && $settings['email_type'] == 2 ? 'selected' : '' ?> selected>
                                                    <?= lang('smtp'); ?></option>
                                                <option value="3" <?= isset($settings['email_type']) && $settings['email_type'] == 3 ? 'selected' : '' ?>>
                                                    <?= lang('sendgrid'); ?></option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <?php $smtp = json_decode(!empty($settings['smtp_config']) ? $settings['smtp_config'] : '', TRUE); ?>
                                    <div class="smtpArea" style="display:<?= isset($settings['email_type'])  && ($settings['email_type'] == 2 || $settings['email_type'] == 1) ? 'block' : 'none' ?>">

                                        <div class="col-md-12">
                                            <div class="callout callout-primary">
                                                <h4><i class="fa fa-envelope-o"></i> Gmail Smtp</h4>

                                                <p>Gmail Host:&nbsp;&nbsp;smtp.gmail.com <br>
                                                    Gmail Port:&nbsp;&nbsp;465</p>

                                                <ol>
                                                    <li>Login to your gmail</li>
                                                    <li>Go to Security setting and Enable 2 factor authentication</li>
                                                    <li>After enabling this you can see app passwords option</li>
                                                    <li>And then, from Your app passwords tab select Other option and
                                                        put your app name and click GENERATE button to get new app
                                                        password. </li>
                                                    <li>Finally copy the 16 digit of password and click done. Now use
                                                        this password instead of email password to send mail via your
                                                        app.</li>
                                                </ol>

                                            </div>
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label class=""><?= lang('smtp_host'); ?></label>
                                            <div class="">
                                                <input type="text" name="smtp_host" placeholder="<?= lang('smtp_host'); ?>" class="form-control" value="<?= !empty($smtp['smtp_host']) ? html_escape($smtp['smtp_host']) : '';  ?>">
                                                <span class="error"><?= form_error('smtp_host'); ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 ">
                                            <label class=""><?= lang('smtp_port'); ?></label>
                                            <div class="">
                                                <input type="text" name="smtp_port" placeholder="<?= lang('smtp_port'); ?>" class="form-control" value="<?= !empty($smtp['smtp_port']) ? html_escape($smtp['smtp_port']) : '';  ?>" autocomplete="off">
                                                <span class="error"><?= form_error('smtp_port'); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?= lang('smtp_password'); ?></label>
                                            <div class="">
                                                <input type="password" name="smtp_password" placeholder=" <?= lang('smtp_password'); ?>" class="form-control" value="<?= !empty($smtp['smtp_password']) ? html_escape(base64_decode($smtp['smtp_password'])) : '';  ?>" autocomplete="off">
                                                <span class="error"><?= form_error('smtp_password'); ?></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row sendGrid">
                                    <div class="sendGrid" style="display: <?= isset($settings['email_type']) && $settings['email_type'] == 3 ? 'block' : 'none' ?>;">
                                        <div class="form-group col-md-12">
                                            <label><?= lang('sendgrid_api_key'); ?></label>
                                            <input type="text" name="sendgrid_api_key" class="form-control" value="<?= isset($settings['sendgrid_api_key']) ? $settings['sendgrid_api_key'] : ""; ?>" placeholder="<?= lang('sendgrid_api_key'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="MailTrap" style="display: none;">
                                        <div class="form-group col-md-12">
                                            <label><?= lang('mailtrap_api_key'); ?></label>
                                            <input type="text" name="mailtrap_api_key" class="form-control" value="<?= isset($smtp['mailtrap_api_key']) ? $smtp['mailtrap_api_key'] : ""; ?>" placeholder="<?= lang('mailtrap_api_key'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <a href="<?= base_url("admin/auth/test_mail"); ?>" target="blank" class="btn btn-secondary"><?= lang('test_mail'); ?></a>
                                    </div>
                                </div>
                            </div><!-- email_content -->
                        </div><!-- email_area -->
                    </div><!-- row -->

                </div><!-- card-body -->
                <div class="card-footer">
                    <input type="hidden" name="id" value="<?= isset($settings['id']) ? html_escape($settings['id']) : 0; ?>">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i>
                        &nbsp;<?= !empty(lang('save_change')) ? lang('save_change') : "Save Change"; ?></button>
                </div>
            </div><!-- card -->
        </form>
    </div><!-- col-9 -->

</div>