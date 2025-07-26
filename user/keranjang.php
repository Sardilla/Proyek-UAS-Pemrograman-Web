<?php
session_start();

// Tambahkan ke keranjang jika ada data POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produk'])) {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $gambar = $_POST['gambar'];

    // Simpan ke session keranjang
    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk]['jumlah'] += $jumlah;
    } else {
        $_SESSION['keranjang'][$id_produk] = [
            'id_produk' => $id_produk,
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'jumlah' => $jumlah,
            'gambar' => $gambar
        ];
    }

    // Redirect agar tidak repost saat refresh
    header("Location: keranjang.php");
    exit;
}

// Tidak perlu lagi mengambil $kembali_id dari session karena akan langsung ke dashboard
// $kembali_id = isset($_SESSION['last_detail_id']) ? $_SESSION['last_detail_id'] : null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    <style>
        body {
            background: linear-gradient(to bottom right, #ffe6f0, #ffffff);
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .top-bar {
            display: flex;
            align-items: center;
            padding: 15px 30px;
            background-color: transparent;
        }

        .top-bar a {
            text-decoration: none;
            color: #d63384;
            font-weight: bold;
            font-size: 16px;
            background-color: #fff0f5;
            padding: 8px 15px;
            border-radius: 8px;
            border: 1px solid #d63384;
            transition: background-color 0.3s;
        }

        .top-bar a:hover {
            background-color: #ffcce0;
        }

        h2 {
            text-align: center;
            margin-top: 10px;
            color: #d63384;
        }

        table {
            margin: 30px auto;
            border-collapse: collapse;
            width: 90%;
            max-width: 1000px;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px;
            border: 1px solid #f3cce5;
            text-align: center;
        }

        th {
            background-color: #fddde6;
            color: #d63384;
        }

        img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            color: #d63384;
        }

        .btn {
            background-color: #d63384;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #c2185b;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <a href="dashboard.php">← Kembali ke Dashboard</a>
</div>

<h2>Keranjang Belanja</h2>

<?php if (empty($_SESSION['keranjang'])): ?>
    <p style="text-align:center;">Keranjang kosong 💔</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total = 0;
            foreach ($_SESSION['keranjang'] as $item):
                $subtotal = $item['jumlah'] * $item['harga'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><img src="../assets/img/<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama_produk']) ?>"></td>
                <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                <td><?= $item['jumlah'] ?></td>
                <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="total">Total Bayar</td>
                <td class="total">Rp <?= number_format($total, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    <form method="post" action="checkout.php" style="text-align:center;">
        <button type="submit" class="btn">💖 Proses Checkout</button>
    </form>
<?php endif; ?>

</body>
</html>