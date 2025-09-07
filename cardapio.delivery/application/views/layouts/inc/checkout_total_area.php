<?php $shop_info = $this->common_m->shop_info($shop_id); ?>
<?php
if ($shop_info['is_area_delivery'] == 1) :
    if (isset($cost) && $cost != 0) :
        $shipping = $cost;
    else :
        $shipping = 0;
    endif;

else :
    $shipping = $shop_info['delivery_charge_in'];
endif;

if (isset($coupon_price)) {
    $coupon_price = $coupon_price;
} else {
    $coupon_price = 0;
}

if (isset($tips) && !empty($tips)) {
    $tips = $tips;
} else {
    $tips = 0;
}


?>

<?php
$tax_fee = 0;
$taxDetails = [];
foreach ($this->cart->contents() as $key => $row) :
    if (!empty($row['tax_fee'])) :
        $taxDetails[] = [
            'percent' => $row['tax_fee'] ?? 0,
            'price' => __taxCalc($row['price'], $row['tax_fee'] ?? 0, $row['tax_status'] ?? '+'),
            'tax_status' => $row['tax_status'] ?? '',
            'qty' => $row['qty'],
        ];
    endif;
endforeach;

if ($shop_info['is_tax'] == 1) :
    $tax_fee = __tax($taxDetails)->total_tax_price;
    $grandSubTotal = $this->cart->total() - $tax_fee;
    $tax_status = '+';
else :
    $grandSubTotal =  $this->cart->total();
    $tax_fee = __taxCalc($grandSubTotal, $shop_info['tax_fee'], $shop_info['tax_status']);
    
    $tax_percent = $shop_info['tax_fee'] ?? 0;
    $tax_status = $shop_info['tax_status'] ?? '+';
    if(tax_type() =='seperate'){
        $grandSubTotal;
    }else{
       $grandSubTotal = $shop_info['tax_status'] == '+' ? $this->cart->total() - $tax_fee : $grandSubTotal;
   }
endif;





if (isset($is_service_charge) && $is_service_charge == 1) :
    $service_charges = __service_charge($grandSubTotal, $shop_id);
    if (isset($service_charges->price) && !empty($service_charges->price)) {
        $service_charge = $service_charges->price;
    } else {
        $service_charge = 0;
    }
else :
    $service_charge = 0;
endif;


if ($shop_info['discount'] != 0) :
    $discount = get_percent($grandSubTotal, $shop_info['discount']);
else :
    $discount = 0;
endif;

$get_total = get_total($grandSubTotal, $shipping, $discount, $tax_fee, $coupon_price, $tips, $tax_status, $service_charge);

?>


