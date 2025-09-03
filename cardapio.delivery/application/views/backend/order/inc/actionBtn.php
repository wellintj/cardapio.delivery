<!-- <a href="<?= base_url('admin/restaurant/todays_dine'); ?>" target="_blank"  class="btn success-light btn-sm btn-flat "><i class="fa fa-eye"></i></a> -->
<?php $apps = !empty($settings['extra_config']) ? json_decode($settings['extra_config']) : '' ?>

<div class="orderListTopBtn">
	<a href="javascript:;" data-id="<?= $row['uid']; ?>" class="btn success-light btn-sm btn-flat quick_view sm-mb-10"><i class="fa fa-eye"></i></a>

	<?php if (isset($apps->edit_order_type) && $apps->edit_order_type == 1) : ?>
		<?php if (file_exists(APPPATH . 'controllers/admin/Pos.php')) : ?>
			<a href="<?= base_url("admin/restaurant/edit_order/{$row['uid']}"); ?>" class="btn btn-info btn-sm btn-flat sm-mb-10" data-toggle="tooltip" title="<?= lang('edit_order'); ?>"><i class="fa fa-edit"></i> </a>
		<?php endif; ?>
	<?php else : ?>
		<a href="<?= base_url("admin/order-details/{$row['uid']}?action=Edit"); ?>" class="btn btn-info btn-sm btn-flat sm-mb-10" data-toggle="tooltip" title="<?= lang('edit_order'); ?>"><i class="fa fa-edit"></i> </a>
	<?php endif; ?>
</div>
<div class="btn-group">
	<a href="javascript:;" class="dropdown-btn dropdown-toggle btn btn-danger btn-sm btn-flat" data-toggle="dropdown" aria-expanded="false">
		<span class="drop_text"><?= lang('action'); ?> </span> <span class="caret"></span>
	</a>
	<?php if (isset($is_filter) && $is_filter == TRUE) : ?>
		<ul class="dropdown-menu dropdown-ul" role="menu">

			<?php if ($row['order_type'] == 7 && !empty($row['table_no'])) : ?>
			<?php else : ?>
				<li class="cl-primary-soft"><a href="<?= base_url('admin/order-details/' . $row['uid']); ?>"><i class="fa fa-eye"></i> <?= lang('order_details'); ?></a></li>
			<?php endif; ?>

			<?php if ($row['status'] == 0) : ?>
				<li class="cl-info-soft">
					<?php if (restaurant()->es_time == 0) : ?>
						<a href="<?= base_url('admin/restaurant/order_status/' . $row['uid'] . '/1'); ?>" data-shop="<?= $row['shop_id']; ?>" title="Mark as Accept"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a>
					<?php else : ?>
						<a href="javascript:;" class="showTimeModal" data-shop="<?= $row['shop_id']; ?>" data-id="<?= $row['uid']; ?>"><i class="fa fa-check"></i> <?= lang('accept'); ?></a>
					<?php endif ?>
				</li>
			<?php endif; ?>
		<?php if ($row['status'] == 0 || $row['status'] == 1) : ?>
    <!-- Botão para Finalizar pedido -->
    <li class="cl-success-soft">
        <a href="<?= base_url('admin/restaurant/order_status/' . $row['uid'] . '/2'); ?>" 
           data-shop="<?= $row['shop_id']; ?>" 
           class="" 
           data-toggle="tooltip" 
           title="Finalizar Pedido">
            <i class="icofont-hand-drag1"></i> &nbsp; <?= lang('complete'); ?>
        </a>
    </li>

    <!-- Botão para Finalizar e Confirmar Pagamento -->
    <?php if ($row['is_payment'] == 0) : ?>
        <li class="cl-success-soft">
            <a href="<?= base_url('admin/restaurant/order_payment_status/' . $row['id'] . '/1'); ?>" 
               data-shop="<?= $row['shop_id']; ?>" 
               class="" 
               data-toggle="tooltip" 
               title="Finalizar e Confirmar Pagamento">
                <i class="icofont-hand-drag1"></i> &nbsp; <?= lang('complete_and_confirm_payment'); ?>
            </a>
        </li>
    <?php endif; ?>
