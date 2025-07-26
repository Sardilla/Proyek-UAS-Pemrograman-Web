# 🚀 Installation Guide - Delicia by Dilla

## 📋 Overview

Panduan lengkap untuk menginstal dan mengkonfigurasi aplikasi toko kue online "Delicia by Dilla" di environment lokal atau server.

---

## 💾 System Requirements

### **Minimum Requirements:**
- **Operating System**: Windows 10/11, macOS 10.14+, Linux Ubuntu 18.04+
- **Web Server**: Apache 2.4+
- **PHP**: 8.0+ dengan extensions:
  - `mysqli`
  - `gd` (untuk image processing)
  - `mbstring`
  - `session`
- **MySQL**: 5.7+ atau MariaDB 10.2+
- **RAM**: 512 MB
- **Storage**: 100 MB free space
- **Browser**: Chrome 90+, Firefox 88+, Safari 14+, Edge 90+

### **Recommended:**
- **PHP**: 8.1+
- **MySQL**: 8.0+
- **RAM**: 1 GB+
- **SSD Storage**: 500 MB+

---

## 🛠️ Pre-Installation

### **A. Install XAMPP (Windows/macOS/Linux)**

1. **Download XAMPP**
   - Kunjungi: https://www.apachefriends.org/
   - Download versi terbaru untuk OS Anda

2. **Install XAMPP**
   ```bash
   # Windows: Jalankan installer .exe
   # macOS: Mount .dmg dan drag ke Applications
   # Linux: 
   chmod +x xampp-linux-*-installer.run
   sudo ./xampp-linux-*-installer.run
   ```

3. **Start Services**
   - Buka XAMPP Control Panel
   - Start Apache dan MySQL

### **B. Alternative: Manual Installation**

#### **Apache Setup:**
```bash
# Ubuntu/Debian
sudo apt update
sudo apt install apache2

# CentOS/RHEL
sudo yum install httpd
sudo systemctl start httpd
sudo systemctl enable httpd
```

#### **PHP Setup:**
```bash
# Ubuntu/Debian
sudo apt install php php-mysqli php-gd php-mbstring

# CentOS/RHEL
sudo yum install php php-mysqli php-gd php-mbstring
```

#### **MySQL Setup:**
```bash
# Ubuntu/Debian
sudo apt install mysql-server
sudo mysql_secure_installation

# CentOS/RHEL
sudo yum install mysql-server
sudo systemctl start mysqld
sudo systemctl enable mysqld
```

---

## 📁 Project Installation

### **Step 1: Download Project Files**

#### **Option A: Git Clone (Recommended)**
```bash
# Clone repository
git clone https://github.com/username/delicia-by-dilla.git
cd delicia-by-dilla
```

#### **Option B: Manual Download**
1. Download ZIP file dari repository
2. Extract ke folder pilihan
3. Rename folder menjadi `delicia-by-dilla`

### **Step 2: Move to Web Directory**

#### **XAMPP (Windows):**
```cmd
# Copy project ke htdocs
xcopy /E /I "delicia-by-dilla" "C:\xampp\htdocs\delicia-by-dilla"
```

#### **XAMPP (macOS/Linux):**
```bash
# Copy project ke htdocs
cp -r delicia-by-dilla /Applications/XAMPP/htdocs/
# atau
sudo cp -r delicia-by-dilla /opt/lampp/htdocs/
```

#### **Apache (Linux):**
```bash
# Copy ke web directory
sudo cp -r delicia-by-dilla /var/www/html/
sudo chown -R www-data:www-data /var/www/html/delicia-by-dilla
sudo chmod -R 755 /var/www/html/delicia-by-dilla
```

### **Step 3: Set Permissions**

#### **Windows (XAMPP):**
- Tidak diperlukan setup khusus
- Pastikan folder dapat diakses oleh Apache

#### **macOS/Linux:**
```bash
# Set proper permissions
sudo chown -R apache:apache /path/to/delicia-by-dilla
# atau untuk www-data
sudo chown -R www-data:www-data /path/to/delicia-by-dilla

# Set folder permissions
sudo chmod -R 755 /path/to/delicia-by-dilla

# Set file permissions
sudo find /path/to/delicia-by-dilla -type f -exec chmod 644 {} \;

# Make assets writable (untuk upload gambar)
sudo chmod -R 777 /path/to/delicia-by-dilla/assets/img/
```

