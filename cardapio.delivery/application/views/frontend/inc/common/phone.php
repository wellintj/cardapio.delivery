<?php
// Automatically set dial_code to 55 (Brazil) - hidden from user
$dial_code = "55";
$cphone = isset($phone) ? $phone : auth('phone', 'customer_info');
?>

<label>
    <i class="fa fa-phone"></i>
    <?= __('phone'); ?> <span class="error">*</span>
</label>
<div class="customPhone OTP_phone">
    <div class="ci-input-group">
        <div class="ci-input-group-prepend w-30 text-center">
            <span class="input-group-text" style="padding: 0.6rem 0;">+55</span>
        </div>
        <!-- Hidden dial_code field - automatically set to 55 (Brazil) -->
        <input type="hidden" name="dial_code" value="55">
        <input type="text" name="phone" class="form-control only_number" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9]/g,'')" value="<?= $cphone ?? ''; ?>" placeholder="00 0 0000 0000" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
    </div>
</div>