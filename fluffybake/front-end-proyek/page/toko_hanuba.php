<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/../koneksi.php';

// ==============================
// Ambil ID TOKO dari URL
// Contoh URL: index.php?url=toko&id_toko=1
// ==============================
$id_toko = $_GET['id_toko'] ?? null;

// Jika id_toko ada, ambil data toko sesuai id_toko
if ($id_toko) {
    $query_toko = mysqli_query($conn, "SELECT * FROM toko WHERE id_toko = '$id_toko'");
} else {
    // Jika tidak ada id_toko di URL, ambil toko pertama dari database
    $query_toko = mysqli_query($conn, "SELECT * FROM toko LIMIT 1");
}
$toko = mysqli_fetch_assoc($query_toko);

// ==============================
// Ambil produk berdasarkan id_toko (jika ada), jika tidak tampilkan semua produk
// ==============================
if ($id_toko) {
    $query_produk = mysqli_query($conn, "SELECT * FROM produk WHERE id_toko = '$id_toko' ORDER BY id_produk ASC");
} else {
    $query_produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk ASC");
}
?>

<link rel="stylesheet" href="assets/css/toko_hanuba.css?v=<?= time(); ?>">

<section class="store-content">
  <a href="index.php?url=store" class="back-link"><img src="assets/img/back.png"></a>

  <div class="store-profile">
    <img src="assets/img/<?= $toko['logo_toko'] ?? 'hanuba1.png' ?>" class="store-logo">
    <h1 class="store-name"><?= $toko['nama_toko'] ?></h1>
  </div>

  <div class="store-description">
    <?= $toko['nama_toko'] ?> berlokasi di <?= $toko['alamat'] ?>.<br>
    Menjual produk homemade seperti <?= $toko['jenis_penjualan'] ?>.
  </div>

  <section class="product-section">
    <div class="product-grid">
      <?php while ($p = mysqli_fetch_assoc($query_produk)) : ?>
        <article class="product-card">
          <img src="assets/img/<?= $p['gambar_produk'] ?>" class="product-image">
          <div class="product-details">
            <p class="product-title"><?= $p['nama_produk'] ?></p>
            <p class="product-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
            <div class="product-actions">
              <button class="quantity-btn minus" data-id="<?= $p['id_produk'] ?>">-</button>
              <span class="quantity-value" id="view-<?= $p['id_produk'] ?>">1</span>
              <button class="quantity-btn plus" data-id="<?= $p['id_produk'] ?>">+</button>
              <input type="hidden" id="qty-<?= $p['id_produk'] ?>" value="1">
              <button class="btn-add-cart" onclick="addToCart(<?= $p['id_produk'] ?>)">ADD CART</button>
            </div>
          </div>
        </article>
      <?php endwhile; ?>
    </div>
  </section>
</section>

<script src="assets/bootstrap-3.3.7-dist/js/cart_handler.js?v=<?= time(); ?>"></script>
