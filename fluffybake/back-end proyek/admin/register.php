<?php
include '../koneksi.php';

if (isset($_POST['register'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $role = $_POST['role'];

    // 🔍 Cek apakah email sudah digunakan di salah satu tabel
    $cekAdmin = mysqli_query($conn, "SELECT email FROM admin WHERE email='$email'");
    $cekToko  = mysqli_query($conn, "SELECT email FROM toko WHERE email='$email'");
    $cekUser  = mysqli_query($conn, "SELECT email FROM user WHERE email='$email'");

    if (mysqli_num_rows($cekAdmin) > 0 || mysqli_num_rows($cekToko) > 0 || mysqli_num_rows($cekUser) > 0) {
        $error_message = "❌ Email sudah digunakan. Gunakan email lain.";
    } else {
        if ($role == "Admin") {
            $query = "INSERT INTO admin (nama_lengkap, email, password, role, status)
                      VALUES ('$nama', '$email', '$password', 'Admin', 'Aktif')";
        } elseif ($role == "Penjual") {
            $query = "INSERT INTO toko (nama_toko, email, nomor_telepon, password, alamat, jenis_penjualan)
                      VALUES ('$nama', '$email', '$no_hp', '$password', '$alamat', '')";
        } else {
            $query = "INSERT INTO user (nama_lengkap, email, password, no_telepon, alamat, status)
                      VALUES ('$nama', '$email', '$password', '$no_hp', '$alamat', 'lainnya')";
        }

        if (mysqli_query($conn, $query)) {
            $success_message = "✅ Registrasi berhasil! Silakan login.";
        } else {
            $error_message = "⚠️ Terjadi kesalahan: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Registrasi Pengguna</title>
<link rel="stylesheet" href="../assets/css/register.css">
<style>
/* Tambahan gaya agar pesan muncul rapi */
.message {
  grid-column: span 2;
  text-align: center;
  margin-bottom: 10px;
  padding: 10px;
  border-radius: 8px;
  font-size: 18px;
}
.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
</style>
</head>
<body>

<section id="registration-section" class="registration-container">
  <header class="registration-header">
    <a href="login.php" class="back-button">
      <img src="../assets/img/back.png" alt="Back">
    </a>
    <h1 class="title">Registrasi</h1>
  </header>

  <main>
    <form class="registration-form" method="POST">

      <?php if (isset($error_message)): ?>
        <div class="message error"><?= htmlspecialchars($error_message) ?></div>
      <?php elseif (isset($success_message)): ?>
        <div class="message success"><?= htmlspecialchars($success_message) ?></div>
      <?php endif; ?>

      <label for="nama" class="form-label">Nama</label>
      <input type="text" id="nama" name="nama" class="form-input" placeholder="Masukkan nama lengkap" required>

      <label for="no_hp" class="form-label">No Hp</label>
      <input type="text" id="no_hp" name="no_hp" class="form-input" placeholder="Masukkan nomor HP" required>

      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" name="email" class="form-input" placeholder="Masukkan email" required>

      <label for="password" class="form-label">Password</label>
      <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan password" required>

      <label for="alamat" class="form-label">Alamat</label>
      <input type="text" id="alamat" name="alamat" class="form-input" placeholder="Masukkan alamat" required>

      <label for="role" class="form-label">Status</label>
      <div class="select-wrapper">
        <select id="role" name="role" class="form-input" required>
          <option value="" disabled selected>Pilih status</option>
          <option value="Admin">Admin</option>
          <option value="Penjual">Penjual</option>
          <option value="Pembeli">Pembeli</option>
        </select>
      </div>

      <div class="form-actions">
        <button type="submit" name="register" class="submit-button">Kirim</button>
      </div>
    </form>
  </main>
</section>
</body>
</html>
