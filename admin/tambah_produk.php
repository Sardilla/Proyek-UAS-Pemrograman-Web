<?php
include '../auth.php';
include '../config/koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>ID produk tidak valid!</p>";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT produk.*, kategori.nama_kategori 
          FROM produk 
          LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori 
          WHERE produk.id_produk = $id";

$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) {
    echo "<p>ID produk tidak ditemukan!</p>";
    exit;
}

$produk = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff0f5;
            padding: 40px;
        }
        .produk-box {
            background: #fff;
            max-width: 700px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(255, 105, 180, 0.2);
        }
        h2 {
            color: #cc0066;
            margin-bottom: 20px;
        }
        .produk-img {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .label {
            font-weight: bold;
            color: #b30059;
        }
        .value {
            margin-bottom: 15px;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #ffe6f0;
            color: #cc0066;
            padding: 10px 20px;
            border-radius: 8px;
        }
        .back-link:hover {
            background-color: #ffccdd;
        }
    </style>
</head>
<body>

<div class="produk-box">
    <h2><?= htmlspecialchars($produk['nama_produk']); ?></h2>
    
    <img src="../../assets/img/<?= htmlspecialchars($produk['gambar']); ?>" alt="Gambar Produk" class="produk-img">
    
    <p><span class="label">Deskripsi:</span><br><span class="value"><?= nl2br(htmlspecialchars($produk['deskripsi'])); ?></span></p>
    <p><span class="label">Harga:</span> <span class="value">Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></span></p>
    <p><span class="label">Stok:</span> <span class="value"><?= $produk['stok']; ?></span></p>
    <p><span class="label">Kategori:</span> <span class="value"><?= htmlspecialchars($produk['nama_kategori'] ?? '-'); ?></span></p>

    <a href="produk.php" class="back-link">← Kembali ke Daftar Produk</a>
</div>

</body>
</html>
