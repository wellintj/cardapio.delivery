<div class="row">
    <div class="col-md-7">
        <form action="<?= base_url("admin/affiliate/add_affiliate_config"); ?>" method="post">
            <?= csrf(); ?>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="custom-checkbox text-success"> <input type="checkbox" name="is_affiliate"
                                value="1" <?= __config('is_affiliate') == "1" ? "checked" : ""; ?>> <?= lang('enable_affiliate');?></label>
                    </div>

                    <div class="form-group">
                        <label> <?= lang('commission_rate');?> </label>
                        <div class="ci-input-group">
                            <input type="number" name="commision_rate" class="form-control" autocomplete="off"
                                placeholder="Commision Rate" value="<?= __config('commision_rate'); ?>">
                            <div class="input-addon">
                                <select name="commision_type" id="commision_type" class="form-control">
                                    <option value="flat" <?= __config('commision_type') == "flat" ? "selected" : ""; ?>>
                                        <?= lang('flat');?></option>
                                    <option value="percent"
                                        <?= __config('commision_type') == "percent" ? "selected" : ""; ?>>%</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label><?= lang('subscriber_commission_rate');?> </label>
                        <div class="ci-input-group">
                            <input type="number" name="subscriber_commision_rate" class="form-control"
                                autocomplete="off" placeholder="Commision Rate"
                                value="<?= __config('subscriber_commision_rate'); ?>">
                            <div class="input-addon">
                                <select name="subscriber_commision_type" id="subscriber_commision_type"
                                    class="form-control">
                                    <option value="flat"
                                        <?= __config('subscriber_commision_type') == "flat" ? "selected" : ""; ?>>
                                        <?= lang('flat');?></option>
                                    <option value="percent"
                                        <?= __config('subscriber_commision_type') == "percent" ? "selected" : ""; ?>>%
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?= lang('minimum_payout');?> </label>
                        <input type="number" name="minimum_payout" class="form-control" placeholder="Minimum Payout"
                            value="<?= __config('minimum_payout'); ?>">
                    </div>

                    <div class="form-group">
                        <label> <?= lang('payment_method');?> </label>
                        <select name="payment_method" id="" class="form-control">
                            <option value="paypal" <?= __config('payment_method') == "paypal" ? "selected" : ""; ?>>
                                Paypal</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label> <?= lang('referral_guidelines');?> </label>
                        <textarea name="referal_guidelines" id="details" class="form-control data_textarea" cols="5"
                            rows="5"><?= __config('referal_guidelines'); ?></textarea>
                    </div>
                </div> <!-- card-body -->
                <div class="card-footer text-right">
                    <button class="btn btn-secondary" type="submit"><?= lang('submit'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>