-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2017 at 05:03 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

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
(1, 'Dhaka', 'Dhaka-1200', '', 1, 1, 2, 1, '2017-11-06 12:50:38', '2017-11-06 06:50:38');

-- --------------------------------------------------------

--
-- Table structure for table `ut_districts`
--

CREATE TABLE `ut_districts` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ut_districts`
--

INSERT INTO `ut_districts` (`id`, `full_name`, `short_name`, `created_at`, `updated_at`) VALUES
(1, 'Dhaka', '01', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(2, 'Rajshahi', '02', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(3, 'Khulna', '03', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(4, 'Chittagong', '04', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(5, 'Barisal', '05', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(6, 'Sylhet', '06', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(7, 'Rangpur', '07', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(8, 'Manikgonj', '08', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(9, 'Gazipur', '09', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(10, 'Mymensingh', '10', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(11, 'Narayanganj', '11', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(12, 'Tangail', '12', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(13, 'Madaripur', '13', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(14, 'Jamalpur', '14', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(15, 'Munshiganj', '15', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(16, 'Gopalganj', '16', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(17, 'Sherpur', '17', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(18, 'Kishoreganj', '18', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(19, 'Narsingdi', '19', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(20, 'Shariatpur', '20', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(21, 'Netrokona', '21', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(22, 'Rajbari', '22', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(23, 'Faridpur', '23', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(24, 'Bogra', '24', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(25, 'Joypurhat', '25', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(26, 'Naogaon', '26', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(27, 'Natore', '27', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(28, 'Chapai Nawabganj', '28', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(29, 'Pabna', '29', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(30, 'Sirajganj', '30', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(31, 'Shatkhira', '31', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(32, 'Bagerhat', '32', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(33, 'Jessore', '33', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(34, 'Narail', '34', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(35, 'Magura', '35', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(36, 'Jhenaidah', '36', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(37, 'Chuadanga', '37', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(38, 'Kushtia', '38', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(39, 'Meherpur', '39', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(40, 'Bandarban', '40', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(41, 'Rangamati', '41', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(42, 'Khagrachari', '42', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(43, 'Cox\'s Bazar', '43', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(44, 'Feni', '44', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(45, 'Noakhali', '45', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(46, 'Lakshmipur', '46', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(47, 'Comilla', '47', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(48, 'Brahmanbaria', '48', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(49, 'Chandpur', '49', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(50, 'Barguna', '50', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(51, 'Bhola', '51', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(52, 'Jhalokati', '52', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(53, 'Patuakhali', '53', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(54, 'Pirojpur', '54', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(55, 'Maulvi Bazar', '55', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(56, 'Habiganj', '56', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(57, 'Sunamgonj', '57', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(58, 'Dinajpur', '58', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(59, 'Gaibandha', '59', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(60, 'Kurigram', '60', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(61, 'Lalmonirhat', '61', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(62, 'Nilphamari', '62', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(63, 'Panchagarh', '63', '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(64, 'Thakurgaon', '64', '2014-10-29 00:00:00', '2014-10-29 00:00:00');

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
-- Table structure for table `ut_hr_academic_calendars`
--

CREATE TABLE `ut_hr_academic_calendars` (
  `event_row_id` int(11) NOT NULL,
  `event_title` varchar(255) DEFAULT NULL,
  `event_start_date` varchar(255) DEFAULT NULL,
  `event_end_date` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ut_hr_academic_calendars`
--

