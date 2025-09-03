<style>
    .email_list ul {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
</style>
<div class="row">
    <div class="col-md-8">
        <form action="<?= base_url('admin/auth/send_mail') ?>" method="post">
            <?= csrf(); ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?= lang('promotion'); ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for=""><?= __('type'); ?></label>
                            <?php $get = $this->input->get('type', true); ?>
                            <select name="type" id="input" class="form-control" onchange="location=this.value;">
                                <option value="<?= base_url('admin/auth/promotion?type=customers') ?>" <?= isset($get) && $get == "customers" ? "selected" : ""; ?>><?= __('customer'); ?></option>

                                <option value="<?= base_url('admin/auth/promotion?type=delivery') ?>" <?= isset($get) && $get == "delivery" ? "selected" : ""; ?>><?= __('delivery_guy'); ?></option>

                                <option value="<?= base_url('admin/auth/promotion?type=checkout') ?>" <?= isset($get) && $get == "checkout" ? "selected" : ""; ?>><?= __('checkout_customers'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for=""><?= lang('email'); ?> <label href="javascript:;" class="pl-5 label success-light pointer custom-checkbox"><input type="checkbox" class="checkAll" data-lang="<?= lang('checked_all'); ?>"> <?= lang('select_all'); ?></label></label>
                            <select name="mails[]" id="checkedItem" class="form-control select2" multiple>
                                <?php foreach ($customer_list as  $key => $customer) : ?>
                                    <option value="<?= $customer->email ?>"><?= $customer->email; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label><?= lang('subject'); ?></label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="<?= lang('subject') ?>">
                        </div>

                        <div class="form-group col-md-12">
                            <label><?= lang('message'); ?></label>
                            <textarea name="message" id="message" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-block " id="send_mail"><?= lang('send'); ?></button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <div class="mailArea">

        </div>
    </div>
</div>
<?php if (!empty($this->session->userdata('email_queue'))) : ?>
    <script type="text/javascript">
        $(document).ready(function() {
            function email_status() {
                var url = `${base_url}/admin/auth/process_email_session`;
                $.get(url, {
                    'csrf_test_name': csrf_value
                }, function(json) {
                    if (json.status === 'success') {
                        $(".mailArea").html(json.load_data);
                        email_status();
                    } else if (json.status === 'completed') {
                        $(".mailArea").html(json.message);

                        setTimeout(() => {
                            window.location.reload();
                        }, 5000);
                    } else {
                        alert(json.message); // Handle error
                    }
                }, 'json');
            }


            email_status();
        });
    </script>
<?php endif; ?>