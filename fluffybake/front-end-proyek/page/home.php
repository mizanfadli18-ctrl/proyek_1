<?php
include "koneksi.php"; 
include_once "assets/functionALL.php";
?>

<!-- Tambahan Style untuk mempercantik -->
<style>
    .carousel-caption h2 {
        color: white;
        transition: color 0.3s ease;
    }

    .carousel .item.active .carousel-caption h2 {
        color: red;
    }

    .img-responsive:hover {
        border: 2px solid red;
        transition: border 0.3s ease;
    }

    h4:hover {
        color: red;
    }

    .btn-primary:hover {
        background-color: red;
        border-color: red;
    }
</style>

<!-- Carousel -->
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php
        $num = 0;
        $query = mysqli_query($koneksi, "SELECT * FROM artikel ORDER BY tgl_artikel DESC LIMIT 0,4");
        while ($data = mysqli_fetch_assoc($query)) {
            $class = ($num == 0) ? "active" : "";
            echo '<li data-target="#carousel-example-generic" data-slide-to="'.$num.'" class="'.$class.'"></li>';
            $num++;
        }
        ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php
        $number = 0;
        $query = mysqli_query($koneksi, "SELECT * FROM artikel ORDER BY tgl_artikel DESC LIMIT 0,4");
        while ($data = mysqli_fetch_assoc($query)) {
            $class = ($number == 0) ? "item active" : "item";
            $gambar = (!empty($data['gambar_artikel']) && file_exists("img/" . $data['gambar_artikel']))
                ? $data['gambar_artikel']
                : "gambar_artikel.jpeg";
        ?>
            <div class="<?= $class ?>">
                <a href="read.php?id=<?= $data['id_artikel'] ?>&judul=<?= urlencode($data['jdl_artikel']) ?>">
                    <img src="img/<?= htmlspecialchars($gambar) ?>" class="img-responsive" style="width:100%; height:350px; object-fit:cover;" alt="Gambar Artikel">
                    <div class="carousel-caption d-none d-md-block">
                        <h2><?= htmlspecialchars($data['jdl_artikel']) ?></h2>
                        <p><?= potong_text($data['isi_artikel'], 150) ?></p>
                    </div>
                </a>
            </div>
        <?php
            $number++;
        }
        ?>
    </div>

   
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    </a>
</div>


<div class="container" style="margin-top: 40px;">
    <h2>Selamat Datang di Portal Artikel Kami</h2>
    <p class="lead">
        Temukan berbagai artikel informatif dan inspiratif yang telah kami sajikan. Apabila Anda sudah membaca artikel sebelumnya,
        laman ini juga menyajikan pembaruan dan lanjutan yang relevan dengan topik-topik tersebut. Jelajahi konten terbaru dan jangan lewatkan informasi penting lainnya.
    </p>
</div>


<div class="container" style="margin-top: 20px;">
    <h3>Artikel Terbaru</h3>
    <hr>
    <?php
    $query = mysqli_query($koneksi, "SELECT * FROM artikel a INNER JOIN kategori b ON a.kode_kategori = b.kode_kategori ORDER BY a.tgl_artikel DESC LIMIT 0,3");
    while ($data = mysqli_fetch_assoc($query)) {
        $gambar = (!empty($data['gambar_artikel']) && file_exists("img/" . $data['gambar_artikel']))
            ? $data['gambar_artikel']
            : "gambar_artikel.jpeg";
    ?>
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-sm-4">
                <img src="img/<?= htmlspecialchars($gambar) ?>" class="img-responsive" style="height:200px; width:100%; object-fit:cover;" alt="Gambar Artikel">
            </div>
            <div class="col-sm-8">
                <h4><?= htmlspecialchars($data['jdl_artikel']) ?></h4>
                <p>
                    <span class="glyphicon glyphicon-calendar"></span> <?= tgljm_full($data['tgl_artikel']) ?> WIB<br>
                    <span class="glyphicon glyphicon-tag"></span> <?= htmlspecialchars($data['nama_kategori']) ?>
                </p>
                <p><?= potong_text($data['isi_artikel'], 300) ?></p>
                <a href="read.php?id=<?= $data['id_artikel'] ?>&judul=<?= urlencode($data['jdl_artikel']) ?>" class="btn btn-primary">Baca Selengkapnya</a>
            </div>
        </div>
        <hr>
    <?php } ?>
</div>
