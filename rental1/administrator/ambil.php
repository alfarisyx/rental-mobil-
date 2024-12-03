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
                <ul class="menu menu-horizontal rounded-lg bg-base-200 shadow-lg">
                    <li><a href="approve.php" class="btn btn-ghost btn-md  m-2">Approve</a></li>
                    <li><a href="ambil.php" class="btn btn-ghost btn-md bg-gray-700 m-2">Ambil</a></li>
                    <li><a href="kembali.php" class="btn btn-ghost btn-md m-2">Kembali</a></li>
                </ul>
                <br>

                <div class=""></div>

            </div>


            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-gray-800">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-16 py-3">
                                <span class="sr-only">Image</span>
                            </th>
                            <th scope="col" class="px-6 py-3">nopol</th>
                            <th scope="col" class="px-6 py-3">tanggal booking</th>
                            <th scope="col" class="px-6 py-3">tanggal ambil</th>
                            <th scope="col" class="px-6 py-3">tanggal kembali</th>
                            <th scope="col" class="px-6 py-3">supir</th>
                            <th scope="col" class="px-6 py-3">total</th>
                            <th scope="col" class="px-6 py-3">dp</th>
                            <th scope="col" class="px-6 py-3">kekurangan</th>
                            <th scope="col" class="px-6 py-3">status</th>
                            <th scope="col" class="px-6 py-3">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
$sql = "SELECT tbl_transaksi.*, tbl_mobil.foto FROM tbl_transaksi JOIN tbl_mobil WHERE tbl_transaksi.nopol = tbl_mobil.nopol AND tbl_transaksi.status = 'approve'";
$stmt = $koneksi->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">


                            <div class="flex hidden items">
                                <?php echo $row['id_transaksi']; ?>
                            </div>

                            <td class="px-6 py-4">
                                <img src="../img/<?php echo $row['foto']; ?>" class="w-10 h-10" alt="">
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items">
                                    <?php echo $row['nopol']; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php echo $row['tgl_booking']; ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php echo $row['tgl_ambil']; ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php echo $row['tgl_kembali']; ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php if($row['supir'] == 1 ) echo "memakai supir" ?>
                                <?php if($row['supir']== 0) echo "tidak memakai supir" ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php echo $row['total']; ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php echo $row['downpayment']; ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php echo $row['kekurangan']; ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php echo $row['status']; ?>
                            </td>
                            <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                    <?php if ($_SESSION['level']=='petugas' && $row['status'] == 'approve'): ?>
                                    <?php $button = '<a href="#" onclick="document.getElementById(\'ambil_modal_' . $row['id_transaksi'] . '\').showModal()" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">ambil</a>'; ?>
                                    <?php else: ?>
                                    <?php $button = '<span class="font-medium text-red-600 dark:text-red-500"> enak memantau to ? wkwkw </span>'; ?>
                                    <?php endif; ?>
                                    <?= $button ?>

                                </div>


                            </td>
                            <?php
    }
} else {
    echo "<tr><td colspan='7' class='text-center py-4'>No records found</td></tr>";
}
?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <?php
$result->data_seek(0); // Reset the result pointer
while ($row = $result->fetch_assoc()) {
?>
    <dialog id="ambil_modal_<?php echo $row['id_transaksi']; ?>" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="text-lg font-bold">sudah diambil ??</h3>
            <p class="py-4 m-4">
                <?php echo $row['nopol']; ?>?</p>
            <div class="modal-action w-full">
                <form method="POST" class="justify-items-center w-full" action=""
                    enctype="multipart/form-data">
                    <!-- Kirim id_transaksi dan nopol melalui hidden input -->
                    <input type="hidden" name="id_transaksi" value="<?php echo $row['id_transaksi']; ?>">
                    <input type="hidden" name="nopol" value="<?php echo $row['nopol']; ?>">

                    <div class="modal-action">
                        <button type="submit" class="btn mt-4">Ya</button>
                        <button class="btn mt-4" type="button"
                            onclick="document.getElementById('ambil_modal_<?php echo $row['id_transaksi']; ?>').close()">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </dialog>
    <?php
}
?>

<?php
if ($_SERVER['REQUEST_METHOD']== 'POST'){
    $id_transaksi = $_POST['id_transaksi'];
    

    $sql = "UPDATE tbl_transaksi SET status = 'ambil' where id_transaksi = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('i', $id_transaksi);
    if ($stmt->execute()) {
        //header("location: ambil.php.php.php"); // sudah tidak perlu
        echo "<script>window.location.href='ambil.php';</script>";
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}
?>
   


?>

    
</body>
</html>