<div class="row">
    <div class="col-md-10 ">
        <div class="card">
            <div class="card-header">
                <h4><a href="<?= base_url("admin/affiliate/payout_request/?requestId={$requestId}")?>"
                        class="text-black hover-default align-center"><i class="fa fa-angle-double-left fz-25"></i>
                        <?= lang('affiliate_list');?></a>
                </h4>
            </div>
            <div class="card-body">
                <div class="row"></div>
                <div class="table-responsive">
                    <table class="table table-striped data_tables">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('payout_month');?></th>
                                <th><?= lang('vendor_name');?></th>
                                <th><?= lang('subscriber_name');?></th>
                                <th><?= lang('amount');?></th>
                                <th><?= lang('date');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($payoutList as  $key=> $row): ?>
                            <tr>
                                <td><?= $key+1 ;?></td>
                                <td><?= month_year_name($row->created_at) ;?></td>
                                <td><?= !empty($row->name)?$row->name:$row->username ;?></td>
                                <td><?= !empty($row->subscriber_name)?$row->subscriber_name:$row->subscriber_username ;?>
                                </td>
                                <td><?= admin_currency_position($row->commision_amount) ;?></td>
                                <td><?= full_date($row->created_at) ;?></td>


                            </tr>

                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>