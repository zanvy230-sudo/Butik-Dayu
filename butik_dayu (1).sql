-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2026 at 08:09 AM
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
-- Database: `butik_dayu`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamats`
--

CREATE TABLE `alamats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_penerima` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `is_utama` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alamats`
--

INSERT INTO `alamats` (`id`, `user_id`, `nama_penerima`, `telepon`, `alamat_lengkap`, `is_utama`, `created_at`, `updated_at`) VALUES
(1, 1, 'Yapping', '089615263729', 'Jl. UNESU no.99', 1, '2026-09-13 18:58:43', '2026-09-13 18:58:43'),
(2, 2, 'Yaafi', '089519049748', 'Jl.Raflesia No.6,Kec Lowokwaru,Kel Jatimulya,65141', 0, '2026-09-22 18:33:19', '2026-09-22 19:17:07');

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
(4, '2026_09_08_025543_add_phone_to_users_table', 2),
(5, '2026_09_10_000000_create_ulasans_table', 2),
(6, '2026_09_14_013028_add_birth_date_and_gender_to_users_table', 3),
(7, '2026_09_14_014724_create_alamats_table', 4),
(8, '2026_09_15_011642_add_security_fields_to_users_table', 5),
(9, '2026_09_15_020000_create_pesanans_table', 6),
(10, '2026_09_16_000000_add_detail_pemesanan_to_pesanans_table', 7),
(11, '2026_09_17_000000_add_tanggal_sewa_to_pesanans_table', 8),
(12, '2026_09_16_100000_create_pemesanan_rias_table', 9),
(13, '2026_09_17_024514_add_pembayaran_to_pemesanan_rias_table', 10),
(14, '2026_09_18_000000_add_order_group_to_pesanans_table', 11),
(15, '2026_09_19_000000_add_role_to_users_table', 12),
(16, '2026_09_19_143338_add_dibatalkan_status_to_pesanans_table', 13),
(17, '2026_09_19_145727_create_ulasan_produks_table', 14),
(18, '2026_09_19_150536_add_nama_whatsapp_to_ulasan_produks_table', 15),
(19, '2026_09_20_151025_add_nama_whatsapp_foto_to_ulasan_produks_table', 16),
(20, '2026_09_20_154744_create_notifikasis_table', 17),
(21, '2026_09_21_010600_create_produks_table', 18),
(22, '2026_09_22_000000_add_rasio_gambar_to_produks_table', 19),
(23, '2026_09_22_010000_add_fokus_gambar_to_produks_table', 20),
(24, '2026_09_23_100000_add_moderation_to_ulasans_table', 21),
(25, '2026_09_23_110000_create_site_settings_table', 22);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasis`
--

CREATE TABLE `notifikasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'pesanan',
  `url` varchar(255) DEFAULT NULL,
  `dibaca_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasis`
--

