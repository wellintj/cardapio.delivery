<div class="row">
    <?php $app = isset($this->settings['attempt_config']) && isJson($this->settings['attempt_config']) ? json_decode($this->settings['attempt_config']) : ''; ?>
    <?php $max_attempts = isset($app->user_attempts) ? $app->user_attempts : 3; ?>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header space-between">
                <h5 class="card-title"><?= lang('malicious'); ?></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped data_tables">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('ip_address'); ?></th>
                                <th><?= lang('date'); ?></th>
                                <th><?= lang('attempts'); ?></th>
                                <th><?= lang('page'); ?></th>
                                <th><?= lang('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as  $key => $row) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= $row['ip_address']; ?></td>
                                    <td><?= full_time($row['created_at']); ?></td>
                                    <td><label class="label label-danger"><?= $row['total_attempts']; ?></label></td>
                                    <td><label class="label label-default"><?= $row['action']; ?></label></td>
                                    <td>
                                        <a href="<?= base_url('admin/dashboard/mstatus/' . $row['id'] . '/' . $max_attempts . '?a=user'); ?>" class="btn btn-danger btn-sm"><?= lang('block'); ?></a>
                                        <a href="<?= base_url('admin/dashboard/mstatus/' . $row['id'] . '/0?a=user'); ?>" class="btn btn-warning btn-sm"><?= lang('reset'); ?></a>
                                        <a href="<?= base_url('admin/home/item_delete/' . html_escape($row['id']) . '/user_action_attempts'); ?>" class="btn btn-danger action_btn btn-sm" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete')) ? lang('delete') : "Delete"; ?></a>
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