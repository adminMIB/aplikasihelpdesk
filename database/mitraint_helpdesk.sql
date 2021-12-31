-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2020 at 03:11 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mitraint_helpdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `bagian_departemen`
--

CREATE TABLE `bagian_departemen` (
  `id_bagian_dept` int(11) NOT NULL,
  `nama_bagian_dept` varchar(30) NOT NULL,
  `id_dept` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bagian_departemen`
--

INSERT INTO `bagian_departemen` (`id_bagian_dept`, `nama_bagian_dept`, `id_dept`) VALUES
(5, 'SOFTWARE', 3),
(8, 'CABANG SEMARANG', 3);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` bigint(20) UNSIGNED NOT NULL,
  `customer_code` varchar(255) NOT NULL,
  `customer_reff` int(11) NOT NULL,
  `telepon` varchar(16) NOT NULL,
  `project_id` int(11) NOT NULL,
  `sla` varchar(15) NOT NULL,
  `teknisi_id` varchar(11) NOT NULL,
  `token` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `customer_code`, `customer_reff`, `telepon`, `project_id`, `sla`, `teknisi_id`, `token`) VALUES
(13, 'customer_010909', 9, '321', 9, '1 Hari', 'T0005', 98),
(14, 'customer_0170808', 8, '0411859 171', 8, '1 Hari', 'T0007', 100),
(15, 'customer_01507011', 7, '0', 11, '1 Hari', 'T0003', 99),
(16, 'customer_016011012', 11, '0778462047', 12, '2 Hari', 'T0008', 8),
(19, 'customer_017014015', 14, '021 181818', 15, '1 hari', 'T0011', 9);

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id_dept` int(11) NOT NULL,
  `nama_dept` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id_dept`, `nama_dept`) VALUES
(3, 'IT'),
(4, 'PPIC');

-- --------------------------------------------------------

--
-- Table structure for table `history_feedback`
--

