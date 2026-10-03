<?php
require_once "../../koneksi.php";
header("Content-Type: application/json");

$id_pesanan = $_POST['id_pesanan'] ?? 0;
$message    = trim($_POST['message'] ?? '');

if (!$id_pesanan || $message == '') {
    echo json_encode(["status"=>"error","msg"=>"Data tidak lengkap"]);
    exit;
}

$messageEsc = mysqli_real_escape_string($conn, $message);

$sql = "
    INSERT INTO chat (id_pesanan, sender, message)
    VALUES ('$id_pesanan', 'penjual', '$messageEsc')
";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error","msg"=>"DB error"]);
}
