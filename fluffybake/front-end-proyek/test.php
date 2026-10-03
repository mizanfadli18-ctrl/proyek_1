<?php
$koneksi = mysqli_connect("localhost", "root", "", "penjualan_db");

if ($koneksi) {
    echo "✅ Koneksi BERHASIL";
} else {
    echo "❌ Koneksi GAGAL: " . mysqli_connect_error();
}
?>
