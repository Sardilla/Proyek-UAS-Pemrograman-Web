# 📖 API Documentation - Delicia by Dilla

## 📋 **Overview**

Dokumentasi ini menjelaskan struktur aplikasi, endpoint, dan flow data dalam sistem Delicia by Dilla. Aplikasi menggunakan arsitektur MVC sederhana dengan PHP native.

---

## 🏗️ **Arsitektur Aplikasi**

```
┌─────────────────────────────────────────────────────┐
│                 CLIENT SIDE                         │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐ │
│  │   HTML5     │  │    CSS3     │  │ JavaScript  │ │
│  └─────────────┘  └─────────────┘  └─────────────┘ │
└─────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────┐
│                SERVER SIDE                          │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐ │
│  │ Controllers │  │    Models   │  │    Views    │ │
│  │ (PHP Files) │  │ (DB Queries)│  │ (Templates) │ │
│  └─────────────┘  └─────────────┘  └─────────────┘ │
└─────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────┐
│                 DATABASE                            │
│               MySQL 5.7+                           │
│            delicia_by_dilla                         │
└─────────────────────────────────────────────────────┘
```

---

## 🚪 **Authentication Endpoints**

### **POST /cek_login.php**
Login user ke sistem

**Request:**
```http
POST /cek_login.php
Content-Type: application/x-www-form-urlencoded

username=admin&password=admin123
```

**Response Success:**
```php
// Redirect based on role
if ($role == 'admin') {
    header("Location: admin/dashboard.php");
} else {
    header("Location: user/dashboard.php");
}
```

**Response Error:**
```javascript
// JavaScript alert
alert("Username atau password salah!");
```

---

### **GET /logout.php**
Logout user dari sistem

**Request:**
```http
GET /logout.php
```

**Response:**
```php
session_destroy();
header("Location: login.php");
```

---

## 👑 **Admin Endpoints**

### **Dashboard**

#### **GET /admin/dashboard.php**
Halaman utama admin dengan statistik

**Response Data:**
```php
$data = [
    'jumlah_user' => mysqli_num_rows($result_users),
    'jumlah_produk' => mysqli_num_rows($result_products),
    'jumlah_transaksi' => mysqli_num_rows($result_transactions)
];
```

---

### **User Management**

#### **GET /admin/data_user.php**
Menampilkan semua user

**SQL Query:**
```sql
SELECT * FROM users WHERE role='user' ORDER BY id DESC
```

#### **POST /admin/tambah_user.php**
Menambah user baru

**Request:**
```http
POST /admin/tambah_user.php
Content-Type: application/x-www-form-urlencoded

nama_lengkap=John Doe&username=johndoe&password=123456&role=user
```

**SQL Query:**
```sql
INSERT INTO users (nama_lengkap, username, password, role) 
VALUES (?, ?, MD5(?), ?)
```

#### **POST /admin/edit_user.php**
Edit data user

**Request:**
```http
POST /admin/edit_user.php?id=1
Content-Type: application/x-www-form-urlencoded

nama_lengkap=Jane Doe&username=janedoe
```

#### **GET /admin/hapus_user.php?id={id}**
Hapus user

**SQL Query:**
```sql
DELETE FROM users WHERE id = ?
```

---

### **Product Management**

#### **GET /admin/data_produk.php**
Menampilkan semua produk

**SQL Query:**
```sql
SELECT p.*, k.nama_kategori 
FROM produk p 
LEFT JOIN kategori k ON p.id_kategori = k.id_kategori 
ORDER BY p.id_produk DESC
```

#### **POST /admin/tambah_produk.php**
Menambah produk baru

**Request:**
```http
POST /admin/tambah_produk.php
Content-Type: multipart/form-data

nama_produk=Chocolate Cake
deskripsi=Delicious chocolate cake
harga=150000
stok=10
id_kategori=1
gambar=[FILE]
```

**File Upload:**
- Directory: `assets/img/`
- Allowed: JPG, PNG, GIF
- Max size: 2MB

---

### **Transaction Management**

#### **GET /admin/data_transaksi.php**
Menampilkan semua transaksi

**SQL Query:**
```sql
SELECT t.*, u.nama_lengkap 
FROM transaksi t 
LEFT JOIN users u ON t.id_user = u.id 
ORDER BY t.tanggal DESC
```

