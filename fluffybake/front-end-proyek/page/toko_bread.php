<?php
// pages/toko_bread.php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/../data_produk.php'; // memastikan data tersedia

// Filter hanya produk milik toko Bread (dengan value 'bread' pada index 5)
$produk_bread = array_filter($products, fn($p) => isset($p[5]) && $p[5] === 'bread');
?>
<link rel="stylesheet" href="assets/css/toko_bread.css?v=1">

<section class="store-page">
  <a href="index.php?url=store" class="back-arrow"><img src="assets/img/back.png" alt="Back"></a>

  <section class="store-info">
    <img src="assets/img/bread.png" class="store-logo" alt="Bread Logo">
    <h1 class="store-name">Toko Bread</h1>
    <div class="store-description-box">
      Toko Bread berlokasi di Desa Semangat RT/RW 006/003 kec. Kertasmaya kab. Indramayu. Menjual berbagai Cake dan Cookies homemade.
    </div>
  </section>

  <section class="product-section">
    <div class="product-grid">
      <?php foreach ($produk_bread as $id => $p): ?>
        <article class="product-card">
          <img src="assets/img/<?= htmlspecialchars($p[0]) ?>" class="product-image" alt="<?= htmlspecialchars($p[1]) ?>">

          <div class="product-details">
            <p class="product-title"><?= htmlspecialchars($p[1]) ?></p>
            <p class="product-price"><?= htmlspecialchars($p[2]) ?></p>

            <div class="product-actions">
              <button class="quantity-btn minus" data-id="<?= (int)$id ?>">−</button>
              <span class="quantity-value" id="view-<?= (int)$id ?>">1</span>
              <button class="quantity-btn plus" data-id="<?= (int)$id ?>">+</button>
              <input type="hidden" id="qty-<?= (int)$id ?>" value="1">
              <button class="btn-add-cart" onclick="addToCart(<?= (int)$id ?>)">ADD CART</button>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>
</section>

<!-- 🟢 WAJIB: Panggil JavaScript dengan path BENAR -->
<script src="assets/bootstrap-3.3.7-dist/js/cart_handler.js?v=<?php echo time(); ?>"></script>
