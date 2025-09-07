<div class="row">
    <?php include APPPATH . "views/backend/dashboard/admin_inc/alert_info.php"; ?>
</div>

<div class="row resoponsiveRow">
    <?php include 'inc/leftsidebar.php'; ?>
    <div class="col-md-8">
        <form class="setting_form validForm" action="<?= base_url('admin/settings/add_settings') ?>" method="post"
            enctype="multipart/form-data">
            <!-- csrf token -->
            <?= csrf(); ?>
            <div class="card">
                <div class="card-body">
                    <div class="row mt-20 mb-20">
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group">
                                <div class="gap favicon_logo">
                                    <img src="<?= !empty($settings['favicon']) ? base_url($settings['favicon']) : '' ?>"
                                        class="fav_icon_preview" alt="">
                                    <label class="btn btn-light-secondary">
                                        <i class="fa fa-cloud-upload"></i>
                                        <?= !empty(lang('favicon')) ? lang('favicon') : "Favicon"; ?>
                                        <input type="file" name="favicon" class="load_img opacity_0" id="favicon">
                                    </label>

                                    <span class="error fav_error"><?= form_error('favicon'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-6">
                            <div class="form-group ">
                                <div class="gap favicon_logo">
                                    <img src="<?= !empty($settings['logo']) ? base_url($settings['logo']) : ''; ?>"
                                        class="service_icon_preview" alt="">
                                    <label class="btn btn-light-secondary">
                                        <i class="fa fa-cloud-upload"></i> &nbsp;
                                        <?= !empty(lang('site_logo')) ? lang('site_logo') : "Site Logo"; ?>
                                        <input type="file" name="images" class="service_img opacity_0" data-height="200"
                                            data-width="500">
                                    </label>
                                    <span class="error img_error"><?= form_error('images'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div><!-- row -->

                    <?php if (isset($settings['language_type']) && $settings['language_type'] == "system"):
                        $language_type = "system";
                    elseif (isset($settings['language_type']) && $settings['language_type'] == "google"):
                        $language_type = "google";
                    else:
                        $language_type = "system";
                    endif;

                    $apps = !empty($settings['glanguage']) && isJson($settings['glanguage']) ? json_decode($settings['glanguage']) : '';
                    ?>
                    <div class="row mt-10">
                        <div class="col-md-12">
                            <div class="form-group col-md-4 pl-0">
                                <label for=""><?= lang('site_language'); ?></label>
                                <select name="language_type" id="language_type" class="form-control"
                                    onchange="changeLang(this.value)">
                                    <option value="system"
                                        <?= isset($language_type) && $language_type == "system" ? "selected" : ""; ?> selected>
                                        <?= lang('system_language'); ?></option>
                                    <option value="google"
                                        <?= isset($language_type) && $language_type == "google" ? "selected" : ""; ?>>
                                        <?= lang('google_translator'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div
                            class="languageItems system mt-10 <?= isset($language_type) && $language_type == "system" ? "" : "dis_none"; ?>">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label><?= !empty(lang('languages')) ? lang('languages') : "language"; ?></label>

                                    <div class="language_select">
                                        <?php foreach ($languages as $lang): ?>
                                            <label class="mr-5 custom-radio"><input type="radio" name="language" class=""
                                                    value="<?= $lang['slug'] ?>"
                                                    <?= !empty($settings['language']) && $settings['language'] == $lang['slug'] ? "checked" : ""; ?>>
                                                <?= $lang['lang_name']; ?></label>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="google col-md-12 mb-20">
                            <div
                                class="languageItems google  <?= isset($language_type) && $language_type == "google" ? "" : "dis_none"; ?>">
                                <?php $glang = isset($apps->glanguage) && isJson($apps->glanguage) ? json_decode($apps->glanguage) : ''; ?>
                                <div class="mb-20">
                                    <label for=""><?= lang('default_language'); ?></label>
                                    <select name="default_language" id="languages" class="form-control select2">
                                        <?php foreach (glanguage() as $key => $val) : ?>
                                            <option value="<?= $key; ?>"
                                                <?= isset($apps->default_language) && $apps->default_language == $key ? "selected" : ""; ?>>
                                                <?= $val; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <h4 class="mb-5"><?= lang('languages'); ?></h4>
                                <select name="glanguage[]" id="languages" class="form-control multiselct" multiple>
                                    <?php foreach (glanguage() as $key => $val) : ?>
                                        <option value="<?= $key; ?>"
                                            <?= isset($glang) && !empty($glang) &&  in_array($key, $glang) == 1 ? "selected" : ""; ?>>
                                            <?= $val; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div><!-- row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputName"><?= !empty(lang('country')) ? lang('country') : "country"; ?> <span
                                        class="error">*</span></label>
                                <select name="country_id" class="form-control select2" id="" required>
                                    <option value=""><?= lang('select'); ?></option>
                                    <?php foreach ($currencies as $con): ?>
                                        <option
                                            <?= !empty($settings['country_id']) && $settings['country_id'] == $con['id'] ? "selected" : ""; ?>
                                            value="<?= $con['id']; ?>"><?= $con['name']; ?></option>
                                    <?php endforeach ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputName"><?= !empty(lang('currency')) ? lang('currency') : "Currency"; ?> <span
                                        class="error">*</span></label>
                                <select name="currency" class="form-control select2" id="" required>
                                    <option value=""><?= lang('select'); ?>
                                        <?= !empty(lang('currency')) ? lang('currency') : "Currency"; ?></option>
                                    <?php foreach ($currencies as $currency): ?>
                                        <option
                                            <?= !empty($settings['currency']) && $settings['currency'] == $currency['id'] ? "selected" : ""; ?>
                                            value="<?= $currency['id']; ?>">
                                            <?= $currency['name'] . ' ' . $currency['currency_code'] . ' (' . $currency['currency_symbol'] . ' )'; ?>
                                        </option>
                                    <?php endforeach ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputName"><?= !empty(lang('time_zone')) ? lang('time_zone') : "Time Zone"; ?>
                                    <span class="error">*</span></label>
                                <select name="time_zone" id="time_zone" class="form-control select2">
                                    <option value="">Select</option>
                                    <?php foreach (timezone_identifiers_list() as $key => $time): ?>
                                        <option value="<?= $time; ?>"
                                            <?= !empty($settings['time_zone']) &&  $settings['time_zone'] == $time ? "selected" : "";  ?>>
                                            <?= $time; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= !empty(lang('site_name')) ? lang('site_name') : "Site Name"; ?> <span
                                        class="error">*</span></label>
                                <input type="text" name="site_name" placeholder="Site Name" class="form-control"
                                    value="<?= !empty($settings['site_name']) ? html_escape($settings['site_name']) : "";  ?>"
                                    required>
                                <span class="error"><?= form_error('site_name'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label
                                    class="gap"><?= !empty(lang('copyright')) ? lang('copyright') : "Copyright"; ?></label>
                                <div class="gap">
                                    <input type="text" name="copyright" placeholder="Copyright" class="form-control"
                                        value="<?= !empty($settings['copyright']) ? html_escape($settings['copyright']) : '';  ?>">
                                    <span class="error"><?= form_error('copyright'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div><!-- row -->
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"><?= lang('currency_position'); ?></label>

                            <select name="currency_position" class="form-control">
                                <option value="1"
                                    <?= isset($settings['currency_position']) && $settings['currency_position'] == 1 ? "selected" : ""; ?>>
                                    100 $</option>
                                <option value="2"
                                    <?= isset($settings['currency_position']) && $settings['currency_position'] == 2 ? "selected" : ""; ?>>
                                    $ 100</option>
                            </select>
                        </div>


                        <div class="form-group col-sm-6">
                            <label class="control-label"><?= lang('number_format'); ?></label>

                            <select name="number_formats" class="form-control">
                                <option value="0" <?= isset($settings['number_formats']) && $settings['number_formats'] == 0 ? "selected" : ""; ?>> 100</option>
                                <option value="1" <?= isset($settings['number_formats']) && $settings['number_formats'] == 1 ? "selected" : ""; ?>>1000.00</option>
                                <option value="2" <?= isset($settings['number_formats']) && $settings['number_formats'] == 2 ? "selected" : ""; ?>>1.000,00</option>
                                <option value="3" <?= isset($settings['number_formats']) && $settings['number_formats'] == 3 ? "selected" : ""; ?>>1,000.00</option>
                                <option value="4" <?= isset($settings['number_formats']) && $settings['number_formats'] == 4 ? "selected" : ""; ?>>1,000,000</option>
                                <option value="5" <?= isset($settings['number_formats']) && $settings['number_formats'] == 5 ? "selected" : ""; ?>>1.000.000</option>
                                <option value="6" <?= isset($settings['number_formats']) && $settings['number_formats'] == 6 ? "selected" : ""; ?>>1000.000</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label
                                    class="gap"><?= !empty(lang('google_analytics')) ? lang('google_analytics') : "Google Analytics"; ?></label>
                                <div class="gap">
                                    <input type="text" name="analytics" id=""
                                        placeholder="<?= !empty(lang('google_analytics_id')) ? lang('google_analytics_id') : "Google Analytics ID"; ?>"
                                        class="form-control"
                                        value="<?= !empty($settings['analytics']) ? $settings['analytics'] : '';  ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label
                                    class="gap"><?= !empty(lang('facebook_pixel')) ? lang('facebook_pixel') : "Facebook Pixel"; ?></label>
                                <div class="gap">
                                    <input type="text" name="pixel_id" id=""
                                        placeholder="<?= !empty(lang('facebook_pixel_id')) ? lang('facebook_pixel_id') : "Facebook Pixel ID"; ?>"
                                        class="form-control"
                                        value="<?= !empty($settings['pixel_id']) ? $settings['pixel_id'] : '';  ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label
                                    class="gap"><?= !empty(lang('pricing_layout')) ? lang('pricing_layout') : "Pricing layouts"; ?></label>
                                <div class="gap">
                                    <label class="custom-radio">
                                        <input type="radio" name="pricing_layout" checked
                                            <?= $settings['pricing_layout'] == 1 ? 'checked' : ''; ?> value="1">
                                        <?= lang('style_1'); ?>
                                    </label> &nbsp; &nbsp; &nbsp; &nbsp;
                                    <label class="custom-radio">
                                        <input type="radio" name="pricing_layout"
                                            <?= $settings['pricing_layout'] == 2 ? 'checked' : ''; ?> value="2">
                                        <?= lang('style_2'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?= !empty(lang('overview')) ? lang('overview') : "overview"; ?></label>
                                <div class="gap">
                                    <textarea name="description" id=""
                                        placeholder="<?= !empty(lang('overview')) ? lang('overview') : "overview"; ?>"
                                        class="form-control" cols="5"
                                        rows="5"><?= !empty($settings['description']) ? html_escape($settings['description']) : '';  ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?= !empty(lang('description')) ? lang('description') : "Description"; ?></label>
                                <div class="gap">
                                    <textarea name="long_description" id=""
                                        placeholder="<?= !empty(lang('description')) ? lang('description') : "Description"; ?>"
                                        class="form-control textarea" cols="5"
                                        rows="5"><?= !empty($settings['long_description']) ? html_escape($settings['long_description']) : '';  ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div><!-- row -->
                    <?php $tax = isJson($settings['invoice_config']) ? json_decode($settings['invoice_config']) : '' ?>
                    <div class="row">

                        <div class="col-md-12 text-center mb-10" style="border-bottom: 1px solid #eee">
                            <p class="fw-bold"><?= lang('subscription_invoice'); ?></p>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><?= lang('tax'); ?></label>
                            <small><?= lang('tax_percent_for_subscription'); ?></small>
                            <div class="input-group">
                                <input type="text" class="form-control only_number" name="tax_percent"
                                    autocomplete="off"
                                    value="<?= isset($tax->tax_percent) && !empty($tax->tax_percent) ? $tax->tax_percent : 0; ?>"
                                    placeholder="<?= lang('percent'); ?>	">
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?= lang('tax_number'); ?></label>
                            <input type="text" name="tax_number" class="form-control"
                                value="<?= isset($tax->tax_number) && !empty($tax->tax_number) ? $tax->tax_number : ''; ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <label><?= lang('company_details'); ?></label>
                            <textarea name="company_details" id="company_details" class="form-control" cols="5"
                                rows="5"><?= isset($tax->company_details) && !empty($tax->company_details) ? html_escape($tax->company_details) : ''; ?></textarea>
                        </div>
                    </div>
                </div><!-- card-body -->
                <div class="card-footer">
                    <div class="">
                        <input type="hidden" name="id"
                            value="<?= isset($settings['id']) ? html_escape($settings['id']) : 0; ?>">
                        <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-save"></i>
                            &nbsp;<?= !empty(lang('save_change')) ? lang('save_change') : "Save change"; ?></button>
                    </div>
                </div>
            </div><!-- card -->
        </form>
    </div><!-- col-md-9 -->
</div><!-- row -->



<script>
    function changeLang(val) {
        $('.languageItems').slideUp();
        $(`.${val}`).slideDown();
    }
</script>