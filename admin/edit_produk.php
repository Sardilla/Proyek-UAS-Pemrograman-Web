<?php
include '../auth.php';
include '../config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id_produk=$id"));
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

if (!$data) {
    echo "Produk tidak ditemukan!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $id_kategori = $_POST['id_kategori'];

    $update = mysqli_query($conn, "UPDATE produk SET 
        nama_produk='$nama', deskripsi='$deskripsi', harga='$harga', stok='$stok', id_kategori='$id_kategori' 
        WHERE id_produk=$id");

    if ($update) {
        header("Location: data_produk.php");
        exit;
    } else {
        $error = "Gagal update produk.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff0f5;
            padding: 40px;
        }

        h2 {
            text-align: center;
            color: #cc0066;
            margin-bottom: 30px;
        }

        form {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(255, 105, 180, 0.1);
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #cc0066;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px 14px;
            margin-bottom: 20px;
            border: 1px solid #ffd6e8;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            background-color: #ff69b4;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            margin-right: 10px;
        }

        button:hover {
            background-color: #d6006c;
        }

        a {
            text-decoration: none;
            background-color: #ccc;
            color: #333;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
        }

        a:hover {
            background-color: #999;
        }

        .error {
            color: red;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Edit Produk</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Nama Produk:</label>
        <input type="text" name="nama_produk" value="<?= htmlspecialchars($data['nama_produk']); ?>" required>

        <label>Deskripsi:</label>
        <textarea name="deskripsi" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>

        <label>Harga:</label>
        <input type="number" name="harga" value="<?= $data['harga']; ?>" required>

        <label>Stok:</label>
        <input type="number" name="stok" value="<?= $data['stok']; ?>" required>

        <label>Kategori:</label>
        <select name="id_kategori" required>
            <?php while ($k = mysqli_fetch_assoc($kategori)) : ?>
                <option value="<?= $k['id_kategori']; ?>" <?= $k['id_kategori'] == $data['id_kategori'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($k['nama_kategori']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Update</button>
        <a href="data_produk.php">Kembali</a>
    </form>

</body>
</html>
