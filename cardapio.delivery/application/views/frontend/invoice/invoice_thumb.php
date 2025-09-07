<div class="row mt-4">
    <div class="col-12 col-lg-12">
        <div class="d-flex space-between sm-column-reverse">
            <div class="flex-1">
                <div class="printLeft <?= direction() == 'rtl'?"text-right":"";?>" style="width: 100%;">
                    <h4><?= lang('order_id'); ?> #<?= $order_info['uid']; ?> </h4>
                    <?php if ($order_info['is_payment'] == 1) : ?>
                        <span class="badge badge-success"><?= lang('paid'); ?></span>
                    <?php else : ?>
                        <span class="badge badge-danger"><?= lang('unpaid'); ?></span>
                    <?php endif; ?>

                    &nbsp; <small class="text-muted"><?= full_time($order_info['created_at']); ?></small><br />
                    <small class="text-muted"><?= lang('order_type'); ?>:
                        <?= order_type($order_info['order_type']); ?>
                        <?php if ($order_info['order_type'] == 4) : ?>
                            ,
                            <?= cl_format(!empty($order_info['pickup_date']) ? $order_info['pickup_date'] : $order_info['created_at']); ?>
                            : <?= slot_time_format($order_info['pickup_time'], $shop_id); ?>
                        <?php endif; ?>
                    </small>

                    <?php if (isset($order_info['table_no']) && !empty($order_info['table_no'])) : ?>
                        <small class="text-muted">
                            &nbsp; <?= lang('table'); ?> :
                            <?= __table($order_info['table_no'])->area_name; ?> /
                            <?= __table($order_info['table_no'])->name; ?>
                        </small>
                    <?php endif; ?>

                    <?php if (isset($order_info['order_type']) && $order_info['order_type'] == 8) : ?>
                        <?php if (isset($order_info['hotel_id']) && !empty($order_info['hotel_id'])) : ?>
                            <p class="ml-0">
                                <small class="text-muted">
                                    <?= lang('hotel_name') ?> :
                                    <b><?= single_select_by_id($order_info['hotel_id'], 'hotel_list')['hotel_name'];; ?></b>
                                    &nbsp;
                                    <?= lang('room_number') ?> : <b><?= $order_info['room_number'] ?></b>
                                </small>
                            </p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="right sm-mb-15">
                <div class="orderQr <?= direction() == 'rtl'?"text-left":"";?>">
                    <?php if (!empty($order_info['qr_link'])) : ?>
                        <img src="<?= base_url($order_info['qr_link']); ?>" alt="">
                    <?php endif ?>
                </div>
            </div>

        </div>
        <hr />
        <div class="row">
            <div class="col-sm-6">
                <div class="customerInfo">
                    <p class="text-muted">
                        <b><?= !empty(lang('customer_info')) ? lang('customer_info') : "Customer Info"; ?></b>
                    </p>
                    <?php if ($order_info['order_type'] == 7) : ?>
                        <p><?= lang('walk_in_customer'); ?></p>
                    <?php else : ?>

                        <?php if ($order_info['is_guest_login'] == 1) : ?>
                            <p><b><?= lang('walk_in_customer'); ?></b></p>
                        <?php else : ?>

                            <h3><?= $order_info['name']; ?></h3>
                            <p><?= lang('phone'); ?> : <?= $order_info['phone']; ?></p>
                            <?php if (!empty($order_info['address'])) : ?>
                                <p><?= lang('address'); ?> : <?= $order_info['address']; ?></p>
                            <?php endif; ?>
                            <?php if ($order_info['order_type'] == 1) : ?>
                                <?php $shpping_info = $this->common_m->delivery_area_by_shop_id($order_info['shipping_id'], $shop_id); ?>
                                <?php if (isset($shpping_info['area']) && !empty($shpping_info['area'])) : ?>
                                    <p><?= lang('delivery_area'); ?> : <span style="color:rebeccapurple;"><?= $shpping_info['area']; ?></span></p>
                                <?php endif; ?>
                                <?php if (!empty($order_info['delivery_area'])) : ?>
                                    <p><?= lang('shipping_address'); ?> : <span style="color: purple;"><?= $order_info['delivery_area']; ?></span></p>
                                <?php endif; ?>
                            <?php endif; ?>
                            <!-- order_type -->
                        <?php endif; ?>
                        <!-- is_guest_login -->
                    <?php endif; ?>
                </div>
            </div>
            <!-- /.col -->

            <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">

                <div class="customerInfo">
                    <h2><?= !empty($shop->name) ? $shop->name : $shop->username; ?></h2>
                    <p>
                        <?= lang('phone'); ?> : <?= !empty($shop->phone) ? $shop->phone : ""; ?>
                        <br />
                        <?= lang('email'); ?> : <?= !empty($shop->email) ? $shop->email : ""; ?>
                        <br />
                        <?php if (!empty($shop->address)) : ?>
                            <?= lang('address'); ?> : <?= !empty($shop->address) ? $shop->address : ""; ?>
                            <br />
                        <?php endif; ?>
                        <?php if (isset($shop->tax_number) && !empty($shop->tax_number)) : ?>
                            <?= lang('tax_number'); ?> : <?= !empty($shop->tax_number) ? $shop->tax_number : ""; ?>
                            <br />
                        <?php endif; ?>
                    </p>
                </div>


            </div>
            <!-- /.col -->
        </div>

        <div class="mt-4">

            <div class="table-responsive responsiveTable">
                <?php if ($order_info['order_type'] == 7) : ?>
                    <?php $get_dinein_items = $this->admin_m->get_dinin_items($order_info['dine_id']); ?>
                    <table class="table customTable invoiceTable" id="example1">
                        <thead>
                            <tr class="text-600 text-white bgc-default-tp1 py-25">
                                <th>#</th>
                                <th><?= lang('name'); ?></th>
                                <th><?= lang('items'); ?></th>
                                <th><?= lang('qty'); ?></th>
                                <th><?= !empty(lang('unit_price')) ? lang('unit_price') : "Unit Price"; ?></th>
                                <th><?= !empty(lang('amount')) ? lang('amount') : "Amount"; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($get_dinein_items as $key => $package) : ?>
                                <tr>
                                    <td data-label="#" ><?= $key + 1; ?></td>
                                    <td data-label="<?= __("name");?>" ><?= $package['package_name']; ?></td>
                                    <td data-label="<?= __("items");?>" >
                                        <ul class="p-0">
                                            <?php foreach ($package['all_items'] as $key => $item) : ?>
                                                <li class="space-between"><span>1 x <?= $item['title']; ?> </span>
                                                    <span><?= currency_position($item['item_price'], $shop_id); ?></span>
                                                </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </td>
                                    <td data-label="<?= __("qty");?>" >1</td>
                                    <td data-label="<?= __("unit_price");?>" ><?= currency_position($order_info['total'], $shop_id); ?></td>
                                    <td data-label="<?= __("amount");?>" ><?= currency_position($order_info['total'], $shop_id); ?></td>

                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="4">
                                    <?php if ($order_info['use_payment'] == 1 && !empty($order_info['payment_by'])) : ?>
                                        <p><?= lang('digital_payment'); ?>
                                            (<b><?= lang($order_info['payment_by']); ?></b>)</p>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <p><?= lang('sub_total'); ?></p>

                                    <p><b><?= lang('total'); ?></b></p>
                                </td>
                                <td>
                                    <p><b><?= currency_position($order_info['total'], $shop_id); ?></b></p>

                                    <p><b><?= currency_position($order_info['total'], $shop_id); ?></b></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                <?php else : ?>

                    <table class="table customTable invoiceTable" id="example1">
                        <thead>
                            <tr class="text-600 text-white bgc-default-tp1 py-25">
                                <th>#</th>
                                <th><?= lang('name'); ?></th>
                                <th><?= lang('qty'); ?></th>
                                <th><?= !empty(lang('unit_price')) ? lang('unit_price') : "Unit Price"; ?></th>
                                <th><?= !empty(lang('amount')) ? lang('amount') : "Amount"; ?></th>
                            </tr>
                        </thead>


                        <tbody>


                            <?php $p = __order($order_info, $item_list); ?>

                            <?php foreach ($item_list as $key => $row) : ?>
                                <tr>
                                    <td data-label="#"><?= $key + 1; ?></td>
                                    <td data-label="<?= __("name");?>">
                                        <p><?= $row['is_package'] == 1 ? $row['package_name'] : $row['name']; ?>

                                            <?php if ($row['is_size'] == 1) : ?>
                                                <span class="badge sizeTag"><?= variants($row['size_slug'], $row['item_id'], $row['shop_id']); ?></span>
                                            <?php endif; ?>
                                        </p>
                                        <?= __taxStatus(shop($shop_id)->is_tax, $row); ?>

                                        <?php if (isset($row['is_extras']) && $row['is_extras'] == 1) : ?>
                                            <div class="extars">
                                                <?= extraList($row['extra_id'], $row['extra_qty'], $row['item_id'], $shop_id); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($row['item_comments']) && !empty($row['item_comments'])) : ?>
                                            <?php if (isset(pos_config($shop_id)->is_comments) && pos_config($shop_id)->is_comments == 1) : ?>
                                                <p style="margin-top:5px; color:#777; width:60%;"><?= $row['item_comments']; ?></p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="<?= __("qty");?>"><?= $row['qty']; ?></td>
                                    <td data-label="<?= __("unit_price");?>"><?= currency_position($row['item_price'], $shop_id); ?> </td>
                                    <td data-label="<?= __("price");?>"><?= currency_position($row['item_price'] * $row['qty'], $shop_id); ?></td>
                                </tr>
                            <?php endforeach ?>


                            <tr>
                                <td colspan="3">
                                    <?php if ($order_info['use_payment'] == 1 && !empty($order_info['payment_by'])) : ?>
                                        <p><?= lang('digital_payment'); ?>
                                            (<b><?= lang($order_info['payment_by']); ?></b>)</p>
                                    <?php endif; ?>
                                </td>


                                <td>
                                    <p><?= lang('sub_total'); ?></p>
                                    <p><?= lang('shipping'); ?></p>
                                    <?php if (!empty($p->tax_details)) : ?>
                                        <?php foreach ($p->tax_details as  $key => $tax) : ?>
                                            <p><?= lang('tax'); ?> <span class="text-sm"><?= tax($tax['percent'], $tax['tax_status']); ?></span>
                                            </p>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <?php if ($p->tax_fee != 0) : ?>
                                            <p><?= lang('tax'); ?></p>
                                        <?php endif ?>
                                    <?php endif; ?>

                                    <?php if ($p->tips != 0) : ?>
                                        <p><?= lang('tips'); ?></p>
                                    <?php endif ?>

                                    <?php if ($p->discount != 0) : ?>
                                        <p><?= lang('discount'); ?></p>
                                    <?php endif ?>

                                    <?php if ($p->coupon_percent != 0) : ?>
                                        <p><?= lang('coupon_discount'); ?> <small> (<?= $p->coupon_percent ?>%)</small></p>
                                    <?php endif ?>

                                    <?php if ($p->service_charge != 0) : ?>
                                        <p><?= lang('service_charge'); ?></p>
                                    <?php endif ?>

                                    <p><b><?= lang('total'); ?></b></p>
                                </td>
                                <td>
                                    <p><b><?= currency_position($p->subtotal, $shop_id); ?></b></p>

                                    <p><?= $p->shipping == 0 ? currency_position(0, $shop_id) : currency_position($p->shipping, $shop_id); ?>
                                    </p>



                                    <?php if (!empty($p->tax_details)) : ?>
                                        <?php foreach ($p->tax_details as  $key => $tax) : ?>
                                            <p><?= currency_position($tax['total_price'], $shop_id); ?> </p>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <?php if ($p->tax_fee != 0) : ?>
                                            <p><?= currency_position($p->tax_fee, $shop_id); ?> </p>
                                        <?php endif ?>
                                    <?php endif; ?>

                                    <?php if ($p->tips != 0) : ?>
                                        <p><?= currency_position($p->tips, $shop_id); ?> </p>
                                    <?php endif; ?>

                                    <?php if ($p->discount != 0) : ?>
                                        <p><?= currency_position($p->discount, $shop_id); ?> </p>
                                    <?php endif; ?>

                                    <?php if ($p->coupon_discount != 0) : ?>
                                        <p><?= currency_position($p->coupon_discount, $shop_id); ?> </p>
                                    <?php endif; ?>
                                    <?php if ($p->service_charge != 0) : ?>
                                        <p><?= currency_position($p->service_charge, $shop_id); ?> </p>
                                    <?php endif; ?>

                                    <p><b><?= currency_position($p->grand_total, $shop_id); ?></b> </p>
                                </td>
                            </tr>
                        </tbody>
                        <?php if (isset($order_info['comments']) && !empty($order_info['comments'])) : ?>
                            <?php if (isset(pos_config($shop_id)->is_comments) && pos_config($shop_id)->is_comments == 1) : ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="5"> <?= $order_info['comments'] ?></td>
                                    </tr>
                                </tfoot>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif ?>
                    </table>
            </div>
        </div>
    </div>
</div>