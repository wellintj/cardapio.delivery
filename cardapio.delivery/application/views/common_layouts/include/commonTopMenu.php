 <div class="userMenu ">
     <div class="container restaurant-container">
         <nav class="navbar navbar-expand-lg fixed-top">
             <div class="container restaurant-container">
                 <a class="navbar-brand <?= imgRation(restaurant($id)->thumb ?? '') ?>" href="<?= url($slug); ?>"><img src="<?= !empty(restaurant($id)->thumb) ? base_url(restaurant($id)->thumb) : base_url("assets/frontend/images/logo-example.png") ?>" alt="shopLogo" class="shopLogo"> </a>
                 <ul class="smDropdown">
                     <?php if ($shop['is_language'] == 1) : ?>
                         <?php if (isset($glang['is_glang']) && $glang['is_glang'] == 1) : ?>
                             <li class="gLanguage allow-sm">
                                 <div class="gtranslate_wrapper glanguageList"></div>
                             </li>
                         <?php else : ?>
                             <?php if (sizeof($language) > 1) : ?>
                                 <li class="dropdownMenu"><a class="nav-link p-r" href="javascript:;"><i class="icofont-globe"></i> <span class=""><?= lang_slug(!empty(site_lang()) ? site_lang() : $settings['language']); ?></span></a>
                                     <div class="dropdownArea dropdownList" style="display: none;">
                                         <ul>
                                             <?php foreach ($language as $ln) : ?>
                                                 <li><a href="<?= base_url('home/lang_switch/' . $ln->slug . '/' . $shop['id']); ?>"><?= $ln->lang_name; ?> </a></li>
                                             <?php endforeach ?>
                                         </ul>
                                     </div>
                                 </li>
                             <?php endif; ?>
                         <?php endif; ?>
                     <?php endif; ?>

                     <?php if ($shop['is_call_waiter'] == 1) : ?>
                         <li class="nav-item allow-sm"><a class="nav-link" class="nav-link" href="javascript:;" data-toggle="modal" data-target="#waiterModal"><i class="icofont-bell-alt"></i></a></li>
                     <?php endif; ?>

                 </ul>
                 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
                 <div class="collapse navbar-collapse" id="navbarNavDropdown">
                     <div class="container-fluid">
                         <div class="userMenu_flex">
                             <ul class="navbar-nav">

                                 <li class="nav-item" data-title="<?= lang("more") ?>"><a href="javascript:;" class="nav-link menuToggle" data-title="<?= lang("more") ?>" data-toggle="tooltip" style="font-size: inherit;"><i class="fa fa-list"></i></a></li>

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







                                 <li class="dropdownMenu moreMenuBtn"><a href="javascript:;" class=""><?= lang('more'); ?> <i class="icofont-rounded-down"></i></a>

                                     <div class="dropdownArea" style="display: none;">
                                         <ul>

                                             <li class="nav-item allow-sm"><a class="nav-link" href="<?= url('track-order/' . $slug); ?>"> <?= lang('track_order'); ?></a></li>

                                             <?php if (is_feature($id, 'reservation') == 1 && is_active($id, 'reservation')) : ?>
                                                 <li class="nav-item allow-sm"><a class="nav-link" href="<?= url('reservation/' . $slug); ?>"> <?= get_features_name('reservation'); ?></a></li>
                                             <?php endif; ?>

                                             <?php if (is_feature($id, 'contacts') == 1 && is_active($id, 'contacts')) : ?>
                                                 <li class="nav-item allow-sm"><a class="nav-link" href="<?= url('shop-contacts/' . $slug); ?>"><?= get_features_name('contacts'); ?></a></li>
                                             <?php endif; ?>

                                             <li class="nav-item allow-sm"><a class="nav-link" href="<?= url('about-us/' . $slug); ?>"><?= lang('about_us'); ?></a></li>
                                             <?php if (isset($shop['is_login']) && $shop['is_login'] == 1) : ?>
                                                 <li class="nav-item allow-sm"><a class="nav-link" href="<?= base_url("staff-login/customer"); ?>"><?= lang('login'); ?></a></li>
                                             <?php endif; ?>

                                         </ul>
                                     </div>
                                 </li>

                             </ul>
                             <?php $_p = ['payment gateway', 'checkout'] ?>
                             <?php if (isset($page_title) && in_array(strtolower($page_title), $_p) == 0) : ?>
                                 <div class="rightMenu">
                                     <ul>
                                         <li class="cart navCart dis_none" style="display:none;"><a class="nav-link" href="javascript:;" data-slug="<?= $slug; ?>"><i class="icofont-cart-alt fa-2x"></i> <span class="cart_count total_count"><?= $this->cart->total_items(); ?></span></a></li>
                                         <?php if ($shop['is_language'] == 1) : ?>
                                             <?php if (isset($glang['is_glang']) && $glang['is_glang'] == 1) : ?>
                                                 <!--  <li class="gLanguage">
                                                 <div class="gtranslate_wrapper glanguageList"></div>
                                             </li> -->
                                             <?php else : ?>
                                                 <?php if (count($language) > 1) : ?>
                                                     <li class="dropdownMenu"><a class="nav-link p-r btn" href="javascript:;"><i class="icofont-globe"></i> <?= lang_slug(!empty(site_lang()) ? site_lang() : $settings['language']); ?></a>
                                                         <div class="dropdownArea dropdownList" style="display: none;">
                                                             <ul>
                                                                 <?php foreach ($language as $ln) : ?>
                                                                     <li><a href="<?= base_url('home/lang_switch/' . $ln->slug . '/' . $shop['id']); ?>"><?= $ln->lang_name; ?></a></li>
                                                                 <?php endforeach ?>
                                                             </ul>
                                                         </div>
                                                     </li>
                                                 <?php endif; ?>
                                             <?php endif; ?><!-- glang -->
                                         <?php endif; ?>


                                         <?php if ($shop['is_call_waiter'] == 1) : ?>
                                             <li class="callwaiter"><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#waiterModal"><i class="icofont-bell-alt"></i> <?= lang('call_waiter'); ?></a></li>

                                         <?php endif; ?>
                                         <?php if (isset($shop['is_login']) && $shop['is_login'] == 1) : ?>
                                             <li class="nav-item ml-10"><a href="<?= base_url("staff-login/customer"); ?>"> <i class="icofont-login"></i></a></li>
                                         <?php endif; ?>
                                     </ul>
                                 </div>
                             <?php endif; ?>
                         </div>
                     </div>
                 </div>
             </div>
         </nav>
     </div>
 </div>
 <div class="customNavBar">
     <div class="customNav commonNav">
         <div class="customNavsideBar">
             <?php include '__navSidebar.php'; ?>
         </div>
     </div>
 </div>