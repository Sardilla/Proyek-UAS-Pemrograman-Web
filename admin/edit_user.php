<?php
include '../auth.php';
include '../config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = $_POST['role'];

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $update = "UPDATE users SET nama_lengkap='$nama', username='$username', password='$password', role='$role' WHERE id=$id";
    } else {
        $update = "UPDATE users SET nama_lengkap='$nama', username='$username', role='$role' WHERE id=$id";
    }

    if (mysqli_query($conn, $update)) {
        header("Location: data_user.php");
        exit;
    } else {
        $error = "Gagal mengupdate data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengguna</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff0f5;
            padding: 40px;
        }

        .container {
            background: white;
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.15);
        }

        h2 {
            color: #b30059;
            margin-bottom: 25px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #b30059;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #f5c1d0;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        button {
            background-color: #ff69b4;
            color: white;
            padding: 10px 20px;
            border: none;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #d6006c;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #b30059;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Pengguna</h2>

    <?php if (isset($error)) : ?>
        <p class="error"><?= $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nama Lengkap:</label>
        <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($data['nama_lengkap']); ?>" required>

        <label>Username:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($data['username']); ?>" required>

        <label>Password (kosongkan jika tidak diubah):</label>
        <input type="password" name="password">

        <label>Role:</label>
        <select name="role" required>
            <option value="user" <?= $data['role'] === 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>

        <button type="submit">Update</button>
    </form>

    <a href="data_user.php" class="back-link">← Kembali ke Data User</a>
</div>

</body>
</html>
