-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2026 at 06:31 AM
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
-- Database: `file_sharing_demo1`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `action`, `details`, `created_at`) VALUES
(1, 1, 'File uploaded', 'smartwatch.jpg', '2026-03-27 01:02:07'),
(2, 1, 'File shared', 'Token: c96595c2', '2026-03-27 01:03:46'),
(3, 1, 'File uploaded', 'coffeemaker.jpg', '2026-03-27 01:04:14'),
(4, 1, 'File uploaded', 'tshirt.jpg', '2026-03-27 01:04:23'),
(5, NULL, 'File uploaded', 'smartwatch.jpg', '2026-03-27 01:04:34'),
(6, NULL, 'File shared', 'Token: ccf7989a', '2026-03-27 01:04:37'),
(7, 1, 'File uploaded', 'smartwatch.jpg', '2026-03-27 01:07:34'),
(8, 1, 'File uploaded', 'coffeemaker.jpg', '2026-03-27 01:14:38'),
(9, 1, 'File shared', 'Token: be10ff7c', '2026-03-27 01:20:48'),
(10, 1, 'Share link revoked', '', '2026-03-27 01:28:42'),
(11, 1, 'File uploaded', 'headphones.jpg', '2026-03-27 01:28:58'),
(12, 1, 'File shared', 'Token: ccfb4dbb', '2026-03-27 01:29:12'),
(13, 1, 'File shared', 'Token: a575d68f', '2026-03-27 01:29:28'),
(14, 1, 'File shared', 'Token: e0e3f373', '2026-03-27 01:29:34'),
(15, 1, 'File shared', 'Token: 7cf19ed1', '2026-03-27 01:29:48'),
(16, 1, 'File shared', 'Token: b2e25d69', '2026-03-27 01:32:42'),
(17, 1, 'File uploaded', 'smartwatch.jpg', '2026-03-27 01:32:56'),
(18, 1, 'File shared', 'Token: e02bc34e', '2026-03-27 01:33:04'),
(19, NULL, 'File uploaded', 'smartwatch.jpg', '2026-03-27 01:33:28'),
(20, NULL, 'File shared', 'Token: fdf765a4', '2026-03-27 01:33:32'),
(21, 1, 'File shared', 'Token: 35705e0b', '2026-03-27 01:35:41'),
(22, 1, 'File deleted', 'file_69c5de4806704.jpg', '2026-03-27 01:47:04'),
(23, 1, 'File shared', 'Token: 1f620c82', '2026-03-27 01:47:09'),
(24, 1, 'File deleted', 'file_69c5d51889796.jpg', '2026-03-27 01:47:13'),
(25, 1, 'File uploaded', 'coffeemaker.jpg', '2026-03-27 01:47:31'),
(26, 1, 'File shared', 'Token: 6561f410', '2026-03-27 01:47:38'),
(27, 1, 'File shared', 'Token: 9ede97bb', '2026-03-27 01:47:43'),
(28, 1, 'File deleted', 'file_69c5e1b31ed55.jpg', '2026-03-27 01:47:48'),
(29, 1, 'File deleted', 'file_69c5dd5a9a2ea.jpg', '2026-03-27 01:47:49'),
(30, 1, 'File deleted', 'file_69c5dc11279f7.jpg', '2026-03-27 01:47:50'),
(31, 1, 'File deleted', 'file_69c5dc0b9f956.jpg', '2026-03-27 01:47:51'),
(32, 1, 'File deleted', 'file_69c5dbfdc3df6.jpg', '2026-03-27 01:47:51'),
(33, 1, 'File deleted', 'file_69c5d9fe2b2d3.jpg', '2026-03-27 01:47:52'),
(34, 1, 'File deleted', 'file_69c5d856040eb.jpg', '2026-03-27 01:47:53'),
(35, 1, 'File deleted', 'file_69c5d7978436c.jpg', '2026-03-27 01:47:53'),
(36, 1, 'File deleted', 'file_69c5d78e429a7.jpg', '2026-03-27 01:47:55'),
(37, 1, 'File deleted', 'file_69c5d70f3e327.jpg', '2026-03-27 01:47:56'),
(38, 1, 'File deleted', 'file_69c5d67dc94a4.jpg', '2026-03-27 01:47:56'),
(39, 1, 'File deleted', 'file_69c5d540b1dd6.jpg', '2026-03-27 01:47:58'),
(40, 1, 'File uploaded', 'coffeemaker.jpg', '2026-03-27 01:48:03'),
(41, 1, 'File shared', 'Token: 05a8a251', '2026-03-27 01:48:09'),
(42, 1, 'File shared', 'Token: 828de2ef', '2026-03-27 01:52:59'),
(43, 1, 'File shared', 'Token: dd28b5b6', '2026-03-27 01:53:12'),
(44, 1, 'File uploaded', 'smartwatch.jpg', '2026-03-27 01:53:16'),
(45, 1, 'File shared', 'Token: 45f5cb4f', '2026-03-27 01:55:04'),
(46, 1, 'File shared', 'Token: e4f795c8', '2026-03-27 01:55:09'),
(47, 1, 'File shared', 'Token: 29873e60', '2026-03-27 01:57:54'),
(48, 1, 'File shared', 'Token: cc5de37d', '2026-03-27 02:01:33'),
(49, 1, 'File shared', 'Token: 5bacf6cd', '2026-03-27 02:08:58'),
(50, 1, 'File uploaded', 'tshirt.jpg', '2026-03-27 02:09:15'),
(51, 1, 'File shared', 'Token: 6ab50263', '2026-03-27 02:09:31'),
(52, 1, 'User suspended', 'User ID: 2', '2026-03-27 02:13:49'),
(53, NULL, 'File uploaded', 'headphones.jpg', '2026-03-27 02:14:05'),
(54, 1, 'User deleted', 'User ID: 2', '2026-03-27 02:14:18'),
(55, 1, 'File shared', 'Token: a6cc3a91', '2026-03-27 02:23:52'),
(56, NULL, 'User registered', 'user1', '2026-03-27 02:38:56'),
(57, NULL, 'File uploaded', 'headphones.jpg', '2026-03-27 02:39:02'),
(58, NULL, 'File shared', 'Token: cbac14ef', '2026-03-27 02:39:05'),
(59, 1, 'File uploaded', 'tshirt.jpg', '2026-03-27 02:39:18'),
(60, 1, 'File shared', 'Token: de12368d', '2026-03-27 02:39:23'),
(61, 1, 'User suspended', 'User: user1', '2026-03-27 02:39:37'),
(62, 1, 'User deleted', 'User: user1', '2026-03-27 02:40:16'),
(63, 6, 'User registered', 'user1', '2026-03-27 02:41:12'),
(64, 1, 'File deleted', '', '2026-03-27 02:45:45'),
(65, 1, 'Share link revoked', '', '2026-03-27 02:45:49'),
(66, 1, 'File deleted', '', '2026-03-27 02:45:55'),
(67, 6, 'File uploaded', 'coffeemaker.jpg', '2026-03-27 02:46:10'),
(68, 6, 'File shared', 'Token: f9266270', '2026-03-27 02:46:18');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_size` bigint(20) NOT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `folder` varchar(100) DEFAULT 'root',
  `tags` varchar(255) DEFAULT NULL,
  `is_encrypted` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user_id`, `filename`, `original_name`, `file_size`, `file_type`, `file_path`, `folder`, `tags`, `is_encrypted`, `created_at`) VALUES
