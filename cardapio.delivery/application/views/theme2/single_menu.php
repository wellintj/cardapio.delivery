<section class="sectionDefault theme_2">
  <?php include "include/home_banner.php"; ?>

  <?php include APPPATH . 'views/common_layouts/coupon_list.php'; ?>
  <div class="section_items">
    <div class="defaultHeading text-center">
      <h1 class="mb-6"><?= get_title($id, 'menu', 1); ?></h1>
      <?php if (!empty(get_title($id, 'menu', 2))) : ?>
        <p><?= get_title($id, 'menu', 2); ?></p>
      <?php endif; ?>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <div class="gallery_area">
            <div class="gallery_top_menu">
              <ul class="gallery_sort">
                <li><button data-filter='*' class="active default-button categoryItem"><i class="fas fa-list-ul"></i> <?= lang('all'); ?></button></li>
                <?php foreach ($all_items as $key => $type) : ?>
                  <?php if (count($type['items']) > 0) : ?>
                    <li><button data-filter='.<?= html_escape($type['category_id']); ?>' class="default-button categoryItem" data-id="<?= html_escape($type['category_id']); ?>"> <?php if (is_image($shop_id) == 0) : ?>
                          <img class="catImg" src="<?= get_img($type['thumb'], '', 1); ?>" alt="cat_img">
                        <?php endif ?>
                        <span class="categoryName"> <?= html_escape($type['name']); ?></span></button></li>
                  <?php endif; ?>
                <?php endforeach ?>
              </ul>

              <?php if (__sub($id) == 1) : ?>
                <?php foreach ($all_items as $key => $type) : ?>
                  <?php if (count($type['items']) > 0) : ?>
                    <?php if (isset($type['sub_categories']) && sizeof($type['sub_categories']) > 0) : ?>
                      <ul class="subcategories subCat subCat_<?= $type['category_id']; ?>  .<?= $type['category_id'] ?>" style="display:none;">
                        <li><a href="javascript:;" class="active" data-filter='*'><?= __('all'); ?></a></li>
                        <?php foreach ($type['sub_categories'] as  $key => $subcat) : ?>
                          <li><a href="javascript:;" data-filter='.s_<?= html_escape($subcat->id); ?>'><?= $subcat->sub_category_name; ?></a></li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>



            </div>
            <div class="grid <?= __sub($id) == 1 ? "mt-10" : ''; ?>">
              <?php foreach ($all_items as $key => $type) : ?>
                <?php foreach ($type['items'] as $key => $row) : ?>
                  <div class="grid-item <?= $row['cat_id'] ?> s_<?= $row['sub_category_id']; ?>  portfolio_single_img">
                    <div class="itemImages">
                      <?php include "include/item_thumbs.php"; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endforeach; ?>
            </div>
          </div><!-- gallery_area -->
        </div>
        <div class="col-md-3">
          <div class="singleMenuItem <?= isset($is_search) && $is_search == TRUE ? "mt-0" : "mt-85"; ?> <?= __sub($id) == 1 ? "mt-10" : ''; ?>">
            <?php include 'include/rightbar.php' ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>