<?php
include '../auth.php';
include '../config/koneksi.php';

$produk = mysqli_query($conn, "SELECT produk.*, kategori.nama_kategori 
                               FROM produk 
                               JOIN kategori ON produk.id_kategori = kategori.id_kategori 
                               ORDER BY produk.id_produk DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Produk - Admin</title>
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
            background-color: #ed92b8;
            padding: 20px 15px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
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

        h2 {
            color: deeppink;
            font-size: 28px;
        }

        .btn {
            display: inline-block;
            background-color: #dc5aa5;
            color: white;
            padding: 8px 16px;
            margin-bottom: 20px;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s ease;
        }

        .btn:hover {
            background-color: #c74c96;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #fce1ec;
            color: #b30059;
        }

        a.edit, a.hapus {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
        }

        a.edit {
            background-color: #007bff;
            color: white;
        }

        a.hapus {
            background-color: #dc3545;
            color: white;
        }

        .gambar-produk {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class="fa-solid fa-cake-candles"></i> D-Admin</h2>
    <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="data_user.php"><i class="fa-solid fa-user"></i> Data User</a>
    <a href="data_produk.php" class="active"><i class="fa-solid fa-cupcake"></i> Produk</a>
    <a href="data_kategori.php"><i class="fa-solid fa-folder"></i> Kategori</a>
    <a href="data_transaksi.php"><i class="fa-solid fa-credit-card"></i> Transaksi</a>
    <a href="laporan.php"><i class="fa-solid fa-chart-bar"></i> Laporan</a>
    <a href="pengaturan.php"><i class="fa-solid fa-gear"></i> Pengaturan</a>
    <a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="main-content">
    <h2>Data Produk</h2>
    <a href="tambah_produk.php" class="btn"><i class="fa fa-plus"></i> Tambah Produk</a>

    <table>
        <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($produk)) : ?>
        <tr>
            <td><?= $no++; ?></td>
            <td>
                <?php if (!empty($row['gambar'])) : ?>
                    <img src="../assets/img/<?= $row['gambar']; ?>" class="gambar-produk" alt="gambar">
                <?php else : ?>
                    <span style="color: #888;">(Tidak ada gambar)</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['nama_produk']); ?></td>
            <td><?= $row['nama_kategori']; ?></td>
            <td>Rp<?= number_format($row['harga']); ?></td>
            <td><?= $row['stok']; ?></td>
            <td>
                <a href="edit_produk.php?id=<?= $row['id_produk']; ?>" class="edit">Edit</a>
                <a href="hapus_produk.php?id=<?= $row['id_produk']; ?>" class="hapus" onclick="return confirm('Hapus produk ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
