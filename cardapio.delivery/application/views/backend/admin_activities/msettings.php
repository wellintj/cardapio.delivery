<div class="row">
    <div class="col-md-6">
        <?php $app = isset($settings['attempt_config']) && isJson($settings['attempt_config']) ? json_decode($settings['attempt_config']) : ''; ?>
        <form action="<?= base_url("admin/dashboard/add_msettings"); ?>" method="post">
            <?= csrf(); ?>
            <div class="card">
                <div class="card-header space-between">
                    <h5 class="card-title"><?= lang('settings'); ?></h5>
                </div>
                <div class="card-body">
                    <fieldset>
                        <legend><?= lang('spam/attack'); ?></legend>
                        <div class="form-group">
                            <label class="custom-checkbox"><input type="checkbox" name="is_spam" id="is_spam" value="1" <?= isset($app->is_spam) && $app->is_spam == 1 ? "checked" : ""; ?>><?= __('enable_detect_spam_attack'); ?></label>
                        </div>
                        <div class="form-group">
                            <label><?= lang('allow_attempts'); ?></label>
                            <select name="spam_attempts" class="form-control">
                                <?php for ($i = 2; $i <= 10; $i = $i + 2) : ?>
                                    <option value="<?= $i; ?>" <?= isset($app->spam_attempts) && $app->spam_attempts == $i ? "selected" : ""; ?>><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </fieldset>


                    <fieldset class="mt-20">
                        <legend><?= lang('user_attempts'); ?></legend>
                        <div class="form-group">
                            <label class="custom-checkbox"><input type="checkbox" name="is_user_attempts" id="is_user_attempts" value="1" <?= isset($app->is_user_attempts) && $app->is_user_attempts == 1 ? "checked" : ""; ?>><?= __('enable_detect_user_attempts'); ?></label>
                        </div>
                        <div class="form-group">
                            <label><?= lang('allow_max_attempts_for_checkout'); ?></label>
                            <select name="user_attempts" class="form-control">
                                <?php for ($i = 2; $i <= 20; $i = $i + 2) : ?>
                                    <option value="<?= $i; ?>" <?= isset($app->user_attempts) && $app->user_attempts == $i ? "selected" : ""; ?>><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </fieldset>
                </div>
                <div class="card-footer text-right">
                    <input type="hidden" name="id" value="<?= isset($settings['id']) ? $settings['id'] : 1 ?>">
                    <button class="btn btn-secondary" type="submit"><?= lang('submit'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>