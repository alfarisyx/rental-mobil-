<?php
include '../session/koneksi.php';
session_start();
if (isset($_SESSION["nik"]) && $_SESSION["user"]){
    echo "Selamat datang " . $_SESSION["user"];
} else {
    header("location: ../session/login.php");
    exit();
}

// Pastikan metode request POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_transaksi = $_POST['id_transaksi'];
    $nopol = $_POST['nopol'];

    // Hapus transaksi berdasarkan id_transaksi
    $sql = "DELETE FROM tbl_transaksi WHERE id_transaksi = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_transaksi);

    if ($stmt->execute()) {
        // Update status mobil di tbl_mobil menjadi 'tersedia'
        $update_sql = "UPDATE tbl_mobil SET status = 'tersedia' WHERE nopol = ?";
        $stmt2 = $koneksi->prepare($update_sql);
        $stmt2->bind_param("s", $nopol);
        if ($stmt2->execute()) {
            // Jika berhasil, redirect ke dashboard dengan pesan sukses
            header("Location: member_dashboard.php");
            exit();
        } else {
            echo "Error updating car status: " . $stmt2->error;
        }
    } else {
        echo "Error deleting transaction: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
    $stmt2->close();
    $koneksi->close();
} else {
    echo "Invalid request.";
}
?>
