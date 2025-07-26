# 🎯 Usage Guide - Delicia by Dilla

## 📋 Overview

Panduan lengkap penggunaan aplikasi "Delicia by Dilla" - sistem manajemen toko kue online. Dokumen ini mencakup tutorial step-by-step untuk Admin dan User dalam menggunakan semua fitur yang tersedia.

---

## 🚀 Getting Started

### **Akses Aplikasi**
- **URL Utama:** `http://localhost/delicia-by-dilla` (local) atau `http://yourdomain.com` (production)
- **Login Admin:** `http://localhost/delicia-by-dilla/login.php`
- **Registrasi User:** `http://localhost/delicia-by-dilla/register.php`

### **Default Credentials (Development)**
```
Admin:
- Username: admin
- Password: admin123

Demo User:
- Username: dilla  
- Password: user123
```

⚠️ **Penting:** Ganti password default setelah instalasi!

---

## 👑 Admin Panel - Complete Guide

### **🏠 Dashboard Admin**

#### **Akses Dashboard:**
1. Buka `http://yourdomain.com/login.php`
2. Login dengan kredensial admin
3. Anda akan diarahkan ke dashboard admin

#### **Fitur Dashboard:**
- **📊 Statistik Real-time:**
  - Total user terdaftar
  - Jumlah produk aktif
  - Transaksi hari ini
  - Revenue total

- **📈 Chart & Analytics:**
  - Grafik penjualan bulanan
  - Produk terlaris
  - Status transaksi terkini

- **🔔 Notifikasi:**
  - Pesanan baru yang masuk
  - Stok produk yang menipis
  - Review produk terbaru

### **👥 Manajemen User**

#### **Melihat Daftar User:**
1. Klik menu "**Data User**" di sidebar
2. Lihat tabel semua user yang terdaftar
3. Informasi meliputi: ID, Nama, Username, Role, Status

#### **Menambah User Baru:**
1. Klik tombol "**+ Tambah User**"
2. Isi form:
   - **Nama Lengkap**: Nama lengkap pengguna
   - **Username**: Username untuk login (unique)
   - **Password**: Password akun
   - **Role**: Pilih Admin atau User
3. Klik "**Simpan**"

#### **Mengedit User:**
1. Klik icon "**✏️ Edit**" pada row user yang ingin diedit
2. Update informasi yang diperlukan
3. Klik "**Update**"

#### **Menghapus User:**
1. Klik icon "**🗑️ Hapus**" pada row user
2. Konfirmasi penghapusan
3. User akan dihapus dari database

### **🧁 Manajemen Produk**

#### **Melihat Katalog Produk:**
1. Klik menu "**Data Produk**" di sidebar
2. View produk dalam format:
   - **Grid View**: Card layout dengan gambar
   - **Table View**: Tabel detail produk

#### **Menambah Produk Baru:**
1. Klik "**+ Tambah Produk**"
2. Isi form produk:
   ```
   Nama Produk: [Red Velvet Cake]
   Kategori: [Pilih dari dropdown]
   Deskripsi: [Deskripsi detail produk]
   Harga: [250000] (dalam rupiah)
   Stok: [10] (jumlah item)
   Gambar: [Upload file JPG/PNG, max 2MB]
   ```
3. Preview produk sebelum menyimpan
4. Klik "**Simpan Produk**"

#### **Mengedit Produk:**
1. Klik "**✏️ Edit**" pada produk yang ingin diubah
2. Update informasi produk
3. Ganti gambar jika diperlukan
4. Klik "**Update Produk**"

#### **Menghapus Produk:**
1. Klik "**🗑️ Hapus**" pada produk
2. Konfirmasi penghapusan
3. Produk akan dihapus beserta relasi transaksinya

### **🏷️ Manajemen Kategori**

#### **Melihat Kategori:**
1. Klik menu "**Kategori**" di sidebar
2. Lihat daftar semua kategori produk

#### **Menambah Kategori:**
1. Klik "**+ Tambah Kategori**"
2. Isi nama kategori (contoh: "Kue Ulang Tahun")
3. Klik "**Simpan**"

#### **Mengedit Kategori:**
1. Klik "**✏️ Edit**" pada kategori
2. Update nama kategori
3. Klik "**Update**"

#### **Menghapus Kategori:**
⚠️ **Perhatian:** Hapus semua produk dalam kategori terlebih dahulu
1. Klik "**🗑️ Hapus**" pada kategori
2. Konfirmasi penghapusan

### **💳 Manajemen Transaksi**

