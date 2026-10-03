<?php
// ===== START: SESSION & KONEKSI DATABASE =====
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . "/../koneksi.php"; // koneksi aman
?>
<link rel="stylesheet" href="assets/css/beranda.css">

<!-- ================== HERO SECTION ================== -->
<section id="section-hero" class="hero-section">
  <div class="container hero-content">
    <img src="assets/img/logo1.png" class="hero-logo">
    <h1 class="welcome-title">Selamat datang fluffybake cake and cookies</h1>
  </div>
</section>

<!-- ================== LOOP KATEGORI OTOMATIS DARI DATABASE ================== -->
<?php
// Ambil semua kategori dari tabel kategori
$kategori_query = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori ASC");

while ($kategori_row = mysqli_fetch_assoc($kategori_query)):
  $kategori = ucfirst($kategori_row['nama_kategori']);
  $id_kat = $kategori_row['id_kategori'];
?>
<section class="product-section">
  <div class="container">
    <h2 class="category-title"><?= htmlspecialchars($kategori) ?></h2>
    <div class="product-grid">
      <?php
      // Ambil produk berdasarkan id_kategori
      $produk_query = mysqli_query(
        $conn,
        "SELECT p.*, k.nama_kategori 
         FROM produk p
         LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
         WHERE p.id_kategori = '$id_kat'
         ORDER BY p.id_produk DESC"
      );

      if (mysqli_num_rows($produk_query) > 0):
        while ($p = mysqli_fetch_assoc($produk_query)):
      ?>
        <article class="product-card">
          <!-- Gambar Produk -->
          <a href="index.php?url=detail&id_produk=<?= $p['id_produk'] ?>">
            <img src="assets/img/<?= htmlspecialchars($p['gambar_produk']) ?>" 
                 alt="<?= htmlspecialchars($p['nama_produk']) ?>" 
                 class="product-image">
          </a>

          <!-- Detail Produk -->
          <div class="product-details">
            <p class="product-name">
              <?= htmlspecialchars($p['nama_produk']) ?><br>
              <span>Rp <?= number_format($p['harga'], 0, ',', '.') ?> / box</span>
            </p>

            <div class="product-actions">
              <div class="quantity-selector">
                <button class="quantity-btn minus" data-id="<?= $p['id_produk'] ?>">−</button>
                <span class="quantity-value" id="view-<?= $p['id_produk'] ?>">1</span>
                <button class="quantity-btn plus" data-id="<?= $p['id_produk'] ?>">+</button>
              </div>

              <!-- Input tersembunyi untuk qty -->
              <input type="hidden" id="qty-<?= $p['id_produk'] ?>" class="form-qty" value="1">

              <!-- Tombol Add Cart AJAX -->
              <button class="add-to-cart-btn" type="button" onclick="addToCart(<?= $p['id_produk'] ?>)">ADD CART</button>
            </div>
          </div>
        </article>
      <?php
        endwhile;
      else:
        echo "<p style='text-align:center; color:#555;'>Produk belum tersedia di kategori ini.</p>";
      endif;
      ?>
    </div>
  </div>
</section>
<?php endwhile; ?>

<footer class="site-footer"></footer>

<!-- ================== SCRIPT JS ================== -->
<script>
// ===== Fungsi + dan - =====
document.querySelectorAll('.quantity-btn').forEach(btn => {
  btn.addEventListener('click', function () {
    const id = this.getAttribute('data-id');
    const qtyView = document.getElementById('view-' + id);
    const qtyInput = document.getElementById('qty-' + id);
    let qty = parseInt(qtyView.innerText);

    if (this.classList.contains('plus')) {
      qty++;
    } else if (this.classList.contains('minus') && qty > 1) {
      qty--;
    }

    qtyView.innerText = qty;
    qtyInput.value = qty;
  });
});

// ===== AJAX Add to Cart =====
function addToCart(id_produk) {
  const qty = document.getElementById('qty-' + id_produk).value;

  let formData = new FormData();
  formData.append('id_produk', id_produk);
  formData.append('qty', qty);

  fetch('actions/add_to_cart.php', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(result => {
      if (result.trim() === 'SUCCESS') {
        showNotification('✅ Produk ditambahkan ke keranjang');
      } else {
        showNotification('❌ Gagal menambahkan produk', true);
      }
    });
}

// ===== Notifikasi popup =====
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
  border-radius: 10px;
  z-index: 1000;
  font-size: 14px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
.cart-notification.error { background-color: #d9534f; }
</style>
