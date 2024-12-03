<?php
include '../session/koneksi.php';
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["level"] != "petugas") {
    header("location: ../session/login.php");
    exit();
}

echo "Selamat datang " . $_SESSION["user"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nopol = $_POST['nopol'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    $target_file = "";
    $uploadOk = 1;

    if (!empty($_FILES["foto"]["name"])) {
        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        
        if ($_FILES["foto"]["size"] > 200000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars(basename($_FILES["foto"]["name"])). " has been uploaded.";
                
            } else {
                echo "Sorry, there was an error uploading your file.";
                $uploadOk = 0;
            }
        }
    }

    if ($uploadOk == 1) {
        if (!empty($target_file)) {
            $sql = $koneksi->prepare("UPDATE tbl_mobil SET nopol = ?, brand = ?, type = ?, tahun = ?, harga = ?, status = ?, foto = ? WHERE nopol = ?");
            $sql->bind_param("ssssisss", $nopol, $brand, $type, $tahun, $harga, $status, $target_file, $nopol);
        } else {
            $sql = $koneksi->prepare("UPDATE tbl_mobil SET nopol = ?, brand = ?, type = ?, tahun = ?, harga = ?, status = ? WHERE nopol = ?");
            $sql->bind_param("ssssiss", $nopol, $brand, $type, $tahun, $harga, $status, $nopol);
        }

        if ($sql->execute()) {
            echo "Data berhasil diupdate.";
            header("location: admin_dashboard.php");
        } else {
            echo "Error: " . $sql->error;
        }
        $sql->close();
    } else {
        echo "Data tidak diupdate karena ada masalah dengan upload file.";
    }
}

$koneksi->close();
?>