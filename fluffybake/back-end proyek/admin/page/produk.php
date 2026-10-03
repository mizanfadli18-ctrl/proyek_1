<?php
// Pastikan koneksi dan fungsi helper bisa diakses
include __DIR__ . "/../../koneksi.php";
include __DIR__ . "/../../assets/functionALL.php"; // Asumsi file ini ada

global $conn;
$action = $_GET['action'] ?? 'list';

// ==========================================================================
// TAMBAH PRODUK
// ==========================================================================
if ($action == 'add') {
?>
    <h2>Tambah Produk</h2>
    <form action="index.php?page=produk&action=save" method="POST" enctype="multipart/form-data">
        <label>Nama Produk:</label><br>
        <input type="text" name="nama_produk" class="form-control" required><br>

        <label>Kategori Produk:</label><br>
        <select name="id_kategori" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="1">Cake</option>
        <option value="2">Cookies</option>
        <option value="3">Pie</option>
        <option value="4">Brownies</option>
        </select><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" class="form-control" required><br>

        <label>Deskripsi Produk:</label><br>
        <textarea name="deskripsi" rows="5" class="form-control" required></textarea><br>

        <label>Gambar Produk:</label><br>
        <input type="file" name="gambar_produk" accept="image/*" required><br><br>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php?page=produk" class="btn btn-default">Kembali</a>
    </form>
<?php
}

// ==========================================================================
// SIMPAN PRODUK
// ==========================================================================
elseif ($action == 'save') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = intval($_POST['harga']);
    $desk = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $id_kategori = intval($_POST['id_kategori']);
    $gambar = $_FILES['gambar_produk']['name'];
    $tmp = $_FILES['gambar_produk']['tmp_name'];
    $targetPath = __DIR__ . "/../../../FRONT-END-PROYEK/assets/img/" . basename($gambar);

    if ($_FILES['gambar_produk']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Gagal mengupload gambar!');history.back();</script>";
        exit;
    }

    if (move_uploaded_file($tmp, $targetPath)) {
        $sql = "INSERT INTO produk 
        (id_kategori, nama_produk, harga, deskripsi, gambar_produk)
        VALUES 
        ('$id_kategori', '$nama','$harga','$desk','$gambar')";
        mysqli_query($conn, $sql);
        echo "<script>alert('Produk berhasil disimpan');document.location='index.php?page=produk';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan gambar di server!');history.back();</script>";
    }
    exit;
}

// ==========================================================================
// HAPUS PRODUK
// ==========================================================================
elseif ($action == 'delete') {
    $id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT gambar_produk FROM produk WHERE id_produk=$id");
    $data = mysqli_fetch_assoc($result);
    $filePath = __DIR__ . "/../../assets/img/" . $data['gambar_produk'];

    if (file_exists($filePath) && !empty($data['gambar_produk'])) {
        unlink($filePath);
    }

    mysqli_query($conn, "DELETE FROM produk WHERE id_produk=$id");
    echo "<script>alert('Produk berhasil dihapus');document.location='index.php?page=produk';</script>";
    exit;
}

// ==========================================================================
// EDIT PRODUK
// ==========================================================================
elseif ($action == 'edit') {
    $id = intval($_GET['id']);
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id_produk=$id"));
?>
    <h2>Edit Produk</h2>
    <form action="index.php?page=produk&action=update&id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <label>Nama Produk:</label><br>
        <input type="text" name="nama_produk" value="<?= htmlspecialchars($data['nama_produk']) ?>" class="form-control" required><br>

        <label>Kategori Produk:</label><br>
        <select name="id_kategori" class="form-control" required>
        <option value="1" <?= $data['id_kategori']==1?'selected':'' ?>>Cake</option>
        <option value="2" <?= $data['id_kategori']==2?'selected':'' ?>>Cookies</option>
        <option value="3" <?= $data['id_kategori']==3?'selected':'' ?>>Pie</option>
        <option value="4" <?= $data['id_kategori']==4?'selected':'' ?>>Brownies</option>
        </select><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" value="<?= htmlspecialchars($data['harga']) ?>" class="form-control" required><br>

        <label>Deskripsi Produk:</label><br>
        <textarea name="deskripsi" rows="5" class="form-control" required><?= htmlspecialchars($data['deskripsi']) ?></textarea><br>

        <label>Gambar Produk:</label><br>
        <input type="file" name="gambar_produk" accept="image/*"><br>
        <small>Gambar saat ini:</small><br>
        <?php if (!empty($data['gambar_produk'])): ?>
            <img src='../../FRONT-END-PROYEK/assets/img/<?= htmlspecialchars($data['gambar_produk']) ?>' width="120">
            <br><br>
        <?php else: ?>
            <p>Tidak ada gambar saat ini.</p>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="index.php?page=produk" class="btn btn-default">Kembali</a>
    </form>
<?php
}

