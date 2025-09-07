<?php $app = isJson($u_settings['vendor_affiliate_settings'])?json_decode($u_settings['vendor_affiliate_settings']):''; ?>
<div class="row mt-20">
    <div class="col-md-6">
        <form action="<?= base_url("admin/affiliate/add_vendor_affiliate_settings")?>" method="post">
            <?= csrf(); ;?>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>
                            <h4><?= lang('settings');?></h4>
                        </label>

                        <div class="form-group">
                            <label><?= lang('payment_method');?></label>
                            <select name="payment_method" class="form-control">
                                <option value="<?= strtolower(__config('payment_method')) ;?>">
                                    <?= lang(__config('payment_method')) ;?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?= lang('payment_email');?></label>
                            <input type="text" name="payment_email" class="form-control"
                                value="<?= isset($app->payment_email) && !empty($app->payment_email)?$app->payment_email:'' ;?>">
                        </div>
                        <div class="form-group">
                            <label><?= lang('payment_details');?></label>
                            <div class="mt-5">
                                <textarea name="payment_details" class="form-control textarea" cols="5"
                                    rows="5"> <?= isset($app->payment_details) && !empty($app->payment_details)?$app->payment_details:'' ;?></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" name="submit" class="btn btn-secondary "><?= lang('submit');?></button>
                </div>
            </div>
        </form>
    </div>
</div>