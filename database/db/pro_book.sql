-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 10, 2022 at 08:15 PM
-- Server version: 5.7.33
-- PHP Version: 8.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pro_book`
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
  `address` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `company_id`, `branch_name`, `contact_person_name`, `contact_person_phone`, `address`, `created_at`, `updated_at`) VALUES
(5, 1, 'Head Office', 'Head Office', '00000', 'Head Office', '2022-07-11 17:56:08', '2022-07-11 17:56:08');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(84, 1, 'Cash', 'Rig machine', '2022-07-25 08:04:59', '2022-07-25 08:04:59');

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `remarks` text,
  `status` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cash_requisitions`
--

INSERT INTO `cash_requisitions` (`id`, `company_id`, `project_id`, `unit_config_id`, `tower_id`, `date`, `remarks`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 8, 3, '2022-10-09', NULL, 'Pending', 2, '2022-10-09 08:20:40', '2022-10-09 08:20:40');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cash_requisition_items`
--

CREATE TABLE `cash_requisition_items` (
  `id` int(11) NOT NULL,
  `cash_requisition_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `budget_head_id` int(11) NOT NULL,
  `requisition_amount` text NOT NULL,
  `approved_amount` text,
  `payment_status` int(11) NOT NULL DEFAULT '0',
  `paid_by` int(11) DEFAULT NULL,
  `payment_time` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cash_requisition_items`
--

INSERT INTO `cash_requisition_items` (`id`, `cash_requisition_id`, `vendor_id`, `budget_head_id`, `requisition_amount`, `approved_amount`, `payment_status`, `paid_by`, `payment_time`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 6, '800', NULL, 0, NULL, NULL, '2022-10-09 08:20:40', '2022-10-09 08:20:40'),
(2, 1, 10, 65, '5000', NULL, 0, NULL, NULL, '2022-10-09 08:20:40', '2022-10-09 08:20:40'),
(3, 1, 10, 74, '5000', NULL, 0, NULL, NULL, '2022-10-09 08:20:40', '2022-10-09 08:20:40');

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
  `logo` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `prefix`, `contact_person_name`, `phone`, `address`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Genex - S S JV', 'genex', 'genex', '0000000', 'Dhaka, Bangladesh', '', '2022-07-11 17:56:07', '2022-07-11 17:56:07');

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
  `truck_no` text,
  `issue_by_name` text,
  `receive_by_name` text,
  `date` text NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `received_by` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `daily_consumptions`
--

INSERT INTO `daily_consumptions` (`id`, `system_serial`, `project_id`, `unit_id`, `tower_id`, `logistics_associate_id`, `truck_no`, `issue_by_name`, `receive_by_name`, `date`, `company_id`, `created_by`, `received_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'genex000000', 2, 8, 12, 7, NULL, NULL, '322423', '2022-07-05', 1, 2, 2, 1, '2022-08-09 11:52:21', '2022-08-09 11:52:21'),
(2, 'genex000002', 2, 8, 12, 7, NULL, NULL, 'erwer', '2022-07-06', 1, 2, 2, 1, '2022-10-06 06:19:04', '2022-10-06 06:19:04'),
(3, 'genex000003', 2, 8, 12, 7, NULL, NULL, NULL, '2022-07-03', 1, 2, NULL, 0, '2022-07-30 05:33:20', '2022-07-30 05:33:20'),
(4, 'genex000004', 2, 8, 12, 7, NULL, NULL, 'adgdagdfsg', '2022-07-01', 1, 2, 2, 1, '2022-08-09 11:48:09', '2022-08-09 11:48:09'),
(5, 'genex000005', 2, 8, 12, 7, NULL, NULL, NULL, '2022-07-02', 1, 2, NULL, 0, '2022-07-30 05:33:17', '2022-07-30 05:33:17'),
(6, 'genex000006', 2, 8, 12, 7, NULL, NULL, NULL, '2022-06-27', 1, 2, NULL, 0, '2022-07-30 05:33:07', '2022-07-30 05:33:07'),
(7, 'genex000007', 2, 8, 12, 7, NULL, NULL, NULL, '2022-06-28', 1, 2, NULL, 0, '2022-07-30 05:33:10', '2022-07-30 05:33:10'),
(8, 'genex000008', 2, 8, 12, 7, NULL, NULL, NULL, '2022-07-21', 1, 2, NULL, 0, '2022-07-30 05:33:54', '2022-07-30 05:33:54'),
(9, 'genex000009', 2, 8, 12, 7, NULL, NULL, NULL, '2022-07-22', 1, 2, NULL, 0, '2022-07-30 05:33:35', '2022-07-30 05:33:35'),
(10, 'genex0000010', 2, 8, 12, 7, NULL, NULL, NULL, '2022-07-24', 1, 2, NULL, 0, '2022-07-30 05:34:13', '2022-07-30 05:34:13'),
(11, 'genex0000011', 2, 8, 12, 7, NULL, NULL, NULL, '2022-07-23', 1, 2, NULL, 0, '2022-07-30 05:34:11', '2022-07-30 05:34:11'),
(12, 'genex0000012', 2, 8, 12, 7, NULL, NULL, NULL, '2022-07-27', 1, 2, NULL, 0, '2022-07-30 05:34:16', '2022-07-30 05:34:16'),
(13, 'genex/lis/000013', 1, 8, 3, 7, '5345345', NULL, NULL, '2022-08-02', 1, 2, NULL, 0, '2022-08-03 18:17:58', '2022-08-03 18:17:58'),
(14, 'genex/lis/000014', 2, 8, 12, 7, '56', 'qweasd123', NULL, '2022-08-01', 1, 2, NULL, 0, '2022-08-08 08:15:33', '2022-08-08 08:15:33');

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `daily_consumption_items`
--

INSERT INTO `daily_consumption_items` (`id`, `daily_consumption_id`, `budget_head_id`, `consumption_qty`, `issue_qty`, `created_at`, `updated_at`) VALUES
(22, 6, 3, '3', '', '2022-07-30 05:33:07', '2022-07-30 05:33:07'),
(23, 7, 3, '1', '', '2022-07-30 05:33:10', '2022-07-30 05:33:10'),
(24, 4, 5, '100', '', '2022-08-09 11:51:53', '2022-08-09 11:51:53'),
(25, 4, 69, '4438', '', '2022-08-09 11:51:53', '2022-08-09 11:51:53'),
(26, 5, 5, '350', '', '2022-07-30 05:33:17', '2022-07-30 05:33:17'),
(27, 5, 69, '983', '', '2022-07-30 05:33:17', '2022-07-30 05:33:17'),
(28, 3, 5, '160', '', '2022-07-30 05:33:20', '2022-07-30 05:33:20'),
(29, 3, 3, '150', '', '2022-07-30 05:33:20', '2022-07-30 05:33:20'),
(30, 9, 4, '200', '', '2022-07-30 05:33:35', '2022-07-30 05:33:35'),
(31, 1, 4, '83', '', '2022-08-09 11:52:21', '2022-08-09 11:52:21'),
(32, 2, 4, '400', '', '2022-10-06 06:19:04', '2022-10-06 06:19:04'),
(33, 8, 3, '140', '', '2022-07-30 05:33:54', '2022-07-30 05:33:54'),
(34, 8, 5, '250', '', '2022-07-30 05:33:54', '2022-07-30 05:33:54'),
(35, 8, 4, '300', '', '2022-07-30 05:33:54', '2022-07-30 05:33:54'),
(36, 11, 69, '2367', '', '2022-07-30 05:34:11', '2022-07-30 05:34:11'),
(37, 10, 5, '350', '', '2022-07-30 05:34:13', '2022-07-30 05:34:13'),
(38, 12, 5, '200', '', '2022-07-30 05:34:16', '2022-07-30 05:34:16'),
(39, 12, 4, '200', '', '2022-07-30 05:34:16', '2022-07-30 05:34:16'),
(41, 13, 5, '10', '', '2022-08-03 18:18:03', '2022-08-03 18:18:03'),
(43, 14, 3, '2', '', '2022-08-08 08:15:33', '2022-08-08 08:15:33');

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
  `truck_no` text,
  `pile_no` text,
  `working_length` text,
  `site_engineer` text,
  `epc_engineer` text,
  `department_engineer` text,
  `date` text NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `daily_uses`
--

