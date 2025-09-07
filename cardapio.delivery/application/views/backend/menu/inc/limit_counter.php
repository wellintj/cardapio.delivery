<div class="col-md-6">
	<?php
	if (isset($multilang) && $multilang == 1) :
		$total = $this->admin_m->check_limit_by_table_ln('items');
	else :
		$total = $this->admin_m->check_limit_by_table('items');
	endif;

	$limit = limit(auth('id'), 1);
	$start_date = users()->start_date;
	$end_date = users()->end_date;
	?>
	<?php if ($limit == 0) : ?>

		<div class="callout callout-default">
			<h5><?= lang('you_can_add'); ?> <b class="underline"> <?= lang('unlimited'); ?> </b> <?= lang('items'); ?></h5>
			<p class="m-0"> <?= lang('total'); ?> : <b><?= $total; ?></b> / <i class="fas fa-infinity"></i> </p>
			<small> <?= lang('duration'); ?> : <?= full_date($start_date) . " - " . full_date($end_date); ?></small>
		</div>

		<?php $active = 1; ?>
	<?php elseif ($total >= $limit) : ?>
		<div class="single_alert alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<div class="d_flex_alert ">
				<h4> <i class="fas fa-exclamation-triangle"></i> <?= lang('alert'); ?></h4>
				<div class="double_text">
					<div class="text-left">
						<h5><i class="fas fa-frown"></i> <?= lang('sorry'); ?></h5>
						<p><?= lang('you_reached_max_limit'); ?> <?= $limit; ?></p>
					</div>

				</div>
			</div>
		</div>
		<?php $active = 0; ?>
	<?php else : ?>

		<div class="callout callout-default">
			<h5><?= lang('you_have_remaining'); ?> <b class="underline"> &nbsp; <?= ($limit - $total); ?> &nbsp;</b> <?= lang('out_of'); ?> <b class="underline"> &nbsp; <?= ($limit); ?> &nbsp;</b></h5>
			<small> <?= lang('duration'); ?> : <?= full_date($start_date) . " - " . full_date($end_date); ?></small>
			<p class="m-0"> <?= lang('total'); ?> : <b><?= $total; ?></b> / <?= $limit; ?> </p>
		</div>
		<?php $active = 1; ?>
	<?php endif; ?>
	<?php if (!auth('is_staff')) : ?>
		<?php $check_default = $this->admin_m->check_default_data(); ?>
		<?php if (!empty($check_default) && $check_default == 1) : ?>
			<div class="card">
				<div class="card-body">
					<p class="m-0"><?= __("you_have_some_test_data_like_items"); ?></p>
					<p class="m-0"><?= __("do_you_want_to_remove_them"); ?></p>
					<div class="mt-10 text-right">
						<a href="<?= base_url("admin/menu/reset_data"); ?>" class="btn btn-danger btn-block action_btn"><?= lang('reset'); ?> / <?= lang('delete'); ?></a>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</div>