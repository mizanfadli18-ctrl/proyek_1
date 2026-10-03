<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: index.php?url=login");
    exit;
}

$id = $_SESSION['id_user'];

$q = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
$u = mysqli_fetch_assoc($q);
?>

<link rel="stylesheet" href="assets/css/edit_profil.css?=v1">

<!-- HEADER -->
<section id="section-header">
  <header class="profile-header">

    <a href="index.php?url=profil" class="back-link">
        <img src="assets/img/back.png" alt="Back" class="back-icon">
    </a>

    <h1 class="header-title">PROFIL USER</h1>
  </header>
</section>

<!-- MAIN CONTENT -->
<main id="profile" class="profile-main">

  <div class="content-wrapper">

    <!-- AVATAR -->
    <div class="profile-avatar-section">
      <img src="assets/img/profil.png" alt="User Avatar" class="profile-avatar">
    </div>

    <!-- FORM -->
    <form class="profile-form" action="index.php?url=update_profil" method="POST">

      <input type="hidden" name="id_user" value="<?= $u['id_user'] ?>">

      <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" class="form-control" value="<?= $u['email'] ?>">
      </div>

      <div class="form-group">
        <label>Password (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control" placeholder="********">
      </div>

      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= $u['nama_lengkap'] ?>">
      </div>

      <div class="form-group">
        <label>Alamat</label>
        <input type="text" name="alamat" class="form-control" value="<?= $u['alamat'] ?>">
      </div>

      <div class="form-group">
        <label>No Hp</label>
        <input type="text" name="no_hp" class="form-control" value="<?= $u['no_telepon'] ?>">
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
