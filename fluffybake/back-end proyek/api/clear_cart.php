<?php
header("Content-Type: application/json");
session_start();
require_once __DIR__ . '/../koneksi.php';

$id_user = $_POST['id_user'] ?? (isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null);
if (!$id_user) {
    echo json_encode(["status"=>"error","message"=>"id_user missing"]);
    exit;
}

$stmt = mysqli_prepare($conn, "DELETE FROM keranjang WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, "i", $id_user);
$ok = mysqli_stmt_execute($stmt);
$error = mysqli_error($conn);
mysqli_stmt_close($stmt);

if ($ok) echo json_encode(["status"=>"success"]);
else echo json_encode(["status"=>"error","message"=>$error]);
