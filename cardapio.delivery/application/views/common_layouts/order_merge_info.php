<div class="orderMergeInfo">
    <?php include VIEWPATH . 'common_layouts/ordered_item_list.php'; ?>

    <div class='mergeInfo mt-10 mb-20'>
        <p><b><?= __('previous_order'); ?></b></p>
        <p><?= __('order_id'); ?> : <b class="ml-10"> #<?= $order['uid']; ?></b></p>

        <div class="summary mt-10">
            <ul>
                <li>
                    <span><?= lang('previous_total') ?> :</span>
                    <span><?= $previous_total ?></span>
                </li>
                <li>
                    <span><?= lang('current_total') ?> :</span>
                    <span><?= $current_total ?></span>
                </li>

                <li>
                    <span><?= lang('merged_total') ?> :</span>
                    <span><?= $merged_total ?></span>
                </li>
            </ul>
        </div>
    </div>
</div>