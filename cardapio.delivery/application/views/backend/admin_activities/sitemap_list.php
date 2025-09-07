<div class="row">
    <div class="col-md-8">
        <form action="">
            <div class="card">
                <div class="card-header space-between">
                    <div class="d-flex">
                        <h5 class="card-title mr-5"><?= lang('sitemap'); ?></h5>
                        <a href="<?= base_url('sitemap/index'); ?>" target="_blank" class="btn btn-sm btn-primary "><i class="fa fa-eye"></i></a>
                    </div>
                    <a href="#addnew" data-toggle="modal" class="btn btn-secondary "> <i class="fa fa-plus"></i> <?= __('add_new'); ?></a>
                </div>
                <div class="card-body">
                    <div class='table-responsive'>
                        <table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?= lang('url'); ?></th>
                                    <th><?= lang('changefreq'); ?></th>
                                    <th><?= lang('action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($site_map_list as  $key => $row) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= prep_url($row['url']); ?></td>
                                        <td><?= ($row['changefreq']); ?></td>
                                        <td>
                                            <a href="<?= base_url('sitemap/delete/' . html_escape($row['id']) . '/sitemap_list'); ?>" class=" action_btn btn btn-sm btn-danger" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete')) ? lang('delete') : "Delete"; ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add New Sitemap -->

<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <form action="<?= base_url('sitemap/add_sitemap'); ?>" method="post">
            <?= csrf(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?= lang('sitemap'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><?= lang('url'); ?></label>
                        <input type="text" name="url" class="form-control" placeholder="<?= __('url'); ?>">
                    </div>


                    <div class="form-group">
                        <label for=""><?= lang('changefreq'); ?></label>
                        <select name="changefreq" id="changefreq" class="form-control">
                            <option value="always">always</option>
                            <option value="hourly">hourly</option>
                            <option value="daily">daily</option>
                            <option value="weekly">weekly</option>
                            <option value="monthly">monthly</option>
                            <option value="yearly">yearly</option>
                            <option value="never">never</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary"><?= lang('save_change'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>