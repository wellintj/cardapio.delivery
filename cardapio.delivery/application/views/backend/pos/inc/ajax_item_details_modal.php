
<div class="modal-content">

  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= html_escape($item[0]['title']) ;?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body item_modal">
    
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close'); ?></button>
    <?php $is_extra = $this->admin_m->check_extra_by_item_id($item[0]['item_id']); ?>
    <?php if(shop($item[0]['shop_id'])->stock_status == 1): ?>

      <?php if($item[0]['in_stock'] > $item[0]['remaining']): ?>

          <?php if($item[0]['is_size']==1): ?>
            <form action="<?= base_url('admin/pos/add_to_cart_form') ;?>" method="post" class="add_to_cart_form">
              <?= csrf() ;?>
              <input type="hidden" name="item_type" value="item">
              <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
              <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">

              <input type="hidden" name="item_size" class="item_size" value="" required="">
              <input type="hidden" name="size_title" class="size_title" value="" required="">

              <input type="hidden" name="extra_id" class="extra_id" value="">

              <!--check price for extra  -->
              <?php if($is_extra['check'] ==1): ?> 
                <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
                <input type="hidden" name="extra_name" class="extra_name" value="">
              <?php endif; ?>


              <button type="submit" class="btn btn-primary add_to_cart_btn <?=  isset($item[0]['is_size']) && $item[0]['is_size']==1?"hidden":"";?>"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
            </form>
          <?php else:?>

            <form action="<?= base_url('dmin/pos/add_to_cart_form') ;?>" method="post" class="add_to_cart_form">
              <?= csrf() ;?>
                <input type="hidden" name="item_type" value="item">
                <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
                <input type="hidden" name="item_size" class="item_size" value="">
                <input type="hidden" name="extra_id" class="extra_id" value="">
                <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">

                <!--check price for extra  -->
                <?php if($is_extra['check'] ==1): ?> 
                  <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
                  <input type="hidden" name="extra_name" class="extra_name" value="">
                <?php endif; ?>

                <button type="submit" class="btn btn-primary add_to_cart_btn"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
            </form>
            
          <?php endif;?> <!--/ is sizes -->
      
      <?php endif;?>


    <?php else: ?><!-- check stock status -->

      <?php if($item[0]['is_size']==1): ?>
        <form action="<?= base_url('dmin/pos/add_to_cart_form') ;?>" method="post" class="add_to_cart_form">
          <?= csrf() ;?>
          <input type="hidden" name="item_type" value="item">
          <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
          <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">

          <input type="hidden" name="item_size" class="item_size" value="" required="">
          <input type="hidden" name="size_title" class="size_title" value="" required="">

            <!--check price for extra  -->
            <?php if($is_extra['check'] ==1): ?> 
              <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
              <input type="hidden" name="extra_name" class="extra_name" value="">
            <?php endif; ?>

          <input type="hidden" name="extra_id" class="extra_id" value="">

          <button type="submit" class="btn btn-primary add_to_cart_btn <?=  isset($item[0]['is_size']) && $item[0]['is_size']==1?"hidden":"";?>"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
        </form>
       <?php else:?>

         <form action="<?= base_url('dmin/pos/add_to_cart_form') ;?>" method="post" class="add_to_cart_form">
              <?= csrf() ;?>
                <input type="hidden" name="item_type" value="item">
                <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
                <input type="hidden" name="item_size" class="item_size" value="">

                <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">

                <!--check price for extra  -->
                <?php if($is_extra['check'] ==1): ?> 
                  <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
                  <input type="hidden" name="extra_name" class="extra_name" value="">
                <?php endif; ?>
                
                <input type="hidden" name="extra_id" class="extra_id" value="">
                <button type="submit" class="btn btn-primary add_to_cart_btn"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
            </form>
      <?php endif;?>

    <?php endif;?><!-- //check stock status -->

      



  </div>
  
</div>



