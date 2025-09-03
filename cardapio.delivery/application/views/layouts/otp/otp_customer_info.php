<form action="<?= base_url('customer/add_otp_info'); ?>" method="post" class="add_otp_info">
    <?= csrf(); ?>
    <div class="modal-body">
        <div class="otpinfo">
            <div class="form-group">
                <label><?= __('name'); ?></label>
                <input type="text" name="name" class="form-control" placeholder="<?= __("name"); ?>">
            </div>

            <?php if (isset($cinfo->email) && empty($cinfo->email)): ?>
                <div class="form-group">
                    <label><?= __('email'); ?></label>
                    <input type="text" name="email" class="form-control" placeholder="<?= __("email"); ?>">
                </div>
            <?php endif; ?>

            <?php if (isset($cinfo->phone) && empty($cinfo->phone)): ?>
                <div class="form-group">
                    <?php __phone(['id' => $id??0]); ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label><?= __('password'); ?></label>
                <input type="password" name="password" class="form-control" placeholder="<?= __("password"); ?>">
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <?= __hidden('id', $id ?? 0); ?>
        <?= __hidden('customer_id', isset($cinfo->id) ? $cinfo->id : 0); ?>
        <button type="submit" class="btn btn-primary btn-block"><?= __('submit'); ?></button>
    </div>
</form>