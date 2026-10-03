<?php
include_once '../koneksi.php';
include_once '../assets/functionALL.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {

  // ======================================================
  // 📋 HALAMAN LIST ADMIN
  // ======================================================
  case 'list':
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Admin</title>
  <link rel="stylesheet" href="../assets/css/kelola.user.css">
</head>
<body>
  <div class="dashboard-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <img src="../assets/img/logo1.png" alt="Logo" class="logo-img">
        <div>
          <h2 class="brand-name">FLUFFYBAKE</h2>
          <p class="brand-slogan">cake & cookies</p>
        </div>
      </div>

      <nav class="sidebar-nav">
        <a href="index.php?page=kelola_admin" class="nav-link active">
          <img src="../assets/img/akun1.png" alt="Settings Icon" class="nav-icon">
          <span>Kelola Admin</span>
        </a>
        <a href="logout.php" class="nav-link">
          <img src="../assets/img/logout.png" alt="Logout Icon" class="nav-icon">
          <span>Logout</span>
        </a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
      <header class="content-header">
        <h1 class="page-title">Kelola Admin</h1>
        <a href="index.php?page=kelola_admin&action=add" class="add-user-btn">+ Tambah Admin</a>
      </header>

      <div class="table-container">
        <div class="table-header">
          <div class="table-cell">No</div>
          <div class="table-cell">Nama Lengkap</div>
          <div class="table-cell">Email</div>
          <div class="table-cell">Role</div>
          <div class="table-cell">Status</div>
          <div class="table-cell">Aksi</div>
        </div>

        <div class="table-body">
        <?php
        $q = mysqli_query($conn, "SELECT * FROM admin ORDER BY id_admin ASC");
        $no = 1;
        while ($d = mysqli_fetch_assoc($q)) {
          echo "
          <div class='table-row'>
            <div class='table-cell'>{$no}</div>
            <div class='table-cell'>" . htmlspecialchars($d['nama_lengkap']) . "</div>
            <div class='table-cell'><a href='mailto:{$d['email']}'>" . htmlspecialchars($d['email']) . "</a></div>
            <div class='table-cell'>" . htmlspecialchars($d['role']) . "</div>
            <div class='table-cell'>" . htmlspecialchars($d['status']) . "</div>
            <div class='table-cell actions-cell'>
              <a href='index.php?page=kelola_admin&action=edit&id={$d['id_admin']}'><button class='action-btn edit-btn'>Edit</button></a>
              <a href='index.php?page=kelola_admin&action=delete&id={$d['id_admin']}' onclick=\"return confirm('Yakin hapus admin ini?')\"><button class='action-btn delete-btn'>Hapus</button></a>
            </div>
          </div>
          ";
          $no++;
        }
        ?>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
<?php
break;

  // ======================================================
  // ➕ TAMBAH ADMIN
  // ======================================================
    // ======================================================
  // ➕ TAMBAH ADMIN (DESAIN SEPERTI GAMBAR NO.2)
  // ======================================================
  case 'add':
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Admin - FluffyBake</title>
  <link rel="stylesheet" href="../assets/css/tambah.user.css">
</head>
<body>
<section id="dashboard" class="dashboard-container">
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-content-wrapper">
      <div class="sidebar-header">
        <img src="../assets/img/logo1.png" alt="Fluffybake Logo" class="logo-img">
        <div class="brand-text">
          <h1 class="brand-name">FLUFFYBAKE</h1>
          <p class="brand-tagline">cake & cookies</p>
        </div>
      </div>
      <nav class="sidebar-nav">
        <a href="index.php?page=kelola_admin" class="nav-link active">
          <img src="../assets/img/akun1.png" alt="" class="nav-icon">
          <span>Kelola Admin</span>
        </a>
        <a href="logout.php" class="nav-link logout">
          <img src="../assets/img/logout.png" alt="" class="nav-icon">
          <span>Logout</span>
        </a>
      </nav>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="main-content">
    <div class="form-card">
      <h2 class="form-title">Tambah Admin</h2>
      <form class="user-form" action="index.php?page=kelola_admin&action=save" method="POST">
        <div class="form-row">
          <label for="fullName" class="form-label">Nama Lengkap</label>
          <div class="form-input-wrapper">
            <input type="text" id="fullName" name="nama_lengkap" required>
          </div>
        </div>
        <div class="form-row">
          <label for="email" class="form-label">Email</label>
          <div class="form-input-wrapper">
            <input type="email" id="email" name="email" required>
          </div>
        </div>
        <div class="form-row">
          <label for="password" class="form-label">Password</label>
          <div class="form-input-wrapper">
            <input type="password" id="password" name="password" required>
          </div>
        </div>
        <div class="form-row">
          <label for="role" class="form-label">Role</label>
          <div class="form-input-wrapper">
            <select id="role" name="role" required>
              <option value="Admin">Admin</option>
              <option value="Super Admin">Super Admin</option>
            </select>
          </div>
        </div>
        <div class="form-checkbox-row">
          <input type="checkbox" id="aktif" name="status" value="Aktif" checked>
          <label for="aktif" class="checkbox-label">AKTIF</label>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="index.php?page=kelola_admin"><button type="button" class="btn btn-secondary">Batal</button></a>
        </div>
      </form>
    </div>
  </main>
</section>
</body>
</html>
<?php
break;

// ======================================================
// ✏️ EDIT ADMIN
// ======================================================
case 'edit':

