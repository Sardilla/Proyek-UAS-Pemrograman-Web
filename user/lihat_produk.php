<?php
session_start();

// Cek apakah user sudah login dan rolenya 'user'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

require_once '../config/koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID produk tidak ditemukan!";
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    echo "Produk tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk - <?= htmlspecialchars($produk['nama_produk']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff0f5;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h1 {
            color: deeppink;
            font-size: 26px;
            margin-bottom: 10px;
        }

        .produk-img {
            max-width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }

        .produk-info {
            margin-top: 20px;
        }

        .produk-info p {
            font-size: 16px;
            margin: 8px 0;
        }

        .harga {
            font-size: 20px;
            color: #e60073;
            font-weight: bold;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 16px;
            background-color: #f58db0;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn-back:hover {
            background-color: #d06d9a;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1><?= htmlspecialchars($produk['nama_produk']) ?></h1>
        <img class="produk-img" src="../assets/img/produk/<?= htmlspecialchars($produk['gambar']) ?>" alt="<?= htmlspecialchars($produk['nama_produk']) ?>">

        <div class="produk-info">
            <p class="harga">Rp<?= number_format($produk['harga'], 0, ',', '.') ?></p>
            <p><strong>Stok:</strong> <?= $produk['stok'] ?></p>
            <p><?= htmlspecialchars($produk['deskripsi']) ?></p>
        </div>

        <a href="detail_produk.php" class="btn-back"><i class="fa fa-arrow-left"></i> Kembali ke Produk</a>
    </div>

</body>
</html>
