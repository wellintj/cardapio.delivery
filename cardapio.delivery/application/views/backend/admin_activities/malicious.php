<div class="row">
    <?php $app = isset($this->settings['attempt_config']) && isJson($this->settings['attempt_config']) ? json_decode($this->settings['attempt_config']) : ''; ?>
    <?php $max_attempts = isset($app->spam_attempts) ? $app->spam_attempts : 3; ?>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header space-between">
                <h5 class="card-title"><?= lang('malicious'); ?></h5>
                <a href="#blockModal" data-toggle="modal" class="btn btn-secondary"><i class="fa fa-plus"></i> <?= __('add'); ?></a>
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
                                <th><?= lang('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as  $key => $row) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= $row['ip_address']; ?></td>
                                    <td><?= full_time($row['created_at']); ?></td>
                                    <td><?= $row['total_attempts']; ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/dashboard/mstatus/' . $row['id'] . '/' . $max_attempts); ?>" class="btn btn-danger btn-sm"><?= lang('block'); ?></a>
                                        <a href="<?= base_url('admin/dashboard/mstatus/' . $row['id'] . '/0'); ?>" class="btn btn-warning btn-sm"><?= lang('reset'); ?></a>
                                        <a href="<?= base_url('admin/home/item_delete/' . html_escape($row['id']) . '/security_attempts'); ?>" class="btn btn-danger action_btn btn-sm" data-msg="<?= !empty(lang('want_to_delete')) ? lang('want_to_delete') : "want to delete"; ?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete')) ? lang('delete') : "Delete"; ?></a>
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

<div id="blockModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url("admin/dashboard/add_ip") ?>" method="post">
                <?= csrf(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><?= __('ip_address'); ?></label>
                        <input type="text" name="ip_address" class="form-control" placeholder="<?= __("ip_address") ?>">
                    </div>
                </div>
                <div class="modal-footer space-between">
                    <button class="btn btn-default" type="button" data-dismiss="modal"><?= lang('cancel'); ?></button>
                    <button class="btn btn-secondary" type="submit"><?= lang('submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        if ('NDEFReader' in window) {
            const reader = new NDEFReader();
            console.log("started");
            reader.scan().then(() => {
                console.log("Scan started successfully");
                reader.onreading = event => {
                    const message = event.message;
                    const record = message.records[0];
                    const nfcData = new TextDecoder().decode(record.data);

                    // Send NFC data to the server
                    // $.ajax({
                    //     url: '<?php echo site_url("nfc/process_nfc_data"); ?>',
                    //     method: 'POST',
                    //     data: {
                    //         nfc_data: nfcData
                    //     },
                    //     dataType: 'json',
                    //     success: function(response) {
                    //         $('#nfcResult').text('NFC Data: ' + nfcData + ' - ' + response.message);
                    //     },
                    //     error: function() {
                    //         $('#nfcResult').text('Error processing NFC data');
                    //     }
                    // });
                }
            }).catch(error => {
                console.log(`Error: ${error}`);
            });
        } else {
            $('#nfcResult').text('NFC is not supported on this device');
        }
    });
</script>