-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2026 at 06:27 AM
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
-- Database: `simple_blog_demo5`
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
(1, 'Technology', 'technology'),
(2, 'Lifestyle', 'lifestyle'),
(3, 'Travel', 'travel');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'approved',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `content`, `parent_id`, `status`, `created_at`) VALUES
(3, 3, 4, 'Brilliant!', NULL, 'approved', '2026-03-26 08:48:19'),
(4, 3, 4, 'Superb!', NULL, 'approved', '2026-03-26 08:54:09'),
(6, 1, 2, 'This is a test comment that needs moderation.', NULL, 'pending', '2026-03-26 08:55:53'),
(7, 1, 2, 'This is a test comment that needs moderation.', NULL, 'pending', '2026-03-26 08:56:23'),
(8, 1, 2, 'This is a new test comment waiting for approval.', NULL, 'pending', '2026-03-26 08:57:48'),
(9, 1, 2, 'This is a new test comment waiting for approval.', NULL, 'pending', '2026-03-26 08:58:23'),
(11, 1, 1, 'This is a test comment that needs moderation. Please approve or reject me.', NULL, 'rejected', '2026-03-26 09:02:52'),
(12, 1, 1, 'This is a test comment that needs moderation. Please approve or reject me.', NULL, 'approved', '2026-03-26 09:03:23'),
(13, 1, 4, 'This is a test comment', NULL, 'approved', '2026-03-26 09:04:11'),
(14, 1, 4, 'Please approve', NULL, 'approved', '2026-03-26 09:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('draft','published') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `featured_image`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Welcome to Simple Blog System', '<p>This is a fully functional demo post.</p><p>Login as admin to access the dashboard.</p>', 'uploads/1774511266_1774510993_sample-post1.jpg', 1, 'published', '2026-03-26 07:39:32', '2026-03-26 07:47:46'),
(2, 'PHP MVC Best Practices', '<p>This project demonstrates clean OOP + MVC structure.</p>', 'uploads/1774511287_sample-post2.jpg', 1, 'published', '2026-03-26 07:39:32', '2026-03-26 07:48:07'),
(3, 'sample post3', 'Content sample-post3', 'uploads/1774511897_sample-post3.jpg', 1, 'published', '2026-03-26 07:58:17', '2026-03-26 07:58:17'),
(6, 'My First Awesome Blog Post', '<h3>Welcome to my blog!</h3>\r\n<p>This is a demo post created with the rich text editor (TinyMCE). You can format text, add lists, links, and even images.</p>\r\n<p>Feel free to edit this content as you like.</p>\r\n                        ', NULL, 4, 'published', '2026-03-26 08:54:19', '2026-03-26 08:54:19'),
(7, 'My First Awesome Blog Post', '<h3>Welcome to my blog!</h3>\r\n<p>This is a demo post created with the rich text editor (TinyMCE). You can format text, add lists, links, and even images.</p>\r\n<p>Feel free to edit this content as you like.</p>\r\n                        ', NULL, 1, 'published', '2026-03-26 09:15:24', '2026-03-26 09:15:24');

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_categories`
--

INSERT INTO `post_categories` (`post_id`, `category_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(3, 2);

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
  `verification_token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `verified`, `verification_token`, `reset_token`, `reset_expires`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, NULL, NULL, NULL, '2026-03-26 07:39:32', '2026-03-26 07:39:32'),
(3, 'testuser', 'testuser@example.com', '$2y$10$IqArIqs20y/sy1DKSX27uOhIhTubSAdulPBlMxdlwh30fD..DaBcy', 'user', 1, '0daec3a1e8fc3bda4bd7b79b969d86417744c77c29db87c8743ce5a217cfd28a', NULL, NULL, '2026-03-26 07:51:20', '2026-03-26 07:51:20'),
(4, 'user1', 'user1@example.com', '$2y$10$HYK60vAxD04ds3Af9WViOOGICXsqblwPe4HDwpg5zAYYzytJd507i', 'user', 1, '56a48879a8a30be0b8f235bd3fa9dba3b46624dc38206438d1b575fc3c6edb57', NULL, NULL, '2026-03-26 08:47:44', '2026-03-26 08:47:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`post_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD CONSTRAINT `post_categories_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
