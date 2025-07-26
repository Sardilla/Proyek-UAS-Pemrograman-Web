<?php
session_start();

// Hapus isi keranjang setelah checkout berhasil
unset($_SESSION['keranjang']);

// Pastikan user sudah login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Berhasil - Delicia by Dilla</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom right, #fff0f5, #ffe6f0);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .success-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 0 30px rgba(255, 182, 193, 0.5);
            text-align: center;
            max-width: 600px;
            width: 90%;
        }
        h2 {
            color: #d63384;
            margin-bottom: 20px;
            font-weight: bold;
        }
        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }
        .btn-custom {
            background-color: #ff69b4;
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
        }
        .btn-custom:hover {
            background-color: #ff1493;
            color: white;
        }
    </style>
</head>
<body>
    <div class="success-box">
        <h2>💖 Checkout Berhasil!</h2>
        <p>Terima kasih telah berbelanja di <strong>Delicia by Dilla</strong>.<br>Pesananmu sedang kami proses dengan cinta dan gula! 🍪</p>
        <a href="riwayat.php" class="btn btn-custom">Lihat Riwayat Pesanan</a>
        <br><br>
        <a href="produk.php" class="btn btn-outline-secondary">Kembali ke Halaman Produk</a>
    </div>
</body>
</html>
