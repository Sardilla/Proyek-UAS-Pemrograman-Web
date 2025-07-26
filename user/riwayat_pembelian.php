<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['user']['id_user'];

// Ambil pesanan user dari database
$query = "SELECT * FROM pesanan WHERE id_user = '$id_user' ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pembelian</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom right, #ffe6f0, #fff);
            font-family: 'Segoe UI', sans-serif;
            padding: 50px 0;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(255, 192, 203, 0.4);
        }
        h2 {
            text-align: center;
            color: #d63384;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .table th {
            background-color: #ffdce5;
            color: #000;
        }
        .no-data {
            text-align: center;
            font-weight: bold;
            color: #777;
            padding: 40px 0;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container col-md-10">
    <h2>🧾 Riwayat Pembelianmu</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date("d M Y - H:i", strtotime($row['tanggal'])) ?></td>
                        <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="no-data">Belum ada pembelian yang kamu lakukan.</div>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary btn-back">← Kembali ke Dashboard</a>
</div>
</body>
</html>
