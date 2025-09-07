<?php 
// Verificar se o PIX Dinâmico está configurado
$mercado_config = [];
if (!empty($shop['mercado_config'])) {
    $mercado_config = json_decode($shop['mercado_config'], true);
}

if (!empty($mercado_config['access_token']) && $shop['is_mercado_pix'] == 1): ?>

<div class="payment_content text-center <?= $pay['slug'];?>">
    <div class="payment_icon payment">
        <img src="<?php echo base_url('assets/frontend/images/payout/mercado_pix.png'); ?>" alt="PIX Dinâmico - Mercado Pago">
    </div>
    <div class="payment_details">
        <div class="userInfo">
            <h4><?= isset($payment['name']) ? html_escape($payment['name']) : ''; ?></h4>
            <p><?= lang('phone'); ?>: <?= isset($payment['phone']) ? html_escape($payment['phone']) : ''; ?></p>
            <p><?= lang('email'); ?>: <?= isset($payment['email']) ? html_escape($payment['email']) : ''; ?></p>
        </div>
        
        <div class="payment_info mt-20">
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i>
                <strong>PIX Dinâmico</strong><br>
                Pagamento instantâneo via PIX com QR Code gerado automaticamente.
                O pagamento é confirmado em tempo real.
            </div>
        </div>

        <div class="payment_action mt-20">
            <button type="button" id="mercado_pix_btn" class="btn btn-success btn-lg">
                <i class="fa fa-qrcode"></i> 
                <?= !empty(lang('generate_pix_payment')) ? lang('generate_pix_payment') : 'Gerar Pagamento PIX'; ?> 
                &nbsp;(<?= get_currency('icon'); ?> <?= isset($total_amount) ? html_escape($total_amount) : ''; ?>)
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pixBtn = document.getElementById('mercado_pix_btn');

    if (pixBtn) {
        pixBtn.addEventListener('click', function() {
            // Desabilitar botão para evitar cliques duplos
            this.disabled = true;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Criando pedido...';

            // Primeiro, criar o pedido via AJAX
            const formData = new FormData();
            formData.append('is_payment', '1');
            formData.append('use_payment', '1');
            formData.append('method', 'mercado_pix');
            formData.append('<?= $this->security->get_csrf_token_name(); ?>', '<?= $this->security->get_csrf_hash(); ?>');

            // Adicionar dados do formulário de checkout
            const checkoutForm = document.querySelector('.order_form');
            if (checkoutForm) {
                const formElements = new FormData(checkoutForm);
                for (let [key, value] of formElements.entries()) {
                    if (key !== 'is_payment' && key !== 'use_payment' && key !== 'method') {
                        formData.append(key, value);
                    }
                }
            }

            fetch('<?= base_url('profile/add_order'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.st === 2 && data.url) {
                    // Sucesso - redirecionar para página de pagamento PIX
                    window.location.href = data.url;
                } else if (data.st === 1 && data.link) {
                    // Pedido criado mas sem pagamento - redirecionar para sucesso
                    window.location.href = data.link;
                } else {
                    // Erro
                    alert('Erro ao criar pedido: ' + (data.msg || 'Erro desconhecido'));
                    this.disabled = false;
                    this.innerHTML = '<i class="fa fa-qrcode"></i> Gerar Pagamento PIX';
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao processar pedido. Tente novamente.');
                this.disabled = false;
                this.innerHTML = '<i class="fa fa-qrcode"></i> Gerar Pagamento PIX';
            });
        });
    }
});
</script>

<?php else: ?>
    <div class="payment_content text-center">
        <h4><?= !empty(lang('credentials_not_found')) ? lang('credentials_not_found') : "Credenciais não encontradas"; ?></h4>
        <p class="text-muted">PIX Dinâmico não está configurado ou ativado para este restaurante.</p>
    </div>
<?php endif; ?>