INSERT INTO `notifikasis` (`id`, `user_id`, `judul`, `pesan`, `icon`, `url`, `dibaca_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Payas Agung Royal\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:26:35', '2026-09-21 00:29:18'),
(2, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Solo Basahan - Velvet Heritage\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:26:39', '2026-09-21 00:29:18'),
(3, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Solo Basahan - Velvet Heritage\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:26:42', '2026-09-21 00:29:18'),
(4, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Solo Basahan - Velvet Heritage\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:26:54', '2026-09-21 00:29:18'),
(5, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Solo Basahan - Velvet Heritage\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:26:59', '2026-09-21 00:29:18'),
(6, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Solo Basahan - Velvet Heritage\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:27:04', '2026-09-21 00:29:18'),
(7, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Solo Basahan - Velvet Heritage\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:27:07', '2026-09-21 00:29:18'),
(8, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Solo Basahan - Velvet Heritage\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:27:11', '2026-09-21 00:29:18'),
(9, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Solo Basahan - Velvet Heritage\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:27:16', '2026-09-21 00:29:18'),
(10, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Sunda Siger White Elegance\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:27:21', '2026-09-21 00:29:18'),
(11, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Sunda Siger White Elegance\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:27:29', '2026-09-21 00:29:18'),
(12, 1, 'Status Pesanan Diperbarui', 'Pesanan \"Solo Basahan - Velvet Heritage\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 00:29:18', '2026-09-21 00:27:33', '2026-09-21 00:29:18'),
(13, 2, 'Pesanan Berhasil Dibuat', 'Pesanan \"Baju Adat Toraja\" sedang menunggu konfirmasi.', 'pesanan', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 21:56:03', '2026-09-21 21:42:42', '2026-09-21 21:56:03'),
(14, 2, 'pesanan', 'Pesanan Berhasil Dibuat', 'Pesanan Baju Adat Toraja sedang menunggu konfirmasi kami.', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 21:56:03', '2026-09-21 21:42:42', '2026-09-21 21:56:03'),
(15, 2, 'Pesanan Berhasil Dibuat', 'Pesanan \"Baju Adat Toraja\" sedang menunggu konfirmasi.', 'pesanan', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 21:56:03', '2026-09-21 21:44:44', '2026-09-21 21:56:03'),
(16, 2, 'pesanan', 'Pesanan Berhasil Dibuat', 'Pesanan Baju Adat Toraja sedang menunggu konfirmasi kami.', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 21:56:03', '2026-09-21 21:44:44', '2026-09-21 21:56:03'),
(17, 2, 'koleksi', 'Pemesanan Layanan Rias Diterima', 'Pemesanan Paket Akad sedang kami proses.', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 21:56:03', '2026-09-21 21:48:21', '2026-09-21 21:56:03'),
(18, 2, 'koleksi', 'Pemesanan Layanan Rias Diterima', 'Pemesanan Paket Akad sedang kami proses.', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-21 21:56:03', '2026-09-21 21:50:37', '2026-09-21 21:56:03'),
(19, 2, 'Pesanan Berhasil Dibuat', 'Pesanan \"Baju Adat Toraja\" sedang menunggu konfirmasi.', 'pesanan', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-22 18:56:08', '2026-09-22 18:43:19', '2026-09-22 18:56:08'),
(20, 2, 'Pesanan Berhasil Dibuat', 'Pesanan Baju Adat Toraja sedang menunggu konfirmasi kami.', 'pesanan', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-22 18:56:08', '2026-09-22 18:43:19', '2026-09-22 18:56:08'),
(21, 2, 'Status Pesanan Diperbarui', 'Pesanan \"Baju Adat Toraja\" sekarang: Pembayaran Berhasil.', 'pengiriman', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-22 18:56:08', '2026-09-22 18:55:05', '2026-09-22 18:56:08'),
(22, 2, 'Pembayaran Dikonfirmasi', 'Pembayaran untuk pesanan Baju Adat Toraja sudah kami konfirmasi.', 'pengiriman', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-22 18:56:08', '2026-09-22 18:55:05', '2026-09-22 18:56:08'),
(23, 2, 'Status Pesanan Diperbarui', 'Pesanan \"Baju Adat Toraja\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-22 19:18:17', '2026-09-22 19:01:17', '2026-09-22 19:18:17'),
(24, 2, 'Status Pesanan Diperbarui', 'Pesanan \"Baju Adat Toraja\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-22 19:18:17', '2026-09-22 19:01:21', '2026-09-22 19:18:17'),
(25, 2, 'Status Pesanan Diperbarui', 'Pesanan \"Baju Adat Toraja\" sekarang: Dibatalkan.', 'batal', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-22 19:18:17', '2026-09-22 19:01:25', '2026-09-22 19:18:17'),
(26, 2, 'Pemesanan Layanan Rias Diterima', 'Pemesanan Paket Resepsi sedang kami proses.', 'koleksi', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-22 19:18:17', '2026-09-22 19:17:59', '2026-09-22 19:18:17'),
(27, 2, 'Pemesanan Layanan Rias Diterima', 'Pemesanan Paket Resepsi sedang kami proses.', 'koleksi', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', '2026-09-22 19:43:28', '2026-09-22 19:40:08', '2026-09-22 19:43:28'),
(28, 2, 'Pembayaran Dikonfirmasi', 'Pembayaran untuk pemesanan Paket Resepsi sudah kami konfirmasi.', 'koleksi', 'http://127.0.0.1:8000/pengaturan?tab=riwayat', NULL, '2026-09-22 20:35:16', '2026-09-22 20:35:16');

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
-- Table structure for table `pemesanan_rias`
--

CREATE TABLE `pemesanan_rias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `paket_slug` varchar(255) NOT NULL,
  `paket_nama` varchar(255) NOT NULL,
  `paket_harga` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `alamat_acara` text NOT NULL,
  `tanggal_acara` date NOT NULL,
  `jam_acara` time NOT NULL,
  `catatan` text DEFAULT NULL,
  `metode_pembayaran` varchar(255) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'menunggu_konfirmasi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemesanan_rias`
--

INSERT INTO `pemesanan_rias` (`id`, `user_id`, `paket_slug`, `paket_nama`, `paket_harga`, `nama_lengkap`, `telepon`, `alamat_acara`, `tanggal_acara`, `jam_acara`, `catatan`, `metode_pembayaran`, `bukti_transfer`, `status`, `created_at`, `updated_at`) VALUES
(7, 2, 'resepsi', 'Paket Resepsi', 5500000, 'Yaafi', '089519049748', 'Jl.Raflesia No.6,Kec Lowokwaru,Kel Jatimulya,65141', '2026-09-23', '12:12:00', 'Datang jangan sampai telat ya', 'transfer', 'bukti-transfer/ioOw8W5Bm7iCU5usP1CK5a91Zx0y1s1qR4PU1tX4.jpg', 'menunggu_verifikasi', '2026-09-22 19:17:59', '2026-09-22 19:18:12'),
(8, 2, 'resepsi', 'Paket Resepsi', 5500000, 'Yaafi', '089519049748', 'Jl.Raflesia No.6,Kec Lowokwaru,Kel Jatimulya,65141', '2026-09-23', '12:00:00', NULL, 'transfer', 'bukti-transfer/iU6XLo0mknQ0Teb1o4727wQ1uZzDDraoRbKHgUAw.png', 'dikonfirmasi', '2026-09-22 19:40:08', '2026-09-22 20:35:16');

-- --------------------------------------------------------

--
-- Table structure for table `pesanans`
--

CREATE TABLE `pesanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_group` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `produk_slug` varchar(255) DEFAULT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `gambar_produk` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `nama_penerima` varchar(255) DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `tanggal_sewa_mulai` date DEFAULT NULL,
  `tanggal_sewa_selesai` date DEFAULT NULL,
  `total_pembayaran` bigint(20) UNSIGNED NOT NULL,
  `metode_pembayaran` enum('transfer','cod') NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status` enum('menunggu_konfirmasi','pembayaran_berhasil','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu_konfirmasi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanans`
--

INSERT INTO `pesanans` (`id`, `order_group`, `user_id`, `produk_slug`, `nama_produk`, `gambar_produk`, `size`, `color`, `nama_penerima`, `telepon`, `alamat_lengkap`, `tanggal_sewa_mulai`, `tanggal_sewa_selesai`, `total_pembayaran`, `metode_pembayaran`, `bukti_transfer`, `status`, `created_at`, `updated_at`) VALUES
(27, NULL, 2, 'baju-adat-toraja', 'Baju Adat Toraja', '/storage/produk/TOx9imDY8pAxQXva9zMkaU4kmFDlZRkRpqdxK7fo.jpg', 'M', 'Gold', 'Yaafi', '089519049748', 'Jl.Raflesia No.8,Kec Lowokwaru,Kel Jatimulya,65141', '2026-09-23', '2026-09-24', 145000, 'transfer', 'bukti-transfer/vj5IaTUSALh6IL9Bn8vUqor3Ui1roLbnjQp2qgJD.png', 'pembayaran_berhasil', '2026-09-22 18:43:19', '2026-09-22 18:55:05');

-- --------------------------------------------------------

--
-- Table structure for table `produks`
--

CREATE TABLE `produks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori_label` varchar(255) NOT NULL,
  `daerah` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `harga` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `jumlah_ulasan` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `deskripsi` text NOT NULL,
  `catatan_pengerjaan` text NOT NULL,
  `gambar_utama` varchar(255) NOT NULL,
  `gambar_galeri` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`gambar_galeri`)),
  `fokus_gambar` varchar(20) NOT NULL DEFAULT '50% 50%',
  `rasio_gambar` varchar(20) NOT NULL DEFAULT 'portrait',
  `stok_ukuran` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`stok_ukuran`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produks`
--

INSERT INTO `produks` (`id`, `slug`, `nama`, `kategori_label`, `daerah`, `region`, `harga`, `rating`, `jumlah_ulasan`, `deskripsi`, `catatan_pengerjaan`, `gambar_utama`, `gambar_galeri`, `fokus_gambar`, `rasio_gambar`, `stok_ukuran`, `created_at`, `updated_at`) VALUES
(1, 'baju-adat-bodo', 'Baju Adat Bodo', 'Baju Adat Jawa', 'Jawa TImur', 'jawa', 119995, 5, 0, 'Baju adat', '', '/storage/produk/j3VA4SKpVGd7xlJzkfJx5uONd4j2gZNxgPiZEUXx.jpg', '[\"\\/storage\\/produk\\/j3VA4SKpVGd7xlJzkfJx5uONd4j2gZNxgPiZEUXx.jpg\"]', '50% 50%', 'portrait', '{\"S (Anak)\":0,\"M (Anak)\":0,\"S\":1,\"M\":2,\"L\":9,\"XL\":0}', '2026-09-21 17:58:43', '2026-09-21 18:00:25'),
(2, 'baju-adat-toraja', 'Baju Adat Toraja', 'Baju Adat Sulawesi', 'Sulawesi Selatan', 'sulawesi', 120000, 5, 0, 'Baju adat', '', '/storage/produk/TOx9imDY8pAxQXva9zMkaU4kmFDlZRkRpqdxK7fo.jpg', '[\"\\/storage\\/produk\\/TOx9imDY8pAxQXva9zMkaU4kmFDlZRkRpqdxK7fo.jpg\"]', '50% 50%', 'portrait', '{\"S (Anak)\":0,\"M (Anak)\":0,\"S\":2,\"M\":4,\"L\":6,\"XL\":0}', '2026-09-21 21:30:24', '2026-09-21 21:30:24'),
(3, 'solo-basahan', 'Solo Basahan - Velvet Heritage', 'Baju Adat Jawa', 'Jawa Tengah', 'jawa', 12500000, 5, 12, 'Koleksi busana pengantin klasik dengan bahan beludru premium dan sulaman payet emas tangan yang membutuhkan waktu 300 jam pengerjaan. Memberikan kesan agung dan elegan bagi setiap pengantin.', 'Diproses secara manual oleh pengrajin ahli kami untuk menjamin kualitas warisan budaya yang tak lekang oleh waktu.', 'https://images.unsplash.com/photo-1650472185090-a8cfdd9a38d3?fm=jpg&q=80&w=900&auto=format&fit=crop', '[\"https:\\/\\/images.unsplash.com\\/photo-1650472185090-a8cfdd9a38d3?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.3&fp-y=0.6\",\"https:\\/\\/images.unsplash.com\\/photo-1650472185090-a8cfdd9a38d3?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop\"]', '50% 50%', 'portrait', '{\"S (Anak)\":2,\"M (Anak)\":3,\"S\":4,\"M\":6,\"L\":5,\"XL\":2}', '2026-09-22 18:26:17', '2026-09-22 18:26:17'),
(4, 'sunda-siger', 'Sunda Siger White Elegance', 'Baju Adat Jawa Barat', 'Jawa Barat', 'sunda', 8500000, 5, 9, 'Balutan busana putih bernuansa lembut dengan siger emas khas Sunda, dipadukan renda halus untuk kesan anggun dan suci di hari pernikahan Anda.', 'Setiap detail siger dan aksesoris dirangkai tangan oleh pengrajin lokal Jawa Barat.', 'https://images.unsplash.com/photo-1643213222456-ca6c9c6824c2?fm=jpg&q=80&w=900&auto=format&fit=crop', '[\"https:\\/\\/images.unsplash.com\\/photo-1643213222456-ca6c9c6824c2?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.5&fp-y=0.3\",\"https:\\/\\/images.unsplash.com\\/photo-1643213222456-ca6c9c6824c2?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop\"]', '50% 50%', 'portrait', '{\"S (Anak)\":1,\"M (Anak)\":2,\"S\":3,\"M\":5,\"L\":4,\"XL\":0}', '2026-09-22 18:26:17', '2026-09-22 18:26:17'),
(5, 'payas-agung', 'Payas Agung Royal Gold', 'Baju Adat Bali', 'Bali', 'bali', 10200000, 5, 15, 'Busana kebesaran khas Bali dengan mahkota emas berukir detail dan kain songket pilihan, menghadirkan kemegahan prosesi adat Bali yang sakral.', 'Mahkota dan aksesoris diimpor langsung dari pengrajin Bali dan dirawat khusus setiap selesai penyewaan.', 'https://images.unsplash.com/photo-1650377509428-11e7fe8614a9?fm=jpg&q=80&w=900&auto=format&fit=crop', '[\"https:\\/\\/images.unsplash.com\\/photo-1650377509428-11e7fe8614a9?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.5&fp-y=0.2\",\"https:\\/\\/images.unsplash.com\\/photo-1650377509428-11e7fe8614a9?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop\"]', '50% 50%', 'portrait', '{\"S (Anak)\":0,\"M (Anak)\":1,\"S\":2,\"M\":3,\"L\":3,\"XL\":1}', '2026-09-22 18:26:17', '2026-09-22 18:26:17'),
(6, 'minang-suntiang', 'Minang Suntiang Heritage', 'Baju Adat Sumatera', 'Sumatera Barat', 'sumatera', 9800000, 5, 7, 'Suntiang megah bertingkat emas dipadukan busana merah marun bersulam benang emas, mencerminkan kebesaran adat Minangkabau.', 'Suntiang dirakit ulang khusus sesuai ukuran kepala penyewa untuk kenyamanan maksimal seharian.', 'https://images.unsplash.com/photo-1756208978395-874a79e3094c?fm=jpg&q=80&w=900&auto=format&fit=crop', '[\"https:\\/\\/images.unsplash.com\\/photo-1756208978395-874a79e3094c?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.5&fp-y=0.2\",\"https:\\/\\/images.unsplash.com\\/photo-1756208978395-874a79e3094c?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop\"]', '50% 50%', 'portrait', '{\"S (Anak)\":2,\"M (Anak)\":1,\"S\":3,\"M\":4,\"L\":2,\"XL\":3}', '2026-09-22 18:26:17', '2026-09-22 18:26:17'),
(7, 'baju-bodo-modern', 'Modern Baju Bodo Silk', 'Baju Adat Sulawesi', 'Sulawesi Selatan', 'sulawesi', 7500000, 4, 6, 'Baju Bodo klasik Bugis-Makassar dalam siluet modern berbahan sutra lembut, cocok untuk pengantin yang ingin tampil ringan namun tetap sarat makna adat.', 'Dibuat dari sutra pilihan yang dijahit halus agar nyaman dipakai sepanjang acara.', 'https://images.unsplash.com/photo-1667353931393-7cf46f3d0649?fm=jpg&q=80&w=900&auto=format&fit=crop', '[\"https:\\/\\/images.unsplash.com\\/photo-1667353931393-7cf46f3d0649?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.5&fp-y=0.2\",\"https:\\/\\/images.unsplash.com\\/photo-1667353931393-7cf46f3d0649?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop\"]', '50% 50%', 'portrait', '{\"S (Anak)\":3,\"M (Anak)\":2,\"S\":5,\"M\":6,\"L\":4,\"XL\":2}', '2026-09-22 18:26:17', '2026-09-22 18:26:17'),
(8, 'dodotan-klasik', 'Dodotan Klasik Couple', 'Baju Adat Jawa', 'Jawa Tengah / DIY', 'jawa', 13500000, 5, 10, 'Paket dodot klasik untuk pasangan pengantin, dengan motif batik tulis otentik dan tata rias pengantin Yogyakarta yang penuh filosofi.', 'Termasuk sesi fitting bersama pasangan sebelum hari-H untuk memastikan ukuran dan kenyamanan.', 'https://images.unsplash.com/photo-1756209126861-4d240394a587?fm=jpg&q=80&w=900&auto=format&fit=crop', '[\"https:\\/\\/images.unsplash.com\\/photo-1756209126861-4d240394a587?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.5&fp-y=0.2\",\"https:\\/\\/images.unsplash.com\\/photo-1756209126861-4d240394a587?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop\"]', '50% 50%', 'portrait', '{\"S (Anak)\":1,\"M (Anak)\":1,\"S\":2,\"M\":4,\"L\":3,\"XL\":2}', '2026-09-22 18:26:17', '2026-09-22 18:26:17');

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
('sktcYppN1NatYcBSKqoKCEXAYBdE8GydaXqb5wRP', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoicEQ5eG9mMXZVWHFFQ3ROTVFsVVFabDB6dXZlMlpXVkswWE9DVE0xNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wZW5nYXR1cmFuIjtzOjU6InJvdXRlIjtzOjIyOiJhZG1pbi5wZW5nYXR1cmFuLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjY6ImxvY2FsZSI7czoyOiJpZCI7czo0OiJjYXJ0IjthOjM6e3M6MTE6InN1bmRhLXNpZ2VyIjthOjY6e3M6NDoibmFtYSI7czoxODoiS2ViYXlhIFNpZ2VyIFN1bmRhIjtzOjY6ImdhbWJhciI7czo5OToiaHR0cHM6Ly9pbWFnZXMudW5zcGxhc2guY29tL3Bob3RvLTE2NDMyMTMyMjI0NTYtY2E2YzljNjgyNGMyP2ZtPWpwZyZxPTgwJnc9MzAwJmF1dG89Zm9ybWF0JmZpdD1jcm9wIjtzOjQ6InNpemUiO3M6MToiTSI7czo1OiJjb2xvciI7czo1OiJXaGl0ZSI7czo1OiJoYXJnYSI7aTo4NTAwMDAwO3M6MzoicXR5IjtpOjE7fXM6MTE6InBheWFzLWFndW5nIjthOjY6e3M6NDoibmFtYSI7czoxNzoiUGF5YXMgQWd1bmcgUm95YWwiO3M6NjoiZ2FtYmFyIjtzOjk5OiJodHRwczovL2ltYWdlcy51bnNwbGFzaC5jb20vcGhvdG8tMTY1MDM3NzUwOTQyOC0xMWU3ZmU4NjE0YTk/Zm09anBnJnE9ODAmdz0zMDAmYXV0bz1mb3JtYXQmZml0PWNyb3AiO3M6NDoic2l6ZSI7czoyOiJYTCI7czo1OiJjb2xvciI7czo0OiJHb2xkIjtzOjU6ImhhcmdhIjtpOjEwNTAwMDAwO3M6MzoicXR5IjtpOjE7fXM6MTU6Im1pbmFuZy1zdW50aWFuZyI7YTo2OntzOjQ6Im5hbWEiO3M6MTU6Ik1pbmFuZyBTdW50aWFuZyI7czo2OiJnYW1iYXIiO3M6OTk6Imh0dHBzOi8vaW1hZ2VzLnVuc3BsYXNoLmNvbS9waG90by0xNzU2MjA4OTc4Mzk1LTg3NGE3OWUzMDk0Yz9mbT1qcGcmcT04MCZ3PTMwMCZhdXRvPWZvcm1hdCZmaXQ9Y3JvcCI7czo0OiJzaXplIjtzOjE6Ik0iO3M6NToiY29sb3IiO3M6NjoiTWFyb29uIjtzOjU6ImhhcmdhIjtpOjkwMDAwMDA7czozOiJxdHkiO2k6MTt9fX0=', 1790138827);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'hero_judul', 'Tampil Anggun di Hari Istimewa.', '2026-09-22 21:29:58', '2026-09-22 21:29:58'),
(2, 'hero_deskripsi', 'Temukan busana adat dan layanan rias terbaik untuk momen berharga Anda.', '2026-09-22 21:29:58', '2026-09-22 21:29:58'),
(3, 'whatsapp', '089519049748', '2026-09-22 21:29:58', '2026-09-22 21:29:58'),
(4, 'instagram_username', '@rentbydayu', '2026-09-22 21:29:58', '2026-09-22 21:29:58'),
(5, 'instagram', 'https://www.instagram.com/rentbydayu', '2026-09-22 21:29:58', '2026-09-22 21:29:58'),
(6, 'email', 'zanvy.230@gmail.com', '2026-09-22 21:29:58', '2026-09-22 21:29:58'),
(7, 'alamat_toko', NULL, '2026-09-22 21:29:58', '2026-09-22 21:29:58'),
(8, 'jam_operasional', 'Senin - Sabtu, 09.00 - 17.00', '2026-09-22 21:29:58', '2026-09-22 21:29:58'),
(9, 'kebijakan_pembayaran', 'Pembayaran dilakukan sesuai instruksi pada halaman checkout.', '2026-09-22 21:29:58', '2026-09-22 21:29:58'),
(10, 'kebijakan_pemesanan', 'Pastikan data acara dan alamat sudah benar sebelum mengirim pesanan.', '2026-09-22 21:29:58', '2026-09-22 21:29:58');

-- --------------------------------------------------------

--
-- Table structure for table `ulasans`
--

CREATE TABLE `ulasans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `tanggal_acara` date DEFAULT NULL,
  `paket` varchar(255) DEFAULT NULL,
  `ulasan` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'menunggu',
  `ditampilkan` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ulasans`
--

INSERT INTO `ulasans` (`id`, `nama`, `whatsapp`, `tanggal_acara`, `paket`, `ulasan`, `status`, `ditampilkan`, `created_at`, `updated_at`) VALUES
(1, 'yaafi', '09712345432', '2000-03-23', 'pre-wedding', 'wow', 'disetujui', 1, '2026-09-14 19:48:36', '2026-09-22 20:26:16'),
(2, 'yaafi', '09712345432', '2000-03-23', 'pre-wedding', 'wow', 'menunggu', 0, '2026-09-14 19:48:36', '2026-09-14 19:48:36');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan_produks`
--

