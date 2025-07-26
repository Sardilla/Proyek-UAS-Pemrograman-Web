<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

require_once '../config/koneksi.php';

$user = $_SESSION['user'];
$username = htmlspecialchars($user['username'] ?? 'Pengguna');

$query = mysqli_query($conn, "SELECT * FROM produk ORDER BY nama_produk ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk - Delicia by Dilla</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff0f5;
            margin: 0;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 200px;
            height: 100%;
            background-color: #f58db0;
            padding: 20px 15px;
        }

        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 25px;
            color: #fff;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 10px 0;
            padding: 8px 10px;
            border-radius: 6px;
            font-size: 14px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #d06d9a;
            transform: translateX(4px);
        }

        .main-content {
            margin-left: 200px;
            padding: 40px;
            background-color: #fff0f5;
            min-height: 100vh;
        }

        h1 {
            color: deeppink;
            font-size: 28px;
        }

        .produk-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }

        .produk-item {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            padding: 16px;
            width: 220px;
        }

        .produk-item img {
            width: 100%;
            border-radius: 10px;
            height: 150px;
            object-fit: cover;
        }

        .produk-item h3 {
            font-size: 18px;
            margin: 10px 0 5px;
            color: #b30059;
        }

        .produk-item p {
            font-size: 14px;
            color: #333;
        }

        .produk-item .harga {
            font-weight: bold;
            color: deeppink;
        }

        .btn-keranjang {
            margin-top: 10px;
            background-color: deeppink;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-keranjang:hover {
            background-color: #c2185b;
        }
    </style>
</head>
<body>

    <nav class="sidebar">
    <h2><i class="fa-solid fa-cake-candles"></i> D-User</h2>
    <a href="dashboard.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="detail_produk.php"><i class="fa-solid fa-cupcake"></i> Produk</a>
    <a href="keranjang.php"><i class="fa-solid fa-cart-shopping"></i> Keranjang</a>
    <a href="checkout.php"><i class="fa-solid fa-credit-card"></i> Checkout</a>
    <a href="detail_transaksi.php"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat</a>
    <a href="profil.php"><i class="fa-solid fa-user"></i> Profil</a>
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</nav>


    <div class="main-content">
        <h1>Daftar Produk</h1>

        <div class="produk-list">
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <div class="produk-item">
                    <img src="../assets/img/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
                    <h3><?= htmlspecialchars($row['nama_produk']) ?></h3>
                    <p class="harga">Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
                    <p><?= htmlspecialchars($row['deskripsi']) ?></p>
                    
                    <!-- Tombol tambah ke keranjang -->
                    <form action="keranjang.php" method="post">
                        <input type="hidden" name="id_produk" value="<?= $row['id_produk'] ?>">
                        <input type="hidden" name="nama_produk" value="<?= htmlspecialchars($row['nama_produk']) ?>">
                        <input type="hidden" name="harga" value="<?= $row['harga'] ?>">
                        <input type="hidden" name="gambar" value="<?= htmlspecialchars($row['gambar']) ?>">
                        <input type="number" name="jumlah" value="1" min="1" max="20" style="width: 60px;">
                        <button type="submit" class="btn-keranjang"><i class="fa-solid fa-cart-plus"></i> Tambah</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>
</html>
