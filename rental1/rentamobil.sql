-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 10:19 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentamobil`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bayar`
--

CREATE TABLE `tbl_bayar` (
  `id_bayar` int(11) NOT NULL,
  `id_kembali` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `total_bayar` decimal(10,0) NOT NULL,
  `status` enum('lunas','belum lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bayar`
--

INSERT INTO `tbl_bayar` (`id_bayar`, `id_kembali`, `tgl_bayar`, `total_bayar`, `status`) VALUES
(3, 5, '2024-10-25', '1300000', 'lunas'),
(4, 6, '2024-10-26', '800000', 'lunas'),
(5, 7, '2024-10-26', '500000', 'lunas'),
(6, 8, '2024-10-24', '0', 'lunas'),
(7, 9, '2024-10-27', '300000', 'lunas');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kembali`
--

CREATE TABLE `tbl_kembali` (
  `id_kembali` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kondisi_mobil` text NOT NULL,
  `denda` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kembali`
--

INSERT INTO `tbl_kembali` (`id_kembali`, `id_transaksi`, `tgl_kembali`, `kondisi_mobil`, `denda`) VALUES
(5, 9, '2024-10-25', '0', '1000000'),
(6, 12, '2024-10-26', '0', '600000'),
(7, 13, '2024-10-26', 'baik', '300000'),
(8, 14, '2024-10-24', 'baik', '100000'),
(9, 15, '2024-10-27', 'baik', '100000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

CREATE TABLE `tbl_member` (
  `nik` int(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `user` varchar(15) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_member`
--

INSERT INTO `tbl_member` (`nik`, `nama`, `jk`, `telp`, `alamat`, `user`, `pass`) VALUES
(2020390291, 'yo', 'L', '0909099909099', '0', 'yo', '$2y$10$SZelU9pD7Nbbpm5A.fFSD.Fe.0W8m98gN8NBEM34O8u1KSAmSMW9S'),
(2147483647, 'jono', 'L', '089509838010', '0', 'jono', '$2y$10$H49.2NiEDiotjBpIC2n3NuO0K2AnAvHN4y10GmgM7ZWvYFCe3rb1W');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mobil`
--

CREATE TABLE `tbl_mobil` (
  `nopol` varchar(10) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `tahun` date NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `status` enum('tersedia','tidak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_mobil`
--

INSERT INTO `tbl_mobil` (`nopol`, `brand`, `type`, `tahun`, `harga`, `foto`, `status`) VALUES
('AA 2030 BA', 'Mercedesw', 'Benz', '2024-10-22', '100000.00', 'ferrari.jpg', 'tersedia'),
('AA 2323 BA', 'toyota', 'avanza', '2024-10-17', '200000.00', '../img/avanza.jpeg', 'tersedia'),
('AA 30 AB', 'Mercedes', 'Benz', '2024-10-16', '100000.00', '../img/bentley.jpg', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `nik` int(50) NOT NULL,
  `nopol` varchar(10) NOT NULL,
  `tgl_booking` date NOT NULL,
  `tgl_ambil` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `supir` tinyint(1) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `downpayment` decimal(10,0) NOT NULL,
  `kekurangan` decimal(10,0) NOT NULL,
  `status` enum('booking','approve','ambil','kembali') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transaksi`
--

INSERT INTO `tbl_transaksi` (`id_transaksi`, `nik`, `nopol`, `tgl_booking`, `tgl_ambil`, `tgl_kembali`, `supir`, `total`, `downpayment`, `kekurangan`, `status`) VALUES
(9, 2147483647, 'AA 2323 BA', '2024-10-21', '2024-10-21', '2024-10-23', 1, '600000', '300000', '300000', 'kembali'),
(12, 2147483647, 'AA 2323 BA', '2024-10-23', '2024-10-23', '2024-10-24', 0, '200000', '0', '200000', 'kembali'),
(13, 2020390291, 'AA 30 AB', '2024-10-24', '2024-10-24', '2024-10-25', 1, '300000', '100000', '200000', 'kembali'),
(14, 2020390291, 'AA 2323 BA', '2024-10-24', '2024-10-24', '2024-10-25', 1, '400000', '500000', '-100000', 'kembali'),
(15, 2147483647, 'AA 30 AB', '2024-10-24', '2024-10-25', '2024-10-26', 1, '300000', '100000', '200000', 'kembali');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `level` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `user`, `pass`, `level`) VALUES
(1, 'sava', '$2y$10$O6uI1tzjctl8f0CsJk4IUOYSQ0H5KcGYVgeYaRRqItj3WMiXSf/9.', 'admin'),
(2, 'petugas', '$2y$10$tp/ASdD1QPbPwqp.QXXJGOKl5PvSi8oNUFfC2kRxrilbh9y1rpOsW', 'petugas'),
(3, 'jomok', '$2y$10$Xn9Fzb./xosunKk4gE.OqeQZl7W064kPHRoUUWhG73c5W4svtqkeC', 'admin'),
(4, 'sava', '$2y$10$.lJ8upeLhGM/kLD6BggrpO05kPTBbY/OKy87zEHqQPtMUiztIHP7a', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_bayar`
--
ALTER TABLE `tbl_bayar`
  ADD PRIMARY KEY (`id_bayar`);

--
-- Indexes for table `tbl_kembali`
--
ALTER TABLE `tbl_kembali`
  ADD PRIMARY KEY (`id_kembali`),
  ADD UNIQUE KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD PRIMARY KEY (`nik`),
  ADD UNIQUE KEY `telp` (`telp`);

--
-- Indexes for table `tbl_mobil`
--
ALTER TABLE `tbl_mobil`
  ADD PRIMARY KEY (`nopol`);

--
-- Indexes for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_bayar`
--
ALTER TABLE `tbl_bayar`
  MODIFY `id_bayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_kembali`
--
ALTER TABLE `tbl_kembali`
  MODIFY `id_kembali` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
