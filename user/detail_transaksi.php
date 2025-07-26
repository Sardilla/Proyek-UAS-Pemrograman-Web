<?php
include '../auth.php';
include '../config/koneksi.php';

$id_user = $_SESSION['user']['id_user'];
$query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_user = '$id_user' ORDER BY id_transaksi DESC");

$semua_transaksi = [];
while ($row = mysqli_fetch_assoc($query_transaksi)) {
    $id_transaksi = $row['id_transaksi'];

    $produk = [];
    $query_produk = mysqli_query($conn, "
        SELECT dp.*, p.nama_produk, p.harga 
        FROM detail_transaksi dp 
        JOIN produk p ON dp.id_produk = p.id_produk 
        WHERE dp.id_transaksi = '$id_transaksi'
    ");
    while ($p = mysqli_fetch_assoc($query_produk)) {
        $produk[] = $p;
    }

    $row['produk'] = $produk;
    $semua_transaksi[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi - Delicia-by-Dilla</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fff5f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }
        h1 {
            text-align: center;
            color: #e83e8c;
            margin-bottom: 40px;
        }
        .transaksi {
            border: 1px solid #fce3ec;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 16px;
            background: #fff9fb;
            position: relative;
        }
        .transaksi h2 {
            margin-top: 0;
            color: #d63384;
            font-size: 20px;
        }
        .transaksi p {
            margin: 6px 0;
        }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background-color: #28a745;
            text-transform: capitalize;
        }
        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #f9dfe7;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #ffe9f0;
            color: #c2185b;
        }
        tr:hover {
            background-color: #fff3f7;
        }
        .btn-back {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background: #e83e8c;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        .btn-back:hover {
            background: #d12c7a;
        }
        .btn-delete {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-delete:hover {
            background-color: #bd2130;
        }
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm("Yakin ingin menghapus transaksi ini?")) {
                window.location.href = 'hapus_transaksi.php?id=' + id;
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h1>📜 Riwayat Detail Transaksi</h1>

    <?php if (count($semua_transaksi) > 0): ?>
        <?php foreach ($semua_transaksi as $t): ?>
            <div class="transaksi">
                <button class="btn-delete" onclick="confirmDelete(<?= $t['id_transaksi']; ?>)">🗑 Hapus</button>
                <h2>🧾 ID Transaksi: <?= $t['id_transaksi']; ?></h2>
                <p><strong>Tanggal:</strong> <?= $t['tanggal'] == '0000-00-00' ? '-' : $t['tanggal']; ?></p>
                <p><strong>Status:</strong> <span class="badge">Sukses</span></p>
                <p><strong>Total:</strong> <span style="color:#28a745;">Rp <?= number_format($t['total'], 0, ',', '.'); ?></span></p>

                <?php if (!empty($t['produk'])): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($t['produk'] as $p): ?>
                                <tr>
                                    <td><?= htmlspecialchars($p['nama_produk']); ?></td>
                                    <td><?= $p['jumlah']; ?></td>
                                    <td>Rp <?= number_format($p['harga'] * $p['jumlah'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><em>Produk tidak tersedia.</em></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p><em>Tidak ada transaksi yang ditemukan.</em></p>
    <?php endif; ?>

    <a href="dashboard.php" class="btn-back">⬅ Kembali ke Dashboard</a>
</div>

</body>
</html>
