<?php
include '../auth.php';
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil gambar untuk hapus file fisiknya (jika ingin)
    $query = mysqli_query($conn, "SELECT gambar FROM produk WHERE id_produk = $id");
    $data = mysqli_fetch_assoc($query);
    if ($data && !empty($data['gambar'])) {
        $gambarPath = '../assets/img/' . $data['gambar'];
        if (file_exists($gambarPath)) {
            unlink($gambarPath); // hapus file gambar dari folder
        }
    }

    $hapus = mysqli_query($conn, "DELETE FROM produk WHERE id_produk = $id");

    if ($hapus) {
        header("Location: data_produk.php");
        exit;
    } else {
        echo "Gagal menghapus produk.";
    }
} else {
    echo "ID tidak ditemukan.";
}
