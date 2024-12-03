<?php
include '../session/koneksi.php';
session_start();
if (isset($_SESSION["user"]) && $_SESSION["level"] == "admin") {
    echo "Selamat datang " . $_SESSION["user"];
} else {
    header("location: ../session/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $user = $_POST['user'];
    $jk = $_POST['jk'];
    $telepon = $_POST['telp'];
    $alamat = $_POST['alamat'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);


    $sql = "INSERT INTO tbl_member (nik, nama, user, jk, telp, alamat , pass) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('issssss', $nik, $nama, $user, $jk, $telepon, $alamat, $password);
    if ($stmt->execute()) {
        header("location: tambahmem.php");
    }
}

   
?>