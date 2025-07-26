<?php
include '../auth.php';
include '../config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kategori WHERE id_kategori=$id"));

if (!$data) {
    echo "Kategori tidak ditemukan!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $update = mysqli_query($conn, "UPDATE kategori SET nama_kategori='$nama' WHERE id_kategori=$id");
    if ($update) {
        header("Location: data_kategori.php");
        exit;
    } else {
        $error = "Gagal mengupdate kategori.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(255, 105, 180, 0.2);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #cc0066;
            margin-bottom: 25px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ffd6e8;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #ff69b4;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #cc0066;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #cc0066;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Kategori</h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">
            <input type="text" name="nama_kategori" value="<?= htmlspecialchars($data['nama_kategori']); ?>" required>
            <button type="submit">Update</button>
        </form>

        <a class="back-link" href="data_kategori.php">← Kembali ke Data Kategori</a>
    </div>

</body>
</html>
