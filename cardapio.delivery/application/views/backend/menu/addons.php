<style>
    .itemHeader {
        margin-bottom: 13px;
        width: 100%;
    }

    .itemImg img {
        height: 100%;
        width: 100%;
    }

    .card.singlePage .modal-footer,
    .card.singlePage .itemComments {
        display: none;
    }



    .card.singlePage .singleItem {
        max-height: 90dvh;
        overflow-x: hidden;
        overflow-y: auto;
        scroll-behavior: smooth;
    }
</style>
<div class="row">
    <div class="col-md-8 col-lg-7 ">
        <?php $getAddons = $this->admin_m->get_my_addons($data['id'], restaurant()->id, false); ?>
        <div class="card">
            <div class="card-header space-between">
                <?= !empty(lang('extras')) ? lang('extras') : "Extras"; ?> / <?= lang('addons'); ?>
                <a href="#addOnModal" data-toggle="modal" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i> <?= lang('add_new') ?></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php if (!empty($getAddons)) : ?>
                        <table class='table table-striped table-bordered  data_tables'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?= __('title') ?></th>
                                    <th><?= __('type') ?></th>
                                    <th width="50%"><?= __('extras') ?></th>
                                    <th><?= __('action') ?></th>
                                </tr>
                            </thead>
                            <tbody id="sortable" class="sortable sorting">
                                <?php foreach ($getAddons as  $key => $ext) : ?>
                                    <tr id='<?= $ext->id; ?>'>
                                        <td class="handle"><?= $key + 1; ?></td>
                                        <td class="handle"><?= $ext->title; ?></td>
                                        <td>
                                            <?php if ($ext->is_single_select == 1) : ?>
                                                <label class="custom-radio-2"><input type="radio" checked> <?= lang('single_select'); ?></label>
                                            <?php else : ?>
                                                <label class="custom-checkbox"><input type="checkbox" checked> <?= lang('multiple_select'); ?></label>
                                            <?php endif; ?>
                                            <div class="mt-5">
                                                <?php if ($ext->is_required == 1) : ?>
                                                    <span class="error">*</span> (<?= __('required') ?>)
                                                <?php else : ?>
                                                    (<?= __('optional') ?>)
                                                <?php endif; ?>
                                            </div>

                                            <div class="mt-5">
                                                <?php if ($ext->select_limit > 0) : ?>
                                                    <small>
                                                        <?= __('select_minimum') ?> <?= $ext->select_limit == 0 ? 1 : $ext->select_limit; ?> <?= __('options'); ?>

                                                        <?php if ($ext->select_max_limit != 0) : ?>
                                                            & <?= __('max') ?> <?= $ext->select_max_limit != 0 ? "<b>" . $ext->select_max_limit . "</b>"  : ''; ?> <?= __('options'); ?>
                                                        <?php endif; ?>
                                                    </small>

                                                <?php endif; ?>
                                            </div>

                                            <div class="mt-5">
                                                <?php if ($ext->max_qty >= 1) : ?>
                                                    <small>
                                                        <?= __('max_qty') ?> <?= $ext->max_qty == 0 ? 1 : $ext->max_qty; ?> <?= __('items'); ?>
                                                    </small>

                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (!empty($ext->extras)) : ?>
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <th>#</th>
                                                        <th><?= lang('name'); ?></th>
                                                        <th><?= lang('price'); ?></th>
                                                        <th><?= lang('action'); ?></th>
                                                    </tr>
                                                    <?php foreach ($ext->extras as  $key1 => $ex) : ?>
                                                        <tr>
                                                            <td><?= $key1 + 1; ?></td>
                                                            <td><?= $ex->ex_name; ?></td>
                                                            <td><?= currency_position($ex->ex_price, $ex->shop_id); ?></td>
                                                            <td class="btnGroup">
                                                                <?php if (is_access('change-status') == 1) : ?>
                                                                    <a href="javascript:;" data-id="<?= html_escape($ex->id); ?>" data-status="<?= html_escape($ex->status); ?>" data-table="item_extras" class="label <?= $ex->status == 1 ? 'label-success' : 'label-danger' ?> change_status"> <i class="fa <?= $ex->status == 1 ? 'fa-check' : 'fa-close' ?>"></i>&nbsp; <?= $ex->status == 1 ? (!empty(lang('live')) ? lang('live') : "Live") : (!empty(lang('hide')) ? lang('hide') : "Hide"); ?></a>
                                                                <?php endif; ?>
                                                                <a href="#editExtraModal_<?= $ex->id; ?>" data-toggle="modal" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                                <?= __deleteBtn($ex->id, 'item_extras', false); ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </table>
                                            <?php endif; ?>
                                        </td>
                                        <td style="display: flex; align-items: center; flex-direction: column;">
                                            <div class="btnGroup">
                                                <a href="javascript:;" onclick="addExtraModal(`<?= $ext->id; ?>`,`<?= $ext->title; ?>`)" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i> <?= __('add_new'); ?> </a>

                                                <a href="javascript:;" title="<?= !empty(lang('add_extras_from_library')) ? lang('add_extras_from_library') : "Add Extras From Library"; ?>" data-toggle="tooltip" onclick="extraListModal(`<?= $ext->id; ?>`,`<?= $ext->title; ?>`)" class="btn bg-purple-active btn-sm extraListModal"><i class="icofont-library"></i> <?= __('list') ?></a>
                                            </div>
                                            <div class="mt-10 btnGroup">
                                                <a href="#editExtraTitleModal_<?= $ext->id; ?>" data-toggle="modal" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>

                                                <a href="<?= base_url("admin/menu/delete_addons/{$ext->id}") ?>" class="btn btn-danger btn-sm action_btn" data-msg="<?= __('want_to_delete'); ?>"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <a href="javascript:;" data-id="extra_title_list" id="tables"></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div> <!-- create_menu_thumb -->

    <div class="col-md-4 col-lg-5">
        <div class="card singlePage">
            <?php include VIEWPATH . "layouts/inc/item_details_thumb_2.php"; ?> </div>
    </div>
