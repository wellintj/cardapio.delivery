<section class="sectionDefault">
  <?php include "include/home_banner.php"; ?>
  <div class="section_items">

    <?php include APPPATH . 'views/common_layouts/coupon_list.php'; ?>


    <div class="defaultHeading text-center">
      <h1 class="mb-6"><?= get_title($id, 'menu', 1); ?></h1>
      <?php if (!empty(get_title($id, 'menu', 2))) : ?>
        <p><?= get_title($id, 'menu', 2); ?></p>
      <?php endif; ?>
    </div>
    <div class="restaurant-container style_2 theme_1">
      <div class="row">
        <div class="col-md-12">
          <div class="gallery_area">
            <div class="gallery_top_menu">
              <ul class="gallery_sort category_shot">
                <li><button id='0' class="active default-button categoryItem"><i class="fas fa-list-ul"></i> <?= lang('all'); ?></button></li>
                <?php foreach ($all_items as $key => $type) : ?>
                  <?php if (count($type['items']) > 0) : ?>
                    <li><button id="<?= $type['category_id']; ?>" class="categoryItem">
                        <?php if (is_image($shop_id) == 0) : ?>
                          <img class="catImg" src="<?= get_img($type['thumb'], '', 1); ?>" alt="cat_img">
                        <?php endif ?>
                        <span class="categoryName"> <?= html_escape($type['name']); ?></span>
                      </button></li>
                  <?php endif; ?>
                <?php endforeach ?>
              </ul>

              <?php if (__sub($id) == 1) : ?>
                <?php foreach ($all_items as $key => $type) : ?>
                  <?php if (count($type['items']) > 0) : ?>
                    <?php if (isset($type['sub_categories']) && sizeof($type['sub_categories']) > 0) : ?>
                      <ul class="subcategories subcat_1 subCategory_<?= $type['category_id']; ?> " style="display:none;">
                        <li><a href="javascript:;" class="active"><?= __('all'); ?></a></li>
                        <?php foreach ($type['sub_categories'] as  $key => $subcat) : ?>
                          <li><a href="javascript:;" id="<?= html_escape($subcat->id); ?>"><?= $subcat->sub_category_name; ?></a></li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>


            </div>
            <div class="all_categories">
              <?php $ids = $sub_cat_ids = []; ?>
              <?php foreach ($all_items as $key => $type) : ?>
                <?php foreach ($type['sub_categories'] as $key => $row) : ?>
                  <?php $sub_cat_ids[] = $row->id; ?>
                <?php endforeach; ?>
                <?php $ids[] = $type['category_id'] ?>
                <?php if (count($type['items']) > 0) : ?>
                  <div class="homeView category_<?= $type['category_id']; ?>" id="category_<?= $type['category_id']; ?>">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="singleCategoryHeader">
                          <h4><?= html_escape($type['name']); ?></h4>
                          <?php if (count($type['items']) >= 4) : ?>
                            <a href="<?= base_url('item-types/' . $slug . '/' . md5(multi_lang($id, $type))); ?>" class="seeMore_link"><?= lang('see_more'); ?> &nbsp;<i class="icofont-thin-double-right fw_bold"></i></a>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <?php foreach ($type['items'] as $key => $row) : ?>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6  q-sm subcatItem subcate_<?= $row['sub_category_id'] ?? 0; ?>">
                          <?php include 'include/item_thumbs.php'; ?>
                        </div>
                      <?php endforeach ?>
                    </div>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div><!-- gallery_area -->
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  var categories = <?= json_encode($ids); ?>;
  var subcategories = <?= json_encode($sub_cat_ids); ?>;
</script>