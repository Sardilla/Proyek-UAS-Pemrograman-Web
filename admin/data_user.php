<?php
include '../auth.php';
include '../config/koneksi.php';

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY role DESC, id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data User - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
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
            margin-left: 200px;
            padding: 40px;
            min-height: 100vh;
        }

        h1 {
            color: deeppink;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.15);
        }

        th, td {
            padding: 12px 16px;
            text-align: center;
        }

        th {
            background-color: #f8c8dc;
            color: #b30059;
        }

        tr:nth-child(even) {
            background-color: #fff0f5;
        }

        tr:hover {
            background-color: #fde6ef;
        }

        .btn {
            padding: 5px 10px;
            font-size: 12px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            color: white;
        }

        .edit { background-color: #ff69b4; }
        .hapus { background-color: #b30059; }

        .add-user {
            margin-bottom: 20px;
            display: inline-block;
            background: #b30059;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2><i class="fa-solid fa-cake-candles"></i> D-Admin</h2>
        <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="data_user.php" class="active"><i class="fa-solid fa-user"></i> User</a>
        <a href="data_produk.php"><i class="fa-solid fa-cupcake"></i> Produk</a>
        <a href="data_kategori.php"><i class="fa-solid fa-folder"></i> Kategori</a>
        <a href="data_transaksi.php"><i class="fa-solid fa-credit-card"></i> Transaksi</a>
        <a href="data_laporan.php"><i class="fa-solid fa-chart-bar"></i> Laporan</a>
        <a href="pengaturan.php"><i class="fa-solid fa-gear"></i> Pengaturan</a>
        <a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <div class="main-content">
        <h1>Data Pengguna</h1>
        <a href="tambah_user.php" class="add-user"><i class="fa fa-plus"></i> Tambah User</a>

        <table>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
            <?php $no = 1; ?>
            <?php while ($row = mysqli_fetch_assoc($users)) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                <td><?= htmlspecialchars($row['username']); ?></td>
                <td><?= $row['role']; ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $row['id']; ?>" class="btn edit">Edit</a>
                    <a href="hapus_user.php?id=<?= $row['id']; ?>" class="btn hapus" onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>
</html>
