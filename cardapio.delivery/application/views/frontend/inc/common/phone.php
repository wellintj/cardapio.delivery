<?php
$dial_code = $id ? (!empty(auth('dial_code', 'customer_info')) ? auth('dial_code', 'customer_info') : ltrim(restaurant($id)->dial_code, '+')) : $this->settings['dial_code'];

$cphone = isset($phone) ? $phone : auth('phone', 'customer_info');
?>

<label>
    <i class="fa fa-phone"></i>
    <?= __('phone'); ?> <span class="error">*</span>
</label>
<div class="customPhone OTP_phone">
    <div class="ci-input-group">
        <div class="ci-input-group-prepend w-30 text-center">
            <span class="input-group-text" style="padding: 0.6rem 0;">+</span>
        </div>
        <div class="ci-input-group-prepend w-50">
            <input type="text" name="dial_code" class="form-control border-radius-0 group-color only_number" value="<?= $dial_code ?? ""; ?>">
        </div>
        <input type="text" name="phone" class="form-control only_number" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9]/g,'')" value="<?= $cphone ?? ''; ?>" placeholder="XX 9 XXXX XXXX">
    </div>
</div>