<?php
// Pastikan session aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../koneksi.php"; // Pastikan koneksi menggunakan variabel $conn

// Cek koneksi
if (!isset($conn) || $conn == null) {
    die("Koneksi database tidak tersedia.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_user  = mysqli_real_escape_string($conn, $_POST['id_user']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat   = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_hp    = mysqli_real_escape_string($conn, $_POST['no_hp']);

    // Cek apakah password diubah
    if (!empty($password)) {
        $password_update = ", password='$password'";
    } else {
        $password_update = "";
    }

    // ✅ Gunakan nama tabel yang benar: `user`
    $query = "UPDATE user SET 
                email='$email',
                nama_lengkap='$nama',
                alamat='$alamat',
                no_telepon='$no_hp'
                $password_update
              WHERE id_user='$id_user'";

    if (mysqli_query($conn, $query)) {
        echo "<script>
            alert('✅ Profil berhasil diperbarui!');
            window.location='index.php?page=profilpem_view';
        </script>";
    } else {
        echo "<script>
            alert('❌ Gagal memperbarui profil!');
            window.location='index.php?page=profilpem_view';
        </script>";
    }
} else {
    header("Location: index.php?page=profilpem_view");
    exit;
}
?>
