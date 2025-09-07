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