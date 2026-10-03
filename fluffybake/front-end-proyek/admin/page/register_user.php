<?php
include '../../koneksi.php';
if (isset($_POST['save'])){
  $nama  = mysqli_real_escape_string($koneksi,$_POST['nama']);
  $email = mysqli_real_escape_string($koneksi,$_POST['email']);
  $pass  = md5($_POST['password']);
  $telp  = mysqli_real_escape_string($koneksi,$_POST['no_hp']);
  $alamat= mysqli_real_escape_string($koneksi,$_POST['alamat']);
  $status= mysqli_real_escape_string($koneksi,$_POST['status']);
  $ok = mysqli_query($koneksi,"INSERT INTO user(nama_lengkap,email,password,no_telepon,alamat,status) VALUES('$nama','$email','$pass','$telp','$alamat','$status')");
  echo $ok ? "<script>alert('User dibuat');history.back();</script>" : "<script>alert('Gagal');history.back();</script>";
}
?>
<link rel="stylesheet" href="../../assets/css/register.css">
<section class="registration-container">
  <header class="registration-header"><h1 class="title">Tambah Customer</h1></header>
  <main>
    <form class="registration-form" method="post">
      <label class="form-label">Nama</label><input class="form-input" name="nama" required>
      <label class="form-label">No Hp</label><input class="form-input" name="no_hp">
      <label class="form-label">Email</label><input class="form-input" name="email" type="email" required>
      <label class="form-label">Password</label><input class="form-input" name="password" type="password" required>
      <label class="form-label">Alamat</label><input class="form-input" name="alamat">
      <label class="form-label">Status</label>
      <div class="select-wrapper">
        <select name="status" class="form-input">
          <option value="lainnya">Lainnya</option>
          <option value="mahasiswa">Mahasiswa</option>
          <option value="pekerja">Pekerja</option>
        </select>
      </div>
      <div class="form-actions"><button type="submit" name="save" class="submit-button">Simpan</button></div>
    </form>
  </main>
</section>
