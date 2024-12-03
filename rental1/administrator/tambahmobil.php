<?php
include '../session/koneksi.php';
session_start();
if (isset($_SESSION["user"]) && $_SESSION["level"] == "admin") {
    echo "Selamat datang " . $_SESSION["user"];
} 
else {
    header("location: ../session/login.php");
}
 
if ($_SERVER['REQUEST_METHOD']=="POST"){
    $nopol = $_POST['nopol'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    
    $target_dir = "../img/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;

    }
    if (file_exists($target_file)) {
        header("location: admin_dashboard.php");
       
        $uploadOk = 0;
    }
    if ($_FILES["foto"]["size"] > 200000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["foto"]["name"])). " has been uploaded.";
            header("location: admin_dashboard.php");
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    $sql = $koneksi->prepare("INSERT INTO tbl_mobil (nopol, brand, type, tahun, harga, status, foto) VALUES (?, ? ,? ,? ,? ,? ,?)");
    $sql->bind_param("ssssiss", $nopol, $brand, $type, $tahun, $harga, $status, $target_file);
    $sql->execute();
    $sql->close();
    $koneksi->close();

}

?>

