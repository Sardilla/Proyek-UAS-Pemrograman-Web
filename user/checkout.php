<?php
include '../auth.php';
include '../config/koneksi.php';

$id_user = $_SESSION['user']['id_user'] ?? 0;

// Proses checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['keranjang'])) {
    $tanggal = date('Y-m-d H:i:s');
    $total = 0;
    foreach ($_SESSION['keranjang'] as $item) {
        $total += $item['jumlah'] * $item['harga'];
    }

    mysqli_query($conn, "INSERT INTO transaksi (id_user, tanggal, total, status) VALUES ('$id_user', '$tanggal', '$total', 'Sukses')");
    $id_transaksi = mysqli_insert_id($conn);

    foreach ($_SESSION['keranjang'] as $item) {
        $id_produk = $item['id_produk'];
        $jumlah = $item['jumlah'];
        mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah) VALUES ('$id_transaksi', '$id_produk', '$jumlah')");
    }

    unset($_SESSION['keranjang']);
}

// Ambil transaksi terakhir user
$query = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_user = '$id_user' ORDER BY id_transaksi DESC LIMIT 1");
$data_transaksi = mysqli_fetch_assoc($query);

// Ambil detail produk
$produk = [];
if ($data_transaksi) {
    $id_transaksi = $data_transaksi['id_transaksi'];
    $query_detail = mysqli_query($conn, "
        SELECT dp.*, p.nama_produk, p.harga 
        FROM detail_transaksi dp 
        JOIN produk p ON dp.id_produk = p.id_produk 
        WHERE dp.id_transaksi = '$id_transaksi'
    ");
    while ($row = mysqli_fetch_assoc($query_detail)) {
        $produk[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Sukses | Delicia by Dilla</title>
    <style>
        body {
            background-color: #fff4f7;
            font-family: 'Segoe UI', sans-serif;
            color: #333;
            padding: 30px;
        }
        .container {
            max-width: 800px;
            background: #fff;
            margin: auto;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        h2 {
            color: #e06c9f;
            text-align: center;
            margin-bottom: 15px;
        }
        .success {
            text-align: center;
            background: #ffecf3;
            padding: 15px;
            border-radius: 10px;
            color: #c8387b;
            font-weight: bold;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #ffe0eb;
            padding: 10px;
            border: 1px solid #ffd6e5;
        }
        td {
            padding: 10px;
            border: 1px solid #ffd6e5;
            text-align: center;
        }
        .buttons {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 25px;
            margin: 10px;
            background-color: #ff7ca8;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background-color: #e96294;
        }
        .back {
            text-decoration: none;
            color: #666;
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🎉 Terima Kasih!</h2>
    <div class="success">Transaksi Anda telah berhasil. Status: <strong>Sukses</strong></div>

    <?php if (!empty($produk)): ?>
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($produk as $item): ?>
            <tr>
                <td><?= $item['nama_produk'] ?></td>
                <td><?= $item['jumlah'] ?></td>
                <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($item['jumlah'] * $item['harga'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="text-align:center;">Tidak ada produk dalam transaksi ini.</p>
    <?php endif; ?>

    <div class="buttons">
        <a href="produk.php"><button class="btn">🛍 Belanja Lagi</button></a>
        <a href="dashboard.php" class="back">⬅ Kembali ke Dashboard</a>
    </div>
</div>
</body>
</html>
