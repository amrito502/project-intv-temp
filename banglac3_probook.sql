-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 27, 2024 at 05:44 PM
-- Server version: 10.6.8-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banglac3_probook`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `branch_name` text NOT NULL,
  `contact_person_name` text NOT NULL,
  `contact_person_phone` text NOT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `company_id`, `branch_name`, `contact_person_name`, `contact_person_phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, 'Head Office', 'Head Office', '00000', 'Head Office', '2024-01-20 15:33:26', '2022-07-11 17:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `budget_heads`
--

CREATE TABLE `budget_heads` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type` text NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `budget_heads`
--

INSERT INTO `budget_heads` (`id`, `company_id`, `type`, `name`, `created_at`, `updated_at`) VALUES
(3, 0, 'Material', 'Cement', '2022-03-05 18:47:58', '2022-03-05 18:47:58'),
(4, 0, 'Material', 'Sand', '2022-03-05 18:48:08', '2022-03-05 18:48:08'),
(5, 0, 'Material', 'Stone', '2022-03-05 18:48:13', '2022-03-05 18:48:13'),
(6, 0, 'Cash', 'Rig Labor', '2022-03-05 18:48:25', '2022-03-05 18:48:25'),
(63, 1, 'Cash', 'Labor', '2022-07-18 08:46:01', '2022-07-18 08:46:01'),
(64, 1, 'Material', 'Vitti Sand', '2022-07-18 08:46:50', '2022-07-18 08:46:50'),
(65, 1, 'Cash', 'Civil Accessories', '2022-07-18 08:47:41', '2022-07-18 08:47:41'),
(66, 1, 'Material', 'Rebar 5\"', '2022-07-18 08:54:19', '2022-07-18 08:54:19'),
(67, 1, 'Material', 'Rebar 10\"', '2022-07-18 08:54:42', '2022-07-18 08:54:42'),
(68, 1, 'Material', 'Rebar 16\"', '2022-07-18 08:55:03', '2022-07-18 08:55:03'),
(69, 1, 'Material', 'Rebar 20\"', '2022-07-18 08:55:36', '2022-07-18 08:55:36'),
(70, 1, 'Material', 'Rebar 25\"', '2022-07-18 08:55:58', '2022-07-18 08:55:58'),
(71, 1, 'Cash', 'Road Preparation', '2022-07-18 08:57:39', '2022-07-18 08:57:39'),
(72, 1, 'Cash', 'Head carrying', '2022-07-18 08:57:44', '2022-07-18 08:57:44'),
(73, 1, 'Cash', 'House Cutting', '2022-07-18 08:57:58', '2022-07-18 08:57:58'),
(74, 1, 'Cash', 'Others cost', '2022-07-18 08:58:05', '2022-07-18 08:58:05'),
(75, 1, 'Cash', 'Water Arrangements', '2022-07-18 08:58:22', '2022-07-18 08:58:22'),
(76, 1, 'Cash', 'Tractor Stone', '2022-07-18 09:45:10', '2022-07-18 09:45:10'),
(77, 1, 'Cash', 'Tractor Sand', '2022-07-18 09:45:16', '2022-07-18 09:45:16'),
(78, 1, 'Cash', 'Tractor Cement', '2022-07-18 09:45:21', '2022-07-18 09:45:21'),
(79, 1, 'Cash', 'Tractor Rebar', '2022-07-18 09:45:24', '2022-07-18 09:45:24'),
(80, 1, 'Cash', 'Head Carrying Stone', '2022-07-18 09:47:34', '2022-07-18 09:47:34'),
(81, 1, 'Cash', 'Head Carrying Sand', '2022-07-18 09:47:42', '2022-07-18 09:47:42'),
(82, 1, 'Material', 'Rebar 8\"', '2022-07-21 09:26:48', '2022-07-21 09:26:48'),
(83, 1, 'Material', 'Rebar 12\"', '2022-07-25 07:51:13', '2022-07-25 07:51:13'),
(84, 1, 'Cash', 'Rig machine', '2022-07-25 08:04:59', '2022-07-25 08:04:59'),
(85, 1, 'Cash', 'Rig Mazaher', '2022-10-14 15:31:19', '2022-10-14 15:31:19'),
(86, 1, 'Cash', 'Rig Sohel', '2022-10-14 15:31:39', '2022-10-14 15:31:39'),
(91, 1, 'Material', 'test', '2022-11-17 17:43:47', '2022-11-17 17:43:47'),
(92, 1, 'Material', 'Cicvil Access', '2022-11-17 17:46:18', '2022-11-17 17:46:18'),
(93, 1, 'Material', 'Casting water', '2022-11-17 17:47:05', '2022-11-17 17:47:05'),
(94, 1, 'Cash', 'PGCB Enter', '2022-11-17 17:50:22', '2022-11-17 17:50:22'),
(95, 1, 'Cash', 'Night Guard', '2022-11-17 17:51:12', '2022-11-17 17:51:12'),
(96, 1, 'Cash', 'Tractor carrying _Rig machine', '2022-11-17 17:54:47', '2022-11-17 17:54:47'),
(97, 1, 'Cash', 'Others Cost', '2022-11-17 17:55:21', '2022-11-17 17:55:21'),
(98, 1, 'Cash', 'PGCB Saving_Site', '2022-11-18 03:57:27', '2022-11-18 03:57:27'),
(99, 1, 'Cash', 'PGCB saving_XEN', '2022-11-18 03:58:17', '2022-11-18 03:58:17'),
(100, 1, 'Material', 'Cement_Saving', '2022-11-18 04:17:57', '2022-11-18 04:17:57'),
(101, 1, 'Cash', 'Cube Test', '2022-11-18 04:18:33', '2022-11-18 04:18:33'),
(106, 1, 'Cash', 'asd', '2022-11-22 06:36:18', '2022-11-22 06:36:18'),
(107, 1, 'Material', 'QWE', '2022-11-22 06:37:58', '2022-11-22 06:37:58'),
(108, 1, 'Cash', 'zxc', '2022-11-22 06:39:34', '2022-11-22 06:39:34'),
(109, 1, 'Cash', '123', '2022-11-22 06:41:05', '2022-11-22 06:41:05'),
(110, 1, 'Material', 'zxc', '2022-11-22 06:41:37', '2022-11-22 06:41:37'),
(111, 1, 'Material', 'asd', '2022-11-22 06:43:08', '2022-11-22 06:43:08'),
(112, 1, 'Material', 'rty', '2022-11-22 06:44:39', '2022-11-22 06:44:39'),
(113, 1, 'Material', 'rty', '2022-11-22 06:45:23', '2022-11-22 06:45:23'),
(114, 1, 'Material', 'cvb', '2022-11-22 06:45:32', '2022-11-22 06:45:32'),
(115, 1, 'Material', 'fgh', '2022-11-22 06:46:04', '2022-11-22 06:46:04'),
(116, 1, 'Material', 'fgh', '2022-11-22 06:48:54', '2022-11-22 06:48:54'),
(117, 1, 'Material', 'fgh', '2022-11-22 06:50:13', '2022-11-22 06:50:13'),
(118, 1, 'Material', '789', '2022-11-22 06:52:00', '2022-11-22 06:52:00'),
(119, 1, 'Material', 'plutonium', '2022-11-22 06:52:52', '2022-11-22 06:52:52'),
(120, 1, 'Cash', 'abc', '2022-11-22 06:53:22', '2022-11-22 06:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `cash_payments`
--

CREATE TABLE `cash_payments` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `date` text NOT NULL,
  `serial` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `cash_payment_items`
--

CREATE TABLE `cash_payment_items` (
  `id` int(11) NOT NULL,
  `cash_payment_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `tower_id` int(11) DEFAULT NULL,
  `budget_head_id` int(11) NOT NULL,
  `paymentAmount` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `cash_requisitions`
--

CREATE TABLE `cash_requisitions` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `unit_config_id` int(11) DEFAULT NULL,
  `tower_id` int(11) DEFAULT NULL,
  `date` text NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `cash_requisitions`
--

