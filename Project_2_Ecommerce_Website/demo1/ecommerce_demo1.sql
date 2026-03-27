-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2026 at 06:29 AM
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
-- Database: `ecommerce_demo1`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Electronics', 'electronics'),
(2, 'Fashion', 'fashion'),
(3, 'Home & Kitchen', 'home-kitchen');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`) VALUES
(1, 20, 59.99, 'pending', '2026-03-26 16:59:28'),
(3, 20, 59.99, 'pending', '2026-03-26 17:42:53'),
(4, 20, 149.99, 'pending', '2026-03-26 18:02:44'),
(5, 20, 209.98, 'pending', '2026-03-26 18:10:14'),
(6, 20, 59.99, 'pending', '2026-03-26 18:18:53'),
(7, 20, 199.97, 'pending', '2026-03-26 18:28:20'),
(13, 20, 149.98, 'pending', '2026-03-26 18:35:05'),
(14, NULL, 99.98, 'delivered', '2026-03-26 18:35:27'),
(15, NULL, 89.99, 'pending', '2026-03-26 18:39:00'),
(17, NULL, 0.00, 'pending', '2026-03-26 18:44:02'),
(18, 19, 59.99, 'pending', '2026-03-26 18:45:22'),
(21, 19, 109.98, 'delivered', '2026-03-26 18:50:47'),
(29, NULL, 59.99, 'pending', '2026-03-26 19:31:34'),
(30, 20, 89.99, 'pending', '2026-03-26 20:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(7, 6, 20, 1, 59.99),
(10, 7, 25, 1, 89.99),
(11, 13, 25, 1, 89.99),
(14, 15, 17, 1, 89.99),
(30, 29, 24, 1, 59.99),
(31, 30, 21, 1, 89.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `category_id`, `image`, `featured`, `created_at`) VALUES
(1, 'Wireless Headphones', 'Premium noise-cancelling over-ear headphones', 89.99, 45, 1, 'headphones.jpg', 1, '2026-03-26 16:17:38'),
(2, 'Smart Watch Pro', 'Advanced fitness and health tracking smartwatch', 149.99, 30, 1, 'smartwatch.jpg', 1, '2026-03-26 16:17:38'),
(3, 'Cotton Classic T-Shirt', 'Soft premium cotton t-shirt', 24.99, 120, 2, 'tshirt.jpg', 0, '2026-03-26 16:17:38'),
(4, 'Automatic Coffee Maker', '12-cup programmable coffee machine', 59.99, 25, 3, 'coffeemaker.jpg', 1, '2026-03-26 16:17:38'),
(5, 'Wireless Headphones', 'Premium noise cancelling headphones', 89.99, 50, 1, 'headphones.jpg', 1, '2026-03-26 16:22:37'),
(6, 'Smart Watch Pro', 'Fitness & health tracking', 149.99, 35, 1, 'smartwatch.jpg', 1, '2026-03-26 16:22:37'),
(7, 'Cotton T-Shirt', 'Soft premium cotton', 24.99, 100, 2, 'tshirt.jpg', 0, '2026-03-26 16:22:37'),
(8, 'Coffee Maker', '12-cup automatic coffee machine', 59.99, 20, 3, 'coffeemaker.jpg', 1, '2026-03-26 16:22:37'),
(9, 'Wireless Headphones', 'Premium noise cancelling headphones', 89.99, 50, 1, 'headphones.jpg', 1, '2026-03-26 16:26:25'),
(10, 'Smart Watch Pro', 'Fitness & health tracking', 149.99, 35, 1, 'smartwatch.jpg', 1, '2026-03-26 16:26:25'),
(11, 'Cotton T-Shirt', 'Soft premium cotton', 24.99, 100, 2, 'tshirt.jpg', 0, '2026-03-26 16:26:25'),
(12, 'Coffee Maker', '12-cup automatic coffee machine', 59.99, 20, 3, 'coffeemaker.jpg', 1, '2026-03-26 16:26:25'),
(13, 'Wireless Headphones', 'Premium noise-cancelling Bluetooth headphones', 89.99, 50, 1, 'headphones.jpg', 1, '2026-03-26 16:32:06'),
(15, 'Cotton Classic T-Shirt', 'Soft premium cotton t-shirt', 24.99, 120, 2, 'tshirt.jpg', 0, '2026-03-26 16:32:06'),
(17, 'Wireless Headphones', 'Premium noise-cancelling Bluetooth headphones', 89.99, 50, 1, 'headphones.jpg', 1, '2026-03-26 16:32:44'),
(18, 'Smart Watch Pro', 'Advanced fitness tracking smartwatch', 149.99, 30, 1, 'smartwatch.jpg', 1, '2026-03-26 16:32:44'),
(20, 'Automatic Coffee Maker', '12-cup programmable drip coffee machine', 59.99, 25, 3, 'coffeemaker.jpg', 1, '2026-03-26 16:32:44'),
(21, 'Wireless Headphones', 'Premium noise-cancelling Bluetooth headphones', 89.99, 50, 1, 'headphones.jpg', 1, '2026-03-26 16:35:20'),
(22, 'Smart Watch Pro', 'Advanced fitness tracking smartwatch', 149.99, 30, 1, 'smartwatch.jpg', 1, '2026-03-26 16:35:20'),
(23, 'Cotton Classic T-Shirt', 'Soft premium cotton t-shirt', 24.99, 120, 2, 'tshirt.jpg', 0, '2026-03-26 16:35:20'),
(24, 'Automatic Coffee Maker', '12-cup programmable drip coffee machine', 59.99, 25, 3, 'coffeemaker.jpg', 1, '2026-03-26 16:35:20'),
(25, 'Wireless Headphones', 'Premium noise-cancelling Bluetooth headphones', 89.99, 50, 1, 'headphones.jpg', 1, '2026-03-26 16:37:16');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 2, 5, 'Excellent sound quality and battery life! Highly recommended.', '2026-03-26 17:15:08'),
(2, 2, 2, 4, 'Great smartwatch. Very comfortable to wear.', '2026-03-26 17:15:08'),
(3, 1, 1, 5, 'Best headphones I have ever used.', '2026-03-26 17:15:08'),
(4, 25, 20, 5, 'continue expanding', '2026-03-26 17:26:48'),
(5, 25, 20, 5, 'afsfd', '2026-03-26 17:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `verified` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `verified`, `created_at`) VALUES
(20, 'customer', 'customer@shop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 1, '2026-03-26 16:38:32'),
(21, 'newcustomer', 'newcustomer@shop.com', '$2y$10$uKQq9RedesmroV.FM/j.1uS9KLaGm6b9bfV8ccM/9vAlBxRNSF.Ny', 'user', 1, '2026-03-26 16:52:21'),
(23, 'testuser374', 'testuser507@example.com', '$2y$10$mrU3KXlFG8tgFdHdBNscreS/HYNgeDZOTupLBaEWdJ.Azqo.JbaCC', 'user', 1, '2026-03-26 19:32:49'),
(24, 'testuser482', 'testuser746@example.com', '$2y$10$JB1oDdLCYqYadmiYN6ilPe5U36U.diutqjZJvIbi5hxPgs.C5GMHq', 'user', 1, '2026-03-26 19:33:28'),
(25, 'testuser695', 'testuser695@example.com', '$2y$10$xfycoVJ/YLJJTFk5as1dfub9D1gC3PtSMR.kK/3R2hqsgAKH9Jk6W', 'user', 1, '2026-03-26 19:35:19'),
(26, 'testuser420', 'testuser420@example.com', '$2y$10$VqelpAt2klpjjaXSJNETKuqVX/8qEf14cwb9PKmIq.pmbRpkST6se', 'user', 1, '2026-03-26 19:35:36'),
(27, 'testuser296', 'testuser296@example.com', '$2y$10$rKtAHSnEZzKRJqhPvzvbFOK5WtpFdiGgMIL63EpvzJ/fKtHqZBUjW', 'user', 1, '2026-03-26 19:37:24'),
(28, 'testuser407', 'testuser407@example.com', '$2y$10$iFJxH/C6w.tI2DASbpNHoupTPDtO4RSGKsPBZl1env9t2p6jgjita', 'user', 1, '2026-03-26 19:39:00'),
(29, 'testuser731', 'testuser731@example.com', '$2y$10$VJjKzW23jLNeJxwp5K41aeJ0sNDbD.LqNXk9n/Ff9P3nyZTAHIU86', 'user', 1, '2026-03-26 19:39:57'),
(30, 'testuser462', 'testuser462@example.com', '$2y$10$P4JKXiF91HLHfhhXybhhQOROsLh5/tvhmN3KYFlzctbu3y/tzOFQi', 'user', 1, '2026-03-26 19:40:05'),
(33, 'testuser219', 'testuser219@example.com', '$2y$10$UJ8NsSKz5ZAlaX4vTfnXLOBmCJBVZGPbDAK.EkNs5aOPPKCku9.H2', 'user', 1, '2026-03-26 19:43:46'),
(34, 'testuser709', 'testuser709@example.com', '$2y$10$LkqX29KCRtIjGgduVlc0Qu/G6OVDnpfB5P1oUcU2BIGKTHDLDsW2S', 'user', 1, '2026-03-26 19:45:36'),
(35, 'testuser342', 'testuser342@example.com', '$2y$10$dY0AGQgNaneZRf5dbhDKK.alzyI51lgCL5hl6Whmeflhh.uwhCXTC', 'user', 1, '2026-03-26 19:46:51'),
(36, 'testuser', 'test@shop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 1, '2026-03-26 19:54:43'),
(37, 'admin', 'admin@shop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, '2026-03-26 19:54:43'),
(38, 'testuser428', 'testuser428@example.com', '$2y$10$93DlnbggNo7I9weoemHJ7ehinb9E6GxIMzHtrXOTR3PjsBkZYzes2', 'user', 1, '2026-03-26 19:55:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
