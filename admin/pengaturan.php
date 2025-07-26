<?php
include '../auth.php';
include '../config/koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM pengaturan WHERE id = 1");
$data = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_toko']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak']);

    $update = mysqli_query($conn, "UPDATE pengaturan SET 
        nama_toko = '$nama', deskripsi = '$deskripsi', kontak = '$kontak'
        WHERE id = 1");

    if ($update) {
        $pesan = "✅ Pengaturan berhasil diperbarui.";
        $data = ['nama_toko' => $nama, 'deskripsi' => $deskripsi, 'kontak' => $kontak];
    } else {
        $pesan = "❌ Gagal menyimpan pengaturan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Sistem</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff0f5;
            color: #333;
            padding: 40px;
        }

        .container {
            max-width: 650px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #cc0066;
            margin-bottom: 25px;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(255, 105, 180, 0.2);
            position: relative;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #444;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ffc0cb;
            border-radius: 8px;
            background: #fffafc;
            margin-bottom: 20px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .back-button {
            text-decoration: none;
            background-color: #ffb6c1;
            color: #fff;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            transition: 0.3s;
        }

        .back-button:hover {
            background-color: #cc0066;
        }

        button[type="submit"] {
            background-color: #ff69b4;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #cc0066;
        }

        .pesan {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #d6006c;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Pengaturan Toko</h2>

    <?php if (isset($pesan)) : ?>
        <div class="pesan"><?= $pesan; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="nama_toko">Nama Toko:</label>
        <input type="text" id="nama_toko" name="nama_toko" value="<?= htmlspecialchars($data['nama_toko']); ?>" required>

        <label for="deskripsi">Deskripsi:</label>
        <textarea id="deskripsi" name="deskripsi" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>

        <label for="kontak">Kontak:</label>
        <input type="text" id="kontak" name="kontak" value="<?= htmlspecialchars($data['kontak']); ?>" required>

        <div class="form-buttons">
            <a href="dashboard.php" class="back-button">← Kembali</a>
            <button type="submit">💾 Simpan</button>
        </div>
    </form>
</div>

</body>
</html>
