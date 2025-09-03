<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header space-between flex-sm-column">
				<h4 class="card-title"><?= lang('staff_activities'); ?></h4>
				<div class="filterAreas">
					<form action="" method="get">
						<div class="filterContent">
							<div class="input-group date">
								<input type="text" name="daterange" class="form-control dateranges" value="<?php 
									if (isset($_GET['daterange']) && !empty($_GET['daterange'])) {
										echo function_exists('daterange') ? daterange($_GET['daterange']) : $_GET['daterange'];
									} else {
										echo '';
									} 
								?>" autocomplete="off">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
							</div>
							<button type="submit" class="btn btn-secondary"><i class="icofont-filter"></i> <?= lang('filter'); ?></button>
						</div>
					</form>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="card-body">
				<div class="upcoming_events">
					<div class="table-responsive">
						<table class="table table-condensed table-striped data_tables">
							<thead>
								<tr>
									<th><?= !empty(lang('sl')) ? lang('sl') : "Sl"; ?></th>
									<th><?= lang('order_id'); ?></th>
									<th><?= lang('order_type'); ?></th>
									<th><?= lang('action'); ?></th>
									<th><?= lang('date'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;
								foreach ($staff_list as $row) : ?>
									<tr>
										<td><?= $i; ?></td>
										<td>#<a href="<?= base_url("admin/order-details/{$row->uid}"); ?>" target="_blank"><?= $row->uid; ?></a></td>
										<td><?= order_type($row->order_type) ?></td>
										<td>
											<?php
											if (strpos($row->action_types, ',') !== false):
												$action_types = explode(',', $row->action_types);
												$acType = [];
												foreach ($action_types as $at) {
													$acType[] = '<label class="label label-default">'. actionType($at). '</label>';
												}
												?>
											 <?=  implode(' ',$acType);?>
											<?php else: ?>
											<label class="label label-default"> <?=  actionType($row->action_types);?></label>
											
											<?php endif;?>
										</td>

										<td>
											<?= full_date($row->created_at); ?>

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

	<div class="col-md-4 col-lg-3 col-sm-4">
		<div class="card">
			<div class="card-body">
				<div class="card-profile">
					<img src="<?= avatar($staff_info->thumb, 'profile'); ?>" alt="">
				</div>
				<div class="card-details">
					<h4><?= $staff_info->name; ?></h4>
					<p><?= $staff_info->uid; ?></p>
					<?php $order = $this->admin_m->get_action_type_counts_for_staff($staff_info->id); ?>
					
					<ul>
						<?php foreach($order as  $key=> $a): ?>
							 <li><?= lang('order') . ' ' . $a->action_type=='create_order'?lang('create'):lang($a->action_type); ?>: <?= $a->total_count ?? 0; ?></li>
						<?php endforeach;?>
						
					</ul>
				</div>
			</div>
		</div>
	</div>

</div>