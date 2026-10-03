<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . "/../koneksi.php"; // koneksi aman
?>

<link rel="stylesheet" href="assets/css/pencarian.css">

<!-- ================= HERO (Back + Search Bar) ================= -->
<section id="section-hero" class="hero-section">
  <div class="container hero-container">
    <a href="javascript:history.back()" class="back-arrow">
      <img src="assets/img/back.png" alt="Back">
    </a>

    <form class="search-bar" method="get" action="index.php">
      <input type="hidden" name="url" value="pencarian">
      <input 
        type="text" 
        name="q" 
        placeholder="Search" 
        class="search-input" 
        value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
      >
      <button type="submit" class="search-btn">
        <img src="assets/img/pencarian.png" alt="Search Icon">
      </button>
    </form>
  </div>
</section>

<!-- ================= HASIL PENCARIAN ================= -->
<?php
$q = strtolower(trim($_GET['q'] ?? ''));

// Ambil semua kategori dari tabel kategori
$kategori_query = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori ASC");
$total_ditemukan = 0; // untuk hitung total hasil semua kategori

while ($kategori_row = mysqli_fetch_assoc($kategori_query)):
  $kategori = ucfirst($kategori_row['nama_kategori']);
  $id_kat = $kategori_row['id_kategori'];
?>
<section class="product-section">
  <div class="container">
    <h2 class="category-title"><?= htmlspecialchars($kategori) ?></h2>
    <div class="product-grid">
      <?php
      // Query produk: ambil semua produk dari kategori ini
      $sql = "SELECT * FROM produk WHERE id_kategori = '$id_kat'";
      if ($q != '') {
        $sql .= " AND (LOWER(nama_produk) LIKE '%$q%' OR LOWER(deskripsi) LIKE '%$q%')";
      }
      $sql .= " ORDER BY id_produk DESC";

      $produk_query = mysqli_query($conn, $sql);

      if (mysqli_num_rows($produk_query) > 0):
        $total_ditemukan += mysqli_num_rows($produk_query);
        while ($p = mysqli_fetch_assoc($produk_query)):
      ?>
        <!-- ====== PRODUK KARTU ====== -->
        <article class="product-card">
          <a href="index.php?url=detail&id_produk=<?= $p['id_produk'] ?>">
            <img src="assets/img/<?= htmlspecialchars($p['gambar_produk']) ?>" 
                 alt="<?= htmlspecialchars($p['nama_produk']) ?>" 
                 class="product-image">
          </a>

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
              <input type="hidden" id="qty-<?= $p['id_produk'] ?>" class="form-qty" value="1">
              <button class="add-to-cart-btn" type="button" onclick="addToCart(<?= $p['id_produk'] ?>)">ADD CART</button>
            </div>
          </div>
        </article>
      <?php
        endwhile;
      else:
        echo "<p style='text-align:center; font-weight:500; color:#5a3b2e;'>Tidak ada produk untuk kategori ini</p>";
      endif;
      ?>
    </div>
  </div>
</section>
<?php endwhile; ?>

<?php
// Jika semua kategori kosong (tidak ada hasil sama sekali)
if ($total_ditemukan == 0) {
  echo "<p style='text-align:center; font-size:18px; font-weight:bold; color:#5a3b2e; margin:40px 0;'>Produk tidak ditemukan</p>";
}
?>

<footer class="site-footer"></footer>

<!-- ================= SCRIPT JS ================= -->
<script>
// ===== Tombol + dan - =====
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

// ===== Notifikasi =====
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
