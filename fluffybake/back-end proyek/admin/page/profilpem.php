<?php
include "../koneksi.php";

// Pastikan admin login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit;
}

// Ambil id_user dari GET
$id_user = $_GET['id'] ?? null;

if (!$id_user) {
    echo "<div style='color:red; text-align:center; padding:20px;'>❌ ID User tidak ditemukan.</div>";
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$id_user'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<div style='color:red; text-align:center; padding:20px;'>⚠ Data tidak ditemukan.</div>";
    exit;
}
?>

<link rel="stylesheet" href="../assets/css/edit_profil.css">

<section id="section-header">
  <header class="profile-header">
     <a href="index.php?page=profilpem_view" class="back-link">
        <img src="../assets/img/back.png" alt="Back" class="back-arrow-icon">
     </a>
    <h1 class="header-title">PROFIL USER</h1>
  </header>
</section>

<main id="profile" class="profile-main">
  <div class="content-wrapper">
    <div class="profile-avatar-section">
      <img src="../assets/img/profil.png" alt="User Avatar" class="profile-avatar">
     
    </div>

    <form class="profile-form" action="index.php?page=updatepem_profil" method="POST">
      <input type="hidden" name="id_user" value="<?= $data['id_user']; ?>">

      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']); ?>">
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" value="<?= htmlspecialchars($data['password']); ?>">
      </div>

      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']); ?>">
      </div>

      <div class="form-group">
        <label for="alamat">Alamat</label>
        <input type="text" id="alamat" name="alamat" class="form-control" value="<?= htmlspecialchars($data['alamat']); ?>">
      </div>

      <div class="form-group">
        <label for="no_hp">No Hp</label>
        <input type="text" id="no_hp" name="no_hp" class="form-control" value="<?= htmlspecialchars($data['no_hp']); ?>">
      </div>

      <div class="profile-actions">
        <button type="submit" class="btn btn-save">Simpan</button>
      </div>
    </form>
  </div>
</main>

<section id="section-footer">
  <footer class="page-footer"></footer>
</section>
