<?php
    include '../session/koneksi.php';
    session_start();
    if (isset($_SESSION["user"]) && $_SESSION["level"]) {
        echo "Selamat datang " . $_SESSION["user"];
    } 
    else {
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

            <?php
           if($_SESSION['level'] == 'petugas'){

               echo '<div class="mb-4 p-4 ">
                   <button class="btn" onclick="document.getElementById(\'my_modal_5\').showModal()">tambah mobil</button>
               </div>';
           }
           ?>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-gray-800">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-16 py-3">
                                <span class="sr-only">Image</span>
                            </th>
                            <th scope="col" class="px-6 py-3">merk</th>
                            <th scope="col" class="px-6 py-3">nopol</th>
                            <th scope="col" class="px-6 py-3">harga</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <?php
                            if($_SESSION['level'] == 'petugas'){
                                echo '<th scope="col" class="px-6 py-3">Action</th>';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
            $sql = "SELECT * FROM tbl_mobil";
            $result = $koneksi->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="p-4">
                                <img src="<?php echo $row['foto']; ?>" class="w-16 md:w-32 max-w-full max-h-full"
                                    alt="Car Image">
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php echo $row['brand'] . " " . $row['type']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items">
                                    <?php echo $row['nopol']; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php echo $row['harga']; ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php echo $row['status']; ?>
                            </td>
                         
                            <?php 
                            if($_SESSION['level'] == 'petugas'){
                                echo '<td class="px-6 py-4">
                                <a href="#"
                                    onclick="document.getElementById(\'edit_modal_' . $row['nopol'] . '\').showModal()"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                <a href="#" onclick="confirmDelete(\'' . $row['nopol'] . '\')"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</a>
                            </td>';
                            }
                            ?>
                         
                        </tr>



                        <?php
                }
            } else {
                echo "<tr><td colspan='6' class='text-center py-4'>No records found</td></tr>";
            }
            ?>
                    </tbody>
                </table>
            </div>
        </div>


        <?php
$result->data_seek(0); // Reset the result pointer
while ($row = $result->fetch_assoc()) {
?>
        <dialog id="edit_modal_<?php echo $row['nopol']; ?>" class="modal modal-bottom sm:modal-middle">
            <div class="modal-box">
                <h3 class="text-lg font-bold">Edit data mobil</h3>
                <p class="py-4"></p>
                <div class="modal-action w-full">
                    <form method="POST" class=" w-full" action="editmobil.php"
                        enctype="multipart/form-data">
                        <input type="hidden" name="original_nopol" value="<?php echo $row['nopol']; ?>">

                        <div class="label">
                            <span class="label-text">Nomor Polisi</span>
                        </div>
                        <input type="text" name="nopol" value="<?php echo $row['nopol']; ?>" placeholder="AA 2323 BA"
                            maxlength="10" class="input input-bordered w-full bg-transparent" required />

                        <div class="label">
                            <span class="label-text">Brand</span>
                        </div>
                        <input type="text" name="brand" value="<?php echo $row['brand']; ?>" placeholder="Toyota"
                            maxlength="50" class="input input-bordered w-full bg-transparent" required />

                        <div class="label">
                            <span class="label-text">Type</span>
                        </div>
                        <input type="text" name="type" value="<?php echo $row['type']; ?>" placeholder="Avanza"
                            maxlength="50" class="input input-bordered w-full bg-transparent" required />

                        <div class="label">
                            <span class="label-text">Tahun</span>
                        </div>
                        <input type="date" name="tahun" value="<?php echo $row['tahun']; ?>"
                            class="input input-bordered w-full bg-transparent" required />

                        <div class="label">
                            <span class="label-text">Harga</span>
                        </div>
                        <input type="number" name="harga" value="<?php echo $row['harga']; ?>" step="0.01"
                            placeholder="100000.00" class="input input-bordered w-full bg-transparent" required />

                        <div class="label">
                            <span class="label-text">Status</span>
                        </div>
                        <select name="status" class="select select-bordered w-full" required>
                            <option value="tersedia" <?php if($row['status']=='tersedia') echo 'selected'; ?>>Tersedia
                            </option>
                            <option value="tidak" <?php if($row['status']=='tidak') echo 'selected'; ?>>Tidak Tersedia
                            </option>
                        </select>

                        <div class="modal-action">
                            <button type="submit" class="btn mt-4">Submit</button>
                            <button class="btn mt-4" type="button"
                                onclick="document.getElementById('edit_modal_<?php echo $row['nopol']; ?>').close()">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </dialog>
        <?php
}
?>





    </div>
    </div>
    </div>

    <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Tambahkan data mobil</h3>
            <p class="py-4"></p>
            <div class="modal-action w-full">
                <form method="POST" class=" w-full" action="tambahmobil.php"
                    enctype="multipart/form-data">

                    <div class="label">
                        <span class="label-text">Nomor Polisi</span>
                    </div>
                    <input type="text" name="nopol" placeholder="AA 2323 BA" maxlength="10"
                        class="input input-bordered w-full bg-transparent" required />

                    <div class="label">
                        <span class="label-text">Brand</span>
                    </div>
                    <input type="text" name="brand" placeholder="Toyota" maxlength="50"
                        class="input input-bordered w-full bg-transparent" required />

                    <div class="label">
                        <span class="label-text">Type</span>
                    </div>
                    <input type="text" name="type" placeholder="Avanza" maxlength="50"
                        class="input input-bordered w-full bg-transparent" required />

                    <div class="label">
                        <span class="label-text">Tahun</span>
                    </div>
                    <input type="date" name="tahun" class="input input-bordered w-full bg-transparent" required />

                    <div class="label">
                        <span class="label-text">Harga</span>
                    </div>
                    <input type="number" name="harga" step="0.01" placeholder="100000.00"
                        class="input input-bordered w-full bg-transparent" required />

                    <div class="label">
                        <span class="label-text">Foto</span>
                    </div>
                    <input type="file" name="foto" accept="image/*"
                        class="file-input file-input-bordered w-full bg-transparent" required />

                    <div class="label">
                        <span class="label-text">Status</span>
                    </div>
                    <select name="status" class="select select-bordered w-full" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="tidak">Tidak Tersedia</option>
                    </select>

                    <!-- Submit button -->
                    <button type="submit" class="btn mt-4 w-full">Submit</button>
                    <button class="btn mt-4 w-full" type="button"
                        onclick="document.getElementById('my_modal_5').close()">Close</button>
                </form>

                <!-- Close button that won't submit the form -->
            </div>
        </div>
    </dialog>




    <script>
    function confirmDelete(nopol) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data mobil akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'deletemobil.php?nopol=' + nopol;
            }
        })
    }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>