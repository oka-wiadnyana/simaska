-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Feb 02, 2024 at 05:53 AM
-- Server version: 8.0.32
-- PHP Version: 8.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sikreta`
--

-- --------------------------------------------------------

--
-- Table structure for table `akuns`
--

CREATE TABLE `akuns` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int DEFAULT NULL,
  `username` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `level` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akuns`
--

INSERT INTO `akuns` (`id`, `employee_id`, `username`, `password`, `level`) VALUES
(124, 51, 'dedi', '$2y$10$0oZ4MM6PaYoAy9mLjnyQau3yYz3AX3a9ohBuCeM6XZhVYhBxsKSJu', '19'),
(125, 52, 'iwan', '$2y$10$svLVhyid1NzDk8F9slMZjeNcUfTFoSvjDsKZOi7eppA/8IAEGsL1a', '5'),
(126, 50, 'super_admin', '$2y$10$Z.qAbMJGaO8fwqm9j60guuY8VpkqMiGPLGxF6OmrRpXEgpfu0iWwu', '20');

-- --------------------------------------------------------

--
-- Table structure for table `db_pegawai`
--

CREATE TABLE `db_pegawai` (
  `id` int NOT NULL,
  `nama` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nip` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `golongan` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_hp` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `atasan_langsung` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_id` int DEFAULT NULL,
  `unit_id` int DEFAULT NULL,
  `golongan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_atasan_langsung` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_awal_mk` date DEFAULT NULL,
  `potongan_mk` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `nama`, `nip`, `position_id`, `unit_id`, `golongan`, `nomor_hp`, `is_atasan_langsung`, `tgl_awal_mk`, `potongan_mk`) VALUES
