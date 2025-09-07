  <a href="<?= !empty(lang('please_select_at_least')) ? lang('please_select_at_least') : 'Please select at least'; ?>" id="select_at_least"></a>
  <a href="<?= !empty(lang('options')) ? lang('options') : 'option(s)'; ?>" id="options"></a>
  <link rel="stylesheet" href="<?= asset_url('public/frontend/css/item.css'); ?>?t=<?= time(); ?>">
  <form action="<?= $url ?? ''; ?>" method="post" class="<?= $class ?? ''; ?>" id="<?= $class ?? ''; ?>">
    <?= csrf(); ?>
    <div class="modal-body p-0">
      <div class="singleItem">
        <div class="itemHeader <?= is_image($item->shop_id); ?>">
          <?php if (is_image($item->shop_id) == 0) : ?>
            <div class="itemImg ">
              <?php $extra_img = isset($item->extra_images) && isJson($item->extra_images)?json_decode($item->extra_images,TRUE):''; ?>
              <?php if (!empty($extra_img)) : ?>
                <div class="opacity_height_1">
                  <div class="single_item_slider">
                    <div class="item__slider">
                      <img src="<?= img_loader(); ?>" class="slideImage img_loader" alt="item_img" data-src="<?= get_img($item->images, $item->img_url, $item->img_type); ?>">
                    </div>
                  </div>
                  <div class="sliderImgThumb">
                    <ul>
                      <li class="Sliderthumb active" data-img="<?= get_img($item->images, $item->img_url, $item->img_type); ?>"><img src="<?= get_img($item->images, $item->img_url, $item->img_type); ?>" alt="item image"></li>
                      <?php foreach ($extra_img as $key => $row) : ?>
                        <li class="Sliderthumb" data-img="<?= base_url($row['image']) ?>"><img src="<?= base_url($row['thumb']) ?>" alt="sliderImg"></li>
                      <?php endforeach ?>
                    </ul>
                  </div>
                </div>
              <?php else : ?>
                <img src="<?= img_loader(); ?>" class="img_loader" alt="item_img" data-src="<?= get_img($item->images, $item->img_url, $item->img_type); ?>">
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
                <label class="variant-btn active"> <input type="radio" name="item_size" data-price="<?= __discount(__numberFormat($item->price, $shop_id), $discount_offer ?? 0); ?>" data-size="" data-size-title="" value="<?= __discount(__numberFormat($item->price, $shop_id), $discount_offer ?? 0,) ?>" checked>

                  <?= __price((array)$item, $shop_id, 'variantPrice', $discount_offer ?? 0) ?>
                </label>
              </div>
            <?php endif; ?>
            <!-- price without sizes -->

            <!-- price with sizes -->
            <?php if (isset($item->is_size) && $item->is_size == 1) : ?>
              <div class="itemVariantArea">
                <?php $price = isJson($item->price) ? json_decode($item->price) : ''; ?>
                <?php if (isset($price->variant_name) && !empty($price->variant_name)) : ?>
                <p class="variantTags mt-10"><?= $price->variant_name ?? ''; ?> <b class="variantPrice"></b></p>
                <div class="itemVariants">
                  <?php foreach ($price->variant_options as $key => $value) : ?>
                    <?php if (!empty($value)) : ?>
                      <label class="variant-btn <?= $key == 0 ? "active" : ''; ?>">
                        <input type="radio" name="item_size" data-price="<?= __discount($value->price, $discount_offer ?? 0); ?>" data-size="<?= $value->slug; ?>" data-size-title="<?= $value->name; ?>" value="<?= $value->slug; ?>" <?= $key == 0 ? "checked" : ''; ?>>
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
                        <input type="radio" name="item_size" data-price="<?= __discount($value, $discount_offer ?? 0); ?>" data-size="<?= $this->admin_m->get_size_info_by_slug($key, $shop_id)['slug']; ?>" data-size-title="<?= $this->admin_m->get_size_info_by_slug($key, $shop_id)['title']; ?>" value="<?= $this->admin_m->get_size_info_by_slug($key, $shop_id)['slug']; ?>" <?= $key == 0 ? "checked" : ''; ?>>
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

            <!-- =========== 
        Allergen Area
       ========================== -->
       <?php $others = __others($shop_id); ?>

       <?php if (isset($others->is_allergen_image) && $others->is_allergen_image == 1) : ?>
        <?php $allerges = isJson($item->allergen_id) ? allergens(json_decode($item->allergen_id), true) : ""; ?>
        <?php if (!empty($allerges) && sizeof($allerges) > 0) : ?>
        <div class="allergenArea">
          <p class="mt-10 mb-5"><b><?= lang('allergens'); ?></b></p>
          <ul class="allergenImage">
            <?php foreach ($allerges as  $key => $al) : ?>
              <li><img src="<?= get_img($al['thumb'], '', 1) ?>" alt="allergen image"> <?= $al['name'] ?? '' ?></li>
            <?php endforeach; ?>

          </ul>
        </div>
      <?php endif; ?>
    <?php else : ?>
      <p class="capital allergen pt-5">
        <?php if (isJson($item->allergen_id)) : ?>
          <span><b><?= lang('allergens'); ?></b>:
            <b><?= is_array(json_decode($item->allergen_id)) ? allergens(json_decode($item->allergen_id)) : ""; ?></b>
          </span>
        <?php endif; ?>
      </p>
    <?php endif; ?>

            <!-- =========== 
        Allergen Area
       ========================== -->
       <?php if (isset($extrasList) && sizeof($extrasList) > 0) : ?>
       <?php foreach ($extrasList as  $ex_key => $ex) : ?>
        <div class="item_extra_list <?= $ex->is_required == 1 ? "required required-section" : "" ?>" data-limit="<?= $ex->select_limit == 0 ? 1 : $ex->select_limit; ?>" data-max-select="<?= $ex->select_max_limit == 0 ? 1000 : $ex->select_max_limit; ?>" data-max-qty=<?= $ex->max_qty == 0 ? 1000 : $ex->max_qty; ?>>

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
                <?= __('select_minimum') ?> <?= $ex->select_limit == 0 ? "<b>1</b>" : "<b>" . $ex->select_limit . "</b>"; ?> <?= __('options'); ?>

                <?php if ($ex->select_max_limit != 0) : ?>
                  & <?= __('max') ?> <?= $ex->select_max_limit != 0 ? "<b>" . $ex->select_max_limit . "</b>"  : ''; ?> <?= __('options'); ?>
                <?php endif; ?>

              </small>

            <?php endif; ?>
          </div>
          <p class="errorMessage"></p>
        </div>

        <ul class="extraUl">
          <?php foreach ($ex->extras as $ex_key2 => $extra) : ?>
            <?php if (!empty($extra)) : ?>
              <?php if ($ex->is_single_select == 1) : ?>
                <li class="extraLabel" data-section="<?= $ex_key; ?>">
                  <label class="custom-checkbox">
                    <div class="increaseDecrease">
                      <a href="javascript:;" class="minusExtra">-</a>
                      <input type="text" name="extra_qty[<?= $extra->id; ?>]" class="extraQty prevent-default" value="0" min="0">
                      <a href="javascript:;" class="plusExtra">+</a>
                    </div>
                  </label>
                  <label class="custom-radio-2 checkBoxArea">
                    <p>
                      <span class="checkboxSection">
                        <input type="radio" name="extras[<?= $ex_key; ?>]" class="extras" data-name="<?= html_escape($extra->ex_name); ?>" data-id="<?= $extra->id; ?>" data-item="<?= $extra->item_id; ?>" data-price="<?= $extra->ex_price; ?>" value="<?= $extra->id; ?>">
                      </span>
                      <span class="mr-30"><?= html_escape($extra->ex_name); ?></span> &nbsp;
                    </p>
                    <?php if ($extra->ex_price != 0) : ?>
                      <span class="left_bold">
                        <?= currency_position($extra->ex_price, $extra->shop_id); ?></span>
                      <?php endif ?>
                    </label>
                  </li>
                <?php else : ?>
                  <li class="extraLabel" data-section="<?= $ex_key; ?>">
                    <label class="custom-checkbox">
                      <div class="increaseDecrease">
                        <a href="javascript:;" class="minusExtra">-</a>
                        <input type="text" name="extra_qty[<?= $extra->id; ?>]" class="extraQty prevent-default" value="0" min="0">
                        <a href="javascript:;" class="plusExtra">+</a>
                      </div>
                    </label>
                    <label class="custom-checkbox checkBoxArea">

                      <p>
                        <span class="checkboxSection">
                          <input type="checkbox" name="extras[<?= $ex_key; ?>]" class="extras" data-name="<?= html_escape($extra->ex_name); ?>" data-id="<?= $extra->id; ?>" data-item="<?= $extra->item_id; ?>" data-price="<?= $extra->ex_price; ?>" value="<?= $extra->id; ?>">
                        </span>

                        <span class="mr-30"><?= html_escape($extra->ex_name); ?></span> &nbsp;
                      </p>
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
      <?php else : ?>
        <!-- old extra -->
        <?php if (isset($extras) && sizeof($extras) > 0) : ?>
        <div class="item_extra_list " data-limit="1" data-max-select="1000">
          <h5 class="extrasHeading"><?= !empty(lang('extras')) ? lang('extras') : 'Extras'; ?></h5>
          <div class="extraTopHeading mb-5">
            <div class="extraHeadingTop">
              <h5 class="extrasHeading"><?= __('optional'); ?>
            </h5>
          </div>
          <p class="errorMessage"></p>
        </div>
        <ul class="extraUl">

          <?php foreach ($extras as $key => $extra) : ?>
            <?php if (!empty($extra)) : ?>
              <li class="extraLabel" data-section="<?= $key; ?>">
                <label class="custom-checkbox">
                  <div class="increaseDecrease">
                    <a href="javascript:;" class="minusExtra">-</a>
                    <input type="text" name="extra_qty[<?= $extra['id']; ?>]" class="extraQty prevent-default" value="0" min="0">
                    <a href="javascript:;" class="plusExtra">+</a>
                  </div>
                </label>
                <label class="custom-checkbox checkBoxArea">

                  <p>
                    <span class="checkboxSection">
                      <input type="checkbox" name="extras[<?= $key; ?>]" class="extras" data-name="<?= html_escape($extra['ex_name']); ?>" data-id="<?= $extra['id']; ?>" data-item="<?= $extra['item_id']; ?>" data-price="<?= $extra['ex_price']; ?>" value="<?= $extra['id']; ?>">
                    </span>

                    <span class="mr-30"><?= html_escape($extra['ex_name']); ?></span> &nbsp;
                  </p>
                  <?php if ($extra['ex_price'] != 0) : ?>
                    <span class="left_bold">
                      <?= currency_position($extra['ex_price'], $extra['shop_id']); ?></span>
                    <?php endif ?>
                  </label>
                </li>

              <?php endif; ?>
            <?php endforeach ?>
          </ul>
        </div>
      <?php endif; ?>

      <!-- end old extra -->
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
          <input type="hidden" name="item_price" value="<?= $item->is_size == 0 ? __discount($item->price, $discount_offer ?? 0) : 0; ?>">
          <input type="hidden" name="price" value="<?= $item->is_size == 0 ? __discount($item->price, $discount_offer ?? 0) : 0; ?>">
          <input type="hidden" name="shop_id" value="<?= $shop_id; ?>">
          <input type="hidden" name="discount_offer" value="<?= $discount_offer ?? 0; ?>">
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

      // Event handler for radio buttons change
        $('input[type="radio"][name^="extras["]').change(function() {
          var extraLabel = $(this).closest('.extraLabel');
          var exqty = extraLabel.find('[name^="extra_qty["]');

          var section = extraLabel.data('section');

        // Uncheck other radio buttons within the same section
          var prevSelected = $('input[type="radio"][name^="extras[' + section + ']"]').not(this).prop('checked', false);
          if (prevSelected.length > 0) {
            prevSelected.prop('checked', false);
            prevSelected.closest('.extraLabel').find('.checkboxSection').show();
            prevSelected.closest('.extraLabel').find('.increaseDecrease').hide();
            prevSelected.closest('.extraLabel').find('[name^="extra_qty["]').val(0);
          }
          if ($(this).prop('checked')) {
            extraLabel.find('.increaseDecrease').show();
            extraLabel.find('.checkboxSection').hide();
            exqty.val(1);
          } else {
          // Show/hide elements based on the section
            extraLabel.find('.increaseDecrease').hide();
            extraLabel.find('.checkboxSection').show();
            exqty.val(0);
          }

        // Update the price for this specific extra item
          updateExtraPrice(extraLabel);

        // Update the total price
          updatePrice();
        });

      // Initial setup
        $('input[name^="extras["]').each(function() {
          var extraLabel = $(this).closest('.extraLabel');
          var exqty = extraLabel.find('[name^="extra_qty["]');

        // Check initial state of extra_qty
          if (parseInt(exqty.val()) === 0) {
            extraLabel.find('.increaseDecrease').hide();
          } else {
            extraLabel.find('.checkboxSection').hide();
          }
        });


      // Event handler for checkbox change
        $('input[name^="extras["]').change(function() {
          var extraLabel = $(this).closest('.extraLabel');
          var exqty = extraLabel.find('[name^="extra_qty["]');


          var itemExtraList = $(this).closest('.item_extra_list');
          var maxLimitInSection = itemExtraList.data('max-select');
          var checkedInSection = $('input[name^="extras["]', itemExtraList).filter(':checked');



          if (checkedInSection.length > maxLimitInSection) {
            $(this).prop('checked', false);
          }


          if ($(this).prop('checked')) {
          // Checkbox is checked, show increaseDecrease and hide checkboxSection
            extraLabel.find('.increaseDecrease').show();
            extraLabel.find('.checkboxSection').hide();

          // Set extra_qty to 1 when the checkbox is checked
            exqty.val(1);
          } else {
          // Checkbox is unchecked, hide increaseDecrease and show checkboxSection
            extraLabel.find('.increaseDecrease').hide();
            extraLabel.find('.checkboxSection').show();
          exqty.val(0); // Reset extra_qty to 0 when unchecked
        }

        // Update the price for this specific extra item
        updateExtraPrice(extraLabel);

        // Update the total price
        updatePrice();
      });



        $('.extraUl').on('click', '.plusExtra, .minusExtra', function() {
          var extraLabel = $(this).closest('.extraLabel');
          var exqty = extraLabel.find('[name^="extra_qty["]');
          var checkbox = extraLabel.find('input[name^="extras["]');
          var isExAdd = $(this).hasClass('plusExtra');

          var itemExtraList = extraLabel.closest('.item_extra_list');
          var maxLimitInSection = itemExtraList.data('max-select');
          var maxQtyInSection = itemExtraList.data('max-qty');

          if (isExAdd && parseInt(exqty.val()) < maxQtyInSection) {
            exqty.val(parseInt(exqty.val()) + 1);
          } else if (!isExAdd && parseInt(exqty.val()) > 0) {
            exqty.val(parseInt(exqty.val()) - 1);
          }



          updateExtraPrice(extraLabel);

        // Update the total price
          updatePrice();


          if (parseInt(exqty.val()) === 0) {
            extraLabel.find('.increaseDecrease').hide();
            extraLabel.find('.checkboxSection').show();

          // Uncheck the extras[] checkbox when extra_qty becomes 0
            checkbox.prop('checked', false);
          } else {
            extraLabel.find('.increaseDecrease').show();
            extraLabel.find('.checkboxSection').hide();
          }
        });


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
          updateItemPrice();
        }

        $('[name="item_size"]').change(function() {
          $('.variant-btn').removeClass('active');
          $(this).closest('.variant-btn').addClass('active');
          $('.addToCartBtn').removeClass('hidden');
          updatePrice();
          updateItemPrice();
        });



        $('input[name^="extras["]').change(function() {
          updatePrice();
        });






        updatePrice();

      // show size price
        function updateItemPrice() {
          let itemPrice = $('[name="item_size"]:checked').data('price');
          $('[name="item_price"]').val(itemPrice);
          $('.variantPrice').text(showPrice(itemPrice));
        }

        function updatePrice() {
          var sizePrice = $('[name="item_size"]:checked').data('price');

          let quantity = $('[name="qty"]').val();

          var toppings = $('input[name^="extras["]:checked').map(function() {
            var extraQty = $(this).closest('.extraLabel').find('[name^="extra_qty["]').val() ?? 1;
            return parseInt(extraQty) * parseFloat($(this).data('price'));
          }).get();


          var basePrice = currencyFormat(sizePrice);
          var toppingsPrice = calculateToppingsPrice(toppings);
          var total = parseInt(quantity) * (parseFloat(basePrice) + parseFloat(toppingsPrice));
          $('[name="price"]').val(total);
          $('.displayPrice').text(showPrice(total));
          if (total > 0) {
            $('.addToCartBtn').removeClass('hidden');
          }
        }

        function calculateToppingsPrice(toppings) {
          return toppings.reduce(function(accumulator, currentValue) {
            return accumulator + currentValue;
          }, 0);
        }



        function updateExtraPrice(extraLabel) {
          var extraQty = extraLabel.find('[name^="extra_qty["]').val();
          var extraPrice = parseFloat(extraLabel.find('input[name^="extras["]:checked').data('price'));

          var extraTotalPrice = parseInt(extraQty) * extraPrice;

        // Update the price display for this specific extra item
          extraLabel.find('.extraPrice').text(showPrice(extraTotalPrice));
        }


      });


  $(document).on('click', '.Sliderthumb', function(e) {
    e.preventDefault();
    var img = $(this).data('img');
    $('.Sliderthumb').removeClass('active');
    $('.slideImage').attr('src', img);
    $(this).addClass('active');

  });




  $('.img_loader').each(function() {
    var lazy = $(this);
    var src = lazy.data('src');
    lazy.attr('src', src);
    $('.img_loader').removeClass('.bg_loader');

  });

</script>