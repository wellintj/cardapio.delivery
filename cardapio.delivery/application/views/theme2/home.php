<?php if (is_feature($id, 'welcome') == 1 && is_active($id, 'welcome')) : ?>
  <section class="sectionDefault pb-0 theme_2">
    <?php include "include/home_banner.php"; ?>


    <section class="Searcharea">
      <div class="container restaurant-container">
        <div class="searchSection welcomeSearch">
          <form action="<?= base_url('profile/ajax_pagination/' . $slug . '/0'); ?>" method="get" class="itemSearch-2" autocomplete="off">
            <div class="searchBar-2">
              <div class="search-box-2">
                <input type="text" class="search-txt-2" name="item" placeholder="<?= lang('search_for_items'); ?>" autocomplete="off" required>
                <button type="submit" class="search-btn">
                  <i class="icofont-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="container restaurant-container">
        <div class="row">
          <div class="col-md-12">
            <div id="showCatItem">

            </div>

          </div>

        </div>
      </div>
    </section>


    <?php include APPPATH . 'views/common_layouts/categoryItem.php'; ?>

    <?php if (isset($user['home_page_style']) && $user['home_page_style'] == 2): ?>

      <?php if (count($all_items) > 0): ?>
        <?php if (is_feature($id, 'menu') == 1 && is_active($id, 'menu')): ?>
          <div class="singleHome_item">
            <div class="container restaurant-container">
              <div class="defaultHeading">
                <h1><?= get_title($id, 'menu', 1); ?></h1>
                <?php if (!empty(get_title($id, 'menu', 2))): ?>
                  <p><?= get_title($id, 'menu', 2); ?></p>
                <?php endif; ?>
              </div>
              <?php foreach ($all_items as $key => $type): ?>
                <?php if (count($type['items']) > 0): ?>
                  <div class="homeView">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="singleCategoryHeader">
                          <h4><?= html_escape($type['name']); ?></h4>
                          <?php if (count($type['items']) >= 4): ?>
                            <a href="<?= base_url('item-types/' . $slug . '/' . md5(multi_lang($id, $type))); ?>" class="seeMore_link"><?= lang('see_more'); ?> &nbsp;<i class="icofont-thin-double-right fw_bold"></i></a>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <?php foreach ($type['items'] as $key => $row): ?>
                        <div class="col-md-6 q-sm">
                          <?php include "include/item_thumbs.php"; ?>
                        </div>
                      <?php endforeach ?>
                    </div>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>

            </div>
          </div>
        <?php endif; ?>
      <?php endif; ?>


      <?php include VIEWPATH . "common_layouts/offer_list.php"; ?>

    <?php else: ?>

      <?php if (is_feature($id, 'menu') == 1 && is_active($id, 'menu')) : ?>
        <?php if (isset($item_list) && sizeof($item_list) > 0) : ?>
          <div class="singleHome_item">
            <div class="container restaurant-container">
              <div class="defaultHeading">
                <h1><?= __('featured_items'); ?></h1>
              </div>
              <div class="homeView">
                <div class="row">
                  <?php foreach ($item_list as $key => $row) : ?>
                    <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-6 q-sm">
                      <?php include "include/item_thumbs.php"; ?>
                    </div>
                  <?php endforeach ?>
                </div>
              </div>

            </div>
          </div>
        <?php endif; ?>
      <?php endif; ?>



      <?php include VIEWPATH . "common_layouts/offer_list.php"; ?>






      <?php if (is_feature($id, 'menu') == 1 && is_active($id, 'menu')) : ?>
        <?php if (sizeof($popular_items) > 0) : ?>
          <div class="singleHome_item">
            <div class="container restaurant-container">
              <div class="defaultHeading">
                <h1><?= __('popular_items'); ?></h1>
              </div>
              <div class="homeView">
                <div class="row">
                  <?php foreach ($popular_items as $key => $row) : ?>
                    <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-6 q-sm">
                      <?php include "include/item_thumbs.php"; ?>
                    </div>
                  <?php endforeach ?>
                </div>
              </div>

            </div>
          </div>
        <?php endif; ?>
      <?php endif; ?>



    <?php endif; ?>

    <?php if (count($specialties) > 0) : ?>
      <?php if (is_feature($id, 'specialities') == 1 && is_active($id, 'specialities')) : ?>
        <div class="homeItemPcakage specialties">
          <div class="container restaurant-container q-sm">
            <div class="homeItemSection">
              <div class="defaultHeading">
                <h1><?= get_title($id, 'specialities', 1); ?></h1>
                <?php if (!empty(get_title($id, 'specialities', 2))) : ?>
                  <p><?= get_title($id, 'specialities', 2); ?></p>
                <?php endif; ?>
              </div>
              <?php include APPPATH . 'views/layouts/special_thumb.php'; ?>
            </div>
            <?php if (count($specialties) >= 4) : ?>
              <div class="row mt-30">
                <div class="col-md-12">
                  <div class="text-center seeMore_btn">
                    <a href="<?= base_url('specialities/' . $slug); ?>" class="btn custom-btn seemomre"><?= lang('see_more'); ?></a>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>



    <?php if (count($packages) > 0) : ?>
      <?php if (is_feature($id, 'packages') == 1 && is_active($id, 'packages')) : ?>
        <div class="homeItemPcakage Packages">
          <div class="container restaurant-container q-sm">
            <div class="homeItemSection">
              <div class="defaultHeading">
                <h1><?= get_title($id, 'packages', 1); ?></h1>
                <?php if (!empty(get_title($id, 'packages', 2))) : ?>
                  <p><?= get_title($id, 'packages', 2); ?></p>
                <?php endif; ?>
              </div>
              <?php if (count($packages) > 0) : ?>

                <?php foreach ($packages as $key1 => $row) : ?>
                  <div class="singlePackage_wrapper">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="package_title">
                          <h4><?= html_escape($row['package_name']); ?>
                            <span class="home_package_price">
                              <span class="bg-round ml-10"><?= currency_position($row['final_price'], $shop_id); ?></span>
                              <?php if ($row['is_discount'] == 1) : ?>
                                <span class="price_discount"><?= currency_position($row['price'], $shop_id); ?></span>
                              <?php endif; ?>
                            </span>
                          </h4>
                          <?php if (shop($row['shop_id'])->is_cart == 1) : ?>
                            <div class="package_order_btn text-center">
                              <?php if (shop($row['shop_id'])->stock_status == 1) : ?>

                                <?php if ($row['in_stock'] > $row['remaining']) : ?>
                                  <a href="javascript:;" class="btn custom-btn add_to_cart" data-id="<?= html_escape($row['id']); ?>" data-type="package" data-placement="top" data-toggle="tooltip" title="<?= lang('add_to_cart'); ?>"><i class="icofont-ui-cart"></i> <?= lang('add_to_cart'); ?></a>
                                <?php else : ?>
                                  <span class="out_of_stock"><?= lang('out_of_stock'); ?></span>
                                <?php endif; ?>

                              <?php else : ?>
                                <a href="javascript:;" class="btn custom-btn add_to_cart" data-id="<?= html_escape($row['id']); ?>" data-type="package" data-placement="top" data-toggle="tooltip" title="<?= lang('add_to_cart'); ?>"><i class="icofont-ui-cart"></i> <?= lang('add_to_cart'); ?></a>
                              <?php endif; ?>

                            </div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <div class="homePackage_details">
                      <div class="row">
                        <?php foreach ($row['items'] as $key => $item) : ?>
                          <div class="col-md-6">
                            <?php include APPPATH . 'views/layouts/package_thumb.php'; ?>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <?php if (count($packages) >= 4) : ?>
              <div class="row">
                <div class="col-md-12">
                  <div class="text-center seeMore_btn">
                    <a href="<?= base_url('packages/' . $slug); ?>" class="btn custom-btn seemomre"><?= lang('see_more'); ?></a>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>

  </section>
<?php endif; ?>