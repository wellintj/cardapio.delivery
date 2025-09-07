<?php if (!isset($hide)) : ?>
    <?php if (isset($is_filter) && $is_filter == TRUE) : ?>
        <?php include APPPATH . 'views/backend/reports/incomeBadge.php'; ?>
        <div class="filterarea">
            <div class="filterContent">
                <div class="filtercontentBody liveOrder">
                    <div class="filterIcon">
                        <a href="javascript:;" class="btn btn-secondary"> <i class="fa fa-filter"></i></a>
                    </div>

                    <form action="" method="get" class="filterForm orderFilterForm">
                        <div class="filterBody">
                            <div class="form-group">
                                <label for=""><?= lang('order_id'); ?></label>
                                <input type="text" name="uid" class="form-control" value="<?= isset($_GET['uid']) ? $_GET['uid'] : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for=""><?= lang('customer_name'); ?></label>
                                <input type="text" name="name" class="form-control" value="<?= isset($_GET['name']) ? $_GET['name'] : ''; ?>" placeholder="<?= lang('customer_name'); ?> / <?= lang('phone'); ?>">
                            </div>
                            <div class="form-group">
                                <label for=""><?= lang('order_type'); ?></label>
                                <select name="order_type" id="" class="form-control">
                                    <?php $order_type = $this->admin_m->select('order_types'); ?>
                                    <option value=""><?= lang('select'); ?></option>
                                    <?php foreach ($order_type as $key => $type) : ?>
                                        <?php if ($type['slug'] != 'reservation') : ?>
                                            <option value="<?= $type['id']; ?>" <?= isset($_GET['order_type']) && $_GET['order_type'] == $type['id'] ? "selected" : ''; ?>>
                                                <?= $type['name']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach ?>
                                    <option value="pos" <?= isset($_GET['order_type']) && $_GET['order_type'] == 'pos' ? "selected" : ''; ?>><?= lang('pos'); ?></option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><?= lang('status'); ?></label>
                                <select name="status" id="status" class="form-control">
                                    <option value='all' <?= isset($_GET['status']) && $_GET['status'] == "all" ? "selected" : ''; ?>>
                                        <?= lang('select'); ?></option>
                                    <option value="pending" <?= isset($_GET['status']) && $_GET['status'] == "pending" ? "selected" : ''; ?>>
                                        <?= lang('pending'); ?></option>
                                    <option value="accepted" <?= isset($_GET['status']) && $_GET['status'] == "accepted" ? "selected" : ''; ?>>
                                        <?= lang('accepted'); ?></option>
                                    <option value="completed" <?= isset($_GET['status']) && $_GET['status'] == "completed" ? "selected" : ''; ?>>
                                        <?= lang('completed'); ?></option>
                                    <option value="rejected" <?= isset($_GET['status']) && $_GET['status'] == 'rejected' ? "selected" : ''; ?>>
                                        <?= lang('rejected'); ?></option>
                                    <option value="paid" <?= isset($_GET['status']) && $_GET['status'] == 'paid' ? "selected" : ''; ?>>
                                        <?= lang('paid'); ?></option>
                                    <option value="unpaid" <?= isset($_GET['status']) && $_GET['status'] == 'unpaid' ? "selected" : ''; ?>>
                                        <?= lang('unpaid'); ?></option>
                                </select>
                            </div>

                            <?php $table_list = $this->common_m->get_table_list(restaurant()->id); ?>
                            <div class="form-group">
                                <label><?= lang('table_no'); ?></label>
                                <select name="table_no" id="table_no" class="form-control">
                                    <option value='' <?= isset($_GET['table_no']) && $_GET['table_no'] == '' ? "selected" : ''; ?>>
                                        <?= lang('select'); ?></option>
                                    <?php foreach ($table_list as $table_no) : ?>
                                        <option value="<?= $table_no['id']; ?>" <?= isset($_GET['table_no']) && $_GET['table_no'] == $table_no['id'] ? "selected" : ''; ?>>
                                            <?= $table_no['name']; ?> / <?= $table_no['area_name']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><?= lang('payment_type'); ?></label>
                                <select name="payment_by" id="payment_by" class="form-control">
                                    <option value='' <?= isset($_GET['payment_by']) && $_GET['payment_by'] == '' ? "selected" : ''; ?>>
                                        <?= lang('all'); ?></option>
                                    <?php foreach (pos_payment_type() as $pm) : ?>
                                        <option value="<?= $pm; ?>" <?= isset($_GET['payment_by']) && $_GET['payment_by'] == $pm ? "selected" : ''; ?>>
                                            <?= __($pm); ?> </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><?= lang('date'); ?></label>
                                <div class="input-group date">
                                    <input type="text" name="daterange" class="form-control dateranges" value="<?= isset($_GET['daterange']) ? $_GET['daterange'] : ''; ?>">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-15 width-auto">
                                <button type="submit" class="btn btn-primary filterBtn"><i class="icofont-filter"></i>
                                    <?= lang('filter'); ?></button>
                            </div>
                            <?php if (isset($_GET['order_type'])) : ?>
                                <div class="form-group mt-15">
                                    <a href="<?= base_url('admin/restaurant/all_order_list'); ?>" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-close"></i></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php endif; ?>


    <?php if (isset($is_filter) && $is_filter == FALSE) : ?>
        <?php include APPPATH . 'views/backend/reports/incomeBadge.php'; ?>
        <div class="filterarea">
            <div class="filterContent">

                <div class="filtercontentBody liveOrder">
                    <div class="filterIcon">
                        <a href="javascript:;" class="btn btn-secondary"> <i class="fa fa-filter"></i></a>
                    </div>
                    <form action="" method="get" class="filterForm orderFilterForm">
                        <div class="filterBody">
                            <div class="form-group">
                                <label for=""><?= lang('order_id'); ?></label>
                                <input type="text" name="uid" class="form-control" value="<?= isset($_GET['uid']) ? $_GET['uid'] : ''; ?>">
                            </div>

                            <div class="form-group">
                                <label for=""><?= lang('customer_name'); ?></label>
                                <input type="text" name="name" class="form-control" value="<?= isset($_GET['name']) ? $_GET['name'] : ''; ?>" placeholder="<?= lang('customer_name'); ?> / <?= lang('phone'); ?>">
                            </div>
                            <div class="form-group">
                                <label for=""><?= lang('order_type'); ?></label>
                                <select name="order_type" id="" class="form-control">
                                    <?php $order_type = $this->admin_m->select('order_types'); ?>
                                    <option value=""><?= lang('all'); ?></option>
                                    <?php foreach ($order_type as $key => $type) : ?>
                                        <option value="<?= $type['id']; ?>" <?= isset($_GET['order_type']) && $_GET['order_type'] == $type['id'] ? "selected" : ''; ?>>
                                            <?= $type['name']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><?= lang('status'); ?></label>
                                <select name="status" id="status" class="form-control">
                                    <option value='all' <?= isset($_GET['status']) && $_GET['status'] == 'all' ? "selected" : ''; ?>>
                                        <?= lang('all'); ?></option>
                                    <option value="pending" <?= isset($_GET['status']) && $_GET['status'] == 'pending' ? "selected" : ''; ?>>
                                        <?= lang('pending'); ?></option>
                                    <option value="accepted" <?= isset($_GET['status']) && $_GET['status'] == 'accepted' ? "selected" : ''; ?>>
                                        <?= lang('accepted'); ?></option>
                                    <option value="completed" <?= isset($_GET['status']) && $_GET['status'] == 'completed' ? "selected" : ''; ?>>
                                        <?= lang('completed'); ?></option>
                                    <option value="rejected" <?= isset($_GET['status']) && $_GET['status'] == 'rejected' ? "selected" : ''; ?>>
                                        <?= lang('rejected'); ?></option>
                                    <option value="paid" <?= isset($_GET['status']) && $_GET['status'] == 'paid' ? "selected" : ''; ?>>
                                        <?= lang('paid'); ?></option> 
                                        
                                        <option value="unpaid" <?= isset($_GET['status']) && $_GET['status'] == 'unpaid' ? "selected" : ''; ?>>
                                        <?= lang('unpaid'); ?></option>
                                </select>
                            </div>

                            <?php $table_list = $this->common_m->get_table_list(restaurant()->id); ?>
                            <div class="form-group">
                                <label><?= lang('table_no'); ?></label>
                                <select name="table_no" id="table_no" class="form-control">
                                    <option value='' <?= isset($_GET['table_no']) && $_GET['table_no'] == '' ? "selected" : ''; ?>>
                                        <?= lang('all'); ?></option>
                                    <?php foreach ($table_list as $table_no) : ?>
                                        <option value="<?= $table_no['id']; ?>" <?= isset($_GET['table_no']) && $_GET['table_no'] == $table_no['id'] ? "selected" : ''; ?>>
                                            <?= $table_no['name']; ?> / <?= $table_no['area_name']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>



                            <div class="form-group">
                                <label><?= lang('payment_type'); ?></label>
                                <select name="payment_by" id="payment_by" class="form-control">
                                    <option value='' <?= isset($_GET['payment_by']) && $_GET['payment_by'] == '' ? "selected" : ''; ?>>
                                        <?= lang('all'); ?></option>
                                    <?php foreach (pos_payment_type() as $pm) : ?>
                                        <option value="<?= $pm; ?>" <?= isset($_GET['payment_by']) && $_GET['payment_by'] == $pm ? "selected" : ''; ?>>
                                            <?= __($pm); ?> </option>
                                    <?php endforeach ?>
                                </select>
                            </div>



                            <div class="form-group mt-15">
                                <button type="submit" class="btn btn-primary filterBtn"><i class="icofont-filter"></i>
                                    <?= lang('filter'); ?></button>
                            </div>
                            <?php if (isset($_GET['order_type'])) : ?>
                                <div class="form-group mt-15">
                                    <a href="<?= base_url('admin/restaurant/order_list'); ?>" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-close"></i></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div id="list_load">

    <div class="row">
        <div class="col-md-12">
            <div class="card orderListCard">
                <div class="card-header">
                    <div class="cardLeftTitle orderCardTitle">
                        <h4 class="card-title "><?= !empty(lang('order_list')) ? lang('order_list') : "order list"; ?> </h4>
                        <div class="restaurantOrderBtn">
                            <?php if (isset($page_type) && $page_type == "restaurant") : ?>
                                <a href="<?= base_url('admin/restaurant/order_list'); ?>" class="btn btn-success success-light btn-flat"><i class="icofont-live-support"></i>
                                    &nbsp;<?= !empty(lang('live_orders')) ? lang('live_orders') : "Live Orders"; ?> </a>
                            <?php else : ?>
                                <a href="<?= base_url('admin/restaurant/all_order_list'); ?>" class="btn btn-secondary btn-flat"> <i class="icofont-tree-alt"></i>
                                    &nbsp;<?= !empty(lang('all_orders')) ? lang('all_orders') : "All Orders"; ?> </a>
                            <?php endif; ?>
                        </div><!-- restaurantOrderBtn -->
                    </div><!-- cardLeftTitle -->
                    <div class="cardRightArea">
                        <div class="orderAbtn ">

                            <?php
                            $controller = $this->uri->rsegment(1); // The Controller
                            $function = $this->uri->rsegment(2);
                            $params = $this->uri->rsegment(3);
                            if ($function != 'all_order_list') {
                                $function = 'order_list';
                            }

                            ?>
                            <div class="restaurantStatusButton">
                                <a href="<?= base_url("admin/restaurant/{$function}?status=accepted"); ?>" class="btn <?= isset($_GET['status']) && $_GET['status'] == 'accepted' ? "bg-info-soft " : "bg-info-light-active"; ?> "><?= lang('accepted'); ?></a>

                                <a href="<?= base_url("admin/restaurant/{$function}?status=completed"); ?>" class="btn <?= isset($_GET['status']) && $_GET['status'] == 'completed' ? "bg-success-soft" : "bg-success-light-active"; ?> "><?= lang('completed'); ?></a>

                                <a href="<?= base_url("admin/restaurant/{$function}?status=pending"); ?>" class="btn <?= isset($_GET['status']) && $_GET['status'] == 'pending' ? "bg-warning-soft" : "bg-warning-light-active"; ?>"><?= lang('pending'); ?></a>

                                <a href="<?= base_url("admin/restaurant/{$function}?status=rejected"); ?>" class="btn <?= isset($_GET['status']) && $_GET['status'] == 'rejected' ? "bg-danger-soft" : "bg-danger-light"; ?> "><?= lang('rejected'); ?></a>

                                <?php if (isset($page_type) && $page_type != 'Restaurant') : ?>
                                    <a href="<?= base_url("admin/restaurant/{$function}?status=draft"); ?>" class="btn bg-purple-active"><?= lang('draft'); ?></a>
                                <?php endif; ?>
                            </div><!-- restaurantStatusButton -->
                        </div>
                        <!-- orderAbtn -->
                        <div class="actionBtn">
                            <form action="<?= base_url("admin/restaurant/order_action"); ?>" method="post">
                                <?= csrf(); ?>
                                <input type="hidden" name="actionIds" value="">
                                <label class="btn btn-info info-light-active p-r" data-toggle="tooltip" title="<?= lang('merge'); ?>" onclick="$(this).closest('form').submit();"> <i class="fa fa-exchange"></i> <input type="radio" name="merge" value="1" class="opacity_0">
                                </label>

                                <label class="btn btn-danger danger-light-active p-r" data-toggle="tooltip" onclick="$(this).closest('form').submit();" title="<?= lang('delete'); ?>"> <i class="fa fa-trash"></i> <input type="radio" name="delete" value="1" class="opacity_0">
                                </label>
                            </form>
                        </div><!-- actionBtn -->

                        <div class="orderList">
                            <ul class="viewContent">
                                <?php if (file_exists(APPPATH . 'controllers/admin/Pos.php')) : ?>
                                    <li><a href="<?= base_url("admin/pos"); ?>" class="btn btn-secondary mr-5"><i class="fa fa-plus"></i> <?= lang('new_order'); ?></a></li>
                                <?php endif; ?>
                                <li class="showExtras"><a href="javascript:;"><i class="fa fa-cog"></i></a></li>
                            </ul>
                            <div class="customFilterContent">
                                <ul>
                                    <li class="<?= restaurant()->order_view_style == 1 ? "active" : ""; ?>"><a href="<?= base_url("admin/auth/change_order_layouts/1"); ?>"><i class="fa fa-list-ul"></i> <?= lang("list_view"); ?></a></li>
                                    <li class="<?= restaurant()->order_view_style == 2 ? "active" : ""; ?>"><a href="<?= base_url("admin/auth/change_order_layouts/2"); ?>"><i class="fa fa-th"></i> <?= lang("grid_view"); ?></a></li>

                                </ul>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.box-header -->
                <div class="card-body p-5">
                    <?php if (restaurant()->order_view_style == 1) : ?>
                        <?php include 'inc/orderList_thumb.php'; ?>
                    <?php else : ?>
                        <?php include 'inc/orderList_grid.php'; ?>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="pagination">
                                <?= $this->pagination->create_links();; ?>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <?php if (isset($total_amount) && $total_amount > 0) : ?>
                    <div class="card-footer">

                        <div class="counFooter">
                            <?= lang('grand_total'); ?> : <b><?= currency_position($total_amount, restaurant()->id); ?></b>

                        </div>
                    </div>

                <?php endif; ?>
            </div> <!-- card -->
        </div>
    </div>
