<?php
include '../session/koneksi.php';
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["level"] != "petugas") {
    header("location: ../session/login.php");
    exit();
}

if (isset($_GET['nopol'])) {
    $nopol = $_GET['nopol'];
    
    $stmt = $koneksi->prepare("DELETE FROM tbl_mobil WHERE nopol = ?");
    $stmt->bind_param("s", $nopol);
    
    if ($stmt->execute()) {
        $message = "Data mobil berhasil dihapus.";
        $alertType = "success";
    } else {
        $message = "Gagal menghapus data mobil: " . $stmt->error;
        $alertType = "error";
    }
    
    $stmt->close();
} else {
    $message = "Nomor polisi tidak ditemukan.";
    $alertType = "error";
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Data Mobil</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
    Swal.fire({
        icon: '<?php echo $alertType; ?>',
        title: '<?php echo $alertType == "success" ? "Berhasil!" : "Error!"; ?>',
        text: '<?php echo $message; ?>',
    }).then((result) => {
        window.location.href = 'admin_dashboard.php';
    });
    </script>
</body>
</html>