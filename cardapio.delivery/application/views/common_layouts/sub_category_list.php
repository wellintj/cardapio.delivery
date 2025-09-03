<?php if (isset($sub_category_list) && sizeof($sub_category_list) > 0) : ?>
    <div class="subcategoryList">
        <ul>
            <?php foreach ($sub_category_list as $key => $subcat) : ?>
                <li class="<?= isset($sub_category_id) && $sub_category_id == md5($subcat['id']) ? "active" : ""; ?>"><a href="<?= base_url("subcategory/{$slug}/" . md5($subcat['id'])); ?>">
                        <?php if (is_image($shop_id) == 0) : ?>
                            <img src="<?= get_img($subcat['thumb'], '', 1); ?>" alt="subcat_img">
                        <?php endif ?>

                        <?= $subcat['sub_category_name']; ?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>