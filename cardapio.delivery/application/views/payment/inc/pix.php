<?php 
// Buscar configuração PIX da tabela pix_config
$CI =& get_instance();
$pix_config = $CI->db->where('restaurant_id', $shop['id'])->get('pix_config')->row_array();

// Verificar se existe configuração
if (!empty($pix_config)) : 
?>

	<div class="payment_content <?= $pay['slug']; ?>">
		<div class="pix-payment-card">
			<!-- PIX Header -->
			<div class="pix-header">
				<div class="pix-logo">
					<i class="fa fa-qrcode"></i>
				</div>
				<h3 class="pix-title"><?= lang('pix'); ?></h3>
				<p class="pix-subtitle"><?= lang('scan_qr_code_or_copy_the_code_below'); ?></p>
			</div>

			<!-- Amount Section -->
			<div class="pix-amount-section">
				<h2 class="pix-amount"><?= isset($total_amount) ? currency_position($total_amount, $shop['id']) : ''; ?></h2>
				<div class="pix-customer-info">
					<?= isset($payment['name']) ? html_escape($payment['name']) : ''; ?>
					<?php if (isset($payment['phone']) && !empty($payment['phone'])): ?>
						• <?= html_escape($payment['phone']); ?>
					<?php endif; ?>
				</div>
			</div>

		<?php
		// Carrega a biblioteca PIX
		$CI =& get_instance();
		$CI->load->library('Pix');
		
		// Testa a integridade da biblioteca
		$integrity_ok = $CI->pix->testarIntegridade();
		
		// Obtém os dados do PIX do restaurante
		$pix_key = isset($pix_config['pix_key']) ? $pix_config['pix_key'] : '';
		$nome = isset($payment['name']) ? $payment['name'] : '';
		$cidade = isset($pix_config['city']) ? $pix_config['city'] : 'BRASIL';
		$valor = isset($total_amount) ? $total_amount : 0;
		$txid = isset($payment['uid']) ? $payment['uid'] : uniqid();
		$descricao = isset($pix_config['pix_description']) ? $pix_config['pix_description'] : '';
		
		// Gera o código PIX e o QR Code
		$pix_copia_cola = $CI->pix->geraPix($pix_key, $nome, $cidade, $valor, $txid, $descricao);
		
		// Gera o QR code ou usa uma API alternativa se houver falha
		if ($integrity_ok) {
			$qrcode_base64 = $CI->pix->geraQrCode($pix_copia_cola);
		} else {
			// Fallback para QRServer API
			$qrcode_base64 = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' . urlencode($pix_copia_cola);
		}
		?>

			<!-- QR Code Section -->
			<div class="pix-qr-section">
				<div class="pix-qr-container">
					<img src="<?= $qrcode_base64 ?>" alt="QR Code PIX" id="pixQrCode">
				</div>
			</div>

			<!-- Instructions -->
			<div class="pix-instructions">
				<div class="pix-alert-info">
					<?= lang('scan_qr_code_or_copy_the_code_below'); ?>
				</div>
			</div>

			<!-- Copy Section -->
			<div class="pix-copy-section">
				<div class="pix-copy-group">
					<input type="text" id="pix-code" value="<?= $pix_copia_cola ?>" readonly>
					<button class="pix-copy-btn" type="button" onclick="copyPixCode()">
						<i class="fa fa-copy"></i>
						<?= lang('copy'); ?>
					</button>
				</div>
				<div id="copyMessage" class="pix-copy-message">
					<i class="fa fa-check"></i> <?= lang('code_copied'); ?>
				</div>
			</div>

		<script>
			function copyPixCode() {
				var pixCode = document.getElementById("pix-code");
				var copyMessage = document.getElementById("copyMessage");

				// Modern clipboard API with fallback
				if (navigator.clipboard && window.isSecureContext) {
					navigator.clipboard.writeText(pixCode.value).then(function() {
						showCopyMessage(copyMessage);
					}).catch(function(err) {
						console.error('Erro ao copiar código PIX: ', err);
						fallbackCopy(pixCode, copyMessage);
					});
				} else {
					fallbackCopy(pixCode, copyMessage);
				}
			}

			function fallbackCopy(pixCode, copyMessage) {
				pixCode.select();
				pixCode.setSelectionRange(0, 99999);

				try {
					document.execCommand("copy");
					showCopyMessage(copyMessage);
				} catch (err) {
					console.error('Erro ao copiar código PIX: ', err);
				}
			}

			function showCopyMessage(copyMessage) {
				copyMessage.classList.add('show');
				setTimeout(function() {
					copyMessage.classList.remove('show');
				}, 3000);
			}
			
			// Verifica se o QR code foi carregado corretamente
			document.addEventListener('DOMContentLoaded', function() {
				var qrCodeImg = document.getElementById('pixQrCode');
				
				qrCodeImg.onerror = function() {
					console.log('Erro ao carregar QR code, tentando método alternativo');
					// Usar API alternativa para gerar QR Code
					var pixCode = document.getElementById('pix-code').value;
					var alternativeQrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' + encodeURIComponent(pixCode);
					qrCodeImg.src = alternativeQrUrl;
				};
				
				// Criar função de fallback para venobox
				if (typeof $.fn.venobox === 'undefined') {
					$.fn.venobox = function() {
						console.warn('venobox não está disponível');
						return this;
					};
				}
			});
		</script>

		<form action="<?= base_url("user_payment/offline_payment_request/{$slug}"); ?>" method="post" enctype='multipart/form-data' style="width:100%;">
			<?= csrf(); ?>
			<div class="row d-flex-center flex-column">
				<input type="hidden" name="offline_type" value="pix">
				
			<!-- Warning Section -->
			<div class="pix-warning-section">
				<div class="pix-alert-warning">
					<?= lang('after_payment_confirmation_click_below'); ?>
				</div>
			</div>

			<!-- Confirm Section -->
			<div class="pix-confirm-section">
				<input type="hidden" name="order_id" value="<?= $payment['uid']; ?>">
				<input type="hidden" name="shop_id" value="<?= $payment['shop_id']; ?>">
				<input type="hidden" name="username" value="<?= $slug ?? ''; ?>">
				<input type="hidden" name="is_txn_required" value="0">
				<?php if (is_demo() == 0) : ?>
					<button type="submit" class="pix-confirm-btn">
						<i class="fa fa-check"></i>
						<?= lang('confirm_payment'); ?>
					</button>
				<?php endif; ?>
			</div>
		</div><!-- .pix-payment-card -->
			</div><!-- row -->
		</form>
	</div>
<?php endif; ?> 