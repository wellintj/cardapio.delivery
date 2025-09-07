<?php
if (!empty($class)) {
    $class = $class;
} else {
    $class = 'nav-item ';
}
?>
<?php foreach ($menuList as  $key => $menu) : ?>
    <?php
    if ($menu['is_extranal_url'] == 0) :
        $url =   empty($menu['url']) || $menu['url'] == '#' ? '#' : base_url($menu['url']);
    else :
        $url = prep_url($menu['url']);
    endif;
    ?>
    <?php if ($menu['is_dropdown'] == 0) : ?>
        <li class='<?= $class; ?>'> <a href='<?= $url; ?>'> <?= isset($is_quick) && $is_quick == 1 ? '<i class="icofont-simple-right"></i>' : ""; ?> <?= $menu['title']; ?> </a> </li>
    <?php else : ?>
        <?php if (isset($menu['dropdownList']) && sizeof($menu['dropdownList']) > 0) : ?>
            <li class='navDropdownMenu <?= $is_sidebar == TRUE?"":"menuDropdown";?> '> <a href='javascript:;'> <?= $menu['title']; ?> <i class="icofont-rounded-down"></i></a>
                <div class="navDropdownList" style="display:none;">
                    <ul class="pt-0">
                        <?php foreach ($menu['dropdownList'] as  $keys => $list) : ?>
                            <?php
                            if ($list['is_extranal_url'] == 0) :
                                $url =   empty($list['url']) || $list['url'] == '#' ? '#' : base_url('vpage/'.shop($menu['shop_id'])->username.'/'.$list['url']);
                            else :
                                $url = prep_url($list['url']);
                            endif;
                            ?>
                            <li class='<?= $class; ?>'> <a href='<?= $url; ?>'> <?= $list['title']; ?> </a> </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>