<?php
 session_start();
 include 'koneksi.php';

 if ($_SERVER["REQUEST_METHOD"]== "POST"){
    $username = $_POST['user'];
    $password = $_POST['pass'];

    $sql_user = " SELECT  * FROM tbl_user WHERE user = ? LIMIT 1 ";
    $stmt_user = $koneksi->prepare($sql_user);
    $stmt_user->bind_param("s", $username,);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
        if (password_verify($password,$user['pass'])){
            $_SESSION['user'] = $user['user'];
            $_SESSION['level'] = $user['level'];

            if ($user['level'] == 'admin'){
                header("location: ../administrator/admin_dashboard.php");
            }else{
                header("location: ../administrator/admin_dashboard.php");
            
            }
            exit();
        }else{
            echo "password jj salah";
        }

    }else{  
        $sql_member = "SELECT  * FROM tbl_member WHERE user = ? LIMIT 1 ";
        $stmt_member = $koneksi->prepare($sql_member);
        $stmt_member->bind_param("s", $username,);
        $stmt_member->execute();
        $result_member = $stmt_member->get_result();
        if ($result_member->num_rows > 0) {
            $member = $result_member->fetch_assoc();
            if (password_verify($password,$member["pass"])){
                $_SESSION["nik"] = $member["nik"];
                $_SESSION["user"] = $member["user"];

                header("location: ../member/member_dashboard.php");


        
            }else{
                echo "password salah";
            }
        }else{
            echo "akun tidak ditemukan";
        }
    }


 }

?>