<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

$id_produk = intval($_POST['id_produk']);
$act = $_POST['act'] ?? '';

if (!isset($_SESSION['keranjang'][$id_produk])) {
    echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
    exit;
}

if ($act === 'plus') {
    $_SESSION['keranjang'][$id_produk]++;
} elseif ($act === 'min' && $_SESSION['keranjang'][$id_produk] > 1) {
    $_SESSION['keranjang'][$id_produk]--;
}

// Hitung total baru
include "../data_produk.php";
$total = 0;
foreach ($_SESSION['keranjang'] as $id => $qty) {
    if (!isset($products[$id])) continue;
    $harga = intval(str_replace(['Rp', '.', ' '], '', $products[$id][2]));
    $total += $harga * $qty;
}

echo json_encode([
    'status' => 'success',
    'qty' => $_SESSION['keranjang'][$id_produk],
    'total' => number_format($total, 0, ',', '.')
]);
exit;
?>
