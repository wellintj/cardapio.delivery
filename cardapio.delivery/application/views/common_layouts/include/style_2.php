<div class="commonTopMenu allow-lg">
    <?php include 'commonTopMenu.php'; ?>
</div>
<div class="allow-sm">
    <?php include 'style_1.php'; ?>
</div>


<!-- style_3 cart icon -->
<?php $disable_pages = ['Payment Gateway', 'All Orders', 'Checkout']; ?>
<?php if (isset($page_title) && !in_array($page_title, $disable_pages)) : ?>
    <div class="cartFloatingIcon menuStyle<?= $u_info['menu_style']; ?>">
        <?php include  APPPATH . "views/common_layouts/cart_floating_icon.php"; ?>
    </div>
<?php endif; ?>


