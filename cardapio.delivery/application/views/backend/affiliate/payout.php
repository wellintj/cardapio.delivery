<?php $monthlyBalance = $monthlyReferal = 0; $date = []?>
<?php foreach($active_transaction as  $key=> $value): 
    $monthlyBalance += $value->grand_balance;
    $monthlyReferal += $value->grand_referal;
    $date[] = month_year_name($value->created_at);
    $getMonthYear[] = year_month($value->created_at);
    $grandDate = implode(', ',$date);
   

endforeach;?>
<?php
    // $month = ['2023-09','2023-10'];
    // $check = $this->affiliate_m->get_payout_request_by_date_ids(1,$getMonthYear,$ids=0);
    // echo '<pre>';print_r($check);exit();
 ?>
<?php $u_settings = $this->common_m->get_user_settings_by_shop_id(restaurant()->id);?>
<?php $app = isJson($u_settings['vendor_affiliate_settings'])?json_decode($u_settings['vendor_affiliate_settings']):[]?>
<div class="row">
    <div class="col-md-4">
        <div class="ci-info-box">
            <div class="ci-info-box-body affiPayoutRequest">
                <div class="topInfo">
                    <h4><?= currency_position(isset($monthlyBalance)?$monthlyBalance:0,$_ENV['ID']) ;?></h4>
                    <p><i class="icofont-calendar"></i> <?= isset($grandDate)?$grandDate:month_year_name(c_time()) ;?>
                    </p>
                    <small><i class="icofont-mastercard"></i> <?= lang('paypal') ?></small>
                </div>
                <div class="rightIcon">
                    <i class="icofont-coins"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(sizeof($active_transaction) > 0): ?>
<div class="row mt-20">
    <div class="col-md-9">
        <form action="<?= base_url('admin/affiliate/send_payout_request');?>" method="post"
            onsubmit="return confirm(`<?= lang('are_you_sure') ?>?`);">
            <?= csrf();?>

            <div class="card">
                <div class="card-header">
                    <h4><?= lang('payout');?></h4>
                </div>
                <div class="card-body table-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?= lang('date');?></th>
                                    <th><?= lang('total_referal');?></th>
                                    <th><?= lang('amount');?></th>
                                    <th><?= lang('status');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $ids = [];?>
                                <?php foreach($active_transaction as  $key=> $row): ?>

                                <tr>
                                    <td><?= month_year_name($row->created_at) ;?></td>
                                    <td><?= $row->total_referal ;?></td>
                                    <td><?= admin_currency_position($row->balance) ;?></td>
                                    <td><label class="label bg-primary-soft"><i class="fa fa-spinner"></i>
                                            <?= lang('running');?></label></td>
                                </tr>
                                <input type="hidden" name="monthyear[]" value="<?= year_month($row->created_at)?>">
                                <?php foreach($row->details as  $key=> $detailsId): ?>
                                <input type="hidden" name="ids[<?= year_month($detailsId->created_at)?>][]"
                                    value="<?= $detailsId->id;?>">
                                <?php endforeach;?>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if(isset($app->payment_method) && empty($app->payment_method)):?>
                <div class="card-footer text-center">
                    <p class="text-danger m-0"><?= lang('please_configure_affiliate_payment_method');?></p>
                </div>
                <?php else: ?>
                <?php if(isset($monthlyBalance) && round($monthlyBalance) >=__config('minimum_payout')):?>
                <div class=" card-footer text-right p-10">
                    <input type="hidden" name="request_id" value="<?= $_ENV['ID'];?>">
                    <button type="submit" class="btn btn-sm  btn-secondary"> <i class="icofont-hand-drag2"></i>
                        <?= lang('submit') ;?> </button>
                </div>
                <?php endif;?>
                <?php endif;?>
            </div>
        </form>
    </div>
</div>

<?php endif;?>


<div class="row mt-20">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h4><?= lang('payout_list');?></h4>
            </div>
            <div class="card-body table-body">
                <div class="table-responsive">
                    <table class="table table-striped data_tables">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('date');?></th>
                                <th><?= lang('total_referal');?></th>
                                <th><?= lang('amount');?></th>
                                <th><?= lang('request_date');?></th>
                                <th><?= lang('complete_date');?></th>
                                <th><?= lang('status');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  $pendingPayment = 0;?>
                            <?php foreach($payoutList as  $key=> $row): ?>
                            <tr>
                                <td><?= $key+1 ;?></td>
                                <td><?= month_year_name($row->payout_month) ;?></td>
                                <td><?= $row->total_referel ;?></td>
                                <td><?= admin_currency_position($row->balance) ;?></td>
                                <td><?= full_date($row->request_date) ;?></td>
                                <td><?= !empty($row->complete_date) && $row->is_payment==1?full_date($row->complete_date):'---' ;?>
                                </td>
                                <td>
                                    <?php if($row->is_payment==0 && $row->status== 0):?>
                                    <label class="label bg-warning-soft"> <i class="icofont-check-alt"></i>
                                        <?= lang('pending') ;?></label>
                                    <?php elseif($row->is_payment==0 && $row->status== 2): ?>
                                    <label class="label bg-danger-soft"> <i class="fa fa-level-down"
                                            aria-hidden="true"></i>
                                        <?= lang('hold') ;?></label>
                                    <?php else: ?>
                                    <label class="label bg-success-soft"> <i class="icofont-check-alt"></i>
                                        <?= lang('completed') ;?></label>
                                    <?php endif;?>
                                </td>

                            </tr>
                            <?php 
                               
                                if($row->is_payment== 0):
                                    $pendingPayment += $row->balance;
                                endif;
                             ?>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($pendingPayment) && !empty($pendingPayment)):?>
    <div class="col-md-3">
        <div class="ci-info-box">
            <div class="ci-info-box-body affiPayoutRequest text-purple">
                <div class="topInfo">
                    <h4 class="text-warning">
                        <?= admin_currency_position(isset($pendingPayment)?$pendingPayment:0,$_ENV['ID']) ;?></h4>
                    <small class="text-mute"> <i class="fa fa-spinner"></i> <?= lang('pending_payment');?></small>
                </div>
                <div class="rightIcon">
                    <i class="icofont-coins"></i>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
</div>