-- Script para inicializar usuário e permissões do banco de dados
-- Este script é executado automaticamente na primeira inicialização do MySQL

-- Criar usuário se não existir
CREATE USER IF NOT EXISTS 'cardapio.delivery-db-usr'@'%' IDENTIFIED BY 'haEY5cLdhMEzrm2D';

-- Garantir que o usuário tenha todas as permissões no banco
GRANT ALL PRIVILEGES ON `cardapio.delivery-db`.* TO 'cardapio.delivery-db-usr'@'%';

-- Permitir acesso do usuário de qualquer host
GRANT ALL PRIVILEGES ON `cardapio.delivery-db`.* TO 'cardapio.delivery-db-usr'@'localhost';

-- Aplicar as mudanças
FLUSH PRIVILEGES;

-- Verificar se o banco foi criado
USE `cardapio.delivery-db`;

-- Log de inicialização
SELECT 'Usuário cardapio.delivery-db-usr criado com sucesso!' as status;
