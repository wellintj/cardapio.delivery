<div class="generateOtp pt-20">
    <form action="<?= base_url('customer/verify_otp'); ?>" method="post" class="vefiryOtp">
        <?= csrf(); ?>
        <div class="modal-body p-0">
            <div class="otpModal">
                <div class="otpFields">
                    <input type="text" name="otp[]" class="form-control otp-input" maxlength="1">
                    <input type="text" name="otp[]" class="form-control otp-input" maxlength="1">
                    <input type="text" name="otp[]" class="form-control otp-input" maxlength="1">
                    <input type="text" name="otp[]" class="form-control otp-input" maxlength="1">
                </div>
                <div class="remainingTime">
                    <span id="remaining-time" data-created='<?= __ctemp('created_time', 'otp_data'); ?>' data-expire_time="<?= __ctemp('otp_expire_time', 'otp_data'); ?>"></span>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <input type="hidden" name="id" value="<?= $id ?? 0; ?>">
            <button type="submit" class="btn btn-primary btn-block"><?= __('verify_otp'); ?></button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        // Start timer when page loads
        updateRemainingTime();

        // Handle OTP input
        $(document).on('input', '.otp-input', function() {
            // Keep only first character
            if (this.value.length > 1) {
                this.value = this.value[0];
            }

            // Move to next input
            if (this.value.length === 1) {
                $(this).next('.otp-input').focus();
            }
        });

        // Handle backspace
        $(document).on('keydown', '.otp-input', function(e) {
            if (e.key === "Backspace" && this.value.length === 0) {
                $(this).prev('.otp-input').focus();
            }
        });

        // Handle paste
        $(document).on('paste', '.otp-input', function(e) {
            e.preventDefault();
            var pasteData = e.originalEvent.clipboardData.getData('text');
            var $inputs = $('.otp-input');

            // Clear existing values
            $inputs.val('');

            // Distribute pasted characters
            for (var i = 0; i < Math.min(pasteData.length, $inputs.length); i++) {
                if (/^\d$/.test(pasteData[i])) { // Only allow numbers
                    $inputs.eq(i).val(pasteData[i]);
                }
            }

            // Focus last input
            $inputs.last().focus();
        });

        // Allow only numbers
        $(document).on('keypress', '.otp-input', function(e) {
            return e.which >= 48 && e.which <= 57;
        });

        // Handle resend OTP
        $(document).on('click', '.resend-otp', function() {
            $('.generateOtp').slideUp();
            $('.requestOtp').slideDown();
        });
    });

    // Timer function
    function updateRemainingTime() {
        var remainingTimeElement = document.getElementById('remaining-time');
        var createdTime = parseInt(remainingTimeElement.getAttribute('data-created')) * 1000;
        var expireTime = parseInt(remainingTimeElement.getAttribute('data-expire_time')) * 1000;

        function update() {
            var now = new Date().getTime();
            var remainingTime = expireTime - now;

            if (remainingTime > 0) {
                var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                remainingTimeElement.textContent = 'Time remaining: ' +
                    (minutes < 10 ? '0' + minutes : minutes) + ':' +
                    (seconds < 10 ? '0' + seconds : seconds);
            } else {
                remainingTimeElement.innerHTML = '<a href="javascript:;" class="resend-otp"><i class="icofont-ui-reply"></i>Resend</a>';
                clearInterval(timerInterval);
            }
        }

        var timerInterval = setInterval(update, 1000);
        update();
    }
</script>