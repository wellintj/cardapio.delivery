<?php if (isset($this->settings['is_item_search']) && $this->settings['is_item_search'] == 1) : ?>

	<section class="nearbySection">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-8">
					<form action="#" method='post' class="searchItemForm">
						<div class="nearbyArea">
							<div class="searchInput">
								<input type="text" name="q" class="form-control sarchValue" placeholder="<?= lang('search_for_items'); ?>">
								<div class="user_right_btn_area">
									<button type="submit" class="btn btn-primary c_btn"><i class="icofont-search-user"></i> <?= lang('search'); ?></button>
								</div>
							</div>

							<div class="findNearby">
								<button type="button" class="btn btn-secondary c_btn" id="getLocation"><i class="icofont-google-map"></i> <?= lang('near_me'); ?></button>
							</div>
						</div>
					</form>
					<div class="errorMSG" id="errorMsg"></div>
				</div>
			</div>
			<div class="restaurantList " id="shopList">
				<div class="topPopularshop homePopular pb-80">
					<div class="row">
						<div class="col-md-12">
							<div class="itemHeading">
								<h4><?= lang('popular_store'); ?></h4>
							</div>
						</div>
					</div>
					<div class="row">
						<?php foreach ($top_8_shop as $key => $row) : ?>
							<?php include VIEWPATH . 'frontend/inc/shop_thumb.php'; ?>
						<?php endforeach ?>
					</div>
				</div><!-- topPopularshop -->

				<div class="popularItem homePopular">
					<div class="row">
						<div class="col-md-12">
							<div class="itemHeading">
								<h4><?= lang('popular_items'); ?></h4>
							</div>
						</div>
					</div>
					<!-- popular item thumb -->
					<?php include VIEWPATH . 'frontend/inc/popularItem_thumb.php'; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>


<?php if (!empty(section_name('pricing')) && $settings['is_registration'] == 1) : ?>
	<?php include VIEWPATH . "frontend/inc/hero_section.php"; ?>
<?php endif; ?>





<!-- How it works -->
<?php $how_it_works = section_name('how_it_works'); ?>
<?php if (!empty($how_it_works) && $how_it_works['status'] == 1) : ?>
	<section class=" default services_area how_it_works">
		<div class="container">
			<?php if (count($how_works) > 0) : ?>
				<div class="row">
					<div class="col-md-12 col-sm-12 features-heading">
						<h2 class="heading-text"><?= html_escape($how_it_works['heading']); ?></h2>
						<p><?= html_escape($how_it_works['sub_heading']); ?></p>
					</div>
					<?php foreach ($how_works as $key => $works) : ?>
						<div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-delay="<?= $key + 1; ?>00">
							<div class="single_serivce_area">
								<div class="single_service">
									<div class="home_service_img">
										<?php if (!empty($works['thumb'])): ?>
											<img src="<?= avatar($works['thumb'], 'logo'); ?>" alt="<?= html_escape($works['title']); ?>">
										<?php endif; ?>
									</div>
									<div class="top_service">
										<h4 class=""><?= html_escape($works['title']); ?></h4>
									</div>
									<div class="service_details">
										<p><?php if (strlen($works['details']) >= 80) : ?>
												<?= character_limiter($works['details'], 65); ?><a href="#worksModal_<?= $works['id']; ?>" data-toggle="modal" class="learn_more_link"><?= lang('read_more'); ?></a>
											<?php else : ?>
												<?= html_escape($works['details']); ?>
											<?php endif; ?>

										</p>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="row">
					<div class="empty_area">
						<div class="empty_text">
							<i class="fa fa-frown fa-2x"></i>
							<h4>Sorry! Data Not found</h4>
							<code>Admin-> Home -> How it works -> Add How it works</code>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>


<?php if (!empty($how_it_works) && $how_it_works['status'] == 1 && count($how_works) > 0) : ?>

	<?php foreach ($how_works as $key => $works_modal) : ?>
		<?php if (strlen($works_modal['details']) >= 40) : ?>
			<!-- Modal -->
			<div class="modal fade" id="worksModal_<?= $works_modal['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><?= html_escape($works_modal['title']); ?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<?= $works_modal['details']; ?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close'); ?></button>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endforeach ?>
<?php endif; ?>