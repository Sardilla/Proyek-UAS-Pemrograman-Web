<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM produk ORDER BY nama_produk ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk - Delicia by Dilla</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fff0f5;
            margin: 0;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100%;
            background-color: #f58db0;
            padding-top: 30px;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar h3 {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            margin: 4px 10px;
            border-radius: 8px;
            transition: background 0.2s ease;
            font-weight: 500;
        }

        .sidebar a:hover {
            background-color: #ffb6c1;
        }

        .sidebar a.active {
            background-color: white;
            color: #f58db0;
            font-weight: bold;
        }

        .main-content {
            margin-left: 240px;
            padding: 40px;
        }

        h1 {
            color: #d63384;
            margin-bottom: 30px;
        }

        .produk-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 24px;
        }

        .produk-item {
            background: #ffffff;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .produk-item:hover {
            transform: translateY(-5px);
        }

        .produk-item img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
        }

        .produk-item h3 {
            font-size: 18px;
            color: #d63384;
            margin: 12px 0 4px;
        }

        .produk-item p {
            color: #444;
            margin: 4px 0 10px;
        }

        .produk-item a {
            text-decoration: none;
            background-color: #f58db0;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
            font-size: 14px;
        }

        .produk-item a:hover {
            background-color: #ff6fa1;
        }

        @media screen and (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h3>Delicia</h3>
    <a href="dashboard.php">Dashboard</a>
    <a href="produk.php" class="active">Produk</a>
    <a href="keranjang.php">Keranjang</a>
    <a href="checkout.php">Checkout</a>
    <a href="riwayat_pembelian.php">Riwayat</a>
    <a href="profil.php">Profil</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Konten Utama -->
<div class="main-content">
    <h1>Daftar Produk</h1>
    <div class="produk-list">
        <?php while($row = mysqli_fetch_assoc($query)) : ?>
            <div class="produk-item">
                <img src="../assets/img/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
                <h3><?= htmlspecialchars($row['nama_produk']) ?></h3>
                <p>Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
                <a href="detail_produk.php?id=<?= $row['id_produk'] ?>"><i class="fa fa-eye"></i> Lihat Detail</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
