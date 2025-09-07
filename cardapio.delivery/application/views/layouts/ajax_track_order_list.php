<div class="single_track bg-gray">
    <div class="card bg-gray">
        <h5 class="card-header">
            <?php if (isset($page_title) && $page_title == "All Orders") : ?>
                <a href="<?= base_url('track-order/' . $slug); ?>" class="back_icon"><i class="icofont-double-left"></i></a>
            <?php else : ?>
                <a href="javascript:;" class="back_track_form back_icon"><i class="icofont-double-left"></i></a>
            <?php endif; ?>

            &nbsp; <?= lang('order_list'); ?>
        </h5>
        <div class="card-body">
            <div class="single_track_list">
                <div class="table-responsive responsiveTable">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?= lang('sl'); ?></th>
                                <th><?= lang('order_id'); ?></th>
                                <th><?= lang('phone'); ?></th>
                                <th><?= lang('total_qty'); ?></th>
                                <th><?= lang('total_price'); ?></th>
                                <th><?= lang('order_date'); ?></th>
                                <th><?= lang('order_type'); ?></th>
                                <th><?= lang('status'); ?></th>
                                <th><?= lang('details'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_list as $key => $list) : ?>
                                <tr>
                                    <td data-label="<?= lang('sl'); ?>"><?= $key + 1; ?></td>
                                    <td data-label="<?= lang('order_id'); ?>"># <?= html_escape($list['uid']); ?></td>
                                    <td data-label="<?= lang('phone'); ?>"><?= html_escape($list['phone']); ?></td>
                                    <td data-label="<?= lang('total_qty'); ?>"><?= $list['total_item']; ?></td>
                                    <td data-label="<?= lang('total_price'); ?>"><?= currency_position($list['total'], $list['shop_id']); ?> </td>
                                    <td data-label="<?= lang('order_date'); ?>">
                                        <span><?= full_date(html_escape($list['created_at']), $list['shop_id']); ?></span>
                                        <div class="">
                                            <?php if ($list['status'] == 1) : ?>
                                                Approved at: <?= get_time_ago($list['created_at'], $list['accept_time']); ?>
                                            <?php elseif ($list['status'] == 2) : ?>
                                                Completed at:
                                                <?= full_time(html_escape($list['completed_time']), $list['shop_id']); ?>
                                            <?php elseif ($list['status'] == 3) : ?>
                                                Cancled at:
                                                <?= full_time(html_escape($list['cancel_time']), $list['shop_id']); ?>
                                            <?php endif; ?>
                                        </div>


                                    </td>
                                    <td data-label="<?= lang('order_type'); ?>">
                                        <label class="label"><?= order_type($list['order_type']); ?></label>
                                    </td>
                                    <td data-label="<?= lang('status'); ?>">
                                        <?php if ($list['status'] == 0) : ?>
                                            <a href="javascript:;" class="badge badge-primary  status-badge"><i class="icofont-spinner-alt-6"></i> &nbsp; <?= lang('pending'); ?></a>
                                        <?php elseif ($list['status'] == 1) : ?>
                                            <div class="d_flex_center">
                                                <a href="javascript:;" class="badge badge-info  status-badge mr-10"><i class="icofont-checked"></i> <?= lang('approved'); ?></a>

                                                <a href="#timeModal_<?= $list['id']; ?>" data-toggle="modal" class="d_color"> <i class="icofont-delivery-time fa-2x"></i> </a>
                                            </div>

                                        <?php elseif ($list['status'] == 2) : ?>
                                            <?php if ($list['order_type'] == 1 && $list['is_db_completed'] == 0) : ?>
                                                <a href="javascript:;" class="badge badge-success  status-badge"><i class="icofont-check-alt"></i></i>
                                                    <?= lang('your_order_is_ready_to_delivery'); ?></a>
                                                <?php if ($list['is_picked'] == 0) : ?>
                                                    <p class="fz-12 text-muted"><?= lang('waiting_for_picked'); ?></p>
                                                <?php else : ?>
                                                    <p class="fz-12 text-muted"><?= lang('order_picked_by_dboy'); ?></p>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <a href="javascript:;" class="badge badge-success  status-badge"><i class="icofont-check-alt"></i></i> <?= lang('completed'); ?></a>
                                            <?php endif; ?>
                                        <?php elseif ($list['status'] == 3) : ?>
                                            <a href="javascript:;" class="badge badge-danger  status-badge"><i class="icofont-close-line"></i> <?= lang('rejected'); ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="<?= lang('details'); ?>">
                                        <?php if ($list['order_type'] != 3) : ?>
                                            <a href="#detailsModal_<?= $list['id']; ?>" data-toggle="modal" class="viewItems"> <i class="fa fa-eye"></i> &nbsp;<?= lang('items'); ?></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <?php if (isset($page_title) && $page_title == "Track Order") : ?>
                        <div class="seemore_order text-center">
                            <?php
                            $order = isset($order_list[0]['total_order']) && !empty($order_list[0]['total_order']) ? $total_order = $order_list[0]['total_order'] - 1 : $total_order = 0;
                            ?>
                            <?php if ($total_order != 0 && !empty($phone)) : ?>
                                <a href="<?= base_url('my-orders/' . $slug . '?phone=' . $phone); ?>" class="viewItems"> <?= lang('you_have_more'); ?> (<?= $total_order; ?>)
                                    <?= lang('orders'); ?>. <u><?= lang('click_here'); ?></u></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row text-center" style="padding-bottom:20px;">
    <div class="ci-paginationArea">
        <div class="ci-pagination-link">
            <div id="paginations"><?= $this->pagination->create_links(); ?></div>
        </div>
    </div>
