<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "delicia_by_dilla";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
