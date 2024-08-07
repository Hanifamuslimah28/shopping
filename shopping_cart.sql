-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 12, 2024 at 11:24 PM
-- Server version: 10.2.3-MariaDB-log
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping_cart`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `kode_produk` varchar(50) DEFAULT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `kode_produk`, `nama_produk`, `jumlah`, `harga`, `sub_total`) VALUES
(1, 1, 'P01', 'Bubur Ayam', 1, 12000.00, 12000.00),
(2, 1, 'P02', 'Indomie Intel Goreng', 1, 10000.00, 10000.00),
(3, 2, 'P01', 'Bubur Ayam', 1, 12000.00, 12000.00),
(4, 3, 'P01', 'Bubur Ayam', 5, 12000.00, 60000.00),
(5, 4, 'P01', 'Bubur Ayam', 1, 12000.00, 12000.00),
(6, 5, 'P01', 'Bubur Ayam', 1, 12000.00, 12000.00);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `kode_produk` char(3) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `keterangan` text NOT NULL,
  `gambar` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama`, `stok`, `harga`, `keterangan`, `gambar`) VALUES
(1, 'P01', 'Bubur Ayam', 10, 12000, 'racikan bubur khas Kuningan + slederi + bawang goreng + ayam suwir, kuah kaldu (dipisah) + kerupuk (dipisah) + sambal (dipisah)', 'bubur_ayam.jpg'),
(2, 'P02', 'Indomie Intel Goreng', 10, 10000, 'Indomie Telor ,sayuran sawi segar + bawang goreng + saos terpisah', 'indomi_goreng.jpg'),
(3, 'P03', 'Bubur Ketan Item', 10, 11000, 'tambahan santan akan dipisah', 'ketan_item.jpg'),
(6, 'B02', 'Cackes', 12, 500000, 'qwewerwrr', 'PERSEBO FC.png');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tanggal_transaksi` datetime DEFAULT current_timestamp(),
  `total_bayar` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tanggal_transaksi`, `total_bayar`, `status`, `user_id`) VALUES
(1, '2024-05-13 03:50:52', 22000.00, 'Diproses', NULL),
(2, '2024-05-13 04:18:57', 12000.00, 'Diproses', NULL),
(3, '2024-05-13 04:54:43', 60000.00, 'Diproses', 1),
(4, '2024-05-13 05:21:29', 12000.00, 'Diproses', 1),
(5, '2024-05-13 05:22:14', 12000.00, 'Diproses', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `level` enum('admin','users') NOT NULL DEFAULT 'users',
  `tanggal_daftar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `alamat`, `telepon`, `level`, `tanggal_daftar`) VALUES
(1, 'aji', 'ani@gmail.com', '$2y$10$diz2j7T/f7ya/Z.sFdg1vuIt1KNYYox..dxO0epWKaatz3g2pswpC', 'jl', '0872487124', 'users', '2024-05-13 04:00:48'),
(2, 'aji', 'pororoaja@gmail.com', '$2y$10$HaFWeByPYWdzz9icxgiEm.ZFo8furztA7mYTsq2QJgZUFayJiNU1.', 'jl aji', 'aji', 'admin', '2024-05-13 05:17:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `kode_produk` (`kode_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
