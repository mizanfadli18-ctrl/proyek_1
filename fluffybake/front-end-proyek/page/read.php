<?php
$id=mysqli_escape_string($koneksi,url_segment(2));
$query = mysqli_query($koneksi, "SELECT * FROM artikel a
INNER JOIN kategori b ON a.kode_kategori = b.kode_kategori
WHERE a.id_artikel = '".$id."'");
$data=mysqli_fetch_assoc($query);
?>
<article class="container">
    <h2><?=$data['jdl_artikel']?></h2>
    <span class="glyphicon glyphicon-calender"></span> <?=tgljm_full($data['tgl_artikel'])?> WIB
    <br>
    <span class="glyphicon glyphicon-tag"></span> <?=$data['nama_kategori']?>
    <img src="<?=base_url()."/img/".$data['gambar_artikel']?>" class="img-responsive">
    <?=$data['isi_artikel']?>
</article>