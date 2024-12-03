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


                <h1 class="text-bold ">selamat datang </h1>
               
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
        $sql_bayar = "SELECT status FROM tbl_bayar WHERE id_kembali = '$row[id_kembali]' AND status = 'lunas'";
        $stmt_bayar = $koneksi->prepare($sql_bayar);
        $stmt_bayar->execute();
        $result_bayar = $stmt_bayar->get_result();
        if ($result_bayar->num_rows > 0) {
            $button = '<span class="font-medium text-green-600 dark:text-green-500">sudah lunas</span>';
        } else {
            if ($_SESSION['level'] == 'petugas') {
                $button = '<a href="#" onclick="document.getElementById(\'bayar_modal_' . $row['id_transaksi'] . '\').showModal()" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">bayar</a>';
            } else {
                $button = '<span class="font-medium text-yellow-600 dark:text-yellow-500">admin memantau</span>';
            }
        }
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
                <?php $sql_member = "SELECT nama FROM tbl_member WHERE nik = '$row[nik]'"; $stmt_member = $koneksi->prepare($sql_member); $stmt_member->execute(); $result_member = $stmt_member->get_result(); $row_member = $result_member->fetch_assoc(); echo $row_member['nama']; ?>
            </td>

            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                <?php echo $semua = $row['kekurangan'] + $row['denda']; ?>
            </td>


            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
    <?php
    // Query untuk mengambil status pembayaran
    $sql_status = "SELECT status FROM tbl_bayar WHERE id_kembali = ? AND status = 'lunas'";
    $stmt_status = $koneksi->prepare($sql_status);
    $stmt_status->bind_param('i', $row['id_kembali']); // Bind parameter id_kembali
    $stmt_status->execute();
    $result_status = $stmt_status->get_result();
    $row2 = $result_status->fetch_assoc();

    // Mengecek apakah ada hasil dari query
    if (isset($row2['status']) && $row2['status'] == 'lunas') {
        echo 'Lunas'; // Jika status lunas, tampilkan "Lunas"
    } else {
        echo 'Belum lunas'; // Jika tidak lunas, tampilkan "Belum lunas"
    }
    ?>
</td>

            <td class="px-6 py-4">
                <div class="flex space-x-2">
                    <?php echo $button ?>
                </div>
            </td>
        </tr>
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
    <dialog id="bayar_modal_<?php echo $row['id_transaksi']; ?>" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <div class="flex flex-col items-center py-4">
                <h3 class="text-lg font-bold">Mengembalikan Mobil dengan Nomor Polisi :</h3>
                <p class="py-2 m-2 text-center"><?php echo $row['nopol']; ?></p>
                <h3 class="text-lg font-bold">Nama Peminjam :</h3>
                <p class="py-4 m-4 text-center"><?php echo $row['nama']; ?></p>
                <h3 class="text-lg font-bold">Tanggal Ambil :</h3>
                <p class="py-4 m-4 text-center"><?php echo $row['tgl_ambil']; ?></p>
                <h3 class="text-lg font-bold">kekurangan </h3>
                <p class="py-4 m-4 text-center"><?php echo $row['kekurangan']; ?></p>

                <h3 class="text-lg font-bold"> denda </h3>
                <p class="py-4 m-4 text-center">
                    <?php
                    $sql = "SELECT denda FROM tbl_kembali WHERE id_transaksi = $row[id_transaksi]";
                    $result2 = $koneksi->query($sql);
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            echo " " . number_format($row2['denda'], 0, ',', '.');
                        }
                    }
                    ?>
                </p>
                <h3 class="text-lg font-bold"> bayar keseluruhan </h3>
                <p class="py-4 m-4 text-center">
                    <?php
                    $sql = "SELECT kekurangan FROM tbl_transaksi WHERE id_transaksi = $row[id_transaksi]";
                    $result2 = $koneksi->query($sql);
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            $kekurangan = $row2['kekurangan'];
                        }
                    }

                    $sql = "SELECT denda FROM tbl_kembali WHERE id_transaksi = $row[id_transaksi]";
                    $result2 = $koneksi->query($sql);
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            $denda = $row2['denda'];
                        }
                    }
                    $semua = $kekurangan + $denda;
                    echo " " . number_format($semua, 0, ',', '.');
                    ?>
                </p>
            </div>
            <div class="modal-action w-full">
                <form method="POST" class="justify-items-center w-full" action="prosesbayar.php"
                    enctype="multipart/form-data">
                    <input type="hidden" name="id_kembali" value="<?php echo $row['id_kembali']; ?>">
                    <input type="hidden" name="nopol" value="<?php echo $row['nopol']; ?>">







                    <div class="label">
                        <span class="label-text">Pelunasan</span>
                    </div>
                    <input type="number" value="<?php echo $semua; ?>" id="total_bayar" name="total_bayar"
                        class="input input-bordered w-full bg-transparent" required />
                    <div class="label">
                        <span class="label-text">tgl_bayar</span>
                    </div>
                    <input type="date" id="tgl_bayar" name="tgl_bayar"
                        class="input input-bordered w-full bg-transparent" required />

                       

                    <div class="label">
                        <span class="label-text">Status</span>
                    </div>
                    <select name="status" id="status" class="select select-bordered w-full" required>
                        <option value="lunas">lunas</option>
                        <option value="belum lunas">belum lunas</option>
                    </select>
                    <div class="modal-action">
                        <button type="submit" class="btn mt-4">Ya</button>
                        <button class="btn mt-4" type="button"
                            onclick="document.getElementById('bayar_modal_<?php echo $row['id_transaksi']; ?>').close()">Batal</button>
                    </div>

                    
                </form>
            </div>
        </div>
    </dialog>

    
    <?php
}
?>

</body>

</html>