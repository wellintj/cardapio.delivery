<?php $pusher_config = pusher_config($id); ?>

<?php if(isset($pusher_config->shop_id) && $pusher_config->shop_id==$id && isset($pusher_config->status) && $pusher_config->status==1): ?>
<!-- pusher js -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

<?php 
	$channel_name = shop($id)->username;
 ?>

<script>
var auth_key = `<?= $pusher_config->auth_key;?>`;
var cluster = `<?= $pusher_config->cluster;?>`;
var channel_name = `<?= $channel_name;?>`;
var a_new_order_is_merge = `<?= lang('a_new_order_is_merge');?>`;
var order_is_merged = `<?= lang('order_id_is_merged');?>`;
var merge_id = `<?= lang('merge_id');?>`;
var shop_id = `<?= $id??0;?>`;
var is_debug = `<?= isset($pusher_config->is_debug) && $pusher_config->is_debug==1?true:false;?>`;



(function($) {
    "use strict"

    let ringInterval;


    Pusher.logToConsole = is_debug;

    var pusher = new Pusher(`${auth_key}`, {
        cluster: `${cluster}`
    });

    var channel = pusher.subscribe(`${channel_name}`);
    channel.bind("notification", (data) => {
        let json = JSON.parse(data);
        if (json.st == 1) {
            switch (json.action_name) {
                case 'new_order':
                    order_notification();
                    orderList();
                    break;
                case 'order_status':
                    orderList(); // korte hobe
                    kds_order_loader();
                    order_details_loader(json.order_id); // order details page
                    break;
                case 'call_waiter':
                    waiter_request_list();
                    table_notification(); //waiter/table-icon
                    table_order();
                    break;
                case 'table_order':
                    table_order();
                    table_notification(); //waiter/table-icon
                    break;

                case 'new_table_order':
                    order_notification();
                    orderList();
                    table_order();
                    table_notification(); //waiter/table-icon
                    break;
                case 'order_merge':
                    order_notification();
                    orderList(); //waiter/table-icon
                    order_merge_list();
                    order_details_loader(json.order_id); // order details page
                    break;
                default:
                    console.log('push');
            }
        }
    });



    /*----------------------------------------------
      		Start New order Notification
    ----------------------------------------------*/

    function order_notification() {
        var url = `${base_url}admin/notification/get_ajax_notification/`;
        $.get(url, {
            'csrf_test_name': csrf_value
        }, function(json) {
            if (json.st == 1) {
                $('.ajax-notification').html(json.load_data);
                playaudio();
                setCookie('is_ring', '1', 5); //set 5minutes
            } else {
                reset();
                return true;
            }
        }, 'json');
    }



    /*----------------------------------------------
        Waiter notification in dashboard bottom list	
    ----------------------------------------------*/

    function waiter_request_list() {
        var url = `${base_url}admin/notification/get_waiter_notification/`;
        $.get(url, {
            'csrf_test_name': csrf_value
        }, function(json) {
            if (json.st == 1) {
                $('.waiter_notificaiton > ul').html(json.load_data);
                playaudio();
                setCookie('is_ring', '1', 5); //set 5minutes
            } else {
                reset();
                return true;
            }
        }, 'json');
    }




    /*----------------------------------------------
    		End new order notification		
    ----------------------------------------------*/





    /*----------------------------------------------
        Table / Dine-in / waiter ajax load data --- icon
    ----------------------------------------------*/

    function table_notification() {
        var url = `${base_url}admin/notification/table_notification/`;
        $.get(url, {
            'csrf_test_name': csrf_value
        }, function(json) {
            if (json.st == 1) {
                $('.table-ajax-notification').html(json.load_data);
            } else {
                return true;
            }
        }, 'json');
    }



    /*----------------------------------------------
      	table/waiter order page ajax load		
    ----------------------------------------------*/
    function table_order() {
        var url = `${base_url}admin/notification/table_order/`;
        $.get(url, {
            'csrf_test_name': csrf_value
        }, function(json) {
            if (json.st == 1) {
                $('#tableOrder').html(json.load_data);
            } else {
                return true;
            }
        }, 'json');
    }



    /*----------------------------------------------
      	Live Order Ajax load
    ----------------------------------------------*/
    function orderList() {
        var url = `${base_url}admin/notification/update_order_status`;
        $.post(url, {
            'csrf_test_name': csrf_value
        }, function(json) {
            if (json.st == 1) {
                $('#list_load').html(json.load_data);
            }
        }, 'json');
    }





    /*----------------------------------------------
      				Disabled notification sound
    ----------------------------------------------*/

    $(document).on('click', '.notify_btn', function() {
        var url = `${base_url}admin/menu/notification_off`
        $.post(url, {
            'csrf_test_name': csrf_value
        }, function(json) {
            if (json.st == 1) {
                $('.notifications-menu').html(json.data);
                $('.is_notify').data('notify', 0);
                reset();
            }
        }, 'json');
        return false;
    });




    /*----------------------------------------------
      	start Order Merge section
    ----------------------------------------------*/

    /*---merge order List ---*/
    function order_merge_list() {
        var url = `${base_url}admin/notification/merge_order_list/`;
        $.get(url, {
            'csrf_test_name': csrf_value
        }, function(json) {
            if (json.st == 1) {
                $('.orderMergeNotifi > ul').html(json.load_data);
            } else {
                return true;
            }
        }, 'json');
    }


    /*---Close merge list ---*/
    $(document).on('click', '.closeMergeNotification', function() {
        let id = $(this).data('id');
        var url = `${base_url}admin/notification/close_merge/${id}`;
        $.get(url, {
            'csrf_test_name': csrf_value
        }, function(json) {
            if (json.st == 1) {
                $(`.mergeLi_${id}`).fadeOut();
            }
        }, 'json');

    });

    /*----------------------------------------------
      	End	Order Merge section
    ----------------------------------------------*/



    let isRing = getCookie('is_ring');

    $(document).ready(function() {
        console.log(`isRing: ${isRing}`);
        if (isRing == 1) {
            ringInterval = setInterval(function() {
                console.log('ringing');
                playaudio();
            }, 10000);
        }
    });


    function reset() {
        clearInterval(ringInterval)
        resetaudio();
        setCookie('is_ring', '0', 5);
    }

    /*----------------------------------------------
      KDS item load after change status from orderList
    ----------------------------------------------*/

    function kds_order_loader() {
        var url = `${base_url}/admin/kds/get_new_order/${shop_id}`;
        $.get(url, {
            'csrf_test_name': csrf_value
        }, function(json) {
            if (json.st == 1) {
                $('.view_kds').html(json.load_data);
            } else {
                return true;
            }
        }, 'json');
    }


    /*----------------------------------------------
      ajax load order details page
    ----------------------------------------------*/

    function order_details_loader(order_id) {
        if (order_id != 0) {
            var url = `${base_url}/admin/restaurant/order_details_ajax/${order_id}`;
            $.get(url, {
                'csrf_test_name': csrf_value
            }, function(json) {
                if (json.st == 1) {
                    $('#orderDetailsView').html(json.result);
                } else {
                    return true;
                }
            }, 'json');
        }
    }

}(jQuery));
</script>

<?php else: ?>
<script src="<?php echo asset_url()?>public/admin/notify.js?v=<?= settings()['version'];?>&time=<?= time();?>"></script>
<?php if(isset($page) && $page == 'KDS'): ?>
<script src="<?php echo asset_url()?>public/admin/kds.js?v=<?= settings()['version'];?>&time=<?= time();?>"></script>
<?php endif;?>
<?php endif; ?>