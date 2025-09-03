# Implementação do Método de Pagamento PIX

Este documento descreve a implementação do método de pagamento PIX como um gateway independente no sistema de cardápio digital de restaurantes.

## Arquivos Modificados

1. **application/controllers/admin/Restaurant.php**
   - Adicionado suporte para processamento do método PIX
   - Inserção/atualização dos dados na tabela pix_config

2. **application/views/backend/users/payment_config.php**
   - Adicionada seção de configuração do PIX como método independente
   - Separado do método de pagamento offline

3. **application/views/payment/inc/pix.php**
   - Adaptado para usar a nova configuração independente do PIX
   - Consulta a tabela pix_config para obter as informações

4. **application/views/payment/payment_gateway.php**
   - Atualizado para gerenciar o PIX como método independente

## Novos Arquivos

1. **adicionar_pix_independente.sql**
   - Script SQL para adicionar as colunas necessárias
   - Criar o método de pagamento PIX na tabela payment_method_list
   - Criar a tabela pix_config

2. **migrar_pix.php**
   - Script para migrar dados do formato offline para o formato independente
   - Cria/atualiza registros na tabela pix_config

## Bancos de Dados

### Alterações nas Tabelas Existentes

- **restaurant_list**
  - Adicionadas colunas: `is_pix`, `pix_status`, `pix_config`

- **payment_method_list**
  - Adicionado registro para o método PIX com slug 'pix'

### Novas Tabelas

- **pix_config**
  - `id` - ID único autoincrement
  - `restaurant_id` - ID do restaurante
  - `pix_key` - Chave PIX (CPF, CNPJ, email, telefone ou chave aleatória)
  - `city` - Cidade do comerciante
  - `pix_description` - Descrição do pagamento
  - `created_at` - Data de criação do registro

## Instruções de Instalação

1. Execute o script SQL `adicionar_pix_independente.sql` para criar as tabelas e colunas necessárias.
2. Execute o script PHP `migrar_pix.php` para migrar dados existentes do formato offline para o formato independente.
3. Verifique se a imagem do PIX existe em `assets/frontend/images/payout/pix.png`.

## Funcionalidades

- Configuração independente do PIX, separada do método offline
- Suporte a QR Code estático no formato PIX
- Informações como chave PIX, cidade e descrição personalizáveis
- Integração com a interface de configuração de pagamentos existente

## Notas

- O PIX continuará usando a mesma lógica de processamento do pagamento offline após o usuário confirmar o pagamento.
- A separação do PIX como método independente permite ativar/desativar o PIX sem afetar o método de pagamento offline. 