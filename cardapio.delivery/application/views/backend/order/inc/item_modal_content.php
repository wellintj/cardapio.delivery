<div class="modal-header">
    <button type="button" class="close closeModal">&times;</button>
    <h4 class="modal-title"><?= lang('items'); ?></h4>
</div>
<div class="modal-body item-modal p-0">
    <div class="table-responsive">
        <div class="searchArea text-right col-md-12">
            <form action="<?= base_url("admin/restaurant/ajax_pagination/{$order_details['uid']}"); ?>" method="POST"
                class="col-md-4 mb-10 pl-0 mt-5 ajaxSearch">
                <?= csrf(); ?>
                <div class="input-group">
                    <input type="text" name="q" class="form-control h-i" placeholder="<?= lang('search'); ?>"
                        value="<?= isset($_REQUEST['q']) && !empty($_REQUEST['q']) ? $_REQUEST['q'] : ''; ?>">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="ajaxItemForm">
            <div class="row">
                <?php foreach ($all_items as $key2 => $items): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="singleItemWrapper">
                            <form action="<?= base_url('admin/restaurant/add_order_item/' . $order_details['uid'] . '/' . $items['id']); ?>"
                                method="post" autocomplete="off" class="addToCart_From">
                                <?= csrf(); ?>
                                <div class="singleItems">
                                    <div class="itemImage">
                                        <img src="<?= get_img($items['item_thumb'], $items['img_url'], $items['img_type']); ?>" alt="" class="order-img" />
                                    </div>
                                    <div class="itemInfo">
                                        <div class="itemName">
                                            <h4><?= $items['title']; ?></h4>
                                            <?= __taxStatus(restaurant()->is_tax, $items); ?>
                                        </div>
                                        <div class="itemPrice">
                                            <?php if ($items['is_size'] == 1): ?>
                                                <div class="singleSize">
                                                    <?php $price = json_decode($items['price'], TRUE); ?>


                                                    <?php if (isset($price['variant_name']) && !empty($price['variant_name'])): ?>
                                                        <?php foreach ($price['variant_options'] as $key => $value): ?>
                                                            <label class="label bg-light-purple-soft custom-radio-2"><input type="radio"
                                                                    class="size_price" onclick="add_price(<?= $value['price']; ?>,<?= $key2; ?>)"
                                                                    name="size_slug" value="<?= $value['slug']; ?>" required>
                                                                <?= $value['name']; ?>
                                                                <?= currency_position($value['price'], $_ENV["ID"]); ?>

                                                            </label>
                                                        <?php endforeach; ?>

                                                    <?php else: ?>
                                                        <?php $p = 1;
                                                        foreach ($price as $key => $value):
                                                            if (!empty($value)):
                                                        ?>
                                                                <label class="label bg-light-purple-soft custom-radio-2"><input type="radio"
                                                                        class="size_price" onclick="add_price(<?= $value; ?>,<?= $key2; ?>)" name="size_slug"
                                                                        value="<?= $key; ?>" required />
                                                                    <?= $this->admin_m->get_size_info_by_slug($key, $items['shop_id'])['title']; ?> :
                                                                    <span>
                                                                        <?= currency_position(html_escape($value), restaurant()->id); ?>
                                                                    </span>

                                                                </label>

                                                        <?php
                                                            endif;
                                                            $p++;
                                                        endforeach;
                                                        ?>


                                                    <?php endif; ?>
                                                    <input type="hidden" name="item_price" class="item_price_<?= $key2; ?>" value="0">
                                                </div>
                                                <input type="hidden" name="is_size" value="1">
                                            <?php else: ?>
                                                <input type="hidden" name="is_size" value="0">
                                                <input type="hidden" name="item_price" value="<?= $items['price']; ?>">

                                                <?= currency_position(html_escape($items['price']), restaurant()->id); ?>

                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="buttonInfo space-between gap-10 mt-10">
                                        <input type="number" name="qty" value="1" min="1" class="form-control w_100p" />
                                        <button type="submit" class="addtocartBtn btn btn-primary btn-block"><i
                                                class="fa fa-shopping-cart"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </div>

</div>
<div class="modal-footer">
    <span class="reg_msg text-left"></span>
    <div class="text-right">
        <div id="pagination">
            <?= $this->pagination->create_links();; ?>
        </div>

        <button type="button" class="btn btn-info closeModal"><?= lang('close'); ?></button>
    </div>
</div>


<style>
    .itemImage {
        max-height: 165px;
        height: 165px;
    }

    .item-modal {
        max-height: 50dvh;
        overflow-y: scroll;
    }

    .itemImage img {
        height: 100%;
        width: 100%;
    }

    .singleItems {
        box-shadow: 0 0 5px var(--box-shadow);
        padding: 5px;
        margin-bottom: 20px;
    }

    .itemInfo {
        margin-top: 7px;
    }

    .itemPrice {
        margin-top: 10px;
        font-weight: bold;
    }

    .w_100p {
        width: 100px !important;
    }

    .singleSize {
        flex-wrap: nowrap;
        overflow-y: auto;
    }

    .singleItemWrapper {
        min-height: 335px;
    }
</style>


<script>
    $(document).on('click', '.closeModal', function() {
        window.location.reload();
    });
</script>