<?php endif; ?>


			<?php if ($row['status'] != 2) : ?>
				<?php if (is_access('delete') == 1) : ?>
					<li class="cl-danger-soft"><a href="<?= base_url('admin/menu/delete/' . $row['id']); ?>" data-shop="<?= $row['shop_id']; ?>" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>" class="action_btn"><i class="fa fa-trash"></i> <?= lang('delete'); ?></a></li>
				<?php endif; ?>
			<?php endif; ?>

			<?php if (isset($apps->edit_order_type) && $apps->edit_order_type == 1) : ?>
				<?php if (is_pos() == 1) : ?>
					<li class="cl-success-soft"><a href="<?= base_url("admin/restaurant/edit_order/{$row['uid']}"); ?>" data-shop="<?= $row['shop_id']; ?>" class="" data-toggle="tooltip" title="Mark as Completed"><i class="fa fa-edit"></i> &nbsp; <?= lang('edit_order'); ?> </a></li>
				<?php endif; ?>
			<?php else : ?>
				<li class="cl-success-soft"><a href="<?= base_url("admin/order-details/{$row['uid']}?action=Edit"); ?>" data-shop="<?= $row['shop_id']; ?>" class="" data-toggle="tooltip"><i class="fa fa-edit"></i> &nbsp; <?= lang('edit_order'); ?> </a></li>
			<?php endif; ?>


		</ul>
		<?php if ($row['order_type'] == 7 && !empty($row['table_no'])) : ?>
		<?php else : ?>
			<a class="btn btn-success btn-flat btn-sm ml-5" target="blank" href="<?= base_url('invoice/' . auth('username') . '/' . $row['uid']); ?>">
				<i class="fa fa-file-pdf-o"></i> &nbsp;
				<?= !empty(lang('invoice')) ? lang('invoice') : "Invoice"; ?>
			</a>
		<?php endif; ?>


	<?php else : ?> <!--  is filter check -->

		<ul class="dropdown-menu dropdown-ul" role="menu">
			<li class="cl-primary-soft"><a href="<?= base_url('admin/order-details/' . $row['uid']); ?>"><i class="fa fa-eye"></i> <?= lang('order_details'); ?></a></li>

			<?php if ($row['status'] == 0) : ?>
				<li class="cl-info-soft">

					<?php if (restaurant()->es_time == 0) : ?>
						<a href="<?= base_url('admin/restaurant/order_status_by_ajax/' . $row['uid'] . '/1'); ?>" class="orderStatus" data-shop="<?= $row['shop_id']; ?>" title="Mark as Accept"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a>
					<?php else : ?>
						<a href="javascript:;" class="showTimeModal" data-shop="<?= $row['shop_id']; ?>" data-id="<?= $row['uid']; ?>"><i class="fa fa-check"></i> <?= lang('accept'); ?></a>
					<?php endif; ?>

				</li>
			<?php endif; ?>
			<?php if ($row['status'] == 0 || $row['status'] == 1) : ?>

				<li class="cl-success-soft"><a href="<?= base_url('admin/restaurant/order_status_by_ajax/' . $row['uid'] . '/2'); ?>" data-shop="<?= $row['shop_id']; ?>" class="orderStatus" data-toggle="tooltip" title="Finalizar"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('complete'); ?> </a></li>
			<?php endif; ?>

			<?php if ($row['status'] == 0) : ?>
				<?php if (is_access('order-cancel') == 1) : ?>
					<li class="cl-warning-soft"><a href="javascript:;" data-url="<?= base_url('admin/restaurant/order_status_by_ajax/' . $row['uid']. '/3') ; ?>" data-ajax="1" data-shop="<?= $row['shop_id']; ?>" class="rejectModal" title="Mark as Cancel"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('cancel'); ?></span> </a></li>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($row['status'] != 2) : ?>
				<?php if (is_access('delete') == 1) : ?>
					<li class="cl-danger-soft"><a href="<?= base_url('admin/menu/delete/' . $row['id']); ?>" data-shop="<?= $row['shop_id']; ?>" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>" class="action_btn"><i class="fa fa-trash"></i> <?= lang('delete'); ?></a></li>
				<?php endif; ?>
			<?php endif; ?>

			<?php if (isset($apps->edit_order_type) && $apps->edit_order_type == 1) : ?>
				<?php if (file_exists(APPPATH . 'controllers/admin/Pos.php')) : ?>
					<li class="cl-success-soft"><a href="<?= base_url("admin/restaurant/edit_order/{$row['uid']}"); ?>" data-shop="<?= $row['shop_id']; ?>" class="" data-toggle="tooltip" title="Mark as Completed"><i class="fa fa-edit"></i> &nbsp; <?= lang('edit_order'); ?> </a></li>
				<?php endif; ?>
			<?php endif; ?>

		</ul>

		<a class="btn btn-success btn-flat btn-sm ml-5" target="blank" href="<?= base_url('invoice/' . auth('username') . '/' . $row['uid']); ?>">
			<i class="fa fa-file-pdf-o"></i> &nbsp;
			<?= !empty(lang('invoice')) ? lang('invoice') : "Invoice"; ?>
		</a>

	<?php endif; ?>
</div><!-- button group -->