# 📦 Deployment Guide - Delicia by Dilla

## 🌐 Overview

Panduan lengkap untuk deploy aplikasi "Delicia by Dilla" ke production server, termasuk shared hosting, VPS, dan cloud platforms.

---

## 🎯 Deployment Targets

### **Supported Environments:**
- 🌐 **Shared Hosting** (cPanel, Plesk)
- ☁️ **VPS/Cloud** (AWS, DigitalOcean, Vultr)
- 🐳 **Containerized** (Docker)
- 🏢 **Dedicated Server**

### **Production Requirements:**
- **PHP**: 8.0+ dengan extensions wajib
- **MySQL**: 5.7+ atau MariaDB 10.2+
- **SSL Certificate**: Highly recommended
- **Domain**: Custom domain name
- **Storage**: 500MB+ untuk assets dan backups

---

## 🌐 Shared Hosting Deployment

### **Step 1: Preparation**

#### **Pre-Deployment Checklist:**
- [ ] Hosting account dengan PHP 8.0+ support
- [ ] MySQL database quota sufficient
- [ ] SSL certificate available
- [ ] Domain pointed to hosting
- [ ] FTP/cPanel access ready

#### **Required Files:**
```bash
# Buat package deployment
tar -czf delicia-deploy.tar.gz \
  --exclude='database/' \
  --exclude='docs/' \
  --exclude='.git/' \
  --exclude='README.md' \
  .
```

### **Step 2: Upload Files**

#### **Via cPanel File Manager:**
1. Login ke cPanel
2. Buka "File Manager"
3. Navigate ke `public_html/`
4. Upload `delicia-deploy.tar.gz`
5. Extract files

#### **Via FTP/SFTP:**
```bash
# Upload via FTP
ftp your-server.com
# Login with credentials
cd public_html
put delicia-deploy.tar.gz
quit

# Or via rsync (recommended)
rsync -avz --exclude='database/' \
  --exclude='docs/' \
  --exclude='.git/' \
  ./ user@server:/public_html/
```

### **Step 3: Database Setup**

#### **Create Database via cPanel:**
1. Buka "MySQL Databases"
2. Buat database baru: `cpanel_user_delicia`
3. Buat database user
4. Assign user ke database dengan full privileges
5. Note credentials untuk configuration

#### **Import Database:**
```bash
# Via phpMyAdmin (cPanel)
# 1. Buka phpMyAdmin
# 2. Select database
# 3. Import database/delicia_by_dilla by.sql

# Via command line (jika tersedia)
mysql -h localhost -u db_user -p db_name < database/delicia_by_dilla.sql
```

### **Step 4: Configuration**

#### **Update Database Config:**
```php
<?php
// config/koneksi.php - Production settings
$host = "localhost";              // atau DB server hostname
$user = "cpanel_user_delicia";    // Database username
$pass = "secure_db_password";     // Database password  
$db = "cpanel_user_delicia";      // Database name

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    // Log error instead of displaying
    error_log("Database connection failed: " . mysqli_connect_error());
    die("Website sedang maintenance. Silakan coba lagi nanti.");
}

mysqli_set_charset($conn, "utf8");
?>
```

#### **Production .htaccess:**
```apache
# .htaccess - Production configuration
RewriteEngine On

# Redirect to HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Security headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

# PHP Security Settings
php_flag display_errors Off
php_flag log_errors On
php_value error_log /path/to/error.log

# File upload limits
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value max_execution_time 300
php_value memory_limit 256M

# Directory protection
Options -Indexes
DirectoryIndex index.php

# Protect sensitive files
<Files "config/koneksi.php">
    Order Allow,Deny
    Deny from all
</Files>

<Files "*.log">
    Order Allow,Deny
    Deny from all
</Files>

# Block unwanted requests
RewriteCond %{REQUEST_METHOD} ^(TRACE|DELETE|TRACK) [NC]
RewriteRule .* - [F]
```

### **Step 5: SSL Configuration**

#### **Install SSL Certificate:**
```bash
# Via cPanel SSL/TLS
# 1. Buka "SSL/TLS"
# 2. Install Let's Encrypt (free) atau upload custom certificate
# 3. Force HTTPS redirect

# Manual SSL verification
openssl s_client -connect yourdomain.com:443 -servername yourdomain.com
```

---

## ☁️ VPS/Cloud Deployment

### **Step 1: Server Setup**

#### **Ubuntu 20.04/22.04 Server:**
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install LAMP stack
sudo apt install apache2 mysql-server php8.1 -y
sudo apt install php8.1-mysqli php8.1-gd php8.1-mbstring php8.1-curl -y

# Install additional tools
sudo apt install unzip git certbot python3-certbot-apache -y

