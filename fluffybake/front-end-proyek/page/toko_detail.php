<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include "data_produk.php";

$id_produk = $_GET['id_produk'] ?? '';
if (!isset($products[$id_produk])) {
  echo "<h2 style='text-align:center; padding:50px;'>Produk tidak ditemukan</h2>";
  exit;
}

$p = $products[$id_produk];
?>

<link rel="stylesheet" href="assets/css/store_detail.css">

<main class="detail-page">

  <a href="javascript:history.back()" class="back-link">
    <img src="assets/img/back.png" alt="Back">
  </a>

  <div class="detail-container">
    <div class="detail-image">
      <img src="assets/img/<?= $p[0] ?>" alt="<?= $p[1] ?>">
    </div>
    <div class="detail-info">
      <h1 class="detail-name"><?= $p[1] ?></h1>
      <p class="detail-price"><?= $p[2] ?></p>
      <p class="detail-description"><?= $p[4] ?></p>

      <div class="detail-actions">
        <div class="quantity-selector">
          <button onclick="changeQty(<?= $id_produk ?>, -1)">-</button>
          <span id="qty-view-<?= $id_produk ?>">1</span>
          <input type="hidden" id="qty-<?= $id_produk ?>" value="1">
          <button onclick="changeQty(<?= $id_produk ?>, 1)">+</button>
        </div>
        <button class="add-to-cart-btn" onclick="addToCart(<?= $id_produk ?>)">ADD CART</button>
      </div>
    </div>
  </div>
</main>

<div id="notif-box" class="notif-hidden"></div>

<script>
function changeQty(id, val) {
  let qtyView = document.getElementById('qty-view-' + id);
  let qtyInput = document.getElementById('qty-' + id);
  let qty = parseInt(qtyView.innerText) + val;
  if (qty < 1) qty = 1;
  qtyView.innerText = qty;
  qtyInput.value = qty;
}

function showNotif(message, isError = false) {
  let box = document.getElementById('notif-box');
  box.innerHTML = message;
  box.className = isError ? 'notif notif-error' : 'notif notif-success';
  setTimeout(() => { box.className = 'notif-hidden'; }, 2000);
}

function addToCart(id_produk) {
  let qty = document.getElementById('qty-' + id_produk).value;
  let formData = new FormData();
  formData.append('id_produk', id_produk);
  formData.append('qty', qty);

  fetch('actions/add_to_cart.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(result => {
    if (result.trim() === 'SUCCESS') {
      showNotif('✅ Produk berhasil ditambahkan ke keranjang');
    } else {
      showNotif('❌ Gagal menambahkan produk', true);
    }
  });
}
</script>
