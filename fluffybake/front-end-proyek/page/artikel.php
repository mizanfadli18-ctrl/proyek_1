<?php
include "../koneksi.php";

// Fungsi Format Tanggal dan Jam
function tgljm_full($tanggal) {
    return date("d M Y, H:i", strtotime($tanggal));
}

// Fungsi Potong Isi Artikel
function potong_text($text, $limit = 500) {
    $text = strip_tags($text); 
    if (strlen($text) > $limit) {
        return substr($text, 0, $limit) . "...";
    } else {
        return $text;
    }
}

// Ambil kode kategori dari URL
$kode = isset($_GET['kode']) ? mysqli_escape_string($koneksi, $_GET['kode']) : '';

// Ambil data artikel dari database
$query = mysqli_query($koneksi, "
    SELECT * FROM artikel a
    INNER JOIN kategori b ON a.kode_kategori = b.kode_kategori
    WHERE a.kode_kategori = '$kode'
    ORDER BY a.tgl_artikel DESC
");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Artikel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body { padding: 20px; }
        img.img-responsive {
            max-height: 200px;
            object-fit: cover;
            width: 100%;
        }
        h2 { margin-top: 0; }
        .article { margin-bottom: 30px; }
    </style>
</head>
<body>

<article class="container">
    <h1>Daftar Artikel</h1>
    <p>Berikut ini adalah artikel-artikel yang tersedia pada kategori yang dipilih:</p>

    <?php if (mysqli_num_rows($query) > 0): ?>
        <?php while($data = mysqli_fetch_assoc($query)): ?>
            <div class="row article">
               
                <div class="col-sm-8">
                    <h2><?= htmlspecialchars($data['jdl_artikel']) ?></h2>
                    <p>
                        <span class="glyphicon glyphicon-calendar"></span> <?= tgljm_full($data['tgl_artikel']) ?> WIB<br>
                        <span class="glyphicon glyphicon-tag"></span> <?= htmlspecialchars($data['nama_kategori']) ?>
                    </p>
                    <p><?= potong_text($data['isi_artikel'], 500) ?></p>
                    <a href="read.php?id=<?= $data['id_artikel'] ?>&judul=<?= urlencode($data['jdl_artikel']) ?>" class="btn btn-success">Read More ></a>
                </div>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-warning">
            <strong>Oops!</strong> Tidak ada artikel yang ditemukan dalam kategori ini.
        </div>
    <?php endif; ?>
</article>

</body>
</html>
