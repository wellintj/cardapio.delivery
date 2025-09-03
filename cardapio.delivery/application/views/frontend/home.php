  <style>
  	.loader {
  		border: 16px solid #f3f3f3;
  		border-radius: 50%;
  		border-top: 16px solid #3498db;
  		width: 120px;
  		height: 120px;
  		animation: spin 2s linear infinite;
  		position: absolute;
  		top: 50%;
  		left: 50%;
  		transform: translate(-50%, -50%);
  		display: none;
  	}

  	@keyframes spin {
  		0% {
  			transform: rotate(0deg);
  		}

  		100% {
  			transform: rotate(360deg);
  		}
  	}
  </style>
  <div class="home_wrapper">
  	<?php $settings = settings(); ?>
  	<?php $social = isJson($settings['social_sites']) ? json_decode($settings['social_sites'], TRUE) : ''; ?>
  	<?php $home = section_name('home'); ?>
  	<?php if ($home['status'] == 1) : ?>
  		<div class="topHome_banner bg_loader" data-src="<?= !empty($home['images']) ? base_url(html_escape($home['images'])) : base_url('assets/frontend/images/banner.png'); ?>" id="hero" style="background: url(<?= bg_loader(); ?>)">
  			<div class="homeTopBanner">
  				<div class="container">
  					<div class="row">
  						<div class="col-lg-7 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
  							<div data-aos="zoom-out" data-aos-delay='1000'>
  								<h1><?= !empty($home) ? html_escape($home['heading']) : 'Create Your space  With '; ?><span> <?= html_escape($settings['site_name']); ?></span></h1>
  								<h2><?= !empty($home) ? html_escape($home['sub_heading']) : 'Create The Great First Impression'; ?></h2>
  								<div class="text-center text-lg-left home_button">

  									<?php if (!empty(section_name('pricing')) && $settings['is_registration'] == 1) : ?>
  										<a href="<?= base_url('pricing') ?>" class="btn-get-started nav-link"><?= lang('get_start'); ?></a>
  									<?php endif; ?>



  									<?php if (isset($social['youtube']) && !empty($social['youtube'])) : ?>
                                    <a href="<?= html_escape($social['youtube']); ?>" class="video_play_btn venobox" data-autoplay="true" data-vbtype="video">
                                       <span class="play-btn"><i class="icofont-play"></i></span>
                                       <span class="hidden-xs"><?= lang('play_video'); ?></span>
                                   </a>
                               <?php endif; ?>

                           </div>
                       </div>
                   </div>
                   <div class="col-lg-5 order-1 order-lg-2 hero-img">
                       <div class="home_left_img">
                          <img src="<?= !empty($settings['home_banner']) ? base_url($settings['home_banner']) : base_url(html_escape(settings()['site_qr_link'])) ?>" alt="home banner">
                      </div>
                  </div>
              </div>
          </div>
          <?php if (isset($settings['restaurant_demo'])  && !empty($settings['restaurant_demo'])) : ?>
          <a href="<?= base_url($settings['restaurant_demo']); ?>" class="resaurantDemo" style="position: absolute;
          bottom: -30px;
          z-index: 999;
          display: inline-block;
          background: #007bff;
          color: #fff;
          padding: 8px 20px;
          border-radius: 8px; margin-bottom: 15px;"><?= lang('restaurant_demo'); ?></a>
      <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<?php $site = section_name('description'); ?>
<div class="container">
    <div class="home_top_banner">
       <div class="row">
          <div class="col-md-8">
             <div class="home_right_test">
                <h4><?= isset($site['heading']) ? $site['heading'] : html_escape($settings['site_name']); ?></h4>
                <p><?= isset($site['sub_heading']) && !empty($site['sub_heading']) ? $site['sub_heading'] : (!empty($settings['long_description']) ? $settings['long_description'] : $settings['description']); ?></p>
            </div>
        </div>
        <?php if ($settings['is_order_video'] == 1) : ?>
         <div class="col-md-4">
            <div class="device-wrapper animated">
               <div class="device" data-device="iPhoneX" data-orientation="portrait" data-color="black">
                  <div class="screen">
                     <iframe width="560" height="315" src="<?= !empty($social['order_video']) ? $social['order_video'] : 'https://www.youtube.com/embed/c5XCpSv0WHk'; ?>?autoplay=1&loop=1&controls=0&showinfo=0&modestbranding=1&rel=0&iv_load_policy=3&playlist=<?= !empty($social['order_video']) ? get_youtube_id($social['order_video']) : "c5XCpSv0WHk"; ?>" frameborder="0" allowfullscreen></iframe>
                 </div>
             </div>
         </div>
     </div>
 <?php endif; ?>


</div>

</div>
</div>
</div>

<div class="step_1 p-r">
 <div class="loader"></div>
 <!-- popular shop -->
 <!-- popular item -->
 <!-- how it works -->
</div>

<div class="step_2 p-r">
 <div class="loader"></div>
 <!-- left/right features -->
 <!-- FAQ -->
 <!-- services -->
 <!-- team -->
 <!-- pricing -->
</div>




<script>
 $(document).ready(function() {

  		// Show the loader
    $('.loader').show();

  		// Load step_1
    $.ajax({
       url: '<?php echo site_url('home/step_1'); ?>',
       type: 'GET',
       dataType: 'json',
       success: function(response) {
          if (response.st === 1) {
             $('.step_1').html(response.load_data);
             console.log('step_1 loaded');
             $.ajax({
                url: '<?php echo site_url('home/step_2'); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                   if (response.st === 1) {
                      $('.step_2').html(response.load_data);
                  }
                  console.log('step_2 loaded');
                  $('.loader').hide();
              },
              error: function(xhr, status, error) {
               console.error('Error loading step_2:', error);
               $('.loader').hide();
           }
       });
         } else {
             $('.loader').hide();
         }


         init();


     },
     error: function(xhr, status, error) {
      console.error('Error loading step_1:', error);
      $('.loader').hide();
  }


});
});

 function init() {

    $(document).on("click", ".page_accordion_header", function() {
       $(this).toggleClass("active").next().slideToggle(300);
       $(this).toggleClass('arrow_up').toggleClass('arrow_down');
   });




}
</script>