// ==========================================================================
// UPDATE PRODUK
// ==========================================================================
elseif ($action == 'update') {
    $id = intval($_GET['id']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = intval($_POST['harga']);
    $desk = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $id_kategori = intval($_POST['id_kategori']); 

    if (!empty($_FILES['gambar_produk']['name'])) {
        $gambar = $_FILES['gambar_produk']['name'];
        $tmp = $_FILES['gambar_produk']['tmp_name'];
        $targetPath = __DIR__ . "/../../../FRONT-END-PROYEK/assets/img/" . basename($gambar);

        $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar_produk FROM produk WHERE id_produk=$id"));
        $oldPath = __DIR__ . "/../../assets/img/" . $old['gambar_produk'];
        if (file_exists($oldPath)) unlink($oldPath);

        move_uploaded_file($tmp, $targetPath);
        $sql = "UPDATE produk SET 
        id_kategori='$id_kategori',
        nama_produk='$nama',
        harga='$harga',
        deskripsi='$desk',
        gambar_produk='$gambar'
        WHERE id_produk=$id";
    } else {
        $sql = "UPDATE produk SET 
        id_kategori='$id_kategori',
        nama_produk='$nama',
        harga='$harga',
        deskripsi='$desk'
        WHERE id_produk=$id";
    }

    mysqli_query($conn, $sql);
    echo "<script>alert('Produk berhasil diperbarui');document.location='index.php?page=produk';</script>";
    exit;
}

// ==========================================================================
// DAFTAR PRODUK (LIST)
// ==========================================================================
else {
?>

<link rel="stylesheet" href="../assets/css/kelola_produk.css">


<main id="product-list" class="product-list-section">
  <div class="list-controls">
    <div class="list-controls-left">
      <h1 class="list-title">Daftar Barang</h1>
      <a href="index.php?page=produk&action=add" class="create-button">Create</a>
    </div>
  </div>

  <div class="product-table-wrapper">
  <div class="product-table">
    <div class="table-header">
      <div class="header-cell">No</div>
      <div class="header-cell">Nama Produk</div>
      <div class="header-cell">Harga</div>
      <div class="header-cell">Gambar Produk</div>
      <div class="header-cell">Deskripsi Produk</div>
      <div class="header-cell">Aksi</div>
    </div>

    <?php
    $no = 1;
    $q = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk DESC");
    while ($d = mysqli_fetch_assoc($q)) {
        echo '
        <div class="table-row '.($no % 2 == 0 ? 'row-gray' : 'row-white').'">
          <div class="table-cell" data-label="No">'.$no.'</div>
          <div class="table-cell" data-label="Nama Produk">'.htmlspecialchars($d['nama_produk']).'</div>
          <div class="table-cell" data-label="Harga">Rp '.number_format($d['harga'],0,',','.').'</div>
          <div class="table-cell" data-label="Gambar Produk">';
        if (!empty($d['gambar_produk'])) {
            echo '<img src="../../FRONT-END-PROYEK/assets/img/'.htmlspecialchars($d['gambar_produk']).'" class="product-image">';
        } else {
            echo 'N/A';
        }
        echo '</div>
          <div class="table-cell cell-description" data-label="Deskripsi Produk">'.htmlspecialchars($d['deskripsi']).'</div>
          <div class="table-cell cell-actions" data-label="Aksi">
            <a href="index.php?page=produk&action=edit&id='.$d['id_produk'].'"><img src="../assets/img/pensil.png" alt="Edit"></a>
            <a href="index.php?page=produk&action=delete&id='.$d['id_produk'].'" onclick="return confirm(\'Yakin hapus produk ini?\')"><img src="../assets/img/sampah.png" alt="Delete"></a>
          </div>
        </div>';
        $no++;
    }
    ?>
  </div>
</div>

</main>

<?php
}
?>
