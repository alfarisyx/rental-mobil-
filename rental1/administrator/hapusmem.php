<?php
include '../session/koneksi.php';
session_start();

// Mengecek apakah user memiliki akses admin
if (isset($_SESSION["user"]) && $_SESSION["level"] == "admin") {
    echo "Selamat datang " . $_SESSION["user"];
} else {
    header("location: ../session/login.php");
    exit();
}

// Memeriksa apakah form sudah dikirim dengan benar
if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];

    // Query untuk menghapus data berdasarkan nik
    $sql = "DELETE FROM tbl_member WHERE nik = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('s', $nik);

    // Eksekusi query dan cek apakah berhasil
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    } else {
        // Redirect ke halaman tambahmem.php setelah berhasil menghapus
        header("location: tambahmem.php");
    }
} else {
    // Jika nik tidak ditemukan dalam form, tampilkan pesan error
    echo "Data nik tidak ditemukan.";
}
?>