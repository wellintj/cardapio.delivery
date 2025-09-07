<?php foreach ($order_list as $key => $row) : ?>
 <?php $shop_info = shop($row['shop_id']);?>
    <?php if ($row['dboy_id'] == auth('staff_id')) : ?>
        <div class="col-md-4">
            <div class="singleOrder" onclick="window.location='<?= base_url("staff/order_details/" . $shop_info->username . "/{$row['uid']}"); ?>'">
                <div class="singleOrderHeader">
                    <p class="timeAgo"><?= get_time_ago($row['completed_time']); ?></p>
                    <a href="<?= base_url("staff/order_details/" . shop($row['shop_id'])->username . "/{$row['uid']}"); ?>">
                        <div class="single_orderTop">
                            <h4><?= $row['name']; ?></h4>
                            <h4>#<?= $row['uid']; ?></h4>

                        </div>
                    </a>
                </div>
                <div class="single_orderDetails">
                    <?php if ($row['order_type'] == 1) : ?>
                        <label class="badge badge-secondary bg-green"><?= order_type($row['order_type']); ?></label>
                    <?php else : ?>
                        <label class="badge info-light"><?= order_type($row['order_type']); ?></label>
                    <?php endif; ?>
                    <p><?= $row['total_item']; ?> <?= lang('item'); ?> - <?= currency_position($row['total'], $row['shop_id']); ?>
                    </p>
                    <p><i class="fa fa-map-marker"></i> <?= $row['address']; ?></p>
                    <?php if ($row['is_db_request'] == 1) : ?>
                        <p class="text-success"><i class="fa fa-check"></i> <?= lang('selectd_by_restaurant'); ?></p>
                    <?php endif ?>
                </div>
            </div>

        </div>
    <?php endif ?>
    <?php if ($row['dboy_id'] == 0) : ?>
        <div class="col-md-4">
            <div class="singleOrder" onclick="window.location='<?= base_url("staff/order_details/" . shop($row['shop_id'])->username . "/{$row['uid']}"); ?>'">
                <p class="timeAgo"><?= get_time_ago($row['completed_time'] ?? ''); ?></p>
                <a href="<?= base_url("staff/order_details/" . shop($row['shop_id'])->username . "/{$row['uid']}"); ?>">
                    <div class="single_orderTop">
                        <h4>
                            <?= !empty($row['name']) ? $row['name'] : lang('walk-in-customer'); ?>
                            <?php if (!empty($row['phone'])) : ?>
                                <small>+<?= $row['phone']; ?></small>
                            <?php endif; ?>
                        </h4>
                        <h4>#<?= $row['uid']; ?></h4>

                    </div>
                </a>
                <div class="single_orderDetails">
                    <?php if ($row['order_type'] == 1) : ?>
                        <label class="badge badge-secondary bg-green"><?= order_type($row['order_type']); ?></label>
                    <?php else : ?>
                        <label class="badge info-light"><?= order_type($row['order_type']); ?></label>
                    <?php endif; ?>
                    <p><?= $row['total_item']; ?> item - <?= currency_position($row['total'], $row['shop_id']); ?>
                    </p>
                    <?php if (!empty($row['address'])) : ?>
                        <p><i class="fa fa-map-marker"></i> <?= $row['address']; ?></p>
                    <?php endif; ?>

                </div>
                <div class="singleOrderfooter">
                   <a href="<?= url($shop_info->username)?>" target="_blank"> <?= !empty($shop_info->name)?$shop_info->name:$shop_info->username?> <i class="icofont-bubble-right"></i></a>
                </div>
            </div>

        </div>
    <?php endif ?>
<?php endforeach ?>