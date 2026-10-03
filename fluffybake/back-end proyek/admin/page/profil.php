<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include '../koneksi.php';

$id_toko = $_SESSION['id_toko'] ?? 1;
$q = mysqli_query($conn, "SELECT * FROM toko WHERE id_toko = $id_toko");
$d = mysqli_fetch_assoc($q);
?>

<link rel="stylesheet" href="../assets/css/Pedit.profil.css?v=1">

<!-- ========== MAIN CONTENT ========== -->
<main id="profile-form" class="profile-form-section">
  <a href="index.php?page=profil_view" class="back-link">
    <img src="../assets/img/back.png" alt="Back" class="back-arrow-icon">
  </a>

  <div class="form-wrapper">
    <div class="profile-avatar-container">
      <img src="../assets/img/hanuba1.png" alt="Profile Avatar" class="profile-avatar">
    </div>

    <form class="edit-profile-form" action="index.php?page=update_profil" method="POST">
      <div class="form-group">
        <label>Nama Toko</label>
        <input type="text" name="nama_toko" value="<?= htmlspecialchars($d['nama_toko']) ?>">
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($d['email']) ?>">
      </div>

      <div class="form-group">
        <label>Nomor Telepon</label>
        <input type="text" name="nomor_telepon" value="<?= htmlspecialchars($d['nomor_telepon']) ?>">
      </div>

      <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" rows="2"><?= htmlspecialchars($d['alamat']) ?></textarea>
      </div>

      <div class="form-group">
        <label>Jenis Penjualan</label>
        <input type="text" name="jenis_penjualan" value="<?= htmlspecialchars($d['jenis_penjualan']) ?>">
      </div>

      <button type="submit" class="submit-button">Selanjutnya</button>
    </form>
  </div>
</main>

