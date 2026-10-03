<?php
session_start();
include "koneksi.php";

$id = $_POST['id_pesanan'] ?? null;

if ($id) {
    mysqli_query($conn, "UPDATE pesanan SET status='Dibatalkan Pembeli' WHERE id_pesanan='$id'");
}

echo "<script>
alert('Pesanan berhasil dibatalkan');
window.location='index.php?url=pesanan';
</script>";
