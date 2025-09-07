@echo off
REM Script de configuração completa do ambiente Docker para desenvolvimento
REM Execute este script para configurar todo o ambiente

echo ========================================
echo   CARDAPIO.DELIVERY - SETUP DOCKER
echo ========================================
echo.

REM Verificar se o Docker está rodando
docker --version >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ERRO: Docker nao encontrado ou nao esta rodando.
    echo Certifique-se de que o Docker Desktop esta instalado e rodando.
    pause
    exit /b 1
)

echo 1. Verificando Docker... OK
echo.

REM Gerar certificados SSL
echo 2. Gerando certificados SSL...
call docker\generate-ssl.bat
if %ERRORLEVEL% NEQ 0 (
    echo ERRO: Falha ao gerar certificados SSL.
    pause
    exit /b 1
)
echo.

REM Parar containers existentes se estiverem rodando
echo 3. Parando containers existentes...
docker-compose down >nul 2>nul
echo.

REM Construir e iniciar os containers
echo 4. Construindo e iniciando containers...
docker-compose up --build -d

if %ERRORLEVEL% NEQ 0 (
    echo ERRO: Falha ao iniciar os containers.
    pause
    exit /b 1
)

echo.
echo 5. Aguardando inicializacao dos servicos...
timeout /t 30 /nobreak >nul

REM Verificar status dos containers
echo 6. Verificando status dos containers...
docker-compose ps

echo.
echo ========================================
echo   SETUP CONCLUIDO COM SUCESSO!
echo ========================================
echo.
echo Servicos disponiveis:
echo - Aplicacao Web: https://cardapio.delivery
echo - Aplicacao Web (HTTP): http://cardapio.delivery
echo - phpMyAdmin: http://localhost:8080
echo - MySQL: localhost:3306
echo.
echo Credenciais do banco:
echo - Usuario: cardapio.delivery-db-usr
echo - Senha: haEY5cLdhMEzrm2D
echo - Database: cardapio.delivery-db
echo.
echo IMPORTANTE: Adicione '127.0.0.1 cardapio.delivery' ao arquivo hosts
echo Localizacao do arquivo hosts: C:\Windows\System32\drivers\etc\hosts
echo.
pause