---

## 🗄️ Database Setup

### **Step 1: Create Database**

#### **Via phpMyAdmin (Recommended):**
1. Buka browser: `http://localhost/phpmyadmin`
2. Login dengan:
   - **Username**: `root`
   - **Password**: (kosong untuk XAMPP default)
3. Klik "New" di sidebar kiri
4. Nama database: `delicia_by_dilla`
5. Collation: `utf8_general_ci`
6. Klik "Create"

#### **Via MySQL Command Line:**
```sql
-- Login ke MySQL
mysql -u root -p

-- Buat database
CREATE DATABASE delicia_by_dilla CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Buat user khusus (optional)
CREATE USER 'dilla_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON delicia_by_dilla.* TO 'dilla_user'@'localhost';
FLUSH PRIVILEGES;

-- Keluar
EXIT;
```

### **Step 2: Import Database Schema**

#### **Via phpMyAdmin:**
1. Pilih database `delicia_by_dilla`
2. Klik tab "Import"
3. Klik "Choose File"
4. Pilih file: `database/delicia_by_dilla.sql`
5. Klik "Go"

#### **Via Command Line:**
```bash
# Import database
mysql -u root -p delicia_by_dilla < database/delicia_by_dilla.sql

# Atau dengan user khusus
mysql -u dilla_user -p delicia_by_dilla < database/delicia_by_dilla.sql
```

### **Step 3: Verify Database Import**
```sql
-- Login dan cek database
mysql -u root -p
USE delicia_by_dilla;
SHOW TABLES;

-- Cek data sample
SELECT * FROM users;
SELECT * FROM kategori;
SELECT * FROM produk;
```

---

## ⚙️ Configuration

### **Step 1: Database Configuration**

Edit file `config/koneksi.php`:

```php
<?php
// Database configuration
$host = "localhost";        // Database host
$user = "root";             // Database username
$pass = "";                 // Database password (kosong untuk XAMPP)
$db = "delicia_by_dilla";   // Database name

// Alternative untuk production
/*
$host = "localhost";
$user = "dilla_user";
$pass = "secure_password";
$db = "delicia_by_dilla";
*/

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8");
?>
```

### **Step 2: PHP Configuration**

Buat/edit file `.htaccess` di root directory:

```apache
# .htaccess
RewriteEngine On

# Security headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
</IfModule>

# PHP Settings
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value max_execution_time 300
php_value memory_limit 256M

# Error reporting (disable in production)
php_flag display_errors Off
php_flag log_errors On

# Directory protection
Options -Indexes
```

### **Step 3: Directory Structure Verification**

Pastikan struktur folder benar:
```
delicia-by-dilla/
├── admin/          ✅
├── user/           ✅
├── assets/         ✅
│   ├── css/        ✅
│   ├── img/        ✅ (writable)
│   └── js/         ✅
├── config/         ✅
├── database/       ✅
├── docs/           ✅
├── includes/       ✅
├── index.php       ✅
├── login.php       ✅
├── register.php    ✅
└── README.md       ✅
```

---

## 🧪 Testing Installation

### **Step 1: Basic Functionality Test**

1. **Akses aplikasi:**
   ```
   http://localhost/delicia-by-dilla
   ```

2. **Test database connection:**
   - Halaman seharusnya load tanpa error
   - Tidak ada pesan "Koneksi gagal"

### **Step 2: Login Test**

#### **Test Admin Login:**
- URL: `http://localhost/delicia-by-dilla/login.php`
- Username: `admin`
- Password: `admin123`
- Expected: Redirect ke admin dashboard

#### **Test User Login:**
- Username: `dilla`
- Password: `user123`
- Expected: Redirect ke user dashboard

### **Step 3: Feature Testing**

#### **Admin Features:**
- ✅ Dashboard statistics
- ✅ Product management (CRUD)
- ✅ User management
- ✅ Transaction monitoring
- ✅ Reports generation

#### **User Features:**
- ✅ Product browsing
- ✅ Shopping cart
- ✅ Checkout process
- ✅ Transaction history
- ✅ Product reviews

---

## ⚠️ Troubleshooting

### **Common Issues:**

#### **1. Database Connection Error**
```
Error: "Koneksi gagal: Access denied for user"
```
**Solution:**
- Periksa kredensial di `config/koneksi.php`
- Pastikan MySQL service berjalan
- Reset password MySQL jika perlu

