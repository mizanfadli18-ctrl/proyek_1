<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$id_produk = intval($_POST['id_produk'] ?? 0);
$qty       = max(1, intval($_POST['qty'] ?? 1));

if ($id_produk <= 0) {
  echo "ERROR:INVALID_ID";
  exit;
}

if (!isset($_SESSION['keranjang'])) {
  $_SESSION['keranjang'] = [];
}

$_SESSION['keranjang'][$id_produk] = ($_SESSION['keranjang'][$id_produk] ?? 0) + $qty;

echo "SUCCESS";
exit;