CREATE TABLE `ulasan_produks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `produk_slug` varchar(255) NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `komentar` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ulasan_produks`
--

INSERT INTO `ulasan_produks` (`id`, `user_id`, `nama`, `whatsapp`, `produk_slug`, `rating`, `komentar`, `foto`, `created_at`, `updated_at`) VALUES
(1, 1, 'Yaafi', '089519049748', 'solo-basahan', 5, 'produknya bagus', NULL, '2026-09-20 07:54:15', '2026-09-20 07:54:15'),
(2, 1, 'yapping', '089519049748', 'solo-basahan', 5, 'wow', 'ulasan-produk/OwnRSfYP09siYGuOIvuyablqkLw02jRi8lgUKHc9.png', '2026-09-20 08:11:10', '2026-09-20 08:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `phone` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `birth_date`, `gender`, `email_verified_at`, `password`, `password_changed_at`, `two_factor_enabled`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Yaafi', 'myaafi32@gmail.com', 'user', '089519049748', '2000-05-24', 'laki-laki', NULL, '$2y$12$L6aR4FuWOBbRZLYjQcT5XOgSYvEYgSQzps/sTb3O9xFX8.QR/L2DG', '2026-09-14 18:36:35', 0, NULL, '2026-09-07 19:58:02', '2026-09-14 18:39:57'),
(2, 'Fauzan', 'zanvy.230@gmail.com', 'admin', '089519049748', NULL, NULL, NULL, '$2y$12$vwV4unoGo9RYWtoQbo7kSOXrmlEETFU9xOY/xBmH2K/O0CI4uf0UG', '2026-09-19 06:24:14', 0, NULL, '2026-09-19 06:23:30', '2026-09-19 06:24:48'),
(3, 'Test User', 'test@example.com', 'user', NULL, NULL, NULL, '2026-09-22 18:26:16', '$2y$12$yPcJlb25/KYnA2Vi0wmQ4u7pNpScdMxf.CkwbVl5HhB0uDgAk/Bha', NULL, 0, 'BuXmqKSIlA', '2026-09-22 18:26:16', '2026-09-22 18:26:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamats`
--
ALTER TABLE `alamats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alamats_user_id_foreign` (`user_id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasis_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pemesanan_rias`
--
ALTER TABLE `pemesanan_rias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemesanan_rias_user_id_foreign` (`user_id`);

--
-- Indexes for table `pesanans`
--
ALTER TABLE `pesanans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanans_user_id_foreign` (`user_id`);

--
-- Indexes for table `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `produks_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Indexes for table `ulasans`
--
ALTER TABLE `ulasans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ulasan_produks`
--
ALTER TABLE `ulasan_produks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ulasan_produks_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT for table `alamats`
--
ALTER TABLE `alamats`
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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pemesanan_rias`
--
ALTER TABLE `pemesanan_rias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pesanans`
--
ALTER TABLE `pesanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `produks`
--
ALTER TABLE `produks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ulasans`
--
ALTER TABLE `ulasans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ulasan_produks`
--
ALTER TABLE `ulasan_produks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alamats`
--
ALTER TABLE `alamats`
  ADD CONSTRAINT `alamats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pemesanan_rias`
--
ALTER TABLE `pemesanan_rias`
  ADD CONSTRAINT `pemesanan_rias_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pesanans`
--
ALTER TABLE `pesanans`
  ADD CONSTRAINT `pesanans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ulasan_produks`
--
ALTER TABLE `ulasan_produks`
  ADD CONSTRAINT `ulasan_produks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
