-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2019 at 03:04 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `belajarcrud2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_akun`
--

CREATE TABLE `tb_akun` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `idauth` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_akun`
--

INSERT INTO `tb_akun` (`id`, `email`, `password`, `idauth`) VALUES
(1, 'budi@yahoo.com', 'budi123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_berita`
--

CREATE TABLE `tb_berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(30) NOT NULL,
  `tanggal` varchar(30) NOT NULL,
  `isi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_berita`
--

INSERT INTO `tb_berita` (`id`, `judul`, `tanggal`, `isi`) VALUES
(1, 'Wasapada Penipuan', '17-10-2018', 'Berita waspada penipuan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jem_pelajaran`
--

CREATE TABLE `tb_jem_pelajaran` (
  `id` int(11) NOT NULL,
  `ids` int(11) NOT NULL,
  `idp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jem_pelajaran`
--

INSERT INTO `tb_jem_pelajaran` (`id`, `ids`, `idp`) VALUES
(78, 4, 4),
(80, 4, 5),
(82, 4, 6),
(85, 11, 1),
(86, 15, 1),
(87, 15, 5),
(88, 23, 2),
(89, 23, 4),
(90, 24, 2),
(91, 24, 4),
(92, 24, 5),
(93, 25, 3),
(94, 25, 4),
(95, 26, 2),
(96, 26, 5),
(97, 27, 2),
(98, 27, 5),
(99, 28, 1),
(100, 28, 2),
(101, 12, 2),
(102, 12, 4),
(103, 11, 5),
(104, 30, 1),
(105, 31, 1),
(106, 28, 3),
(107, 28, 5),
(108, 29, 3),
(109, 10, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `nama` varchar(30) NOT NULL,
  `keterangan` text NOT NULL,
  `tingkat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id`, `create_at`, `nama`, `keterangan`, `tingkat_id`) VALUES
(1, '2018-08-21 00:00:00', '1 TKJ 1', 'Kelas teknik', 4),
(2, '2018-08-08 00:00:00', '2 TKJ 4', '', 5),
(3, '2018-08-17 00:00:00', '3 TKJ 4', 'Kelas Jaringan', 6),
(4, '2018-08-31 00:00:00', '1 TKJ 2', '', 4),
(5, '2018-08-30 00:00:00', '1 TKJ 3', '', 4),
(6, '2018-08-31 00:00:00', '2 TKJ 2', '', 5),
(7, '2018-08-31 00:00:00', '2 TKJ 3', '', 5),
(9, '2018-08-31 00:00:00', '3 TKJ 3', '', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tb_laporan`
--

CREATE TABLE `tb_laporan` (
  `id` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `biaya` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL,
  `tingkat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_laporan`
--

INSERT INTO `tb_laporan` (`id`, `create_at`, `biaya`, `keterangan`, `status`, `tingkat`) VALUES
(1, '2018-08-23 00:00:00', 50000, 'Laporan biaya', 1, 4),
(2, '2018-08-22 00:00:00', 35000, 'Tiga puluh lima ribu', 0, 4),
(3, '2018-08-12 00:00:00', 25000, 'Dua puluh lima ribu', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelajaran`
--

CREATE TABLE `tb_pelajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pelajaran`
--

INSERT INTO `tb_pelajaran` (`id`, `nama`, `keterangan`) VALUES
(1, 'IPA', ''),
(2, 'IPS', ''),
(3, 'Matematika', ''),
(4, 'Fisika', ''),
(5, 'Biologi', ''),
(6, 'PLKJ', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `kelas_id` int(11) NOT NULL,
  `tingkat_id` int(11) NOT NULL,
  `handphone` int(11) DEFAULT NULL,
  `alamat` text,
  `sertifikat` text,
  `fotoprofil` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`id`, `nama`, `email`, `kelas_id`, `tingkat_id`, `handphone`, `alamat`, `sertifikat`, `fotoprofil`) VALUES
(4, 'Bayu Aditya Rahmanian', 'bayu_rahmanian@yahoo.com', 5, 4, 87453534, 'Kota Jogja karta', '<p>nmbmb<strong>dhgfhf</strong>ghfghaaaaa 11111aaaaaterubah lompat12345aaa</p>\n\n<p>&nbsp;</p>\n\n<p>dfgdfgdgdfgaaa</p>\n', 'foto_profil_siswa_Bayu_Aditya_Rahmanian_247942_2018_10_28_11_11_22.jpg'),
(7, 'Risno', 'risno@yahoo.com', 6, 5, 87562655, 'Bintara 9', '<p>dfgdfgdfgdfgdfg</p>\n', 'foto_profil_siswa_Bayu_828228_2018_09_13_12_36_36.jpg'),
(8, 'Bambang', 'bambang@yahoo.com', 1, 4, 87562655, 'Jatinegara', '<p>dfgdfgdfgdfgdfg32423434</p>\n', 'foto_profil_siswa_Bambang_460777_2018_09_19_05_01_22.jpg'),
(10, 'Dina Yanti', 'dinayanti@yahoo.com', 4, 4, 87562655, 'Bintara 9', '<p>dfgdfgdfgdfgdfg</p>\n', 'foto_profil_siswa_Dina_Yanti_400592_2018_09_19_09_32_53.jpg'),
(11, 'Nirma AWANI AHMAD', 'nirmawan@yahoo.com', 3, 6, 221183647, 'sfsdfsfdsfsdfd 123123', '<p>sdfsdfsdf</p>\n\n<p>&nbsp;</p>\n\n<p>sdfdsfsdfaaa</p>\n', 'foto_profil_siswa_Nirma_AWANI_AHMAD_599197_2018_11_05_09_34_04.jpg'),
(12, 'Cayamiaa', 'rinami@yahoo.com', 6, 5, 2147483647, 'Bintara 3', '<p>Kejurusan Microsoft</p>\n', 'foto_profil_siswa_Cayamiaa_387617_2018_11_22_03_53_58.jpg'),
(23, 'Wisma', 'wisma@yahoo.com', 5, 4, 8566636, 'sdfdsf', '<p>sdfsdfsdf</p>\n', 'foto_profil_siswa_Wisma_580984_2018_10_29_04_43_21.jpg'),
(25, 'Amirul Wisnu', 'wisma@yahoo.com', 5, 4, 8566636, 'sdfdsf', '<p>sdfsdfsdf</p>\n', 'foto_profil_siswa_Amirul_Wisnu_580476_2018_10_29_04_47_10.jpg'),
(26, 'Rahma', 'rahma@yahoo.com', 5, 4, 896636666, 'Bintara 12', '<p>areeeeeeeeeeeeeeee</p>\n', 'foto_profil_siswa_Rahma_981907_2018_10_30_04_00_54.jpg'),
(27, 'Rahmania', 'rahma@yahoo.com', 4, 4, 896636666, 'Bintara 12', '<p>areeeeeeeeeeeeeeee</p>\n', 'foto_profil_siswa_Rahmania_989059_2018_10_30_04_01_39.jpg'),
(28, 'Parto Suraya', 'parto@yahoo.com', 6, 5, 85669926, 'Kalimantan', '<p>sdfsfsdfsdfsdfeeeeeeeeeereeeesaaaa</p>\n', 'foto_profil_siswa_Parto_Suraya_962900_2018_11_08_01_53_09.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tingkat`
--

CREATE TABLE `tb_tingkat` (
  `id` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `nama` varchar(30) NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_tingkat`
--

INSERT INTO `tb_tingkat` (`id`, `create_at`, `nama`, `keterangan`, `status`) VALUES
(4, '2018-08-23 00:00:00', '1', 'Tingkat 1', 1),
(5, '2018-08-23 00:00:00', '2', 'Tingkat 2', 1),
(6, '2018-08-23 00:00:00', '3', 'Tingkat 3', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_akun`
--
ALTER TABLE `tb_akun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_berita`
--
ALTER TABLE `tb_berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_jem_pelajaran`
--
ALTER TABLE `tb_jem_pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pelajaran`
--
ALTER TABLE `tb_pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_tingkat`
--
ALTER TABLE `tb_tingkat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_akun`
--
ALTER TABLE `tb_akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_berita`
--
ALTER TABLE `tb_berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_jem_pelajaran`
--
ALTER TABLE `tb_jem_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_pelajaran`
--
ALTER TABLE `tb_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tb_tingkat`
--
ALTER TABLE `tb_tingkat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
