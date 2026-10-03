<?php
include '../koneksi.php';
switch($_GET['action']){
    default:
?>
<table class="table table-bordered table-striped">
<thead>
    <th>No</th>
    <th>Username</th>
    <th>Nama</th>
    <th><a href="index.php?page=admin&action=add" class="btn btn-sm btn-primary">
        <span class="glyphicon glyphicon-plus"></span> Add</a></th>
</thead>
<tbody>
    <?php
    $nomor=1;
    $query=mysqli_query($koneksi,"SELECT * FROM admin");
    while($data=mysqli_fetch_assoc($query)){
        ?>
        <tr>
            <td><?=$nomor;?></td>
            <td><?=$data['username'];?></td>
            <td><?=$data['nama'];?></td>
            <td>
                <a href="index.php?page=admin&action=edit&id=<?=$data['username'];?>"
                class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="index.php?page=admin&action=resset&id=<?=$data['username'];?>" 
                class="btn btn-sm btn-default"><span class="glyphicon glyphicon-refresh"></span></a>
                <a href="index.php?page=admin&action=hapus&id=<?=$data['username'];?>"
                class="btn btn-sm btn-danger"><span class="glyphicon-trash"></span></a>
    </td>
    </tr>
    <?php
    $nomor++;
    }
    ?>
    </tbody>
</table>
<?php

?>
<form method="POST" action="index.php?page=admin&action=save">
    <label>Username:</label>
    <input type="text" name="user" class="form-control" required="true">
    <label>password:</label>
    <input type="password" name="pass" class="form-control" required="true">
    <label>Nama Lengkap:</label>
    <input type="text" name="nama" class="form-control" required="true"><br>
    <button type="submit" class="btn btn-primary">SIMPAN</button>
    <a href="index.php?page=admin" class="btn btn-default">KEMBALI</a>
</form>
<?php

    break;
    case 'add':

        break;
    case 'save':

        break;
    case 'edit':

        break;
    case 'update':

        break;
    case 'hapus':

        break;
    case 'resset':

        break;
}

?>
<form method="POST" action="index.php?page=admin&action=save">
    <label>Username:</label>
    <input type="text" name="user" class="form-control" required="true">
    <label>password:</label>
    <input type="password" name="pass" class="form-control" required="true">
    <label>Nama Lengkap:</label>
    <input type="text" name="nama" class="form-control" required="true"><br>
    <button type="submit" class="btn btn-primary">SIMPAN</button>
    <a href="index.php?page=admin" class="btn btn-default">KEMBALI</a>
</form>
<?php

if(isset($_POST['user'])){
    $user = $_POST['user'];
    $password = md5($_POST['pass']);
    $nama = $_POST['nama'];
    $query = mysqli_query($koneksi, "INSERT INTO admin (username, password, nama)
VALUES ('".$user."','".$password."','".$nama."')");
    if($query){
        echo "<script> document.location='index.php?page=admin';</script>";
    }else{
        echo "<script> alert('Gagal'); document.location='index.php?page=admin&action=add'; </script>";
    }
    }

$query=mysqli_query($koneksi, "SELECT * FROM admin WHERE username='".$_GET['id']."'");
$data=mysqli_fetch_assoc($query);
?>
<form method="POST" action="index.php?page=admin&action=update">
    <input type="hidden" name="id" value="<?=$data['username']?>">
    <label>username:</label>
    <input type="text" name="user" class="form-control" required="true" value="<?=$data['username']?>" disabled="true">
    <label>password:</label>
    <input type="password" name="pass" class="form control" required="true" value="<?=$data['password']?>" disabled="true">
    <label>Nama Lengkap:</label>
    <input type="text" name="nama" class="form-control" required="true" value="<?=$data['nama']?>"><br>
    <button type="submit" class="btn btn-primary">UPDATE</button>
    <a href="index.php?page=admin" class="btn btn-default">KEMBALI</a>
</form>
<?php

if(isset($_POST['id'])){
    $nama = $_POST['nama'];
$query=mysqli_query($koneksi,"UPDATE admin SET nama='".$nama."' WHERE username='".$_POST['id']."'");
    if($query){
       echo "<script> document.location='index.php?page=admin'; </script>";
    }else{
        echo "<script> alert('Gagal');
        document.location='index.php?page=admin&action=edit&action=edit&id=".$_post['id']."'; </script";
    }
    }

$query=mysqli_query($koneksi,"DELETE FROM admin WHERE username='".$_GET['id']."'");
if($query){
    echo "<script> document.location='index.php?page=admin'; </script>";
}else{
    echo "<script> alert('Gagal'); document.location='index.php?page=admin'; </script>";
}

$password = md5("123456");
$query=mysqli_query($koneksi,"UPDATE admin SET password='".$password."' WHERE username='".$_GET['id']."'");
if($query){
    echo "<script> alert('sukses resset password 123456');
    document.location='index.php?admin'; </script>";
}else{
    echo "<script> alert('Gagal'); document.location='index.php?page=admin'; </script>";
}
