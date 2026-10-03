<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$id_produk = intval($_POST['id_produk'] ?? 0);

if (isset($_SESSION['keranjang'][$id_produk])) {
    unset($_SESSION['keranjang'][$id_produk]);
}

echo "SUCCESS";
exit;
?>
