<?php
// PERBAIKAN PATH: Menggunakan '../' karena file ini di-include dari index.php
// Lokasi: admin/page/kategori.php -> akses ke admin/koneksi.php
include '../koneksi.php';
// Lokasi: admin/page/kategori.php -> akses ke admin/assets/functionALL.php
include '../assets/functionALL.php'; 

// Gunakan 'action' untuk mengontrol switch, dengan default 'list'
$action = $_GET['action'] ?? 'list';

switch ($action) {

case 'add':
?>
    <h4>Tambah Kategori</h4>
    <form action="index.php?page=kategori&action=save" method="POST">
        <div class="form-group">
            <label for="nama_kategori">Nama Kategori:</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php?page=kategori" class="btn btn-default">Kembali</a>
    </form>
<?php
break;

case 'save':
    // Pengecekan POST dan Sanitasi Data
    if (!isset($_POST['nama_kategori'])) {
        header("Location: index.php?page=kategori");
        exit;
    }
    
    // Asumsi variabel koneksi Anda adalah $conn
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']); 
    $sql = "INSERT INTO kategori (nama_kategori) VALUES ('$nama')";
    $query = mysqli_query($conn, $sql);
    
    if ($query) {
        echo "<script>alert('Kategori berhasil disimpan');</script>";
    } else {
        echo "<script>alert('Gagal menyimpan kategori');</script>";
    }
    
    // Redirect ke halaman kategori di index.php
    echo "<script>document.location='index.php?page=kategori';</script>";
    exit;
break;

case 'edit':
    // Pengecekan ID dan Sanitasi Data
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id === 0) {
        header("Location: index.php?page=kategori");
        exit;
    }
    
    $query = mysqli_query($conn, "SELECT * FROM kategori WHERE id_kategori=$id");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "<script>alert('Data tidak ditemukan'); document.location='index.php?page=kategori';</script>";
        exit;
    }
?>
    <h4>Edit Kategori</h4>
    <form action="index.php?page=kategori&action=update" method="POST">
        <input type="hidden" name="id_kategori" value="<?= htmlspecialchars($data['id_kategori']) ?>">
        <div class="form-group">
            <label for="nama_kategori">Nama Kategori:</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="<?= htmlspecialchars($data['nama_kategori']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php?page=kategori" class="btn btn-default">Kembali</a>
    </form>
<?php
break;

case 'update':
    // Pengecekan POST dan Sanitasi Data
    if (!isset($_POST['id_kategori']) || !isset($_POST['nama_kategori'])) {
        header("Location: index.php?page=kategori");
        exit;
    }

    $id = (int)$_POST['id_kategori'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $query = mysqli_query($conn, "UPDATE kategori SET nama_kategori='$nama' WHERE id_kategori=$id");

    if ($query) {
        echo "<script>alert('Kategori berhasil diupdate');</script>";
    } else {
        echo "<script>alert('Gagal mengupdate kategori');</script>";
    }

    // Redirect ke halaman kategori di index.php
    echo "<script>document.location='index.php?page=kategori';</script>";
    exit;
break;

case 'delete':
    // Pengecekan ID dan Sanitasi Data
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id === 0) {
        header("Location: index.php?page=kategori");
        exit;
    }
    
    $query = mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori=$id");
    
    if ($query) {
        echo "<script>alert('Kategori berhasil dihapus');</script>";
    } else {
        echo "<script>alert('Gagal menghapus kategori');</script>";
    }

    // Redirect ke halaman kategori di index.php
    echo "<script>document.location='index.php?page=kategori';</script>";
    exit;
break;

case 'list':
default:
    echo "<h4>Daftar Kategori</h4>";
    // PERBAIKAN LINK: Mengarahkan kembali ke file index.php
    echo "<a href='index.php?page=kategori&action=add' class='btn btn-sm btn-primary'>Tambah Kategori</a><br><br>";

    $q = mysqli_query($conn, "SELECT * FROM kategori");
    
    // Menggunakan class Bootstrap untuk tabel
    echo "<table class='table table-bordered table-striped'>
              <thead>
                  <tr><th>No</th><th>Nama Kategori</th><th>Aksi</th></tr>
              </thead>
              <tbody>";
    $no = 1;
    while ($d = mysqli_fetch_assoc($q)) {
        echo "<tr>
                <td>$no</td>
                <td>".htmlspecialchars($d['nama_kategori'] ?? '-')."</td>
                <td>
                  <a href='index.php?page=kategori&action=edit&id={$d['id_kategori']}' class='btn btn-sm btn-warning'><span class='glyphicon glyphicon-pencil'></span> Edit</a> 
                  <a href='index.php?page=kategori&action=delete&id={$d['id_kategori']}' 
                     class='btn btn-sm btn-danger'
                     onclick=\"return confirm('Hapus kategori {$d['nama_kategori']}?')\"><span class='glyphicon glyphicon-trash'></span> Hapus</a>
                </td>
              </tr>";
        $no++;
    }
    echo "</tbody></table>";
}
?>