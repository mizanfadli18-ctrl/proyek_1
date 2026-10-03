<?php
include "data_produk.php";
include "koneksi.php";

$id_produk = $_GET['id_produk'] ?? '';
$produk = null;

// Ambil produk dari array atau database
if (isset($products[$id_produk])) {
    $produk = $products[$id_produk];
} else {
    $q = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    if ($q && mysqli_num_rows($q) > 0) {
        $produk = mysqli_fetch_assoc($q);
    }
}

if (!$produk) {
    echo "<h2 style='text-align:center;margin-top:80px;'>Produk tidak ditemukan</h2>";
    exit;
}

$gambar = isset($produk['gambar_produk']) ? $produk['gambar_produk'] : (isset($produk[0]) ? $produk[0] : 'default.png');
$nama = isset($produk['nama_produk']) ? $produk['nama_produk'] : $produk[1];
$deskripsi = isset($produk['deskripsi']) ? $produk['deskripsi'] : $produk[4];

// Pastikan harga angka murni
$harga_raw = isset($produk['harga']) ? $produk['harga'] : $produk[2];
$harga = (int) preg_replace('/\D/', '', $harga_raw);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Produk</title>
  <link rel="stylesheet" href="assets/css/detail.produk.css">
</head>
<body>

<section id="product-details" class="product-details-section">
  <div class="product-details-content">

    <!-- Tombol Back -->
    <a href="javascript:history.back()" class="back-link">
      <img src="assets/img/back.png" alt="Back" class="back-icon">
    </a>

    <main class="product-content">
      <img src="assets/img/<?= $gambar ?>" class="product-image" alt="<?= $nama ?>">

      <h1 class="product-title"><?= $nama ?></h1>

      <p class="product-description"><?= $deskripsi ?></p>

      <p class="product-price">Rp <?= number_format($harga, 0, ',', '.') ?></p>

      <div class="product-actions">
        <div class="quantity-selector">
          <button class="quantity-btn minus" onclick="updateQty(-1)">−</button>
          <span id="qty" class="quantity-value">1</span>
          <button class="quantity-btn plus" onclick="updateQty(1)">+</button>
        </div>
        <button class="add-to-cart-btn" onclick="addToCart('<?= $id_produk ?>')">ADD CART</button>
      </div>

      <p class="address-info">
        Alamat : Perumahan graha Sudirman Blok A3 no 02 kelemahan mekar kec.<br>
        indramayu kab indramayu
      </p>
    </main>
  </div>
</section>

<script>
let qty = 1;
function updateQty(change) {
    qty += change;
    if (qty < 1) qty = 1;
    document.getElementById('qty').textContent = qty;
}

function addToCart(id_produk){
    let formData = new FormData();
    formData.append('id_produk', id_produk);
    formData.append('qty', qty);
    fetch('actions/add_to_cart.php', {method:'POST', body:formData})
    .then(res=>res.text())
    .then(r=>{
        alert((r.trim()==='SUCCESS') ? '✅ Produk masuk keranjang!' : '❌ Gagal menambah!');
    });
}
</script>

</body>
</html>
