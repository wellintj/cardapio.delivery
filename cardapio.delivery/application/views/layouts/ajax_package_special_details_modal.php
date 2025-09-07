<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= html_escape($item['package_name']); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body packageModal p-0">
    <div class="single_item">
      <?php if (!empty($item['images'])) : ?>
        <div class="single_items_img hidden">
          <img src="<?= base_url($item['images']); ?>" alt="itemImg">
        </div>
      <?php endif; ?>
      <div class="single_item_details">
        <h4><?= html_escape($item['package_name']); ?></h4>
        <?= __taxStatus(restaurant()->is_tax??0, $item) ?>

        <?php if (shop($item['shop_id'])->stock_status == 1) : ?>

          <?php if (shop($item['shop_id'])->is_stock_count == 1) : ?>
            <?php $remaining = $item['in_stock'] - $item['remaining']; ?>

            <p class="fz-12"><?= lang('availability'); ?> : <?= $item['in_stock'] > $item['remaining'] ? '<span class="in_stock">' . lang('in_stock') . '</span>' . ' (' . $remaining . ')' : '<span class="out_of_stock">' . lang('out_of_stock') . '</span>'; ?></p>
          <?php else : ?>
            <p class="fz-12"><?= lang('availability'); ?> : <?= $item['in_stock'] > $item['remaining'] ? '<span class="in_stock">' . lang('in_stock') . '</span>' : '<span class="out_of_stock">' . lang('out_of_stock') . '</span>' ?></p>
          <?php endif; ?>

        <?php endif; ?>

        <p><b><?= currency_position($item['price'], $item['shop_id']); ?> </b></p>
      </div>
      <div class="item_extra_details">
        <?php if (isset($item['details']) && !empty($item['details'])) : ?>
          <p><?= $item['details']; ?></p>
        <?php else : ?>
          <p><?= $item['overview']; ?></p>
        <?php endif; ?>
      </div>
      <?php if (isset($item['items']) && !empty($item['items'])) : ?>
        <div class="packageItemList">
          <?php foreach ($item['items'] as  $key => $i) : ?>
            <div class="itemList">
              <img src="<?= base_url(!empty($i['item_thumb']) ? $i['item_thumb'] : EMPTY_IMG); ?>" alt="">
              <h4><?= $i['title'] ?? ''; ?></h4>
            </div>
          <?php endforeach; ?>

        </div><!-- packageItemList -->
      <?php endif; ?>
    </div>
  </div>
  <div class="modal-footer text-right">
    <input type="hidden" name="item_id" value="<?= html_escape($item['id']); ?>">
    <input type="hidden" name="item_price" value="<?= html_escape($item['price']); ?>">
    <?php if (shop($item['shop_id'])->is_cart == 1) : ?>
      <?php if (shop($item['shop_id'])->stock_status == 1) : ?>
        <?php if ($item['in_stock'] > $item['remaining']) : ?>
          <button type="button" class="btn btn-primary add_to_cart" data-id="<?= html_escape($item['id']); ?>" data-type="package"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart')) ? lang('add_to_cart') : 'Add Cart'; ?></button>
        <?php endif; ?>
      <?php else : ?>
        <button type="button" class="btn btn-secondary add_to_cart" data-id="<?= html_escape($item['id']); ?>" data-type="package"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart')) ? lang('add_to_cart') : 'Add Cart'; ?></button>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>