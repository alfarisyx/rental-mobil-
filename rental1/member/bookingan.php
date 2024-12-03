<?php
include '../session/koneksi.php';
session_start();

if (!isset($_SESSION["nik"]) || !isset($_SESSION["user"])) {
    header("location: ../session/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
   
    <title>Rental Dashboard</title>
   
</head>

<?php include '../layout/navmem.html' ?>

<body class="bg-white min-h-screen">
    <div class="hero bg-white py-12">
        <div class="hero-content bg-white text-center">
            <div class="max-w-md bg-white">
                <h1 class="text-5xl font-bold text-primary">riwayat transaksimu</h1>
                <p class="py-6">Your premier destination for quality car rentals. Choose from our wide selection of vehicles for your next journey.</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
                $nik = $_SESSION["nik"];
                $sql = "SELECT tbl_transaksi.*, tbl_mobil.foto 
                        FROM tbl_transaksi 
                        JOIN tbl_mobil ON tbl_transaksi.nopol = tbl_mobil.nopol 
                        WHERE tbl_transaksi.nik = ?";
                $stmt = $koneksi->prepare($sql);
                $stmt->bind_param("s", $nik);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                        <figure class="px-6 pt-6">
                                <img src="../img/<?php echo htmlspecialchars($row['foto']); ?>" 
                                     class="h-full w-full object-cover"
                                     alt="Vehicle Image">
                            </figure>
                            <div class="card-body p-4 text-sm">
                                <h2 class="card-title">Nopol: <?php echo htmlspecialchars($row['nopol']); ?></h2>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="font-semibold">Status:</span>
                                        <span class="px-2 py-1 rounded-full text-xs <?php echo $row['status'] === 'booking' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'; ?>">
                                            <?php echo htmlspecialchars($row['status']); ?>
                                        </span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-semibold">Booking:</span>
                                        <span><?php echo htmlspecialchars($row['tgl_booking']); ?></span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-semibold">Ambil:</span>
                                        <span><?php echo htmlspecialchars($row['tgl_ambil']); ?></span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-semibold">Kembali:</span>
                                        <span><?php echo htmlspecialchars($row['tgl_kembali']); ?></span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-semibold">Supir:</span>
                                        <span><?php echo $row['supir'] ? 'Memakai Supir' : 'Tidak Memakai Supir'; ?></span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-semibold">Total:</span>
                                        <span>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-semibold">DP:</span>
                                        <span>Rp <?php echo number_format($row['downpayment'], 0, ',', '.'); ?></span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-semibold">Kekurangan:</span>
                                        <span>Rp <?php echo number_format($row['kekurangan'], 0, ',', '.'); ?></span>
                                    </div>
                                </div>

                                <div class="card-actions justify-end mt-4">
                                    <?php if ($row['status'] === 'booking'): ?>
                                        <button onclick="document.getElementById('batal_modal_<?php echo $row['id_transaksi']; ?>').showModal()"
                                                class="btn btn-error btn-sm">
                                            Batalkan
                                        </button>
                                    <?php elseif ($row['status']== 'kembali'): ?>
                                        <span class="text-gray-500">transaksi anda telah selesai , terimakasih </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Cancel Modal -->
                        <dialog id="batal_modal_<?php echo $row['id_transaksi']; ?>" 
                                class="modal modal-bottom sm:modal-middle">
                            <div class="modal-box">
                                <h3 class="text-lg font-bold">Konfirmasi Pembatalan</h3>
                                <p class="py-4">Apakah Anda yakin ingin membatalkan booking mobil dengan Nopol: <?php echo htmlspecialchars($row['nopol']); ?>?</p>
                                <div class="modal-action">
                                    <form method="POST" action="batalkan.php">
                                        <input type="hidden" name="id_transaksi" value="<?php echo $row['id_transaksi']; ?>">
                                        <input type="hidden" name="nopol" value="<?php echo $row['nopol']; ?>">
                                        <div class="flex gap-2">
                                            <button type="submit" class="btn btn-error">Ya, Batalkan</button>
                                            <button type="button" 
                                                    class="btn"
                                                    onclick="document.getElementById('batal_modal_<?php echo $row['id_transaksi']; ?>').close()">
                                                Tidak
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </dialog>
                    <?php
                    }
                } else {
                    echo '<div class="col-span-full text-center py-8 bg-base-100 rounded-lg shadow">
                            <p class="text-gray-500">Tidak ada data transaksi</p>
                          </div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
