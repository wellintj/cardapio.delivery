# 🚀 Cardapio.delivery - Guia de Instalação

## 📋 Pré-requisitos
- PHP 7.4+ ou 8.x
- MySQL 5.7+ ou MariaDB 10.3+
- Apache/Nginx com mod_rewrite habilitado
- Composer (para dependências PHP)

## 🔧 Instalação no Servidor

### 1. Clone do Repositório
```bash
git clone https://github.com/wellintj/cardapio.delivery.git
cd cardapio.delivery
```

### 2. Configuração do Banco de Dados

#### 2.1 Copiar arquivo de configuração
```bash
cp application/config/database.example.php application/config/database.php
```

#### 2.2 Editar configurações do banco
```bash
nano application/config/database.php
```

Altere as seguintes linhas:
```php
'hostname' => 'localhost',           // Seu host MySQL
'username' => 'SEU_USUARIO_MYSQL',   // Seu usuário MySQL  
'password' => 'SUA_SENHA_MYSQL',     // Sua senha MySQL
'database' => 'SEU_BANCO_MYSQL',     // Nome do seu banco
```

#### 2.3 Importar banco de dados
```bash
mysql -u root -p SEU_BANCO_MYSQL < cardapio_delivery-db.sql
```

### 3. Configurar Permissões
```bash
# Criar diretórios necessários
mkdir -p application/logs
mkdir -p application/cache  
mkdir -p uploads
mkdir -p assets/uploads

# Definir permissões
chmod 755 application/logs
chmod 755 application/cache
chmod 755 uploads
chmod 755 assets/uploads

# Para servidores Apache
chown -R www-data:www-data .
```

### 4. Configurar Apache/Nginx

#### Apache (.htaccess já incluído)
Certifique-se que mod_rewrite está habilitado:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Nginx
Adicione ao seu arquivo de configuração:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### 5. Instalar Dependências (se necessário)
```bash
composer install --no-dev --optimize-autoloader
```

## 🔒 Arquivos Sensíveis

Os seguintes arquivos contêm informações sensíveis e **NÃO** estão no repositório:
- `application/config/database.php` - Credenciais do banco
- `uploads/` - Arquivos enviados pelos usuários
- `application/logs/` - Logs do sistema
- `application/cache/` - Cache do sistema

## ⚙️ Configurações Adicionais

### Configurar URL Base
Edite `application/config/config.php`:
```php
$config['base_url'] = 'https://seudominio.com/';
```

### Configurar Timezone
```php
$config['time_reference'] = 'America/Sao_Paulo';
```

## 🧪 Teste da Instalação

1. Acesse seu domínio no navegador
2. Verifique se a página inicial carrega
3. Teste o login administrativo
4. Verifique se as imagens são carregadas

## 🆘 Problemas Comuns

### Erro de Conexão com Banco
- Verifique credenciais em `database.php`
- Confirme se o MySQL está rodando
- Teste conexão: `mysql -u usuario -p`

### Erro 500 - Internal Server Error
- Verifique permissões dos arquivos
- Confira logs: `tail -f application/logs/log-*.php`
- Verifique se mod_rewrite está habilitado

### Imagens não carregam
- Verifique permissões da pasta `uploads/`
- Confirme se o caminho está correto

## 📞 Suporte

Para problemas de instalação, verifique:
1. Logs do Apache/Nginx
2. Logs da aplicação em `application/logs/`
3. Configurações do PHP (php.ini)

---
**Importante**: Nunca commite arquivos com credenciais reais no Git!
