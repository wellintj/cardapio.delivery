<div class="row mb-15">
    <div class=" col-md-3">
        <div class="ci-info-box border-default">
            <div class="ci-info-box-body">

                <h4 class="text-default">
                    <?=  $month->total_referal;?>
                </h4>

                <p class=""><?= lang('total_referal');?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="ci-info-box border-purple">
            <div class="ci-info-box-body">
                <h4 class="text-purple">
                    <?= admin_currency_position($month->balance) ;?>
                </h4>
                <p class=""><?= lang('balance');?></p>

            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="ci-info-box border-success">
            <div class="ci-info-box-body">
                <h4 class="text-success">
                    <?= admin_currency_position($all->balance) ;?>
                </h4>
                <p class=""><?= lang('total_income');?></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h4><?= lang('affiliate_list');?></h4>
            </div>
            <div class="card-body table-body">
                <div class="table-responsive">
                    <table class="table table-striped data_tables">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('subscriber');?></th>
                                <th><?= lang('commision_price');?></th>
                                <th><?= lang('price');?></th>
                                <th><?= lang('created_at');?></th>
                                <th><?= lang('status');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($transaction_list as  $key=> $row): ?>
                            <tr>
                                <td><?= $key+1 ;?></td>
                                <td><?= !empty($row->name)?$row->name:$row->username ;?></td>
                                <td><?= currency_position($row->commision_amount,$_ENV['ID']) ;?></td>
                                <td><?= currency_position($row->package_price,$_ENV['ID']) ;?></td>
                                <td><?= full_date($row->created_at) ;?></td>
                                <td>
                                    <?php if($row->is_payment==1): ?>
                                    <label class="label bg-success-soft"><i class="fa fa-check"></i>
                                        <?= lang('paid');?></label>
                                    <?php else: ?>
                                    <label label class="label bg-warning-soft"><i class="fa fa-spinner"></i>
                                        <?= lang('pending');?></label>
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