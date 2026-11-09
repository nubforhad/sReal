-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2026 at 10:25 AM
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
-- Database: `sreal`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `company_id`, `name`, `code`, `phone`, `email`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Demra Branch', 'Velit voluptate eu', '+1 (755) 652-9762', 'loxaxyde@mailinator.com', 'Sit eum velit non ex', 1, '2026-09-27 05:46:34', '2026-09-27 05:46:34');

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `rajuk_approval_id` bigint(20) UNSIGNED DEFAULT NULL,
  `building_code` varchar(255) DEFAULT NULL,
  `building_name` varchar(255) NOT NULL,
  `building_type` varchar(255) DEFAULT NULL,
  `number_of_floors` int(10) UNSIGNED DEFAULT NULL,
  `number_of_basements` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_flats` int(10) UNSIGNED DEFAULT NULL,
  `construction_start_date` date DEFAULT NULL,
  `expected_completion_date` date DEFAULT NULL,
  `actual_completion_date` date DEFAULT NULL,
  `contractor_name` varchar(255) DEFAULT NULL,
  `contractor_phone` varchar(20) DEFAULT NULL,
  `architect_name` varchar(255) DEFAULT NULL,
  `engineer_name` varchar(255) DEFAULT NULL,
  `status` enum('planning','preparation','ongoing','paused','completed','on_hold') NOT NULL DEFAULT 'planning',
  `description` text DEFAULT NULL,
  `building_image` varchar(255) DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `company_id`, `branch_id`, `project_id`, `rajuk_approval_id`, `building_code`, `building_name`, `building_type`, `number_of_floors`, `number_of_basements`, `total_flats`, `construction_start_date`, `expected_completion_date`, `actual_completion_date`, `contractor_name`, `contractor_phone`, `architect_name`, `engineer_name`, `status`, `description`, `building_image`, `document`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '009', 'ko', 'Residential', 10, 1, 66, '2026-11-02', '2027-03-23', '2027-05-06', 'o', '01888882222', 'i', 'hysfc', 'ongoing', 'yu', 'buildings/images/ydZoH3c2NqGU54BSKzWbQWF15SlkB2OSiiX2vgwX.webp', NULL, '2026-11-02 01:12:23', '2026-11-02 01:38:30'),
(2, 1, 1, 1, 1, 'Amet mollitia quia', 'Shannon Camacho', 'Commercial', 518, 389, 81, '2006-01-30', '2023-10-05', '2011-05-07', 'Cassady Pruitt', '+1 (768) 588-1633', 'Lucas Stephenson', 'Kasper Erickson', 'preparation', 'Voluptatem Velit s', NULL, NULL, '2026-11-08 00:18:39', '2026-11-08 00:18:39');

-- --------------------------------------------------------

--
-- Table structure for table `building_client_assignments`
--

CREATE TABLE `building_client_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `building_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_at` date DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `building_client_assignments`
--

INSERT INTO `building_client_assignments` (`id`, `company_id`, `branch_id`, `project_id`, `building_id`, `client_id`, `assigned_at`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, '2026-11-03', 'active', NULL, '2026-11-03 01:03:51', '2026-11-03 01:03:51'),
(2, 1, 1, 1, 2, 2, '2026-11-08', 'active', NULL, '2026-11-08 00:20:14', '2026-11-08 00:20:14');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `client_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `spouse_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `alternate_phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nid` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `nid_document` varchar(255) DEFAULT NULL,
  `other_document` varchar(255) DEFAULT NULL,
  `nominee_name` varchar(255) DEFAULT NULL,
  `nominee_relation` varchar(255) DEFAULT NULL,
  `nominee_phone` varchar(255) DEFAULT NULL,
  `nominee_nid` varchar(255) DEFAULT NULL,
  `nominee_address` text DEFAULT NULL,
  `nominee_photo` varchar(255) DEFAULT NULL,
  `nominee_nid_document` varchar(255) DEFAULT NULL,
  `nominee_other_document` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `company_id`, `branch_id`, `project_id`, `client_code`, `name`, `father_name`, `mother_name`, `spouse_name`, `phone`, `alternate_phone`, `email`, `nid`, `date_of_birth`, `occupation`, `address`, `city`, `photo`, `nid_document`, `other_document`, `nominee_name`, `nominee_relation`, `nominee_phone`, `nominee_nid`, `nominee_address`, `nominee_photo`, `nominee_nid_document`, `nominee_other_document`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'RE-2026-000001', 'client 1', 'rfsdf', 'dfg', 'ewff', '01912466718', '01912466718', 'mdforhadahsan1999@gmail.com', 'erfe', '2008-06-10', 'ed wf', '60 fit mirpur-2 e', 'Dhaka', 'clients/photos/ufJWnbTes9utJA2ghFnopFJ8FD7be21eMA5Hysqk.jpg', 'clients/nid/oNIBXftXzlyg8ZdfLPIBAlvIp2TV7K7qIYlfWn78.jpg', 'clients/documents/lVPK50kFxhkW9uCaao4gtiLNQmPluQQtz0Bj6X8G.jpg', 'wwwwww', 'Mother', '01711477892', '56357897', '60 fit mirpur-2 3', 'clients/nominees/photos/tra2C1iUZ1MmmzOyodADFTaDJ6ukglmEoV290xgQ.jpg', 'clients/nominees/nid/Y4mcYDqmn0ejiND6AMJrk4HouH2KiSG3HdAheT5b.jpg', 'clients/nominees/documents/dkr98lIPs1OUXHSER9ohDw9TBCoLWAgc5sShtfcy.jpg', 'active', NULL, '2026-09-28 05:46:53', '2026-09-28 05:46:53'),