</div><!-- #list_load -->
<div class="view_orderList">

</div>




<?php include 'estimate_time_modal.php' ?>



<script type="text/javascript">
    var text = '<?= lang('remaining'); ?>';
    $(".get_time").each(function(i, e) {
        var id = $(this).data('id');
        var time = $(this).data('time');
        var countDownDate = new Date(time).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            if (days > 0) {
                $('#show_time_' + id).html(text + ': ' + days + "d " + hours + "h " + minutes + "m " +
                    seconds + "s ");

            } else if (hours > 0) {
                $('#show_time_' + id).html(text + ': ' + hours + "h " + minutes + "m " + seconds + "s ");

            } else if (minutes > 0) {
                $('#show_time_' + id).html(text + ': ' + minutes + "m " + seconds + "s ");

            } else if (seconds > 0) {
                $('#show_time_' + id).html(text + ': ' + seconds + "s ");
            } else {
                $('#show_time_' + id).html('');
            }


            if (distance < 0) {
                clearInterval(x);
                $('#show_time_' + id).html('');
            }
        }, 1000);
    });
</script>


<?php if (isset($is_filter) && $is_filter == FALSE) : ?>
    <a href="javascript:;" class="isFilter" data-id="1"></a>
<?php endif; ?>

<style>
    .box {
        overflow: hidden;
    }

    .box-header {
        position: relative;
    }

    .customFilterContent.active {
        right: 0px;
        display: block;
    }

    .customFilterContent {
        position: absolute;
        right: -100%;
        background: var(--background-color);
        min-height: 71px;
        width: 200px;
        box-shadow: 0 0 5px var(--box-shadow-soft);
        display: flex;
        align-items: flex-start;
        z-index: 99;
        top: 67px;
        transition: all .3s ease-in-out;
        display: none;
    }

    .customFilterContent ul {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        gap: 5px;
    }

    .customFilterContent ul li a i {
        font-size: 19px;
    }

    .customFilterContent ul li a {
        padding: 9px;
        display: flex;
        width: 100%;
        color: var(--color);
        align-items: center;
        gap: 8px;
        transition: all .3s ease-in-out;
    }

    .customFilterContent ul li a:hover {
        background: var(--background-soft);
    }

    .customFilterContent ul li.active a {
        color: var(--color);
    }

    .customFilterContent ul li {
        width: 100%;
        display: block;
    }
</style>
<script>
    $(document).on("click", ".showExtras a", function() {
        $('.customFilterContent').toggleClass('active');
    });

    $(document).on("click", ".filterIcon a", function() {
        $('.filterForm').slideToggle();
    });


    $(document).on("click", "[name='order_ids']", function() {
        var numberNotChecked = $("[name='order_ids']").filter(':checked').length;

        var ids = [];
        $('[name="order_ids"]:checked').each(function() {
            var id = $(this).val();
            ids.push($(this).val());
        });
        if (numberNotChecked > 1) {
            $('[name="actionIds"]').val(JSON.stringify(ids));
            $('.actionBtn').addClass('active');
        } else {
            $('[name="actionIds"]').val('');
            $('.actionBtn').removeClass('active');
        }
    });
</script>