$id = (int)($_GET['id'] ?? 0);
$q = mysqli_query($conn, "SELECT * FROM admin WHERE id_admin=$id");
$d = mysqli_fetch_assoc($q);

if (!$d) {
  echo "<p>Data admin tidak ditemukan</p>";
  break;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Admin - FluffyBake</title>
  <link rel="stylesheet" href="../assets/css/tambah.user.css">
</head>
<body>
<section class="dashboard-container">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-content-wrapper">
      <div class="sidebar-header">
        <img src="../assets/img/logo1.png" class="logo-img">
        <div class="brand-text">
          <h1 class="brand-name">FLUFFYBAKE</h1>
          <p class="brand-tagline">cake & cookies</p>
        </div>
      </div>
      <nav class="sidebar-nav">
        <a href="index.php?page=kelola_admin" class="nav-link active">
          <span>Kelola Admin</span>
        </a>
        <a href="logout.php" class="nav-link logout">
          <span>Logout</span>
        </a>
      </nav>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="main-content">
    <div class="form-card">
      <h2 class="form-title">Edit Admin</h2>

      <form class="user-form"
      action="index.php?page=kelola_admin&action=update"
      method="POST">

  <input type="hidden" name="id_admin" value="<?= $d['id_admin']; ?>">

  <!-- Nama Lengkap -->
  <div class="form-row">
    <label class="form-label">Nama Lengkap</label>
    <div class="form-input-wrapper">
      <input type="text" name="nama_lengkap"
             value="<?= htmlspecialchars($d['nama_lengkap']); ?>" required>
    </div>
  </div>

  <!-- Email -->
  <div class="form-row">
    <label class="form-label">Email</label>
    <div class="form-input-wrapper">
      <input type="email" name="email"
             value="<?= htmlspecialchars($d['email']); ?>" required>
    </div>
  </div>

  <!-- Password (TANPA TEKS TAMBAHAN) -->
  <div class="form-row">
    <label class="form-label">Password</label>
    <div class="form-input-wrapper">
      <input type="password" name="password" value="">
    </div>
  </div>

  <!-- Role -->
  <div class="form-row">
    <label class="form-label">Role</label>
    <div class="form-input-wrapper">
      <select name="role">
        <option value="Admin" <?= $d['role']=='Admin'?'selected':''; ?>>Admin</option>
        <option value="Super Admin" <?= $d['role']=='Super Admin'?'selected':''; ?>>Super Admin</option>
      </select>
    </div>
  </div>

  <!-- Status -->
  <div class="form-checkbox-row">
    <input type="checkbox" id="aktif" name="status" value="Aktif"
      <?= $d['status']=='Aktif'?'checked':''; ?>>
    <label for="aktif" class="checkbox-label">AKTIF</label>
  </div>

  <!-- Button -->
  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="index.php?page=kelola_admin">
      <button type="button" class="btn btn-secondary">Batal</button>
    </a>
  </div>
</form>

    </div>
  </main>
</section>
</body>
</html>
<?php
break;


  // ======================================================
  // 💾 SIMPAN ADMIN BARU
  // ======================================================
  case 'save':
    if (isset($_POST['nama_lengkap'])) {
      $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $pass = md5($_POST['password']);
      $role = mysqli_real_escape_string($conn, $_POST['role']);
      $status = mysqli_real_escape_string($conn, $_POST['status']);

      $sql = "INSERT INTO admin (nama_lengkap, email, password, role, status)
              VALUES ('$nama', '$email', '$pass', '$role', '$status')";
      $query = mysqli_query($conn, $sql);

      if ($query) {
        echo "<script>alert('Admin berhasil disimpan');window.location='index.php?page=kelola_admin';</script>";
      } else {
        echo "<script>alert('Gagal menyimpan admin');window.history.back();</script>";
      }
      exit;
    }
  break;

  // ======================================================
// 🔄 UPDATE ADMIN
// ======================================================
case 'update':

$id     = (int)$_POST['id_admin'];
$nama   = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
$email  = mysqli_real_escape_string($conn, $_POST['email']);
$role   = mysqli_real_escape_string($conn, $_POST['role']);
$status = isset($_POST['status']) ? 'Aktif' : 'Nonaktif';

if (!empty($_POST['password'])) {
  $pass = md5($_POST['password']);
  $sql = "UPDATE admin SET
          nama_lengkap='$nama',
          email='$email',
          password='$pass',
          role='$role',
          status='$status'
          WHERE id_admin=$id";
} else {
  $sql = "UPDATE admin SET
          nama_lengkap='$nama',
          email='$email',
          role='$role',
          status='$status'
          WHERE id_admin=$id";
}

mysqli_query($conn, $sql);
echo "<script>alert('Admin berhasil diupdate');window.location='index.php?page=kelola_admin';</script>";
exit;
break;


  // ======================================================
  // ❌ HAPUS ADMIN
  // ======================================================
  case 'delete':
    $id = (int)($_GET['id'] ?? 0);
    mysqli_query($conn, "DELETE FROM admin WHERE id_admin=$id");
    echo "<script>alert('Admin berhasil dihapus');window.location='index.php?page=kelola_admin';</script>";
    exit;
  break;

  // ======================================================
  // DEFAULT (safety)
  // ======================================================
  default:
    echo "<p>Halaman tidak ditemukan.</p>";
  break;
}
?>
