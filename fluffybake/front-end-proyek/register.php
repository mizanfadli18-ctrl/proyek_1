<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "koneksi.php"; // koneksi ke database

$success = "";
$error = "";

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Cek apakah email sudah terdaftar
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "⚠ Email sudah terdaftar!";
    } else {
        // Simpan ke database
        $query = "INSERT INTO users (nama, email, password, alamat, no_hp) 
                  VALUES ('$nama', '$email', '$password', '$alamat', '$no_hp')";
        if (mysqli_query($conn, $query)) {
            $success = "✅ Registrasi berhasil! Silakan login.";
            header("refresh:2; url=index.php?url=login");
        } else {
            $error = "❌ Gagal menyimpan data. Silakan coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Registrasi</title>
  <link rel="stylesheet" href="assets/css/register.css?v=<?= time(); ?>">
</head>
<body>
  <section id="registration-section" class="registration-container">
    <header class="registration-header">
      <a href="index.php?url=login" class="back-button">
        <img src="assets/img/back.png" alt="Kembali">
      </a>
      <h1 class="title">Registrasi</h1>
    </header>

    <main>
      <!-- Pesan sukses atau error -->
      <?php if (!empty($success)): ?>
        <p class="success-message"><?= htmlspecialchars($success) ?></p>
      <?php elseif (!empty($error)): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form class="registration-form" method="POST" action="">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" id="nama" name="nama" class="form-input" required>

        <label for="no_hp" class="form-label">No Hp</label>
        <input type="tel" id="no_hp" name="no_hp" class="form-input" required>

        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-input" required>

        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-input" required>

        <label for="alamat" class="form-label">Alamat</label>
        <input type="text" id="alamat" name="alamat" class="form-input" required>

        <label for="status" class="form-label">Status</label>
        <input type="text" id="status" name="status" class="form-input" required>

        <div class="form-actions">
          <button type="submit" class="submit-button">Kirim</button>
        </div>
      </form>
    </main>
  </section>
</body>
</html>
