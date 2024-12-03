<?php
include '../session/koneksi.php';
session_start();
if (isset($_SESSION["user"]) && $_SESSION["level"] == "admin") {
    echo "Selamat datang " . $_SESSION["user"];
} else {
    header("location: ../session/login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD']== 'POST'){

    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $user = $_POST['user'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telp'];
    $jk = $_POST['jk'];

    $sql = "UPDATE tbl_member SET nama = ?, user = ?, alamat = ?, telp = ?, jk = ? WHERE nik = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('sssssi', $nama, $user, $alamat, $telepon, $jk, $nik);
    if ($stmt->execute()) {
        header("location: tambahmem.php");
    }
}
?>