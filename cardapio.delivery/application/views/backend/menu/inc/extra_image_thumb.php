<?php if (!isset($_GET['action'])) : ?>
    <div class="col-md-5 " style="margin-top: 105px;">
        <div class="box box-success">
            <div class="box-header with-border dflex">
                <h3 class="box-title w_100"><?= !empty(lang('images')) ? lang('images') : "images"; ?></h3>
                <a href="#addimgModal" data-toggle="modal" class="addnewBtn btn btn-success btn-flat"><i class="fa fa-plus"></i> &nbsp;<?= lang('add_more_image'); ?></a>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="extraImages">
                    <?php if (!empty($data['extra_images'])) : ?>
                        <?php $i = 1;
                        foreach (json_decode($data['extra_images'], true) as $key => $img) : ?>
                            <div class="singleEximg" id="hide_<?= $key;; ?>">
                                <img src="<?= base_url($img['thumb']); ?>" alt="">
                                <a href="<?= base_url('admin/menu/delete_extra_img/' . $data['id'] . '?img=' . $key); ?>" data-id="<?= $key; ?>" class="delete-img action_btn" data-msg="<?= lang('want_to_delete'); ?>"><i class="fa fa-trash"></i></a>
                            </div>
                        <?php $i++;
                        endforeach ?>
                    <?php endif; ?>
                </div>


            </div><!-- /.box-body -->
        </div>
    </div>
<?php endif; ?>