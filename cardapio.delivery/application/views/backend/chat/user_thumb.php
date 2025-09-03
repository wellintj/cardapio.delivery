<?php foreach ($user_list as  $key => $row) : ?>
    <li class="contact " onclick="window.location.href = ' <?= base_url('admin/chat?q=' . md5($row->id)) ?> ';">
        <div class="wrap">
            <span class="contact-status online"></span>
            <img src="<?= avatar($row->thumb); ?>" alt="avatar" />
            <div class="meta">
                <p class="name"><?= !empty($row->name) ? $row->name : $row->username ?></p>
            </div>
        </div>
    </li>
<?php endforeach; ?>