(2, 1, 1, 1, 'RE-2026-000002', 'Holly Ashley', 'Wallace Wilkins', 'Brenden Velazquez', 'Melanie Trevino', '+1 (426) 972-9915', '+1 (531) 242-4232', 'suloqodyce@mailinator.com', 'Earum culpa ut qui p', '1985-12-07', 'Id harum enim est do', 'Dhaka Motijheel', 'Necessitatibus est a', NULL, NULL, NULL, 'Hanna Chavez', 'Brother', '+1 (238) 966-5832', 'Veritatis at minim m', 'Ab officiis omnis nu', NULL, NULL, NULL, 'active', 'Quia aut sed eveniet', '2026-11-08 00:20:01', '2026-11-08 00:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `code`, `phone`, `email`, `address`, `logo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Safe Community', 'Ut velit neque in a', '+1 (711) 948-8044', 'dote@mailinator.com', 'Amet a quis officia', 'Sunt ratione pariatu', 1, '2026-09-27 05:46:27', '2026-09-27 05:46:27');

-- --------------------------------------------------------

--
-- Table structure for table `construction_costs`
--

CREATE TABLE `construction_costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `building_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `receipt_no` varchar(25) DEFAULT NULL,
  `building_client_assignment_id` bigint(20) UNSIGNED NOT NULL,
  `construction_cost_category_id` bigint(20) UNSIGNED NOT NULL,
  `cost_date` date NOT NULL,
  `payment_date` date DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `cheque_no` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_branch` varchar(255) DEFAULT NULL,
  `amount_words` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `construction_costs`
--

INSERT INTO `construction_costs` (`id`, `company_id`, `branch_id`, `project_id`, `building_id`, `client_id`, `receipt_no`, `building_client_assignment_id`, `construction_cost_category_id`, `cost_date`, `payment_date`, `amount`, `description`, `document`, `created_by`, `created_at`, `updated_at`, `purpose`, `payment_method`, `cheque_no`, `bank_name`, `bank_branch`, `amount_words`) VALUES
(1, 1, 1, 1, 1, 1, NULL, 1, 1, '2026-11-03', '2026-11-03', 1000.00, NULL, NULL, 2, '2026-11-03 05:33:41', '2026-11-03 05:33:41', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 1, 1, 2, 2, NULL, 2, 1, '2026-11-09', '2026-11-10', 150000.00, 'Good', NULL, 2, '2026-11-09 00:11:32', '2026-11-09 00:11:32', 'Installment', 'Cash', NULL, NULL, NULL, 'One Lakh Fifty Thousand Taka Only'),
(3, 1, 1, 1, 2, 2, NULL, 2, 1, '2026-11-09', '2026-11-11', 40000.00, NULL, NULL, 2, '2026-11-09 01:23:00', '2026-11-09 01:23:00', 'Booking', 'Cash', 'NA', 'NA', NULL, 'Forty Thousand Taka Only'),
(4, 1, 1, 1, 2, 2, 'MRC-20261109-AK34RX', 2, 1, '2026-11-09', '2026-11-11', 15000.00, NULL, NULL, 2, '2026-11-09 03:22:18', '2026-11-09 03:22:18', 'Booking', 'Cash', NULL, NULL, NULL, 'Fifteen Thousand Taka Only');

-- --------------------------------------------------------

--
-- Table structure for table `construction_cost_categories`
--

CREATE TABLE `construction_cost_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_code` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `construction_cost_categories`
--

INSERT INTO `construction_cost_categories` (`id`, `company_id`, `branch_id`, `project_id`, `category_name`, `category_code`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'trf', 'sdvcd dv xc', 'av', 'active', '2026-11-03 05:11:09', '2026-11-03 05:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lands`
--

