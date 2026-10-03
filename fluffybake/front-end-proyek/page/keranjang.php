<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include "koneksi.php"; // koneksi ke database

// Ambil data keranjang dari session
$keranjang = $_SESSION['keranjang'] ?? [];
?>
<link rel="stylesheet" href="assets/css/keranjang.css?=v1">

<main class="cart-page">
  <div class="container">

    <!-- Tombol kembali -->
    <a href="javascript:history.back()" class="back-link">
      <img src="assets/img/back.png" alt="Back">
    </a>

    <!-- Judul -->
    <h1 style="margin-bottom: 40px;">Keranjang Belanja</h1>

    <div class="cart-content">
      <?php if (empty($keranjang)): ?>
        <p>Keranjang kosong.</p>
      <?php else: ?>
        <?php
        $total = 0;

        foreach ($keranjang as $id_produk => $qty):
          // Ambil data produk dari database berdasarkan id_produk
          $query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id_produk LIMIT 1");
          $p = mysqli_fetch_assoc($query);

          if (!$p) continue; // Jika produk tidak ditemukan, skip

          $nama  = $p['nama_produk'];
$harga = $p['harga'];
$gambar = $p['gambar_produk']; // ✅ kolom yang benar
$subtotal = $harga * $qty;
$total += $subtotal;

        ?>
        <div class="cart-item" id="item-<?= $id_produk ?>">
          <div class="item-info">
            <img src="assets/img/ceklis2.png" alt="Checklist" class="item-checkbox">
            <img src="assets/img/<?= htmlspecialchars($gambar) ?>" alt="<?= htmlspecialchars($nama) ?>" class="item-image">
            <div class="item-details">
              <p class="item-name"><?= htmlspecialchars($nama) ?></p>
              <p class="item-price">Rp <?= number_format($harga, 0, ',', '.') ?></p>
            </div>
          </div>

          <div class="item-controls">
            <!-- Tombol Plus Minus -->
            <div class="quantity-selector">
              <button class="quantity-btn" onclick="updateQty(<?= $id_produk ?>, 'min')">
                <img src="assets/img/minus.png" alt="Kurang">
              </button>
              <span class="quantity-value" id="qty-<?= $id_produk ?>"><?= $qty ?></span>
              <button class="quantity-btn" onclick="updateQty(<?= $id_produk ?>, 'plus')">
                <img src="assets/img/vector.png" alt="Tambah">
              </button>
            </div>

            <!-- Tombol Hapus -->
            <button class="delete-btn" onclick="removeItem(<?= $id_produk ?>)">
              <img src="assets/img/sampah.png" alt="Hapus">
            </button>
          </div>
        </div>
        <?php endforeach; ?>

        <!-- Total -->
        <div class="cart-summary">
          <p class="store-info">Toko: Fluffybake</p>
          <p class="total-price">Total <span id="total">Rp <?= number_format($total, 0, ',', '.') ?></span></p>
        </div>

        <!-- Tombol Checkout -->
        <div class="checkout-action">
         <?php if (!isset($_SESSION['id_user'])): ?>
  <a href="index.php?url=login&redirect=transaksi" class="checkout-button">
    Melakukan Pembayaran
  </a>
<?php else: ?>
  <a href="index.php?url=transaksi" class="checkout-button">
    Melakukan Pembayaran
  </a>
<?php endif; ?>

        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<footer class="site-footer"></footer>

<script>
// ====== UPDATE JUMLAH PRODUK TANPA RELOAD ======
function updateQty(id_produk, act) {
  let formData = new FormData();
  formData.append('id_produk', id_produk);
  formData.append('act', act);

  fetch('actions/update_cart.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      document.getElementById('qty-' + id_produk).innerText = data.qty;
      document.getElementById('total').innerText = 'Rp ' + data.total;
    } else {
      showNotification('❌ ' + data.message, true);
    }
  })
  .catch(() => showNotification('❌ Gagal memperbarui jumlah!', true));
}

function removeItem(id_produk) {
  let formData = new FormData();
  formData.append('id_produk', id_produk);

  fetch('actions/remove_from_cart.php', {
    method: 'POST',
    body: formData
  })
  .then(() => {
    document.getElementById('item-' + id_produk).remove();
    showNotification('🗑️ Produk dihapus dari keranjang');
  });
}

function showNotification(message, isError = false) {
  let notif = document.createElement('div');
  notif.className = 'cart-notification ' + (isError ? 'error' : 'success');
  notif.innerText = message;
  document.body.appendChild(notif);
  setTimeout(() => notif.remove(), 2000);
}
</script>

<style>
.cart-notification {
  position: fixed;
  top: 20px;
  right: 20px;
  background-color: #5a3b2e;
  color: white;
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 14px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  z-index: 9999;
}
.cart-notification.error { background-color: red; }
</style>
