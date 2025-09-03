<?php
$id = auth('id');
function hex2rgb($color)
{
    list($r, $g, $b) = array(
        $color[0] . $color[1],
        $color[2] . $color[3],
        $color[4] . $color[5]
    );
    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);
    return $r . ',' . $g . ',' . $b;
}
$my_color  = isset($this->my_info['colors']) && !empty(trim($this->my_info['colors'])) ? trim($this->my_info['colors']) : '29C7AC';
$my_color_rgb  = hex2rgb(trim($this->my_info['colors']));
?>
<style>
    .skin-black-light .sidebar-menu>li.active>a {
        background: rgba(<?= $my_color_rgb; ?>, .1)!important;
        color: #<?= $my_color;
                ?>!important;
    }

    .skin-black-light .sidebar-menu .treeview-menu>li.active>a {
        color: #<?= $my_color;
                ?>!important;
    }

    .skin-black-light .sidebar-menu>li>.treeview-menu li.active,
    .sidebar-menu>li.active>a {
        border-left: 3px solid rgba(<?= $my_color_rgb; ?>, .8)!important;
        ;
    }

    .skin-black-light .sidebar-menu .treeview-menu>li>a:hover {
        background: rgba(<?= $my_color_rgb; ?>, .1)!important;
        color: rgba(<?= $my_color_rgb; ?>, 1)!important;
    }

    .skin-black-light .sidebar-menu .treeview-menu>li.active>a i {
        color: #<?= $my_color;
                ?>!important;
    }
</style>
<?php if (!auth('is_staff')) : ?>
    <li class="<?= isset($page_title) && $page_title == "Subscriptions" ? "active" : ""; ?>">
        <a href="<?= base_url('admin/auth/subscriptions') ?>">
            <i class="icofont-repair fz-20"></i>
            <span><?= !empty(lang('subscriptions')) ? lang('subscriptions') : "Subscriptions"; ?></span>
        </a>
    </li>

<?php endif; ?>


