<?php
session_start();
require_once 'config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Ambil user berdasarkan username
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) === 1) {
    $data = mysqli_fetch_assoc($result);

    // Cek password (pakai MD5)
    if ($data['password'] === md5($password)) {
        // SET session yang benar (perhatikan: kolom id, bukan id_user)
        $_SESSION['user'] = [
            'id_user' => $data['id'], // FIXED: ambil dari kolom 'id' di database
            'username' => $data['username'],
            'role' => $data['role']
        ];

        // Redirect berdasarkan role
        if ($data['role'] === 'admin') {
            header("Location: admin/dashboard.php");
            exit;
        } elseif ($data['role'] === 'user') {
            header("Location: user/dashboard.php");
            exit;
        } else {
            echo "Role tidak valid!";
        }
    } else {
        echo "Password salah!";
    }
} else {
    echo "Username tidak ditemukan!";
}
?>
