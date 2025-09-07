<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header space-between">
                <h5 class="card-title"><?= lang('offers'); ?></h5>
                <a href="#addnew" data-toggle="modal" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i> <?= __('add_new'); ?></a>
            </div>
            <div class="card-body">
                <div class='table-responsive'>
                    <table class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= __('name'); ?></th>
                                <th><?= __('discount'); ?></th>
                                <th><?= __('start_date'); ?></th>
                                <th><?= __('end_date'); ?></th>
                                <th><?= __('items'); ?></th>
                                <th><?= __('status'); ?></th>
                                <th><?= __('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($offer_list as  $key => $row) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td>
                                        <h4><?= $row['name']; ?></h4>
                                        <div class="mt-10 bannerImg">
                                            <img src="<?= avatar($row['thumb'], 'logo'); ?>" alt="">
                                        </div>
                                    </td>
                                    <td><label class="label label-default"><?= $row['discount']; ?> %</label></td>
                                    <td><?= date('d/m/Y', strtotime($row['start_date'])); ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['end_date'])); ?></td>

                                    <td>
                                        <table class="table">
                                            <?php foreach ($row['items'] as  $key => $item) : ?>
                                                <tr>
                                                    <td><?= $item['title']; ?></td>
                                                    <td><a href="<?= base_url('admin/coupon/remove_item/' . $item['id'] . '/' . $row['id']) ?>" class="text-danger action_btn" data-msg="<?= __('want_to_delete'); ?>"><i class="fa fa-trash-o"></i></a></td>
                                                </tr>
                                            <?php endforeach; ?>

                                        </table>
                                    </td>
                                    <td>
                                        <a href="javascript:;" data-id="<?= html_escape($row['id']); ?>" data-status="<?= html_escape($row['status']); ?>" data-table="offer_list" class="label <?= $row['status'] == 1 ? 'label-success' : 'label-danger' ?> change_status"> <i class="fa <?= $row['status'] == 1 ? 'fa-check' : 'fa-close' ?>"></i>&nbsp; <?= $row['status'] == 1 ? (!empty(lang('live')) ? lang('live') : "Live") : (!empty(lang('hide')) ? lang('hide') : "Hide"); ?></a>
                                    </td>
                                    <td>
                                        <a href="#edit_<?= $row['id']; ?>" data-toggle="modal" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="<?= base_url('admin/dashboard/item_delete/' . html_escape($row['id']) . '/offer_list'); ?>" class="btn btn-danger btn-sm action_btn" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : 'Want to delete?'; ?>"><i class="fa fa-trash"></i> </a>
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


<?php foreach ($offer_list as  $key => $row) : ?>
    <div id="edit_<?= $row['id']; ?>" class="modal fade customModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="<?= base_url("admin/coupon/add_offers") ?>" method="post" enctype="multipart/form-data" class="validForm">
                <?= csrf(); ?>
                <div class="modal-content">
                    <div class="modal-header space-between">
                        <h4 class="modal-title"><?= lang('offers'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name"><?= __('name') ?> <span class="error">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="<?= __('name') ?>" required value="<?= !empty($row['name']) ? $row['name'] : ''; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name"><?= __('slug') ?> <span class="alert_text">* <?= lang('must_unique_english'); ?></span></label>
                                <input type="text" name="slug" class="form-control" placeholder="<?= __('slug') ?>" required value="<?= !empty($row['slug']) ? $row['slug'] : ''; ?>">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name"><?= __('start_date') ?> <span class="error">*</span></label>
                                <input type="text" name="start_date" class="form-control datepicker" placeholder="dd/mm/yyyy" required value="<?= !empty($row['start_date']) ? date('d/m/Y', strtotime($row['start_date'])) : ''; ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="name"><?= __('end_date') ?> <span class="error">*</span></label>
                                <input type="text" name="end_date" class="form-control datepicker" placeholder="dd/mm/yyyy" required value="<?= !empty($row['end_date']) ? date('d/m/Y', strtotime($row['end_date'])) : ''; ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for=""><?= lang('items'); ?></label>
                                <select name="item_ids[]" class="form-control select2" multiple required>
                                    <option value=""><?= lang('select'); ?></option>
                                    <?php foreach ($item_list as  $key => $item) : ?>
                                        <option value="<?= $item['id'] ?>" <?= in_array($item['id'], json_decode($row['item_ids'])) ? "selected" : "" ?>><?= $item['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name"><?= __('discount') ?> <span class="error">*</span></label>
                                <input type="text" name="discount" class="form-control only_number" placeholder="<?= __('discount') ?>" required value="<?= !empty($row['discount']) ? $row['discount'] : ''; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name"><?= __('image') ?>(548px, 140px) <span class="error">*</span></label>
                                <input type="file" name="file[]" class="form-control">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="name"><?= __('status') ?></label>
                                <div class="">
                                    <label class="custom-radio"><input type="radio" name="status" value="1" <?= $row['status'] == 1 ? "checked" : ""; ?> checked><?= lang('active'); ?></label>
                                    <label class="custom-radio"><input type="radio" name="status" value="0" <?= $row['status'] == 0 ? "checked" : ""; ?>><?= lang('inactive'); ?></label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= $row['id'] ?? 0 ?>">
                        <button class="btn btn-secondary" type="submit"><?= lang('submit'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<div id="addnew" class="modal fade customModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url("admin/coupon/add_offers") ?>" method="post" enctype="multipart/form-data" class="validForm">
            <?= csrf(); ?>
            <div class="modal-content">
                <div class="modal-header space-between">
                    <h4 class="modal-title"><?= lang('offers'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name"><?= __('name') ?> <span class="error">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="<?= __('name') ?>" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name"><?= __('slug') ?> <span class="alert_text">* <?= lang('must_unique_english'); ?></span></label>
                            <input type="text" name="slug" class="form-control" placeholder="<?= __('slug') ?>" required>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name"><?= __('start_date') ?> <span class="error">*</span></label>
                            <input type="text" name="start_date" class="form-control datepicker" placeholder="dd/mm/yyyy" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name"><?= __('end_date') ?> <span class="error">*</span></label>
                            <input type="text" name="end_date" class="form-control datepicker" placeholder="dd/mm/yyyy" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for=""><?= lang('items'); ?></label>
                            <select name="item_ids[]" class="form-control select2" multiple required>
                                <option value=""><?= lang('select'); ?></option>
                                <?php foreach ($item_list as  $key => $item) : ?>
                                    <option value="<?= $item['id'] ?>"><?= $item['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name"><?= __('discount') ?> (%) <span class="error">*</span></label>
                            <input type="text" name="discount" class="form-control only_number" placeholder="<?= __('discount') ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name"><?= __('image') ?>(548px, 140px) <span class="error">*</span></label>
                            <input type="file" name="file[]" class="form-control" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="name"><?= __('status') ?></label>
                            <div class="">
                                <label class="custom-radio"><input type="radio" name="status" value="1" checked><?= lang('active'); ?></label>
                                <label class="custom-radio"><input type="radio" name="status" value="0"><?= lang('inactive'); ?></label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" value="0">
                    <button class="btn btn-secondary" type="submit"><?= lang('submit'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>