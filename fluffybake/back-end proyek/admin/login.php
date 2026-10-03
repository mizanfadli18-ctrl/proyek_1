<?php
// ===============================
// 🔧 FIX SESSION UNTUK FOLDER DENGAN SPASI
// ===============================
$sessionPath = str_replace('\\', '/', dirname(__DIR__)) . '/session_data';
if (!file_exists($sessionPath)) mkdir($sessionPath, 0777, true);
session_save_path($sessionPath);
session_start();

include '../koneksi.php';

// Jika sudah login, arahkan sesuai role
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $role = $_SESSION['role'] ?? '';
    if ($role === 'Admin') {
        header("Location: index.php?page=kelola_admin"); // ✅ Admin langsung ke Kelola Admin
    } elseif ($role === 'Penjual') {
        header("Location: index.php?page=produk"); // ✅ Penjual ke Produk
    } elseif ($role === 'Pembeli') {
        header("Location: index.php?page=profilpem_view"); // ✅ Pembeli ke Profil Pembeli
    } else {
        header("Location: login.php");
    }
    exit;
}

// ====================================
// PROSES LOGIN
// ====================================
if (isset($_POST['login'])) {
    // Bersihkan session lama
    session_unset();
    session_destroy();

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $user = null;
    $role = '';

    // 🔹 1. Cek di tabel admin
    $res = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email' LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);
        $role = 'Admin';
    }

    // 🔹 2. Cek di tabel toko (penjual)
    if (!$user) {
        $res = mysqli_query($conn, "SELECT * FROM toko WHERE email='$email' LIMIT 1");
        if ($res && mysqli_num_rows($res) > 0) {
            $user = mysqli_fetch_assoc($res);
            $role = 'Penjual';
        }
    }

    // 🔹 3. Cek di tabel user (pembeli)
    if (!$user) {
        $res = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' LIMIT 1");
        if ($res && mysqli_num_rows($res) > 0) {
            $user = mysqli_fetch_assoc($res);
            $role = 'Pembeli';
        }
    }

    // ✅ Jika email ditemukan di salah satu tabel
    if ($user) {
        $validPassword = password_verify($password, $user['password']) || $password === $user['password'];

        if ($validPassword) {
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $role;

            // Simpan ID & nama sesuai role
            if ($role === 'Admin') {
                $_SESSION['nama'] = $user['nama_lengkap'];
                $_SESSION['id_admin'] = $user['id_admin'];
                header("Location: index.php?page=kelola_admin"); // ✅ Admin langsung ke kelola_admin

            } elseif ($role === 'Penjual') {
                $_SESSION['nama'] = $user['nama_toko'];
                $_SESSION['id_toko'] = $user['id_toko'];
                header("Location: index.php?page=produk"); // ✅ Penjual ke produk

            } elseif ($role === 'Pembeli') {
                $_SESSION['nama'] = $user['nama_lengkap'];
                $_SESSION['id_user'] = $user['id_user'];
                header("Location: index.php?page=profilpem_view"); // ✅ Pembeli ke profil pembeli
            }
            exit;
        } else {
            $error_message = "❌ Password salah.";
        }
    } else {
        $error_message = "❌ Email tidak ditemukan di sistem kami.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Pengguna</title>
<style>
body {
    background-color: #f5e9d8;
    font-family: 'Poppins', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.login-container {
    background-color: #fffaf2;
    border-radius: 20px;
    padding: 40px 30px;
    width: 340px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
.login-container h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #5a3b2e;
}
.input-group {
    background-color: #5a3b2e;
    border-radius: 12px;
    display: flex;
    align-items: center;
    padding: 10px 15px;
    margin-bottom: 15px;
}
.input-group i {
    color: white;
    margin-right: 10px;
}
.input-group input {
    border: none;
    outline: none;
    background: none;
    color: white;
    width: 100%;
    font-size: 15px;
}
.input-group input::placeholder {
    color: #f1e0d1;
}
button {
    width: 100%;
    background-color: #5a3b2e;
    color: white;
    border: none;
    border-radius: 12px;
    padding: 10px;
    font-size: 16px;
    cursor: pointer;
    font-weight: bold;
}
button:hover {
    background-color: #7a543d;
}
.error-alert {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    border-radius: 8px;
    padding: 8px;
    text-align: center;
    font-size: 14px;
    margin-bottom: 10px;
}
</style>
</head>
<body>
<div class="login-container">
    <h2>Login Pengguna</h2>
    <form method="POST">
        <?php if (isset($error_message)): ?>
            <div class="error-alert"><?= $error_message; ?></div>
        <?php endif; ?>
        <div class="input-group">
            <i>📧</i>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-group">
            <i>🔒</i>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" name="login">Login</button>
    </form>
    <div style="text-align:center; margin-top:15px;">
        <a href="register.php" style="color:#5a3b2e; text-decoration:none; font-weight:bold;">Registrasi</a>
    </div>
</div>
</body>
</html>
