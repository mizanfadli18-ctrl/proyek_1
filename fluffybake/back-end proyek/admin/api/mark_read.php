<?php
require_once "../koneksi.php";

$id_pesanan = $_POST['id_pesanan'] ?? 0;

mysqli_query($conn,"
    UPDATE chat SET is_read=1
    WHERE id_pesanan='$id_pesanan'
");

echo json_encode(["status" => "ok"]);
