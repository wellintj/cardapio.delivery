<?php foreach ($order_list as $key => $order) : ?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= lang('order_id'); ?> #<?= $order['uid']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="icofont-close-line"></i></span>
        </button>
    </div><!-- modal header -->
    <div class="modal-body p-0">
        <div class="table-responsive responsiveTable">
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <th width=""><?= !empty(lang('sl')) ? lang('sl') : "sl"; ?></th>
                        <th width=""><?= !empty(lang('image')) ? lang('image') : "image"; ?></th>
                        <th width=""><?= !empty(lang('item_name')) ? lang('item_name') : "name"; ?></th>
                        <th width=""><?= !empty(lang('qty')) ? lang('qty') : "qty"; ?></th>
                        <th width=""><?= !empty(lang('total')) ? lang('total') : "total"; ?></th>


                    </tr>
                </thead>
                <tbody>
                    <?php $p = __order($order, $order['item_list']); ?>
                    <?php foreach ($order['item_list'] as $key => $row) : ?>
                        <?php if ($row['is_package'] == 1) : ?>
                            <tr>
                                <td data-label="<?= lang('sl'); ?>"><?= $key + 1;; ?></td>
                                <td data-label="<?= lang('image'); ?>"><img src="<?= base_url($row['package_thumb']); ?>" alt="" class="order-img"></td>
                                <td data-label="<?= lang('item_name'); ?>">
                                    <?= html_escape($row['package_name']); ?>
                                    <label class="badge badge-info fw_normal"><?= lang('package'); ?></label>

                                </td>

                                <td data-label="<?= lang('qty'); ?>">
                                    <?= html_escape($row['qty']); ?> x <?= currency_position($row['item_price'], $row['shop_id']); ?>
                                </td>
                                <td data-label="<?= lang('total'); ?>"><?= currency_position($row['sub_total'], $row['shop_id']); ?></td>

                            </tr>
                        <?php else : ?>
                            <tr>
                                <td data-label="<?= lang('sl'); ?>"><?= $key + 1;; ?></td>
                                <td data-label="<?= lang('image'); ?>"><img src="<?= base_url($row['item_thumb']); ?>" alt="" class="order-img"></td>
                                <td data-label="<?= lang('item_name'); ?>">
                                    <?= html_escape($row['title']); ?> <?php if (isset($row['veg_type']) && $row['veg_type'] != 0) : ?>
                                        <i class="fa fa-circle veg_type <?= $row['veg_type'] == 1 ? 'c_green' : 'c_red'; ?>" data-placement="top" data-toggle="tooltip" title="<?= lang(veg_type($row['veg_type'])); ?>"></i><?php endif; ?>

                                    <div>
                                        <?php if ($row['is_size'] == 1) : ?>
                                            <label class="label sizeTag">
                                                <?= isset($row['size_slug']) ? variants($row['size_slug'], $row['item_id'], $row['shop_id']) : ''; ?>
                                            </label>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (shop($p->shop_id)->is_tax == 1 && $row['tax_fee'] != 0) : ?>
                                        <p class="tax_status">
                                            <?= tax($row['tax_fee'], shop($p->shop_id)->tax_status); ?></p>
                                    <?php endif ?>
                                    <?php if (isset($row['is_extras']) && $row['is_extras'] == 1) : ?>
                                        <div class="extars">
                                            <?= extraList($row['extra_id'], $row['extra_qty'], $row['item_id'], $row['shop_id']); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td data-label="<?= lang('qty'); ?>"><?= html_escape($row['qty']); ?> x <?= currency_position($row['item_price'], $row['shop_id']); ?>
                                </td>
                                <td data-label="<?= lang('total'); ?>"><?= currency_position($row['sub_total'], $row['shop_id']); ?></td>

                            </tr>
                        <?php endif; ?>

                    <?php endforeach; ?>
                    <tr class="bolder">
                        <td colspan="3" class="colspan-null"></td>
                        <td colspan="2" class="colspan-data">
                            <div class="bottomPrice">
                                <p class="flex-between"><span><?= lang('qty'); ?> </span> <b><?= $p->qty; ?></b></p>
                                <p class="flex-between"><span><?= lang('sub_total'); ?> </span>
                                    <b><?= currency_position($p->subtotal, $p->shop_id); ?> </b>
                                </p>



                                <?php if (!empty($p->tax_details)) : ?>
                                    <?php foreach ($p->tax_details as  $key => $tax) : ?>
                                        <p class="flex-between">
                                            <span><?= lang('tax'); ?> <span class="text-sm">
                                                    <?= tax($tax['percent'], $tax['tax_status']); ?></span> </span>

                                            <b><?= currency_position($tax['total_price'], $shop_id); ?>
                                            </b>
                                        </p>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <?php if ($p->tax_fee != 0) : ?>
                                        <p class="flex-between"><span><?= lang('tax'); ?> (<span class="text-sm"><?= tax($p->tax_percent, shop($shop_id)->tax_status); ?></span>)</span>
                                            <b><?= currency_position($p->tax_fee, $shop_id); ?>
                                            </b>
                                        </p>
                                    <?php endif; ?>
                                <?php endif; ?>




                                <?php if ($p->tips != 0) : ?>
                                    <p class="flex-between"><span><?= lang('tips'); ?> </span>
                                        <b><?= currency_position($p->tips, $p->shop_id); ?> </b>
                                    </p>
                                <?php endif; ?>

                                <?php if ($p->service_charge != 0) : ?>
                                    <p class="flex-between"><span><?= lang('service_charge'); ?> </span>
                                        <b><?= currency_position($p->service_charge, $p->shop_id); ?> </b>
                                    </p>
                                <?php endif; ?>

                                <?php if ($order['order_type'] == 1) : ?>
                                    <p class="flex-between"><span><?= lang('shipping'); ?> </span>
                                        <b><?= currency_position($p->shipping, $p->shop_id); ?> </b>
                                    </p>
                                <?php endif; ?>

                                <?php if ($p->discount != 0) : ?>
                                    <p class="flex-between"><span><?= lang('discount'); ?> </span>
                                        <b><?= currency_position($p->discount, $p->shop_id); ?>
                                        </b>
                                    </p>
                                <?php endif; ?>

                                <?php if ($p->coupon_discount != 0) : ?>
                                    <p class="flex-between"><span><?= lang('coupon_discount'); ?> <small>(<?= $p->coupon_discount; ?>%)</small> </span>
                                        <b><?= currency_position($p->coupon_discount, $p->shop_id); ?>
                                        </b>
                                    </p>
                                <?php endif; ?>

                                <h4 class="fw-bold pt-5 pb-10 fz-16 priceTopBorder flex-between">
                                    <span><?= lang('total'); ?></span>
                                    <span><?= currency_position($p->grand_total, $p->shop_id); ?> </span>
                                </h4>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php if ($order['status'] == 3) : ?>
                <div class="rejectReason">
                    <h5 class="text-danger"><?= lang('reject_reasons'); ?></h5>
                    <?php $reason = get_reject_reson($order['reject_reason']); ?>
                    <?php if (isset($reason->reason_list) && !empty($reason->reason_list)) : ?>
                        <div class="rejectReason_details">
                            <ul>
                                <?php foreach ($reason->reason_list as $rlist) : ?>
                                    <li><?= $rlist->title; ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($reason->reject_msg) && !empty($reason->reject_msg)) : ?>
                        <p><?= $reason->reject_msg; ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-secondary custom_btn"><?= lang('cancel'); ?></button>
            <?php if ($order['order_type'] != 5) : ?>
                <a href="<?= base_url("profile/reorder/{$order['uid']}"); ?>" class="btn btn-primary custom_btn"><i class="fa fa-repeat"></i> <?= lang('order_again'); ?></a>
            <?php endif; ?>
        </div>
    </div>

<?php endforeach; ?>