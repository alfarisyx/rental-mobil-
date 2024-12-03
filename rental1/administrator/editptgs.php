<?php 
include '../session/koneksi.php';
session_start();

if (isset($_SESSION["user"]) && $_SESSION["level"] == "admin") {
    echo "Selamat datang " . $_SESSION["user"];
} elseif (isset($_SESSION["user"]) && $_SESSION["level"] == "petugas") {
    echo "<script>alert('karyawan tidak berhak, wlee');</script>";
    header("location: admin_dashboard.php");
    exit();
} else {
    header("location: ../session/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // Prepare the SQL statement
    if ($pass) {
        // Hash the password only if it's not empty
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "UPDATE tbl_user SET user = ?, pass = ? WHERE id_user = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param('ssi', $user, $pass, $id_user);
    } else {
        // Don't update the password if it's empty
        $sql = "UPDATE tbl_user SET user = ? WHERE id_user = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param('si', $user, $id_user);
    }

    // Execute the statement
    if ($stmt->execute()) {
        header("location: tambahpetugas.php");
    } else {
        echo $stmt->error; // Output error if it fails
    }
}
?>
