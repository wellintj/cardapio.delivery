<div class="row resoponsiveRow">
    <?php include APPPATH . 'views/backend/users/inc/leftsidebar.php'; ?>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= lang('checkout_config'); ?></h4>
                    </div>
                    <div class="card-body">
                        <fieldset>
                            <legend><?= __('shipping_config') ?></legend>
                            <div class="orderTypeConfig flex gap-10">
                                <label class="custom-radio-2"><input type="radio" name="order_type" value="default"> <?= __('default'); ?> </label>
                                <label class="custom-radio-2"><input type="radio" name="order_type" value="area"> <?= __('area_based'); ?> </label>
                                <label class="custom-radio-2"><input type="radio" name="order_type" value="radius"> <?= __('area_based'); ?> </label>
                            </div>
                        </fieldset>

                    </div>
                </div>
            </div><!-- col-9 -->
            <div class="col-md-4 p-0">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= lang('checkout_config'); ?></h4>
                    </div>
                    <div class="card-body">
                        <fieldset>
                            <legend><?= __('shipping_config') ?></legend>
                            <div class="orderTypeConfig flex gap-10">
                                <label class="custom-radio-2"><input type="radio" name="order_type" value="default"> <?= __('default'); ?> </label>
                                <label class="custom-radio-2"><input type="radio" name="order_type" value="area"> <?= __('area_based'); ?> </label>
                                <label class="custom-radio-2"><input type="radio" name="order_type" value="radius"> <?= __('area_based'); ?> </label>
                            </div>
                        </fieldset>

                    </div>
                </div>
            </div><!-- col-3 -->
        </div><!-- row -->
    </div>
</div>