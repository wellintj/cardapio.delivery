<!-- Modal -->
<div class="modal fade otpModal" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="requestOtp <?= __ctemp('remaining_time', 'otp_data'); ?> <?= empty(__ctemp('remaining_time', 'otp_data')) ? '' : "dis_none"; ?>">
                <form action="<?= base_url('customer/send_otp'); ?>" method="post" class="sendOtp">
                    <?= csrf(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?= __('otp'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php if (isset($s_info->is_customer_login) && $s_info->is_customer_login == 3) : ?>

                            <div class="form-group">
                                <?php __phone(['id' => $s_info->user_id]); ?>
                            </div>
                            <input type="hidden" name="otp_type" value="phone">
                        <?php else: ?>
                            <div class="form-group">
                                <label><?= __('email'); ?></label>
                                <div class="input-group">
                                    <span class="otp_icon"><i class="fa-solid fa-envelope-open-text"></i></span>
                                    <input type="text" name="phone" class="form-control _inputStye" <?= auth('email', 'customer_info') ?? ''; ?>>
                                </div>
                            </div>
                            <input type="hidden" name="otp_type" value="email">
                        <?php endif; ?>

                    </div><!-- modal-body -->
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= $id ?? 0; ?>">
                        <button type="submit" class="btn otpSaveBtn"><?= __('submit'); ?></button>
                    </div>
                </form>
            </div>
            <div class="showOtpContent <?= __ctemp('remaining_time', 'otp_data'); ?>">
                <?php if (!empty(__ctemp('remaining_time', 'otp_data'))) : ?>
                    <?php include VIEWPATH . 'layouts/otp/otp_modal.php'; ?>
                <?php endif; ?>
            </div>
        </div><!-- modal content -->
    </div>
</div>