<div class="row">
    <div class="col-lg-12 col-sm-12">
        <div class="upperSum">
            <div class="flex justify-between">
                <p><?= !empty(lang('qty')) ? lang('qty') : 'Qty'; ?> :</p> <span class="cart_count"><?= $this->cart->total_items(); ?></span>
            </div>
            <div class="flex justify-between">
                <p><?= !empty(lang('sub_total')) ? lang('sub_total') : 'sub_total'; ?> : </p> <span> <span class="total_price"><?= currency_position($grandSubTotal, $shop_id); ?></span>
            </div>



            <div class="dis_none <?= $shop_info['is_area_delivery'] == 1 ? "showShipping" : "show_address"; ?> ">
                <?php if ($shipping != 0) : ?>
                    <div class="flex justify-between">
                        <p><?= !empty(lang('shipping')) ? lang('shipping') : 'Shipping'; ?> : </p><span class="d_charge"><?= currency_position($shipping, $shop_id); ?></span>
                    </div>
                <?php else : ?>
                    <div class="flex justify-between">
                        <p><?= !empty(lang('shipping')) ? lang('shipping') : 'Shipping'; ?> : </p><span class="d_charge"><?= !empty(lang('Free')) ? lang('Free') : 'Free'; ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="discount_tax">

                <?php if ($shop_info['is_tax'] == 1) : ?>
                    <?php foreach (__tax($taxDetails)->details as  $key => $tax) : ?>

                        <div class="flex justify-between">
                            <p><?= lang('tax'); ?> <span class="text-sm"> <?= tax($tax['percent'], $tax['tax_status']); ?>
                        </span> : </p> <span class="d_charge"><?= currency_position($tax['total_price'], $shop_id); ?></span>
                    </div>

                <?php endforeach; ?>

            <?php else : ?>

                <?php if ($tax_fee != 0) : ?>

                    <div class="flex justify-between">
                        <p><?= lang('tax'); ?> <span class="text-sm">( <?= tax($tax_percent, $tax_status); ?> )</span> : </p> <span class="d_charge">
                            <?= currency_position($tax_fee, $shop_id); ?></span>
                        </div>
                    <?php else : ?>
                        <?php $tax_fee = 0; ?>
                    <?php endif; ?>

                <?php endif; ?>


                <?php if ($shop_info['discount'] != 0) : ?>
                    <?php $discount = get_percent($grandSubTotal, $shop_info['discount']); ?>
                    <div class="flex justify-between">
                        <p><?= !empty(lang('discount')) ? lang('discount') : 'Discount'; ?> : </p> <span class="d_charge"><?= currency_position($discount, $shop_id); ?></span>
                    </div>
                <?php else : ?>
                    <?php $discount = 0; ?>
                <?php endif; ?>
            </div>


            <div class="couponPricearea " style="display:none;">
                <div class="flex justify-between">
                    <p><?= !empty(lang('coupon_discount')) ? lang('coupon_discount') : 'coupon_discount'; ?> : </p><span class="coupon_price"><?= currency_position($coupon_price, $shop_id); ?></span>
                </div>
            </div>

            <?php if ($tips != 0) : ?>
                <div class="tips">
                    <div class="flex justify-between">
                        <p><?= !empty(lang('tip')) ? lang('tip') : 'tip'; ?> : </p><span class="tip_price"><?= currency_position($tips, $shop_id); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($service_charge != 0) : ?>
                <div class="tips serviceCharge dis_none">
                    <div class="flex justify-between">
                        <p><?= !empty(lang('service_charge')) ? lang('service_charge') : 'service_charge'; ?>
                        <?= $service_charges->details; ?> : </p><span class="tip_price"><?= currency_position($service_charge, $shop_id); ?></span>
                    </div>
                </div>
            <?php endif; ?>


        </div>


        <?php if ($shop_info['is_area_delivery'] == 1) : ?>

            <div class="dis_none <?= $shop_info['is_area_delivery'] == 1 ? "showShipping" : "show_address"; ?>">
                <div class="flex justify-between ">
                    <h4 class=""><?= !empty(lang('total')) ? lang('total') : 'total'; ?> : </h4>
                    <h4 class="">
                        <?= currency_position($get_total, $shop_id); ?>
                    </h4>
                </div>
            </div>
            <div class="show_price">
                <div class="flex justify-between">
                    <h4 class=""><?= !empty(lang('total')) ? lang('total') : 'total'; ?> : </h4>
                    <h4 class="">
                        <?= currency_position($get_total, $shop_id); ?>
                    </h4>
                </div>
            </div>
        <?php else : ?>

            <div class="dis_none <?= $shop_info['is_area_delivery'] == 1 ? "showShipping" : "show_address"; ?>">
                <div class="flex justify-between ">
                    <h4 class=""><?= !empty(lang('total')) ? lang('total') : 'total'; ?> : </h4>
                    <h4 class="">
                        <?= currency_position($get_total, $shop_id); ?>
                    </h4>
                </div>
            </div>

            <?php if ($shop_info['is_area_delivery'] == 0 && $shipping != 0) : ?>
                <div class="show_price defaultshipping">
                    <div class="flex justify-between">
                        <h4 class=""><?= !empty(lang('total')) ? lang('total') : 'total'; ?> : </h4>
                        <h4 class="">
                            <?= currency_position(($get_total - $shipping), $shop_id); ?>
                        </h4>
                    </div>
                </div>
            <?php else : ?>
                <div class="show_price defaultshipping">
                    <div class="flex justify-between">
                        <h4 class=""><?= !empty(lang('total')) ? lang('total') : 'total'; ?> : </h4>
                        <h4 class="">
                            <?= currency_position($get_total, $shop_id); ?>
                        </h4>
                    </div>
                </div>
            <?php endif ?>
        <?php endif; ?>

    </div><!-- col-md-6 -->
</div><!-- row -->