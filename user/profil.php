<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['user']['id_user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon      = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat       = mysqli_real_escape_string($conn, $_POST['alamat']);

    $update = "UPDATE users SET 
                nama_lengkap = '$nama_lengkap',
                email = '$email',
                telepon = '$telepon',
                alamat = '$alamat'
               WHERE id = '$id_user'";
    mysqli_query($conn, $update);
    $success = "Profil berhasil diperbarui!";
}

$query = "SELECT * FROM users WHERE id = '$id_user'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya | Delicia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ffe4ec, #fef6f9);
            font-family: 'Segoe UI', sans-serif;
        }

        .profile-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 700px;
            margin: 60px auto;
        }

        .profile-title {
            text-align: center;
            color: #d63384;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        label {
            font-weight: 500;
            margin-bottom: 6px;
            color: #555;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .btn-simpan {
            background-color: #ff69b4;
            color: white;
            border: none;
            font-weight: bold;
            border-radius: 10px;
            padding: 10px 25px;
            transition: 0.3s;
        }

        .btn-simpan:hover {
            background-color: #e65399;
        }

        .btn-kembali {
            background-color: #6c757d;
            color: white;
            border: none;
            font-weight: bold;
            border-radius: 10px;
            padding: 10px 25px;
            margin-right: 10px;
            transition: 0.3s;
        }

        .btn-kembali:hover {
            background-color: #5a6268;
        }

        .alert-success {
            background: #eafaf1;
            border-left: 4px solid #3ac47d;
            color: #2e7d32;
            font-size: 14px;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php if (file_exists('../inc/navbar_user.php')) include '../inc/navbar_user.php'; ?>

<div class="profile-card">
    <div class="profile-title">💖 Profil Saya</div>

    <?php if (isset($success)) : ?>
        <div class="alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($user['telepon'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="3"><?= htmlspecialchars($user['alamat'] ?? '') ?></textarea>
        </div>
        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-kembali">🔙 Kembali ke Dashboard</a>
            <button type="submit" class="btn btn-simpan">💾 Simpan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>