</div>

<?php foreach ($order_list as $key => $order) : ?>
    <!-- Modal -->
    <div class="modal fade" id="detailsModal_<?= $order['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content bg-gray pp-5">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= lang('order_id'); ?> #<?= $order['uid']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icofont-close-line"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive responsiveTable">
                        <table class="table table-bordered table-condensed table-striped" id="example1">
                            <thead>
                                <tr>
                                    <th width=""><?= !empty(lang('sl')) ? lang('sl') : "sl"; ?></th>
                                    <th width=""><?= !empty(lang('image')) ? lang('image') : "image"; ?></th>
                                    <th width=""><?= !empty(lang('item_name')) ? lang('item_name') : "name"; ?></th>
                                    <th width=""><?= !empty(lang('qty')) ? lang('qty') : "qty"; ?></th>
                                    <th width=""><?= !empty(lang('total')) ? lang('total') : "total"; ?></th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php $p = __order($order, $order['item_list']); ?>
                                <?php foreach ($order['item_list'] as $key => $row) : ?>
                                    <?php if ($row['is_package'] == 1) : ?>
                                        <tr>
                                            <td data-label="<?= lang('sl'); ?>"><?= $key + 1;; ?></td>
                                            <td data-label="<?= lang('image'); ?>"><img src="<?= base_url($row['package_thumb']); ?>" alt="" class="order-img"></td>
                                            <td data-label="<?= lang('item_name'); ?>">
                                                <?= html_escape($row['package_name']); ?>
                                                <label class="badge badge-info fw_normal"><?= lang('package'); ?></label>

                                            </td>

                                            <td data-label="<?= lang('qty'); ?>">
                                                <?= html_escape($row['qty']); ?> x
                                                <?= currency_position($row['item_price'], $row['shop_id']); ?></td>
                                            <td data-label="<?= lang('total'); ?>"><?= currency_position($row['sub_total'], $row['shop_id']); ?></td>

                                        </tr>
                                    <?php else : ?>
                                        <tr>
                                            <td data-label="<?= lang('sl'); ?>"><?= $key + 1;; ?></td>
                                            <td data-label="<?= lang('image'); ?>"><img src="<?= base_url($row['item_thumb']); ?>" alt="" class="order-img"></td>
                                            <td data-label="<?= lang('item_name'); ?>">
                                                <?= html_escape($row['title']); ?>
                                                <?php if (isset($row['veg_type']) && $row['veg_type'] != 0) : ?> <i class="fa fa-circle veg_type <?= $row['veg_type'] == 1 ? 'c_green' : 'c_red'; ?>" data-placement="top" data-toggle="tooltip" title="<?= lang(veg_type($row['veg_type'])); ?>"></i><?php endif; ?>
                                                <?php if (shop($p->shop_id)->is_tax == 1 && $row['tax_fee'] != 0) : ?>
                                                    <p class="tax_status">
                                                        <?= tax($row['tax_fee'], shop($p->shop_id)->tax_status); ?></p>
                                                <?php endif ?>
                                                <div>
                                                    <?php if ($row['is_size'] == 1) : ?>
                                                        <label class="label sizeTag ml-5">
                                                            <?= isset($row['size_slug']) ? variants($row['size_slug'], $row['item_id'], $row['shop_id']) : ''; ?></label>
                                                    <?php endif; ?>
                                                </div>

                                                <?php if (isset($row['is_extras']) && $row['is_extras'] == 1) : ?>
                                                    <div class="extars">
                                                        <?= extraList($row['extra_id'], $row['extra_qty'], $row['item_id'], $row['shop_id']); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>

                                            <td data-label="<?= lang('qty'); ?>"><?= html_escape($row['qty']); ?> x
                                                <?= currency_position($row['item_price'], $row['shop_id']); ?></td>
                                            <td data-label="<?= lang('total'); ?>"><?= currency_position($row['sub_total'], $row['shop_id']); ?></td>

                                        </tr>
                                    <?php endif; ?>

                                <?php endforeach ?>
                                <tr class="bolder">
                                    <td colspan="3" class="colspan-null"></td>
                                    <td colspan="2" class="colspan-data">
                                        <div class="bottomPrice">
                                            <p class="flex-between fz-14"><span><?= lang('qty'); ?> </span> <b><?= $p->qty; ?></b>
                                            </p>
                                            <p class="flex-between fz-14"><span><?= lang('sub_total'); ?> </span>
                                                <b><?= currency_position($p->subtotal, $p->shop_id); ?> </b>
                                            </p>

                                            <?php if (!empty($p->tax_details)) : ?>
                                                <?php foreach ($p->tax_details as  $key => $tax) : ?>
                                                    <p class="flex-between fz-14"><span><?= lang('tax'); ?> <span class="text-sm">
                                                                <?= tax($tax['percent'], $tax['tax_status']); ?></span></span>
                                                        <b><?= currency_position($tax['total_price'], $p->shop_id); ?></b>
                                                    </p>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <?php if ($p->tax_fee != 0) : ?>
                                                    <p class="flex-between fz-14"><span><?= lang('tax'); ?> (<span class="text-sm"><?= tax($p->tax_percent, shop($p->shop_id)->tax_status); ?></span>)</span>
                                                        <b><?= currency_position($p->tax_fee, $p->shop_id); ?></b>
                                                    </p>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($p->tips != 0) : ?>
                                                <p class="flex-between fz-14"><span><?= lang('tips'); ?> </span>
                                                    <b><?= currency_position($p->tips, $p->shop_id); ?></b>
                                                </p>
                                            <?php endif; ?>



                                            <?php if ($order['order_type'] == 1 || $order['order_type'] == 5) : ?>
                                                <p class="flex-between fz-14"><span><?= lang('shipping'); ?> </span>
                                                    <b><?= currency_position($p->shipping, $p->shop_id); ?>
                                                    </b>
                                                </p>
                                            <?php endif; ?>

                                            <?php if ($p->service_charge != 0) : ?>
                                                <p class="flex-between fz-14"><span><?= lang('service_charge'); ?> </span>
                                                    <b><?= currency_position($p->service_charge, $p->shop_id); ?></b>
                                                </p>
                                            <?php endif; ?>

                                            <?php if ($p->discount != 0) : ?>
                                                <p class="flex-between fz-14"><span><?= lang('discount'); ?> </span>
                                                    <b><?= currency_position($p->discount, $p->shop_id); ?></b>
                                                </p>
                                            <?php endif; ?>

                                            <?php if ($p->coupon_discount != 0) : ?>
                                                <p class="flex-between fz-14"><span><?= lang('coupon_discount'); ?> </span>
                                                    <b><?= currency_position($p->coupon_discount, $p->shop_id); ?></b>
                                                </p>
                                            <?php endif; ?>



                                            <p class="fw-bold pt-5 pb-10 fz-16 priceTopBorder flex-between">
                                                <span><b><?= lang('total'); ?></b></span>
                                                <span><b><?= currency_position($p->grand_total, $p->shop_id); ?></b> </span>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if ($order['status'] == 3) : ?>
                            <div class="rejectReason">
                                <h5 class="text-danger"><?= lang('reject_reasons'); ?></h5>
                                <?php $reason = get_reject_reson($order['reject_reason']); ?>
                                <?php if (isset($reason->reason_list) && !empty($reason->reason_list)) : ?>
                                    <div class="rejectReason_details">
                                        <ul>
                                            <?php foreach ($reason->reason_list as $rlist) : ?>
                                                <li><?= $rlist->title; ?></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($reason->reject_msg) && !empty($reason->reject_msg)) : ?>
                                    <p><?= $reason->reject_msg; ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer space-between  d_flex">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary float-left"><?= lang('close'); ?></button>
                    <?php //if($order['order_type'] !=5): 
                    ?>
                    <a href="<?= base_url("profile/reorder/{$order['uid']}"); ?>" data-msg='' class="btn btn-primary custom_btn action_btn"><i class="fa fa-repeat"></i>
                        <?= lang('order_again'); ?></a>
                    <?php //endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->
    </div>
    <!-- 	timeModal here -->
    <?php if ($order['status'] == 1) : ?>
        <!-- Modal -->
        <div class="modal fade" id="timeModal_<?= $order['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <?= !empty(lang('order_status')) ? lang('order_status') : "Order status"; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="orderTimerModal text-center">
                            <?php if ($order['estimate_time'] > d_time()) : ?>
                                <div class="remainingStatus">
                                    <p><?= lang('order_accept_msg'); ?></p>
                                </div>
                                <span class="get_time modalTime" id="show_time_<?= $order['id']; ?>" data-time="<?= $order['estimate_time']; ?>" data-id="<?= $order['id']; ?>"></span>

                                <?php if ($order['order_type'] == 6) : ?>
                                    <?php if (shop($p->shop_id)->is_kds == 1) :  ?>
                                        <div class="mt-5">
                                            <a href="<?= base_url('admin/kds/live/' . md5($p->shop_id)); ?>" target="_blank" class="live_order_status">
                                                <?= !empty(lang('live_order_status')) ? lang('live_order_status') : "Live order status"; ?> <i class="icofont-rounded-double-right"></i></a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                            <?php else : ?>
                                <p><?= lang('order_delivery_msg'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close'); ?></button>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>


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
                $('#show_time_' + id).html(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");

            } else if (hours > 0) {
                $('#show_time_' + id).html(hours + "h " + minutes + "m " + seconds + "s ");

            } else if (minutes > 0) {
                $('#show_time_' + id).html(minutes + "m " + seconds + "s ");

            } else if (seconds > 0) {
                $('#show_time_' + id).html(seconds + "s ");
            } else {
                $('#show_time_' + id).html('');
            }


            if (distance < 0) {
                clearInterval(x);
                $('#show_time_' + id).html('');
            }
        }, 1000);
    });

    // Mobile responsiveness enhancements
    $(document).ready(function() {
        // Ensure proper mobile viewport handling
        if (window.innerWidth <= 767) {
            // Add mobile-specific classes
            $('.responsiveTable').addClass('mobile-enhanced');

            // Improve touch interactions
            $('.responsiveTable .table tbody tr').on('touchstart', function() {
                $(this).addClass('touch-active');
            }).on('touchend', function() {
                $(this).removeClass('touch-active');
            });

            // Handle modal improvements on mobile
            $('.modal').on('show.bs.modal', function() {
                $('body').addClass('modal-open-mobile');
            }).on('hide.bs.modal', function() {
                $('body').removeClass('modal-open-mobile');
            });

            // Smooth scroll for pagination
            $('.ci-pagination-link a').on('click', function() {
                $('html, body').animate({
                    scrollTop: $('.track_order_section').offset().top - 20
                }, 500);
            });
        }
    });
</script>

<style>
    /* Additional mobile touch improvements */
    @media screen and (max-width: 767px) {
        .responsiveTable.mobile-enhanced .table tbody tr.touch-active {
            transform: scale(0.98);
            transition: transform 0.1s ease;
        }

        body.modal-open-mobile {
            overflow: hidden;
        }

        body.modal-open-mobile .modal {
            padding-right: 0 !important;
        }

        /* Improve button touch targets */
        .viewItems, .badge, .back_icon {
            min-height: 44px;
            min-width: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Better focus states for accessibility */
        .viewItems:focus, .back_icon:focus {
            outline: 2px solid #007bff;
            outline-offset: 2px;
        }
    }
</style>