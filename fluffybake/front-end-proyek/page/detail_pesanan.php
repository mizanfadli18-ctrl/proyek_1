<?php
require_once "koneksi.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<p style='text-align:center;color:red;margin-top:40px;'>ID pesanan tidak ditemukan.</p>";
    exit;
}

// Ambil data pesanan + user
$q = mysqli_query($conn, "
    SELECT p.*, u.nama_lengkap, u.alamat AS alamat_user, u.no_telepon
    FROM pesanan p
    LEFT JOIN user u ON p.id_user = u.id_user
    WHERE p.id_pesanan = '$id'
");

$p = mysqli_fetch_assoc($q);

if (!$p) {
    echo "<p style='text-align:center;color:red;margin-top:40px;'>Data pesanan tidak ditemukan.</p>";
    exit;
}
?>

<link rel="stylesheet" href="assets/css/pesanan_detail.css?=v1">

<!-- ❌ HAPUS HEADER — AGAR HALAMAN POLS -->
<!-- <header class="site-header">...</header> -->

<main class="detail-wrapper">

    <a href="index.php?url=pesanan" class="back-link">
        <img src="assets/img/back.png" alt="Back">
    </a>

    <div class="detail-card">

        <h2 class="title">Detail Pesanan</h2>

        <div class="detail-content">

            <div class="image-box">
                <img src="assets/img/<?= htmlspecialchars($p['gambar']) ?>" alt="Produk">
            </div>

            <div class="info-box">

                <p><strong>Nama Produk:</strong> <?= htmlspecialchars($p['nama_produk']) ?></p>
                <p><strong>Jumlah:</strong> <?= (int)$p['jumlah'] ?> pcs</p>
                <p><strong>Total:</strong> Rp <?= number_format($p['total'],0,',','.') ?></p>

                <hr>

                <p><strong>Pembeli:</strong> <?= htmlspecialchars($p['nama_lengkap']) ?></p>
                <p><strong>Alamat Pembeli:</strong> <?= htmlspecialchars($p['alamat_user']) ?></p>
                <p><strong>No Telepon:</strong> <?= htmlspecialchars($p['no_telepon']) ?></p>

                <hr>

                <p><strong>Status Pesanan:</strong> 
                    <span class="status <?= strtolower($p['status']) ?>">
                        <?= htmlspecialchars($p['status']) ?>
                    </span>
                </p>

                <a href="https://wa.me/62<?= substr($p['no_telepon'],1) ?>?text=Halo%20saya%20mau%20bertanya%20tentang%20pesanan."
                
                   target="_blank"
                   class="btn-wa">
                   Hubungi Penjual
                </a>
                <a href="index.php?url=chat&id=<?= $p['id_pesanan'] ?>" class="btn-wa" style="background:#5A3B2E;">
                Buka Chat
                </a>



            </div>

        </div>

    </div>

</main>
