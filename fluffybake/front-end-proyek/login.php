<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "koneksi.php"; // koneksi ke database

$error = "";

// Jika form login dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek data di tabel users
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");
    $user = mysqli_fetch_assoc($query);

    if ($user) {
        // Jika password cocok (belum di-hash)
        if ($password === $user['password']) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];

            // Jika login karena redirect (misal dari keranjang)
            // Setelah login sukses
if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    $redirect = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['redirect']); // bersihkan nama
    header("Location: index.php?url=$redirect");
} else {
    header("Location: index.php?url=beranda");
}
exit;


            exit;
        } else {
            $error = "⚠ Password salah!";
        }
    } else {
        $error = "⚠ Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/login1.css?v=<?= time(); ?>">
</head>
<body>
  <div class="page-wrapper">
    <header class="site-header"></header>

    <main class="main-content">
      <div class="login-form-container">
        <img src="assets/img/logo1.png" alt="Logo" class="logo">

        <?php if (!empty($error)): ?>
          <p style="color:red; font-size:14px; margin-bottom:10px;">
            <?= htmlspecialchars($error) ?>
          </p>
        <?php endif; ?>

        <form action="" method="post" class="login-form">
          <div class="input-group">
            <img src="assets/img/email.png" alt="Email" class="input-icon email-icon">
            <input type="email" name="email" placeholder="Email" class="form-control" required>
          </div>

          <div class="input-group">
            <img src="assets/img/kunci.png" alt="Password" class="input-icon password-icon">
            <input type="password" name="password" placeholder="Password" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-signin">Signin</button>
          <a href="register.php" class="btn btn-register">Registrasi</a>
          <p class="separator">OR</p>
          <button type="button" class="btn btn-google">
            <img src="assets/img/gogle.png" alt="Login dengan Google">
          </button>
        </form>
      </div>
    </main>

    <footer class="site-footer"></footer>
  </div>
</body>
</html>
