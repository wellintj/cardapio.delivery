#!/bin/bash

# Script otimizado para corrigir permissões do CodeIgniter no container
echo "Corrigindo permissões do CodeIgniter..."

# Criar diretórios se não existirem
mkdir -p /var/www/html/application/cache
mkdir -p /var/www/html/application/logs
mkdir -p /var/www/html/application/session
mkdir -p /var/www/html/application/temp
mkdir -p /var/www/html/uploads

# Definir proprietário correto (mais rápido que find)
chown -R www-data:www-data /var/www/html

# Permissões básicas para diretórios e arquivos (otimizado)
chmod -R 755 /var/www/html

# Permissões especiais para diretórios que precisam de escrita
chmod -R 777 /var/www/html/uploads
chmod -R 777 /var/www/html/application/cache
chmod -R 777 /var/www/html/application/logs
chmod -R 777 /var/www/html/application/session
chmod -R 777 /var/www/html/application/temp

# Permissões para arquivos específicos
chmod 644 /var/www/html/index.php

echo "Permissões corrigidas com sucesso!"
echo "Proprietário: www-data:www-data"
echo "Diretórios base: 755"
echo "Diretórios de escrita: 777"
