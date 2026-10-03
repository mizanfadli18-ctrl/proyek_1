<?php
header("Content-Type: application/json");
session_start();
require_once __DIR__ . '/../koneksi.php';

$id_pesanan = $_GET['id_pesanan'] ?? null;
if (!$id_pesanan) {
    echo json_encode(["status"=>"error","message"=>"id_pesanan missing"]);
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT p.*, u.nama_lengkap, u.alamat, u.no_telepon FROM pesanan p LEFT JOIN user u ON p.id_user = u.id_user WHERE p.id_pesanan = ?");
mysqli_stmt_bind_param($stmt, "s", $id_pesanan);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$data) {
    echo json_encode(["status"=>"error","message"=>"Pesanan tidak ditemukan"]);
} else {
    echo json_encode(["status"=>"success","data"=>$data]);
}
