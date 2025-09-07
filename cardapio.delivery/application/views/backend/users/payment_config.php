<div class="row resoponsiveRow">
	<?php include APPPATH . 'views/backend/users/inc/leftsidebar.php'; ?>
	<?php if (check() == 1 && $this->security->online_payment() == 1) : ?>
		<div class="col-md-7">
			<div class="card">
				<div class="card-header">
					<h4><?= lang('payment_gateway'); ?></h4>
				</div>
				<div class="card-body">
					<div class="payemt_list">
						<div class="table-responsive">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th><?= lang('name'); ?></th>
										<th><?= lang('status'); ?></th>
										<th><?= lang('action'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									foreach (payment_methods() as $key => $value) : ?>

										<tr>
											<td><?= $i; ?></td>
											<td><?= $value['name']; ?></td>
											<td>
												<?php if ($settings[$value['active_slug']] == 1) : ?>
													<span class="label bg-success-soft"><i class="fa fa-check c_green"></i> &nbsp;<?= lang('installed'); ?></span>
												<?php else : ?>
													<span class="label bg-danger-soft"><i class="fa fa-ban c_red"></i> &nbsp;<?= lang('not_installed'); ?></span>
												<?php endif; ?>
											</td>
											<td>
												<?php if ($settings[$value['active_slug']] == 1) : ?>
													<a href="<?= base_url("{$install_url}{$value['active_slug']}/0"); ?>" class="label label-danger action_btn" data-msg="click to uninstall"><i class="icofont-ban"></i> <?= lang('uninstall'); ?></a>
												<?php else : ?>
													<a href='<?= base_url("{$install_url}{$value['active_slug']}/1"); ?>' class="label label-success action_btn" data-msg="click to install"><i class="icofont-hand-drag1"></i> <?= lang('install'); ?></a>
												<?php endif; ?>
											</td>
										</tr>
									<?php $i++;
									endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<form class="email_setting_form mt-50" action="<?= base_url('admin/restaurant/add_payment_method'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
				<?= csrf(); ?>
				<?php if (shop_active('paypal_status') == 1) : ?>
					<div class="card">
						<div class="card-header">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/paypal.svg'); ?>" alt="pMethod">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="form-group  col-md-6 col-sm-6 col-xs-6">
									<?php $paypal = json_decode(restaurant()->paypal_config); ?>
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Paypal Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_paypal" class="" value="1" <?= isset($settings['is_paypal']) && $settings['is_paypal'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>

								<div class="form-group  col-md-12 col-sm-12 col-xs-12">
									<label for=""><?= !empty(lang('paypal_environment')) ? lang('paypal_environment') : "Paypal Environment"; ?></label>
									<div class="">
										<select name="is_live" class="form-control">
											<option value="0" <?= isset($paypal->is_live) && $paypal->is_live == 0 ? "selected" : ""; ?>><?= lang('sandbox'); ?></option>
											<option value="1" <?= isset($paypal->is_live) && $paypal->is_live == 1 ? "selected" : ""; ?>><?= lang('live'); ?></option>
										</select>
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('paypal_email')) ? lang('paypal_email') : "Paypal Email"; ?></label>
										<div class="">
											<input type="text" name="paypal_email" placeholder="<?= !empty(lang('paypal_business_email')) ? lang('paypal_business_email') : "Paypal Business Email"; ?>" class="form-control" value="<?= !empty($paypal->paypal_email) ? html_escape($paypal->paypal_email) : '';  ?>">
										</div>
									</div>
								</div>

							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>
				<?php if (shop_active('stripe_status') == 1) : ?>
					<div class="card">
						<div class="card-header">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/stripe.svg'); ?>" alt="pMethod">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $stripe =  json_decode(restaurant()->stripe_config); ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('stripe_payment')) ? lang('stripe_payment') : "Stripe Payment Gateway"; ?></label>
									<div class="">
										<input type="checkbox" name="is_stripe" class="" value="1" <?= isset($settings['is_stripe']) && $settings['is_stripe'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('stripe_public_key')) ? lang('stripe_public_key') : "Stripe Public key"; ?></label>
										<div class="">
											<input type="text" name="public_key" placeholder="<?= !empty(lang('stripe_public_key')) ? lang('stripe_public_key') : "Stripe Public key"; ?>" class="form-control" value="<?= !empty($stripe->public_key) ? html_escape($stripe->public_key) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('stripe_secret_key')) ? lang('stripe_secret_key') : "Stripe Secret key"; ?></label>
										<div class="">
											<input type="text" name="secret_key" placeholder="<?= !empty(lang('stripe_secret_key')) ? lang('stripe_secret_key') : "Stripe Secret key"; ?>" class="form-control" value="<?= !empty($stripe->secret_key) ? html_escape($stripe->secret_key) : '';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>
				<?php if (shop_active('razorpay_status') == 1) : ?>
					<div class="card">
						<div class="card-header">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/razorpay.svg'); ?>" alt="pMethod">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="form-group  col-md-6 col-sm-6 col-xs-6">
									<?php $razorpay = json_decode(restaurant()->razorpay_config); ?>
									<label for=""><?= !empty(lang('razorpay_payment')) ? lang('razorpay_payment') : "razorpay Payment"; ?></label>
									<div class="">
										<input type="checkbox" name="is_razorpay" class="" value="1" <?= isset($settings['is_razorpay']) && $settings['is_razorpay'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('razorpay_key_id')) ? lang('razorpay_key_id') : "Razorpay Key Id"; ?></label>
										<div class="">
											<input type="text" name="razorpay_key_id" placeholder="<?= !empty(lang('razorpay_key_id')) ? lang('razorpay_key_id') : "Razorpay key"; ?>" class="form-control" value="<?= !empty($razorpay->razorpay_key_id) ? html_escape($razorpay->razorpay_key_id) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('secret_key')) ? lang('secret_key') : "Secret Key"; ?></label>
										<div class="">
											<input type="text" name="razorpay_key" placeholder="<?= !empty(lang('razorpay_key')) ? lang('razorpay_key') : "Razorpay Key"; ?>" class="form-control" value="<?= !empty($razorpay->razorpay_key) ? html_escape($razorpay->razorpay_key) : '';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>
				<?php if (shop_active('stripe_fpx_status') == 1) : ?>
					<div class="card">
						<div class="card-header mt-1">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/fpx.png'); ?>" alt="pMethod">
							</div>
						</div>
						<?php $fpx = !empty($settings['fpx_config']) ? json_decode($settings['fpx_config']) : ''; ?>
						<div class="card-body">
							<div class="row">
								<div class="form-group  col-md-6 col-sm-6 col-xs-6">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_fpx" class="" value="1" <?= isset($settings['is_fpx']) && $settings['is_fpx'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('public_key')) ? lang('public_key') : "Public Key"; ?></label>
										<div class="">
											<input type="text" name="fpx_public_key" placeholder="<?= !empty(lang('public_key')) ? lang('public_key') : "Public key"; ?>" class="form-control" value="<?= !empty($fpx->fpx_public_key) ? html_escape($fpx->fpx_public_key) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('secret_key')) ? lang('secret_key') : "Secret Key"; ?></label>
										<div class="">
											<input type="text" name="fpx_secret_key" placeholder="<?= !empty(lang('secret_key')) ? lang('secret_key') : "Secret Key"; ?>" class="form-control" value="<?= !empty($fpx->fpx_secret_key) ? html_escape($fpx->fpx_secret_key) : '';  ?>">
										</div>
									</div>
								</div>

							</div>

						</div><!-- card-body -->

					</div><!-- card -->
				<?php endif; ?>

				<?php if (shop_active('mercado_status') == 1) : ?>
					<div class="card">
						<div class="card-header mt-1">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/mercado_pago.svg'); ?>" alt="pMethod">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $mercado = !empty($settings['mercado_config']) ? json_decode($settings['mercado_config']) : ''; ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_mercado" class="" value="1" <?= isset($settings['is_mercado']) && $settings['is_mercado'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('public_key')) ? lang('public_key') : "Public key"; ?></label>
										<div class="">
											<input type="text" name="mercado_public_key" placeholder="<?= !empty(lang('public_key')) ? lang('public_key') : "Public key"; ?>" class="form-control" value="<?= !empty($mercado->mercado_public_key) ? html_escape($mercado->mercado_public_key) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('access_token')) ? lang('access_token') : "Access Token"; ?></label>
										<div class="">
											<input type="text" name="access_token" placeholder="<?= !empty(lang('access_token')) ? lang('access_token') : "Access Token"; ?>" class="form-control" value="<?= !empty($mercado->access_token) ? html_escape($mercado->access_token) : '';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>

				<?php if (shop_active('mercado_status') == 1) : ?>
					<!-- PIX Dinâmico - Mercado Pago -->
					<div class="card">
						<div class="card-header">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/mercado_pix.png'); ?>" alt="PIX Dinâmico" style="width: 32px; height: 32px;">
								<span class="ml-2">PIX Dinâmico - Mercado Pago</span>
							</div>
							<small class="text-muted d-block mt-1">Pagamento PIX instantâneo com QR Code automático</small>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="form-group col-md-6 col-sm-6 col-xs-12">
									<label><?= function_exists('lang') ? htmlspecialchars(lang('status')) : 'Status'; ?></label>
									<div>
										<input type="checkbox"
											   name="is_mercado_pix"
											   id="is_mercado_pix"
											   value="1"
											   <?= isset($settings['is_mercado_pix']) && $settings['is_mercado_pix'] == 1 ? 'checked' : ''; ?>
											   data-toggle="toggle"
											   data-on='<i class="fa fa-check"></i> <?= function_exists('lang') ? htmlspecialchars(lang('active')) : 'Ativo'; ?>'
											   data-off='<i class="fa fa-pause"></i> <?= function_exists('lang') ? htmlspecialchars(lang('off')) : 'Desligado'; ?>'>
									</div>
									<small class="text-muted">Ativar PIX dinâmico</small>
								</div>
								<div class="form-group col-md-6 col-sm-6 col-xs-12">
									<label>Validação</label>
									<div>
										<button type="button" class="btn btn-info btn-sm" id="validate-mercado-credentials">
											<i class="fa fa-check-circle"></i> Validar Credenciais
										</button>
										<div id="validation-result" class="mt-2"></div>
									</div>
									<small class="text-muted">Verificar configuração do Mercado Pago</small>
								</div>
							</div>
						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>

				<?php if (shop_active('paytm_status') == 1) : ?>
					<div class="card">
						<div class="card-header mt-1">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/paytm.svg'); ?>" alt="pMethod">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $paytm = !empty($settings['paytm_config']) ? json_decode($settings['paytm_config']) : ''; ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_paytm" class="" value="1" <?= isset($settings['is_paytm']) && $settings['is_paytm'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="form-group  col-md-12 col-sm-12 col-xs-12">
									<label for=""><?= !empty(lang('environment')) ? lang('environment') : "Environment"; ?></label>
									<div class="">
										<select name="is_paytm_live" class="form-control">
											<option value="0" <?= isset($paytm->is_paytm_live) && $paytm->is_paytm_live == 0 ? "selected" : ""; ?>><?= lang('sandbox'); ?></option>
											<option value="1" <?= isset($paytm->is_paytm_live) && $paytm->is_paytm_live == 1 ? "selected" : ""; ?>><?= lang('live'); ?></option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('merchand_id')) ? lang('merchand_id') : "Merchand ID"; ?></label>
										<div class="">
											<input type="text" name="merchant_id" placeholder="<?= !empty(lang('merchant_id')) ? lang('merchant_id') : "Merchant ID"; ?>" class="form-control" value="<?= !empty($paytm->merchant_id) ? html_escape($paytm->merchant_id) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('merchant_key')) ? lang('merchant_key') : "Merchant Key"; ?></label>
										<div class="">
											<input type="text" name="merchant_key" placeholder="<?= !empty(lang('merchant_key')) ? lang('merchant_key') : "Merchant Key"; ?>" class="form-control" value="<?= !empty($paytm->merchant_key) ? html_escape($paytm->merchant_key) : '';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>
				<?php if (shop_active('flutterwave_status') == 1) : ?>
					<div class="card">
						<div class="card-header mt-1">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/flutterwave.svg'); ?>" alt="pMethod">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $flutterwave = !empty($settings['flutterwave_config']) ? json_decode($settings['flutterwave_config']) : ''; ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_flutterwave" class="" value="1" <?= isset($settings['is_flutterwave']) && $settings['is_flutterwave'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="form-group  col-md-12 col-sm-12 col-xs-12">
									<label for=""><?= !empty(lang('environment')) ? lang('environment') : "Environment"; ?></label>
									<div class="">
										<select name="is_flutterwave_live" class="form-control">
											<option value="0" <?= isset($flutterwave->is_flutterwave_live) && $flutterwave->is_flutterwave_live == 0 ? "selected" : ""; ?>><?= lang('sandbox'); ?></option>
											<option value="1" <?= isset($flutterwave->is_flutterwave_live) && $flutterwave->is_flutterwave_live == 1 ? "selected" : ""; ?>><?= lang('live'); ?></option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('public_key')) ? lang('public_key') : "Public Key"; ?></label>
										<div class="">
											<input type="text" name="fw_public_key" placeholder="<?= !empty(lang('public_key')) ? lang('public_key') : "Merchant ID"; ?>" class="form-control" value="<?= !empty($flutterwave->fw_public_key) ? html_escape($flutterwave->fw_public_key) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('secret_key')) ? lang('secret_key') : "Secret key"; ?></label>
										<div class="">
											<input type="text" name="fw_secret_key" placeholder="<?= !empty(lang('secret_key')) ? lang('secret_key') : "Secret key"; ?>" class="form-control" value="<?= !empty($flutterwave->fw_secret_key) ? html_escape($flutterwave->fw_secret_key) : '';  ?>">
										</div>
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('encryption_key')) ? lang('encryption_key') : "Encryption Key "; ?></label>
										<div class="">
											<input type="text" name="encryption_key" placeholder="<?= !empty(lang('encryption_key')) ? lang('encryption_key') : "Encryption Key "; ?>" class="form-control" value="<?= !empty($flutterwave->encryption_key) ? html_escape($flutterwave->encryption_key) : '';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>

				<?php if (shop_active('paystack_status') == 1) : ?>
					<div class="card">
						<div class="card-header mt-1">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/paystack.svg'); ?>" alt="pMethod">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $paystack =  json_decode(restaurant()->paystack_config); ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_paystack" class="" value="1" <?= isset($settings['is_paystack']) && $settings['is_paystack'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('paystack_public_key')) ? lang('paystack_public_key') : "paystack Public key"; ?></label>
										<div class="">
											<input type="text" name="paystack_public_key" placeholder="<?= !empty(lang('paystack_public_key')) ? lang('paystack_public_key') : "paystack Public key"; ?>" class="form-control" value="<?= !empty($paystack->paystack_public_key) ? html_escape($paystack->paystack_public_key) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('paystack_secret_key')) ? lang('paystack_secret_key') : "paystack Secret key"; ?></label>
										<div class="">
											<input type="text" name="paystack_secret_key" placeholder="<?= !empty(lang('paystack_secret_key')) ? lang('paystack_secret_key') : "paystack Secret key"; ?>" class="form-control" value="<?= !empty($paystack->paystack_secret_key) ? html_escape($paystack->paystack_secret_key) : '';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>


				<?php if (shop_active('pagadito_status') == 1) : ?>
					<div class="card pagadito">
						<div class="card-header mt-1">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/pagadito.svg'); ?>" alt="Pagadito">
							</div>
						</div>
						<div class="card-body">

							<div class="row">
								<div class="col-md-12">
									<h4>Return URL</h4>
									<p><?= base_url('pagadito-success/?token={value}&idca={ern_value}') ?></p>
								</div>
							</div>

							<div class="row">
								<?php $pagadito = !empty(restaurant()->pagadito_config) ? json_decode(restaurant()->pagadito_config) : ""; ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_pagadito" class="" value="1" <?= isset($settings['is_pagadito']) && $settings['is_pagadito'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
								<div class="form-group  col-md-12 col-sm-12 col-xs-12">
									<label for=""><?= !empty(lang('environment')) ? lang('environment') : "Environment"; ?></label>
									<div class="">
										<select name="is_pagadito_live" class="form-control">
											<option value="0" <?= isset($pagadito->is_pagadito_live) && $pagadito->is_pagadito_live == 0 ? "selected" : ""; ?>><?= lang('sandbox'); ?></option>
											<option value="1" <?= isset($pagadito->is_pagadito_live) && $pagadito->is_pagadito_live == 1 ? "selected" : ""; ?>><?= lang('live'); ?></option>
										</select>
									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('pagadito_uid')) ? lang('pagadito_uid') : "Pagadito UID"; ?></label>
										<div class="">
											<input type="text" name="pagadito_uid" placeholder="<?= !empty(lang('pagadito_uid')) ? lang('pagadito_uid') : "paystack Public key"; ?>" class="form-control" value="<?= !empty($pagadito->pagadito_uid) ? html_escape($pagadito->pagadito_uid) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('pagadito_wsk_key')) ? lang('pagadito_wsk_key') : "Pagadito WSK key"; ?></label>
										<div class="">
											<input type="text" name="pagadito_wsk_key" placeholder="<?= !empty(lang('pagadito_wsk_key')) ? lang('pagadito_wsk_key') : "paystack Secret key"; ?>" class="form-control" value="<?= !empty($pagadito->pagadito_wsk_key) ? html_escape($pagadito->pagadito_wsk_key) : '';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>

				<?php if (shop_active('netseasy_status') == 1) : ?>
					<?php $netseasy = 'netseasy'; ?>
					<div class="card netseasy">
						<div class="card-header mt-1">
							<div class="paymentImg">
								<img src="<?php echo base_url("assets/frontend/images/payout/{$netseasy}.svg"); ?>" alt="<?= $netseasy; ?>">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $netseasy = !empty(restaurant()->netseasy_config) ? json_decode(restaurant()->netseasy_config) : ""; ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_netseasy" class="" value="1" <?= isset($settings['is_netseasy']) && $settings['is_netseasy'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
								<div class="form-group  col-md-12 col-sm-12 col-xs-12">
									<label for=""><?= !empty(lang('environment')) ? lang('environment') : "Environment"; ?></label>
									<div class="">
										<select name="is_netseasy_live" class="form-control">
											<option value="0" <?= isset($netseasy->is_netseasy_live) && $netseasy->is_netseasy_live == 0 ? "selected" : ""; ?>><?= lang('sandbox'); ?></option>
											<option value="1" <?= isset($netseasy->is_netseasy_live) && $netseasy->is_netseasy_live == 1 ? "selected" : ""; ?>><?= lang('live'); ?></option>
										</select>
									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('merchant_id')) ? lang('merchant_id') : "merchant id"; ?></label>
										<div class="">
											<input type="text" name="netseasy_merchant_id" placeholder="<?= !empty(lang('merchant_id')) ? lang('merchant_id') : "merchant id"; ?>" class="form-control" value="<?= !empty($netseasy->netseasy_merchant_id) ? html_escape($netseasy->netseasy_merchant_id) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('secret_key')) ? lang('secret_key') : "secret_key"; ?></label>
										<div class="">
											<input type="text" name="netseasy_secret_key" placeholder="<?= !empty(lang('secret_key')) ? lang('secret_key') : "paystack Secret key"; ?>" class="form-control" value="<?= !empty($netseasy->netseasy_secret_key) ? html_escape($netseasy->netseasy_secret_key) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('checkout_key')) ? lang('checkout_key') : "checkout key"; ?></label>
										<div class="">
											<input type="text" name="netseasy_checkout_key" placeholder="<?= !empty(lang('checkout_key')) ? lang('checkout_key') : "Checkout key"; ?>" class="form-control" value="<?= !empty($netseasy->netseasy_checkout_key) ? html_escape($netseasy->netseasy_checkout_key) : '';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>

				<?php if (shop_active('moyasar_status') == 1) : ?>
					<div class="card moyasar">
						<div class="card-header mt-1">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/moyasar.svg'); ?>" alt="pMethod">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $moyasar = isJson($settings['moyasar_config']) ? json_decode($settings['moyasar_config']) : ''; ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_moyasar" class="" value="1" <?= isset($settings['is_moyasar']) && $settings['is_moyasar'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('public_key')) ? lang('public_key') : "Public key"; ?></label>
										<div class="">
											<input type="text" name="moyasar_public_key" placeholder="<?= lang('public_key'); ?>" class="form-control" value="<?= !empty($moyasar->moyasar_public_key) ? html_escape($moyasar->moyasar_public_key) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('secret_key')) ? lang('secret_key') : "Secret key"; ?></label>
										<div class="">
											<input type="text" name="moyasar_secret_key" placeholder="<?= lang('secret_key'); ?>" class="form-control" value="<?= !empty($moyasar->moyasar_secret_key) ? html_escape($moyasar->moyasar_secret_key) : '';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>

				<?php if (shop_active('midtrans_status') == 1) : ?>
					<div class="card midtrans">
						<div class="card-header mt-1">
							<div class="paymentImg" style="background-color: #002855; padding: 2px 10px; border-radius:.2rem;">
								<img src="<?php echo base_url('assets/frontend/images/payout/midtrans.svg'); ?>" alt="pMethod">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $midtrans = !empty($settings['midtrans_config']) ? json_decode($settings['midtrans_config']) : ''; ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_midtrans" class="" value="1" <?= isset($settings['is_midtrans']) && $settings['is_midtrans'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="form-group  col-md-12 col-sm-12 col-xs-12">
									<label for=""><?= !empty(lang('environment')) ? lang('environment') : "Environment"; ?></label>
									<div class="">
										<select name="is_midtrans_live" class="form-control">
											<option value="0" <?= isset($midtrans->is_midtrans_live) && $midtrans->is_midtrans_live == 0 ? "selected" : ""; ?>>
												<?= lang('sandbox'); ?></option>
											<option value="1" <?= isset($midtrans->is_midtrans_live) && $midtrans->is_midtrans_live == 1 ? "selected" : ""; ?>>
												<?= lang('live'); ?></option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('client_key')) ? lang('client_key') : "Client Key"; ?></label>
										<div class="">
											<input type="text" name="client_key" placeholder="<?= !empty(lang('client_key')) ? lang('client_key') : "Client Key"; ?>" class="form-control" value="<?= !empty($midtrans->client_key) ? html_escape($midtrans->client_key) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('server_key')) ? lang('server_key') : "Server Key"; ?></label>
										<div class="">
											<input type="text" name="server_key" placeholder="<?= !empty(lang('server_key')) ? lang('server_key') : "Server Key"; ?>" class="form-control" value="<?= !empty($midtrans->server_key) ? html_escape($midtrans->server_key) : '';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>


				<?php if (shop_active('cashfree_status') == 1) : ?>
					<div class="card cashfree">
						<div class="card-header mt-1">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/cashfree.png'); ?>" alt="pMethod">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $cashfree = !empty($settings['cashfree_config']) ? json_decode($settings['cashfree_config']) : ''; ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_cashfree" class="" value="1" <?= isset($settings['is_cashfree']) && $settings['is_cashfree'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="form-group  col-md-12 col-sm-12 col-xs-12">
									<label for=""><?= !empty(lang('environment')) ? lang('environment') : "Environment"; ?></label>
									<div class="">
										<select name="is_cashfree_live" class="form-control">
											<option value="0" <?= isset($cashfree->is_cashfree_live) && $cashfree->is_cashfree_live == 0 ? "selected" : ""; ?>>
												<?= lang('sandbox'); ?></option>
											<option value="1" <?= isset($cashfree->is_cashfree_live) && $cashfree->is_cashfree_live == 1 ? "selected" : ""; ?>>
												<?= lang('live'); ?></option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('app_id')) ? lang('app_id') : "App ID"; ?></label>
										<div class="">
											<input type="text" name="cashfree_app_id" placeholder="<?= !empty(lang('app_id')) ? lang('app_id') : "App ID"; ?>" class="form-control" value="<?= !empty($cashfree->cashfree_app_id) ? html_escape($cashfree->cashfree_app_id) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('secret_key')) ? lang('secret_key') : "Secret Key"; ?></label>
										<div class="">
											<input type="text" name="cashfree_secret_key" placeholder="<?= !empty(lang('secret_key')) ? lang('secret_key') : "secret Key"; ?>" class="form-control" value="<?= !empty($cashfree->cashfree_secret_key) ? html_escape($cashfree->cashfree_secret_key) : '';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>


				<?php if (shop_active('myfatoorah_status') == 1) : ?>
					<div class="card myfatoorah">
						<div class="card-header mt-1">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/myfatoorah.png'); ?>" alt="pMethod">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $myfatoorah = !empty($settings['myfatoorah_config']) ? json_decode($settings['myfatoorah_config']) : ''; ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_myfatoorah" class="" value="1" <?= isset($settings['is_myfatoorah']) && $settings['is_myfatoorah'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="form-group  col-md-6 col-sm-6 col-xs-6">
									<label for=""><?= !empty(lang('environment')) ? lang('environment') : "Environment"; ?></label>
									<div class="">
										<select name="is_myfatoorah_live" class="form-control">
											<option value="0" <?= isset($myfatoorah->is_myfatoorah_live) && $myfatoorah->is_myfatoorah_live == 0 ? "selected" : ""; ?>>
												<?= lang('sandbox'); ?></option>
											<option value="1" <?= isset($myfatoorah->is_myfatoorah_live) && $myfatoorah->is_myfatoorah_live == 1 ? "selected" : ""; ?>>
												<?= lang('live'); ?></option>
										</select>
									</div>
								</div>

								<div class="form-group  col-md-6 col-sm-6 col-xs-6">
									<?php $vcCode = ['KWT', 'SAU', 'ARE', 'QAT', 'BHR', 'OMN', 'JOD',  'EGY']; ?>
									<label for=""><?= !empty(lang('vcCode')) ? lang('vcCode') : "vcCode"; ?></label>
									<div class="">
										<select name="vccode" class="form-control">
											<?php foreach ($vcCode as  $key => $vc): ?>
												<option value="<?= $vc; ?>" <?= isset($myfatoorah->vccode) && $myfatoorah->vccode == $vc ? "selected" : ""; ?>><?= $vc; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('api_key')) ? lang('api_key') : "API key"; ?></label>
										<div class="">
											<input type="text" name="myfatoorah_api_key" placeholder="<?= !empty(lang('api_key')) ? lang('api_key') : "API key"; ?>" class="form-control" value="<?= !empty($myfatoorah->myfatoorah_api_key) ? html_escape($myfatoorah->myfatoorah_api_key) : '';  ?>">
										</div>
									</div>
								</div>

							</div>

						</div><!-- card-body -->
					</div><!-- card -->
				<?php endif; ?>


				<?php if (shop_active('pix_status') == 1) : ?>
					<div class="card">
						<div class="card-header mt-1">
							<div class="paymentImg">
								<img src="<?php echo base_url('assets/frontend/images/payout/pix.png'); ?>" alt="PIX">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $pix_config = !empty($settings['pix_config']) ? json_decode($settings['pix_config']) : ''; ?>
								<div class="form-group col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status')) ? lang('status') : "Status"; ?></label>
									<div class="">
										<input type="checkbox" name="is_pix" class="" value="1" <?= isset($settings['is_pix']) && $settings['is_pix'] == 1 ? 'checked' : ''; ?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">
									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class=""><?= !empty(lang('pix_key')) ? lang('pix_key') : "Chave PIX"; ?></label>
										<div class="">
											<input type="text" name="pix_key" placeholder="<?= !empty(lang('pix_key')) ? lang('pix_key') : "Chave PIX (CPF, CNPJ, Email, Telefone ou Chave Aleatória)"; ?>" class="form-control" value="<?= !empty($pix_config->pix_key) ? html_escape($pix_config->pix_key) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class=""><?= !empty(lang('city')) ? lang('city') : "Cidade"; ?></label>
										<div class="">
											<input type="text" name="pix_city" placeholder="<?= !empty(lang('city')) ? lang('city') : "Cidade"; ?>" class="form-control" value="<?= !empty($pix_config->city) ? html_escape($pix_config->city) : '';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('pix_description')) ? lang('pix_description') : "Descrição do PIX"; ?></label>
										<div class="">
											<input type="text" name="pix_description" placeholder="<?= !empty(lang('pix_description')) ? lang('pix_description') : "Descrição (opcional)"; ?>" class="form-control" value="<?= !empty($pix_config->pix_description) ? html_escape($pix_config->pix_description) : '';  ?>">
											<p class="text-muted"><small><?= !empty(lang('pix_description_help')) ? lang('pix_description_help') : "Esta descrição aparecerá no extrato do cliente"; ?></small></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="card-footer">
					<input type="hidden" name="id" value="<?= isset($settings['id']) ? html_escape($settings['id']) : 0; ?>">
					<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change')) ? lang('save_change') : 'Save Change'; ?></button>
				</div>
			</form>
		</div><!-- col-9 -->
	<?php endif; ?>
