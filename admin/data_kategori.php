<?php
include '../auth.php';
include '../config/koneksi.php';

// Ambil data kategori dari database
$kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kategori</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff0f5;
            padding: 40px;
        }

        h2 {
            color: #cc0066;
            text-align: center;
            margin-bottom: 20px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .top-bar a {
            text-decoration: none;
            color: #fff;
            background-color: #ff69b4;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: bold;
        }

        .top-bar a:hover {
            background-color: #d6006c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(255, 105, 180, 0.1);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ffd6e8;
            text-align: left;
        }

        th {
            background-color: #ffb6c1;
            color: #fff;
        }

        td a {
            color: #cc0066;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
        }

        .bottom-bar {
            margin-top: 30px;
            text-align: center;
        }

        .bottom-bar a {
            text-decoration: none;
            background-color: #ff69b4;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
        }

        .bottom-bar a:hover {
            background-color: #d6006c;
        }
    </style>
</head>
<body>

    <h2>Data Kategori Produk</h2>

    <div class="top-bar">
        <div></div>
        <a href="tambah_kategori.php">+ Tambah Kategori</a>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($kategori)) : ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
            <td>
                <a href="edit_kategori.php?id=<?= $row['id_kategori']; ?>">Edit</a> |
                <a href="hapus_kategori.php?id=<?= $row['id_kategori']; ?>" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="bottom-bar">
        <a href="dashboard.php">← Kembali ke Dashboard</a>
    </div>

</body>
</html>
