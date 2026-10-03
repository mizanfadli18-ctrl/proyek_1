<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<link rel="stylesheet" href="assets/css/toko.css?=v1">

<main class="store-content">
  <a href="javascript:history.back()" class="back-link">
    <img src="assets/img/back.png" alt="Back">
  </a>
  <h1 class="page-title">Daftar Toko</h1>

  <div class="store-list">

    <!-- ✅ Toko Hanuba -->
    <article class="store-card">
      <img src="assets/img/hanuba1.png" class="store-logo">
      <div class="store-details">
        <p><b>Nama</b> : Hanuba cake and cookies</p>
        <p><b>Jenis makanan</b> : Cake, Cookies, Pie, Brownies</p>
        <p><b>Alamat</b> : Perumahan Graha Sudirman Blok A3 no 02, Indramayu</p>
        <a href="index.php?url=toko&id=hanuba" class="visit-btn">Kunjungi Toko</a>
      </div>
    </article>

    <!-- ✅ Toko Bread -->
    <article class="store-card">
      <img src="assets/img/bread.png" class="store-logo">
      <div class="store-details">
        <p><b>Nama</b> : Toko Bread</p>
        <p><b>Jenis makanan</b> : Cake dan Cookies</p>
        <p><b>Alamat</b> : Desa Semangat, Indramayu</p>
        <a href="index.php?url=toko&id=bread" class="visit-btn">Kunjungi Toko</a>
      </div>
    </article>

  </div>
</main>
