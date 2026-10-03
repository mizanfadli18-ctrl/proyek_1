<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "../koneksi.php";

$id_user    = $_SESSION['id_user'] ?? 0;
$id_pesanan = $_POST['id_pesanan'] ?? 0;
$message    = trim($_POST['message'] ?? '');

if (!$id_pesanan || $message == '') {
    echo json_encode(["status"=>"error","msg"=>"Data tidak lengkap"]);
    exit;
}

// cek pesanan milik pembeli
$q = mysqli_query($conn, "SELECT id_user FROM pesanan WHERE id_pesanan='$id_pesanan'");
$d = mysqli_fetch_assoc($q);

if (!$d || $d['id_user'] != $id_user) {
    echo json_encode(["status"=>"error","msg"=>"Akses ditolak"]);
    exit;
}

$messageEsc = mysqli_real_escape_string($conn, $message);

mysqli_query($conn, "
    INSERT INTO chat (id_pesanan, sender, message)
    VALUES ('$id_pesanan','pembeli','$messageEsc')
");

echo json_encode(["status"=>"success"]);
