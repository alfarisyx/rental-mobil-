<?php
    include '../session/koneksi.php';
    session_start();
    if (isset($_SESSION["user"]) && $_SESSION["level"] == "petugas") {
        echo "Selamat datang " . $_SESSION["user"];
    } else {
        header("location: ../session/login.php");
    }
   
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
 include '../layout/nav.html';
 ?>
<body>
     
<div class="p-4 sm:ml-64">
     <div class="p-4  mt-14">
        <div class="grid grid-cols-3 gap-4 mb-4">
           
              
               <h1 class="text-bold ">selamat datang petugas</h1>
               <br>
              
           </div>
        
        </div>
     </div>
  </div>
   
    
</body>
</html>