<?php
ob_start();

/* ============================================
   SESSION FIX UNTUK FOLDER DENGAN SPASI
============================================ */
$sessionPath = str_replace('\\', '/', dirname(__DIR__)) . '/session_data';
if (!file_exists($sessionPath)) mkdir($sessionPath, 0777, true);
session_save_path($sessionPath);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../koneksi.php";

/* ============================================
   CEK LOGIN
============================================ */
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'] ?? 'Guest';
$nama = $_SESSION['nama'] ?? '';

/* ============================================
   ROUTING API — harus di luar HTML
============================================ */
if (isset($_GET['api'])) {

    $api = $_GET['api'];

    switch ($api) {
        case 'create_order': include "api/create_order.php"; break;
        case 'get_cart': include "api/get_cart.php"; break;
        case 'get_order_detail': include "api/get_order_detail.php"; break;
        case 'update_payment': include "api/update_payment.php"; break;
        case 'clear_cart': include "api/clear_cart.php"; break;
        default:
            echo json_encode(["status" => "error", "message" => "API tidak ditemukan"]);
    }

    exit; // hentikan agar tidak masuk ke HTML admin
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard <?= htmlspecialchars($role) ?></title>
<link href="../assets/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background-color: #f5e9d8;
    font-family: Arial, sans-serif;
}
.sidebar {
    width: 220px;
    float: left;
    height: 100vh;
    background-color: #5A3B2E;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 20px;
}
.sidebar h4 {
    text-align: center;
    margin: 15px 0 10px;
    font-size: 13px;
    letter-spacing: 1px;
    color: #f2e6d8;
}
.sidebar a {
    color: white;
    display: block;
    padding: 10px 16px;
    margin: 6px 12px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 14px;
}

.sidebar a:hover,
.sidebar a.active {
    background-color: #3d2a21;
}
.content {
    margin-left: 220px;
    padding: 20px;
    background-color: #F4E7DA;
    min-height: 100vh;
}
.brand {
    text-align: center;
    margin-bottom: 20px;
}
.brand img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 6px;
}
.brand h3 {
    margin: 4px 0 0;
    font-weight: 700;
    font-size: 18px;
    letter-spacing: 1px;
}

.brand small {
    font-size: 11px;
    color: #e6d3c1;
}

.sidebar hr {
    border-top: 1px solid #7a5645;
}

</style>
</head>

<body>
<div class="container-fluid">
    <div class="row">

        <!-- ===================== SIDEBAR ===================== -->
        <div class="col-sm-3 sidebar">
    <!-- LOGO & BRAND -->
    <div class="brand">
        <img src="../assets/img/logo.png" alt="FluffyBake Logo">
        <h3>FLUFFYBAKE</h3>
        <small>cake & cookies</small>
    </div>
    <hr>
    <h4><?= strtoupper($role) ?> PANEL</h4>

            <?php if ($role === 'Admin'): ?>
                <a href="index.php?page=kelola_admin">Kelola Admin</a>
                <a href="index.php?page=kategori">Kategori</a>
                <a href="logout.php">Logout</a>

            <?php elseif ($role === 'Penjual'): ?>
                <a href="index.php?page=produk">Produk</a>
                <a href="index.php?page=pesanan">Pesanan</a>
                <a href="index.php?page=profil_view">Profil Penjual</a>
                <a href="logout.php">Logout</a>

            <?php elseif ($role === 'Pembeli'): ?>
                <a href="index.php?page=profilpem_view">Profil Pembeli</a>
                <a href="index.php?page=riwayat_pembelian">Riwayat Pembelian</a>
                <a href="logout.php">Logout</a>

            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </div>

        <!-- ===================== AREA KONTEN ===================== -->
        <div class="content">
            <?php
            $page = $_GET['page'] ?? '';

            switch ($page) {

                /* ===== ADMIN ===== */
                case 'kelola_admin': include "page/admin.php"; break;
                case 'kategori': include "page/kategori.php"; break;

                /* ===== PENJUAL ===== */
                case 'produk': include "page/produk.php"; break;
                case 'pesanan': include "page/pesanan.php"; break;
                case 'profil_view': include "page/profil_view.php"; break;
                case 'profil': include "page/profil.php"; break;
                case 'edit_bank': include "page/edit_bank.php"; break;
                case 'update_profil': include "page/update_profil.php"; break;
                case 'update_bank': include "page/update_bank.php"; break;

                /* ===== PEMBELI ===== */
                case 'profilpem_view': include "page/profilpem_view.php"; break;
                case 'profilpem': include "page/profilpem.php"; break;
                case 'editpem_bank': include "page/editpem_bank.php"; break;
                case 'updatepem_profil': include "page/updatepem_profil.php"; break;
                case 'updatepem_bank': include "page/updatepem_bank.php"; break;
                case 'riwayat_pembelian': include "page/riwayat_pembelian.php"; break;
                case 'terima_pesanan':
    include "page/terima_pesanan.php";
    break;
case 'detail_pesanan':
    include "page/detail_pesanan.php";
    break;

    case 'chat':
    include "page/chat.php";
    break;

                /* ===== DEFAULT ===== */
                default:
                    echo "<div class='alert alert-info'>
                            Silakan pilih menu di sidebar sesuai hak akses Anda.
                          </div>";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
