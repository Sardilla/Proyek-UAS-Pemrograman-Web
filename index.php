<?php
session_start();
include 'auth.php';
include 'config/koneksi.php';

$nama = $_SESSION['user']['username'] ?? 'User';
$role = $_SESSION['user']['role'] ?? 'user';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Delicia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #fef3f7;
        }
        .container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #d14c74;
        }
        p {
            font-size: 16px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: #d14c74;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            background: #ba3e66;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selamat datang, <?= htmlspecialchars($nama) ?>!</h2>
        <p>Anda login sebagai <strong><?= htmlspecialchars($role) ?></strong>.</p>

        <?php if ($role == 'admin'): ?>
            <a href="admin/dashboard.php">Masuk ke Admin Panel</a>
        <?php else: ?>
            <a href="user/dashboard.php">Masuk ke User Panel</a>
        <?php endif; ?>

        <br><br>
        <a href="logout.php" style="background: #999;">Logout</a>
    </div>
</body>
</html>
