<div class="row">
    <?php foreach($request_list as  $key=> $row): ?>
    <?php $u_settings = $this->common_m->get_user_settings_by_shop_id($row->request_id);?>
    <?php $app = isJson($u_settings['vendor_affiliate_settings'])?json_decode($u_settings['vendor_affiliate_settings']):[]?>
    <?php if(isset($_GET['requestId']) && !empty(trim($_GET['requestId'])) && $_GET['requestId']==md5($row->request_id)): ?>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="vendorImg">
                    <img src="<?= avatar($row->thumb,'logo')?>" alt="vendorImg">
                </div>
                <div class="vendorDetails">
                    <h4><?= !empty($row->name)?$row->name:$row->username; ?></h4>
                    <div class="vendorReferal_details">
                        <p> <?= full_date($row->request_date) ?></p>
                        <div class="vendorReferal_bottom">
                            <ul>
                                <li>
                                    <p>total Referal</p>
                                    <h4><?= $row->total_referels??0; ?></h4>
                                </li>
                                <li>
                                    <p>Amount</p>
                                    <h4> <?= admin_currency_position($row->total_balance??0); ?></h4>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if(isset($_GET['requestId']) && !empty(trim($_GET['requestId']))): ?>
                <div class="paymentDetails">
                    <div class=""><span><?= lang('payment_method');?> :</span>
                        <b><?= isset($app->payment_method) && !empty($app->payment_method)?$app->payment_method:'' ;?></b>
                    </div>
                    <div class=""><span><?= lang('payment_email');?> :</span>
                        <b><?= isset($app->payment_method) && !empty($app->payment_email)?$app->payment_email:'' ;?></b>
                    </div>
                </div>
                <div class="mt-20 text-center">
                    <a href="#payment_details" data-toggle="modal"><?= lang('see_more');?></a>
                </div>
                <?php endif;?>
            </div>
            <div class="card-footer p-5 text-center">
                <?php if(isset($_GET['requestId']) && !empty(trim($_GET['requestId']))): ?>
                <a href="<?= base_url('admin/affiliate/payout_request')?>" class="btn btn-secondary btn-sm btn-block"><i
                        class="fa fa-arrow-left"></i></a>
                <?php else: ?>
                <a href="<?= base_url("admin/affiliate/payout_request/?requestId=".md5($row->request_id));?>"
                    class="btn btn-info btn-sm btn-block"><i class="fa fa-eye"></i></a>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php elseif(!isset($_GET['requestId'])): ?>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="vendorImg">
                    <img src="<?= avatar($row->thumb,'logo')?>" alt="vendorImg">
                </div>
                <div class="vendorDetails">
                    <h4><?= !empty($row->name)?$row->name:$row->username; ?></h4>
                    <div class="vendorReferal_details">
                        <p> <?= full_date($row->request_date) ?></p>
                        <div class="vendorReferal_bottom">
                            <ul>
                                <li>
                                    <p>total Referal</p>
                                    <h4><?= $row->total_referels??0; ?></h4>
                                </li>
                                <li>
                                    <p>Amount</p>
                                    <h4> <?= admin_currency_position($row->total_balance??0); ?></h4>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if(isset($_GET['requestId']) && !empty(trim($_GET['requestId']))): ?>
                <div class="paymentDetails">
                    <div class=""><span><?= lang('payment_method');?> :</span> <b>Paypal</b></div>
                    <div class=""><span><?= lang('payment_email');?> :</span> <b>demo@paypal.com</b></div>
                </div>
                <?php endif;?>
            </div>
            <div class="card-footer p-5 text-center">
                <?php if(isset($_GET['requestId']) && !empty(trim($_GET['requestId']))): ?>
                <a href="<?= base_url('admin/affiliate/payout_request')?>" class="btn btn-secondary btn-sm btn-block"><i
                        class="fa fa-arrow-left"></i></a>
                <?php else: ?>
                <a href="<?= base_url("admin/affiliate/payout_request/?requestId=".md5($row->request_id));?>"
                    class="btn btn-info btn-sm btn-block"><i class="fa fa-eye"></i></a>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php endforeach;?>

    <div class="col-md-10 hidden">
        <div class="card">
            <div class="card-header">
                <h4><?= lang('payout_request');?></h4>
            </div>
            <div class="card-body">
                <div class="row"></div>
                <div class="table-responsive">
                    <table class="table table-striped data_tables">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('date');?></th>
                                <th><?= lang('vendor_name');?></th>
                                <th><?= lang('total_referal');?></th>
                                <th><?= lang('amount');?></th>
                                <th><?= lang('request_date');?></th>
                                <th><?= lang('complete_date');?></th>
                                <th><?= lang('status');?></th>
                                <th><?= lang('action');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  $pendingPayment = $total_referal =  0;?>
                            <?php  $date = [];?>
                            <?php foreach($payoutList as  $key=> $row): ?>
                            <?php 
                                $date[] = month_year_name($row->payout_month);
                                $grandDate = implode(',',$date);
                                if($row->is_payment== 0):
                                    $pendingPayment += $row->balance;
                                    $total_referal += $row->total_referal;
                                endif;
                             ?>
                            <tr>
                                <td><?= $key+1 ;?></td>
                                <td><?= $grandDate ;?></td>
                                <td><?= !empty($row->name)?$row->name:$row->username ;?></td>
                                <td><?= $total_referal ;?></td>
                                <td><?= admin_currency_position($pendingPayment) ;?></td>
                                <td><?= full_date($row->request_date) ;?></td>
                                <td><?= !empty($row->complete_date)?full_date($row->complete_date):'---' ;?></td>
                                <td>
                                    <?php if($row->is_payment==0):?>
                                    <label class="label bg-warning-soft"> <i class="icofont-check-alt"></i>
                                        <?= lang('pending') ;?></label>
                                    <?php else: ?>
                                    <label class="label bg-success-soft"> <i class="icofont-check-alt"></i>
                                        <?= lang('completed_at') ;?></label>
                                    <?php endif;?>
                                </td>

                                <td>
                                    <div class="d-flex">
                                        <a href="" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i></a>
                                        <div class="dropdown customDropdown border-0">
                                            <button class="dropdown-toggle fz-18" type="button" data-toggle="dropdown">
                                                <i class="fas fa-ellipsis-h"></i></button>
                                            <ul class="dropdown-menu ">
                                                <li class="dropdown-header"><?= lang('action');?></li>
                                                <li> <a href="<?= base_url("admin/affiliate/approve_payment/".md5($row->request_id)."/{$row->month_year}");?>"
                                                        class="text-success "><?= lang('mark_as_paid');?></a>
                                                </li>
                                                <li> <a href="" class="text-warning "><?= lang('mark_as_hold');?></a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>


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

