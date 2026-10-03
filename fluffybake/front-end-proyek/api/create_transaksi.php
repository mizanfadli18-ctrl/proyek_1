<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['id_user'])) {
    die("User belum login");
}

$id_user = $_SESSION['id_user'];
$nama_pembeli = $_SESSION['nama'] ?? '-';
$keranjang = $_SESSION['keranjang'] ?? [];

if (empty($keranjang)) {
    die("Keranjang kosong");
}

$id_pesanan = time();
$status = 'Menunggu';

foreach ($keranjang as $id_produk => $jumlah) {

    // ambil data produk
    $q = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
    $p = mysqli_fetch_assoc($q);

    if (!$p) continue;

    $nama_produk = $p['nama_produk'];
    $gambar      = $p['gambar_produk'];
    $total       = $p['harga'] * $jumlah;

    mysqli_query($conn, "
        INSERT INTO pesanan 
        (id_pesanan, id_user, id_produk, jumlah, nama_pembeli, nama_produk, gambar, total, status)
        VALUES
        ('$id_pesanan', '$id_user', '$id_produk', '$jumlah',
         '$nama_pembeli', '$nama_produk', '$gambar', '$total', '$status')
    ");
}

// kosongkan keranjang setelah checkout
unset($_SESSION['keranjang']);

// redirect ke halaman pesanan
header("Location: ../index.php?url=pesanan&id=$id_pesanan");
exit;
