<?php
session_start();

include "koneksi.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $level = $_POST['level'];

    $stmt = $koneksi->prepare("INSERT INTO tbl_user (user, pass, level) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $pass, $level);

    if ($stmt->execute()) {
        echo "New admin registered successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$koneksi->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
</head>
<body>
    <h2>Register Admin</h2>
    <form method="post" action="">
        <label for="user">Username:</label><br>
        <input type="text" id="user" name="user" required><br>
        <label for="pass">Password:</label><br>
        <input type="password" id="pass" name="pass" required><br>
        <label for="level">Level:</label><br>
        <select id="level" name="level" required>
            <option value="admin">Admin</option>
            <option value="petugas">Petugas</option>
        </select><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>