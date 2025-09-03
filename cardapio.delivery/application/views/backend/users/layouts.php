<div class="row resoponsiveRow">
    <?php include APPPATH . 'views/backend/users/inc/leftsidebar.php'; ?>
    <div class="col-md-8">
        <form action="<?= base_url("admin/auth/add_layouts"); ?>" method="post">
            <?= csrf(); ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0 mr-5"><?= lang('layouts'); ?> </h5>
                </div>
                <div class="card-body">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?= lang('color_picker'); ?>:</label>

                                    <div class="color_picker">
                                        <div class="input-group my-colorpicker2 colorpicker-element">
                                            <input type="text" class="form-control" name="colors" value="<?= $this->my_info['colors']; ?>">

                                            <div class="input-group-addon">
                                                <i style="background-color: rgb(0, 0, 0);"></i>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="singleDiv">
                            <div class="divHeader">
                                <h4><?= lang('preloader'); ?></h4>
                            </div>
                            <div class="singleDivDetails">
                                <div class="row">
                                    <div class="preloaderList">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="pointer custom-radio">
                                                    <div class="admin_preloader">
                                                        <div id="preloaders">
                                                            <div class="preloader_1"><span></span> <span></span></div>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="preloader" value="1"
                                                        <?= isset($settings['preloader']) && $settings['preloader'] == 1 ? 'checked' : ''; ?>>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="pointer custom-radio">
                                                    <div class="admin_preloader">
                                                        <div id="preloaders">
                                                            <div class="preloader_2"><span></span> <span></span></div>
                                                        </div>

                                                    </div>
                                                    <input type="radio" name="preloader" value="2"
                                                        <?= isset($settings['preloader']) && $settings['preloader'] == 2 ? 'checked' : ''; ?>>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="pointer custom-radio">
                                                    <div class="admin_preloader">
                                                        <div id="preloaders">
                                                            <div class="preloader_3"><span></span> <span></span></div>
                                                        </div>

                                                    </div>
                                                    <input type="radio" name="preloader" value="3"
                                                        <?= isset($settings['preloader']) && $settings['preloader'] == 3 ? 'checked' : ''; ?>>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="pointer custom-radio">
                                                    <div class="admin_preloader">
                                                        <div id="preloaders">
                                                            <div class="preloader_4"><span></span> <span></span></div>
                                                        </div>

                                                    </div>
                                                    <input type="radio" name="preloader" value="4"
                                                        <?= isset($settings['preloader']) && $settings['preloader'] == 4 ? 'checked' : ''; ?>>
                                                </label>
                                            </div>
                                        </div>


                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="pointer custom-radio custom-radio text-center">
                                                    <div class="admin_preloader">
                                                        <div id="preloaders"> <?= lang('off'); ?> </div>
                                                    </div>
                                                    <input type="radio" name="preloader" value="0"
                                                        <?= isset($settings['preloader']) && $settings['preloader'] == 0 ? 'checked' : ''; ?>>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- singleDivDetails -->
                        </div><!-- singleDiv -->

                        <div class="singleDiv">
                            <div class="divHeader">
                                <h4><?= lang('layouts'); ?></h4>
                            </div>
                            <div class="singleDivDetails">
                                <div class="row">
                                    <div class="">
                                        <?php for ($i = 1; $i <= 3; $i++) { ?>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="pointer custom-radio layoutImg">
                                                        <div class="layouts">
                                                            <img src="<?= base_url(IMG_PATH . 'layouts/layout_' . $i . '.png'); ?>"
                                                                alt="">
                                                        </div>
                                                        <input type="radio" name="theme" value="<?= $i;; ?>"
                                                            <?= isset($auth_info->theme) && $auth_info->theme == $i ? 'checked' : ''; ?>>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php  } ?>

                                    </div>
                                </div>
                            </div><!-- singleDivDetails -->
                        </div><!-- singleDiv -->

                        <div class="singleDiv">
                            <div class="divHeader">
                                <h4><?= lang('menu_style'); ?></h4>
                            </div>
                            <div class="singleDivDetails">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php for ($i = 1; $i <= 3; $i++) { ?>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <?php if ($i == 1): ?>
                                                        <h4 class="mb-5"><?= lang('menu_top'); ?></h4>
                                                    <?php elseif ($i == 2): ?>
                                                        <h4 class="mb-5"><?= lang('menu_top'); ?></h4>
                                                    <?php else: ?>
                                                        <h4 class="mb-5"><?= lang('menu_bottom'); ?></h4>
                                                    <?php endif; ?>
                                                    <label class="pointer layoutImg menu_style">
                                                        <div class="layouts">
                                                            <img src="<?= base_url(IMG_PATH . 'layouts/menu_' . $i . '.png'); ?>"
                                                                alt="">
                                                        </div>
                                                        <input type="radio" name="menu_style" value="<?= $i;; ?>"
                                                            class="icheck"
                                                            <?= isset($auth_info->menu_style) && $auth_info->menu_style == $i ? 'checked' : ''; ?>>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div><!-- singleDivDetails -->
                        </div><!-- singleDiv -->

                        <div class="row mt-10 mb-20">
                            <div class="col-md-12">
                                <fieldset>
                                    <legend><?= __('welcome_page'); ?></legend>
                                    <div class="form-group d-flex gap-20">
                                        <label class="custom-radio mr-1rm d-flex flex-column text-center align-center home_layouts"> <input type="radio" name="home_page_style" value="1" <?= isset($auth_info->home_page_style) && $auth_info->home_page_style == 1 ? 'checked' : ''; ?>>
                                            <div class="customInput mt-5">
                                                <?= lang('style_1'); ?> <p><small><?= __('with_popular_feature_items'); ?></small></p>
                                            </div>
                                        </label>
                                        <label class="custom-radio d-flex flex-column text-center align-center home_layouts"> <input type="radio" name="home_page_style" value="2" <?= isset($auth_info->home_page_style) && $auth_info->home_page_style == 2 ? 'checked' : ''; ?>>
                                            <div class="customInput mt-5">
                                                <?= lang('style_2'); ?> <p><small><?= __('without_popular_feature_items'); ?></small></p>
                                            </div>
                                        </label>
                                    </div>

                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="singleDiv">
                        <div class="divHeader">
                            <h4><?= lang('dashboard'); ?></h4>
                        </div>
                        <div class="singleDivDetails">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('light'); ?></label>
                                        <label class="pointer custom-radio layoutImg">
                                            <div class="layouts">
                                                <img src="<?= base_url("assets/frontend/images/dashboard_layouts/user_light_dashboard.png"); ?>"
                                                    class="img-thumbnail box-shadow" alt="">
                                            </div>
                                            <input type="radio" name="site_theme" value="1"
                                                <?= isset($settings['site_theme']) && $settings['site_theme'] == 1 ? "checked" : ""; ?>>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('dark'); ?></label>
                                        <label class="pointer custom-radio layoutImg">
                                            <div class="layouts">
                                                <img src="<?= base_url("assets/frontend/images/dashboard_layouts/user_dark_dashboard.png"); ?>"
                                                    class="img-thumbnail box-shadow" alt="">
                                            </div>
                                            <input type="radio" name="site_theme" value="2"
                                                <?= isset($settings['site_theme']) && $settings['site_theme'] == 2 ? "checked" : ""; ?>>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div><!-- singleDivDetails -->
                    </div><!-- singleDiv -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="custom-checkbox"><input type="checkbox" name="is_theme_toggle" value="1" <?= isset($auth_info->is_theme_toggle) && $auth_info->is_theme_toggle == 1 ? 'checked' : ''; ?>><?= __('enable_theme_toggle'); ?></label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="custom-checkbox"><input type="checkbox" name="is_banner" value="1"
                                    <?= isset($settings['is_banner']) && $settings['is_banner'] == 1 ? "checked" : ""; ?>>
                                <?= lang('hide_banner'); ?> </label>
                        </div>
                        <div class="col-md-3">
                            <label class="custom-checkbox"><input type="checkbox" name="is_footer" value="1"
                                    <?= isset($settings['is_footer']) && $settings['is_footer'] == 1 ? "checked" : ""; ?>>
                                <?= lang('hide_footer'); ?></label>
                        </div>
                    </div>

                </div><!-- card-content -->
            </div><!-- card-body -->
            <div class="card-footer text-right">
                <input type="hidden" name="setting_id" value="<?= isset($settings['id']) ? $settings['id'] : 0; ?>">
                <input type="hidden" name="user_id" value="<?= isset($auth_info->id) ? $auth_info->id : 0; ?>">
                <button type="submit" class="btn btn-secondary"><?= lang('save_change'); ?></button>
            </div>
    </div><!-- card -->
    </form>
</div>
</div>