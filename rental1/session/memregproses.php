<?php
 
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"]== "POST"){
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];
    $user = $_POST['user'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    

    $sql = $koneksi->prepare("INSERT INTO tbl_member (nik, nama , jk , telp , alamat , user , pass) VALUES (?, ? ,? ,? ,? ,? ,?)");
    $sql->bind_param("issssss", $nik, $nama, $jk, $telp, $alamat, $user, $pass);

    if ($sql->execute()) {
        echo "<script>alert('New member registered successfully');</script>";
        header("location: login.php");
    } else {
        echo "<script>alert('Error: " . $sql->error . "');</script>";
    }
    $sql->close();
    $koneksi->close();
   
    
}
?>