CREATE TABLE `history_feedback` (
  `id_feedback` int(11) NOT NULL,
  `id_ticket` varchar(255) NOT NULL,
  `feedback` int(11) NOT NULL,
  `reported` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history_feedback`
--

INSERT INTO `history_feedback` (`id_feedback`, `id_ticket`, `feedback`, `reported`) VALUES
(28, 'T200702105648-01507011', 1, 'customer_01507011'),
(29, 'T200702113358-016011012', 1, 'customer_016011012'),
(30, 'T200702120025-016011012', 1, 'customer_016011012'),
(31, 'T200716115329-017012013', 1, 'customer_017012013'),
(32, 'T200716132816-018013014', 1, 'customer_018013014'),
(33, 'T200717060226-019014015', 1, 'customer_017014015');

-- --------------------------------------------------------

--
-- Table structure for table `informasi`
--

CREATE TABLE `informasi` (
  `id_informasi` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `subject` varchar(35) NOT NULL,
  `pesan` text NOT NULL,
  `status` decimal(2,0) NOT NULL,
  `id_user` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `informasi`
--

INSERT INTO `informasi` (`id_informasi`, `tanggal`, `subject`, `pesan`, `status`, `id_user`) VALUES
(1, '2020-05-11 01:48:16', 'WAJIB MENGISI FEEDBACK', 'PENGISIAN FEEDBACK PENTING GUNA MEMBANTU KAMI DALAM MEMBERIKAN PENILAIAN TERHADAP KINERJA TEKNISI, TERKAIT DENGAN PELAYANAN DAN SURVEY KEPUASAN USER', '1', 'K0001'),
(2, '2020-05-11 01:45:09', 'CUSTOMER FAQ', 'LOREM IPSUM DOLOR SIT AMET, SCAEVOLA PRAESENT TE PRO, NO MODO DIAM OPORTEAT QUI. NO EIUS PERTINACIA ULLAMCORPER VIM, SIMUL DOLORE DELENIT VEL NO, AN UNUM IRIURE HIS. VIX CU LOREM PAULO. CUM EUISMOD HONESTATIS ID. PRO ID LEGERE ANCILLAE, CU ILLUM PAULO MUCIUS NAM, VIX ERREM SCRIBENTUR AT.', '1', 'K0001');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'KEPALA BAGIAN'),
(2, 'KEPALA DEPARTEMEN'),
(3, 'KEPALA REGU'),
(4, 'TEKNISI');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `nik` varchar(5) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `alamat` text NOT NULL,
  `jk` varchar(10) NOT NULL,
  `id_bagian_dept` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`nik`, `nama`, `alamat`, `jk`, `id_bagian_dept`, `id_jabatan`) VALUES
('K0001', 'NURUL AZHAR', 'TANGERANG', 'LAKI-LAKI', 5, 2),
('K0002', 'DESI', 'JAKARTA', 'PEREMPUAN', 7, 4),
('K0003', 'NINO', 'BEKASI', 'LAKI-LAKI', 8, 4),
('K0004', 'ZEIN', 'BOJONG', 'LAKI-LAKI', 6, 4),
('K0005', 'RIO', 'TANGERANG', 'LAKI-LAKI', 7, 4),
('K0006', 'RINDA', 'JAKARTA', 'PEREMPUAN', 5, 4),
('K0007', 'RONALD', 'JAKARTA', 'LAKI-LAKI', 5, 4),
('K0009', 'ABID', 'CILEDUG', 'LAKI-LAKI', 5, 4),
('K0010', 'BILAL', 'BOJONEGORO', 'LAKI-LAKI', 6, 4),
('K0011', 'SANDY', 'BEKASI', 'LAKI-LAKI', 5, 4),
('K0012', 'ADI', 'JAKARTA', 'LAKI-LAKI', 8, 2),
('K0013', 'PIPI', 'JAKARTA', 'LAKI-LAKI', 8, 2),
('K0014', 'RINA', 'JAKARTA', 'PEREMPUAN', 8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(7, 'BANK DKI'),
(8, 'BANK BSSB'),
(9, 'BANK MANTAP'),
(10, 'LPDB KEMENKOP'),
(11, 'BP BATAM'),
(12, 'BANK ABC'),
(13, 'POSCO IT'),
(14, 'BANK ABCD');

-- --------------------------------------------------------

--
-- Table structure for table `kondisi`
--

CREATE TABLE `kondisi` (
  `id_kondisi` int(11) NOT NULL,
  `nama_kondisi` varchar(30) NOT NULL,
  `waktu_respon` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kondisi`
--

INSERT INTO `kondisi` (`id_kondisi`, `nama_kondisi`, `waktu_respon`) VALUES
(1, 'LEVEL 2 ( MAJOR )', '2'),
(2, 'LEVEL 1 ( MINOR )', '2'),
(3, 'LEVEL 3 ( CRITICAL )', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kategori`
--

CREATE TABLE `sub_kategori` (
  `id_sub_kategori` int(11) NOT NULL,
  `nama_sub_kategori` varchar(35) NOT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_kategori`
--

INSERT INTO `sub_kategori` (`id_sub_kategori`, `nama_sub_kategori`, `id_kategori`) VALUES
(8, 'VALIDATOR XBRL', 8),
(9, 'APLIKASI PELAPORAN', 9),
(11, 'APLIKASI REKONJATOL', 7),
(12, 'MAINTENANCE ORACLE WEBLOGIC', 11),
(13, 'APLIKASI PEMBAYARAN', 12),
(14, 'INSTALASI DATABASE', 13),
(15, 'APLIKASI PEMBAYARAN', 14);

-- --------------------------------------------------------

--
-- Table structure for table `teknisi`
--

CREATE TABLE `teknisi` (
  `id_teknisi` varchar(5) NOT NULL,
  `nik` varchar(5) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `point` decimal(2,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teknisi`
--

INSERT INTO `teknisi` (`id_teknisi`, `nik`, `id_kategori`, `status`, `point`) VALUES
('T0004', 'K0003', 8, '', '0'),
('T0005', 'K0003', 9, '', '1'),
('T0006', 'K0003', 10, '', '0'),
('T0007', 'K0011', 8, '', '0'),
('T0008', 'K0007', 11, '', '2'),
('T0009', 'K0003', 12, '', '1'),
('T0010', 'K0003', 13, '', '1'),
('T0011', 'K0003', 14, '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `tanggal_proses` datetime NOT NULL,
  `tanggal_solved` datetime NOT NULL,
  `reported` varchar(255) NOT NULL,
  `id_sub_kategori` int(11) NOT NULL,
  `problem_summary` varchar(50) NOT NULL,
  `user_file` text NOT NULL,
  `problem_detail` text NOT NULL,
  `id_teknisi` varchar(5) NOT NULL,
  `status` int(11) NOT NULL,
  `progress` decimal(10,0) NOT NULL,
  `action` varchar(15) NOT NULL,
  `batas_tanggal_notif` datetime NOT NULL,
  `email_notif_attempt` int(11) NOT NULL,
  `is_act_by_teknisi` tinyint(1) NOT NULL DEFAULT '0',
  `is_read_by_admin` tinyint(1) NOT NULL,
  `is_read_by_teknisi` tinyint(1) NOT NULL,
  `jenis_urgensi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id_ticket`, `tanggal`, `tanggal_proses`, `tanggal_solved`, `reported`, `id_sub_kategori`, `problem_summary`, `user_file`, `problem_detail`, `id_teknisi`, `status`, `progress`, `action`, `batas_tanggal_notif`, `email_notif_attempt`, `is_act_by_teknisi`, `is_read_by_admin`, `is_read_by_teknisi`, `jenis_urgensi`) VALUES
('T200702105648-01507011', '2020-06-24 08:56:48', '2020-06-24 10:30:20', '2020-06-24 11:07:46', 'CUSTOMER_01507011', 11, 'Transaksi rekonjatol Doble Proses', '', 'Case Double Transaksi\r\nfile generate nyangkut dan tidak pindah', 'T0003', 6, '100', 'REMOTE', '2020-06-27 15:56:48', 1, 0, 1, 1, 'CRITICAL'),
('T200702113358-016011012', '2020-04-06 19:33:58', '2020-04-07 09:46:58', '2020-04-07 15:47:49', 'CUSTOMER_016011012', 12, 'Server HRM 3 Running tp not OK', 'hrm.jpg', 'Pada hr_server3 meskipun state pada server adalah RUNNING tetapi pada status health kosong tidak terdapat tanda OK.\r\n\r\nmohon untuk dibantu melakukan pengecekan\r\nterima kasih', 'T0008', 6, '80', 'REMOTE', '2020-04-08 19:33:58', 1, 0, 1, 1, 'MINOR'),
('T200702120025-016011012', '2020-04-13 12:00:25', '2020-04-13 13:15:25', '2020-07-14 23:09:32', 'CUSTOMER_016011012', 12, 'Server Land 3 Down', 'land_server_3.jpg', 'Server land 3 down di weblogic statunya failed\r\nmohon untuk dicek\r\nterima kasih', 'T0008', 6, '100', 'REMOTE', '2020-04-15 12:00:25', 1, 0, 1, 1, 'MAJOR'),
('T200711162637-0130909', '2020-07-11 16:26:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CUSTOMER_010909', 9, 'tes lagi 11', 'db2.png', 'tesre', 'T0005', 4, '0', '', '2020-07-11 21:26:37', 0, 0, 0, 0, ''),
('T200716115329-017012013', '2020-07-16 11:53:28', '0000-00-00 00:00:00', '2020-07-16 11:56:11', 'CUSTOMER_017012013', 13, 'menu transaksi error', 'db3.png', 'ada double transaksi', 'T0009', 6, '100', 'REMOTE', '2020-07-16 16:53:28', 0, 1, 0, 1, 'MINOR'),
('T200716131655-018013014', '2020-07-16 13:16:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CUSTOMER_018013014', 14, 'error', 'db4.png', 'eror di validasi', 'T0010', 4, '0', '', '2020-07-16 18:16:55', 0, 0, 0, 0, ''),
('T200716132816-018013014', '2020-07-16 13:28:16', '0000-00-00 00:00:00', '2020-07-16 13:32:58', 'CUSTOMER_018013014', 14, 'error validasi', 'db5.png', 'eror validasi lagi', 'T0010', 6, '100', 'REMOTE', '2020-07-16 18:28:16', 0, 1, 0, 1, 'MINOR'),
('T200717060226-019014015', '2020-07-17 06:02:26', '0000-00-00 00:00:00', '2020-07-17 06:05:03', 'CUSTOMER_017014015', 15, 'error Transaksi', 'db6.png', 'doble transaksi pembayaran', 'T0011', 6, '100', 'REMOTE', '2020-07-17 11:02:26', 0, 1, 0, 1, 'MINOR');

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `id_tracking` int(11) NOT NULL,
  `id_ticket` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `action_teknisi` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tracking`
--

INSERT INTO `tracking` (`id_tracking`, `id_ticket`, `tanggal`, `status`, `deskripsi`, `id_user`, `action_teknisi`) VALUES
(1, 'T201612020001', '2016-12-02 16:59:18', 'Created Ticket', '', 'K0001', ''),
(2, 'T201612020001', '2016-12-02 16:59:34', 'Ticket disetujui', '', 'K0001', ''),
(3, 'T201612020001', '2016-12-02 16:59:55', 'Pemilihan Teknisi', 'Ticket Anda sudah di berikan kepada Teknisi', 'K0001', ''),
(4, 'T201612020001', '2016-12-02 17:00:39', 'Diproses oleh teknisi', '', 'K0001', ''),
(5, 'T201612020001', '2016-12-02 17:01:32', 'Up Progress To 100 %', 'SELESAI SILAHKAN AMBIL', 'K0001', ''),
(6, 'T201612020002', '2016-12-02 17:05:29', 'Created Ticket', '', 'K0001', ''),
(7, 'T201612020002', '2016-12-02 17:05:41', 'Ticket tidak disetujui', '', 'K0001', ''),
(8, 'T201612020002', '2016-12-02 17:05:47', 'Ticket dikembalikan ke posisi belum di setujui', '', 'K0001', ''),
(9, 'T201612020002', '2016-12-02 17:05:48', 'Ticket disetujui', '', 'K0001', ''),
(10, 'T201612020002', '2016-12-02 17:06:08', 'Pemilihan Teknisi', 'Ticket Anda sudah di berikan kepada Teknisi', 'K0001', ''),
(11, 'T201612020002', '2016-12-02 17:06:35', 'Pending oleh teknisi', '', 'K0001', ''),
(12, 'T201612020002', '2016-12-02 17:09:06', 'Diproses oleh teknisi', '', 'K0001', ''),
(13, 'T201612020002', '2016-12-02 17:09:32', 'Up Progress To 90 %', '', 'K0001', ''),
(14, 'T201612020002', '2016-12-04 06:32:39', 'Up Progress To 100 %', '', 'K0001', ''),
(15, 'T201612040003', '2016-12-04 07:06:47', 'Created Ticket', '', 'K0001', ''),
(16, 'T201612040003', '2016-12-04 08:19:03', 'Ticket disetujui', '', 'K0001', ''),
(17, 'T201612040003', '2016-12-04 08:19:17', 'Pemilihan Teknisi', 'Ticket Anda sudah di berikan kepada Teknisi', 'K0001', ''),
(18, 'T201612040003', '2016-12-04 08:20:29', 'Diproses oleh teknisi', '', 'K0001', ''),
(19, 'T201612040003', '2016-12-04 08:21:14', 'Up Progress To 10 %', '', 'K0001', ''),
(20, 'T201612040003', '2016-12-04 08:22:11', 'Up Progress To 100 %', '', 'K0001', ''),
(21, 'T201612040004', '2016-12-04 08:24:44', 'Created Ticket', '', 'K0001', ''),
(22, 'T201612040004', '2016-12-04 08:25:04', 'Ticket disetujui', '', 'K0001', ''),
(23, 'T201612040004', '2016-12-04 08:25:35', 'Pemilihan Teknisi', 'Ticket Anda sudah di berikan kepada Teknisi', 'K0001', ''),
(24, 'T201612040004', '2016-12-04 08:25:57', 'Diproses oleh teknisi', '', 'K0001', ''),
(25, 'T201612040004', '2016-12-04 08:43:02', 'Up Progress To 10 %', 'MENUNGGU KOMPONEN MAINBOARD', 'K0001', ''),
(26, 'T201612040005', '2016-12-04 09:43:02', 'Created Ticket', '', 'K0001', ''),
(27, 'T201612040005', '2016-12-04 09:44:22', 'Ticket tidak disetujui', '', 'K0001', ''),
(28, 'T201612040005', '2016-12-04 09:44:23', 'Ticket tidak disetujui', '', 'K0001', ''),
(29, 'T201612040005', '2016-12-04 09:44:35', 'Ticket dikembalikan ke posisi belum di setujui', '', 'K0001', ''),
(30, 'T201612040005', '2016-12-04 09:44:37', 'Ticket disetujui', '', 'K0001', ''),
(31, 'T201612040005', '2016-12-04 09:45:31', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(32, 'T201612040005', '2016-12-04 09:45:58', 'Pending oleh teknisi', '', 'K0001', ''),
(33, 'T201612040005', '2016-12-04 09:46:50', 'Diproses oleh teknisi', '', 'K0001', ''),
(34, 'T201612040004', '2016-12-04 09:47:27', 'Up Progress To 100 %', '', 'K0001', ''),
(35, 'T201612180006', '2016-12-18 07:00:49', 'Created Ticket', '', 'K0002', ''),
(36, 'T201612180006', '2016-12-18 07:01:49', 'Ticket disetujui', '', 'K0001', ''),
(37, 'T201612180006', '2016-12-18 07:23:02', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(38, 'T201612180006', '2016-12-18 07:25:21', 'Diproses oleh teknisi', '', 'K0003', ''),
(39, 'T201612180006', '2016-12-18 07:25:48', 'Up Progress To 10 %', '', 'K0003', ''),
(40, 'T201612180006', '2016-12-18 07:25:58', 'Up Progress To 70 %', '', 'K0003', ''),
(41, 'T201612180006', '2016-12-18 07:26:11', 'Up Progress To 100 %', 'SELESAI', 'K0003', ''),
(42, 'T201612180007', '2016-12-18 08:09:25', 'Created Ticket', '', 'K0002', ''),
(43, 'T201612180007', '2016-12-18 08:11:12', 'Ticket disetujui', '', 'K0005', ''),
(44, 'T201612180007', '2016-12-18 08:16:57', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(45, 'T201612180007', '2016-12-18 08:17:45', 'Diproses oleh teknisi', '', 'K0003', ''),
(46, 'T201612180007', '2016-12-18 08:18:21', 'Up Progress To 70 %', 'TINGGAL TUNGGU KOMPONEN', 'K0003', ''),
(47, 'T201612180007', '2016-12-18 08:20:37', 'Up Progress To 100 %', 'SOLVED TINGGAL AMBIL', 'K0003', ''),
(48, 'T201612190008', '2016-12-19 13:02:25', 'Created Ticket', '', 'K0001', ''),
(49, 'T201612190008', '2016-12-19 13:02:36', 'Ticket disetujui', '', 'K0001', ''),
(50, 'T201612190008', '2016-12-19 13:02:53', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(51, 'T201612190008', '2016-12-19 13:03:37', 'Diproses oleh teknisi', '', 'K0003', ''),
(52, 'T201612190008', '2016-12-19 13:03:54', 'Up Progress To 100 %', 'SELESAI', 'K0003', ''),
(53, 'T201612190009', '2016-12-19 14:09:09', 'Created Ticket', '', 'K0001', ''),
(54, 'T201612190009', '2016-12-19 14:11:49', 'Ticket disetujui', '', 'K0001', ''),
(55, 'T201612190010', '2016-12-19 14:35:33', 'Created Ticket', '', 'K0001', ''),
(56, 'T201612190010', '2016-12-19 14:35:38', 'Ticket disetujui', '', 'K0001', ''),
(57, 'T201612190010', '2016-12-19 14:47:17', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(58, 'T201612190010', '2016-12-19 15:09:27', 'Diproses oleh teknisi', '', 'K0003', ''),
(59, 'T201612190010', '2016-12-19 15:09:44', 'Up Progress To 50 %', 'TGGU KOMP', 'K0003', ''),
(60, 'T201612190010', '2016-12-19 15:09:59', 'Up Progress To 100 %', 'OKJE', 'K0003', ''),
(61, 'T201612280011', '2016-12-28 15:15:32', 'Created Ticket', '', 'K0001', ''),
(62, 'T201612280011', '2016-12-28 15:15:54', 'Ticket disetujui', '', 'K0001', ''),
(63, 'T201612280011', '2016-12-28 15:16:46', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(64, 'T202002030012', '2020-02-03 04:06:03', 'Created Ticket', '', 'K0002', ''),
(65, 'T202002030012', '2020-02-03 04:08:42', 'Ticket disetujui', '', 'K0005', ''),
(66, 'T202002030013', '0000-00-00 00:00:00', 'Created Ticket', '', 'K0002', ''),
(67, 'T201612280011', '2020-02-03 04:26:14', 'Diproses oleh teknisi', '', 'K0003', ''),
(68, 'T201612280011', '2020-02-03 04:26:31', 'Up Progress To 100 %', 'TES', 'K0003', ''),
(69, 'T202002030012', '2020-02-03 04:27:12', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(70, 'T202002030013', '2020-02-03 04:27:58', 'Ticket disetujui', '', 'K0005', ''),
(71, 'T202002030014', '0000-00-00 00:00:00', 'Created Ticket', '', 'K0002', ''),
(72, 'T202002030014', '2020-02-03 04:54:45', 'Ticket disetujui', '', 'K0001', ''),
(73, 'T202002030014', '2020-02-03 04:55:00', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(74, 'T202002030014', '2020-02-03 04:55:18', 'Diproses oleh teknisi', '', 'K0003', ''),
(75, 'T202002030012', '2020-02-03 04:55:21', 'Diproses oleh teknisi', '', 'K0003', ''),
(76, 'T202002030014', '2020-02-03 04:55:33', 'Up Progress To 100 %', 'TES', 'K0003', ''),
(77, 'T202002070015', '0000-00-00 00:00:00', 'Created Ticket', '', 'K0002', ''),
(78, 'T202002070015', '2020-02-07 09:51:36', 'Ticket disetujui', '', 'K0001', ''),
(79, 'T202002070016', '0000-00-00 00:00:00', 'Created Ticket', '', 'K0002', ''),
(80, 'T202002070016', '2020-02-07 10:01:21', 'Ticket disetujui', '', 'K0001', ''),
(81, 'T202002070016', '2020-02-07 10:01:40', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(82, 'T202002070016', '2020-02-07 10:02:10', 'Diproses oleh teknisi', '', 'K0003', ''),
(83, 'T202002070016', '2020-02-07 10:02:30', 'Up Progress To 100 %', 'SUDAH SOLVED', 'K0003', ''),
(84, 'T202003040017', '0000-00-00 00:00:00', 'Created Ticket', '', 'K0002', ''),
(85, 'T202003040018', '2020-03-04 03:20:36', 'Created Ticket', '', 'K0002', ''),
(86, 'T202003040019', '2020-03-04 03:23:54', 'Created Ticket', '', 'K0002', ''),
(87, 'T202003040020', '2020-03-04 03:24:55', 'Created Ticket', '', 'K0001', ''),
(88, 'T202003040021', '2020-03-04 03:28:28', 'Created Ticket', '', 'K0007', ''),
(89, 'T202003040022', '2020-03-04 03:45:38', 'Created Ticket', '', 'K0002', ''),
(90, 'T202003040022', '2020-03-04 03:48:14', 'Ticket disetujui', '', 'K0005', ''),
(91, 'T202003040022', '2020-03-04 03:48:35', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(92, 'T202003040022', '2020-03-04 03:49:18', 'Diproses oleh teknisi', '', 'K0003', ''),
(93, 'T202003040022', '2020-03-04 03:49:43', 'Up Progress To 100 %', 'LOG HAPUS DI MENU A', 'K0003', ''),
(94, 'T202003040023', '2020-03-04 08:00:53', 'Created Ticket', '', 'K0002', ''),
(95, 'T202003040023', '2020-03-04 08:02:21', 'Ticket disetujui', '', 'K0005', ''),
(96, 'T202003040023', '2020-03-04 08:05:34', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(97, 'T202003040023', '2020-03-04 08:06:12', 'Diproses oleh teknisi', '', 'K0003', ''),
(98, 'T202003040023', '2020-03-04 08:08:50', 'Up Progress To 100 %', 'SOLVED', 'K0003', ''),
(99, 'T202003070024', '2020-03-07 10:46:51', 'Created Ticket', '', 'K0002', ''),
(100, 'T202003070024', '2020-03-07 10:47:40', 'Ticket disetujui', '', 'K0005', ''),
(101, 'T202003070024', '2020-03-07 10:58:41', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(102, 'T202003070024', '2020-03-07 11:03:59', 'Diproses oleh teknisi', '', 'K0003', ''),
(103, 'T202003070024', '2020-03-07 11:08:45', 'Up Progress To 100 %', 'SOLVED', 'K0003', ''),
(104, 'T202003070025', '2020-03-07 15:48:39', 'Created Ticket', '', 'K0002', ''),
(105, 'T202003070025', '2020-03-07 15:48:58', 'Ticket disetujui', '', 'K0005', ''),
(106, 'T202003070025', '2020-03-07 15:49:59', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(107, 'T202003070025', '2020-03-07 15:50:13', 'Diproses oleh teknisi', '', 'K0003', ''),
(108, 'T202003100026', '2020-03-10 14:58:51', 'Created Ticket', '', 'K0002', ''),
(109, 'T202003070025', '2020-03-11 02:27:49', 'Up Progress To 20 %', 'F', 'K0003', ''),
(110, 'T202003070025', '2020-03-11 02:27:55', 'Up Progress To 40 %', 'F', 'K0003', ''),
(111, 'T202003160027', '2020-03-16 03:24:50', 'Created Ticket', '', '', ''),
(112, 'T202003160028', '2020-03-16 03:27:51', 'Created Ticket', '', 'CUSTO', ''),
(113, 'T202003160029', '2020-03-16 03:28:28', 'Created Ticket', '', 'CUSTOMER_88', ''),
(114, 'T202003160030', '2020-03-16 03:28:52', 'Created Ticket', '', 'CUSTOMER_88', ''),
(115, 'T202003160030', '2020-03-16 03:50:00', 'Up Progress To 10 %', '', 'K0003', ''),
(116, 'T202003160030', '2020-03-16 03:51:38', 'Up Progress To 20 %', '', 'K0003', ''),
(117, 'T202003160031', '2020-03-16 04:02:24', 'Created Ticket', '', 'CUSTOMER_88', ''),
(118, 'T202003160032', '2020-03-16 04:02:46', 'Created Ticket', '', 'CUSTOMER_88', ''),
(119, 'T202003160033', '2020-03-16 04:03:08', 'Created Ticket', '', 'CUSTOMER_88', ''),
(120, 'T202003160034', '2020-03-16 04:04:53', 'Created Ticket', '', 'CUSTOMER_88', ''),
(121, 'T202003160035', '2020-03-16 04:05:09', 'Created Ticket', '', 'CUSTOMER_88', ''),
(122, 'T202003160036', '2020-03-16 04:05:13', 'Created Ticket', '', 'CUSTOMER_88', ''),
(123, 'T202003160037', '2020-03-16 04:05:19', 'Created Ticket', '', 'CUSTOMER_88', ''),
(124, 'T202003160038', '2020-03-16 04:05:42', 'Created Ticket', '', 'CUSTOMER_88', ''),
(125, 'T202003160039', '2020-03-16 04:05:59', 'Created Ticket', '', 'CUSTOMER_88', ''),
(126, 'T202003160040', '2020-03-16 04:06:11', 'Created Ticket', '', 'CUSTOMER_88', ''),
(127, 'T202003160041', '2020-03-16 04:06:26', 'Created Ticket', '', 'CUSTOMER_88', ''),
(128, 'T202003160042', '2020-03-16 04:06:37', 'Created Ticket', '', 'CUSTOMER_88', ''),
(129, 'T202003160043', '2020-03-16 04:07:10', 'Created Ticket', '', 'CUSTOMER_88', ''),
(130, 'T202003160044', '2020-03-16 04:07:32', 'Created Ticket', '', 'CUSTOMER_88', ''),
(131, 'T202003160045', '2020-03-16 04:08:14', 'Created Ticket', '', 'CUSTOMER_88', ''),
(132, 'T202003160046', '2020-03-16 04:09:34', 'Created Ticket', '', 'CUSTOMER_88', ''),
(133, 'T202003160047', '2020-03-16 04:09:43', 'Created Ticket', '', 'CUSTOMER_88', ''),
(134, 'T202003160048', '2020-03-16 04:13:13', 'Created Ticket', '', 'CUSTOMER_88', ''),
(135, 'T202003160049', '2020-03-16 04:13:27', 'Created Ticket', '', 'CUSTOMER_88', ''),
(136, 'T202003160033', '2020-03-16 04:19:05', 'Up Progress To 10 %', 'G', 'K0003', 'CALL'),
(137, 'T202003160032', '2020-03-16 04:20:35', 'Up Progress To 10 %', '', 'K0003', 'TICKET'),
(138, 'T202003160050', '2020-03-16 05:09:11', 'Created Ticket', '', 'CUSTOMER_88', ''),
(139, 'T202003160034', '2020-03-16 08:25:22', 'Up Progress To 0 %', '', 'K0003', 'REMOTE'),
(140, 'T202003160034', '2020-03-16 08:25:52', 'Up Progress To 0 %', '', 'K0003', 'REMOTE'),
(141, 'T202003160034', '2020-03-16 08:25:58', 'Up Progress To 10 %', '', 'K0003', 'REMOTE'),
(142, 'T202003160051', '2020-03-16 08:45:43', 'Created Ticket', '', 'CUSTOMER_88', ''),
(143, 'T202003160027', '2020-03-17 04:03:02', 'Pemilihan Teknisi', 'TICKET DIBERIKAN KEPADA TEKNISI', 'K0001', ''),
(144, 'T202003170052', '2020-03-17 08:36:13', 'Created Ticket', '', 'CUSTOMER_88', ''),
(145, 'T202003170053', '2020-03-17 09:14:29', 'Created Ticket', '', 'CUSTOMER_88', ''),
(146, 'T202003170054', '2020-03-17 13:55:36', 'Created Ticket', '', 'CUSTOMER_88', ''),
(147, 'T202003170055', '2020-03-17 13:55:46', 'Created Ticket', '', 'CUSTOMER_88', ''),
(148, 'T202003170056', '2020-03-17 13:56:27', 'Created Ticket', '', 'CUSTOMER_88', ''),
(149, 'T202003170056', '2020-03-17 14:00:07', 'Up Progress To 0 %', '', 'K0003', 'REMOTE'),
(150, 'T202003170056', '2020-03-17 14:02:05', 'Up Progress To 0 %', '', 'K0003', 'REMOTE'),
(151, 'T20200317-040', '2020-03-17 14:06:08', 'Created Ticket', '', 'CUSTOMER_88', ''),
(152, 'T200317142924', '2020-03-17 14:29:24', 'Created Ticket', '', 'CUSTOMER_88', ''),
(153, 'T200317142924', '2020-03-17 14:33:40', 'Up Progress To 0 %', '', 'K0003', 'REMOTE'),
(154, 'T200317142924', '2020-03-17 14:33:49', 'Up Progress To 0 %', '', 'K0003', 'REMOTE'),
(155, 'T200317142924', '2020-03-20 06:39:08', 'Up Progress To 10 %', '', 'K0003', 'REMOTE'),
(156, 'T200317142924', '2020-03-20 06:40:15', 'Up Progress To 10 %', '', 'K0003', 'REMOTE'),
(157, 'T200317142924', '2020-03-20 06:40:19', 'Up Progress To 30 %', '', 'K0003', 'REMOTE'),
(158, 'T200317142924', '2020-03-20 06:41:14', 'Up Progress To 30 %', '', 'K0003', 'REMOTE'),
(159, 'T200327085333-040808', '2020-03-27 08:53:33', 'Created Ticket', '', 'CUSTOMER_88', ''),
(160, 'T200327085355-040808', '2020-03-27 08:53:55', 'Created Ticket', '', 'CUSTOMER_88', ''),
(161, 'T200327085749-040808', '2020-03-27 08:57:49', 'Created Ticket', '', 'CUSTOMER_88', ''),
(162, 'T200327085822-040808', '2020-03-27 08:58:22', 'Created Ticket', '', 'CUSTOMER_88', ''),
(163, 'T200327090206-040808', '2020-03-27 09:02:06', 'Created Ticket', '', 'CUSTOMER_88', ''),
(164, 'T200327090241-040808', '2020-03-27 09:02:41', 'Created Ticket', '', 'CUSTOMER_88', ''),
(165, 'T200327090316-040808', '2020-03-27 09:03:16', 'Created Ticket', '', 'CUSTOMER_88', ''),
(166, 'T200327090411-040808', '2020-03-27 09:04:11', 'Created Ticket', '', 'CUSTOMER_88', ''),
(167, 'T200327090642-040808', '2020-03-27 09:06:42', 'Created Ticket', '', 'CUSTOMER_88', ''),
(168, 'T200327091754-040808', '2020-03-27 09:17:54', 'Created Ticket', '', 'CUSTOMER_88', ''),
(169, 'T200327091920-040808', '2020-03-27 09:19:20', 'Created Ticket', '', 'CUSTOMER_88', ''),
(170, 'T200327093534-040808', '2020-03-27 09:35:34', 'Created Ticket', '', 'CUSTOMER_88', ''),
(171, 'T200327094150-040808', '2020-03-27 09:41:50', 'Created Ticket', '', 'CUSTOMER_88', ''),
(172, 'T200327094205-040808', '2020-03-27 09:42:05', 'Created Ticket', '', 'CUSTOMER_88', ''),
(173, 'T200327094215-040808', '2020-03-27 09:42:15', 'Created Ticket', '', 'CUSTOMER_88', ''),
(174, 'T200327094240-040808', '2020-03-27 09:42:40', 'Created Ticket', '', 'CUSTOMER_88', ''),
(175, 'T200327094326-040808', '2020-03-27 09:43:25', 'Created Ticket', '', 'CUSTOMER_88', ''),
(176, 'T200327094426-040808', '2020-03-27 09:44:26', 'Created Ticket', '', 'CUSTOMER_88', ''),
(177, 'T200327094150-040808', '2020-04-07 06:41:33', 'Up Progress To 100 %', 'TES', 'K0003', 'CALL'),
(178, 'T200327094426-040808', '2020-04-07 06:42:07', 'Up Progress To 100 %', 'TES123', 'K0003', 'REMOTE'),
(179, 'T200408140336-080707', '2020-04-08 14:03:36', 'Created Ticket', '', 'CUSTOMER_080707', ''),
(180, 'T200408140336-080707', '2020-04-08 14:06:14', 'Up Progress To 100 %', 'CEK CEK', 'K0003', 'REMOTE'),
(181, 'T200408141129-080707', '2020-04-08 14:11:29', 'Created Ticket', '', 'CUSTOMER_080707', ''),
(182, 'T200408142107-080707', '2020-04-08 14:21:07', 'Created Ticket', '', 'CUSTOMER_080707', ''),
(183, 'T200408142107-080707', '2020-04-08 15:42:40', 'Up Progress To 80 %', 'CEK CEK CEK', 'K0003', 'REMOTE'),
(184, 'T200424093331-011010010', '2020-04-24 09:33:31', 'Created Ticket', '', 'CUSTOMER_011010010', ''),
(185, 'T200424093351-011010010', '2020-04-24 09:33:51', 'Created Ticket', '', 'CUSTOMER_011010010', ''),
(186, 'T200424093351-011010010', '2020-04-24 09:37:12', 'Up Progress To 100 %', 'CEK NODE 2', 'K0003', 'REMOTE'),
(187, 'T200424145722-011010010', '2020-04-24 14:57:22', 'Created Ticket', '', 'CUSTOMER_011010010', ''),
(188, 'T200424150525-011010010', '2020-04-24 15:05:25', 'Created Ticket', '', 'CUSTOMER_011010010', ''),
(189, 'T200424151433-011010010', '2020-04-24 15:14:33', 'Created Ticket', '', 'CUSTOMER_011010010', ''),
(190, 'T200424151930-011010010', '2020-04-24 15:19:30', 'Created Ticket', '', 'CUSTOMER_011010010', ''),
(191, 'T200424152858-011010010', '2020-04-24 15:28:58', 'Created Ticket', '', 'CUSTOMER_011010010', ''),
(192, 'T200427142307-0100909', '2020-04-27 14:23:07', 'Created Ticket', '', 'CUSTOMER_090909', ''),
(193, 'T200427142307-0100909', '2020-04-27 14:24:04', 'Up Progress To 0 %', 'DESKRIPSI PROGRES', 'K0003', 'TICKET'),
(194, 'T200427142307-0100909', '2020-04-27 14:24:37', 'Up Progress To 60 %', '', 'K0003', 'REMOTE'),
(195, 'T200506101949-0100909', '2020-05-06 10:19:49', 'Created Ticket', '', 'CUSTOMER_090909', ''),
(196, 'T200506102246-0100909', '2020-05-06 10:22:46', 'Created Ticket', '', 'CUSTOMER_090909', ''),
(197, 'T200511014603', '2020-05-11 01:46:03', 'Created Ticket', '', 'K0001', ''),
(198, 'T200630115800-0100909', '2020-06-30 11:58:00', 'Created Ticket', '', 'CUSTOMER_090909', ''),
(199, 'T200702092706-0120909', '2020-07-02 09:27:06', 'Created Ticket', '', 'CUSTOMER_0120909', ''),
(200, 'T200702095635-0130909', '2020-07-02 09:56:35', 'Created Ticket', '', 'CUSTOMER_010909', ''),
(201, 'T200702095635-0130909', '2020-07-02 09:57:39', 'Up Progress To 100 %', 'OKE', 'K0003', 'REMOTE'),
(202, 'T200702105648-01507011', '2020-06-24 08:56:48', 'Created Ticket', '', 'CUSTOMER_01507011', ''),
(203, 'T200702105648-01507011', '2020-06-24 11:07:46', 'Up Progress To 100 %', '1. CEK SISI PENTAHONYA, NYANGKUT DI AKHIR JOB DI CEK ULANG\r\n2. TAMBAHIN VALIDASI\r\n3. KALO FILE BERBEDA ADA TRANSAKSI SAMA ITU OTOMATIS AMBIL SALAH SATU SKRG, YG SATUNYA OTOMATIS DI DROP\r\n4. ADA KETERANGAN DOUBLE DI MONITORING SETTLEMENT', 'K0003', 'REMOTE'),
(204, 'T200702113358-016011012', '2020-04-06 19:33:58', 'Created Ticket', '', 'CUSTOMER_016011012', ''),
(205, 'T200702113358-016011012', '2020-04-07 15:47:49', 'Up Progress To 80 %', 'LOG PADA HR_SERVER3 BERHENTI PADA TANGGAL 4 APRIL 2020, DAN JUGA ISI LOG JAUH BERBEDA DENGAN HR_SERVER1, HR_SERVER2, DAN HR_SERVER4 MESKIPUN SERVER-SERVER TERSEBUT DILAKUKAN CLUSTERING.\r\nDAN JUGA TERDAPAT ERROR CODE PADA WEBLOGIC LOG UNTUK HR_SERVER3 YAITU DENGAN ERROR SEBAGAI BERIKUT:\r\n\r\n<ERROR> <HTTP> <DRC-APP03> <HR_SERVER3> <EXECUTETHREAD: \'3\' FOR QUEUE: \'WEBLOGIC.SOCKET.MUXER\'> <<WLS KERNEL>> <> <> <1585828575531> <BEA-101215> <MALFORMED REQUEST \"NULL\". REQUEST PARSING FAILED, CODE: -1>\r\n\r\nERROR TERSEBUT MENGAKIBATKAN LOG FILE DI PENUHI DENGAN ERROR LOG TERSEBUT SEHINGGA DENGAN CEPAT MEMENUHI DISK SPACE SEHINGGA MEMPENGARUHI PERFORMA MESKIPUN USER TETAP BISA MEMAKAI APLIKASI.', 'K0007', 'REMOTE'),
(206, 'T200702120025-016011012', '2020-04-13 12:00:25', 'Created Ticket', '', 'CUSTOMER_016011012', ''),
(207, 'T200702120025-016011012', '2020-04-13 13:27:45', 'Up Progress To 10 %', 'AMBIL LOG UNTUK INVESTIGASI DAN DIANALISA.', 'K0007', 'REMOTE'),
(208, 'T200702120025-016011012', '2020-04-14 15:08:01', 'Up Progress To 90 %', 'SAAT DILAKUKAN CHECK LOG, TERDAPAT ERROR MESSAGE JAVA.LANG.OUTOFMEMORYERROR:\r\nRESOURCE TEMPORARILY UNAVAILABLE IN TSSTARTJAVATHREAD (LIFECYCLE.C:1097). \r\nMUNCULNYA ERROR MESSAGE TERSEBUT DIKARENAKAN JUMLAH PROSES PER USER PADA SERVER DI\r\nLEVEL OS MELEBIHI DARI KAPASITAS MAKSIMAL.\r\n\r\nMENUNGGU IZIN UNTUK SERVER LAN 3', 'K0007', 'REMOTE'),
(209, 'T200702120025-016011012', '2020-04-14 23:09:32', 'Up Progress To 100 %', 'RESTART SERVER LAND 3\r\nDAN STATUS SUDAH RUNNING KEMBALI', 'K0007', 'REMOTE'),
(210, 'T200711162637-0130909', '2020-07-11 16:26:37', 'Created Ticket', '', 'CUSTOMER_010909', ''),
(211, 'T200716115329-017012013', '2020-07-16 11:53:28', 'Created Ticket', '', 'CUSTOMER_017012013', ''),
(212, 'T200716115329-017012013', '2020-07-16 11:56:11', 'Up Progress To 100 %', 'CEK LINE 30 PADA CODE', 'K0003', 'REMOTE'),
(213, 'T200716131655-018013014', '2020-07-16 13:16:55', 'Created Ticket', '', 'CUSTOMER_018013014', ''),
(214, 'T200716132816-018013014', '2020-07-16 13:28:16', 'Created Ticket', '', 'CUSTOMER_018013014', ''),
(215, 'T200716132816-018013014', '2020-07-16 13:32:58', 'Up Progress To 100 %', 'CEK LOG AJA', 'K0003', 'REMOTE'),
(216, 'T200717060226-019014015', '2020-07-17 06:02:26', 'Created Ticket', '', 'CUSTOMER_017014015', ''),
(217, 'T200717060226-019014015', '2020-07-17 06:05:03', 'Up Progress To 100 %', 'CEK LOG APLIKASI', 'K0003', 'REMOTE');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `level` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`, `email`) VALUES
(1, 'K0001', '21232f297a57a5a743894a0e4a801fc3', 'ADMIN', 'NURUL.AZHAR@MITRAINTIBERSAMA.COM'),
(2, 'K0003', 'e21394aaeee10f917f581054d24b031f', 'TEKNISI', 'NINOBAGUS.MAIL@GMAIL.COM'),
(22, 'K0009', '21232f297a57a5a743894a0e4a801fc3', 'ADMIN', 'nurulazhar23@gmail.com'),
(24, 'K0011', '0192023a7bbd73250516f069df18b500', 'ADMIN', 'arvinchristian9@gmail.com'),
(26, 'customer_010909', '9948f1e097b01d0b1b8d7705659ad8a8', 'CUSTOMER', 'bankmantap@bankmantap.com'),
(27, 'customer_0170808', '161ebd7d45089b3446ee4e0d86dbcf92', 'CUSTOMER', 'irham_hasly@yahoo.com'),
(28, 'customer_01507011', '91cb974ef627a6659fa69731c10d4e38', 'CUSTOMER', 'subhan@bankdki.co.id'),
(29, 'customer_016011012', '161ebd7d45089b3446ee4e0d86dbcf92', 'CUSTOMER', 'pudjoian@gmail.com'),
(30, 'K0007', 'e21394aaeee10f917f581054d24b031f', 'TEKNISI', 'RONALD@MITRAINTIBERSAMA.COM'),
(33, 'K0012', '7360409d967a24b667afc33a8384ec9e', 'ADMIN', 'ADI@GMAIL.COM'),
(34, 'K0004', '7e9aedd97b5ec4590edb8281ff12b168', 'TEKNISI', 'ZEIN@GMAIL.COM'),
(36, 'K0013', '16d5d24f5b09a1991bd4e5f57bf11237', 'ADMIN', 'PIPI@MITRAINTIBERSAMA.COM'),
(38, 'K0014', '9a1591b6e5317fb71c6032eedd5c051a', 'TEKNISI', 'RINA@GMAIL.COM'),
(39, 'customer_017014015', '79cfeb94595de33b3326c06ab1c7dbda', 'CUSTOMER', 'abcd@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bagian_departemen`
--
ALTER TABLE `bagian_departemen`
  ADD PRIMARY KEY (`id_bagian_dept`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD UNIQUE KEY `id_customer` (`id_customer`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id_dept`);

--
-- Indexes for table `history_feedback`
--
ALTER TABLE `history_feedback`
  ADD PRIMARY KEY (`id_feedback`);

--
-- Indexes for table `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id_informasi`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kondisi`
--
ALTER TABLE `kondisi`
  ADD PRIMARY KEY (`id_kondisi`);

--
-- Indexes for table `sub_kategori`
--
ALTER TABLE `sub_kategori`
  ADD PRIMARY KEY (`id_sub_kategori`);

--
-- Indexes for table `teknisi`
--
ALTER TABLE `teknisi`
  ADD PRIMARY KEY (`id_teknisi`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`);

--
-- Indexes for table `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id_tracking`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bagian_departemen`
--
ALTER TABLE `bagian_departemen`
  MODIFY `id_bagian_dept` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id_dept` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `history_feedback`
--
ALTER TABLE `history_feedback`
  MODIFY `id_feedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id_informasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kondisi`
--
ALTER TABLE `kondisi`
  MODIFY `id_kondisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_kategori`
--
ALTER TABLE `sub_kategori`
  MODIFY `id_sub_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id_tracking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
