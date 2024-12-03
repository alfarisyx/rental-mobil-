<?php
include '../session/koneksi.php';
session_start();
if (isset($_SESSION["user"]) && $_SESSION["level"] == "petugas") {
    echo "Selamat datang " . $_SESSION["user"];
} else {
    header("location: ../session/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = $_POST['id_transaksi'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $kondisi_mobil = $_POST['kondisi_mobil'];
    $denda = $_POST['denda'];

    $sql = "INSERT INTO tbl_kembali (id_transaksi, tgl_kembali, kondisi_mobil, denda) VALUES (?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('issi', $id_transaksi, $tgl_kembali, $kondisi_mobil, $denda);
    if ($stmt->execute()) {
        $id_kembali = $stmt->insert_id;

        $sql_update = "UPDATE tbl_transaksi SET status = 'kembali' WHERE id_transaksi = ?";
        $stmt_update = $koneksi->prepare($sql_update);
        $stmt_update->bind_param('i', $id_transaksi);
        if ($stmt_update->execute()) {
            $sql_bayar = "INSERT INTO tbl_bayar (id_kembali, status) VALUES (?, 'belum lunas')";
            $stmt_bayar = $koneksi->prepare($sql_bayar);
            $stmt_bayar->bind_param('i', $id_kembali);
            if ($stmt_bayar->execute()) {
                $sql_update_mobil = "UPDATE tbl_mobil SET status = 'tersedia' WHERE nopol = (SELECT nopol FROM tbl_transaksi WHERE id_transaksi = ?)";
                $stmt_update_mobil = $koneksi->prepare($sql_update_mobil);
                $stmt_update_mobil->bind_param('i', $id_transaksi);
                if ($stmt_update_mobil->execute()) {
                    header("location: kembali.php");
                    exit();
                } else {
                    echo "Error updating mobil status: " . $stmt_update_mobil->error;
                }
            } else {
                echo "Error inserting bayar data: " . $stmt_bayar->error;
            }
        } else {
            echo "Error updating transaction status: " . $stmt_update->error;
        }
    } else {
        echo "Error inserting return data: " . $stmt->error;
    }
}
?>

