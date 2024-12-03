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
            <th scope="col" class="px-6 py-3">nik</th>
            <th scope="col" class="px-6 py-3">nama</th>
            <th scope="col" class="px-6 py-3">user</th>
            <th scope="col" class="px-6 py-3">jenis kelamin</th>
            <th scope="col" class="px-6 py-3">telp</th>
            <th scope="col" class="px-6 py-3">alamat</th>
            <th scope="col" class="px-6 py-3">aksi</th>
        </tr>
    </thead>
    <tbody class="bg-white">
        <?php
        $no = 1;
        $sql = "SELECT * FROM tbl_member";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?php echo $no++; ?>
                    </th>
                    <td class="px-6 py-4"><?php echo $row['nik']; ?></td>
                    <td class="px-6 py-4"><?php echo $row['nama']; ?></td>
                    <td class="px-6 py-4"><?php echo $row['user']; ?></td>
                    <td class="px-6 py-4"><?php echo $row['jk']; ?></td>
                    <td class="px-6 py-4"><?php echo $row['telp']; ?></td>
                    <td class="px-6 py-4"><?php echo $row['alamat']; ?></td>
                    <td class="px-6 py-4">
                        <a href="#" onclick="document.getElementById('edit_modal_<?php echo $row['nik']; ?>').showModal()"
                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        <a href="#" onclick="document.getElementById('delete_modal_<?php echo $row['nik']; ?>').showModal()"
                           class="font-medium text-red-600 dark:text-red-500 hover:underline">hapus</a>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <dialog id="edit_modal_<?php echo $row['nik']; ?>" class="modal modal-bottom sm:modal-middle">
                    <div class="modal-box">
                        <h3 class="font-bold">Edit Data Member</h3>
                        <form method="POST" class="space-y-4" action="editmem.php" enctype="multipart/form-data">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">NIK</span>
                                </label>
                                <input type="number" name="nik" value="<?php echo $row['nik']; ?>" maxlength="11" class="input input-bordered w-full bg-transparent" required />
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Nama</span>
                                </label>
                                <input type="text" name="nama" value="<?php echo $row['nama']; ?>" class="input input-bordered w-full bg-transparent" required />
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Username</span>
                                </label>
                                <input type="text" name="user" value="<?php echo $row['user']; ?>" class="input input-bordered w-full bg-transparent" required />
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Jenis Kelamin</span>
                                </label>
                                <select name="jk" class="select select-bordered w-full" required>
                                    <option value="L" <?php if($row['jk'] == 'L') echo "selected"; ?>>Laki-laki</option>
                                    <option value="P" <?php if($row['jk'] == 'P') echo "selected"; ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">No Telp</span>
                                </label>
                                <input type="number" name="telp" value="<?php echo $row['telp']; ?>" class="input input-bordered w-full bg-transparent" required />
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Alamat</span>
                                </label>
                                <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>" class="input input-bordered w-full bg-transparent" required />
                            </div>
                            <div class="modal-action">
                                <button type="submit" class="btn mt-4">Simpan</button>
                                <button class="btn mt-4" type="button" onclick="document.getElementById('edit_modal_<?php echo $row['nik']; ?>').close()">Batal</button>
                            </div>
                        </form>
                    </div>
                </dialog>
        <?php
            }
        }
        ?>
    </tbody>
</table>


<dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="text-lg font-bold">Tambahkan data member</h3>
        <form method="POST" class="space-y-4" action="tambahmember.php" enctype="multipart/form-data">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">NIK</span>
                </label>
                <input type="number" name="nik" maxlength="10" class="input input-bordered w-full bg-transparent" required />
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input type="text" name="nama" maxlength="50" class="input input-bordered w-full bg-transparent" required />
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Username</span>
                </label>
                <input type="text" name="user" maxlength="50" class="input input-bordered w-full bg-transparent" required />
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Jenis Kelamin</span>
                </label>
                <select name="jk" class="select select-bordered w-full" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">No Telp</span>
                </label>
                <input type="number" name="telp" maxlength="50" class="input input-bordered w-full bg-transparent" required />
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Alamat</span>
                </label>
                <input type="text" name="alamat" maxlength="50" class="input input-bordered w-full bg-transparent" required />
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" name="pass" maxlength="50" class="input input-bordered w-full bg-transparent" required />
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

<dialog id="delete_modal_<?php echo $row['nik']; ?>" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="POST" action="hapusmem.php" enctype="multipart/form-data">
            <!-- Menambahkan name pada input hidden -->
            <input type="hidden" name="nik" value="<?php echo $row['nik']; ?>" id="">

            <h1>Yakin menghapus user dengan username <?php echo $row['user']; ?>?</h1>

            <div class="modal-action">
                <button type="submit" class="btn mt-4">Ya</button>
                <button class="btn mt-4" type="button" onclick="document.getElementById('delete_modal_<?php echo $row['nik']; ?>').close()">Batal</button>
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