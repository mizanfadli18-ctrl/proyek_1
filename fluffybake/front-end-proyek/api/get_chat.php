<?php
require_once "../koneksi.php";

$id_pesanan = $_GET['id_pesanan'] ?? 0;

$q = mysqli_query($conn,"
    SELECT * FROM chat
    WHERE id_pesanan='$id_pesanan'
    ORDER BY waktu ASC
");

$data = [];
while ($c = mysqli_fetch_assoc($q)) {
    $data[] = $c;
}

header('Content-Type: application/json');
echo json_encode($data);
