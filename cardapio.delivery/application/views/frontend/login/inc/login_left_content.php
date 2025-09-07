<?php $settings = settings(); ?>
<?php $site = section_name('description'); ?>
<div class="left_login_page login_banner" style="background: url(<?= base_url('assets/frontend/images/login_banner.jpg'); ?>);">
	<div class="left_top_login">
		<h4><?= $settings['site_name']; ?></h4>
		<p><?= isset($site['sub_heading']) && !empty($site['sub_heading']) ? $site['sub_heading'] : (!empty($settings['long_description']) ? $settings['long_description'] : $settings['description']); ?></p>
		<?php $home_setting = isJson($settings['social_sites']) ? json_decode($settings['social_sites'], TRUE) : ''; ?>
		<div class="left_footer">
			<ul class="">
				<?php if (isset($home_setting['facebook']) && !empty($home_setting['facebook'])): ?>
					<li><a href="<?= redirect_url($home_setting['facebook'], 'facebook'); ?>"><i class="fa fa-facebook facebook"></i></a></li>
				<?php endif; ?>

				<?php if (!empty($home_setting['instagram'])): ?>
					<li><a href="<?= redirect_url($home_setting['instagram'], 'instagram'); ?>"><i class="fa fa-instagram instagram"></i></a></li>
				<?php endif; ?>

				<?php if (isset($home_setting['whatsapp']) && !empty($home_setting['whatsapp'])): ?>
					<li><a href="<?= redirect_url($home_setting['whatsapp'], 'whatsapp', admin()->dial_code, base_url()); ?>"><i class="fa fa-whatsapp whatsapp"></i></a></li>
				<?php endif; ?>

				<?php if (isset($home_setting['linkedin']) && !empty($home_setting['linkedin'])): ?>
					<li><a href="<?= redirect_url($home_setting['linkedin'], 'linkedin'); ?>"><i class="fa fa-linkedin linkedin"></i></a></li>
				<?php endif; ?>


				<?php if (isset($home_setting['phone']) && !empty($home_setting['phone'])): ?>
					<li><a href="<?= redirect_url($home_setting['phone'], 'phone', admin()->dial_code); ?>"><i class="fa fa-phone phone"></i></a></li>
				<?php endif; ?>

				<?php if (isset($home_setting['tiktok']) && !empty($home_setting['tiktok'])): ?>
					<li><a href="<?= redirect_url($home_setting['tiktok'], 'tiktok'); ?>"><i class="fab fa-tiktok youtube"></i></a></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>