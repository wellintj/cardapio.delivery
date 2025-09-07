@echo off
REM Script para gerar certificados SSL auto-assinados para desenvolvimento no Windows
REM Execute este script para criar os certificados SSL necessários

set SSL_DIR=docker\ssl
set DOMAIN=cardapio.delivery

echo Gerando certificados SSL para %DOMAIN%...

REM Verificar se o OpenSSL está disponível
where openssl >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ERRO: OpenSSL nao encontrado no PATH.
    echo Instale o OpenSSL ou use o Git Bash para executar o script .sh
    echo Voce pode baixar o OpenSSL em: https://slproweb.com/products/Win32OpenSSL.html
    pause
    exit /b 1
)

REM Criar diretório SSL se não existir
if not exist %SSL_DIR% mkdir %SSL_DIR%

REM Gerar chave privada
openssl genrsa -out %SSL_DIR%\%DOMAIN%.key 2048

REM Gerar certificado auto-assinado
openssl req -new -x509 -key %SSL_DIR%\%DOMAIN%.key -out %SSL_DIR%\%DOMAIN%.crt -days 365 -subj "/C=BR/ST=SP/L=SaoPaulo/O=CardapioDelivery/OU=Development/CN=%DOMAIN%"

echo.
echo Certificados SSL gerados com sucesso!
echo Chave privada: %SSL_DIR%\%DOMAIN%.key
echo Certificado: %SSL_DIR%\%DOMAIN%.crt
echo.
echo IMPORTANTE: Estes sao certificados auto-assinados para desenvolvimento.
echo Para producao, use certificados validos de uma CA confiavel.
echo.
echo Para confiar no certificado no seu navegador:
echo 1. Acesse https://cardapio.delivery
echo 2. Clique em 'Avancado' quando aparecer o aviso de seguranca
echo 3. Clique em 'Prosseguir para cardapio.delivery (nao seguro)'
echo.
echo Ou adicione o certificado as autoridades confiaveis do seu sistema.
pause
