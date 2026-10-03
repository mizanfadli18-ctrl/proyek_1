<?php
switch($_GET['action']){
    default:
?>
<h3>Data Kategori</h3>
<a href="index.php?page=kategori&action=add" class="btn btn-primary">Tambah Kategori</a>
<table class="table table-bordered">
    <thead>
        <tr><th>No</th><th>Nama Kategori</th><th>Aksi</th></tr>
    </thead>
    <tbody>
    <?php
    $no=1;
    $query=mysqli_query($koneksi,"SELECT * FROM kategori");
    while($data=mysqli_fetch_assoc($query)){
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $data['nama_kategori']; ?></td>
        <td>
            <a href="index.php?page=kategori&action=edit&id=<?= $data['id_kategori']; ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="index.php?page=kategori&action=hapus&id=<?= $data['id_kategori']; ?>" class="btn btn-danger btn-sm">Hapus</a>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<?php
    break;

    case 'add':
?>
<h3>Tambah Kategori</h3>
<form method="POST" action="index.php?page=kategori&action=save">
    <input type="text" name="nama_kategori" class="form-control" required>
    <button class="btn btn-success">Simpan</button>
</form>
<?php
    break;

    case 'save':
        $nama = $_POST['nama_kategori'];
        $query = mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori) VALUES ('$nama')");
        if($query){
            echo "<script>document.location='index.php?page=kategori';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan'); document.location='index.php?page=kategori&action=add';</script>";
        }
    break;

    case 'edit':
        $id = $_GET['id'];
        $query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_kategori='$id'");
        $data = mysqli_fetch_assoc($query);
?>
<h3>Edit Kategori</h3>
<form method="POST" action="index.php?page=kategori&action=update">
    <input type="hidden" name="id" value="<?= $data['id_kategori']; ?>">
    <input type="text" name="nama_kategori" class="form-control" value="<?= $data['nama_kategori']; ?>" required>
    <button class="btn btn-primary">Update</button>
</form>
<?php
    break;

    case 'update':
        $id = $_POST['id'];
        $nama = $_POST['nama_kategori'];
        $query = mysqli_query($koneksi, "UPDATE kategori SET nama_kategori='$nama' WHERE id_kategori='$id'");
        if($query){
            echo "<script>document.location='index.php?page=kategori';</script>";
        } else {
            echo "<script>alert('Gagal update'); document.location='index.php?page=kategori&action=edit&id=$id';</script>";
        }
    break;

    case 'hapus':
        $id = $_GET['id'];
        $query = mysqli_query($koneksi, "DELETE FROM kategori WHERE id_kategori='$id'");
        if($query){
            echo "<script>document.location='index.php?page=kategori';</script>";
        } else {
            echo "<script>alert('Gagal hapus'); document.location='index.php?page=kategori';</script>";
        }
    break;
}
