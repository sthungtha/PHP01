-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2026 at 06:30 AM
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
-- Database: `task_management_demo1`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `task_id`, `user_id`, `action`, `created_at`) VALUES
(1, 1, 1, 'Task created: Update homepage hero section', '2026-03-26 22:03:44'),
(2, 1, 2, 'Status changed to In Progress', '2026-03-26 22:03:44'),
(3, 1, 2, 'Assigned to testuser', '2026-03-26 22:03:44'),
(12, 3, 2, 'Task updated', '2026-03-26 22:06:41'),
(13, 3, 2, 'Comment added', '2026-03-26 22:06:42'),
(14, 11, 2, 'Task updated', '2026-03-26 22:10:42'),
(15, 11, 2, 'Comment added', '2026-03-26 22:10:44'),
(16, 11, 2, 'Comment added', '2026-03-26 22:10:46'),
(17, 11, 2, 'Task updated', '2026-03-26 22:10:50'),
(18, 3, 2, 'Task updated', '2026-03-26 22:13:53'),
(19, 3, 2, 'Comment added', '2026-03-26 22:13:54'),
(21, 11, 2, 'Task updated', '2026-03-26 22:14:09'),
(22, 11, 2, 'Task updated', '2026-03-26 22:14:11'),
(23, 11, 2, 'Task updated', '2026-03-26 22:14:12'),
(25, 3, 2, 'Comment added', '2026-03-26 22:17:33'),
(26, 3, 2, 'Comment added', '2026-03-26 22:18:03'),
(27, 11, 2, 'Task updated', '2026-03-26 22:18:31'),
(29, 3, 2, 'Task updated', '2026-03-26 22:22:22'),
(30, 3, 2, 'Task updated', '2026-03-26 22:25:42'),
(31, 3, 2, 'Task updated', '2026-03-26 22:26:57'),
(32, 11, 2, 'Task updated', '2026-03-26 22:28:28'),
(33, 11, 2, 'Comment added', '2026-03-26 22:28:34'),
(34, 3, 2, 'Task updated', '2026-03-26 23:14:58'),
(35, 3, 2, 'Task updated', '2026-03-26 23:15:06'),
(36, 3, 2, 'Task updated', '2026-03-26 23:19:03'),
(37, 3, 2, 'Task updated', '2026-03-26 23:20:56'),
(38, 3, 2, 'Task updated', '2026-03-26 23:21:14'),
(39, 3, 2, 'Task updated', '2026-03-26 23:24:06'),
(40, 3, 2, 'Task updated', '2026-03-26 23:27:08'),
(41, 3, 2, 'Task updated', '2026-03-26 23:29:14'),
(45, 3, 2, 'Task updated', '2026-03-26 23:31:04'),
(52, 11, 2, 'Task updated', '2026-03-26 23:37:13'),
(53, 11, 2, 'Task updated', '2026-03-26 23:37:38'),
(54, 11, 2, 'Task updated', '2026-03-26 23:37:57'),
(55, 11, 2, 'Task updated', '2026-03-26 23:44:49'),
(56, 11, 2, 'Task updated', '2026-03-26 23:51:48'),
(57, 8, 2, 'Task updated', '2026-03-27 00:31:43'),
(58, 8, 2, 'Task updated', '2026-03-27 00:31:48'),
(59, 8, 2, 'Task updated', '2026-03-27 00:31:54'),
(60, 6, 2, 'Status changed to Done', '2026-03-27 00:35:24'),
(61, 7, 2, 'Status changed to Inprogress', '2026-03-27 00:35:30'),
(62, 13, 2, 'Status changed to Inprogress', '2026-03-27 00:36:14'),
(63, 11, 2, 'Status changed to Done', '2026-03-27 00:36:20'),
(64, 3, 2, 'Status changed to Inprogress', '2026-03-27 00:36:22'),
(65, 13, 2, 'Status changed to Done', '2026-03-27 00:36:25'),
(66, 26, 2, 'Task created: Implement user authentication', '2026-03-27 00:39:00'),
(67, 26, 2, 'Task updated', '2026-03-27 00:39:10'),
(68, 26, 2, 'Status changed to Inprogress', '2026-03-27 00:39:23'),
(69, 3, 2, 'Status changed to Todo', '2026-03-27 00:39:25'),
(70, 26, 2, 'Comment added', '2026-03-27 00:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `task_id`, `user_id`, `comment`, `created_at`) VALUES
(1, 1, 1, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-26 21:07:25'),
(2, 1, 1, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-26 21:08:14'),
(3, 11, 2, 'dsfsdf', '2026-03-26 21:09:45'),
(8, 13, 2, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-26 21:58:40'),
(9, 11, 2, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-26 22:00:29'),
(12, 3, 2, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-26 22:06:42'),
(13, 11, 2, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-26 22:10:44'),
(14, 11, 2, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-26 22:10:46'),
(15, 3, 2, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-26 22:13:54'),
(16, 3, 2, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-26 22:17:33'),
(17, 3, 2, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-26 22:18:03'),
(18, 11, 2, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-26 22:28:34'),
(19, 26, 2, 'This looks good. Please coordinate with marketing team before final approval.', '2026-03-27 00:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `created_by`, `created_at`) VALUES
(1, 'Website Redesign', 'Complete overhaul of company website', 1, '2026-03-26 20:35:57'),
(2, 'Mobile App Development', 'Build iOS and Android app', 1, '2026-03-26 20:35:57'),
(3, 'Website Redesign', 'Complete overhaul of the company website with modern design and improved user experience.', 2, '2026-03-26 20:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('todo','inprogress','done') DEFAULT 'todo',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `assigned_to` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `attachment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `title`, `description`, `status`, `priority`, `assigned_to`, `due_date`, `created_by`, `created_at`, `attachment`) VALUES
(1, 1, 'Design homepage', 'Create modern homepage layout', 'done', 'high', 2, NULL, NULL, '2026-03-26 20:35:57', NULL),
(2, 1, 'Setup navigation', 'Implement main menu and footer', 'inprogress', 'medium', 2, NULL, NULL, '2026-03-26 20:35:57', NULL),
(3, 2, 'Create login screen', 'Design user authentication UI', 'todo', 'medium', 2, '2026-03-13', NULL, '2026-03-26 20:35:57', NULL),
(4, 3, 'Design new homepage layout', 'Create modern homepage with improved UX', 'todo', 'medium', NULL, NULL, 2, '2026-03-26 20:39:47', NULL),
(5, 3, 'Design new homepage layout', 'Create modern homepage with improved UX', 'inprogress', 'medium', NULL, NULL, 2, '2026-03-26 20:39:54', NULL),
(6, 3, 'Design new homepage layout', 'Create modern homepage with improved UX', 'done', 'high', NULL, NULL, 2, '2026-03-26 20:39:59', NULL),
(7, 3, 'Create login page UI', 'Design and implement user login screen with validation', 'inprogress', 'low', NULL, NULL, 2, '2026-03-26 20:42:29', NULL),
(8, 1, 'Update homepage hero section', '', 'todo', 'medium', NULL, NULL, 2, '2026-03-26 20:43:19', '1774571508_smartwatch.jpg'),
(10, 3, 'Update homepage hero section', '', 'todo', 'medium', NULL, NULL, 2, '2026-03-26 20:45:37', NULL),
(11, 2, 'Update homepage hero section', '', 'done', 'medium', NULL, NULL, 2, '2026-03-26 20:47:27', '1774569108_coffeemaker.jpg'),
(13, 2, 'Create login page UI', '', 'done', 'medium', NULL, NULL, 2, '2026-03-26 20:52:47', NULL),
(26, 2, 'Implement user authentication', 'Create secure login and registration system with password hashing and CSRF protection. Include email verification simulation.', 'inprogress', 'medium', 2, '2026-04-03', 2, '2026-03-27 00:39:00', '1774571950_smartwatch.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','member') DEFAULT 'member',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@task.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-03-26 20:35:57'),
(2, 'testuser', 'test@task.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'member', '2026-03-26 20:35:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `assigned_to` (`assigned_to`),
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
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_log_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