(50, 'Admin', '000', 27, 16, '12', '081337320205', 'Y', '2024-02-01', NULL),
(51, 'dedi', '098765', 16, 8, '1', '081803275788', 'T', '2024-02-01', NULL),
(52, 'Tes2', '0987651', 6, 6, '1', '081803275788', 'Y', '2024-02-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fullfills`
--

CREATE TABLE `fullfills` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` int DEFAULT NULL,
  `order_detail_id` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `satuan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `dipa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE `goods` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `goods`
--

INSERT INTO `goods` (`id`, `nama_barang`, `satuan`, `kode`, `urutan`) VALUES
(1, 'Paper Clip No. 5', 'kotak', NULL, NULL),
(2, 'Spidol Permanent', 'buah', NULL, NULL),
(3, 'Spidol Boardmaker', 'buah', NULL, NULL),
(4, 'Bolpoint Ball Liner', 'buah', NULL, NULL),
(5, 'Pulpen Kenko Easy Gel', 'buah', NULL, NULL),
(6, 'Pulpen Snowman V7', 'buah', NULL, NULL),
(7, 'Pulpen Snowman V5', 'buah', NULL, NULL),
(8, 'Pulpen Queens', 'buah', NULL, NULL),
(9, 'Pulpen ZuiXua', 'buah', NULL, NULL),
(10, 'Pencil Standard 2B', 'buah', NULL, NULL),
(11, 'Pulpen Deli Meja', 'buah', NULL, NULL),
(12, 'Pulpen Standard P5', 'buah', NULL, NULL),
(13, 'Tinta Stempel', 'buah', NULL, NULL),
(14, 'Trigonal clips', 'Kotak', NULL, NULL),
(15, 'Paper Clips No. 3', 'kotak', NULL, NULL),
(16, 'Binder Clips No 105', 'Kotak', NULL, NULL),
(17, 'Binder Clips No 200', 'Kotak', NULL, NULL),
(18, 'Binder Clips No 260', 'Kotak', NULL, NULL),
(19, 'Buku Kwitansi kecil', 'buah', NULL, NULL),
(20, 'Buku kwitansi besar', 'buah', NULL, NULL),
(21, 'Tip Ex', 'buah', NULL, NULL),
(22, 'Penghapus pensil', 'buah', NULL, NULL),
(23, 'Penghapus pulpen', 'buah', NULL, NULL),
(24, 'Buku Ekspedisi', 'buah', NULL, NULL),
(25, 'Buku Folio isi 200', 'buah', NULL, NULL),
(26, 'Buku Folio isi 100', 'buah', NULL, NULL),
(27, 'Buku Foilo isi 50', 'buah', NULL, NULL),
(28, 'Buku Tulis Kwarto', 'buah', NULL, NULL),
(29, 'Buku Tulis Biasa', 'buah', NULL, NULL),
(30, 'Map Folio Biasa', 'buah', NULL, NULL),
(31, 'Map Folio Logo PN', 'buah', NULL, NULL),
(32, 'Map Plastik Snellhecter', 'buah', NULL, NULL),
(33, 'Map Plastik Jepit', 'buah', NULL, NULL),
(34, 'Map Batik', 'buah', NULL, NULL),
(35, 'Map Kancing', 'buah', NULL, NULL),
(36, 'Ordener', 'buah', NULL, NULL),
(37, 'Box File', 'buah', NULL, NULL),
(38, 'Penggaris 30 cm', 'buah', NULL, NULL),
(39, 'Penggaris 50 cm', 'buah', NULL, NULL),
(40, 'Cutter Besar', 'buah', NULL, NULL),
(41, 'Isi Cutter', 'buah', NULL, NULL),
(42, 'Gunting kecil', 'buah', NULL, NULL),
(43, 'Gunting sedang', 'buah', NULL, NULL),
(44, 'Lakban Hitam', 'buah', NULL, NULL),
(45, 'Lakban Hitam sedang', 'buah', NULL, NULL),
(46, 'Lakban Bening', 'buah', NULL, NULL),
(47, 'Lem Kertas', 'buah', NULL, NULL),
(48, 'Lem Castol', 'buah', NULL, NULL),
(49, 'Lem Stick', 'buah', NULL, NULL),
(50, 'Lem Sakti', 'buah', NULL, NULL),
(51, 'Double tape putih', 'buah', NULL, NULL),
(52, 'Doble tape hitam', 'buah', NULL, NULL),
(53, 'Stapler Besar', 'buah', NULL, NULL),
(54, 'Stapler HD-10', 'buah', NULL, NULL),
(55, 'Isi Staples besar', 'buah', NULL, NULL),
(56, 'Isi stapler 10-1MU', 'buah', NULL, NULL),
(57, 'Bantalan Stempel', 'buah', NULL, NULL),
(58, 'Gantungan kunci', 'buah', NULL, NULL),
(59, 'Pelubang Kertas', 'buah', NULL, NULL),
(60, 'Clip board/papan ujian', 'buah', NULL, NULL),
(61, 'Rautan pensil', 'buah', NULL, NULL),
(62, 'Highlighter/Stabilo', 'buah', NULL, NULL),
(63, 'Sheet protector', 'pax', NULL, NULL),
(64, 'HVS SIDU 70 grF4', 'Rim', NULL, NULL),
(65, 'HVS SIDU 70 gr A4', 'Rim', NULL, NULL),
(66, 'HVS berwarna merah', 'Rim', NULL, NULL),
(67, 'HVS berwarna hijau', 'Rim', NULL, NULL),
(68, 'HVS berwarna kuning', 'Rim', NULL, NULL),
(69, 'Kertas Kissing Coklat', 'buah', NULL, NULL),
(70, 'Kertas sticker Camel', 'Lembar', NULL, NULL),
(71, 'Kertas Stiker Glossy', 'pax', NULL, NULL),
(72, 'Sticknnote kecil', 'pax', NULL, NULL),
(73, 'Sticknote besar', 'pax', NULL, NULL),
(74, 'Kertas Bufallo', 'Rim', NULL, NULL),
(75, 'Mika utk Jilid', 'pax', NULL, NULL),
(76, 'Tinta Canon 790 Hitam', 'buah', NULL, NULL),
(77, 'Amplop Coklat kecil', 'pax', NULL, NULL),
(78, 'Amplop Coklat ukuran Sedang', 'pax', NULL, NULL),
(79, 'Amplop Coklat Uk Besar', 'pax', NULL, NULL),
(80, 'Amplop putih kecil', 'pax', NULL, NULL),
(81, 'Amplop putih besar', 'pax', NULL, NULL),
(82, 'Sapu Ijuk', 'buah', NULL, NULL),
(83, 'Sapu Lidi Tangkai', 'buah', NULL, NULL),
(84, 'Sapu Taman', 'buah', NULL, NULL),
(85, 'Sikat WC bulat', 'buah', NULL, NULL),
(86, 'Lap Canebo', 'buah', NULL, NULL),
(87, 'Lap  kuning', 'buah', NULL, NULL),
(88, 'Alat Pel', 'buah', NULL, NULL),
(89, 'Ember Besar', 'buah', NULL, NULL),
(90, 'Kabel Ties kecil', 'buah', NULL, NULL),
(91, 'Kabel ties Sedang', 'Bungkus', NULL, NULL),
(92, 'Kabel Ties Panjang', 'Bungkus', NULL, NULL),
(93, 'Pembersih kaca Cling', 'buah', NULL, NULL),
(94, 'Pembersih Lantai Wipol', 'buah', NULL, NULL),
(95, 'Pembersih Lantai So Klin', 'buah', NULL, NULL),
(96, 'Vixal porcelain cleaner', 'buah', NULL, NULL),
(97, 'Super Sol 450 ML', 'buah', NULL, NULL),
(98, 'Rinso', 'buah', NULL, NULL),
(99, 'Sunlihgt pencuci piring', 'buah', NULL, NULL),
(100, 'Baygon', 'buah', NULL, NULL),
(101, 'Handsoap', 'buah', NULL, NULL),
(102, 'Pengharum gantung', 'buah', NULL, NULL),
(103, 'Pengharum Refil', 'buah', NULL, NULL),
(104, 'Alat Pengharum matic', 'buah', NULL, NULL),
(105, 'Baterai AA', 'set', NULL, NULL),
(106, 'Baterai AAA', 'Set', NULL, NULL),
(107, 'Baterai kotak', 'buah', NULL, NULL),
(108, 'Nice Tissu gulung', 'buah', NULL, NULL),
(109, 'Facial Tissu /Tisu Meja', 'buah', NULL, NULL),
(110, 'Hand towel Tisu/pengesat', 'buah', NULL, NULL),
(111, 'AUTAN', 'buah', NULL, NULL),
(112, 'Benang Berkas', 'buah', NULL, NULL),
(113, 'Jarum berkas', 'buah', NULL, NULL),
(114, 'Daimaru cloth merah 48x12 mm', 'Buah', NULL, NULL),
(115, 'Lakban Hijau', 'Buah', NULL, NULL),
(116, 'Kertas Foto Glossy', 'pax', NULL, NULL),
(117, 'porstex', 'Buah', NULL, NULL),
(118, 'Tinta HP 955 XL', 'buah', NULL, NULL),
(119, 'Tinta HP 955 XL black', 'buah', NULL, NULL),
(120, 'Tinta HP 955 XL Cyan', 'buah', NULL, NULL),
(121, 'Tinta HP 955 XL Magenta', 'buah', NULL, NULL),
(122, 'Tinta HP 955 XL Magenta', 'buah', NULL, NULL),
(123, 'Tinta HP 955 XL Yellow', 'buah', NULL, NULL),
(124, 'Tinta canon 790 Magenta', 'buah', NULL, NULL),
(125, 'Tinta Canon  790 Yellow', 'buah', NULL, NULL),
(126, 'Tinta Canon 790 Cyan', 'buah', NULL, NULL),
(127, 'Pledge', 'buah', NULL, NULL),
(128, 'Kit Protectant', 'buah', NULL, NULL),
(129, 'Spon', 'buah', NULL, NULL),
(130, 'Mouse Pad', 'buah', NULL, NULL),
(131, 'Hand Sanitizer 250ml', 'buah', NULL, NULL),
(132, 'Deli Cutter D 100 40', 'buah', NULL, NULL),
(133, 'Bayclin 200ml', 'buah', NULL, NULL),
(134, 'kresek sampah', 'buah', NULL, NULL),
(135, 'Double tape Kenko Besar', 'buah', NULL, NULL),
(136, 'Double Tape', 'buah', NULL, NULL),
(137, 'Amplas  Air', 'buah', NULL, NULL),
(138, 'Karbol Wangi', 'buah', NULL, NULL),
(139, 'Penghapus BIG', 'buah', NULL, NULL),
(140, 'STD Yellow Pencil 2B', 'buah', NULL, NULL),
(141, 'Standard cm 2', 'buah', NULL, NULL),
(142, 'Buku Tulis Sampul Tebal', 'buah', NULL, NULL),
(143, 'Sapu Bulu', 'buah', NULL, NULL),
(144, 'Binder Clips 280', 'kotak', NULL, NULL),
(145, 'Gunting besar', 'buah', NULL, NULL),
(146, 'Bingkai foto', 'buah', NULL, NULL),
(147, 'Spidol Warna Merah Kecil', 'buah', NULL, NULL),
(148, 'Binder Clips 111', 'kotak', NULL, NULL),
(150, 'Roundup', 'buah', 'B', 1),
(151, 'USB HUB ROBOT 4 PORT H130 B', 'buah', 'C', 1),
(152, 'Refill Toner Brother', 'buah', 'A', 1),
(153, 'RefillToner 83A', 'buah', 'A', 2),
(154, 'Refill Toner Canon', 'buah', 'A', 3),
(155, 'spidol merah', 'buah', 'C', 2),
(156, 'binder clip 280', 'buah', 'C', 3),
(157, 'Bantek', 'buah', 'C', 4),
(158, 'Wipol', 'buah', 'B', 2),
(159, 'Kuas', 'buah', 'C', 5),
(160, 'Kuas', 'buah', 'C', 6),
(161, 'Map Perkara Pidana', 'buah', 'A', 4),
(163, 'Kalkulator', 'buah', 'C', 7),
(164, 'Tempat Sampah', 'buah', 'C', 8),
(165, 'Amplop Perkara Pidana', 'pax', 'A', 5),
(166, 'CD-R', 'kotak', 'A', 6),
(167, 'Tali Tambang', 'meter', 'C', 9),
(168, 'Benang Kemong', 'buah', 'C', 10),
(169, 'Buku dobel folio', 'buah', 'A', 7);

-- --------------------------------------------------------

--
-- Table structure for table `hari_efektif`
--

CREATE TABLE `hari_efektif` (
  `id` bigint UNSIGNED NOT NULL,
  `id_cuti` int NOT NULL,
  `tahun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jml_hari_efektif` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hari_efektif`
--

INSERT INTO `hari_efektif` (`id`, `id_cuti`, `tahun`, `jml_hari_efektif`) VALUES
(1, 1, '2024', 2),
(2, 2, '2024', 2);

-- --------------------------------------------------------

--
-- Table structure for table `izin_keluar_kantor`
--

CREATE TABLE `izin_keluar_kantor` (
  `id` int UNSIGNED NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nip_atasan` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_awal` time DEFAULT NULL,
  `jam_akhir` time DEFAULT NULL,
  `alasan` text,
  `acc_ats` varchar(50) DEFAULT NULL,
  `reject_ats` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi_kka`
--

CREATE TABLE `klasifikasi_kka` (
  `id` int NOT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `klasifikasi_kka`
--

INSERT INTO `klasifikasi_kka` (`id`, `kode`, `keterangan`) VALUES
(1, 'HK 1', 'Peraturan  Perundang-undangan eksterna/internal'),
(2, 'HK 1.1', 'Peraturan  perundang-undangan eksternal'),
(3, 'HK 1.1.1', 'Undang-undang/ Peraturan   Pemerintah   Pengganti Undang-undang  (PERPU).'),
(4, 'HK1. 1.2', 'Peraturan  Pemerintah.'),
(5, 'HK1. 1.3', 'Peraturan  Presiden.'),
(6, 'HK1. 1.4', 'Keputusan  Presiden.'),
(7, 'HK1. 1.5', 'Instruksi  Presiden.'),
(8, 'HK1.2', 'Peraturan perundang-undangan/Kebijakan internal'),
(9, 'HK1.2.1', 'Peraturan  Mahkamah Agung'),
(10, 'HK1.2.2', 'Instruksi'),
(11, 'HK 1.2.3', 'Surat Edaran'),
(12, 'HK1.2.4', 'Maklumat  Ketua Mahkamah  Agung'),
(13, 'HK 1.2.5', 'Keputusan'),
(14, 'HKl.3', 'Surat Perjanjian/ Nota Kesepahaman'),
(15, 'HK1.3.1', 'Dalam  Negeri'),
(16, 'HK l .3.2', 'Luar  Negeri'),
(17, 'HK2', 'Penyelesaian  perkara'),
(18, 'HK2. 1', 'Pidana  umum'),
(19, 'HK2.2', 'Pidana khusus'),
(20, 'HK2.3', 'Pidana militer'),
(21, 'HK2.4', 'Perdata Umum'),
(22, 'HK2.5', 'Perdata niaga'),
(23, 'HK2.6', 'Perdata agama'),
(24, 'HK2.7', 'Tata usaha negara'),
(25, 'HM1', 'Hubungan  Masyarakat'),
(26, 'HM1. 1', 'Publikasi  informasi'),
(27, 'HM1. 1. 1', 'Penerangan  dan publikasi'),
(28, 'HM1. l .2', 'Pidato\n'),
(29, 'HM1.2', 'Dokumentasi  dan peliputan'),
(30, 'HM2', 'Hubungan  Kelembagaan'),
(31, 'HM2.1', 'Hubungan  antar Lembaga'),
(32, 'HM2.1.1', 'Lembaga  Pemerintah'),
(33, 'HM2.1.2', 'Lembaga  Swasta'),
(34, '\nHM2.1.3', ' Organisasi  Sosial/ LSM Naskah yang berkaitan dengan  kegiatan hubungan  dengan organisasi sosial/ LSM.'),
(35, '\nHM2.1.4', 'Perguruan Tinggi Naskah yang  berkaitan  dengan kegiatan hubungan  dengan  perguruan  tinggi'),
(36, 'HM3', 'Keprotokolan'),
(37, 'HM3.1', 'Upacara dan Kegiatan  resmi'),
(38, 'HM3.1.1\nHM3. 1.2', 'Upacara/Acara  Kedinasan'),
(39, 'HM3.1.3', 'Agenda pimpinan'),
(40, 'KA 1', 'Kendali Arsip'),
(41, 'KA 1.1', 'Pengendalian  Dan Pengurusan  Arsip'),
(42, 'KA 1.2', 'Layanan  Penggunaan  Arsip'),
(43, 'KA 2', 'Pengelolaan  Arsip'),
(44, 'KA 2.1', 'Penyimpanan  Dan  Pemeliharaan  Arsip\n'),
(45, 'KA2. 1.1', 'Pengelolaan  Arsip Aktif'),
(46, 'KA2. 1.2', 'Pengelolaan  Arsip Inaktif'),
(47, 'KA2. 1.3', 'Pengelolaan  Arsip Vital'),
(48, 'KA2. 1.4', 'Pengelolaan  Arsip Terjaga'),
(49, 'KA2. 1.5', 'Perawatan Arsip'),
(50, 'KA2. 1.6', 'Penyelamatan  dan  Pemulihan  Arsip'),
(51, 'KA2.2', 'Penyusutan Arsip\n'),
(52, 'KA2.2. 1', 'Pemindahan Arsip Inaktif'),
(53, NULL, 'Arsip  yang  berkaitan  dengan  kegiatan  pemindahan'),
(54, 'KA2.2.2', 'Pemusnahan  Arsip\nArsip yang  berkaitan dengan  kegiatan  pemusnahan arsip'),
(55, 'KA2.2.3', 'Penyerahan  Arsip'),
(56, 'KA2.3', 'Pengawasan  Kearsipan'),
(57, NULL, 'Arsip  yang  berkaitan  dengan  kegiatan  pengawasan\nkearsipan'),
(58, 'KP1', 'Pengadaan  SDM'),
(59, 'KP 1. l', 'Perencanaan  dan  Seleksi'),
(60, 'KP1.1.1', 'Hakim  Agung'),
(61, 'KP 1. 1.2', 'Hakim'),
(62, 'KP 1.1.3', 'Hakim Ad Hoc'),
(63, 'KP l . 1.4', 'Pejabat  Pimpinan  Tinggi Madya'),
(64, 'KP1.1.5', 'Pejabat  Pimpinan Tinggi Pratama'),
(65, 'KP1.1.6', 'PNS'),
(66, 'KP 1.1.7', 'PPPK'),
(67, 'KP l . 1.8', 'Tenaga  Ahli dan  lain-lain'),
(68, 'KP1.2', 'Pengangkatan'),
(69, 'KP 1.2. 1', 'Hakim  Agung'),
(70, 'KP  1.2. 2', 'Hakim'),
(71, 'KP 1.2.3', 'Hakim Ad Hoc'),
(72, 'KP1.2.4', 'Pejabat  Pimpinan  Tinggi  Madya'),
(73, 'KP 1.2.5', 'Pejabat  Pimpinan  Tinggi Pratama'),
(74, 'KP1.2.6', 'PNS'),
(75, 'KP1.2.7', 'PPPK'),
(76, 'KPI.2.8', 'Tenaga Ahli dan lain-lain'),
(77, 'KPI.2.9', 'Pegawai  Pindah  Instansi  masuk/ keluar  Mahkamah Agung/Pengisian Jabatan\n'),
(78, NULL, NULL),
(79, 'KP2', 'Kepangkatan\nArsip yang  berkaitan  dengan  pangkat/golongan.'),
(80, 'KP2.1', 'Pangkat/ Golongan'),
(81, 'KP2. 1.1', 'Kenaikan  pangkat/golongan'),
(82, 'KP2.1.2', 'Kenaikan  gaji berkala'),
(83, 'KP2.1.3', 'Penyesuaian  masa kerja'),
(84, 'KP3', 'Pengelolaan   Kompetensi   dan   Manajemen   Kinerja Pegawai'),
(85, 'KP3. 1', 'Standar Kompetensi  Jabatan'),
(86, 'KP3. 1.1', 'Standar Kompetensi  Teknis Jabatan'),
(87, 'KP3. 1.2', 'Asesmen  Sumber  Daya Manusia'),
(88, 'KP3.1.3', 'Profiling  Pegawai'),
(89, 'KP3.2', 'Ujian Kenaikan  Pangkat/Ijazah'),
(90, 'KP3.2. I', 'Ujian Penyesuaian  Ijazah'),
(91, 'KP3.2.2', 'Ujian Dinas'),
(92, 'KP3.2.3', 'Ujian Kompetensi'),
(93, 'KP33', 'Tugas Belajar/Izin  Belajar'),
(94, 'KP3.3.1', 'Tugas Belajar'),
(95, 'KP3.3.2', 'Izin Belajar'),
(96, 'KP3.4', 'Manajemen  Kinerja Pegawai'),
(97, 'KP3.4.1', 'Perencanaan  dan Pelaksanaan  Kinerja Pegawai\n'),
(98, 'KP3.4.2', 'Pembinaan  Kinerja  Pegawai'),
(99, 'KP3.4.3', 'Evaluasi Kinerja Pegawai'),
(100, NULL, 'Arsip   yang    berkaitan    dengan    kegiatan    evaluasi'),
(101, 'KP3.4.4', 'Penilaian  Kinerja Jabatan  Fungsional'),
(102, 'KP3.4.5', 'Penetapan  Jabatan dan Peringkat  Pegawai'),
(103, 'KP3.4.6', 'Pemetaan  Pegawai\n'),
(104, 'KP4', 'Manajemen  Karier\n'),
(105, 'KP4.1', 'Pengembangan  Karier\n'),
(106, 'KP4.1.1', 'Pengembangan  Karier Pegawai\n'),
(107, 'KP4.1.2', 'Manajemen  Talenta'),
(108, NULL, NULL),
(109, 'KP4.1.3', 'Mutasi,  Promosi,  dan Demosi'),
(110, 'KP4.1.4', 'Tim Penilai Kinerja Jabatan'),
(111, 'KP4.1.ö', 'Pemberhentian  jabatan'),
(112, 'KP5', 'Kesejahteraan  Pegawai\n'),
(113, 'KP5.1', 'Mutasi Keluarga'),
(114, 'KP5.2', 'Layanan  Kesehatan\n'),
(115, 'KP5.3', 'Cuti   dan   izin    bepergian    ke   Luar   Negeri   diluar\nKedinasan\n'),
(116, 'KP5.4', 'Kegiatan  Sosial'),
(117, 'KP5.5', 'Perumahan'),
(118, 'KP5.6', 'Koperasi'),
(119, 'KP5.7', 'Transportasi antar jemput'),
(120, 'KP5.8', 'Penghargaan  dan Tanda Jasa'),
(121, 'KP6', 'Pemberhentian  pegawai\n'),
(122, 'KP6.1', 'Pemberhentian  Pegawai  dengan  Hak Pensiun\n'),
(123, 'KP6.2', 'Pemberhentian  Pegawai Tanpa Hak Pension'),
(124, 'KP6.3', 'Tewas,  Hilang/ Meninggal  Dalam Tugas'),
(125, 'KP6.4', 'Pembinaan  Mental,  Agama dan  Konseling'),
(126, 'KP7', 'Administrasi Sumber  Daya Mariusia\n'),
(127, 'KP7. 1', 'Pelaksanaan  Tugas Dalam Jabatan\n'),
(128, 'KP7.2', 'Dokumentasi  Identitas Pegawai\n'),
(129, 'KP7.3', 'Laporan   Pajak-Pajak   Pribadi   (LP2P)   dan   Laporan\nHarta Kekayaan (LHK)'),
(130, 'KP74', 'Surat    Penunjukan    Pelaksana    Tugas    (Plt.)    dan\nPelaksana  Harian (Plh.)\n'),
(131, 'KP7.5', 'lzin Perkawinan/Perceraian Pegawai'),
(132, NULL, 'Kode Etik dan Disiplin'),
(133, 'KP8. 1', 'Kode Etik dan Perilaku\n'),
(134, 'KP8.2', 'Sanksi/Hukuman Disiplin  Pegawai'),
(135, NULL, NULL),
(136, 'KP8.3', 'Penyelesaian  Keberatan/Banding (Disiplin)\n'),
(137, 'KP8.4', 'Pemberhenti dari   Berdasarkan  Permasalahan Kepegawaian  Lainnya\n'),
(138, 'PL1', 'Pengadaan         Barang/Jasa,         Pengelolaan         dan\nPenatausahaan  Barang Milik  Negara'),
(139, 'PL1.1', 'Pengadaan  Barang/Jasa'),
(140, 'PL1.1.1', 'Pengadaan  Barang Persediaan\n'),
(141, 'PL1.1.2', 'Pengadaan  Barang Inventaris\n'),
(142, 'PL1.1.3', 'Pengadaan  Barang\n'),
(143, 'PL1.1.4', 'Pengadaan  Jasa'),
(144, 'PL1.1.5', 'Pengadaan  Jasa Konsultansi'),
(145, 'PL1. 1.6', 'Pengadaan  Jasa Lainnya\n'),
(146, 'PL1. 1.7', 'Pengadaan  Jasa Konstruksi'),
(147, 'PL1.2', 'Pengelolaan dan Penatausahaan  Barang Milik Negara'),
(148, 'PL1.2.1', 'Perencanaan  Barang  Milik Negara\n'),
(149, 'PL l .2.2', 'Standar Barang dan Standar Kebutuhan  BMN\n(SBSK) dari Unit Kerja/ Unit Organisasi'),
(150, 'PL1.2.3', 'Penghapusan  dan  Pemusnahan  BMN'),
(151, 'PL1.2.4', 'Hibah'),
(152, 'PL1.2.5', 'Pencatatan  BMN'),
(153, 'PL1.2.6', 'Revaluasi  dan  Rekonsiliasi  BMN'),
(154, 'PL1.2.7', 'Pelaporan  BMN'),
(155, 'PS 1', 'Pengelolaan  dan  Pengembangan  koleksi  pustaka\n'),
(156, 'PS 1.1', 'Akuisisi Koleksi/Bahan pustaka\n'),
(157, 'PS 1.2', 'Hibah Koleksi/Bahan  Pustaka\n'),
(158, 'PS 1.3', 'Layanan  Kepustakaan\n'),
(159, 'PS 1.4', 'Keanggotaan  Perpustakaan\n'),
(160, 'PS 1.4.1', 'Form Keanggotaan  Perpustakaan\n'),
(161, 'PS 1.4.2', 'Data Anggota Perpustakaan\n'),
(162, 'Ps 1.s', 'Sirkulasi Koleksi/  Bahan Pustaka\n'),
(163, 'PS1.6', 'Preservasi  Koleksi/  Bahan Pustaka\n'),
(164, 'PS 1.7', 'Pengembangan   Perpustakaan   dan   Pengembangan Minat  Baca\n'),
(165, 'PW1', 'Pengawasan/ Pemantauan  Internal\n'),
(166, 'PW 1. 1', 'Pengawasan  dengan Tiridak  lanjut\n'),
(167, 'PW  1.1.1', 'Pengawasan / Pemantauan yang  Memerlukan Tindak  Lanjut\n'),
(168, 'PW 1. 1.2', 'Pengawasan / Pemaritauan yang  Merigandung Unsur Pelanggaran  Non Administratif/  Fraud yang Memerlukan  Tindak  Lanjut\n'),
(169, 'PW1.2', 'Pengawasan yang tidak memerlukan Tindak lanjut\n'),
(170, 'PW 1.2.1', 'Pengawasan / Pemantauan  yang  Tidak Memerlukan Tindak Lanjut\n'),
(171, 'PW 1.2.2', 'Pengawasan / Pemantauan       yang       Mengandung Unsur  Pelanggaran  Non  Administratif/ Fraud  yang Tidak  Memerlukan  Tindak  Lanjut\n'),
(172, 'PW 1.3', 'Pengawasan/ Pemantauan  Pegawai\n'),
(173, 'PW1.4', 'Pengawasan  Eksternal\n'),
(174, 'RT1', 'Penggunaan  Gedung  dan Fasilitas  Kantor\n'),
(175, 'RT1.1', 'Pemeliharaan  Gedung  dan Fasilitas Kantor\n'),
(176, 'RT1.1.1', 'Bangunan  Gedung  dan Lingkungan\n'),
(177, 'RT1.1.2', 'Peralatan  Operasional\n'),
(178, 'RT1.1.3', 'Mekanikal  Elektrikal\n'),
(179, 'RT1.1.4', 'Ketertiban dan keamanan\n'),
(180, 'RT1.1.5', 'Pengelolaan  Parkir\n'),
(181, 'RT2', 'Pengelolaan  Museum\n'),
(182, 'RT2. 1', 'Pendaftaran  Museum\n'),
(183, 'RT2.2', 'Pelindungan  Museum\n'),
(184, 'RT2.3', 'Pengembangan  dan Pemanfaatan  Museum\n'),
(185, 'TI1', 'Sistem  Informasi\n'),
(186, 'TI1. 1', 'Aplikasi\n'),
(187, 'TI1. l . l', 'Aplikasi  Umum\n'),
(188, 'TI1.1.2', 'Aplikasi Khusus\n'),
(189, NULL, NULL),
(190, 'TI1.2', 'Jaringan  Komunikasi\n'),
(191, 'TI1.2.1', 'Jaringan  Internet  dan Ekstranet\n'),
(192, NULL, NULL),
(193, 'TI1.2.2', 'Jaringan Intranet\n'),
(194, 'TI1.2.3', 'Pengelolaan  Sistem  Kolaborasi\n'),
(195, 'TI1.3', 'Basis Data\n'),
(196, 'TI1.3. 1', 'Operasional Basis Data\n'),
(197, 'TI 1.3.2', 'Penyajian  Data\n'),
(198, NULL, NULL),
(199, 'TI1.3.3', 'Sistem  Layanan  Data\n'),
(200, NULL, NULL),
(201, 'TI1.3.4', 'Web  lservice (API)'),
(202, 'TI1.4', 'Server\n'),
(203, 'TI1.4.1', 'Server Fisik\n'),
(204, NULL, NULL),
(205, 'TI1.4.2', 'Server  Virtual\n'),
(206, 'TI2', 'Tata Kelola Teknologi Informasi  dan  Komunikasi  (TIK)\n'),
(207, 'TI2.1', 'Layanan Teknologi  Informasi  dan  Komunikasi\n'),
(208, 'TI2.1.1', 'Perencanaan,     Monitoring     dan     Evaluasi    Layanan Teknologi  Informasi dan  Komunikasi\n'),
(209, 'TI2.1.2', 'Tingkat Layanan Teknologi Informasi dan Komunikasi\n'),
(210, 'TI2.2', 'Keamanan  Informasi\n'),
(211, 'TI2.2.1', 'Pengelolaan  Keamanan  Informasi\n'),
(212, 'TI2.2.2', 'Pengendalian  Keamanan  Informasi\n'),
(213, 'DL1', 'Pendidikan  dan Pelatihan\n'),
(214, 'DL1.1', 'Beasiswa'),
(215, 'DL1.2', 'Sertifikasi Keahlian'),
(216, 'DL1.3', 'Perencanaan Pembelajarari  dan Pengembangan Program'),
(217, 'DL1.4', 'Kurikulum  dan  Silabus\n'),
(218, 'DU.5', 'Tenaga Pengajar\n'),
(219, 'DU.6', 'Penyelenggaraan Pembelajaran\n'),
(220, 'DL1. 7', 'Evaluasi Pembelajaran\n'),
(221, 'DU.8', 'Monitoring  dan Evaluasi Program  Pembelajaran\n'),
(222, 'DU.9', 'Penerbitan  Surat  Keterangan  Pembelajaran\n'),
(223, 'RA1', 'Perencanaan  Anggaran'),
(224, 'RA 1.1', 'Penyusunan  Rencana Program'),
(225, 'RA 1.2', 'Rencana Jangka Panjang  Strategis Mahkamah Agung'),
(226, 'RA1.3', 'Rencana  Kerja Strategis Lima Tahunan  (RENSTRA)\n'),
(227, 'RA l .4', 'Perencanaan  Lintas Kementerian/  Lembaga\n'),
(228, 'RA1.5', 'Rencana  Kerja (RENJA)\n'),
(229, 'RA1.6', 'Usulan  Anggaran'),
(230, 'RA1.7', 'Penyusunan  Anggaran'),
(231, 'RA1.8', 'Revisi  Anggaran'),
(232, 'RA1.9', 'Rencana  Kinerja Tahunan  (RKT)'),
(233, 'RA1.10', 'Perjanjian  Kinerja Tahunan  (PKT)'),
(234, 'KU 1', 'Pelaksanaan  Anggaran  dan  Pertanggungjawaban'),
(235, 'KU l .1', 'Perbendaharaan'),
(236, 'KU 1. 1.1', 'Penetapan  PA,  KPA,  PPK,  Bendahara,  dan  Pengelola Keuangan'),
(237, 'KU 1.1.2', 'Dokumen  Pertanggungjawaban atas beban APBN'),
(238, 'KU1.1.3', 'Laporan  Pembayaran  dan  Pertanggungjawaban atas beban APBN'),
(239, 'KU1.1.4', 'Asistensi Pelaksanaan  Anggaran'),
(240, 'KU 1.1.5', 'Data rekening BUN'),
(241, 'KU l .2', 'Laporan     Perkembangan     Penyelesaian     Kerugian Negara'),
(242, 'KU l .3', 'Pelaksanaan Tuntutan  Ganti Rugi'),
(243, 'KU l .4', 'Penerimaan  Negara Bukan  Pajak'),
(244, 'KU2', 'Pelaporan'),
(245, 'KU2. 1', 'Penyusunan  Laporan  Keuangan'),
(246, 'KU2.2', 'Rekonsiliasi  Laporan  Keuangan'),
(247, 'OT1', 'Organisasi  dan Tatalaksana'),
(248, 'OT1.1', 'Pembentukan / Perubahan/  Penghapusan  Organisasi\nArsip yang  berkaitan dengan kegiatan Mahkamah Agung  berupa pembentukan,  perubahan,  dan penghapusan  organisasi dan  unit kerja di Lingkungan  Mahkamah  Agung  dan  Badan  Peradilan yang Berada di Bawahnya'),
(249, 'OT1.2', 'Tatalaksana/ Mekanisme  Kerja\nArsip yang  berkaitan dengan  tatalaksana Mahkamah Agung  meliputi,  standardisasi /  pembakuan  sistem/ uiork  instruction,  proses  bisnis,  enferpri:se arsitektur.'),
(250, 'OT1.3', 'Analisis Jabatan dan Analisis Beban  Kerja'),
(251, 'OT1.4', 'Evaluasi Jabatan'),
(252, 'OT1.5', 'Peta Jabatan'),
(253, 'OT1.6', 'Kinerja Organisasi'),
(254, 'OT1.7', 'Penilaian    Maturitas    Sistem    Pengendalian    Intern Pemerintah  (SPIP)');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int NOT NULL,
  `kode` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `id_jenis_cuti` int DEFAULT NULL,
  `nip_pegawai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip_atasan_langsung` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `hari_efektif` int DEFAULT NULL,
  `alasan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_cuti` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_surat_cuti` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `kode`, `tgl_pengajuan`, `id_jenis_cuti`, `nip_pegawai`, `nip_atasan_langsung`, `tgl_mulai`, `tgl_akhir`, `hari_efektif`, `alasan`, `alamat_cuti`, `nomor_surat_cuti`) VALUES
(2, 'CTI-0012024', '2024-02-01', 1, '098765', '0987651', '2024-02-01', '2024-02-01', 2, 'dd', 'dd', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_kinds`
--

CREATE TABLE `leave_kinds` (
  `id` int NOT NULL,
  `jenis` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_kinds`
--

INSERT INTO `leave_kinds` (`id`, `jenis`) VALUES
(1, 'Cuti Tahunan'),
(2, 'Cuti Sakit'),
(3, 'Cuti Melahirkan'),
(4, 'Cuti Alasan Penting'),
(5, 'Cuti Besar'),
(6, 'Cuti Diluar Tanggungan Negara');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_level` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `nama_level`) VALUES
(1, 'ketua'),
(2, 'wakil_ketua'),
(3, 'panitera'),
(4, 'sekretaris'),
(5, 'kabag_perencanaan'),
(6, 'kabag_keuangan'),
(7, 'kasubag_renprog'),
(8, 'kasubag_kepegawaian'),
(9, 'kasubag_tu_rt'),
(10, 'kasubag_keuangan'),
(11, 'panmud_perdata'),
(12, 'panmud_pidana'),
(13, 'panmud_hukum'),
(14, 'panmud_tipikor'),
(15, 'admin_renprog'),
(16, 'admin_kepegawaian'),
(17, 'admin_tu_rt'),
(18, 'admin_keuangan'),
(19, 'user'),
(20, 'super_admin');

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_index` int DEFAULT NULL,
  `nomor_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `perihal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tujuan` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penanda_tangan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  `file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `arsip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bagian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2023_01_21_033324_create_user_table', 1),
(3, '2023_01_21_033938_create_units_table', 1),
(4, '2023_01_21_034125_create_positions_table', 1),
(10, '2023_01_22_132036_create_akuns_table', 2),
(12, '2023_01_22_132820_create_levels_table', 3),
(18, '2023_01_21_031918_create_mail_table', 7),
(20, '2023_01_24_124445_create_orderdetails_table', 9),
(21, '2023_01_27_124954_create_fullfills_table', 9),
(22, '2023_01_24_124221_create_orders_table', 10),
(24, '2023_01_28_062607_add_employee_id_table_to_orders_table', 11),
(26, '2023_01_28_064054_create_orderfullfills_table', 12),
(29, '2023_01_28_223340_update_column_order_detail_id_from_orderfullfills', 13),
(30, '2023_01_29_012545_rename_order_details_id_to_fullfills_id_table_orderfullfills', 14),
(31, '2023_06_16_202202_create_goods', 15),
(32, '2023_06_20_201634_add_dipa_column_to_orders_table', 16),
(33, '2023_06_22_134921_drop_column_dipa_for_orders_table', 16),
(34, '2024_01_30_124840_add_penanda_tangan_column_to_mails_table', 17),
(35, '2024_01_30_202651_create_table_ppnpn_assessment', 18),
(36, '2024_02_01_133711_add_is_ppnpn_column_to_position_table', 19),
(37, '2024_02_01_145838_add_potongan_mk_column_to_employees_table', 20);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` int DEFAULT NULL,
  `nama_barang` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_barang` int DEFAULT NULL,
  `satuan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `complete` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderfullfills`
--

CREATE TABLE `orderfullfills` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` int DEFAULT NULL,
  `orderfullfills_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal` date DEFAULT NULL,
  `sign` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_index` int NOT NULL,
  `nomor_pesanan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pesanan` date NOT NULL,
  `unit_id` int NOT NULL,
  `employee_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jabatan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_ppnpn` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `nama_jabatan`, `is_ppnpn`) VALUES
(1, 'Ketua', NULL),
(2, 'Wakil Ketua', NULL),
(3, 'Panitera', NULL),
(4, 'Sekretaris', NULL),
(5, 'Hakim', NULL),
(6, 'Kabag Perencanaan dan Kepegawaian', NULL),
(7, 'Kabag Umum dan Keuangan', NULL),
(8, 'Kasubag Rencana Program dan Anggaran', NULL),
(9, 'Kasubag Kepegawaian dan Teknologi Informasi', NULL),
(10, 'Kasubag Tata Usaha dan Rumah Tangga', NULL),
(11, 'Kasubag Keuangan dan Pelaporan', NULL),
(12, 'Panitera Muda Pidana', NULL),
(13, 'Panitera Muda Perdata', NULL),
(14, 'Panitera Muda Hukum', NULL),
(15, 'Panitera Muda Tipikor', NULL),
(16, 'Staf Subag Rencana Program dan Anggaran', NULL),
(17, 'Staf Subag Kepegawaian dan Teknologi Informasi', NULL),
(18, 'Staf Subag Tata Usaha dan Rumah Tangga', NULL),
(19, 'Staf Subag Keuangan dan Pelaporan', NULL),
(20, 'Staf Kepaniteraan Muda Pidana', NULL),
(21, 'Staf Kepaniteraan Muda Perdata', NULL),
(22, 'Staf Kepaniteraan Muda Hukum', NULL),
(23, 'Staf Kepaniteraan Muda Tipikor', NULL),
(24, 'Sopir', 'Y'),
(25, 'Pramubakti', 'Y'),
(26, 'Petugas Keamanan', 'Y'),
(27, 'Super Admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int UNSIGNED NOT NULL,
  `tanggal` date DEFAULT NULL,
  `pukul` time DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE `ranks` (
  `id` bigint UNSIGNED NOT NULL,
  `pangkat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golongan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`id`, `pangkat`, `golongan`) VALUES
(1, 'Pengatur', 'II/c'),
(2, 'Pengatur Tk.I', 'II/d'),
(3, 'Penata Muda', 'III/a'),
(4, 'Penata Muda Tk.I', 'III/b'),
(5, 'Penata', 'III/c'),
(6, 'Penata Tk.I', 'III/d'),
(7, 'Pembina', 'IV/a'),
(8, 'Pembina Tk.I', 'IV/b'),
(9, 'Pembina Utama Muda', 'IV/c'),
(10, 'Pembina Utama Madya', 'IV/d'),
(11, 'Pembina Utama', 'IV/e'),
(12, 'Super Admin', 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `ref_jenis_barang`
--

CREATE TABLE `ref_jenis_barang` (
  `id` int UNSIGNED NOT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_jenis_barang`
--

INSERT INTO `ref_jenis_barang` (`id`, `kode`, `uraian`) VALUES
(1, 'A', 'Alat Tulis Kantor'),
(2, 'B', 'Alat Kebersihan'),
(3, 'C', 'Alat Rumah Tangga'),
(4, 'A1', 'TINTA TULIS, TINTA STEMPEL'),
(5, 'A2', 'PENJEPIT KERTAS'),
(6, 'A3', 'PENGHAPUS/KOREKTOR'),
(7, 'A4', 'BUKU TULIS'),
(8, 'A5', 'ORDNER DAN MAP'),
(9, 'A6', 'PENGGARIS'),
(10, 'A7', 'CUTTER (ALAT TULIS KANTOR)'),
(11, 'A8', 'PITA MESIN KETIK'),
(12, 'A9', 'ALAT PEREKAT'),
(14, 'A10', 'STAPLES'),
(15, 'A11', 'ISI STAPLES'),
(16, 'A12', 'ALAT TULIS KANTOR LAINNYA'),
(17, 'A13', 'KERTAS HVS'),
(18, 'A14', 'BERBAGAI KERTAS'),
(19, 'A15', 'AMPLOP'),
(20, 'A16', 'KERTAS DAN COVER LAINNYA'),
(21, 'A17', 'TRANSPARANT SHEET'),
(22, 'A18', 'BAHAN CETAK LAINNYA'),
(23, 'A19', 'TINTA/TONER PRINTER'),
(24, 'A20', 'USB/FLASHDISK'),
(25, 'A21', 'MOUSE'),
(26, 'A22', 'BAHAN KOMPUTER LAINNYA'),
(27, 'B1', 'SAPU DAN SIKAT'),
(28, 'B2', 'ALAT-ALAT PEL DAN LAP'),
(29, 'B3', 'EMBER, SLANG, DAN TEMPAT AIR LAINNYA'),
(30, 'B4', 'ALAT PENGIKAT'),
(31, 'B5', 'BAHAN KIMIA UNTUK PEMBERSIH'),
(32, 'B6', 'PENGHARUM RUANGAN'),
(33, 'B7', 'KUAS'),
(34, 'B8', 'PERABOT KANTOR LAINNYA'),
(35, 'C1', 'KABEL LISTRIK'),
(36, 'C2', 'BATU BATERAI'),
(37, 'A23', 'STEMPEL'),
(38, 'C3', 'PERLENGKAPAN PENUNJANG KEGIATAN KANTOR LAINNYA'),
(39, 'B9', 'OBAT CAIR (BARANG KONSUMSI)'),
(40, 'B10', 'OBAT LAINNYA (BARANG KONSUMSI)'),
(41, 'C4', 'ALAT/BAHAN UNTUK KEGIATAN KANTOR LAINNYA'),
(42, 'A', 'kabel ties');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `gaji` int DEFAULT NULL,
  `uang_makan` int DEFAULT NULL,
  `remunerasi` int DEFAULT NULL,
  `iuran_koperasi` int DEFAULT NULL,
  `potongan_koperasi` int DEFAULT NULL,
  `potongan_bri` int DEFAULT NULL,
  `potongan_bpd` int DEFAULT NULL,
  `potongan_ptwp` int DEFAULT NULL,
  `bea_siswa` int DEFAULT NULL,
  `ipaspi` int DEFAULT NULL,
  `iuran_korpri` int DEFAULT NULL,
  `dana_sosial` int DEFAULT NULL,
  `simp_sukarela` int DEFAULT NULL,
  `dana_punia` int DEFAULT NULL,
  `yusti_karini` int DEFAULT NULL,
  `sp_koperasi` int DEFAULT NULL,
  `ydsh_ikahi` int DEFAULT NULL,
  `lain_lain` int DEFAULT NULL,
  `potongan_bank_gaji` int DEFAULT NULL,
  `potongan_bank_remun` int DEFAULT NULL,
  `bulan` int DEFAULT NULL,
  `tahun` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `saldo_cuti`
--

CREATE TABLE `saldo_cuti` (
  `id` bigint UNSIGNED NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saldo_cuti_tahun_ini` int DEFAULT NULL,
  `sisa_cuti_tahun_lalu` int DEFAULT NULL,
  `penangguhan_tahun_lalu` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saldo_cuti`
--

INSERT INTO `saldo_cuti` (`id`, `nip`, `tahun`, `saldo_cuti_tahun_ini`, `sisa_cuti_tahun_lalu`, `penangguhan_tahun_lalu`) VALUES
(1, '098765', '2024', 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `setuju_cuti`
--

CREATE TABLE `setuju_cuti` (
  `id` int NOT NULL,
  `id_cuti` int DEFAULT NULL,
  `acc_ats` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `timestamp_acc_ats` datetime DEFAULT NULL,
  `acc_kpn` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `timestamp_acc_kpn` datetime DEFAULT NULL,
  `reject_ats` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reject_kpn` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alasan_reject` text COLLATE utf8mb4_general_ci,
  `ditangguhkan_ats` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ditangguhkan_kpn` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alasan_ditangguhkan` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setuju_cuti`
--

INSERT INTO `setuju_cuti` (`id`, `id_cuti`, `acc_ats`, `timestamp_acc_ats`, `acc_kpn`, `timestamp_acc_kpn`, `reject_ats`, `reject_kpn`, `alasan_reject`, `ditangguhkan_ats`, `ditangguhkan_kpn`, `alasan_ditangguhkan`) VALUES
(1, 2, 'OK', '2024-02-01 15:50:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sisa_cuti`
--

CREATE TABLE `sisa_cuti` (
  `id` int NOT NULL,
  `nama_pegawai` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun` varchar(4) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sisa_cuti` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_keputusan`
--

CREATE TABLE `surat_keputusan` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_index` int DEFAULT NULL,
  `nomor_sk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_sk` date DEFAULT NULL,
  `tentang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_ppnpn_assessment`
--

CREATE TABLE `table_ppnpn_assessment` (
  `id` bigint UNSIGNED NOT NULL,
  `ppnpn_id` int NOT NULL,
  `bulan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `integritas` int NOT NULL,
  `kedisiplinan` int NOT NULL,
  `kerjasama` int NOT NULL,
  `komunikasi` int NOT NULL,
  `pelayanan` int NOT NULL,
  `jumlah_kehadiran` int DEFAULT NULL,
  `jumlah_hari_kerja` int DEFAULT NULL,
  `penilai_id` int DEFAULT NULL,
  `evaluasi` text COLLATE utf8mb4_unicode_ci,
  `is_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_surat`
--

CREATE TABLE `template_surat` (
  `id` int UNSIGNED NOT NULL,
  `nama_template` varchar(50) DEFAULT NULL,
  `keterangan` text,
  `file` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template_surat`
--

INSERT INTO `template_surat` (`id`, `nama_template`, `keterangan`, `file`) VALUES
(1, 'KOP SURAT PN NEGARA', 'Kop Surat', 'KOP SURAT PN NEGARA-1692758562.docx'),
(2, 'Naskah Dinas Korespondensi Eksternal', 'Surat keluar instansi', 'Naskah Dinas Korespondensi Eksternal-1695092625.docx');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_unit` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `nama_unit`) VALUES
(1, 'Ketua'),
(2, 'Wakil Ketua'),
(3, 'Panitera'),
(4, 'Sekretaris'),
(5, 'Hakim'),
(6, 'Bagian Perencanaan dan Kepegawaian'),
(7, 'Bagian Umum dan Keuangan'),
(8, 'SubBagian Rencana Program dan Anggaran'),
(9, 'SubBagian Kepegawaian dan Teknologi Informasi'),
(10, 'SubBagian Tata Usaha dan Rumah Tangga'),
(11, 'SubBagian Keuangan dan Pelaporan'),
(12, 'Kepaniteraan Muda Pidana'),
(13, 'Kepaniteraan Muda Perdata'),
(14, 'Kepaniteraan Muda Hukum'),
(15, 'Kepaniteraan Muda Tipikor'),
(16, 'Super Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuns`
--
ALTER TABLE `akuns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_pegawai`
--
ALTER TABLE `db_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fullfills`
--
ALTER TABLE `fullfills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hari_efektif`
--
ALTER TABLE `hari_efektif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `izin_keluar_kantor`
--
ALTER TABLE `izin_keluar_kantor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klasifikasi_kka`
--
ALTER TABLE `klasifikasi_kka`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_kinds`
--
ALTER TABLE `leave_kinds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderfullfills`
--
ALTER TABLE `orderfullfills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ranks`
--
ALTER TABLE `ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_jenis_barang`
--
ALTER TABLE `ref_jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo_cuti`
--
ALTER TABLE `saldo_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setuju_cuti`
--
ALTER TABLE `setuju_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sisa_cuti`
--
ALTER TABLE `sisa_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_keputusan`
--
ALTER TABLE `surat_keputusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_ppnpn_assessment`
--
ALTER TABLE `table_ppnpn_assessment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_surat`
--
ALTER TABLE `template_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akuns`
--
ALTER TABLE `akuns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `db_pegawai`
--
ALTER TABLE `db_pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `fullfills`
--
ALTER TABLE `fullfills`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `hari_efektif`
--
ALTER TABLE `hari_efektif`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `izin_keluar_kantor`
--
ALTER TABLE `izin_keluar_kantor`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `klasifikasi_kka`
--
ALTER TABLE `klasifikasi_kka`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leave_kinds`
--
ALTER TABLE `leave_kinds`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderfullfills`
--
ALTER TABLE `orderfullfills`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ranks`
--
ALTER TABLE `ranks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ref_jenis_barang`
--
ALTER TABLE `ref_jenis_barang`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saldo_cuti`
--
ALTER TABLE `saldo_cuti`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setuju_cuti`
--
ALTER TABLE `setuju_cuti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sisa_cuti`
--
ALTER TABLE `sisa_cuti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_keputusan`
--
ALTER TABLE `surat_keputusan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_ppnpn_assessment`
--
ALTER TABLE `table_ppnpn_assessment`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_surat`
--
ALTER TABLE `template_surat`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