#### **GET /admin/detail_transaksi.php?id={id}**
Detail transaksi

**SQL Query:**
```sql
SELECT dt.*, p.nama_produk, p.gambar 
FROM detail_transaksi dt 
LEFT JOIN produk p ON dt.id_produk = p.id_produk 
WHERE dt.id_transaksi = ?
```

---

## 👤 **User Endpoints**

### **Dashboard**

#### **GET /user/dashboard.php**
Halaman utama user

**Response Data:**
```php
$data = [
    'username' => $_SESSION['user']['username'],
    'jumlah_produk' => $total_products,
    'jumlah_transaksi_user' => $user_transactions
];
```

---

### **Product Catalog**

#### **GET /user/detail_produk.php**
Katalog produk untuk user

**SQL Query:**
```sql
SELECT p.*, k.nama_kategori 
FROM produk p 
LEFT JOIN kategori k ON p.id_kategori = k.id_kategori 
WHERE p.stok > 0 
ORDER BY p.nama_produk ASC
```

#### **GET /user/lihat_produk.php?id={id}**
Detail single produk

**SQL Query:**
```sql
SELECT p.*, k.nama_kategori 
FROM produk p 
LEFT JOIN kategori k ON p.id_kategori = k.id_kategori 
WHERE p.id_produk = ?
```

---

### **Shopping Cart**

#### **POST /user/keranjang.php**
Tambah item ke keranjang

**Request:**
```http
POST /user/keranjang.php
Content-Type: application/x-www-form-urlencoded

action=add&id_produk=1&jumlah=2
```

**SQL Query:**
```sql
INSERT INTO keranjang (id_user, id_produk, jumlah) 
VALUES (?, ?, ?) 
ON DUPLICATE KEY UPDATE jumlah = jumlah + VALUES(jumlah)
```

#### **GET /user/keranjang.php**
Lihat isi keranjang

**SQL Query:**
```sql
SELECT k.*, p.nama_produk, p.harga, p.gambar 
FROM keranjang k 
LEFT JOIN produk p ON k.id_produk = p.id_produk 
WHERE k.id_user = ?
```

---

### **Checkout Process**

#### **POST /user/checkout.php**
Proses checkout

**Request:**
```http
POST /user/checkout.php
Content-Type: application/x-www-form-urlencoded

metode_pembayaran=transfer&alamat_pengiriman=Jl. Example No. 123
```

**SQL Queries:**
```sql
-- 1. Create transaction
INSERT INTO transaksi (id_user, tanggal, total, status) VALUES (?, NOW(), ?, 'pending')

-- 2. Move cart to transaction details
INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, harga) 
SELECT ?, id_produk, jumlah, (SELECT harga FROM produk WHERE id_produk = k.id_produk) 
FROM keranjang k WHERE id_user = ?

-- 3. Update stock
UPDATE produk p 
SET stok = stok - (SELECT jumlah FROM keranjang WHERE id_produk = p.id_produk AND id_user = ?) 
WHERE EXISTS (SELECT 1 FROM keranjang WHERE id_produk = p.id_produk AND id_user = ?)

-- 4. Clear cart
DELETE FROM keranjang WHERE id_user = ?
```

---

## 📊 **Database Schema**

### **Tabel Users**
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user'
);
```

### **Tabel Kategori**
```sql
CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);
```

### **Tabel Produk**
```sql
CREATE TABLE produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga INT NOT NULL,
    stok INT NOT NULL,
    gambar VARCHAR(100),
    id_kategori INT,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
);
```

### **Tabel Keranjang**
```sql
CREATE TABLE keranjang (
    id_keranjang INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_produk INT,
    jumlah INT NOT NULL,
    tanggal_ditambahkan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
);
```

### **Tabel Transaksi**
```sql
CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    tanggal DATE NOT NULL,
    total INT NOT NULL,
    status ENUM('pending','diproses','selesai','dibatalkan') DEFAULT 'pending',
    FOREIGN KEY (id_user) REFERENCES users(id)
);
```

### **Tabel Detail Transaksi**
```sql
CREATE TABLE detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    id_produk INT,
    jumlah INT NOT NULL,
    harga INT NOT NULL,
    FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi),
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
);
```

---

## 🔐 **Security Features**

### **Session Management**
```php
// auth.php
session_start();

function checkLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: ../login.php");
        exit;
    }
}

function checkRole($required_role) {
    checkLogin();
    if ($_SESSION['user']['role'] !== $required_role) {
        header("Location: ../login.php");
        exit;
    }
}
```

### **SQL Injection Prevention**
```php
// Prepared statements example
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = MD5(?)");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
```

### **XSS Prevention**
```php
// Output sanitization
echo htmlspecialchars($user_input, ENT_QUOTES, 'UTF-8');
```

### **File Upload Security**
```php
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
$max_size = 2 * 1024 * 1024; // 2MB

$file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
if (!in_array($file_ext, $allowed_types)) {
    die("File type not allowed");
}

if ($_FILES['gambar']['size'] > $max_size) {
    die("File too large");
}
```

---

## 📝 **Response Formats**

### **Success Response**
```php
// For redirects
header("Location: success_page.php?message=success");

// For AJAX (if implemented)
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Operation completed successfully',
    'data' => $result
]);
```

### **Error Response**
```php
// For redirects with error
header("Location: form_page.php?error=invalid_data");

// For AJAX (if implemented)
header('Content-Type: application/json');
http_response_code(400);
echo json_encode([
    'status' => 'error',
    'message' => 'Invalid input data',
    'errors' => $validation_errors
]);
```

---

## 🧪 **Testing Endpoints**

### **Manual Testing**

1. **Test Authentication:**
```bash
# Valid admin login
curl -X POST http://localhost/Delicia-by-Dilla/cek_login.php \
  -d "username=admin&password=admin123"

# Invalid login
curl -X POST http://localhost/Delicia-by-Dilla/cek_login.php \
  -d "username=wrong&password=wrong"
```

2. **Test Admin Dashboard:**
```bash
# Access admin dashboard (requires session)
curl http://localhost/Delicia-by-Dilla/admin/dashboard.php \
  -b "PHPSESSID=your_session_id"
```

3. **Test Product API:**
```bash
# Add product (multipart form)
curl -X POST http://localhost/Delicia-by-Dilla/admin/tambah_produk.php \
  -F "nama_produk=Test Cake" \
  -F "deskripsi=Test Description" \
  -F "harga=100000" \
  -F "stok=5" \
  -F "id_kategori=1" \
  -F "gambar=@test_image.jpg" \
  -b "PHPSESSID=your_session_id"
```

---

## 🔄 **Data Flow Examples**

### **User Shopping Flow**
```
1. User Login → Session Created
2. Browse Products → SELECT from produk table
3. Add to Cart → INSERT/UPDATE keranjang table
4. Checkout → 
   a. INSERT into transaksi
   b. INSERT into detail_transaksi
   c. UPDATE produk stock
   d. DELETE from keranjang
5. View Transaction → SELECT from transaksi + detail_transaksi
```

### **Admin Management Flow**
```
1. Admin Login → Session Created with role='admin'
2. View Dashboard → COUNT queries on multiple tables
3. Add Product →
   a. Upload image to assets/img/
   b. INSERT into produk table
4. Manage Orders →
   a. VIEW all transaksi
   b. UPDATE status if needed
```

---

## 🐛 **Common API Errors**

### **Authentication Errors**
- `401 Unauthorized`: Session expired or invalid
- `403 Forbidden`: Insufficient permissions (role-based)

### **Validation Errors**
- `400 Bad Request`: Missing required fields
- `422 Unprocessable Entity`: Invalid data format

### **Server Errors**
- `500 Internal Server Error`: Database connection issues
- `503 Service Unavailable`: Server maintenance

---

## 📈 **Performance Considerations**

### **Database Optimization**
```sql
-- Add indexes for better query performance
CREATE INDEX idx_produk_kategori ON produk(id_kategori);
CREATE INDEX idx_transaksi_user ON transaksi(id_user);
CREATE INDEX idx_keranjang_user ON keranjang(id_user);
```

### **Caching Strategies**
```php
// Simple session-based caching for product categories
if (!isset($_SESSION['categories'])) {
    $_SESSION['categories'] = mysqli_fetch_all(
        mysqli_query($conn, "SELECT * FROM kategori"), 
        MYSQLI_ASSOC
    );
}
```

---

**API Documentation - Delicia by Dilla**  
*Last Updated: 19 Juli 2025*
