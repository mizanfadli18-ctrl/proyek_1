<?php
header("Content-Type: application/json");
session_start();
require_once __DIR__ . '/../koneksi.php';

$id_user = isset($_GET['id_user']) ? (int)$_GET['id_user'] : (isset($_SESSION['id_user']) ? (int)$_SESSION['id_user'] : 0);

$q = "
    SELECT k.*, p.nama_produk, p.harga, p.gambar_produk
    FROM keranjang k
    LEFT JOIN produk p ON k.id_produk = p.id_produk
    WHERE k.id_user = ?
";

$stmt = mysqli_prepare($conn, $q);
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$list = [];
while ($row = mysqli_fetch_assoc($res)) {
    $list[] = $row;
}

echo json_encode($list);
