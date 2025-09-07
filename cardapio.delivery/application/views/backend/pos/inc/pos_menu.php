<div class="row">
	<div class="col-md-6">
		<div class="posMenu">
			<ul>
				<li><a href="<?= base_url("dashboard");?>" class="<?= isset($page_title) && $page_title==""?"active":"";?>"><i class="icofont-long-arrow-left fz-20"></i></a></li>
				<li><a href="javascript:;" class="active expand mr-10"><i class="fa fa-expand fz-20 "></i></a></li>
				<li><a href="<?= base_url(isset($this->link['pos_link'])?$this->link['pos_link']:'');?>" class="<?= isset($page_title) && $page_title=="POS"?"active":"";?>"><img src="<?= base_url("assets/frontend/images/pos.png");?>" alt="" class="menuImg mr-5"> <?= lang('pos');?></a></li>
				<li><a href="<?= base_url(isset($this->link['pos_settings_link'])?$this->link['pos_settings_link']:'');?>" class="<?= isset($page_title) && $page_title=="POS Settings"?"active":"";?>"><i class="icofont-ui-settings mr-3"></i> <?= lang('settings');?></a></li>
			</ul>
		</div>
	</div>
	 <?php if (auth('is_staff')==true) : ?>
		<div class="col-md-6">
			<div class="posStaff text-right pr-10">
				<p><?= lang('total_orders');?> : <?= $this->admin_m->get_staff_orders_activities(staff_info()->id,'total')['total'];?></p>
				<p><?= lang('todays_orders');?> : <?= $this->admin_m->get_staff_orders_activities(staff_info()->id,'today')['total'];?></p>
			</div>
		</div>
	<?php endif; ?>
</div>

<script>
	$(document).on('click','.expand',function(){
		$('.posMenu').toggleClass('active');
	})
</script>