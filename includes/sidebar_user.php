<?php
if (isset($_SESSION['user']['username'])) {
    $username = $_SESSION['user']['username'];
} else {
    $username = 'User';
}
?>

<aside style="width: 220px; float: left; background-color: #fff0f5; height: 100vh; padding: 20px; box-sizing: border-box;">
    <h3 style="color: #d63384;">User Menu</h3>
    <ul style="list-style: none; padding: 0;">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="produk.php">Lihat Produk</a></li>
        <li><a href="keranjang.php">Keranjang</a></li>
        <li><a href="checkout.php">Checkout</a></li>
        <li><a href="detail_transaksi.php">Detail Transaksi</a></li>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="logout.php" style="color:red;">Logout</a></li>
    </ul>
</aside>

<div style="margin-left: 240px; padding: 20px;">
    <!-- Konten utama di sini -->
    <h1>Selamat datang, <?= htmlspecialchars($username) ?>!</h1>
    <p>Ini adalah halaman dashboard user.</p>
</div>