INSERT INTO `ut_hr_academic_calendars` (`event_row_id`, `event_title`, `event_start_date`, `event_end_date`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(43, 'Annual Sports Competition ', '2017-01-21', '2017-01-31', '2017-09-17 15:33:16', '2017-09-17 15:33:16', NULL, NULL),
(44, 'Class Activities & Book Distribution ', '2017-01-01', '2017-01-01', '2017-09-17 15:34:02', '2017-09-17 15:34:02', NULL, NULL),
(45, 'Fatiha-E-Eajdaham', '2017-01-10', '2017-01-10', '2017-09-17 15:34:41', '2017-09-17 15:34:41', NULL, NULL),
(46, 'Sharashwaati puja', '2017-02-01', '2017-02-01', '2017-09-17 15:40:26', '2017-09-17 15:40:26', NULL, NULL),
(48, 'International Mother Language Day', '2017-02-21', '2017-02-21', '2017-09-17 15:41:39', '2017-09-17 15:41:39', NULL, NULL),
(49, 'Maghi purnima', '2017-02-10', '2017-02-10', '2017-09-17 15:42:18', '2017-09-17 15:42:18', NULL, NULL),
(50, 'Shib Ratri', '2017-02-24', '2017-02-24', '2017-09-17 15:42:57', '2017-09-17 15:42:57', NULL, NULL),
(51, 'Class Test-1 Starts 1-X', '2017-03-08', '2017-03-19', '2017-09-18 09:40:31', '2017-09-18 09:40:31', NULL, NULL),
(52, 'Dol jatra', '2017-03-12', '2017-03-12', '2017-09-18 09:40:59', '2017-09-18 09:40:59', NULL, NULL),
(53, 'Celebration of birth anniversary of the father of the nation', '2017-03-17', '2017-03-17', '2017-09-18 09:42:40', '2017-09-18 09:42:40', NULL, NULL),
(54, 'Independence day', '2017-03-26', '2017-03-26', '2017-09-18 09:43:25', '2017-09-18 09:43:25', NULL, NULL),
(55, 'Science fair', '2017-03-25', '2017-03-30', '2017-09-18 09:43:58', '2017-09-18 09:43:58', NULL, NULL),
(56, '1st term exam', '2017-04-05', '2017-04-27', '2017-09-18 09:45:18', '2017-09-18 09:45:18', NULL, NULL),
(57, 'Bangla new year', '2017-04-14', '2017-04-14', '2017-09-18 09:46:18', '2017-09-18 09:46:18', NULL, NULL),
(58, 'Shab-E-Meraz', '2017-04-25', '2017-04-25', '2017-09-18 09:46:58', '2017-09-18 09:46:58', NULL, NULL),
(59, 'May day', '2017-05-01', '2017-05-01', '2017-09-18 09:47:18', '2017-09-18 09:47:18', NULL, NULL),
(60, '1st term exam result', '2017-05-17', '2017-05-17', '2017-09-18 09:47:53', '2017-09-18 09:47:53', NULL, NULL),
(61, 'Ramadan,Shob-E-Qadr & Eid-Ul-Fitr vacation', '2017-05-28', '2017-07-01', '2017-09-18 09:50:48', '2017-09-18 09:50:48', NULL, NULL),
(62, 'Class-X pre-test exam', '2017-07-03', '2017-07-20', '2017-09-18 09:55:38', '2017-09-18 09:55:38', NULL, NULL),
(63, 'Janmastomy', '2017-08-14', '2017-08-14', '2017-09-18 09:56:34', '2017-09-18 09:56:34', NULL, NULL),
(64, 'National Mourning day', '2017-08-15', '2017-08-15', '2017-09-18 09:58:13', '2017-09-18 09:58:13', NULL, NULL),
(66, 'Eid-Ul-Azha vacation', '2017-08-29', '2017-09-07', '2017-09-18 10:02:07', '2017-09-18 10:02:07', NULL, NULL),
(67, '2nd term exam ', '2017-07-03', '2017-07-20', '2017-09-18 10:03:12', '2017-09-18 10:03:12', NULL, NULL),
(68, 'Durga puja', '2017-09-26', '2017-09-30', '2017-09-18 10:03:56', '2017-09-18 10:03:56', NULL, NULL),
(69, 'Holy ashura', '2017-10-01', '2017-10-01', '2017-09-18 10:04:13', '2017-09-18 10:04:13', NULL, NULL),
(70, 'Final exam', '2017-11-20', '2017-12-10', '2017-09-18 10:05:34', '2017-09-18 10:05:34', NULL, NULL),
(71, 'Winter vacation', '2017-12-21', '2017-12-31', '2017-09-18 10:06:27', '2017-09-18 10:06:27', NULL, NULL),
(80, 'Eid', '08/01/2017', '08/08/2017', '2017-10-31 11:15:32', '2017-10-31 11:15:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_departments`
--

CREATE TABLE `ut_hr_departments` (
  `department_row_id` int(11) NOT NULL,
  `department_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ut_hr_departments`
--

INSERT INTO `ut_hr_departments` (`department_row_id`, `department_name`, `sort_order`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(14, 'IT', 2, 1, '2017-11-06 13:14:59', 1, NULL, NULL),
(15, 'Faculty', 3, 1, '2017-11-06 13:15:07', 1, NULL, NULL),
(16, 'Office Staff', 4, 1, '2017-11-06 13:16:31', 1, NULL, NULL),
(17, 'Governing Body', 1, 1, '2017-11-06 13:17:07', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_designations`
--

CREATE TABLE `ut_hr_designations` (
  `designation_row_id` int(11) NOT NULL,
  `designation_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `department_row_id` int(11) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ut_hr_designations`
--

INSERT INTO `ut_hr_designations` (`designation_row_id`, `designation_name`, `department_row_id`, `sort_order`, `is_active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(69, 'Software engineer', 14, 3, 1, 1, '2017-11-06 14:34:26', 1, '2017-11-06 14:34:26'),
(70, 'Lead Software Engineer', 14, 1, 1, 1, '2017-11-06 15:34:22', NULL, '2017-11-06 15:34:22'),
(71, 'Sr. Software Engineer', 14, 2, 1, 1, '2017-11-06 15:34:48', NULL, '2017-11-06 15:34:48'),
(72, 'Composer & Graphics Designer', 14, 4, 1, 1, '2017-11-06 15:36:05', NULL, '2017-11-06 15:36:05'),
(73, 'IT Executive', 14, 6, 1, 1, '2017-11-06 15:37:10', NULL, '2017-11-06 15:37:10'),
(74, 'Office Executive', 14, 5, 1, 1, '2017-11-06 15:37:22', NULL, '2017-11-06 15:37:22'),
(75, 'Front End Developer', 14, 7, 1, 1, '2017-11-06 15:38:02', NULL, '2017-11-06 15:38:02'),
(76, 'Research Associate', 14, 8, 1, 1, '2017-11-06 15:38:16', NULL, '2017-11-06 15:38:16'),
(77, 'Software Engineer & Research Associate', 14, 9, 1, 1, '2017-11-06 15:38:38', NULL, '2017-11-06 15:38:38'),
(78, 'Graphic Designer', 14, 10, 1, 1, '2017-11-06 15:38:53', 1, '2017-11-06 15:38:53'),
(79, 'Software Engineer & Multimedia Analyst', 14, 11, 1, 1, '2017-11-06 15:39:23', NULL, '2017-11-06 15:39:23'),
(80, 'Jr. Software Engineer', 14, 12, 1, 1, '2017-11-06 15:39:42', NULL, '2017-11-06 15:39:42'),
(81, 'Liaison Officer & Front End Developer', 14, 13, 1, 1, '2017-11-06 15:40:02', NULL, '2017-11-06 15:40:02'),
(82, 'Head of IT, Asiya Bari Ideal School', 14, 14, 1, 1, '2017-11-06 15:40:32', NULL, '2017-11-06 15:40:32'),
(83, 'Coordinator - English & Communications', 15, 1, 1, 1, '2017-11-06 15:42:55', NULL, '2017-11-06 15:42:55'),
(84, 'Faculty- Physics', 15, 2, 1, 1, '2017-11-06 15:43:17', NULL, '2017-11-06 15:43:17'),
(85, 'Faculty-ICT', 15, 3, 1, 1, '2017-11-06 15:43:30', NULL, '2017-11-06 15:43:30'),
(86, 'Jr. Faculty- Chemistry', 15, 4, 1, 1, '2017-11-06 15:43:54', NULL, '2017-11-06 15:43:54'),
(87, 'Jr. Faculty-Biology', 15, 5, 1, 1, '2017-11-06 15:44:26', NULL, '2017-11-06 15:44:26'),
(88, 'Faculty- Science (Primary)', 15, 6, 1, 1, '2017-11-06 15:44:41', NULL, '2017-11-06 15:44:41'),
(89, 'Faculty- English', 15, 7, 1, 1, '2017-11-06 15:44:53', NULL, '2017-11-06 15:44:53'),
(90, 'Faculty- BGS', 15, 8, 1, 1, '2017-11-06 15:45:07', NULL, '2017-11-06 15:45:07'),
(91, 'Faculty- Mathematics', 15, 9, 1, 1, '2017-11-06 15:45:23', NULL, '2017-11-06 15:45:23'),
(92, 'Faculty- Biology', 15, 10, 1, 1, '2017-11-06 15:45:48', NULL, '2017-11-06 15:45:48'),
(93, 'Faculty- English & Communication', 15, 11, 1, 1, '2017-11-06 15:46:38', NULL, '2017-11-06 15:46:38'),
(94, 'Faculty (Part time)', 15, 12, 1, 1, '2017-11-06 15:47:38', NULL, '2017-11-06 15:47:38'),
(95, 'Jr. Officer, Admin', 15, 13, 1, 1, '2017-11-06 15:47:50', NULL, '2017-11-06 15:47:50'),
(96, 'Adviser, International Affairs', 15, 14, 1, 1, '2017-11-06 15:48:00', 1, '2017-11-06 15:48:00'),
(97, 'Executive, Admin & Academic', 14, 15, 1, 1, '2017-11-06 17:12:33', NULL, '2017-11-06 17:12:33'),
(98, 'Faculty', 15, 15, 1, 1, '2017-11-06 17:23:54', NULL, '2017-11-06 17:23:54'),
(99, 'Receptionist', 16, 1, 1, 1, '2017-11-07 09:13:57', NULL, '2017-11-07 09:13:57'),
(100, 'Peon', 16, 2, 1, 1, '2017-11-07 09:14:55', NULL, '2017-11-07 09:14:55'),
(101, 'Jr. Officer, Admin', 16, 3, 1, 1, '2017-11-07 09:15:26', NULL, '2017-11-07 09:15:26'),
(102, 'Chairman', 17, 1, 1, 1, '2017-11-07 09:45:15', NULL, '2017-11-07 09:45:15'),
(103, 'Managing director', 17, 2, 1, 1, '2017-11-07 09:45:28', NULL, '2017-11-07 09:45:28'),
(104, 'Director', 17, 3, 1, 1, '2017-11-07 09:45:39', NULL, '2017-11-07 09:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_districts`
--

CREATE TABLE `ut_hr_districts` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `division_id` int(3) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ut_hr_districts`
--

INSERT INTO `ut_hr_districts` (`id`, `full_name`, `short_name`, `division_id`, `created_at`, `updated_at`) VALUES
(1, 'Dhaka', '01', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(2, 'Rajshahi', '02', 3, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(3, 'Khulna', '03', 4, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(4, 'Chittagong', '04', 2, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(5, 'Barisal', '05', 5, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(6, 'Sylhet', '06', 6, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(7, 'Rangpur', '07', 7, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(8, 'Manikgonj', '08', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(9, 'Gazipur', '09', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(10, 'Mymensingh', '10', 8, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(11, 'Narayanganj', '11', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(12, 'Tangail', '12', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(13, 'Madaripur', '13', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(14, 'Jamalpur', '14', 8, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(15, 'Munshiganj', '15', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(16, 'Gopalganj', '16', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(17, 'Sherpur', '17', 8, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(18, 'Kishoreganj', '18', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(19, 'Narsingdi', '19', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(20, 'Shariatpur', '20', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(21, 'Netrokona', '21', 8, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(22, 'Rajbari', '22', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(23, 'Faridpur', '23', 1, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(24, 'Bogra', '24', 3, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(25, 'Joypurhat', '25', 3, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(26, 'Naogaon', '26', 3, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(27, 'Natore', '27', 3, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(28, 'Chapai Nawabganj', '28', 3, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(29, 'Pabna', '29', 3, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(30, 'Sirajganj', '30', 3, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(31, 'Shatkhira', '31', 4, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(32, 'Bagerhat', '32', 4, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(33, 'Jessore', '33', 4, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(34, 'Narail', '34', 4, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(35, 'Magura', '35', 4, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(36, 'Jhenaidah', '36', 4, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(37, 'Chuadanga', '37', 4, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(38, 'Kushtia', '38', 4, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(39, 'Meherpur', '39', 4, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(40, 'Bandarban', '40', 2, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(41, 'Rangamati', '41', 2, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(42, 'Khagrachari', '42', 2, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(43, 'Cox\'s Bazar', '43', 2, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(44, 'Feni', '44', 2, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(45, 'Noakhali', '45', 2, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(46, 'Lakshmipur', '46', 2, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(47, 'Comilla', '47', 2, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(48, 'Brahmanbaria', '48', 2, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(49, 'Chandpur', '49', 2, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(50, 'Barguna', '50', 5, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(51, 'Bhola', '51', 5, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(52, 'Jhalokati', '52', 5, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(53, 'Patuakhali', '53', 5, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(54, 'Pirojpur', '54', 5, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(55, 'Maulvi Bazar', '55', 6, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(56, 'Habiganj', '56', 6, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(57, 'Sunamgonj', '57', 6, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(58, 'Dinajpur', '58', 7, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(59, 'Gaibandha', '59', 7, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(60, 'Kurigram', '60', 7, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(61, 'Lalmonirhat', '61', 7, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(62, 'Nilphamari', '62', 7, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(63, 'Panchagarh', '63', 7, '2014-10-29 00:00:00', '2014-10-29 00:00:00'),
(64, 'Thakurgaon', '64', 7, '2014-10-29 00:00:00', '2014-10-29 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_employees`
--

CREATE TABLE `ut_hr_employees` (
  `employee_row_id` int(11) NOT NULL,
  `area_row_id` int(11) DEFAULT NULL,
  `employee_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_name_bangla` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `signature_image_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `joining_date` varchar(255) DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `blood_group` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT '1',
  `institution_row_id` int(11) DEFAULT NULL,
  `department_row_id` int(11) DEFAULT NULL,
  `designation_row_id` int(11) DEFAULT NULL,
  `plain_password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ut_hr_employees`
--

INSERT INTO `ut_hr_employees` (`employee_row_id`, `area_row_id`, `employee_name`, `employee_name_bangla`, `employee_email`, `password`, `photo_name`, `signature_image_name`, `contact_1`, `contact_2`, `joining_date`, `gender`, `blood_group`, `active_status`, `institution_row_id`, `department_row_id`, `designation_row_id`, `plain_password`, `remember_token`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(96, 1, 'Santanu Das', 'শান্তনু দাস', 'santanudastusher@gmail.com', '$2y$10$7rtCLvtJdVr0iZwXFTDizuigIbwRi3XEqJMTIsFxCW45HEaOPYYUC', '1509962081_sdt.jpg', '1509962081_signature_sample.png', '01687-161171', NULL, '02/12/2017', 'Select', '0', 1, NULL, 14, 69, '123456', NULL, 1, NULL, '2017-11-06 15:54:41', NULL),
(97, 1, 'Roxana Ahmad Chowdhury', 'Roxana Ahmad Chowdhury', 'dna_1961@yahoo.com', NULL, '', '', '01672-387697', NULL, NULL, 'Select', '0', 1, NULL, 15, 83, NULL, NULL, 1, NULL, '2017-11-06 16:23:17', NULL),
(98, 1, 'Masuduzzaman', 'Masuduzzaman', 'enggmasud1983@gmail.com', NULL, '', '', '01739-976459', NULL, NULL, 'Select', '0', 1, NULL, 14, 70, NULL, NULL, 1, NULL, '2017-11-06 16:57:20', NULL),
(99, 1, 'Asif Ahmed', 'Asif Ahmed', 'romeoasif@gmail.com', NULL, '', '', '01676-293452', NULL, NULL, 'Select', '0', 1, NULL, 14, 70, NULL, NULL, 1, NULL, '2017-11-06 16:58:25', NULL),
(100, 1, 'Md. Sakoat Hossen', 'Md. Sakoat Hossen', 'sakoatcse@gmail.com', NULL, '', '', '01733-548180', NULL, NULL, 'male', '0', 1, NULL, 14, 71, NULL, NULL, 1, NULL, '2017-11-06 16:59:05', NULL),
(101, 1, 'Md. Sahidul Islam Sapon', 'Md. Sahidul Islam Sapon', 'sapondewan@yahoo.com', NULL, '', '', '01918-109098', NULL, NULL, 'Select', '0', 1, NULL, 14, 72, NULL, NULL, 1, NULL, '2017-11-06 17:01:20', NULL),
(102, 1, 'Kamrun Nahar Suma', 'Kamrun Nahar Suma', 'sumacse2103@yahoo.com', NULL, '', '', '01718-745215', NULL, NULL, 'Select', '0', 1, NULL, 14, 73, NULL, NULL, 1, NULL, '2017-11-06 17:02:43', NULL),
(103, 1, 'Md. Shahedul Islam', 'Md. Shahedul Islam', 'modhumoti75@gmail.com', NULL, '', '', '01718-435546', NULL, NULL, 'Select', '0', 1, NULL, 14, 74, NULL, NULL, 1, NULL, '2017-11-06 17:03:37', NULL),
(104, 1, 'Sayeem Mohammad Shahria', 'Sayeem Mohammad Shahria', 'sayeems@gmail.com', NULL, '', '', '01670-939430', NULL, NULL, 'Select', '0', 1, NULL, 14, 69, NULL, NULL, 1, NULL, '2017-11-06 17:04:15', NULL),
(105, 1, 'Tuhin Khan', 'Tuhin Khan', 'uiu.tuhin@gmail.com', NULL, '', '', '01717-402382', NULL, NULL, 'Select', '0', 1, NULL, 14, 69, NULL, NULL, 1, NULL, '2017-11-06 17:04:56', NULL),
(106, 1, 'Manik Deb Nath', 'Manik Deb Nath', 'manikdeb012@gmail.com', NULL, '', '', '01682-280434', NULL, NULL, 'Select', '0', 1, NULL, 14, 75, NULL, NULL, 1, NULL, '2017-11-06 17:05:47', NULL),
(107, 1, 'Al Maruf Hassan', 'Al Maruf Hassan', 'ahassan123036@bscse.uiu.ac.bd', NULL, '', '', '01670-199178', NULL, NULL, 'Select', '0', 1, NULL, 14, 76, NULL, NULL, 1, NULL, '2017-11-06 17:06:39', NULL),
(108, 1, 'Mohammad Ali', 'Mohammad Ali', 'ali.khulna@gmail.com', NULL, '', '', '01617-530362', NULL, NULL, 'Select', '0', 1, NULL, 14, 77, NULL, NULL, 1, NULL, '2017-11-06 17:08:25', NULL),
(109, 1, 'Yasin Arafat Riad', 'Yasin Arafat Riad', 'yasinriad2013@gmail.com', NULL, '', '', '01783-638740', NULL, NULL, 'Select', '0', 1, NULL, 14, 78, NULL, NULL, 1, NULL, '2017-11-06 17:09:12', NULL),
(110, 1, 'Md. Saidul Islam', 'Md. Saidul Islam', 'kafi.rashid@gmail.com', NULL, '', '', '01719-440084', NULL, NULL, 'Select', '0', 1, NULL, 14, 79, NULL, NULL, 1, NULL, '2017-11-06 17:09:57', NULL),
(111, 1, 'Nazmul Hasan', 'Nazmul Hasan', 'nazmul_2734@diu.edu.bd', NULL, '', '', '01758-022702', NULL, NULL, 'Select', '0', 1, NULL, 14, 80, NULL, NULL, 1, NULL, '2017-11-06 17:10:44', NULL),
(112, 1, 'Rafsun Uddin', 'Rafsun Uddin', 'rafsunnishat7@gmail.com', NULL, '', '', '01521-258496', NULL, NULL, 'Select', '0', 1, NULL, 14, 81, NULL, NULL, 1, NULL, '2017-11-06 17:11:10', NULL),
(113, 1, 'Md. Ebadur Rahman', 'Md. Ebadur Rahman', 'ebadur.info@gmail.com', NULL, '', '', '01911-290083', NULL, NULL, 'Select', '0', 1, NULL, 14, 97, NULL, NULL, 1, NULL, '2017-11-06 17:13:39', NULL),
(114, 1, 'Rakesh Kumar Das', 'Rakesh Kumar Das', 'rakesh.cse.uiu@gmail.com', NULL, '', '', '01676-917146', NULL, NULL, 'Select', '0', 1, NULL, 14, 82, NULL, NULL, 1, NULL, '2017-11-06 17:14:38', NULL),
(115, 1, 'Mohammad Sabit Hossain', 'Mohammad Sabit Hossain', 'sabithossain@gmail.com', NULL, '', '', '01675-741544', NULL, NULL, 'Select', '0', 1, NULL, 15, 84, NULL, NULL, 1, NULL, '2017-11-06 17:16:41', NULL),
(116, 1, 'Mehrab Imtiaz', 'Mehrab Imtiaz', 'mehrab.i009@gmail.com', NULL, '', '', '01754-990455', NULL, NULL, 'Select', '0', 1, NULL, 15, 85, NULL, NULL, 1, NULL, '2017-11-06 17:18:07', NULL),
(117, 1, 'Raiyan Islam', 'Raiyan Islam', 'raiyanislam863@gmail.com', NULL, '', '', '01616-489495', '01616-489495', NULL, 'Select', '0', 1, NULL, 15, 86, NULL, NULL, 1, NULL, '2017-11-06 17:19:04', NULL),
(118, 1, 'Amana Iftekhar', 'Amana Iftekhar', 'amanaiftekhar@gmail.com', NULL, '', '', '01788-220832', NULL, NULL, 'Select', '0', 1, NULL, 15, 87, NULL, NULL, 1, NULL, '2017-11-06 17:19:45', NULL),
(119, 1, 'Arif Hossain bhuyia', 'Arif Hossain bhuyia', 'arifrony17@gmail.com', NULL, '', '', '01715-767245', NULL, NULL, 'Select', '0', 1, NULL, 15, 88, NULL, NULL, 1, NULL, '2017-11-06 17:20:31', NULL),
(120, 1, 'Syed Nakib Sadi', 'Syed Nakib Sadi', 'nakibsadi1993@gmail.com', NULL, '', '', '0168-3957674', NULL, NULL, 'Select', '0', 1, NULL, 15, 89, NULL, NULL, 1, NULL, '2017-11-06 17:21:15', NULL),
(121, 1, 'Md. Fazlul Momen', 'Md. Fazlul Momen', 'koreabd2010@gmail.com', NULL, '', '', '01703-499376', NULL, NULL, 'Select', '0', 1, NULL, 15, 90, NULL, NULL, 1, NULL, '2017-11-06 17:21:56', NULL),
(122, 1, 'Tanvirul Islam', 'Tanvirul Islam', 'tanvirul@live.com', NULL, '', '', '01676-053296', NULL, NULL, 'Select', '0', 1, NULL, 15, 91, NULL, NULL, 1, NULL, '2017-11-06 17:23:04', NULL),
(123, 1, 'Raisa Tabassum', 'Raisa Tabassum', 'raisa08bd@gmail.com', NULL, '', '', '01623-195577', NULL, NULL, 'Select', '0', 1, NULL, 15, 98, NULL, NULL, 1, NULL, '2017-11-06 17:24:27', NULL),
(124, 1, 'Indragit Kumar Paul', 'Indragit Kumar Paul', 'indrapaul1991@gmail.com', NULL, '', '', '01515-243703', NULL, NULL, 'Select', '0', 1, NULL, 15, 91, NULL, NULL, 1, NULL, '2017-11-06 17:25:13', NULL),
(125, 1, 'Shaiful Islam', 'Shaiful Islam', 'shaifulislambot2010@gmail.com', NULL, '', '', '01797-261536', NULL, NULL, 'Select', '0', 1, NULL, 15, 92, NULL, NULL, 1, NULL, '2017-11-06 17:25:54', NULL),
(126, 1, 'Md. Khaled Hasan', 'Md. Khaled Hasan', 'khaled16hasan@gmail.com', NULL, '', '', '01916-745902', NULL, NULL, 'Select', '0', 1, NULL, 15, 93, NULL, NULL, 1, NULL, '2017-11-06 17:26:35', NULL),
(127, 1, 'Aaphsaarah Rahman', 'Aaphsaarah Rahman', 'apsarah.rahman@gmail.com', NULL, '', '', '01736-534368', NULL, NULL, 'Select', '0', 1, NULL, 15, 94, NULL, NULL, 1, NULL, '2017-11-06 17:27:08', NULL),
(128, 1, 'Jannatul Fardush Boby', 'Jannatul Fardush Boby', 'jannatulfardush1989@gmail.com', NULL, '', '', '01937-144880', NULL, NULL, 'Select', '0', 1, NULL, 16, 101, NULL, NULL, 1, NULL, '2017-11-06 17:28:00', NULL),
(129, 1, 'Dr. Rezaul Karim', 'Dr. Rezaul Karim', NULL, NULL, '', '', NULL, NULL, NULL, 'Select', '0', 1, NULL, 15, 96, NULL, NULL, 1, NULL, '2017-11-06 17:28:29', NULL),
(130, 1, 'Suman Ahmmed', 'Suman Ahmmed', 'sumanahmmed@gmail.com', NULL, '', '', '01765049901', NULL, NULL, 'Select', '0', 1, NULL, 17, 102, NULL, NULL, 1, NULL, '2017-11-07 09:46:54', NULL),
(131, 1, 'Jashodhan Saha', 'Jashodhan Saha', 'jashodhan@gmail.com', NULL, '', '', '01712204400', NULL, NULL, 'Select', '0', 1, NULL, 17, 103, NULL, NULL, 1, NULL, '2017-11-07 09:48:54', NULL),
(132, 1, 'Sharmin Yusuf', 'Sharmin Yusuf', 'sharminyusuf1971@gmail.com', NULL, '', '', '01765049902', NULL, NULL, 'Select', '0', 1, NULL, 17, 104, NULL, NULL, 1, NULL, '2017-11-07 09:50:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_employee_details`
--

CREATE TABLE `ut_hr_employee_details` (
  `employee_details_row_id` int(11) NOT NULL,
  `employee_row_id` int(11) NOT NULL,
  `nid` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nid_photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `religion` tinyint(1) DEFAULT NULL,
  `next_of_kin` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `kin_relationship` int(2) DEFAULT NULL,
  `nationality` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `present_address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `present_address_bangla` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `present_division_id` int(5) DEFAULT NULL,
  `present_district_id` int(5) DEFAULT NULL,
  `present_upazila_id` int(5) DEFAULT NULL,
  `present_post_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `permanent_address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `permanent_address_bangla` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `permanent_division_id` int(5) DEFAULT NULL,
  `permanent_district_id` int(5) DEFAULT NULL,
  `permanent_upazila_id` int(5) DEFAULT NULL,
  `permanent_post_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssc_exam_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssc_group` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssc_result` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssc_board` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssc_passing_year` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssc_certificate_photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `hsc_exam_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `hsc_group` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `hsc_result` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `hsc_board` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `hsc_passing_year` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `hsc_certificate_photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `graduation_exam_row_id` int(3) DEFAULT NULL,
  `graduation_subject_row_id` int(3) DEFAULT NULL,
  `graduation_result` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `graduation_board` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `graduation_passing_year` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `graduation_certificate_photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_graduation_exam_row_id` int(3) DEFAULT NULL,
  `post_graduation_subject_row_id` int(3) DEFAULT NULL,
  `post_graduation_result` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_graduation_board` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_graduation_passing_year` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_graduation_certificate_photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `b_ed_completed` tinyint(1) DEFAULT NULL,
  `b_ed_result` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `b_ed_board` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `b_ed_passing_year` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_ed_completed` tinyint(1) DEFAULT NULL,
  `m_ed_result` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_ed_board` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_ed_passing_year` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `higher_degree_exam_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `higher_degree_subject_row_id` int(3) DEFAULT NULL,
  `higher_degree_result` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `higher_degree_board` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `higher_degree_passing_year` int(11) DEFAULT NULL,
  `higher_degree_certificate_photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `special_training` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ut_hr_employee_details`
--

INSERT INTO `ut_hr_employee_details` (`employee_details_row_id`, `employee_row_id`, `nid`, `nid_photo`, `dob`, `religion`, `next_of_kin`, `kin_relationship`, `nationality`, `present_address`, `present_address_bangla`, `present_division_id`, `present_district_id`, `present_upazila_id`, `present_post_code`, `permanent_address`, `permanent_address_bangla`, `permanent_division_id`, `permanent_district_id`, `permanent_upazila_id`, `permanent_post_code`, `ssc_exam_name`, `ssc_group`, `ssc_result`, `ssc_board`, `ssc_passing_year`, `ssc_certificate_photo`, `hsc_exam_name`, `hsc_group`, `hsc_result`, `hsc_board`, `hsc_passing_year`, `hsc_certificate_photo`, `graduation_exam_row_id`, `graduation_subject_row_id`, `graduation_result`, `graduation_board`, `graduation_passing_year`, `graduation_certificate_photo`, `post_graduation_exam_row_id`, `post_graduation_subject_row_id`, `post_graduation_result`, `post_graduation_board`, `post_graduation_passing_year`, `post_graduation_certificate_photo`, `b_ed_completed`, `b_ed_result`, `b_ed_board`, `b_ed_passing_year`, `m_ed_completed`, `m_ed_result`, `m_ed_board`, `m_ed_passing_year`, `higher_degree_exam_name`, `higher_degree_subject_row_id`, `higher_degree_result`, `higher_degree_board`, `higher_degree_passing_year`, `higher_degree_certificate_photo`, `special_training`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(92, 96, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(93, 97, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(94, 98, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(95, 99, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(96, 100, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(97, 101, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(98, 102, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(99, 103, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(100, 104, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(101, 105, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(102, 106, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(103, 107, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(104, 108, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(105, 109, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(106, 110, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(107, 111, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(108, 112, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(109, 113, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(110, 114, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(111, 115, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(112, 116, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(113, 117, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(114, 118, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(115, 119, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(116, 120, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(117, 121, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(118, 122, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(119, 123, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(120, 124, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(121, 125, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(122, 126, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(123, 127, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(124, 128, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(125, 129, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(126, 130, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(127, 131, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL),
(128, 132, NULL, '', NULL, 0, NULL, 0, 'Bangladeshi', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_employee_histories`
--

CREATE TABLE `ut_hr_employee_histories` (
  `employee_history_row_id` int(11) NOT NULL,
  `employee_row_id` int(11) NOT NULL,
  `department_row_id` int(11) DEFAULT NULL,
  `designation_row_id` int(11) DEFAULT NULL,
  `salary_effected_from` date DEFAULT NULL,
  `is_starting_salary` tinyint(1) NOT NULL DEFAULT '0',
  `basic_salary` float(10,2) DEFAULT '0.00',
  `salary_parts` text,
  `gross_salary` float(10,2) DEFAULT '0.00',
  `increamented_basic_salary` float(10,2) DEFAULT '0.00',
  `increamented_salary_parts` text,
  `increamented_gross_salary` float(10,2) NOT NULL DEFAULT '0.00',
  `salary_year` int(11) DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `step` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ut_hr_employee_histories`
--

INSERT INTO `ut_hr_employee_histories` (`employee_history_row_id`, `employee_row_id`, `department_row_id`, `designation_row_id`, `salary_effected_from`, `is_starting_salary`, `basic_salary`, `salary_parts`, `gross_salary`, `increamented_basic_salary`, `increamented_salary_parts`, `increamented_gross_salary`, `salary_year`, `grade`, `step`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(92, 96, 14, 69, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 09:54:41', NULL, 1, NULL),
(93, 97, 15, 83, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 10:23:17', NULL, 1, NULL),
(94, 98, 14, 70, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 10:57:20', NULL, 1, NULL),
(95, 99, 14, 70, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 10:58:25', NULL, 1, NULL),
(96, 100, 14, 71, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 10:59:05', NULL, 1, NULL),
(97, 101, 14, 72, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:01:20', NULL, 1, NULL),
(98, 102, 14, 73, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:02:43', NULL, 1, NULL),
(99, 103, 14, 74, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:03:37', NULL, 1, NULL),
(100, 104, 14, 69, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:04:15', NULL, 1, NULL),
(101, 105, 14, 69, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:04:56', NULL, 1, NULL),
(102, 106, 14, 75, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:05:47', NULL, 1, NULL),
(103, 107, 14, 76, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:06:39', NULL, 1, NULL),
(104, 108, 14, 77, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:08:25', NULL, 1, NULL),
(105, 109, 14, 78, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:09:12', NULL, 1, NULL),
(106, 110, 14, 79, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:09:57', NULL, 1, NULL),
(107, 111, 14, 80, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:10:44', NULL, 1, NULL),
(108, 112, 14, 81, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:11:10', NULL, 1, NULL),
(109, 113, 14, 97, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:13:39', NULL, 1, NULL),
(110, 114, 14, 82, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:14:38', NULL, 1, NULL),
(111, 115, 15, 84, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:16:41', NULL, 1, NULL),
(112, 116, 15, 85, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:18:07', NULL, 1, NULL),
(113, 117, 15, 86, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:19:04', NULL, 1, NULL),
(114, 118, 15, 87, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:19:45', NULL, 1, NULL),
(115, 119, 15, 88, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:20:31', NULL, 1, NULL),
(116, 120, 15, 89, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:21:15', NULL, 1, NULL),
(117, 121, 15, 90, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:21:56', NULL, 1, NULL),
(118, 122, 15, 91, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:23:04', NULL, 1, NULL),
(119, 123, 15, 98, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:24:27', NULL, 1, NULL),
(120, 124, 15, 91, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:25:13', NULL, 1, NULL),
(121, 125, 15, 92, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:25:54', NULL, 1, NULL),
(122, 126, 15, 93, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:26:35', NULL, 1, NULL),
(123, 127, 15, 94, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:27:08', NULL, 1, NULL),
(124, 128, 16, 101, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:28:00', NULL, 1, NULL),
(125, 129, 15, 96, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-06 11:28:29', NULL, 1, NULL),
(126, 130, 17, 102, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-07 03:46:54', NULL, 1, NULL),
(127, 131, 17, 103, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-07 03:48:54', NULL, 1, NULL),
(128, 132, 17, 104, NULL, 0, 0.00, NULL, 0.00, 0.00, NULL, 0.00, NULL, NULL, NULL, '2017-11-07 03:50:44', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_employee_leave_records`
--

CREATE TABLE `ut_hr_employee_leave_records` (
  `leave_record_row_id` int(11) NOT NULL,
  `area_row_id` int(11) DEFAULT NULL,
  `department_row_id` int(11) DEFAULT NULL,
  `institution_row_id` int(11) DEFAULT NULL,
  `employee_row_id` int(11) NOT NULL,
  `leave_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `leave_date_from` date NOT NULL,
  `leave_date_to` date DEFAULT NULL,
  `number_of_days` int(11) DEFAULT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_grad_exam_names`
--

CREATE TABLE `ut_hr_grad_exam_names` (
  `grad_exam_row_id` int(11) NOT NULL,
  `grad_exam_name` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ut_hr_grad_exam_names`
--

INSERT INTO `ut_hr_grad_exam_names` (`grad_exam_row_id`, `grad_exam_name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'B.Architect', NULL, NULL, NULL, NULL),
(2, 'B.A', NULL, NULL, NULL, NULL),
(3, 'Bachelor(Hons)', NULL, NULL, NULL, NULL),
(4, 'BBA', NULL, NULL, NULL, NULL),
(5, 'BSc Engineering', NULL, NULL, NULL, NULL),
(6, 'Fazil', NULL, NULL, NULL, NULL),
(7, 'Others', NULL, NULL, NULL, NULL),
(8, 'B.Com', 1, 1, '2017-03-09 00:00:00', '2017-03-17 00:00:00'),
(9, 'B.Sc', 1, 1, '2017-03-16 00:00:00', '2017-03-17 00:00:00'),
(10, 'B.B.S.', 1, 1, NULL, NULL),
(11, 'B.S.S', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_grad_postgrad_subject_names`
--

CREATE TABLE `ut_hr_grad_postgrad_subject_names` (
  `grad_postgrad_subject_name_row_id` int(11) NOT NULL,
  `subject_title` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ut_hr_grad_postgrad_subject_names`
--

INSERT INTO `ut_hr_grad_postgrad_subject_names` (`grad_postgrad_subject_name_row_id`, `subject_title`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Accounting', NULL, NULL, NULL, NULL),
(2, 'Accounting and Information System', NULL, NULL, NULL, NULL),
(3, 'Accounting and Finance', NULL, NULL, NULL, NULL),
(4, 'Agricultural Engineering', NULL, NULL, NULL, NULL),
(5, 'Agricultural Economics', NULL, NULL, NULL, NULL),
(6, 'Agricultural Foresty', NULL, NULL, NULL, NULL),
(7, 'Agriculture', NULL, NULL, NULL, NULL),
(8, 'Agronomy', NULL, NULL, NULL, NULL),
(9, 'Agronomy and Agricultural Studies', NULL, NULL, NULL, NULL),
(10, 'Animal Husbandry', NULL, NULL, NULL, NULL),
(11, 'Animal Nutrition', NULL, NULL, NULL, NULL),
(12, 'Anthropology', NULL, NULL, NULL, NULL),
(13, 'Applied Chemistry', NULL, NULL, NULL, NULL),
(14, 'Applied Chemistry and Chemical Techbology', NULL, NULL, NULL, NULL),
(15, 'Applied Mathematics', NULL, NULL, NULL, NULL),
(16, 'Applied Physics', NULL, NULL, NULL, NULL),
(17, 'Applied Physics and Electronics', NULL, NULL, NULL, NULL),
(18, 'Applied Statistics', NULL, NULL, NULL, NULL),
(19, 'Architecture', NULL, NULL, NULL, NULL),
(20, 'Bank Management', NULL, NULL, NULL, NULL),
(21, 'Banking', NULL, NULL, NULL, NULL),
(22, 'Bengali', NULL, NULL, NULL, NULL),
(23, 'Biochemistry', NULL, NULL, NULL, NULL),
(24, 'Biochemistry and Molecular Biology', NULL, NULL, NULL, NULL),
(25, 'Biotechnology', NULL, NULL, NULL, NULL),
(26, 'Botany', NULL, NULL, NULL, NULL),
(27, 'Business Administration', NULL, NULL, NULL, NULL),
(28, 'Business Economics', NULL, NULL, NULL, NULL),
(29, 'Chemical Engineering', NULL, NULL, NULL, NULL),
(30, 'Chemistry', NULL, NULL, NULL, NULL),
(31, 'Civil Engineering', NULL, NULL, NULL, NULL),
(32, 'Clinical Pharmacy and Pharmacology', NULL, NULL, NULL, NULL),
(33, 'Clinical Psychology', NULL, NULL, NULL, NULL),
(34, 'Commerce', NULL, NULL, NULL, NULL),
(35, 'Computer Science', NULL, NULL, NULL, NULL),
(36, 'Computer Science and Engineering', NULL, NULL, NULL, NULL),
(37, 'Developement Studies', NULL, NULL, NULL, NULL),
(38, 'Economics', NULL, NULL, NULL, NULL),
(39, 'Education and Research', NULL, NULL, NULL, NULL),
(40, 'Electrical and Electronic Engineering', NULL, NULL, NULL, NULL),
(41, 'Electronics and Communication Engineering', NULL, NULL, NULL, NULL),
(42, 'English', NULL, NULL, NULL, NULL),
(43, 'Entomology', NULL, NULL, NULL, NULL),
(44, 'Environmental Science', NULL, NULL, NULL, NULL),
(45, 'Finance', NULL, NULL, NULL, NULL),
(46, 'Finance and Banking', NULL, NULL, NULL, NULL),
(47, 'Fine Arts', NULL, NULL, NULL, NULL),
(48, 'Fisheries', NULL, NULL, NULL, NULL),
(49, 'Folklore', NULL, NULL, NULL, NULL),
(50, 'Forestry', NULL, NULL, NULL, NULL),
(51, 'Forestry and Wood Technology', NULL, NULL, NULL, NULL),
(52, 'Genetic Engineering', NULL, NULL, NULL, NULL),
(53, 'Genetic Engineering and Bio-Technology', NULL, NULL, NULL, NULL),
(54, 'Geography', NULL, NULL, NULL, NULL),
(55, 'Geography and Environment', NULL, NULL, NULL, NULL),
(56, 'Geology', NULL, NULL, NULL, NULL),
(57, 'Health Economics', NULL, NULL, NULL, NULL),
(58, 'History', NULL, NULL, NULL, NULL),
(59, 'Home Economics', NULL, NULL, NULL, NULL),
(60, 'Horticulture', NULL, NULL, NULL, NULL),
(61, 'Human Resource Management', NULL, NULL, NULL, NULL),
(62, 'Humanities', NULL, NULL, NULL, NULL),
(63, 'Industrial and Production Engineering', NULL, NULL, NULL, NULL),
(64, 'Information and Communication Engineering', NULL, NULL, NULL, NULL),
(65, 'Information Science and Library Management', NULL, NULL, NULL, NULL),
(66, 'Interior Design', NULL, NULL, NULL, NULL),
(67, 'International Relations', NULL, NULL, NULL, NULL),
(68, 'Islamic History', NULL, NULL, NULL, NULL),
(69, 'Islamic History and Culture', NULL, NULL, NULL, NULL),
(70, 'Islamic Studies', NULL, NULL, NULL, NULL),
(71, 'LAW', NULL, NULL, NULL, NULL),
(72, 'Leather Products Technology', NULL, NULL, NULL, NULL),
(73, 'Linguistics', NULL, NULL, NULL, NULL),
(74, 'Linguistics', NULL, NULL, NULL, NULL),
(75, 'Management', NULL, NULL, NULL, NULL),
(76, 'Management Information System', NULL, NULL, NULL, NULL),
(77, 'Marine Science', NULL, NULL, NULL, NULL),
(78, 'Marketing', NULL, NULL, NULL, NULL),
(79, 'Mass Communication and Journalism', NULL, NULL, NULL, NULL),
(80, 'Materials and Metallurgical Engineering', NULL, NULL, NULL, NULL),
(81, 'Mathematics', NULL, NULL, NULL, NULL),
(82, 'Mechanical Engineering', NULL, NULL, NULL, NULL),
(83, 'Medicine', NULL, NULL, NULL, NULL),
(84, 'Microbiology', NULL, NULL, NULL, NULL),
(85, 'Mineralogy and Petroleum Technology', NULL, NULL, NULL, NULL),
(86, 'Naval Architecture and Marine Engineering', NULL, NULL, NULL, NULL),
(87, 'Nutrition and Food Sciences', NULL, NULL, NULL, NULL),
(88, 'Parasitology', NULL, NULL, NULL, NULL),
(89, 'Pathology', NULL, NULL, NULL, NULL),
(90, 'Peace and Conflict Studies', NULL, NULL, NULL, NULL),
(91, 'Petroleum and Mineral Resources Engineering', NULL, NULL, NULL, NULL),
(92, 'Pharmaceutical Chemistry', NULL, NULL, NULL, NULL),
(93, 'Pharmacy', NULL, NULL, NULL, NULL),
(94, 'Philosophy', NULL, NULL, NULL, NULL),
(95, 'Physics', NULL, NULL, NULL, NULL),
(96, 'Plant Pathology', NULL, NULL, NULL, NULL),
(97, 'Political Science', NULL, NULL, NULL, NULL),
(98, 'Polymer Science', NULL, NULL, NULL, NULL),
(99, 'Population Science', NULL, NULL, NULL, NULL),
(100, 'Psychology', NULL, NULL, NULL, NULL),
(101, 'Public Administration', NULL, NULL, NULL, NULL),
(102, 'Sanskrit and Pali', NULL, NULL, NULL, NULL),
(103, 'Social Welfare and Research', NULL, NULL, NULL, NULL),
(104, 'Sociology', NULL, NULL, NULL, NULL),
(105, 'Soil, Water and Environment', NULL, NULL, NULL, NULL),
(106, 'Statistics', NULL, NULL, NULL, NULL),
(107, 'Strategic Management', NULL, NULL, NULL, NULL),
(108, 'Tea Technology', NULL, NULL, NULL, NULL),
(109, 'Telecommunications Engineering', NULL, NULL, NULL, NULL),
(110, 'Textile Engineering', NULL, NULL, NULL, NULL),
(111, 'Theater and Music', NULL, NULL, NULL, NULL),
(112, 'Veterinary Medicine', NULL, NULL, NULL, NULL),
(113, 'Veterinary Science', NULL, NULL, NULL, NULL),
(114, 'Zoology', NULL, NULL, NULL, NULL),
(115, 'Social Work', NULL, NULL, NULL, NULL),
(116, 'Hadith', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_institutions`
--

CREATE TABLE `ut_hr_institutions` (
  `institution_row_id` int(11) NOT NULL,
  `institution_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `area_row_id` int(11) DEFAULT NULL,
  `department_row_id` int(11) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ut_hr_institutions`
--

INSERT INTO `ut_hr_institutions` (`institution_row_id`, `institution_name`, `short_name`, `area_row_id`, `department_row_id`, `sort_order`, `is_active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(44, 'DBP(Feni)', NULL, 4, 11, NULL, 1, 1, '2017-10-26 16:27:48', NULL, '2017-10-26 16:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_post_grad_exam_names`
--

CREATE TABLE `ut_hr_post_grad_exam_names` (
  `post_grad_exam_row_id` int(11) NOT NULL,
  `post_grad_exam_name` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ut_hr_post_grad_exam_names`
--

INSERT INTO `ut_hr_post_grad_exam_names` (`post_grad_exam_row_id`, `post_grad_exam_name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'M.A.', NULL, NULL, NULL, NULL),
(2, 'M.B.A.', NULL, NULL, NULL, NULL),
(3, 'MBM(BIBM)', NULL, NULL, NULL, NULL),
(4, 'M. Com', NULL, NULL, NULL, NULL),
(5, 'MSc', NULL, NULL, NULL, NULL),
(6, 'M.Eng', NULL, NULL, NULL, NULL),
(7, 'M Phil', NULL, NULL, NULL, NULL),
(8, 'MSS', NULL, NULL, NULL, NULL),
(9, 'Kamil', NULL, NULL, NULL, NULL),
(10, 'Others', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_salary_heads`
--

CREATE TABLE `ut_hr_salary_heads` (
  `salary_head_row_id` int(11) NOT NULL,
  `salary_head_slug` varchar(255) DEFAULT NULL,
  `salary_head_name` varchar(100) DEFAULT NULL,
  `sort_order` tinyint(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ut_hr_salary_heads`
--

INSERT INTO `ut_hr_salary_heads` (`salary_head_row_id`, `salary_head_slug`, `salary_head_name`, `sort_order`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'house_rent', 'House Rent', 1, 1, NULL, '2017-09-14 10:22:55', '2017-10-02 09:28:38'),
(2, 'medical_alowance', 'Medical Allowance', 2, 1, NULL, '2017-09-14 10:22:55', '2017-09-14 10:22:55'),
(3, 'transport_facility', 'Transport Facilities', 3, 1, NULL, '2017-09-14 10:23:31', '2017-09-14 10:23:31'),
(4, 'medical_cost', 'Medical Reimbursements', 4, 4, NULL, '2017-09-14 10:59:30', '2017-09-14 10:59:30'),
(5, 'new_head', 'Entertainment', 5, 1, NULL, '2017-09-20 10:30:35', '2017-10-02 09:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_salary_head_pay_amounts`
--

CREATE TABLE `ut_hr_salary_head_pay_amounts` (
  `head_pay_amount_row_id` int(11) NOT NULL,
  `salary_head_row_id` int(11) NOT NULL,
  `percantage_fixed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=percantage, 2=fixed',
  `amount_percantage` float(8,2) DEFAULT NULL,
  `amount_fixed` float(10,2) DEFAULT NULL,
  `fiscal_year` int(4) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ut_hr_salary_head_pay_amounts`
--

INSERT INTO `ut_hr_salary_head_pay_amounts` (`head_pay_amount_row_id`, `salary_head_row_id`, `percantage_fixed`, `amount_percantage`, `amount_fixed`, `fiscal_year`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 50.00, 0.00, 2017, 1, 1, 1, '2017-09-17 13:08:01', '2017-09-17 13:08:01'),
(2, 2, 1, 10.00, 0.00, 2017, 1, 0, 0, '2017-09-17 13:08:07', '2017-09-17 13:08:07'),
(3, 3, 2, NULL, 1000.00, 2017, 1, 0, 0, '2017-09-17 16:08:19', '2017-09-17 16:08:19'),
(4, 4, 2, NULL, 500.00, 2017, 1, 0, 0, '2017-09-17 16:08:19', '2017-09-17 16:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `ut_hr_sub_areas`
--

CREATE TABLE `ut_hr_sub_areas` (
  `sub_area_row_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `area_row_id` int(11) NOT NULL,
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
-- Dumping data for table `ut_hr_sub_areas`
--

INSERT INTO `ut_hr_sub_areas` (`sub_area_row_id`, `title`, `area_row_id`, `area_code`, `description`, `sort_order`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Momenabad', 1, '', '', 0, 1, 0, 0, '2017-10-22 14:57:28', '2017-10-22 14:57:28'),
(2, 'HazraBari', 1, '', '', 0, 1, 0, 0, '2017-10-22 14:57:55', '2017-10-22 14:57:55');

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
-- Table structure for table `ut_upazila`
--

CREATE TABLE `ut_upazila` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ut_upazila`
--

INSERT INTO `ut_upazila` (`id`, `full_name`, `short_name`, `code`, `district_id`, `created_at`, `updated_at`) VALUES
(1, 'DCC North', '01', 200, 1, '2014-09-14 19:33:23', '2014-09-14 19:33:23'),
(2, 'DCC South', '02', 200, 1, '2014-09-14 19:33:23', '2014-09-14 19:33:23'),
(3, 'Dhamrai', '03', 200, 1, '2014-09-14 19:33:23', '2014-09-14 19:33:23'),
(4, 'Dohar', '04', 200, 1, '2014-09-14 19:33:23', '2014-09-14 19:33:23'),
(5, 'Keraniganj', '05', 200, 1, '2014-09-14 19:33:23', '2014-09-14 19:33:23'),
(6, 'Nawabganj', '06', 200, 1, '2014-09-14 19:33:23', '2014-09-14 19:33:23'),
(7, 'Savar', '07', 200, 1, '2014-10-17 04:15:47', '2014-10-17 04:15:47'),
(8, 'Gazipur Sadar', '01', 18, 9, '2014-10-17 06:00:43', '2014-10-17 06:00:43'),
(12, 'Kaliakair', '02', 200, 9, '2014-10-27 21:48:37', '2014-10-27 21:48:37'),
(13, 'Kaliganj', '03', 200, 9, '2014-10-27 21:49:39', '2014-10-27 21:49:39'),
(14, 'Kapasia', '04', 200, 9, '2014-10-27 21:50:06', '2014-10-27 21:50:06'),
(15, 'Sreepur', '05', 200, 9, '2014-10-27 21:50:48', '2014-10-27 21:50:48'),
(16, 'Tangail Sadar', '06', 200, 12, '2014-10-27 21:52:01', '2014-10-27 21:52:01'),
(17, 'Gopalpur', '07', 200, 12, '2014-10-27 21:52:30', '2014-10-27 21:52:30'),
(18, 'Basail', '08', 200, 12, '2014-10-27 21:53:02', '2014-10-27 21:53:02'),
(19, 'Basail', '09', 200, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'Bhuapur', '10', 200, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'Delduar', '11', 200, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'Ghatail', '12', 200, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'Kalihati', '13', 200, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'Madhupur', '14', 200, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'Mirzapur', '15', 200, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'Nagarpur', '16', 200, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'Sakhipur', '17', 200, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'Dhanbari', '18', 200, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'Astagram', '25', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 'Bajitpur', '26', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'Bhairab', '27', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'Hossainpur', '28', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'Itna', '29', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'Karimganj', '30', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'Katiadi', '31', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 'Kishoreganj Sadar', '33', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'Kuliarchar', '34', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 'Mithamain', '35', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 'Nikli', '36', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 'Pakundia', '37', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'Tarail', '38', 200, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 'Araihazar', '01', 200, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 'Bandar', '02', 200, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'Narayanganj Sadar', '03', 200, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 'Rupganj', '04', 200, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 'Sonargaon', '05', 200, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 'Fatullah', '06', 200, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 'Siddhirganj', '07', 200, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 'Daulatpur', '14', 200, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 'Ghior', '09', 200, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'Harirampur', '10', 200, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 'Manikgonj Sadar', '11', 200, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 'Saturia', '12', 200, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 'Shivalaya', '13', 200, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 'Singair', '08', 200, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'Narsingdi Sadar', '15', 200, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 'Belabo', '16', 200, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 'Monohardi', '17', 200, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'Palash', '18', 200, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 'Raipura', '19', 200, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 'Shibpur', '20', 200, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 'Gazaria', '21', 200, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 'Lohajang', '22', 200, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 'Munshiganj Sadar', '23', 200, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 'Sirajdikhan', '24', 200, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 'Sreenagar', '25', 200, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 'Tongibari', '26', 200, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 'Ajmiriganj', '01', 1, 56, '2014-10-28 15:21:56', '2014-10-28 15:21:56'),
(69, 'Bahubal', '02', 200, 56, '2014-10-28 15:24:32', '2014-10-28 15:24:32'),
(70, 'Baniyachong', '03', 200, 56, '2014-10-28 15:25:21', '2014-10-28 15:25:21'),
(71, 'Chunarughat', '04', 200, 56, '2014-10-28 15:25:58', '2014-10-28 15:25:58'),
(72, 'Habiganj Sadar', '05', 200, 56, '2014-10-28 15:26:31', '2014-10-28 15:26:31'),
(73, 'Lakhai', '06', 200, 56, '2014-10-28 15:27:07', '2014-10-28 15:27:07'),
(74, 'Madhabpur', '07', 200, 56, '2014-10-28 15:27:40', '2014-10-28 15:27:40'),
(75, 'Nabiganj', '08', 200, 56, '2014-10-28 15:28:23', '2014-10-28 15:28:23'),
(76, 'Barlekha', '09', 200, 55, '2014-10-28 15:29:09', '2014-10-28 15:29:09'),
(77, 'Kamalganj', '10', 200, 55, '2014-10-28 15:29:59', '2014-10-28 15:29:59'),
(78, 'Kulaura', '11', 200, 55, '2014-10-28 15:30:30', '2014-10-28 15:30:30'),
(79, 'Moulvibazar Sadar', '12', 200, 55, '2014-10-28 15:31:01', '2014-10-28 15:31:01'),
(80, 'Rajnagar', '13', 200, 55, '2014-10-28 15:31:40', '2014-10-28 15:31:40'),
(81, 'Sreemangal', '14', 200, 55, '2014-10-28 15:35:51', '2014-10-28 15:35:51'),
(82, 'Juri', '15', 200, 55, '2014-10-28 15:36:21', '2014-10-28 15:36:21'),
(83, 'Bishwamvarpur', '16', 200, 57, '2014-10-28 15:38:01', '2014-10-28 15:38:01'),
(84, 'Chhatak', '17', 200, 57, '2014-10-28 15:38:42', '2014-10-28 15:38:42'),
(85, 'Derai', '18', 200, 57, '2014-10-28 15:39:17', '2014-10-28 15:39:17'),
(86, 'Dharampasha', '19', 200, 57, '2014-10-28 15:39:52', '2014-10-28 15:39:52'),
(87, 'Dowarabazar', '20', 200, 57, '2014-10-28 15:40:25', '2014-10-28 15:40:25'),
(88, 'Jagannathpur', '21', 200, 57, '2014-10-28 15:41:07', '2014-10-28 15:41:07'),
(89, 'Jamalganj', '22', 200, 57, '2014-10-28 15:43:05', '2014-10-28 15:43:05'),
(90, 'Sullah', '23', 200, 57, '2014-10-28 15:44:07', '2014-10-28 15:44:07'),
(91, 'Sunamganj	Sadar', '24', 200, 57, '2014-10-28 15:45:59', '2014-10-28 15:45:59'),
(92, 'Tahirpur', '25', 200, 57, '2014-10-28 15:46:38', '2014-10-28 15:46:38'),
(93, 'South Sunamganj', '26', 200, 57, '2014-10-28 15:47:28', '2014-10-28 15:47:28'),
(94, 'Balaganj', '27', 200, 6, '2014-10-28 15:48:54', '2014-10-28 15:48:54'),
(95, 'Beanibazar', '28', 200, 6, '2014-10-28 15:49:42', '2014-10-28 15:49:42'),
(96, 'Bishwanath', '29', 200, 6, '2014-10-28 15:50:10', '2014-10-28 15:50:10'),
(97, 'Companigonj', '30', 200, 6, '2014-10-28 15:50:46', '2014-10-28 15:50:46'),
(98, 'Fenchuganj', '31', 200, 6, '2014-10-28 15:51:11', '2014-10-28 15:51:11'),
(99, 'Golapganj', '32', 200, 6, '2014-10-28 15:51:51', '2014-10-28 15:51:51'),
(100, 'Gowainghat', '33', 200, 6, '2014-10-28 15:52:55', '2014-10-28 15:52:55'),
(101, 'Jaintiapur', '34', 200, 6, '2014-10-28 15:53:31', '2014-10-28 15:53:31'),
(102, 'Kanaighat', '35', 200, 6, '2014-10-28 15:54:04', '2014-10-28 15:54:04'),
(103, 'Sylhet Sadar', '36', 200, 6, '2014-10-28 15:54:48', '2014-10-28 15:54:48'),
(104, 'Zakiganj', '37', 200, 6, '2014-10-28 15:55:15', '2014-10-28 15:55:15'),
(105, 'South Shurma', '38', 200, 6, '2014-10-28 15:55:45', '2014-10-28 15:55:45'),
(106, 'Birampur', '01', 9, 58, '2014-10-28 16:05:32', '2014-10-28 16:05:32'),
(107, 'Birganj', '02', 9, 58, '2014-10-28 16:06:19', '2014-10-28 16:06:19'),
(108, 'Biral', '03', 9, 58, '2014-10-28 16:06:50', '2014-10-28 16:06:50'),
(109, 'Bochaganj', '04', 9, 58, '2014-10-28 16:07:26', '2014-10-28 16:07:26'),
(110, 'Chirirbandar', '05', 9, 58, '2014-10-28 16:08:44', '2014-10-28 16:08:44'),
(111, 'Phulbari', '06', 9, 58, '2014-10-28 16:12:01', '2014-10-28 16:12:01'),
(112, 'Ghoraghat', '07', 9, 58, '2014-10-28 16:12:39', '2014-10-28 16:12:39'),
(113, 'Hakimpur', '08', 900, 58, '2014-10-28 16:13:34', '2014-10-28 16:13:34'),
(114, 'Kaharole', '09', 900, 58, '2014-10-28 16:14:08', '2014-10-28 16:14:08'),
(115, 'Khansama', '10', 900, 58, '2014-10-28 16:14:38', '2014-10-28 16:14:38'),
(116, 'Dinajpur Sadar', '11', 900, 58, '2014-10-28 16:15:11', '2014-10-28 16:15:11'),
(117, 'Nawabganj', '12', 900, 58, '2014-10-28 16:15:43', '2014-10-28 16:15:43'),
(118, 'Parbatipur', '13', 900, 58, '2014-10-28 16:16:10', '2014-10-28 16:16:10'),
(119, 'Phulchhari', '14', 900, 59, '2014-10-28 16:16:53', '2014-10-28 16:16:53'),
(120, 'Gaibandha Sadar', '15', 900, 59, '2014-10-28 16:17:38', '2014-10-28 16:17:38'),
(121, 'Gobindaganj', '16', 900, 59, '2014-10-28 16:18:23', '2014-10-28 16:18:23'),
(122, 'Palashbari', '17', 900, 59, '2014-10-28 16:19:04', '2014-10-28 16:19:04'),
(123, 'Sadullapur', '18', 900, 59, '2014-10-28 16:19:31', '2014-10-28 16:19:31'),
(124, 'Sughatta', '19', 900, 59, '2014-10-28 16:20:03', '2014-10-28 16:20:03'),
(125, 'Sundarganj', '20', 900, 59, '2014-10-28 16:20:43', '2014-10-28 16:20:43'),
(126, 'Badarganj', '21', 900, 7, '2014-10-28 16:21:27', '2014-10-28 16:21:27'),
(127, 'Gangachhara', '22', 900, 7, '2014-10-28 16:21:56', '2014-10-28 16:21:56'),
(128, 'Kaunia', '23', 900, 7, '2014-10-28 16:22:35', '2014-10-28 16:22:35'),
(129, 'Rangpur Sadar', '24', 900, 7, '2014-10-28 16:23:05', '2014-10-28 16:23:05'),
(130, 'Mithapukur', '25', 900, 7, '2014-10-28 16:23:31', '2014-10-28 16:23:31'),
(131, 'Pirgachha', '26', 900, 7, '2014-10-28 16:23:59', '2014-10-28 16:23:59'),
(132, 'Pirganj', '27', 900, 7, '2014-10-28 16:24:27', '2014-10-28 16:24:27'),
(133, 'Taraganj', '28', 900, 7, '2014-10-28 16:24:53', '2014-10-28 16:24:53'),
(134, 'Baliadangi', '29', 900, 64, '2014-10-28 16:25:31', '2014-10-28 16:25:31'),
(135, 'Haripur', '30', 900, 64, '2014-10-28 16:26:00', '2014-10-28 16:26:00'),
(136, 'Pirganj', '31', 900, 64, '2014-10-28 16:26:29', '2014-10-28 16:26:29'),
(137, 'Ranisankail', '32', 900, 64, '2014-10-28 16:27:04', '2014-10-28 16:27:04'),
(138, 'Thakurgaon Sadar', '33', 900, 64, '2014-10-28 16:27:39', '2014-10-28 16:27:39'),
(139, 'Bhurungamari', '01', 100, 60, '2014-10-28 16:40:52', '2014-10-28 16:40:52'),
(140, 'Char	 Rajibpur', '02', 100, 60, '2014-10-28 16:41:57', '2014-10-28 16:41:57'),
(141, 'Chilmari', '03', 100, 60, '2014-10-28 16:42:33', '2014-10-28 16:42:33'),
(142, 'Phulbari', '04', 100, 60, '2014-10-28 16:43:18', '2014-10-28 16:43:18'),
(143, 'Kurigram	Sadar', '05', 100, 60, '2014-10-28 16:44:02', '2014-10-28 16:44:02'),
(144, 'Nageshwari', '06', 100, 60, '2014-10-28 16:44:37', '2014-10-28 16:44:37'),
(145, 'Rajarhat', '07', 100, 60, '2014-10-28 16:45:20', '2014-10-28 16:45:20'),
(146, 'Raomari', '08', 100, 60, '2014-10-28 16:45:51', '2014-10-28 16:45:51'),
(147, 'Ulipur', '09', 100, 60, '2014-10-28 16:46:25', '2014-10-28 16:46:25'),
(148, 'Aditmari', '10', 100, 61, '2014-10-28 16:47:02', '2014-10-28 16:47:02'),
(149, 'Hatibandha', '11', 100, 61, '2014-10-28 16:47:35', '2014-10-28 16:47:35'),
(150, 'Kaliganj', '12', 100, 61, '2014-10-28 16:48:20', '2014-10-28 16:48:20'),
(151, 'Lalmonirhat Sadar', '13', 100, 61, '2014-10-28 16:48:55', '2014-10-28 16:48:55'),
(152, 'Patgram', '14', 100, 61, '2014-10-28 16:49:26', '2014-10-28 16:49:26'),
(153, 'Dimla', '15', 100, 62, '2014-10-28 16:50:37', '2014-10-28 16:50:37'),
(154, 'Domar', '16', 100, 62, '2014-10-28 16:51:13', '2014-10-28 16:51:13'),
(155, 'Jaldhaka', '17', 100, 62, '2014-10-28 16:51:46', '2014-10-28 16:51:46'),
(156, 'Kishoreganj', '18', 100, 62, '2014-10-28 16:52:31', '2014-10-28 16:52:31'),
(157, 'Nilphamari Sadar', '19', 100, 62, '2014-10-28 16:53:07', '2014-10-28 16:53:07'),
(158, 'Saidpur', '20', 100, 62, '2014-10-28 16:53:36', '2014-10-28 16:53:36'),
(159, 'Atwari', '21', 100, 63, '2014-10-28 16:54:21', '2014-10-28 16:54:21'),
(160, 'Boda', '22', 100, 63, '2014-10-28 16:54:47', '2014-10-28 16:54:47'),
(161, 'Debiganj', '23', 100, 63, '2014-10-28 16:55:28', '2014-10-28 16:55:28'),
(162, 'Panchagarh Sadar', '24', 100, 63, '2014-10-28 16:56:12', '2014-10-28 16:56:12'),
(163, 'Tetulia', '25', 100, 63, '2014-10-28 16:56:40', '2014-10-28 16:56:40'),
(164, 'Bagha', '01', 700, 2, '2014-10-28 17:26:42', '2014-10-28 17:26:42'),
(165, 'Bagmara', '02', 700, 2, '2014-10-28 17:27:18', '2014-10-28 17:27:18'),
(166, 'Charghat', '03', 700, 2, '2014-10-28 17:28:01', '2014-10-28 17:28:01'),
(167, 'Durgapur', '04', 700, 2, '2014-10-28 17:28:31', '2014-10-28 17:28:31'),
(168, 'Godagari', '05', 700, 2, '2014-10-28 17:28:57', '2014-10-28 17:28:57'),
(169, 'Mohanpur', '06', 700, 2, '2014-10-28 17:29:23', '2014-10-28 17:29:23'),
(170, 'Paba', '07', 700, 2, '2014-10-28 17:29:52', '2014-10-28 17:29:52'),
(171, 'Puthia', '08', 700, 2, '2014-10-28 17:30:23', '2014-10-28 17:30:23'),
(172, 'Tanore', '09', 700, 2, '2014-10-28 17:30:50', '2014-10-28 17:30:50'),
(173, 'Boalia', '10', 700, 2, '2014-10-28 17:33:10', '2014-10-28 17:33:10'),
(174, 'Matihar', '11', 700, 2, '2014-10-28 17:33:34', '2014-10-28 17:33:34'),
(175, 'Rajpara', '12', 700, 2, '2014-10-28 17:34:05', '2014-10-28 17:34:05'),
(176, 'Shah Mokdum', '13', 700, 2, '2014-10-28 17:35:00', '2014-10-28 17:35:00'),
(177, 'Akkelpur', '14', 700, 25, '2014-10-28 17:35:41', '2014-10-28 17:35:41'),
(178, 'Joypurhat	Sadar', '15', 700, 25, '2014-10-28 17:36:49', '2014-10-28 17:36:49'),
(179, 'Kalai', '16', 700, 25, '2014-10-28 17:37:43', '2014-10-28 17:37:43'),
(180, 'Khetlal', '17', 200, 25, '2014-10-28 17:38:23', '2014-10-28 17:38:23'),
(181, 'Baksiganj', '01', 200, 14, '2014-10-28 17:38:37', '2014-10-28 17:38:37'),
(182, 'Panchbibi', '18', 700, 25, '2014-10-28 17:39:01', '2014-10-28 17:39:01'),
(183, 'Dewanganj', '02', 200, 14, '2014-10-28 17:39:08', '2014-10-28 17:39:08'),
(184, 'Islampur', '03', 200, 14, '2014-10-28 17:39:50', '2014-10-28 17:39:50'),
(185, 'Atrai', '19', 700, 26, '2014-10-28 17:40:26', '2014-10-28 17:40:26'),
(186, 'Badalgachhi', '20', 700, 26, '2014-10-28 17:41:00', '2014-10-28 17:41:00'),
(187, 'Manda', '21', 700, 26, '2014-10-28 17:41:30', '2014-10-28 17:41:30'),
(188, 'Dhamoirhat', '22', 700, 26, '2014-10-28 17:42:04', '2014-10-28 17:42:04'),
(189, 'Mohadevpur', '23', 700, 26, '2014-10-28 17:42:34', '2014-10-28 17:42:34'),
(190, 'Naogaon	Sadar', '24', 700, 26, '2014-10-28 17:43:04', '2014-10-28 17:43:04'),
(191, 'Niamatpur', '25', 700, 26, '2014-10-28 17:43:37', '2014-10-28 17:43:37'),
(192, 'Patnitala', '26', 700, 26, '2014-10-28 17:44:19', '2014-10-28 17:44:19'),
(193, 'Jamalpur Sadar', '05', 200, 14, '2014-10-28 17:44:27', '2014-10-28 17:44:27'),
(194, 'Porsha', '27', 700, 26, '2014-10-28 17:44:59', '2014-10-28 17:44:59'),
(195, 'Madarganj', '04', 200, 14, '2014-10-28 17:45:17', '2014-10-28 17:45:17'),
(196, 'Raninagar', '28', 700, 26, '2014-10-28 17:45:55', '2014-10-28 17:45:55'),
(197, 'Melandaha', '06', 200, 14, '2014-10-28 17:47:09', '2014-10-28 17:47:09'),
(198, 'Sapahar', '29', 700, 26, '2014-10-28 17:47:17', '2014-10-28 17:47:17'),
(199, 'Sarishabari', '07', 200, 14, '2014-10-28 17:47:36', '2014-10-28 17:47:36'),
(200, 'Bholahat', '30', 700, 28, '2014-10-28 17:48:46', '2014-10-28 17:48:46'),
(201, 'Gomastapur', '31', 700, 28, '2014-10-28 17:49:15', '2014-10-28 17:49:15'),
(202, 'Nachole', '32', 700, 28, '2014-10-28 17:49:43', '2014-10-28 17:49:43'),
(203, 'Nawabganj', '33', 700, 28, '2014-10-28 17:50:10', '2014-10-28 17:50:10'),
(204, 'Shibganj', '34', 700, 28, '2014-10-28 17:50:43', '2014-10-28 17:50:43'),
(205, 'Bhaluka', '08', 200, 10, '2014-10-28 17:50:47', '2014-10-28 17:50:47'),
(206, 'Dhobaura', '09', 200, 10, '2014-10-28 17:51:43', '2014-10-28 17:51:43'),
(207, 'Fulbaria', '10', 200, 10, '2014-10-28 17:52:12', '2014-10-28 17:52:12'),
(208, 'Gaffargaon', '11', 200, 10, '2014-10-28 17:53:14', '2014-10-28 17:53:14'),
(209, 'Gauripur', '12', 200, 10, '2014-10-28 17:54:53', '2014-10-28 17:54:53'),
(210, 'Haluaghat', '13', 200, 10, '2014-10-28 17:55:37', '2014-10-28 17:55:37'),
(211, 'Ishwarganj', '14', 200, 10, '2014-10-28 17:55:59', '2014-10-28 17:55:59'),
(212, 'Mymensingh Sadar', '15', 200, 10, '2014-10-28 17:56:34', '2014-10-28 17:56:34'),
(213, 'Muktagachha', '16', 200, 10, '2014-10-28 17:56:53', '2014-10-28 17:56:53'),
(214, 'Nandail', '17', 200, 10, '2014-10-28 17:57:13', '2014-10-28 17:57:13'),
(215, 'Adamdighi', '01', 800, 24, '2014-10-28 17:58:52', '2014-10-28 17:58:52'),
(216, 'Bogra Sadar', '02', 800, 24, '2014-10-28 17:59:37', '2014-10-28 17:59:37'),
(217, 'Dhunat', '03', 800, 24, '2014-10-28 18:00:06', '2014-10-28 18:00:06'),
(218, 'Phulpur', '18', 200, 10, '2014-10-28 18:00:11', '2014-10-28 18:00:11'),
(219, 'Dhupchanchia', '04', 800, 24, '2014-10-28 18:00:41', '2014-10-28 18:00:41'),
(220, 'Gabtali', '05', 800, 24, '2014-10-28 18:01:10', '2014-10-28 18:01:10'),
(221, 'Trishal', '19', 200, 10, '2014-10-28 18:01:31', '2014-10-28 18:01:31'),
(222, 'Kahaloo', '06', 800, 24, '2014-10-28 18:01:38', '2014-10-28 18:01:38'),
(223, 'Nandigram', '07', 800, 24, '2014-10-28 18:02:04', '2014-10-28 18:02:04'),
(224, 'Tara Khanda', '20', 200, 10, '2014-10-28 18:02:11', '2014-10-28 18:02:11'),
(225, 'Sariakandi', '08', 800, 24, '2014-10-28 18:02:32', '2014-10-28 18:02:32'),
(226, 'Shajahanpur', '09', 800, 24, '2014-10-28 18:03:13', '2014-10-28 18:03:13'),
(227, 'Sherpur', '10', 800, 24, '2014-10-28 18:03:44', '2014-10-28 18:03:44'),
(228, 'Shibganj', '11', 800, 24, '2014-10-28 18:04:19', '2014-10-28 18:04:19'),
(229, 'Sonatola', '12', 800, 24, '2014-10-28 18:04:47', '2014-10-28 18:04:47'),
(230, 'Bagatipara', '13', 800, 27, '2014-10-28 18:05:31', '2014-10-28 18:05:31'),
(231, 'Baraigram', '14', 800, 27, '2014-10-28 18:06:01', '2014-10-28 18:06:01'),
(232, 'Gurudaspur', '15', 800, 27, '2014-10-28 18:06:32', '2014-10-28 18:06:32'),
(233, 'Lalpur', '16', 800, 27, '2014-10-28 18:06:56', '2014-10-28 18:06:56'),
(234, 'Natore Sadar', '17', 800, 27, '2014-10-28 18:07:32', '2014-10-28 18:07:32'),
(235, 'Atpara', '21', 200, 21, '2014-10-28 18:07:40', '2014-10-28 18:07:40'),
(236, 'Singra', '18', 800, 27, '2014-10-28 18:08:04', '2014-10-28 18:08:04'),
(237, 'Naldanga', '19', 800, 27, '2014-10-28 18:08:28', '2014-10-28 18:08:28'),
(238, 'Ataikula', '20', 800, 29, '2014-10-28 18:09:40', '2014-10-28 18:09:40'),
(239, 'Atgharia', '21', 800, 29, '2014-10-28 18:10:06', '2014-10-28 18:10:06'),
(240, 'Bera', '22', 800, 29, '2014-10-28 18:10:36', '2014-10-28 18:10:36'),
(241, 'Bhangura', '23', 800, 29, '2014-10-28 18:11:02', '2014-10-28 18:11:02'),
(242, 'Barhatta', '22', 200, 21, '2014-10-28 18:11:06', '2014-10-28 18:11:06'),
(243, 'Chatmohar', '24', 800, 29, '2014-10-28 18:11:25', '2014-10-28 18:11:25'),
(244, 'Faridpur', '25', 700, 29, '2014-10-28 18:11:51', '2014-10-28 18:11:51'),
(245, 'Ishwardi', '26', 800, 29, '2014-10-28 18:13:00', '2014-10-28 18:13:00'),
(246, 'Pabna Sadar', '27', 800, 29, '2014-10-28 18:13:38', '2014-10-28 18:13:38'),
(247, 'Santhia', '28', 800, 29, '2014-10-28 18:14:07', '2014-10-28 18:14:07'),
(248, 'Sujanagar', '29', 800, 29, '2014-10-28 18:14:34', '2014-10-28 18:14:34'),
(249, 'Durgapur', '23', 200, 21, '2014-10-28 18:14:50', '2014-10-28 18:14:50'),
(250, 'Khaliajuri', '24', 200, 21, '2014-10-28 18:15:28', '2014-10-28 18:15:28'),
(251, 'Belkuchi', '30', 800, 30, '2014-10-28 18:15:45', '2014-10-28 18:15:45'),
(252, 'Kalmakanda', '25', 200, 21, '2014-10-28 18:15:59', '2014-10-28 18:15:59'),
(253, 'Chauhali', '31', 800, 30, '2014-10-28 18:16:24', '2014-10-28 18:16:24'),
(254, 'Kendua', '26', 200, 21, '2014-10-28 18:16:56', '2014-10-28 18:16:56'),
(255, 'Kamarkhanda', '32', 800, 30, '2014-10-28 18:17:08', '2014-10-28 18:17:08'),
(256, 'Madan', '27', 200, 21, '2014-10-28 18:17:34', '2014-10-28 18:17:34'),
(257, 'Kazipur', '33', 800, 30, '2014-10-28 18:17:39', '2014-10-28 18:17:39'),
(258, 'Raiganj', '34', 800, 30, '2014-10-28 18:18:09', '2014-10-28 18:18:09'),
(259, 'Mohanganj', '28', 200, 21, '2014-10-28 18:18:20', '2014-10-28 18:18:20'),
(260, 'Netrokona Sadar', '29', 200, 21, '2014-10-28 18:18:40', '2014-10-28 18:18:40'),
(261, 'Shahjadpur', '35', 800, 30, '2014-10-28 18:18:44', '2014-10-28 18:18:44'),
(262, 'Sirajganj	Sadar', '36', 800, 30, '2014-10-28 18:19:17', '2014-10-28 18:19:17'),
(263, 'Tarash', '37', 800, 30, '2014-10-28 18:20:04', '2014-10-28 18:20:04'),
(264, 'Ullahpara', '38', 800, 30, '2014-10-28 18:20:42', '2014-10-28 18:20:42'),
(265, 'Purbadhala', '30', 200, 21, '2014-10-28 18:21:13', '2014-10-28 18:21:13'),
(266, 'Bagerhat	Sadar', '01', 110, 32, '2014-10-28 18:25:27', '2014-10-28 18:25:27'),
(267, 'Chitalmari', '02', 110, 32, '2014-10-28 18:26:07', '2014-10-28 18:26:07'),
(268, 'Fakirhat', '03', 110, 32, '2014-10-28 18:26:59', '2014-10-28 18:26:59'),
(269, 'Kachua', '04', 110, 32, '2014-10-28 18:27:28', '2014-10-28 18:27:28'),
(270, 'Mollahat', '05', 110, 32, '2014-10-28 18:28:04', '2014-10-28 18:28:04'),
(271, 'Mongla', '06', 110, 32, '2014-10-28 18:28:31', '2014-10-28 18:28:31'),
(272, 'Morrelganj', '07', 110, 32, '2014-10-28 18:29:00', '2014-10-28 18:29:00'),
(273, 'Rampal', '08', 110, 32, '2014-10-28 18:29:34', '2014-10-28 18:29:34'),
(274, 'Sarankhola', '09', 110, 32, '2014-10-28 18:29:57', '2014-10-28 18:29:57'),
(275, 'Batiaghata', '10', 110, 3, '2014-10-28 18:30:33', '2014-10-28 18:30:33'),
(276, 'Dacope', '11', 110, 3, '2014-10-28 18:31:05', '2014-10-28 18:31:05'),
(277, 'Dumuria', '12', 110, 3, '2014-10-28 18:31:49', '2014-10-28 18:31:49'),
(278, 'Dighalia', '13', 110, 3, '2014-10-28 18:32:17', '2014-10-28 18:32:17'),
(279, 'Koyra', '14', 110, 3, '2014-10-28 18:32:42', '2014-10-28 18:32:42'),
(280, 'Paikgachha', '15', 110, 3, '2014-10-28 18:33:06', '2014-10-28 18:33:06'),
(281, 'Phultala', '16', 110, 3, '2014-10-28 18:33:43', '2014-10-28 18:33:43'),
(282, 'Rupsha', '17', 110, 3, '2014-10-28 18:34:07', '2014-10-28 18:34:07'),
(283, 'Terokhada', '18', 110, 3, '2014-10-28 18:34:31', '2014-10-28 18:34:31'),
(284, 'Daulatpur', '19', 110, 3, '2014-10-28 18:34:58', '2014-10-28 18:34:58'),
(285, 'Khalishpur', '20', 110, 3, '2014-10-28 18:35:21', '2014-10-28 18:35:21'),
(286, 'Khan Jahan Ali', '21', 110, 3, '2014-10-28 18:36:00', '2014-10-28 18:36:00'),
(287, 'Kotwali', '22', 110, 3, '2014-10-28 18:36:16', '2014-10-28 18:36:16'),
(288, 'Sonadanga', '23', 110, 3, '2014-10-28 18:36:38', '2014-10-28 18:36:38'),
(289, 'Harintana', '24', 110, 6, '2014-10-28 18:37:05', '2014-10-28 18:37:05'),
(290, 'Assasuni', '25', 110, 31, '2014-10-28 18:38:07', '2014-10-28 18:38:07'),
(291, 'Kalaroa', '27', 110, 3, '2014-10-28 18:38:30', '2014-10-28 18:38:30'),
(292, 'Kaliganj', '28', 110, 31, '2014-10-28 18:39:11', '2014-10-28 18:39:11'),
(293, 'Satkhira sadar', '29', 110, 31, '2014-10-28 18:39:49', '2014-10-28 18:39:49'),
(294, 'Shyamnagar', '30', 110, 31, '2014-10-28 18:41:03', '2014-10-28 18:41:03'),
(295, 'Tala', '31', 110, 31, '2014-10-28 18:41:38', '2014-10-28 18:41:38'),
(296, 'Kalia', '01', 120, 34, '2014-10-28 18:42:41', '2014-10-28 18:42:41'),
(297, 'Lohagara', '02', 120, 34, '2014-10-28 18:43:36', '2014-10-28 18:43:36'),
(298, 'Narail	Sadar', '03', 120, 34, '2014-10-28 18:44:23', '2014-10-28 18:44:23'),
(299, 'Naragati', '04', 120, 34, '2014-10-28 18:45:01', '2014-10-28 18:45:01'),
(300, 'Abhaynagar', '05', 120, 33, '2014-10-28 18:45:46', '2014-10-28 18:45:46'),
(301, 'Bagherpara', '06', 120, 33, '2014-10-28 18:46:51', '2014-10-28 18:46:51'),
(302, 'Chaugachha', '07', 120, 33, '2014-10-28 18:47:25', '2014-10-28 18:47:25'),
(303, 'Jhikargachha', '08', 120, 33, '2014-10-28 18:47:55', '2014-10-28 18:47:55'),
(304, 'Keshabpur', '09', 120, 33, '2014-10-28 18:48:29', '2014-10-28 18:48:29'),
(305, 'Jessore	Sadar', '10', 120, 33, '2014-10-28 18:49:15', '2014-10-28 18:49:15'),
(306, 'Manirampur', '11', 120, 33, '2014-10-28 18:50:23', '2014-10-28 18:50:23'),
(307, 'Sharsha', '12', 120, 33, '2014-10-28 18:51:04', '2014-10-28 18:51:04'),
(308, 'Magura Sadar', '13', 21, 35, '2014-10-28 18:51:52', '2014-10-28 18:51:52'),
(309, 'Mohammadpur', '14', 120, 35, '2014-10-28 18:53:24', '2014-10-28 18:53:24'),
(310, 'Shalikha', '15', 120, 35, '2014-10-28 18:53:48', '2014-10-28 18:53:48'),
(311, 'Sreepur', '16', 120, 35, '2014-10-28 18:54:27', '2014-10-28 18:54:27'),
(312, 'Alamdanga', '01', 130, 37, '2014-10-28 18:55:17', '2014-10-28 18:55:17'),
(313, 'Chuadanga Sadar', '02', 120, 37, '2014-10-28 18:55:59', '2014-10-28 18:55:59'),
(314, 'Damurhuda', '03', 120, 37, '2014-10-28 18:56:53', '2014-10-28 18:56:53'),
(315, 'Jibannagar', '04', 120, 37, '2014-10-28 18:57:20', '2014-10-28 18:57:20'),
(316, 'Harinakunda', '05', 120, 36, '2014-10-28 18:57:58', '2014-10-28 18:57:58'),
(317, 'Jhenaidah Sadar', '06', 120, 36, '2014-10-28 18:58:55', '2014-10-28 18:58:55'),
(318, 'Kaliganj', '07', 120, 36, '2014-10-28 19:00:11', '2014-10-28 19:00:11'),
(319, 'Kotchandpur', '08', 120, 36, '2014-10-28 19:00:55', '2014-10-28 19:00:55'),
(320, 'Maheshpur', '09', 120, 36, '2014-10-28 19:01:21', '2014-10-28 19:01:21'),
(321, 'Shailkupa', '10', 120, 36, '2014-10-28 19:01:49', '2014-10-28 19:01:49'),
(322, 'Bheramara', '11', 130, 38, '2014-10-28 19:03:45', '2014-10-28 19:03:45'),
(323, 'Daulatpur', '12', 130, 38, '2014-10-28 19:04:20', '2014-10-28 19:04:20'),
(324, 'Khoksa', '13', 130, 38, '2014-10-28 19:04:45', '2014-10-28 19:04:45'),
(325, 'Kumarkhali', '14', 130, 38, '2014-10-28 19:05:08', '2014-10-28 19:05:08'),
(326, 'Kushtia Sadar', '15', 130, 38, '2014-10-28 19:05:50', '2014-10-28 19:05:50'),
(327, 'Mirpur', '16', 130, 38, '2014-10-28 19:06:19', '2014-10-28 19:06:19'),
(328, 'Shekhpara', '17', 130, 38, '2014-10-28 19:07:08', '2014-10-28 19:07:08'),
(329, 'Gangni', '18', 130, 39, '2014-10-28 19:08:13', '2014-10-28 19:08:13'),
(330, 'Meherpur Sadar', '19', 130, 39, '2014-10-28 19:09:14', '2014-10-28 19:09:14'),
(331, 'Mujibnagar', '20', 130, 39, '2014-10-28 19:09:41', '2014-10-28 19:09:41'),
(332, 'Ali Kadam', '01', 140, 40, '2014-10-28 19:23:22', '2014-10-28 19:23:22'),
(333, 'Bandarban Sadar', '02', 140, 40, '2014-10-28 19:24:28', '2014-10-28 19:24:28'),
(334, 'Lama', '03', 140, 40, '2014-10-28 19:26:00', '2014-10-28 19:26:00'),
(335, 'Naikhongchhari', '04', 140, 40, '2014-10-28 19:26:30', '2014-10-28 19:26:30'),
(336, 'Rowangchhari', '05', 140, 40, '2014-10-28 19:27:10', '2014-10-28 19:27:10'),
(337, 'Ruma', '06', 140, 40, '2014-10-28 19:27:52', '2014-10-28 19:27:52'),
(338, 'Thanchi', '07', 140, 40, '2014-10-28 19:28:27', '2014-10-28 19:28:27'),
(339, 'Chakaria', '08', 140, 43, '2014-10-28 19:38:47', '2014-10-28 19:38:47'),
(340, 'Cox\'s Bazar Sadar', '09', 140, 43, '2014-10-28 19:39:28', '2014-10-28 19:39:28'),
(341, 'Kutubdia', '10', 140, 43, '2014-10-28 19:39:56', '2014-10-28 19:39:56'),
(342, 'Maheshkhali', '11', 140, 43, '2014-10-28 19:40:26', '2014-10-28 19:40:26'),
(343, 'Ramu', '12', 140, 43, '2014-10-28 19:40:59', '2014-10-28 19:40:59'),
(344, 'Teknaf', '13', 140, 43, '2014-10-28 19:41:27', '2014-10-28 19:41:27'),
(345, 'Ukhia', '14', 140, 43, '2014-10-28 19:41:53', '2014-10-28 19:41:53'),
(346, 'Pekua', '15', 140, 43, '2014-10-28 19:42:16', '2014-10-28 19:42:16'),
(347, 'Chhagalnaiya', '16', 140, 44, '2014-10-28 19:42:43', '2014-10-28 19:42:43'),
(348, 'Daganbhuiyan', '17', 140, 44, '2014-10-28 19:43:08', '2014-10-28 19:43:08'),
(349, 'Feni	Sadar', '18', 140, 44, '2014-10-28 19:43:39', '2014-10-28 19:43:39'),
(350, 'Parshuram', '19', 140, 44, '2014-10-28 19:44:02', '2014-10-28 19:44:02'),
(351, 'Sonagazi', '20', 140, 44, '2014-10-28 19:44:25', '2014-10-28 19:44:25'),
(352, 'Fulgazi', '21', 140, 44, '2014-10-28 19:44:47', '2014-10-28 19:44:47'),
(353, 'Anwara', '22', 140, 4, '2014-10-28 19:45:15', '2014-10-28 19:45:15'),
(354, 'Banshkhali', '23', 140, 4, '2014-10-28 19:45:46', '2014-10-28 19:45:46'),
(355, 'Boalkhali', '24', 140, 4, '2014-10-28 19:46:10', '2014-10-28 19:46:10'),
(356, 'Chandanaish', '25', 140, 4, '2014-10-28 19:46:46', '2014-10-28 19:46:46'),
(357, 'Fatikchhari', '26', 140, 4, '2014-10-28 19:47:12', '2014-10-28 19:47:12'),
(358, 'Hathazari', '27', 140, 4, '2014-10-28 19:47:36', '2014-10-28 19:47:36'),
(359, 'Lohagara', '28', 140, 4, '2014-10-28 19:48:07', '2014-10-28 19:48:07'),
(360, 'Mirsharai', '29', 140, 4, '2014-10-28 19:48:30', '2014-10-28 19:48:30'),
(361, 'Jhenaigati', '31', 200, 17, '2014-10-28 19:48:45', '2014-10-28 19:48:45'),
(362, 'Patiya', '30', 140, 4, '2014-10-28 19:48:59', '2014-10-28 19:48:59'),
(363, 'Nakla', '32', 200, 17, '2014-10-28 19:49:15', '2014-10-28 19:49:15'),
(364, 'Rangunia', '31', 140, 4, '2014-10-28 19:49:24', '2014-10-28 19:49:24'),
(365, 'Raozan', '32', 140, 4, '2014-10-28 19:49:46', '2014-10-28 19:49:46'),
(366, 'Sandwip', '33', 140, 4, '2014-10-28 19:50:08', '2014-10-28 19:50:08'),
(367, 'Nalitabari', '33', 200, 17, '2014-10-28 19:50:24', '2014-10-28 19:50:24'),
(368, 'Satkania', '34', 140, 4, '2014-10-28 19:50:42', '2014-10-28 19:50:42'),
(369, 'Sitakunda', '35', 140, 4, '2014-10-28 19:51:03', '2014-10-28 19:51:03'),
(370, 'Sherpur Sadar', '34', 200, 17, '2014-10-28 19:51:03', '2014-10-28 19:51:03'),
(371, 'Bandor-Chittagong	Port', '36', 140, 4, '2014-10-28 19:51:59', '2014-10-28 19:51:59'),
(372, 'Chandgaon', '37', 140, 4, '2014-10-28 19:52:28', '2014-10-28 19:52:28'),
(373, 'Sreebardi', '35', 200, 17, '2014-10-28 19:52:29', '2014-10-28 19:52:29'),
(374, 'Double	Mooring', '38', 140, 4, '2014-10-28 19:52:57', '2014-10-28 19:52:57'),
(375, 'Kotwali', '39', 140, 4, '2014-10-28 19:53:26', '2014-10-28 19:53:26'),
(376, 'Pahartali', '40', 140, 4, '2014-10-28 19:53:50', '2014-10-28 19:53:50'),
(377, 'Panchlaish', '41', 140, 4, '2014-10-28 19:54:16', '2014-10-28 19:54:16'),
(378, 'Dighinala', '42', 140, 42, '2014-10-28 19:54:54', '2014-10-28 19:54:54'),
(379, 'Alfadanga', '01', 200, 23, '2014-10-28 19:55:09', '2014-10-28 19:55:09'),
(380, 'Khagrachhari sadar', '43', 140, 42, '2014-10-28 19:56:37', '2014-10-28 19:56:37'),
(381, 'Bhanga', '02', 200, 23, '2014-10-28 19:56:59', '2014-10-28 19:56:59'),
(382, 'Lakshmichhari', '44', 140, 42, '2014-10-28 19:57:04', '2014-10-28 19:57:04'),
(383, 'Mahalchhari', '45', 140, 42, '2014-10-28 19:57:31', '2014-10-28 19:57:31'),
(384, 'Manikchhari', '46', 140, 42, '2014-10-28 19:58:00', '2014-10-28 19:58:00'),
(385, 'Matiranga', '47', 140, 42, '2014-10-28 19:58:45', '2014-10-28 19:58:45'),
(386, 'Panchhari', '48', 140, 42, '2014-10-28 20:01:12', '2014-10-28 20:01:12'),
(387, 'Ramgarh', '49', 140, 42, '2014-10-28 20:01:39', '2014-10-28 20:01:39'),
(388, 'Bagaichhari', '50', 140, 41, '2014-10-28 20:02:18', '2014-10-28 20:02:18'),
(389, 'Barkal', '51', 140, 41, '2014-10-28 20:02:58', '2014-10-28 20:02:58'),
(390, 'Kawkhali-Betbunia', '52', 140, 41, '2014-10-28 20:04:02', '2014-10-28 20:04:02'),
(391, 'Belaichhari', '53', 140, 41, '2014-10-28 20:04:32', '2014-10-28 20:04:32'),
(392, 'Kaptai', '54', 140, 41, '2014-10-28 20:04:59', '2014-10-28 20:04:59'),
(393, 'Juraichhari', '55', 140, 41, '2014-10-28 20:05:27', '2014-10-28 20:05:27'),
(394, 'Langadu', '56', 140, 41, '2014-10-28 20:05:53', '2014-10-28 20:05:53'),
(395, 'Naniyachar', '57', 140, 41, '2014-10-28 20:06:20', '2014-10-28 20:06:20'),
(396, 'Rajasthali', '58', 140, 41, '2014-10-28 20:06:46', '2014-10-28 20:06:46'),
(397, 'Rangamati', '59', 140, 41, '2014-10-28 20:07:09', '2014-10-28 20:07:09'),
(398, 'Amtali', '01', 160, 50, '2014-10-28 20:13:24', '2014-10-28 20:13:24'),
(399, 'Bamna', '02', 160, 50, '2014-10-28 20:13:54', '2014-10-28 20:13:54'),
(400, 'Barguna Sadar', '03', 160, 50, '2014-10-28 20:14:27', '2014-10-28 20:14:27'),
(401, 'Betagi', '04', 160, 50, '2014-10-28 20:14:52', '2014-10-28 20:14:52'),
(402, 'Patharghata', '05', 160, 50, '2014-10-28 20:15:22', '2014-10-28 20:15:22'),
(403, 'Taltoli', '06', 160, 50, '2014-10-28 20:15:57', '2014-10-28 20:15:57'),
(404, 'Agailjhara', '07', 160, 5, '2014-10-28 20:16:34', '2014-10-28 20:16:34'),
(405, 'Babuganj', '08', 160, 5, '2014-10-28 20:16:59', '2014-10-28 20:16:59'),
(406, 'Bakerganj', '09', 160, 5, '2014-10-28 20:17:26', '2014-10-28 20:17:26'),
(407, 'Boalmari', '03', 200, 23, '2014-10-28 20:17:30', '2014-10-28 20:17:30'),
(408, 'Banaripara', '10', 160, 5, '2014-10-28 20:17:50', '2014-10-28 20:17:50'),
(409, 'Charbhadrasan', '04', 200, 23, '2014-10-28 20:18:04', '2014-10-28 20:18:04'),
(410, 'Gaurnadi', '11', 160, 5, '2014-10-28 20:18:24', '2014-10-28 20:18:24'),
(411, 'Hizla', '12', 160, 5, '2014-10-28 20:18:44', '2014-10-28 20:18:44'),
(412, 'Faridpur Sadar', '05', 200, 23, '2014-10-28 20:19:12', '2014-10-28 20:19:12'),
(413, 'Barisal Sadar', '13', 160, 5, '2014-10-28 20:19:17', '2014-10-28 20:19:17'),
(414, 'Madhukhali', '06', 200, 23, '2014-10-28 20:19:42', '2014-10-28 20:19:42'),
(415, 'Mehendiganj', '14', 160, 5, '2014-10-28 20:19:52', '2014-10-28 20:19:52'),
(416, 'Nagarkanda', '07', 200, 23, '2014-10-28 20:20:08', '2014-10-28 20:20:08'),
(417, 'Muladi', '15', 160, 5, '2014-10-28 20:20:18', '2014-10-28 20:20:18'),
(418, 'Wazirpur', '16', 160, 5, '2014-10-28 20:20:41', '2014-10-28 20:20:41'),
(419, 'Sadarpur', '08', 200, 23, '2014-10-28 20:20:48', '2014-10-28 20:20:48'),
(420, 'Bhola Sadar', '17', 160, 51, '2014-10-28 20:21:13', '2014-10-28 20:21:13'),
(421, 'Burhanuddin', '18', 160, 51, '2014-10-28 20:21:50', '2014-10-28 20:21:50'),
(422, 'Char	Fasson', '19', 160, 51, '2014-10-28 20:22:27', '2014-10-28 20:22:27'),
(423, 'Gopalganj Sadar', '09', 200, 16, '2014-10-28 20:22:54', '2014-10-28 20:22:54'),
(424, 'Daulatkhan', '20', 160, 51, '2014-10-28 20:23:10', '2014-10-28 20:23:10'),
(425, 'Lalmohan', '21', 160, 51, '2014-10-28 20:23:43', '2014-10-28 20:23:43'),
(426, 'Manpura', '22', 160, 51, '2014-10-28 20:24:07', '2014-10-28 20:24:07'),
(427, 'Kashiani', '10', 200, 16, '2014-10-28 20:24:09', '2014-10-28 20:24:09'),
(428, 'Tazumuddin', '23', 160, 51, '2014-10-28 20:24:51', '2014-10-28 20:24:51'),
(429, 'Jhalokati	Sadar', '24', 160, 52, '2014-10-28 20:25:42', '2014-10-28 20:25:42'),
(430, 'Kathalia', '25', 160, 52, '2014-10-28 20:26:17', '2014-10-28 20:26:17'),
(431, 'Kotalipara', '11', 200, 16, '2014-10-28 20:26:21', '2014-10-28 20:26:21'),
(432, 'Nalchity', '26', 160, 52, '2014-10-28 20:26:46', '2014-10-28 20:26:46'),
(433, 'Muksudpur', '12', 200, 16, '2014-10-28 20:26:57', '2014-10-28 20:26:57'),
(434, 'Rajapur', '27', 160, 52, '2014-10-28 20:27:16', '2014-10-28 20:27:16'),
(435, 'Bauphal', '28', 160, 53, '2014-10-28 20:27:55', '2014-10-28 20:27:55'),
(436, 'Dashmina', '29', 160, 53, '2014-10-28 20:28:29', '2014-10-28 20:28:29'),
(437, 'Galachipa', '30', 160, 53, '2014-10-28 20:28:53', '2014-10-28 20:28:53'),
(438, 'Kalapara', '31', 160, 53, '2014-10-28 20:29:18', '2014-10-28 20:29:18'),
(439, 'Mirzaganj', '32', 160, 53, '2014-10-28 20:29:47', '2014-10-28 20:29:47'),
(440, 'Patuakhali Sadar', '33', 160, 53, '2014-10-28 20:30:23', '2014-10-28 20:30:23'),
(441, 'Rangabali', '34', 140, 53, '2014-10-28 20:30:55', '2014-10-28 20:30:55'),
(442, 'Dumki', '35', 160, 53, '2014-10-28 20:31:32', '2014-10-28 20:31:32'),
(443, 'Bhandaria', '36', 160, 54, '2014-10-28 20:32:09', '2014-10-28 20:32:09'),
(444, 'Kawkhali', '37', 160, 54, '2014-10-28 20:32:39', '2014-10-28 20:32:39'),
(445, 'Mathbaria', '38', 160, 54, '2014-10-28 20:33:06', '2014-10-28 20:33:06'),
(446, 'Nazirpur', '39', 160, 54, '2014-10-28 20:33:33', '2014-10-28 20:33:33'),
(447, 'Pirojpur Sadar', '40', 160, 54, '2014-10-28 20:34:14', '2014-10-28 20:34:14'),
(448, 'Tungipara', '13', 200, 16, '2014-10-28 20:34:14', '2014-10-28 20:34:14'),
(449, 'Nesarabad-Swarupkati', '41', 160, 54, '2014-10-28 20:35:16', '2014-10-28 20:35:16'),
(450, 'Zianagor', '42', 160, 54, '2014-10-28 20:35:43', '2014-10-28 20:35:43'),
(451, 'Rajoir', '14', 200, 8, '2014-10-28 20:36:02', '2014-10-28 20:36:02'),
(452, 'Akhaura', '01', 170, 48, '2014-10-28 20:41:40', '2014-10-28 20:41:40'),
(453, 'Bancharampur', '02', 170, 48, '2014-10-28 20:42:29', '2014-10-28 20:42:29'),
(454, 'Madaripur Sadar', '15', 200, 13, '2014-10-28 20:45:46', '2014-10-28 20:45:46'),
(455, 'Kalkini', '16', 200, 13, '2014-10-28 20:46:40', '2014-10-28 20:46:40'),
(456, 'Brahmanbaria sadar', '03', 170, 48, '2014-10-28 20:46:53', '2014-10-28 20:46:53'),
(457, 'Kasba', '04', 170, 48, '2014-10-28 20:47:34', '2014-10-28 20:47:34'),
(458, 'Shibchar', '17', 200, 13, '2014-10-28 20:47:47', '2014-10-28 20:47:47'),
(459, 'Nabinagar', '05', 170, 48, '2014-10-28 20:48:08', '2014-10-28 20:48:08'),
(460, 'Nasirnagar', '06', 170, 48, '2014-10-28 20:48:32', '2014-10-28 20:48:32'),
(461, 'Sarail', '07', 170, 48, '2014-10-28 20:49:01', '2014-10-28 20:49:01'),
(462, 'Ashuganj', '08', 170, 48, '2014-10-28 20:49:29', '2014-10-28 20:49:29'),
(463, 'Bijoynagar', '09', 170, 48, '2014-10-28 20:49:57', '2014-10-28 20:49:57'),
(464, 'Chandpur sadar', '10', 170, 49, '2014-10-28 20:51:04', '2014-10-28 20:51:04'),
(465, 'Faridganj', '11', 170, 49, '2014-10-28 20:51:33', '2014-10-28 20:51:33'),
(466, 'Haimchar', '12', 170, 49, '2014-10-28 20:52:07', '2014-10-28 20:52:07'),
(467, 'Haziganj', '13', 170, 49, '2014-10-28 20:52:44', '2014-10-28 20:52:44'),
(468, 'Kachua', '14', 170, 49, '2014-10-28 20:53:10', '2014-10-28 20:53:10'),
(469, 'Matlab Dakshin', '15', 170, 49, '2014-10-28 20:53:50', '2014-10-28 20:53:50'),
(470, 'Matlab Uttar', '16', 170, 49, '2014-10-28 20:54:25', '2014-10-28 20:54:25'),
(471, 'Shahrasti', '17', 170, 49, '2014-10-28 20:54:56', '2014-10-28 20:54:56'),
(472, 'Barura', '18', 170, 47, '2014-10-28 20:55:55', '2014-10-28 20:55:55'),
(473, 'Brahmanpara', '19', 170, 47, '2014-10-28 20:56:20', '2014-10-28 20:56:20'),
(474, 'Burichang', '20', 170, 47, '2014-10-28 20:56:52', '2014-10-28 20:56:52'),
(475, 'Chandina', '21', 170, 47, '2014-10-28 20:57:17', '2014-10-28 20:57:17'),
(476, 'Chauddagram', '22', 170, 47, '2014-10-28 20:57:40', '2014-10-28 20:57:40'),
(477, 'Daudkandi', '23', 170, 47, '2014-10-28 20:58:15', '2014-10-28 20:58:15'),
(478, 'Debidwar', '24', 170, 47, '2014-10-28 20:58:39', '2014-10-28 20:58:39'),
(479, 'Homna', '25', 170, 47, '2014-10-28 20:59:04', '2014-10-28 20:59:04'),
(480, 'Laksam', '26', 170, 47, '2014-10-28 20:59:31', '2014-10-28 20:59:31'),
(481, 'Muradnagar', '27', 170, 47, '2014-10-28 20:59:56', '2014-10-28 20:59:56'),
(482, 'Nangalkot', '28', 170, 47, '2014-10-28 21:00:20', '2014-10-28 21:00:20'),
(483, 'Comilla Sadar', '29', 170, 47, '2014-10-28 21:00:51', '2014-10-28 21:00:51'),
(484, 'Meghna', '30', 170, 47, '2014-10-28 21:01:17', '2014-10-28 21:01:17'),
(485, 'Titas', '31', 170, 47, '2014-10-28 21:01:48', '2014-10-28 21:01:48'),
(486, 'Monohargonj', '32', 170, 47, '2014-10-28 21:02:11', '2014-10-28 21:02:11'),
(487, 'Sadar South Upazila', '33', 170, 47, '2014-10-28 21:03:08', '2014-10-28 21:03:08'),
(488, 'Lakshmipur Sadar', '34', 170, 46, '2014-10-28 21:03:38', '2014-10-28 21:03:38'),
(489, 'Raipur', '35', 170, 46, '2014-10-28 21:04:02', '2014-10-28 21:04:02'),
(490, 'Ramganj', '36', 170, 46, '2014-10-28 21:04:25', '2014-10-28 21:04:25'),
(491, 'Ramgati', '37', 170, 46, '2014-10-28 21:04:49', '2014-10-28 21:04:49'),
(492, 'Komolnagar', '38', 170, 46, '2014-10-28 21:05:15', '2014-10-28 21:05:15'),
(493, 'Begumganj', '39', 170, 45, '2014-10-28 21:05:53', '2014-10-28 21:05:53'),
(494, 'Noakhali	Sadar', '40', 170, 45, '2014-10-28 21:06:35', '2014-10-28 21:06:35'),
(495, 'Chatkhil', '41', 170, 45, '2014-10-28 21:07:10', '2014-10-28 21:07:10'),
(496, 'Companiganj', '42', 170, 45, '2014-10-28 21:07:43', '2014-10-28 21:07:43'),
(497, 'Hatiya', '43', 170, 45, '2014-10-28 21:08:13', '2014-10-28 21:08:13'),
(498, 'Senbagh', '44', 170, 45, '2014-10-28 21:08:47', '2014-10-28 21:08:47'),
(499, 'Sonaimuri', '45', 170, 45, '2014-10-28 21:09:17', '2014-10-28 21:09:17'),
(500, 'Subarnachar', '46', 170, 45, '2014-10-28 21:09:43', '2014-10-28 21:09:43'),
(501, 'Kabirhat', '47', 170, 45, '2014-10-28 21:10:11', '2014-10-28 21:10:11'),
(502, 'Baliakandi', '18', 600, 22, '2014-10-28 21:11:05', '2014-10-28 21:11:05'),
(503, 'Goalandaghat', '19', 170, 22, '2014-10-28 21:11:31', '2014-10-28 21:11:31'),
(504, 'Pangsha', '20', 170, 22, '2014-10-28 21:11:58', '2014-10-28 21:11:58'),
(505, 'Rajbari Sadar', '21', 600, 22, '2014-10-28 21:12:47', '2014-10-28 21:12:47'),
(506, 'Kalukhali', '22', 170, 22, '2014-10-28 21:13:12', '2014-10-28 21:13:12'),
(507, 'Bhedarganj', '23', 600, 20, '2014-10-28 21:13:47', '2014-10-28 21:13:47'),
(508, 'Damudya', '24', 600, 20, '2014-10-28 21:14:20', '2014-10-28 21:14:20'),
(509, 'Gosairhat', '25', 170, 20, '2014-10-28 21:14:45', '2014-10-28 21:14:45'),
(510, 'Naria', '26', 170, 20, '2014-10-28 21:15:20', '2014-10-28 21:15:20'),
(511, 'Shariatpur Sadar', '27', 600, 20, '2014-10-28 21:16:01', '2014-10-28 21:16:01'),
(512, 'Zanjira', '28', 170, 20, '2014-10-28 21:16:31', '2014-10-28 21:16:31'),
(513, 'Shakhipur', '29', 600, 20, '2014-10-28 21:17:07', '2014-10-28 21:17:07');

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
(1, 'Admin', 'info@bdeducations.org', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', 'w84j5AovyTwlXfu6XwiYLxQyZgOA7WrZRuPeZFlgKtApcSyZIZxT3Ob46ZyT', '2017-02-13 03:31:59', '2017-02-13 03:31:59'),
(2, 'Md.Sakoat Hossen', 'sakoatcse@gmail.com', '$2y$10$YEM6BvfpKfZdYT/kQ2djPujxzCePLGNrDTyBK/CCV7t13dP7DRSI.', 'B3EDGGfk09HznFNr8501VLullYWyywaIOocYpd2ePoeiC8oKYoVyBttwdfUT', '2017-02-14 00:05:08', '2017-02-14 00:05:08'),
(3, 'Ebadur Rahman', 'ebadur.info@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', 'Kcpi3Hw3MJ5e2gSc6CZLQAxfjrytI1UKKULvVtgRqdqtiRs3XjDm15IZ2qmT', '2017-03-05 01:14:55', '2017-03-05 01:14:55'),
(4, 'Shahedul Islam', 'modhumoti75@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', 'HPEy2pTJ1RM9I7506dIq6r37inh9oFmnEHVgdI1mhZDRl6SDz778Fbf2u38U', '2017-03-05 01:14:55', '2017-03-05 01:14:55'),
(5, 'Suman Ahmmed', 'sumanahmmed@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', '3nqkt2WBSPNNF4ucsJ27Qjj0k4N0rsmV48g0ZMMcLz3IeAKSLNvf8nOtigdQ', '2017-03-05 01:14:55', '2017-03-05 01:14:55'),
(6, 'Sharmin Yusuf', 'sharminyusuf1971@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', '3nqkt2WBSPNNF4ucsJ27Qjj0k4N0rsmV48g0ZMMcLz3IeAKSLNvf8nOtigdQ', '2017-03-05 01:14:55', '2017-03-05 01:14:55'),
(7, 'Masud Zaman', 'enggmasud1983@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', 'HPEy2pTJ1RM9I7506dIq6r37inh9oFmnEHVgdI1mhZDRl6SDz778Fbf2u38U', '2017-03-05 01:14:55', '2017-03-05 01:14:55'),
(9, 'Jashodhan Saha', 'jashodhan@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', '3nqkt2WBSPNNF4ucsJ27Qjj0k4N0rsmV48g0ZMMcLz3IeAKSLNvf8nOtigdQ', '2017-03-05 01:14:55', '2017-03-05 01:14:55'),
(10, 'Santanu Das', 'santanu@gmail.com', '$2y$10$suoJtg/1Mo0JzPFSyzFfAub2aJHqLW0bvutU9iVV/L4CP8RIE/LG2', 'HPEy2pTJ1RM9I7506dIq6r37inh9oFmnEHVgdI1mhZDRl6SDz778Fbf2u38U', '2017-03-05 01:14:55', '2017-03-05 01:14:55');

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
-- Indexes for table `ut_districts`
--
ALTER TABLE `ut_districts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `ut_hr_academic_calendars`
--
ALTER TABLE `ut_hr_academic_calendars`
  ADD PRIMARY KEY (`event_row_id`);

--
-- Indexes for table `ut_hr_departments`
--
ALTER TABLE `ut_hr_departments`
  ADD PRIMARY KEY (`department_row_id`);

--
-- Indexes for table `ut_hr_designations`
--
ALTER TABLE `ut_hr_designations`
  ADD PRIMARY KEY (`designation_row_id`);

--
-- Indexes for table `ut_hr_districts`
--
ALTER TABLE `ut_hr_districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ut_hr_employees`
--
ALTER TABLE `ut_hr_employees`
  ADD PRIMARY KEY (`employee_row_id`);

--
-- Indexes for table `ut_hr_employee_details`
--
ALTER TABLE `ut_hr_employee_details`
  ADD PRIMARY KEY (`employee_details_row_id`);

--
-- Indexes for table `ut_hr_employee_histories`
--
ALTER TABLE `ut_hr_employee_histories`
  ADD PRIMARY KEY (`employee_history_row_id`);

--
-- Indexes for table `ut_hr_employee_leave_records`
--
ALTER TABLE `ut_hr_employee_leave_records`
  ADD PRIMARY KEY (`leave_record_row_id`);

--
-- Indexes for table `ut_hr_grad_exam_names`
--
ALTER TABLE `ut_hr_grad_exam_names`
  ADD PRIMARY KEY (`grad_exam_row_id`);

--
-- Indexes for table `ut_hr_grad_postgrad_subject_names`
--
ALTER TABLE `ut_hr_grad_postgrad_subject_names`
  ADD PRIMARY KEY (`grad_postgrad_subject_name_row_id`);

--
-- Indexes for table `ut_hr_institutions`
--
ALTER TABLE `ut_hr_institutions`
  ADD PRIMARY KEY (`institution_row_id`);

--
-- Indexes for table `ut_hr_post_grad_exam_names`
--
ALTER TABLE `ut_hr_post_grad_exam_names`
  ADD PRIMARY KEY (`post_grad_exam_row_id`);

--
-- Indexes for table `ut_hr_salary_heads`
--
ALTER TABLE `ut_hr_salary_heads`
  ADD PRIMARY KEY (`salary_head_row_id`);

--
-- Indexes for table `ut_hr_salary_head_pay_amounts`
--
ALTER TABLE `ut_hr_salary_head_pay_amounts`
  ADD PRIMARY KEY (`head_pay_amount_row_id`);

--
-- Indexes for table `ut_hr_sub_areas`
--
ALTER TABLE `ut_hr_sub_areas`
  ADD PRIMARY KEY (`sub_area_row_id`);

--
-- Indexes for table `ut_project_heads`
--
ALTER TABLE `ut_project_heads`
  ADD PRIMARY KEY (`project_head_row_id`);

--
-- Indexes for table `ut_upazila`
--
ALTER TABLE `ut_upazila`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6E1F1E0B08FA272` (`district_id`);

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
-- AUTO_INCREMENT for table `ut_districts`
--
ALTER TABLE `ut_districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
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
-- AUTO_INCREMENT for table `ut_hr_academic_calendars`
--
ALTER TABLE `ut_hr_academic_calendars`
  MODIFY `event_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `ut_hr_departments`
--
ALTER TABLE `ut_hr_departments`
  MODIFY `department_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `ut_hr_designations`
--
ALTER TABLE `ut_hr_designations`
  MODIFY `designation_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT for table `ut_hr_districts`
--
ALTER TABLE `ut_hr_districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `ut_hr_employees`
--
ALTER TABLE `ut_hr_employees`
  MODIFY `employee_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `ut_hr_employee_details`
--
ALTER TABLE `ut_hr_employee_details`
  MODIFY `employee_details_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `ut_hr_employee_histories`
--
ALTER TABLE `ut_hr_employee_histories`
  MODIFY `employee_history_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `ut_hr_employee_leave_records`
--
ALTER TABLE `ut_hr_employee_leave_records`
  MODIFY `leave_record_row_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ut_hr_grad_exam_names`
--
ALTER TABLE `ut_hr_grad_exam_names`
  MODIFY `grad_exam_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `ut_hr_grad_postgrad_subject_names`
--
ALTER TABLE `ut_hr_grad_postgrad_subject_names`
  MODIFY `grad_postgrad_subject_name_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
--
-- AUTO_INCREMENT for table `ut_hr_institutions`
--
ALTER TABLE `ut_hr_institutions`
  MODIFY `institution_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `ut_hr_post_grad_exam_names`
--
ALTER TABLE `ut_hr_post_grad_exam_names`
  MODIFY `post_grad_exam_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `ut_hr_salary_heads`
--
ALTER TABLE `ut_hr_salary_heads`
  MODIFY `salary_head_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ut_hr_salary_head_pay_amounts`
--
ALTER TABLE `ut_hr_salary_head_pay_amounts`
  MODIFY `head_pay_amount_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ut_hr_sub_areas`
--
ALTER TABLE `ut_hr_sub_areas`
  MODIFY `sub_area_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ut_project_heads`
--
ALTER TABLE `ut_project_heads`
  MODIFY `project_head_row_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ut_upazila`
--
ALTER TABLE `ut_upazila`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=514;
--
-- AUTO_INCREMENT for table `ut_users`
--
ALTER TABLE `ut_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
