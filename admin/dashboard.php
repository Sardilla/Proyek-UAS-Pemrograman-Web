<?php
include '../auth.php';
include '../config/koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['user']['username'] ?? 'Admin';

$jumlah_user = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='user'"));
$jumlah_produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM produk"));
$jumlah_transaksi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Delicia by Dilla</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #fff0f5;
        }

        .sidebar {
    position: fixed;
    left: 0; /* dari sebelumnya -5px */
    top: 0;
    width: 230px;
    height: 100vh;
    background-color: #ed92b8;
    padding: 25px 10px; /* sedikiiit dirapikan */
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
}


        .sidebar-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .sidebar-logo img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-bottom: 10px;
            object-fit: cover;
            border: 3px solid #fff;
        }

        .sidebar-logo span {
            font-size: 18px;
            color: #fff;
            font-weight: bold;
        }

        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            margin: 12px 0;
            font-size: 15px;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #d06d9a;
        }

        .main-content {
            margin-left: 230px;
            padding: 40px;
        }

        .main-content h1 {
            font-size: 34px;
            color: #d63384;
            margin-bottom: 5px;
        }

        .main-content p {
            color: #777;
        }

        .stats {
            margin-top: 40px;
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
        }

        .card {
            background: #fff;
            flex: 1;
            min-width: 250px;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(255, 105, 180, 0.15);
            text-align: center;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card h2 {
            font-size: 48px;
            margin: 0;
            color: #e91e63;
        }

        .card p {
            margin-top: 12px;
            color: #b30059;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="../assets/img/logo.png" alt="Logo Delicia">
            <span>D-Admin</span>
        </div>
        <a href="dashboard.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="data_user.php"><i class="fa-solid fa-user"></i> Data User</a>
        <a href="data_produk.php"><i class="fa-solid fa-cupcake"></i> Produk</a>
        <a href="data_kategori.php"><i class="fa-solid fa-folder"></i> Kategori</a>
        <a href="data_transaksi.php"><i class="fa-solid fa-credit-card"></i> Transaksi</a>
        <a href="laporan.php"><i class="fa-solid fa-chart-bar"></i> Laporan</a>
        <a href="pengaturan.php"><i class="fa-solid fa-gear"></i> Pengaturan</a>
        <a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <div class="main-content">
        <h1>Delicia by Dilla</h1>
        <p>Selamat datang, <strong><?= htmlspecialchars($username); ?></strong>!</p>

        <div class="stats">
            <div class="card">
                <h2><?= $jumlah_user; ?></h2>
                <p>User Terdaftar</p>
            </div>
            <div class="card">
                <h2><?= $jumlah_produk; ?></h2>
                <p>Produk Tersedia</p>
            </div>
            <div class="card">
                <h2><?= $jumlah_transaksi; ?></h2>
                <p>Total Transaksi</p>
            </div>
        </div>
    </div>

</body>
</html>