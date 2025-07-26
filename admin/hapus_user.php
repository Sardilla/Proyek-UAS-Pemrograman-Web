<?php
include '../auth.php';
include '../config/koneksi.php';

$id = $_GET['id'];

// Cegah menghapus diri sendiri (opsional)
if ($_SESSION['id_user'] == $id) {
    echo "Tidak dapat menghapus akun sendiri.";
    exit;
}

$hapus = mysqli_query($conn, "DELETE FROM users WHERE id=$id");
header("Location: data_user.php");
exit;
?>
