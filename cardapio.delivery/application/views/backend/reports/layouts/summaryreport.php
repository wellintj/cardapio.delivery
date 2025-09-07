<div class="zReports" id="printArea">
    <div class="allReportsDetails">
        <div class="singleReport">
            <div class='table-responsive'>
                <table class='table table-striped'>
                    <thead class="tableHeader">
                        <tr class="title">
                            <th>
                             <div class="space-between">
                                 <h4> <?= lang('summaryreport'); ?></h4> <h4><?= lang('date'); ?> : <?= isset($_GET['daterange']) && !empty($_GET['daterange']) ? $_GET['daterange'] : full_date(today()); ?> </h4>
                             </div>
                            </th>
                            <th class="text-right">
                                <?= lang('amount'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w_50"><?= lang('total_sales'); ?></td>
                            <td class="text-right"><?= currency_position($report->total, $shop_id); ?></td>
                        </tr>
                        <tr>
                            <td class="w_50"><?= lang('tax'); ?></td>
                            <td class="text-right"><?= currency_position($report->tax, $shop_id); ?></td>
                        </tr>
                        <tr>
                            <td class="w_50"><?= lang('delivery_charge'); ?></td>
                            <td class="text-right"><?= currency_position($report->shipping, $shop_id); ?></td>
                        </tr>
                        <tr>
                            <td class="w_50"><?= lang('tips'); ?></td>
                            <td class="text-right"><?= currency_position($report->tips, $shop_id); ?></td>
                        </tr>
                        <tr>
                            <td class="w_50"><?= lang('service_charge'); ?></td>
                            <td class="text-right"><?= currency_position($report->service_charge, $shop_id); ?></td>
                        </tr>
                        <tr>
                            <td class="w_50"><?= lang('discount'); ?> (-)</td>
                            <td class="text-right"><?= currency_position($report->discount, $shop_id); ?></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="singleReport">
            <div class='table-responsive'>
                <table class='table table-striped'>
                    <thead>
                        <tr class="title">
                            <th class="w_50">
                                <h4><?= lang('payment_with_cash'); ?></h4>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w_50"><?= lang('amount'); ?></td>
                            <td class="text-right"><?= currency_position($report->cash, $shop_id); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (!empty($report->online_payment)) : ?>
            <div class="singleReport">
                <div class='table-responsive'>
                    <table class='table table-striped'>
                        <thead>
                            <tr class="title">
                                <th class="w_50">
                                    <h4><?= lang('online_payments'); ?></h4>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="w_50"><?= lang('amount'); ?></td>
                                <td class="text-right"><?= currency_position($report->online_payment, $shop_id); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>