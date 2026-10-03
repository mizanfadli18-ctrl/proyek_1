<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "penjualan_db";  // pastikan sesuai dengan nama database kamu

// Gunakan nama variabel $conn (bukan $koneksi)
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
