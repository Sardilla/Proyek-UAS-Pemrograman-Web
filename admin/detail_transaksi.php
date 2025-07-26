<?php
include '../auth.php';
include '../config/koneksi.php';

$id = $_GET['id'];

// Ambil data transaksi utama
$transaksi = mysqli_query($conn, "
    SELECT transaksi.*, users.nama_lengkap 
    FROM transaksi 
    JOIN users ON transaksi.id_user = users.id 
    WHERE transaksi.id_transaksi = $id
");
$data = mysqli_fetch_assoc($transaksi);

// Ambil detail item produk
$detail = mysqli_query($conn, "
    SELECT detail_transaksi.*, produk.nama_produk 
    FROM detail_transaksi 
    JOIN produk ON detail_transaksi.id_produk = produk.id_produk 
    WHERE detail_transaksi.id_transaksi = $id
");

if (!$data) {
    echo "Transaksi tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
</head>
<body>
    <h2>Detail Transaksi #<?= $id; ?></h2>
    <p><strong>Nama Pembeli:</strong> <?= $data['nama_lengkap']; ?></p>
    <p><strong>Tanggal:</strong> <?= $data['tanggal']; ?></p>
    <p><strong>Status:</strong> <?= ucfirst($data['status']); ?></p>
    <p><strong>Total:</strong> Rp<?= number_format($data['total']); ?></p>

    <h3>Produk Dipesan:</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
        <?php 
        $no = 1; 
        while ($d = mysqli_fetch_assoc($detail)) : 
            $subtotal = $d['jumlah'] * $d['harga'];
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($d['nama_produk']); ?></td>
            <td><?= $d['jumlah']; ?></td>
            <td>Rp<?= number_format($d['harga']); ?></td>
            <td>Rp<?= number_format($subtotal); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="transaksi.php">Kembali ke Daftar Transaksi</a>
</body>
</html>