</div>



<div id="addOnModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?= base_url('admin/menu/add_new_extras') ?>" method="post" enctype="multipart/form-data">
            <!-- csrf token -->
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= lang('add_new_extra_title'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="extrasBody">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for=""><?= lang('title'); ?></label>
                                <input type="text" name="title" class="form-control" required placeholder="<?= __('title') ?>">
                            </div>

                            <div class="form-group col-md-12">
                                <label for=""><?= lang('type'); ?></label>
                                <div class="">
                                    <label class="custom-radio"> <input type="radio" name="is_single_select" value="1" checked> <?= lang('single_select'); ?></label>

                                    <label class="custom-radio"> <input type="radio" name="is_single_select" value="0"><?= lang('multiple_select'); ?></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <label for=""><?= lang('required'); ?></label>
                                        <div class="">
                                            <label class="custom-checkbox"> <input type="checkbox" name="is_required" value="1" onchange="showLimit(this)"><?= lang('is_required'); ?></label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for=""><?= lang('max_qty'); ?></label>
                                        <div class="">
                                            <input type="number" name="max_qty" class="form-control" value="0" min="0" placeholder="<?= __('max_qty') ?>">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row dis_none limit_div" id="">
                                <div class="col-md-12">
                                    <div class="form-group col-md-6 ">
                                        <label for=""><?= lang('select_minimum'); ?></label>
                                        <div class="">
                                            <input type="number" name="select_limit" value="1" class="form-control number" min="1">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 ">
                                        <label for=""><?= lang('select_max_limit'); ?></label>
                                        <div class="">
                                            <input type="number" name="select_max_limit" value="1" class="form-control number" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="item_id" value="<?= isset($data['id']) && $data['id'] != 0 ? $data['id'] : 0; ?>">
                    <button type="submit" class="btn btn-secondary"><?= lang('save'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php if (isset($data['id']) && $data['id'] != 0) : ?>

    <!-- Modal -->
    <div id="addExtraModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form action="<?= base_url('admin/menu/add_extras') ?>" method="post" enctype="multipart/form-data">
                <!-- csrf token -->
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title modalTitle"><?= lang('add_new_extras'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="extrasBody">
                            <div class="form-group">
                                <label for=""><?= lang('name'); ?></label>
                                <input type="text" name="ex_name" class="form-control" placeholder="<?= __('addons') ?> <?= __('name') ?>" required>
                            </div>

                            <div class="form-group">
                                <label for=""><?= lang('price'); ?></label>
                                <input step=".01" type="number" name="ex_price" class="form-control price" required placeholder="0.0">
                            </div>
                            <div class="form-group hidden">
                                <label><?= lang('language'); ?></label>
                                <?php languageDropdown($data, true) ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ex_id" value="0">
                        <input type="hidden" name="extra_title_id" value="0">
                        <input type="hidden" name="item_id" value="<?= isset($data['id']) && $data['id'] != 0 ? $data['id'] : 0; ?>">
                        <button type="submit" class="btn btn-secondary"><i class="fa fa-save"></i> <?= lang('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php endif; ?>




<?php foreach ($getAddons as $key => $row) : ?>
    <!----------------------------------------------
  			Edit Extra Hearder / Group
            ---------------------------------------------->
    <div id="editExtraTitleModal_<?= $row->id ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form action="<?= base_url('admin/menu/add_new_extras') ?>" method="post" enctype="multipart/form-data">
                <!-- csrf token -->
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?= lang('edit'); ?> <?= $row->title ?? ''; ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="extrasBody">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for=""><?= lang('title'); ?></label>
                                    <input type="text" name="title" class="form-control" value="<?= !empty($row->title) ? $row->title : ''; ?>" required>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for=""><?= lang('type'); ?></label>
                                    <div class="">
                                        <label class="custom-radio"> <input type="radio" name="is_single_select" value="1" checked <?= isset($row->is_single_select)  && $row->is_single_select == 1 ? "checked"  : ''; ?>><?= lang('single_select'); ?></label>
                                        <label class="custom-radio"> <input type="radio" name="is_single_select" value="0" <?= isset($row->is_single_select)  && $row->is_single_select == 0 ? "checked"  : ''; ?>><?= lang('multiple_select'); ?></label>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-6">
                                            <label for=""><?= lang('required'); ?></label>
                                            <div class="">
                                                <label class="custom-checkbox"> <input type="checkbox" name="is_required" value="1" onchange="showLimit(this)" <?= isset($row->is_required)  && $row->is_required == 1 ? "checked"  : ''; ?>><?= lang('is_required'); ?></label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for=""><?= lang('max_qty'); ?></label>
                                            <div class="">
                                                <input type="number" name="max_qty" class="form-control" value="<?= !empty($row->max_qty) ? $row->max_qty : 1; ?>" min="0" placeholder="<?= __('max_qty') ?>">

                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row  <?= isset($row->is_required)  && $row->is_required == 1 && $row->is_single_select == 0 ? ""  : 'dis_none'; ?> limit_div" id="">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-6 ">
                                            <label for=""><?= lang('select_minimum'); ?></label>
                                            <div class="">
                                                <input type="number" name="select_limit" value="<?= !empty($row->select_limit) ? $row->select_limit : 1; ?>" class="form-control only_number" min="1">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 ">
                                            <label for=""><?= lang('select_max_limit'); ?></label>
                                            <div class="">
                                                <input type="number" name="select_max_limit" value="<?= !empty($row->select_max_limit) ? $row->select_max_limit : 0; ?>" class="form-control number" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="item_id" value="<?= isset($data['id']) && $data['id'] != 0 ? $data['id'] : 0; ?>">
                        <input type="hidden" name="extra_title_id" value="<?= $row->id ?? 0; ?>">
                        <button type="submit" class="btn btn-secondary"><i class="fa fa-save"></i> <?= lang('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!----------------------------------------------
  			Start edit extra title and price
            ---------------------------------------------->
    <?php if (!empty($row->extras)) : ?>
        <?php foreach ($row->extras as  $key => $e) : ?>
            <div id="editExtraModal_<?= $e->id ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <form action="<?= base_url('admin/menu/add_extras') ?>" method="post" enctype="multipart/form-data">
                        <!-- csrf token -->
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title modalTitle"><?= lang('add_new_extras'); ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="extrasBody">
                                    <div class="form-group">
                                        <label for=""><?= lang('name'); ?></label>
                                        <input type="text" name="ex_name" class="form-control" value="<?= $e->ex_name ?? ''; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for=""><?= lang('price'); ?></label>
                                        <input step=".01" type="number" name="ex_price" value="<?= $e->ex_price ?? ''; ?>" class="form-control" required placeholder="0.0">
                                    </div>
                                    <div class="form-group hidden">
                                        <label><?= lang('language'); ?></label>
                                        <?php languageDropdown($data, true) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="ex_id" value="<?= $e->id ?? 0; ?>">
                                <input type="hidden" name="extra_title_id" value="<?= $row->id ?? 0; ?>">
                                <input type="hidden" name="item_id" value="<?= isset($data['id']) && $data['id'] == $row->item_id ? $row->item_id : 0; ?>">
                                <button type="submit" class="btn btn-secondary"><i class="fa fa-save"></i> <?= lang('save'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>





<!----------------------------------------------
  			start	Extra from library
            ---------------------------------------------->
<div id="extraListModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?= base_url('admin/menu/add_library_extras') ?>" method="post" enctype="multipart/form-data">
            <!-- csrf token -->
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title modalTitle"><?= lang('add_new_extras'); ?> <a href="<?= base_url("admin/menu/extras"); ?>" class="btn btn-secondary"><i class="fa fa-plus"></i> <?= lang('add_new'); ?></a></h4>
                </div>
                <div class="modal-body">
                    <div class="extrasBody">
                        <ul class="extra_list_inputs">
                            <?php foreach ($extras_libraries as $key => $ex) : ?>
                                <label class="custom-checkbox"><span><input type="checkbox" name="ex_id[<?= $ex['id']; ?>]" value="<?= $ex['id']; ?>"> <?= $ex['name']; ?></span> <span><?= currency_position($ex['price'], restaurant()->id); ?></span></label>
                                <input type="hidden" name="ex_name[<?= $ex['id']; ?>]" value="<?= $ex['name']; ?>">
                                <input type="hidden" name="ex_price[<?= $ex['id']; ?>]" value="<?= $ex['price']; ?>">
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="item_id" value="<?= !empty($data['id']) ? $data['id'] : 0; ?>">
                    <input type="hidden" name="extra_title_id" value="0">
                    <button type="submit" class="btn btn-secondary"><i class="fa fa-save"></i> <?= lang('save'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!----------------------------------------------
  			End	Extra from library
            ---------------------------------------------->



<script>
    function addExtraModal(id, name) {
        $('#addExtraModal').modal('show');
        $('#addExtraModal [name="extra_title_id"]').val(id);
        $('#addExtraModal .modalTitle').text(name);
    }

    function addExtraModal(id, name) {
        $('#addExtraModal').modal('show');
        $('#addExtraModal [name="extra_title_id"]').val(id);
        $('#addExtraModal .modalTitle').text(name);
    }
</script>
<script>
    function extraListModal(id, name) {
        $('#extraListModal').modal('show');
        $('#extraListModal [name="extra_title_id"]').val(id);
        $('#extraListModal .modalTitle').text(name);
    }

    function showLimit($this) {
        if ($($this).is(':checked')) {
            let is_single_select = $('[name="is_single_select"]:checked').val();
            if (is_single_select == 1) {
                $('.limit_div').slideUp();
            } else {
                $('.limit_div').slideDown();
            }
        } else {
            $('.limit_div').slideUp();
        }
    }


    $('[name="is_single_select"]').on('change', function() {
        if ($(this).val() == 1) {
            $('.limit_div').slideUp();
        } else {
            $('.limit_div').slideDown();
        }
    });
</script>