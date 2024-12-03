<?php 

include '../session/koneksi.php';
session_start();
if (isset($_SESSION["nik"]) && $_SESSION["user"]) {
    echo "Selamat datang " . $_SESSION["user"];
} else {
    header("location: ../session/login.php");
    exit();
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST'){
    $nik = $_POST['nik'];
    $nopol = $_POST['nopol'];
    $tgl_booking = $_POST['tgl_booking'];
    $tgl_ambil = $_POST['tgl_ambil'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $supir = $_POST['supir'];
    $downpayment = $_POST['downpayment'];
    
    $harga_sql = "SELECT harga from tbl_mobil WHERE nopol=?";
    $stmt_harga = $koneksi->prepare($harga_sql);
    $stmt_harga->bind_param("s", $nopol);
    $stmt_harga->execute();
    $stmt_harga->bind_result($harga);
    $stmt_harga->fetch();
    $stmt_harga->close();

    if ($harga){
        $total = ceil(abs(strtotime($tgl_kembali) - strtotime($tgl_ambil)) / 86400) * $harga;
        if ($supir == 1) {
            $total += 200000;
        }
        $kekurangan = $total - $downpayment;
        $sql = "INSERT INTO tbl_transaksi (nik, nopol, tgl_booking, tgl_ambil, tgl_kembali, supir, total, downpayment, kekurangan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sssssiiii", $nik, $nopol, $tgl_booking, $tgl_ambil, $tgl_kembali, $supir, $total, $downpayment, $kekurangan);
        if ($stmt->execute()) {
            $update_sql = "UPDATE tbl_mobil SET status='tidak' WHERE nopol=?";
            $stmt2 = $koneksi->prepare($update_sql);
            $stmt2->bind_param("s", $nopol);
            if ($stmt2->execute()) {
                echo "Data inserted successfully";
                header("location: bookingan.php");
            } else {
                echo "Error: " . $stmt2->error;
            }
            $stmt2->close();
        } else {
            
            echo "Error: " . $stmt->error;
        }
    }
    
}





?>

