-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 10, 2021 at 05:24 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nota_thermal`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga_barang` int(11) NOT NULL,
  `id_category_barang` int(11) UNSIGNED NOT NULL,
  `stok_barang` int(11) NOT NULL,
  `deskripsi_barang` text NOT NULL,
  `foto_barang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `harga_barang`, `id_category_barang`, `stok_barang`, `deskripsi_barang`, `foto_barang`, `created_at`, `updated_at`) VALUES
(37, 'Mouse', 50000, 5, 5, 'Mouse Sades Biru', '15_14_57_Gunblade-1.jpg', '2021-12-08 08:14:57', '2021-12-08 08:14:57'),
(38, 'RAM Laptop Hynix DDR3 PC3 10600 1GB / Memory Memori', 35, 1, 5, 'Merk: Hynix\nChip: Hynix\nManufacture: Hynix\nKapasitas: 1GB\nDDR3 PC3-10600\nJenis: RAM LAPTOP\n*copotan / bawaan Laptop', '15_18_20_Ram.jpg', '2021-12-08 08:18:20', '2021-12-08 08:18:20'),
(46, 'Baterai CMOS BIOS Laptop Notebook CR2032 Soket Kabel 3V Volt 2 pin', 11800, 1, 30, 'Baterai battery CMOS Laptop Notebook CR 2032\nSocket Kabel 2 Pin Ukuran 3 Volt', '16_32_33_cmos.jpg', '2021-12-08 09:32:33', '2021-12-08 09:32:33'),
(47, 'Jaket Hoodie Silas Navy Preloved - Thrift - Second - Murah', 45000, 4, 1, 'Brand Silas\nSize L / P 67 X LD 100\nGood Condition\nPrice 75K', '10_35_2_jaket.jpg', '2021-12-10 03:35:02', '2021-12-10 03:35:02');

-- --------------------------------------------------------

--
-- Table structure for table `category_barang`
--

CREATE TABLE `category_barang` (
  `id_category` int(11) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_barang`
--

INSERT INTO `category_barang` (`id_category`, `category`) VALUES
(1, 'SparePart Laptop'),
(2, 'SparePart Computer'),
(3, 'Laptop Second'),
(4, 'Baju Thrift - Preloved'),
(5, 'Aksesoris Komputer Laptop'),
(6, 'Paket Rakit Komputer'),
(7, 'Pelatihan Training'),
(8, 'Gaming'),
(9, 'Printer Percetakan'),
(10, 'Jaringan');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transactions`
--

CREATE TABLE `detail_transactions` (
  `id` int(10) NOT NULL,
  `id_transaction` int(10) UNSIGNED NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banyak_barang` int(11) NOT NULL,
  `harga_barang` float NOT NULL,
  `total_harga_barang` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_transactions`
--

INSERT INTO `detail_transactions` (`id`, `id_transaction`, `nama_barang`, `banyak_barang`, `harga_barang`, `total_harga_barang`, `created_at`, `updated_at`) VALUES
(74, 65, 'Mouse', 1, 1, 1, '2021-11-29 11:03:31', '2021-11-29 11:03:31'),
(75, 66, 'Keyboard', 1, 1, 1, '2021-11-29 11:03:48', '2021-11-29 11:03:48'),
(76, 67, 'Mouse', 1, 1, 1, '2021-11-29 11:04:07', '2021-11-29 11:04:07'),
(77, 68, 'Anjay', 12, 23, 276, '2021-11-29 11:04:26', '2021-11-29 11:04:26'),
(78, 69, 'Mouse', 1, 2000, 2000, '2021-11-30 02:55:58', '2021-11-30 02:55:58'),
(79, 70, 'Keyboard', 1, 20000, 20000, '2021-11-30 02:56:42', '2021-11-30 02:56:42'),
(80, 71, 'Service Laptop', 1, 50000, 50000, '2021-11-30 02:57:09', '2021-11-30 02:57:09'),
(81, 72, 'Service Handphone', 1, 150000, 150000, '2021-11-30 03:17:35', '2021-11-30 03:17:35'),
(82, 73, 'Service Laptop', 1, 50000, 50000, '2021-11-30 03:18:04', '2021-11-30 03:18:04'),
(83, 74, 'Monitor', 1, 100000, 100000, '2021-11-30 03:20:10', '2021-11-30 03:20:10'),
(84, 75, 'Handphone', 1, 50000, 50000, '2021-11-30 03:20:41', '2021-11-30 03:20:41'),
(85, 76, 'Coba1', 2, 5000, 10000, '2021-12-08 09:08:32', '2021-12-08 09:08:32'),
(86, 76, 'Coba2', 2, 5000, 10000, '2021-12-08 09:08:32', '2021-12-08 09:08:32'),
(87, 76, 'Coba3', 5, 5000, 25000, '2021-12-08 09:08:32', '2021-12-08 09:08:32'),
(88, 77, 'Obeng', 1, 5000, 5000, '2021-12-09 08:10:56', '2021-12-09 08:10:56');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_10_20_072359_create_transactions_table', 1),
(6, '2021_10_20_072454_create_detail_transactions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `total_semua` float NOT NULL,
  `uang_bayar` int(11) NOT NULL,
  `uang_kembali` float NOT NULL,
  `nama_pembeli` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembuat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metode_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_tf` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `total_semua`, `uang_bayar`, `uang_kembali`, `nama_pembeli`, `pembuat`, `metode_pembayaran`, `jenis_transaksi`, `bukti_tf`, `created_at`, `updated_at`) VALUES
