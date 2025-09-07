<?php $item = (object) $item; ?>
<link rel="stylesheet" href="<?= asset_url('public/frontend/css/item.css'); ?>?t=<?= time(); ?>">
<form action="<?= base_url('profile/add_to_cart_form'); ?>" method="post" class="cart_form" id="cart_form">
    <?= csrf(); ?>
    <div class="modal-body p-0">
        <div class="singleItem">
            <div class="itemHeader <?= is_image($item->shop_id); ?>">
                <?php if (is_image($item->shop_id) == 0) : ?>
                    <div class="itemImg ">
                        <?php if (!empty($item->extra_images)) : ?>
                            <div class="itemSlider opacity_height_0">
                                <?php foreach (json_decode($item->extra_images, TRUE) as $key => $row) : ?>
                                    <div class="single_item_slider">
                                        <div class="item__slider">
                                            <img src="<?= base_url($row['image']); ?>" alt="item_img">
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php else : ?>
                            <img src="<?= get_img($item->images, $item->img_url, $item->img_type); ?>" alt="item_img">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div><!-- itemHeader -->
            <div class="singleItemContent">
                <div class="itemTitle">
                    <h4>
                        <?= html_escape($item->title); ?>
                        <?php if (isset($item->veg_type) && $item->veg_type != 0) : ?> <i class="fa fa-circle veg_type <?= $item->veg_type == 1 ? 'c_green' : 'c_red'; ?>" data-placement="top" data-toggle="tooltip" title="<?= lang(veg_type($item->veg_type)); ?>"></i><?php endif; ?>
                    </h4>

                    <?php if ($shop_info->is_tax == 1 && !empty($item->tax_fee)) : ?>
                        <p class="tax_status"><?= tax($item->tax_fee, $item->tax_status); ?></p>
                    <?php endif; ?>

                    <!-- check stock status -->
                    <?php if ($shop_info->stock_status == 1) : ?>
                        <?php if ($shop_info->is_stock_count == 1) : ?>
                            <?php $remaining = $item->in_stock - $item->remaining; ?>

                            <p class="fz-12 stock_counter"><?= lang('availability'); ?> :
                                <?= $item->in_stock > $item->remaining ? '<span class="in_stock">' . lang('in_stock') . '</span>' . ' (' . $remaining . ')' : '<span class="out_of_stock">' . lang('out_of_stock') . '</span>'; ?>
                            </p>
                        <?php else : ?>
                            <p class="fz-12 stock_counter"><?= lang('availability'); ?> :
                                <?= $item->in_stock > $item->remaining ? '<span class="in_stock">' . lang('in_stock') . '</span>' : '<span class="out_of_stock">' . lang('out_of_stock') . '</span>' ?>
                            </p>
                        <?php endif; ?>

                    <?php endif; ?>
                    <!-- check stock status -->

                    <!-- price without sizes -->
                    <?php if ($item->is_size == 0) : ?>
                        <div class="itemVariants mt-10">
                            <label class="variant-btn active"> <input type="radio" name="item_size" data-price="<?= __numberFormat($item->price, $shop_id) ?>" data-size="" data-size-title="" value="<?= __numberFormat($item->price, $shop_id) ?>" checked>
                                <span class="displayPrice"> <?= currency_position($item->price, $shop_id) ?></span></label>
                            </div>
                        <?php endif; ?>
                        <!-- price without sizes -->

                        <!-- price with sizes -->
                        <?php if (isset($item->is_size) && $item->is_size == 1) : ?>
                            <div class="itemVariantArea">
                                <?php $price = isJson($item->price) ? json_decode($item->price) : ''; ?>
                                <?php if (isset($price->variant_name) && !empty($price->variant_name)) : ?>
                                <p class="variantTags mt-10"><?= $price->variant_name ?? ''; ?></p>
                                <div class="itemVariants">
                                    <?php foreach ($price->variant_options as $key => $value) : ?>
                                        <?php if (!empty($value)) : ?>
                                            <label class="variant-btn <?= $key == 0 ? "active" : ''; ?>">
                                                <input type="radio" name="item_size" data-price="<?= $value->price; ?>" data-size="<?= $value->slug; ?>" data-size-title="<?= $value->name; ?>" value="<?= $value->slug; ?>" <?= $key == 0 ? "checked" : ''; ?>>
                                                <?= $value->name; ?>
                                            </label>
                                        <?php endif; ?>
                                    <?php endforeach;  ?>
                                </div>
                                <input type="hidden" name="is_variants" value="1">
                            <?php else : ?>

                                <div class="mt-10 itemVariants ">
                                    <?php foreach ($price as $key => $value) : ?>
                                        <?php if (!empty($value)) : ?>
                                            <label class="variant-btn <?= $key == 0 ? "active" : ''; ?>">
                                                <?= $this->admin_m->get_size_by_slug($key, $item->user_id); ?>
                                                <input type="radio" name="item_size" data-price="<?= $value; ?>" data-size="<?= $this->admin_m->get_size_info_by_slug($key, $shop_id)['slug']; ?>" data-size-title="<?= $this->admin_m->get_size_info_by_slug($key, $shop_id)['title']; ?>" value="<?= $this->admin_m->get_size_info_by_slug($key, $shop_id)['slug']; ?>" <?= $key == 0 ? "checked" : ''; ?>>
                                            </label>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <input type="hidden" name="is_variants" value="1">
                                <?php endif; ?> <!-- check variant price -->

                            </div><!-- itemVariantArea -->
                        <?php endif; ?>
                        <!-- price with sizes -->
                    </div>
                    <div class="item_extra_details">
                        <?php if (isset($item->details) && !empty($item->details)) : ?>
                        <p><?= $item->details; ?></p>
                    <?php else : ?>
                        <p><?= $item->overview ?? ''; ?></p>
                    <?php endif; ?>
                    <p class="capital allergen pt-5">
                        <?php if (isJson($item->allergen_id)) : ?>
                            <span><b><?= lang('allergens'); ?></b>:
                                <?= is_array(json_decode($item->allergen_id)) ? allergens(json_decode($item->allergen_id)) : ""; ?>
                            </span>
                        <?php endif; ?>
                    </p>
                    <?php if (isset($extrasList) && sizeof($extrasList) > 0) : ?>
                    <?php foreach ($extrasList as  $ex_key => $ex) : ?>
                        <div class="item_extra_list <?= $ex->is_required == 1 ? "required required-section" : "" ?>" data-limit="<?= $ex->select_limit == 0 ? 1 : $ex->select_limit; ?>">

                            <div class="extraTopHeading mb-5">
                                <div class="extraHeadingTop">
                                    <h5 class="extrasHeading"><?= $ex->title; ?>
                                    <small>
                                        <?php if ($ex->is_required == 1) : ?>
                                            <span class="error">*</span> (<?= __('required') ?>)
                                        <?php else : ?>
                                            (<?= __('optional') ?>)
                                        <?php endif; ?>
                                    </small>
                                </h5>
                                <?php if ($ex->is_required == 1 && $ex->select_limit > 1) : ?>
                                    <small class="text-muted"> <span class="error">*</span>
                                        <?= __('select_minimum') ?> <?= $ex->select_limit == 0 ? 1 : $ex->select_limit; ?> <?= __('options'); ?>
                                    </small>

                                <?php endif; ?>
                            </div>
                            <p class="errorMessage"></p>
                        </div>

                        <ul class="extraUl">
                            <?php foreach ($ex->extras as $ex_key2 => $extra) : ?>
                                <?php if (!empty($extra)) : ?>
                                    <?php if ($ex->is_single_select == 1) : ?>
                                        <li>
                                            <label class="custom-radio-2">
                                                <p><input type="radio" name="extras[]" class="extras" data-name="<?= html_escape($extra->ex_name); ?>" data-id="<?= $extra->id; ?>" data-item="<?= $extra->item_id; ?>" data-price="<?= $extra->ex_price; ?>" value="<?= $extra->id; ?>"> <span class="mr-30"><?= html_escape($extra->ex_name); ?></span> &nbsp; </p>
                                                <?php if ($extra->ex_price != 0) : ?>
                                                    <span class="left_bold">
                                                        <?= currency_position($extra->ex_price, $extra->shop_id); ?></span>
                                                    <?php endif ?>
                                                </label>
                                            </li>
                                        <?php else : ?>
                                            <li>
                                                <label class="custom-checkbox extraLabel">
                                                    <div class="increaseDecrease">
                                                     <a href="javascript:;">-</a>
                                                     <input type="text" name="extra_qty" class="extraQty" value="1" min="1">
                                                     <a href="javascript:;">+</a>
                                                 </div>
                                                 <p><input type="checkbox" name="extras[]" class="extras" data-name="<?= html_escape($extra->ex_name); ?>" data-id="<?= $extra->id; ?>" data-item="<?= $extra->item_id; ?>" data-price="<?= $extra->ex_price; ?>" value="<?= $extra->id; ?>"> <span class="mr-30"><?= html_escape($extra->ex_name); ?></span> &nbsp; </p>
                                                 <?php if ($extra->ex_price != 0) : ?>
                                                    <span class="left_bold">
                                                        <?= currency_position($extra->ex_price, $extra->shop_id); ?></span>
                                                    <?php endif ?>
                                                </label>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if (isset($shop_info->is_cart) && $shop_info->is_cart == 1) : ?>
            <div class="form-group col-md-12 p-10 itemComments">
                <label><?= lang('comments'); ?></label>
                <textarea name="item_comments" id="item_comments" class="form-control" cols="0" rows="2"></textarea>
            </div>
        <?php endif; ?>
    </div><!-- singleItem -->
