<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php?url=profil");
    exit;
}

$id = $_POST['id_user'];
$email = $_POST['email'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$password = $_POST['password'];

if ($password != "") {
    $sql = "UPDATE user SET 
                email='$email',
                nama_lengkap='$nama',
                alamat='$alamat',
                no_telepon='$no_hp',
                password='$password'
            WHERE id_user='$id'";
} else {
    $sql = "UPDATE user SET 
                email='$email',
                nama_lengkap='$nama',
                alamat='$alamat',
                no_telepon='$no_hp'
            WHERE id_user='$id'";
}

mysqli_query($conn, $sql);

echo "<script>alert('Profil berhasil diperbarui!');window.location='index.php?url=profil';</script>";
?>
