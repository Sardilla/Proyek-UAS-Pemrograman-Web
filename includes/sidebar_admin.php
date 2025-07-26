<!-- sidebar.php -->
<style>
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 200px;
    height: 100%;
    background-color: #ffb6c1; /* Baby pastel pink */
    padding: 20px 15px;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    font-family: 'Segoe UI', sans-serif;
    z-index: 1000;
}

.sidebar h2 {
    font-size: 16px;
    margin-bottom: 25px;
    color: #b30059; /* Pink tua elegan */
    display: flex;
    align-items: center;
    gap: 6px;
}

.sidebar a {
    display: block;
    color: white; /* Biar cerah & kontras */
    text-decoration: none;
    margin: 10px 0;
    padding: 8px 10px;
    border-radius: 6px;
    font-size: 14px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.sidebar a:hover,
.sidebar a.active {
    background-color: ""; /* Versi lebih gelap untuk hover */
    color: white;
    transform: translateX(4px);
}

.main-content {
    margin-left: 200px;
    padding: 30px;
    background-color: #fffafc; /* Sedikit lebih putih agar lembut */
    min-height: 100vh;
}
</style>



<div class="sidebar">
    <h2>🍰 D-Admin</h2>
    <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">🏠 Dashboard</a>
    <a href="user.php" class="<?= basename($_SERVER['PHP_SELF']) == 'user.php' ? 'active' : '' ?>">👤 User</a>
    <a href="produk.php" class="<?= basename($_SERVER['PHP_SELF']) == 'produk.php' ? 'active' : '' ?>">🧁 Produk</a>
    <a href="kategori.php" class="<?= basename($_SERVER['PHP_SELF']) == 'kategori.php' ? 'active' : '' ?>">📂 Kategori</a>
    <a href="transaksi.php" class="<?= basename($_SERVER['PHP_SELF']) == 'transaksi.php' ? 'active' : '' ?>">💳 Transaksi</a>
    <a href="laporan.php" class="<?= basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : '' ?>">📊 Laporan</a>
    <a href="pengaturan.php" class="<?= basename($_SERVER['PHP_SELF']) == 'pengaturan.php' ? 'active' : '' ?>">⚙️ Pengaturan</a>
    <a href="../logout.php">🚪 Logout</a>
</div>
