<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Flatpickr</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <input type="text" class="datepicker-3" placeholder="Escolha uma data">
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
    <script>
        flatpickr.localize(flatpickr.l10ns.pt); // Configura o idioma globalmente para Português

        // Inicializa o flatpickr
        flatpickr(".datepicker-3", {
            enableTime: false,
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            locale: "pt", // Idioma configurado localmente (opcional)
        });
    </script>
</body>
</html>