# Enable Apache modules
sudo a2enmod rewrite headers ssl
sudo systemctl restart apache2
```

#### **Configure Apache Virtual Host:**
```apache
# /etc/apache2/sites-available/delicia.conf
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/html/delicia-by-dilla
    
    <Directory /var/www/html/delicia-by-dilla>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/delicia_error.log
    CustomLog ${APACHE_LOG_DIR}/delicia_access.log combined
</VirtualHost>

# Enable site
sudo a2ensite delicia.conf
sudo systemctl reload apache2
```

### **Step 2: Secure MySQL Installation**

```bash
# Secure MySQL
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p
```

```sql
-- Create production database
CREATE DATABASE delicia_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create dedicated user
CREATE USER 'delicia_user'@'localhost' IDENTIFIED BY 'very_secure_password_here';
GRANT ALL PRIVILEGES ON delicia_production.* TO 'delicia_user'@'localhost';
FLUSH PRIVILEGES;

-- Import data
USE delicia_production;
SOURCE /path/to/database/delicia_by_dilla.sql;

EXIT;
```

### **Step 3: Deploy Application**

```bash
# Clone repository
cd /var/www/html/
sudo git clone https://github.com/username/delicia-by-dilla.git
cd delicia-by-dilla

# Set proper permissions
sudo chown -R www-data:www-data /var/www/html/delicia-by-dilla
sudo find /var/www/html/delicia-by-dilla -type f -exec chmod 644 {} \;
sudo find /var/www/html/delicia-by-dilla -type d -exec chmod 755 {} \;

# Make assets writable
sudo chmod -R 775 /var/www/html/delicia-by-dilla/assets/img/
sudo chown -R www-data:www-data /var/www/html/delicia-by-dilla/assets/img/

# Secure config file
sudo chmod 600 /var/www/html/delicia-by-dilla/config/koneksi.php
```

### **Step 4: SSL Certificate**

```bash
# Install Let's Encrypt SSL
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com

# Verify SSL renewal
sudo certbot renew --dry-run

# Setup auto-renewal crontab
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

---

## 🐳 Docker Deployment

### **Step 1: Create Dockerfile**

```dockerfile
# Dockerfile
FROM php:8.1-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    docker-php-ext-enable mysqli

# Install additional tools
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Enable Apache modules
RUN a2enmod rewrite headers

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/ && \
    chmod -R 755 /var/www/html/ && \
    chmod -R 775 /var/www/html/assets/img/

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
```

### **Step 2: Docker Compose Setup**

```yaml
# docker-compose.yml
version: '3.8'

services:
  web:
    build: .
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./assets/img:/var/www/html/assets/img
      - ./logs:/var/log/apache2
    depends_on:
      - db
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html
    
  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: delicia_by_dilla
      MYSQL_USER: delicia_user
      MYSQL_PASSWORD: user_password
    volumes:
      - mysql_data:/var/lib/mysql
      - ./database/delicia_by_dilla.sql:/docker-entrypoint-initdb.d/init.sql
    ports:
      - "3306:3306"

  phpmyadmin:
    image: phpmyadmin:latest
    environment:
      PMA_HOST: db
      PMA_USER: root
      PMA_PASSWORD: root_password
    ports:
      - "8080:80"
    depends_on:
      - db

volumes:
  mysql_data:
```

### **Step 3: Deploy with Docker**

```bash
# Build and run
docker-compose up -d

# Check status
docker-compose ps

# View logs
docker-compose logs -f web

# Update deployment
docker-compose pull
docker-compose up -d --build
```

---

## 🔒 Security Hardening

### **Production Security Checklist:**

#### **File Permissions:**
```bash
# Set secure permissions
find /var/www/html/delicia-by-dilla -type f -exec chmod 644 {} \;
find /var/www/html/delicia-by-dilla -type d -exec chmod 755 {} \;

# Secure sensitive files
chmod 600 config/koneksi.php
chmod 600 .env (if exists)

# Writable directories only
chmod 775 assets/img/
chown www-data:www-data assets/img/
```

#### **Remove Development Files:**
```bash
# Remove unnecessary files for production
rm -rf database/
rm -rf docs/
rm -rf .git/
rm README.md
rm docker-compose.yml
rm Dockerfile
```

#### **Database Security:**
```sql
-- Remove default accounts
DELETE FROM mysql.user WHERE User='';
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');

-- Update admin password
UPDATE users SET password = MD5('new_secure_admin_password') WHERE username = 'admin';

-- Remove demo user (optional)
DELETE FROM users WHERE username = 'dilla';
```

