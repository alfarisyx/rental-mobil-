<?php
include '../session/koneksi.php';
session_start();
if (isset($_SESSION["user"]) && $_SESSION["level"] == "admin") {
    echo "Selamat datang " . $_SESSION["user"];
} elseif (isset($_SESSION["user"]) && $_SESSION["level"] == "petugas") {
    echo "<script>alert('karyawan tidak berhak , wlee');</script>";
    header("location: admin_dashboard.php");
}else{
    header("location: ../session/login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.13/dist/full.min.css" rel="stylesheet" type="text/css" />
    <title>Document</title>
</head>
<?php
include '../layout/nav.html';
?>

<body class="bg-white">

    <div class="p-4 sm:ml-64 bg-white">
        <div class="p-4  mt-14 bg-white">
            <div class="flex justify-end mt-4"></div>
            <div class="grid grid-cols-3 gap-4 mb-4 bg-white">


                <h1 class="text-bold ">selamat datang admin</h1>

                <br>

                <div class=""></div>

            </div>

            <div class="mb-4 p-4 ">
                <button class="btn" onclick="my_modal_5.showModal()">tambah member</button>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-gray-800">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>

                            <th scope="col" class="px-6 py-3">no</th>
                            <th scope="col" class="px-6 py-3">id user</th>
                            <th scope="col" class="px-6 py-3">user</th>
                            <th scope="col" class="px-6 py-3">level</th>
                            <th scope="col" class="px-6 py-3">aksi</th>
                           

                        </tr>
                    </thead>
                    <tbody class="bg-white">

                        <?php
                        $no = 1;
                        $sql = "SELECT * FROM tbl_user where level = 'petugas'";
                        $result = $koneksi->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?php echo $no ++; ?>
                            </th>
                            <td class="px-6 py-4">
                                <?php echo $row['id_user']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $row['user']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $row['level']; ?>
                            </td>
                          
                            <td class="px-6 py-4">
                                <a href="#"
                                    onclick="document.getElementById('edit_modal_<?php echo $row['id_user']; ?>').showModal()"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                <a href="#"
                                    onclick="document.getElementById('delete_modal_<?php echo $row['id_user']; ?>').showModal()"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">hapus</a>
                               
                            </td>
                        </tr>

                        <?php
                            }     
                        } 
                        ?>

                        <?php
$result->data_seek(0); // Reset the result pointer
while ($row = $result->fetch_assoc()) {
?>

            <dialog id="edit_modal_<?php echo $row['id_user']; ?>" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold">Edit Data Petugas</h3>
        <form method="POST" class="space-y-4" action="editptgs.php" enctype="multipart/form-data">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">ID User</span>
                </label>
                <input type="text" name="id_user" value="<?php echo $row['id_user']; ?>" class="input input-bordered w-full bg-transparent" readonly />
            </div>


            <div class="form-control">
                <label class="label">
                    <span class="label-text">Username</span>
                </label>
                <input type="text" name="user" value="<?php echo $row['user']; ?>" class="input input-bordered w-full bg-transparent" required />
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">password</span>
                </label>
                <input type="text" name="pass" value="" class="input input-bordered w-full bg-transparent"  />
            </div>

           

           

           

            <div class="modal-action">
                <button type="submit" class="btn mt-4">Simpan</button>
                <button class="btn mt-4" type="button" onclick="document.getElementById('edit_modal_<?php echo $row['id_user']; ?>').close()">Batal</button>
            </div>
        </form>
    </div>
</dialog>

<?php
}
?>

<dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="text-lg font-bold">Tambahkan data petugas</h3>
        <form method="POST" class="space-y-4" action="tambahptgs.php" enctype="multipart/form-data">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Username</span>
                </label>
                <input type="text" name="user" maxlength="50" class="input input-bordered w-full bg-transparent" required />
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" name="pass" maxlength="50" class="input input-bordered w-full bg-transparent" required />
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Level</span>
                </label>
                <select name="level" class="select select-bordered w-full" required readonly>
                    <option value="petugas" selected readonly>Petugas</option>
                </select>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn mt-4">Submit</button>
                <button class="btn mt-4 " type="button" onclick="document.getElementById('my_modal_5').close()">Close</button>
            </div>
        </form>
    </div>
</dialog>


<?php
$result->data_seek(0);
while ($row = $result->fetch_assoc()) {
?>

<dialog id="delete_modal_<?php echo $row['id_user']; ?>" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="POST" action="hapusptgs.php" enctype="multipart/form-data">
            <!-- Menambahkan name pada input hidden -->
            <input type="hidden" name="id_user" value="<?php echo $row['id_user']; ?>" id="">

            <h1>Yakin menghapus user dengan username <?php echo $row['user']; ?>?</h1>

            <div class="modal-action">
                <button type="submit" class="btn mt-4">Ya</button>
                <button class="btn mt-4" type="button" onclick="document.getElementById('delete_modal_<?php echo $row['id_user']; ?>').close()">Batal</button>
            </div>
        </form>
    </div>
</dialog>

<?php
}

?>


            </tbody>
</body>

</html>