(19, 1, 'file_69c5e30c69f51.jpg', 'smartwatch.jpg', 7847, 'image/jpeg', 'file_69c5e30c69f51.jpg', 'root', NULL, 0, '2026-03-27 01:53:16'),
(20, 1, 'file_69c5e6cb16f61.jpg', 'tshirt.jpg', 5068, 'image/jpeg', 'file_69c5e6cb16f61.jpg', 'root', NULL, 0, '2026-03-27 02:09:15'),
(24, 6, 'file_69c5ef71f3cec.jpg', 'coffeemaker.jpg', 8451, 'image/jpeg', 'file_69c5ef71f3cec.jpg', 'root', NULL, 0, '2026-03-27 02:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

CREATE TABLE `shares` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `share_token` varchar(64) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `permissions` enum('view','download') DEFAULT 'view',
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shares`
--

INSERT INTO `shares` (`id`, `file_id`, `share_token`, `expires_at`, `password_hash`, `permissions`, `created_by`, `created_at`) VALUES
(33, 20, '6ab50263221359849313f7971c3c83c4', '2026-04-03 03:09:31', '$2y$10$1lIYqPCx6JehWPKAapoMcevZ9pd7/QO/Uv18hpdlAP80t3eZCCnsy', 'view', 1, '2026-03-27 02:09:31'),
(37, 24, 'f9266270c2784adc4dce377e914ca505', '2026-04-03 03:46:18', '$2y$10$8z/PTS8L1Yh6GbPv7yu8W.SgaAZMGPtwBu5zM0IiBQqDiG3/SC27O', 'view', 6, '2026-03-27 02:46:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('regular','premium','admin','suspended') DEFAULT 'regular',
  `storage_used` bigint(20) DEFAULT 0,
  `storage_limit` bigint(20) DEFAULT 1073741824,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `storage_used`, `storage_limit`, `created_at`) VALUES
(1, 'admin', 'admin@files.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 113837, 1073741824, '2026-03-27 00:47:22'),
(6, 'user1', 'user1@files.com', '$2y$10$th38eE4sjWvRnsRKTu1pdOuPZz7q2/h4Azw10cRzImN3sSJpYwdIK', 'regular', 8451, 1073741824, '2026-03-27 02:41:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shares`
--
ALTER TABLE `shares`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `share_token` (`share_token`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `shares`
--
ALTER TABLE `shares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shares`
--
ALTER TABLE `shares`
  ADD CONSTRAINT `shares_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shares_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
