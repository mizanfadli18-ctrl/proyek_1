<?php
include dirname(__DIR__, 2) . '/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<h3 style='text-align:center;color:red;'>ID pesanan tidak ditemukan</h3>";
    exit;
}

// Ambil detail pesanan + user
$q = mysqli_query($conn, "
    SELECT 
        p.id_pesanan,
        p.status,
        u.nama_lengkap,
        u.alamat,
        u.no_telepon,
        COALESCE(pr.nama_produk, p.nama_produk) AS nama_produk,
        COALESCE(pr.gambar_produk, p.gambar) AS gambar_produk,
        COALESCE(dp.jumlah, p.jumlah) AS jumlah,
        COALESCE(dp.subtotal, p.total) AS total
    FROM pesanan p
    LEFT JOIN detail_pesanan dp ON dp.pesanan_id = p.id_pesanan
    LEFT JOIN produk pr ON pr.id_produk = dp.produk_id
    JOIN user u ON u.id_user = p.id_user
    WHERE p.id_pesanan = '$id'
");

$p = mysqli_fetch_assoc($q);
if (!$p) {
    echo "<h3 style='text-align:center;color:red;'>Data pesanan tidak ditemukan</h3>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Pesanan</title>
<link rel="stylesheet" href="../assets/css/detail_pesanan.css?v=1">
</head>

<body>

<section class="detail-page">

    <a href="index.php?page=terima_pesanan" class="back-link">
        <img src="../assets/img/back.png" alt="Back">
    </a>

    <div class="detail-container">

        <h1 class="title">Detail Pesanan</h1>

        <div class="detail-card">

            <div class="detail-left">
            <?php if (!empty($p['gambar_produk'])): ?>
             <img 
                src="http://localhost/FRONT-END-PROYEK/assets/img/<?= htmlspecialchars($p['gambar_produk']) ?>" 
                class="product-image">

                <?php else: ?>
                 <p>Gambar tidak tersedia</p>
                <?php endif; ?>
                </div>

            <div class="detail-right">

                <p><strong>Nama Pembeli:</strong> <?= htmlspecialchars($p['nama_lengkap']) ?></p>
                <p><strong>Nama Produk:</strong> <?= htmlspecialchars($p['nama_produk']) ?></p>
                <p><strong>Jumlah:</strong> <?= (int)$p['jumlah'] ?> pcs</p>
                <p><strong>Total:</strong> Rp <?= number_format($p['total'], 0, ',', '.') ?></p>
                <p><strong>Alamat:</strong> <?= htmlspecialchars($p['alamat']) ?></p>
                <p><strong>No Telepon:</strong> <?= htmlspecialchars($p['no_telepon']) ?></p>
                <p><strong>Status:</strong> <span class="status"><?= $p['status'] ?></span></p>

                <a href="https://wa.me/62<?= substr($p['no_telepon'], 1) ?>?text=Halo, pesanan Anda diterima."
                
                   target="_blank"
                   class="wa-button">Hubungi Pembeli</a>
                   <a href="index.php?page=chat&id=<?= $p['id_pesanan'] ?>" 
   class="wa-button" 
   style="background:#5A3B2E;margin-top:10px;">
   Chat Pembeli
</a>


            </div>

        </div>

    </div>
</section>

</body>
</html>
