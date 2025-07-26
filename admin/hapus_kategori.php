<?php
include '../auth.php';
include '../config/koneksi.php';

$id = $_GET['id'];

$hapus = mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori=$id");
header("Location: data_kategori.php");
exit;
?>
