<style>
    p {
        margin: 0;
        padding: 0;
    }
</style>
<?php if (empty(restaurant()->referal_code)): ?>
    <?php $rand = strtoupper(random_string('alpha', 6)); ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form action="<?= base_url("admin/affiliate/add_code"); ?>" method="post">
                <?= csrf(); ?>
                <div class="card">
                    <div class="card-body pb-10">
                        <div class="referealCodeArea">
                            <div class="referalCodeTop">
                                <div class="ci-input-group">
                                    <input type="text" name="referal_code" class="form-control showCode"
                                        value="<?= $rand; ?>">
                                    <div class="input-group">
                                        <button type="button" class="btn btn-success" onclick="makeid(6)"><i
                                                class="fa fa-refresh"></i> <?= lang("new_code"); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-s mt-20">
                            <button type="submit" class="btn btn-secondary btn-block"><?= lang('submit'); ?></button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        function makeid(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() *
                    charactersLength));
            }

            $('.showCode').val(result.toUpperCase());
            return result;
        }
    </script>

<?php else: ?>
    <div class="row border-card">
        <div class="col-md-4">
            <div class="ci-info-box border-default">
                <div class="ci-info-box-body">
                    <h4 class="text-default"><?= $all->total_referal; ?></h4>
                    <p><?= lang('total_referal'); ?></p>
                </div>
            </div>
        </div>



        <div class="col-md-4">
            <div class="ci-info-box border-purple">
                <div class="ci-info-box-body">
                    <h4 class="text-purple"><?= admin_currency_position($all->balance); ?></h4>
                    <p><?= lang('blance'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ci-info-box border-success">
                <div class="ci-info-box-body">
                    <h4 class="text-success"><?= admin_currency_position('000'); ?></h4>
                    <p><?= lang('total_withdraw'); ?></p>
                </div>
            </div>
        </div>


    </div>

    <div class="row mt-20">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>
                            <h4><?= lang('referal_url'); ?></h4>
                        </label>
                        <div class="ci-input-group">
                            <input type="text" name="referral_link" class="form-control copyContent"
                                value="<?= add_ref_parameter(base_url(), restaurant()->referal_code); ?>">
                            <div class="input-group">
                                <button class="btn btn-secondary px-20 copyText"><i class="fa fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row mt-20">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body mt-5">
                    <div class="mt-5">
                        <h3 class="font-weight-bold mb-1 text-center"><?= lang('how_it_works'); ?></h3>
                        <div class="row mt-30">
                            <div class="col-md-4 text-center">
                                <div class="info-icon">
                                    <i class="fa fa-paper-plane ref-icon bg-success-soft"></i>
                                </div>
                                <h5 class="font-weight-bold mt-15"><?= lang('send_invitation'); ?></h5>
                                <p class=" mt-1 pl-0 text-muted"><?= lang('invitation_details'); ?></p>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="info-icon ">
                                    <i class="fa fa-user-plus ref-icon bg-primary-soft"></i>
                                </div>
                                <h5 class="font-weight-bold mt-15"><?= lang('registration'); ?></h5>
                                <p class=" mt-1 pl-0 text-muted"><?= lang('affiliate_registration_details'); ?></p>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="info-icon">
                                    <i class="fa fa-percent ref-icon bg-default-soft"></i>
                                </div>
                                <h5 class="font-weight-bold mt-15">
                                    <?= lang('get_commisions'); ?> </h5>
                                <p class="mt-1 pl-0 text-muted"><?= lang('get_commision_details'); ?>
                                </p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="row mt-20">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><?= lang('referral_guidelines'); ?></h4>
                </div>
                <div class="card-body">
                    <?= __config('referal_guidelines'); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>