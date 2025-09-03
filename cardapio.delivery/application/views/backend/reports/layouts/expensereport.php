<div class="zReports" id="printArea">
    <div class="allReportsDetails">
        <table class="table table-striped ">
            <thead>
                <tr class="title">
                    <th>
                        <h4 class="fw_bold"><?= lang('expenses'); ?></h4>
                    </th>
                    <th>
                        <?= lang('date'); ?> : <?= isset($_GET['daterange']) && !empty($_GET['daterange']) ? $_GET['daterange'] : full_date(today()); ?>
                    </th>
                </tr>
                <tr class="tableHeader">
                    <th>#</th>
                    <th><?= lang('category'); ?></th>
                    <th><?= lang('title'); ?></th>
                    <th><?= lang('date'); ?></th>
                    <th><?= lang('amount'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $grand_price = 0; ?>
                <?php foreach ($xreport as  $key => $row) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $row->category_name; ?></td>
                        <td><?= $row->title; ?></td>
                        <td><?= full_date($row->created_at); ?></td>
                        <td><?= currency_position($row->amount, $shop_id); ?></td>
                    </tr>
                    <?php $grand_price += $row->amount; ?>
                <?php endforeach; ?>

            </tbody>
            <tr class="tableFooter">
                <th colspan="3"></th>
                <th><?= lang('total'); ?></th>
                <th><?= currency_position($grand_price, $shop_id); ?></th>
            </tr>
        </table>
    </div>
</div>