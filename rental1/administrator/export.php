<?php
// export.php
include "../session/koneksi.php";
session_start();

// Periksa apakah session user ada dan level tidak terisi
if (!isset($_SESSION['user']) || empty($_SESSION['level'])) {
    header("location:../login.php");
    exit();
}

// Periksa apakah start_date dan end_date disediakan
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Header untuk export Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Transaksi_" . date('Y-m-d') . ".xls");

// Tambahkan kondisi WHERE untuk filter tanggal jika tersedia
$sql = "SELECT tbl_bayar.*, tbl_member.nama, tbl_kembali.id_kembali, tbl_transaksi.tgl_ambil, tbl_transaksi.tgl_kembali
        FROM tbl_bayar
        JOIN tbl_kembali ON tbl_bayar.id_kembali = tbl_kembali.id_kembali
        JOIN tbl_transaksi ON tbl_kembali.id_transaksi = tbl_transaksi.id_transaksi
        JOIN tbl_member ON tbl_transaksi.nik = tbl_member.nik
        WHERE tbl_bayar.status = 'lunas'";

if ($start_date && $end_date) {
    $sql .= " AND tbl_bayar.tgl_bayar BETWEEN ? AND ?";
}

$stmt = $koneksi->prepare($sql);

// Jika ada filter tanggal, bind parameter
if ($start_date && $end_date) {
    $stmt->bind_param("ss", $start_date, $end_date);
}

$stmt->execute();
$result = $stmt->get_result();

// CSS untuk styling Excel
echo '<style>
    .header { font-weight: bold; background-color: #f0f0f0; }
    .total { font-weight: bold; background-color: #e0e0e0; }
    td, th { padding: 5px; }
</style>';
?>
<table border="1">
    <tr class="header">
        <th colspan="7" style="text-align: center; font-size: 16pt; height: 30px;">
            LAPORAN TRANSAKSI RENTAL MOBIL
        </th>
    </tr>
    <tr>
        <th colspan="7" style="text-align: center; font-size: 11pt;">
            Tanggal: <?php echo date('d-m-Y'); ?>
        </th>
    </tr>
    <tr></tr>
    <tr class="header">
        <th>No</th>
        <th>Nama</th>
        <th>Tgl. Ambil</th>
        <th>Tgl. Kembali</th>
        <th>Total Bayar</th>
        <th>Status</th>
    </tr>

    <?php
    $no = 1;
    $total_bayar = 0;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $total_bayar += $row['total_bayar'];
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $no++; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td style="text-align: center;"><?php echo $row['tgl_ambil']; ?></td>
                <td style="text-align: center;"><?php echo $row['tgl_kembali']; ?></td>
                <td style="text-align: right;">Rp. <?php echo number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                <td style="text-align: center;"><?php echo $row['status']; ?></td>
            </tr>
        <?php
        }
    }
    ?>
    <tr class="total">
        <td colspan="4" style="text-align: right;">Total Bayar:</td>
        <td style="text-align: right;">Rp. <?php echo number_format($total_bayar, 0, ',', '.'); ?></td>
        <td></td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="7" style="text-align: left; font-size: 11pt;">
            Dicetak pada: <?php echo date('d/m/Y H:i:s'); ?>
        </td>
    </tr>
</table>
