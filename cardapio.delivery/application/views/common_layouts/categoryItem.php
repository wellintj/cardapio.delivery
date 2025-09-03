  <div class="categorySection mb-50">
    <div class="container restaurant-container">
      <div class="defaultHeading space-between pb-20">
        <h4><?= get_title($id, 'menu', 1); ?></h4>
      </div>
      <div class="item-wrapper">
        <div class="topCategory itemList">
          <div class="swiper-container mySwiper">
            <div class="swiper-wrapper">
              <?php foreach ($categories as $key => $cat) : ?>
                <div class="swiper-slide">
                  <a href="<?= base_url('item-types/' . $slug . '/' . md5(multi_lang($id, $cat))); ?>" class="items">
                    <div class="singleCatItem <?= is_image($shop_id); ?>">
                      <?php if (is_image($shop_id) == 0) : ?>
                        <div class="catTop img bg_loader" data-src="<?= get_img($cat['thumb'], '', 1); ?>" style="background: url(<?= img_loader(); ?>);"></div>
                      <?php endif; ?>
                      <h4><?= html_escape($cat['name']); ?></h4>
                    </div>
                  </a>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- Add Navigation Arrows -->
            <div class="swiper-button-next" ></div>
            <div class="swiper-button-prev"></div>
          </div>

        </div>

      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var swiper = new Swiper(".mySwiper", {
        slidesPerView: 2,  
        spaceBetween: 10,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        breakpoints: {
          640: {
            slidesPerView: 2, 
            spaceBetween: 20,
          },
          768: {
            slidesPerView: 4, 
            spaceBetween: 15,
          },
          1024: {
            slidesPerView: 7.5, 
            spaceBetween: 10,
          },
        },

      });
    });

  </script>
