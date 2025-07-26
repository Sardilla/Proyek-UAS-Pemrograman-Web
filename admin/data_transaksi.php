<?php
include '../auth.php';
include '../config/koneksi.php';

// Handle status update
if (isset($_POST['update_status'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $new_status = $_POST['status'];
    
    $update_query = "UPDATE transaksi SET status = '$new_status' WHERE id_transaksi = '$id_transaksi'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Status berhasil diperbarui!'); window.location.href = 'data_transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui status!');</script>";
    }
}

$query = "SELECT t.id_transaksi, t.tanggal, u.nama_lengkap, t.total, t.status 
          FROM transaksi t 
          JOIN users u ON t.id_user = u.id 
          ORDER BY t.tanggal DESC";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

// Function untuk menentukan class CSS status
function getStatusClass($status) {
    switch(strtolower($status)) {
        case 'pending':
            return 'status-pending';
        case 'diproses':
            return 'status-diproses';
        case 'selesai':
            return 'status-selesai';
        case 'dibatalkan':
            return 'status-dibatalkan';
        default:
            return 'status-pending';
    }
}

// Function untuk menampilkan status dengan handling null/empty
function displayStatus($status) {
    if (empty($status) || is_null($status)) {
        return 'Pending';
    }
    return ucfirst($status);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff0f5;
            padding: 30px;
        }
        h2 {
            color: #cc0066;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(255, 105, 180, 0.2);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ffc0cb;
            text-align: center;
        }
        th {
            background-color: #ffb6c1;
            color: #fff;
        }
        tr:hover {
            background-color: #ffe6f0;
        }
        .back {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #ff69b4;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: bold;
        }
        .back:hover {
            background: #d6006c;
        }
        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        .status-diproses {
            background-color: #cce5ff;
            color: #004085;
            border: 1px solid #74b9ff;
        }
        .status-selesai {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #00b894;
        }
        .status-dibatalkan {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #e17055;
        }
        .status-select {
            padding: 5px 8px;
            border: 1px solid #ff69b4;
            border-radius: 5px;
            background: white;
            font-size: 12px;
        }
        .update-btn {
            padding: 3px 8px;
            background: #ff69b4;
            color: white;
            border: none;
            border-radius: 3px;
            font-size: 11px;
            cursor: pointer;
            margin-left: 5px;
        }
        .update-btn:hover {
            background: #d6006c;
        }
    </style>
</head>
<body>

<h2>Data Transaksi</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama User</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): 
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['tanggal']; ?></td>
                    <td><?= $row['nama_lengkap']; ?></td>
                    <td>Rp<?= number_format($row['total'], 0, ',', '.'); ?></td>
<td><span class="status <?= getStatusClass($row['status']); ?>"><?= displayStatus($row['status']); ?></span></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
                            <select name="status" class="status-select">
                                <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="diproses" <?= $row['status'] == 'diproses' ? 'selected' : ''; ?>>Diproses</option>
                                <option value="selesai" <?= $row['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                <option value="dibatalkan" <?= $row['status'] == 'dibatalkan' ? 'selected' : ''; ?>>Dibatalkan</option>
                            </select>
                            <button type="submit" name="update_status" class="update-btn">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">Belum ada transaksi.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<a href="dashboard.php" class="back">← Kembali ke Dashboard</a>

</body>
</html>