#### **Melihat Transaksi:**
1. Klik menu "**Data Transaksi**" di sidebar
2. Lihat semua transaksi dengan status:
   - 🟡 **Pending**: Menunggu konfirmasi
   - 🔵 **Diproses**: Sedang diproses
   - 🟢 **Selesai**: Transaksi selesai
   - 🔴 **Dibatalkan**: Transaksi dibatalkan

#### **Update Status Transaksi:**
1. Klik "**👁️ Detail**" pada transaksi
2. Lihat detail item yang dibeli
3. Update status sesuai progres:
   ```
   Pending → Diproses → Selesai
   atau
   Pending → Dibatalkan
   ```
4. Klik "**Update Status**"

#### **Detail Transaksi:**
- **Info Customer**: Nama, kontak
- **Item Pesanan**: Produk, jumlah, harga
- **Total Pembayaran**: Grand total
- **Tanggal Order**: Timestamp transaksi
- **Status History**: Log perubahan status

### **📊 Laporan Penjualan**

#### **Akses Laporan:**
1. Klik menu "**Laporan**" di sidebar
2. Pilih periode laporan:
   - Harian
   - Mingguan  
   - Bulanan
   - Custom range

#### **Jenis Laporan:**
- **📈 Revenue Report**: Total penjualan per periode
- **🥇 Best Seller**: Produk terlaris
- **👥 Customer Report**: Statistik pelanggan
- **📦 Inventory Report**: Status stok produk

#### **Export Laporan:**
1. Pilih format export:
   - PDF (untuk presentasi)
   - Excel (untuk analisis)
2. Klik "**📥 Download**"

### **⚙️ Pengaturan Toko**

#### **Konfigurasi Toko:**
1. Klik menu "**Pengaturan**" di sidebar
2. Update informasi toko:
   ```
   Nama Toko: [Delicia by Dilla]
   Deskripsi: [Toko kue rumahan handmade dan premium]
   Kontak: [0812-3456-7890]
   Alamat: [Alamat lengkap toko]
   Email: [contact@deliciabydilla.com]
   ```
3. Upload logo toko (format PNG/JPG)
4. Klik "**Simpan Pengaturan**"

### **📋 Log Aktivitas**

#### **Monitor Aktivitas Admin:**
1. Klik menu "**Aktivitas**" di sidebar
2. Lihat log semua aktivitas admin:
   - Login/logout
   - CRUD operations
   - Status changes
   - Configuration updates

---

## 👤 User Panel - Complete Guide

### **🏠 Dashboard User**

#### **Akses Dashboard:**
1. Buka `http://yourdomain.com`
2. Login dengan akun user atau register akun baru
3. Dashboard user akan menampilkan:
   - Selamat datang message
   - Quick access ke fitur utama
   - Rekomendasi produk
   - Status pesanan terbaru

### **📝 Registrasi Akun Baru**

#### **Langkah Registrasi:**
1. Klik "**Daftar**" di halaman login
2. Isi form registrasi:
   ```
   Nama Lengkap: [Nama lengkap Anda]
   Username: [username unik]
   Password: [password kuat]
   Konfirmasi Password: [ulangi password]
   ```
3. Klik "**Daftar Akun**"
4. Login dengan akun yang baru dibuat

### **🛍️ Shopping Experience**

#### **Browse Katalog Produk:**
1. Klik menu "**Produk**" di navigasi
2. Lihat produk dalam kategori:
   - 🎂 **Kue Ulang Tahun**
   - 🥮 **Kue Tradisional**
   - 🥐 **Roti & Pastry**
   - 🍪 **Cookies & Biscuit**

#### **Filter & Search Produk:**
- **🔍 Search Box**: Cari berdasarkan nama produk
- **🏷️ Filter Kategori**: Filter berdasarkan kategori
- **💰 Filter Harga**: Range harga minimum-maksimum
- **⭐ Sort by Rating**: Urutkan berdasarkan rating

#### **Detail Produk:**
1. Klik pada gambar/nama produk
2. Lihat informasi lengkap:
   - **🖼️ Gallery**: Multiple gambar produk
   - **📝 Deskripsi**: Detail produk
   - **💰 Harga**: Harga per unit
   - **📦 Stok**: Ketersediaan
   - **⭐ Rating**: Rata-rata rating
   - **💬 Reviews**: Ulasan customer

### **🛒 Shopping Cart**

#### **Menambah ke Keranjang:**
1. Di halaman detail produk:
2. Pilih jumlah yang diinginkan
3. Klik "**🛒 Tambah ke Keranjang**"
4. Produk akan ditambahkan ke cart

#### **Mengelola Keranjang:**
1. Klik icon "**🛒**" di navigasi
2. Lihat semua item dalam keranjang:
   - **Gambar produk**
   - **Nama & harga**
   - **Quantity selector**
   - **Subtotal per item**
