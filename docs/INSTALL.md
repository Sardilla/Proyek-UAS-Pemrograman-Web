# 🔧 Panduan Instalasi Lengkap - Delicia by Dilla

## 📋 **Daftar Isi**
1. [Prasyarat Sistem](#prasyarat-sistem)
2. [Instalasi XAMPP](#instalasi-xampp)
3. [Setup Proyek](#setup-proyek)
4. [Konfigurasi Database](#konfigurasi-database)
5. [Testing Instalasi](#testing-instalasi)
6. [Troubleshooting](#troubleshooting)

---

## 🖥️ **Prasyarat Sistem**

### **Windows:**
- Windows 10/11 (64-bit recommended)
- RAM minimal 4GB
- Storage kosong minimal 2GB
- Browser modern (Chrome, Firefox, Edge)

### **Software Requirements:**
- XAMPP 8.0+ atau
- PHP 8.0+ standalone
- MySQL 5.7+ atau MariaDB 10.4+
- Apache Web Server 2.4+

---

## 🚀 **Instalasi XAMPP**

### **Step 1: Download XAMPP**
1. Kunjungi: https://www.apachefriends.org/
2. Download XAMPP untuk Windows (PHP 8.0+)
3. File size sekitar 150MB

### **Step 2: Install XAMPP**
1. Run installer sebagai Administrator
2. Pilih komponen:
   - ✅ Apache
   - ✅ MySQL
   - ✅ PHP
   - ✅ phpMyAdmin
   - ⬜ FileZilla (optional)
   - ⬜ Mercury (optional)
3. Install location: `C:\xampp` (default)
4. Klik Install dan tunggu proses selesai

### **Step 3: Start Services**
1. Buka XAMPP Control Panel
2. Start service:
   - **Apache** → Klik Start
   - **MySQL** → Klik Start
3. Pastikan status menunjukkan "Running" (hijau)

---

## 📁 **Setup Proyek**

### **Step 1: Download Proyek**
```bash
# Jika menggunakan Git
git clone https://github.com/username/Delicia-by-Dilla.git

# Atau download ZIP dan extract
```

### **Step 2: Copy ke XAMPP Directory**
1. Buka folder: `C:\xampp\htdocs\`
2. Copy folder `Delicia-by-Dilla` ke dalam htdocs
3. Structure should be: `C:\xampp\htdocs\Delicia-by-Dilla\`

### **Step 3: Set Permissions** (jika di Linux/Mac)
```bash
chmod -R 755 /opt/lampp/htdocs/Delicia-by-Dilla
chown -R www-data:www-data /opt/lampp/htdocs/Delicia-by-Dilla
```

---

## 🗄️ **Konfigurasi Database**

### **Step 1: Akses phpMyAdmin**
1. Buka browser
2. Kunjungi: `http://localhost/phpmyadmin`
3. Login (default: username `root`, password kosong)

### **Step 2: Buat Database**
1. Klik tab **"Databases"**
2. Database name: `delicia_by_dilla`
3. Collation: `utf8_general_ci`
4. Klik **"Create"**

### **Step 3: Import Schema**
1. Pilih database `delicia_by_dilla`
2. Klik tab **"Import"**
3. Choose file: `sql/delicia_by_dilla.sql`
4. Format: **SQL**
5. Klik **"Go"**

### **Step 4: Verifikasi Tables**
Pastikan tabel berikut sudah terbuat:
- ✅ users
- ✅ kategori  
- ✅ produk
- ✅ keranjang
- ✅ transaksi
- ✅ detail_transaksi
- ✅ ulasan
- ✅ riwayat_pembelian
- ✅ aktivitas
- ✅ pengaturan

---

## ⚙️ **Konfigurasi Aplikasi**

### **Step 1: Database Connection**
Edit file: `config/koneksi.php`

```php
<?php
$host = "localhost";
$user = "root";          // MySQL username
$pass = "";              // MySQL password (kosong untuk XAMPP default)
$db = "delicia_by_dilla"; // Database name

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
```

### **Step 2: Session Configuration**
File sudah dikonfigurasi dengan benar di `auth.php`

### **Step 3: Upload Directory Permissions**
Pastikan folder `assets/img/` dapat ditulis:
```bash
# Windows (via Command Prompt as Admin)
icacls "C:\xampp\htdocs\Delicia-by-Dilla\assets\img" /grant Everyone:F

# Linux/Mac
chmod 777 assets/img/
```

---

## 🧪 **Testing Instalasi**

### **Step 1: Akses Homepage**
1. Buka browser
2. Kunjungi: `http://localhost/Delicia-by-Dilla`
3. Should redirect to login page

### **Step 2: Test Login Admin**
1. Username: `admin`
2. Password: `admin123`
3. Should access admin dashboard

### **Step 3: Test Login User**
1. Username: `dilla`
2. Password: `user123`
3. Should access user dashboard

### **Step 4: Test Database Connection**
Create file `test-db.php` in root:
```php
<?php
include 'config/koneksi.php';

if ($conn) {
    echo "✅ Database connection successful!";
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
    $row = mysqli_fetch_assoc($result);
    echo "<br>👥 Total users: " . $row['total'];
} else {
    echo "❌ Database connection failed!";
}
?>
```

Visit: `http://localhost/Delicia-by-Dilla/test-db.php`

---

## 🐛 **Troubleshooting**

### **Apache Won't Start**
**Error**: Port 80 sudah digunakan
```bash
# Windows - Check port usage
netstat -ano | findstr :80

# Solution 1: Change Apache port
# Edit: C:\xampp\apache\conf\httpd.conf
# Change: Listen 80 to Listen 8080

# Solution 2: Stop conflicting service
net stop http /y
```

**Error**: Permission denied
```bash
# Run XAMPP as Administrator
# Right-click XAMPP Control Panel → Run as Administrator
```

### **MySQL Won't Start**
**Error**: Port 3306 sudah digunakan
```bash
# Check MySQL service
services.msc
# Stop MySQL service if running

# Or change MySQL port in XAMPP
# Edit: C:\xampp\mysql\bin\my.ini
# Change: port = 3306 to port = 3307
```

### **Database Connection Error**
1. **Check MySQL service**:
   - XAMPP Control Panel → MySQL → Start

2. **Verify credentials**:
   ```php
   // config/koneksi.php
   $host = "localhost";    // or 127.0.0.1
   $user = "root";
   $pass = "";             // empty for XAMPP
   $db = "delicia_by_dilla";
   ```

3. **Test connection manually**:
   ```bash
   mysql -u root -p
   SHOW DATABASES;
   USE delicia_by_dilla;
   SHOW TABLES;
   ```

### **Session Issues**
1. **Check session directory**:
   ```php
   // Check in php.ini
   session.save_path = "C:/xampp/tmp"
   ```

2. **Clear browser cache and cookies**

3. **Restart Apache service**

### **File Upload Issues**
1. **Check upload directory permissions**:
   - `assets/img/` should be writable

2. **PHP upload limits**:
   ```ini
   # php.ini
   file_uploads = On
   upload_max_filesize = 50M
   post_max_size = 50M
   max_execution_time = 300
   ```

### **CSS/JS Not Loading**
1. **Check file paths**:
   ```html
   <!-- Correct -->
   <link rel="stylesheet" href="assets/css/style.css">
   
   <!-- Incorrect -->
   <link rel="stylesheet" href="/assets/css/style.css">
   ```

2. **Check file permissions**

3. **Clear browser cache**: Ctrl+F5

### **Display Errors for Development**
Add to top of PHP files for debugging:
```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
```

---

## 📊 **Post-Installation Checklist**

- ✅ XAMPP services running (Apache + MySQL)
- ✅ Database `delicia_by_dilla` created
- ✅ All tables imported successfully
- ✅ Admin login works (`admin`/`admin123`)
- ✅ User login works (`dilla`/`user123`)
- ✅ File upload directory writable
- ✅ No PHP errors displayed
- ✅ CSS and images loading correctly
- ✅ Database connection stable

---

## 🔄 **Updates & Maintenance**

### **Regular Maintenance**:
1. **Backup database** weekly
2. **Clear log files** monthly
3. **Update PHP/MySQL** as needed
4. **Monitor disk space**

### **Backup Database**:
```bash
# Command line backup
mysqldump -u root -p delicia_by_dilla > backup_$(date +%Y%m%d).sql

# Or use phpMyAdmin Export function
```

### **Update Application**:
1. Backup current files
2. Backup database
3. Download new version
4. Copy files (preserve `config/koneksi.php`)
5. Run database migrations if any
6. Test functionality

---

## 📞 **Bantuan Tambahan**

Jika masih mengalami masalah:
1. **Email**: dillasardilla387@gmail.com
2. **Check error logs**: 
   - Apache: `C:\xampp\apache\logs\error.log`
   - PHP: `C:\xampp\php\logs\php_error_log`
3. **Online resources**: 
   - XAMPP Documentation
   - PHP Manual
   - MySQL Documentation

---

**Happy Coding! 🚀**

*Panduan ini dibuat untuk memastikan instalasi yang sukses dan trouble-free.*