#### **Web Server Hardening:**
```apache
# Additional security headers
Header always set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';"
Header always set X-Permitted-Cross-Domain-Policies "none"
Header always set Feature-Policy "camera 'none'; microphone 'none'; geolocation 'self'"

# Hide server information
ServerTokens Prod
ServerSignature Off
```

---

## 📊 Performance Optimization

### **PHP Optimization:**
```ini
# php.ini production settings
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 10M
post_max_size = 10M
max_input_vars = 3000

# OPcache for better performance
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.validate_timestamps=0  # Production only
```

### **MySQL Performance:**
```ini
# my.cnf optimizations
[mysqld]
innodb_buffer_pool_size = 512M
query_cache_size = 64M
key_buffer_size = 64M
tmp_table_size = 64M
max_heap_table_size = 64M
innodb_log_file_size = 64M
```

### **Apache Performance:**
```apache
# Enable compression
LoadModule deflate_module modules/mod_deflate.so
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
</IfModule>

# Enable caching
LoadModule expires_module modules/mod_expires.so
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/pdf "access plus 1 month"
    ExpiresByType text/javascript "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

---

## 📈 Monitoring & Maintenance

### **Log Monitoring:**
```bash
# Monitor error logs
tail -f /var/log/apache2/delicia_error.log

# Monitor access logs
tail -f /var/log/apache2/delicia_access.log

# Monitor MySQL logs
tail -f /var/log/mysql/error.log
```

### **Automated Backups:**
```bash
#!/bin/bash
# backup.sh
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/delicia"

# Database backup
mysqldump -u delicia_user -p'password' delicia_production > $BACKUP_DIR/db_$DATE.sql

# Files backup
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/html/delicia-by-dilla

# Clean old backups (keep 7 days)
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

# Setup cron for daily backup
# 0 2 * * * /path/to/backup.sh
```

### **Health Check Script:**
```bash
#!/bin/bash
# health-check.sh
URL="https://yourdomain.com"
STATUS=$(curl -o /dev/null -s -w "%{http_code}" $URL)

if [ $STATUS -eq 200 ]; then
    echo "Site is UP - Status: $STATUS"
else
    echo "Site is DOWN - Status: $STATUS"
    # Send notification (email/slack/etc)
fi
```

---

## 🚀 Deployment Checklist

### **Pre-Deployment:**
- [ ] Code tested in staging environment
- [ ] Database migrations prepared
- [ ] SSL certificate ready
- [ ] Domain DNS configured
- [ ] Hosting resources allocated
- [ ] Backup strategy planned

### **Deployment:**
- [ ] Files uploaded successfully
- [ ] Database imported and configured
- [ ] Configuration files updated
- [ ] Permissions set correctly
- [ ] SSL certificate installed
- [ ] Security headers configured

### **Post-Deployment:**
- [ ] Application accessible via domain
- [ ] Admin login working
- [ ] User registration/login working
- [ ] All features tested
- [ ] Performance optimized
- [ ] Monitoring configured
- [ ] Backup automation setup

### **Go-Live:**
- [ ] Change default passwords
- [ ] Remove demo data
- [ ] Configure store settings
- [ ] Test all critical functions
- [ ] Monitor for 24 hours
- [ ] Document any issues

---

## 🆘 Troubleshooting

### **Common Deployment Issues:**

#### **1. Database Connection Errors:**
```bash
# Check database service
sudo systemctl status mysql

# Verify credentials
mysql -u delicia_user -p delicia_production

# Check firewall (if applicable)
sudo ufw status
```

#### **2. File Permission Issues:**
```bash
# Reset permissions
sudo chown -R www-data:www-data /var/www/html/delicia-by-dilla
sudo chmod -R 755 /var/www/html/delicia-by-dilla
sudo chmod -R 775 /var/www/html/delicia-by-dilla/assets/img/
```

#### **3. SSL Certificate Problems:**
```bash
# Check certificate status
sudo certbot certificates

# Renew certificate
sudo certbot renew

# Test SSL configuration
openssl s_client -connect yourdomain.com:443
```

#### **4. Performance Issues:**
```bash
# Check server resources
htop
df -h
iostat

# Monitor logs for errors
sudo journalctl -u apache2 -f
```

---

## 📞 Support & Maintenance

### **Production Support:**
- Monitor logs daily
- Apply security updates monthly
- Database optimization quarterly
- Full backup verification monthly
- SSL certificate renewal (automated)

### **Contact for Issues:**
- **Developer**: dillasardilla387@gmail.com
- **Documentation**: Check all docs/ files
- **Emergency**: Include server logs and error messages

---

**📦 Deployment Guide**  
Created by: Sardilla (202312071)  
Last Updated: Juli 2025  
Version: 1.0.0
