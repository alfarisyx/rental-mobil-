<?php
include '../session/koneksi.php';
session_start();
    if (isset($_SESSION["user"]) && $_SESSION["level"] == "petugas") {
        echo "Selamat datang " . $_SESSION["user"];
    } 
    else {
        header("location: ../session/login.php");
    }


    if ($_SERVER['REQUEST_METHOD']== 'POST'){

        $id_kembali = $_POST['id_kembali'];
        $tgl_bayar = $_POST['tgl_bayar'];
        $total_bayar = $_POST['total_bayar'];
        $status = $_POST['status'];

        $sql = "UPDATE tbl_bayar SET tgl_bayar = ?, total_bayar = ?, status = ? WHERE id_kembali = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sssi", $tgl_bayar, $total_bayar, $status, $id_kembali);
        if ($stmt->execute()){
            header("location: bayar.php");
        }

    }
?>