INSERT INTO `daily_uses` (`id`, `system_serial`, `project_id`, `unit_id`, `tower_id`, `logistics_associate_id`, `truck_no`, `pile_no`, `working_length`, `site_engineer`, `epc_engineer`, `department_engineer`, `date`, `company_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'genex000000', 2, 8, 12, NULL, NULL, 'C-2', NULL, 'Mr.Rifaz', 'Mr.Mizanur', 'Mr.Sanjay', '2022-07-26', 1, 2, '2022-07-29 17:31:17', '2022-07-29 17:31:17'),
(2, 'genex000002', 2, 8, 12, NULL, NULL, 'B-3', NULL, 'Mr.Rifaz', 'Mr.Sazzad', 'Mr.Rokey', '2022-07-23', 1, 2, '2022-07-29 17:31:57', '2022-07-29 17:31:57'),
(4, 'genex000003', 2, 8, 12, NULL, NULL, 'C-1', NULL, 'Mr.Rifaz', 'Mr.Sujon', 'Mr.Sanjay', '2022-07-25', 1, 2, '2022-07-29 17:31:26', '2022-07-29 17:31:26'),
(5, 'genex000004', 2, 8, 12, NULL, NULL, 'B-4', NULL, 'Mr.Rifaz', 'Mr.Sujon', 'Mr.Rokey', '2022-07-24', 1, 2, '2022-07-29 17:31:47', '2022-07-29 17:31:47'),
(6, 'genex/du/00005', 2, 8, 12, 7, 'sdf', 'asdf', NULL, 'kljfa', 'jklh', 'kjg', '2022-07-29', 1, 2, '2022-07-31 11:23:11', '2022-07-31 11:23:11'),
(8, 'genex/du/00006', 2, 8, 12, 7, '34', 'C-2', '28', NULL, 'Mr.Sazzad', 'Mr.Sanjay', '2022-08-01', 1, 2, '2022-07-31 18:35:32', '2022-07-31 18:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `daily_use_items`
--

CREATE TABLE `daily_use_items` (
  `id` int(11) NOT NULL,
  `daily_use_id` int(11) NOT NULL,
  `budget_head_id` int(11) NOT NULL,
  `use_qty` text NOT NULL,
  `remarks` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `daily_use_items`
--

INSERT INTO `daily_use_items` (`id`, `daily_use_id`, `budget_head_id`, `use_qty`, `remarks`, `created_at`, `updated_at`) VALUES
(28, 1, 5, '180', NULL, '2022-07-29 17:31:17', '2022-07-29 17:31:17'),
(29, 1, 4, '120', NULL, '2022-07-29 17:31:17', '2022-07-29 17:31:17'),
(30, 1, 3, '54', NULL, '2022-07-29 17:31:17', '2022-07-29 17:31:17'),
(31, 4, 5, '180', NULL, '2022-07-29 17:31:26', '2022-07-29 17:31:26'),
(32, 4, 4, '120', NULL, '2022-07-29 17:31:26', '2022-07-29 17:31:26'),
(33, 4, 3, '53', NULL, '2022-07-29 17:31:26', '2022-07-29 17:31:26'),
(34, 5, 5, '180', NULL, '2022-07-29 17:31:47', '2022-07-29 17:31:47'),
(35, 5, 4, '120', NULL, '2022-07-29 17:31:47', '2022-07-29 17:31:47'),
(36, 5, 3, '41', NULL, '2022-07-29 17:31:47', '2022-07-29 17:31:47'),
(37, 2, 5, '205', NULL, '2022-07-29 17:31:57', '2022-07-29 17:31:57'),
(38, 2, 4, '135', NULL, '2022-07-29 17:31:57', '2022-07-29 17:31:57'),
(39, 2, 3, '55', NULL, '2022-07-29 17:31:57', '2022-07-29 17:31:57'),
(40, 6, 3, '1', '1', '2022-07-31 11:23:11', '2022-07-31 11:23:11'),
(41, 6, 4, '1', '2', '2022-07-31 11:23:11', '2022-07-31 11:23:11'),
(42, 6, 5, '1', '3', '2022-07-31 11:23:11', '2022-07-31 11:23:11'),
(49, 8, 3, '5', 'qwe', '2022-07-31 18:35:39', '2022-07-31 18:35:39'),
(50, 8, 4, '2', 'asd', '2022-07-31 18:35:39', '2022-07-31 18:35:39'),
(51, 8, 5, '5', 'zxc', '2022-07-31 18:35:39', '2022-07-31 18:35:39');

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
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `company_id`, `title`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kaliakoir - Mymensingh 400kv line', 2, '2022-07-17 08:33:17', '2022-07-17 08:33:17'),
(2, 1, 'Bogra to Kaliakoir 400kv double circuit line', 2, '2022-07-17 08:35:50', '2022-07-17 08:35:50');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gallery_dates`
--

INSERT INTO `gallery_dates` (`id`, `gallery_id`, `date`, `created_at`, `updated_at`) VALUES
(2, 1, '09-07-2022', '2022-07-30 05:34:23', '2022-07-30 05:34:23');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logistics_charges`
--

INSERT INTO `logistics_charges` (`id`, `company_id`, `project_id`, `general_transportation_charge`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '10', 2, '2022-07-18 09:43:16', '2022-07-18 09:43:16');

-- --------------------------------------------------------

--
-- Table structure for table `logistics_charge_items`
--

CREATE TABLE `logistics_charge_items` (
  `id` int(11) NOT NULL,
  `logistics_charge_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `material_rate` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logistics_charge_items`
--

INSERT INTO `logistics_charge_items` (`id`, `logistics_charge_id`, `material_id`, `material_rate`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '9.17', '2022-07-18 09:43:16', '2022-07-18 09:43:16'),
(2, 1, 3, '9.17', '2022-07-18 09:43:16', '2022-07-18 09:43:16'),
(3, 1, 5, '10', '2022-07-18 09:43:16', '2022-07-18 09:43:16'),
(4, 1, 56, '0', '2022-07-18 09:43:16', '2022-07-18 09:43:16'),
(5, 1, 57, '1', '2022-07-18 09:43:16', '2022-07-18 09:43:16'),
(6, 1, 58, '1', '2022-07-18 09:43:16', '2022-07-18 09:43:16'),
(7, 1, 59, '1', '2022-07-18 09:43:16', '2022-07-18 09:43:16'),
(8, 1, 60, '1', '2022-07-18 09:43:16', '2022-07-18 09:43:16'),
(9, 1, 61, '1', '2022-07-18 09:43:16', '2022-07-18 09:43:16');

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
  `transportation_charge` int(11) NOT NULL DEFAULT '0',
  `show_dashboard` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `company_id`, `name`, `code`, `unit`, `transportation_charge`, `show_dashboard`, `created_at`, `updated_at`) VALUES
(2, 0, 'Cement', 'Cement', 8, 1, 1, '2022-05-24 04:09:40', '2022-03-05 16:33:53'),
(3, 0, 'Sand', 'Sand', 1, 1, 1, '2022-05-24 04:09:41', '2022-03-05 17:56:32'),
(5, 0, 'Stone', 'Stone', 1, 1, 1, '2022-05-24 04:09:46', '2022-03-05 17:57:23'),
(56, 1, 'Vitti Sand', 'vitti-sand', 1, 1, 0, '2022-07-18 08:46:50', '2022-07-18 08:46:50'),
(57, 1, 'Rebar 5\"', 'rebar5', 10, 1, 0, '2022-07-18 08:54:19', '2022-07-18 08:54:19'),
(58, 1, 'Rebar 10\"', 'rebar10', 10, 1, 0, '2022-07-18 08:54:42', '2022-07-18 08:54:42'),
(59, 1, 'Rebar 16\"', 'rebar16', 10, 1, 0, '2022-07-18 08:55:02', '2022-07-18 08:55:02'),
(60, 1, 'Rebar 20\"', 'rebar20', 10, 1, 0, '2022-07-18 08:55:36', '2022-07-18 08:55:36'),
(61, 1, 'Rebar 25\"', 'rebar25', 10, 1, 0, '2022-07-18 08:55:58', '2022-07-18 08:55:58'),
(62, 1, 'Rebar 8\"', 'rebar8', 10, 0, 0, '2022-07-21 09:26:48', '2022-07-21 09:26:48'),
(63, 1, 'Rebar 12\"', 'rebar-12', 10, 0, 0, '2022-07-25 07:51:13', '2022-07-25 07:51:13');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `material_groups`
--

CREATE TABLE `material_groups` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `material_issues`
--

INSERT INTO `material_issues` (`id`, `company_id`, `system_serial`, `source_project_id`, `source_unit_id`, `source_tower_id`, `project_id`, `unit_id`, `tower_id`, `logistics_associate`, `issue_date`, `issue_to`, `truck_no`, `status`, `created_by`, `received_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'genex/is/00001', 1, 8, 3, 2, 8, 12, 7, '2022-08-08', 'cbhgf', 'sdfsdfsdf', 'Received', 2, 4, '2022-08-08 08:36:40', '2022-08-08 08:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `material_issue_items`
--

CREATE TABLE `material_issue_items` (
  `id` int(11) NOT NULL,
  `material_issue_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `material_qty` int(11) NOT NULL,
  `receive_qty` decimal(10,0) DEFAULT '0',
  `material_rate` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `material_issue_items`
--

INSERT INTO `material_issue_items` (`id`, `material_issue_id`, `material_id`, `material_qty`, `receive_qty`, `material_rate`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 7, '7', 0, NULL, '2022-08-08 08:52:11');

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
  `truck_no` text,
  `vouchar_date` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `material_liftings`
--

INSERT INTO `material_liftings` (`id`, `company_id`, `system_serial`, `lifting_type`, `vendor_id`, `logistics_vendor`, `project_id`, `unit_id`, `tower_id`, `voucher`, `truck_no`, `vouchar_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'genex000000', 'Local Lifting To Project', 2, NULL, 2, 8, 12, 'KEC', NULL, '2022-05-24', '2022-07-21 07:01:53', '2022-07-21 07:04:22'),
(2, 1, 'genex000002', 'Local Lifting To Project', 2, NULL, 2, 8, 12, 'KEC', NULL, '2022-05-26', '2022-07-21 07:02:44', '2022-07-21 07:02:44'),
(3, 1, 'genex000003', 'Local Lifting To Project', 2, NULL, 2, 8, 12, 'KEC', NULL, '2022-05-27', '2022-07-21 07:03:20', '2022-07-21 07:03:20'),
(4, 1, 'genex000004', 'Local Lifting To Project', 2, NULL, 2, 8, 12, 'AAC(Manik)', NULL, '2022-06-05', '2022-07-21 07:04:14', '2022-07-21 07:04:14'),
(5, 1, 'genex000005', 'Local Lifting To Project', 2, NULL, 2, 8, 12, 'KEC', NULL, '2022-06-06', '2022-07-21 07:04:58', '2022-07-21 07:04:58'),
(6, 1, 'genex000006', 'Local Lifting To Project', 2, NULL, 2, 8, 12, 'KEC', NULL, '2022-06-10', '2022-07-21 07:07:25', '2022-07-21 07:07:25'),
(7, 1, 'genex000007', 'Local Lifting To Project', 2, NULL, 2, 8, 12, '10312', NULL, '2022-06-28', '2022-07-21 07:08:09', '2022-07-21 07:08:09'),
(11, 1, 'genex000008', 'Local Lifting To Project', 3, NULL, 2, 8, 12, '5958', NULL, '2022-05-24', '2022-07-21 07:15:17', '2022-07-21 07:15:17'),
(12, 1, 'genex000009', 'Local Lifting To Project', 4, NULL, 2, 8, 12, '350', NULL, '2022-06-01', '2022-07-21 07:16:50', '2022-07-21 07:16:50'),
(13, 1, 'genex0000010', 'Local Lifting To Project', 5, NULL, 2, 8, 12, '010', NULL, '2022-06-02', '2022-07-21 07:17:35', '2022-07-21 07:17:35'),
(14, 1, 'genex0000011', 'Local Lifting To Project', 4, NULL, 2, 8, 12, '011', NULL, '2022-06-03', '2022-07-21 07:18:25', '2022-07-21 07:18:25'),
(15, 1, 'genex0000012', 'Local Lifting To Project', 5, NULL, 2, 8, 12, '012', NULL, '2022-06-07', '2022-07-21 07:19:42', '2022-07-21 07:19:42'),
(16, 1, 'genex0000013', 'Local Lifting To Project', 5, NULL, 2, 8, 12, '013', NULL, '2022-06-08', '2022-07-21 07:20:27', '2022-07-21 07:20:27'),
(17, 1, 'genex0000014', 'Local Lifting To Project', 5, NULL, 2, 8, 12, '014', NULL, '2022-06-07', '2022-07-21 07:22:38', '2022-07-21 07:22:38'),
(18, 1, 'genex0000015', 'Local Lifting To Project', 5, NULL, 2, 8, 12, '015', NULL, '2022-06-13', '2022-07-21 07:23:40', '2022-07-21 07:23:40'),
(19, 1, 'genex0000016', 'Local Lifting To Project', 5, NULL, 2, 8, 12, '016', NULL, '2022-06-13', '2022-07-21 07:24:28', '2022-07-21 07:24:28'),
(20, 1, 'genex0000017', 'Local Lifting To Project', 5, NULL, 2, 8, 12, '017', NULL, '2022-06-20', '2022-07-21 07:25:05', '2022-07-21 07:25:05'),
(21, 1, 'genex0000018', 'Local Lifting To Project', 5, NULL, 2, 8, 12, '018', NULL, '2022-07-01', '2022-07-21 07:25:50', '2022-07-21 07:25:50'),
(22, 1, 'genex0000019', 'Local Lifting To Project', 6, NULL, 2, 8, 12, '019', NULL, '2022-04-22', '2022-07-21 09:02:33', '2022-07-21 09:02:33'),
(23, 1, 'genex0000020', 'Local Lifting To Project', 6, NULL, 2, 8, 12, '020', NULL, '2022-05-26', '2022-07-21 09:04:26', '2022-07-21 09:04:26'),
(24, 1, 'genex0000021', 'Local Lifting To Project', 6, NULL, 2, 8, 12, '021', NULL, '2022-06-02', '2022-07-21 09:04:58', '2022-07-21 09:04:58'),
(25, 1, 'genex0000022', 'Local Lifting To Project', 6, NULL, 2, 8, 12, '022', NULL, '2022-06-03', '2022-07-21 09:06:36', '2022-07-21 09:06:36'),
(26, 1, 'genex0000023', 'Local Lifting To Project', 6, NULL, 2, 8, 12, '023', NULL, '2022-06-08', '2022-07-21 09:08:42', '2022-07-21 09:08:42'),
(27, 1, 'genex0000024', 'Local Lifting To Project', 6, NULL, 2, 8, 12, '024', NULL, '2022-06-09', '2022-07-21 09:09:51', '2022-07-21 09:09:51'),
(28, 1, 'genex0000025', 'Local Lifting To Project', 6, NULL, 2, 8, 12, '025', NULL, '2022-06-17', '2022-07-21 09:10:50', '2022-07-21 09:10:50'),
(29, 1, 'genex0000026', 'Local Lifting To Project', 6, NULL, 2, 8, 12, '540', NULL, '2022-07-05', '2022-07-21 09:13:35', '2022-07-21 09:13:35'),
(30, 1, 'genex0000027', 'Local Lifting To Project', 6, NULL, 2, 8, 12, '293', NULL, '2022-07-06', '2022-07-21 09:16:29', '2022-07-21 09:16:29'),
(31, 1, 'genex0000028', 'Client Provide To Project', NULL, NULL, 2, 8, 12, '028', NULL, '2022-04-25', '2022-07-21 09:27:16', '2022-07-21 09:27:16'),
(32, 1, 'genex0000029', 'Client Provide To Project', NULL, NULL, 2, 8, 12, '10247', NULL, '2022-06-17', '2022-07-21 09:28:46', '2022-07-21 09:28:46'),
(33, 1, 'genex0000030', 'Client Provide To Project', NULL, NULL, 2, 8, 12, '030', NULL, '2022-06-11', '2022-07-21 09:30:00', '2022-07-21 09:30:00'),
(34, 1, 'genex0000031', 'Client Provide To Project', NULL, NULL, 2, 8, 12, '10315', NULL, '2022-06-30', '2022-07-21 09:31:30', '2022-07-21 09:31:30'),
(35, 1, 'genex0000032', 'Client Provide To Project', NULL, NULL, 2, 8, 12, '55', NULL, '2022-07-01', '2022-07-21 09:33:25', '2022-07-21 09:33:25'),
(37, 1, 'genex0000033', 'Local Lifting To Project', 3, NULL, 1, 8, 3, '6924', 'D.M.T 18-0372', '2022-04-07', '2022-07-25 05:56:31', '2022-07-25 05:57:31'),
(38, 1, 'genex0000034', 'Local Lifting To Project', 3, NULL, 1, 8, 3, '6940', 'D.M.T 18-4400', '2022-04-11', '2022-07-25 05:59:13', '2022-07-25 05:59:13'),
(39, 1, 'genex0000035', 'Local Lifting To Project', 3, NULL, 1, 8, 3, '5352', 'D.M.T 24-1153', '2022-04-15', '2022-07-25 06:00:17', '2022-07-25 06:00:17'),
(40, 1, 'genex0000036', 'Local Lifting To Project', 3, NULL, 1, 8, 3, '5362', 'D.M.T 24-3805', '2022-04-18', '2022-07-25 06:01:56', '2022-07-25 06:01:56'),
(41, 1, 'genex0000037', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '323', 'D.M.T 22-0562', '2022-04-18', '2022-07-25 06:03:23', '2022-07-25 06:03:23'),
(42, 1, 'genex0000038', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '327', 'D.M.T 20-8383', '2022-04-21', '2022-07-25 06:04:32', '2022-07-25 06:04:32'),
(43, 1, 'genex0000039', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '326', 'CTG.M.T11-9759', '2022-04-21', '2022-07-25 06:05:37', '2022-07-25 06:05:37'),
(44, 1, 'genex0000040', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '332', NULL, '2022-04-27', '2022-07-25 06:06:48', '2022-07-25 06:06:48'),
(45, 1, 'genex0000041', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '333', 'D.M.TA-24-5789', '2022-05-13', '2022-07-25 06:08:32', '2022-07-25 06:08:32'),
(46, 1, 'genex0000042', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '344', NULL, '2022-05-22', '2022-07-25 06:10:17', '2022-07-25 06:10:17'),
(47, 1, 'genex0000043', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '348', 'D.M.TA-18-6045', '2022-05-28', '2022-07-25 06:11:30', '2022-07-25 06:11:30'),
(48, 1, 'genex0000044', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '345', 'D.M.TA-24-380', '2022-05-28', '2022-07-25 06:12:35', '2022-07-25 06:12:35'),
(49, 1, 'genex0000045', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '346', 'D.M.T 24-3805', '2022-06-01', '2022-07-25 06:14:29', '2022-07-25 06:14:29'),
(50, 1, 'genex0000046', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '335', 'D.M.TA-15-9251', '2022-06-01', '2022-07-25 06:16:32', '2022-07-25 06:16:32'),
(51, 1, 'genex0000047', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '350', 'D.M.TA-22-7013', '2022-06-04', '2022-07-25 06:18:05', '2022-07-25 06:18:05'),
(52, 1, 'genex0000048', 'Local Lifting To Project', 5, NULL, 1, 8, 3, '048', NULL, '2022-06-06', '2022-07-25 06:20:11', '2022-07-25 06:20:11'),
(53, 1, 'genex0000049', 'Local Lifting To Project', 4, NULL, 1, 8, 3, '345', 'D.M.TA.24-4399', '2022-06-08', '2022-07-25 06:21:41', '2022-07-25 06:21:41'),
(54, 1, 'genex0000050', 'Local Lifting To Project', NULL, NULL, 1, 8, 3, '050', NULL, '2022-06-09', '2022-07-25 06:23:02', '2022-07-25 06:23:02'),
(55, 1, 'genex0000051', 'Local Lifting To Project', 3, NULL, 1, 8, 3, '5153', 'D.M.TA.15-8820', '2022-06-12', '2022-07-25 06:24:13', '2022-07-25 06:24:13'),
(56, 1, 'genex0000052', 'Local Lifting To Project', 5, NULL, 1, 8, 3, '052', NULL, '2022-06-13', '2022-07-25 06:25:07', '2022-07-25 06:25:07'),
(57, 1, 'genex0000053', 'Local Lifting To Project', 5, NULL, 1, 8, 3, '053', NULL, '2022-06-23', '2022-07-25 06:26:47', '2022-07-25 06:26:47'),
(58, 1, 'genex0000054', 'Local Lifting To Project', 5, NULL, 1, 8, 3, '054', NULL, '2022-06-25', '2022-07-25 06:28:49', '2022-07-25 06:28:49'),
(59, 1, 'genex0000055', 'Local Lifting To Project', 5, NULL, 1, 8, 3, '055', NULL, '2022-06-28', '2022-07-25 06:30:34', '2022-07-25 06:30:34'),
(60, 1, 'genex0000056', 'Local Lifting To Project', 5, NULL, 1, 8, 3, '056', NULL, '2022-06-30', '2022-07-25 06:32:29', '2022-07-25 06:32:29'),
(61, 1, 'genex0000057', 'Local Lifting To Project', 5, NULL, 1, 8, 3, '057', NULL, '2022-07-04', '2022-07-25 06:34:19', '2022-07-25 06:34:19'),
(62, 1, 'genex0000058', 'Local Lifting To Project', 5, NULL, 1, 8, 3, '058', NULL, '2022-07-06', '2022-07-25 06:35:25', '2022-07-25 06:35:25'),
(64, 1, 'genex0000059', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '059', NULL, '2022-04-09', '2022-07-25 06:43:51', '2022-07-25 06:43:51'),
(65, 1, 'genex0000060', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '060', NULL, '2022-04-10', '2022-07-25 06:44:35', '2022-07-25 06:44:35'),
(66, 1, 'genex0000061', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '061', NULL, '2022-04-14', '2022-07-25 06:45:13', '2022-07-25 06:45:13'),
(67, 1, 'genex0000062', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '062', NULL, '2022-04-15', '2022-07-25 06:47:56', '2022-07-25 06:47:56'),
(68, 1, 'genex0000063', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '063', NULL, '2022-04-18', '2022-07-25 06:49:44', '2022-07-25 06:49:44'),
(69, 1, 'genex0000064', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '064', NULL, '2022-04-27', '2022-07-25 06:50:32', '2022-07-25 06:50:32'),
(70, 1, 'genex0000065', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '065', NULL, '2022-04-28', '2022-07-25 06:51:35', '2022-07-25 06:51:35'),
(71, 1, 'genex0000066', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '066', NULL, '2022-05-15', '2022-07-25 06:52:49', '2022-07-25 06:52:49'),
(72, 1, 'genex0000067', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '067', NULL, '2022-05-21', '2022-07-25 06:53:49', '2022-07-25 06:53:49'),
(73, 1, 'genex0000068', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '068', NULL, '2022-05-27', '2022-07-25 06:55:30', '2022-07-25 06:55:30'),
(74, 1, 'genex0000069', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '069', NULL, '2022-05-28', '2022-07-25 06:56:21', '2022-07-25 06:56:21'),
(75, 1, 'genex0000070', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '070', NULL, '2022-05-31', '2022-07-25 06:57:04', '2022-07-25 06:57:04'),
(76, 1, 'genex0000071', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '071', NULL, '2022-06-03', '2022-07-25 06:57:49', '2022-07-25 06:57:49'),
(77, 1, 'genex0000072', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '072', NULL, '2022-06-06', '2022-07-25 06:59:44', '2022-07-25 06:59:44'),
(78, 1, 'genex0000073', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '073', NULL, '2022-06-08', '2022-07-25 07:00:50', '2022-07-25 07:00:50'),
(79, 1, 'genex0000074', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '074', NULL, '2022-06-15', '2022-07-25 07:02:09', '2022-07-25 07:02:09'),
(80, 1, 'genex0000075', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '075', NULL, '2022-06-23', '2022-07-25 07:03:26', '2022-07-25 07:03:26'),
(81, 1, 'genex0000076', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '076', NULL, '2022-06-24', '2022-07-25 07:04:16', '2022-07-25 07:04:16'),
(82, 1, 'genex0000077', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '077', NULL, '2022-07-02', '2022-07-25 07:05:18', '2022-07-25 07:05:18'),
(83, 1, 'genex0000078', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '078', NULL, '2022-07-02', '2022-07-25 07:05:54', '2022-07-25 07:05:54'),
(84, 1, 'genex0000079', 'Local Lifting To Project', 6, NULL, 1, 8, 3, '079', NULL, '2022-07-05', '2022-07-25 07:06:52', '2022-07-25 07:06:52'),
(85, 1, 'genex0000080', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '1071572', 'D.M-u-11-1839', '2022-04-09', '2022-07-25 07:10:25', '2022-07-25 07:10:25'),
(86, 1, 'genex0000081', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '1075384', 'D.M.-u-14-0743', '2022-04-15', '2022-07-25 07:11:13', '2022-07-25 07:11:13'),
(87, 1, 'genex0000082', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '1078682', 'D.M-u-11-1834', '2022-04-18', '2022-07-25 07:12:35', '2022-07-25 07:12:35'),
(88, 1, 'genex0000083', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '1080732', 'D.M-u-11-2084', '2022-04-21', '2022-07-25 07:13:24', '2022-07-25 07:13:24'),
(89, 1, 'genex0000084', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '084', NULL, '2022-04-28', '2022-07-25 07:17:33', '2022-07-25 07:17:33'),
(90, 1, 'genex0000085', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '213817', 'D.M-u-11-1495', '2022-05-08', '2022-07-25 07:19:00', '2022-07-25 07:19:00'),
(91, 1, 'genex0000086', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '218041', 'D.M-u-11-1023', '2022-05-26', '2022-07-25 07:19:45', '2022-07-25 07:19:45'),
(92, 1, 'genex0000087', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '219521', 'D.M-U-11-1914', '2022-06-01', '2022-07-25 07:20:51', '2022-07-25 07:20:51'),
(93, 1, 'genex0000088', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '220106', 'D.M-U-11-1023', '2022-06-03', '2022-07-25 07:21:49', '2022-07-25 07:21:49'),
(94, 1, 'genex0000089', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '220794', 'D.M-u-11-3601', '2022-06-06', '2022-07-25 07:23:08', '2022-07-25 07:23:08'),
(95, 1, 'genex0000090', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '222079', 'D.M-u-11-1837', '2022-06-11', '2022-07-25 07:24:07', '2022-07-25 07:24:07'),
(96, 1, 'genex0000091', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '220628', 'DMT-11-1914', '2022-06-21', '2022-07-25 07:24:55', '2022-07-25 07:24:55'),
(97, 1, 'genex0000092', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '226287', 'DMT-11-1914', '2022-06-27', '2022-07-25 07:25:48', '2022-07-25 07:25:48'),
(98, 1, 'genex0000093', 'Local Lifting To Project', 8, NULL, 1, 8, 3, '745', 'DMT-11-1023', '2022-07-04', '2022-07-25 07:26:55', '2022-07-25 07:26:55'),
(99, 1, 'genex0000094', 'Client Provide To Project', NULL, NULL, 1, 8, 3, '8100033332', 'CM-U-11-0487', '2022-04-04', '2022-07-25 07:45:49', '2022-07-25 07:45:49'),
(100, 1, 'genex0000095', 'Client Provide To Project', NULL, NULL, 1, 8, 3, '8100033325', 'CM-U-11-0851', '2022-04-04', '2022-07-25 07:47:09', '2022-07-25 07:47:09'),
(101, 1, 'genex0000096', 'Client Provide To Project', NULL, NULL, 1, 8, 3, '8100033324', 'CM-U-110848', '2022-04-04', '2022-07-25 07:47:50', '2022-07-25 07:47:50'),
(102, 1, 'genex0000097', 'Client Provide To Project', NULL, NULL, 1, 8, 3, '8100033394', 'CM-U-11-0848', '2022-04-05', '2022-07-25 07:48:32', '2022-07-25 07:48:32'),
(103, 1, 'genex0000098', 'Client Provide To Project', NULL, NULL, 1, 8, 3, '8100033322', 'CM-U-11-0842', '2022-04-05', '2022-07-25 07:50:07', '2022-07-25 07:50:07'),
(104, 1, 'genex0000099', 'Client Provide To Project', NULL, NULL, 1, 8, 3, '099', 'Tractor', '2022-07-02', '2022-07-25 07:51:43', '2022-07-25 07:51:43');

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
  `remarks` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `material_lifting_materials`
--

INSERT INTO `material_lifting_materials` (`id`, `material_lifting_id`, `material_id`, `unit_id`, `material_qty`, `material_rate`, `remarks`, `created_at`, `updated_at`) VALUES
(2, 2, 2, 8, '130', 400, NULL, NULL, NULL),
(3, 3, 2, 8, '130', 400, NULL, NULL, NULL),
(4, 4, 2, 8, '110', 400, NULL, NULL, NULL),
(5, 1, 2, 8, '140', 400, NULL, NULL, NULL),
(6, 5, 2, 8, '400', 400, NULL, NULL, NULL),
(7, 6, 2, 8, '400', 400, NULL, NULL, NULL),
(8, 7, 2, 8, '450', 400, NULL, NULL, NULL),
(12, 11, 5, 1, '575', 230, NULL, NULL, NULL),
(13, 12, 5, 1, '578', 230, NULL, NULL, NULL),
(14, 13, 5, 1, '563', 230, NULL, NULL, NULL),
(15, 14, 5, 1, '450', 230, NULL, NULL, NULL),
(16, 15, 5, 1, '578', 230, NULL, NULL, NULL),
(17, 16, 5, 1, '611', 230, NULL, NULL, NULL),
(18, 17, 5, 1, '578', 230, NULL, NULL, NULL),
(19, 18, 5, 1, '559', 230, NULL, NULL, NULL),
(20, 19, 5, 1, '537', 230, NULL, NULL, NULL),
(21, 20, 5, 1, '351', 230, NULL, NULL, NULL),
(22, 21, 5, 1, '875', 230, NULL, NULL, NULL),
(23, 22, 3, 1, '633', 50, NULL, NULL, NULL),
(24, 23, 3, 1, '638', 50, NULL, NULL, NULL),
(25, 24, 3, 1, '640', 50, NULL, NULL, NULL),
(26, 25, 3, 1, '627', 50, NULL, NULL, NULL),
(27, 26, 3, 1, '630', 50, NULL, NULL, NULL),
(28, 27, 3, 1, '631', 50, NULL, NULL, NULL),
(29, 28, 3, 1, '619', 50, NULL, NULL, NULL),
(30, 29, 3, 1, '183', 50, NULL, NULL, NULL),
(31, 30, 3, 1, '943', 50, NULL, NULL, NULL),
(32, 31, 60, 10, '11482', 0, NULL, NULL, NULL),
(33, 31, 62, 10, '1705', 0, NULL, NULL, NULL),
(34, 32, 62, 10, '1801', 0, NULL, NULL, NULL),
(35, 32, 60, 10, '10077', 0, NULL, NULL, NULL),
(36, 33, 62, 10, '2068', 0, NULL, NULL, NULL),
(37, 33, 60, 10, '6036', 0, NULL, NULL, NULL),
(38, 34, 60, 10, '8184', 0, NULL, NULL, NULL),
(39, 35, 62, 10, '3839', 0, NULL, NULL, NULL),
(42, 37, 5, 1, '479', 220, NULL, NULL, NULL),
(43, 38, 5, 1, '609', 220, 'challan 634', NULL, NULL),
(44, 39, 5, 1, '541', 220, 'chalan 571', NULL, NULL),
(45, 40, 5, 1, '627', 220, 'chalan 659', NULL, NULL),
(46, 41, 5, 1, '614', 220, 'challan 640', NULL, NULL),
(47, 42, 5, 1, '636.5', 220, 'cha', NULL, NULL),
(48, 43, 5, 1, '633.5', 220, 'challan 653', NULL, NULL),
(49, 44, 5, 1, '614', 220, 'chalan 626', NULL, NULL),
(50, 45, 5, 1, '581', 220, 'challan 603', NULL, NULL),
(51, 46, 5, 1, '591', 220, 'chalan 603', NULL, NULL),
(52, 47, 5, 1, '614', 220, 'challan 646', NULL, NULL),
(53, 48, 5, 1, '622', 220, 'chalan 654', NULL, NULL),
(54, 49, 5, 1, '644', 220, 'challan 659', NULL, NULL),
(55, 50, 5, 1, '612', 220, 'chalan 650', NULL, NULL),
(56, 51, 5, 1, '630', 220, 'chalan 648', NULL, NULL),
(57, 52, 5, 1, '547', 220, NULL, NULL, NULL),
(58, 53, 5, 1, '580', 220, 'chalan 643', NULL, NULL),
(59, 54, 5, 1, '569', 220, 'chalan 569', NULL, NULL),
(60, 55, 5, 1, '606', 220, 'challan 640', NULL, NULL),
(61, 56, 5, 1, '405', 220, 'challan 405', NULL, NULL),
(62, 57, 5, 1, '613', 220, NULL, NULL, NULL),
(63, 58, 5, 1, '465', 220, NULL, NULL, NULL),
(64, 59, 5, 1, '528', 220, NULL, NULL, NULL),
(65, 60, 5, 1, '586', 220, NULL, NULL, NULL),
(66, 61, 5, 1, '585', 220, NULL, NULL, NULL),
(67, 62, 5, 1, '638', 220, NULL, NULL, NULL),
(71, 66, 3, 1, '637', 45, NULL, NULL, NULL),
(72, 64, 3, 1, '618', 45, NULL, NULL, NULL),
(73, 65, 3, 1, '627', 45, NULL, NULL, NULL),
(74, 67, 3, 1, '643', 45, NULL, NULL, NULL),
(75, 68, 3, 1, '633', 45, NULL, NULL, NULL),
(76, 69, 3, 1, '120', 45, NULL, NULL, NULL),
(77, 70, 3, 1, '260', 45, NULL, NULL, NULL),
(78, 71, 3, 1, '701', 45, NULL, NULL, NULL),
(79, 72, 3, 1, '655', 45, NULL, NULL, NULL),
(80, 73, 3, 1, '653', 45, NULL, NULL, NULL),
(81, 74, 3, 1, '625', 45, NULL, NULL, NULL),
(82, 75, 3, 1, '521', 45, NULL, NULL, NULL),
(83, 76, 3, 1, '656', 45, NULL, NULL, NULL),
(84, 77, 3, 1, '565', 45, NULL, NULL, NULL),
(85, 78, 3, 1, '584', 45, NULL, NULL, NULL),
(86, 79, 3, 1, '617', 45, NULL, NULL, NULL),
(87, 80, 3, 1, '585', 45, NULL, NULL, NULL),
(88, 81, 3, 1, '582', 45, NULL, NULL, NULL),
(89, 82, 3, 1, '688', 45, NULL, NULL, NULL),
(90, 83, 3, 1, '632', 45, NULL, NULL, NULL),
(91, 84, 3, 1, '668', 45, NULL, NULL, NULL),
(92, 85, 2, 8, '300', 470, NULL, NULL, NULL),
(93, 86, 2, 8, '300', 470, NULL, NULL, NULL),
(94, 87, 2, 8, '200', 470, NULL, NULL, NULL),
(95, 88, 2, 8, '300', 470, NULL, NULL, NULL),
(96, 89, 2, 8, '134', 470, NULL, NULL, NULL),
(97, 90, 2, 8, '300', 470, NULL, NULL, NULL),
(98, 91, 2, 8, '300', 470, NULL, NULL, NULL),
(99, 92, 2, 8, '300', 470, NULL, NULL, NULL),
(100, 93, 2, 8, '300', 470, NULL, NULL, NULL),
(101, 94, 2, 8, '300', 470, NULL, NULL, NULL),
(102, 95, 2, 8, '300', 470, NULL, NULL, NULL),
(103, 96, 2, 8, '300', 470, NULL, NULL, NULL),
(104, 97, 2, 8, '300', 470, NULL, NULL, NULL),
(105, 98, 2, 8, '300', 470, NULL, NULL, NULL),
(106, 99, 59, 10, '18500', 0, NULL, NULL, NULL),
(107, 100, 62, 10, '500', 0, NULL, NULL, NULL),
(108, 100, 59, 10, '6500', 0, NULL, NULL, NULL),
(109, 100, 60, 10, '11000', 0, NULL, NULL, NULL),
(110, 101, 59, 10, '13000', 0, NULL, NULL, NULL),
(111, 102, 59, 10, '5000', 0, NULL, NULL, NULL),
(112, 103, 62, 10, '8000', 0, NULL, NULL, NULL),
(113, 103, 58, 10, '3000', 0, NULL, NULL, NULL),
(114, 103, 61, 10, '7000', 0, NULL, NULL, NULL),
(115, 104, 58, 10, '446', 0, NULL, NULL, NULL),
(116, 104, 63, 10, '813', 0, NULL, NULL, NULL),
(117, 104, 60, 10, '385', 0, NULL, NULL, NULL);

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
  `remarks` text,
  `status` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `material_requisitions`
--

INSERT INTO `material_requisitions` (`id`, `company_id`, `project_id`, `unit_config_id`, `tower_id`, `date`, `remarks`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 8, 3, '2022-10-11', '234234', 'ApprovedOne', 3, '2022-10-10 19:47:15', '2022-10-10 20:14:10');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `material_requisition_communications`
--

INSERT INTO `material_requisition_communications` (`id`, `material_requisition_id`, `comment`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 6, 'asdfasd f asdf asd fasdf', 2, '2022-10-09 09:04:09', '2022-10-09 09:04:16'),
(3, 7, 'z as f sfas dfa dfsa dsfa sdf', 2, '2022-10-10 17:16:58', '2022-10-10 17:18:32'),
(4, 7, 'd fasf asdf324234234', 2, '2022-10-10 17:17:01', '2022-10-10 17:18:35'),
(5, 7, 's dfas df3 4563 465 34', 2, '2022-10-10 17:18:29', '2022-10-10 17:18:37');

-- --------------------------------------------------------

--
-- Table structure for table `material_requisition_items`
--

CREATE TABLE `material_requisition_items` (
  `id` int(11) NOT NULL,
  `material_requisition_id` int(11) NOT NULL,
  `budget_head_id` int(11) NOT NULL,
  `requisition_amount` text NOT NULL,
  `approved_amount_one` text,
  `approved_amount_two` text,
  `estimated_amount` text,
  `issued_amount` text,
  `balance_amount` text,
  `payment_status` int(11) NOT NULL DEFAULT '0',
  `paid_by` int(11) DEFAULT NULL,
  `payment_time` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `material_requisition_items`
--

INSERT INTO `material_requisition_items` (`id`, `material_requisition_id`, `budget_head_id`, `requisition_amount`, `approved_amount_one`, `approved_amount_two`, `estimated_amount`, `issued_amount`, `balance_amount`, `payment_status`, `paid_by`, `payment_time`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '500', '30', '50', '650403', '0', '650403', 0, NULL, NULL, '2022-10-10 19:47:15', '2022-10-10 20:14:29'),
(2, 1, 4, '200', '10', '20', '132826', '0', '132826', 0, NULL, NULL, '2022-10-10 19:47:15', '2022-10-10 20:14:30');

-- --------------------------------------------------------

--
-- Table structure for table `material_units`
--

CREATE TABLE `material_units` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `payment_no` text NOT NULL,
  `payment_date` text NOT NULL,
  `payment_amount` text NOT NULL,
  `payment_type` text NOT NULL,
  `money_receipt` text NOT NULL,
  `remarks` text,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(7, 'App\\Models\\User', 2),
(10, 'App\\Models\\User', 3),
(10, 'App\\Models\\User', 4),
(9, 'App\\Models\\User', 5),
(7, 'App\\Models\\User', 11),
(7, 'App\\Models\\User', 12),
(1, 'App\\Models\\User', 18),
(2, 'App\\Models\\User', 19),
(2, 'App\\Models\\User', 20),
(7, 'App\\Models\\User', 21),
(7, 'App\\Models\\User', 22),
(2, 'App\\Models\\User', 23),
(8, 'App\\Models\\User', 24),
(7, 'App\\Models\\User', 26),
(9, 'App\\Models\\User', 27),
(9, 'App\\Models\\User', 28),
(9, 'App\\Models\\User', 29),
(9, 'App\\Models\\User', 30),
(9, 'App\\Models\\User', 31),
(9, 'App\\Models\\User', 32),
(9, 'App\\Models\\User', 33),
(2, 'App\\Models\\User', 34),
(9, 'App\\Models\\User', 35),
(1, 'App\\Models\\User', 36),
(10, 'App\\Models\\User', 37),
(7, 'App\\Models\\User', 38),
(9, 'App\\Models\\User', 39),
(9, 'App\\Models\\User', 40),
(9, 'App\\Models\\User', 41),
(8, 'App\\Models\\User', 42);

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
  `status` int(11) NOT NULL DEFAULT '1',
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `order_serial` int(10) UNSIGNED DEFAULT NULL,
  `action_menu` int(10) UNSIGNED DEFAULT NULL,
  `software_admin_only` int(11) NOT NULL DEFAULT '0',
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `icon_color` text COLLATE utf8mb4_unicode_ci,
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
(54, 1, NULL, 8, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'User Management', 'web', '2022-01-22 05:27:50', '2022-04-07 20:07:08'),
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
(67, 1, 56, 2, 0, 0, 'supplier.payment', 'fa fa-dashboard', '#ffffff', 'Supplier Payment', 'web', '2022-01-23 16:26:06', '2022-01-29 18:19:42'),
(69, 1, 116, 4, 0, 0, 'cost.ledger.report', 'fa fa-dashboard', '#ffffff', 'Cost Ledger', 'web', '2022-01-23 16:34:18', '2022-04-06 17:30:29'),
(70, 1, 56, 5, 0, 0, 'vendorStatement', 'fa fa-dashboard', '#ffffff', 'Vendor Statement', 'web', '2022-01-23 16:34:35', '2022-03-09 05:53:35'),
(71, 0, 56, 6, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Project Profit Loss', 'web', '2022-01-23 16:34:55', '2022-01-23 16:34:55'),
(72, 1, 57, 1, 0, 0, 'materiallifting.index', 'fa fa-dashboard', '#ffffff', 'Material Lifting', 'web', '2022-01-23 16:36:26', '2022-01-23 17:28:29'),
(73, 1, 56, 2, 0, 0, 'materialrequisition.index', 'fa fa-dashboard', '#ffffff', 'Material Requisition', 'web', '2022-01-23 16:36:48', '2022-10-08 15:28:20'),
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
(88, 1, NULL, 9, 0, 0, 'gallery.index', 'fa fa-dashboard', '#ffffff', 'Project Gallery', 'web', '2022-01-25 09:03:21', '2022-04-07 20:07:07'),
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
(105, 1, 116, 10, 0, 0, 'material.statement.report', 'fa fa-dashboard', '#ffffff', 'Material Statement', 'web', '2022-03-09 18:53:06', '2022-04-06 17:30:10'),
(106, 1, 75, 1, 1, 0, 'dailyconsumption.create', NULL, NULL, 'create local issue', 'web', '2022-03-30 06:43:20', '2022-03-30 06:43:20'),
(107, 1, 75, 2, 1, 0, 'dailyconsumption.edit', NULL, NULL, 'edit local issue', 'web', '2022-03-30 06:43:37', '2022-03-30 06:43:37'),
(108, 1, 75, 3, 1, 0, 'dailyconsumption.delete', NULL, NULL, 'delete local issue', 'web', '2022-03-30 06:44:20', '2022-03-30 06:44:20'),
(109, 1, 116, 11, 0, 0, 'daily.consumption.report', 'fa fa-dashboard', '#ffffff', 'Daily Consumption Log', 'web', '2022-03-31 18:13:51', '2022-04-06 17:29:33'),
(110, 1, 116, 12, 0, 0, 'stock.report', 'fa fa-dashboard', '#ffffff', 'Stock Report', 'web', '2022-04-01 16:58:33', '2022-04-06 17:30:14'),
(111, 1, 116, 13, 0, 0, 'lifting.report', 'fa fa-dashboard', '#ffffff', 'Lifting Log', 'web', '2022-04-02 07:37:06', '2022-04-06 17:29:36'),
(112, 1, 116, 14, 0, 0, 'issue.log.report', 'fa fa-dashboard', '#ffffff', 'Transfer Log', 'web', '2022-04-02 16:47:04', '2022-07-27 09:27:57'),
(113, 1, 116, 15, 0, 0, 'payment.log.report', 'fa fa-dashboard', '#ffffff', 'Payment Log', 'web', '2022-04-02 17:47:59', '2022-04-06 17:29:42'),
(116, 1, NULL, 7, 0, 0, 'home', 'fa fa-dashboard', '#ffffff', 'Transaction Reports', 'web', '2022-04-06 17:19:16', '2022-04-07 20:07:05'),
(117, 1, 1, 10, 0, 0, 'company.setup', 'fa fa-dashboard', '#ffffff', 'Company', 'web', '2022-04-08 06:52:40', '2022-04-08 06:52:40'),
(118, 1, 57, 10, 0, 0, 'dailyuses.index', 'fa fa-dashboard', '#ffffff', 'Daily Consumption', 'web', '2022-04-21 20:00:54', '2022-06-10 09:02:08'),
(119, 1, 62, 4, 1, 0, 'projectwiseroa.index', NULL, NULL, 'ROA', 'web', '2022-04-22 05:51:36', '2022-04-22 05:51:36'),
(120, 1, 66, 5, 1, 0, 'cashrequisition.payment.view', NULL, NULL, 'Cash Requisition Payment', 'web', '2022-04-24 19:44:25', '2022-04-24 19:44:25'),
(121, 1, 74, 4, 1, 0, 'materialissue.print', NULL, NULL, 'print materialissue', 'web', '2022-05-19 03:43:09', '2022-05-19 03:43:09'),
(122, 1, 72, 4, 1, 0, 'materiallifting.print', NULL, NULL, 'print materiallifting', 'web', '2022-05-19 17:32:57', '2022-05-19 17:32:57'),
(124, 1, 75, 4, 1, 0, 'dailyconsumption.print', NULL, NULL, 'print local issue', 'web', '2022-05-19 17:35:45', '2022-05-19 17:35:45'),
(125, 1, 1, 9, 0, 0, 'logisticCharge.index', 'fa fa-dashboard', '#ffffff', 'Logistics Charge', 'web', '2022-05-24 04:01:31', '2022-05-29 05:17:57'),
(126, 1, 125, 1, 1, 0, 'logisticCharge.create', NULL, NULL, 'create logistics charge', 'web', '2022-05-24 04:01:57', '2022-05-24 04:01:57'),
(127, 1, 125, 2, 1, 0, 'logisticCharge.edit', NULL, NULL, 'edit logistics charge', 'web', '2022-05-24 04:02:14', '2022-05-24 04:02:14'),
(128, 1, 125, 3, 1, 0, 'logisticCharge.delete', NULL, NULL, 'delete logistics charge', 'web', '2022-05-24 04:02:29', '2022-05-24 04:02:29'),
(129, 1, 56, 10, 0, 0, 'tbp.index', 'fa fa-dashboard', '#ffffff', 'Transportation Bill Prepare', 'web', '2022-05-24 05:11:56', '2022-05-29 05:18:08'),
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
(141, 1, 116, 8, 0, 0, 'local.issue.report', 'fa fa-dashboard', '#ffffff', 'Local Issue Log', 'web', '2022-07-27 10:56:28', '2022-07-27 10:56:28'),
(142, 1, 57, 11, 0, 0, 'dailyconsumption.receiveList', 'fa fa-dashboard', '#ffffff', 'Local Receive', 'web', '2022-08-09 11:05:52', '2022-08-09 11:05:52'),
(143, 1, 60, 6, 0, 0, 'additionalbudget.index', 'fa fa-dashboard', '#ffffff', 'Additional Budget', 'web', '2022-08-11 08:26:56', '2022-08-11 08:26:56'),
(144, 1, 143, 1, 1, 0, 'home.index', NULL, NULL, 'create additionalbudget', 'web', '2022-08-11 08:29:34', '2022-08-11 08:29:34'),
(145, 1, 73, 1, 1, 0, 'home.index', NULL, NULL, 'create materialrequisition', 'web', '2022-10-08 15:28:54', '2022-10-08 15:28:54'),
(146, 1, 73, 2, 1, 0, 'home.index', NULL, NULL, 'edit materialrequisition', 'web', '2022-10-08 15:29:00', '2022-10-08 15:29:00'),
(147, 1, 73, 3, 1, 0, 'home.index', NULL, NULL, 'delete materialrequisition', 'web', '2022-10-08 15:29:25', '2022-10-08 15:29:25'),
(148, 1, 56, 7, 0, 0, 'approveRequisitionStepOneList', 'fa fa-dashboard', '#ffffff', 'Material Requisition Approve', 'web', '2022-10-09 08:28:03', '2022-10-09 08:28:03'),
(149, 1, 56, 8, 0, 0, 'approveRequisitionStepTwoList', 'fa fa-dashboard', '#ffffff', 'Material Requisition Final Approve', 'web', '2022-10-09 17:40:58', '2022-10-09 17:40:58');

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
  `show_dashboard` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `company_id`, `branch_id`, `project_type`, `project_code`, `project_name`, `contact_person_name`, `contact_person_phone`, `address`, `show_dashboard`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'tower', 'Fujian-01', 'Kaliakoir - Mymensingh 400kv line', 'Sakhawat Hossain', '01844169000', 'Bhaluka - Bhoradoba', 1, '2022-07-18 09:00:29', '2022-07-18 09:00:29'),
(2, 1, 5, 'tower', 'KEC01', 'Bogra to Kaliakoir 400kv double circuit line', 'Sakhawat Hossain', '01844169000', 'Tangail  - Elenga', 1, '2022-07-18 09:00:30', '2022-07-18 09:00:30');

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
  `payment_date` text,
  `total` text NOT NULL,
  `advance_paid` text NOT NULL,
  `owner_demand` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_budget_wise_roas`
--

INSERT INTO `project_budget_wise_roas` (`id`, `projectwise_budget_id`, `survery_date`, `owner_name`, `access_type`, `phone`, `crops`, `area`, `per_area`, `rate_per_kg`, `payment_date`, `total`, `advance_paid`, `owner_demand`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '15-07-2022', 'Owner 1', 'Land', '5555555555', 'Illiana Ramsey', 'Davis Chen', '1', '9000', '15-07-2022', '9000', '0', '0', 2, '2022-07-18 09:51:09', '2022-07-18 09:51:09'),
(2, 1, '16-07-2022', 'Owner 2', 'Land', '999999999', 'Hilary Wilkerson', 'Avye Farmer', '1', '7500', '15-07-2022', '7500', '0', '0', 2, '2022-07-18 09:51:09', '2022-07-18 09:51:09'),
(3, 3, '14-07-2022', 'Owner 1', 'Land', '5555555555', 'no', 'no', '1', '9000', '17-07-2022', '9000', '0', '0', 2, '2022-07-18 10:54:43', '2022-07-18 10:54:43'),
(4, 3, '16-07-2022', 'Owner 2', 'Land', '99999999999999', 'no', 'no', '1', '7500', '17-07-2022', '7500', '0', '0', 2, '2022-07-18 10:54:43', '2022-07-18 10:54:43'),
(7, 4, '19-07-2022', 'Owner 1', 'Land', '5555555555', 'no', 'no', '1', '10000', '19-07-2022', '10000', '10000', '0', 2, '2022-07-21 06:10:45', '2022-07-21 06:10:45'),
(8, 4, '19-07-2022', 'Owner 2', 'Land', '9999999999999', 'no', 'no', '1', '5000', '19-07-2022', '5000', '5000', '0', 2, '2022-07-21 06:10:45', '2022-07-21 06:10:45'),
(9, 5, '19-07-2022', 'Owner 1', 'Land', '5555555555', 'no', 'no', '1', '10000', '19-07-2022', '10000', '10000', '0', 2, '2022-07-21 06:29:34', '2022-07-21 06:29:34'),
(10, 5, '20-07-2022', 'Owner 2', 'Land', '333333333333333', 'no', 'no', '1', '5000', '19-07-2022', '5000', '5000', '0', 2, '2022-07-21 06:29:34', '2022-07-21 06:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `project_towers`
--

CREATE TABLE `project_towers` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text,
  `soil_category` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_towers`
--

INSERT INTO `project_towers` (`id`, `project_id`, `name`, `type`, `soil_category`, `created_at`, `updated_at`) VALUES
(1, 1, 'T - 36', '', '', '2022-07-17 08:33:17', '2022-07-17 08:33:17'),
(2, 1, 'T - 36/1', '', '', '2022-07-17 08:33:17', '2022-07-17 08:33:17'),
(3, 1, 'T - 37', '', '', '2022-07-17 08:33:17', '2022-07-17 08:33:17'),
(4, 1, 'T - 37/1', '', '', '2022-07-17 08:33:17', '2022-07-17 08:33:17'),
(5, 1, 'T - 42/10', '', '', '2022-07-17 08:33:17', '2022-07-17 08:33:17'),
(10, 2, 'T - 12/1', NULL, NULL, '2022-07-29 17:29:44', '2022-07-29 17:29:44'),
(11, 2, 'T - 23/1', NULL, NULL, '2022-07-29 17:29:44', '2022-07-29 17:29:44'),
(12, 2, 'T - 39/1', '4 DL- +1.50 m', '2', '2022-07-29 17:29:44', '2022-07-29 17:29:44'),
(13, 2, 'T - 11/1', NULL, NULL, '2022-07-29 17:29:44', '2022-07-29 17:29:44');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_units`
--

INSERT INTO `project_units` (`id`, `project_id`, `unit_id`, `created_at`, `updated_at`) VALUES
(1, 1, 8, NULL, NULL),
(2, 1, 9, NULL, NULL),
(7, 2, 8, NULL, NULL),
(8, 2, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_wise_budgets`
--

CREATE TABLE `project_wise_budgets` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `unit_config_id` int(11) DEFAULT NULL,
  `long_l` int(11) DEFAULT NULL,
  `volume` int(11) DEFAULT NULL,
  `number_of_pile` int(11) DEFAULT NULL,
  `tower_id` int(11) DEFAULT NULL,
  `start_date` text,
  `end_date` text,
  `remarks` text,
  `is_additional` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_wise_budgets`
--

INSERT INTO `project_wise_budgets` (`id`, `company_id`, `project_id`, `unit_id`, `unit_config_id`, `long_l`, `volume`, `number_of_pile`, `tower_id`, `start_date`, `end_date`, `remarks`, `is_additional`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 8, 2, 30, NULL, 16, 4, '2022-07-01', '2022-07-31', NULL, 0, 2, '2022-07-18 10:53:45', '2022-07-18 10:53:45'),
(5, 1, 2, 8, 1, 28, NULL, 16, 12, '2022-07-01', '2022-07-31', NULL, 0, 2, '2022-07-21 06:28:27', '2022-07-21 06:28:27'),
(6, 1, 1, 8, NULL, NULL, NULL, NULL, 3, NULL, NULL, '1234556', 1, 2, '2022-08-12 09:22:13', '2022-08-12 09:22:13');

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
  `remarks` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_wise_budget_items`
--

INSERT INTO `project_wise_budget_items` (`id`, `projectwise_budget_id`, `budget_head`, `amount`, `qty`, `remarks`, `created_at`, `updated_at`) VALUES
(23, 3, 3, '650403', 1414, NULL, NULL, NULL),
(24, 3, 4, '132826', 2952, NULL, NULL, NULL),
(25, 3, 5, '836000', 3800, NULL, NULL, NULL),
(26, 3, 64, '15000', 600, NULL, NULL, NULL),
(27, 3, 6, '424800', 472, NULL, NULL, NULL),
(28, 3, 65, '15000', 1, NULL, NULL, NULL),
(29, 3, 76, '34850', 3800, NULL, NULL, NULL),
(30, 3, 78, '14080', 1408, NULL, NULL, NULL),
(31, 3, 77, '27070', 2952, NULL, NULL, NULL),
(32, 3, 79, '16430', 16430, NULL, NULL, NULL),
(33, 3, 71, '16000', 2, NULL, NULL, NULL),
(34, 3, 80, '42000', 3000, NULL, NULL, NULL),
(35, 3, 81, '35000', 2500, NULL, NULL, NULL),
(36, 3, 73, '5000', 1, NULL, NULL, NULL),
(37, 3, 74, '25000', 1, NULL, NULL, NULL),
(107, 5, 3, '366800', 917, NULL, NULL, NULL),
(108, 5, 4, '86394', 1800, NULL, NULL, NULL),
(109, 5, 5, '625460', 2843, NULL, NULL, NULL),
(110, 5, 64, '10000', 500, NULL, NULL, NULL),
(111, 5, 6, '358400', 448, NULL, NULL, NULL),
(112, 5, 65, '10000', 1, NULL, NULL, NULL),
(113, 5, 76, '26116', 2848, NULL, NULL, NULL),
(114, 5, 77, '16579', 1808, NULL, NULL, NULL),
(115, 5, 78, '9120', 912, NULL, NULL, NULL),
(116, 5, 79, '16430', 16430, NULL, NULL, NULL),
(117, 5, 71, '16000', 2, NULL, NULL, NULL),
(118, 5, 73, '5000', 1, NULL, NULL, NULL),
(119, 5, 75, '10000', 1, NULL, NULL, NULL),
(120, 5, 74, '20000', 1, NULL, NULL, NULL),
(121, 6, 66, '8120', 145, 'dfsg', NULL, NULL),
(122, 6, 72, '41280', 645, '453453', NULL, NULL);

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
(8, 7, 'Project Manager', 'web', '2022-01-22 08:45:08', '2022-01-22 08:45:08'),
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
(2, 1),
(3, 1),
(4, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(54, 1),
(56, 1),
(57, 1),
(60, 1),
(61, 1),
(62, 1),
(64, 1),
(66, 1),
(67, 1),
(69, 1),
(70, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(78, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(116, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(1, 2),
(2, 2),
(3, 2),
(6, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(54, 2),
(56, 2),
(57, 2),
(60, 2),
(61, 2),
(62, 2),
(64, 2),
(66, 2),
(67, 2),
(69, 2),
(70, 2),
(72, 2),
(74, 2),
(75, 2),
(76, 2),
(78, 2),
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(86, 2),
(87, 2),
(88, 2),
(89, 2),
(90, 2),
(91, 2),
(92, 2),
(93, 2),
(94, 2),
(95, 2),
(96, 2),
(97, 2),
(98, 2),
(101, 2),
(102, 2),
(103, 2),
(105, 2),
(106, 2),
(107, 2),
(108, 2),
(109, 2),
(110, 2),
(111, 2),
(112, 2),
(113, 2),
(116, 2),
(117, 2),
(118, 2),
(134, 2),
(135, 2),
(136, 2),
(137, 2),
(138, 2),
(139, 2),
(140, 2),
(148, 2),
(149, 2),
(1, 7),
(2, 7),
(3, 7),
(4, 7),
(6, 7),
(7, 7),
(8, 7),
(9, 7),
(10, 7),
(11, 7),
(12, 7),
(21, 7),
(23, 7),
(24, 7),
(25, 7),
(26, 7),
(27, 7),
(28, 7),
(29, 7),
(30, 7),
(31, 7),
(32, 7),
(33, 7),
(34, 7),
(43, 7),
(44, 7),
(45, 7),
(46, 7),
(48, 7),
(49, 7),
(50, 7),
(51, 7),
(54, 7),
(56, 7),
(57, 7),
(60, 7),
(61, 7),
(62, 7),
(64, 7),
(66, 7),
(67, 7),
(69, 7),
(70, 7),
(72, 7),
(73, 7),
(74, 7),
(75, 7),
(78, 7),
(82, 7),
(83, 7),
(84, 7),
(85, 7),
(86, 7),
(87, 7),
(88, 7),
(89, 7),
(90, 7),
(91, 7),
(92, 7),
(93, 7),
(94, 7),
(95, 7),
(96, 7),
(97, 7),
(98, 7),
(100, 7),
(101, 7),
(102, 7),
(103, 7),
(105, 7),
(106, 7),
(107, 7),
(108, 7),
(109, 7),
(110, 7),
(111, 7),
(112, 7),
(113, 7),
(116, 7),
(117, 7),
(118, 7),
(119, 7),
(120, 7),
(121, 7),
(122, 7),
(124, 7),
(125, 7),
(126, 7),
(127, 7),
(128, 7),
(129, 7),
(130, 7),
(132, 7),
(133, 7),
(134, 7),
(135, 7),
(136, 7),
(137, 7),
(138, 7),
(139, 7),
(140, 7),
(141, 7),
(142, 7),
(143, 7),
(144, 7),
(145, 7),
(146, 7),
(147, 7),
(148, 7),
(149, 7),
(1, 8),
(8, 8),
(31, 8),
(32, 8),
(33, 8),
(34, 8),
(35, 8),
(36, 8),
(37, 8),
(38, 8),
(39, 8),
(40, 8),
(41, 8),
(42, 8),
(43, 8),
(44, 8),
(45, 8),
(46, 8),
(48, 8),
(49, 8),
(50, 8),
(51, 8),
(56, 8),
(57, 8),
(60, 8),
(61, 8),
(62, 8),
(64, 8),
(66, 8),
(67, 8),
(69, 8),
(70, 8),
(72, 8),
(74, 8),
(75, 8),
(76, 8),
(82, 8),
(83, 8),
(84, 8),
(85, 8),
(86, 8),
(87, 8),
(88, 8),
(89, 8),
(90, 8),
(91, 8),
(92, 8),
(93, 8),
(94, 8),
(95, 8),
(96, 8),
(97, 8),
(98, 8),
(101, 8),
(102, 8),
(103, 8),
(105, 8),
(106, 8),
(107, 8),
(108, 8),
(109, 8),
(110, 8),
(111, 8),
(112, 8),
(113, 8),
(116, 8),
(118, 8),
(121, 8),
(122, 8),
(124, 8),
(129, 8),
(130, 8),
(132, 8),
(133, 8),
(56, 9),
(66, 9),
(67, 9),
(70, 9),
(96, 9),
(97, 9),
(98, 9),
(100, 9),
(120, 9),
(56, 10),
(57, 10),
(72, 10),
(73, 10),
(74, 10),
(75, 10),
(76, 10),
(82, 10),
(83, 10),
(84, 10),
(85, 10),
(86, 10),
(87, 10),
(106, 10),
(107, 10),
(108, 10),
(118, 10),
(121, 10),
(122, 10),
(124, 10),
(134, 10),
(135, 10),
(136, 10),
(137, 10),
(145, 10),
(146, 10),
(147, 10);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `website_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `website_logo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon_img` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `website_name`, `website_logo`, `favicon_img`, `created_at`, `updated_at`) VALUES
(1, 'Project Book', 'YWLWr1bdUIrL7wIKxrSs0K5D2PrL5b9gIA4pfS8x.png', 'gUTPtujgSvk6HPijA3UHfPblHZ5IutAFAdOm41r5.jpg', '2021-11-13 04:37:15', '2022-05-13 10:08:39');

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
  `payment_type` text,
  `payment_date` text NOT NULL,
  `money_receipt` text NOT NULL,
  `remarks` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `payment_amount` text,
  `payment_status` int(11) NOT NULL DEFAULT '0',
  `paid_by` int(11) DEFAULT NULL,
  `payment_time` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `payment_type` text NOT NULL,
  `remarks` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `code` text,
  `name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `pile_length` text,
  `dia` text,
  `length` text,
  `width` text,
  `height` text,
  `cement` text,
  `sand` text,
  `stone` text,
  `cement_qty` text,
  `sand_qty` text,
  `stone_qty` text,
  `brick_qty` text,
  `soil_qty` text,
  `tiles_sft` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unit_configurations`
--

INSERT INTO `unit_configurations` (`id`, `company_id`, `project_id`, `unit_id`, `unit_name`, `pile_length`, `dia`, `length`, `width`, `height`, `cement`, `sand`, `stone`, `cement_qty`, `sand_qty`, `stone_qty`, `brick_qty`, `soil_qty`, `tiles_sft`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 8, 'KEC01_PLC/28_550_4.74', '28', '550', NULL, NULL, NULL, '1', '1.57', '2.48', '57.3211', '112.4926', '177.6953', NULL, NULL, NULL, '2022-07-18 09:05:39', '2022-07-21 06:22:38'),
(2, 1, 1, 8, 'Fujian-01_PLC/29.5_650_4.82', '29.5', '650', NULL, NULL, NULL, '1', '1.67', '2.15', '88.37', '184.48', '237.50', NULL, NULL, NULL, '2022-07-18 09:09:04', '2022-07-18 10:31:30');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `photo` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Software Admin', 'rifat@email.com', NULL, '$2y$10$WyqOlhZTAjqYD0GZjaiGNu51EAty0AGrpENHuz6iwylld7KC/Wj.a', NULL, 1, NULL, '2021-11-13 04:37:15', '2021-11-13 04:37:15'),
(2, 1, 'Genex - S S JV', 'genex', NULL, '$2y$10$nYx6nyKN3xZRICroCHCME.hqWmHzYNDa9yi16yWY0G3Ve4hGTYFlK', NULL, 1, 'pSTI0qEJcftqMmTMGnX4JrUpVXUyzN6uH42uaaGLrT73cU5TlMuzoVg9TH8g', '2022-07-11 17:56:07', '2022-07-11 17:56:07'),
(3, 1, 'field1', 'field1', NULL, '$2y$10$OycNgMpZlIHKqJ.T7RGGnO6InPiW.EbQpLyDsvkYfN1FWfSEnah.O', '', 1, NULL, '2022-07-29 16:48:19', '2022-07-29 16:48:19'),
(4, 1, 'field2', 'field2', NULL, '$2y$10$uq4F.3il9gYLJEeQcjfzZOi4ns1pczCpypYJVgYPhBkSiH0wAEk9S', '', 1, NULL, '2022-07-29 16:50:16', '2022-07-29 16:50:16'),
(5, 1, 'Luke Cross', 'Luke Cross', NULL, '$2y$10$WKly50epxDKr/C/V5FrdHeAi2itzJKUC9sR1Zoupn.25BdXgbRAR.', '', 1, NULL, '2022-10-09 08:19:37', '2022-10-09 08:19:37');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_projects`
--

INSERT INTO `user_projects` (`id`, `user_id`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 42, 1, NULL, NULL),
(7, 26, 1, NULL, NULL),
(8, 35, 1, NULL, NULL),
(9, 35, 2, NULL, NULL),
(10, 35, 4, NULL, NULL),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vendor_type` text NOT NULL,
  `code` text,
  `name` text NOT NULL,
  `contact_person_name` text NOT NULL,
  `contact_person_phone` text NOT NULL,
  `contact_person_email` text,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `company_id`, `user_id`, `vendor_type`, `code`, `name`, `contact_person_name`, `contact_person_phone`, `contact_person_email`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Material Supplier', 'V_Stone_001', 'Al kafeydu Trading', 'Mr Jahangir', '01715149279', 'xyz@fdf.com', 'Chatak Syhlet', '2022-07-17 08:37:56', '2022-07-17 08:37:56'),
(2, 1, NULL, 'Material Supplier', 'anoar-cement', 'Anowar cement', 'Anowar cement', '444444444444', 'companyavendor@gmail.com', 'sdafsadfasfsadf', '2022-07-21 06:56:35', '2022-07-21 06:56:35'),
(3, 1, NULL, 'Material Supplier', 'saidul-trade', 'M/S Saiful Trad', 'M/S Saiful Trad.', '435345345', 'companyavendor@gmail.com', 'sda fasd fasd f', '2022-07-21 07:12:21', '2022-07-21 07:12:21'),
(4, 1, NULL, 'Material Supplier', 'Al-Kafidul', 'M/S Al-Kafidul', 'M/S Al-Kafidul', '444444444444', 'companyavendor@gmail.com', 'sdafsda fasdf as fasf', '2022-07-21 07:12:38', '2022-07-21 07:12:38'),
(5, 1, NULL, 'Material Supplier', 'Shohag', 'Shohag', 'Shohag', '+1 (481) 705-1026', 'companyavendor@gmail.com', 'asdsad', '2022-07-21 07:12:49', '2022-07-21 07:12:49'),
(6, 1, NULL, 'Material Supplier', 'Alom', 'Alom', 'Alom', '444444444444', 'companyavendor@gmail.com', 'dfsdfs fsd f', '2022-07-21 09:02:03', '2022-07-21 09:02:03'),
(7, 1, NULL, 'Logistics Associate', 'aslam', 'Aslam', 'Aslam', '444444444444', 'companyavendor@gmail.com', 'Aslam', '2022-07-24 05:57:45', '2022-07-24 05:57:45'),
(8, 1, NULL, 'Material Supplier', 'crown-cement', 'Crown cement plc', 'Crown cement plc', '5555555555', 'crown@gmail.com', 'address', '2022-07-25 07:18:02', '2022-07-25 07:18:02'),
(9, 1, NULL, 'Material Supplier', 'gph-ispat', 'GPH ispat ltd', 'GPH ispat ltd', '99999999999', 'gph@gmail.com', 'address', '2022-07-25 07:29:31', '2022-07-25 07:29:31'),
(10, 1, 5, 'Working Associate', 'Reiciendis libero pe', 'Luke Cross', 'Edward Berg', '+1 (605) 984-1648', 'jydazel@mailinator.com', 'Distinctio Porro fa', '2022-10-09 08:19:37', '2022-10-09 08:19:37');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `budget_heads`
--
ALTER TABLE `budget_heads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cash_requisition_communications`
--
ALTER TABLE `cash_requisition_communications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_requisition_items`
--
ALTER TABLE `cash_requisition_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_consumptions`
--
ALTER TABLE `daily_consumptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `daily_consumption_items`
--
ALTER TABLE `daily_consumption_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `daily_uses`
--
ALTER TABLE `daily_uses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `daily_use_items`
--
ALTER TABLE `daily_use_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logistics_charge_items`
--
ALTER TABLE `logistics_charge_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `material_issue_items`
--
ALTER TABLE `material_issue_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `material_liftings`
--
ALTER TABLE `material_liftings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `material_lifting_materials`
--
ALTER TABLE `material_lifting_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `material_requisitions`
--
ALTER TABLE `material_requisitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `material_requisition_communications`
--
ALTER TABLE `material_requisition_communications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `project_budget_wise_roas`
--
ALTER TABLE `project_budget_wise_roas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `project_towers`
--
ALTER TABLE `project_towers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `project_units`
--
ALTER TABLE `project_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `project_wise_budgets`
--
ALTER TABLE `project_wise_budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_wise_budget_items`
--
ALTER TABLE `project_wise_budget_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_b_p_s`
--
ALTER TABLE `t_b_p_s`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `unit_configurations`
--
ALTER TABLE `unit_configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unit_config_materials`
--
ALTER TABLE `unit_config_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
