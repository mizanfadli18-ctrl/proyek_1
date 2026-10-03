<?php
header("Content-Type: application/json");
session_start();
require_once "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    echo json_encode([
        "status" => "error",
        "message" => "User belum login"
    ]);
    exit;
}

$id_user = $_SESSION['id_user'];
$id_produk = $_POST['id_produk'] ?? null;
$jumlah = $_POST['jumlah'] ?? 1;

// --- Ambil data user ---
$user = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT nama_lengkap, alamat, no_telepon 
     FROM user 
     WHERE id_user='$id_user'"
));

if (!$user) {
    echo json_encode(["status" => "error", "message" => "User tidak ditemukan"]);
    exit;
}

$nama_pembeli = $user['nama_lengkap'];
$alamat = $user['alamat'];
$no_telepon = $user['no_telepon'];

// --- Ambil data produk ---
$produk = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT * FROM produk WHERE id_produk='$id_produk'"
));

if (!$produk) {
    echo json_encode(["status" => "error", "message" => "Produk tidak ditemukan"]);
    exit;
}

$nama_produk = $produk['nama_produk'];
$harga = $produk['harga'];
$gambar = $produk['gambar_produk'];

$total = $harga * $jumlah;

// --- Simpan pesanan ke tabel ---
$q = mysqli_query($conn, "
    INSERT INTO pesanan (
        id_user, 
        id_produk,
        jumlah,
        nama_pembeli,
        nama_produk,
        gambar,
        total,
        alamat,
        no_telepon,
        status,
        tanggal_pesan
    ) VALUES (
        '$id_user',
        '$id_produk',
        '$jumlah',
        '$nama_pembeli',
        '$nama_produk',
        '$gambar',
        '$total',
        '$alamat',
        '$no_telepon',
        'Menunggu',
        NOW()
    )
");

// --- Output JSON ---
if ($q) {
    echo json_encode([
        "status" => "success",
        "message" => "Pesanan berhasil dibuat"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);
}
?>
