<?php $offer_list = $this->common_m->get_offers($shop_id); ?>
<?php if (sizeof($offer_list) > 0) : ?>
    <div class="container ci-container">
        <div class="offerList">
            <div class="row">
                <?php foreach ($offer_list as $key => $offer) : ?>
                    <div class="col-md-6">
                        <a href="<?= url("offers/{$slug}/{$offer['slug']}") ?>">
                            <div class="singleOffer">
                                <img src="<?= img_loader(); ?>" alt="offer image" class="img_loader" data-src="<?= avatar($offer['images'], 'logo') ?>">
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>