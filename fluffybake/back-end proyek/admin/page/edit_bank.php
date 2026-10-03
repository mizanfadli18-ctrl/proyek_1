<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include '../koneksi.php';

$id_toko = $_SESSION['id_toko'] ?? 1;
$q = mysqli_query($conn, "SELECT * FROM toko WHERE id_toko = $id_toko");
$d = mysqli_fetch_assoc($q);
?>

<link rel="stylesheet" href="../assets/css/Pedit.bank.css?v=1">

<!-- ===== MAIN CONTENT ===== -->
<section id="section-main">
  <div class="page-header">
  <a href="index.php?page=profil&id=<?= $id_toko ?>" class="back-link">
    <img src="../assets/img/back.png" alt="Back">
  </a>
  <h1 class="page-title">Metode Pembayaran</h1>
</div>
  <main class="main-content">
    <form action="index.php?page=update_bank" method="POST" class="payment-methods-list">

      <div class="payment-method">
        <div class="bank-info">
          <img src="../assets/img/BRI.png" alt="Bank BRI logo" class="bank-logo">
          <p class="bank-name">Bank BRI</p>
        </div>
        <div class="account-number-box">
          <input type="text" name="bri" class="account-number" value="<?= htmlspecialchars($d['bri']) ?>">
        </div>
      </div>

      <div class="payment-method">
        <div class="bank-info">
          <img src="../assets/img/BNI.png" alt="Bank BNI logo" class="bank-logo">
          <p class="bank-name">Bank BNI</p>
        </div>
        <div class="account-number-box">
          <input type="text" name="bni" class="account-number" value="<?= htmlspecialchars($d['bni']) ?>">
        </div>
      </div>

      <div class="payment-method">
        <div class="bank-info">
          <img src="../assets/img/MANDIRI.png" alt="Bank Mandiri logo" class="bank-logo">
          <p class="bank-name">Bank Mandiri</p>
        </div>
        <div class="account-number-box">
          <input type="text" name="mandiri" class="account-number" value="<?= htmlspecialchars($d['mandiri']) ?>">
        </div>
      </div>

      <div class="payment-method">
        <div class="bank-info">
          <img src="../assets/img/BCA.png" alt="Bank BCA logo" class="bank-logo">
          <p class="bank-name">Bank BCA</p>
        </div>
        <div class="account-number-box">
          <input type="text" name="bca" class="account-number" value="<?= htmlspecialchars($d['bca']) ?>">
        </div>
      </div>

      <div class="payment-method">
        <div class="bank-info">
          <img src="../assets/img/PERMATA.png" alt="Bank Permata logo" class="bank-logo">
          <p class="bank-name">Bank Permata</p>
        </div>
        <div class="account-number-box">
          <input type="text" name="permata" class="account-number" value="<?= htmlspecialchars($d['permata']) ?>">
        </div>
      </div>

      <button type="submit" class="save-button">Simpan</button>
    </form>
  </main>
</section>
