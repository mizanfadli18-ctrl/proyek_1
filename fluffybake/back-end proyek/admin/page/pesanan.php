<?php
include dirname(__DIR__, 2) . '/koneksi.php';
include dirname(__DIR__, 2) . '/assets/functionALL.php';

/* =====================================================
   UPDATE STATUS PESANAN
===================================================== */
if (isset($_GET['aksi']) && isset($_GET['id'])) {

    $id = intval($_GET['id']);
    $aksi = $_GET['aksi'];

    if ($aksi === 'terima') {
        mysqli_query($conn, "UPDATE pesanan SET status='Diterima' WHERE id_pesanan='$id'");
    } 
    elseif ($aksi === 'tolak') {
        mysqli_query($conn, "UPDATE pesanan SET status='Ditolak Penjual' WHERE id_pesanan='$id'");
    }

    header("Location: index.php?page=pesanan");
    exit;
}

/* =====================================================
   AMBIL DATA PESANAN
===================================================== */
$q = mysqli_query($conn, "
    SELECT p.*, u.nama_lengkap, u.alamat, u.no_telepon
    FROM pesanan p
    LEFT JOIN user u ON p.id_user = u.id_user
    WHERE p.status NOT IN ('Dibatalkan Pembeli', 'Ditolak Penjual')
    ORDER BY p.tanggal_pesan DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan</title>
  <link rel="stylesheet" href="../assets/css/Ppesanan.css?v=1">
</head>

<body>

  

  <!-- MAIN CONTENT -->
  <main>
    <section id="orders" class="orders-section">
      <div class="page-title">
      <h1>Daftar Pesanan</h1>
      </div>

      <div class="orders-table-container">
        <div class="orders-table">

          <div class="table-header">
            <div class="header-cell">No</div>
            <div class="header-cell">Nama Pembeli</div>
            <div class="header-cell">Nama Produk</div>
            <div class="header-cell">Total</div>
            <div class="header-cell">Alamat</div>
            <div class="header-cell">No Telepon</div>
            <div class="header-cell">Aksi</div>
          </div>

          <?php $no=1; while($d=mysqli_fetch_assoc($q)): ?>
            <div class="table-row">

              <div class="data-cell"><?= $no ?></div>
              <div class="data-cell"><?= htmlspecialchars($d['nama_lengkap'] ?? '-') ?></div>
              <div class="data-cell"><?= htmlspecialchars($d['nama_produk']) ?></div>
              <div class="data-cell">Rp <?= number_format($d['total'],0,',','.') ?></div>
              <div class="data-cell"><?= htmlspecialchars($d['alamat'] ?? '-') ?></div>
              <div class="data-cell"><?= htmlspecialchars($d['no_telepon'] ?? '-') ?></div>

              <div class="data-cell action-cell">

                <?php if ($d['status']=='Menunggu'): ?>

                    <!-- TOMBOL TERIMA -->
                    <a href="index.php?page=pesanan&aksi=terima&id=<?= $d['id_pesanan'] ?>">
                      <button class="action-btn btn-accept">Terima Pesanan</button>
                    </a>

                    <!-- TOMBOL TOLAK -->
                    <a href="index.php?page=pesanan&aksi=tolak&id=<?= $d['id_pesanan'] ?>">
                      <button class="action-btn btn-reject">Tolak Pesanan</button>
                    </a>

                <?php elseif ($d['status']=='Diterima'): ?>

                    <!-- TOMBOL LIHAT DETAIL PESANAN -->
                    <a href="index.php?page=detail_pesanan&id=<?= $d['id_pesanan'] ?>">
                      <button class="action-btn btn-accept" style="background:#ffcc66;color:#000;">
                        Lihat Detail Pesanan
                      </button>
                    </a>

                <?php endif; ?>

              </div>

            </div>
          <?php $no++; endwhile; ?>

        </div>
      </div>

    </section>
  </main>

</body>
</html>
