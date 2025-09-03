<section class="sectionDefault categorySection theme_2">
  <?php include "include/banner.php"; ?>
  <div class="section_items">
    <div class="defaultHeading text-center">
      <div class="categoryDetails">
        <?php if (is_image($shop_id) == 0) : ?>
          <div class="catTop img bg_loader" data-src="<?= get_img($cat_info['thumb'], '', 1); ?>" style="background: url(<?= img_loader(); ?>);">
          </div>
        <?php endif; ?>
        <h1 class="mb-6"><?= @$cat_info['name']; ?></h1>
      </div>
      <div class="container">
        <?php include APPPATH . 'views/common_layouts/sub_category_list.php'; ?>
      </div>
    </div>
    <div class="container restaurant-container">
      <div class="row">
        <div class="col-md-9">
          <div id="showCatItem">
            <?php include "include/ajax_single_item_list.php"; ?>
          </div>

        </div>
        <div class="col-md-3">
          <div class="singleMenuItem">
            <?php include 'include/rightbar.php' ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>