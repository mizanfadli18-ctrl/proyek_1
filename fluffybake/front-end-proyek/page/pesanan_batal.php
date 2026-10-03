<?php
require_once "koneksi.php";

$id_user = $_SESSION['id_user'] ?? null;
if (!$id_user) {
    echo "<p style='text-align:center'>Silakan login.</p>";
    exit;
}

$q = mysqli_query($conn, "
    SELECT *
    FROM pesanan 
    WHERE id_user = '$id_user'
    AND status NOT IN ('Dibatalkan Pembeli','Ditolak Penjual')
    ORDER BY tanggal_pesan DESC
");

?>

<link rel="stylesheet" href="assets/css/pesanan.css">

<div class="order-wrapper">
    <a href="index.php?url=beranda" class="back-link">
        <img src="assets/img/back.png">
    </a>

    <h2 class="title">Pesanan Anda</h2>

    <?php if (mysqli_num_rows($q) == 0): ?>
        <p class="no-order">Tidak ada pesanan.</p>
    <?php endif; ?>

    <?php while($p = mysqli_fetch_assoc($q)): ?>
        <div class="order-card">
            
            <img src="assets/img/<?= $p['gambar'] ?>" class="product-img">

            <div class="order-info">
                <h3><?= $p['nama_produk'] ?></h3>
                <p>Jumlah: <?= $p['jumlah'] ?> pcs</p>
                <p>Total: Rp <?= number_format($p['total'],0,',','.') ?></p>

                <?php if ($p['status'] == "Menunggu"): ?>
                    <span class="status status-wait">Menunggu konfirmasi penjual</span>

                    <form method="post" action="index.php?url=batalkan_pesanan">
                        <input type="hidden" name="id_pesanan" value="<?= $p['id_pesanan'] ?>">
                        <button class="btn-cancel" type="submit">Batalkan Pesanan</button>
                    </form>

                <?php elseif ($p['status'] == "Diterima"): ?>
                    <span class="status status-success">Pesanan diterima penjual</span>

                <?php elseif ($p['status'] == "Ditolak"): ?>
                    <span class="status status-failed">Pesanan ditolak penjual</span>

                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>
