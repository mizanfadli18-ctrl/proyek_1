<?php
include "../koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit;
}

// ✅ Ambil ID toko dari session (jika sudah login)
$id_toko = $_SESSION['id_toko'] ?? null;

// Jika belum ada session toko, ambil toko pertama (fallback)
if (!$id_toko) {
    $get_default = mysqli_query($conn, "SELECT id_toko FROM toko LIMIT 1");
    $row_default = mysqli_fetch_assoc($get_default);
    $id_toko = $row_default['id_toko'] ?? null;
}

// Jika tabel toko kosong
if (!$id_toko) {
    echo "<div style='text-align:center; padding:20px; color:red; font-size:18px;'>
            ❌ Tidak ada data penjual di tabel <b>toko</b>.
          </div>";
    exit;
}

// ✅ Ambil data penjual dari tabel toko
$query = mysqli_query($conn, "SELECT * FROM toko WHERE id_toko='$id_toko'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<div style='text-align:center; padding:20px; color:red; font-size:18px;'>
            ⚠ Data penjual tidak ditemukan.
          </div>";
    exit;
}
?>

<link rel="stylesheet" href="../assets/css/Pprofil.css?v=2">

<section id="section-profile" class="profile-section">
  <div class="profile-content">

    <div class="profile-header">
      <img src="../assets/img/hanuba1.png" alt="Profile Avatar" class="profile-avatar">
      <a href="index.php?page=profil&id=<?= $data['id_toko']; ?>" class="edit-button">Edit</a>
    </div>

    <div class="profile-details">
      <!-- Profil Toko -->
      <div class="details-group">
        <h2 class="details-title">Profil Toko</h2>
        <div class="info-card">
          <p><?= htmlspecialchars($data['nama_toko']); ?></p>
        </div>
        <div class="info-card">
          <p><?= htmlspecialchars($data['jenis_penjualan']); ?></p>
        </div>
        <div class="info-card">
          <p><?= htmlspecialchars($data['alamat']); ?></p>
        </div>
      </div>

      <!-- Kontak Kami -->
      <div class="details-group">
        <h2 class="details-title">Kontak Kami</h2>
        <div class="info-card contact-card">
          <img src="../assets/img/wa1.png" alt="WhatsApp Icon">
          <span><?= htmlspecialchars($data['nomor_telepon']); ?></span>
        </div>
      </div>

      <!-- Bank -->
      <div class="details-group">
        <h2 class="details-title">Bank</h2>
        <div class="info-card contact-card">
          <img src="../assets/img/bri1.png" alt="Bank Icon">
          <span><?= htmlspecialchars($data['bri'] ?: 'Belum diisi'); ?></span>
        </div>
      </div>

      <!-- Tombol Logout di bawah Bank -->
      <div class="details-group logout-group">
        <a href="logout.php" class="logout-btn" onclick="return confirm('Yakin ingin logout?')">Logout</a>
      </div>
    </div>
  </div>
</section>