3. **Update Quantity**: Ubah jumlah item
4. **Remove Item**: Hapus item dari keranjang
5. **Continue Shopping**: Lanjut belanja

### **💳 Checkout Process**

#### **Proses Pemesanan:**
1. Dari keranjang, klik "**Checkout**"
2. Review pesanan:
   ```
   Item Details:
   - [Nama Produk] x [Qty] = [Subtotal]
   - [Nama Produk] x [Qty] = [Subtotal]
   
   Order Summary:
   - Subtotal: Rp [amount]
   - Tax (if applicable): Rp [amount]
   - Total: Rp [grand_total]
   ```
3. Konfirmasi alamat pengiriman
4. Pilih metode pembayaran:
   - 💰 **Cash on Delivery (COD)**
   - 🏧 **Transfer Bank**
   - 💳 **E-Wallet** (jika tersedia)
5. Klik "**Pesan Sekarang**"

#### **Konfirmasi Pesanan:**
1. Pesanan berhasil dibuat dengan status "**Pending**"
2. Note nomor pesanan untuk tracking
3. Tunggu konfirmasi dari admin
4. Terima notifikasi update status

### **📋 Riwayat Transaksi**

#### **Melihat History Pembelian:**
1. Klik menu "**Riwayat Pembelian**" di profil
2. Lihat semua transaksi dengan informasi:
   - **📅 Tanggal**: Tanggal pemesanan
   - **🛍️ Items**: Produk yang dibeli
   - **💰 Total**: Total pembayaran
   - **📊 Status**: Status current
   - **👁️ Detail**: Link ke detail transaksi

#### **Tracking Status Pesanan:**
- 🟡 **Pending**: Pesanan diterima, menunggu proses
- 🔵 **Diproses**: Pesanan sedang disiapkan
- 🟢 **Selesai**: Pesanan selesai, siap diambil/dikirim
- 🔴 **Dibatalkan**: Pesanan dibatalkan

### **⭐ Review & Rating System**

#### **Memberikan Review:**
1. Buka detail produk yang pernah dibeli
2. Scroll ke section "**Reviews**"
3. Klik "**Tulis Review**"
4. Isi form review:
   ```
   Rating: [1-5 bintang]
   Review: [Tulis pengalaman Anda dengan produk ini]
   ```
5. Klik "**Kirim Review**"

#### **Melihat Review Produk:**
- Lihat semua review dari customer lain
- Rating rata-rata produk
- Filter review berdasarkan rating
- Helpful vote untuk review

### **👤 Manajemen Profil**

#### **Update Profil:**
1. Klik menu "**Profil**" di navigasi
2. Edit informasi akun:
   ```
   Nama Lengkap: [Update nama]
   Username: [Username saat ini - tidak bisa diubah]
   Email: [Update email]
   No. Telepon: [Update nomor]
   Alamat: [Update alamat lengkap]
   ```
3. Klik "**Simpan Perubahan**"

#### **Ganti Password:**
1. Di halaman profil, klik "**Ganti Password**"
2. Isi form:
   ```
   Password Lama: [password saat ini]
   Password Baru: [password baru]
   Konfirmasi Password: [ulangi password baru]
   ```
3. Klik "**Update Password**"

---

## 🔒 Security Tips

### **Kiat Keamanan untuk Pengguna**
- Selalu gunakan password yang kuat
- Logout setelah selesai melakukan transaksi
- Jangan bagikan kredensial login Anda

### **Kiat Keamanan untuk Admin**
- Perbarui password admin secara berkala
- Batasi akses admin ke user yang terotorisasi saja
- Gunakan SSL untuk semua komunikasi antara server dan client

---

## 🏗️ Troubleshooting

### **Masalah Login**
- **Solusi:** Pastikan username dan password benar
- **Resmi:** Gunakan fitur reset password jika tersedia

### **Masalah Menambah Produk**
- **Solusi:** Cek format gambar produk dan pastikan ukuran tidak melebihi batas
- **Konfirmasi:** Periksa izin folder upload gambar (writable)

### **Transaksi Bermasalah**
- **Solusi:** Pastikan koneksi database stabil dan service berjalan
- **Konsultasi:** Hubungi partner penyedia pembayaran jika ada masalah

---

## 💼 Support

### **Kontak Developer**
- Email: dillasardilla387@gmail.com

### **Bantuan Teknis**
- Sediakan detail masalah, screenshots, dan langkah yang diambil

### **Komunitas dan Dokumentasi**
- Bergabunglah dengan komunitas dan diskusi di forum yang tersedia

---

**🎯 Usage Guide**  
Created by: Sardilla (202312071)  
Last Updated: Juli 2025  
Version: 1.0.0
