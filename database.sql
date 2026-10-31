-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2026 at 07:18 AM
-- Server version: 10.11.16-MariaDB
-- PHP Version: 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sewagame_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `platform_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `condition` enum('bnib','like_new','good') NOT NULL DEFAULT 'good',
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `rent_daily_price` decimal(12,2) NOT NULL,
  `deposit_amount` decimal(12,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `platform_id`, `title`, `cover_image`, `condition`, `stock`, `rent_daily_price`, `deposit_amount`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Marvel\'s Spider-Man 2', 'Marvel\'s Spider-Man 2.jpg', 'bnib', 2, 20000.00, 150000.00, 1, '2026-10-28 22:56:43', '2026-10-30 08:14:41'),
(2, 1, 'God of War Ragnarök', 'God of War Ragnarök.jpg', 'like_new', 2, 15000.00, 10000.00, 1, '2026-10-28 22:56:43', '2026-10-30 08:14:40'),
(3, 2, 'Elden Ring', 'Elden Ring.jpg', 'good', 5, 10000.00, 150000.00, 1, '2026-10-28 22:56:43', '2026-10-30 07:41:35'),
(4, 3, 'The Legend of Zelda: Tears of the Kingdom', 'Zelda-Tears-Of-Kingdom-Hero-1038x576.jpg', 'like_new', 4, 10000.00, 100000.00, 1, '2026-10-28 22:56:43', '2026-10-30 07:37:11'),
(5, 3, 'Super Mario Odyssey', 'Super Mario Odyssey Is Right Around The Corner_ -___.jpg', 'good', 2, 8000.00, 50000.00, 1, '2026-10-28 22:56:43', '2026-10-30 07:37:11'),
(6, 4, 'Forza Horizon 5', 'Forza Horizon 5 Review.jpg', 'like_new', 3, 10000.00, 100000.00, 1, '2026-10-28 22:56:43', '2026-10-30 07:37:11'),
(7, 5, 'Tekken 3 (PS1 Original Disc)', 'tekken3.jpg', 'good', 1, 5000.00, 50000.00, 1, '2026-10-28 22:56:43', '2026-10-30 07:37:11'),
(8, 2, 'Red Dead Redemption 2', '1793371537_Red_Dead_Redemption2.jpg', 'bnib', 2, 10000.00, 70000.00, 1, '2026-10-30 07:45:37', '2026-10-30 07:46:53');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
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
(4, '2026_10_28_082403_create_platforms_table', 1),
(5, '2026_10_28_082416_create_games_table', 1),
(6, '2026_10_28_082424_create_rentals_table', 1),
(7, '2026_10_28_082434_create_payments_table', 1),
(8, '2026_10_28_151030_add_cover_image_to_games_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rental_id` bigint(20) UNSIGNED NOT NULL,
  `method` enum('qris','bank','ewallet') NOT NULL DEFAULT 'qris',
  `amount` decimal(12,2) NOT NULL,
  `status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `rental_id`, `method`, `amount`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'qris', 460000.00, 'paid', '2026-10-28 23:25:59', '2026-10-28 23:25:25', '2026-10-28 23:25:59'),
(2, 2, 'qris', 545000.00, 'paid', '2026-10-30 08:14:38', '2026-10-28 23:55:38', '2026-10-30 08:14:38'),
(3, 3, 'qris', 545000.00, 'paid', '2026-10-30 08:14:41', '2026-10-28 23:56:35', '2026-10-30 08:14:41'),
(4, 4, 'qris', 460000.00, 'paid', '2026-10-30 08:14:40', '2026-10-29 00:13:58', '2026-10-30 08:14:40'),
(5, 5, 'qris', 275000.00, 'paid', '2026-10-30 07:18:16', '2026-10-30 07:18:09', '2026-10-30 07:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `platforms`
--

CREATE TABLE `platforms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `platforms`
--

INSERT INTO `platforms` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'PlayStation 5', '2026-10-28 22:56:43', '2026-10-28 22:56:43'),
(2, 'PlayStation 4', '2026-10-28 22:56:43', '2026-10-28 22:56:43'),
(3, 'Nintendo Switch', '2026-10-28 22:56:43', '2026-10-28 22:56:43'),
(4, 'Xbox Series X', '2026-10-28 22:56:43', '2026-10-28 22:56:43'),
(5, 'Retro Console', '2026-10-28 22:56:43', '2026-10-28 22:56:43');

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `duration_days` tinyint(3) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `returned_at` datetime DEFAULT NULL,
  `rent_total` decimal(12,2) NOT NULL,
  `deposit_amount` decimal(12,2) NOT NULL,
  `late_days` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `late_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deposit_refund` decimal(12,2) NOT NULL DEFAULT 0.00,
  `delivery_method` enum('pickup','courier') NOT NULL DEFAULT 'pickup',
  `status` enum('pending_payment','paid','active','returned','completed') NOT NULL DEFAULT 'pending_payment',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`id`, `user_id`, `game_id`, `duration_days`, `start_date`, `due_date`, `returned_at`, `rent_total`, `deposit_amount`, `late_days`, `late_fee`, `deposit_refund`, `delivery_method`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 7, '2026-10-29', '2026-11-05', NULL, 210000.00, 250000.00, 0, 0.00, 250000.00, 'courier', 'active', '2026-10-28 23:25:25', '2026-10-28 23:25:59'),
(2, 2, 1, 7, '2026-10-29', '2026-11-05', NULL, 245000.00, 300000.00, 0, 0.00, 300000.00, 'pickup', 'active', '2026-10-28 23:55:38', '2026-10-30 08:14:38'),
(3, 2, 1, 7, '2026-10-29', '2026-11-05', NULL, 245000.00, 300000.00, 0, 0.00, 300000.00, 'pickup', 'active', '2026-10-28 23:56:35', '2026-10-30 08:14:41'),
(4, 2, 2, 7, '2026-10-29', '2026-11-05', NULL, 210000.00, 250000.00, 0, 0.00, 250000.00, 'pickup', 'active', '2026-10-29 00:13:58', '2026-10-30 08:14:40'),
(5, 2, 6, 3, '2026-10-30', '2026-11-02', NULL, 75000.00, 200000.00, 0, 0.00, 200000.00, 'courier', 'paid', '2026-10-30 07:18:09', '2026-10-30 07:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pemilik Toko (Admin)', 'admin@sewagame.id', '$2y$12$hL22vuOG4kem3FvFglU6C.QFXIbe3ZuFWggJra.VX3jZXF.FtpESS', 'admin', NULL, '2026-10-28 22:56:42', '2026-10-28 22:56:42'),
(2, 'Cierlary', 'cierlary@gmail.com', '$2y$12$YTNzVTa75XpG6S6qWZUb5uULD0orHKLWrLvzSxjpUfkTy0vvyaa4C', 'customer', NULL, '2026-10-28 22:56:43', '2026-10-28 22:56:43');

--
-- Indexes for dumped tables
--

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
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `games_platform_id_foreign` (`platform_id`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_rental_id_foreign` (`rental_id`);

--
-- Indexes for table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rentals_user_id_foreign` (`user_id`),
  ADD KEY `rentals_game_id_foreign` (`game_id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_platform_id_foreign` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_rental_id_foreign` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `rentals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
