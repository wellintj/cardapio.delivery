<div class="row resoponsiveRow">
    <?php include APPPATH . 'views/backend/users/inc/leftsidebar.php'; ?>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header space-between">
                <h4><?= lang('slider'); ?></h4>
                <a href="#addNew" data-toggle="modal" class="btn btn-secondary btn-sm "><i class="fa fa-plus"></i> <?= __('add_new'); ?></a>
            </div>
            <div class="card-body">
                <div class='table-responsive'>
                    <table class='table table-striped table-bordered  data_tables'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('image'); ?></th>
                                <th><?= lang('title'); ?></th>
                                <th><?= lang('status'); ?></th>
                                <th><?= lang('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vendor_slider_list as  $key => $row) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td>
                                        <div class="serviceImgs">
                                            <img src="<?= base_url($row->thumb); ?>" alt="" class="img">
                                        </div>
                                    </td>
                                    <td><?= $row->title; ?></td>
                                    <td>
                                        <?php if (is_access('change-status') == 1) : ?>
                                            <a href="javascript:;" data-id="<?= html_escape($row->id); ?>" data-status="<?= html_escape($row->status); ?>" data-table="vendor_slider_list" class="label <?= $row->status == 1 ? 'label-success' : 'label-danger' ?> change_status"> <i class="fa <?= $row->status == 1 ? 'fa-check' : 'fa-close' ?>"></i>&nbsp; <?= $row->status == 1 ? (!empty(lang('live')) ? lang('live') : "Live") : (!empty(lang('inactive')) ? lang('inactive') : "inactive"); ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="btnGroup">
                                        <a href="#editModal_<?= $row->id; ?>" data-toggle="modal" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                        <?= __deleteBtn($row->id, 'vendor_slider_list', false); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>

            </div><!-- card-body -->
        </div><!-- card -->
        </form>
    </div><!-- col-9 -->

</div>


<!-- Modal -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url("admin/auth/add_slider") ?>" method="post" enctype="multipart/form-data" autocomplete="off" class="validForm">
                <?= csrf(); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalLabel"><?= lang('add_new'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><?= lang('title'); ?> <span class="error">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <label class="defaultImg square">
                            <img src="" alt="" class="imgPreview opacity_0">

                            <div class="imgPreviewDiv">
                                <i class="fa fa-upload"></i>
                                <h4><?= lang('upload_image'); ?> <span class="error">*</span></h4>
                                <p class="fw_normal mt-3"><?= lang('max'); ?>: 1200 x 500 px</p>
                            </div>

                            <input type="file" name="file[]" class="imgFile opacity_0" data-width="0" data-height="0" required>
                        </label>
                        <span class="img_error"></span>
                    </div>


                    <div class="form-group hidden">
                        <label for=""><?= lang('details'); ?></label>
                        <textarea name="details" id="details" class="form-control" cols="5" rows="5"></textarea>
                    </div>

                    <div class="form-group">
                        <label><?= __('extranal_url'); ?></label>
                        <input type="text" name="external_url" class="form-control" placeholder="https://" value="">
                    </div>

                    <div class="form-group mt-10">
                        <label for=""><?= lang('status'); ?> <span class="error">*</span></label>
                        <div class="mt-5">
                            <label class="custom-radio"><input type="radio" name="status" value="1" checked><?= lang('active'); ?></label>
                            <label class="custom-radio"><input type="radio" name="status" value="0"> <?= lang('inactive'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" value="0">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?= lang('save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($vendor_slider_list as  $key => $row) : ?>
    <div class="modal fade" id="editModal_<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url("admin/auth/add_slider") ?>" method="post" enctype="multipart/form-data" autocomplete="off" class="validForm">
                    <?= csrf(); ?>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="modalLabel"><?= lang('edit'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for=""><?= lang('title'); ?> <span class="error">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="Title" value="<?= $row->title ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="defaultImg square">
                                <?php if (isset($row->id) && !empty($row->id)) : ?>
                                    <a href="<?= base_url('admin/restaurant/delete_img/' . $row->id . '/vendor_slider_list'); ?>" class="deleteImg <?= isset($row->thumb) && !empty($row->thumb) ? "" : "opacity_0" ?>" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>"><i class="fa fa-close"></i></a>
                                <?php endif; ?>

                                <img src="<?= isset($row->thumb) && !empty($row->thumb) ? base_url($row->thumb) : "" ?>" alt="" class="imgPreview <?= isset($row->thumb) && !empty($row->thumb) ? "" : "opacity_0" ?>">

                                <div class="imgPreviewDiv <?= isset($row->thumb) && !empty($row->thumb) ? "opacity_0" : "" ?>">
                                    <i class="fa fa-upload"></i>
                                    <h4><?= lang('upload_image'); ?> <span class="error">*</span></h4>
                                    <p class="fw_normal mt-3"><?= lang('max'); ?>: 1200 x 500 px</p>
                                </div>

                                <input type="file" name="file[]" class="imgFile opacity_0" data-width="0" data-height="0" required>
                            </label>
                            <span class="img_error"></span>
                        </div>

                        <div class="form-group">
                            <label><?= __('extranal_url'); ?></label>
                            <input type="text" name="external_url" class="form-control" placeholder="https://" value="<?= $row->external_url ?? ''; ?>">
                        </div>


                        <div class="form-group hidden">
                            <label for=""><?= lang('details'); ?></label>
                            <textarea name="details" id="details" class="form-control" cols="5" rows="5"><?= $row->details ?? ''; ?></textarea>
                        </div>

                        <div class="form-group mt-10">
                            <label for=""><?= lang('status'); ?> <span class="error">*</span></label>
                            <div class="mt-5">
                                <label class="custom-radio"><input type="radio" name="status" value="1" <?= $row->status == 1 ? 'checked' : ''; ?> checked><?= lang('active'); ?></label>
                                <label class="custom-radio"><input type="radio" name="status" value="0" <?= $row->status == 0 ? 'checked' : ''; ?>> <?= lang('inactive'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= $row->id ?? 0 ?>">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?= lang('save'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach; ?>