
<div class="zReports" id="printArea">
    <div class="allReportsDetails">
        <?php if (sizeof($xreport['item_list']) > 0) : ?>
            <div class="singleReport">
                <div class='table-responsive'>
                    <table class='table table-striped'>
                        <thead>
                            <tr class="title">
                                <th>
                                    <h4 class="fw_bold"><?= lang('order_list'); ?></h4>
                                </th>
                                <th>
                                    <?= lang('date'); ?> : <?= !empty($this->input->get('daterange',TRUE)) ? $this->input->get('daterange',TRUE) : full_date(today()); ?>
                                </th>
                            </tr>
                            <tr class="tableHeader">
                                <th min-width="3%">#</th>
                                <th><?= lang('order_id'); ?></th>
                                <th><?= lang('order_type'); ?></th>
                                <th><?= lang('payment_by'); ?></th>
                                <th><?= lang('amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $grand_qty = $grand_price = 0; ?>
                            <?php foreach ($xreport['order_details'] as  $key => $row) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= $row->uid; ?></td>
                                    <td><?= order_type($row->order_type); ?></td>
                                    <td><?= !empty($row->payment_by)?lang($row->payment_by):lang('cash'); ?></td>
                                    <td><?= currency_position($row->sub_total, $shop_id); ?></td>
                                </tr>
                                <?php
                                    $grand_price += $row->sub_total;
                                ?>
                            <?php endforeach; ?>

                            <tr class="tableFooter">
                                <th colspan="3"></th>
                                <th><?= lang('sub_total'); ?></th>
                                <th><?= currency_position($grand_price, $shop_id); ?></th>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><?= lang('tax');?> </td>
                                <td><?= currency_position($report->tax,$shop_id) ;?></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><?= lang('shipping');?> </td>
                                <td><?= currency_position($report->shipping,$shop_id) ;?></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><?= lang('tips');?> </td>
                                <td><?= currency_position($report->tips,$shop_id) ;?></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><?= lang('service_charge');?> </td>
                                <td><?= currency_position($report->service_charge,$shop_id) ;?></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><?= lang('discount');?> (-) </td>
                                <td><?= currency_position($report->discount,$shop_id) ;?></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><?= lang('coupon_discount');?> (-) </td>
                                <td><?= currency_position($report->coupon_discount,$shop_id) ;?></td>
                            </tr>
                            <tr class="fw_bold">
                                <td colspan="3"></td>
                                <td><?= lang('grand_total');?> </td>
                                <td><?= currency_position($report->grand_total,$shop_id) ;?></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        <?php endif; ?>
        
        
        <?php if (sizeof($xreport['item_list']) > 0) : ?>
            <div class="singleReport">
                <div class='table-responsive'>
                    <table class='table table-striped'>
                        <thead>
                            <tr class="title">
                                <th>
                                    <h4><?= lang('product_wise_sales'); ?></h4>
                                </th>
                            </tr>
                            <tr class="tableHeader">
                                <th width="2%">#</th>
                                <th><?= lang('title'); ?></th>
                                <th><?= lang('qty'); ?></th>
                                <th><?= lang('amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $grand_qty = $grand_price = 0; ?>
                            <?php foreach ($xreport['item_list'] as  $key => $row) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= $row->item_name; ?></td>
                                    <td><?= $row->total_item; ?></td>
                                    <td><?= currency_position($row->total_amount, $shop_id); ?></td>
                                </tr>
                                <?php
                                $grand_qty += $row->total_item;
                                $grand_price += $row->total_amount;
                                ?>
                            <?php endforeach; ?>

                            <tr class="tableFooter">
                                <th colspan=""></th>
                                <th><?= lang('total'); ?></th>
                                <th><?= $grand_qty; ?></th>
                                <th><?= currency_position($grand_price, $shop_id); ?></th>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>