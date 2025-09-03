<div class="row">
    <div class="col-lg-10 col-md-8">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= !empty(lang('customer_list'))?lang('customer_list'):"Customer List";?> &nbsp; &nbsp; <a href="#addNew" data-toggle="modal" class="btn btn-info info-light btn-flat"><i class="fa fa-plus"></i> &nbsp;<?= !empty(lang('add_new'))?lang('add_new'):"Add New Table";?> </a></h3>
                <div class="box-tools pull-right">
                    <a href="<?= base_url("admin/restaurant/export_customer");?>" class="btn btn-secondary"><i class="fa fa-download"></i> <?= lang('export');?></a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="upcoming_events">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?= !empty(lang('sl'))?lang('sl'):"Sl";?></th>
                                    <th><?= !empty(lang('name'))?lang('name'):"name";?></th>
                                    <th><?= !empty(lang('phone'))?lang('phone'):"phone";?></th>
                                    <th><?= !empty(lang('email'))?lang('email'):"email";?></th>
                                    <th><?= !empty(lang('total_orders'))?lang('total_orders'):"total order";?></th>
                                    <th><?= !empty(lang('status'))?lang('status'):"status";?></th>
                                    <th><?= !empty(lang('action'))?lang('action'):"action";?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($dboy_list as $row) : ?>
                                    <tr>
                                        <td><?= $i;?></td>
                                        <td><?= html_escape($row['name']); ?></td>
                                        <td><?= html_escape($row['phone']); ?></td>
                                        <td><?= html_escape($row['email']); ?></td>
                                        <td><label class=" label bg-primary-soft"><?= $row['total_orders'] ;?></label></td>
                                        
                                        <td>
                                            <a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="customer_list" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1? (!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
                                        </td>
                                        <td>
                                            <a href="javascript:;" title="Reset Password" data-toggle="tooltip" data-placement="top" class="btn btn-flat btn-warning btn-sm customer_password" data-id="<?= $row['id'];?>"> <i class="fa fa-lock"></i> </a>

                                            <a href="<?= base_url('admin/restaurant/edit_customer/'.html_escape($row['id'])); ?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>

                                            <a href="<?= base_url('delete-single-item/'.$row['id'].'/customer_list'); ?>" class=" action_btn btn btn-danger btn-sm" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>

                                            <a href="<?= base_url('admin/restaurant/customer_login/'.html_escape($row['customer_id'])); ?>" class=" btn btn-primary btn-sm hidden" target="blank"> <i class="fa fa-eye"></i>  <?= lang('customer_details');?></a>

                                        </td>
                                    </tr>
                                    <?php $i++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

<div id="addNew" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?= base_url('admin/restaurant/add_customer') ?>" method="post" class="form-submit">
				<?= csrf(); ?>
				<div class="modal-header">
					<h4><?= lang('add_new'); ?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="type_name"><?= !empty(lang('name')) ? lang('name') : "name"; ?></label>
						<input type="text" name="name" id="name" class="form-control" placeholder="<?= !empty(lang('name')) ? lang('name') : "Name"; ?>" value="">
					</div>
					<div class="form-group">
						<label for="type_name"><?= !empty(lang('phone')) ? lang('phone') : "phone"; ?></label>
						<input type="text" name="phone" id="phone" class="form-control" placeholder="">
					</div>

					<div class="form-group">
						<label for="type_name"><?= !empty(lang('email')) ? lang('email') : "email"; ?></label>
						<input type="text" name="email" id="email" class="form-control" placeholder="<?= !empty(lang('email')) ? lang('email') : "email"; ?>" value="">
					</div>
				</div>
				<div class="modal-footer">
					<div class="pull-left">
						<a href="javascript:;" data-dismiss="modal" class="btn btn-default"><?= lang('cancel'); ?></a>
					</div>
					<button type="submit" class="btn btn-secondary "><?= lang('submit'); ?></button>
					<p class="text-center"><small><?= lang('password'); ?> : <b>1234</b></small></p>
				</div>
			</form>
		</div>
	</div>
</div>