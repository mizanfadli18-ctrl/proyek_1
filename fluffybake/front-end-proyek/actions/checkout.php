<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php?url=login");
    exit;
}

$id_user = (int)$_SESSION['id_user'];

// ambil data user
$u = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = $id_user")
);

// ambil isi keranjang
$items = mysqli_query(
    $koneksi,
    "SELECT 
        k.*, 
        p.harga,
        p.nama_produk,
        p.gambar_produk
     FROM keranjang k 
     JOIN produk p ON p.id_produk = k.id_produk 
     WHERE k.id_user = $id_user"
);

if ($items && mysqli_num_rows($items) > 0) {

    while ($it = mysqli_fetch_assoc($items)) {

        $jumlah   = (int)$it['quantity'];
        $harga    = (float)$it['harga'];
        $subtotal = $jumlah * $harga;

        // 1️⃣ INSERT KE PESANAN
        mysqli_query($koneksi, "
            INSERT INTO pesanan (
    id_user,
    id_produk,
    jumlah,
    nama_pembeli,
    nama_produk,
    gambar,
    total,
    alamat,
    no_telepon,
    status
) VALUES (
    $id_user,
    {$it['id_produk']},
    $jumlah,
    '{$u['nama_lengkap']}',
    '{$it['nama_produk']}',
    '{$it['gambar_produk']}',
    $subtotal,
    '{$u['alamat']}',
    '{$u['no_telepon']}',
    'Menunggu'
);
        ");

        // 2️⃣ AMBIL ID PESANAN
        $pesanan_id = mysqli_insert_id($koneksi);

        if (!$pesanan_id) {
            die("Gagal membuat pesanan");
        }

        // 3️⃣ INSERT DETAIL PESANAN (INI KUNCI)
        mysqli_query($koneksi, "
            INSERT INTO detail_pesanan (
                pesanan_id,
                produk_id,
                jumlah,
                subtotal
            ) VALUES (
                $pesanan_id,
                {$it['id_produk']},
                $jumlah,
                $subtotal
            )
        ");
    }

    // 4️⃣ KOSONGKAN KERANJANG
    mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_user = $id_user");
}

// 5️⃣ REDIRECT
header("Location: ../index.php?url=pesanan");
exit;
