<?php
session_start();
include '../config/koneksi.php';

// Cek login user
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['user']['id_user'];

// Cek apakah ada ID transaksi yang dikirim
if (isset($_GET['id'])) {
    $id_transaksi = intval($_GET['id']);

    // Pastikan transaksi milik user yang sedang login
    $cek = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi' AND id_user = '$id_user'");
    if (mysqli_num_rows($cek) > 0) {

        // Hapus detail transaksi terlebih dahulu
        mysqli_query($conn, "DELETE FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'");

        // Hapus transaksi utama
        mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");

        // Redirect kembali ke halaman detail transaksi
        header("Location: detail_transaksi.php");
        exit;
    } else {
        echo "Transaksi tidak ditemukan atau bukan milik Anda.";
    }
} else {
    echo "ID transaksi tidak valid.";
}
?>
