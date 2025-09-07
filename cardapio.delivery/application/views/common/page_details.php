<?php include APPPATH . "views/common_layouts/topMenu.php"; ?>
<div class="terms_page vendorPagae">
	<div class="container">
		<?php if (isset($spage) && !empty($spage)): ?>
			<div class="single_page">
				<div class="page_title mb-20">
					<h4><?= $spage->title ?? ''; ?></h4>
				</div>
				<div class="pageDetails">
					<?= $spage->details ?? ''; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="empty_area">
				<i class="fa fa-frown-o"></i>
				<p><?= __('not_found'); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>