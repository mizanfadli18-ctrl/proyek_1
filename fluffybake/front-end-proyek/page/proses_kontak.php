<?php

require_once '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nama   = $_POST["nama"];
    $email  = $_POST["email"];
    $alamat = $_POST["alamat"];
    $pesan  = $_POST["pesan"];

    
    $stmt = mysqli_prepare($koneksi, "INSERT INTO kontak (nama, email, alamat, pesan) VALUES (?, ?, ?, ?)");
    
    
    if ($stmt === false) {
        die("Error menyiapkan statement: " . mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param($stmt, "ssss", $nama, $email, $alamat, $pesan);

    
    if (mysqli_stmt_execute($stmt)) {
        echo "<h3>Data berhasil disimpan ke database!</h3>";
        echo "Nama: " . htmlspecialchars($nama) . "<br>";
        echo "Email: " . htmlspecialchars($email) . "<br>";
        echo "Alamat: " . htmlspecialchars($alamat) . "<br>";
        echo "Pesan: " . htmlspecialchars($pesan) . "<br>";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Akses tidak valid.";
}

?>
