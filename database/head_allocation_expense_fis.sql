-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2017 at 11:33 AM
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

--
-- Dumping data for table `ut_allocations`
--

INSERT INTO `ut_allocations` (`allocation_row_id`, `area_row_id`, `head_row_id`, `source_area_row_id`, `source_head_row_id`, `is_adjustment`, `amount`, `remarks`, `budget_year`, `allocation_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 0, 0, '1000000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 15:17:43', '2017-11-08 15:17:43'),
(2, 1, 2, 0, 0, 0, '1000000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 15:48:53', '2017-11-08 15:48:53'),
(3, 1, 10, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 15:50:52', '2017-11-08 15:50:52'),
(4, 1, 29, 0, 0, 0, '1000000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 15:56:06', '2017-11-08 15:56:06'),
(5, 1, 5, 0, 0, 0, '1000000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 15:57:13', '2017-11-08 15:57:13'),
(6, 1, 11, 0, 0, 0, '1000000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 15:58:06', '2017-11-08 15:58:06'),
(7, 1, 29, 0, 0, 0, '100000.00', '', 2017, '2017-11-03', 2, 2, '2017-11-08 15:59:15', '2017-11-08 15:59:15'),
(8, 1, 30, 0, 0, 0, '10000.00', '', 2017, '2017-11-02', 2, 2, '2017-11-08 16:00:15', '2017-11-08 16:00:15'),
(9, 1, 14, 0, 0, 0, '10000.00', '', 2017, '2017-11-05', 2, 2, '2017-11-08 16:41:38', '2017-11-08 16:41:38'),
(10, 1, 3, 0, 0, 0, '100000.00', '', 2017, '2017-11-04', 2, 2, '2017-11-08 16:42:56', '2017-11-08 16:42:56'),
(11, 1, 17, 0, 0, 0, '10000.00', '', 2017, '2017-11-04', 2, 2, '2017-11-08 16:44:25', '2017-11-08 16:44:25'),
(12, 1, 28, 0, 0, 0, '10000.00', '', 2017, '2017-11-02', 2, 2, '2017-11-08 16:44:50', '2017-11-08 16:44:50'),
(13, 1, 32, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:45:32', '2017-11-08 16:45:32'),
(14, 1, 21, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:47:33', '2017-11-08 16:47:33'),
(15, 1, 21, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:48', '2017-11-08 16:52:48'),
(16, 1, 19, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:48', '2017-11-08 16:52:48'),
(17, 1, 3, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:48', '2017-11-08 16:52:48'),
(18, 1, 4, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:48', '2017-11-08 16:52:48'),
(19, 1, 6, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:48', '2017-11-08 16:52:48'),
(20, 1, 22, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:48', '2017-11-08 16:52:48'),
(21, 1, 23, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:48', '2017-11-08 16:52:48'),
(22, 1, 24, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:49', '2017-11-08 16:52:49'),
(23, 1, 25, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:49', '2017-11-08 16:52:49'),
(24, 1, 26, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:49', '2017-11-08 16:52:49'),
(25, 1, 27, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:49', '2017-11-08 16:52:49'),
(26, 1, 31, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:49', '2017-11-08 16:52:49'),
(27, 1, 34, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:52:49', '2017-11-08 16:52:49'),
(28, 1, 33, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:58:56', '2017-11-08 16:58:56'),
(29, 1, 35, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-08 16:58:56', '2017-11-08 16:58:56'),
(30, 1, 39, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-09 12:22:10', '2017-11-09 12:22:10'),
(31, 1, 40, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-09 12:22:10', '2017-11-09 12:22:10'),
(32, 1, 13, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-09 12:24:14', '2017-11-09 12:24:14'),
(33, 1, 12, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-09 12:24:15', '2017-11-09 12:24:15'),
(34, 1, 15, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-09 12:28:31', '2017-11-09 12:28:31'),
(35, 1, 16, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-09 12:28:31', '2017-11-09 12:28:31'),
(36, 1, 20, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-09 12:34:56', '2017-11-09 12:34:56'),
(37, 1, 38, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-09 12:34:56', '2017-11-09 12:34:56'),
(38, 1, 36, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-09 12:35:35', '2017-11-09 12:35:35'),
(39, 1, 37, 0, 0, 0, '100000.00', '', 2017, '2017-11-01', 2, 2, '2017-11-09 12:35:35', '2017-11-09 12:35:35'),
(40, 1, 41, 0, 0, 0, '100000.00', '', 2017, '2017-10-30', 2, 2, '2017-11-09 12:50:14', '2017-11-09 12:50:14');

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
(1, 'Dhaka', 'BDEDU-12000', '', 1, 1, 2, 2, '2017-11-08 11:58:28', '2017-11-08 05:58:28'),
(2, 'Kishoreganj', 'BDEDU-12001', '', 2, 1, 2, 2, '2017-11-08 11:57:55', '2017-11-08 11:57:55'),
(3, 'Jamalpur', 'BDEDU-12004', '', 5, 1, 2, 2, '2017-11-08 12:01:00', '2017-11-08 06:01:00'),
(4, 'Munshigonj', 'BDEDU-12002', '', 3, 1, 2, 2, '2017-11-08 12:00:44', '2017-11-08 06:00:44'),
(5, 'Feni', 'BDEDU-12003', '', 4, 1, 2, 2, '2017-11-08 12:00:52', '2017-11-08 06:00:52');

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

--
-- Dumping data for table `ut_expenses`
--

INSERT INTO `ut_expenses` (`expense_row_id`, `area_row_id`, `head_row_id`, `amount`, `remarks`, `budget_year`, `expense_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '3500.00', '0', 2017, '2017-11-01', 2, 2, '2017-11-08 17:00:06', '2017-11-08 17:00:06'),
(2, 1, 6, '900.00', '0', 2017, '2017-11-05', 2, 2, '2017-11-08 17:00:43', '2017-11-08 17:00:43'),
(3, 1, 1, '2100.00', 'Tuhin', 2017, '2017-08-02', 2, 2, '2017-11-09 12:37:43', '2017-11-09 12:37:43'),
(4, 1, 1, '2100.00', 'Ebadur', 2017, '2017-08-02', 2, 2, '2017-11-09 12:37:43', '2017-11-09 12:37:43'),
(5, 1, 1, '2100.00', 'Rashed', 2017, '2017-08-02', 2, 2, '2017-11-09 12:38:23', '2017-11-09 12:38:23'),
(6, 1, 4, '1100.00', 'Audio Recording', 2017, '2017-06-02', 2, 2, '2017-11-09 12:39:45', '2017-11-09 12:39:45'),
(7, 1, 2, '2299.00', 'Feni Tour(Manik and Rashed)', 2017, '2017-04-17', 2, 2, '2017-11-09 12:42:05', '2017-11-09 12:42:05'),
(8, 1, 11, '300.00', 'Shohid', 2017, '2017-08-02', 2, 2, '2017-11-09 12:42:49', '2017-11-09 12:42:49'),
(9, 1, 5, '390.00', 'Shohid', 2017, '2017-06-01', 2, 2, '2017-11-09 12:44:26', '2017-11-09 12:44:26'),
(10, 1, 24, '10000.00', 'Mac UPS', 2017, '2017-04-09', 2, 2, '2017-11-09 12:45:45', '2017-11-09 12:45:45'),
(11, 1, 25, '4400.00', 'Mac', 2017, '2017-04-11', 2, 2, '2017-11-09 12:46:10', '2017-11-09 12:46:10'),
(12, 1, 27, '339.00', 'Internet Bill', 2017, '2017-04-17', 2, 2, '2017-11-09 12:46:52', '2017-11-09 12:46:52'),
(13, 1, 23, '2000.00', '0', 2017, '2017-06-10', 2, 2, '2017-11-09 12:49:05', '2017-11-09 12:49:05'),
(14, 1, 41, '950.00', '0', 2017, '2017-06-13', 2, 2, '2017-11-09 12:50:29', '2017-11-09 12:50:29'),
(15, 1, 26, '7700.00', 'Two 4GB', 2017, '2017-05-11', 2, 2, '2017-11-09 12:51:16', '2017-11-09 12:51:16'),
(16, 1, 31, '23700.00', 'TP Link Brand', 2017, '2017-04-26', 2, 2, '2017-11-09 12:52:03', '2017-11-09 12:52:03'),
(17, 1, 27, '4500.00', 'SIM and ITEL Banglalink', 2017, '2017-04-26', 2, 2, '2017-11-09 12:53:12', '2017-11-09 12:53:12');

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
(1, 'DA', '', 1, 0, 0, 0, 0, 0, 1, 2, 2, '2017-11-08 12:33:36', '2017-11-08 12:33:36'),
(2, 'TA', '', 2, 0, 0, 0, 0, 0, 1, 2, 2, '2017-11-08 12:33:46', '2017-11-08 12:33:46'),
(3, 'Attendance Device', '', 3, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 13:37:29', '2017-11-08 13:37:29'),
(4, 'Memory Card', '', 4, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 13:37:40', '2017-11-08 13:37:40'),
(5, 'Conveyance', '', 5, 0, 0, 0, 0, 0, 1, 2, 2, '2017-11-08 12:35:11', '2017-11-08 12:35:11'),
(6, 'Mouse', '', 5, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 13:38:27', '2017-11-08 13:38:27'),
(7, 'Computer and Electronic Equipment', '', 3, 0, 1, 0, 0, 0, 1, 2, 2, '2017-11-08 13:37:30', '2017-11-08 13:37:30'),
(8, 'Stationary', '', 4, 0, 1, 0, 0, 0, 1, 2, 2, '2017-11-08 12:49:38', '2017-11-08 12:49:38'),
(9, 'Web and Software Tools', '', 6, 0, 1, 0, 0, 0, 1, 2, 2, '2017-11-08 15:01:08', '2017-11-08 15:01:08'),
(10, 'A4 Printing Paper', '', 1, 8, 0, 1, 0, 0, 1, 2, 2, '2017-11-09 11:54:59', '2017-11-09 11:54:59'),
(11, 'Mobile Bill', '', 7, 0, 0, 0, 0, 0, 1, 2, 2, '2017-11-08 13:43:16', '2017-11-08 13:43:16'),
(12, 'Photocopy', '', 10, 0, 0, 0, 0, 0, 1, 2, 2, '2017-11-08 13:43:29', '2017-11-08 13:43:29'),
(13, 'Lunch Bill', '', 8, 0, 0, 0, 0, 0, 1, 2, 2, '2017-11-08 13:41:20', '2017-11-08 13:41:20'),
(14, 'Train Ticket', '', 9, 0, 0, 0, 0, 0, 1, 2, 2, '2017-11-08 13:42:32', '2017-11-08 13:42:32'),
(15, 'Snaks', '', 11, 0, 0, 0, 0, 0, 1, 2, 2, '2017-11-08 13:44:15', '2017-11-08 13:44:15'),
(16, 'Books', '', 12, 0, 0, 0, 0, 0, 1, 2, 2, '2017-11-08 13:44:26', '2017-11-08 13:44:26'),
(17, 'Ball Pen', '', 2, 8, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 13:47:06', '2017-11-08 13:47:06'),
(18, 'Cleaning Accessories', '', 13, 0, 1, 0, 0, 0, 1, 2, 2, '2017-11-09 11:54:22', '2017-11-09 11:54:22'),
(19, 'IC Card and Ribbon', '', 2, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:53:02', '2017-11-08 14:53:02'),
(20, 'Glass Cleaner', '', 1, 18, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:54:02', '2017-11-08 14:54:02'),
(21, 'USB Cable', '', 1, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:54:31', '2017-11-08 14:54:31'),
(22, 'NFC and LF Reader', '', 6, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:55:16', '2017-11-08 14:55:16'),
(23, 'Battery', '', 7, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:56:16', '2017-11-08 14:56:16'),
(24, 'UPS', '', 8, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:56:26', '2017-11-08 14:56:26'),
(25, 'Headphone', '', 9, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:56:44', '2017-11-08 14:56:44'),
(26, 'RAM', '', 10, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:57:02', '2017-11-08 14:57:02'),
(27, 'Modem', '', 11, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:57:20', '2017-11-08 14:57:20'),
(28, 'Auto Seal', '', 4, 8, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:58:13', '2017-11-08 14:58:13'),
(29, 'Facial Tissue', '', 3, 8, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:59:05', '2017-11-08 14:59:05'),
(30, 'Toilet Tissue', '', 5, 8, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 14:59:27', '2017-11-08 14:59:27'),
(31, 'Router and Wireless Device', '', 12, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 15:02:33', '2017-11-08 15:02:33'),
(32, 'Server Bill', '', 1, 9, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 15:01:08', '2017-11-08 15:01:08'),
(33, 'Template Bill', '', 2, 9, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 15:01:29', '2017-11-08 15:01:29'),
(34, 'Switch and Poch Cod', '', 13, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 15:03:03', '2017-11-08 15:03:03'),
(35, 'Domains Bill', '', 3, 9, 0, 1, 0, 0, 1, 2, 2, '2017-11-08 15:03:41', '2017-11-08 15:03:41'),
(36, 'Handwash', '', 5, 18, 0, 1, 0, 0, 1, 2, 2, '2017-11-09 11:57:07', '2017-11-09 11:57:07'),
(37, 'Mr.Brasso', '', 3, 18, 0, 1, 0, 0, 1, 2, 2, '2017-11-09 12:03:03', '2017-11-09 12:03:03'),
(38, 'Harpic', '', 2, 18, 0, 1, 0, 0, 1, 2, 2, '2017-11-09 11:58:45', '2017-11-09 11:58:45'),
(39, 'Air Freshner', '', 6, 8, 0, 1, 0, 0, 1, 2, 2, '2017-11-09 12:00:15', '2017-11-09 12:00:15'),
(40, 'Marker Pen', '', 7, 8, 0, 1, 0, 0, 1, 2, 2, '2017-11-09 12:04:27', '2017-11-09 12:04:27'),
(41, 'Adapter and Charger', '', 14, 7, 0, 1, 0, 0, 1, 2, 2, '2017-11-09 12:48:31', '2017-11-09 12:48:31');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ut_allocations`
--
ALTER TABLE `ut_allocations`
  MODIFY `allocation_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `ut_areas`
--
ALTER TABLE `ut_areas`
  MODIFY `area_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ut_expenses`
--
ALTER TABLE `ut_expenses`
  MODIFY `expense_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `ut_heads`
--
ALTER TABLE `ut_heads`
  MODIFY `head_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
