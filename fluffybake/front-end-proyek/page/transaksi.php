<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/../koneksi.php';

// 🔒 Jika user belum login → arahkan ke login, lalu kembali ke transaksi
if (!isset($_SESSION['id_user'])) {
  header("Location: index.php?url=login&redirect=transaksi");
  exit;
}

// Ambil data keranjang dari session
$keranjang = $_SESSION['keranjang'] ?? [];

// Jika keranjang kosong
if (empty($keranjang)) {
  echo "<script>alert('Keranjang masih kosong!');window.location='index.php?url=keranjang';</script>";
  exit;
}

// Hitung total dari database
$total = 0;
?>
<link rel="stylesheet" href="assets/css/trans_beli.css?=v1">

<header class="page-header">
  <div class="content-wrapper">
    <a href="index.php?url=keranjang" aria-label="Back">
      <img src="assets/img/back.png" alt="Back Arrow">
    </a>
  </div>
</header>

<main class="page-container">
  <div class="content-wrapper">

    <!-- ==== TOTAL PEMBAYARAN ==== -->
    <section id="payment-summary" class="card">
      <h2 class="summary-title">Total Pembayaran</h2>

      <?php
      foreach ($keranjang as $id_produk => $qty):
        $q = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id_produk");
        $p = mysqli_fetch_assoc($q);
        if (!$p) continue;

        $nama = $p['nama_produk'];
        $harga = $p['harga'];
        $gambar = $p['gambar_produk'];
        $subtotal = $harga * $qty;
        $total += $subtotal;
      ?>
      <div class="order-item">
        <div class="item-details">
          <img src="assets/img/<?= htmlspecialchars($gambar) ?>" alt="<?= htmlspecialchars($nama) ?>" class="item-image">
          <span class="item-name"><?= htmlspecialchars($nama) ?></span>
        </div>
        <div class="item-pricing">
          <span class="item-quantity"><?= $qty ?>x</span>
          <span class="item-price">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
        </div>
      </div>
      <?php endforeach; ?>

      <hr>
      <h3 style="text-align:right; font-weight:600; color:#5a3b2e;">
        Total: Rp <?= number_format($total, 0, ',', '.') ?>
      </h3>
    </section>

    <!-- ==== METODE PEMBAYARAN ==== -->
    <section id="payment-method">
      <h2 class="section-title">Metode Pembayaran</h2>
      <div class="payment-options-container">

        <div class="card payment-form-card">
          <h3 class="form-title">Transfer Bank</h3>

          <form class="payment-form" method="POST" action="api/create_transaksi.php">
            <div class="form-group">
                <label for="owner-name-input">Nama Pemilik Bank</label>
                <input type="text" id="owner-name-input" name="owner-name" class="form-input" 
                       value="<?= htmlspecialchars($_SESSION['nama']) ?>" required>
            </div>

            <div class="form-group">
                <label for="bank-name-input">Nama Bank atau Dana</label>
                <input type="text" id="bank-name-input" name="bank-name" class="form-input" 
                       placeholder="BANK MANDIRI / DANA" required>
            </div>

            <div class="form-group">
                <label for="account-number-input">No Rek</label>
                <input type="text" id="account-number-input" name="account-number" class="form-input" 
                       placeholder="Masukkan nomor rekening" required>
            </div>

            <button type="submit" class="submit-button">Kirim</button>
          </form>

        </div>

        <div class="card bank-list-card">
          <ul class="bank-list">
            <li class="bank-item"><img src="assets/img/BRI.png"><span>: 788********</span></li>
            <li class="bank-item"><img src="assets/img/MANDIRI.png"><span>: 788********</span></li>
            <li class="bank-item"><img src="assets/img/PERMATA.png"><span>: 788********</span></li>
            <li class="bank-item"><img src="assets/img/BNI.png"><span>: 788********</span></li>
            <li class="bank-item"><img src="assets/img/BCA.png"><span>: 788********</span></li>
          </ul>
        </div>

      </div>
    </section>
  </div>
</main>

<footer class="page-footer"></footer>
