-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 20, 2021 at 05:38 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Sea food', '2021-02-08 19:55:37', '2021-02-08 19:55:37'),
(3, 'Fast food', '2021-02-08 20:13:37', '2021-02-11 17:44:12'),
(4, 'Lunch', '2021-02-09 03:16:48', '2021-02-09 03:16:48');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `price`, `image`, `description`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Hamburger', '5.00', '12022021005060256e5167f7e.jpg', 'A hamburger (also burger for short).', 3, '2021-02-10 03:37:17', '2021-02-11 17:50:09'),
(7, 'Noodles', '10.00', '1402202109106028868898988.jpg', 'Noodles', 1, '2021-02-14 02:10:16', '2021-02-14 02:10:16'),
(6, 'Chicken', '15.00', '1402202109086028862c6a8a6.jpg', 'Chicken', 4, '2021-02-14 02:08:44', '2021-02-14 02:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_02_09_023754_create_categories_table', 2),
(5, '2021_02_09_150427_create_menus_table', 3),
(6, '2021_02_12_213351_create_tables_table', 4),
(7, '2021_02_14_085356_create_sales_table', 5),
(8, '2021_02_14_090612_create_sale_details_table', 6),
(9, '2021_02_17_213653_add_role_feild_to_users', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`(250))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_id` int(11) NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_recieved` decimal(8,2) NOT NULL DEFAULT 0.00,
  `change` decimal(8,2) NOT NULL DEFAULT 0.00,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sale_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `table_id`, `table_name`, `user_id`, `user_name`, `total_price`, `total_recieved`, `change`, `payment_type`, `sale_status`, `created_at`, `updated_at`) VALUES
(5, 2, 'A1', 1, 'van', '15.00', '20.00', '5.00', 'cash', 'paid', '2021-02-14 15:48:09', '2021-02-16 07:54:25'),
(6, 3, 'A2', 1, 'van', '25.00', '50.00', '25.00', 'credit card', 'paid', '2021-02-16 07:56:21', '2021-02-16 07:57:01'),
(14, 2, 'A1', 1, 'van', '15.00', '100.00', '85.00', 'cash', 'paid', '2021-02-16 14:33:46', '2021-02-16 14:34:05'),
(15, 2, 'A1', 1, 'van', '10.00', '20.00', '10.00', 'cash', 'paid', '2021-02-16 14:34:53', '2021-02-16 14:35:05'),
(20, 5, 'A3', 1, 'van', '40.00', '200.00', '160.00', 'cash', 'paid', '2021-02-17 09:27:24', '2021-02-17 09:28:20'),
(21, 2, 'A1', 4, 'van', '60.00', '100.00', '40.00', 'cash', 'paid', '2021-02-20 05:16:28', '2021-02-20 05:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

DROP TABLE IF EXISTS `sale_details`;
CREATE TABLE IF NOT EXISTS `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'noConfirm',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`id`, `sale_id`, `menu_id`, `menu_name`, `menu_price`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(28, 14, 6, 'Chicken', 15, 1, 'confirm', '2021-02-16 14:33:46', '2021-02-16 14:33:49'),
(20, 6, 7, 'Noodles', 10, 1, 'confirm', '2021-02-16 07:56:25', '2021-02-16 07:56:30'),
(19, 6, 6, 'Chicken', 15, 1, 'confirm', '2021-02-16 07:56:21', '2021-02-16 07:56:30'),
(11, 5, 1, 'Hamburger', 5, 1, 'confirm', '2021-02-14 15:48:17', '2021-02-14 15:48:37'),
(10, 5, 7, 'Noodles', 10, 1, 'confirm', '2021-02-14 15:48:09', '2021-02-14 15:48:37'),
(29, 15, 7, 'Noodles', 10, 1, 'confirm', '2021-02-16 14:34:53', '2021-02-16 14:34:56'),
(39, 20, 7, 'Noodles', 10, 2, 'confirm', '2021-02-17 09:27:24', '2021-02-17 09:27:43'),
(40, 20, 1, 'Hamburger', 5, 4, 'confirm', '2021-02-17 09:27:27', '2021-02-17 09:27:43'),
(41, 21, 7, 'Noodles', 10, 3, 'confirm', '2021-02-20 05:16:28', '2021-02-20 05:16:45'),
(42, 21, 6, 'Chicken', 15, 2, 'confirm', '2021-02-20 05:16:34', '2021-02-20 05:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'A1', 'available', '2021-02-13 06:48:04', '2021-02-20 05:16:56'),
(5, 'A3', 'available', '2021-02-17 08:39:05', '2021-02-17 09:28:20'),
(4, 'A2', 'available', '2021-02-13 07:21:25', '2021-02-17 08:28:21'),
(6, 'A4', 'available', '2021-02-17 09:15:55', '2021-02-17 09:15:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(9, 'user2', 'cashier', 'user2@gmail.com', NULL, '$2y$10$gc3zRZV8qIiGSUP7Idekc.rCi7PkqKCL4iI.4AzbJcOqE3Z.tsycW', NULL, '2021-02-18 05:25:49', '2021-02-18 05:25:49'),
(8, 'user1', 'cashier', 'user1@gmail.com', NULL, '$2y$10$jwz067MWYTAaaSbqtzc5Qu2H1Yy7jj1D25irS53v159vDOpP6Olx6', NULL, '2021-02-18 05:20:50', '2021-02-18 05:20:50'),
(4, 'van', 'admin', 'van@gmail.com', NULL, '$2y$10$186hjNGNZ2W5l1rCwt0mDeVmXZQ5z15oVWuDujYJsMbauGOgTgLwO', NULL, '2021-02-18 03:06:10', '2021-02-18 06:01:14'),
(10, 'admin', 'admin', 'admin@gmail.com', NULL, '$2y$10$KmanORdx0CT3y.hh16Ug9eGDmgGGThkxzLQ71jswt/DgMGrvDQZSe', NULL, '2021-02-18 05:48:29', '2021-02-18 05:48:29');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
