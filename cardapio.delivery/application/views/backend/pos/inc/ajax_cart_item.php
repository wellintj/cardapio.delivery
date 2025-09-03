<div class="cartItemList">
    <?php $shop_info = shop(restaurant()->id); ?>
    <?php $subtotal = $total = 0; ?>
    <?php $i = 1;
    foreach ($this->cart->contents() as $key => $row) : ?>
        <?php if (isset($row['is_pos']) && $row['is_pos'] == 1) : ?>
            <?php
            $item = $this->admin_m->single_select_by_id($row['item_id'], 'items');
            if (!empty($item['tax_fee'])) :
                $taxDetails[] = [
                    'percent' => $item['tax_fee'],
                    'price' => __taxCalc($row['price'], $item['tax_fee'], $item['tax_status']),
                    'tax_status' => $item['tax_status'],
                    'qty' => $row['qty'] ?? 1,
                ];
            else :
                $taxDetails[] = [];
            endif;



            $i_info = order_info();

            if (isset($i_info['is_item_tax']) && $i_info['is_item_tax'] == 1) :
                $tax_fee = __tax($taxDetails)->total_tax_price;
                $price = $this->cart->total() - $tax_fee;
                $is_item_tax = 1;
                $tax_status = '+';
            else :
                if (isset($i_info['tax_fee']) && !empty($i_info['tax_fee'])) :
                    $tax_fee = $i_info['tax_fee'];
                    $price = $i_info['sub_total'];
                    $is_item_tax = 0;
                    $tax_status = !empty($i_info['tax_status']) ? $i_info['tax_status'] : '+';

                endif;
            endif;


            if (isset($shop_info->is_tax) && $shop_info->is_tax == 1) :
                $tax_fee = __tax($taxDetails)->total_tax_price;
                $price = $this->cart->total() - $tax_fee;
                $is_item_tax = 1;
                $tax_status = '+';
            else :
                $price = $this->cart->total();
                $tax_fee = __taxCalc($price, $shop_info->tax_fee, $shop_info->tax_status);
                $is_item_tax = 0;
                $tax_status = $shop_info->tax_status;
                $price = $tax_status == '+' ? $price - $tax_fee : $price;
                if (tax_type() == 'seperate') {
                    $price = $price;
                } else {
                    $price = $tax_status == '+' ? $price - $tax_fee : $price;
                }
            endif;


            $price_without_tax = $this->cart->total();
            $subtotal = $price;


            if (!empty(cart('discount'))) :
                $discount = cart('discount');
            else :
                if (isset($i_info['discount']) && !empty($i_info['discount'])) {
                    $discount = get_percent($subtotal, $i_info['discount'], $i_info['is_pos']);
                } else {
                    $discount = 0;
                };
            endif;


            if (!empty(cart('shipping'))) :
                $shipping = cart('shipping');
            else :

                if (isset($i_info['delivery_charge']) && !empty($i_info['delivery_charge'])) {
                    $shipping = $i_info['delivery_charge'];
                } else {
                    $shipping = 0;
                }
            endif;


            if (!empty(cart('coupon')->coupon_discount)) :
                $get_percent = get_percent($subtotal, cart('coupon')->coupon_discount);
                $coupon_discount = $get_percent;
                $coupon_percent = cart('coupon')->coupon_discount;
                $coupon_id = cart('coupon')->coupon_id;
            else :
                if (isset($i_info['is_coupon']) && !empty($i_info['coupon_percent'])) {
                    $coupon_discount =  get_percent($subtotal, $i_info['coupon_percent']);
                    $coupon_percent = $i_info['coupon_percent'];
                    $coupon_id = $i_info['coupon_id'];
                } else {

                    $coupon_discount = 0;
                };
            endif;


            if (!empty(cart('service_charge'))) :
                $service_charge = cart('service_charge');
            else :
                if (isset($i_info['service_charge']) && !empty($i_info['service_charge'])) {
                    $service_charge = $i_info['service_charge'];
                } else {
                    $service_charge = 0;
                }
            endif;





            if (isset($i_info['tips']) && !empty($i_info['tips'])) {
                $tips = $i_info['tips'];
            } else {
                $tips = 0;
            }



            $grandTotal = get_total(
                $subtotal,
                $shipping,
                $discount,
                $tax_fee,
                $coupon_discount,
                $tips,
                $tax_status,
                $service_charge
            );
            ?>
            <div class="singleCartContent">
                <div class="cartItems">
                    <div class="itemThumb">
                        <img src="<?= get_img($row['thumb'], $row['img_url'], $row['img_type']); ?>" alt="item_img">
                    </div>
                    <div class="cartitemDetails">
                        <div class="itemLeftDetails">
                            <h4><?= html_escape($row['name']); ?>
                                <?php if ($shop_info->is_tax == 1) : ?>
                                    <p class="tax_status mt-4"><?= tax($row['tax_fee'], $row['tax_status']); ?></p>
                                <?php endif; ?>
                            </h4>
                            <?php if ((isset($row['is_variants']) && $row['is_variants'] == 1) && (isset($row['sizes']['size_slug']) && !empty($row['sizes']['size_slug']))) : ?>
                                <?php $item_size = item_size($row['sizes']['size_slug'], $row['item_id'], $row['shop_id']); ?>
                                <div class="posSize">
                                    <p><?= isset($item_size) && !empty($item_size) ? $item_size->variant_name . ': ' . $item_size->name : ''; ?></p>
                                </div>
                            <?php endif; ?>
                            <div class="incress_area">
                                <span class="value-button minus default-light" data-id="<?= $row['rowid']; ?>" value="Decrease Value">-</span>

                                <span class="cart_qty_field"><input readonly type="number" id="qty_<?= $row['rowid']; ?>" class="qty" value="<?= $row['qty']; ?>" min-value='1' /></span>

                                <span class="value-button add default-light" data-id="<?= $row['rowid']; ?>" value="Increase Value">+</span>
                            </div>

                        </div><!-- itemLeftDetails -->

                        <div class="itemPriceArea">
                            <a href="javascript:;" class="remove_item danger-light" data-id="<?= $row['rowid']; ?>">&#10006;</a>
                            <?php if ((isset($row['is_variants']) && $row['is_variants'] == 1) && (isset($row['sizes']['size_slug']) && !empty($row['sizes']['size_slug']))): ?>
                                <?php $item_size = item_size($row['sizes']['size_slug'], $row['item_id'], $row['shop_id']); ?>
                                <p class="subTotalTag">
                                    <?= isset($item_size) && !empty($item_size) ? $item_size->variant_name . ': ' . $item_size->name : ''; ?>
                                </p>
                            <?php else : ?>
                                <?php if (isset($row['extras']['is_extra']) && $row['extras']['is_extra'] == 1) : ?>
                                    <p class="subTotalTag"><?= currency_position(($row['qty'] * $row['extra_price']), $shop_info->id); ?>
                                    </p>
                                <?php else : ?>
                                    <p class="subTotalTag"><?= currency_position(($row['qty'] * $row['item_price']), $shop_info->id); ?></p>
                                <?php endif; ?>

                            <?php endif ?>

                        </div>

                    </div><!-- itemDetails -->
                </div><!-- cartItems -->
                <?php if (isset($row['is_extras']) && $row['is_extras'] == 1 && !empty($row['extra_qty'])) : ?>
                    <div class="extras_size_area">
                        <ul>
                            <?php foreach (json_decode($row['extra_qty']) as $ex) : ?>
                                <?php
                                $ex_qty = $ex->ex_qty;
                                $ex_info = extras($ex->extra_id, $row['item_id']);
                                $ex_name = $ex_info->ex_name ?? '';
                                $ex_price = $ex_info->ex_price ?? 0;
                                ?>
                                <li><span><?= $ex_qty . ' x ' . $ex_name; ?></span>
                                    <span><?= currency_position(($row['qty'] * $ex_price), $row['shop_id']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div><!-- extras_size_area -->
                    <div class="extraWithPrice">
                        <span><b><?= currency_position(($row['qty'] * $row['price']), $shop_info->id); ?></b></span>
                    </div>
                <?php endif ?>
            </div>
        <?php endif; ?>
        <!-- check pos == 1 -->
    <?php $i++;
    endforeach; ?>
</div>


<?php if ($this->cart->total_items() > 0) : ?>
    <div class="cartOrderInfo">
        <div class="cartPriceArea">
            <div class="subTotalInfo bb_1">
                <p><span><?= lang('sub_total'); ?> (<?= $this->cart->total_items(); ?> <?= lang('items'); ?>)</span> <span>
                        <?= currency_position($subtotal, $shop_info->id); ?></span></p>

                <?php if (!empty($shipping)) : ?>
                    <p><span><?= lang('shipping'); ?></span> <span><?= currency_position($shipping, $shop_info->id); ?></span>
                    </p>
                <?php endif ?>

                <?php if (isset($is_item_tax) && $is_item_tax == 1) : ?>
                    <?php foreach (__tax($taxDetails)->details as  $key => $tax) : ?>
                        <p><span><?= lang('tax'); ?> (<span class="text-sm"> <?= tax($tax['percent'], $tax['tax_status']); ?>
                                </span>)</span>
                            <span><?= currency_position($tax['total_price'], $shop_info->id); ?></span>
                        </p>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php if (isset($tax_fee) && $tax_fee != 0) : ?>
                        <p><span><?= lang('tax_fee'); ?> (<?= tax($shop_info->tax_fee, $shop_info->tax_status); ?>)</span>
                            <span><?= currency_position($tax_fee, $shop_info->id); ?></span>
                        </p>
                    <?php endif ?>
                <?php endif; ?>

                <?php if (isset($tips) && !empty($tips)) : ?>
                    <p><span><?= lang('tips'); ?></span>
                        <span><?= currency_position($tips, $shop_info->id); ?></span>
                    </p>
                <?php endif ?>

                <?php if (isset($service_charge) && !empty($service_charge)) : ?>
                    <p><span><?= lang('service_charge'); ?></span>
                        <span><?= currency_position($service_charge, $shop_info->id); ?></span>
                    </p>
                <?php endif ?>


                <?php if (isset($discount)) : ?>
                    <p><span><?= lang('discount'); ?></span> <span><?= currency_position($discount, $shop_info->id); ?></span>
                    </p>
                <?php endif ?>


                <?php if (!empty($coupon_discount)) : ?>
                    <p><span><?= lang('coupon_discount'); ?> (<?= $coupon_percent; ?>%)</span>
                        <span><?= currency_position($coupon_discount, $shop_info->id); ?></span>
                    </p>
                <?php endif ?>
            </div>

            <div class="subTotalInfo">
                <p><span><?= lang('total'); ?></span> <span><?= currency_position($grandTotal ?? 0, $shop_info->id); ?></span>
                </p>
            </div>
        </div><!-- cartPriceArea -->
        <div class="cartActionArea">
            <ul>
                <li><a href="#couponModal" <?= empty(auth('is_order_edit')) ? 'data-toggle="modal"' : ""; ?>> <span><i class="icofont-tag"></i>
                            <?= !empty($coupon_discount) ?  currency_position($coupon_discount, $shop_info->id) : ""; ?>
                            <?= !empty($coupon_percent) ? "(" . $coupon_percent . "%)" : ''; ?></span>
                        <span><?= lang('coupon'); ?></span></a></li>

                <li><a href="#discountModal" data-toggle="modal"><span><i class="icofont-dollar-minus"></i>
                            <?= !empty($discount) ? currency_position($discount, $shop_info->id) : ""; ?></span>
                        <span><?= lang('discount'); ?></span></a></li>


                <li><a href="#serviceModal" <?= empty(auth('is_order_edit')) ? 'data-toggle="modal"' : ""; ?>><span><i class="icofont-fast-delivery"></i><?= !empty($service_charge) ? currency_position($service_charge, $shop_info->id) : "";; ?></span>
                        <span> <?= lang('service_charge'); ?></span></a></li>

                <li class="hidden"><a href="#shippingModal" <?= empty(auth('is_order_edit')) ? 'data-toggle="modal"' : ""; ?>><span><i class="icofont-fast-delivery"></i><?= !empty($shipping) ? currency_position($shipping, $shop_info->id) : "";; ?></span>
                        <span> <?= lang('shipping'); ?></span></a></li>
            </ul>
        </div>
    </div>
<?php endif ?>