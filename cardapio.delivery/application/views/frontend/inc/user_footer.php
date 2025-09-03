<?php $user_settings = u_settings($id); ?>
<div class="footer_area">
  <?php if (isset($user_settings['is_footer']) && $user_settings['is_footer'] == 0) : ?>

    <div class="top_footer">
      <div class="container restaurant-container">
        <div class="row <?= isset($shop_info->is_quick_access) && $shop_info->is_quick_access == 0 ? "justify-content-center" : "" ?>">

          <div class=" col-lg-4 col-sm-4 col-xs-12">
            <div class="left_footer">
              <div class="qrCode">
                <img src="<?= base_url(!empty($user['qr_link']) ? $user['qr_link'] : ''); ?>" alt="">
              </div>
              <h4><?= html_escape(!empty(restaurant($id)->name) ? restaurant($id)->name : restaurant($id)->username); ?></h4>

              <div class="shopFooterInfo">
                <?php if (isset($shop['phone']) && !empty($shop['phone'])) : ?>
                  <p class="phone mb-5"><i class="fas fa-phone fa-flip-horizontal phone mr-5 "></i> <a href="<?= redirect_url($shop['phone'], 'phone', $shop['dial_code']); ?>"><?= $shop['dial_code']; ?> <?= html_escape($shop['phone']); ?></a></p>
                <?php endif; ?>

                <?php if (!empty(restaurant($id)->location)) : ?>
                  <p class="address"><i class="icofont-google-map"></i> <a href="<?= redirect_url(restaurant($id)->location, 'google'); ?>"><?= restaurant($id)->address; ?></a></p>
                <?php endif; ?>

              </div>
              <ul class="">

                <?php if (!empty($social['facebook'])) : ?>
                  <li><a href="<?= redirect_url($social['facebook'], 'facebook'); ?>"><i class="fa fa-facebook facebook"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($social['instagram'])) : ?>
                  <li><a href="<?= redirect_url($social['instagram'], 'instagram'); ?>"><i class="fa fa-instagram instagram"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($social['whatsapp'])) : ?>
                  <li><a href="<?= redirect_url($social['whatsapp'], 'whatsapp', $shop['dial_code'], url(restaurant($id)->username)); ?>"><i class="fa fa-whatsapp whatsapp"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($social['twitter'])) : ?>
                  <li><a href="<?= redirect_url($social['twitter'], 'twitter'); ?>"><i class="fa fa-twitter twitter"></i></a></li>
                <?php endif; ?>

                <?php if (!empty($social['youtube'])) : ?>
                  <li><a href="<?= redirect_url($social['youtube'],'youtube'); ?>" class="venobox" data-autoplay="true" data-vbtype="video"><i class="fa fa-youtube youtube"></i></a></li>
                <?php endif; ?>
                
                 <?php if (!empty($social['tiktok'])) : ?>
                  <li><a href="<?= redirect_url($social['tiktok'],'tiktok'); ?>"><i class="fab fa-tiktok youtube"></i></a></li>
                <?php endif; ?>
              </ul>
            </div>
          </div>

          <?php $days = get_days(); ?>
          <?php if (isset($days) && !empty($days)) : ?>
            <?php
            $currentDay = strtolower(date('l'));
            $available_type = isset($shop_info->available_type) && $shop_info->available_type == 'open' ? 'open' : 'close';
            ?>

            <div class="col-12 col-sm-4 col-lg-4 ">
              <div class="left_footer">
                <h4> </h4>
                <ul class="row_ul availableDays  <?= isset($shop_info->available_type) ? $shop_info->available_type : ''; ?>">
                  <?php $i = 0;

                  foreach ($days as $key => $day) : ?>
                    <?php if ($available_type == 'open') : ?>
                      <?php if (strtolower($day) == $currentDay) : ?>
                        <?php include "common/avaiable_days.php"; ?>
                      <?php endif; ?>
                    <?php else : ?>
                      <?php include "common/avaiable_days.php"; ?>
                  <?php endif;
                  endforeach; ?>
                  <?php if ($available_type == 'open') : ?>
                    <li><a href="#availableDays" class="f-color mr-10" data-toggle="modal"> <i class="fa fa-calendar-minus-o"></i> <?= lang('available_days'); ?></a></li>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          <?php endif; ?>

          <?php if (isset($shop_info->is_quick_access) && $shop_info->is_quick_access == 1) : ?>
            <div class=" col-6 col-sm-4 col-lg-4 sm-p-5">
              <div class="left_footer">
                <h4><?= !empty(lang('quick_links')) ? lang('quick_links') : "Quick Links"; ?></h4>
                <ul class="row_ul">
                  <?php __menu($shop_id??0, '-', true); ?>

                  <li><a href="<?= url($slug); ?>"><i class="icofont-simple-right"></i> <?= !empty(lang('home')) ? lang('home') : "home"; ?></a></li>

                  <?php if (is_feature($id, 'reservation') == 1 && is_active($id, 'reservation')) : ?>
                    <li><a href="<?= url('reservation/' . $slug); ?>"><i class="icofont-simple-right"></i> <?= !empty(lang('reservation')) ? lang('reservation') : "reservation"; ?></a></li>
                  <?php endif; ?>

                  <li><a href="<?= url('about-us/' . $slug); ?>"><i class="icofont-simple-right"></i> <?= !empty(lang('about_us')) ? lang('about_us') : "About Us"; ?></a></li>

                  <li><a href="<?= url('track-order/' . $slug); ?>"><i class="icofont-simple-right"></i> <?= !empty(lang('track_order')) ? lang('track_order') : "track order"; ?></a></li>

                  <?php if (is_feature($id, 'contacts') == 1 && is_active($id, 'contacts')) : ?>
                    <li><a href="<?= url('shop-contacts/' . $slug); ?>"><i class="icofont-simple-right"></i> <?= !empty(lang('contacts')) ? lang('contacts') : "contacts"; ?></a></li>
                  <?php endif; ?>

                  <?php if (isset(restaurant($id)->is_review) && restaurant($id)->is_review == 1) : ?>
                    <li><a href="<?= url('shop-reviews/' . $slug); ?>"><i class="icofont-simple-right"></i> <?= !empty(lang('reviews')) ? lang('reviews') : "reviews"; ?></a></li>
                  <?php endif; ?>

                  <?php if (isset(restaurant($id)->is_login) && restaurant($id)->is_login == 1) : ?>
                  <li><a href="<?= base_url('staff-login/customer'); ?>"><i class="icofont-simple-right"></i> <?= !empty(lang('login')) ? lang('login') : "Login"; ?></a></li>
                <?php endif ?>


                </ul>
              </div>
            </div>
          <?php endif; ?>


        </div>
      </div>

    </div>
    <div class="footer_bottom text-center">
      <?php if (isset(restaurant($id)->is_branding) && restaurant($id)->is_branding == 1) : ?>
        <p class="created_by"><img src="<?= avatar(st()->logo, 'item'); ?>" alt=""> <?= lang('created_by'); ?> <a href="<?= base_url(""); ?>"><?= $this->settings['site_name']; ?></a></p>
      <?php else : ?>
        <p>© <?= html_escape(!empty(restaurant($id)->name) ? restaurant($id)->name : restaurant($id)->username); ?> </p>
      <?php endif; ?>
    </div>

  <?php endif ?>
</div>