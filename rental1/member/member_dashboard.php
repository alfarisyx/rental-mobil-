<?php 
include '../session/koneksi.php';
session_start();
if (!isset($_SESSION["nik"]) || !isset($_SESSION["user"])) {
    header("location: ../session/login.php");
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.13/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <title>ReMob</title>
</head>

<?php include '../layout/navmem.html' ?>

<body class="bg-white min-h-screen">
    <div class="hero bg-white py-12">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold text-primary">Selamat Datang di ReMob</h1>
                <p class="py-6">halo <?php echo $_SESSION["user"]; ?>  pilih mobil yang akan kamu rental </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $sql = "SELECT * FROM tbl_mobil";
            $result = $koneksi->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                <figure class="px-6 pt-6">
                    <img src="<?php echo $row['foto']; ?>" alt="Mobil" class="rounded-xl h-48 w-full object-cover" />
                </figure>
                <div class="card-body items-center text-center">
                    <h2 class="card-title text-2xl font-bold"><?php echo $row['brand'] . " " . $row['type']; ?></h2>
                    <div class="badge badge-secondary mb-2">Nopol: <?php echo $row['nopol']; ?></div>
                    <p class="text-lg font-semibold text-primary">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>/day</p>

                    <?php if ($row['status'] == 'tersedia'): ?>
                    <div class="card-actions mt-4">
                        <button onclick="document.getElementById('booking_modal_<?php echo $row['nopol']; ?>').showModal()" 
                                class="btn btn-primary">Book Now</button>
                    </div>
                    <?php else: ?>
                    <div class="badge badge-error gap-2 mt-4">Tidak Tersedia</div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<div class='col-span-full text-center py-8 text-lg'>No vehicles available at the moment</div>";
            }
            ?>
        </div>
    </div>

    <?php
    $result->data_seek(0);
    while ($row = $result->fetch_assoc()) {
    ?>
    <dialog id="booking_modal_<?php echo $row['nopol']; ?>" class="modal">
        <div class="modal-box w-11/12 max-w-3xl">
            <div class="flex justify-between items-center border-b pb-4">
                <h3 class="text-2xl font-bold text-primary">Booking mobilmu</h3>
                <form method="dialog">
                    <button class="btn btn-circle btn-ghost">✕</button>
                </form>
            </div>
            
            <form method="POST" class="space-y-6 py-6" action="booking.php" enctype="multipart/form-data">
                <input type="hidden" name="nik" value="<?php echo $_SESSION["nik"]; ?>">
                <input type="hidden" name="nopol" value="<?php echo $row['nopol']; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">tanggal booking</span>
                        </label>
                        <input type="date" id="tgl_booking_<?php echo $row['nopol']; ?>" name="tgl_booking"
                            class="input input-bordered w-full" required value="<?php echo date('Y-m-d'); ?>" />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">tanggal ambil</span>
                        </label>
                        <input type="date" id="tgl_ambil_<?php echo $row['nopol']; ?>" name="tgl_ambil"
                            class="input input-bordered w-full" required />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">tanggal kembali</span>
                        </label>
                        <input type="date" id="tgl_kembali_<?php echo $row['nopol']; ?>" name="tgl_kembali"
                            class="input input-bordered w-full" required />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">butuh supir ?</span>
                        </label>
                        <select id="supir_<?php echo $row['nopol']; ?>" name="supir"
                            class="select select-bordered w-full" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Total </span>
                        </label>
                        <input type="text" id="total_<?php echo $row['nopol']; ?>" name="total"
                            class="input input-bordered w-full font-semibold text-primary" readonly />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Downpayment</span>
                        </label>
                        <input type="number" name="downpayment" id="downpayment_<?php echo $row['nopol']; ?>" 
                            step="0.01" placeholder="100000.00"
                            class="input input-bordered w-full" required />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">kekurangan</span>
                        </label>
                        <input type="text" id="kekurangan_<?php echo $row['nopol']; ?>" name="kekurangan"
                            class="input input-bordered w-full font-semibold text-error" readonly />
                    </div>
                </div>

                <div class="modal-action flex justify-end gap-2 mt-6">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn" onclick="document.getElementById('booking_modal_<?php echo $row['nopol']; ?>').close()">Close</button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
    (function() {
        const hargaPerHari = <?php echo $row['harga']; ?>;
        const biayaSupir = 200000;
        const nopol = "<?php echo $row['nopol']; ?>";

        document.getElementById('tgl_ambil_' + nopol).addEventListener('change', hitungTotal);
        document.getElementById('tgl_kembali_' + nopol).addEventListener('change', hitungTotal);
        document.getElementById('supir_' + nopol).addEventListener('change', hitungTotal);
        document.getElementById('downpayment_' + nopol).addEventListener('input', hitungKurang);

        function hitungTotal() {
            const tglAmbil = document.getElementById('tgl_ambil_' + nopol).value;
            const tglKembali = document.getElementById('tgl_kembali_' + nopol).value;
            const supir = document.getElementById('supir_' + nopol).value;

            if (tglAmbil && tglKembali) {
                const date1 = new Date(tglAmbil);
                const date2 = new Date(tglKembali);

                const timeDiff = Math.abs(date2.getTime() - date1.getTime());
                const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                let totalHarga = diffDays * hargaPerHari;

                if (supir === "1") {
                    totalHarga += biayaSupir;
                }

                document.getElementById('total_' + nopol).value = totalHarga;
                hitungKurang(); // Memanggil fungsi kekurangan
            }
        }

        function hitungKurang() {
            const totals = parseFloat(document.getElementById('total_' + nopol).value) || 0;
            const dp = parseFloat(document.getElementById('downpayment_' + nopol).value) || 0;

            let totalKurang = totals - dp;

            document.getElementById('kekurangan_' + nopol).value = totalKurang;
        }
    })();
    </script>
    <?php
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>
