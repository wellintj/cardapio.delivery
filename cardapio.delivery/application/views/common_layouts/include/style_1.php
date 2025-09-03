
 <div class="customNavBar">
     <div class="customNav">
         <div class="container restaurant-container">
             <div class="menuArea">
                 <div class="navLeftMenu">
                     <ul>
                         <li><a href="javascript:;" class="menuToggle"><img src="<?= base_url("assets/frontend/images/menu.svg") ?>" alt=""></a></li>
                     </ul>
                     <a class="navbar-brand <?= imgRation(restaurant($id)->thumb ?? '') ?> ml-10" href="<?= url($slug); ?>"><img src="<?= !empty(restaurant($id)->thumb) ? base_url(restaurant($id)->thumb) : base_url("assets/frontend/images/logo-example.png") ?>" alt="shopLogo" class="shopLogo"> </a>
                     <div class="customMenu nwStyleNav">
                         <ul class="navbar-nav">
                             <?php if (is_feature($id, 'welcome') == 1 && is_active($id, 'welcome')) : ?>
                                 <li class="nav-item <?= isset($page_title) && $page_title == "Profile" ? "active" : ""; ?>">
                                     <a class="nav-link" href="<?= base_url($slug); ?>"><?= lang('home'); ?> <span class="sr-only">(current)</span></a>
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
                         </ul>
                     </div>

                 </div>
               
                 <?php $_p = ['payment gateway', 'checkout'] ?>
                 <?php if (isset($page_title) && in_array(strtolower($page_title), $_p) == 0) : ?>
                     <div class="navRightMenu">
                         <ul>
                             <?php if ($shop['is_language'] == 1) : ?>
                                 <?php if (sizeof($language) > 1 && !isset($glang['is_glang'])) : ?>
                                     <li class="navDropdownMenu menuDropdown"><a class="nav-link p-r" href="javascript:;"><i class="icofont-globe"></i> &nbsp;<span class="allow-lg"><?= lang_slug(!empty(site_lang()) ? site_lang() : $settings['language']); ?> <i class="icofont-rounded-down"></i></span></a>
                                         <div class="navDropdownList" style="display: none;">
                                             <ul>
                                                 <?php foreach ($language as $ln) : ?>
                                                     <li><a href="<?= base_url('home/lang_switch/' . $ln->slug.'/'.$shop['id']); ?>"><?= $ln->lang_name; ?></a></li>
                                                 <?php endforeach ?>
                                             </ul>
                                         </div>
                                     </li>
                                 <?php endif; ?> <!-- sizeof -->
                             <?php endif; ?><!-- is_langauge -->
                             <?php if ($shop['is_call_waiter'] == 1) : ?>
                                 <li> <a href="javascript:;" data-toggle="modal" data-target="#waiterModal"><i class="icofont-bell-alt"></i></a></li>
                             <?php endif; ?>

                             <li class="navCart" data-slug="<?= $slug; ?>"><a href="javascript:;"><i class="fa fa-shopping-bag"></i> <span class="ajaxQty"><?php include  APPPATH . "views/common_layouts/cartCount.php"; ?></span></a></li>

                         </ul>
                     </div>
                 <?php endif; ?>
             </div>
             <!-- top menubar -->
         </div>





         <?php include '__navSidebar.php'; ?>
     </div>
 </div>