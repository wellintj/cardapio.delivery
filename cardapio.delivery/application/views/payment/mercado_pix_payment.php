<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento PIX - <?= htmlspecialchars($restaurant_name ?? 'Restaurante'); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/frontend/css/mercado_pix_payment.css'); ?>" rel="stylesheet">
</head>
<body>
    <div class="container-fluid pix-payment-container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="pix-payment-card">
                    <!-- Header -->
                    <div class="payment-header text-center">
                        <div class="restaurant-info">
                            <?php if (!empty($restaurant_logo)): ?>
                                <img src="<?= $restaurant_logo; ?>" alt="<?= htmlspecialchars($restaurant_name); ?>" class="restaurant-logo">
                            <?php endif; ?>
                            <h2 class="restaurant-name"><?= htmlspecialchars($restaurant_name ?? 'Restaurante'); ?></h2>
                        </div>
                        <div class="payment-method-info">
                            <i class="fas fa-qrcode pix-icon"></i>
                            <h3>Pagamento PIX Dinâmico</h3>
                            <p class="text-muted">Escaneie o QR Code ou copie o código PIX</p>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="payment-status" id="payment-status">
                        <div class="status-pending">
                            <i class="fas fa-clock text-warning"></i>
                            <span>Aguardando pagamento...</span>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <h4><i class="fas fa-receipt"></i> Resumo do Pedido</h4>
                        <div class="order-details">
                            <div class="order-item">
                                <span class="item-label">Pedido #<?= htmlspecialchars($order_id ?? ''); ?></span>
                                <span class="item-value">R$ <?= number_format($total_amount ?? 0, 2, ',', '.'); ?></span>
                            </div>
                            <?php if (!empty($customer_name)): ?>
                                <div class="order-item">
                                    <span class="item-label">Cliente:</span>
                                    <span class="item-value"><?= htmlspecialchars($customer_name); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="order-item">
                                <span class="item-label">Método:</span>
                                <span class="item-value">PIX Dinâmico</span>
                            </div>
                            <div class="order-item">
                                <span class="item-label">Expira em:</span>
                                <span class="item-value" id="countdown-timer">
                                    <?= isset($expiration_minutes) ? $expiration_minutes : 30; ?> minutos
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code Section -->
                    <div class="qr-code-section text-center">
                        <?php if (!empty($qr_code_base64)): ?>
                            <div class="qr-code-container">
                                <img src="data:image/png;base64,<?= $qr_code_base64; ?>" 
                                     alt="QR Code PIX" 
                                     class="qr-code-image" 
                                     id="qr-code-image">
                                <div class="qr-code-overlay" id="qr-code-overlay">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <p>Pagamento Confirmado!</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="qr-code-error">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                <p>Erro ao gerar QR Code. Tente novamente.</p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="qr-instructions">
                            <h5><i class="fas fa-mobile-alt"></i> Como pagar:</h5>
                            <ol class="payment-steps">
                                <li>Abra o app do seu banco</li>
                                <li>Escolha a opção PIX</li>
                                <li>Escaneie o QR Code acima</li>
                                <li>Confirme o pagamento</li>
                            </ol>
                        </div>
                    </div>

                    <!-- PIX Code Section -->
                    <?php if (!empty($qr_code)): ?>
                        <div class="pix-code-section">
                            <h5><i class="fas fa-copy"></i> Ou copie o código PIX:</h5>
                            <div class="pix-code-container">
                                <div class="pix-code-input">
                                    <input type="text" 
                                           class="form-control" 
                                           id="pix-code" 
                                           value="<?= htmlspecialchars($qr_code); ?>" 
                                           readonly>
                                    <button class="btn btn-outline-primary" 
                                            id="copy-pix-code" 
                                            onclick="copyPixCode()">
                                        <i class="fas fa-copy"></i> Copiar
                                    </button>
                                </div>
                                <small class="text-muted">
                                    Cole este código na área PIX do seu banco
                                </small>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="action-buttons text-center">
                        <button class="btn btn-success btn-lg" 
                                id="check-payment" 
                                onclick="checkPaymentStatus()">
                            <i class="fas fa-sync-alt"></i> Verificar Pagamento
                        </button>
                        
                        <div class="mt-3">
                            <a href="<?= base_url(); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar ao Início
                            </a>
                            
                            <?php if (!empty($order_tracking_url)): ?>
                                <a href="<?= $order_tracking_url; ?>" class="btn btn-outline-info">
                                    <i class="fas fa-search"></i> Acompanhar Pedido
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Payment Success -->
                    <div class="payment-success d-none" id="payment-success">
                        <div class="success-animation">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <h3 class="text-success">Pagamento Confirmado!</h3>
                        <p>Seu pedido foi aprovado e está sendo preparado.</p>
                        <div class="success-actions">
                            <?php if (!empty($order_tracking_url)): ?>
                                <a href="<?= $order_tracking_url; ?>" class="btn btn-success btn-lg">
                                    <i class="fas fa-utensils"></i> Acompanhar Pedido
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="payment-footer text-center">
                        <div class="security-info">
                            <i class="fas fa-shield-alt text-success"></i>
                            <small class="text-muted">
                                Pagamento seguro processado pelo Mercado Pago
                            </small>
                        </div>
                        
                        <div class="support-info mt-2">
                            <small class="text-muted">
                                Problemas com o pagamento? 
                                <a href="#" onclick="showSupport()">Entre em contato</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-2 mb-0">Verificando pagamento...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Dados do pagamento
        const paymentData = {
            paymentId: '<?= $payment_id ?? ''; ?>',
            orderId: '<?= $order_id ?? ''; ?>',
            expirationTime: <?= isset($expiration_timestamp) ? $expiration_timestamp : 'null'; ?>,
            checkUrl: '<?= base_url('payment/check_mercado_pix_status'); ?>'
        };

        // Verificar status do pagamento
        function checkPaymentStatus() {
            if (!paymentData.paymentId) {
                alert('ID do pagamento não encontrado');
                return;
            }

            // Reset error count when user manually checks
            errorCount = 0;

            // Restart auto-check if it was stopped
            if (!autoCheckInterval) {
                startAutoCheck();
            }

            const modal = new bootstrap.Modal(document.getElementById('loadingModal'));
            modal.show();

            fetch(paymentData.checkUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    payment_id: paymentData.paymentId,
                    order_id: paymentData.orderId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                modal.hide();

                if (data.success && data.status === 'approved') {
                    showPaymentSuccess();
                } else if (data.success) {
                    updatePaymentStatus(data.status);
                } else {
                    console.error('Payment check error:', data.error);
                    showErrorMessage('Erro ao verificar pagamento: ' + (data.error || 'Erro desconhecido'));
                }
            })
            .catch(error => {
                modal.hide();
                console.error('Payment check failed:', error);
                showErrorMessage('Erro ao verificar pagamento. Tente novamente.');
            });
        }

        // Atualizar status do pagamento
        function updatePaymentStatus(status) {
            const statusElement = document.getElementById('payment-status');
            const statusMessages = {
                'pending': { icon: 'fas fa-clock text-warning', text: 'Aguardando pagamento...' },
                'in_process': { icon: 'fas fa-spinner fa-spin text-info', text: 'Processando pagamento...' },
                'approved': { icon: 'fas fa-check-circle text-success', text: 'Pagamento aprovado!' },
                'rejected': { icon: 'fas fa-times-circle text-danger', text: 'Pagamento rejeitado' },
                'cancelled': { icon: 'fas fa-ban text-secondary', text: 'Pagamento cancelado' }
            };

            const statusInfo = statusMessages[status] || statusMessages['pending'];
            statusElement.innerHTML = `
                <div class="status-${status}">
                    <i class="${statusInfo.icon}"></i>
                    <span>${statusInfo.text}</span>
                </div>
            `;
        }

        // Mostrar sucesso do pagamento
        function showPaymentSuccess() {
            document.querySelector('.qr-code-section').classList.add('d-none');
            document.querySelector('.pix-code-section')?.classList.add('d-none');
            document.querySelector('.action-buttons').classList.add('d-none');
            document.getElementById('payment-success').classList.remove('d-none');
            
            // Mostrar overlay no QR Code
            document.getElementById('qr-code-overlay')?.classList.add('show');
            
            updatePaymentStatus('approved');
        }

        // Copiar código PIX
        function copyPixCode() {
            const pixCodeInput = document.getElementById('pix-code');
            const copyButton = document.getElementById('copy-pix-code');
            
            pixCodeInput.select();
            pixCodeInput.setSelectionRange(0, 99999);
            
            navigator.clipboard.writeText(pixCodeInput.value).then(() => {
                const originalText = copyButton.innerHTML;
                copyButton.innerHTML = '<i class="fas fa-check"></i> Copiado!';
                copyButton.classList.remove('btn-outline-primary');
                copyButton.classList.add('btn-success');
                
                setTimeout(() => {
                    copyButton.innerHTML = originalText;
                    copyButton.classList.remove('btn-success');
                    copyButton.classList.add('btn-outline-primary');
                }, 2000);
            });
        }

        // Mostrar suporte
        function showSupport() {
            alert('Entre em contato pelo WhatsApp ou telefone do restaurante para suporte.');
        }

        // Countdown timer
        function startCountdown() {
            if (!paymentData.expirationTime) {
                console.warn('No expiration time provided for PIX payment');
                return;
            }

            // Debug logging
            console.log('PIX Timer Debug Info:');
            console.log('- Expiration timestamp:', paymentData.expirationTime);
            console.log('- Current timestamp:', Math.floor(Date.now() / 1000));
            console.log('- Expiration date:', new Date(paymentData.expirationTime * 1000));
            console.log('- Current date:', new Date());

            const timerElement = document.getElementById('countdown-timer');

            const updateTimer = () => {
                const now = Math.floor(Date.now() / 1000);
                const timeLeft = paymentData.expirationTime - now;

                // Debug logging for first update
                if (!updateTimer.debugLogged) {
                    console.log('Timer calculation:');
                    console.log('- Now:', now);
                    console.log('- Expiration:', paymentData.expirationTime);
                    console.log('- Time left (seconds):', timeLeft);
                    console.log('- Time left (minutes):', Math.floor(timeLeft / 60));
                    updateTimer.debugLogged = true;
                }

                if (timeLeft <= 0) {
                    timerElement.textContent = 'Expirado';
                    timerElement.classList.add('text-danger');

                    // Stop auto-check when expired
                    if (autoCheckInterval) {
                        clearInterval(autoCheckInterval);
                        autoCheckInterval = null;
                    }

                    // Show expiration message
                    showExpirationMessage();
                    return;
                }

                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;

                // Warning for unusual timer values
                if (minutes > 60) {
                    console.warn('PIX Timer showing unusual value:', minutes, 'minutes');
                    console.warn('This might indicate a timestamp format issue');
                }

                timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            };

            // Check if already expired when page loads
            const now = Math.floor(Date.now() / 1000);
            if (paymentData.expirationTime <= now) {
                console.log('PIX payment already expired on page load');
                timerElement.textContent = 'Expirado';
                timerElement.classList.add('text-danger');
                showExpirationMessage();
                return;
            }

            updateTimer();
            setInterval(updateTimer, 1000);
        }

        // Show expiration message
        function showExpirationMessage() {
            const existingMsg = document.querySelector('.pix-expired-message');
            if (existingMsg) return; // Already shown

            const expiredDiv = document.createElement('div');
            expiredDiv.className = 'alert alert-warning pix-expired-message mt-3';
            expiredDiv.innerHTML = `
                <i class="fas fa-clock"></i>
                <strong>PIX Expirado</strong><br>
                Este código PIX expirou. Você pode gerar um novo pagamento ou entrar em contato com o restaurante.
            `;

            const qrContainer = document.querySelector('.qr-code-container');
            if (qrContainer) {
                qrContainer.insertAdjacentElement('afterend', expiredDiv);
            }
        }

        // Mostrar mensagem de erro sem alert
        function showErrorMessage(message) {
            // Remove mensagens de erro anteriores
            const existingError = document.querySelector('.payment-error-message');
            if (existingError) {
                existingError.remove();
            }

            // Cria nova mensagem de erro
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-warning alert-dismissible fade show payment-error-message mt-3';
            errorDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // Adiciona após o QR code
            const qrContainer = document.querySelector('.qr-code-container');
            if (qrContainer) {
                qrContainer.insertAdjacentElement('afterend', errorDiv);
            }
        }

        // Auto-verificação de pagamento com controle de erro
        let autoCheckInterval;
        let errorCount = 0;
        const maxErrors = 3;

        function startAutoCheck() {
            // Verificar a cada 10 segundos
            autoCheckInterval = setInterval(() => {
                if (!document.getElementById('payment-success').classList.contains('d-none')) {
                    clearInterval(autoCheckInterval);
                    return; // Já foi pago
                }

                // Se houve muitos erros, parar auto-verificação
                if (errorCount >= maxErrors) {
                    clearInterval(autoCheckInterval);
                    showErrorMessage('Auto-verificação pausada devido a erros. Use o botão "Verificar Pagamento" para tentar novamente.');
                    return;
                }

                checkPaymentStatusSilent();
            }, 10000);
        }

        // Versão silenciosa da verificação (sem modal)
        function checkPaymentStatusSilent() {
            if (!paymentData.paymentId) {
                return;
            }

            fetch(paymentData.checkUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    payment_id: paymentData.paymentId,
                    order_id: paymentData.orderId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                errorCount = 0; // Reset error count on success

                if (data.success && data.status === 'approved') {
                    clearInterval(autoCheckInterval);
                    showPaymentSuccess();
                } else if (data.success) {
                    updatePaymentStatus(data.status);
                }
            })
            .catch(error => {
                errorCount++;
                console.error('Silent payment check failed:', error);
            });
        }

        // Inicializar quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
            startCountdown();
            startAutoCheck();
        });
    </script>
</body>
</html>
