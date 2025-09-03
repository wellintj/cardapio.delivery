<div class="row">
    <?php $total_item = $total_amount = 0; ?>
    <?php foreach ($order_list as $key => $row) : ?>
        <div class="col-md-3">
            <div class="singleOrder">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> <a href="<?= base_url("admin/restaurant/get_item_list_by_order_id/{$row['uid']}"); ?>">#<?= $row['uid']; ?></a>
                        </h3>

                    </div>
                    <div class="card-body p-0 thumb-card">
                        <div class="customerInfo">
                            <h5 class="infoTitle"><?= lang('customer_info'); ?> :</h5>

                            <?php if ($row['is_guest_login'] == 1) : ?>
                                <p><?= lang('walk_in_customer'); ?></p>
                                <?php if (!empty($row['phone'])) : ?>
                                    <p><?= $row['phone']; ?></p>
                                <?php endif; ?>
                            <?php else : ?>
                                <p><?= html_escape($row['name']); ?></p>
                                <p><?= html_escape($row['phone']); ?></p>
                                <p><?= html_escape($row['address']); ?></p>
                            <?php endif; ?>

                            <?php if ($row['is_pos'] == 1) : ?>
                                <div><label class="label bg-light-purple-soft"><?= lang('pos'); ?></label></div>
                            <?php endif ?>
                        </div><!-- customerInfo -->

                        <div class="orderInfo">
                            <h5 class="infoTitle"><?= lang('order_type'); ?> :</h5>
                            <?php if ($row['order_type'] == 7 && $row['table_no'] != 0) : ?>
                                <label class="label bg-danger-soft"><?= lang('package_restaurant_dine_in'); ?> </label> &nbsp;
                            <?php else : ?>
                                <label class="label bg-primary-soft"><?= order_type($row['order_type']); ?> </label> &nbsp;
                            <?php endif ?>

                            <?php if ($row['order_type'] == 7) : ?>
                                <?php if (!empty($row['table_no']) || $row['table_no'] != 0) : ?>
                                    <label class="label default-light-active" data-toggle="tooltip" title="Table No"><?= lang('table'); ?> : <?= __table($row['table_no'])->area_name; ?> /
                                        <?= __table($row['table_no'])->name; ?></label> &nbsp;

                                    <div class="mt-10">
                                        <label class="label bg-light-purple-soft" data-toggle="tooltip" title="Table No"><?= lang('token_number'); ?> : <?= $row['token_number']; ?></label>
                                        &nbsp;
                                    </div>
                                <?php endif ?>

                            <?php endif; ?>


                            <?php if ($row['order_type'] == 1 || $row['order_type'] == 5) : ?>
                                <div class="mt-5">
                                    <?php if ($row['shipping_id'] != 0) : ?>
                                        <?php $shipping_info = shipping($row['shipping_id'], restaurant()->id) ?>
                                        <label class="label default-light-active"><?= !empty(lang('shipping')) ? lang('shipping') : "Shipping"; ?>
                                            --
                                            <?= $row['delivery_charge'] != 0 ? $shipping_info['area'] . ' : ' . currency_position($shipping_info['cost'], restaurant()->id) : 'Free'; ?>
                                        </label>
                                    <?php else : ?>
                                        <label class="label default-light-active"><?= !empty(lang('shipping')) ? lang('shipping') : "Shipping"; ?>
                                            --
                                            <?= $row['delivery_charge'] != 0 ? currency_position($row['delivery_charge'], restaurant()->id) : 'Free'; ?>
                                        </label>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="mt-2">

                                <?php if ($row['order_type'] == 2) : ?>
                                    <label class="label default-light" data-toggle="tooltip" title="Booking Date"><?= full_time($row['reservation_date'], restaurant()->id); ?></label>
                                    &nbsp;
                                    <label class="label default-light" data-toggle="tooltip" title="Total Person Number"><?= lang('total_person'); ?>:
                                        <?= $row['total_person']; ?></label>
                                <?php endif; ?>

                                <?php if ($row['order_type'] == 4) : ?>
                                    <?php if (isset($row['pickup_date']) && !empty($row['pickup_date'])) : ?>
                                        <label class="label default-light " data-toggle="tooltip" title="<?= lang('pickup_date'); ?>"><?= lang('pickup_date'); ?>:
                                            <?= !empty($row['pickup_date']) ? cl_format($row['pickup_date'], restaurant()->id) : time_format_12($row['reservation_date'], restaurant()->id); ?></label>
                                        &nbsp;
                                    <?php endif; ?>
                                    <div class=" mt-4">
                                        <label class="label bg-light-purple-soft " data-toggle="tooltip" title="Pickup Time"><?= lang('pickup_time'); ?>:
                                            <?= !empty($row['pickup_time']) ? slot_time_format($row['pickup_time'], restaurant()->id) : time_format_12($row['reservation_date'], restaurant()->id); ?></label>
                                        &nbsp;
                                    </div>
                                <?php endif; ?>

                                <?php if ($row['is_payment'] == 1) : ?>
                                    <?php if ($row['is_payment'] == 1) : ?>
                                        <label class="label success-light"><?= lang('paid'); ?></label> &nbsp;
                                        <label class="label default-light" data-toggle="tooltip" title="Payment paid by"><?= lang($row['payment_by']); ?></label> &nbsp;
                                    <?php else : ?>
                                        <label class="label danger-light"><?= lang('rejected'); ?></label>
                                    <?php endif; ?>

                                <?php endif; ?>

                                <?php if ($row['order_type'] == 1 && !empty($row['delivery_payment_method'])) : ?>
                                    <div class="mt-2">
                                        <?php
                                        $payment_methods = [
                                            'cash' => ['icon' => 'cash-delivery.svg', 'label' => lang('cash_on_delivery')],
                                            'credit_card' => ['icon' => 'card-terminal.svg', 'label' => lang('credit_card_on_delivery')],
                                            'debit_card' => ['icon' => 'card-terminal.svg', 'label' => lang('debit_card_on_delivery')],
                                            'pix' => ['icon' => 'pix-delivery.svg', 'label' => lang('pix_on_delivery')]
                                        ];
                                        $method = $payment_methods[$row['delivery_payment_method']] ?? null;
                                        ?>
                                        <?php if ($method) : ?>
                                            <div class="delivery-payment-info">
                                                <img src="<?= base_url('imagens_para_checkout/' . $method['icon']); ?>" alt="<?= $method['label']; ?>" width="16" height="16" style="vertical-align: middle; margin-right: 5px;">
                                                <small><?= $method['label']; ?></small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($row['order_type'] == 6 && !empty($row['table_no'])) : ?>
                                    <div class="mt-10">
                                        <label class="label default-light-active" data-toggle="tooltip" title="Table No"><?= lang('table'); ?> :
                                            <?= __table($row['table_no'])->area_name; ?> /
                                            <?= __table($row['table_no'])->name; ?></label> &nbsp;
                                        <label class="label default-light-active" data-toggle="tooltip" title="Total Person Number"><?= lang('total_person'); ?> :
                                            <?= $row['total_person']; ?></label>
                                    </div>
                                <?php endif; ?>

                                <?php if ($row['order_type'] == 8 && !empty($row['hotel_id'])) : ?>
                                    <div class="mt-10">
                                        <label class="label default-light-active" data-toggle="tooltip"><?= lang('hotel_name'); ?> :
                                            <?= single_select_by_id($row['hotel_id'], 'hotel_list')['hotel_name']; ?></label>
                                        &nbsp;

                                        <label class="label default-light" data-toggle="tooltip"><?= lang('room_number'); ?> :
                                            <?= $row['room_number']; ?></label> &nbsp;
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div><!-- orderInfo -->

                        <div class="oder_info-2">
                            <h5 class="infoTitle"><?= lang('order_details'); ?> :</h5>
                            <?php if ($row['order_type'] == 7) : ?>
                                <label class="label default-light" data-toggle="tooltip" title="Total Price">
                                    <?= lang('price'); ?> : <?= currency_position($row['total'], restaurant()->id); ?> </label>
                                <div class="mt-2">
                                    <label class="label bg-primary-soft" data-toggle="tooltip" title="Order Time">
                                        <?= lang('order_time'); ?> :
                                        <?= full_time(html_escape($row['created_at']), restaurant()->id); ?></label>
                                </div>
                            <?php else : ?>

                                <label class="label default-light" data-toggle="tooltip" title="Total Qty"> <?= lang('qty'); ?>
                                    : <?= $row['total_item']; ?></label>
                                <label class="label default-light-active" data-toggle="tooltip" title="Total Price">
                                    <?= lang('price'); ?> :
                                    <?= currency_position($row['total'], restaurant()->id); ?></label>
                                <div class="mt-2">
                                    <label class="label bg-primary-soft" data-toggle="tooltip" title="Order Time">
                                        <?= lang('order_time'); ?> :
                                        <?= full_time(html_escape($row['created_at']), restaurant()->id); ?></label>
                                </div>
                            <?php endif; ?>
                        </div><!-- oder_info-2 -->

                        <div class="order_info_3 mb-10 mt-10 ml-10">
                            <h5 class="infoTitle"><?= lang('order_status'); ?> :</h5>

                            <?php if ($row['status'] == 0) : ?>
                                <div>
                                    <label class="label danger-light-active mr-10"><?= get_time_ago($row['created_at']); ?></label>

                                    <label class="label danger-light" data-toggle="tooltip" title="Pending order">
                                        <?= lang('pending'); ?> <i class="fa fa-spinner"></i></label>


                                </div>
                            <?php elseif ($row['status'] == 1) : ?>
                                <label class="label info-light" data-toggle="tooltip" title="Accept By Shop"><i class="fa fa-check"></i> <?= lang('accepted'); ?></label>
                                <div class="mt-2">

                                    <?php if ($row['estimate_time'] > d_time()) : ?>
                                        <label class="label default-light">
                                            <?= lang('prepared_time'); ?> : <?= $row['es_time'] . ' ' . lang($row['time_slot']); ?>
                                        </label> &nbsp; &nbsp;
                                        <?php if ($row['status'] == 1 && $row['is_preparing'] == 2) : ?>
                                            <label class="label default-light-active"><?= lang('prepared_finish'); ?></label>
                                        <?php else : ?>
                                            <label class="label default-light-active get_time" id="show_time_<?= $row['id']; ?>" data-time="<?= $row['estimate_time']; ?>" data-id="<?= $row['id']; ?>"></label>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div>
                            <?php elseif ($row['status'] == 2) : ?>
                                <label class="label success-light-active" data-toggle="tooltip" title="Completed Order"><i class="fa fa-check-square-o"></i> <?= lang('completed'); ?></label>

                                <?php if ($row['order_type'] == 1 || $row['order_type'] == 5) : ?>
                                    <div class="deliveryStatus mt-5">
                                        <?php if ($row['dboy_status'] == 1) : ?>
                                            <label class="label default-light-active" data-toggle="tooltip" title="Accept By Delivery Saff"><i class="fa fa-check"></i>
                                                <?= lang('accepted_by_delivery_staff'); ?></label>
                                        <?php elseif ($row['dboy_status'] == 2) : ?>
                                            <label class="label default-light-active" data-toggle="tooltip" title="Picked By Delivery Saff"><i class="fa fa-check"></i>
                                                <?= lang('picked'); ?></label>
                                        <?php elseif ($row['dboy_status'] == 3) : ?>
                                            <label class="label default-light-active" data-toggle="tooltip" title="Completed By Delivery Saff"><i class="fa fa-check"></i>
                                                <?= lang('completed'); ?></label>
                                        <?php endif; ?>
                                    </div>

                                <?php endif; ?>
                            <?php elseif ($row['status'] == 3) : ?>
                                <?php if (is_access('order-cancel') == 1) : ?>
                                    <label class="label danger-light-active" data-toggle="tooltip" title="Order Canceled"><i class="fa fa-ban"></i> <?= lang('canceled'); ?></label>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (!empty($row['customer_rating'])) : ?>
                                <div class="startRating mt-5" title="<?= $row['customer_rating'] . ' ' . lang('stars'); ?>" data-toggle="tooltip">
                                    <?php for ($i = 1; $i <= 5; $i++) { ?>

                                        <span><i class="fa <?= $i <= $row['customer_rating'] ? "fa-star" : "fa-star-o"; ?>"></i></span>

                                    <?php }; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($row['is_order_merge'] == 1) : ?>
                            <div class="mt-5 ml-10">
                                <label class="label default-light-soft-active"><i class="fa fa-exchange"></i>
                                    <?= lang('order_merged'); ?></label>
                            </div>
                        <?php endif ?>

                    </div><!-- card-body -->
                    <div class="card-footer">
                        <?php include 'actionBtn.php'; ?>
                    </div>
                </div><!-- card -->
            </div>
        </div>
        <?php
        $total_amount += (float) $row['total'];
        ?>
    <?php endforeach; ?>
</div>