</div><!-- modal-body -->
<?php if (isset($shop_info->is_cart) && $shop_info->is_cart == 1) : ?>
    <?php
    if (isset($shop_info->stock_status) && $shop_info->stock_status == 1) :
        if ($item->in_stock > $item->remaining) :
            $isActive = 1;
        else :
            $isActive = 0;
        endif;
    else :
        $isActive = 1;
    endif;
    ?>
    <?php if (isset($isActive) && $isActive == 1) : ?>
        <div class="modal-footer">
            <div class="modalFooterArea">
                <div class="modalIncreateArea">
                    <span class="decrease"> - </span> <input type="number" class="qty" name="qty" value="1" min-value="1" readonly><span class="increase">+</span>
                </div>
                <div class="addToCartbutton">
                    <input type="hidden" name="item_id" value="<?= $item->id; ?>">
                    <input type="hidden" name="price" value="<?= $item->is_size == 0 ? $item->price : 0; ?>">
                    <input type="hidden" name="shop_id" value="<?= $shop_id; ?>">
                    <button type="submit" class="btn btn-primary addToCartBtn add_to_cart_form hidden">
                        <?= !empty(lang('add_to_cart')) ? lang('add_to_cart') : 'Add Cart'; ?> <span class="displayPrice"><?= wh_currency_position($item->price, $shop_id) ?></span></button>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="modal-footer text-right">
                <div class="modalFooterArea text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close'); ?></button>
                    <div class="addToCartbutton">
                        <button type="button" class="btn btn-danger"><?= lang('out_of_stock'); ?> </button>
                    </div>
                </div>
            </div>
            <?php endif; ?> <!-- isActive -->
            <?php endif; ?><!-- $shop_info->is_cart -->
        </form>


        <script>
            $(document).ready(function() {

                $('.modalIncreateArea').on('click', '.increase, .decrease', function() {
                    var qty = $(this).closest('.modalIncreateArea').find('[name="qty"]'),
                    currentVal = parseInt(qty.val()),
                    isAdd = $(this).hasClass('increase');
                    if (currentVal != 0) {
                        !isNaN(currentVal) && qty.val(
                            isAdd ? currentVal + 1 : (currentVal > 1 ? currentVal - 1 : currentVal)
                            )

                        updatePrice();
                    }
                });



                if ($('[name="item_size"]').is(':checked')) {
                    updatePrice();
                }

                $('[name="item_size"]').change(function() {
                    $('.variant-btn').removeClass('active');
                    $(this).closest('.variant-btn').addClass('active');
                    $('.addToCartBtn').removeClass('hidden');
                    updatePrice();
                });



                $('input[name="extras[]"]').change(function() {
                    updatePrice();
                });

                updatePrice();

                function updatePrice() {
                    var sizePrice = $('[name="item_size"]:checked').data('price');

                    let quantity = $('[name="qty"]').val();

                    var toppings = $('input[name="extras[]"]:checked').map(function() {
                        return parseFloat($(this).data('price'));
                    }).get();


                    var basePrice = currencyFormat(sizePrice);
                    var toppingsPrice = calculateToppingsPrice(toppings);
                    var total = parseInt(quantity) * (parseFloat(basePrice) + parseFloat(toppingsPrice));
                    $('[name="price"]').val(total);
                    $('.displayPrice').text(showPrice(total));
                    if(total > 0){
                        $('.addToCartBtn').removeClass('hidden');
                    }
                }

                function calculateToppingsPrice(toppings) {
                    return toppings.reduce(function(accumulator, currentValue) {
                        return accumulator + currentValue;
                    }, 0);
                }
            });
        </script>