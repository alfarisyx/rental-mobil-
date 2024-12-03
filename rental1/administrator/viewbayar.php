<?php
include '../session/koneksi.php';
session_start();
if (isset($_SESSION["user"]) && $_SESSION["level"]) {
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
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.13/dist/full.min.css" rel="stylesheet" type="text/css" />
    <title>Document</title>
</head>

<?php
include '../layout/nav.html';
?>

<body class="bg-white">
    <div class="p-4 sm:ml-64 bg-white">
        <div class="p-4 mt-14 bg-white">
            <div class="flex justify-end mt-4"></div>
            <div class="grid grid-cols-3 gap-4 mb-4 bg-white">
                <h1 class="text-bold">selamat datang admin</h1>
                <br>
                <div class=""></div>
            </div>

            <form method="GET" action="">
                <div class="flex gap-4 mb-4">
                    <div>
                        <label>Dari Tanggal:</label>
                        <input type="date" name="start_date" class="border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label>Sampai Tanggal:</label>
                        <input type="date" name="end_date" class="border rounded px-2 py-1" required>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Filter
                    </button>
                    <button type="submit" formaction="export.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Export Excel
                    </button>
                </div>
            </form>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-gray-800">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            
                            <th scope="col" class="px-6 py-3">nopol</th>
                            <th scope="col" class="px-6 py-3">nama peminjam</th>
                            <th scope="col" class="px-6 py-3">tanggal bayar</th>
                            <th scope="col" class="px-6 py-3">tanggal ambil</th>
                            <th scope="col" class="px-6 py-3">tanggal kembali</th>
                            <th scope="col" class="px-6 py-3">total</th>
                            <th scope="col" class="px-6 py-3">status</th>
                            <th scope="col" class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Default values for start and end dates
                        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
                        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

                        // SQL query with date filtering
                        $sql = "SELECT tbl_bayar.*, tbl_member.nama, tbl_kembali.id_kembali, tbl_transaksi.tgl_ambil, tbl_transaksi.tgl_kembali, tbl_transaksi.nopol
                                FROM tbl_bayar
                                JOIN tbl_kembali ON tbl_bayar.id_kembali = tbl_kembali.id_kembali
                                JOIN tbl_transaksi ON tbl_kembali.id_transaksi = tbl_transaksi.id_transaksi
                                JOIN tbl_member ON tbl_transaksi.nik = tbl_member.nik
                                WHERE tbl_bayar.status = 'lunas'";

                        // Add date filtering to the SQL query
                        if ($start_date && $end_date) {
                            $sql .= " AND tbl_bayar.tgl_bayar BETWEEN ? AND ?";
                        }

                        $stmt = $koneksi->prepare($sql);

                        // Bind parameters if filtering by date
                        if ($start_date && $end_date) {
                            $stmt->bind_param("ss", $start_date, $end_date);
                        }

                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        <div class="flex items"><?php echo $row['nopol']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        <?php echo $row['nama']; ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        <?php echo $row['tgl_bayar']; ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        <?php echo $row['tgl_ambil']; ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        <?php echo $row['tgl_kembali']; ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        <?php echo number_format($row['total_bayar'], 0, ',', '.'); ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        <?php echo $row['status']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <?php if ($row['status'] == 'tidak'): ?>
                                                <?php $button = '<a href="#" onclick="document.getElementById(\'bayar_modal_' . $row['id_transaksi'] . '\').showModal()" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">bayar</a>'; ?>
                                            <?php else: ?>
                                                <?php $button = '<span class="font-medium text-red-600 dark:text-red-500"> sudah lunas </span>'; ?>
                                            <?php endif; ?>
                                            <?= $button ?>
                                        </div>
                                    </td>
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
    </div>
</body>
</html>
