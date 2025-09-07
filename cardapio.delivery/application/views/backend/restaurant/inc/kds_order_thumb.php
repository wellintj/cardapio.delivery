<div class="row">
    <div class="kds_shop_header">
        <div class="kds_shopName">
            <img src="<?= base_url($shop['thumb']); ?>" alt="<?= $shop['thumb']; ?>">
            <div class="kdsShopDetails">
                <h4><?= !empty($shop['name']) ? $shop['name'] : $shop['username']; ?></h4>
                <p><?= $shop['currency_code']; ?> (<?= $shop['icon']; ?>)</p>
            </div>
        </div>
        <?php if ((auth('is_user') == TRUE || auth('user_staff')) && (isset(restaurant()->id) && $shop['id'] == restaurant()->id)) : ?>
            <div class="kds_shop__header_right">
                <div class="searchField">
                    <form action="" method="get">
                        <div class="ci-input-group">
                            <input type="text" name="orderid" class="form-control" placeholder="<?= lang("order_id") ?>" value="<?= isset($_GET['orderid']) ? $_GET['orderid'] : '' ?>">
                            <div class="input-group">
                                <button type="submit" class="btn btn-secondary "><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                $orderSt = $this->admin_m->get_todays_kds_order_statistics($id);
                $new_order = $preparing = $ready = $served = $dine_in  = $pending_order = [];
                foreach ($orderSt as $keys => $orders) :

                    if ($orders['status'] == 0) {
                        $pending_order[] = $orders['id'];
                    }

                    if ($orders['status'] == 1 &&  $orders['is_preparing'] == 0) {
                        $new_order[] = $orders['id'];
                    }
                    if ($orders['status'] == 1 &&  $orders['is_preparing'] == 1) {
                        $preparing[] = $orders['id'];
                    }
                    if ($orders['status'] == 1 &&  $orders['is_preparing'] == 2) {
                        $ready[] = $orders['id'];
                    }
                    if ($orders['status'] == 2) {
                        $served[] = $orders['id'];
                    }
                    if ($orders['order_type'] == 7) {
                        $dine_in[] = $orders['id'];
                    }

                endforeach;

                ?>
                <ul>
                    <li><a href="<?= base_url("admin/kds/live/" . md5($id)) ?>"><span class="kdsMenuCount"><?= sizeof($orderSt) ?? 0; ?></span>
                            <span class="kdsMenuTitle"> <?= lang('all'); ?></span></a>
                    </li>

                    <li><a href="<?= base_url("admin/kds/live/" . md5($id) . "?q=dine-in") ?>"><span class="kdsMenuCount"><?= sizeof($dine_in) ?? 0; ?></span>
                            <span class="kdsMenuTitle"> <?= lang('dine-in'); ?></span></a>
                    </li>


                    <li><a href="<?= base_url("admin/kds/live/" . md5($id) . "?q=pending") ?>"><span class="kdsMenuCount"><?= sizeof($pending_order) ?? 0; ?></span>
                            <span class="kdsMenuTitle"><?= lang('pending'); ?></span> </a></li>


                     <li><a href="<?= base_url("admin/kds/live/" . md5($id) . "?q=new-order") ?>"><span class="kdsMenuCount"><?= sizeof($new_order) ?? 0; ?></span>
                            <span class="kdsMenuTitle"><?= lang('new_order'); ?></span> </a></li>


                    <li><a href="<?= base_url("admin/kds/live/" . md5($id) . "?q=preparing") ?>"><span class="kdsMenuCount"><?= sizeof($preparing) ?? 0; ?></span>
                            <span class="kdsMenuTitle"><?= lang('preparing'); ?></span> </a></li>


                    <li><a href="<?= base_url("admin/kds/live/" . md5($id) . "?q=ready") ?>"><span class="kdsMenuCount"><?= sizeof($ready) ?? 0; ?></span>
                            <span class="kdsMenuTitle"><?= lang('ready'); ?></span> </a></li>

                    <li><a href="<?= base_url("admin/kds/live/" . md5($id) . "?q=served") ?>"><span class="kdsMenuCount"><?= sizeof($served) ?? 0; ?></span>
                            <span class="kdsMenuTitle"><?= lang('served'); ?></span> </a>
                    </li>

                    <li><a href="<?= base_url("admin/kds/logout/") ?>"><span class="kdsMenuCount"><i class="icofont-sign-out"></i></span>
                            <span class="kdsMenuTitle"><?= lang('logout'); ?></span> </a>
                    </li>

                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row column-sm-reverse">
    <div class="col-md-9">
        <div class="row">
            <?php $i = 1; ?>
            <div class="col-md-3 p-5">
                <?php
                $is_new_order = 1;
                $status = 'new_order';
                $icon = "<i class='fa fa-spinner text-danger'></i>";
                ?>
                <div class="kdsStatusTitle <?= $status; ?>">
                    <?= __($status); ?>
                </div>
                <?php foreach ($order_list as $key => $row) : ?>
                    <?php if ($row['status'] == 1 && $row['is_preparing'] == 0) : ?>
                        <?php include 'kds_item_thumb.php'; ?>
                    <?php endif; ?>
                <?php endforeach; ?>

                <!--[if IE]>PENDING ORDERS<![endif]-->

                <?php $others = __others($id); ?>
                <?php if (isset($others->is_kds_pending_orders) && $others->is_kds_pending_orders == 1) : ?>
                    <?php $is_pending_order = 1; ?>
                    <?php $status = 'pending_order'; ?>
                    <div class="">
                        <div class="kdsStatusTitle <?= $status; ?>">
                            <?= __($status); ?>
                        </div>
                        <?php foreach ($order_list as $key => $row) : ?>
                            <?php if ($row['status'] == 0) : ?>

                                <?php include 'kds_item_thumb.php'; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>



            </div>


            <div class="col-md-3 p-5">
                <?php
                $is_new_order = 0;
                $status = 'accepted';
                $icon = "<i class='fa fa-check text-success'></i>";
                ?>
                <div class="kdsStatusTitle <?= $status; ?>">
                    <?= __($status); ?>
                </div>
                <?php foreach ($order_list as $key => $row) : ?>
                    <?php if ($row['status'] == 1 && $row['is_preparing'] == 1) : ?>
                        <?php include 'kds_item_thumb.php'; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="col-md-3 p-5">
                <?php
                $is_new_order = 0;
                $status = 'completed';
                $icon = "<i class='fa fa-check text-success'></i>";
                ?>
                <div class="kdsStatusTitle <?= $status; ?>">
                    <?= __($status); ?>
                </div>
                <?php foreach ($order_list as $key => $row) : ?>
                    <?php if ($row['status'] == 1  && $row['is_preparing'] == 2) : ?>
                        <?php include 'kds_item_thumb.php'; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- orderList -->
            </div>

            <div class="col-md-3 p-5">
                <?php
                $is_new_order = 0;
                $status = 'served';
                $icon = "<i class='fa fa-check text-success'></i>";
                ?>

                <div class="kdsStatusTitle <?= $status; ?>">
                    <?= __($status); ?>
                </div>
                <?php foreach ($order_list as $key => $row) : ?>
                    <?php if ($row['status'] == 2) : ?>
                        <?php include 'kds_item_thumb.php'; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <!-- orderList -->

        </div>
    </div> <!-- col-md-9 -->
    <?php if ((auth('is_user') == TRUE || auth('user_staff')) && (isset(restaurant()->id) && $shop['id'] == restaurant()->id)) : ?>
        <?php $item_details = $this->admin_m->get_todays_orders($id); ?>
        <div class="col-md-3 pr-lg-0 pl-sm-0">
            <div class="card kds_item_details">
                <div class="card-body p-0">
                    <div class="todays_statistics">
                        <div class="KDSsidebarHeading hidden-lg">
                            <span><?= lang('product'); ?></span> <span><i class="icofont-rounded-down"></i></span>
                            <span><?= lang('qty'); ?></span>
                        </div>
                        <ul class="kdsSidebar">
                            <?php $itemCount = 0; ?>
                            <?php foreach ($item_details as  $key => $category) : ?>
                                <?php if (!empty($category->category_name)) : ?>
                                    <li class="categoryNames"><span><?= $category->category_name; ?></span>
                                    </li>
                                <?php endif; ?>
                                <?php foreach ($category->items as  $key => $citem) : ?>
                                    <li><span><?= $citem->item_name; ?></span> <span><?= $citem->item_count; ?></span></li>
                                <?php endforeach; ?>

                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>


<script>
    function showCustomerDetails(id) {
        $('.kdsCustomerDetails').slideUp();


        if ($('#showCustomerDetails_' + id).hasClass("kdsCustomerDetails active")) {
            $('#showCustomerDetails_' + id).removeClass('active').slideUp();
        } else {
            $('#showCustomerDetails_' + id).addClass('active').slideDown();
        }
    }
</script>