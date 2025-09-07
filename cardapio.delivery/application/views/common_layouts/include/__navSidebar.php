<div class="customNavsideBar">
    <div class="customNavContent">
        <div class="topHeader">
            <a class="navbar-brand" href="<?= url($slug); ?>"><img src="<?= !empty(restaurant($id)->thumb) ? base_url(restaurant($id)->thumb) : base_url("assets/frontend/images/logo-example.png") ?>" alt="shopLogo" class="shopLogo"> </a>
            <a href="javascript:;" class="menuToggle closenav"><i class="icofont-close-line"></i></a>
        </div>
        <div class="navBarBody">
            <ul class="navbar-nav">
                <?php if (is_feature($id, 'welcome') == 1 && is_active($id, 'welcome')) : ?>
                    <li class="nav-item <?= isset($page_title) && $page_title == "Profile" ? "active" : ""; ?>">
                        <a class="nav-link" href="<?= url($slug); ?>"><?= lang('home'); ?> <span class="sr-only">(current)</span></a>
                    </li>
                <?php endif; ?>

                <?php if (is_feature($id, 'menu') == 1 && is_active($id, 'menu')) : ?>
                    <li class="nav-item <?= isset($page_title) && $page_title == "Menus" ? "active" : ""; ?>">
                        <a class="nav-link" href="<?= url('menu/' . $slug); ?>"><?= get_features_name('menu'); ?></a>
                    </li>
                <?php endif; ?>

                <?php if (is_feature($id, 'packages') == 1 && is_active($id, 'packages')) : ?>
                    <li class="nav-item <?= isset($page_title) && $page_title == "Packages" ? "active" : ""; ?>">
                        <a class="nav-link" href="<?= url('packages/' . $slug); ?>"><?= get_features_name('packages'); ?></a>
                    </li>
                <?php endif; ?>
                <?php if (is_feature($id, 'specialities') == 1 && is_active($id, 'specialities')) : ?>
                    <li class="nav-item <?= isset($page_title) && $page_title == "Specialties" ? "active" : ""; ?>">
                        <a class="nav-link" href="<?= url('specialities/' . $slug); ?>"> <?= get_features_name('specialities'); ?></a>
                    </li>
                <?php endif; ?>

                <?php if (is_feature($id, 'reservation') == 1 && is_active($id, 'reservation')) : ?>
                    <li><a href="<?= url('reservation/' . $slug); ?>"><?= get_features_name('reservation'); ?></a></li>
                <?php endif; ?>
                <?php if (sizeof($page_list) > 0) : ?>
                    <li class="navDropdownMenu"><a href="javascript:;" class="nav-link"><?= lang('pages'); ?> <i class="icofont-rounded-down"></i></a>
                        <div class="navDropdownList" style="display:none;">
                            <ul class="pt-0 mt-0">
                                <?php foreach ($page_list as $key => $pg) : ?>
                                    <li class="nav-item"><a class="nav-link" href="<?= url('page/' . $slug . '/' . $pg->slug); ?>"> <?= $pg->title; ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <li class="navDropdownMenu"><a href="javascript:;" class=""><?= lang('more'); ?> <i class="icofont-rounded-down"></i></a>

                    <div class="navDropdownList" style="display:none;">
                        <ul class="pt-0">

                            <li class="nav-item"><a class="" href="<?= url('track-order/' . $slug); ?>"> <?= lang('track_order'); ?></a></li>


                            <?php if (is_feature($id, 'contacts') == 1 && is_active($id, 'contacts')) : ?>
                                <li class="nav-item"><a class="" href="<?= url('shop-contacts/' . $slug); ?>"><?= get_features_name('contacts'); ?></a></li>
                            <?php endif; ?>

                            <li class="nav-item"><a class="" href="<?= url('about-us/' . $slug); ?>"><?= lang('about_us'); ?></a></li>
                            <?php if (isset($shop['is_login']) && $shop['is_login'] == 1) : ?>
                                <li class="nav-item"><a class="" href="<?= base_url("staff-login/customer"); ?>"><?= lang('login'); ?></a></li>
                            <?php endif; ?>

                        </ul>
                    </div>
                </li>

                <?php if (isset($glang['is_glang']) && $glang['is_glang'] == 1) : ?>
                    <li class="gLanguage p-r allow-sm">
                        <div class="gtranslate_wrapper glanguageList"></div>
                    </li>
                <?php else : ?>
                    <?php if (isset($shop['is_language']) && $shop['is_language'] == 1) : ?>
                        <li class="navDropdownMenu"><a class="nav-link p-r" href="javascript:;"> <?= lang_slug(!empty(site_lang()) ? site_lang() : $settings['language']); ?> <i class="icofont-rounded-down"></i></a>
                            <div class="navDropdownList" style="display: none;">
                                <ul>
                                    <?php foreach ($language as $ln) : ?>
                                        <li><a href="<?= base_url('home/lang_switch/' . $ln->slug . '/' . $shop['id']); ?>"><?= $ln->lang_name; ?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>


                <?php __menu(restaurant($id)->id, '', false, $is_sidebar = true); ?>
            </ul><!-- navBar -->
        </div><!-- topbarbody -->
    </div>
    <div class="topFooter">
        <ul class="mt-0 pt-0 text-right ">
            <?php if ($shop['is_call_waiter'] == 1) : ?>
                <li><a href="javascript:;" data-toggle="modal" data-target="#waiterModal"><i class="icofont-bell-alt"></i> <?= lang('call_waiter'); ?></a></li>

            <?php endif; ?>
            <?php if (isset($shop['is_login']) && $shop['is_login'] == 1) : ?>
                <li><a href="<?= base_url('staff-login/customer') ?>"><i class="fa fa-sign-in"></i> <?= __('login') ?></a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>