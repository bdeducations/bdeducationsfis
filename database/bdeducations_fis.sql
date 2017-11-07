-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2017 at 06:42 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdeducations_fis`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ut_allocations`
--

CREATE TABLE `ut_allocations` (
  `allocation_row_id` int(11) NOT NULL,
  `area_row_id` int(11) NOT NULL,
  `head_row_id` int(11) NOT NULL,
  `source_area_row_id` int(11) NOT NULL DEFAULT '0' COMMENT 'source area info for adjustment',
  `source_head_row_id` int(11) NOT NULL DEFAULT '0' COMMENT 'source head info for adjustment',
  `is_adjustment` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'check adjustment or allocation',
  `amount` decimal(14,2) NOT NULL,
  `remarks` text NOT NULL,
  `budget_year` year(4) NOT NULL DEFAULT '2017',
  `allocation_at` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ut_areas`
--

CREATE TABLE `ut_areas` (
  `area_row_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `area_code` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `status` int(3) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ut_areas`
--

INSERT INTO `ut_areas` (`area_row_id`, `title`, `area_code`, `description`, `sort_order`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'BD Educations', 'bdedu-1200', '', 1, 1, 2, 2, '2017-09-09 12:58:59', '2017-09-09 06:58:59');

-- --------------------------------------------------------

--
-- Table structure for table `ut_expenses`
--

CREATE TABLE `ut_expenses` (
  `expense_row_id` int(11) NOT NULL,
  `area_row_id` int(11) NOT NULL,
  `head_row_id` int(11) NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `remarks` text NOT NULL,
  `budget_year` year(4) NOT NULL DEFAULT '2017',
  `expense_at` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ut_heads`
--

CREATE TABLE `ut_heads` (
  `head_row_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `has_child` tinyint(1) NOT NULL DEFAULT '0',
  `level` int(11) DEFAULT NULL COMMENT 'head level, parent ~ 0, child ~ 1, grand-child ~ 2, great-grand-child ~ 3',
  `is_unforeseen` tinyint(1) NOT NULL DEFAULT '0',
  `is_project` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 ~ Means that projects Head',
  `status` int(3) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL COMMENT 'user id of head creator',
  `updated_by` int(11) NOT NULL COMMENT 'user id of head updator',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ut_heads`
--

INSERT INTO `ut_heads` (`head_row_id`, `title`, `description`, `sort_order`, `parent_id`, `has_child`, `level`, `is_unforeseen`, `is_project`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'DA Jamalpur Tour', '', 1, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:11:52', '2017-10-17 11:11:52'),
(2, 'Conveyance', '', 2, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:13:10', '2017-10-17 11:13:10'),
(3, 'Mobile Bill', '', 3, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:13:51', '2017-10-17 11:13:51'),
(4, 'Domain Bill', '', 5, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:15:20', '2017-10-17 11:15:20'),
(5, 'Stationary', '', 4, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:15:06', '2017-10-17 11:15:06'),
(6, 'Photocopy for Jamalpur Tour', '', 6, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:16:06', '2017-10-17 11:16:06'),
(7, 'Train Ticket for Jamalpur Tour', '', 7, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:16:47', '2017-10-17 11:16:47'),
(8, 'Other Cost Jamalpur Tour', '', 8, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:17:24', '2017-10-17 11:17:24'),
(9, 'Transport Cost Jamalpur Tour', '', 9, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:17:54', '2017-10-17 11:17:54'),
(10, 'Personal Cost', '', 10, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:18:24', '2017-10-17 11:18:24'),
(11, 'Guest Snaks', '', 12, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:19:18', '2017-10-17 11:19:18'),
(12, 'Modem Bill', '', 11, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:20:05', '2017-10-17 11:20:05'),
(13, 'Attendance Device', '', 13, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:20:39', '2017-10-17 11:20:39'),
(14, 'Memory Card', '', 14, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:21:00', '2017-10-17 11:21:00'),
(15, 'Mouse', '', 15, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:21:15', '2017-10-17 11:21:15'),
(16, 'Transport Cost Kishoreganj Tour', '', 16, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:22:14', '2017-10-17 11:22:14'),
(17, 'Other Cost Kishoreganj Tour', '', 17, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:22:49', '2017-10-17 11:22:49'),
(18, 'Book', '', 18, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:23:15', '2017-10-17 11:23:15'),
(19, 'Ball Pen', '', 19, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:23:46', '2017-10-17 11:23:46'),
(20, 'Lunch Bill', '', 20, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:24:56', '2017-10-17 11:24:56'),
(21, 'DA for Feni Tour', '', 21, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:25:48', '2017-10-17 11:25:48'),
(22, 'TA for Feni Tour', '', 22, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:26:19', '2017-10-17 11:26:19'),
(23, 'Battery', '', 23, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:26:52', '2017-10-17 11:26:52'),
(24, 'UPS', '', 24, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:27:11', '2017-10-17 11:27:11'),
(25, 'Headphone', '', 25, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:27:23', '2017-10-17 11:27:23'),
(26, 'RAM', '', 26, 0, 0, 0, 0, 0, 1, 2, 2, '2017-10-17 11:27:56', '2017-10-17 11:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `ut_project_heads`
--

CREATE TABLE `ut_project_heads` (
  `project_head_row_id` int(11) NOT NULL,
  `head_row_id` int(11) NOT NULL,
  `budget_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ut_users`
--

CREATE TABLE `ut_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ut_users`
--

INSERT INTO `ut_users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'info@unitedtrust.org', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', 'w84j5AovyTwlXfu6XwiYLxQyZgOA7WrZRuPeZFlgKtApcSyZIZxT3Ob46ZyT', '2017-02-13 03:31:59', '2017-02-13 03:31:59'),
(2, 'Md.Sakoat Hossen', 'sakoatcse@gmail.com', '$2y$10$YEM6BvfpKfZdYT/kQ2djPujxzCePLGNrDTyBK/CCV7t13dP7DRSI.', 'B3EDGGfk09HznFNr8501VLullYWyywaIOocYpd2ePoeiC8oKYoVyBttwdfUT', '2017-02-14 00:05:08', '2017-02-14 00:05:08'),
(3, 'Ebadur Rahman', 'ebadur.info@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', 'Kcpi3Hw3MJ5e2gSc6CZLQAxfjrytI1UKKULvVtgRqdqtiRs3XjDm15IZ2qmT', '2017-03-05 01:14:55', '2017-03-05 01:14:55'),
(4, 'Shahedul Islam', 'modhumoti75@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', 'HPEy2pTJ1RM9I7506dIq6r37inh9oFmnEHVgdI1mhZDRl6SDz778Fbf2u38U', '2017-03-05 01:14:55', '2017-03-05 01:14:55'),
(5, 'Suman Ahmmed', 'sumanahmmed@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', '3nqkt2WBSPNNF4ucsJ27Qjj0k4N0rsmV48g0ZMMcLz3IeAKSLNvf8nOtigdQ', '2017-03-05 01:14:55', '2017-03-05 01:14:55'),
(6, 'Sharmin Yusuf', 'sharminyusuf1971@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', '3nqkt2WBSPNNF4ucsJ27Qjj0k4N0rsmV48g0ZMMcLz3IeAKSLNvf8nOtigdQ', '2017-03-05 01:14:55', '2017-03-05 01:14:55'),
(7, 'Masud Zaman', 'enggmasud1983@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', 'HPEy2pTJ1RM9I7506dIq6r37inh9oFmnEHVgdI1mhZDRl6SDz778Fbf2u38U', '2017-03-05 01:14:55', '2017-03-05 01:14:55'),
(9, 'Jashodhan Saha', 'jashodhan@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', '3nqkt2WBSPNNF4ucsJ27Qjj0k4N0rsmV48g0ZMMcLz3IeAKSLNvf8nOtigdQ', '2017-03-05 01:14:55', '2017-03-05 01:14:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `ut_allocations`
--
ALTER TABLE `ut_allocations`
  ADD PRIMARY KEY (`allocation_row_id`);

--
-- Indexes for table `ut_areas`
--
ALTER TABLE `ut_areas`
  ADD PRIMARY KEY (`area_row_id`);

--
-- Indexes for table `ut_expenses`
--
ALTER TABLE `ut_expenses`
  ADD PRIMARY KEY (`expense_row_id`);

--
-- Indexes for table `ut_heads`
--
ALTER TABLE `ut_heads`
  ADD PRIMARY KEY (`head_row_id`);

--
-- Indexes for table `ut_project_heads`
--
ALTER TABLE `ut_project_heads`
  ADD PRIMARY KEY (`project_head_row_id`);

--
-- Indexes for table `ut_users`
--
ALTER TABLE `ut_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ut_allocations`
--
ALTER TABLE `ut_allocations`
  MODIFY `allocation_row_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ut_areas`
--
ALTER TABLE `ut_areas`
  MODIFY `area_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ut_expenses`
--
ALTER TABLE `ut_expenses`
  MODIFY `expense_row_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ut_heads`
--
ALTER TABLE `ut_heads`
  MODIFY `head_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `ut_project_heads`
--
ALTER TABLE `ut_project_heads`
  MODIFY `project_head_row_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ut_users`
--
ALTER TABLE `ut_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
