-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2026 at 07:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_renang`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `before` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`before`)),
  `after` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`after`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `deadline_pendaftaran` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `nama_event`, `lokasi`, `tanggal_mulai`, `tanggal_selesai`, `deadline_pendaftaran`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Kejuaraan Renang Daerah 2026', 'Kolam Renang Stadion Utama', '2026-10-15', '2026-10-17', '2026-10-10 23:59:59', 1, '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(2, 'kasri cup', 'udinus', '2026-10-02', '2026-10-03', '2026-09-30 15:05:00', 1, '2026-09-23 01:08:07', '2026-09-23 01:09:41');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelompok_umur`
--

CREATE TABLE `kelompok_umur` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `nama_ku` varchar(255) NOT NULL,
  `usia_min` tinyint(3) UNSIGNED DEFAULT NULL,
  `usia_max` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelompok_umur`
--

INSERT INTO `kelompok_umur` (`id`, `event_id`, `nama_ku`, `usia_min`, `usia_max`, `created_at`, `updated_at`) VALUES
(1, 1, 'KU I', 8, 10, '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(2, 1, 'KU II', 11, 12, '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(3, 1, 'KU III', 13, 14, '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(4, 1, 'Senior', 15, NULL, '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(5, 2, 'KU 1', 10, 17, '2026-09-23 01:08:07', '2026-09-23 01:08:07');

-- --------------------------------------------------------

--
-- Table structure for table `master_riwayat_atlet`
--

CREATE TABLE `master_riwayat_atlet` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_atlet` varchar(255) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('putra','putri') NOT NULL,
  `jarak` smallint(5) UNSIGNED NOT NULL,
  `gaya` enum('bebas','dada','punggung','kupu','ganti_perorangan','ganti_estafet') NOT NULL,
  `limit_waktu` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_riwayat_atlet`
--

INSERT INTO `master_riwayat_atlet` (`id`, `user_id`, `nama_atlet`, `tanggal_lahir`, `jenis_kelamin`, `jarak`, `gaya`, `limit_waktu`, `created_at`, `updated_at`) VALUES
(1, 2, 'RADEN AJENG ALZENA GANNYKA ADZRA', '2015-09-09', 'putra', 50, 'bebas', '00:30.20', '2026-09-30 01:04:29', '2026-09-30 01:04:29'),
(2, 2, 'RADEN AJENG ALZENA GANNYKA ADZRA', '2015-09-09', 'putra', 50, 'dada', '00:55.21', '2026-09-30 01:04:29', '2026-09-30 01:04:29'),
(3, 2, 'RADEN ALZAREN GANNYKA SANUM', '2016-05-05', 'putra', 25, 'bebas', '00:21.22', '2026-09-30 01:04:29', '2026-09-30 01:04:29'),
(4, 2, 'RADEN ALZAREN GANNYKA SANUM', '2016-05-05', 'putra', 25, 'dada', '00:29.23', '2026-09-30 01:04:29', '2026-09-30 01:04:29'),
(5, 2, 'DAMAR JUANG IBRAHIM', '2018-07-07', 'putri', 50, 'bebas', '00:35.00', '2026-09-30 01:04:29', '2026-09-30 01:04:29'),
(6, 2, 'DAMAR JUANG IBRAHIM', '2018-07-07', 'putri', 25, 'bebas', '00:23.09', '2026-09-30 01:04:29', '2026-09-30 01:04:29'),
(7, 2, 'RADEN AJENG ALZENA GANNYKA ADZRA', '2015-09-09', 'putri', 100, 'bebas', 'NT', '2026-10-06 20:34:28', '2026-10-07 00:03:52'),
(8, 3, 'Agus Setiawan', '2010-02-09', 'putra', 50, 'bebas', '00:29.49', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(9, 3, 'Rina Marlina', '2007-08-21', 'putri', 50, 'dada', '00:38.27', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(10, 3, 'Bayu Nugroho', '2004-08-01', 'putra', 100, 'punggung', '01:13.99', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(11, 3, 'Putri Anggraini', '2010-01-23', 'putri', 100, 'kupu', '01:11.26', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(12, 3, 'Fajar Ramadhan', '2010-04-19', 'putra', 100, 'ganti_perorangan', '01:07.76', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(13, 3, 'Nadia Safitri', '2004-01-01', 'putri', 50, 'ganti_estafet', '00:33.00', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(14, 3, 'Dimas Prasetyo', '2007-11-07', 'putra', 200, 'bebas', '02:11.87', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(15, 3, 'Melati Kusuma', '2008-04-25', 'putri', 100, 'dada', '01:26.70', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(16, 3, 'Rizky Hidayat', '2008-04-12', 'putra', 100, 'punggung', '01:16.42', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(17, 3, 'Ayu Wulandari', '2010-08-10', 'putri', 50, 'kupu', '00:35.05', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(18, 3, 'Hendra Gunawan', '2008-11-04', 'putra', 50, 'ganti_perorangan', '00:32.68', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(19, 3, 'Sari Puspita', '2009-05-04', 'putri', 50, 'ganti_estafet', '00:31.09', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(20, 3, 'Eko Saputra', '2009-09-14', 'putra', 200, 'punggung', '02:38.48', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(21, 3, 'Tiara Maharani', '2006-10-16', 'putri', 200, 'ganti_estafet', '02:06.04', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(22, 3, 'Yoga Permana', '2004-08-08', 'putra', 200, 'kupu', '02:23.19', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(23, 3, 'Intan Permatasari', '2005-06-18', 'putri', 200, 'kupu', '02:28.49', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(24, 3, 'Galih Firmansyah', '2004-08-22', 'putra', 200, 'ganti_estafet', '02:12.74', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(25, 3, 'Citra Dewanti', '2008-07-12', 'putri', 200, 'bebas', '02:30.20', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(26, 3, 'Wahyu Hartono', '2004-05-23', 'putra', 100, 'ganti_estafet', '00:53.52', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(27, 3, 'Laras Ningrum', '2009-03-06', 'putri', 200, 'ganti_perorangan', '02:44.90', '2026-10-06 23:54:59', '2026-10-06 23:54:59'),
(28, 2, 'Arif Rahman', '2006-03-24', 'putra', 50, 'bebas', '00:26.27', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(29, 2, 'Salsabila Putri', '2006-10-07', 'putri', 200, 'dada', '03:06.60', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(30, 2, 'Teguh Wibowo', '2009-03-14', 'putra', 200, 'punggung', '02:09.46', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(31, 2, 'Anisa Rahmawati', '2009-09-12', 'putri', 200, 'kupu', '02:27.76', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(32, 2, 'Reza Pahlevi', '2008-05-02', 'putra', 200, 'ganti_perorangan', '02:45.16', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(33, 2, 'Maya Sari', '2006-07-14', 'putri', 50, 'ganti_estafet', '00:29.23', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(34, 2, 'Doni Kurniawan', '2005-04-08', 'putra', 200, 'bebas', '02:00.42', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(35, 2, 'Lestari Handayani', '2005-03-17', 'putri', 50, 'dada', '00:35.43', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(36, 2, 'Iqbal Maulana', '2008-11-18', 'putra', 200, 'punggung', '02:20.39', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(37, 2, 'Fitri Ayuningtyas', '2007-07-24', 'putri', 50, 'kupu', '00:37.55', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(38, 2, 'Ilham Syahputra', '2010-06-26', 'putra', 200, 'ganti_perorangan', '02:44.14', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(39, 2, 'Wulan Cahyani', '2010-08-06', 'putri', 200, 'ganti_estafet', '02:11.22', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(40, 2, 'Bagas Mahendra', '2009-09-08', 'putra', 100, 'ganti_estafet', '01:03.43', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(41, 2, 'Nabila Azzahra', '2008-09-27', 'putri', 100, 'punggung', '01:22.28', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(42, 2, 'Satria Utama', '2007-06-19', 'putra', 100, 'ganti_estafet', '01:05.44', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(43, 2, 'Kirana Dewi', '2007-11-08', 'putri', 200, 'ganti_perorangan', '02:50.39', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(44, 2, 'Farhan Alfarizi', '2008-05-25', 'putra', 100, 'ganti_estafet', '01:04.77', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(45, 2, 'Dinda Permata', '2010-12-27', 'putri', 100, 'punggung', '01:11.46', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(46, 2, 'Surya Atmaja', '2009-10-19', 'putra', 200, 'ganti_perorangan', '02:30.58', '2026-10-06 23:55:42', '2026-10-06 23:55:42'),
(47, 2, 'Rahma Yulianti', '2007-09-12', 'putri', 100, 'punggung', '01:18.91', '2026-10-06 23:55:42', '2026-10-06 23:55:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_22_000001_create_events_table', 1),
(5, '2026_09_22_000002_create_kelompok_umur_table', 1),
(6, '2026_09_22_000003_create_nomor_lomba_table', 1),
(7, '2026_09_22_000004_create_master_riwayat_atlet_table', 1),
(8, '2026_09_22_000005_create_pendaftaran_table', 1),
(9, '2026_09_22_000006_create_audit_logs_table', 1),
(10, '2026_09_22_054620_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nomor_lomba`
--

