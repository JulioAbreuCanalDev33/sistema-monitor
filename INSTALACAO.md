# 🚀 Guia de Instalação - Sistema de Monitoramento

## 📋 Pré-requisitos

### Servidor Web
- **Apache** 2.4+ ou **Nginx** 1.18+
- **PHP** 7.4+ (recomendado 8.0+)
- **MySQL** 5.7+ ou **MariaDB** 10.3+

### Extensões PHP Necessárias
```bash
php-mysql
php-gd
php-mbstring
php-curl
php-zip
php-xml
```

## 🔧 Instalação Passo a Passo

### 1. Preparar o Ambiente

#### No Ubuntu/Debian:
```bash
sudo apt update
sudo apt install apache2 php mysql-server
sudo apt install php-mysql php-gd php-mbstring php-curl php-zip php-xml
```

#### No CentOS/RHEL:
```bash
sudo yum install httpd php mysql-server
sudo yum install php-mysql php-gd php-mbstring php-curl php-zip php-xml
```

### 2. Configurar o Banco de Dados

#### Acessar MySQL:
```bash
mysql -u root -p
```

#### Criar banco e usuário:
```sql
CREATE DATABASE sistema_monitoramento;
CREATE USER 'sistema_user'@'localhost' IDENTIFIED BY 'senha_segura';
GRANT ALL PRIVILEGES ON sistema_monitoramento.* TO 'sistema_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Importar estrutura do banco:
```bash
mysql -u sistema_user -p sistema_monitoramento < database_completo.sql
```

### 3. Configurar o Sistema

#### Extrair arquivos:
```bash
unzip sistema_monitoramento_final_completo.zip
sudo mv sistema_monitoramento /var/www/html/
```

#### Configurar permissões:
```bash
sudo chown -R www-data:www-data /var/www/html/sistema_monitoramento
sudo chmod -R 755 /var/www/html/sistema_monitoramento
sudo chmod -R 777 /var/www/html/sistema_monitoramento/assets/uploads
sudo chmod -R 777 /var/www/html/sistema_monitoramento/logs
sudo chmod -R 777 /var/www/html/sistema_monitoramento/reports
```

#### Configurar banco de dados:
Editar o arquivo `config/database.php`:
```php
<?php
class Database {
    private $host = "localhost";
    private $db_name = "sistema_monitoramento";
    private $username = "sistema_user";
    private $password = "senha_segura";
    // ... resto do código
}
?>
```

### 4. Configurar Apache

#### Criar VirtualHost:
```bash
sudo nano /etc/apache2/sites-available/sistema-monitoramento.conf
```

#### Conteúdo do VirtualHost:
```apache
<VirtualHost *:80>
    ServerName sistema-monitoramento.local
    DocumentRoot /var/www/html/sistema_monitoramento
    
    <Directory /var/www/html/sistema_monitoramento>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/sistema_error.log
    CustomLog ${APACHE_LOG_DIR}/sistema_access.log combined
</VirtualHost>
```

#### Ativar site:
```bash
sudo a2ensite sistema-monitoramento.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 5. Configurar Hosts (Opcional)

#### Adicionar ao /etc/hosts:
```bash
sudo nano /etc/hosts
```

#### Adicionar linha:
```
127.0.0.1    sistema-monitoramento.local
```

## 🔐 Primeiro Acesso

### Dados de Login Padrão:
- **URL**: http://localhost/sistema_monitoramento ou http://sistema-monitoramento.local
- **Email**: admin@sistema.com
- **Senha**: password

### ⚠️ IMPORTANTE - Alterar Senha Padrão:
1. Faça login com as credenciais padrão
2. Acesse o menu "Usuários"
3. Edite o usuário administrador
4. Altere a senha para uma senha segura

## 🛠️ Configurações Adicionais

### Upload de Arquivos

#### Configurar PHP.ini:
```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
memory_limit = 256M
```

#### Reiniciar Apache:
```bash
sudo systemctl restart apache2
```

### Backup Automático

#### Criar script de backup:
```bash
sudo nano /usr/local/bin/backup-sistema.sh
```

#### Conteúdo do script:
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/sistema_monitoramento"
DB_NAME="sistema_monitoramento"
DB_USER="sistema_user"
DB_PASS="senha_segura"

mkdir -p $BACKUP_DIR

# Backup do banco
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_$DATE.sql

# Backup dos arquivos
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/html/sistema_monitoramento/assets/uploads

# Manter apenas últimos 7 backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

#### Tornar executável e agendar:
```bash
sudo chmod +x /usr/local/bin/backup-sistema.sh
sudo crontab -e
```

#### Adicionar ao crontab (backup diário às 2h):
```
0 2 * * * /usr/local/bin/backup-sistema.sh
```

## 🔍 Solução de Problemas

### Erro de Conexão com Banco
1. Verificar credenciais em `config/database.php`
2. Verificar se MySQL está rodando: `sudo systemctl status mysql`
3. Verificar se usuário tem permissões corretas

### Erro de Upload
1. Verificar permissões da pasta uploads: `ls -la assets/uploads`
2. Verificar configurações PHP: `php -i | grep upload`
3. Verificar logs do Apache: `sudo tail -f /var/log/apache2/error.log`

### Erro 500 - Internal Server Error
1. Verificar logs do Apache
2. Verificar permissões dos arquivos
3. Verificar se todas as extensões PHP estão instaladas

### Problemas de Permissão
```bash
# Corrigir permissões
sudo chown -R www-data:www-data /var/www/html/sistema_monitoramento
sudo find /var/www/html/sistema_monitoramento -type d -exec chmod 755 {} \;
sudo find /var/www/html/sistema_monitoramento -type f -exec chmod 644 {} \;
sudo chmod -R 777 /var/www/html/sistema_monitoramento/assets/uploads
sudo chmod -R 777 /var/www/html/sistema_monitoramento/logs
```

## 📞 Suporte

### Logs do Sistema
- **Apache**: `/var/log/apache2/error.log`
- **Sistema**: `logs/activity.log`
- **PHP**: `/var/log/php_errors.log`

### Verificar Status dos Serviços
```bash
sudo systemctl status apache2
sudo systemctl status mysql
```

### Testar Conexão PHP-MySQL
Criar arquivo `test.php` na raiz:
```php
<?php
$conn = new mysqli("localhost", "sistema_user", "senha_segura", "sistema_monitoramento");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
echo "Conexão bem-sucedida!";
?>
```

## ✅ Checklist de Instalação

- [ ] Servidor web instalado e configurado
- [ ] PHP e extensões instaladas
- [ ] MySQL instalado e configurado
- [ ] Banco de dados criado e importado
- [ ] Arquivos extraídos e permissões configuradas
- [ ] Configuração do banco atualizada
- [ ] VirtualHost configurado (opcional)
- [ ] Primeiro acesso realizado
- [ ] Senha padrão alterada
- [ ] Backup configurado (opcional)

---

**Sistema de Monitoramento v2.0**  
*Desenvolvido com foco na segurança e usabilidade*

