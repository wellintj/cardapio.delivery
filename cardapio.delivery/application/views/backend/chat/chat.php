<style>
    <?php include 'chat.css'; ?>
</style>
<div class="row">
    <div class="col-md-10">
        <div id="frame">
            <div id="sidepanel">
                <div id="profile">
                    <div class="wrap">
                        <img id="profile-img" src="<?= avatar($info->thumb) ?>" class="online" alt="user_profile" />
                        <p><?= isset($info->name) && !empty($info->name) ? $info->name : $info->username; ?></p>
                    </div>
                </div>
                <?php if (auth('user_role') == 1) : ?>
                    <form action="<?= base_url('admin/chat/search'); ?>">
                        <div id="search">
                            <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                            <input type="text" name="search" placeholder="Buscar Contatos..." />
                        </div>
                    </form>
                <?php endif; ?>
                <div id="contacts">
                    <ul class="adminContacs">
                        <?php if ($role == 'admin') : ?>
                            <?php foreach ($user_message as  $key => $users) : ?>
                                <?php $msginfo =  $this->admin_m->get_last_message($users->sender_id); ?>
                                <li class="contact <?= isset($qinfo->sender_id) && $qinfo->sender_id == $users->sender_id ? "active" : "" ?> <?= $users->sender_id ?>" onclick="window.location.href = '<?= base_url('admin/chat?q=' . md5($users->sender_id)) ?>';">
                                    <div class="wrap">
                                        <span class="contact-status online"></span>
                                        <img src="<?= avatar($users->thumb) ?>" alt="" />
                                        <div class="meta">
                                            <p class="name"><?= !empty($users->name) ? $users->name : $user->username ?>
                                                <?php if (!empty($msginfo['count'])) : ?>
                                                    <span class="counter"><?= $msginfo['count']; ?></span>
                                                <?php endif; ?>
                                            </p>
                                            <p class="lastMsg"><?= $msginfo['last_message']; ?></p>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li class="contact active">
                                <div class="wrap">
                                    <span class="contact-status online"></span>
                                    <img src="<?= avatar(admin()->thumb); ?>" alt="" />
                                    <div class="meta">
                                        <p class="name"><?= !empty(admin()->name) ? admin()->name : admin()->username; ?></p>
                                    </div>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>

                </div>
                <div id="bottom-bar" class="hidden">
                    <button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Adicionar Contato</span></button>
                    <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Definições</span></button>
                </div>
            </div>
            <div class="content">
                <?php if ($role == 'admin') : ?>
                    <div class="messages custommsg_<?= auth('id'); ?> adminMsg_<?= $sender_id . '_' . $receiver_id; ?>" data-id="<?= auth('id'); ?>">
                        <?php if (isset($_GET['q']) && !empty($_GET['q'])) : ?>
                            <?php include 'chat_thumb.php'; ?>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="messages custommsg_<?= auth('id') ?> userMsg_<?= $sender_id . '_' . $receiver_id; ?>" data-id="<?= auth('id'); ?>">
                        <?php include 'chat_thumb.php'; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($receiver_id)) : ?>
                    <form action="<?= base_url('admin/chat/send') ?>" method="post" class="chatForm">
                        <?= csrf(); ?>
                        <div class="message-input">
                            <div class="wrap">
                                <input type="text" name="message" placeholder="Escreva sua Mensagem..." />
                                <input type="hidden" name="sender_id" value="<?= $sender_id; ?>">
                                <input type="hidden" name="receiver_id" value="<?= $receiver_id; ?>">
                                <input type="hidden" name="role" value="<?= $role; ?>">
                                <button class="submit submit_btn" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>


<script>
    let senderId = $('[name="sender_id"]').val();
    $(function() {

        $(document).on('submit', '.chatForm', function(e) {
            e.preventDefault();

            if ($('.reg_msg').length == 0) {
                $(this).prepend('<span class="reg_msg"></span>');
            }
            $('.submit_btn').prop('disabled', true);

            var formData = new FormData(this); // Create a FormData object from the form

            var url = $(this).attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(json) {
                    if (json.st == 1) {
                        getMessage(senderId);
                        $('[name="message"]').val(null);
                        $(".messages").animate({
                            scrollTop: $(".messages")[0].scrollHeight
                        }, "fast");

                    } else {
                        $(".reg_msg").html(json.msg).slideDown();
                    }
                    setTimeout(function() {
                        $('.reg_msg').fadeOut();
                        $('.submit_btn').prop('disabled', false);
                    }, 2000);
                },
                dataType: 'json'
            });

            return false;
        });

    });


    $(".messages").animate({
        scrollTop: $(".messages")[0].scrollHeight
    }, "fast");



    function getMessage(sender_id) {
        var url = `${base_url}admin/chat/get_message/${sender_id}`;
        $.get(url, {
            'csrf_test_name': csrf_value
        }, function(json) {
            if (json.st == 1) {
                $('.messages').html(json.load_data);
                $(".messages").animate({
                    scrollTop: $(".messages")[0].scrollHeight
                }, "fast");

            }
        }, 'json');
        return false;
    }

    $(document).on('keyup', '[name="search"]', function() {
        var value = $(this).val();
        if (value.length > 2) {
            var url = `${base_url}admin/chat/search?search=${value}`; // Remove space around '='
            $.get(url, {
                'csrf_test_name': csrf_value
            }, function(json) {
                if (json.st == 1) {
                    $('.adminContacs').html(json.load_data);
                    $(".messages").animate({
                        scrollTop: $(".messages")[0].scrollHeight
                    }, "fast");
                }
            }, 'json');
            return false;
        }
    });

    $(document).on('click', '[name="message"]', function() {
        console.log('press');
        var value = $('[name="receiver_id"]').val();
        var val = $(this).val();
        var url = `${base_url}admin/chat/change_status/${value}`; // Remove space around '='
        $.get(url, {
            'csrf_test_name': csrf_value
        }, function(json) {
            if (json.st == 1) {
                $('[name="message"]').val(val);
            }
        }, 'json');
        return false;
    });
</script>