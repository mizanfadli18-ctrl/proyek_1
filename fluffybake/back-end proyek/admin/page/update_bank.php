<?php
session_start();
include '../koneksi.php';

$id_toko = $_SESSION['id_toko'] ?? 1;
$bri = $_POST['bri'];
$bni = $_POST['bni'];
$mandiri = $_POST['mandiri'];
$bca = $_POST['bca'];
$permata = $_POST['permata'];

$q = "UPDATE toko SET bri='$bri', bni='$bni', mandiri='$mandiri', bca='$bca', permata='$permata' WHERE id_toko=$id_toko";

if (mysqli_query($conn, $q)) {
  echo "<script>alert('Berhasil disimpan');window.location='index.php?page=profil_view';</script>";
} else {
  echo "Gagal: " . mysqli_error($conn);
}
?>
