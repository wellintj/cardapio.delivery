$(document).ready(function() {
    // Função para aplicar a máscara
    function applyPhoneMask() {
        $('.phone-mask').each(function() {
            $(this).mask('(00) 00000-0000', {
                clearIfNotMatch: true,
                placeholder: "(XX) XXXXX-XXXX"
            });
        });
    }

    // Função para formatar número de telefone existente
    function formatExistingPhone(phone) {
        if (!phone) return '';
        // Remove todos os caracteres não numéricos
        phone = phone.replace(/\D/g, '');
        // Remove o prefixo 55 se existir
        phone = phone.replace(/^55/, '');
        // Aplica a formatação
        if (phone.length === 11) {
            return '(' + phone.substr(0, 2) + ') ' + phone.substr(2, 5) + '-' + phone.substr(7);
        }
        return phone;
    }

    // Formata números de telefone existentes na página
    function formatDisplayedPhones() {
        // Formata o telefone no checkout e informações do cliente
        $('.customerInfoModal .fz-14, .ModalCustomerInfo .fz-14, #loadCustomer .fz-14').each(function() {
            var phoneText = $(this).text();
            if (phoneText.includes('icofont-ui-call')) {
                var phone = phoneText.replace(/[^\d]/g, '');
                $(this).html('<i class="icofont-ui-call"></i> ' + formatExistingPhone(phone));
            }
        });

        // Formata números em elementos específicos do checkout
        $('.customerInfoModal p, #loadCustomer p').each(function() {
            if ($(this).find('i.icofont-ui-call').length > 0) {
                var phoneText = $(this).text().trim();
                var phone = phoneText.replace(/[^\d]/g, '');
                $(this).html('<i class="icofont-ui-call"></i> ' + formatExistingPhone(phone));
            }
        });
    }

    // Aplica a máscara inicialmente
    applyPhoneMask();
    formatDisplayedPhones();

    // Aplica a máscara quando um modal é aberto
    $(document).on('shown.bs.modal', function() {
        applyPhoneMask();
        formatDisplayedPhones();
    });

    // Aplica a máscara quando conteúdo dinâmico é carregado
    $(document).ajaxComplete(function() {
        applyPhoneMask();
        formatDisplayedPhones();
    });

    // Aplica a máscara quando o campo recebe foco
    $(document).on('focus', '.phone-mask', function() {
        applyPhoneMask();
    });

    // Antes de enviar o formulário
    $('form').on('submit', function() {
        var phoneInput = $(this).find('input[name="phone"]');
        if (phoneInput.length) {
            // Remove qualquer formatação existente (parênteses, espaços, hífens)
            var phoneValue = phoneInput.val().replace(/\D/g, '');
            
            // Para formulários de recuperação de senha, mantenha o número completo
            var formId = $(this).attr('id');
            if (formId === 'recovery_password' || formId === 'checkAnswer') {
                // Para recuperação de senha, garantimos que enviamos apenas os números
                // mas mantemos o dial_code como um campo separado
                if (phoneValue.length > 0) {
                    phoneInput.val(phoneValue);
                }
            } else {
                // Para outros formulários, removemos o 55 inicial conforme comportamento original
                phoneValue = phoneValue.replace(/^55/, '');
                phoneInput.val(phoneValue);
            }
            
            // Garante que o dial_code está presente
            if (!$(this).find('input[name="dial_code"]').length) {
                $(this).append('<input type="hidden" name="dial_code" value="55">');
            }
        }
        return true;
    });
    
    // Reaplica as máscaras após qualquer erro AJAX na página
    $(document).ajaxError(function() {
        setTimeout(function() {
            applyPhoneMask();
        }, 100);
    });
    
    // Reaplica as máscaras após qualquer sucesso AJAX na página
    $(document).ajaxSuccess(function() {
        setTimeout(function() {
            applyPhoneMask();
        }, 100);
    });
}); 