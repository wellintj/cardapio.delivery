# Cardápio Delivery - Ambiente Docker para Desenvolvimento

Este guia explica como configurar e executar o projeto Cardápio Delivery usando Docker para desenvolvimento local.

## Pré-requisitos

- Docker Desktop instalado e rodando
- Git Bash ou OpenSSL (para gerar certificados SSL)
- Arquivo hosts configurado (veja instruções abaixo)

## Configuração Rápida

### 1. Executar Setup Automático

Execute o script de configuração automática:

```bash
# No Windows
docker\setup.bat

# No Linux/Mac
chmod +x docker/generate-ssl.sh
./docker/generate-ssl.sh
docker-compose up --build -d
```

### 2. Configurar Arquivo Hosts

Adicione a seguinte linha ao arquivo hosts do seu sistema:

```
127.0.0.1 cardapio.delivery
```

**Localização do arquivo hosts:**
- Windows: `C:\Windows\System32\drivers\etc\hosts`
- Linux/Mac: `/etc/hosts`

## Serviços Disponíveis

Após a configuração, os seguintes serviços estarão disponíveis:

- **Aplicação Web (HTTPS)**: https://cardapio.delivery
- **Aplicação Web (HTTP)**: http://cardapio.delivery (redireciona para HTTPS)
- **phpMyAdmin**: http://localhost:8080
- **MySQL**: localhost:3306

## Credenciais do Banco de Dados

- **Host**: db (interno) / localhost:3306 (externo)
- **Usuário**: cardapio.delivery-db-usr
- **Senha**: haEY5cLdhMEzrm2D
- **Database**: cardapio.delivery-db

## Comandos Docker Úteis

### Iniciar os containers
```bash
docker-compose up -d
```

### Parar os containers
```bash
docker-compose down
```

### Reconstruir e iniciar
```bash
docker-compose up --build -d
```

### Ver logs
```bash
# Todos os serviços
docker-compose logs -f

# Apenas a aplicação web
docker-compose logs -f web

# Apenas o banco de dados
docker-compose logs -f db
```

### Acessar container da aplicação
```bash
docker-compose exec web bash
```

### Acessar MySQL
```bash
docker-compose exec db mysql -u root -p
# Senha: root123
```

## Estrutura dos Arquivos Docker

```
docker/
├── apache-config.conf      # Configuração do Apache (HTTP)
├── apache-ssl.conf         # Configuração do Apache (HTTPS)
├── mysql-config.cnf        # Configuração personalizada do MySQL
├── generate-ssl.sh         # Script para gerar certificados SSL (Linux/Mac)
├── generate-ssl.bat        # Script para gerar certificados SSL (Windows)
├── setup.bat              # Script de configuração completa (Windows)
└── ssl/                   # Diretório dos certificados SSL
    ├── cardapio.delivery.crt
    └── cardapio.delivery.key
```

## Certificados SSL

Os certificados SSL são auto-assinados para desenvolvimento. Quando acessar https://cardapio.delivery pela primeira vez:

1. O navegador mostrará um aviso de segurança
2. Clique em "Avançado"
3. Clique em "Prosseguir para cardapio.delivery (não seguro)"

**Para produção**, substitua os certificados auto-assinados por certificados válidos de uma CA confiável.

## Importação do Banco de Dados

O dump do banco `cardapio.delivery-db_20250510_130856.sql` é automaticamente importado na primeira execução do container MySQL.

## Volumes e Persistência

- **mysql_data**: Volume persistente para dados do MySQL
- **Código fonte**: Montado como volume para desenvolvimento (hot reload)
- **Uploads**: Diretório de uploads persistente

## Troubleshooting

### Container não inicia
```bash
# Verificar logs
docker-compose logs

# Reconstruir containers
docker-compose down
docker-compose up --build -d
```

### Problemas de permissão
```bash
# Acessar container e ajustar permissões
docker-compose exec web bash
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
```

### Banco de dados não conecta
1. Verifique se o container do MySQL está rodando: `docker-compose ps`
2. Verifique os logs do MySQL: `docker-compose logs db`
3. Teste a conexão: `docker-compose exec db mysql -u cardapio.delivery-db-usr -p`

### SSL não funciona
1. Verifique se os certificados foram gerados: `ls docker/ssl/`
2. Regenere os certificados: `docker/generate-ssl.bat`
3. Reinicie os containers: `docker-compose restart web`

## Desenvolvimento

Para desenvolvimento, os arquivos são montados como volumes, então as alterações no código são refletidas imediatamente sem necessidade de reconstruir o container.

### Logs da aplicação
- Apache: `docker-compose logs web`
- PHP: Verifique `/var/www/html/application/logs/` dentro do container
- MySQL: `docker-compose logs db`

## Produção

Este setup é apenas para desenvolvimento. Para produção:

1. Use certificados SSL válidos
2. Configure variáveis de ambiente adequadas
3. Use imagens otimizadas para produção
4. Configure backup automático do banco
5. Implemente monitoramento e logs centralizados
