<div class="row mb-15 payment_info">
    <div class=" col-md-4">
        <div class="ci-info-box border-default">
            <div class="ci-info-box-body">
                <p class=""><?= lang('this_month');?></p>
                <h4 class="text-default">
                    <?= admin_currency_position($month->total_package_price) ;?>
                </h4>

                <small class="text-mute mt-5">earnings this month (<?=  date('M');?>), before referal discount
                    taxes:</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ci-info-box border-default">
            <div class="ci-info-box-body">
                <p class=""><?= lang('balance');?></p>
                <h4 class="text-default">
                    <?= admin_currency_position($balance->total_price) ;?>
                </h4>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ci-info-box border-default">
            <div class="ci-info-box-body">
                <p class=""><?= lang('total_income');?></p>
                <h4 class="text-default">
                    <?= admin_currency_position($total_income->total_package_price) ;?>
                </h4>

                <small class="text-mute mt-5">Total value of your earning, before taxes:</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card card-info">
            <div class="card-header with-border">
                <h3 class="card-title">
                    <?= !empty(lang('payment_transaction'))?lang('payment_transaction'):"Payment Transaction";?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="upcoming_events">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped data_tables">
                            <thead>
                                <tr>
                                    <th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
                                    <th><?= !empty(lang('name'))?lang('name'):"name";?></th>
                                    <th><?= !empty(lang('package_name'))?lang('package_name'):"Package Name";?></th>
                                    <th><?= !empty(lang('price'))?lang('price'):"price";?></th>
                                    <th width=5><?= !empty(lang('status'))?lang('status'):"status";?></th>
                                    <th><?= !empty(lang('txn_id'))?lang('txn_id'):"Txn id";?></th>
                                    <th><?= !empty(lang('payment_by'))?lang('payment_by'):"Payment by";?></th>
                                    <th><?= !empty(lang('date'))?lang('date'):"Payment Date";?></th>
                                    <th><?= !empty(lang('-'))?lang('-'):"-";?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $i=1; foreach ($transactions as $row): ?>
                                <tr>
                                    <td><?= $i;?></td>
                                    <td>
                                        <?php if(isset($row['user_id'])): ?>
                                        <?php $user = get_user_info_by_id($row['user_id']);?>
                                        <?= isset($user['username']) && !empty($user['username'])?$user['username']:"<span class='error'>".lang('not_found')."</span>";?>
                                        <?php endif; ?>

                                    </td>

                                    <td><?= $row['account_type']!=0?html_escape(get_package_info_by_id($row['account_type']))['package_name']:''; ?>
                                    </td>
                                    <td class="uppercase"><?= html_escape($row['price']); ?>
                                        <?= html_escape($row['currency_code']); ?></td>
                                    <td>

                                        <?php 
											if(!empty($row['status'])){
												if(in_array(strtolower($row['status']),['success','completed','succeeded','authorized','successful'])):
													$class = 'bg-success-soft';
													$icon = '<i class="icofont-check-alt"></i>';
												elseif(strtolower($row['status'])=='failed'):
													$class = 'bg-danger-soft';
													$icon = '<i class="fa fa-ban"></i>';
												else:
													$class = 'bg-warning-soft';
													$icon = '<i class="fa fa-spinner"></i>';
												endif;
											}
											?>

                                        <label class="label <?= $class??''; ?> fw-normal">
                                            <?= $icon??'' ;?>
                                            <?= isset($row['is_payment']) && $row['is_payment']==0?lang('pending'):html_escape($row['status']); ?>
                                        </label>


                                    </td>
                                    <td><?= html_escape($row['txn_id']); ?></td>
                                    <td>
                                        <label
                                            class='label <?= $row['payment_type']==0?'bg-primary-soft':($row['payment_type']==1?"label-info":($row['payment_type']==2?'label-warning':'label-success')) ;?>'>
                                            <?=  get_payment_type(html_escape($row['payment_type']));?>

                                        </label>
                                    </td>
                                    <td><?= full_time(html_escape($row['created_at'])); ?></td>
                                    <td>
                                        <a href='<?= base_url("subscription-invoice/".md5($row['id']));?>'
                                            target="blank" class="btn btn-secondary btn-sm"><i
                                                class="fa fa-file-pdf-o"></i></a>
                                    </td>

                                </tr>
                                <?php $i++; endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.card-body -->
        </div>
    </div>
</div>