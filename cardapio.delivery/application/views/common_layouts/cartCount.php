 <?php if (__cart()->shop_id == @$shop_id) : ?>
     <?php if ($this->cart->total_items() > 0 && check_shop_open_status(@$shop_id) == 1) : ?>
         <?php if (empty(auth('is_pos')) && auth('is_pos')==0) : ?>
             <span class="cartCount">
                 <?= __cart()->qty; ?>
             </span>
         <?php endif; ?>
     <?php endif; ?>
 <?php endif; ?>