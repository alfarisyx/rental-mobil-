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
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
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
            <button onclick="window.print();" class="no-print bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mb-4">Cetak Laporan</button>
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
                            <th scope="col" class="px-6 py-3">peminjam</th>
                            <th scope="col" class="px-6 py-3">total</th>
                            
                            <th scope="col" class="px-6 py-3">status</th>
                            <th scope="col" class="px-6 py-3">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
$sql = "SELECT tbl_transaksi.*, tbl_mobil.foto, tbl_member.nama, tbl_kembali.denda, tbl_kembali.id_kembali FROM tbl_transaksi JOIN tbl_mobil ON tbl_transaksi.nopol = tbl_mobil.nopol JOIN tbl_member ON tbl_transaksi.nik = tbl_member.nik JOIN tbl_kembali ON tbl_transaksi.id_transaksi = tbl_kembali.id_transaksi WHERE tbl_transaksi.status = 'kembali'";
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
                                <?php $sql = "SELECT nama FROM tbl_member WHERE nik = '$row[nik] ";echo $row['nama']; ?>
                            </td>
                           
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php echo $semua = $row['kekurangan'] + $row['denda']; ?>
                            </td>
                          
                  
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?php $sql ="SELECT status FROM tbl_bayar WHERE id_kembali = '$row[id_kembali]'"; $stmt = $koneksi->prepare($sql); $stmt->execute(); $result = $stmt->get_result(); $row2 = $result->fetch_assoc(); echo $row2['status']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <?php if ($row['status'] == 'belum lunas'): ?>
                                    <?php $button = '<a href="#" onclick="document.getElementById(\'bayar_modal_' . $row['id_transaksi'] . '\').showModal()" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">bayar</a>'; ?>
                                    <?php else: ?>
                                    <?php $button = '<span class="font-medium text-red-600 dark:text-red-500"> sudah lunas </span>'; ?>
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
    