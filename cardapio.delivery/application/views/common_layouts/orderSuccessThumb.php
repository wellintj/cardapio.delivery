<?php $getData = $this->input->get(null, TRUE); ?>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="successMsgArea single__page__order">
				<div class="successMsg singleSuccessPage <?= isset($shop['is_order_qr']) && $shop["is_order_qr"] == 0 ? 'deactiveorderQr' : ''; ?>">
					<div class="confirmMsgArea">
						<i class="icofont-check-circled fa-3x successIcon success-light"></i>
						<h4><?= !empty(lang('order_confirmed')) ? lang('order_confirmed') : 'order confirmed'; ?>.</h4>
						<h5> <?= !empty(lang('your_order_id')) ? lang('your_order_id') : 'your order id'; ?>: #<span class="order_id"><?= $order_id; ?></span></h5>
						<p><?= !empty(lang('track_your_order_using_phone')) ? lang('track_your_order_using_phone') : 'You can track you order using your phone number'; ?></p>
						<?php if (isset($getData['txn_id'])): ?>
							<p><?= __('txn_id'); ?> : <?= $getData['txn_id']; ?></p>
						<?php endif; ?>
						<?php if (isset($getData['method'])): ?>
							<p><?= __('payment_by'); ?> : <?= $getData['method']; ?></p>
						<?php endif; ?>
						<?php if (!empty($qr_link)): ?>

							<div class="qr_link">
								<img src="<?= base_url($qr_link); ?>" alt="qrCode" id="qr_link">
								<a href="<?= base_url($qr_link); ?>" download target="blank" data-link="<?= base_url($qr_link); ?>" class="qrDownloadBtn" id="downloadLink" data-placement="top" data-toggle="tooltip" title="Download Qr for Quick access your order"><i class="fa fa-download"></i> <?= !empty(lang('download')) ? lang('download') : 'download'; ?></a>

							</div>
						<?php else: ?>
							<div class="mt-20 h-25px"></div>
						<?php endif; ?>

						<?php if (isset($is_whatsapp) && $is_whatsapp == 1): ?>
							<div class="whatsapp_share_data">
								<div class="whatsapp_share">
									<a href='<?= base_url("profile/whatsapp/{$order_id}"); ?>' style="text-decoration:none" data-action="share/whatsapp/share" class="redirect_whatsapp">
										<div>
											<i class="fa fa-whatsapp"></i>&nbsp;&nbsp;<?= lang('order_on_whatsapp'); ?>
										</div>
									</a>
								</div>
							</div>
						<?php endif ?>

					</div>
					<div class="trackLink">
						<a href="<?= $track_link; ?>" id="track_order_btn" target="blank" class="fz-14"><?= lang('track_order'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>