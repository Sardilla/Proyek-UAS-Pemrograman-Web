-- Tabel Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user'
);

-- Tabel Kategori Produk
CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

-- Tabel Produk
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

-- Tabel Keranjang (User)
CREATE TABLE keranjang (
    id_keranjang INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_produk INT,
    jumlah INT NOT NULL,
    tanggal_ditambahkan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
);

-- Tabel Transaksi
CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    tanggal DATE NOT NULL,
    total INT NOT NULL,
    status ENUM('pending','diproses','selesai','dibatalkan') DEFAULT 'pending',
    FOREIGN KEY (id_user) REFERENCES users(id)
);

-- Tabel Detail Transaksi
CREATE TABLE detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    id_produk INT,
    jumlah INT NOT NULL,
    harga INT NOT NULL,
    FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi),
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
);

-- Tabel Ulasan Produk
CREATE TABLE ulasan (
    id_ulasan INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_produk INT,
    ulasan TEXT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
);

-- Tabel Riwayat Pembelian (untuk user)
CREATE TABLE riwayat_pembelian (
    id_riwayat INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_transaksi INT,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi)
);

-- Tabel Aktivitas Admin
CREATE TABLE aktivitas (
    id_aktivitas INT AUTO_INCREMENT PRIMARY KEY,
    id_admin INT,
    aktivitas TEXT,
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_admin) REFERENCES users(id)
);

-- Tabel Pengaturan Toko
CREATE TABLE pengaturan (
    id INT PRIMARY KEY,
    nama_toko VARCHAR(100),
    deskripsi TEXT,
    kontak VARCHAR(100)
);

-- Data Awal Pengaturan
INSERT INTO pengaturan (id, nama_toko, deskripsi, kontak) VALUES
(1, 'Delicia by Dilla', 'Toko kue rumahan handmade dan premium.', '0812-3456-7890');

-- Data Awal Admin
INSERT INTO users (nama_lengkap, username, password, role) VALUES
('Admin', 'admin', MD5('admin123'), 'admin');

-- Data Awal User
INSERT INTO users (nama_lengkap, username, password, role) VALUES
('Dilla', 'dilla', MD5('user123'), 'user');

-- Data Awal Kategori
INSERT INTO kategori (nama_kategori) VALUES
('Kue Ulang Tahun'),
('Kue Tradisional'),
('Roti & Pastry'),
('Cookies & Biscuit');

-- Data Awal Produk
INSERT INTO produk (nama_produk, deskripsi, harga, stok, gambar, id_kategori) VALUES
('Red Velvet Cake', 'Kue red velvet lembut dengan cream cheese frosting', 250000, 10, 'gambar1.jpg', 1),
('Chocolate Birthday Cake', 'Kue coklat spesial untuk ulang tahun', 200000, 15, 'gambar2.jpg', 1),
('Klepon', 'Kue tradisional isi gula merah dengan kelapa', 25000, 50, 'gambar3.jpg', 2),
('Croissant', 'Roti pastry mentega premium', 15000, 30, 'gambar4.jpg', 3),
('Chocolate Chip Cookies', 'Cookies renyah dengan coklat chip', 35000, 25, 'gambar5.jpg', 4);

-- Data Contoh Transaksi
INSERT INTO transaksi (id_user, tanggal, total, status) VALUES
(2, '2025-07-18', 75000, 'pending'),
(2, '2025-07-18', 205000, 'diproses'),
(2, '2025-07-17', 150000, 'selesai'),
(2, '2025-07-16', 50000, 'dibatalkan');

-- Data Contoh Detail Transaksi
INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, harga) VALUES
(1, 3, 3, 25000),
(2, 1, 1, 250000),
(3, 4, 10, 15000),
(4, 5, 2, 25000);
