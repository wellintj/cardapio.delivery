<?php
// URL de um ícone do PIX para download
$pixIconUrl = 'https://logospng.org/download/pix/logo-pix-icone-512.png';

// Pasta de destino
$destFolder = 'assets/frontend/images/payout/';

// Nome do arquivo
$fileName = 'pix.png';

// Verifica se a pasta existe, caso contrário, cria
if (!is_dir($destFolder)) {
    mkdir($destFolder, 0777, true);
}

// Baixa o arquivo
$iconData = file_get_contents($pixIconUrl);

// Salva o arquivo
file_put_contents($destFolder . $fileName, $iconData);

echo "Ícone do PIX baixado com sucesso para " . $destFolder . $fileName;
?> 