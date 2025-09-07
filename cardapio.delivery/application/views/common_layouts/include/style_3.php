<div class="commonTopMenu allow-lg">
    <?php include 'commonTopMenu.php'; ?>
</div>

<div class="UserResponsive_menu">
    <div class="UserMobileMenu">
        <ul>

            <li data-toggle="tooltip" title="" class="menuToggle"> <a href="javascript:;" class="base"><i class="icofont-navigation-menu"></i></a></li>
        </ul>
    </div>
</div>

<!-- style_3 cart icon -->
<?php $disable_pages = ['Payment Gateway', 'All Orders', 'Checkout']; ?>
<?php if (isset($page_title) && !in_array($page_title, $disable_pages)) : ?>
    <div class="cartFloatingIcon menuStyle<?= $u_info['menu_style']; ?>">
        <?php include  APPPATH . "views/common_layouts/cart_floating_icon.php"; ?>
    </div>
<?php endif; ?>

 <div class="customNavBar allow-sm">
     <div class="customNav commonNav">
         <div class="customNavsideBar">
             <?php include '__navSidebar.php'; ?>
         </div>
     </div>
 </div>


