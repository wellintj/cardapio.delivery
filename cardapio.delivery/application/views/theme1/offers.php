<div class="offerPage">
    <?php include APPPATH . 'views/common_layouts/topMenu.php' ?>
    <div class="container restaurant-container">
        <?php foreach ($offer_list as  $key => $offer) : ?>
            <?php $offer_discount = $offer['discount'] ?? 0 ;?>
            <h4 class="title"><?= $offer['name'] ?></h4>
            <div class="offerItems style_2">
                <div class="row homeStyle_3">
                    <?php foreach ($offer['items'] as $key => $row) : ?>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 q-sm col-6">
                            <?php include "include/item_thumbs.php"; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>