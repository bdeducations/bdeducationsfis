-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2017 at 05:04 AM
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
(69, 'Software engineer', 14, 6, 1, 1, '2017-11-06 14:34:26', 1, '2017-11-06 14:34:26'),
(70, 'Lead Software Engineer', 14, 4, 1, 1, '2017-11-06 15:34:22', 1, '2017-11-06 15:34:22'),
(71, 'Sr. Software Engineer', 14, 5, 1, 1, '2017-11-06 15:34:48', 1, '2017-11-06 15:34:48'),
(72, 'Composer & Graphics Designer', 14, 15, 1, 1, '2017-11-06 15:36:05', 1, '2017-11-06 15:36:05'),
(73, 'IT Executive', 14, 16, 1, 1, '2017-11-06 15:37:10', 1, '2017-11-06 15:37:10'),
(74, 'Office Executive', 14, 17, 1, 1, '2017-11-06 15:37:22', 1, '2017-11-06 15:37:22'),
(75, 'Front End Developer', 14, 12, 1, 1, '2017-11-06 15:38:02', 1, '2017-11-06 15:38:02'),
(76, 'Research Associate', 14, 10, 1, 1, '2017-11-06 15:38:16', 1, '2017-11-06 15:38:16'),
(77, 'Software Engineer & Research Associate', 14, 7, 1, 1, '2017-11-06 15:38:38', 1, '2017-11-06 15:38:38'),
(78, 'Graphic Designer', 14, 11, 1, 1, '2017-11-06 15:38:53', 1, '2017-11-06 15:38:53'),
(79, 'Software Engineer & Multimedia Analyst', 14, 9, 1, 1, '2017-11-06 15:39:23', 1, '2017-11-06 15:39:23'),
(80, 'Jr. Software Engineer', 14, 8, 1, 1, '2017-11-06 15:39:42', 1, '2017-11-06 15:39:42'),
(81, 'Liaison Officer & Front End Developer', 14, 14, 1, 1, '2017-11-06 15:40:02', 1, '2017-11-06 15:40:02'),
(82, 'Head of IT, Asiya Bari Ideal School', 14, 13, 1, 1, '2017-11-06 15:40:32', 1, '2017-11-06 15:40:32'),
(83, 'Coordinator - English & Communications', 15, 19, 1, 1, '2017-11-06 15:42:55', 1, '2017-11-06 15:42:55'),
(84, 'Faculty- Physics', 15, 23, 1, 1, '2017-11-06 15:43:17', 1, '2017-11-06 15:43:17'),
(85, 'Faculty-ICT', 15, 22, 1, 1, '2017-11-06 15:43:30', 1, '2017-11-06 15:43:30'),
(86, 'Jr. Faculty- Chemistry', 15, 31, 1, 1, '2017-11-06 15:43:54', 1, '2017-11-06 15:43:54'),
(87, 'Jr. Faculty-Biology', 15, 30, 1, 1, '2017-11-06 15:44:26', 1, '2017-11-06 15:44:26'),
(88, 'Faculty- Science (Primary)', 15, 28, 1, 1, '2017-11-06 15:44:41', 1, '2017-11-06 15:44:41'),
(89, 'Faculty- English', 15, 24, 1, 1, '2017-11-06 15:44:53', 1, '2017-11-06 15:44:53'),
(90, 'Faculty- BGS', 15, 25, 1, 1, '2017-11-06 15:45:07', 1, '2017-11-06 15:45:07'),
(91, 'Faculty- Mathematics', 15, 26, 1, 1, '2017-11-06 15:45:23', 1, '2017-11-06 15:45:23'),
(92, 'Faculty- Biology', 15, 27, 1, 1, '2017-11-06 15:45:48', 1, '2017-11-06 15:45:48'),
(93, 'Faculty- English & Communication', 15, 21, 1, 1, '2017-11-06 15:46:38', 1, '2017-11-06 15:46:38'),
(94, 'Faculty (Part time)', 15, 35, 1, 1, '2017-11-06 15:47:38', 1, '2017-11-06 15:47:38'),
(95, 'Jr. Officer, Admin', 15, 33, 1, 1, '2017-11-06 15:47:50', 1, '2017-11-06 15:47:50'),
(96, 'Adviser, International Affairs', 15, 20, 1, 1, '2017-11-06 15:48:00', 1, '2017-11-06 15:48:00'),
(97, 'Executive, Admin & Academic', 14, 18, 1, 1, '2017-11-06 17:12:33', 1, '2017-11-06 17:12:33'),
(98, 'Faculty', 15, 29, 1, 1, '2017-11-06 17:23:54', 1, '2017-11-06 17:23:54'),
(99, 'Receptionist', 16, 34, 1, 1, '2017-11-07 09:13:57', 1, '2017-11-07 09:13:57'),
(100, 'Peon', 16, 36, 1, 1, '2017-11-07 09:14:55', 1, '2017-11-07 09:14:55'),
(101, 'Jr. Officer, Admin', 16, 32, 1, 1, '2017-11-07 09:15:26', 1, '2017-11-07 09:15:26'),
(102, 'Chairman', 17, 1, 1, 1, '2017-11-07 09:45:15', NULL, '2017-11-07 09:45:15'),
(103, 'Managing director', 17, 2, 1, 1, '2017-11-07 09:45:28', NULL, '2017-11-07 09:45:28'),
(104, 'Director', 17, 3, 1, 1, '2017-11-07 09:45:39', NULL, '2017-11-07 09:45:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ut_hr_designations`
--
ALTER TABLE `ut_hr_designations`
  ADD PRIMARY KEY (`designation_row_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ut_hr_designations`
--
ALTER TABLE `ut_hr_designations`
  MODIFY `designation_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
