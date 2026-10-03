<?php
include dirname(__DIR__, 2) . '/koneksi.php';
include dirname(__DIR__, 2) . '/assets/functionALL.php';

// Ambil semua pesanan yang SUDAH DITERIMA
$q = mysqli_query($conn, "
    SELECT p.*, u.nama_lengkap, u.alamat, u.no_telepon
    FROM pesanan p
    LEFT JOIN user u ON p.id_user = u.id_user
    WHERE p.status = 'Diterima'
    ORDER BY p.tanggal_pesan DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Menerima Pesanan</title>
  <link rel="stylesheet" href="../assets/css/terimaP.css?v=1">
</head>

<body>

<section class="orders-page">
  <div class="container">
    
    <a href="index.php?page=pesanan" class="back-link">
      <img src="../assets/img/back.png" alt="Back">
    </a>
    <h2 class="page-title">Daftar Menerima Pesanan</h2>

    <div class="table-wrapper">
      <div class="table-container">

        <div class="table-header">
          <div class="table-cell header-no">No</div>
          <div class="table-cell header-buyer">Nama Pembeli</div>
          <div class="table-cell header-product">Nama Produk</div>
          <div class="table-cell header-total">Total</div>
          <div class="table-cell header-address">Alamat</div>
          <div class="table-cell header-phone">No Telepon</div>
          <div class="table-cell header-action">Aksi</div>
        </div>

        <div class="table-body">
        <?php $no = 1; while ($p = mysqli_fetch_assoc($q)): ?>
          <div class="table-row">
            <div class="table-cell"><?= $no ?></div>
            <div class="table-cell"><?= htmlspecialchars($p['nama_lengkap']) ?></div>
            <div class="table-cell"><?= htmlspecialchars($p['nama_produk']) ?></div>
            <div class="table-cell">Rp <?= number_format($p['total'], 0, ',', '.') ?></div>
            <div class="table-cell"><?= htmlspecialchars($p['alamat']) ?></div>
            <div class="table-cell phone-cell">
              <span><?= htmlspecialchars($p['no_telepon']) ?></span>
            </div>
            <div class="table-cell">
              <a href="index.php?page=detail_pesanan&id=<?= $p['id_pesanan'] ?>" class="action-button">
                Lihat Detail Produk
              </a>
            </div>
          </div>
        <?php $no++; endwhile; ?>
        </div>

      </div>
    </div>

  </div>
</section>

</body>
</html>
