<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/../koneksi.php';

// 🔒 Cek login user
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu');window.location='index.php?url=login';</script>";
    exit;
}

$id_user = (int)$_SESSION['id_user'];

// 🔹 Ambil data dari tabel user
$q = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id_user");
$u = mysqli_fetch_assoc($q);

if (!$u) {
    echo "<script>alert('Data user tidak ditemukan');window.location='index.php?url=login';</script>";
    exit;
}
?>

<link rel="stylesheet" href="assets/css/profil.css?=v2">

<div class="page-container">

  <!-- ===== HEADER ATAS ===== -->
  <section id="section-header">
    <header class="profile-header">
      <h1 class="profile-header__title">PROFIL USER</h1>
    </header>
  </section>

  <!-- ===== KONTEN PROFIL ===== -->
  <section id="section-profile" class="profile-main-section">
    <main class="profile-content">

      <!-- Tombol Kembali -->
      <a href="index.php?url=beranda" class="back-link">
        <img src="assets/img/back.png" alt="Back">
      </a>

      <!-- Avatar -->
      <img src="assets/img/profil.png" alt="User Avatar" class="profile-avatar">

      <!-- Detail User -->
      <div class="profile-details">
        <div class="detail-item">
          <p class="detail-text name"><?= htmlspecialchars($u['nama_lengkap']) ?></p>
        </div>

        <div class="detail-item">
          <p class="detail-text email"><?= htmlspecialchars($u['email']) ?></p>
        </div>

        <div class="detail-item">
          <p class="detail-text phone"><?= htmlspecialchars($u['no_telepon']) ?></p>
        </div>

        <div class="detail-item address">
          <p class="detail-text"><?= htmlspecialchars($u['alamat']) ?></p>
        </div>
      </div>

      <!-- Tombol Edit + Logout -->
      <div class="button-group">
    <a href="index.php?url=edit_profil" class="edit-button">Edit</a>

    <a href="logout.php" class="logout-button">Logout</a>
</div>

      
    </main>
  </section>

  <section id="section-footer">
    <footer class="profile-footer"></footer>
  </section>

</div>