CREATE TABLE `lands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `land_code` varchar(255) NOT NULL,
  `land_name` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `upazila` varchar(255) DEFAULT NULL,
  `mouza` varchar(255) DEFAULT NULL,
  `khatian_no` varchar(255) DEFAULT NULL,
  `dag_no` varchar(255) DEFAULT NULL,
  `jl_no` varchar(255) DEFAULT NULL,
  `total_land_size` decimal(12,4) DEFAULT NULL,
  `land_unit` varchar(255) NOT NULL DEFAULT 'decimal',
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_phone` varchar(255) DEFAULT NULL,
  `owner_nid` varchar(255) DEFAULT NULL,
  `purchase_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `purchase_date` date DEFAULT NULL,
  `status` enum('available','partially_sold','fully_sold','registered','closed') NOT NULL DEFAULT 'available',
  `description` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lands`
--

INSERT INTO `lands` (`id`, `company_id`, `branch_id`, `project_id`, `land_code`, `land_name`, `district`, `upazila`, `mouza`, `khatian_no`, `dag_no`, `jl_no`, `total_land_size`, `land_unit`, `owner_name`, `owner_phone`, `owner_nid`, `purchase_price`, `purchase_date`, `status`, `description`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'LAND010', 'Safe 7', 'Dhaka', 'Dhaka', 'Dhaka', '12', '59541', '56', 17.0000, 'katha', 'hjgdsu', '015497412654', '543985264', 15200.00, '2026-09-29', 'partially_sold', 'sdft vbg 65u vb', 'nrdt76 hggj f6ut yjtyj n', '2026-09-29 05:57:05', '2026-09-29 05:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `land_registrations`
--

CREATE TABLE `land_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `land_share_sale_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `registration_code` varchar(255) NOT NULL,
  `deed_no` varchar(255) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `sub_registry_office` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `upazila` varchar(255) DEFAULT NULL,
  `mouza` varchar(255) DEFAULT NULL,
  `khatian_no` varchar(255) DEFAULT NULL,
  `dag_no` varchar(255) DEFAULT NULL,
  `jl_no` varchar(255) DEFAULT NULL,
  `registered_land_size` decimal(12,4) DEFAULT NULL,
  `land_unit` varchar(255) NOT NULL DEFAULT 'decimal',
  `registration_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `other_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `deed_document` varchar(255) DEFAULT NULL,
  `registration_document` varchar(255) DEFAULT NULL,
  `other_document` varchar(255) DEFAULT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `land_registrations`
--

INSERT INTO `land_registrations` (`id`, `company_id`, `branch_id`, `project_id`, `land_share_sale_id`, `client_id`, `registration_code`, `deed_no`, `registration_date`, `sub_registry_office`, `district`, `upazila`, `mouza`, `khatian_no`, `dag_no`, `jl_no`, `registered_land_size`, `land_unit`, `registration_cost`, `other_cost`, `total_cost`, `deed_document`, `registration_document`, `other_document`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 'REG-2026-000001', '2321', '2026-10-01', 'Demra', 'Dhaka', 'Dhaka', 'Dhaka', '123', '595412', '3442', 1.1200, 'Decimal', 152000.00, 12400.00, 164400.00, NULL, NULL, NULL, 'completed', NULL, '2026-09-30 23:44:32', '2026-09-30 23:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `land_share_payments`
--

CREATE TABLE `land_share_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `land_share_sale_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method` enum('cash','bank','cheque','mobile_banking','online','other') NOT NULL DEFAULT 'cash',
  `transaction_no` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `cheque_no` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `land_share_payments`
--

INSERT INTO `land_share_payments` (`id`, `company_id`, `branch_id`, `project_id`, `land_share_sale_id`, `client_id`, `receipt_no`, `payment_date`, `amount`, `payment_method`, `transaction_no`, `bank_name`, `cheque_no`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 'LSP-2026-000001', '2026-09-29', 1000.00, 'cash', '51498419', 'NA', 'NA', 're6tm ghj m', '2026-09-29 05:59:59', '2026-09-29 05:59:59'),
(2, 1, 1, 1, 1, 1, 'LSP-2026-000002', '2026-09-30', 14064.80, 'cash', 'A7454s77', 'N/A', 'N/A', NULL, '2026-09-30 00:12:04', '2026-09-30 00:12:04');

-- --------------------------------------------------------

--
-- Table structure for table `land_share_sales`
--

CREATE TABLE `land_share_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `land_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `sale_code` varchar(255) NOT NULL,
  `sale_date` date NOT NULL,
  `share_size` decimal(12,4) NOT NULL,
  `share_unit` varchar(255) NOT NULL DEFAULT 'decimal',
  `price_per_unit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `land_share_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('draft','confirmed','cancelled','completed') NOT NULL DEFAULT 'draft',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `land_share_sales`
--

INSERT INTO `land_share_sales` (`id`, `company_id`, `branch_id`, `project_id`, `land_id`, `client_id`, `sale_code`, `sale_date`, `share_size`, `share_unit`, `price_per_unit`, `land_share_price`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 'LSS-2026-000001', '2026-09-29', 1.2554, 'katha', 12000.00, 15064.80, 'confirmed', 'rt trh ghn cftgh c', '2026-09-29 05:58:56', '2026-09-30 08:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_09_26_064901_create_companies_table', 1),
(4, '2026_09_26_071021_create_branches_table', 1),
(5, '2026_09_26_071022_create_users_table', 1),
(6, '2026_09_27_045706_create_projects_table', 1),
(7, '2026_09_27_062255_create_permission_tables', 1),
(8, '2026_09_27_115531_create_clients_table', 2),
(9, '2026_09_28_135621_create_lands_table', 3),
(10, '2026_09_29_050036_create_land_share_sales_table', 4),
(11, '2026_09_29_061553_create_land_share_payments_table', 4),
(12, '2026_09_29_121234_create_land_registrations_table', 5),
(13, '2026_10_01_110857_create_rajuk_approvals_table', 6),
(14, '2026_11_02_061539_create_buildings_table', 7),
(15, '2026_11_03_102219_create_construction_cost_categories_table', 8),
(16, '2026_11_03_111414_create_construction_costs_table', 9),
(17, '2026_11_09_055930_add_receipt_fields_to_construction_costs_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(2, 'dashboard.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(3, 'dashboard.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(4, 'dashboard.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(5, 'dashboard.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(6, 'dashboard.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(7, 'dashboard.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(8, 'dashboard.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(9, 'company.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(10, 'company.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(11, 'company.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(12, 'company.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(13, 'company.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(14, 'company.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(15, 'company.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(16, 'company.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(17, 'branch.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(18, 'branch.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(19, 'branch.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(20, 'branch.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(21, 'branch.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(22, 'branch.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(23, 'branch.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(24, 'branch.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(25, 'project.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(26, 'project.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(27, 'project.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(28, 'project.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(29, 'project.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(30, 'project.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(31, 'project.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(32, 'project.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(33, 'client.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(34, 'client.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(35, 'client.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(36, 'client.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(37, 'client.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(38, 'client.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(39, 'client.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(40, 'client.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(41, 'land.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(42, 'land.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(43, 'land.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(44, 'land.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(45, 'land.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(46, 'land.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(47, 'land.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(48, 'land.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(49, 'land-share-sale.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(50, 'land-share-sale.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(51, 'land-share-sale.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(52, 'land-share-sale.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(53, 'land-share-sale.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(54, 'land-share-sale.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(55, 'land-share-sale.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(56, 'land-share-sale.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(57, 'land-share-payment.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(58, 'land-share-payment.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(59, 'land-share-payment.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(60, 'land-share-payment.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(61, 'land-share-payment.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(62, 'land-share-payment.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(63, 'land-share-payment.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(64, 'land-share-payment.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(65, 'land-registration.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(66, 'land-registration.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(67, 'land-registration.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(68, 'land-registration.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(69, 'land-registration.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(70, 'land-registration.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(71, 'land-registration.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(72, 'land-registration.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(73, 'rajuk.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(74, 'rajuk.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(75, 'rajuk.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(76, 'rajuk.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(77, 'rajuk.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(78, 'rajuk.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(79, 'rajuk.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(80, 'rajuk.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(81, 'building.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(82, 'building.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(83, 'building.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(84, 'building.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(85, 'building.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(86, 'building.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(87, 'building.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(88, 'building.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(89, 'floor.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(90, 'floor.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(91, 'floor.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(92, 'floor.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(93, 'floor.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(94, 'floor.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(95, 'floor.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(96, 'floor.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(97, 'flat.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(98, 'flat.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(99, 'flat.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(100, 'flat.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(101, 'flat.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(102, 'flat.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(103, 'flat.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(104, 'flat.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(105, 'construction.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(106, 'construction.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(107, 'construction.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(108, 'construction.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(109, 'construction.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(110, 'construction.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(111, 'construction.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(112, 'construction.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(113, 'boq.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(114, 'boq.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(115, 'boq.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(116, 'boq.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(117, 'boq.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(118, 'boq.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(119, 'boq.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(120, 'boq.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(121, 'procurement.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(122, 'procurement.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(123, 'procurement.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(124, 'procurement.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(125, 'procurement.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(126, 'procurement.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(127, 'procurement.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(128, 'procurement.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(129, 'inventory.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(130, 'inventory.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(131, 'inventory.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(132, 'inventory.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(133, 'inventory.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(134, 'inventory.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(135, 'inventory.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(136, 'inventory.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(137, 'contractor.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(138, 'contractor.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(139, 'contractor.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(140, 'contractor.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(141, 'contractor.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(142, 'contractor.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(143, 'contractor.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(144, 'contractor.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(145, 'construction-cost.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(146, 'construction-cost.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(147, 'construction-cost.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(148, 'construction-cost.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(149, 'construction-cost.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(150, 'construction-cost.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(151, 'construction-cost.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(152, 'construction-cost.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(153, 'service-charge.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(154, 'service-charge.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(155, 'service-charge.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(156, 'service-charge.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(157, 'service-charge.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(158, 'service-charge.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(159, 'service-charge.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(160, 'service-charge.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(161, 'installment.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(162, 'installment.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(163, 'installment.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(164, 'installment.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(165, 'installment.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(166, 'installment.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(167, 'installment.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(168, 'installment.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(169, 'payment.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(170, 'payment.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(171, 'payment.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(172, 'payment.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(173, 'payment.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(174, 'payment.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(175, 'payment.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(176, 'payment.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(177, 'payment-point.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(178, 'payment-point.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(179, 'payment-point.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(180, 'payment-point.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(181, 'payment-point.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(182, 'payment-point.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(183, 'payment-point.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(184, 'payment-point.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(185, 'flat-choice.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(186, 'flat-choice.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(187, 'flat-choice.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(188, 'flat-choice.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(189, 'flat-choice.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(190, 'flat-choice.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(191, 'flat-choice.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(192, 'flat-choice.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(193, 'flat-allocation.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(194, 'flat-allocation.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(195, 'flat-allocation.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(196, 'flat-allocation.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(197, 'flat-allocation.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(198, 'flat-allocation.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(199, 'flat-allocation.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(200, 'flat-allocation.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(201, 'agreement.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(202, 'agreement.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(203, 'agreement.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(204, 'agreement.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(205, 'agreement.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(206, 'agreement.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(207, 'agreement.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(208, 'agreement.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(209, 'handover.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(210, 'handover.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(211, 'handover.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(212, 'handover.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(213, 'handover.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(214, 'handover.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(215, 'handover.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(216, 'handover.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(217, 'complaint.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(218, 'complaint.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(219, 'complaint.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(220, 'complaint.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(221, 'complaint.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(222, 'complaint.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(223, 'complaint.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(224, 'complaint.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(225, 'income.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(226, 'income.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(227, 'income.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(228, 'income.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(229, 'income.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(230, 'income.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(231, 'income.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(232, 'income.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(233, 'expense.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(234, 'expense.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(235, 'expense.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(236, 'expense.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(237, 'expense.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(238, 'expense.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(239, 'expense.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(240, 'expense.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(241, 'finance.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(242, 'finance.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(243, 'finance.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(244, 'finance.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(245, 'finance.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(246, 'finance.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(247, 'finance.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(248, 'finance.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(249, 'employee.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(250, 'employee.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(251, 'employee.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(252, 'employee.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(253, 'employee.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(254, 'employee.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(255, 'employee.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(256, 'employee.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(257, 'payroll.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(258, 'payroll.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(259, 'payroll.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(260, 'payroll.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(261, 'payroll.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(262, 'payroll.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(263, 'payroll.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(264, 'payroll.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(265, 'crm.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(266, 'crm.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(267, 'crm.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(268, 'crm.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(269, 'crm.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(270, 'crm.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(271, 'crm.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(272, 'crm.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(273, 'document.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(274, 'document.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(275, 'document.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(276, 'document.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(277, 'document.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(278, 'document.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(279, 'document.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(280, 'document.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(281, 'notification.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(282, 'notification.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(283, 'notification.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(284, 'notification.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(285, 'notification.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(286, 'notification.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(287, 'notification.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(288, 'notification.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(289, 'report.view', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(290, 'report.create', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(291, 'report.edit', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(292, 'report.delete', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(293, 'report.print', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(294, 'report.approve', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(295, 'report.payment', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(296, 'report.export', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `project_code` varchar(255) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_type` varchar(255) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `key_highlights` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expected_completion_date` date DEFAULT NULL,
  `status` enum('planning','ongoing','completed','on_hold','cancelled') NOT NULL DEFAULT 'planning',
  `share_status` enum('available','limited','sold_out','closed') NOT NULL DEFAULT 'available',
  `working_status` enum('not_started','ongoing','completed','on_hold') NOT NULL DEFAULT 'not_started',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `company_id`, `branch_id`, `project_code`, `project_name`, `project_type`, `location`, `size`, `image`, `key_highlights`, `start_date`, `expected_completion_date`, `status`, `share_status`, `working_status`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'SGF-001', 'Safe 1', 'Land', 'st bsrt tyuj mdftg', '10510', 'projects/wm1cW6rprX93skLwTSRnNljXegLgxGsOrUWd0qLg.jpg', 'dfg sfgh dgb bvnd gh rt furjhf 3ynbt, ytfcjhmyctmjhtvr fxdghfzxd mnvbn b', '2026-09-27', '2029-06-27', 'ongoing', 'sold_out', 'not_started', NULL, '2026-09-27 05:54:30', '2026-09-27 05:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `rajuk_approvals`
--

CREATE TABLE `rajuk_approvals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `application_no` varchar(255) DEFAULT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `applicant_phone` varchar(20) DEFAULT NULL,
  `plot_number` varchar(255) DEFAULT NULL,
  `road_number` varchar(255) DEFAULT NULL,
  `block` varchar(255) DEFAULT NULL,
  `mouza` varchar(255) DEFAULT NULL,
  `land_area` varchar(255) DEFAULT NULL,
  `plan_type` varchar(255) DEFAULT NULL,
  `number_of_floors` int(10) UNSIGNED DEFAULT NULL,
  `number_of_flats` int(10) UNSIGNED DEFAULT NULL,
  `architect_name` varchar(255) DEFAULT NULL,
  `consultant_name` varchar(255) DEFAULT NULL,
  `application_date` date DEFAULT NULL,
  `submission_date` date DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `approval_number` varchar(255) DEFAULT NULL,
  `status` enum('draft','submitted','under_review','approved','rejected','on_hold') NOT NULL DEFAULT 'draft',
  `remarks` text DEFAULT NULL,
  `plan_document` varchar(255) DEFAULT NULL,
  `approval_document` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rajuk_approvals`
--

INSERT INTO `rajuk_approvals` (`id`, `company_id`, `branch_id`, `project_id`, `application_no`, `applicant_name`, `applicant_phone`, `plot_number`, `road_number`, `block`, `mouza`, `land_area`, `plan_type`, `number_of_floors`, `number_of_flats`, `architect_name`, `consultant_name`, `application_date`, `submission_date`, `approval_date`, `approval_number`, `status`, `remarks`, `plan_document`, `approval_document`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '95282', 'Avc', '0101811582', '4353', '435', 'h', 'Dhaka', '5', 'Residential', 45, 345, 'Craig Allison', 'Haley Olson', '2026-10-01', '2026-10-01', '2026-10-01', '15', 'approved', NULL, NULL, NULL, '2026-10-01 06:46:09', '2026-10-01 07:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(2, 'Company Admin', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(3, 'Branch Manager', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(4, 'Project Manager', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(5, 'Sales Manager', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(6, 'Sales Executive', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(7, 'Accountant', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(8, 'Land Officer', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(9, 'Construction Manager', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(10, 'Procurement Officer', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(11, 'Store Manager', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(12, 'HR', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(13, 'Reception', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51'),
(14, 'Viewer', 'web', '2026-09-27 02:16:51', '2026-09-27 02:16:51');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qyv7F0gXhRbizduwUVbZNl9MnVOm8gvGyRE63QeN', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiam1zc1hIWVZBRDBqZGtXMUtSc2R1QlRET1RSUmVpQkhsUUR0MzZGUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9jb25zdHJ1Y3Rpb24tY29zdHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1794216277);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `branch_id`, `name`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Test User', 'test@gmail.com', '2026-09-27 02:16:50', '$2y$12$WjFTGxFrbE8L30/c5zwQmOHXZPUW02MMvyxK.kGMh1WuW8pj1.U9y', 1, 'oV2l2MBESm', '2026-09-27 02:16:51', '2026-09-27 05:46:47'),
(2, NULL, NULL, 'Super Admin', 'admin@gmail.com', NULL, '$2y$12$Q0hmxAAuZ34Th.WzGikYk.dm/FM4ioRtHeEIDR2Rx.nM1VRLmO8Pi', 1, NULL, '2026-09-27 02:16:52', '2026-09-27 02:16:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_company_id_code_unique` (`company_id`,`code`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buildings_project_id_foreign` (`project_id`),
  ADD KEY `buildings_rajuk_approval_id_foreign` (`rajuk_approval_id`),
  ADD KEY `buildings_scope_index` (`company_id`,`branch_id`,`project_id`),
  ADD KEY `buildings_status_index` (`status`),
  ADD KEY `buildings_construction_start_date_index` (`construction_start_date`),
  ADD KEY `buildings_company_id_index` (`company_id`),
  ADD KEY `buildings_branch_id_index` (`branch_id`);

--
-- Indexes for table `building_client_assignments`
--
ALTER TABLE `building_client_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `building_client_unique` (`building_id`,`client_id`),
  ADD KEY `building_client_assignments_company_id_foreign` (`company_id`),
  ADD KEY `building_client_assignments_branch_id_foreign` (`branch_id`),
  ADD KEY `building_client_assignments_project_id_foreign` (`project_id`),
  ADD KEY `building_client_assignments_client_id_foreign` (`client_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_client_code_unique` (`client_code`),
  ADD KEY `clients_company_id_foreign` (`company_id`),
  ADD KEY `clients_project_id_foreign` (`project_id`),
  ADD KEY `clients_branch_id_project_id_index` (`branch_id`,`project_id`),
  ADD KEY `clients_nid_index` (`nid`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_code_unique` (`code`);

--
-- Indexes for table `construction_costs`
--
ALTER TABLE `construction_costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `construction_costs_branch_id_foreign` (`branch_id`),
  ADD KEY `construction_costs_project_id_foreign` (`project_id`),
  ADD KEY `construction_costs_client_id_foreign` (`client_id`),
  ADD KEY `construction_costs_building_client_assignment_id_foreign` (`building_client_assignment_id`),
  ADD KEY `construction_costs_construction_cost_category_id_foreign` (`construction_cost_category_id`),
  ADD KEY `construction_costs_created_by_foreign` (`created_by`),
  ADD KEY `construction_costs_company_id_branch_id_project_id_index` (`company_id`,`branch_id`,`project_id`),
  ADD KEY `construction_costs_building_id_client_id_index` (`building_id`,`client_id`),
  ADD KEY `construction_costs_cost_date_index` (`cost_date`);

--
-- Indexes for table `construction_cost_categories`
--
ALTER TABLE `construction_cost_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `construction_cost_category_project_name_unique` (`project_id`,`category_name`),
  ADD KEY `construction_cost_categories_branch_id_foreign` (`branch_id`),
  ADD KEY `construction_cost_categories_company_id_branch_id_index` (`company_id`,`branch_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lands`
--
ALTER TABLE `lands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lands_branch_id_land_code_unique` (`branch_id`,`land_code`),
  ADD KEY `lands_company_id_foreign` (`company_id`),
  ADD KEY `lands_project_id_foreign` (`project_id`),
  ADD KEY `lands_branch_id_project_id_index` (`branch_id`,`project_id`);

--
-- Indexes for table `land_registrations`
--
ALTER TABLE `land_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `land_registrations_branch_id_registration_code_unique` (`branch_id`,`registration_code`),
  ADD KEY `land_registrations_company_id_foreign` (`company_id`),
  ADD KEY `land_registrations_project_id_foreign` (`project_id`),
  ADD KEY `land_registrations_land_share_sale_id_foreign` (`land_share_sale_id`),
  ADD KEY `land_registrations_client_id_foreign` (`client_id`),
  ADD KEY `land_registrations_branch_id_project_id_index` (`branch_id`,`project_id`),
  ADD KEY `land_registrations_registration_date_index` (`registration_date`);

--
-- Indexes for table `land_share_payments`
--
ALTER TABLE `land_share_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `land_share_payments_branch_id_receipt_no_unique` (`branch_id`,`receipt_no`),
  ADD KEY `land_share_payments_company_id_foreign` (`company_id`),
  ADD KEY `land_share_payments_project_id_foreign` (`project_id`),
  ADD KEY `land_share_payments_client_id_foreign` (`client_id`),
  ADD KEY `land_share_payments_branch_id_project_id_index` (`branch_id`,`project_id`),
  ADD KEY `land_share_payments_land_share_sale_id_client_id_index` (`land_share_sale_id`,`client_id`),
  ADD KEY `land_share_payments_payment_date_index` (`payment_date`);

--
-- Indexes for table `land_share_sales`
--
ALTER TABLE `land_share_sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `land_share_sales_branch_id_sale_code_unique` (`branch_id`,`sale_code`),
  ADD KEY `land_share_sales_company_id_foreign` (`company_id`),
  ADD KEY `land_share_sales_project_id_foreign` (`project_id`),
  ADD KEY `land_share_sales_client_id_foreign` (`client_id`),
  ADD KEY `land_share_sales_branch_id_project_id_index` (`branch_id`,`project_id`),
  ADD KEY `land_share_sales_land_id_client_id_index` (`land_id`,`client_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_branch_id_project_code_unique` (`branch_id`,`project_code`),
  ADD KEY `projects_company_id_foreign` (`company_id`);

--
-- Indexes for table `rajuk_approvals`
--
ALTER TABLE `rajuk_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rajuk_approvals_project_id_foreign` (`project_id`),
  ADD KEY `rajuk_scope_index` (`company_id`,`branch_id`,`project_id`),
  ADD KEY `rajuk_approvals_status_index` (`status`),
  ADD KEY `rajuk_approvals_application_date_index` (`application_date`),
  ADD KEY `rajuk_approvals_company_id_index` (`company_id`),
  ADD KEY `rajuk_approvals_branch_id_index` (`branch_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_company_id_foreign` (`company_id`),
  ADD KEY `users_branch_id_foreign` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `building_client_assignments`
--
ALTER TABLE `building_client_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `construction_costs`
--
ALTER TABLE `construction_costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `construction_cost_categories`
--
ALTER TABLE `construction_cost_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lands`
--
ALTER TABLE `lands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `land_registrations`
--
ALTER TABLE `land_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `land_share_payments`
--
ALTER TABLE `land_share_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `land_share_sales`
--
ALTER TABLE `land_share_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rajuk_approvals`
--
ALTER TABLE `rajuk_approvals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buildings`
--
ALTER TABLE `buildings`
  ADD CONSTRAINT `buildings_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `buildings_rajuk_approval_id_foreign` FOREIGN KEY (`rajuk_approval_id`) REFERENCES `rajuk_approvals` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `building_client_assignments`
--
ALTER TABLE `building_client_assignments`
  ADD CONSTRAINT `building_client_assignments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `building_client_assignments_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `building_client_assignments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `building_client_assignments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `building_client_assignments_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clients_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clients_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `construction_costs`
--
ALTER TABLE `construction_costs`
  ADD CONSTRAINT `construction_costs_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `construction_costs_building_client_assignment_id_foreign` FOREIGN KEY (`building_client_assignment_id`) REFERENCES `building_client_assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `construction_costs_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `construction_costs_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `construction_costs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `construction_costs_construction_cost_category_id_foreign` FOREIGN KEY (`construction_cost_category_id`) REFERENCES `construction_cost_categories` (`id`),
  ADD CONSTRAINT `construction_costs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `construction_costs_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `construction_cost_categories`
--
ALTER TABLE `construction_cost_categories`
  ADD CONSTRAINT `construction_cost_categories_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `construction_cost_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `construction_cost_categories_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lands`
--
ALTER TABLE `lands`
  ADD CONSTRAINT `lands_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lands_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lands_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `land_registrations`
--
ALTER TABLE `land_registrations`
  ADD CONSTRAINT `land_registrations_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `land_registrations_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `land_registrations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `land_registrations_land_share_sale_id_foreign` FOREIGN KEY (`land_share_sale_id`) REFERENCES `land_share_sales` (`id`),
  ADD CONSTRAINT `land_registrations_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `land_share_payments`
--
ALTER TABLE `land_share_payments`
  ADD CONSTRAINT `land_share_payments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `land_share_payments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `land_share_payments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `land_share_payments_land_share_sale_id_foreign` FOREIGN KEY (`land_share_sale_id`) REFERENCES `land_share_sales` (`id`),
  ADD CONSTRAINT `land_share_payments_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `land_share_sales`
--
ALTER TABLE `land_share_sales`
  ADD CONSTRAINT `land_share_sales_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `land_share_sales_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `land_share_sales_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `land_share_sales_land_id_foreign` FOREIGN KEY (`land_id`) REFERENCES `lands` (`id`),
  ADD CONSTRAINT `land_share_sales_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rajuk_approvals`
--
ALTER TABLE `rajuk_approvals`
  ADD CONSTRAINT `rajuk_approvals_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
