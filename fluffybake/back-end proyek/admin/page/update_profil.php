<?php
include '../koneksi.php';
session_start();

$id_toko = $_SESSION['id_toko'] ?? 1;

$nama = $_POST['nama_toko'];
$email = $_POST['email'];
$telepon = $_POST['nomor_telepon'];
$alamat = $_POST['alamat'];
$jenis = $_POST['jenis_penjualan'];

$upd = "UPDATE toko SET 
  nama_toko='$nama',
  email='$email',
  nomor_telepon='$telepon',
  alamat='$alamat',
  jenis_penjualan='$jenis'
  WHERE id_toko=$id_toko";

if (mysqli_query($conn, $upd)) {
  header("Location: index.php?page=edit_bank");
} else {
  echo "Error: " . mysqli_error($conn);
}
?>