(65, 1, 12, 11, 'Yusuf', 'Kodehack', 'Cash', 'Pemasukan', '', '2021-11-29 11:03:31', '2021-11-29 11:03:31'),
(66, 1, 2, 1, '2', 'Kodehack', 'Transfer', 'Pemasukan', '18_3_48_radio.jpg', '2021-11-29 11:03:48', '2021-11-29 11:03:48'),
(67, 1, 2, 1, '2', 'Kodehack', 'Cash', 'Pemasukan', '', '2021-11-29 11:04:07', '2021-11-29 11:04:07'),
(68, 276, 323, 47, '23', 'Kodehack', 'Transfer', 'Pemasukan', '18_4_26_komputer.jpg', '2021-11-29 11:04:26', '2021-11-29 11:04:26'),
(69, 2000, 20000, 18000, 'Ok', 'Kodehack', 'Transfer', 'Pemasukan', '9_55_58_komputer.jpg', '2021-11-30 02:55:58', '2021-11-30 02:55:58'),
(70, 20000, 50000, 30000, 'Rendy', 'Kodehack', 'Transfer', 'Pengeluaran', '9_56_42_smartphone.jpg', '2021-11-30 02:56:42', '2021-11-30 02:56:42'),
(71, 50000, 50000, 0, 'Tintin', 'Kodehack', 'Cash', 'Pemasukan', '', '2021-11-30 02:57:09', '2021-11-30 02:57:09'),
(72, 150000, 150000, 0, 'Ucup', 'Kodehack', 'Cash', 'Pemasukan', '', '2021-11-30 03:17:35', '2021-11-30 03:17:35'),
(73, 50000, 50000, 0, 'Kiku', 'Kodehack', 'Transfer', 'Pemasukan', '10_18_4_smartphone.jpg', '2021-11-30 03:18:04', '2021-11-30 03:18:04'),
(74, 100000, 100000, 0, 'Ucup', 'Kodehack', 'Cash', 'Pengeluaran', '', '2021-11-30 03:20:10', '2021-11-30 03:20:10'),
(75, 50000, 100000, 50000, 'Koki', 'Kodehack', 'Cash', 'Pemasukan', '', '2021-11-30 03:20:41', '2021-11-30 03:20:41'),
(76, 45000, 50000, 5000, 'Yusuf', 'Kodehack', 'Cash', 'Pemasukan', '', '2021-12-08 09:08:32', '2021-12-08 09:08:32'),
(77, 5000, 10000, 5000, 'Yusuf', 'Kodehack', 'Cash', 'Pemasukan', '', '2021-12-09 08:10:56', '2021-12-09 08:10:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Kodehack', 'kodehack', 'k0d3h4ck', NULL, NULL),
(5, 'Jago Kodehack', 'jago', 'k0d3h4ck', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category_barang` (`id_category_barang`) USING BTREE;

--
-- Indexes for table `category_barang`
--
ALTER TABLE `category_barang`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `detail_transactions`
--
ALTER TABLE `detail_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transactions_id_transaction_foreign` (`id_transaction`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `category_barang`
--
ALTER TABLE `category_barang`
  MODIFY `id_category` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `detail_transactions`
--
ALTER TABLE `detail_transactions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_category_barang`) REFERENCES `category_barang` (`id_category`);

--
-- Constraints for table `detail_transactions`
--
ALTER TABLE `detail_transactions`
  ADD CONSTRAINT `detail_transactions_id_transaction_foreign` FOREIGN KEY (`id_transaction`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
