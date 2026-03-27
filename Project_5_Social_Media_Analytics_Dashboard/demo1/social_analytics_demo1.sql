-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2026 at 06:32 AM
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
-- Database: `social_analytics_demo1`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert_thresholds`
--

CREATE TABLE `alert_thresholds` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `metric` varchar(50) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `threshold_value` decimal(10,2) NOT NULL,
  `direction` enum('above','below') DEFAULT 'below',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alert_thresholds`
--

INSERT INTO `alert_thresholds` (`id`, `user_id`, `metric`, `platform`, `threshold_value`, `direction`, `created_at`) VALUES
(1, 1, 'engagement', 'instagram', 5.00, 'below', '2026-03-27 04:46:27');

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `action` varchar(100) NOT NULL,
  `detail` text DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `user_id`, `action`, `detail`, `ip`, `created_at`) VALUES
(1, 1, 'logout', 'admin', '::1', '2026-03-27 04:45:54'),
(2, 1, 'login', 'admin@analytics.com', '::1', '2026-03-27 04:45:57'),
(3, 1, 'promote_user', 'Target user ID: 15 promoted to manager', '::1', '2026-03-27 04:46:14'),
(4, 1, 'logout', 'admin', '::1', '2026-03-27 04:58:25'),
(5, 1, 'login', 'admin@analytics.com', '::1', '2026-03-27 04:58:26'),
(6, 1, 'change_password', 'User changed their password', '::1', '2026-03-27 05:01:28'),
(7, 1, 'logout', 'admin', '::1', '2026-03-27 05:01:33'),
(8, 1, 'login', 'admin@analytics.com', '::1', '2026-03-27 05:01:34'),
(9, 1, 'logout', 'admin', '::1', '2026-03-27 05:01:36'),
(10, 1, 'login', 'admin@analytics.com', '::1', '2026-03-27 05:01:59'),
(11, 1, 'login', 'admin@analytics.com', '::1', '2026-03-27 05:02:11'),
(12, 1, 'logout', 'admin', '::1', '2026-03-27 05:02:13'),
(13, 1, 'login', 'admin@analytics.com', '::1', '2026-03-27 05:02:14'),
(14, 1, 'logout', 'admin', '::1', '2026-03-27 05:20:41'),
(15, 1, 'login', 'admin@analytics.com', '::1', '2026-03-27 05:20:43');

-- --------------------------------------------------------

--
-- Table structure for table `competitors`
--

CREATE TABLE `competitors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `handle` varchar(100) DEFAULT NULL,
  `platform` varchar(50) DEFAULT NULL,
  `followers` int(11) DEFAULT 0,
  `engagement_rate` decimal(5,2) DEFAULT 0.00,
  `growth` varchar(20) DEFAULT '+0%',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competitors`
--

INSERT INTO `competitors` (`id`, `user_id`, `name`, `handle`, `platform`, `followers`, `engagement_rate`, `growth`, `created_at`) VALUES
(2, 1, 'BrandRival', '@brandrival', 'Instagram', 52000, 7.40, '+8%', '2026-03-27 05:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `platform_metrics`
--

CREATE TABLE `platform_metrics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `followers` int(11) DEFAULT 0,
  `engagement_rate` decimal(5,2) DEFAULT 0.00,
  `posts` int(11) DEFAULT 0,
  `recorded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_posts`
--

CREATE TABLE `scheduled_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `status` enum('draft','scheduled','published') DEFAULT 'scheduled',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scheduled_posts`
--

INSERT INTO `scheduled_posts` (`id`, `user_id`, `platform`, `content`, `scheduled_at`, `status`, `created_at`) VALUES
(2, 1, 'Instagram', 'Exciting news! Our spring collection is live. Check it out now and use code SPRING20 for 20% off. #SpringSale #NewArrival', '2026-03-28 05:59:00', 'scheduled', '2026-03-27 04:59:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','analyst','suspended') DEFAULT 'analyst',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@analytics.com', '$2y$10$ZoQaAF7DQcHlH7hNynGPv.jTXK34C4w./nDjhtgcaoK8Izfib9GGi', 'admin', '2026-03-27 02:58:57'),
(2, 'analyst', 'analyst@analytics.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'analyst', '2026-03-27 02:58:57'),
(3, 'new_analyst', 'newuser@analytics.com', '$2y$10$08VRZb04Q0WoLSseeyOWyOMBrQ7ns6cJyedFBNSkcP2gAFqTxM42e', 'analyst', '2026-03-27 03:50:10'),
(5, 'user_1484', 'user_1484@demo.com', '$2y$10$3NIx.cw13FFkvqYj.8dUEeeAZebqaMGeYchiL89IGh1qO3c9amowa', 'analyst', '2026-03-27 03:51:37'),
(6, 'user_8603', 'user_8603@demo.com', '$2y$10$YSWdEVMldC9C6KYZyuoLJ..Cq04PpBvMf5tepfeDk23dlkime/WPa', 'analyst', '2026-03-27 03:53:49'),
(7, 'user_9350', 'user_9350@demo.com', '$2y$10$G9RKLepxtrUoqrp8MrXXtuoQ3EWDOSAVWQ6i91IQd4gbFdSOqYEEi', '', '2026-03-27 03:54:38'),
(9, 'user_3521', 'user_3521@demo.com', '$2y$10$ddLIzawJI7xWUEfbuJxFyeK.axt80/mKI.7guYiVWIjFzxn6SVh6S', 'analyst', '2026-03-27 03:57:37'),
(10, 'user_2995', 'user_2995@demo.com', '$2y$10$CB0f7s5otxcDMiH3NaKVLexSGUMN51d/C2yTsPAYOT6Jktwm/oRUa', 'analyst', '2026-03-27 03:58:59'),
(11, 'user_1963', 'user_1963@demo.com', '$2y$10$lzq/AmMFMBvOjMRSqk80eeaHUpfckE3lEBjwfvARkl8Y2LlSg3HLi', 'analyst', '2026-03-27 03:59:10'),
(15, 'user_4507', 'user_4507@demo.com', '$2y$10$sWu78c89UrOlQqZ7qf.VGetSwG91G8BRfbtAqnzxt88gW9uEyB/k2', 'manager', '2026-03-27 04:16:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alert_thresholds`
--
ALTER TABLE `alert_thresholds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competitors`
--
ALTER TABLE `competitors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `platform_metrics`
--
ALTER TABLE `platform_metrics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `scheduled_posts`
--
ALTER TABLE `scheduled_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `alert_thresholds`
--
ALTER TABLE `alert_thresholds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `competitors`
--
ALTER TABLE `competitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `platform_metrics`
--
ALTER TABLE `platform_metrics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scheduled_posts`
--
ALTER TABLE `scheduled_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alert_thresholds`
--
ALTER TABLE `alert_thresholds`
  ADD CONSTRAINT `alert_thresholds_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `competitors`
--
ALTER TABLE `competitors`
  ADD CONSTRAINT `competitors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `platform_metrics`
--
ALTER TABLE `platform_metrics`
  ADD CONSTRAINT `platform_metrics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `scheduled_posts`
--
ALTER TABLE `scheduled_posts`
  ADD CONSTRAINT `scheduled_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
