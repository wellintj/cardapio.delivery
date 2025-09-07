#!/bin/bash

# Script para gerar certificados SSL auto-assinados para desenvolvimento
# Execute este script para criar os certificados SSL necessários

SSL_DIR="./docker/ssl"
DOMAIN="cardapio.delivery"

echo "Gerando certificados SSL para $DOMAIN..."

# Criar diretório SSL se não existir
mkdir -p $SSL_DIR

# Gerar chave privada
openssl genrsa -out $SSL_DIR/$DOMAIN.key 2048

# Gerar certificado auto-assinado
openssl req -new -x509 -key $SSL_DIR/$DOMAIN.key -out $SSL_DIR/$DOMAIN.crt -days 365 -subj "/C=BR/ST=SP/L=SaoPaulo/O=CardapioDelivery/OU=Development/CN=$DOMAIN"

# Definir permissões adequadas
chmod 600 $SSL_DIR/$DOMAIN.key
chmod 644 $SSL_DIR/$DOMAIN.crt

echo "Certificados SSL gerados com sucesso!"
echo "Chave privada: $SSL_DIR/$DOMAIN.key"
echo "Certificado: $SSL_DIR/$DOMAIN.crt"
echo ""
echo "IMPORTANTE: Estes são certificados auto-assinados para desenvolvimento."
echo "Para produção, use certificados válidos de uma CA confiável."
echo ""
echo "Para confiar no certificado no seu navegador:"
echo "1. Acesse https://cardapio.delivery"
echo "2. Clique em 'Avançado' quando aparecer o aviso de segurança"
echo "3. Clique em 'Prosseguir para cardapio.delivery (não seguro)'"
echo ""
echo "Ou adicione o certificado às autoridades confiáveis do seu sistema."