CREATE TABLE `nomor_lomba` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelompok_umur_id` bigint(20) UNSIGNED NOT NULL,
  `nama_nomor` varchar(255) NOT NULL,
  `jarak` smallint(5) UNSIGNED NOT NULL,
  `gaya` enum('bebas','dada','punggung','kupu','ganti_perorangan','ganti_estafet') NOT NULL,
  `jenis_kelamin` enum('putra','putri','campuran') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nomor_lomba`
--

INSERT INTO `nomor_lomba` (`id`, `kelompok_umur_id`, `nama_nomor`, `jarak`, `gaya`, `jenis_kelamin`, `created_at`, `updated_at`) VALUES
(1, 1, '50m Gaya Bebas Putra', 50, 'bebas', 'putra', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(2, 1, '50m Gaya Bebas Putri', 50, 'bebas', 'putri', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(3, 1, '50m Gaya Dada Putra', 50, 'dada', 'putra', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(4, 1, '50m Gaya Dada Putri', 50, 'dada', 'putri', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(5, 2, '100m Gaya Bebas Putra', 100, 'bebas', 'putra', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(6, 2, '100m Gaya Bebas Putri', 100, 'bebas', 'putri', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(7, 2, '100m Gaya Punggung Putra', 100, 'punggung', 'putra', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(8, 2, '100m Gaya Punggung Putri', 100, 'punggung', 'putri', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(9, 3, '200m Gaya Bebas Putra', 200, 'bebas', 'putra', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(10, 3, '200m Gaya Bebas Putri', 200, 'bebas', 'putri', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(11, 3, '100m Gaya Kupu Putra', 100, 'kupu', 'putra', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(12, 3, '100m Gaya Kupu Putri', 100, 'kupu', 'putri', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(13, 4, '400m Gaya Bebas Putra', 400, 'bebas', 'putra', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(14, 4, '400m Gaya Bebas Putri', 400, 'bebas', 'putri', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(15, 4, '200m Gaya Ganti Putra', 200, 'ganti_perorangan', 'putra', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(16, 4, '200m Gaya Ganti Putri', 200, 'ganti_perorangan', 'putri', '2026-09-23 00:48:19', '2026-09-23 00:48:19'),
(17, 5, '001', 100, 'punggung', 'putra', '2026-09-23 01:09:41', '2026-09-23 01:09:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kelompok_umur_id` bigint(20) UNSIGNED NOT NULL,
  `nomor_lomba_id` bigint(20) UNSIGNED NOT NULL,
  `nama_atlet` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('putra','putri') NOT NULL,
  `limit_waktu` varchar(255) DEFAULT NULL,
  `status_waktu` enum('normal','NT') NOT NULL DEFAULT 'NT',
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `event_id`, `user_id`, `kelompok_umur_id`, `nomor_lomba_id`, `nama_atlet`, `tanggal_lahir`, `jenis_kelamin`, `limit_waktu`, `status_waktu`, `is_locked`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 5, 17, 'con', '2016-09-09', 'putra', '00:00.90', 'normal', 0, '2026-09-29 22:29:42', '2026-09-29 22:29:42'),
(2, 1, 3, 2, 5, 'blpojj', '2015-09-09', 'putra', '00:23.00', 'normal', 0, '2026-09-29 22:32:34', '2026-09-29 22:32:34'),
(3, 1, 3, 2, 7, 'blpojj', '2015-09-09', 'putra', NULL, 'NT', 0, '2026-09-29 22:32:34', '2026-09-29 22:32:34'),
(4, 1, 2, 2, 5, 'RADEN AJENG ALZENA GANNYKA ADZRA', '2015-09-09', 'putri', NULL, 'NT', 0, '2026-09-30 01:35:01', '2026-10-07 00:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Q0rN7tpCL0KLkbtSBrcMlGp4OYkmBK9CZW06CCVt', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Avast/152.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZXBqaXJtNlQzRDhCTEVWcHB4UHBXTVpXMkpVQWY1dU4zcmpPYmtOSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9pbXBvcnQvcml3YXlhdCI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4uaW1wb3J0LmZvcm0iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1791356685),
('uLAcs0dGcdijRb6DDpDMzNCn1WilvdmCpLr5FUC4', 2, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 17; M2012K11G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.8059.39 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic041bzJvR01FekdOMVRUNDh4eUppMlBFd2Ewb1UxUlpMbkZyUkVIayI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2V2ZW50cyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcGVya3VtcHVsYW4vcmVrYXAiO3M6NToicm91dGUiO3M6MTc6InBlcmt1bXB1bGFuLnJla2FwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1791362941);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','perkumpulan') NOT NULL DEFAULT 'perkumpulan',
  `nama_klub` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `nama_klub`, `whatsapp`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@renang.test', NULL, '$2y$12$83Bs0zp2tbqdHUylcRXlL.rC5z6BF9gpKrxrRL.5HyE6/D/1E.W.i', 'admin', NULL, NULL, 1, NULL, '2026-09-23 00:48:18', '2026-09-23 00:48:18'),
(2, 'Klub Harapan', 'harapan@renang.test', NULL, '$2y$12$N5jmr5PgfswvSz0MHC39..HmZTPZqfO3Lxlb97/k0Lq5dimaa2EJm', 'perkumpulan', 'Perkumpulan Renang Harapan', '081234567890', 1, NULL, '2026-09-23 00:48:18', '2026-09-23 00:48:18'),
(3, 'Klub Garuda', 'garuda@renang.test', NULL, '$2y$12$QCCL1jSwkY4A6fhDZH6shuP9iP1Za8gEcgyBZFVyc4aMrsvErTLM6', 'perkumpulan', 'Perkumpulan Renang Garuda', '082345678901', 1, NULL, '2026-09-23 00:48:19', '2026-09-23 00:48:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`),
  ADD KEY `audit_logs_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelompok_umur`
--
ALTER TABLE `kelompok_umur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelompok_umur_event_id_foreign` (`event_id`);

--
-- Indexes for table `master_riwayat_atlet`
--
ALTER TABLE `master_riwayat_atlet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `master_riwayat_atlet_user_id_foreign` (`user_id`),
  ADD KEY `master_riwayat_atlet_nama_atlet_user_id_index` (`nama_atlet`,`user_id`),
  ADD KEY `master_riwayat_atlet_nama_atlet_jarak_gaya_user_id_index` (`nama_atlet`,`jarak`,`gaya`,`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `nomor_lomba`
--
ALTER TABLE `nomor_lomba`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomor_lomba_kelompok_umur_id_foreign` (`kelompok_umur_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pendaftaran_event_id_nomor_lomba_id_nama_atlet_unique` (`event_id`,`nomor_lomba_id`,`nama_atlet`),
  ADD KEY `pendaftaran_user_id_foreign` (`user_id`),
  ADD KEY `pendaftaran_kelompok_umur_id_foreign` (`kelompok_umur_id`),
  ADD KEY `pendaftaran_nomor_lomba_id_foreign` (`nomor_lomba_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelompok_umur`
--
ALTER TABLE `kelompok_umur`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `master_riwayat_atlet`
--
ALTER TABLE `master_riwayat_atlet`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nomor_lomba`
--
ALTER TABLE `nomor_lomba`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `kelompok_umur`
--
ALTER TABLE `kelompok_umur`
  ADD CONSTRAINT `kelompok_umur_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `master_riwayat_atlet`
--
ALTER TABLE `master_riwayat_atlet`
  ADD CONSTRAINT `master_riwayat_atlet_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nomor_lomba`
--
ALTER TABLE `nomor_lomba`
  ADD CONSTRAINT `nomor_lomba_kelompok_umur_id_foreign` FOREIGN KEY (`kelompok_umur_id`) REFERENCES `kelompok_umur` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_kelompok_umur_id_foreign` FOREIGN KEY (`kelompok_umur_id`) REFERENCES `kelompok_umur` (`id`),
  ADD CONSTRAINT `pendaftaran_nomor_lomba_id_foreign` FOREIGN KEY (`nomor_lomba_id`) REFERENCES `nomor_lomba` (`id`),
  ADD CONSTRAINT `pendaftaran_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
