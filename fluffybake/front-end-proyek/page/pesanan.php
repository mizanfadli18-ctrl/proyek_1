<?php
require_once "koneksi.php";

$id_user = $_SESSION['id_user'] ?? null;
if (!$id_user) {
    echo "<p style='text-align:center'>Silakan login untuk melihat pesanan Anda.</p>";
    return;
}

$stmt = mysqli_prepare($conn, "
    SELECT * FROM pesanan 
    WHERE id_user = ? 
    AND status NOT IN ('Dibatalkan Pembeli', 'Ditolak Penjual')
    ORDER BY tanggal_pesan DESC
");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
?>

<link rel="stylesheet" href="assets/css/pesanan.ada.css?=v1">

<header class="site-header"> ... </header>

<main class="order-details-section">
  <div class="order-container">

    <a href="index.php?url=beranda" class="back-link">
      <img src="assets/img/back.png" alt="Back">
    </a>

    <?php if (mysqli_num_rows($res) == 0): ?>
      <p class="no-order">Belum ada pesanan.</p>

    <?php else: while($p = mysqli_fetch_assoc($res)): ?>

      <div class="order-card">

        <!-- GAMBAR -->
        <img class="product-image" 
             src="assets/img/<?= htmlspecialchars($p['gambar'] ?? 'cake1.png') ?>" 
             alt="<?= htmlspecialchars($p['nama_produk']) ?>">

        <!-- INFORMASI PRODUK -->
        <div class="order-info">
          <h2 class="product-name"><?= htmlspecialchars($p['nama_produk']) ?></h2>

          <div class="quantity-selector">
            <span class="quantity-display"><?= (int)$p['jumlah'] ?></span><span> pcs</span>
          </div>

          <p class="total-price">Total : <?= rupiah($p['total']) ?></p>

          <p class="buyer-name">
            Pembeli: <?= htmlspecialchars($p['nama_pembeli'] ?? $_SESSION['nama'] ?? '-') ?>
          </p>
        </div>

        <!-- AKSI / STATUS -->
        <div class="order-actions">

         <?php if ($p['status'] == 'Diterima'): ?>
    <a href="index.php?url=detail_pesanan&id=<?= $p['id_pesanan'] ?>" 
       class="action-button status-button" style="text-align:center;">
       Lihat Detail Pesanan
    </a>

    <a href="index.php?url=chat&id=<?= $p['id_pesanan'] ?>" 
       class="action-button status-button" 
       style="margin-top:10px;text-align:center;background:#5A3B2E;color:white;">
       Chat Penjual
    </a>
<?php else: ?>


              <!-- STATUS MENUNGGU / DLL -->
              <div class="action-button status-button">
                  <?= htmlspecialchars($p['status']) ?>
              </div>

              <?php if ($p['status'] == 'Menunggu'): ?>
              <!-- TOMBOL BATALKAN PESANAN -->
              <form method="post" 
                    action="index.php?url=batalkan_pesanan" 
                    style="margin-top:10px;">
                <input type="hidden" name="id_pesanan" 
                       value="<?= htmlspecialchars($p['id_pesanan']) ?>">
                <button class="action-button cancel-button" type="submit">
                  Batalkan pesanan
                </button>
              </form>
              <?php endif; ?>

          <?php endif; ?>

        </div>

      </div>

      <!-- INFO TOKO -->
      <div class="store-info">
        <h3>Toko: <?= htmlspecialchars($p['toko'] ?? 'Toko Hanuba') ?></h3>
        <a href="#"><img src="assets/img/wa1.png" alt="WA"></a>
      </div>

    <?php endwhile; endif; ?>

  </div>
</main>
