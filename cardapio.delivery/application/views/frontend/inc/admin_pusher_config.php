<?php $pusher_config = pusher_config(); ?>

<?php if (isset($pusher_config->status) && $pusher_config->status == 1) : ?>
    <!-- pusher js -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <?php
    $channel_name = 'admin';
    ?>

    <script>
        var auth_key = `<?= $pusher_config->auth_key; ?>`;
        var cluster = `<?= $pusher_config->cluster; ?>`;
        var channel_name = `<?= $channel_name; ?>`;
        var shop_id = `<?= $id ?? 0; ?>`;
        var is_debug = false;
        // let is_debug = `<?= isset($pusher_config->is_debug) && $pusher_config->is_debug == 1 ? true : false; ?>`;



        (function($) {
            "use strict"

            let ringInterval;


            Pusher.logToConsole = is_debug;

            var pusher = new Pusher(`${auth_key}`, {
                cluster: `${cluster}`
            });

            var channel = pusher.subscribe(`${channel_name}`);
            channel.bind("chat", (data) => {
                let json = JSON.parse(data);
                if (json.st == 1) {
                    switch (json.action_name) {
                        case 'new_message':
                            if (json.role == 'admin') {
                                adminMsg(json.sender_id, json.receiver_id);
                                getMessage(json.receiver_id, json.sender_id, json.role);
                            }

                            if (json.role == 'user') {
                                getMessage(json.sender_id, json.receiver_id, json.role);
                                adminMsg(json.receiver_id, json.sender_id);
                            }

                            break;
                        default:
                            console.log('push');
                    }
                }
            });


            /*----------------------------------------------
              	get message
            ----------------------------------------------*/

            function getMessage(sender_id, receiver_id) {
                var url = `${base_url}admin/chat/get_message/${sender_id}/${receiver_id}`;
                $.get(url, {
                    'csrf_test_name': csrf_value
                }, function(json) {
                    if (json.st == 1) {
                        var id = $('.messages').data('id');
                        console.log(id);
                        if (sender_id == id || receiver_id == id) {
                            $(`.userMsg_${sender_id}_${receiver_id}`).html(json.load_data);
                        }

                        $(".messages").animate({
                            scrollTop: $(".messages")[0].scrollHeight
                        }, "fast");


                    }
                }, 'json');
                return false;
            }

            function adminMsg(sender_id, receiver_id) {
                var url = `${base_url}admin/chat/get_message/${sender_id}/${receiver_id}`;
                $.get(url, {
                    'csrf_test_name': csrf_value
                }, function(json) {
                    if (json.st == 1) {
                        var id = $('.messages').data('id');
                        if (sender_id == id || receiver_id == id) {
                            $(`.adminMsg_${sender_id}_${receiver_id}`).html(json.load_data);
                        }

                        $(".messages").animate({
                            scrollTop: $(".messages")[0].scrollHeight
                        }, "fast");


                    }
                }, 'json');
                return false;
            }



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





        }(jQuery));
    </script>

<?php else : ?>
    <!-- <script src="<?php echo base_url() ?>public/admin/notify.js?v=<?= settings()['version']; ?>&time=<?= time(); ?>"></script> -->
<?php endif; ?>