#### **2. Permission Denied**
```
Error: "Warning: fopen(): Permission denied"
```
**Solution:**
```bash
# Linux/macOS
sudo chmod -R 755 /path/to/delicia-by-dilla
sudo chown -R www-data:www-data /path/to/delicia-by-dilla

# Khusus folder assets/img
sudo chmod -R 777 /path/to/delicia-by-dilla/assets/img/
```

#### **3. PHP Extensions Missing**
```
Error: "Fatal error: Uncaught Error: Call to undefined function mysqli_connect()"
```
**Solution:**
```bash
# Ubuntu/Debian
sudo apt install php-mysqli
sudo systemctl restart apache2

# Enable di php.ini
extension=mysqli
```

#### **4. Session Issues**
```
Error: "Warning: session_start(): Cannot send session"
```
**Solution:**
- Periksa session folder permissions
- Clear browser cache
- Restart web server

### **Debug Mode:**

Untuk development, enable error reporting di `config/koneksi.php`:

```php
<?php
// Enable error reporting (hanya untuk development)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Database connection code...
?>
```

---

## 🔧 Post-Installation

### **Step 1: Change Default Passwords**

#### **Admin Password:**
1. Login sebagai admin
2. Buka menu "Pengaturan" atau "Profil"
3. Ganti password default
4. Atau via database:
```sql
UPDATE users SET password = MD5('new_password') WHERE username = 'admin';
```

#### **Database User (Production):**
```sql
-- Ganti password database user
ALTER USER 'dilla_user'@'localhost' IDENTIFIED BY 'new_secure_password';
FLUSH PRIVILEGES;
```

### **Step 2: Configure Store Settings**

1. Login sebagai admin
2. Buka menu "Pengaturan Toko"
3. Update informasi:
   - Nama toko
   - Deskripsi
   - Kontak/alamat
   - Logo toko

### **Step 3: Add Products**

1. Buka menu "Kategori"
   - Tambah/edit kategori produk
2. Buka menu "Produk"
   - Tambah produk baru
   - Upload gambar produk
   - Set harga dan stok

### **Step 4: Security Hardening**

#### **Production Environment:**
1. **Disable error reporting:**
   ```php
   error_reporting(0);
   ini_set('display_errors', 0);
   ```

2. **Secure file permissions:**
   ```bash
   find /path/to/app -type f -exec chmod 644 {} \;
   find /path/to/app -type d -exec chmod 755 {} \;
   chmod 600 config/koneksi.php
   ```

3. **Remove unnecessary files:**
   ```bash
   rm -rf database/
   rm -rf docs/
   rm README.md
   ```

---

## 📊 Performance Optimization

### **PHP Optimization:**
```ini
; php.ini optimizations
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 10M
post_max_size = 10M
max_input_vars = 3000

; OPcache (if available)
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=4000
```

### **MySQL Optimization:**
```ini
; my.cnf optimizations
[mysqld]
innodb_buffer_pool_size = 256M
query_cache_size = 32M
key_buffer_size = 32M
tmp_table_size = 32M
max_heap_table_size = 32M
```

---

## ✅ Installation Checklist

- [ ] XAMPP/Web server installed and running
- [ ] PHP 8.0+ with required extensions
- [ ] MySQL 5.7+ installed and running
- [ ] Project files downloaded and placed correctly
- [ ] Folder permissions set properly
- [ ] Database created and imported successfully
- [ ] Database configuration updated
- [ ] Application accessible via browser
- [ ] Admin login working
- [ ] User login working
- [ ] All main features tested
- [ ] Default passwords changed
- [ ] Store settings configured
- [ ] Products added successfully

---

## 🆘 Getting Help

Jika mengalami masalah selama instalasi:

1. **Check Documentation:**
   - [Database Guide](Database.md)
   - [Usage Guide](Usage.md)
   - [Deployment Guide](Deployment.md)

2. **Common Solutions:**
   - Restart web server dan MySQL
   - Clear browser cache
   - Check file permissions
   - Verify database credentials

3. **Contact Developer:**
   - Email: dillasardilla387@gmail.com
   - Include error messages dan screenshots

---

**🚀 Installation Guide**  
Created by: Sardilla (202312071)  
Last Updated: Juli 2025  
Version: 1.0.0
