<?php
session_start();

// Cek apakah user sudah login dan rolenya 'user'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

require_once '../config/koneksi.php';

// Ambil data user dari session
$user = $_SESSION['user'];
$username = htmlspecialchars($user['username'] ?? 'Pengguna');
$id_user = $user['id_user'] ?? null;

// Ambil jumlah produk dan jumlah transaksi milik user
$jumlah_produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM produk"));
$jumlah_transaksi_user = 0;
if ($id_user) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM transaksi WHERE id_user = '$id_user'");
    $row = mysqli_fetch_assoc($result);
    $jumlah_transaksi_user = $row['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard User - Delicia by Dilla</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-image: url('../assets/img/walpaper.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #333;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background-color: rgba(245, 141, 176, 0.9);
            padding: 20px;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 1000;
        }

        .sidebar .logo {
            width: 100px;
            height: 100px;
            background-color: white;
            border-radius: 50%;
            margin-bottom: 20px;
            background-image: url('../assets/img/logo.png');
            background-size: cover;
            background-position: center;
            border: 4px solid #fff;
        }

        .sidebar h2 {
            color: white;
            font-size: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            width: 100%;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 8px;
            transition: background 0.3s;
            font-size: 14px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #d06d9a;
        }

        .main-content {
            margin-left: 240px;
            padding: 40px;
            min-height: 100vh;
            backdrop-filter: blur(5px);
        }

        .main-content h1 {
            font-size: 30px;
            color: deeppink;
            margin-bottom: 8px;
        }

        .main-content p {
            font-style: italic;
            color: #555;
        }

        .stats {
            display: flex;
            gap: 25px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            min-width: 220px;
            background-color: #fff;
            border-radius: 16px;
            padding: 30px 20px;
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
            text-align: center;
        }

        .card h2 {
            font-size: 40px;
            color: deeppink;
            margin-bottom: 8px;
        }

        .card p {
            color: #b30059;
            font-weight: 500;
        }

        .btn-checkout {
            display: inline-block;
            margin-top: 40px;
            padding: 14px 28px;
            background-color: deeppink;
            color: white;
            font-size: 16px;
            border-radius: 12px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(255, 105, 180, 0.5);
            transition: background-color 0.3s;
        }

        .btn-checkout:hover {
            background-color: #b30059;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-around;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .stats {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo"></div>
    <h2>D-User</h2>
    <a href="dashboard.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="detail_produk.php"><i class="fa-solid fa-cupcake"></i> Produk</a>
    <a href="keranjang.php"><i class="fa-solid fa-cart-shopping"></i> Keranjang</a>
    <a href="checkout.php"><i class="fa-solid fa-credit-card"></i> Checkout</a>
    <a href="detail_transaksi.php"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat</a>
    <a href="profil.php"><i class="fa-solid fa-user"></i> Profil</a>
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<main class="main-content">
    <h1>Selamat Datang, <?= $username ?>!</h1>
    <p>Ini adalah halaman utama akunmu di <strong>Delicia by Dilla</strong>.</p>

    <div class="stats">
        <div class="card">
            <h2><?= $jumlah_produk ?></h2>
            <p>Produk Tersedia</p>
        </div>
        <div class="card">
            <h2><?= $jumlah_transaksi_user ?></h2>
            <p>Pesanan Kamu</p>
        </div>
    </div>

    <a href="checkout.php" class="btn-checkout"><i class="fa-solid fa-credit-card"></i> Checkout Sekarang</a>
</main>

</body>
</html>