<?php if ($this->auth['is_payment'] == 1 && $this->auth['is_expired'] == 0 && shop_id() > 0) : ?>
    <?php if (is_access('order-control') == 1) : ?>
        <li class="nav-drawer-header"><?= lang('order'); ?></li>
        <?php if (is_feature($id, 'order') == 1 && is_active($id, 'order')) : ?>
            <li class="<?= isset($page_title) && $page_title == "Order List" ? "active" : ""; ?>">
                <?php $today_order = $this->admin_m->get_todays_notify(restaurant()->id); ?>
                <a href="<?= base_url('admin/restaurant/order_list') ?>" class="flex_between liveOrder">
                    <i class="icofont-live-support fz-20"></i>
                    <span class="flex_between">
                        <span><?= !empty(lang('live_order')) ? lang('live_order') : "Live Orders"; ?> </span><span class="blob <?= isset($today_order) && $today_order > 0 ? "red" : "green"; ?>"></span>
                    </span>
                </a>
            </li>
        <?php endif; ?>
        <?php if (is_feature($id, 'reservation') == 1 && is_active($id, 'reservation')) : ?>
            <li class="<?= isset($page) && $page == "Reservation List" ? "active" : ""; ?>">

                <?php $todays_reservation = $this->admin_m->get_todays_reservations_notify(restaurant()->id); ?>
                <a href="<?= base_url('admin/restaurant/todays_reservation') ?>" class="flex_between liveOrder">
                    <i class="icofont-delivery-time fz-20"></i>
                    <span class="flex_between">
                        <span><?= !empty(lang('reservation')) ? lang('reservation') : "Reservation"; ?> </span><span class="blob <?= isset($todays_reservation) && $todays_reservation > 0 ? "red" : "green"; ?>"></span>
                    </span>
                </a>
            </li>
        <?php endif; ?>

        <?php if (restaurant()->is_call_waiter == 1) : ?>
            <li class="<?= isset($page) && $page == "Call Waiter" ? "active" : ""; ?> hidden">
                <a href="<?= base_url('admin/restaurant/call_waiter') ?>" class="flex_between liveOrder">
                    <i class="icofont-waiter fz-20"></i>
                    <span class="flex_between">
                        <span><?= lang('call_waiter'); ?> </span>
                    </span>
                </a>
            </li>
        <?php endif; ?>

    <?php endif; ?>
    <!-- order-control -->
    <?php if (is_access('kds') == 1) : ?>
        <!-- kds -->
        <?php if (restaurant()->is_kds == 1) : ?>
            </li>
            <li class="<?= isset($page) && $page == "KDS" ? "active" : ""; ?>">
                <a href="<?= base_url('admin/kds/live/' . md5(restaurant()->id)) ?>" class="flex_between liveOrder" target="_blank">
                    <i class="icofont-prestashop fz-20"></i>
                    <span class="flex_between">
                        <span><?= !empty(lang('kds')) ? lang('kds') : "KDS"; ?>
                        </span>
                </a>
            </li>
        <?php endif; ?>
        <!-- kds -->
    <?php endif; ?>


    <?php if (file_exists(APPPATH . 'controllers/admin/Pos.php')) : ?>
        <?php if (is_feature(auth('id'), 'pos') == 1) : ?>
            <li class="treeview pos <?= isset($page) && $page == "POS" ? "active" : ""; ?> <?= isset($page_title) && $page_title == "Expenses" ? "active" : ""; ?> <?= isset($this->pos['class']) ? $this->pos['class'] : ''; ?>">
                <a href="#">
                    <img src="<?= base_url("assets/frontend/images/pos.png"); ?>" alt="" class="menuImg">
                    <span><?= isset($this->pos['pos_text']) ? lang($this->pos['pos_text']) : ''; ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if (is_access('pos-order') == 1) : ?>
                        <li class="<?= $page_title == "POS" ? "active" : ""; ?>"><a href="<?= base_url(isset($this->pos['pos_link']) ? $this->pos['pos_link'] : '') ?>"><i class="fa fa-plus"></i>
                                <?= !empty(lang('add_new_order')) ? lang('add_new_order') : "Add New Order"; ?></a></li>
                    <?php endif; ?>

                    <?php if (is_access('pos-settings') == 1) : ?>
                        <li class="<?= $page_title == "POS Settings" ? "active" : ""; ?>"><a href="<?= base_url(isset($this->pos['pos_settings_link']) ? $this->pos['pos_settings_link'] : '') ?>"><i class="fa fa-angle-double-right"></i>
                                <?= !empty(lang('settings')) ? lang('settings') : "Settings"; ?></a></li>

                        <li class="<?= $page_title == "Expenses" ? "active" : ""; ?>"><a href="<?= base_url('admin/pos/expenses') ?>"><i class="fa fa-angle-double-right"></i>
                                <?= !empty(lang('expenses')) ? lang('expenses') : "Expenses"; ?>
                                <?= is_new('3.1.2'); ?></a></li>


                        <li class="<?= $page_title == "Order List" ? "active" : ""; ?>"><a href="<?= base_url('admin/restaurant/all_order_list?status=draft') ?>"><i class="fa fa-angle-double-right"></i>
                                <?= !empty(lang('draft')) ? lang('draft') : "Draft"; ?>
                                <?= is_new('3.2.2'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (is_access('reports') == 1) : ?>
        <li class="treeview <?= isset($page) && $page == "Reports" ? "active" : ""; ?>">
            <a href="#">
                <i class="icofont-sound-wave fz-20"></i>
                <span><?= lang('reports'); ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="<?= $page_title == "Statistics" ? "active" : ""; ?>"><a href="<?= base_url('admin/reports/statistics?status=2') ?>"><i class="fa fa-angle-double-right"></i>
                        <?= !empty(lang('statistics')) ? lang('statistics') : "Statistics"; ?></a></li>

                <li class="<?= $page_title == "Earnings" ? "active" : ""; ?>"><a href="<?= base_url('admin/reports/earnings/' . date('Y') . '/' . date('m')); ?>"><i class="fa fa-angle-double-right"></i>
                        <?= !empty(lang('earnings')) ? lang('earnings') : "Earnings"; ?></a></li>

                <li class="<?= $page_title == "Reports" ? "active" : ""; ?>"><a href="<?= base_url('admin/reports/getReports?q=xReport'); ?>"><i class="fa fa-angle-double-right"></i>
                        <?= !empty(lang('reports')) ? lang('reports') : "Report"; ?></a></li>
            </ul>
        </li>

    <?php endif; ?>


    <?php if (!empty(restaurant()->phone) && restaurant()->country_id != 0) : ?>
        <?php if (is_access('menu') == 1) : ?>
            <li class="nav-drawer-header"><?= lang('menu'); ?></li>
            <li class="treeview <?= isset($page) && $page == "Menu" ? "active" : ""; ?>">
                <a href="#">
                    <i class="icofont-tasks fz-20"></i>
                    <span><?= !empty(lang('menu')) ? lang('menu') : "menu"; ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    <li class="<?= $page_title == "Category" ? "active" : ""; ?>"><a href="<?= base_url('admin/menu/category') ?>"><i class="fa fa-angle-double-right"></i>
                            <?= !empty(lang('menu_categories')) ? lang('menu_categories') : "Menu Categories"; ?></a></li>

                    <?php if (__sub(restaurant()->id) == 1) : ?>
                        <li class="<?= $page_title == "Sub Category" ? "active" : ""; ?>"><a href="<?= base_url('admin/menu/sub_category') ?>"><i class="fa fa-angle-double-right"></i> <?= !empty(lang('sub_categories')) ? lang('sub_categories') : "Sub Categories"; ?></a></li>
                    <?php endif; ?>


                    <?php if (is_feature(auth('id'), 'menu') == 1) : ?>
                        <li class="<?= $page_title == "Items" ? "active" : ""; ?>"><a href="<?= base_url('admin/menu/item') ?>"><i class="fa fa-angle-double-right"></i> <?= !empty(lang('items')) ? lang('items') : "Items"; ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if (is_feature(auth('id'), 'packages') == 1) : ?>
                        <li class="<?= $page_title == "Packages" ? "active" : ""; ?>"><a href="<?= base_url('admin/menu/packages') ?>"><i class="fa fa-angle-double-right"></i>
                                <?= !empty(lang('packages')) ? lang('packages') : "Packages"; ?></a></li>
                    <?php endif; ?>

                    <?php if (is_feature(auth('id'), 'specialities') == 1) : ?>

                        <li class="<?= $page_title == "Specialties" ? "active" : ""; ?>"><a href="<?= base_url('admin/menu/specialties') ?>"><i class="fa fa-angle-double-right"></i>
                                <?= !empty(lang('specialties')) ? lang('specialties') : "Specialties"; ?></a></li>
                    <?php endif; ?>

                    <?php if (is_feature(auth('id'), 'qr-code') == 1) : ?>
                        <li class="<?= $page_title == "QR Builder" ? "active" : ""; ?>"><a href="<?= base_url('admin/menu/dine_in') ?>"><i class="fa fa-angle-double-right"></i>
                                <?= !empty(lang('package_qr_builder')) ? lang('package_qr_builder') : "Package QR builder"; ?></a></li>
                    <?php endif ?>

                    <li class="<?= $page_title == "Allergens" ? "active" : ""; ?>"><a href="<?= base_url('admin/menu/allergens') ?>"><i class="fa fa-angle-double-right"></i>
                            <?= !empty(lang('allergens')) ? lang('allergens') : "allergens"; ?></a></li>


                    <li class="<?= $page_title == "Extras" ? "active" : ""; ?>"><a href="<?= base_url('admin/menu/extras') ?>"><i class="fa fa-angle-double-right"></i> <?= lang('extras'); ?> <span class="ab-position custom_badge danger-light-active"><?= lang('new'); ?></span></a></li>

                </ul>
            </li>
        <?php endif; ?>
    <?php endif; ?>
    <!-- !empty(restaurant()->phone) && restaurant()->country_id !=0 -->



    <!-- settings -->
    <?php if (is_access('setting-control') == 1) : ?>
        <li class="nav-drawer-header"><?= lang('settings'); ?></li>
        <li class="<?= isset($page) && $page == "Profile" ? "active" : ""; ?>"><a href="<?= base_url('admin/restaurant/general') ?>"><i class="fa fa-user-circle"></i> <span>
                    <?= !empty(lang('shop_configuration')) ? lang('shop_configuration') : "shop configuration"; ?> </span></a>
        </li>

        <!-- settings -->

        <li class="<?= isset($page) && $page == "Settings" ? "active" : ""; ?>">
            <a href="<?= base_url('admin/auth/settings') ?>">
                <i class="fa fa-cogs"></i> <span><?= !empty(lang('settings')) ? lang('settings') : "Settings"; ?></span>
            </a>
        </li>
        <!-- settings -->



        <?php if (is_feature(auth('id'), 'whatsapp') == 1) : ?>

            <li class="treeview <?= isset($page) && $page == "Whatsapp Config" ? "active" : ""; ?>">
                <a href="#">
                    <i class="fa fa-whatsapp fz-20"></i>
                    <span><?= !empty(lang('whatsapp_config')) ? lang('whatsapp_config') : "Whatsapp Config"; ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= isset($page_title) && $page_title == "Whatsapp Support" ? "active" : ""; ?>">
                        <a href="<?= base_url('admin/auth/whatsapp_support') ?>">
                            <i class="fa fa-angle-double-right"></i> <span><?= lang('whatsapp_support'); ?></span>
                        </a>
                    </li>

                    <li class="<?= isset($page_title) && $page_title == "Whatsapp Share" ? "active" : ""; ?>">
                        <a href="<?= base_url('admin/auth/whatsapp_share') ?>">
                            <i class="fa fa-angle-double-right"></i> <span><?= lang('whatsapp_share'); ?></span>
                        </a>
                    </li>

                    <li class="<?= isset($page_title) && $page_title == "Whatsapp Message" ? "active" : ""; ?>">
                        <a href="<?= base_url('admin/auth/whatsapp_message') ?>">
                            <i class="fa fa-angle-double-right"></i> <span><?= lang('whatsapp_message'); ?></span>
                        </a>
                    </li>

                </ul>
            </li>

        <?php endif; ?>

    <?php endif; ?>
    <!-- is access setting-control-->


    <li class="nav-drawer-header"><?= lang('others'); ?></li>
    <?php if (check() == 1) : ?>
        <?php if (is_access('affiliate') == 1) : ?>
            <?php if (is_feature(auth('id'), 'affiliate') == 1) : ?>
                <?php if (__config('is_affiliate') == 1) : ?>
                    <!-- Affiliate -->
                    <li class="treeview <?= isset($page) && $page == "Affiliate" ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-cube fz-20"></i>
                            <span><?= !empty(lang('affiliate')) ? lang('affiliate') : "affiliate"; ?></span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>


                        <ul class="treeview-menu">

                            <li class="<?= $page_title == "Affiliate Dashboard" ? "active" : ""; ?>">
                                <a href="<?= base_url('admin/affiliate/user') ?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?= lang('home'); ?></span>
                                </a>
                            </li>



                            <li class="<?= $page_title == "Payout Request" ? "active" : ""; ?>">
                                <a href="<?= base_url('admin/affiliate/payout') ?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?= lang('payout_request'); ?></span>
                                </a>
                            </li>

                            <li class="<?= $page_title == "Vendor Affiliate List" ? "active" : ""; ?>">
                                <a href="<?= base_url('admin/affiliate/vendor_affiliate_list') ?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?= lang('affiliate_list'); ?></span>
                                </a>
                            </li>

                            <li class="<?= $page_title == "Vendor Affiliate Settings" ? "active" : ""; ?>">
                                <a href="<?= base_url('admin/affiliate/vendor_affiliate_settings') ?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?= lang('settings'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Affiliate -->
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (is_access('pages') == 1) : ?>
        <li class="<?= isset($page) && $page == "Pages" ? "active" : ""; ?>">
            <a href="<?= base_url('admin/pages/') ?>">
                <i class="fa fa-copy"></i> <span><?= lang('pages'); ?> <?= is_new('3.1.6'); ?></span>
            </a>
        </li>
    <?php endif; ?>
    <?php if (is_access('coupon') == 1) : ?>
        <li class="treeview <?= isset($page) && $page == "Promo" ? "active" : ""; ?>">
            <a href="#">
                <i class="fa fa-gift fz-20"></i>
                <span><?= !empty(lang('promo')) ? lang('promo') : "promo"; ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>


            <ul class="treeview-menu">

                <li class="<?= isset($page_title) && $page_title == "Coupon List" ? "active" : ""; ?>">
                    <a href="<?= base_url('admin/coupon/') ?>">
                        <i class="fa fa-angle-double-right"></i> <?= lang('coupon_list'); ?></span>
                    </a>
                </li>


                <li class="<?= isset($page_title) && $page_title == "Offers List" ? "active" : ""; ?>">
                    <a href="<?= base_url('admin/coupon/offers') ?>">
                        <i class="fa fa-angle-double-right"></i> <span><?= lang('offers'); ?></span>
                    </a>
                </li>


            </ul>
        </li>



    <?php endif; ?>

    <li class="<?= isset($page_title) && $page_title == "Payment History" ? "active" : ""; ?>">
        <a href="<?= base_url('admin/restaurant/payment_history') ?>">
            <i class="fa fa-credit-card-alt"></i>
            <span><?= !empty(lang('payment_history')) ? lang('payment_history') : "Payment History"; ?></span>
        </a>
    </li>








    <!-- settings -->

    <?php if (auth('account_type') != 0) : ?>

        <li class="treeview <?= isset($page) && $page == "Staff" ? "active" : ""; ?>">
            <a href="#">
                <i class="icofont-users-social fz-20"></i>
                <?= !empty(lang('staffs')) ? lang('staffs') : "Staffs"; ?>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <?php if (!auth('is_staff')) : ?>
                    <li class="<?= isset($page_title) && $page_title == "Staff" ? "active" : ""; ?>">
                        <a href="<?= base_url('admin/restaurant/staff_list') ?>">
                            <i class="fa fa-angle-double-right"></i> <span>
                                <?= !empty(lang('staff')) ? lang('staff') : "staff"; ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (check() == 1 && is_feature(auth('id'), 'dboy') == 1) : ?>
                    <?php if (is_access('delivery-guy') == 1) : ?>
                        <li class="<?= isset($page_title) && $page_title == "Delivery Staff" ? "active" : ""; ?>">
                            <a href="<?= base_url('admin/restaurant/dboy_list') ?>">
                                <i class="fa fa-angle-double-right"></i>
                                <span><?= !empty(lang('delivery_staff')) ? lang('delivery_staff') : "Delivery staff"; ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

            </ul>
        </li>
    <?php endif; ?>


    <?php if (is_access('customer') == 1) : ?>
        <li class="<?= isset($page_title) && $page_title == "Customer List" ? "active" : ""; ?>">
            <a href="<?= base_url('admin/restaurant/customer_list') ?>">
                <i class="icofont-learn"></i> <span><?= lang('customer_list'); ?></span>
            </a>
        </li>
    <?php endif; ?>


    <?php if (auth('account_type') != 0 && !auth('is_staff')) : ?>
        <li class="<?= isset($page_title) && $page_title == "Reviews" ? "active" : ""; ?>">
            <a href="<?= base_url('admin/restaurant/reviews') ?>">
                <i class="fa fa-star-o"></i> <span><?= !empty(lang('reviews')) ? lang('reviews') : "Reviews"; ?>
                    <?= is_new('3.1.5'); ?></span>
            </a>
        </li>
    <?php endif; ?>

    <?php if (auth('account_type') != 0 && !auth('is_staff')) : ?>
        <li class="<?= isset($page_title) && $page_title == "Manage Features" ? "active" : ""; ?>">
            <a href="<?= base_url('admin/auth/manage_features') ?>">
                <i class="fa fa-toggle-on"></i>
                <span><?= !empty(lang('manage_features')) ? lang('manage_features') : "Manage Features"; ?></span>
            </a>
        </li>
    <?php endif; ?>

    <?php if (auth('account_type') != 0 && !auth('is_staff')) : ?>
        <li class="<?= isset($page_title) && $page_title == "Promotion" ? "active" : ""; ?>">
            <a href="<?= base_url('admin/auth/promotion') ?>">
                <i class="icofont-brand-bada"></i>
                <span><?= !empty(lang('promotion')) ? lang('promotion') : "promotion"; ?></span>
            </a>
        </li>
    <?php endif; ?>
    
    <?php if (isset($pusher_config->status) && $pusher_config->status == 1) : ?>
        <?php if (auth('account_type') != 0 && !auth('is_staff')) : ?>
            <li class="<?= isset($page_title) && $page_title == "Chat" ? "active" : ""; ?>">
                <a href="<?= base_url('admin/chat/user_chat') ?>">
                    <i class="fa fa-comment-o"></i>
                    <span><?= !empty(lang('chat')) ? lang('chat') : "Chat"; ?></span>
                </a>
            </li>
        <?php endif; ?>
    <?php endif; ?>




<?php endif; ?>
<!-- is_expired && is_payment -->


<script>
    $(document).ready(function() {
        <?= isset($this->pos['connected']) ? $this->pos['connected'] : ""; ?>
    });
</script>