<?php if(isset($payoutList) && sizeof($payoutList)> 0): ?>
<div class="row">
    <div class="col-md-12">
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
                                <th><?= lang('vendor_name');?></th>
                                <th><?= lang('total_referal');?></th>
                                <th><?= lang('amount');?></th>
                                <th><?= lang('request_date');?></th>
                                <th><?= lang('complete_date');?></th>
                                <th><?= lang('status');?></th>
                                <th><?= lang('action');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  $pendingPayment = 0;?>
                            <?php foreach($payoutList as  $key=> $row): ?>
                            <tr>
                                <td><?= $key+1 ;?></td>
                                <td><?= month_year_name($row->payout_month) ;?></td>
                                <td><?= !empty($row->name)?$row->name:$row->username ;?></td>
                                <td><?= $row->total_referel ;?></td>
                                <td><?= admin_currency_position($row->balance) ;?></td>
                                <td><?= full_date($row->request_date) ;?></td>
                                <td><?= !empty($row->complete_date) && $row->is_payment==1?full_date($row->complete_date):'---' ;?>
                                </td>
                                <td>
                                    <?php if($row->is_payment==0  && $row->status==0):?>
                                    <label class="label bg-warning-soft"> <i class="icofont-check-alt"></i>
                                        <?= lang('pending') ;?></label>

                                    <?php elseif($row->is_payment==0  && $row->status==2):?>
                                    <label class="label bg-warning-soft"> <i class="fa fa-level-down"></i>
                                        <?= lang('hold') ;?></label>
                                    <?php elseif($row->is_payment==1 && $row->status==1): ?>
                                    <label class="label bg-success-soft"> <i class="icofont-check-alt"></i>
                                        <?= lang('completed') ;?></label>
                                    <?php endif;?>
                                </td>

                                <td>
                                    <div class="d-flex">
                                        <a href="<?= base_url("admin/affiliate/affiliate_details?requestId=".md5($row->request_id)."&monthYear={$row->payout_month}");?>"
                                            class="btn btn-sm btn-info"> <i class="fa fa-eye"></i></a>
                                        <div class="dropdown customDropdown border-0">
                                            <button class="dropdown-toggle fz-18" type="button" data-toggle="dropdown">
                                                <i class="fas fa-ellipsis-h"></i></button>
                                            <ul class="dropdown-menu ">
                                                <li class="dropdown-header"><?= lang('action');?></li>
                                                <?php if($row->is_payment== 0 || $row->status== 2):?>
                                                <li> <a href="<?= base_url("admin/affiliate/approve_payment/".md5($row->request_id)."/{$row->payout_month}/1");?>"
                                                        class="text-success "><?= lang('mark_as_paid');?></a>
                                                </li>
                                                <?php endif;?>
                                                <?php if($row->status!= 2): ?>
                                                <li> <a href="<?= base_url("admin/affiliate/approve_payment/".md5($row->request_id)."/{$row->payout_month}/0");?>"
                                                        class="text-warning "><?= lang('mark_as_hold');?></a>
                                                </li>
                                                <?php endif;?>

                                            </ul>
                                        </div>
                                    </div>


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
</div>
<?php endif;?>
<div id="payment_details" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modalpaymentDetails">
                    <ul>
                        <li><span><?= lang('payment_method');?></span><span><?= isset($app->payment_method) && !empty($app->payment_method)?$app->payment_method:'' ;?></span>
                        </li>
                        <li><span><?= lang('payment_email');?></span><span><?= isset($app->payment_email) && !empty($app->payment_email)?$app->payment_email:'' ;?></span>
                        </li>
                    </ul>
                </div>

                <p><?= isset($app->payment_details) && !empty($app->payment_details)?$app->payment_details:'' ;?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close');?></button>
            </div>
        </div>
    </div>
</div>