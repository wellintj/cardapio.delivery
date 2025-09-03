<section class="sectionDefault categorySection">
	<?php include "include/banner.php"; ?>
	<div class="section_items">
    <div class="container restaurant-container style_2 theme_1">
      <div class="row">
        <div class="col-md-12">
          <div class="defaultHeading single__cat__header <?= __sub($id) == 1?"pb-20":"";?>">
            <select name="" class="ci-select" onchange="window.location.href=this.value">
              <?php foreach ($cat_list as $cat): ?>
                <option value="<?= base_url("item-types/{$slug}/".md5(multi_lang($id,$cat))) ;?>" <?= md5(multi_lang($id,$cat))==$cat_id?"selected":""?>><?= $cat['name'] ;?></option>
              <?php endforeach ?>
            </select>
            
            <div class="searchSection">
              <form action="<?= base_url('profile/ajax_pagination/'.$slug.'/'.$cat_id) ;?>" method="get" class="itemSearch-2" autocomplete="off">
                <div class="searchBar-2">
                  <div class="search-box-2">
                    <input type="text" class="search-txt-2" name="item" placeholder="<?= lang('search'); ?>" autocomplete="off">
                    <button type="submit" class="search-btn">
                      <i class="icofont-search"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php if(__sub($id) == 1): ?>
        <div class="subcateogry mb-30">
          <?php include APPPATH . 'views/common_layouts/sub_category_list.php'; ?>
        </div>
      <?php endif ?>
    </div>
    <div class="container restaurant-container style_2 theme_1">
      <div class="row">
        <div class="col-md-12">
          <div id="showCatItem">
            <?php include "include/ajax_single_item_list.php"; ?>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>