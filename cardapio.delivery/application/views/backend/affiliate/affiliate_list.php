<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4><?= lang('affiliate_list')?></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped data_tables">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('subscriber');?> </th>
                                <th><?= lang('affiliate_from');?> </th>
                                <th><?= lang('package_price');?> </th>
                                <th><?= lang('price');?> </th>
                                <th><?= lang('commision_price');?> </th>
                                <th><?= lang('created_at');?> </th>
                                <th><?= lang('payment_status');?> </th>
                                <th><?= lang('status');?> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($transaction_list as  $key=> $row): ?>
                            <tr>
                                <td><?= $key+1 ;?></td>
                                <td><?= !empty($row->subscriber_name)?$row->subscriber_name:$row->subscriber_username ;?>
                                </td>
                                <td><?= !empty($row->name)?$row->name:$row->username ;?>
                                    (<b><?= $row->referal_code ;?></b>)
                                </td>
                                <td><?= admin_currency_position($row->package_price) ;?></td>
                                <td><?= admin_currency_position($row->amount) ;?></td>
                                <td><?= admin_currency_position($row->commision_amount) ;?></td>
                                <td><?= full_date($row->created_at) ;?></td>
                                <td>
                                    <?php if($row->is_payment==0): ?>
                                    <label class="label label-warning"><?= lang('pending');?></label>
                                    <?php else: ?>
                                    <label class="label label-success"><?= lang('paid');?></label>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <?php if($row->is_request==0): ?>
                                    <label class="label label-primary"><?= lang('running');?></label>
                                    <?php else: ?>
                                    <label class="label label-success"><?= lang('in_progress');?></label>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>