<?php 
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Ambil data dari session
$role = $_SESSION['user']['role'] ?? null;
$current_path = $_SERVER['PHP_SELF'];

// Jika admin coba akses halaman user
if (strpos($current_path, '/user/') !== false && $role !== 'user') {
    header("Location: ../admin/dashboard.php");
    exit;
}

// Jika user coba akses halaman admin
if (strpos($current_path, '/admin/') !== false && $role !== 'admin') {
    header("Location: ../user/dashboard.php");
    exit;
}
?>
