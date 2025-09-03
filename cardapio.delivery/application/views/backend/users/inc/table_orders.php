<div class="row justify-content-center flex-column ">
	<div class="col-md-10">
		<div class="card tableCard">
			<div class="card-header">
				<h4><?= lang('tables'); ?></h4>
				<?php
				$emptyIcon = '<i class="fa fa-minus"></i>';
				$emptyText = lang('the_table_is_empty');
				$customerIcon = '<i class="icofont-fork-and-knife"></i>';
				$customerText = lang('there_are_customers');
				$newIcon = '<i class="fa fa-bell-o"></i>';
				$newText = lang('have_a_new_order');
				$waiterIcon = '<i class="icofont-bell"></i>';
				$waiterText = lang('waiter_calling');
				?>
				<ul>

					<li><?= $emptyIcon; ?> <span><?= $emptyText; ?></span></li>
					<li><?= $customerIcon; ?> <span><?= $customerText; ?></span></li>
					<li><?= $newIcon; ?> <span><?= $newText; ?></span></li>
					<li><?= $waiterIcon; ?> <span><?= $waiterText; ?></span></li>
				</ul>
			</div>
			<div class="card-body">
				<div class="card-content">
					<div class="row TableNotifyArea">
						<?php foreach ($table_list as $key => $row) : ?>
							<?php $check_new_order = $this->admin_m->new_dine_in_order(restaurant()->id, $row['id']); ?>
							<?php $is_customer = $this->admin_m->customer_availabity(restaurant()->id, $row['id']); ?>
							<?php $is_waiter = $this->admin_m->call_waiter_notify(restaurant()->id, $row['id']); ?>
							<?php $is_active_waiter = $this->admin_m->call_waiter_active_notify(restaurant()->id, $row['id']); ?>
							<?php
							if (isset($check_new_order) && $check_new_order > 0) :
								$orderType = "newOrder";
								$icon = $newIcon;
								$text = $newText;
								$isEmpty = FALSE;
							elseif (isset($is_customer) && $is_customer > 0) :
								$orderType = "isCustomer";
								$icon = $customerIcon;
								$text = $customerText;
								$isEmpty = FALSE;
							elseif (isset($is_active_waiter) && $is_active_waiter > 0) :
								$orderType = "isCustomer";
								$icon = $customerIcon;
								$text = $customerText;
								$isEmpty = FALSE;
							else :
								$orderType = "empty";
								$icon = $emptyIcon;
								$text = $emptyText;
								$isEmpty = TRUE;
							endif;


							?>
							<div class="col-md-3">
								<div class="singleTables <?= isset($orderType) ? $orderType : ''; ?> <?= isset($is_waiter) && $is_waiter > 0 ? "newWaiter" : "";; ?>">
									<div class="tableIcon">
										<?php if ($isEmpty == TRUE && isset($is_waiter) && $is_waiter > 0) : ?>
											<?= isset($is_waiter) && $is_waiter > 0 ? '<i class="icofont-bell"></i>' : "";; ?>
										<?php else : ?>
											<?= isset($icon) ? $icon : ''; ?>
											<?= isset($is_waiter) && $is_waiter > 0 ? '<i class="icofont-bell"></i>' : "";; ?>
										<?php endif; ?>


									</div>
									<div class="singleTableDetails">
										<?php if ($isEmpty == TRUE && isset($is_waiter) && $is_waiter > 0) : ?>
											<p><?= isset($waiterText) ? $waiterText : ''; ?></p>
										<?php else : ?>
											<p><?= isset($text) ? $text : ''; ?></p>
											<?php if (isset($is_waiter) && $is_waiter > 0) : ?>
												<?= $waiterText; ?>
											<?php endif; ?>
										<?php endif; ?>
										<h4><?= $row['name']; ?></h4>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				</div><!-- card-content -->
			</div><!-- card-body -->
		</div><!-- card -->
	</div>
	<?php $callWaiterList = $this->admin_m->get_call_waiter_list(); ?>
	<?php if (sizeof($callWaiterList) > 0) : ?>
		<div class="col-md-10 mt-50">
			<div class="card">
				<div class="card-body">
					<div class='table-responsive'>
						<table class='table table-striped data_tables'>
							<thead>
								<tr>
									<th>#</th>
									<th><?= lang('table'); ?></th>
									<th><?= lang('status'); ?></th>
									<th><?= lang('action'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($callWaiterList as  $key => $waiter) : ?>
									<tr>
										<td><?= $key + 1; ?></td>
										<td><?= $waiter->table_name; ?></td>
										<td>
											<?php if ($waiter->is_ring == 1 && $waiter->status == 0) : ?>
												<label class="label label-info"><i class="fa fa-spinner"></i> <?= lang('pending'); ?></label>
											<?php elseif ($waiter->is_ring == 0 && $waiter->status == 0) : ?>
												<label class="label label-warning"><i class="icofont-fork-and-knife"></i> <?= lang('there_are_customers'); ?></label>
											<?php elseif ($waiter->status == 1) : ?>
												<label class="label label-success"><i class="fa fa-check"></i> <?= lang('completed'); ?></label>
											<?php endif; ?>
											<?php if (isset($waiter->staff_id) && !empty($waiter->staff_id)) : ?>
												<div class="mt-3">
													<small><?= __staff($staff_id)->name; ?> - <?= __staff($staff_id)->uid ?? ''; ?></small>
												</div>
											<?php endif; ?>
										</td>
										<td>
											<?php if ($waiter->is_ring == 1) : ?>
												<a href="<?= base_url("admin/notification/accept_waiter/{$waiter->id}/0") ?>" class="btn btn-info waiterAccept btn-sm"><i class="fa fa-check"></i> <?= lang('mark_as_accepted'); ?></a>
											<?php endif; ?>
											<?php if ($waiter->is_ring == 0 && $waiter->status == 0) : ?>
												<a href="<?= base_url("admin/notification/accept_waiter/{$waiter->id}/1") ?>" class="btn btn-success waiterAccept btn-sm"><i class="fa fa-check"></i> <?= lang('mark_as_completed'); ?></a>
											<?php else : ?>
												<a href="javascript:;" class="btn btn-success btn-sm"><i class="fa fa-check"></i> <?= lang('completed'); ?></a>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>