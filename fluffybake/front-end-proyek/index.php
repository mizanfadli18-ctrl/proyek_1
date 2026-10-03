<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

// ====== Koneksi & Data Produk ======
include "koneksi.php";     // Untuk database (produk Hanuba)
// Untuk produk Bread (array)

// ====== Fungsi Format Rupiah ======
function rupiah($angka) {
    return 'Rp ' . number_format((float)$angka, 0, ',', '.');
}

// ====== Routing URL ======
$url = $_GET['url'] ?? 'beranda';

// ====== Halaman Publik Tanpa Login ======
$public_pages = ['beranda', 'store', 'toko', 'detail', 'login'];

// ====== Cek Login untuk halaman private ======
if (!isset($_SESSION['id_user']) && !in_array($url, $public_pages)) {
    // simpan halaman tujuan ke login redirect
    header("Location: index.php?url=login&redirect=$url");
    exit;
}


// ====== Panggil Navigasi Sekali ======
// ====== Tampilkan NAV kecuali untuk halaman 'profil' dan 'login' ======
if ($url !== 'profil' && $url !== 'login' && $url !== 'edit_profil' && $url !== 'detail_pesanan') {
    include "nav.php";
}




// Mulai container utama halaman
echo "<div class='main-container'>";


// ====== Routing API (Frontend) ======
if (isset($_GET['api'])) {
    $api = $_GET['api'];

    switch ($api) {
        case 'create_order': include "api/create_order.php"; break;
        case 'get_cart': include "api/get_cart.php"; break;

        default:
            echo json_encode(["status" => "error", "message" => "API tidak ditemukan"]);
    }
    exit; // stop, tidak lanjut ke HTML template
}




// ====== Sistem Routing Halaman ======
switch ($url) {

    // ----- HALAMAN BERANDA -----
    case 'beranda':
        include "page/beranda.php";
        break;

// ----- HALAMAN PENCARIAN -----
case 'pencarian':
    include "page/pencarian.php";
    break;


    // ----- HALAMAN STORE / DAFTAR TOKO -----
    case 'store':
        include "page/toko.php"; // tampilkan daftar toko
        break;

    // ----- HALAMAN TOKO KHUSUS -----
    case 'toko':
        $id = $_GET['id'] ?? '';
        if ($id === 'hanuba') {
            include "page/toko_hanuba.php"; // produk dari DATABASE
        } elseif ($id === 'bread') {
            include "page/toko_bread.php";  // produk dari ARRAY
        } else {
            echo "<h2 style='text-align:center;padding:50px;'>Toko tidak ditemukan</h2>";
        }
        break;

    // ----- HALAMAN DETAIL PRODUK -----
    case 'detail':
        include "page/detail.php"; // bisa pakai database atau array
        break;

    // ----- HALAMAN KERANJANG -----
    case 'keranjang':
        include "page/keranjang.php";
        break;

    // ----- HALAMAN PESANAN -----
    case 'pesanan':
        include "page/pesanan.php";
        break;

    
    case 'pesanan_batal':
    include "page/pesanan_batal.php";
    break;


    case 'batalkan_pesanan':
    include "page/batalkan_pesanan.php";
    break;


    case 'detail_pesanan':
    include "page/detail_pesanan.php";
    break;

    // ----- HALAMAN PROFIL -----
case 'profil':
    include "page/profil.php";
    break;

// ======= PERBAIKAN DI SINI =======
case 'edit_profil':
    include "page/profil_edit.php";
    break;
// =================================

case 'update_profil':
    include "page/update_profil.php";
    break;


    // ----- HALAMAN LOGIN -----
    case 'login':
        include "login.php";
        break;
    
    // ----- HALAMAN REGISTER -----
    case 'register':
        include "register.php";
        break;

    // ----- DEFAULT: JIKA URL TIDAK DITEMUKAN -----
    default:
        include "page/beranda.php";
        break;


    // ----- HALAMAN TRANSAKSI PEMBELIAN -----
case 'transaksi':
    include "page/transaksi.php";
    break;

    case 'chat':
    include "page/chat.php";
    break;





}

// Tutup container halaman
echo "</div>";
?>
