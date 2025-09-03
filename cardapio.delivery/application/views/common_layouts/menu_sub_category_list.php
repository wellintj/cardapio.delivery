<div class="subcategoryList menuSubcategoryList">
    <p><?= lang('sub_categories'); ?></p>
    <ul>
        <?php foreach ($sub_category_list as $key => $subcat) : ?>
            <li class="<?= isset($sub_category_id) && $sub_category_id == md5($subcat['id']) ? "active" : ""; ?>"><a href="<?= base_url("subcategory/{$slug}/" . md5($subcat['id'])); ?>"><?= $subcat['sub_category_name']; ?></a></li>
        <?php endforeach ?>
    </ul>
</div>