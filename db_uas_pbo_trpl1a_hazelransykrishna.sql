-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 26, 2026 at 12:57 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uas_pbo_trpl1a_hazelransykrishna`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mahasiswa`
--

CREATE TABLE `tabel_mahasiswa` (
  `id_mahasiswa` int NOT NULL,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `semester` int NOT NULL,
  `tarif_ukt_nominal` decimal(15,2) NOT NULL,
  `jenis_pembayaran` enum('Mandiri','Bidik Misi','Prestasi') NOT NULL,
  `golongan_ukt` varchar(10) DEFAULT NULL,
  `nama_wali` varchar(100) DEFAULT NULL,
  `nomor_kip_kuliah` varchar(50) DEFAULT NULL,
  `dana_saku_subsidi` decimal(15,2) DEFAULT NULL,
  `nama_instansi_beasiswa` varchar(100) DEFAULT NULL,
  `minimal_ukt_bersyarat` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_mahasiswa`
--

INSERT INTO `tabel_mahasiswa` (`id_mahasiswa`, `nama_mahasiswa`, `nim`, `semester`, `tarif_ukt_nominal`, `jenis_pembayaran`, `golongan_ukt`, `nama_wali`, `nomor_kip_kuliah`, `dana_saku_subsidi`, `nama_instansi_beasiswa`, `minimal_ukt_bersyarat`) VALUES
(1, 'Andi Pratama', '220101001', 5, '12000000.00', 'Mandiri', 'A', 'Budi Pratama', NULL, NULL, NULL, NULL),
(2, 'Siti Rahayu', '220101002', 3, '9500000.00', 'Mandiri', 'B', 'Ahmad Rahayu', NULL, NULL, NULL, NULL),
(3, 'Budi Santoso', '220101003', 7, '14000000.00', 'Mandiri', 'A', 'Hari Santoso', NULL, NULL, NULL, NULL),
(4, 'Dewi Lestari', '220101004', 1, '8500000.00', 'Mandiri', 'C', 'Slamet Lestari', NULL, NULL, NULL, NULL),
(5, 'Rizky Fadillah', '220101005', 5, '11000000.00', 'Mandiri', 'B', 'Fajar Fadillah', NULL, NULL, NULL, NULL),
(6, 'Maya Sari', '220101006', 3, '9000000.00', 'Mandiri', 'B', 'Dedi Sari', NULL, NULL, NULL, NULL),
(7, 'Agus Wijaya', '220101007', 5, '13000000.00', 'Mandiri', 'A', 'Hendra Wijaya', NULL, NULL, NULL, NULL),
(8, 'Nurul Hidayati', '220101008', 5, '2400000.00', 'Bidik Misi', NULL, 'Kartini Hidayati', 'KIP2022001', '1500000.00', NULL, NULL),
(9, 'Ahmad Fauzi', '220101009', 3, '2400000.00', 'Bidik Misi', NULL, 'Fatimah Fauzi', 'KIP2022002', '1500000.00', NULL, NULL),
(10, 'Rina Puspita', '220101010', 7, '2400000.00', 'Bidik Misi', NULL, 'Slamet Puspita', 'KIP2022003', '1500000.00', NULL, NULL),
(11, 'Hendra Gunawan', '220101011', 1, '2400000.00', 'Bidik Misi', NULL, 'Sri Gunawan', 'KIP2022004', '1500000.00', NULL, NULL),
(12, 'Putri Maharani', '220101012', 5, '2400000.00', 'Bidik Misi', NULL, 'Herman Maharani', 'KIP2022005', '1500000.00', NULL, NULL),
(13, 'Doni Saputra', '220101013', 3, '2400000.00', 'Bidik Misi', NULL, 'Siti Saputra', 'KIP2022006', '1500000.00', NULL, NULL),
(14, 'Lisa Anggraini', '220101014', 5, '2400000.00', 'Bidik Misi', NULL, 'Bambang Anggraini', 'KIP2022007', '1500000.00', NULL, NULL),
(15, 'Firda Aulia', '220101015', 5, '5000000.00', 'Prestasi', NULL, NULL, NULL, NULL, 'Puslapdik Kemdikbud', '2400000.00'),
(16, 'Gilang Ramadhan', '220101016', 3, '4500000.00', 'Prestasi', NULL, NULL, NULL, NULL, 'Bank Indonesia', '2400000.00'),
(17, 'Nadia Zahra', '220101017', 7, '5500000.00', 'Prestasi', NULL, NULL, NULL, NULL, 'Djarum Foundation', '2400000.00'),
(18, 'Eko Prasetyo', '220101018', 1, '4000000.00', 'Prestasi', NULL, NULL, NULL, NULL, 'Puslapdik Kemdikbud', '2400000.00'),
(19, 'Rani Fitriani', '220101019', 5, '5000000.00', 'Prestasi', NULL, NULL, NULL, NULL, 'Bank Indonesia', '2400000.00'),
(20, 'Indra Maulana', '220101020', 3, '4500000.00', 'Prestasi', NULL, NULL, NULL, NULL, 'Djarum Foundation', '2400000.00'),
(21, 'Winda Pertiwi', '220101021', 5, '5500000.00', 'Prestasi', NULL, NULL, NULL, NULL, 'Puslapdik Kemdikbud', '2400000.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_mahasiswa`
--
ALTER TABLE `tabel_mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_mahasiswa`
--
ALTER TABLE `tabel_mahasiswa`
  MODIFY `id_mahasiswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
