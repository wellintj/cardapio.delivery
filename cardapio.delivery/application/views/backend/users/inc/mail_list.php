<div class="card">
    <div class="card-body">
        <div class="email_list">
            <ul>
                <?php foreach ($email_queue as $email) : ?>
                    <?php $icon = $email['status'] === 'pending' ? '⏳' : ($email['status'] === 'sent' ? '✅' : '❌'); ?>
                    <li> <?= $icon; ?> <?= $email['email']; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>