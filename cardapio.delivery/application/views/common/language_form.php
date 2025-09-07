<?php $language = isset($data['language']) && $data['language'] ? $data['language'] : site_lang(); ?>
<div class="form-group <?= isset($col) ? $col : 'col-md-12' ?> <?= isset($_GET['action']) && $_GET['action'] == 'clone' ? "" : "hidden" ?>">
    <label for="title"><?= lang('languages'); ?> <span class="error">*</span></label>
    <select name="language" class="form-control <?= isset($is_lang) && $is_lang == 0 ? "pointerEvent" : ""; ?>" required>
        <?php if (isset($_GET['action']) && $_GET['action'] == 'clone'): ?>
            <?php foreach (shop_languages(auth('id')) as $key => $language) : ?>
                <?php if ($language->slug  != site_lang()): ?>
                    <option value="<?= $language->slug; ?>" <?= isset($language) && $language == $language->slug ? "selected" : ""; ?>> <?= $language->lang_name; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <input type="hidden" name="language" value="<?= $language ?? 'english'; ?>">
        <?php endif; ?>

    </select>

    <input type="hidden" name="is_clone" value="<?= isset($_GET['action']) && $_GET['action'] == 'clone' ? 1 : 0; ?>">
</div>