<?php
include "../koneksi.php";

// ✅ Cek login pembeli
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit;
}

// ✅ Ambil id_user dari URL jika tersedia
$id_user = $_GET['id'] ?? null;

// ✅ Jika tidak ada id_user, ambil user pertama dari tabel users
if (!$id_user) {
    $get_default_user = mysqli_query($conn, "SELECT id_user FROM users LIMIT 1");
    $row_default = mysqli_fetch_assoc($get_default_user);
    $id_user = $row_default['id_user'] ?? null;
}

// 🚨 Jika tabel users kosong
if (!$id_user) {
    echo "<div style='color:red; text-align:center; padding:20px; font-size:18px;'>
            ❌ Tidak ada data pembeli di dalam tabel <b>users</b>.
          </div>";
    exit;
}

// ✅ Ambil data user dari tabel users
$query = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$id_user'");
$data = mysqli_fetch_assoc($query);

// 🚨 Jika data tidak ditemukan
if (!$data) {
    echo "<div style='color:red; text-align:center; padding:20px; font-size:18px;'>
            ⚠ Data user dengan ID $id_user tidak ditemukan di tabel users.
          </div>";
    exit;
}
?>

<link rel="stylesheet" href="../assets/css/profil.css">

<div class="page-container">
  <section id="section-header">
    <header class="profile-header">
      <h1 class="profile-header__title">PROFIL PEMBELI</h1>
    </header>
  </section>

  <section id="section-profile" class="profile-main-section">
    <main class="profile-content">
      <a href="index.php" class="back-link">
        <img src="../assets/img/back.png" alt="Back">
      </a>

      <img src="../assets/img/profil.png" alt="User Avatar" class="profile-avatar">

      <div class="profile-details">
        <div class="detail-item">
          <p class="detail-text name"><?= htmlspecialchars($data['nama']); ?></p>
        </div>
        <div class="detail-item">
          <p class="detail-text email"><?= htmlspecialchars($data['email']); ?></p>
        </div>
        <div class="detail-item">
          <p class="detail-text phone"><?= htmlspecialchars($data['no_hp']); ?></p>
        </div>
        <div class="detail-item address">
          <p class="detail-text"><?= htmlspecialchars($data['alamat']); ?></p>
        </div>
      </div>

      <div class="button-group">
        <a href="index.php?page=profilpem&id=<?= $data['id_user']; ?>" class="edit-button">Edit</a>
        <a href="logout.php" class="logout-button">Logout</a>
      </div>
    </main>
  </section>
</div>

<style>
/* ===== Styling Tambahan untuk Tombol Logout ===== */
.button-group {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 40px;
  margin-top: 30px;
}

.edit-button, .logout-button {
  display: inline-block;
  text-align: center;
  background-color: #5a3b2e;
  color: #fff;
  font-weight: 700;
  font-size: 24px;
  padding: 15px 40px;
  border-radius: 15px;
  text-decoration: none;
  transition: all 0.3s ease;
}

.edit-button:hover, .logout-button:hover {
  background-color: #7a543d;
}
.logout-button {
  background-color: #483021;
}
.logout-button:hover {
  background-color: #7a543d;
}
</style>
