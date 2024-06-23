-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2024 at 03:52 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_q2`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `iddetail` int(11) NOT NULL,
  `idtransaksi` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `idkaryawan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`iddetail`, `idtransaksi`, `idproduk`, `jumlah`, `harga`, `idkaryawan`) VALUES
(16, 16, 1, 1, '25000.00', NULL),
(17, 17, 4, 2, '2400.00', NULL),
(18, 18, 3, 2, '90000.00', NULL),
(19, 19, 7, 2, '360000.00', NULL),
(20, 20, 7, 2, '360000.00', NULL),
(21, 21, 10, 2, '70000.00', NULL),
(22, 22, 10, 1, '25000.00', NULL),
(23, 23, 2, 2, '0.00', NULL),
(24, 24, 1, 1, '0.00', NULL),
(25, 25, 1, 1, '0.00', NULL),
(26, 26, 7, 1, '0.00', NULL),
(27, 27, 14, 1, '0.00', NULL),
(28, 28, 2, 1, '0.00', NULL),
(29, 29, 7, 1, '0.00', NULL),
(30, 30, 10, 1, '0.00', NULL),
(31, 31, 7, 2, '0.00', NULL),
(34, 34, 10, 2, '35000.00', NULL),
(35, 35, 2, 2, '105000.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `idkaryawan` int(11) NOT NULL,
  `namakaryawan` varchar(30) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`idkaryawan`, `namakaryawan`, `username`, `password`, `role`, `alamat`, `telepon`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'nguwok', '08001'),
(2, 'user', 'user', 'user', 'user', 'kdp', '08002'),
(3, 'adam', 'adam', '123', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `idpelanggan` int(11) NOT NULL,
  `namapelanggan` varchar(255) NOT NULL,
  `alamatpelanggan` text DEFAULT NULL,
  `teleponpelanggan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`idpelanggan`, `namapelanggan`, `alamatpelanggan`, `teleponpelanggan`) VALUES
(1, 'umum', '-', '-'),
(2, 'ujang', 'bandung', '0812'),
(5, 'mufrody', 'jombang', '08123'),
(6, 'Andiana', 'jakarta', '08888');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `namaproduk` varchar(255) NOT NULL,
  `hargaproduk` decimal(10,0) NOT NULL,
  `stokproduk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `namaproduk`, `hargaproduk`, `stokproduk`) VALUES
(1, 'Cat Tembok Avian 1KG', '25000', 140),
(2, 'Semen Portland 40 kg', '105000', 50),
(3, 'Genteng Beton Flat 1m', '45000', 197),
(4, 'Batu Bata Merah Press', '1200', 496),
(5, 'Keramik Lantai Motif Kayu', '75000', 80),
(6, 'Paku Besi 4 inch', '1500', 300),
(7, 'Triplek Meranti 12 mm', '180000', 36),
(8, 'Cat Kayu Interior Duco', '85000', 120),
(9, 'Pipa PVC 4 inch', '25000', 150),
(10, 'Lampu LED Hemat Energi', '35000', 87),
(13, 'Lem Rajawali 1Lusin', '100000', 4),
(14, 'Cat No Drop 1Kg', '23000', 12);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `idtransaksi` int(11) NOT NULL,
  `idpelanggan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`idtransaksi`, `idpelanggan`, `tanggal`, `total`) VALUES
(16, 1, '2024-06-23', '25000.00'),
(17, 1, '2024-06-23', '2400.00'),
(18, 1, '2024-06-23', '90000.00'),
(19, 1, '2024-06-23', '360000.00'),
(20, 1, '2024-06-23', '360000.00'),
(21, 2, '2024-06-23', '70000.00'),
(22, 6, '2024-06-23', '25000.00'),
(23, 5, '2024-06-22', '0.21'),
(24, 6, '2024-06-23', '0.25'),
(25, 5, '2024-06-23', '0.25'),
(26, 2, '2024-06-23', '0.18'),
(27, 2, '2024-06-23', '0.23'),
(28, 5, '2024-06-23', '0.11'),
(29, 1, '2024-06-23', '0.18'),
(30, 1, '2024-06-23', '0.35'),
(31, 1, '2024-06-23', '0.36'),
(32, 2, '2024-06-23', '210000.00'),
(34, 1, '2024-06-23', '70000.00'),
(35, 6, '2024-06-23', '210000.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`iddetail`),
  ADD KEY `idtransaksi` (`idtransaksi`),
  ADD KEY `idproduk` (`idproduk`),
  ADD KEY `fk_detail_transaksi_karyawan` (`idkaryawan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`idkaryawan`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`idpelanggan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`idtransaksi`),
  ADD KEY `idpelanggan` (`idpelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `iddetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `idkaryawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `idpelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `idtransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`idtransaksi`) REFERENCES `transaksi` (`idtransaksi`),
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`idproduk`),
  ADD CONSTRAINT `fk_detail_transaksi_karyawan` FOREIGN KEY (`idkaryawan`) REFERENCES `karyawan` (`idkaryawan`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`idpelanggan`) REFERENCES `pelanggan` (`idpelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
