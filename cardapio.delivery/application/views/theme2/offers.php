<div class="offerPage">
    <?php include APPPATH . 'views/common_layouts/topMenu.php' ?>
    <div class="container restaurant-container theme_2">
        <?php foreach ($offer_list as  $key => $offer) : ?>
            <?php $offer_discount = $offer['discount'] ?? 0 ;?>
            <h4 class="title"><?= $offer['name'] ?></h4>
            <div class="offerItems">
                <div class="row">
                    <?php foreach ($offer['items'] as $key => $row) : ?>
                        <div class="col-xl-4 col-lg-34 col-md-6 col-sm-6 q-sm gap-10">
                            <?php include "include/item_thumbs.php"; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>