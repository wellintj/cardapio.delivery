<div class="row resoponsiveRow">
    <?php include APPPATH . 'views/backend/common/inc/leftsidebar.php'; ?>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-8">
                <form action="<?= base_url('admin/restaurant/available_type'); ?>" method="post">
                    <?= csrf(); ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for=""><?= lang('opening_system'); ?> <?= $restaurant['available_type']?></label>
                                <select name="available_type" class="form-control" onchange="this.form.submit();">
                                    <option value="close" <?= isset($restaurant['available_type']) && $restaurant['available_type'] == "close" ? "selected" : ""; ?>><?= lang('multiple_close'); ?></option>
                                    <option value="open" <?= isset($restaurant['available_type']) && $restaurant['available_type'] == "open" ? "selected" : ""; ?>><?= lang('multiple_open'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?= isset($restaurant['id']) ? $restaurant['id'] : "0"; ?>">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <form class="email_setting_form" action="<?= base_url('admin/restaurant/add_reservation/' . $shop_id) ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">

                    <div class=" availableDays">
                        <?php $days = get_days(); ?>
                        <?php foreach ($days as $key => $day) : ?>
                            <?php $my_days = $this->admin_m->single_appoinment($key); ?>
                            <?php $getTimes = $this->admin_m->get_time_config(@$my_days['id']); ?>
                            <div class="card">
                                <div class="card-header space-between">
                                    <label class="custom-checkbox"> <input type="checkbox" name="days[]" <?= isset($my_days['days']) && html_escape($my_days['days']) == $key ? "checked" : ''; ?> value="<?= $key; ?>"> <?= !empty(__($day))?__($day):$day; ?> </label>
                                    <div class="text-center open24">
                                        <label class="custom-checkbox"><input type="checkbox" name="is_24[<?= $key ?>]" value="1" <?= isset($my_days['is_24']) && html_escape($my_days['is_24']) == 1 ? "checked" : ''; ?> /><?= lang('open_24_hours'); ?></label>
                                    </div>
                                </div>


                                <div class="card-body showDays_<?= $key; ?>">
                                    <div class="inputTimeArea" data-id="<?= $key; ?>">
                                        <div class="inputFormArea">
                                            <div class="form-group">
                                                <label><?= lang('start_time'); ?></label>
                                                <div class="ci-input-group input-group-append" direction="ltr">
                                                    <div class="input-group">
                                                        <button class="btn btn-default">
                                                            <i class="fa fa-clock"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="start_time_<?= $key ?>[]" value="<?= !empty($my_days['start_time']) ? $my_days['start_time'] : '' ?>" class="form-control timepicker">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label><?= lang('end_time'); ?></label>
                                                <div class="ci-input-group input-group-append" direction="ltr">
                                                    <div class="input-group">
                                                        <button class="btn btn-default">
                                                            <i class="fa fa-clock"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="end_time_<?= $key ?>[]" value="<?= !empty($my_days['end_time']) ? $my_days['end_time'] : '' ?>" class="form-control timepicker">
                                                </div>
                                            </div>
                                            <a href="javascript:;" class="remove_time_row btn bg-danger-soft opacity_0"><i class="fa fa-minus-circle"></i></a>
                                        </div>
                                        <div class="form-group addBreaks" style="flex:1;">
                                            <?php if (isset($restaurant['available_type']) && $restaurant['available_type'] == 'close') : ?>
                                                <a href="#" data-id="<?= $key; ?>" class="add_time_row text-purple"><i class="fa fa-plus-circle"></i> <?= lang('add_breaks'); ?></a>
                                            <?php else : ?>
                                                <a href="#" data-id="<?= $key; ?>" class="add_time_row text-purple"><i class="fa fa-plus-circle"></i> <?= lang('add_opening_slots'); ?></a>
                                            <?php endif; ?>
                                        </div>
                                    </div><!-- inputTimeArea -->
                                    <?php if (isset($getTimes) && !empty($getTimes)) : ?>
                                        <?php foreach ($getTimes as  $keys => $times) : ?>
                                            <div class="inputTimeArea" data-id="<?= $key; ?>">
                                                <div class="inputFormArea">
                                                    <div class="form-group">
                                                        <label><?= lang('start_time'); ?></label>
                                                        <div class="ci-input-group input-group-append" direction="ltr">
                                                            <div class="input-group">
                                                                <button class="btn btn-default">
                                                                    <i class="fa fa-clock"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" name="start_time_<?= $key ?>[]" value="<?= !empty($times->start_time) ? $times->start_time : '' ?>" class="form-control timepicker">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?= lang('end_time'); ?></label>
                                                        <div class="ci-input-group input-group-append" direction="ltr">
                                                            <div class="input-group">
                                                                <button class="btn btn-default">
                                                                    <i class="fa fa-clock"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" name="end_time_<?= $key ?>[]" value="<?= !empty($times->end_time) ? $times->end_time : '' ?>" class="form-control timepicker">
                                                        </div>
                                                    </div>
                                                    <a href="javascript:;" class="remove_old_row rowRemove btn bg-danger-soft"><i class="icofont-trash"></i> </a>
                                                </div>

                                            </div><!-- inputTimeArea -->
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </div><!-- card-body -->
                            </div><!-- card -->
                        <?php endforeach; ?>
                    </div>
                    <div class="col-md-12 mt-10">
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-secondary btn-block "><?= lang('submit'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div><!-- col-9 -->

</div>

<script>
    let remove = `<?= lang('remove'); ?>`;
    let are_you_sure = `<?= lang('are_you_sure'); ?>`;
    $(document).on('click', '[name="days[]"]', function(event) {
        let val = $(this).val()
        if ($(this).is(':checked')) {
            $('.showDays_' + val).slideDown();

        } else {
            $('.showDays_' + val).slideUp();
        }
    });

    $(document).on('click', '.remove_old_row', function(event) {
        event.preventDefault();
        if (confirm(are_you_sure)) {
            $(this).closest('.inputTimeArea').remove();
        }
        return false;

    });


    $(document).ready(function() {
        // Handle click event on the "Add Breaks" link
        $('.add_time_row').click(function(e) {
            e.preventDefault();

            // Get the data-id attribute to identify the inputTimeArea
            var dataId = $(this).data('id');

            // Clone the inputTimeArea with the corresponding data-id
            var clonedInputTimeArea = $('.inputTimeArea[data-id="' + dataId + '"]:first').clone();
            clonedInputTimeArea.find('input[type="text"]').val(''); // Clear input values
            clonedInputTimeArea.find('.addBreaks').remove(); // Clear input values
            clonedInputTimeArea.find('.remove_time_row').removeClass('opacity_0'); // Clear input values

            $('.inputTimeArea[data-id="' + dataId + '"]:last').after(clonedInputTimeArea);

            // Attach a click event to the new remove link
            clonedInputTimeArea.find('.remove_time_row').click(function(e) {
                e.preventDefault();
                if (confirm(are_you_sure)) {
                    $(this).closest('.inputTimeArea').remove();
                }
                return false;
            });

            $('.timepicker').timepicker({
                showInputs: false,
                defaultTime: '10:00',
                format: 'hh:mm',
                use24hours: true,
                showMeridian: false,
                minuteStepping: 10,
            });
        });

    });
</script>