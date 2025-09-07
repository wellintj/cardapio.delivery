<div class="items <?= $row['order_type'] == 7 ? "dineIn" : ""; ?>">
    <div class="singleKDS">
        <div class="kdsHeader <?= $status ?? '' ?>">
            <div class="kdsTitle">
                <?php if (!empty($row['table_no'])) : ?>
                    <h3> <?= __table($row['table_no'])->area_name; ?> /
                        <?= __table($row['table_no'])->name; ?> </h3>
                <?php endif; ?>
                <h4># <?= $row['uid']; ?></h4>
                <h4 class="mt-5"><i class="icofont-culinary"></i> <?= order_type($row['order_type']); ?>
                </h4>
                <h4 class="mt-5 mb-5"><?= lang('price'); ?> : <?= currency_position($row['total'], $id); ?>
                </h4>
            </div>

            <div class="kdsTime">
                <?php if (auth('is_user') == TRUE || auth('user_staff')) : ?>
                    <a href="<?= url("invoice/{$shop['username']}/{$row['uid']}") ?>" class="btn bg-purple-soft-active btn-sm" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                <?php endif; ?>

                <h4><i class="fa fa-clock"></i> <?= time_format($row['created_at'], $row['shop_id']); ?>
                </h4>
            </div>


            <?php if ($row['order_type'] == 7) : ?>
                <h4 class="fz-16 fw_bold text-center w_100"><?= lang('token_number'); ?> :
                    <?= $row['token_number']; ?></h4>
            <?php endif; ?>

            <!-- preparing timeout -->
            <?php if ($row['estimate_time'] != 0) : ?>
                <?php if ($row['is_preparing'] == 0 || $row['is_preparing'] == 1) : ?>
                    <h4 class="preparingTime" id="preparingTime_<?= $row['id']; ?>">
                        <i class="fa fa-hourglass-start"></i>
                        <p class="showPTime get_time m-0" id="show_time_<?= $row['id']; ?>" data-time="<?= $row['estimate_time']; ?>" data-id="<?= $row['id']; ?>"></p>
                    </h4>
                <?php endif; ?>
            <?php endif; ?>
            <!-- preparing time -->

        </div>

        <?php if ($row['order_type'] == 7) : ?>
            <?php $get_dinein_items = $this->admin_m->get_dinin_items($row['dine_id']); ?>
            <?php foreach ($get_dinein_items as $key1 => $package) : ?>
                <div class="kdsorderBody">
                    <div class="itemTitle">
                        <div class="dineInItems">
                            <?php foreach ($package['all_items'] as $key2 => $ditem) : ?>
                                <h4> <span><span class="Itemicon"><?= $item_icon ?? ''; ?> </span> <?= $item['qty'] ?? 1; ?>
                                        x
                                        <?= $ditem['title']; ?></span>
                                    <span><?= currency_position($ditem['item_price'], $row['shop_id']); ?></span>
                                </h4>
                            <?php endforeach; ?>
                            <!-- package/item title check -->
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <!-- orderType==7 -->



        <?php foreach ($row['all_items'] as $keys => $item) : ?>
            <?php
            if ($item['status'] == 0) :
                $is_item_new_order = 1;
                $item_status = 'new_order';
                $item_icon = "<i class='fa fa-spinner text-danger'></i>";
            elseif ($item["status"] == 1) :
                $is_item_new_order = 0;
                $item_status = 'served';
                $item_icon = "<i class='icofont-verification-check text-success'></i>";
            elseif ($item["status"] == 2) :
                $is_item_new_order = 0;
                $item_status = 'reject';
                $item_icon = "<i class='icofont-close text-danger'></i>";
            endif;
            ?>
            <div class="kdsorderBody <?= $item['is_merge'] == 1 ? "bg-danger-soft" : "" ?>">
                <div class="itemTitle">
                    <div class="itemTitle_left">
                        <?php if (isset($item['is_package']) && $item['is_package'] == 1) : ?>
                            <h4> <span class="Itemicon"><?= $item_icon ?? ''; ?></span> <?= $item['qty'] ?? 1; ?> x
                                <?= $item['package_name']; ?></h4>
                        <?php else : ?>
                            <h4> <span class="Itemicon"><?= $item_icon ?? ''; ?> </span> <?= $item['qty'] ?? 1; ?> x
                                <?= $item['title']; ?>
                                <?php if (!empty($item['veg_type'])) : ?>
                                    <span title="<?= veg_type($item['veg_type']); ?>" class="vegType <?= $item['veg_type'] == 1 ? "bg-success-light-active " : "bg-danger-light-active" ?>"></span>
                                <?php endif; ?>
                            </h4>
                            <?php if (isset($item['is_size']) && $item['is_size'] == 1) : ?>
                                <small class="kds_variants">
                                    <?= variants($item['size_slug'], $item['item_id'], $item['shop_id']); ?>
                                </small>
                            <?php endif; ?>

                            <!-- check variants -->
                        <?php endif; ?>
                        <!-- package/item title check -->
                    </div>
                    <?php if ($row['status'] == 1 && $row['is_preparing'] == 1) : ?>
                        <div class="itemTitle_right">
                            <?php if ($item['status'] == 0) : ?>
                                <a href="<?= base_url("admin/kds/status/" . md5($item['order_item_id']) . "/done/{$item['order_item_id']}") ?>" class="btn btn-sm bg-success-soft changeStatus"><i class="fa fa-check"></i></a>
                                <a href="<?= base_url("admin/kds/status/" . md5($item['order_item_id']) . "/cancle/{$item['order_item_id']}") ?>" class="btn btn-sm bg-danger-soft changeStatus"><i class="fa fa-close"></i></a>
                            <?php elseif ($item['status'] == 1) : ?>
                                <a href="javascript:;" class="btn btn-sm success-light-active"><i class="fa fa-check"></i></a>
                                <a href="<?= base_url("admin/kds/status/" . md5($item['order_item_id']) . "/done/{$item['order_item_id']}") ?>" class="btn btn-sm bg-danger-soft changeStatus"><i class="fa fa-close"></i></a>
                            <?php elseif ($item['status'] == 2) : ?>
                                <a href="<?= base_url("admin/kds/status/" . md5($item['order_item_id']) . "/done/{$item['order_item_id']}") ?>" class="btn btn-sm bg-success-soft changeStatus"><i class="fa fa-check"></i></a>
                                <a href="javascript:;" class="btn btn-sm danger-light-active"><i class="fa fa-close"></i></a>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                </div>

                <?php if (isset($item['is_extras']) && $item['is_extras'] == 1) : ?>
                    <div class="itemExtras">
                        <?= extraList($item['extra_id'], $item['extra_qty'], $item['item_id'], $item['shop_id']); ?>
                    </div>
                <?php endif; ?>

                <!-- is_extras -->

                <?php if (!empty($item['item_comments'])) : ?>
                    <div class="itemComments mt-10">
                        <small><i class="fa fa-comments text-muted "></i>
                            <?= html_escape($item['item_comments']); ?></small>
                    </div>
                <?php endif; ?>
                <!-- item comments  -->
            </div>
        <?php endforeach; ?>
        <!-- all_items -->
    </div>

    <?php if ($row['status'] != 2) : ?>
        <?php if (auth('is_user') == TRUE || auth('user_staff')) : ?>
            <div class="kdsFooter">
                <?php if ($row['status'] == 0) : ?>
                    <a href="<?= base_url('admin/kds/order_status_by_ajax/' . $row['id'] . '/' . md5($row['shop_id']) . '/0'); ?>" class="btn btn-primary btn-sm kdsOrder" data-shop="<?= $row['shop_id']; ?>"><i class="fa fa-check"></i>
                        &nbsp; <?= lang('accept'); ?></a>
                <?php endif; ?> 


                <?php if ($row['status'] == 1 && $row['is_preparing'] == 0) : ?>
                    <a href="<?= base_url('admin/kds/order_status_by_ajax/' . $row['id'] . '/' . md5($row['shop_id']) . '/1'); ?>" class="btn btn-primary btn-sm kdsOrder" data-shop="<?= $row['shop_id']; ?>"><i class="fa fa-check"></i>
                        &nbsp; <?= lang('start_preparing'); ?></a>
                <?php endif; ?>

                <?php if ($row['status'] == 1 && $row['is_preparing'] == 1) : ?>
                    <a href="<?= base_url('admin/kds/order_status_by_ajax/' . $row['id'] . '/' . md5($row['shop_id']) . '/4'); ?>" class="btn btn-info kdsOrder btn-sm" data-shop="<?= $row['shop_id']; ?>"><i class="fa fa-check"></i> &nbsp; <?= lang('mark_as_completed'); ?></a>
                <?php endif; ?>

                <?php if ($row['status'] == 1  && $row['is_preparing'] == 2) : ?>
                    <a href="<?= base_url('admin/kds/order_status_by_ajax/' . $row['id'] . '/' . md5($row['shop_id']) . '/2'); ?>" class="btn btn-success kdsOrder btn-sm" data-shop="<?= $row['shop_id']; ?>"><i class="fa fa-check"></i> &nbsp; <?= lang('mark_as_served'); ?></a>
                <?php endif; ?>
                <?php if ($row['is_order_merge'] == 1) : ?>
                    <p class="text-danger m-0"> <i class="fa fa-exchange"></i> <?= lang('order_merged'); ?></p>
                <?php endif; ?>
            </div>

        <?php endif; ?>
        <!-- status != 2 -->
    <?php endif; ?>
    <!-- auth('is_user')==TRUE || auth('user_staff') -->


    <?php if (auth('is_user') == TRUE || auth('user_staff')) : ?>
        <?php if (!empty($row['phone']) || !empty($row['name'])) : ?>
            <div class="customerKds">

                <a href="javascript:;" class="showOrderDetails" onclick="showCustomerDetails(<?= $row['id']; ?>)"><?= lang('see_more'); ?> <i class="icofont-long-arrow-right"></i></a>


                <div class="kdsCustomerDetails" id="showCustomerDetails_<?= $row['id']; ?>">
                    <?php if (!empty($row['name'])) : ?>
                        <p><?= lang('name'); ?>: <b><?= $row['name']; ?></b></p>
                    <?php endif; ?>
                    <?php if (!empty($row['phone'])) : ?>
                        <p><?= lang('phone'); ?>: <b><?= $row['phone']; ?></b></p>
                    <?php endif; ?>
                </div><!-- kdsCustomerDetails -->
            </div><!-- customerKds -->
        <?php endif; ?>
        <!-- is not empty -->
    <?php endif; ?>
    <!-- is_login -->

</div> <!-- col-3 -->