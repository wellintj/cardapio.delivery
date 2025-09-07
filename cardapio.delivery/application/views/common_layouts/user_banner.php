<?php include APPPATH . 'views/common_layouts/topMenu.php' ?>
<?php if (isset($page_title) && $page_title != "Checkout") : ?>
  <?php $slider_list = $this->admin_m->select_by_shop_id_status($shop_info->id, 'vendor_slider_list'); ?>
  <?php if (isset($slider_list, $page_title) && sizeof($slider_list) > 0 && $page_title == 'Profile') : ?>
    <?php include VIEWPATH . "common_layouts/home_slider.php"; ?>
  <?php else : ?>
    <?php $user_settings = u_settings($id); ?>
    <?php if (isset($user_settings['is_banner']) && $user_settings['is_banner'] == 0) : ?>
      <section class="user_home_banner img bg_loader menu_style_<?= isset($user['menu_style']) ? $user['menu_style'] : 0 ?>" data-src="<?= base_url(!empty(restaurant($id)->cover_photo) ? restaurant($id)->cover_photo : 'assets/frontend/images/bg/bg_1.jpg'); ?>" style="background: url(<?= bg_loader(); ?>);">
        <div class="container restaurant-container">
          <div class="single_banner">
            <img src="<?= html_escape(!empty($shop['thumb']) ? base_url($shop['thumb']) : ''); ?>" alt="">
            <div class="userbanner_right">
              <div class="userbanner_top">
                <h4><?= html_escape(!empty($shop['name']) ? $shop['name'] : $shop['username']); ?></h4>
              </div>
              <div class="userbanner_bottpm">
                <?php if (!empty($shop['location'])) : ?>
                  <p class="address"><i class="icofont-google-map"></i> <a href="<?= redirect_url($shop['location'], 'google'); ?>"><?= $shop['address']; ?></a></p>
                <?php endif; ?>
                <div class="social_icon_section">
                  <div class="home_social list style_1">
                    <ul>

                      <?php if (!empty($shop['phone'])) : ?>
                        <li><a href="<?= redirect_url($shop['phone'], 'phone', $shop['dial_code']); ?>"><i class="fas fa-phone fa-flip-horizontal phone"></i><?= $shop['dial_code']; ?> <?= html_escape($shop['phone']); ?> </a></li>
                      <?php endif; ?>

                      <?php if (!empty($social['whatsapp'])) : ?>
                        <li><a href="<?= redirect_url($social['whatsapp'], 'whatsapp', $shop['dial_code'], url($shop['username'])); ?>"><i class="fab fa-whatsapp whatsapp"></i><?= $shop['dial_code']; ?> <?= html_escape($social['whatsapp']); ?></a></li>
                      <?php endif; ?>

                     
                    </ul>
                  </div>
                </div><!--social_icon_section-->
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php else : ?>
      <?php if (isset($user_settings['is_banner']) && $user_settings['is_banner'] == 1) : ?>
        <div class="mt-50"></div>
      <?php endif ?>

    <?php endif; ?>
  <?php endif; ?>
<?php endif; ?>