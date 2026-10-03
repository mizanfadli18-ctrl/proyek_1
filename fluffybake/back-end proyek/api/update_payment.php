<?php
header("Content-Type: application/json");
session_start();
require_once __DIR__ . '/../koneksi.php';

$id_pesanan = $_POST['id_pesanan'] ?? null;
$status = $_POST['status'] ?? null;

if (!$id_pesanan || !$status) {
    echo json_encode(["status"=>"error","message"=>"parameter kurang"]);
    exit;
}

$stmt = mysqli_prepare($conn, "UPDATE pesanan SET status = ? WHERE id_pesanan = ?");
mysqli_stmt_bind_param($stmt, "ss", $status, $id_pesanan);
$ok = mysqli_stmt_execute($stmt);
$error = mysqli_error($conn);
mysqli_stmt_close($stmt);

if ($ok) echo json_encode(["status"=>"success","message"=>"Status diperbarui"]);
else echo json_encode(["status"=>"error","message"=>$error]);