INSERT INTO `cash_requisitions` (`id`, `company_id`, `project_id`, `unit_config_id`, `tower_id`, `date`, `remarks`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(17, 1, 1, 8, 2, '2024-01-21', 'wsws', 'Pending', 1, '2024-01-21 07:54:56', '2024-01-21 07:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `cash_requisition_communications`
--

CREATE TABLE `cash_requisition_communications` (
  `id` int(11) NOT NULL,
  `cash_requisition_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `cash_requisition_items`
--

CREATE TABLE `cash_requisition_items` (
  `id` int(11) NOT NULL,
  `cash_requisition_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `budget_head_id` int(11) NOT NULL,
  `requisition_amount` text NOT NULL,
  `approved_amount` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `approved_amount_log` text DEFAULT NULL,
  `issued_amount_log` text DEFAULT NULL,
  `approved_due_log` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `cash_requisition_items`
--

INSERT INTO `cash_requisition_items` (`id`, `cash_requisition_id`, `vendor_id`, `budget_head_id`, `requisition_amount`, `approved_amount`, `remarks`, `approved_amount_log`, `issued_amount_log`, `approved_due_log`, `created_at`, `updated_at`) VALUES
(36, 16, 14, 6, '630000', '630000', NULL, '0', '0', '0', '2022-11-24 20:42:59', '2022-11-24 20:43:18'),
(37, 16, 14, 90, '3000', '3000', NULL, '0', '0', '0', '2022-11-24 20:42:59', '2022-11-24 20:43:18'),
(38, 16, 14, 104, '20000', '20000', NULL, '0', '0', '0', '2022-11-24 20:42:59', '2022-11-24 20:43:18'),
(39, 16, 14, 123, '60000', '60000', NULL, '0', '0', '0', '2022-11-24 20:42:59', '2022-11-24 20:43:18'),
(40, 17, 5, 6, '2000', NULL, 'sss', '0', '0', '0', '2024-01-21 07:54:56', '2024-01-21 07:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `cash_vendor_payments`
--

CREATE TABLE `cash_vendor_payments` (
  `id` int(11) NOT NULL,
  `requisition_item_id` int(11) NOT NULL,
  `amount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_vendor_payments`
--

INSERT INTO `cash_vendor_payments` (`id`, `requisition_item_id`, `amount`, `created_by`, `created_at`, `updated_at`) VALUES
(26, 23, '6000', 2, '2022-11-13 10:52:34', '2022-11-13 10:52:34'),
(27, 26, '1000', 2, '2022-11-13 10:52:34', '2022-11-13 10:52:34'),
(28, 28, '2000', 2, '2022-11-13 10:52:34', '2022-11-13 10:52:34'),
(29, 15, '10000', 2, '2022-11-15 07:38:58', '2022-11-15 07:38:58'),
(30, 16, '3000', 2, '2022-11-15 07:38:58', '2022-11-15 07:38:58'),
(31, 17, '6000', 2, '2022-11-15 07:38:58', '2022-11-15 07:38:58'),
(32, 18, '6000', 2, '2022-11-15 07:38:58', '2022-11-15 07:38:58'),
(33, 19, '5000', 2, '2022-11-15 07:38:58', '2022-11-15 07:38:58'),
(34, 20, '6000', 2, '2022-11-15 07:38:58', '2022-11-15 07:38:58'),
(35, 29, '6000', 2, '2022-11-15 07:45:07', '2022-11-15 07:45:07'),
(36, 30, '5000', 2, '2022-11-15 07:45:07', '2022-11-15 07:45:07'),
(37, 29, '2000', 2, '2022-11-15 08:09:24', '2022-11-15 08:09:24'),
(38, 30, '5000', 2, '2022-11-15 08:09:24', '2022-11-15 08:09:24'),
(39, 31, '5000', 2, '2022-11-15 08:18:14', '2022-11-15 08:18:14'),
(40, 32, '4000', 2, '2022-11-15 08:18:14', '2022-11-15 08:18:14'),
(41, 33, '2500', 2, '2022-11-15 08:18:14', '2022-11-15 08:18:14'),
(42, 34, '7000', 2, '2022-11-15 08:18:14', '2022-11-15 08:18:14'),
(43, 35, '4000', 2, '2022-11-15 08:18:14', '2022-11-15 08:18:14'),
(44, 36, '630000', 5, '2022-11-24 20:43:43', '2022-11-24 20:43:43'),
(45, 37, '3000', 5, '2022-11-24 20:43:43', '2022-11-24 20:43:43'),
(46, 38, '20000', 5, '2022-11-24 20:43:43', '2022-11-24 20:43:43'),
(47, 39, '60000', 5, '2022-11-24 20:43:43', '2022-11-24 20:43:43');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `prefix` text NOT NULL,
  `contact_person_name` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `email` text DEFAULT NULL,
  `website` text DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `prefix`, `contact_person_name`, `phone`, `address`, `email`, `website`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Contain i', 'CI', 'Mr.Tanvir', '01713-031691', 'Dhaka, Bangladesh', NULL, NULL, '', '2024-01-21 06:18:11', '2022-07-11 17:56:07');

-- --------------------------------------------------------

--
-- Table structure for table `daily_consumptions`
--

CREATE TABLE `daily_consumptions` (
  `id` int(11) NOT NULL,
  `system_serial` text NOT NULL,
  `project_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `tower_id` int(11) DEFAULT NULL,
  `logistics_associate_id` int(11) DEFAULT NULL,
  `truck_no` text DEFAULT NULL,
  `issue_by_name` text DEFAULT NULL,
  `date` text NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `received_by` int(11) DEFAULT NULL,
  `receive_by_name` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `daily_consumptions`
--

INSERT INTO `daily_consumptions` (`id`, `system_serial`, `project_id`, `unit_id`, `tower_id`, `logistics_associate_id`, `truck_no`, `issue_by_name`, `date`, `company_id`, `created_by`, `status`, `received_by`, `receive_by_name`, `created_at`, `updated_at`) VALUES
(35, 'CI/lis/1', 1, 8, 2, 7, '111', '221', '2024-01-22', 1, 1, 1, 1, 'aaaaa', '2024-01-21 07:51:48', '2024-01-21 07:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `daily_consumption_items`
--

CREATE TABLE `daily_consumption_items` (
  `id` int(11) NOT NULL,
  `daily_consumption_id` int(11) NOT NULL,
  `budget_head_id` int(11) NOT NULL,
  `consumption_qty` text NOT NULL,
  `issue_qty` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `daily_consumption_items`
--

INSERT INTO `daily_consumption_items` (`id`, `daily_consumption_id`, `budget_head_id`, `consumption_qty`, `issue_qty`, `created_at`, `updated_at`) VALUES
(93, 35, 3, '10', '10', '2024-01-21 07:51:48', '2024-01-21 07:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `daily_expenses`
--

CREATE TABLE `daily_expenses` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `unit_config_id` int(11) DEFAULT NULL,
  `tower_id` int(11) DEFAULT NULL,
  `date` text NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `daily_expense_items`
--

CREATE TABLE `daily_expense_items` (
  `id` int(11) NOT NULL,
  `daily_expense_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `budget_head_id` int(11) NOT NULL,
  `amount` text NOT NULL,
  `remarks` text DEFAULT NULL,
  `approved_amount_log` text DEFAULT NULL,
  `issued_amount_log` text DEFAULT NULL,
  `approved_due_log` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `daily_uses`
--

CREATE TABLE `daily_uses` (
  `id` int(11) NOT NULL,
  `system_serial` text NOT NULL,
  `project_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `tower_id` int(11) DEFAULT NULL,
  `logistics_associate_id` int(11) DEFAULT NULL,
  `truck_no` text DEFAULT NULL,
  `pile_no` text DEFAULT NULL,
  `working_length` text DEFAULT NULL,
  `site_engineer` text DEFAULT NULL,
  `epc_engineer` text DEFAULT NULL,
  `department_engineer` text DEFAULT NULL,
  `date` text NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `daily_uses`
--

INSERT INTO `daily_uses` (`id`, `system_serial`, `project_id`, `unit_id`, `tower_id`, `logistics_associate_id`, `truck_no`, `pile_no`, `working_length`, `site_engineer`, `epc_engineer`, `department_engineer`, `date`, `company_id`, `created_by`, `created_at`, `updated_at`) VALUES
(20, 'CI/dc/1', 1, 8, 2, 7, '12', '1', '4', 'qq', 'qwsa', 'wsde', '2024-01-21', 1, 1, '2024-01-21 07:53:11', '2024-01-21 07:53:11');

-- --------------------------------------------------------

--
-- Table structure for table `daily_use_items`
--

CREATE TABLE `daily_use_items` (
  `id` int(11) NOT NULL,
  `daily_use_id` int(11) NOT NULL,
  `budget_head_id` int(11) NOT NULL,
  `use_qty` text NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `daily_use_items`
--

INSERT INTO `daily_use_items` (`id`, `daily_use_id`, `budget_head_id`, `use_qty`, `remarks`, `created_at`, `updated_at`) VALUES
(82, 20, 3, '2', '223', '2024-01-21 07:53:11', '2024-01-21 07:53:11');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `company_id`, `title`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Neogoan - Bagmara 132Kv Line', 1, '2024-01-20 07:39:29', '2024-01-20 07:39:29');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_dates`
--

CREATE TABLE `gallery_dates` (
  `id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `date` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gallery_dates`
--

INSERT INTO `gallery_dates` (`id`, `gallery_id`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, '09-07-2022', '2022-07-30 05:34:23', '2022-07-30 05:34:23');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_date_images`
--

CREATE TABLE `gallery_date_images` (
  `id` int(11) NOT NULL,
  `gallery_date_id` int(11) NOT NULL,
  `information` text NOT NULL,
  `image` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `logistics_charges`
--

CREATE TABLE `logistics_charges` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `general_transportation_charge` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `logistics_charge_items`
--

CREATE TABLE `logistics_charge_items` (
  `id` int(11) NOT NULL,
  `logistics_charge_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `material_rate` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `code` text NOT NULL,
  `unit` int(11) DEFAULT NULL,
  `transportation_charge` int(11) NOT NULL DEFAULT 0,
  `show_dashboard` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `company_id`, `name`, `code`, `unit`, `transportation_charge`, `show_dashboard`, `created_at`, `updated_at`) VALUES
(2, 0, 'Cement', 'Cement', 8, 1, 1, '2022-05-24 04:09:40', '2022-03-05 16:33:53'),
(3, 0, 'Sand', 'Sand', 1, 1, 1, '2022-05-24 04:09:41', '2022-03-05 17:56:32'),
(5, 0, 'Stone', 'Stone', 1, 1, 1, '2022-05-24 04:09:46', '2022-03-05 17:57:23'),
(56, 1, 'Vitti Sand', 'vitti-sand Sylet', 1, 1, 0, '2022-11-06 13:03:43', '2022-11-06 13:03:43'),
(57, 1, 'Rebar 5\"', 'rebar5', 10, 1, 0, '2022-07-18 08:54:19', '2022-07-18 08:54:19'),
(58, 1, 'Rebar 10\"', 'rebar10', 10, 1, 0, '2022-07-18 08:54:42', '2022-07-18 08:54:42'),
(59, 1, 'Rebar 16\"', 'rebar16', 10, 1, 0, '2022-07-18 08:55:02', '2022-07-18 08:55:02'),
(60, 1, 'Rebar 20\"', 'rebar20', 10, 1, 0, '2022-07-18 08:55:36', '2022-07-18 08:55:36'),
(61, 1, 'Rebar 25\"', 'rebar25', 10, 1, 0, '2022-07-18 08:55:58', '2022-07-18 08:55:58'),
(62, 1, 'Rebar 8\"', 'rebar8', 10, 0, 0, '2022-07-21 09:26:48', '2022-07-21 09:26:48'),
(63, 1, 'Rebar 12\"', 'rebar-12', 10, 0, 0, '2022-07-25 07:51:13', '2022-07-25 07:51:13'),
(67, 1, 'test', 'test', 1, 1, 1, '2022-11-17 17:43:47', '2022-11-17 17:43:47'),
(68, 1, 'Cicvil Access', 'Access_01', 11, 0, 0, '2022-11-17 17:46:18', '2022-11-17 17:46:18'),
(69, 1, 'Casting water', 'water_1', 11, 0, 0, '2022-11-17 17:47:05', '2022-11-17 17:47:05'),
(70, 1, 'Cement_Saving', 'Cement_2', 8, 0, 0, '2022-11-18 04:17:57', '2022-11-18 04:17:57'),
(72, 1, 'QWE', 'qwe', 1, 0, 0, '2022-11-22 06:37:58', '2022-11-22 06:37:58'),
(73, 1, 'zxc', 'zxc', 2, 0, 0, '2022-11-22 06:41:37', '2022-11-22 06:41:37'),
(74, 1, 'asd', 'asd', 3, 0, 0, '2022-11-22 06:43:08', '2022-11-22 06:43:08'),
(75, 1, 'rty', 'rty', 3, 0, 0, '2022-11-22 06:44:39', '2022-11-22 06:44:39'),
(76, 1, 'rty', 'rty', 3, 0, 0, '2022-11-22 06:45:23', '2022-11-22 06:45:23'),
(77, 1, 'cvb', 'cvb', 3, 0, 0, '2022-11-22 06:45:32', '2022-11-22 06:45:32'),
(78, 1, 'fgh', 'fgh', 4, 0, 0, '2022-11-22 06:46:03', '2022-11-22 06:46:03'),
(79, 1, 'fgh', 'fgh', 4, 0, 0, '2022-11-22 06:48:54', '2022-11-22 06:48:54'),
(80, 1, 'fgh', 'fgh', 4, 0, 0, '2022-11-22 06:50:13', '2022-11-22 06:50:13'),
(81, 1, '789', '789', 1, 0, 0, '2022-11-22 06:52:00', '2022-11-22 06:52:00'),
(82, 1, 'plutonium', 'plutonium', 1, 0, 0, '2022-11-22 06:52:52', '2022-11-22 06:52:52'),
(83, 2, 'sdas', 'xzc', 2, 0, 0, '2022-11-22 14:22:44', '2022-11-22 14:22:44'),
(84, 2, 'special mat', 'sm', 8, 0, 0, '2022-11-24 06:41:03', '2022-11-24 06:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `materials_groups`
--

CREATE TABLE `materials_groups` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `materialgroup_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `material_groups`
--

CREATE TABLE `material_groups` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `material_issues`
--

CREATE TABLE `material_issues` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `system_serial` text NOT NULL,
  `source_project_id` int(11) NOT NULL,
  `source_unit_id` int(11) DEFAULT NULL,
  `source_tower_id` int(11) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `tower_id` int(11) DEFAULT NULL,
  `logistics_associate` int(11) DEFAULT NULL,
  `issue_date` text NOT NULL,
  `issue_to` text NOT NULL,
  `truck_no` text NOT NULL,
  `status` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `received_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `material_issues`
--

INSERT INTO `material_issues` (`id`, `company_id`, `system_serial`, `source_project_id`, `source_unit_id`, `source_tower_id`, `project_id`, `unit_id`, `tower_id`, `logistics_associate`, `issue_date`, `issue_to`, `truck_no`, `status`, `created_by`, `received_by`, `created_at`, `updated_at`) VALUES
(9, 1, 'CI/ts/1', 1, 8, 2, 1, 8, 1, 7, '2024-01-21', '2222', '111', 'Issued', 1, NULL, '2024-01-21 07:49:32', '2024-01-21 07:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `material_issue_items`
--

CREATE TABLE `material_issue_items` (
  `id` int(11) NOT NULL,
  `material_issue_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `material_qty` int(11) NOT NULL,
  `receive_qty` decimal(10,0) DEFAULT 0,
  `material_rate` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `material_issue_items`
--

INSERT INTO `material_issue_items` (`id`, `material_issue_id`, `material_id`, `material_qty`, `receive_qty`, `material_rate`, `created_at`, `updated_at`) VALUES
(25, 9, 2, 10, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `material_liftings`
--

CREATE TABLE `material_liftings` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `system_serial` text NOT NULL,
  `lifting_type` text NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `logistics_vendor` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `tower_id` int(11) DEFAULT NULL,
  `voucher` text NOT NULL,
  `truck_no` text DEFAULT NULL,
  `vouchar_date` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `material_liftings`
--

INSERT INTO `material_liftings` (`id`, `company_id`, `system_serial`, `lifting_type`, `vendor_id`, `logistics_vendor`, `project_id`, `unit_id`, `tower_id`, `voucher`, `truck_no`, `vouchar_date`, `created_at`, `updated_at`) VALUES
(127, 1, 'CI/li/1', 'Local Lifting To Project', 1, 13, 1, 8, 2, 'qqq', '1212', '2024-01-21', '2024-01-21 07:45:35', '2024-01-21 07:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `material_lifting_materials`
--

CREATE TABLE `material_lifting_materials` (
  `id` int(11) NOT NULL,
  `material_lifting_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `material_qty` text NOT NULL,
  `material_rate` double NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `material_lifting_materials`
--

INSERT INTO `material_lifting_materials` (`id`, `material_lifting_id`, `material_id`, `unit_id`, `material_qty`, `material_rate`, `remarks`, `created_at`, `updated_at`) VALUES
(184, 127, 2, 8, '100', 450, 'aaa', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `material_requisitions`
--

CREATE TABLE `material_requisitions` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `unit_config_id` int(11) DEFAULT NULL,
  `tower_id` int(11) DEFAULT NULL,
  `date` text NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `material_requisition_communications`
--

CREATE TABLE `material_requisition_communications` (
  `id` int(11) NOT NULL,
  `material_requisition_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `material_requisition_items`
--

CREATE TABLE `material_requisition_items` (
  `id` int(11) NOT NULL,
  `material_requisition_id` int(11) NOT NULL,
  `budget_head_id` int(11) NOT NULL,
  `requisition_amount` text NOT NULL,
  `approved_amount_one` text DEFAULT NULL,
  `approved_amount_two` text DEFAULT NULL,
  `estimated_amount` text DEFAULT NULL,
  `issued_amount` text DEFAULT NULL,
  `balance_amount` text DEFAULT NULL,
  `payment_status` int(11) NOT NULL DEFAULT 0,
  `paid_by` int(11) DEFAULT NULL,
  `payment_time` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `material_units`
--

CREATE TABLE `material_units` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `material_units`
--

INSERT INTO `material_units` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'CFT', NULL, NULL),
(2, 'Meter', NULL, NULL),
(3, 'MM', NULL, NULL),
(4, 'CM', NULL, NULL),
(5, 'm^3', NULL, NULL),
(6, 'TON', NULL, NULL),
(7, 'Feet', NULL, NULL),
(8, 'Bosta', NULL, NULL),
(9, 'Litre', NULL, NULL),
(10, 'KG', NULL, NULL),
(11, 'PCS', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `material_vendor_payments`
--

CREATE TABLE `material_vendor_payments` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `tower_id` int(11) NOT NULL,
  `payment_no` text NOT NULL,
  `payment_date` text NOT NULL,
  `payment_amount` text NOT NULL,
  `payment_type` text NOT NULL,
  `money_receipt` text NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `material_vendor_payment_invoices`
--

CREATE TABLE `material_vendor_payment_invoices` (
  `id` int(11) NOT NULL,
  `material_vendor_payment_id` int(11) NOT NULL,
  `lifting_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_12_22_145421_create_permission_tables', 1),
(5, '2021_01_14_182600_create_site_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 18),
(1, 'App\\Models\\User', 36),
(2, 'App\\Models\\User', 19),
(2, 'App\\Models\\User', 20),
(2, 'App\\Models\\User', 23),
(2, 'App\\Models\\User', 34),
(7, 'App\\Models\\User', 2),
(7, 'App\\Models\\User', 11),
(7, 'App\\Models\\User', 12),
(7, 'App\\Models\\User', 21),
(7, 'App\\Models\\User', 22),
(7, 'App\\Models\\User', 26),
(7, 'App\\Models\\User', 38),
(8, 'App\\Models\\User', 24),
(8, 'App\\Models\\User', 42),
(9, 'App\\Models\\User', 6),
(9, 'App\\Models\\User', 27),
(9, 'App\\Models\\User', 28),
(9, 'App\\Models\\User', 29),
(9, 'App\\Models\\User', 30),
(9, 'App\\Models\\User', 31),
(9, 'App\\Models\\User', 32),
(9, 'App\\Models\\User', 33),
(9, 'App\\Models\\User', 35),
(9, 'App\\Models\\User', 39),
(9, 'App\\Models\\User', 40),
(9, 'App\\Models\\User', 41),
(10, 'App\\Models\\User', 3),
(10, 'App\\Models\\User', 4),
(10, 'App\\Models\\User', 37);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `order_serial` int(10) UNSIGNED DEFAULT NULL,
  `action_menu` int(10) UNSIGNED DEFAULT NULL,
  `software_admin_only` int(11) NOT NULL DEFAULT 0,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_color` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `status`, `parent_id`, `order_serial`, `action_menu`, `software_admin_only`, `url`, `icon`, `icon_color`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, 0, 0, 'general.index', 'fa fa-cogs', '#ffffff', 'System Settings', 'web', '2021-11-13 04:37:13', '2022-01-22 05:06:35'),
(2, 1, 54, 9, 0, 0, 'user.index', 'fa fa-circle-o', '#ffffff', 'User Setup', 'web', '2021-11-13 04:37:13', '2022-01-22 05:44:17'),
(3, 1, 2, 1, 1, 0, 'user.create', NULL, NULL, 'create user', 'web', '2021-11-13 04:37:14', '2021-11-13 04:37:14'),
(4, 1, 2, 2, 1, 1, 'user.status', NULL, '#000000', 'status user', 'web', '2021-11-13 04:37:14', '2022-01-22 08:41:33'),
(6, 1, 2, 4, 1, 0, 'user.edit', NULL, NULL, 'edit user', 'web', '2021-11-13 04:37:14', '2021-11-13 04:37:14'),
(7, 1, 2, 5, 1, 0, 'user.delete', NULL, NULL, 'delete user', 'web', '2021-11-13 04:37:14', '2021-11-13 04:37:14'),
(8, 1, 2, 6, 1, 0, 'user.change_password', NULL, NULL, 'change_password user', 'web', '2021-11-13 04:37:14', '2021-11-13 04:37:14'),
(9, 1, 54, 10, 0, 0, 'role.index', 'fa fa-circle-o', '#ffffff', 'Role Setup', 'web', '2021-11-13 04:37:14', '2022-01-22 05:44:35'),
(10, 1, 9, 1, 1, 0, 'role.create', NULL, NULL, 'create role', 'web', '2021-11-13 04:37:14', '2021-11-13 04:37:14'),
(11, 1, 9, 2, 1, 0, 'role.edit', NULL, NULL, 'edit role', 'web', '2021-11-13 04:37:14', '2021-11-13 04:37:14'),
(12, 1, 9, 3, 1, 0, 'role.delete', NULL, NULL, 'delete role', 'web', '2021-11-13 04:37:14', '2021-11-13 04:37:14'),
(13, 1, 54, 11, 0, 1, 'module.index', 'fa fa-circle-o', '#ffffff', 'Module Setup', 'web', '2021-11-13 04:37:14', '2022-01-22 08:43:42'),
(14, 1, 13, 1, 1, 0, 'module.create', NULL, NULL, 'create module', 'web', '2021-11-13 04:37:14', '2021-11-13 04:37:14'),
(15, 1, 13, 2, 1, 0, 'module.edit', NULL, NULL, 'edit module', 'web', '2021-11-13 04:37:14', '2021-11-13 04:37:14'),
(16, 1, 13, 3, 1, 0, 'module.delete', NULL, NULL, 'delete module', 'web', '2021-11-13 04:37:14', '2021-11-13 04:37:14'),
(17, 1, 1, 1, 0, 1, 'site_setting.index', 'fa fa-circle-o', '#ffffff', 'Site Setting', 'web', '2021-11-13 04:37:14', '2022-01-22 08:43:36'),
(19, 1, 1, 1, 0, 1, 'company.index', 'fa fa-dashboard', '#ffffff', 'Company Setup', 'web', '2022-01-16 08:49:01', '2022-01-22 08:43:25'),
(20, 1, 19, 1, 1, 0, 'company.create', NULL, NULL, 'create company', 'web', '2022-01-16 08:53:37', '2022-01-16 08:53:37'),
(21, 1, 19, 2, 1, 0, 'company.edit', NULL, NULL, 'edit company', 'web', '2022-01-16 08:54:28', '2022-01-16 08:54:28'),
(22, 1, 19, 3, 1, 0, 'company.delete', NULL, NULL, 'delete company', 'web', '2022-01-16 08:54:33', '2022-01-16 08:54:33'),
(23, 1, 1, 3, 0, 0, 'branch.index', 'fa fa-dashboard', '#ffffff', 'Business Wing', 'web', '2022-01-16 09:27:30', '2022-01-22 05:24:52'),
(24, 1, 23, 1, 1, 0, 'branch.create', NULL, NULL, 'create branch', 'web', '2022-01-16 09:30:17', '2022-01-16 09:30:17'),
(25, 1, 23, 2, 1, 0, 'branch.edit', NULL, NULL, 'edit branch', 'web', '2022-01-16 09:30:22', '2022-01-16 09:30:22'),
(26, 1, 23, 3, 1, 0, 'branch.delete', NULL, NULL, 'delete branch', 'web', '2022-01-16 09:30:27', '2022-01-16 09:30:27'),
(27, 1, 1, 5, 0, 0, 'project.index', 'fa fa-dashboard', '#ffffff', 'Project Setup', 'web', '2022-01-16 10:39:57', '2022-03-01 07:37:58'),
(28, 1, 27, 1, 1, 0, 'project.create', NULL, NULL, 'create project', 'web', '2022-01-16 10:40:15', '2022-01-16 10:40:15'),
(29, 1, 27, 2, 1, 0, 'project.edit', NULL, NULL, 'edit project', 'web', '2022-01-16 10:40:21', '2022-01-16 10:40:21'),
(30, 1, 27, 3, 1, 0, 'project.delete', NULL, NULL, 'delete project', 'web', '2022-01-16 10:40:34', '2022-01-16 10:40:34'),
(31, 1, 1, 6, 0, 0, 'vendor.index', 'fa fa-dashboard', '#ffffff', 'Vendor Setup', 'web', '2022-01-17 04:50:58', '2022-01-22 05:29:55'),
(32, 1, 31, 1, 1, 0, 'vendor.create', NULL, '#000000', 'create vendor', 'web', '2022-01-17 04:51:10', '2022-01-17 04:51:34'),
(33, 1, 31, 2, 1, 0, 'vendor.edit', NULL, NULL, 'edit vendor', 'web', '2022-01-17 04:51:17', '2022-01-17 04:51:17'),
(34, 1, 31, 3, 1, 0, 'vendor.delete', NULL, NULL, 'delete vendor', 'web', '2022-01-17 04:51:23', '2022-01-17 04:51:23'),
(35, 1, 1, 4, 0, 0, 'unit.index', 'fa fa-dashboard', '#ffffff', 'Unit Setup', 'web', '2022-01-17 05:55:31', '2022-03-01 07:37:59'),
(36, 1, 35, 1, 1, 0, 'unit.create', NULL, NULL, 'create unit', 'web', '2022-01-17 05:55:47', '2022-01-17 05:55:47'),
(37, 1, 35, 2, 1, 0, 'unit.edit', NULL, NULL, 'edit unit', 'web', '2022-01-17 05:55:53', '2022-01-17 05:55:53'),
(38, 1, 35, 3, 1, 0, 'unit.delete', NULL, NULL, 'delete unit', 'web', '2022-01-17 05:56:02', '2022-01-17 05:56:02'),
(39, 1, 1, 7, 0, 0, 'materialgroup.index', 'fa fa-dashboard', '#ffffff', 'Material Group Setup', 'web', '2022-01-17 10:31:01', '2022-01-22 05:25:18'),
(40, 1, 39, 1, 1, 0, 'materialgroup.create', NULL, '#000000', 'create material group', 'web', '2022-01-17 10:31:37', '2022-01-22 05:57:57'),
(41, 1, 39, 2, 1, 0, 'materialgroup.edit', NULL, '#000000', 'edit material group', 'web', '2022-01-17 10:31:47', '2022-01-22 05:57:59'),
(42, 1, 39, 3, 1, 0, 'materialgroup.delete', NULL, '#000000', 'delete material group', 'web', '2022-01-17 10:31:57', '2022-01-22 05:58:01'),
(43, 1, 1, 8, 0, 0, 'material.index', 'fa fa-dashboard', '#ffffff', 'Material Setup', 'web', '2022-01-18 07:31:33', '2022-01-22 05:25:22'),
(44, 1, 43, 1, 1, 0, 'material.create', NULL, NULL, 'create material', 'web', '2022-01-18 07:31:47', '2022-01-18 07:31:47'),
(45, 1, 43, 2, 1, 0, 'material.edit', NULL, NULL, 'edit material', 'web', '2022-01-18 07:31:52', '2022-01-18 07:31:52'),
(46, 1, 43, 3, 1, 0, 'material.delete', NULL, NULL, 'delete material', 'web', '2022-01-18 07:32:31', '2022-01-18 07:32:31'),
(48, 1, 1, 9, 0, 0, 'unitconfiguration.index', 'fa fa-dashboard', '#ffffff', 'Unit Estimation', 'web', '2022-01-20 06:35:52', '2022-04-05 20:03:34'),
(49, 1, 48, 1, 1, 0, 'unitconfiguration.create', NULL, NULL, 'create unitconfiguration', 'web', '2022-01-20 06:39:17', '2022-01-20 06:39:17'),
(50, 1, 48, 2, 1, 0, 'unitconfiguration.edit', NULL, NULL, 'edit unitconfiguration', 'web', '2022-01-20 06:39:24', '2022-01-20 06:39:24'),
(51, 1, 48, 3, 1, 0, 'unitconfiguration.delete', NULL, NULL, 'delete unitconfiguration', 'web', '2022-01-20 06:39:34', '2022-01-20 06:39:34'),
(53, 0, NULL, 2, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'System Configuration', 'web', '2022-01-22 05:27:42', '2022-01-22 05:27:42'),
(54, 1, NULL, 9, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'User Management', 'web', '2022-01-22 05:27:50', '2022-11-22 06:06:47'),
(56, 1, NULL, 6, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Account Management', 'web', '2022-01-22 05:48:34', '2022-03-30 06:24:35'),
(57, 1, NULL, 5, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Inventory Management', 'web', '2022-01-22 05:48:45', '2022-01-23 16:38:21'),
(58, 0, 53, 2, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'TimeLine Setup', 'web', '2022-01-23 16:11:52', '2022-01-23 16:11:52'),
(59, 0, 53, 3, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Conversion Cofiguration', 'web', '2022-01-23 16:12:37', '2022-01-23 16:12:37'),
(60, 1, NULL, 3, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Project Budgeting', 'web', '2022-01-23 16:15:04', '2022-01-23 16:18:26'),
(61, 1, 60, 1, 0, 0, 'budgethead.index', 'fa fa-dashboard', '#ffffff', 'Cost Head', 'web', '2022-01-23 16:15:26', '2022-03-07 21:09:19'),
(62, 1, 60, 1, 0, 0, 'projectwisebudget.index', 'fa fa-dashboard', '#ffffff', 'Budget Prepare', 'web', '2022-01-23 16:15:42', '2022-03-07 21:10:49'),
(64, 1, 60, 2, 0, 0, 'plan.sheet.follow.up', 'fa fa-dashboard', '#ffffff', 'Project Plan Sheet', 'web', '2022-01-23 16:16:51', '2022-03-07 21:08:04'),
(65, 0, 60, 2, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Unit Cost Follow-Up', 'web', '2022-01-23 16:17:30', '2022-01-23 16:33:21'),
(66, 1, 56, 1, 0, 0, 'cashrequisition.index', 'fa fa-dashboard', '#ffffff', 'Cash Requisition', 'web', '2022-01-23 16:25:54', '2022-01-26 18:37:20'),
(67, 1, 56, 6, 0, 0, 'supplier.payment', 'fa fa-dashboard', '#ffffff', 'Supplier Payment', 'web', '2022-01-23 16:26:06', '2022-11-12 06:12:37'),
(69, 1, 158, 5, 0, 0, 'cost.ledger.report', 'fa fa-dashboard', '#ffffff', 'Cost Ledger', 'web', '2022-01-23 16:34:18', '2022-11-22 06:08:51'),
(70, 1, 158, 5, 0, 0, 'vendorStatement', 'fa fa-dashboard', '#ffffff', 'Vendor Statement', 'web', '2022-01-23 16:34:35', '2022-11-22 06:08:58'),
(71, 0, 56, 6, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Project Profit Loss', 'web', '2022-01-23 16:34:55', '2022-01-23 16:34:55'),
(72, 1, 57, 1, 0, 0, 'materiallifting.index', 'fa fa-dashboard', '#ffffff', 'Material Lifting', 'web', '2022-01-23 16:36:26', '2022-01-23 17:28:29'),
(73, 1, 57, 2, 0, 0, 'materialrequisition.index', 'fa fa-dashboard', '#ffffff', 'Material Requisition', 'web', '2022-01-23 16:36:48', '2022-10-16 10:32:27'),
(74, 1, 57, 3, 0, 0, 'materialissue.index', 'fa fa-dashboard', '#ffffff', 'Material Transfer', 'web', '2022-01-23 16:37:41', '2022-07-27 09:31:39'),
(75, 1, 57, 5, 0, 0, 'dailyconsumption.index', 'fa fa-dashboard', '#ffffff', 'Local Issue', 'web', '2022-01-23 16:38:11', '2022-03-30 06:42:45'),
(76, 1, 57, 4, 0, 0, 'materialreceive.index', 'fa fa-dashboard', '#ffffff', 'Material Receive', 'web', '2022-01-23 16:38:40', '2022-01-24 09:34:18'),
(77, 0, 57, 6, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Consumption Follow-Up', 'web', '2022-01-23 16:40:51', '2022-01-23 16:40:51'),
(78, 1, 60, 7, 0, 0, 'project.budget.status', 'fa fa-dashboard', '#ffffff', 'Project Budget Status', 'web', '2022-01-23 16:41:11', '2022-03-08 08:49:48'),
(79, 0, 57, 8, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Material Movement Status', 'web', '2022-01-23 16:41:21', '2022-01-23 16:41:21'),
(80, 0, 57, 9, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Material Inventory', 'web', '2022-01-23 16:41:40', '2022-01-23 16:41:40'),
(81, 0, 57, 10, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Daily Work Activity', 'web', '2022-01-23 16:41:51', '2022-01-23 16:41:51'),
(82, 1, 72, 1, 1, 0, 'materiallifting.create', NULL, NULL, 'create materiallifting', 'web', '2022-01-23 17:28:04', '2022-01-23 17:28:04'),
(83, 1, 72, 2, 1, 0, 'materiallifting.edit', NULL, NULL, 'edit materiallifting', 'web', '2022-01-23 17:28:09', '2022-01-23 17:28:09'),
(84, 1, 72, 3, 1, 0, 'materiallifting.delete', NULL, NULL, 'delete materiallifting', 'web', '2022-01-23 17:28:15', '2022-01-23 17:28:15'),
(85, 1, 74, 1, 1, 0, 'materialissue.create', NULL, NULL, 'create materialissue', 'web', '2022-01-24 07:18:59', '2022-01-24 07:18:59'),
(86, 1, 74, 2, 1, 0, 'materialissue.edit', NULL, NULL, 'edit materialissue', 'web', '2022-01-24 07:19:06', '2022-01-24 07:19:06'),
(87, 1, 74, 3, 1, 0, 'materialissue.delete', NULL, NULL, 'delete materialissue', 'web', '2022-01-24 07:19:16', '2022-01-24 07:19:16'),
(88, 1, NULL, 10, 0, 0, 'gallery.index', 'fa fa-dashboard', '#ffffff', 'Project Gallery', 'web', '2022-01-25 09:03:21', '2022-11-22 06:07:00'),
(89, 1, 88, 1, 1, 0, 'gallery.create', NULL, NULL, 'create gallery', 'web', '2022-01-25 09:03:41', '2022-01-25 09:03:41'),
(90, 1, 88, 2, 1, 0, 'gallery.edit', NULL, NULL, 'edit gallery', 'web', '2022-01-25 09:03:47', '2022-01-25 09:03:47'),
(91, 1, 88, 3, 1, 0, 'gallery.delete', NULL, NULL, 'delete gallery', 'web', '2022-01-25 09:03:56', '2022-01-25 09:03:56'),
(92, 1, 88, 4, 1, 0, 'gallery.show', NULL, NULL, 'show gallery', 'web', '2022-01-25 09:19:07', '2022-01-25 09:19:07'),
(93, 1, 61, 1, 1, 0, 'budgethead.create', NULL, NULL, 'create budgethead', 'web', '2022-01-26 17:33:34', '2022-01-26 17:33:34'),
(94, 1, 61, 2, 1, 0, 'budgethead.edit', NULL, NULL, 'edit budgethead', 'web', '2022-01-26 17:33:41', '2022-01-26 17:33:41'),
(95, 1, 61, 3, 1, 0, 'budgethead.delete', NULL, NULL, 'delete budgethead', 'web', '2022-01-26 17:33:48', '2022-01-26 17:33:48'),
(96, 1, 66, 1, 1, 0, 'cashrequisition.create', NULL, NULL, 'create cashrequisition', 'web', '2022-01-26 18:37:34', '2022-01-26 18:37:34'),
(97, 1, 66, 2, 1, 0, 'cashrequisition.edit', NULL, NULL, 'edit cashrequisition', 'web', '2022-01-26 18:37:39', '2022-01-26 18:37:39'),
(98, 1, 66, 3, 1, 0, 'cashrequisition.delete', NULL, NULL, 'delete cashrequisition', 'web', '2022-01-26 18:37:46', '2022-01-26 18:37:46'),
(100, 1, 66, 4, 1, 0, 'home', NULL, '#000000', 'Can Approve Cash Requisition', 'web', '2022-01-29 16:46:49', '2022-01-29 16:47:13'),
(101, 1, 62, 1, 1, 0, 'projectwisebudget.create', NULL, NULL, 'create projectwisebudget', 'web', '2022-01-30 16:28:40', '2022-01-30 16:28:40'),
(102, 1, 62, 2, 1, 0, 'projectwisebudget.edit', NULL, NULL, 'edit projectwisebudget', 'web', '2022-01-30 16:28:46', '2022-01-30 16:28:46'),
(103, 1, 62, 3, 1, 0, 'projectwisebudget.delete', NULL, NULL, 'delete projectwisebudget', 'web', '2022-01-30 16:28:54', '2022-01-30 16:28:54'),
(105, 1, 158, 10, 0, 0, 'material.statement.report', 'fa fa-dashboard', '#ffffff', 'Material Statement', 'web', '2022-03-09 18:53:06', '2022-11-22 06:09:01'),
(106, 1, 75, 1, 1, 0, 'dailyconsumption.create', NULL, NULL, 'create local issue', 'web', '2022-03-30 06:43:20', '2022-03-30 06:43:20'),
(107, 1, 75, 2, 1, 0, 'dailyconsumption.edit', NULL, NULL, 'edit local issue', 'web', '2022-03-30 06:43:37', '2022-03-30 06:43:37'),
(108, 1, 75, 3, 1, 0, 'dailyconsumption.delete', NULL, NULL, 'delete local issue', 'web', '2022-03-30 06:44:20', '2022-03-30 06:44:20'),
(109, 1, 116, 4, 0, 0, 'daily.consumption.report', 'fa fa-dashboard', '#ffffff', 'Consumption Log', 'web', '2022-03-31 18:13:51', '2022-11-13 03:29:51'),
(110, 1, 158, 12, 0, 0, 'stock.report', 'fa fa-dashboard', '#ffffff', 'Stock Status', 'web', '2022-04-01 16:58:33', '2022-11-22 06:09:55'),
(111, 1, 116, 1, 0, 0, 'lifting.report', 'fa fa-dashboard', '#ffffff', 'Lifting Log', 'web', '2022-04-02 07:37:06', '2022-11-13 03:29:02'),
(112, 1, 116, 2, 0, 0, 'issue.log.report', 'fa fa-dashboard', '#ffffff', 'Transfer Log', 'web', '2022-04-02 16:47:04', '2022-11-13 03:29:15'),
(113, 1, 116, 15, 0, 0, 'payment.log.report', 'fa fa-dashboard', '#ffffff', 'Payment Log', 'web', '2022-04-02 17:47:59', '2022-04-06 17:29:42'),
(116, 1, NULL, 7, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Transaction Report', 'web', '2022-04-06 17:19:16', '2022-11-22 06:07:25'),
(117, 1, 1, 10, 0, 0, 'company.setup', 'fa fa-dashboard', '#ffffff', 'Company', 'web', '2022-04-08 06:52:40', '2022-04-08 06:52:40'),
(118, 1, 57, 7, 0, 0, 'dailyuses.index', 'fa fa-dashboard', '#ffffff', 'Daily Consumption', 'web', '2022-04-21 20:00:54', '2022-11-13 03:26:01'),
(119, 1, 62, 4, 1, 0, 'projectwiseroa.index', NULL, NULL, 'ROA', 'web', '2022-04-22 05:51:36', '2022-04-22 05:51:36'),
(120, 1, 66, 5, 1, 0, 'cashrequisition.payment.view', NULL, NULL, 'Cash Requisition Payment', 'web', '2022-04-24 19:44:25', '2022-04-24 19:44:25'),
(121, 1, 74, 4, 1, 0, 'materialissue.print', NULL, NULL, 'print materialissue', 'web', '2022-05-19 03:43:09', '2022-05-19 03:43:09'),
(122, 1, 72, 4, 1, 0, 'materiallifting.print', NULL, NULL, 'print materiallifting', 'web', '2022-05-19 17:32:57', '2022-05-19 17:32:57'),
(124, 1, 75, 4, 1, 0, 'dailyconsumption.print', NULL, NULL, 'print local issue', 'web', '2022-05-19 17:35:45', '2022-05-19 17:35:45'),
(125, 1, 1, 9, 0, 0, 'logisticCharge.index', 'fa fa-dashboard', '#ffffff', 'Logistics Charge', 'web', '2022-05-24 04:01:31', '2022-05-29 05:17:57'),
(126, 1, 125, 1, 1, 0, 'logisticCharge.create', NULL, NULL, 'create logistics charge', 'web', '2022-05-24 04:01:57', '2022-05-24 04:01:57'),
(127, 1, 125, 2, 1, 0, 'logisticCharge.edit', NULL, NULL, 'edit logistics charge', 'web', '2022-05-24 04:02:14', '2022-05-24 04:02:14'),
(128, 1, 125, 3, 1, 0, 'logisticCharge.delete', NULL, NULL, 'delete logistics charge', 'web', '2022-05-24 04:02:29', '2022-05-24 04:02:29'),
(129, 1, 56, 3, 0, 0, 'tbp.index', 'fa fa-dashboard', '#ffffff', 'Transportation Bill', 'web', '2022-05-24 05:11:56', '2022-11-11 19:17:10'),
(130, 1, 129, 1, 1, 0, 'tbp.create', NULL, NULL, 'create tbp', 'web', '2022-05-24 05:12:20', '2022-05-24 05:12:20'),
(132, 1, 129, 3, 1, 0, 'tbp.delete', NULL, NULL, 'delete tbp', 'web', '2022-05-24 05:12:53', '2022-05-24 05:12:53'),
(133, 1, 129, 4, 1, 0, 'tbp.print', NULL, NULL, 'print tbp', 'web', '2022-05-24 09:21:02', '2022-05-24 09:21:02'),
(134, 1, 118, 1, 1, 0, 'dailyuse.create', NULL, NULL, 'create daily use', 'web', '2022-06-10 09:02:48', '2022-06-10 09:02:48'),
(135, 1, 118, 2, 1, 0, 'dailyuse.edit', NULL, NULL, 'edit daily use', 'web', '2022-06-10 09:03:00', '2022-06-10 09:03:00'),
(136, 1, 118, 3, 1, 0, 'dailyuse.delete', NULL, NULL, 'delete daily use', 'web', '2022-06-10 09:03:11', '2022-06-10 09:03:11'),
(137, 1, 118, 4, 1, 0, 'dailyuse.print', NULL, NULL, 'print daily use', 'web', '2022-06-10 09:03:22', '2022-06-10 09:03:22'),
(138, 1, 67, 1, 1, 0, 'home.index', NULL, NULL, 'cash', 'web', '2022-06-12 08:42:59', '2022-06-12 08:42:59'),
(139, 1, 67, 2, 1, 0, 'home.index', NULL, NULL, 'material', 'web', '2022-06-12 08:43:05', '2022-06-12 08:43:05'),
(140, 1, 67, 3, 1, 0, 'home.index', NULL, NULL, 'transportation', 'web', '2022-06-12 08:43:14', '2022-06-12 08:43:14'),
(141, 1, 116, 3, 0, 0, 'local.issue.report', 'fa fa-dashboard', '#ffffff', 'Local Issue Log', 'web', '2022-07-27 10:56:28', '2022-11-13 03:29:31'),
(142, 1, 57, 6, 0, 0, 'dailyconsumption.receiveList', 'fa fa-dashboard', '#ffffff', 'Local Receive', 'web', '2022-08-09 12:13:10', '2022-11-13 03:25:21'),
(143, 1, 60, 6, 0, 0, 'additionalbudget.index', 'fa fa-dashboard', '#ffffff', 'Additional Budget', 'web', '2022-08-12 09:23:07', '2022-08-12 09:23:07'),
(144, 1, 143, 1, 1, 0, 'home.index', NULL, NULL, 'create additionalbudget', 'web', '2022-08-12 09:23:34', '2022-08-12 09:23:34'),
(145, 1, 73, 1, 1, 0, 'home.index', NULL, NULL, 'create materialrequisition', 'web', '2022-10-16 10:32:58', '2022-10-16 10:32:58'),
(146, 1, 73, 2, 1, 0, 'home.index', NULL, NULL, 'edit materialrequisition', 'web', '2022-10-16 10:33:10', '2022-10-16 10:33:10'),
(147, 1, 73, 3, 1, 0, 'home.index', NULL, NULL, 'delete materialrequisition', 'web', '2022-10-16 10:33:21', '2022-10-16 10:33:21'),
(148, 1, 57, 9, 0, 0, 'approveRequisitionStepOneList', 'fa fa-dashboard', '#ffffff', 'Material Approve', 'web', '2022-10-16 10:34:11', '2022-11-13 03:26:44'),
(149, 1, 57, 10, 0, 0, 'approveRequisitionStepTwoList', 'fa fa-dashboard', '#ffffff', 'Material Final Approve', 'web', '2022-10-16 10:34:24', '2022-11-13 03:27:22'),
(150, 1, 56, 2, 0, 0, 'cashrequisition.index.view', 'fa fa-dashboard', '#ffffff', 'Requisition Approve', 'web', '2022-10-16 10:35:04', '2022-10-29 06:44:22'),
(151, 1, 56, 7, 0, 0, 'dailyexpense.index', 'fa fa-dashboard', '#ffffff', 'Daily Expense', 'web', '2022-10-20 18:15:16', '2022-11-12 06:12:35'),
(152, 1, 151, 1, 1, 0, 'home.index', NULL, NULL, 'create dailyexpense', 'web', '2022-10-20 18:17:09', '2022-10-20 18:17:09'),
(153, 1, 151, 2, 1, 0, 'home.index', NULL, NULL, 'edit dailyexpense', 'web', '2022-10-20 18:17:23', '2022-10-20 18:17:23'),
(154, 1, 151, 3, 1, 0, 'home.index', NULL, NULL, 'delete dailyexpense', 'web', '2022-10-20 18:17:45', '2022-10-20 18:17:45'),
(155, 1, 143, 2, 1, 0, 'home.index', NULL, NULL, 'delete additionalbudget', 'web', '2022-10-23 08:28:47', '2022-10-23 08:28:47'),
(156, 1, 116, 16, 0, 0, 'expense.log.report', 'fa fa-dashboard', '#ffffff', 'Expense Log', 'web', '2022-11-11 19:04:40', '2022-11-11 19:20:03'),
(157, 1, 56, 7, 0, 0, 'cash.due.status', 'fa fa-dashboard', '#ffffff', 'Cash Payment Status', 'web', '2022-11-12 19:52:06', '2022-11-12 20:06:31'),
(158, 1, NULL, 8, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Ledger Report', 'web', '2022-11-22 06:03:42', '2022-11-22 06:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `project_type` text NOT NULL,
  `project_code` text NOT NULL,
  `project_name` text NOT NULL,
  `contact_person_name` text NOT NULL,
  `contact_person_phone` text NOT NULL,
  `address` text NOT NULL,
  `show_dashboard` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `company_id`, `branch_id`, `project_type`, `project_code`, `project_name`, `contact_person_name`, `contact_person_phone`, `address`, `show_dashboard`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'tower', 'NB132KvL', 'Neogoan - Bagmara 132Kv Line', 'Mr.Tanvir', '0000000000', 'Dhaka', 1, '2024-02-07 05:03:39', '2024-02-07 05:03:39');

-- --------------------------------------------------------

--
-- Table structure for table `project_budget_wise_roas`
--

CREATE TABLE `project_budget_wise_roas` (
  `id` int(11) NOT NULL,
  `projectwise_budget_id` int(11) NOT NULL,
  `survery_date` text NOT NULL,
  `owner_name` text NOT NULL,
  `access_type` text NOT NULL,
  `phone` text NOT NULL,
  `crops` text NOT NULL,
  `area` text NOT NULL,
  `per_area` text NOT NULL,
  `rate_per_kg` text NOT NULL,
  `payment_date` text DEFAULT NULL,
  `total` text NOT NULL,
  `advance_paid` text NOT NULL,
  `owner_demand` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `project_budget_wise_roas`
--

INSERT INTO `project_budget_wise_roas` (`id`, `projectwise_budget_id`, `survery_date`, `owner_name`, `access_type`, `phone`, `crops`, `area`, `per_area`, `rate_per_kg`, `payment_date`, `total`, `advance_paid`, `owner_demand`, `created_by`, `created_at`, `updated_at`) VALUES
(12, 16, '21-01-2024', 'aaa', 'Land', '111111', '11', '11', '10', '100', '21-01-2024', '1000', '200', '1200', 1, '2024-01-21 07:23:47', '2024-01-21 07:23:47');

-- --------------------------------------------------------

--
-- Table structure for table `project_towers`
--

CREATE TABLE `project_towers` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text DEFAULT NULL,
  `soil_category` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `project_towers`
--

INSERT INTO `project_towers` (`id`, `project_id`, `name`, `type`, `soil_category`, `created_at`, `updated_at`) VALUES
(1, 1, 'T-5/1', '1DL+6.0m', '02', '2024-01-20 15:48:27', '2024-01-20 07:39:29'),
(2, 1, 'T-5/2', '1DL+3.0m', '02', '2024-01-20 15:48:32', '2024-01-20 07:39:29'),
(3, 1, 'T-5/3', '1DL+9.0m', '02', '2024-01-20 15:48:37', '2024-01-20 07:39:29'),
(4, 1, 'AP-3', '1DT6+9.0m', '02', '2024-01-20 15:48:42', '2024-01-20 07:39:29'),
(5, 1, 'T-2B/2', '1DL+9.0m', '02', '2024-01-20 15:48:47', '2024-01-20 07:39:29'),
(6, 1, 'T-7/6', '1DL+9.0m', '02', '2024-01-20 15:48:53', '2024-01-20 07:39:29'),
(7, 1, 'T-7/3', '1DL+6.0m', '02', '2024-01-20 15:48:58', '2024-01-20 07:39:29');

-- --------------------------------------------------------

--
-- Table structure for table `project_units`
--

CREATE TABLE `project_units` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `project_units`
--

INSERT INTO `project_units` (`id`, `project_id`, `unit_id`, `created_at`, `updated_at`) VALUES
(1, 1, 8, NULL, NULL),
(2, 1, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_wise_budgets`
--

CREATE TABLE `project_wise_budgets` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `unit_config_id` int(11) NOT NULL,
  `long_l` int(11) DEFAULT NULL,
  `volume` int(11) DEFAULT NULL,
  `number_of_pile` int(11) DEFAULT NULL,
  `tower_id` int(11) DEFAULT NULL,
  `start_date` text DEFAULT NULL,
  `end_date` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `is_additional` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `project_wise_budgets`
--

INSERT INTO `project_wise_budgets` (`id`, `company_id`, `project_id`, `unit_id`, `unit_config_id`, `long_l`, `volume`, `number_of_pile`, `tower_id`, `start_date`, `end_date`, `remarks`, `is_additional`, `created_by`, `created_at`, `updated_at`) VALUES
(16, 1, 1, 8, 1, 8, NULL, 10, 2, '2024-01-01', '2024-01-31', NULL, 0, 1, '2024-01-21 07:19:39', '2024-01-21 07:19:39'),
(18, 1, 1, 8, 0, NULL, NULL, NULL, 2, NULL, NULL, 'aaa', 1, 1, '2024-01-21 07:25:21', '2024-01-21 07:25:21'),
(19, 1, 1, 8, 0, NULL, NULL, NULL, 1, NULL, NULL, 'Ggg', 1, 1, '2024-01-22 09:10:21', '2024-01-22 09:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `project_wise_budget_items`
--

CREATE TABLE `project_wise_budget_items` (
  `id` int(11) NOT NULL,
  `projectwise_budget_id` int(11) NOT NULL,
  `budget_head` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `project_wise_budget_items`
--

INSERT INTO `project_wise_budget_items` (`id`, `projectwise_budget_id`, `budget_head`, `amount`, `qty`, `remarks`, `created_at`, `updated_at`) VALUES
(272, 16, 3, 17016, 142, NULL, NULL, NULL),
(273, 16, 4, 38480, 296, NULL, NULL, NULL),
(274, 16, 5, 64787, 381, NULL, NULL, NULL),
(275, 16, 66, 4480, 80, NULL, NULL, NULL),
(276, 16, 6, 32000, 80, NULL, NULL, NULL),
(277, 16, 63, 13500, 45, NULL, NULL, NULL),
(278, 16, 71, 750, 15, NULL, NULL, NULL),
(280, 18, 68, 1020, 10, 'ww', NULL, NULL),
(281, 18, 74, 2000, 20, 'ww', NULL, NULL),
(282, 19, 68, 26, 2, 'Hygt', NULL, NULL),
(283, 19, 75, 13600, 136, 'Hgg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `company_id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Software Admin', 'web', '2021-11-13 04:37:14', '2021-11-13 04:37:14'),
(2, NULL, 'SuperAdmin', 'web', '2021-11-13 04:37:14', '2022-01-16 09:29:56'),
(7, NULL, 'Company Admin', 'web', '2022-01-19 06:09:10', '2022-01-22 08:09:11'),
(8, NULL, 'Project Manager', 'web', '2022-01-22 08:45:08', '2022-01-22 08:45:08'),
(9, NULL, 'Vendor', 'web', '2022-01-19 06:09:10', '2022-01-22 08:09:11'),
(10, NULL, 'Field Operator', 'web', '2022-05-28 07:51:12', '2022-05-28 07:51:12');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 7),
(1, 8),
(2, 1),
(2, 2),
(2, 7),
(3, 1),
(3, 2),
(3, 7),
(4, 1),
(6, 1),
(6, 2),
(6, 7),
(7, 1),
(7, 7),
(8, 1),
(8, 2),
(8, 7),
(8, 8),
(9, 1),
(9, 2),
(9, 7),
(10, 1),
(10, 2),
(10, 7),
(11, 1),
(11, 2),
(11, 7),
(12, 1),
(12, 2),
(12, 7),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 1),
(27, 2),
(27, 7),
(28, 1),
(28, 2),
(28, 7),
(29, 1),
(29, 2),
(29, 7),
(30, 1),
(30, 2),
(30, 7),
(31, 1),
(31, 2),
(31, 7),
(31, 8),
(32, 1),
(32, 2),
(32, 7),
(32, 8),
(33, 1),
(33, 2),
(33, 7),
(33, 8),
(34, 1),
(34, 2),
(34, 7),
(34, 8),
(35, 8),
(36, 8),
(37, 8),
(38, 8),
(39, 8),
(40, 8),
(41, 8),
(42, 8),
(43, 1),
(43, 2),
(43, 7),
(43, 8),
(44, 1),
(44, 2),
(44, 7),
(44, 8),
(45, 1),
(45, 2),
(45, 7),
(45, 8),
(46, 1),
(46, 2),
(46, 7),
(46, 8),
(48, 1),
(48, 2),
(48, 7),
(48, 8),
(49, 1),
(49, 2),
(49, 7),
(49, 8),
(50, 1),
(50, 2),
(50, 7),
(50, 8),
(51, 1),
(51, 2),
(51, 7),
(51, 8),
(54, 1),
(54, 2),
(54, 7),
(56, 1),
(56, 2),
(56, 7),
(56, 8),
(56, 9),
(57, 1),
(57, 2),
(57, 7),
(57, 8),
(57, 10),
(60, 1),
(60, 2),
(60, 7),
(60, 8),
(61, 1),
(61, 2),
(61, 7),
(61, 8),
(62, 1),
(62, 2),
(62, 7),
(62, 8),
(64, 1),
(64, 2),
(64, 8),
(66, 1),
(66, 2),
(66, 7),
(66, 8),
(66, 9),
(67, 1),
(67, 2),
(67, 7),
(67, 8),
(67, 9),
(69, 1),
(69, 2),
(69, 7),
(69, 8),
(70, 1),
(70, 2),
(70, 7),
(70, 8),
(70, 9),
(72, 1),
(72, 2),
(72, 7),
(72, 8),
(72, 10),
(73, 10),
(74, 1),
(74, 2),
(74, 7),
(74, 8),
(74, 10),
(75, 1),
(75, 2),
(75, 7),
(75, 8),
(75, 10),
(76, 2),
(76, 7),
(76, 8),
(76, 10),
(78, 1),
(78, 2),
(78, 7),
(82, 1),
(82, 2),
(82, 7),
(82, 8),
(82, 10),
(83, 1),
(83, 2),
(83, 7),
(83, 8),
(83, 10),
(84, 1),
(84, 2),
(84, 7),
(84, 8),
(84, 10),
(85, 1),
(85, 2),
(85, 7),
(85, 8),
(85, 10),
(86, 1),
(86, 2),
(86, 7),
(86, 8),
(86, 10),
(87, 1),
(87, 2),
(87, 7),
(87, 8),
(87, 10),
(88, 1),
(88, 2),
(88, 7),
(88, 8),
(89, 1),
(89, 2),
(89, 7),
(89, 8),
(90, 1),
(90, 2),
(90, 7),
(90, 8),
(91, 1),
(91, 2),
(91, 7),
(91, 8),
(92, 1),
(92, 2),
(92, 7),
(92, 8),
(93, 1),
(93, 2),
(93, 7),
(93, 8),
(94, 1),
(94, 2),
(94, 7),
(94, 8),
(95, 1),
(95, 2),
(95, 7),
(95, 8),
(96, 1),
(96, 2),
(96, 7),
(96, 8),
(96, 9),
(97, 1),
(97, 2),
(97, 7),
(97, 8),
(97, 9),
(98, 1),
(98, 2),
(98, 7),
(98, 8),
(98, 9),
(100, 1),
(100, 7),
(100, 9),
(101, 1),
(101, 2),
(101, 7),
(101, 8),
(102, 1),
(102, 2),
(102, 7),
(102, 8),
(103, 1),
(103, 2),
(103, 7),
(103, 8),
(105, 1),
(105, 2),
(105, 7),
(105, 8),
(106, 1),
(106, 2),
(106, 7),
(106, 8),
(106, 10),
(107, 1),
(107, 2),
(107, 7),
(107, 8),
(107, 10),
(108, 1),
(108, 2),
(108, 7),
(108, 8),
(108, 10),
(109, 1),
(109, 2),
(109, 7),
(109, 8),
(110, 1),
(110, 2),
(110, 7),
(110, 8),
(111, 1),
(111, 2),
(111, 7),
(111, 8),
(112, 1),
(112, 2),
(112, 8),
(113, 1),
(113, 2),
(113, 7),
(113, 8),
(116, 1),
(116, 2),
(116, 7),
(116, 8),
(117, 2),
(118, 1),
(118, 2),
(118, 7),
(118, 8),
(118, 10),
(119, 1),
(119, 7),
(120, 1),
(120, 7),
(120, 9),
(121, 1),
(121, 7),
(121, 8),
(121, 10),
(122, 1),
(122, 7),
(122, 8),
(122, 10),
(124, 1),
(124, 7),
(124, 8),
(124, 10),
(125, 1),
(125, 7),
(126, 1),
(126, 7),
(127, 1),
(127, 7),
(128, 1),
(128, 7),
(129, 1),
(129, 7),
(129, 8),
(130, 1),
(130, 7),
(130, 8),
(132, 1),
(132, 7),
(132, 8),
(133, 1),
(133, 7),
(133, 8),
(134, 1),
(134, 2),
(134, 7),
(134, 10),
(135, 1),
(135, 2),
(135, 7),
(135, 10),
(136, 1),
(136, 2),
(136, 7),
(136, 10),
(137, 1),
(137, 2),
(137, 7),
(137, 10),
(138, 1),
(138, 2),
(138, 7),
(139, 1),
(139, 2),
(139, 7),
(140, 1),
(140, 2),
(140, 7),
(141, 7),
(142, 1),
(142, 7),
(143, 1),
(143, 7),
(144, 1),
(144, 7),
(145, 10),
(146, 10),
(147, 10),
(148, 1),
(149, 1),
(150, 1),
(150, 7),
(151, 1),
(151, 7),
(152, 1),
(152, 7),
(153, 1),
(153, 7),
(154, 1),
(154, 7),
(155, 1),
(155, 7),
(156, 1),
(156, 7),
(156, 8),
(157, 1),
(157, 7),
(157, 8),
(158, 1),
(158, 7);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `website_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `website_logo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon_img` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `website_name`, `website_logo`, `favicon_img`, `created_at`, `updated_at`) VALUES
(1, 'Project Book', 'wX8XqbpCN1kqfGrSIuE2WHGFTGrwxskcljEP0prC.jpg', 'tUHqF8VLqpv9raTszOsfvrqzdpuX5oG9U8RYgMp3.jpg', '2021-11-13 04:37:15', '2023-05-24 04:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payments`
--

CREATE TABLE `supplier_payments` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `tower_id` int(11) DEFAULT NULL,
  `payment_no` text NOT NULL,
  `payment_type` text DEFAULT NULL,
  `payment_date` text NOT NULL,
  `money_receipt` text NOT NULL,
  `remarks` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payment_items`
--

CREATE TABLE `supplier_payment_items` (
  `id` int(11) NOT NULL,
  `supplier_payment_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `budget_head_id` int(11) NOT NULL,
  `amount` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `t_b_p_items`
--

CREATE TABLE `t_b_p_items` (
  `id` int(11) NOT NULL,
  `tbp_id` int(11) NOT NULL,
  `consumption_item_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `material_qty` text NOT NULL,
  `material_rate` text NOT NULL,
  `payment_amount` text DEFAULT NULL,
  `payment_status` int(11) NOT NULL DEFAULT 0,
  `paid_by` int(11) DEFAULT NULL,
  `payment_time` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `t_b_p_s`
--

CREATE TABLE `t_b_p_s` (
  `id` int(11) NOT NULL,
  `system_serial` text NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `budget_head_id` int(11) NOT NULL,
  `date` text DEFAULT NULL,
  `payment_type` text NOT NULL,
  `remarks` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `code` text DEFAULT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `company_id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(8, 0, 'PLC', 'Pile Work', '2022-03-01 07:54:05', '2022-03-01 07:54:05'),
(9, 0, 'PCW', 'Cap Work', '2022-03-01 07:54:17', '2022-03-01 07:54:17'),
(10, 0, 'soil_excavation', 'Soil Excavation', '2022-03-09 17:49:18', '2022-03-26 08:28:40'),
(11, 0, 'rcc_footing_work', 'RCC Footing Work', '2022-03-26 08:39:02', '2022-03-26 08:39:02'),
(12, 0, 'rcc_column', 'RCC Column', '2022-03-26 08:42:01', '2022-03-26 08:42:01'),
(13, 0, 'rcc_beam', 'RCC Beam', '2022-03-26 08:44:40', '2022-03-26 08:44:40'),
(14, 0, 'rcc_slab', 'RCC Slab', '2022-03-26 08:44:49', '2022-03-26 08:44:49'),
(15, 0, 'guide_wall', 'Guide Wall', '2022-03-26 08:45:07', '2022-03-26 08:45:07'),
(16, 0, 'wall', 'Wall', '2022-03-26 08:48:31', '2022-03-26 08:48:31'),
(17, 0, 'pluster', 'Pluster', '2022-03-26 09:05:54', '2022-03-26 09:05:54'),
(18, 0, 'brick_soling', 'Brick Soling', '2022-03-26 09:19:48', '2022-03-26 09:19:48'),
(19, 0, 'sand_filing', 'Sand Filing', '2022-03-26 09:19:58', '2022-03-26 09:19:58'),
(20, 0, 'tiles', 'Tiles', '2022-03-26 09:20:17', '2022-03-26 09:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `unit_configurations`
--

CREATE TABLE `unit_configurations` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_name` text NOT NULL,
  `pile_length` text DEFAULT NULL,
  `dia` text DEFAULT NULL,
  `length` text DEFAULT NULL,
  `width` text DEFAULT NULL,
  `height` text DEFAULT NULL,
  `cement` text DEFAULT NULL,
  `sand` text DEFAULT NULL,
  `stone` text DEFAULT NULL,
  `cement_qty` text DEFAULT NULL,
  `sand_qty` text DEFAULT NULL,
  `stone_qty` text DEFAULT NULL,
  `brick_qty` text DEFAULT NULL,
  `soil_qty` text DEFAULT NULL,
  `tiles_sft` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `unit_configurations`
--

INSERT INTO `unit_configurations` (`id`, `company_id`, `project_id`, `unit_id`, `unit_name`, `pile_length`, `dia`, `length`, `width`, `height`, `cement`, `sand`, `stone`, `cement_qty`, `sand_qty`, `stone_qty`, `brick_qty`, `soil_qty`, `tiles_sft`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 8, '001_PLC/8_500_4.82', '8', '500', NULL, NULL, NULL, '1', '1.67', '2.15', '14.18', '29.60', '38.11', NULL, NULL, NULL, '2024-01-20 07:42:08', '2024-01-20 07:42:08'),
(2, 1, 1, 9, '001_PCW/2.3_900_.5_5.52', NULL, NULL, '2.3', '900', '.5', '1', '1.78', '2.74', '1', '1', '1', NULL, NULL, NULL, '2024-01-20 07:45:43', '2024-01-20 07:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `unit_config_materials`
--

CREATE TABLE `unit_config_materials` (
  `id` int(11) NOT NULL,
  `unitconfig_id` text NOT NULL,
  `material_id` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Software Admin', 'admin@gmail.com', NULL, '$2y$10$WyqOlhZTAjqYD0GZjaiGNu51EAty0AGrpENHuz6iwylld7KC/Wj.a', NULL, 1, 'TknR0Zp1JCvh4rBUEJeT8M3jZcIXCu924JfunXiuT52rg641B0biZqzKnyze', '2021-11-13 04:37:15', '2022-10-01 06:41:56'),
(2, 1, 'Contain i', 'Contain', NULL, '$2y$10$nYx6nyKN3xZRICroCHCME.hqWmHzYNDa9yi16yWY0G3Ve4hGTYFlK', 'GUMgtkYwIEpfzoAcCXceoqKybCLEUUocNhrAZYhG.jpg', 1, '5LmhbwdbYFiwulFpk7Erg9likWoVppYpvTUoSDXJPr5pAlNl27G2Et6iy4ti', '2022-07-11 17:56:07', '2024-01-21 07:40:23'),
(3, 1, 'field1', 'field1', NULL, '$2y$10$OycNgMpZlIHKqJ.T7RGGnO6InPiW.EbQpLyDsvkYfN1FWfSEnah.O', '', 1, NULL, '2022-07-29 16:48:19', '2022-07-29 16:48:19'),
(4, 1, 'field2', 'field2', NULL, '$2y$10$uq4F.3il9gYLJEeQcjfzZOi4ns1pczCpypYJVgYPhBkSiH0wAEk9S', '', 1, NULL, '2022-07-29 16:50:16', '2022-07-29 16:50:16'),
(6, 1, 'Working Associate 01', 'Working Associate 01', NULL, '$2y$10$FJCTWVp9DqGUDJ2QjojrbeS2c2DVfChzHfZqFxXEKaHrircitF.LW', '', 1, NULL, '2022-11-19 08:48:19', '2022-11-19 08:48:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_branches`
--

CREATE TABLE `user_branches` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `user_projects`
--

CREATE TABLE `user_projects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_projects`
--

INSERT INTO `user_projects` (`id`, `user_id`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 42, 1, NULL, NULL),
(7, 26, 1, NULL, NULL),
(8, 35, 1, NULL, NULL),
(9, 35, 2, NULL, NULL),
(11, 3, 1, NULL, NULL),
(12, 4, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_units`
--

CREATE TABLE `user_units` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vendor_type` text NOT NULL,
  `code` text DEFAULT NULL,
  `name` text NOT NULL,
  `contact_person_name` text NOT NULL,
  `contact_person_phone` text NOT NULL,
  `contact_person_email` text DEFAULT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `company_id`, `user_id`, `vendor_type`, `code`, `name`, `contact_person_name`, `contact_person_phone`, `contact_person_email`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Material Supplier', 'V_Stone_001', 'Al kafeydu Trading', 'Mr Jahangir', '01715149279', 'xyz@fdf.com', 'Chatak Syhlet', '2022-07-17 08:37:56', '2022-07-17 08:37:56'),
(2, 1, NULL, 'Material Supplier', 'anoar-cement', 'Anowar cement', 'Anowar cement', '444444444444', 'companyavendor@gmail.com', 'sdafsadfasfsadf', '2022-07-21 06:56:35', '2022-07-21 06:56:35'),
(3, 1, NULL, 'Material Supplier', 'saidul-trade', 'M/S Saiful Trad', 'M/S Saiful Trad.', '435345345', 'companyavendor@gmail.com', 'sda fasd fasd f', '2022-07-21 07:12:21', '2022-07-21 07:12:21'),
(4, 1, NULL, 'Material Supplier', 'Al-Kafidul', 'M/S Al-Kafidul', 'M/S Al-Kafidul', '444444444444', 'companyavendor@gmail.com', 'sdafsda fasdf as fasf', '2022-07-21 07:12:38', '2022-07-21 07:12:38'),
(5, 1, NULL, 'Working Associate', 'Shohag', 'Shohag', 'Shohag', '+1 (481) 705-1026', 'companyavendor@gmail.com', 'asdsad', '2022-11-12 04:14:57', '2022-11-12 04:14:57'),
(6, 1, NULL, 'Working Associate', 'Alom', 'Alom', 'Alom', '444444444444', 'companyavendor@gmail.com', 'dfsdfs fsd f', '2022-11-12 14:48:58', '2022-11-12 14:48:58'),
(7, 1, NULL, 'Logistics Associate', 'aslam', 'Aslam', 'Aslam', '444444444444', 'companyavendor@gmail.com', 'Aslam', '2022-07-24 05:57:45', '2022-07-24 05:57:45'),
(8, 1, NULL, 'Material Supplier', 'crown-cement', 'Crown cement plc', 'Crown cement plc', '5555555555', 'crown@gmail.com', 'address', '2022-07-25 07:18:02', '2022-07-25 07:18:02'),
(9, 1, NULL, 'Material Supplier', 'gph-ispat', 'GPH ispat ltd', 'GPH ispat ltd', '99999999999', 'gph@gmail.com', 'address', '2022-07-25 07:29:31', '2022-07-25 07:29:31'),
(10, 1, NULL, 'Working Associate', 'testvendor', 'testvendor', 'testvendor', 'testvendor', 'testvendor@testvendor.com', 'testvendor', '2022-10-14 17:05:17', '2022-10-14 17:05:17'),
(12, 1, NULL, 'Logistics Associate', 'Tractor-101', 'Kader', 'mr dobir', '01715149279', NULL, 'Bhaluka, Mymensingh', '2022-11-13 10:33:05', '2022-11-13 10:33:05'),
(13, 1, NULL, 'Logistics Associate', 'T_01_naogaon', 'Mr Shoriful', 'Sakahawat', '01794581440', NULL, 'Naogaon', '2022-11-17 15:41:41', '2022-11-17 15:41:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_heads`
--
ALTER TABLE `budget_heads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_payments`
--
ALTER TABLE `cash_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_payment_items`
--
ALTER TABLE `cash_payment_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_requisitions`
--
ALTER TABLE `cash_requisitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_requisition_communications`
--
ALTER TABLE `cash_requisition_communications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_requisition_items`
--
ALTER TABLE `cash_requisition_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_vendor_payments`
--
ALTER TABLE `cash_vendor_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_consumptions`
--
ALTER TABLE `daily_consumptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_consumption_items`
--
ALTER TABLE `daily_consumption_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_expenses`
--
ALTER TABLE `daily_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_expense_items`
--
ALTER TABLE `daily_expense_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_uses`
--
ALTER TABLE `daily_uses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_use_items`
--
ALTER TABLE `daily_use_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_dates`
--
ALTER TABLE `gallery_dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_date_images`
--
ALTER TABLE `gallery_date_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistics_charges`
--
ALTER TABLE `logistics_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistics_charge_items`
--
ALTER TABLE `logistics_charge_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials_groups`
--
ALTER TABLE `materials_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_groups`
--
ALTER TABLE `material_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_issues`
--
ALTER TABLE `material_issues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_issue_items`
--
ALTER TABLE `material_issue_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_liftings`
--
ALTER TABLE `material_liftings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_lifting_materials`
--
ALTER TABLE `material_lifting_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_requisitions`
--
ALTER TABLE `material_requisitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_requisition_communications`
--
ALTER TABLE `material_requisition_communications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_requisition_items`
--
ALTER TABLE `material_requisition_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_units`
--
ALTER TABLE `material_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_vendor_payments`
--
ALTER TABLE `material_vendor_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_vendor_payment_invoices`
--
ALTER TABLE `material_vendor_payment_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_budget_wise_roas`
--
ALTER TABLE `project_budget_wise_roas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_towers`
--
ALTER TABLE `project_towers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_units`
--
ALTER TABLE `project_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_wise_budgets`
--
ALTER TABLE `project_wise_budgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_wise_budget_items`
--
ALTER TABLE `project_wise_budget_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_payment_items`
--
ALTER TABLE `supplier_payment_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_b_p_items`
--
ALTER TABLE `t_b_p_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_b_p_s`
--
ALTER TABLE `t_b_p_s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_configurations`
--
ALTER TABLE `unit_configurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_config_materials`
--
ALTER TABLE `unit_config_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_branches`
--
ALTER TABLE `user_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_projects`
--
ALTER TABLE `user_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_units`
--
ALTER TABLE `user_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `budget_heads`
--
ALTER TABLE `budget_heads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `cash_payments`
--
ALTER TABLE `cash_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_payment_items`
--
ALTER TABLE `cash_payment_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_requisitions`
--
ALTER TABLE `cash_requisitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cash_requisition_communications`
--
ALTER TABLE `cash_requisition_communications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cash_requisition_items`
--
ALTER TABLE `cash_requisition_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `cash_vendor_payments`
--
ALTER TABLE `cash_vendor_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `daily_consumptions`
--
ALTER TABLE `daily_consumptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `daily_consumption_items`
--
ALTER TABLE `daily_consumption_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `daily_expenses`
--
ALTER TABLE `daily_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_expense_items`
--
ALTER TABLE `daily_expense_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `daily_uses`
--
ALTER TABLE `daily_uses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `daily_use_items`
--
ALTER TABLE `daily_use_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery_dates`
--
ALTER TABLE `gallery_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery_date_images`
--
ALTER TABLE `gallery_date_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistics_charges`
--
ALTER TABLE `logistics_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `logistics_charge_items`
--
ALTER TABLE `logistics_charge_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `materials_groups`
--
ALTER TABLE `materials_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_groups`
--
ALTER TABLE `material_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_issues`
--
ALTER TABLE `material_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `material_issue_items`
--
ALTER TABLE `material_issue_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `material_liftings`
--
ALTER TABLE `material_liftings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `material_lifting_materials`
--
ALTER TABLE `material_lifting_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `material_requisitions`
--
ALTER TABLE `material_requisitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `material_requisition_communications`
--
ALTER TABLE `material_requisition_communications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_requisition_items`
--
ALTER TABLE `material_requisition_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_units`
--
ALTER TABLE `material_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `material_vendor_payments`
--
ALTER TABLE `material_vendor_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_vendor_payment_invoices`
--
ALTER TABLE `material_vendor_payment_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000002;

--
-- AUTO_INCREMENT for table `project_budget_wise_roas`
--
ALTER TABLE `project_budget_wise_roas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `project_towers`
--
ALTER TABLE `project_towers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `project_units`
--
ALTER TABLE `project_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `project_wise_budgets`
--
ALTER TABLE `project_wise_budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `project_wise_budget_items`
--
ALTER TABLE `project_wise_budget_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_payment_items`
--
ALTER TABLE `supplier_payment_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_b_p_items`
--
ALTER TABLE `t_b_p_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `t_b_p_s`
--
ALTER TABLE `t_b_p_s`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `unit_configurations`
--
ALTER TABLE `unit_configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `unit_config_materials`
--
ALTER TABLE `unit_config_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_branches`
--
ALTER TABLE `user_branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_projects`
--
ALTER TABLE `user_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_units`
--
ALTER TABLE `user_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
