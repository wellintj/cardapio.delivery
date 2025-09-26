	<?php $shop_info = $this->common_m->shop_info($shop_id); ?>
	<?php $dial_code = $shop_info['dial_code'] ?? '1'; ?>
	<?php $guest = isJson($shop_info['guest_config']) ? json_decode($shop_info['guest_config']) : ''; ?>
	<?php $extra_config = extra_settings($shop_info['user_id']); ?>
	<style>
		.customPhone .group-color {
			border-radius: 0 !important;
		}

		/* Brazilian Delivery Payment Options Styles */
		.delivery-payment-section {
			background: #f8f9fa;
			border-radius: 8px;
			padding: 20px;
			border: 1px solid #e9ecef;
		}

		.delivery-payment-section h5 {
			color: #495057;
			font-weight: 600;
			margin-bottom: 15px;
		}

		.delivery-payment-option {
			cursor: pointer;
			margin-bottom: 0;
			width: 100%;
		}

		.delivery-payment-option input[type="radio"] {
			display: none;
		}

		.payment-option-card {
			display: flex;
			align-items: center;
			padding: 15px;
			border: 2px solid #e9ecef;
			border-radius: 8px;
			background: white;
			transition: all 0.3s ease;
			min-height: 70px;
		}

		.payment-option-card:hover {
			border-color: #007bff;
			box-shadow: 0 2px 8px rgba(0,123,255,0.15);
		}

		.delivery-payment-option input[type="radio"]:checked + .payment-option-card {
			border-color: #007bff;
			background: #f8f9ff;
			box-shadow: 0 2px 8px rgba(0,123,255,0.15);
		}

		.payment-icon {
			margin-right: 12px;
			flex-shrink: 0;
		}

		.payment-info h6 {
			margin: 0 0 4px 0;
			font-weight: 600;
			color: #495057;
			font-size: 14px;
		}

		.payment-info small {
			font-size: 12px;
			line-height: 1.3;
		}

		@media (max-width: 768px) {
			.payment-option-card {
				padding: 12px;
				min-height: 60px;
			}

			.payment-info h6 {
				font-size: 13px;
			}

			.payment-info small {
				font-size: 11px;
			}
		}

		/* Error styling for insufficient payment amount */
		#customer_payment_amount.error {
			border-color: #d73925;
			box-shadow: 0 0 0 0.2rem rgba(215, 57, 37, 0.25);
		}
	</style>
	<div class="step_1">
		<span class="reg_msg"></span>

		<?php if (isset($shop_info['is_customer_login']) && $shop_info['is_customer_login'] == 0) : ?>
			<div class="customerInfo <?= !empty(temp('is_table')) ? "hidden" : ""; ?>">
				<div class="row">
					<div class="form-group col-md-6">
						<label for=""><?= lang('name'); ?> <span class="error">*</span></label>
						<input type="text" name="name" class="form-control" placeholder="<?= lang('name'); ?>">
					</div>
					<div class="form-group col-md-6">
						<label for=""><?= lang('phone'); ?> <span class="error">*</span> </label>
						<div class="customPhone">
							<div class="ci-input-group">
								<div class="ci-input-group-prepend w-30 text-center">
									<span class="input-group-text" style="padding: .6rem 0;;">+55</span>
								</div>
								<!-- Hidden dial_code field - automatically set to 55 (Brazil) -->
								<input type="hidden" name="dial_code" value="55">
								<input type="text" name="phone" class="form-control remove_char only_number" autocomplete="off" data-char="+" placeholder="00 0 0000 0000" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
							</div>
						</div>

					</div>
					<?php if (isset($shop_info['is_checkout_mail']) && $shop_info['is_checkout_mail'] == 1) : ?>
						<div class="form-group col-md-6">
							<label for=""><?= lang('email'); ?> <span class="error">*</span></label>
							<input type="email" name="email" class="form-control" placeholder="<?= lang('email'); ?>">
						</div>
					<?php endif; ?>
				</div>
			</div>


			<?php if (isset($guest->is_guest_login) && in_array($guest->is_guest_login, [1, 2,3])) : ?>
				<?php if (!empty(temp('is_table'))) : ?>

					<div class="guestLoginArea">
						<div class="row">
							<div class="col-md-12">
								<label class="custom-checkbox w_100"><input type="checkbox" name="is_guest_login" value="1" checked><?= lang('login_as_guest'); ?></label>
							</div>
						</div>
					</div><!-- guestLoginArea -->
				<?php else : ?>
					<div class="payincash_guest">
						<div class="or"><?= lang('or'); ?></div>
						<div class="guestLoginArea">
							<div class="row">
								<div class="col-md-12">
									<label class="custom-checkbox w_100"><input type="checkbox" name="is_guest_login" value="1"><?= lang('login_as_guest'); ?></label>
								</div>
							</div>
						</div><!-- guestLoginArea -->
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<!-- is_empty table -->

		<?php endif; ?>
		<!-- check customer login -->

		<div class="row">
			<div class="form-group col-md-6">
				<label><?= !empty(lang('order_type')) ? lang('order_type') : 'order type'; ?> <span class="error">*</span></label>

				<?php $order_type =  $this->admin_m->get_users_order_types_by_shop_id($shop_id); ?>

				<select name="order_type" id="order_type_list" class="form-control order_type <?= !empty(temp('is_table')) ? "pointerEvent" : ""; ?>" data-id="<?= $shop_id; ?>">
					<option value="">
						<?= !empty(lang('select_order_type')) ? lang('select_order_type') : 'select order type'; ?></option>

					<?php foreach ($order_type as $key => $types) : ?>
						<option value="<?= $types['type_id']; ?>" data-radius="<?= isset($shop_info['is_radius']) ? $shop_info['is_radius'] : 0; ?>" data-service_charge="<?= $types['is_service_charge'] ?? 0; ?>" data-required="<?= $types['is_required']; ?>" data-pay="<?= $types['is_payment']; ?>" data-slug="<?= $types['slug']; ?>" <?= !empty(temp('is_table')) && $types['slug'] == "dine-in" ? "selected" : ""; ?>>
							<?= !empty(lang($types['slug'])) ? lang($types['slug']) : $types['type_name']; ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="notfound col-md-12 dis_none ">
				<div class="showNotfoundMsg"></div>
			</div>
			<div class="priceEmpty col-md-12 dis_none ">
				<div class="priceCheck ">
					<h4><?= lang('minimum_price_msg_for_cod'); ?></h4>
					<p><?= lang('minimum_price'); ?> : <b><?= $shop_info['min_order']; ?> <?= shop($shop_id)->icon; ?></b>
					</p>
				</div>
			</div>
		</div><!-- row -->
		<div class="order_type_body dis_none">
			<div class="row">
				<div class="form-group col-md-6 booking dis_none">
					<label><?= !empty(lang('person')) ? lang('person') : 'Person'; ?> <span class="error">*</span></label>
					<input type="number" name="total_person" class="form-control only_number" min="1" value="1">
				</div>
				<div class="form-group col-md-6 col-6">
					<label><?= !empty(lang('booking_date')) ? lang('booking_date') : 'Booking date'; ?> <span class="error">*</span></label>
					<div class="input-group date flatpickr" id="datetimepicker1" data-target-input="nearest">
						<input type="text" name="reservation_date" class="form-control datetimepicker" data-target="#datetimepicker1" data-input />
						<div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
							<div class="input-group-text"><i class="fa fa-calendar"></i></div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- order_type_body -->

		<div class="pickup dis_none">
			<?php $time = $this->common_m->get_single_appoinment(__week(), $shop_id); ?>
			<?php $pickup_area = $this->common_m->get_pickup_area($shop_id); ?>
			<div class="row">
				<div class="col-md-12">
					<label class=""><?= lang('select_pickup_area'); ?>
						<?php if (shop($shop_id)->is_gmap == 1 || shop($shop_id)->is_admin_gmap == 1) : ?>
							<a href="javascript:;" class="checkmap"><?= lang('show_map'); ?></a>
						<?php endif; ?>
					</label>
					<div class="pickup_area_list">
						<?php
						$single_area = count($pickup_area) === 1;
						foreach ($pickup_area as $key => $area) :
							$checked = $single_area ? 'checked active' : '';
						?>
							<label class="single_pickup_area <?= $checked ?>"
								id="active_point_<?= $area['id']; ?>"
								data-id="<?= $area['id']; ?>"
								data-toggle="tooltip"
								title="<?= $area['address']; ?>">
								<?= $area['name']; ?>
							</label>
						<?php endforeach ?>
						<input type="hidden"
							name="pickup_point_id"
							class="add_pickpoint_value"
							value="<?= $single_area ? $pickup_area[0]['id'] : ''; ?>">
					</div>
				</div>
				<?php if (isset($time) && !empty($time)) : ?>

					<div class="form-group col-md-6 col-6 mt-20">
						<label><?= !empty(lang('pickup_date')) ? lang('pickup_date') : 'Pickup date'; ?> <span class="error">*</span></label>
						<div class="pickupCheckDate mt-5 mb-10">
							<label class="badge  custom-radio-2"><input type="radio" class="pickup_date_checker" name="today" data-id="<?= $shop_id; ?>" value="1" checked><?= lang('today'); ?></label>
							<label class="badge ml-10 custom-radio-2"><input type="radio" class="pickup_date_checker" name="today" data-id="<?= $shop_id; ?>" value="2"><?= lang('others'); ?></label>
						</div>
						<div class="pickupTime" style="display: none;">

							<div class="input-group date flatpickr" id="datepicker" data-target-input="nearest">
								<input type="text" name="pickup_date" class="form-control datepicker-1" data-target="#datepicker" data-input />
								<div class="input-group-append" data-target="#datepicker" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>
							</div>
						</div>
					</div>

					<!-- pickup time slots -->
					<div class="form-group col-md-12 col-lg-12 col-12 mt-5">
						<div class="pickupTimeSlots null">
							<i class="fa fa-spinner fa-spin"></i>
						</div>
					</div>
					<!-- pickup time slots -->

				<?php else : ?>
					<div class="form-group col-md-6 col-12 mt-10">
						<label><?= !empty(lang('pickup_time')) ? lang('pickup_time') : 'pickup time'; ?> <span class="error">*</span></label>
						<div class="pickup_up">
							<h4><?= lang('pickup_time_alert'); ?></h4>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div><!-- order_type_body -->

	</div><!-- step_1 -->
	<div class="step_2">
		<!-- dine in -->
		<div class="dineInsection">
			<div class="dinein mb-10 dis_none">
				<?php $dinein = $this->common_m->get_table_list($shop_id); ?>
				<div class="row">
					<div class="col-md-6">
						<div class="dineInList">
							<label for=""><?= lang('select_table'); ?></label>
							<?php if (!empty(temp('table_no'))) : ?>
								<select name="table_no" class="form-control table_no" id="table_no_1" data-id="<?= $shop_id; ?>">
									<?php foreach ($dinein as $key => $dine) : ?>
										<?php if (!empty(temp('table_no')) && temp('table_no') == $dine['id']) : ?>
											<option value="<?= $dine['id']; ?>" data-size="<?= $dine['size']; ?>" <?= !empty(temp('table_no')) && temp('table_no') == $dine['id'] ? "selected" : ""; ?>>
												<?= $dine['name']; ?> / <?= $dine['area_name']; ?> -
												<?= $dine['size'] . ' ' . lang('person'); ?> </option>
										<?php endif ?>
									<?php endforeach ?>
								</select>
							<?php else : ?>
								<select name="table_no" class="form-control table_no" id="table_no_2" data-id="<?= $shop_id; ?>">
									<option value=""><?= lang('select'); ?></option>
									<?php foreach ($dinein as $key => $dine) : ?>
										<option value="<?= $dine['id']; ?>" data-size="<?= $dine['size']; ?>" <?= !empty(temp('table_no')) && temp('table_no') == $dine['id'] ? "selected" : ""; ?>>
											<?= $dine['name']; ?> / <?= $dine['area_name']; ?> -
											<?= $dine['size'] . ' ' . lang('person'); ?> </option>
									<?php endforeach ?>
								</select>
							<?php endif ?>

						</div>
					</div>

					<div class="col-md-6">
						<div class="table_person dis_none">
							<label for=""><?= lang('select_person'); ?></label>
							<select name="person" class="form-control" id="table_person">

							</select>
						</div>
					</div>
				</div>

			</div>
		</div>


		<!-- dine in -->
		<div class="dis_none hidePay-in-cash show_address">
			<?php if ($shop_info['is_area_delivery'] == 1 && $shop_info['is_radius'] == 0) : ?>
				<div class="row">
					<div class="form-group col-md-12 cod_phone" style="display: none;">
						<label for=""><?= lang('phone'); ?> <i class="fa fa-info-circle" data-title="<?= lang('phone_with_international_format') ?>" data-toggle="tooltip"></i> <span class="error">*</span> </label>
						<div class="customPhone">
							<div class="ci-input-group">
								<div class="ci-input-group-prepend w-30 text-center">
									<span class="input-group-text" style="padding: .6rem 0;;">+55</span>
								</div>
								<!-- Hidden cod_dial_code field - automatically set to 55 (Brazil) -->
								<input type="hidden" name="cod_dial_code" value="55">
								<input type="text" name="cod_phone" class="form-control remove_char only_number" autocomplete="off" data-char="+" placeholder="00 0 0000 0000" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
							</div>
						</div>

					</div>
					<!-- phone for delivery -->
					<div class="col-md-12">
						<?php if (isset($shop_info['delivery_area_style']) && $shop_info['delivery_area_style'] == 2) : ?>
							<div class="shoppingAddressArea mb-20">
								<select name="shipping_area" id="shipping_area" class="form-control shippingDropdown select2">
									<option value=""><?= lang('delivery_area'); ?> *</option>
									<?php foreach (delivery_area($shop_id) as $key => $area) : ?>
										<option value="<?= $area['id']; ?>" data-cost="<?= $area['cost']; ?>" data-id="<?= $area['id']; ?>">
											<?= $area['area'] . ' - ' . currency_position($area['cost'], $shop_id); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						<?php else : ?>
							<div class="slots_area mb-20">
								<?php foreach (delivery_area($shop_id) as $key => $area) : ?>
									<label class="single_slots">
										<input type="radio" name="shipping_area" data-cost="<?= $area['cost']; ?>" data-id="<?= $area['id']; ?>" value="<?= $area['id']; ?>" class="shippingArea"><?= $area['area'] . ' - ' . currency_position($area['cost'], $shop_id); ?>
									</label>
								<?php endforeach ?>
							</div>
						<?php endif; ?>
					</div>


				</div>
			<?php else : ?>
				<div class="form-group cod_phone" style="display: none;">
					<label for=""><?= lang('phone'); ?> <i class="fa fa-info-circle" data-title="<?= lang('phone_with_international_format') ?>" data-toggle="tooltip"></i> <span class="error">*</span> </label>
					<div class="customPhone">
						<div class="ci-input-group">
							<div class="ci-input-group-prepend w-30 text-center">
								<span class="input-group-text" style="padding: .6rem 0;;">+55</span>
							</div>
							<!-- Hidden cod_dial_code field - automatically set to 55 (Brazil) -->
							<input type="hidden" name="cod_dial_code" value="55">
							<input type="text" name="cod_phone" class="form-control remove_char only_number" autocomplete="off" data-char="+" placeholder="00 0 0000 0000" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
						</div>
					</div>

				</div>
			<?php endif; ?>
			<div class="row">
				<div class="form-group col-md-12">
					<input type="hidden" name="customer_phone" class="customer_phone" value="<?= !empty(auth('customer_phone')) ? auth('customer_phone') : ""; ?>">
					<textarea name="address" cols="5" rows="5" id="address_guest" class="form-control shippingAddress" placeholder="<?= !empty(lang('shipping_address')) ? lang('shipping_address') : 'shipping address'; ?> *"><?= !empty(auth('customer_address')) ? auth('customer_address') : ""; ?></textarea>
				</div>

				<div class="form-group col-md-12">
					<?php if (shop($shop_id)->is_gmap == 1 || shop($shop_id)->is_admin_gmap == 1) : ?>
						<div class="gmapLink" id="locator-input-section">
							<select id="editable-select" name="delivery_area" id="delivery_area" class="form-control gmap_link autocomplete" placeholder="<?= !empty(lang('google_map_link')) ? lang('google_map_link') : 'Google map link'; ?>">
								<?php if (!empty(auth('gmap_link'))) : ?>
									<option><?= !empty(auth('gmap_link')) ? auth('gmap_link') : ""; ?></option>
								<?php endif ?>
								<option value=""></option>
							</select>
							<i class="fa fa-dot-circle" id="locator-button" data-toggle="tooltip" title="<?= lang('get_google_location'); ?>"></i>
						</div>
					<?php else : ?>
						<input type="text" name="delivery_area" class="form-control" value="<?= !empty(auth('gmap_link')) ? auth('gmap_link') : ""; ?>" placeholder="<?= !empty(lang('google_map_link')) ? lang('google_map_link') : 'Google map link'; ?>">
					<?php endif ?>
				</div>

			</div><!-- row -->


			<div class="changeInfo dis_none">
				<div class="row mt-10">
					<div class="form-group col-md-6">
						<label class="custom-checkbox"><b><input type="checkbox" name="is_change" class="is_change" value="1"> <?= lang('i_need_change'); ?></b></label>
						<div class="change_field mt-10 dis_none">
							<div class="row">
								<div class="col-md-12">
									<label for="customer_payment_amount"><strong><?= lang('change_value'); ?>:</strong></label>
									<input type="number" name="customer_payment_amount" id="customer_payment_amount" class="form-control" placeholder="<?= lang('change_value'); ?>" step="0.01" min="0">
									<small class="text-muted"><?= lang('enter_customer_payment_amount'); ?></small>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- changeInfo -->



		</div><!-- show_address -->
		<div class="room_service dis_none">
			<div class="row">
				<div class="form-group col-md-12">
					<div class="room_services mb-10">
						<?php $hotel_list = $this->common_m->get_my_hotel($shop_id); ?>
						<div class="row">
							<div class="col-md-6">
								<div class="hotelName">
									<label for=""><?= lang('select'); ?></label>
									<select name="hotel_id" class="form-control hotel_name" id="hotel_name">
										<option value=""><?= lang('select'); ?></option>
										<?php foreach ($hotel_list as $key => $hotel) : ?>
											<option value="<?= $hotel['id']; ?>"><?= $hotel['hotel_name']; ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>

							<div class="col-md-12">
								<div class="roomNumbers">

								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- room service -->

		<div class="couponArea" style="display:none;">
			<a href="javascript:;" class="couponBtn"><?= lang('do_you_have_coupon'); ?></a>
			<div class="couponField" style="display:none;">
				<div class="couponInput-group">
					<div class="couponFields">
						<input type="text" name="coupon_code" class="form-control coupon_code" placeholder="<?= lang('coupon_code'); ?>">
						<a href="javascript:;" class="text-danger couponClose"><i class="fa fa-close"></i></a>
					</div>
					<input type="hidden" name="shop_id" class="shop_id" value="<?= $shop_id; ?>">
					<input type="hidden" name="all_price" class="all_price" value="<?= $grandSubTotal ?? $this->cart->total(); ?>">
					<input type="hidden" name="is_coupon" class="form-control is_coupon" value="0">
					<input type="hidden" name="coupon_percent" class="form-control coupon_percent" value="0">
					<input type="hidden" name="coupon_id" class="form-control coupon_id" value="0">
					<input type="hidden" name="shipping_cost" class="form-control shipping_cost" value="0">
					<input type="hidden" name="last_order_type" class="form-control last_order_type" value="0">
					<button type="button" class="btn btn-secondary couponFormBtn"><?= lang('apply'); ?></button>
				</div>
			</div>
		</div>

		<?php $tips_config = tips_config($shop_id); ?>
		<?php if (isset($tips_config->is_tips) && $tips_config->is_tips == 1) : ?>
			<div class="tipsSection">
				<div class="row mt-10">
					<div class="form-group col-md-12">
						<div class="tipsArea">
							<p><?= lang('tips'); ?></p>
							<div class="tipsHeader">
								<ul>
									<?php if (sizeof($tips_config->tips_field_config) > 0) : ?>
										<?php foreach ($tips_config->tips_field_config as $tipsValue) : ?>
											<?php if (!empty($tipsValue->tips)) : ?>
												<li>
													<label class="tipsLabel">
														<span><?= $tipsValue->tips; ?>%</span>
														<input type="radio" name="tips_btn" value="<?= get_percent($grandSubTotal ?? $this->cart->total(), $tipsValue->tips); ?>">
													</label>
												</li>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endif; ?>
									<li>
										<label class="tipsLabel">
											<span><?= lang('others'); ?></span>
											<input type="radio" name="tips_btn" value="0">
										</label>
									</li>
								</ul>
							</div>
							<div class="tipsFieldArea dis_none">
								<div class="tipsfields">
									<input type="text" name="tips" class="form-control number" value="">
									<button type="button" class="btn btn-secondary addTips"> <?= lang('add_tip'); ?> </button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- tipsSection -->
		<?php endif; ?>

		<?php if (is_feature($shop_info['user_id'], 'online-payment') == 1 && is_active($shop_info['user_id'], 'online-payment') && overlay == 1) : ?>
			<div class="makePayment <?= is_package; ?>" style="display:<?= !empty(temp('is_table')) ? "" : "none;" ?>;">
				<div class="form-group">
					<div class="">
						<label class="custom-radio-2 f-color mr-5 pay_now"><input type="radio" name="use_payment" value="1">
							<b><?= lang('pay_now'); ?></b></label> &nbsp;

						<label class="custom-radio-2 f-color pay_later"><input type="radio" name="use_payment" value="0" checked> <b><?= lang('pay_later'); ?></b></label>
					</div>
					<?php include 'checkout_payment_list.php'; ?>

					<!-- Brazilian Delivery Payment Options -->
					<div class="delivery-payment-options" style="display: none;">
						<div class="delivery-payment-section mt-20">
							<h5 class="mb-15"><?= lang('select_delivery_payment'); ?></h5>
							<p class="text-muted mb-20"><?= lang('general_payment_terminal_info'); ?></p>
							<div class="delivery-payment-methods">
								<div class="row">
									<!-- Cash on Delivery -->
									<div class="col-md-6 col-12 mb-15">
										<label class="delivery-payment-option">
											<input type="radio" name="delivery_payment_method" value="cash" class="delivery-payment-radio">
											<div class="payment-option-card">
												<div class="payment-icon">
													<img src="<?= base_url('imagens_para_checkout/cash-delivery.svg'); ?>" alt="Cash" width="32" height="32">
												</div>
												<div class="payment-info">
													<h6><?= lang('cash_on_delivery'); ?></h6>
													<small class="text-muted"><?= lang('change_for_amount'); ?></small>
												</div>
											</div>
										</label>
									</div>

									<!-- Credit Card on Delivery -->
									<div class="col-md-6 col-12 mb-15">
										<label class="delivery-payment-option">
											<input type="radio" name="delivery_payment_method" value="credit_card" class="delivery-payment-radio">
											<div class="payment-option-card">
												<div class="payment-icon">
													<img src="<?= base_url('imagens_para_checkout/card-terminal.svg'); ?>" alt="Credit Card" width="32" height="32">
												</div>
												<div class="payment-info">
													<h6><?= lang('credit_card_on_delivery'); ?></h6>
												</div>
											</div>
										</label>
									</div>

									<!-- Debit Card on Delivery -->
									<div class="col-md-6 col-12 mb-15">
										<label class="delivery-payment-option">
											<input type="radio" name="delivery_payment_method" value="debit_card" class="delivery-payment-radio">
											<div class="payment-option-card">
												<div class="payment-icon">
													<img src="<?= base_url('imagens_para_checkout/card-terminal.svg'); ?>" alt="Debit Card" width="32" height="32">
												</div>
												<div class="payment-info">
													<h6><?= lang('debit_card_on_delivery'); ?></h6>
												</div>
											</div>
										</label>
									</div>

									<!-- PIX on Delivery -->
									<div class="col-md-6 col-12 mb-15">
										<label class="delivery-payment-option">
											<input type="radio" name="delivery_payment_method" value="pix" class="delivery-payment-radio">
											<div class="payment-option-card">
												<div class="payment-icon">
													<img src="<?= base_url('imagens_para_checkout/pix-delivery.svg'); ?>" alt="PIX" width="32" height="32">
												</div>
												<div class="payment-info">
													<h6><?= lang('pix_on_delivery'); ?> <?= lang('pix_qr_code_info'); ?></h6>
												</div>
											</div>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
	<div class="row">
		<div class="col-md-12">
			<textarea name="comments" id="comments" class="form-control" cols="5" rows="5" placeholder="<?= lang('comments'); ?>"></textarea>
		</div>
	</div>
	<?php $order_merge_config = @!empty($shop_info['order_merge_config']) ? json_decode($shop_info['order_merge_config']) : ''; ?>
	<?php if (isset($order_merge_config->is_order_merge) && $order_merge_config->is_order_merge == 1) : ?>
		<div class="mergeArea" style="display:none;">
			<div class="row">
				<div class="col-md-12 mt-10 mb-5">
					<div class="mergeArealist">
						<div class="m-0 p-0 previousOrderDetails mb-5"></div>
						<?php if (isset($order_merge_config->is_system) && $order_merge_config->is_system == 1) : ?>
							<input type="checkbox" name="is_merge" value="1" checked>
						<?php else : ?>
							<label class="custom-checkbox f-color mr-10"> <input type="checkbox" name="is_merge" value="1"><?= lang('merge_with_previous_order'); ?></label>
							<label class="custom-checkbox f-color"> <input type="checkbox" name="is_merge" value="0"><?= lang('make_it_as_single_order'); ?></label>
						<?php endif ?>

					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="modal-footer">


		<input type="hidden" name="get_price" class="getPrice" value="<?= $grandSubTotal ?? $this->cart->total(); ?>">
		<input type="hidden" name="minPrice" class="minPrice" value="<?= isset($shop_info['min_order']) ? $shop_info['min_order'] : 0; ?>">
		<input type="hidden" name="is_service_charge" class="is_service_charge" value="0">

		<input type="hidden" name="is_payment" class="is_payment" value="0">
		<div class="checkoutBtnList">
			<?php if (isset($extra_config['terms']) && !empty(json_decode($extra_config['terms']))) : ?>
				<label class="pointer custom-checkbox"> <input type="checkbox" name="terms" value="1">
					<?= lang('read_terms'); ?> <a href="#termsModal" data-toggle="modal"> <?= lang('terms_condition'); ?></a>
					<?= lang('accept_them'); ?></label>
			<?php endif; ?>
			<button type="submit" class="btn btn-primary confirm_btn" <?= isset($extra_config['terms']) && !empty(json_decode($extra_config['terms'])) ? "disabled" : ""; ?>> <i class="icofont-check-circled checkIcon"></i>
				<?= !empty(lang('confirm_oder')) ? lang('confirm_oder') : 'confirm oder'; ?></button>
		</div>
	</div><!-- modal-footer -->


	<script>
		$(document).on('change', '[name="terms"]', function() {
			if ($(this).is(':checked')) {
				$('.confirm_btn').prop('disabled', false);
				$('.checkIcon').css('visibility', 'visible');
			} else {
				$('.confirm_btn').prop('disabled', true);
				$('.checkIcon').css('visibility', 'hidden');
			}
		});

		// Brazilian Delivery Payment Options Logic
		$(document).on('change', '[name="use_payment"]', function() {
			var selectedValue = $(this).val();
			var orderType = $('#order_type_list').val();
			var orderTypeSlug = $('#order_type_list option:selected').data('slug');

			// Show delivery payment options only for delivery orders when "Pay Later" is selected
			if (selectedValue == '0' && orderTypeSlug == 'cash-on-delivery') {
				$('.delivery-payment-options').slideDown();
			} else {
				$('.delivery-payment-options').slideUp();
				// Clear selection when hiding
				$('[name="delivery_payment_method"]').prop('checked', false);
			}
		});

		// Show/hide change amount field for cash payments
		$(document).on('change', '[name="delivery_payment_method"]', function() {
			var selectedMethod = $(this).val();
			if (selectedMethod == 'cash') {
				$('.changeInfo').slideDown();
			} else {
				$('.changeInfo').slideUp();
				$('[name="is_change"]').prop('checked', false);
				$('.change_field').slideUp();
				$('[name="customer_payment_amount"]').val('');
			}
		});

		// Simple validation for customer payment amount
		$(document).on('input', '#customer_payment_amount', function() {
			var customerAmount = parseFloat($(this).val()) || 0;
			var orderTotal = parseFloat($('.grandTotal').text().replace(/[^\d.,]/g, '').replace(',', '.')) || 0;

			// Basic validation - ensure customer amount is sufficient
			if (customerAmount > 0 && orderTotal > 0 && customerAmount < orderTotal) {
				$(this).addClass('error');
				$(this).attr('title', '<?= lang("customer_payment_insufficient"); ?>');
			} else {
				$(this).removeClass('error');
				$(this).removeAttr('title');
			}
		});

		// Handle order type change to show/hide delivery payment options
		$(document).on('change', '#order_type_list', function() {
			var orderTypeSlug = $(this).find('option:selected').data('slug');
			var usePayment = $('[name="use_payment"]:checked').val();

			if (orderTypeSlug == 'cash-on-delivery' && usePayment == '0') {
				$('.delivery-payment-options').slideDown();
			} else {
				$('.delivery-payment-options').slideUp();
				$('[name="delivery_payment_method"]').prop('checked', false);
				// Also hide change info when not delivery
				$('.changeInfo').slideUp();
				$('[name="is_change"]').prop('checked', false);
				$('.change_field').slideUp();
				$('[name="customer_payment_amount"]').val('');
			}
		});

		// Form validation before submission
		$(document).on('submit', '.order_form', function(e) {
			var orderTypeSlug = $('#order_type_list option:selected').data('slug');
			var usePayment = $('[name="use_payment"]:checked').val();

			// If it's a delivery order with "Pay Later", ensure payment method is selected
			if (orderTypeSlug == 'cash-on-delivery' && usePayment == '0') {
				var deliveryPaymentMethod = $('[name="delivery_payment_method"]:checked').val();

				if (!deliveryPaymentMethod) {
					alert('<?= lang("select_delivery_payment"); ?>');
					e.preventDefault();
					return false;
				}

				// If cash is selected and change is needed, validate customer payment amount
				if (deliveryPaymentMethod == 'cash' && $('[name="is_change"]').is(':checked')) {
					var customerPaymentAmount = $('[name="customer_payment_amount"]').val();
					var orderTotal = parseFloat($('.grandTotal').text().replace(/[^\d.,]/g, '').replace(',', '.')) || 0;

					if (!customerPaymentAmount || parseFloat(customerPaymentAmount) <= 0) {
						alert('<?= lang("enter_customer_payment_amount"); ?>');
						$('[name="customer_payment_amount"]').focus();
						e.preventDefault();
						return false;
					}

					if (parseFloat(customerPaymentAmount) < orderTotal) {
						alert('<?= lang("customer_payment_insufficient"); ?>');
						$('[name="customer_payment_amount"]').focus();
						e.preventDefault();
						return false;
					}

					var orderTotal = parseFloat($('.grandTotal').text().replace(/[^\d.,]/g, '').replace(',', '.')) || 0;
					if (parseFloat(customerPaymentAmount) < orderTotal) {
						alert('<?= lang("customer_payment_insufficient"); ?>');
						$('[name="customer_payment_amount"]').focus();
						e.preventDefault();
						return false;
					}
				}
			}
		});
	</script>


	<?php if (isset($extra_config['terms']) && !empty($extra_config['terms'])) : ?>
		<div class="modal fade" id="termsModal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class=""><?= lang('terms_condition'); ?></h3>
					</div>
					<div class="modal-body">
						<p><?= json_decode($extra_config['terms']); ?></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('ok'); ?></button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	<?php endif ?>