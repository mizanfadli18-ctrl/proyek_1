<?php
// Cek halaman aktif
$url = $_GET['url'] ?? 'beranda';
?>

<link rel="stylesheet" href="assets/css/global.css">

<header class="site-header">
  <div class="header-container">

    <!-- LOGO -->
    <a href="index.php?url=beranda" class="logo-link">
      <img src="assets/img/logo1.png" alt="Fluffybake Logo" class="header-logo">
    </a>

    <!-- MENU NAVIGASI -->
    <nav class="main-nav">
      <ul>
        <li><a href="index.php?url=beranda" class="<?= ($url=='beranda') ? 'nav-item-active' : '' ?>">Beranda</a></li>
        <li><a href="index.php?url=store" class="<?= ($url=='store') ? 'nav-item-active' : '' ?>">Store</a></li>
        <li><a href="index.php?url=pesanan" class="<?= ($url=='pesanan') ? 'nav-item-active' : '' ?>">Pesanan</a></li>
      </ul>
    </nav>

    <!-- ICON -->
    <div class="header-icons">
      <a href="index.php?url=keranjang"><img src="assets/img/keranjang.png" alt="Keranjang"></a>
     <a href="index.php?url=pencarian">
 
     <img src="assets/img/pencarian.png" alt="Cari">
     </a>

     <?php if (isset($_SESSION['id_user'])): ?>
  <a href="index.php?url=profil"><img src="assets/img/akun.png" alt="Profil"></a>
<?php else: ?>
  <a href="index.php?url=login&redirect=profil"><img src="assets/img/akun.png" alt="Login"></a>
<?php endif; ?>

    </div>

  </div>
</header>
