<div class="row">
    <?php include APPPATH . 'views/backend/common/inc/leftsidebar.php'; ?>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header space-between">
                <h4><?= lang('menu'); ?></h4>
                <a href="#addMenuList" data-toggle="modal" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i> <?= lang('add_new'); ?></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class='table table-striped table-bordered '>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('title'); ?></th>
                                <th><?= lang('url'); ?></th>
                                <th><?= lang('is_dropdown'); ?></th>
                                <th><?= lang('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menu_list as  $key => $row) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $row['title']; ?></td>
                                    <td>
                                        <?php if ($row['is_extranal_url'] == 0) : ?>
                                            <?= empty($row['url']) || $row['url'] == '#' ? $row['url'] : base_url($row['url']); ?>
                                        <?php else : ?>
                                            <?= prep_url($row['url']); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (isset($row['dropdownList']) && sizeof($row['dropdownList']) > 0) : ?>

                                        <div class='table-responsive'>
                                            <table class='table table-striped table-bordered'>
                                                <thead>
                                                    <tr>
                                                        <th><?= lang('title'); ?></th>
                                                        <th><?= lang('url'); ?></th>
                                                        <th><?= lang('action'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($row['dropdownList'] as  $keys => $list) : ?>
                                                        <tr>
                                                            <td><?= $list['title']; ?></td>
                                                            <td> <?php if ($list['is_extranal_url'] == 0) : ?>
                                                            <?= empty($list['url']) || $list['url'] == '#' ? '#' : base_url($list['url']); ?>
                                                        <?php else : ?>
                                                            <?= prep_url($list['url']); ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="btnGroup">
                                                        <a href="#editMenu_<?= $list['id']; ?>" data-toggle="modal" class="btn btn-sm btn-info"> <i class="fa fa-edit"></i> </a>
                                                        <?= __deleteBtn($row['id'], 'vendor_menu_list', false); ?>
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="btnGroup">
                            <?php if ($row['is_dropdown'] == 1) : ?>
                                <a href="javascript:;" onclick="addModal(`<?= $row['id'] ?>`)" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i> <?= lang('add_new'); ?></a>
                            <?php endif; ?>

                            <a href="javascript:;" onclick="editModal(`<?= $row['id'] ?>`,true)" class="btn btn-secondary btn-sm"><i class="fa fa-copy"></i></a>

                            <a href="javascript:;" onclick="editModal(`<?= $row['id'] ?>`,false)" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>

                            <?= __deleteBtn($row['id'], 'vendor_menu_list', false); ?>



                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>


<div id="addMenuList" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url("admin/restaurant/add_menu"); ?>" method="post">
                <?= csrf(); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= lang('add_new'); ?> - <?= __language(''); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><?= lang('title'); ?></label>
                        <input type="text" name="title" class="form-control" placeholder="<?= lang('title'); ?>" value="">
                    </div>
                    <div class="form-group">
                        <label for=""><?= lang('url'); ?></label>
                        <div class="ci-input-group input-group-append">
                            <div class="input-group btn btn-default">
                                <label class="custom-checkbox"> <input type="checkbox" name="is_extranal_url"><?= lang('extranal_link'); ?></label>
                            </div>
                            <input type="text" name="url" class="form-control" placeholder="<?= lang('url'); ?>" value="">
                        </div>

                    </div>

                    <div class="form-group mt-10 quickCheck">
                        <label class="custom-checkbox mr-5"><input type="checkbox" name="is_quick_link" value="1"> <?= lang('quick_access'); ?></label>

                        <label class="custom-checkbox is_dropdown"><input type="checkbox" name="is_dropdown" value="1"> <?= lang('is_dropdown'); ?></label>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="language" value="<?= site_lang() ?? 'english' ?>">
                    <input type="hidden" name="id" value="0">
                    <input type="hidden" name="dropdown_id" value="0">
                    <button type="submit" class="btn btn-success "><?= lang('submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="addMenu" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url("admin/restaurant/add_menu"); ?>" method="post">
                <?= csrf(); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= lang('add_new'); ?> - <?= __language(''); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><?= lang('title'); ?></label>
                        <input type="text" name="title" class="form-control" placeholder="<?= lang('title'); ?>" value="">
                    </div>
                    <div class="form-group">
                        <label for=""><?= lang('url'); ?></label>
                        <div class="ci-input-group input-group-append">
                            <div class="input-group btn btn-default">
                                <label class="custom-checkbox"> <input type="checkbox" name="is_extranal_url"><?= lang('extranal_link'); ?></label>
                            </div>
                            <input type="text" name="url" class="form-control" placeholder="<?= lang('url'); ?>" value="">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="language" value="<?= site_lang() ?? 'english' ?>">
                    <input type="hidden" name="id" value="0">
                    <input type="hidden" name="dropdown_id" value="0">
                    <button type="submit" class="btn btn-success "><?= lang('submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($menuList as  $key => $menu) : ?>

    <div id="editMenu_<?= $menu['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url("admin/restaurant/add_menu"); ?>" method="post">
                    <?= csrf(); ?>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?= lang('edit'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for=""><?= lang('title'); ?></label>
                            <input type="text" name="title" class="form-control" placeholder="<?= lang('title'); ?>" value="<?= isset($menu['title']) ? $menu['title'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for=""><?= lang('url'); ?></label>
                            <div class="ci-input-group input-group-append">
                                <div class="input-group btn btn-default">
                                    <label class="custom-checkbox"> <input type="checkbox" name="is_extranal_url" <?= isset($menu['is_extranal_url']) && $menu['is_extranal_url'] == 1 ? "checked" : ''; ?>><?= lang('extranal_link'); ?></label>
                                </div>
                                <input type="text" name="url" class="form-control" placeholder="<?= lang('url'); ?>" value="<?= isset($menu['url']) ? $menu['url'] : ''; ?>">
                            </div>

                        </div>


                        <div class="form-group languageDropdown" style="display: none;">
                            <label><?= lang('language'); ?></label>
                            <?php languageDropdown($data, false) ?>
                        </div>

                        <div class="form-group mt-20 quickCheck">
                            <label class="custom-checkbox mr-5"><input type="checkbox" name="is_quick_link" value="1" <?= isset($menu['is_quick_link']) && $menu['is_quick_link'] == 1 ? "checked" : ''; ?>> <?= lang('quick_access'); ?></label>

                            <label class="custom-checkbox is_dropdown"><input type="checkbox" name="is_dropdown" value="1" <?= isset($menu['is_dropdown']) && $menu['is_dropdown'] == 1 ? "checked" : ''; ?>> <?= lang('is_dropdown'); ?></label>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= $menu['id'] ?? 0; ?>">
                        <input type="hidden" name="dropdown_id" value="<?= $menu['dropdown_id'] ?? 0; ?>">
                        <input type="hidden" name="is_clone" value="0">
                        <button type="submit" class="btn btn-success "><?= lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach; ?>




<script>
    $(document).on('click', '[name="is_quick_link"]', function() {
        if ($(this).prop("checked")) {
            $('[name="is_dropdown"]').prop("checked", false);
            $('.is_dropdown').slideUp();
        } else {
            $('.is_dropdown').slideDown();
        }
    })

    function addModal(id) {
        $('#addMenu').modal('show');
        $('#addMenu [name="dropdown_id"]').val(id);
    }

    function editModal(id, isClone = false) {
        $('#editMenu_' + id).modal('show');
        if (isClone == true) {
            $('[name="is_clone"]').val(1);
            $('.languageDropdown').slideDown();
        } else {
            $('[name="is_clone"]').val(0);
            $('.languageDropdown').slideUp();
        }
    }
</script>