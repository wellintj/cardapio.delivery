<?php $features = section_name('features'); ?>
<?php if (!empty($features) && $features['status'] == 1) : ?>
	<section class="default feature_area">
		<div class="container">
			<?php if (count($left_features) > 0 && count($right_features) > 0) : ?>
				<div class="row">
					<div class="col-md-12 col-sm-12 features-heading top_heading">
						<h2 class="heading-text"><?= html_escape($features['heading']); ?></h2>
						<p><?= html_escape($features['sub_heading']); ?></p>
					</div>
					<!--col-md-12-->
					<div class="col-lg-4 col-sm-12 features-text mr-0 pr-0">
						<?php foreach ($left_features as $key => $left) : ?>
							<div class="features_warp_content" data-aos="fade-right" data-aos-delay="<?= $key + 1; ?>0">
								<div class="features-wrap left_wrap">
									<div class="features-content">
										<h4><?= html_escape($left['title']); ?></h4>
										<p><?= character_limiter(html_escape($left['details']), 120); ?> </p>
									</div>
									<!--features-content-->
									<?php if (!empty($left['icon'])) : ?>
										<?= $left['icon']; ?>
									<?php else : ?>
										<img src="<?= html_escape(base_url($left['thumb'])); ?>" alt="<?= html_escape($left['title']); ?>">
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>

					</div>
					<!--col-md-6-->
					<div class=" col-lg-3 col-sm-6">
						<div class="features-img" data-aos="zoom-in" data-aos-delay="100">
							<img src="<?= !empty($features['images']) ? base_url($features['images']) : ""; ?>" alt="features-img">
						</div>
						<!--features-img-->
					</div>

					<!--col-md-4-->
					<div class="col-lg-4 col-sm-12  features-text ml-0 pl-0">
						<?php foreach ($right_features as $key => $right) : ?>
							<div class="features_warp_content" data-aos="fade-left" data-aos-delay="<?= $key + 1; ?>0">
								<div class="features-wrap right_wrap">
									<?php if (!empty($right['icon'])) : ?>
										<?= $right['icon']; ?>
									<?php else : ?>
										<img src="<?= base_url($right['thumb']); ?>" alt="<?= html_escape($right['title']); ?>">
									<?php endif; ?>
									<div class="features-content">
										<h4><?= html_escape($right['title']); ?></h4>
										<p><?= character_limiter(html_escape($right['details']), 120); ?> </p>
									</div>
									<!--features-content-->
								</div>
							</div>
						<?php endforeach; ?>

					</div>
					<!--col-md-6-->
				</div>
				<!--row-->
			<?php else : ?>
				<div class="row">
					<div class="empty_area">
						<div class="empty_text">
							<i class="fa fa-frown fa-2x"></i>
							<h4>Sorry! Data Not found</h4>
							<code>Admin-> settings -> Home settings -> Add Section Banners</code>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>


<?php $faq = section_name('faq'); ?>
<?php if (!empty($faq) && $faq['status'] == 1) : ?>
	<section class=" default services_area">
		<div class="container">
			<?php if (count($faqs) > 0) : ?>
				<div class="row">
					<div class="col-md-12 col-sm-12 features-heading">
						<h2 class="heading-text"><?= html_escape($faq['heading']); ?></h2>
						<p><?= $faq['sub_heading']; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="accordion_area">
							<div class="accordions">
								<?php foreach ($faqs as $key => $home_faq) : ?>
									<div class="single_accordion" dir="<?= direction(); ?>" data-aos="fade-up" data-aos-delay="<?= $key + 1; ?> 000">
										<div class="page_accordion_header active arrow_down"><?= html_escape($home_faq['title']); ?></div>
										<div class="accordion_content block">
											<?= $home_faq['details']; ?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<div class="col-md-6" data-aos="fade-left" data-aos-delay="100">
						<div class="faq_images">
							<img src="<?= !empty($faq['images']) ? base_url($faq['images']) : base_url('assets/frontend/images/faq.jpg'); ?>" alt="Faq Image">
						</div>
					</div>
				</div>
			<?php else : ?>
				<div class="row">
					<div class="empty_area">
						<div class="empty_text">
							<i class="fa fa-frown fa-2x"></i>
							<h4>Sorry! Data Not found</h4>
							<code>Admin-> Home -> FAQ -> Add FAQ</code>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>





<?php $home_services = section_name('services'); ?>
<?php if (!empty($home_services) && $home_services['status'] == 1) : ?>
	<section class="default service_area">
		<div class="container">
			<?php if (count($services) > 0) : ?>
				<div class="row">
					<div class="col-md-12 col-sm-12 features-heading">
						<h2 class="heading-text"><?= html_escape($home_services['heading']); ?></h2>
						<p><?= html_escape($home_services['sub_heading']); ?></p>
					</div>
				</div>
				<?php foreach ($services as $key => $row) : ?>
					<div class="row mtb-20 mi-shadow home_service_mr <?= ($key + 1) % 2 == 0 ? 'row_reverse' : ''; ?> " data-aos="fade-down" data-aos-delay="<?= $key + 1; ?>00">
						<div class="col-sm-6">
							<div class="service_home_img ">
								<img src="<?= avatar($row['images'],'logo'); ?>" alt="service_home_img">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="service_home_details <?= ($key + 1) % 2 == 0 ? 'text-right' : 'text-left'; ?>">
								<div class="service_home_title">
									<h4><?= html_escape($row['title']); ?></h4>
								</div>
								<p><?= $row['details']; ?></p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="row">
					<div class="empty_area">
						<div class="empty_text">
							<i class="fa fa-frown fa-2x"></i>
							<h4>Sorry! Data Not found</h4>
							<code>Admin-> Home -> services -> Add services</code>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

<?php $home_team = section_name('teams'); ?>
<?php if (!empty($home_team) && $home_team['status'] == 1) : ?>
	<div class="default teamSections section-padding-top section-padding-bottom">
		<div class="container">
			<?php if (count($team) > 0) : ?>
				<div class="row">
					<div class="col-md-12 col-sm-12 features-heading">
						<h2 class="heading-text"><?= html_escape($home_team['heading']); ?></h2>
						<p><?= html_escape($home_team['sub_heading']); ?></p>
					</div>
				</div>
				<div class="team_section">
					<div class="row team_slider slider-nav">
						<?php foreach ($team as $key => $row) : ?>
							<div class="teamLead">
								<div class="single_team style_2">
									<div class="team_header">
										<img src="<?= avatar($row['images'],'logo'); ?>" alt="team image">
										<div class="team_details">
											<h5><?= html_escape($row['name']); ?></h5>
											<p><?= html_escape($row['designation']); ?></p>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			<?php else : ?>
				<div class="row">
					<div class="empty_area">
						<div class="empty_text">
							<i class="fa fa-frown fa-2x"></i>
							<h4>Sorry! Data Not found</h4>
							<code>Admin-> Home -> Teams -> Add Teams</code>
						</div>
					</div>
				</div>
			<?php endif ?>
		</div>
	</div>
<?php endif; ?>


<script>
	$(document).ready(function() {
		var get_rtl = $('#rtl').data('id');

		if (get_rtl == 'rtl') {
			var rtl = true;
		} else {
			var rtl = false;
		}

		$('.team_slider').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			rtl: rtl,
			autoplay: false,
			prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			autoplaySpeed: 2000,
			dots: false,
			arrows: true,
			focusOnSelect: true,
			responsive: [{
					breakpoint: 1024,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1,
					}
				},
				{
					breakpoint: 600,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}
			]
		});
	})
</script>