</div>



<div id="methodModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<form action="<?= base_url("admin/auth/add_offline_method") ?>" method="post">
			<?= csrf(); ?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?= __('offline_payment'); ?></h4>
				</div>
				<div class="modal-body">
					<input type="text" name="name" class="form-control" placeholder="<?= __('offline_payment'); ?>">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-block"><?= __('submit'); ?></button>
				</div>
			</div>
		</form>

	</div>
</div>

<script>
$(document).ready(function() {
	// Validação de credenciais do Mercado Pago para PIX dinâmico
	$('#validate-mercado-credentials').click(function() {
		var button = $(this);
		var resultDiv = $('#validation-result');

		// Desabilitar botão e mostrar loading
		button.prop('disabled', true);
		button.html('<i class="fa fa-spinner fa-spin"></i> Validando...');
		resultDiv.html('');

		$.ajax({
			url: '<?= base_url('admin/restaurant/validate_mercado_credentials'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {
				'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
			},
			success: function(response) {
				if (response.valid) {
					resultDiv.html('<div class="alert alert-success alert-sm mt-2">' +
						'<i class="fa fa-check-circle"></i> ' + response.message +
						(response.account_info ? '<br><small>País: ' + response.account_info.country + ' | Site: ' + response.account_info.site + '</small>' : '') +
						'</div>');
				} else {
					resultDiv.html('<div class="alert alert-danger alert-sm mt-2">' +
						'<i class="fa fa-exclamation-triangle"></i> ' + response.error +
						'</div>');
				}
			},
			error: function() {
				resultDiv.html('<div class="alert alert-danger alert-sm mt-2">' +
					'<i class="fa fa-exclamation-triangle"></i> Erro ao validar credenciais. Tente novamente.' +
					'</div>');
			},
			complete: function() {
				// Reabilitar botão
				button.prop('disabled', false);
				button.html('<i class="fa fa-check-circle"></i> Validar Configuração');
			}
		});
	});
});
</script>