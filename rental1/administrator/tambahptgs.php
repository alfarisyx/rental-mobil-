<?php
include '../session/koneksi.php';
session_start();

// Check user session and role
if (isset($_SESSION["user"]) && $_SESSION["level"] == "admin") {
    echo "Selamat datang " . $_SESSION["user"];
} elseif (isset($_SESSION["user"]) && $_SESSION["level"] == "petugas") {
    echo "<script>alert('karyawan tidak berhak , wlee');</script>";
    header("location: admin_dashboard.php");
} else {
    header("location: ../session/login.php");
}

// Handle POST request to insert new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'];
    // Hash the password using password_hash
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $level = $_POST['level'];

    // Prepare SQL statement to prevent SQL injection
    $sql = "INSERT INTO tbl_user (user, pass, level) VALUES (?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sss", $user, $pass, $level);

    // Execute the statement and handle the response
    if ($stmt->execute()) {
        header("location: tambahpetugas.php");
    } else {
        echo $stmt->error;
    }
}
?>
