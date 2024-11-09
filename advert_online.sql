-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 09, 2024 at 09:25 AM
-- Server version: 8.0.39-0ubuntu0.24.04.2
-- PHP Version: 8.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `advert_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone_switch_at` timestamp NULL DEFAULT NULL,
  `account_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `business_name`, `timezone`, `timezone_switch_at`, `account_id`, `salt`, `approval_status`, `deleted`, `created_at`, `updated_at`, `deleted_at`, `user_id`) VALUES
(1, 'FurniShop', 'Furni Inc.', 'America/New_York', '2023-01-01 08:00:00', '18ce54ayf01', 'salt123', 'ACCEPTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 1),
(2, 'ElectroHub', 'Electro Co.', 'America/Los_Angeles', '2023-01-02 08:00:00', '18ce54ayf02', 'salt234', 'PENDING', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 22),
(3, 'StyleMax', 'Style Corp.', 'America/Chicago', '2023-01-03 08:00:00', '18ce54ayf03', 'salt345', 'ACCEPTED', 1, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 43),
(4, 'HomeEssentials', 'Home Ess.', 'Europe/London', '2023-01-04 08:00:00', '18ce54ayf04', 'salt456', 'REJECTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 1),
(5, 'BeautyLine', 'Beauty Ltd.', 'Asia/Tokyo', '2023-01-05 08:00:00', '18ce54ayf05', 'salt567', 'ACCEPTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 22),
(6, 'KidsWorld', 'Kids World Co.', 'America/Denver', '2023-01-06 08:00:00', '18ce54ayf06', 'salt678', 'PENDING', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 43),
(7, 'TechPulse', 'Tech Solutions', 'America/New_York', '2023-01-07 08:00:00', '18ce54ayf07', 'salt789', 'ACCEPTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 1),
(8, 'AutoGear', 'Auto Inc.', 'America/Los_Angeles', '2023-01-08 08:00:00', '18ce54ayf08', 'salt890', 'REJECTED', 1, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 22),
(9, 'SportPro', 'Sporty Co.', 'Europe/Berlin', '2023-01-09 08:00:00', '18ce54ayf09', 'salt901', 'ACCEPTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 43),
(10, 'PetPalace', 'Pet Palace', 'America/New_York', '2023-01-10 08:00:00', '18ce54ayf10', 'salt012', 'PENDING', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 1),
(11, 'HealthPoint', 'Health Ltd.', 'America/Los_Angeles', '2023-01-11 08:00:00', '18ce54ayf11', 'salt1234', 'ACCEPTED', 1, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 22),
(12, 'EcoStore', 'Eco Solutions', 'America/Chicago', '2023-01-12 08:00:00', '18ce54ayf12', 'salt2345', 'REJECTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 43),
(13, 'GourmetMart', 'Gourmet Market', 'America/New_York', '2023-01-13 08:00:00', '18ce54ayf13', 'salt3456', 'ACCEPTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 1),
(14, 'BabyBoom', 'Baby Products', 'America/Los_Angeles', '2023-01-14 08:00:00', '18ce54ayf14', 'salt4567', 'PENDING', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 22),
(15, 'GadgetPlus', 'Gadgets Inc.', 'Asia/Shanghai', '2023-01-15 08:00:00', '18ce54ayf15', 'salt5678', 'ACCEPTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 43),
(16, 'BookBarn', 'Book Hub', 'America/New_York', '2023-01-16 08:00:00', '18ce54ayf16', 'salt6789', 'REJECTED', 1, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 1),
(17, 'FashionFiesta', 'Fashion Fiesta Co.', 'America/Los_Angeles', '2023-01-17 08:00:00', '18ce54ayf17', 'salt7890', 'ACCEPTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 22),
(18, 'HomePlus', 'Home Goods', 'America/Chicago', '2023-01-18 08:00:00', '18ce54ayf18', 'salt8901', 'PENDING', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 43),
(19, 'TechiesHub', 'Tech Hub', 'America/New_York', '2023-01-19 08:00:00', '18ce54ayf19', 'salt9012', 'ACCEPTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 1),
(20, 'TravelNow', 'Travel Now Inc.', 'Europe/London', '2023-01-20 08:00:00', '18ce54ayf20', 'salt0123', 'REJECTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 22),
(21, 'ToysMania', 'Toy Kingdom', 'America/Denver', '2023-01-21 08:00:00', '18ce54ayf21', 'salt12345', 'ACCEPTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 43),
(22, 'MusicFest', 'Music Festival', 'America/New_York', '2023-01-22 08:00:00', '18ce54ayf22', 'salt23456', 'PENDING', 1, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 1),
(23, 'KitchenKing', 'Kitchen Supplies', 'Asia/Tokyo', '2023-01-23 08:00:00', '18ce54ayf23', 'salt34567', 'ACCEPTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 22),
(24, 'FitnessLife', 'Fitness Center', 'America/Los_Angeles', '2023-01-24 08:00:00', '18ce54ayf24', 'salt45678', 'REJECTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 43),
(25, 'GardenWorld', 'Garden Supplies', 'Europe/Paris', '2023-01-25 08:00:00', '18ce54ayf25', 'salt56789', 'ACCEPTED', 0, '2024-10-28 14:32:36', '2024-10-28 14:32:36', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `accounts_x`
--

CREATE TABLE `accounts_x` (
  `id` bigint UNSIGNED NOT NULL,
  `account_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone_switch_at` timestamp NULL DEFAULT NULL,
  `business_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2024-08-09 23:35:23', '2024-08-09 23:35:23', NULL),
(2, 2, '2024-08-09 23:35:23', '2024-08-09 23:35:23', NULL),
(3, 1, '2024-08-19 23:13:06', '2024-08-19 23:13:06', NULL),
(4, 2, '2024-08-19 23:13:06', '2024-08-19 23:13:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ads_x_metrics`
--

CREATE TABLE `ads_x_metrics` (
  `id` bigint UNSIGNED NOT NULL,
  `account_id` bigint UNSIGNED NOT NULL,
  `metric_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `placement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `granularity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metrics_data` json NOT NULL,
  `last_fetched_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ad_x_analytics`
--

CREATE TABLE `ad_x_analytics` (
  `id` bigint UNSIGNED NOT NULL,
  `data_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ad_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_series_length` int NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `granularity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_analytics` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ad_x_analytics`
--

INSERT INTO `ad_x_analytics` (`id`, `data_type`, `account_id`, `ad_id`, `time_series_length`, `start_time`, `end_time`, `granularity`, `data_analytics`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'stats', '18ce54ayf01', 'ad001', 12, '2023-10-01 00:00:00', '2023-10-01 11:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55], \"engagements\": [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110], \"impressions\": [0, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100], \"conversion_site_visits\": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(2, 'stats', '18ce54ayf01', 'ad001_2', 12, '2023-10-01 12:00:00', '2023-10-01 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [1, 6, 11, 16, 21, 26, 31, 36, 41, 46, 51, 56], \"engagements\": [5, 20, 30, 50, 70, 90, 110, 130, 150, 170, 190, 210], \"impressions\": [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200], \"conversion_site_visits\": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(3, 'stats', '18ce54ayf02', 'ad002', 18, '2023-10-02 00:00:00', '2023-10-02 17:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [0, 8, 16, 24, 32, 40, 48, 56, 64, 72, 80, 88, 96, 104, 112, 120], \"engagements\": [0, 15, 30, 45, 60, 75, 90, 105, 120, 135, 150, 165, 180, 195, 210, 225], \"impressions\": [0, 150, 300, 450, 600, 750, 900, 1050, 1200, 1350, 1500, 1650, 1800, 1950, 2100, 2250, 2400, 2550], \"conversion_site_visits\": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(4, 'stats', '18ce54ayf02', 'ad002_2', 18, '2023-10-02 18:00:00', '2023-10-02 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [1, 12, 23, 34, 45, 56, 67, 78, 89, 100, 111, 122], \"engagements\": [15, 35, 55, 75, 95, 115, 135, 155, 175, 195, 215, 235], \"impressions\": [150, 300, 450, 600, 750, 900, 1050, 1200, 1350, 1500, 1650, 1800], \"conversion_site_visits\": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(5, 'stats', '18ce54ayf03', 'ad003', 24, '2023-10-03 00:00:00', '2023-10-03 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [0, 12, 24, 36, 48, 60, 72, 84, 96, 108, 120, 132, 144, 156, 168, 180, 192, 204, 216, 228], \"engagements\": [0, 20, 40, 60, 80, 100, 120, 140, 160, 180, 200, 220, 240, 260, 280, 300, 320, 340, 360, 380, 400], \"impressions\": [0, 200, 400, 600, 800, 1000, 1200, 1400, 1600, 1800, 2000, 2200, 2400, 2600, 2800, 3000, 3200, 3400, 3600, 3800, 4000, 4200, 4400, 4600], \"conversion_site_visits\": [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(6, 'stats', '18ce54ayf03', 'ad003_2', 24, '2023-10-04 00:00:00', '2023-10-04 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [4, 16, 28, 40, 52, 64, 76, 88, 100, 112, 124, 136], \"engagements\": [20, 40, 60, 80, 100, 120, 140, 160, 180, 200, 220, 240], \"impressions\": [200, 400, 600, 800, 1000, 1200, 1400, 1600, 1800, 2000, 2200, 2400], \"conversion_site_visits\": [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(7, 'stats', '18ce54ayf04', 'ad004', 6, '2023-10-04 00:00:00', '2023-10-04 05:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [2, 4, 6, 8, 10, 12], \"engagements\": [10, 20, 30, 40, 50, 60], \"impressions\": [100, 200, 300, 400, 500, 600], \"conversion_site_visits\": [1, 2, 3, 4, 5, 6]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(8, 'stats', '18ce54ayf04', 'ad004_2', 6, '2023-10-04 06:00:00', '2023-10-04 11:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [4, 8, 12, 16, 20, 24], \"engagements\": [20, 30, 40, 60, 80, 100], \"impressions\": [200, 300, 400, 500, 600, 700], \"conversion_site_visits\": [2, 4, 6, 8, 10, 12]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(9, 'stats', '18ce54ayf04', 'ad004_3', 6, '2023-10-04 12:00:00', '2023-10-04 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [6, 12, 18, 24, 30, 36], \"engagements\": [30, 50, 70, 90, 110, 130], \"impressions\": [300, 400, 500, 600, 700, 800], \"conversion_site_visits\": [3, 6, 9, 12, 15, 18]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(10, 'stats', '18ce54ayf05', 'ad005', 18, '2023-10-05 00:00:00', '2023-10-05 17:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140], \"engagements\": [0, 25, 50, 75, 100, 125, 150, 175, 200, 225, 250, 275, 300, 325, 350, 375], \"impressions\": [0, 250, 500, 750, 1000, 1250, 1500, 1750, 2000, 2250, 2500, 2750, 3000, 3250, 3500, 3750, 4000, 4250], \"conversion_site_visits\": [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(11, 'stats', '18ce54ayf05', 'ad005_2', 18, '2023-10-05 18:00:00', '2023-10-05 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [5, 15, 25, 35, 45, 55, 65, 75, 85, 95, 105, 115], \"engagements\": [25, 50, 75, 100, 125, 150, 175, 200, 225, 250, 275, 300, 325], \"impressions\": [250, 500, 750, 1000, 1250, 1500, 1750, 2000, 2250, 2500, 2750, 3000], \"conversion_site_visits\": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(12, 'stats', '18ce54ayf05', 'ad005_3', 18, '2023-10-06 00:00:00', '2023-10-06 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130], \"engagements\": [50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 650], \"impressions\": [500, 750, 1000, 1250, 1500, 1750, 2000, 2250, 2500, 2750, 3000, 3250], \"conversion_site_visits\": [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(13, 'stats', '18ce54ayf06', 'ad006', 24, '2023-10-06 00:00:00', '2023-10-06 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [0, 15, 30, 45, 60, 75, 90, 105, 120, 135, 150, 165, 180, 195, 210], \"engagements\": [0, 30, 60, 90, 120, 150, 180, 210, 240, 270, 300, 330, 360, 390, 420, 450, 480, 510, 540, 570, 600], \"impressions\": [0, 300, 600, 900, 1200, 1500, 1800, 2100, 2400, 2700, 3000, 3300, 3600, 3900, 4200, 4500, 4800, 5100, 5400, 5700, 6000, 6300, 6600, 6900], \"conversion_site_visits\": [0, 3, 6, 9, 12, 15, 18, 21, 24, 27, 30, 33, 36, 39]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(14, 'stats', '18ce54ayf06', 'ad006_2', 24, '2023-10-07 00:00:00', '2023-10-07 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [5, 25, 35, 45, 55, 65, 75, 85, 95, 105, 115, 125], \"engagements\": [30, 60, 90, 120, 150, 180, 210, 240, 270, 300, 330, 360], \"impressions\": [300, 600, 900, 1200, 1500, 1800, 2100, 2400, 2700, 3000, 3300, 3600], \"conversion_site_visits\": [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(15, 'stats', '18ce54ayf06', 'ad006_3', 24, '2023-10-08 00:00:00', '2023-10-08 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [10, 30, 50, 70, 90, 110, 130, 150, 170, 190, 210, 230], \"engagements\": [60, 90, 120, 150, 180, 210, 240, 270, 300, 330, 360], \"impressions\": [600, 900, 1200, 1500, 1800, 2100, 2400, 2700, 3000, 3300, 3600], \"conversion_site_visits\": [3, 6, 9, 12, 15, 18, 21, 24, 27, 30, 33, 36]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(16, 'stats', '18ce54ayf07', 'ad007', 12, '2023-10-09 00:00:00', '2023-10-09 11:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23], \"engagements\": [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60], \"impressions\": [50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600], \"conversion_site_visits\": [1, 2, 3, 4, 5, 6]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(17, 'stats', '18ce54ayf07', 'ad007_2', 12, '2023-10-09 12:00:00', '2023-10-09 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [2, 5, 8, 11, 14, 17, 20, 23, 26, 29, 32, 35], \"engagements\": [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120], \"impressions\": [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200], \"conversion_site_visits\": [2, 4, 6, 8, 10, 12]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(18, 'stats', '18ce54ayf08', 'ad008', 24, '2023-10-10 00:00:00', '2023-10-10 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20], \"engagements\": [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 160, 170, 180, 190, 200, 210, 220, 230, 240], \"impressions\": [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 1600, 1700, 1800, 1900, 2000, 2100, 2200, 2300, 2400], \"conversion_site_visits\": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(19, 'stats', '18ce54ayf08', 'ad008_2', 24, '2023-10-11 00:00:00', '2023-10-11 23:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24], \"engagements\": [20, 40, 60, 80, 100, 120, 140, 160, 180, 200, 220, 240, 260], \"impressions\": [200, 400, 600, 800, 1000, 1200, 1400, 1600, 1800, 2000, 2200, 2400], \"conversion_site_visits\": [2, 4, 6, 8, 10, 12]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(20, 'stats', '18ce54ayf09', 'ad009', 6, '2023-10-12 00:00:00', '2023-10-12 05:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [3, 6, 9, 12, 15, 18], \"engagements\": [15, 30, 45, 60, 75, 90], \"impressions\": [150, 300, 450, 600, 750, 900], \"conversion_site_visits\": [1, 2, 3, 4, 5, 6]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL),
(21, 'stats', '18ce54ayf09', 'ad009_2', 6, '2023-10-12 06:00:00', '2023-10-12 11:59:59', 'HOUR', '[{\"metrics\": {\"clicks\": [6, 9, 12, 15, 18, 21], \"engagements\": [30, 45, 60, 75, 90, 105], \"impressions\": [300, 450, 600, 750, 900, 1050], \"conversion_site_visits\": [2, 3, 4, 5, 6, 7]}, \"segment\": null}]', '2024-11-01 18:58:44', '2024-11-01 18:58:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `agencies`
--

CREATE TABLE `agencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `facebook_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `x_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pack_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agencies`
--

INSERT INTO `agencies` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `address`, `permissions`, `facebook_url`, `tiktok_url`, `snapchat_url`, `x_url`, `instagram_url`, `pack_id`) VALUES
(1, 'khalid agency', 3, '2024-08-09 23:35:23', '2024-08-09 23:35:23', NULL, 'kwait', NULL, 'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f', 'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f', 'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f', 'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f', 'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f', NULL),
(2, 'omar agency', 7, '2024-08-10 13:43:38', '2024-08-10 13:43:38', NULL, 'arabia saoudi', NULL, 'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f', 'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f', 'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f', 'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f', 'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f', NULL),
(3, 're', 4, '2024-08-19 17:34:10', '2024-08-19 17:51:12', NULL, 'eee', NULL, ' ', 'xxx', ' ', 'edd', 'zzz', NULL),
(4, NULL, 8, '2024-08-19 17:52:13', '2024-08-19 17:52:13', NULL, NULL, NULL, 'amir', 'amir', NULL, NULL, NULL, NULL),
(5, 'amin', 9, '2024-08-19 17:54:50', '2024-08-19 17:55:01', NULL, 'sami', NULL, ' ', ' ', ' ', ' ', ' ', NULL),
(6, ' ', 1, '2024-08-19 22:06:06', '2024-08-19 22:06:06', NULL, '-', NULL, ' ', ' ', ' ', ' ', ' ', NULL),
(7, 'Agent Smith', 3, '2024-08-19 23:13:06', '2024-08-19 23:13:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, ' ', 22, '2024-08-19 23:58:16', '2024-08-19 23:58:16', NULL, '-', NULL, ' ', ' ', ' ', ' ', ' ', NULL),
(9, 'brahim@fff.coi', 24, '2024-08-20 11:36:15', '2024-08-20 11:36:15', NULL, '21212112', NULL, '2121', '211212', '211212', '2121', '211221', NULL),
(10, 'Kenyon Graves', 25, '2024-08-20 11:38:51', '2024-08-20 11:38:51', NULL, 'Dolores sint non lab', NULL, 'Occaecat fugiat des', 'Quae laboriosam fug', 'Amet ipsa nulla ve', 'Placeat in excepteu', 'Eum quia laborum ull', NULL),
(11, 'Dexter Boyle', 26, '2024-08-20 11:40:20', '2024-08-20 11:40:20', NULL, 'Assumenda voluptatem', NULL, 'Voluptatem voluptat', 'Nemo velit deserunt', 'Duis eos odio sit q', 'Eum et laborum Maxi', 'Eu eiusmod fuga Dol', NULL),
(12, NULL, 34, '2024-10-04 18:07:33', '2024-10-04 18:07:33', NULL, NULL, NULL, '', '', '', '', '', NULL),
(13, 'Maxine Chapman', 35, '2024-10-05 05:03:07', '2024-10-05 05:03:07', NULL, 'Dolorem sunt sint', NULL, 'Voluptas ut rerum ab', 'Dolore blanditiis vo', 'Commodo odit recusan', 'Aperiam et aspernatu', 'Quod tempora impedit', NULL),
(14, ' ', 43, '2024-10-12 08:46:18', '2024-10-14 06:44:20', NULL, '-', NULL, ' ', ' ', ' ', ' ', ' ', NULL),
(15, NULL, 44, '2024-10-20 20:16:36', '2024-10-20 20:16:36', NULL, NULL, NULL, '', '', '', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agency_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `facebook_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `x_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pack_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `agency_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `address`, `permissions`, `facebook_url`, `tiktok_url`, `snapchat_url`, `x_url`, `instagram_url`, `pack_id`) VALUES
(1, 'Agent Smith', 1, 3, '2024-08-09 23:35:23', '2024-08-09 23:35:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Agent Smith', 2, 3, '2024-08-19 23:13:06', '2024-08-19 23:13:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Sloane Sweeney', 11, 27, '2024-08-20 11:41:38', '2024-08-20 11:41:38', NULL, 'Molestiae animi ani', NULL, 'Hic officia nobis la', 'Tempore incidunt c', 'Non irure esse omni', 'Maiores esse dolor o', 'Beatae reprehenderit', NULL),
(4, 'Knox Boyle', 11, 28, '2024-08-20 11:41:47', '2024-08-20 11:41:47', NULL, 'Id tempor expedita', NULL, 'Molestiae unde incid', 'Natus ex explicabo', 'Aut velit non tempor', 'Quis aut velit eos', 'Rem qui ea aut magna', NULL),
(5, 'Kirk Francis', 11, 30, '2024-08-20 23:51:22', '2024-08-20 23:51:22', NULL, 'Dolor atque cupidita', NULL, 'Deserunt omnis quibu', 'Ad totam qui sunt et', 'Ut iste illum commo', 'Consequat Tenetur v', 'Laboris reiciendis q', NULL),
(6, 'Joan Norman', 11, 31, '2024-08-20 23:51:54', '2024-08-20 23:51:54', NULL, 'Ut enim sequi libero', NULL, 'Nulla soluta exercit', 'Perferendis eligendi', 'Ipsum ipsa ut occa', 'Cum tempora optio a', 'Molestias consequat', NULL),
(7, 'Hadley Cortez', 11, 32, '2024-08-21 00:14:26', '2024-08-21 00:29:37', NULL, 'Ipsam do iste quo la', NULL, 'Commodi dignissimos', 'Adipisicing laborios', 'Dolore corrupti qui0000', 'Consequat Consequat', 'Cupidatat sapiente u', NULL),
(8, 'Willow Atkinson', 11, 33, '2024-08-21 00:30:12', '2024-08-21 00:30:12', NULL, 'Aut laboris molestia', NULL, 'Voluptate modi venia', 'Ducimus nesciunt e', 'Soluta accusamus et', 'Aliquip magni magna', 'Qui quibusdam placea', NULL),
(9, 'Lenore Colon', 13, 39, '2024-10-05 05:28:46', '2024-10-05 05:28:46', NULL, 'Qui distinctio Unde', NULL, 'Autem qui cumque rep', 'Itaque corporis volu', 'Labore saepe soluta', 'Quaerat quibusdam do', 'Enim et tempore est', NULL),
(12, 'test', 13, 42, '2024-10-05 05:59:22', '2024-10-05 05:59:22', NULL, 'brahim@gmail.com', NULL, 'brahim@gmail.com', 'brahim@gmail.com', 'brahim@gmail.com', 'brahim@gmail.com', 'brahim@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `campaigns_x`
--

CREATE TABLE `campaigns_x` (
  `id` bigint UNSIGNED NOT NULL,
  `account_id` bigint UNSIGNED NOT NULL,
  `campaign_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget_optimization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reasons_not_servable` json DEFAULT NULL,
  `servable` tinyint(1) NOT NULL DEFAULT '0',
  `purchase_order_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `effective_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daily_budget_amount_local_micro` bigint DEFAULT NULL,
  `funding_instrument_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_in_days` int DEFAULT NULL,
  `standard_delivery` tinyint(1) DEFAULT NULL,
  `total_budget_amount_local_micro` bigint DEFAULT NULL,
  `entity_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequency_cap` int DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `line_items_x`
--

CREATE TABLE `line_items_x` (
  `id` bigint UNSIGNED NOT NULL,
  `campaign_id` bigint UNSIGNED NOT NULL,
  `line_item_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placements` json DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `bid_amount_local_micro` bigint DEFAULT NULL,
  `advertiser_domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_cpa_local_micro` bigint DEFAULT NULL,
  `goal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daily_budget_amount_local_micro` bigint DEFAULT NULL,
  `product_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `funding_instrument_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bid_strategy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_in_days` int DEFAULT NULL,
  `standard_delivery` tinyint(1) DEFAULT NULL,
  `total_budget_amount_local_micro` bigint DEFAULT NULL,
  `objective` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `automatic_tweet_promotion` tinyint(1) DEFAULT NULL,
  `frequency_cap` int DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creative_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2024_07_19_235041_create_admins_table', 1),
(11, '2024_07_19_235054_create_agencies_table', 1),
(12, '2024_07_19_235208_create_agents_table', 1),
(13, '2024_07_19_235228_create_notifications_table', 1),
(14, '2024_08_09_001222_create_packs_table', 1),
(15, '2024_08_09_001227_add_fields_to_agencies', 1),
(16, '2024_08_20_122138_add_fields_to_agents', 2),
(17, '2024_10_02_174428_create_snapchat_ads_table', 3),
(18, '2024_10_02_174429_create_snapchat_ads_table', 4),
(19, '2024_10_02_131419_add_twitter_columns_to_users_table', 5),
(20, '2024_10_02_161507_create_twitter_states_table', 5),
(21, '2024_10_10_123316_add_ticktok_column_to_users', 5),
(22, '2024_10_10_193532_add_fields_snapchat_to_users', 5),
(23, '2024_10_10_202707_add_snapchat_tokens_to_users_table', 5),
(24, '2024_10_11_182420_create_snapchat_accounts_table', 5),
(25, '2024_10_11_184223_create_snapchat_campaigns_table', 5),
(26, '2024_10_11_185328_create_snapchat_adsquads_table', 5),
(27, '2024_10_11_190137_create_snap_ads_table', 5),
(28, '2024_10_18_084404_create_role_access', 6),
(29, '2024_10_22_132751_add_fields_to_twitter_states', 6),
(30, '2024_10_22_200211_add_fields_to_twitter_states', 6),
(31, '2024_10_22_214248_add_fields_to_twitter_states', 6),
(32, '2024_10_28_140816_create_accounts_table', 6),
(33, '2024_10_28_141603_add_fiels_to_accounts', 6),
(34, '2024_10_28_193446_create_ad_x_analytics_table', 6),
(35, '2024_11_03_052240_create_sessions_table', 7),
(36, '2024_11_01_204922_add_fields_to_snap_ads', 8),
(37, '2024_11_04_235511_create_accounts_x_table', 9),
(38, '2024_11_04_235557_create_campaigns_x_table', 9),
(39, '2024_11_04_235619_create_line_items_x_table', 9),
(40, '2024_11_04_235645_create_promoted_tweets_x_table', 9),
(41, '2024_11_05_003433_create_ads_x_metrics_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_id` bigint UNSIGNED DEFAULT NULL,
  `received_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `value`, `sender_id`, `received_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ikcek', 'jfdsjfsd', 'newndew', 3, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packs`
--

CREATE TABLE `packs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `months` int DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `nb_product_private` decimal(8,2) DEFAULT NULL,
  `advantages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'advert', '3773bd6bf92d2700b3f185d28ee8a524fc0a35ce08884df5522c5ee110f2f50e', '[\"*\"]', NULL, NULL, '2024-08-09 23:38:00', '2024-08-09 23:38:00'),
(2, 'App\\Models\\User', 1, 'advert', 'a22c171ead97ba26c9f60643ff7f3a17e795d198b97cc506b6d14e44f8274b6c', '[\"*\"]', NULL, NULL, '2024-08-10 11:22:46', '2024-08-10 11:22:46'),
(3, 'App\\Models\\User', 1, 'advert', '3e44daead1f871a80cac5edf20f2e5c8cb7464a9f44cbfe257d11cdfc1ef4cca', '[\"*\"]', NULL, NULL, '2024-08-10 13:43:21', '2024-08-10 13:43:21'),
(4, 'App\\Models\\User', 1, 'advert', '784c03e279ecfa9169b778ce6b73d91c0a17645de7258538ca9e467b3806c659', '[\"*\"]', NULL, NULL, '2024-08-19 16:44:54', '2024-08-19 16:44:54'),
(5, 'App\\Models\\User', 1, 'advert', '829e6315809f06b77d280a1f44e25aa81e95cfd5e07aea6bab3511c1e48150b0', '[\"*\"]', NULL, NULL, '2024-08-19 21:29:10', '2024-08-19 21:29:10'),
(6, 'App\\Models\\User', 1, 'advert', 'f92575099bded5e8590e260d01a07e930db85c7aaa49cff6d32388238e786e24', '[\"*\"]', NULL, NULL, '2024-08-19 21:32:56', '2024-08-19 21:32:56'),
(7, 'App\\Models\\User', 1, 'advert', '5542fd0fa160bdd31a1e55d45f1932c7f536f03b4eb7e24b19ab9214214ddb85', '[\"*\"]', NULL, NULL, '2024-08-19 21:36:26', '2024-08-19 21:36:26'),
(8, 'App\\Models\\User', 1, 'advert', '2a97d0c2d9ec9c627330f1c75bfd0afdade14303feb7645be7cda0cede3f7eb9', '[\"*\"]', NULL, NULL, '2024-08-19 21:38:57', '2024-08-19 21:38:57'),
(9, 'App\\Models\\User', 1, 'advert', '000841d58f5490c22550128f8ac67b5d3e7c13339f98c4fff2ecde98c6e6edc5', '[\"*\"]', NULL, NULL, '2024-08-19 21:39:29', '2024-08-19 21:39:29'),
(10, 'App\\Models\\User', 1, 'advert', '47e9d384f56bbebf833526f956d1b5e3bd4172df79f7be62826dc442c3a89164', '[\"*\"]', NULL, NULL, '2024-08-19 21:43:30', '2024-08-19 21:43:30'),
(11, 'App\\Models\\User', 3, 'advert', 'f331f4da3053de672b70a2488daa552667de5096eadbc822a58c2449d78458a6', '[\"*\"]', NULL, NULL, '2024-08-19 23:11:49', '2024-08-19 23:11:49'),
(12, 'App\\Models\\User', 2, 'advert', '6984185d9cdea729ef8701118634187b9b66178cb733d9227dadb5ef2f7ce17b', '[\"*\"]', NULL, NULL, '2024-08-19 23:12:46', '2024-08-19 23:12:46'),
(19, 'App\\Models\\User', 26, 'advert', '4afa5166011495374af4299a23042eaa7047d898622444f2c1679fdc3eff7a65', '[\"*\"]', NULL, NULL, '2024-08-20 11:52:15', '2024-08-20 11:52:15'),
(20, 'App\\Models\\User', 26, 'advert', '026c8ea8e041ffa9e62cd3970523c280a642bd16645846d1d2e0e0e5079232ab', '[\"*\"]', NULL, NULL, '2024-08-20 11:59:05', '2024-08-20 11:59:05'),
(21, 'App\\Models\\User', 26, 'advert', 'ce9a55e72eabd5cc56ab982ca0189ca1f28e81515d73059ba50703bd16aac167', '[\"*\"]', NULL, NULL, '2024-08-20 16:30:32', '2024-08-20 16:30:32'),
(22, 'App\\Models\\User', 26, 'advert', 'c2a21a6c3164be0b61a67b1318e13606696ebed953aaf856c521fcec96757b66', '[\"*\"]', NULL, NULL, '2024-08-20 23:02:26', '2024-08-20 23:02:26'),
(23, 'App\\Models\\User', 26, 'advert', '4c68734c15b73d02b369329456069836584ca34941708b9c5843cffbc65e05c1', '[\"*\"]', NULL, NULL, '2024-08-21 00:43:30', '2024-08-21 00:43:30'),
(24, 'App\\Models\\User', 33, 'advert', 'a838b567a59c30c1d48c67dd7febaeb57baa622b1462391893a1e833d3a49273', '[\"*\"]', NULL, NULL, '2024-08-21 00:46:04', '2024-08-21 00:46:04'),
(25, 'App\\Models\\User', 33, 'advert', '7506130cc916f2f25e337ca85584009c57af8727c649da630b256e453de1536a', '[\"*\"]', NULL, NULL, '2024-08-21 00:51:17', '2024-08-21 00:51:17'),
(28, 'App\\Models\\User', 25, 'advert', 'c6104623c33c8e8b6af8508633b328b1d2a1f0dda3a2f3842bf37a44218c4bef', '[\"*\"]', NULL, NULL, '2024-08-25 20:07:48', '2024-08-25 20:07:48'),
(29, 'App\\Models\\User', 33, 'advert', '04385c2fdfbff5e4aca36ea7a742ad2392fe9c1585581dbb857100d0b05b012d', '[\"*\"]', NULL, NULL, '2024-08-25 20:09:48', '2024-08-25 20:09:48'),
(37, 'App\\Models\\User', 35, 'advert', 'ac48ac2476fe7692c096e36ad488e85066a73e5420f001edff1f6cd5defe321d', '[\"*\"]', NULL, NULL, '2024-10-05 05:06:11', '2024-10-05 05:06:11'),
(38, 'App\\Models\\User', 42, 'advert', 'c0906ce792be3e24ffdbc832562763554b19cf24dbf07ecae2b6a63d74aa2ba4', '[\"*\"]', NULL, NULL, '2024-10-05 06:07:12', '2024-10-05 06:07:12'),
(39, 'App\\Models\\User', 42, 'advert', '333e848a01041a8ea71fcd6089a651fc4296f0bce684306aa3bb3e2c131f4fb8', '[\"*\"]', NULL, NULL, '2024-10-05 06:10:41', '2024-10-05 06:10:41'),
(40, 'App\\Models\\User', 42, 'advert', 'd7f30c021e11a05b869b4e46f7726d4632b4c4bfbbc85e2ecb74635f3e27c95e', '[\"*\"]', NULL, NULL, '2024-10-05 06:12:11', '2024-10-05 06:12:11'),
(41, 'App\\Models\\User', 35, 'advert', '8d6a4e5f3f2f2c1f6f74d60a91ecc77997e1ebee4fded63d907c812935b91af6', '[\"*\"]', NULL, NULL, '2024-10-05 06:22:30', '2024-10-05 06:22:30'),
(42, 'App\\Models\\User', 42, 'advert', 'd52fe7ede5159f7780083720d0fde70a2be75c0ace8776c52f3bfde70c679f28', '[\"*\"]', NULL, NULL, '2024-10-05 06:22:41', '2024-10-05 06:22:41'),
(44, 'App\\Models\\User', 42, 'advert', 'a0d99aa2e3849b2a924d4596d91cbd83cb75ad3b1fb216d2b76226ecb09cf5a9', '[\"*\"]', NULL, NULL, '2024-10-05 06:30:45', '2024-10-05 06:30:45'),
(45, 'App\\Models\\User', 42, 'advert', '2915177c78148581617b2cb27586cb70ac63a46f5d7b282aaf9e138fc73544ab', '[\"*\"]', NULL, NULL, '2024-10-05 06:32:35', '2024-10-05 06:32:35'),
(46, 'App\\Models\\User', 42, 'advert', '86842ddb411a53715e3dee1b4d627e025d663bc6b6f2b6f1474a7b379180863e', '[\"*\"]', NULL, NULL, '2024-10-05 06:35:22', '2024-10-05 06:35:22'),
(47, 'App\\Models\\User', 42, 'advert', '4296af01e5536185ec59c058e5a3d000d423952e9d044a3c36dfd21d43ee8be7', '[\"*\"]', NULL, NULL, '2024-10-05 06:36:10', '2024-10-05 06:36:10'),
(48, 'App\\Models\\User', 42, 'advert', 'da1c564c3b88020a3b68af56139e3bc90b0a561c8bd323b154bba2ea8a114f2d', '[\"*\"]', NULL, NULL, '2024-10-05 06:36:21', '2024-10-05 06:36:21'),
(49, 'App\\Models\\User', 42, 'advert', 'abaf22ec4128f32c6b35816434a5386fbbe929c539e472c80f4d49d7555f6606', '[\"*\"]', NULL, NULL, '2024-10-05 06:36:24', '2024-10-05 06:36:24'),
(50, 'App\\Models\\User', 42, 'advert', '4e35865f1040a518dcd246924838c99af58f7852195fb8710dbc5cfa962788e0', '[\"*\"]', NULL, NULL, '2024-10-05 06:37:02', '2024-10-05 06:37:02'),
(51, 'App\\Models\\User', 42, 'advert', '6ee95628fe0dc9a019fc80ceb660f20fff485ad19bcc41b1e276e5275bdeaa07', '[\"*\"]', NULL, NULL, '2024-10-05 06:39:30', '2024-10-05 06:39:30'),
(52, 'App\\Models\\User', 42, 'advert', '40913d0012364f5959b45add17038ff1a743ba8d3838580db98c8d7e7196ee0c', '[\"*\"]', NULL, NULL, '2024-10-05 06:41:00', '2024-10-05 06:41:00'),
(53, 'App\\Models\\User', 42, 'advert', '7e9ac9ee2f9c4607baf58a2953aea20d24931bf3ac81a767e07a1b539e7168bd', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:53', '2024-10-05 06:44:53'),
(54, 'App\\Models\\User', 42, 'advert', '61976045907e4e51351a66fb98c9edecd73739b8f9bef6602b4ed46db1b4b27a', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:55', '2024-10-05 06:44:55'),
(55, 'App\\Models\\User', 42, 'advert', '44fd29f78f87ee1210dc3112af7ccb9a5a9bd1008b31a04771cf9e4e2a4ca343', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:55', '2024-10-05 06:44:55'),
(56, 'App\\Models\\User', 42, 'advert', '4c00f6072e68427efc12c283087c04a6fdbac518abdb827ad8285bb8e84bcc96', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:56', '2024-10-05 06:44:56'),
(57, 'App\\Models\\User', 42, 'advert', '1cfec82b1e53e31271c32791780ce1b800d2aea815d57145311836f9417ef9d8', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:56', '2024-10-05 06:44:56'),
(58, 'App\\Models\\User', 42, 'advert', 'cfdaf24db29d35224c56e19fa191c9cd4d0fce92111fd9c23195cf08ec961cf6', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:56', '2024-10-05 06:44:56'),
(59, 'App\\Models\\User', 42, 'advert', '0d26541768926db9686d0e3aa4db97ed41465117f9650ac7e2e3bfcb7c9a8c12', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:57', '2024-10-05 06:44:57'),
(60, 'App\\Models\\User', 42, 'advert', 'cd22f0c2bc244e62c5638cd077dbf68ddef17e8b164e40a477143a15379b8f88', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:57', '2024-10-05 06:44:57'),
(61, 'App\\Models\\User', 42, 'advert', 'a461078cfc0de3085087e47361f4640d9e59618b5be434d68fb6bbdb1cd19ca9', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:57', '2024-10-05 06:44:57'),
(62, 'App\\Models\\User', 42, 'advert', '056e7b82936836d9450c6b8ad1fc27cf1710646d1b228adc623c3ca38a6cf641', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:58', '2024-10-05 06:44:58'),
(63, 'App\\Models\\User', 42, 'advert', 'c0238fa5b6b3d0d214942acf43c1ddd100099e1e0cc800519fb71e8edcdc6fc5', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:58', '2024-10-05 06:44:58'),
(64, 'App\\Models\\User', 42, 'advert', '0003a94d88bec2b880f0419030258728d3790fa0b45372fa5bc4918bf29da31e', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:58', '2024-10-05 06:44:58'),
(65, 'App\\Models\\User', 42, 'advert', '377f77bdcf5df645c3937f2e5d31d00ab709099f3cd12795cfbcab6b8144842a', '[\"*\"]', NULL, NULL, '2024-10-05 06:44:59', '2024-10-05 06:44:59'),
(66, 'App\\Models\\User', 42, 'advert', '570d4b9aa01ab4098498ae8e868a5b8cfd6fd9b6ccaa0d9ba9e9d3f4a4a437e4', '[\"*\"]', NULL, NULL, '2024-10-05 06:49:59', '2024-10-05 06:49:59'),
(106, 'App\\Models\\User', 1, 'advert', 'c8882d07deea4701c3422e9e134b89f68025bc32d81127067bbbb81182347ae8', '[\"*\"]', NULL, NULL, '2024-10-10 08:48:19', '2024-10-10 08:48:19'),
(134, 'App\\Models\\User', 42, 'advert', '6751b43bddf4c6288a4cedb1aaedd1d27fa0ebbd54b5da52aa92af429fb1e280', '[\"*\"]', NULL, NULL, '2024-10-16 20:26:36', '2024-10-16 20:26:36'),
(140, 'App\\Models\\User', 9, 'advert', '8f11d13775321bb2b60f0d2135c7e1adf509be16bc44ff219ddbfa656eb258c4', '[\"*\"]', NULL, NULL, '2024-10-18 22:22:37', '2024-10-18 22:22:37'),
(145, 'App\\Models\\User', 44, 'advert', 'cff81b914e3f3e925b62cfea35331c4b1f95ae3e74367a26afd0652fb8356aca', '[\"*\"]', NULL, NULL, '2024-10-20 20:16:36', '2024-10-20 20:16:36'),
(148, 'App\\Models\\User', 44, 'advert', '7186a76966953e7a5852a5c40e4ceab5dd2518114e22d5b497ec9e3aa23b5a7d', '[\"*\"]', NULL, NULL, '2024-10-20 20:33:52', '2024-10-20 20:33:52'),
(169, 'App\\Models\\User', 34, 'advert', 'cb3f75b58b56bc707c9a8807e794de4ff004ea00e408342e02e3b49584f8c215', '[\"*\"]', NULL, NULL, '2024-10-31 18:06:01', '2024-10-31 18:06:01');

-- --------------------------------------------------------

--
-- Table structure for table `promoted_tweets_x`
--

CREATE TABLE `promoted_tweets_x` (
  `id` bigint UNSIGNED NOT NULL,
  `line_item_id` bigint UNSIGNED NOT NULL,
  `tweet_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_access`
--

CREATE TABLE `role_access` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_access`
--

INSERT INTO `role_access` (`id`, `role`, `access`, `created_at`, `updated_at`) VALUES
(1, 'admin', '[{\"id\": \"1\", \"name\": \"الصفحة الرئيسية\", \"path\": \"/\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"5\", \"name\": \"إعادة الضبط\", \"path\": \"/reset\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"10\", \"name\": \"لوحة التحكم\", \"path\": \"/dashboard\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"11\", \"name\": \"الإشعارات\", \"path\": \"/notifications\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"12\", \"name\": \"الوكلاء\", \"path\": \"/agents\", \"children\": [{\"id\": \"12-1\", \"name\": \"إدارة الوكلاء\", \"path\": \"/agents/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"12-2\", \"name\": \"إضافة الوكلاء\", \"path\": \"/agents/add/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"12-3\", \"name\": \"تحديث الوكلاء\", \"path\": \"/agents/edit/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"13\", \"name\": \"التقارير\", \"path\": \"/rapport\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"14\", \"name\": \"الوكالة\", \"path\": \"/agencies\", \"children\": [{\"id\": \"14-1\", \"name\": \"إدارة الوكالات\", \"path\": \"/agencies/\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"14-2\", \"name\": \"إضافة وكالة\", \"path\": \"/agencies/add\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"14-3\", \"name\": \"تحديث الوكالة\", \"path\": \"/agencies/edit/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"14-4\", \"name\": \"إضافة وكالة\", \"path\": \"/agencies/create\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"14-5\", \"name\": \"تحديث الوكالة\", \"path\": \"/agencies/edit:{id}\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}], \"expanded\": true, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"15\", \"name\": \"المدراء\", \"path\": \"/admins\", \"children\": [{\"id\": \"15-1\", \"name\": \"إدارة المدراء\", \"path\": \"/admins/\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"15-2\", \"name\": \"إضافة المدراء\", \"path\": \"/admins/add\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"15-3\", \"name\": \"تحديث المدراء\", \"path\": \"/admins/edit/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"16\", \"name\": \"الإعدادات\", \"path\": \"/settings\", \"children\": [{\"id\": \"16-1\", \"name\": \"الملف الشخصي\", \"path\": \"/settings/profile\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"16-2\", \"name\": \"إدارة الأدوار\", \"path\": \"/settings/role\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}], \"expanded\": true, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"18\", \"name\": \"فيسبوك\", \"path\": \"/facebook\", \"children\": [], \"expanded\": false, \"selected\": false, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"19\", \"name\": \"X\", \"path\": \"/x\", \"children\": [], \"expanded\": false, \"selected\": false, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"20\", \"name\": \"انستغرام\", \"path\": \"/instagram\", \"children\": [], \"expanded\": false, \"selected\": false, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"21\", \"name\": \"سناب شات\", \"path\": \"/snapchat\", \"children\": [], \"expanded\": false, \"selected\": false, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"22\", \"name\": \"تيك توك\", \"path\": \"/tiktok\", \"children\": [], \"expanded\": false, \"selected\": false, \"selectable\": false, \"indeterminate\": false}]', '2024-10-22 11:11:06', '2024-11-05 16:16:14'),
(2, 'agency', '[{\"id\": \"1\", \"name\": \"الصفحة الرئيسية\", \"path\": \"/\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"5\", \"name\": \"إعادة الضبط\", \"path\": \"/reset\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"10\", \"name\": \"لوحة التحكم\", \"path\": \"/dashboard\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"11\", \"name\": \"الإشعارات\", \"path\": \"/notifications\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"12\", \"name\": \"الوكلاء\", \"path\": \"/agents\", \"children\": [{\"id\": \"12-1\", \"name\": \"إدارة الوكلاء\", \"path\": \"/agents/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"12-2\", \"name\": \"إضافة الوكلاء\", \"path\": \"/agents/add/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"12-3\", \"name\": \"تحديث الوكلاء\", \"path\": \"/agents/edit/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"13\", \"name\": \"التقارير\", \"path\": \"/rapport\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"14\", \"name\": \"الوكالة\", \"path\": \"/agencies\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"15\", \"name\": \"المدراء\", \"path\": \"/admins\", \"children\": [{\"id\": \"15-1\", \"name\": \"إدارة المدراء\", \"path\": \"/admins/list\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"15-2\", \"name\": \"إضافة المدراء\", \"path\": \"/admins/add\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"15-3\", \"name\": \"تحديث المدراء\", \"path\": \"/admins/edit/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"16\", \"name\": \"الإعدادات\", \"path\": \"/settings\", \"children\": [{\"id\": \"16-1\", \"name\": \"الملف الشخصي\", \"path\": \"/settings/profile\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"16-2\", \"name\": \"إدارة الأدوار\", \"path\": \"/settings/role\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"18\", \"name\": \"فيسبوك\", \"path\": \"/facebook\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"19\", \"name\": \"X\", \"path\": \"/x\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"20\", \"name\": \"انستغرام\", \"path\": \"/instagram\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"21\", \"name\": \"سناب شات\", \"path\": \"/snapchat\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"22\", \"name\": \"تيك توك\", \"path\": \"/tiktok\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}]', '2024-10-22 12:56:27', '2024-11-05 17:30:44'),
(3, 'agent', '[{\"id\": \"1\", \"name\": \"الصفحة الرئيسية\", \"path\": \"/\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"5\", \"name\": \"إعادة الضبط\", \"path\": \"/reset\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"10\", \"name\": \"لوحة التحكم\", \"path\": \"/dashboard\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"11\", \"name\": \"الإشعارات\", \"path\": \"/notifications\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"12\", \"name\": \"الوكلاء\", \"path\": \"/agents\", \"children\": [{\"id\": \"12-1\", \"name\": \"إدارة الوكلاء\", \"path\": \"/agents/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"12-2\", \"name\": \"إضافة الوكلاء\", \"path\": \"/agents/add/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"12-3\", \"name\": \"تحديث الوكلاء\", \"path\": \"/agents/edit/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"13\", \"name\": \"التقارير\", \"path\": \"/rapport\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"14\", \"name\": \"الوكالة\", \"path\": \"/agencies\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"15\", \"name\": \"المدراء\", \"path\": \"/admins\", \"children\": [{\"id\": \"15-1\", \"name\": \"إدارة المدراء\", \"path\": \"/admins/list\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"15-2\", \"name\": \"إضافة المدراء\", \"path\": \"/admins/add\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"15-3\", \"name\": \"تحديث المدراء\", \"path\": \"/admins/edit/:id\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"16\", \"name\": \"الإعدادات\", \"path\": \"/settings\", \"children\": [{\"id\": \"16-1\", \"name\": \"الملف الشخصي\", \"path\": \"/settings/profile\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"16-2\", \"name\": \"إدارة الصلاحيات\", \"path\": \"/settings/role\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"18\", \"name\": \"فيسبوك\", \"path\": \"/facebook\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"19\", \"name\": \"X\", \"path\": \"/x\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"20\", \"name\": \"انستغرام\", \"path\": \"/instagram\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"21\", \"name\": \"سناب شات\", \"path\": \"/snapchat\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}, {\"id\": \"22\", \"name\": \"تيك توك\", \"path\": \"/tiktok\", \"children\": [], \"expanded\": false, \"selected\": true, \"selectable\": false, \"indeterminate\": false}]', '2024-11-02 13:29:21', '2024-11-05 17:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `snapchat_accounts`
--

CREATE TABLE `snapchat_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `snap_adaccount_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_adaccount_created_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_adaccount_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_adaccount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_adaccount_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_adaccount_organization_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_adaccount_currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_adaccount_timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_adaccount_advertiser_organization_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_adaccount_advertiser_billing_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_adaccount_agency_representing_client` tinyint(1) DEFAULT NULL,
  `snap_adaccount_client_paying_invoices` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `snapchat_accounts`
--

INSERT INTO `snapchat_accounts` (`id`, `snap_adaccount_id`, `snap_adaccount_created_at`, `snap_adaccount_name`, `snap_adaccount_type`, `snap_adaccount_status`, `snap_adaccount_organization_id`, `snap_adaccount_currency`, `snap_adaccount_timezone`, `snap_adaccount_advertiser_organization_id`, `snap_adaccount_advertiser_billing_type`, `snap_adaccount_agency_representing_client`, `snap_adaccount_client_paying_invoices`, `user_id`, `created_at`, `updated_at`) VALUES
(18, 'be155fcf-b845-4e12-bfc7-ea4139fe4c4c', '2024-10-11T01:19:05.691Z', 'haladigitally Self Service', 'PARTNER', 'PENDING', 'd5ba7edf-8b3c-4ae6-b318-98f180d774d9', 'USD', 'America/Los_Angeles', 'd5ba7edf-8b3c-4ae6-b318-98f180d774d9', 'REVOLVING', 0, '0', 44, '2024-11-05 14:54:48', '2024-11-05 15:52:59'),
(26, 'b9155b40-f8fe-4445-abc2-8f2f998b2879', '2023-09-01T16:40:31.627Z', 'New Network Trading Company Self Service', 'PARTNER', 'ACTIVE', '5c727774-b4f6-4e82-a6a3-eeb66cdbde9e', 'USD', 'Asia/Riyadh', '5c727774-b4f6-4e82-a6a3-eeb66cdbde9e', 'REVOLVING', 0, '0', 36, '2024-11-05 17:05:08', '2024-11-05 17:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `snapchat_ads`
--

CREATE TABLE `snapchat_ads` (
  `id` bigint UNSIGNED NOT NULL,
  `ad_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `impressions` int NOT NULL,
  `clicks` int DEFAULT NULL,
  `cost` double(8,2) DEFAULT NULL,
  `revenue` double(8,2) DEFAULT NULL,
  `promo_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `snapchat_adsquads`
--

CREATE TABLE `snapchat_adsquads` (
  `id` bigint UNSIGNED NOT NULL,
  `snap_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_created_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_billing_event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_auto_bid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_target_bid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_bid_strategy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_daily_budget_micro` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_start_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_optimization_goal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_campaign_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `snapchat_campaigns`
--

CREATE TABLE `snapchat_campaigns` (
  `id` bigint UNSIGNED NOT NULL,
  `snap_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_created_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_daily_budget_micro` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_start_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_end_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_account_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `snapchat_campaigns`
--

INSERT INTO `snapchat_campaigns` (`id`, `snap_id`, `snap_created_at`, `snap_name`, `snap_daily_budget_micro`, `snap_status`, `snap_start_time`, `snap_end_time`, `snapchat_account_id`, `created_at`, `updated_at`) VALUES
(1136, '012f76ae-3851-49d7-80e0-a9ef0027288c', '2023-11-08T19:01:50.172Z', 'جذب الزيارات إلى الموقع الإلكتروني', '100000000', 'ACTIVE', '2023-11-08T18:52:11.108Z', '2023-11-14T20:59:00.000Z', 26, '2024-11-05 17:05:08', '2024-11-05 17:05:08'),
(1137, '05fdfe9f-ade2-47cf-85e3-2affd501bb94', '2023-12-19T08:36:16.162Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-19T08:32:27.219Z', '', 26, '2024-11-05 17:05:09', '2024-11-05 17:05:09'),
(1138, '06f5d7ef-ff11-4de2-94b8-7ce9e2bae64a', '2024-04-04T15:53:15.097Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-04T00:22:29.162Z', '', 26, '2024-11-05 17:05:09', '2024-11-05 17:05:09'),
(1139, '089cadd8-f36d-4666-a3e8-e10a5b94a9e7', '2024-03-12T22:31:12.426Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-12T22:28:06.809Z', '', 26, '2024-11-05 17:05:09', '2024-11-05 17:05:09'),
(1140, '08f52c73-40b9-46bc-9fb7-34a01363206c', '2024-05-16T17:53:26.459Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-05-16T17:46:48.448Z', '', 26, '2024-11-05 17:05:10', '2024-11-05 17:05:10'),
(1141, '0d6e9d0d-776e-4cc9-8f83-9767a965d02a', '2024-06-20T18:54:12.006Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-06-20T18:50:32.763Z', '', 26, '2024-11-05 17:05:10', '2024-11-05 17:05:10'),
(1142, '0fd4c2b6-78a8-4593-bb8d-f32dfc00c993', '2024-03-24T00:14:37.633Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-23T23:52:47.420Z', '', 26, '2024-11-05 17:05:10', '2024-11-05 17:05:10'),
(1143, '131c400f-b4de-4616-b25d-6f1624b86b15', '2024-08-29T14:42:10.949Z', 'B IPAD ', '', 'ACTIVE', '2024-08-29T14:36:49.082Z', '', 26, '2024-11-05 17:05:11', '2024-11-05 17:05:11'),
(1144, '13d673e6-7b60-47df-81ca-cd5e58aa22ae', '2024-10-27T14:13:10.601Z', 'alhfr 2', '', 'PAUSED', '2024-10-27T14:05:44.336Z', '', 26, '2024-11-05 17:05:11', '2024-11-05 17:05:11'),
(1145, '15b8879d-4da2-43fc-a60c-f52c5c452d15', '2023-11-11T15:50:05.168Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-11-11T15:46:16.190Z', '', 26, '2024-11-05 17:05:11', '2024-11-05 17:05:11'),
(1146, '16b2a3a4-7230-4ea8-abcf-a68e9b82194c', '2024-01-05T21:29:05.604Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'PAUSED', '2024-01-05T21:23:39.718Z', '', 26, '2024-11-05 17:05:11', '2024-11-05 17:05:11'),
(1147, '1718a4ae-cc99-42e6-8ecd-c760568f530f', '2024-10-30T13:22:26.609Z', 'نسخة من jed 4', '', 'ACTIVE', '2024-10-30T13:22:26.702Z', '', 26, '2024-11-05 17:05:12', '2024-11-05 17:05:12'),
(1148, '1bc20cec-6033-498f-bd1f-d5f7fdec2f14', '2024-10-14T17:32:38.935Z', ' sh 2 b iph', '', 'PAUSED', '2024-10-14T17:29:08.818Z', '', 26, '2024-11-05 17:05:12', '2024-11-05 17:05:12'),
(1149, '1d28e5a6-592b-440e-bdb2-15e403d2fd5e', '2023-12-24T13:57:29.613Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-24T13:43:16.501Z', '', 26, '2024-11-05 17:05:12', '2024-11-05 17:05:12'),
(1150, '1db36bd6-a357-4fde-a341-de4ed9539d84', '2023-12-26T09:11:27.528Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-26T09:07:23.965Z', '', 26, '2024-11-05 17:05:13', '2024-11-05 17:05:13'),
(1151, '287e735c-9637-4ee3-8949-06a9e256e8c5', '2024-10-07T19:32:36.532Z', 'sh ply', '', 'ACTIVE', '2024-10-07T19:27:06.456Z', '', 26, '2024-11-05 17:05:13', '2024-11-05 17:05:13'),
(1152, '2bdfa279-1faa-41b7-b119-5e983837cada', '2023-12-25T16:44:59.462Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-25T16:39:58.036Z', '', 26, '2024-11-05 17:05:13', '2024-11-05 17:05:13'),
(1153, '2c142342-1fa7-4a86-9622-e7b20b2fa0d8', '2024-04-14T16:45:04.480Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-14T16:39:10.774Z', '', 26, '2024-11-05 17:05:13', '2024-11-05 17:05:13'),
(1154, '2f84ff22-028b-4e28-b61f-09238f8e74ef', '2024-02-21T18:18:28.087Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-21T18:11:16.975Z', '', 26, '2024-11-05 17:05:14', '2024-11-05 17:05:14'),
(1155, '2fb3445e-ec09-45ac-aa4c-c05e6fe83334', '2024-02-04T16:13:05.275Z', 'جذب الزيارات إلى الموقع الإلكتروني', '200000000', 'ACTIVE', '2024-02-04T16:02:52.517Z', '', 26, '2024-11-05 17:05:14', '2024-11-05 17:05:14'),
(1156, '300c86d7-f020-4749-90de-5f4c429ba127', '2024-01-27T21:23:02.829Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-27T21:19:55.303Z', '', 26, '2024-11-05 17:05:14', '2024-11-05 17:05:14'),
(1157, '302a0464-e922-41cd-913b-46b37ce5649d', '2024-08-11T13:47:36.636Z', 'B NNC1', '', 'ACTIVE', '2024-08-11T13:36:38.618Z', '', 26, '2024-11-05 17:05:15', '2024-11-05 17:05:15'),
(1158, '30bf3c60-aef7-4b49-b1ea-0cfdbdf00c13', '2024-02-04T17:20:59.734Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-04T17:16:13.958Z', '', 26, '2024-11-05 17:05:15', '2024-11-05 17:05:15'),
(1159, '327ca538-77f4-4874-9f37-da5f084630d6', '2024-08-03T15:53:33.361Z', 'جذب الزيارات إلى الموقع الإلكتروني', '300000000', 'ACTIVE', '2024-08-03T15:50:51.768Z', '', 26, '2024-11-05 17:05:15', '2024-11-05 17:05:15'),
(1160, '337c474f-33fd-42c9-b6c8-8735aef74de4', '2024-02-19T13:43:47.688Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-19T13:39:28.066Z', '', 26, '2024-11-05 17:05:15', '2024-11-05 17:05:15'),
(1161, '36dc45e5-ce52-4a6d-bfd1-5a6146d7c200', '2023-11-29T13:29:44.848Z', 'جذب الزيارات إلى الموقع الإلكتروني', '500000000', 'ACTIVE', '2023-11-29T13:23:01.927Z', '2023-12-07T20:59:00.000Z', 26, '2024-11-05 17:05:16', '2024-11-05 17:05:16'),
(1162, '3994a294-4aa7-4c8d-8c02-db4a54dcad1f', '2024-07-21T13:03:12.340Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-07-21T12:54:38.372Z', '', 26, '2024-11-05 17:05:16', '2024-11-05 17:05:16'),
(1163, '3e8cc4b7-38f9-42d5-a188-6e0db984262b', '2024-08-28T16:34:20.924Z', 'V SH O', '100000000', 'ACTIVE', '2024-08-28T16:31:45.739Z', '', 26, '2024-11-05 17:05:16', '2024-11-05 17:05:16'),
(1164, '410a1cec-bc68-40ea-afeb-feb07a51e0c6', '2024-02-27T18:22:07.572Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-27T18:19:15.749Z', '', 26, '2024-11-05 17:05:17', '2024-11-05 17:05:17'),
(1165, '41a538e6-baf3-49e3-b3a7-8a994f1a5906', '2024-01-24T15:34:09.540Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-24T15:31:19.314Z', '', 26, '2024-11-05 17:05:17', '2024-11-05 17:05:17'),
(1166, '46e2ee5d-534a-4d63-bcc2-c2bedb774367', '2023-12-24T11:47:42.537Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-24T11:41:48.276Z', '', 26, '2024-11-05 17:05:17', '2024-11-05 17:05:17'),
(1167, '46efe9c5-7fa4-43d9-bb0a-605aea200c80', '2023-12-18T12:33:37.233Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-18T12:29:52.375Z', '', 26, '2024-11-05 17:05:18', '2024-11-05 17:05:18'),
(1168, '49e3de3f-88c0-4438-ba47-5f81006a0071', '2024-05-16T18:02:58.535Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-05-16T18:00:07.403Z', '', 26, '2024-11-05 17:05:18', '2024-11-05 17:05:18'),
(1169, '4bde56ea-cb68-49b9-b109-80877d10fc0a', '2024-06-26T12:54:22.473Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-06-26T12:51:48.121Z', '', 26, '2024-11-05 17:05:18', '2024-11-05 17:05:18'),
(1170, '4c2dc08c-6fec-4c24-9ee6-7920d93ea3ba', '2023-11-19T11:02:09.860Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-11-19T10:21:40.515Z', '', 26, '2024-11-05 17:05:18', '2024-11-05 17:05:18'),
(1171, '53b49aed-5035-4fb4-af8d-8621f8570af6', '2023-10-01T18:14:08.523Z', 'جذب الزيارات إلى الموقع الإلكتروني', '200000000', 'ACTIVE', '2023-10-01T17:09:11.767Z', '', 26, '2024-11-05 17:05:19', '2024-11-05 17:05:19'),
(1172, '589deaf5-276c-4b18-a055-f788eb310362', '2024-05-16T17:58:55.492Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-05-16T17:54:15.950Z', '', 26, '2024-11-05 17:05:19', '2024-11-05 17:05:19'),
(1173, '59586237-8de8-479e-be36-313381e6fddc', '2024-10-21T19:20:31.290Z', 'jed 4', '', 'ACTIVE', '2024-10-21T19:15:01.353Z', '', 26, '2024-11-05 17:05:19', '2024-11-05 17:05:19'),
(1174, '5d024b00-a6b7-4595-89cc-399b34147ad7', '2024-04-17T15:39:37.436Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-17T15:35:43.825Z', '', 26, '2024-11-05 17:05:20', '2024-11-05 17:05:20'),
(1175, '60363390-5f6a-471b-9534-9cde345f058a', '2024-10-17T06:05:22.713Z', 'alhafer', '', 'ACTIVE', '2024-10-17T05:59:40.196Z', '', 26, '2024-11-05 17:05:20', '2024-11-05 17:05:20'),
(1176, '60c08b88-58de-45e8-a437-6166b1ee2562', '2024-10-21T18:29:24.714Z', 'tbok 4', '', 'ACTIVE', '2024-10-21T16:57:15.786Z', '', 26, '2024-11-05 17:05:20', '2024-11-05 17:05:20'),
(1177, '62a31736-e104-4414-ba91-20118ce84f3b', '2023-12-30T13:21:43.678Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-30T13:07:52.325Z', '', 26, '2024-11-05 17:05:21', '2024-11-05 17:05:21'),
(1178, '648b0dce-333e-4c94-afb0-c17a3559bb2b', '2024-02-04T17:15:13.416Z', 'تحويلات الموقع الإلكتروني', '', 'ACTIVE', '2024-02-04T16:55:07.476Z', '', 26, '2024-11-05 17:05:21', '2024-11-05 17:05:21'),
(1179, '66d2a1a0-5241-4853-846f-83ce700585b3', '2024-09-16T12:18:11.271Z', 'حجز ا 16 ', '100000000', 'PAUSED', '2024-09-16T12:07:09.544Z', '', 26, '2024-11-05 17:05:21', '2024-11-05 17:05:21'),
(1180, '6ac253bb-b058-4b27-9aaa-a6cdbe03f3e9', '2023-11-06T10:03:58.481Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-11-06T09:59:08.168Z', '', 26, '2024-11-05 17:05:21', '2024-11-05 17:05:21'),
(1181, '6aeb858b-0ed4-4d5f-af0f-73d7312e629c', '2024-02-06T17:10:55.195Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-06T17:01:48.989Z', '', 26, '2024-11-05 17:05:22', '2024-11-05 17:05:22'),
(1182, '6ec1c1d9-b1de-480b-aa6b-0d6943a59bd7', '2024-04-14T06:05:35.616Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-14T06:00:02.864Z', '', 26, '2024-11-05 17:05:22', '2024-11-05 17:05:22'),
(1183, '6efdd352-7747-4568-ae5a-000451f1d5b1', '2023-12-24T16:45:50.400Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-24T16:42:43.239Z', '', 26, '2024-11-05 17:05:22', '2024-11-05 17:05:22'),
(1184, '706b9982-05cb-4216-998c-4ab4af7e2a94', '2024-08-27T14:47:22.994Z', 'C V', '200000000', 'ACTIVE', '2024-08-26T16:06:24.641Z', '', 26, '2024-11-05 17:05:23', '2024-11-05 17:05:23'),
(1185, '71d87f77-502f-450f-bf8c-1b59b0effd87', '2024-10-29T15:42:02.395Z', 'alhfr 3', '', 'PAUSED', '2024-10-29T15:36:14.297Z', '', 26, '2024-11-05 17:05:23', '2024-11-05 17:05:23'),
(1186, '74d31796-362b-49e7-96bf-33d6afed3df5', '2024-06-06T15:02:20.882Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-06-06T14:53:50.323Z', '', 26, '2024-11-05 17:05:23', '2024-11-05 17:05:23'),
(1187, '7502b86b-40f9-4559-b470-a8cb5e403409', '2024-10-17T04:26:16.032Z', 'jed v m', '', 'PAUSED', '2024-10-17T04:04:48.802Z', '', 26, '2024-11-05 17:05:23', '2024-11-05 17:05:23'),
(1188, '75282fb6-974a-4a8e-8d6b-0790ae37f763', '2024-01-11T18:16:56.204Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-11T18:13:58.984Z', '', 26, '2024-11-05 17:05:24', '2024-11-05 17:05:24'),
(1189, '75c79db8-545a-420d-8486-a3e7f929a8cb', '2024-03-12T22:17:27.282Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-12T22:13:43.070Z', '', 26, '2024-11-05 17:05:24', '2024-11-05 17:05:24'),
(1190, '791f76bb-a837-47e1-9bd4-e8f8e6820e61', '2024-02-04T16:19:09.585Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-04T16:13:32.560Z', '', 26, '2024-11-05 17:05:24', '2024-11-05 17:05:24'),
(1191, '79cf266f-df07-416c-815b-fd2b05d9e6c3', '2024-02-21T18:23:32.713Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-21T18:19:23.182Z', '', 26, '2024-11-05 17:05:25', '2024-11-05 17:05:25'),
(1192, '7c0ee5c8-8fdb-499e-a32b-43d239849dd7', '2023-11-15T10:08:40.227Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-11-15T10:03:24.809Z', '', 26, '2024-11-05 17:05:25', '2024-11-05 17:05:25'),
(1193, '7cd2fae3-b874-44e9-a085-5f5b2ad8c05a', '2024-04-17T15:42:25.308Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-17T15:40:04.264Z', '', 26, '2024-11-05 17:05:25', '2024-11-05 17:05:25'),
(1194, '7d99e46b-79b9-4429-aca6-d72dbede0dbd', '2024-01-05T21:21:42.887Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-05T21:12:53.181Z', '', 26, '2024-11-05 17:05:26', '2024-11-05 17:05:26'),
(1195, '7da13ad6-a8b6-4dae-9150-5116951db1e5', '2024-10-14T17:23:18.103Z', 'sh tbok', '', 'ACTIVE', '2024-10-14T16:46:08.368Z', '', 26, '2024-11-05 17:05:26', '2024-11-05 17:05:26'),
(1196, '7eac2d9a-8721-47a8-b18d-b64c9078aa7b', '2024-04-17T15:35:01.566Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-17T15:31:49.073Z', '', 26, '2024-11-05 17:05:26', '2024-11-05 17:05:26'),
(1197, '7eb93fb4-ae66-488d-b3b7-c3307e8a37e5', '2024-03-12T22:03:59.984Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-12T21:58:28.275Z', '', 26, '2024-11-05 17:05:26', '2024-11-05 17:05:26'),
(1198, '7fdd4a2b-b6aa-4419-87b6-489f7beae1e3', '2023-09-17T18:14:09.929Z', 'موافقة فورية - استلام فوري - حملة', '', 'ACTIVE', '2023-09-17T18:14:09.200Z', '', 26, '2024-11-05 17:05:27', '2024-11-05 17:05:27'),
(1199, '82c3328d-7807-4d04-93e5-c3899b0a95b7', '2024-03-26T17:00:21.228Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-26T16:54:02.692Z', '', 26, '2024-11-05 17:05:27', '2024-11-05 17:05:27'),
(1200, '88fd0c67-4b83-42bb-a192-ab87bc132907', '2024-10-06T16:01:56.885Z', 'v sh tabok', '', 'PAUSED', '2024-10-06T16:01:57.266Z', '', 26, '2024-11-05 17:05:27', '2024-11-05 17:05:27'),
(1201, '89ea9dbd-de08-45aa-8283-829824f009b6', '2024-01-27T18:58:55.568Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-27T18:55:22.049Z', '', 26, '2024-11-05 17:05:28', '2024-11-05 17:05:28'),
(1202, '8a311171-252d-432f-adb7-1c7d1ba0c258', '2024-08-13T13:58:14.074Z', 'نسخة من NTC 1', '', 'ACTIVE', '2024-08-13T13:41:11.058Z', '', 26, '2024-11-05 17:05:28', '2024-11-05 17:05:28'),
(1203, '8c00233c-e50a-4c25-9745-077cd712cd8d', '2023-12-02T11:10:58.775Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'PAUSED', '2023-12-02T11:06:47.822Z', '', 26, '2024-11-05 17:05:28', '2024-11-05 17:05:28'),
(1204, '93fdebf8-eb61-4d17-bf7c-29a0b47cf4d8', '2024-02-25T19:28:22.778Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-25T19:22:20.878Z', '', 26, '2024-11-05 17:05:29', '2024-11-05 17:05:29'),
(1205, '9668043f-16ff-401d-ad70-4d93765cb73f', '2024-03-20T22:03:37.541Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-20T21:50:19.658Z', '', 26, '2024-11-05 17:05:29', '2024-11-05 17:05:29'),
(1206, '9813ed0d-9583-44b0-9636-55073a0cf692', '2024-01-11T13:34:50.175Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-11T13:29:10.168Z', '', 26, '2024-11-05 17:05:29', '2024-11-05 17:05:29'),
(1207, '994ae847-1b03-4622-a147-8f20742a089b', '2024-03-25T01:10:32.182Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-25T01:03:19.988Z', '', 26, '2024-11-05 17:05:29', '2024-11-05 17:05:29'),
(1208, '9ac12883-b899-41d0-8620-57e799352886', '2024-01-19T19:26:28.028Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-19T19:22:55.755Z', '', 26, '2024-11-05 17:05:30', '2024-11-05 17:05:30'),
(1209, '9f62b07b-7be1-4585-b5f4-7c7acf7c10a3', '2024-04-17T15:31:21.480Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-17T15:28:15.690Z', '', 26, '2024-11-05 17:05:30', '2024-11-05 17:05:30'),
(1210, 'a11496c9-0da6-42f3-843d-650a611eb126', '2023-11-11T15:58:56.783Z', 'جذب الزيارات إلى الموقع الإلكتروني', '100000000', 'ACTIVE', '2023-11-11T15:55:09.193Z', '2023-11-18T20:59:00.000Z', 26, '2024-11-05 17:05:30', '2024-11-05 17:05:30'),
(1211, 'a2d376f7-0921-4716-8ef0-f671ec211fd0', '2023-12-17T18:27:40.273Z', 'جذب الزيارات إلى الموقع الإلكتروني', '500000000', 'PAUSED', '2023-12-18T11:00:00.000Z', '', 26, '2024-11-05 17:05:31', '2024-11-05 17:05:31'),
(1212, 'a7e592b4-1d9f-4a23-895c-55287f59b79e', '2024-07-31T13:33:33.779Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'PAUSED', '2024-07-31T13:05:49.095Z', '', 26, '2024-11-05 17:05:31', '2024-11-05 17:05:31'),
(1213, 'a93570c9-e7f3-47fa-9ca3-b5f1478afd2f', '2024-01-20T13:58:12.834Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-20T13:53:34.578Z', '', 26, '2024-11-05 17:05:31', '2024-11-05 17:05:31'),
(1214, 'a976cc74-5435-4926-8f55-da1b11bebfea', '2024-10-21T18:52:52.522Z', 'jed 4', '', 'PAUSED', '2024-10-21T18:44:19.504Z', '', 26, '2024-11-05 17:05:31', '2024-11-05 17:05:31'),
(1215, 'aa30d91b-62e6-4598-8923-e974a16e3352', '2024-08-06T16:56:47.036Z', '** نسخة من جذب الزيارات إلى الموقع الإلكتروني NTC ', '', 'PAUSED', '2024-08-06T16:56:46.219Z', '', 26, '2024-11-05 17:05:32', '2024-11-05 17:05:32'),
(1216, 'aed0820d-8bb9-4606-86f7-2af8cfcc99f4', '2024-01-28T07:23:35.021Z', 'جذب العملاء المحتملين', '', 'ACTIVE', '2024-01-28T07:19:03.683Z', '', 26, '2024-11-05 17:05:32', '2024-11-05 17:05:32'),
(1217, 'b0161555-91c3-4910-bccd-e63f2011016e', '2024-10-03T12:07:56.748Z', 'sh m', '', 'ACTIVE', '2024-10-03T11:52:35.848Z', '', 26, '2024-11-05 17:05:32', '2024-11-05 17:05:32'),
(1218, 'b215940d-ae9e-47e6-aa22-7360ec853c9f', '2024-02-13T11:46:52.596Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-13T11:44:27.073Z', '', 26, '2024-11-05 17:05:33', '2024-11-05 17:05:33'),
(1219, 'b3264d18-e070-496f-a590-cc2b4140b4f8', '2023-12-18T11:43:00.346Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-18T11:38:24.951Z', '', 26, '2024-11-05 17:05:33', '2024-11-05 17:05:33'),
(1220, 'b589e7f1-de5e-41ef-805e-9b4145826f55', '2024-05-16T18:07:41.616Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-05-16T18:04:53.732Z', '', 26, '2024-11-05 17:05:33', '2024-11-05 17:05:33'),
(1221, 'b6128948-110a-49d0-a8e6-f46931b29f6c', '2023-11-25T16:05:54.707Z', 'جذب الزيارات إلى الموقع الإلكتروني', '500000000', 'ACTIVE', '2023-11-25T15:58:24.569Z', '', 26, '2024-11-05 17:05:34', '2024-11-05 17:05:34'),
(1222, 'b714af67-506f-46af-91ef-224bafd2bda0', '2024-04-03T01:34:48.356Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-03T01:19:29.403Z', '', 26, '2024-11-05 17:05:34', '2024-11-05 17:05:34'),
(1223, 'b9049d42-064a-4d83-856f-828a4f316c97', '2024-09-01T16:03:08.873Z', 'jed b 1', '100000000', 'ACTIVE', '2024-09-01T15:57:42.904Z', '', 26, '2024-11-05 17:05:34', '2024-11-05 17:05:34'),
(1224, 'b9f5317c-2656-43a0-a88b-3a6050db4498', '2024-04-14T17:03:30.349Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-14T17:00:27.091Z', '', 26, '2024-11-05 17:05:35', '2024-11-05 17:05:35'),
(1225, 'bb9ec0fa-4c9a-4fff-9ce7-57aecadccbd8', '2024-02-25T11:38:38.553Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-25T11:16:35.821Z', '', 26, '2024-11-05 17:05:35', '2024-11-05 17:05:35'),
(1226, 'bdfdadde-e512-4d76-a37e-97e6ad3bab3d', '2024-02-06T17:24:01.688Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-06T17:14:41.542Z', '', 26, '2024-11-05 17:05:35', '2024-11-05 17:05:35'),
(1227, 'c0ee4665-12ca-42b4-baff-0cee283aadac', '2024-11-04T10:38:32.268Z', 'نسخة من tbok 4', '', 'ACTIVE', '2024-11-04T10:38:33.804Z', '', 26, '2024-11-05 17:05:35', '2024-11-05 17:05:35'),
(1228, 'c373bdb7-d4b3-4086-b2f1-9bac6b8cc3b8', '2023-12-24T16:54:08.199Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-24T16:50:38.982Z', '', 26, '2024-11-05 17:05:36', '2024-11-05 17:05:36'),
(1229, 'c3b0b008-9284-4cfe-80c8-f13b32d1aa8b', '2024-08-11T16:17:38.222Z', 'b 2', '', 'ACTIVE', '2024-08-11T16:12:22.490Z', '', 26, '2024-11-05 17:05:36', '2024-11-05 17:05:36'),
(1230, 'c3f8f619-c891-47fa-b8ca-bf04e47f9dda', '2024-08-13T11:27:08.507Z', 'B NTC 2', '', 'ACTIVE', '2024-08-13T11:20:10.789Z', '', 26, '2024-11-05 17:05:36', '2024-11-05 17:05:36'),
(1231, 'c4fe08c2-fb7f-441b-8853-e94993c59d23', '2024-08-13T15:10:27.381Z', 'نسخة من VID NNC ', '', 'ACTIVE', '2024-08-13T15:10:26.891Z', '', 26, '2024-11-05 17:05:37', '2024-11-05 17:05:37'),
(1232, 'c5fc763b-2fa8-40a9-a685-a28fbd5b251c', '2024-01-15T18:19:45.048Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-15T18:10:46.166Z', '', 26, '2024-11-05 17:05:37', '2024-11-05 17:05:37'),
(1233, 'c7de6857-b3cd-41ac-b56a-ab9ed1405722', '2024-04-06T23:07:37.148Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-06T23:03:51.870Z', '', 26, '2024-11-05 17:05:37', '2024-11-05 17:05:37'),
(1234, 'c80df69c-bdb6-49c9-ba76-3fdf14ddb707', '2024-10-06T16:34:23.367Z', '2sh m', '', 'ACTIVE', '2024-10-06T16:17:58.258Z', '', 26, '2024-11-05 17:05:38', '2024-11-05 17:05:38'),
(1235, 'c83e634a-5dca-41e6-a40b-ae8442b08bb5', '2024-04-14T16:55:15.334Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-14T16:50:59.707Z', '', 26, '2024-11-05 17:05:38', '2024-11-05 17:05:38'),
(1236, 'c9c2ac62-3876-407b-aec4-c1eec1bfda18', '2024-03-23T23:51:17.978Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-23T23:35:45.651Z', '', 26, '2024-11-05 17:05:38', '2024-11-05 17:05:38'),
(1237, 'cc7e9306-cd1b-4a86-b458-8f4a3641f9f4', '2024-04-17T15:27:56.963Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-17T15:17:23.984Z', '', 26, '2024-11-05 17:05:38', '2024-11-05 17:05:38'),
(1238, 'ce748a36-b564-414f-9e12-41b68842e75e', '2024-03-24T00:25:54.953Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-24T00:15:31.664Z', '', 26, '2024-11-05 17:05:39', '2024-11-05 17:05:39'),
(1239, 'ce9db8bb-7a73-464c-813f-8aa7691caa28', '2024-01-20T15:51:12.591Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-20T15:43:32.835Z', '', 26, '2024-11-05 17:05:39', '2024-11-05 17:05:39'),
(1240, 'd0e455f5-c655-498c-aba8-781947e2e7ff', '2023-12-29T12:10:47.840Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-29T12:05:40.512Z', '', 26, '2024-11-05 17:05:39', '2024-11-05 17:05:39'),
(1241, 'd20bbaf5-6c57-49b0-8d8f-5395569ed9e8', '2024-04-14T16:59:24.508Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-14T16:56:10.834Z', '', 26, '2024-11-05 17:05:40', '2024-11-05 17:05:40'),
(1242, 'd35ce414-3e35-4998-818b-d9a2e5020e0e', '2024-10-17T03:24:00.474Z', 'jed ply ', '', 'ACTIVE', '2024-10-17T03:18:39.845Z', '', 26, '2024-11-05 17:05:40', '2024-11-05 17:05:40'),
(1243, 'd734ee09-0b3b-4f36-9b0f-356688e81f80', '2024-02-13T11:40:53.550Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-13T11:37:43.549Z', '', 26, '2024-11-05 17:05:40', '2024-11-05 17:05:40'),
(1244, 'd86bf45d-2391-4dae-b4af-e30b9a929d66', '2023-12-24T11:40:13.688Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-24T11:32:14.540Z', '', 26, '2024-11-05 17:05:41', '2024-11-05 17:05:41'),
(1245, 'd8b200e1-2f5e-4285-bcc7-8a06252c4aff', '2024-01-17T19:46:12.365Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-17T19:39:20.046Z', '', 26, '2024-11-05 17:05:41', '2024-11-05 17:05:41'),
(1246, 'd97b74b2-6be0-4fb0-b2f1-a1a65956f9da', '2024-04-27T19:37:37.409Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-27T19:32:30.170Z', '', 26, '2024-11-05 17:05:41', '2024-11-05 17:05:41'),
(1247, 'da836406-5485-4534-a4b1-90194c971fb8', '2024-01-11T13:48:50.335Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-11T13:44:03.140Z', '', 26, '2024-11-05 17:05:42', '2024-11-05 17:05:42'),
(1248, 'da8da21b-a590-46cd-b965-1f7d71e5af85', '2024-10-27T13:49:51.971Z', 'algnob', '', 'ACTIVE', '2024-10-27T13:16:35.218Z', '', 26, '2024-11-05 17:05:42', '2024-11-05 17:05:42'),
(1249, 'da91b283-df8c-4fef-bf90-061691212010', '2024-09-24T15:55:44.128Z', 'n day sh', '50000000', 'ACTIVE', '2024-09-24T15:21:47.766Z', '', 26, '2024-11-05 17:05:42', '2024-11-05 17:05:42'),
(1250, 'db6d6806-ee93-4f4b-8f51-41e4db6107a2', '2024-10-29T15:47:27.289Z', 'حجز 2', '', 'ACTIVE', '2024-10-29T15:44:10.064Z', '', 26, '2024-11-05 17:05:43', '2024-11-05 17:05:43'),
(1251, 'dc3468fa-9e65-4f34-9ee7-eb14ffa91fd6', '2023-11-11T15:54:40.673Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-11-11T15:50:41.149Z', '', 26, '2024-11-05 17:05:43', '2024-11-05 17:05:43'),
(1252, 'dd15bca9-d42e-4843-8fc4-c3f019a2cbf5', '2024-03-25T22:53:19.328Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-25T22:35:14.032Z', '', 26, '2024-11-05 17:05:43', '2024-11-05 17:05:43'),
(1253, 'e0002dc6-fd7b-4b3a-a32d-595d0f302230', '2024-10-17T02:49:49.951Z', 'sh tbok 2', '', 'ACTIVE', '2024-10-17T02:40:36.714Z', '', 26, '2024-11-05 17:05:43', '2024-11-05 17:05:43'),
(1254, 'e0b3ac19-0f74-4755-b70a-316acacd6f0c', '2023-12-24T14:01:58.888Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-24T13:58:01.309Z', '', 26, '2024-11-05 17:05:44', '2024-11-05 17:05:44'),
(1255, 'e30b216e-c555-44d3-bb9a-40f5829ee9c8', '2024-08-13T12:10:24.121Z', 'NNC 3 B', '', 'ACTIVE', '2024-08-12T15:32:27.671Z', '', 26, '2024-11-05 17:05:44', '2024-11-05 17:05:44'),
(1256, 'e51482c7-9bf6-4012-b309-2afa0fc17a02', '2024-02-19T13:19:43.029Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-19T13:04:10.413Z', '', 26, '2024-11-05 17:05:44', '2024-11-05 17:05:44'),
(1257, 'e60a7ea5-18f3-4dae-ad49-0e62f3dc616e', '2024-08-03T05:32:11.675Z', 'جذب الزيارات إلى الموقع الإلكتروني', '200000000', 'PAUSED', '2024-08-03T05:25:04.231Z', '', 26, '2024-11-05 17:05:45', '2024-11-05 17:05:45'),
(1258, 'e60bfdb5-32c2-4658-b22b-fe21291bf688', '2024-01-05T21:40:54.020Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-05T21:30:44.701Z', '', 26, '2024-11-05 17:05:45', '2024-11-05 17:05:45'),
(1259, 'e8db9f0d-b71b-4461-b6b7-aa1fb4f9e0fd', '2024-05-16T18:11:12.316Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-05-16T18:09:02.260Z', '', 26, '2024-11-05 17:05:45', '2024-11-05 17:05:45'),
(1260, 'e92b742b-db52-4138-9cf7-450866d71f9f', '2024-10-21T18:44:01.888Z', 'jed 3', '', 'ACTIVE', '2024-10-21T18:38:53.320Z', '', 26, '2024-11-05 17:05:46', '2024-11-05 17:05:46'),
(1261, 'eaf43de3-bd2a-4456-a1b8-d818cb711a24', '2024-03-25T01:01:43.355Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-25T00:55:56.726Z', '', 26, '2024-11-05 17:05:46', '2024-11-05 17:05:46'),
(1262, 'ec1d6509-08a0-465c-94b2-7a1c912958d0', '2024-01-27T19:04:17.611Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-27T18:59:37.284Z', '', 26, '2024-11-05 17:05:46', '2024-11-05 17:05:46'),
(1263, 'ef977f62-7d63-40f4-a062-06de24b68b33', '2023-12-11T10:06:09.653Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-11T09:42:24.084Z', '', 26, '2024-11-05 17:05:47', '2024-11-05 17:05:47'),
(1264, 'ef9cb05a-38e9-4020-9ef5-d85623376c16', '2024-01-11T13:43:16.269Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-01-11T13:35:39.559Z', '', 26, '2024-11-05 17:05:47', '2024-11-05 17:05:47'),
(1265, 'f0746ba8-705d-4a0c-834d-00ba0fd51294', '2024-10-30T13:50:08.628Z', 'نسخة من sh ply', '', 'ACTIVE', '2024-10-30T13:50:08.675Z', '', 26, '2024-11-05 17:05:47', '2024-11-05 17:05:47'),
(1266, 'f080b708-4fd4-441f-8860-d05d36d14f4e', '2024-08-12T13:52:21.090Z', 'B NTC 3', '', 'ACTIVE', '2024-08-12T13:12:23.590Z', '', 26, '2024-11-05 17:05:47', '2024-11-05 17:05:47'),
(1267, 'f0bf9691-192a-4f04-81b6-7821588a9306', '2024-03-04T17:40:50.743Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-04T17:38:38.985Z', '', 26, '2024-11-05 17:05:48', '2024-11-05 17:05:48'),
(1268, 'f27d0865-b6be-4679-a645-1fb00a642c05', '2024-08-07T12:07:09.875Z', 'ntc 2', '', 'ACTIVE', '2024-08-07T12:00:27.822Z', '', 26, '2024-11-05 17:05:48', '2024-11-05 17:05:48'),
(1269, 'f2ebb470-5765-410c-845c-894c380cc33d', '2024-03-12T22:13:01.924Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-12T22:05:16.495Z', '', 26, '2024-11-05 17:05:48', '2024-11-05 17:05:48'),
(1270, 'f3fcecf0-8fd7-41cd-985e-97358f35155c', '2024-04-27T14:02:23.881Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-04-27T14:00:41.584Z', '', 26, '2024-11-05 17:05:49', '2024-11-05 17:05:49'),
(1271, 'f4bbc344-97f3-4f4e-a349-2e9d59a5b4ba', '2023-12-10T15:06:44.230Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2023-12-10T14:57:31.097Z', '', 26, '2024-11-05 17:05:49', '2024-11-05 17:05:49'),
(1272, 'f67e908f-05da-4832-b264-95ab6a6f28e9', '2024-10-13T18:43:38.232Z', 'sh 2 iph', '', 'ACTIVE', '2024-10-13T18:41:10.781Z', '', 26, '2024-11-05 17:05:49', '2024-11-05 17:05:49'),
(1273, 'f6c4715a-5fff-42ce-836c-e7ed65789daa', '2024-03-25T00:55:19.212Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-03-24T23:33:21.599Z', '', 26, '2024-11-05 17:05:49', '2024-11-05 17:05:49'),
(1274, 'f77458fe-51b8-4466-b31e-2d0976f5dc7c', '2024-02-13T11:36:23.317Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-13T11:24:54.521Z', '', 26, '2024-11-05 17:05:50', '2024-11-05 17:05:50'),
(1275, 'f96a7bd9-e2d6-482e-868b-d253a0fa39f5', '2023-11-11T15:45:26.745Z', 'جذب الزيارات إلى الموقع الإلكتروني', '100000000', 'ACTIVE', '2023-11-11T15:40:45.553Z', '', 26, '2024-11-05 17:05:50', '2024-11-05 17:05:50'),
(1276, 'f99ea900-d908-4a66-b2d7-c021e352468b', '2024-02-19T14:00:07.080Z', 'جذب الزيارات إلى الموقع الإلكتروني', '', 'ACTIVE', '2024-02-19T13:55:21.964Z', '', 26, '2024-11-05 17:05:50', '2024-11-05 17:05:50'),
(1277, 'fb9ad5a3-a2a8-4f3c-bf9d-0462a4405402', '2024-10-17T03:14:21.588Z', 'tbok 3 iph', '', 'PAUSED', '2024-10-17T02:58:35.027Z', '', 26, '2024-11-05 17:05:51', '2024-11-05 17:05:51'),
(1278, 'fbd5be6b-79dd-4e4d-9a44-eceb3787c065', '2024-08-06T17:25:54.788Z', 'NTC 1', '', 'PAUSED', '2024-08-06T17:01:13.790Z', '', 26, '2024-11-05 17:05:51', '2024-11-05 17:05:51'),
(1279, 'fc9fd299-8f56-48ea-baf1-cbe0f45d61cf', '2024-08-13T12:33:27.262Z', 'NNC 4 ALL PHONE', '', 'ACTIVE', '2024-08-13T12:23:00.397Z', '', 26, '2024-11-05 17:05:51', '2024-11-05 17:05:51');

-- --------------------------------------------------------

--
-- Table structure for table `snap_ads`
--

CREATE TABLE `snap_ads` (
  `id` bigint UNSIGNED NOT NULL,
  `snap_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_created_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_creative_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_granularity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_impressions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_swipes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_spend` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_quartile_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_quartile_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_quartile_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_view_completion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_screen_time_millis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_adsquad_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_conversion_purchases` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_conversion_save` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_conversion_start_checkout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_conversion_add_cart` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_conversion_view_content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_conversion_add_billing` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_conversion_sign_ups` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_conversion_searches` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_conversion_level_completes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_conversion_app_opens` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stats_conversion_page_views` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `twitter_states`
--

CREATE TABLE `twitter_states` (
  `id` bigint UNSIGNED NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oauth_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oauth_token_secret` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `session_id` int DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `twitter_states`
--

INSERT INTO `twitter_states` (`id`, `state`, `oauth_token`, `oauth_token_secret`, `created_at`, `updated_at`, `user_id`, `session_id`, `access_token`) VALUES
(4, '12LoC3Lqe14PgDfojSQViC3gHLZevQOiZMtGcZyy', '8VanLAAAAAABupPwAAABkoHFvE0', 'GLZmZRdRaGgaMyB6MrYJw846f4Ssd35S', '2024-10-12 17:27:52', '2024-10-12 17:27:52', NULL, NULL, NULL),
(6, 'EDrXeog8k71ibaAuMXZXoU3gW0Y9WjgTTV3bQu6K', '3TijPQAAAAABupPwAAABkpc0OzA', 'aoWfYCEMjOLhOCiYX8AZcCTHoGY3PkB3', '2024-10-16 21:20:35', '2024-10-16 21:20:35', NULL, NULL, NULL),
(7, 'QdmfK1XItwgKved3Mwa4od5Qr3w3nOLcQpWAdyuB', 'Vy3aqAAAAAABupPwAAABkqIs83w', 'I49XFtoyLLhveG0cSfCzeaMAxVor8nIj', '2024-10-19 00:28:28', '2024-10-19 00:28:28', NULL, NULL, NULL),
(8, 'S3cZsG19QkvX6svBgcNtj1gLCiKG1WEIUBDzV0fC', 'lN8i7AAAAAABupPwAAABkqO_2GY', 'Xv5nKQE31I3faAPIzc8JXF5eGZKeDPSa', '2024-10-19 07:48:32', '2024-10-19 07:48:32', NULL, NULL, NULL),
(10, 'p1pjALt7xA1BA3WwpbPnFuD8DgjWn6DN2R4UJC5q', 'yCR8oAAAAAABupPwAAABkq-_zK8', 'zLTq1kFr6wdWbiJ91WJOCPieYFgWOM7R', '2024-10-21 15:43:55', '2024-10-21 15:43:55', NULL, NULL, NULL),
(13, 'IF3DOF5VWaBYRqCkBJ33cOeihDP0umjuZtAnIU7X', 'bxKz5AAAAAABupPwAAABkv097D4', 'lDuCDFDaeMRrcu8DYIkJULHOhm4BbWTE', '2024-11-05 16:52:27', '2024-11-05 16:52:27', 36, NULL, NULL),
(14, '5MIct3SFyKj1XPH6zx6m3dkIg8fuIC2nrkwZXD7j', 'YlPMPQAAAAABupPwAAABkwtnpO0', 'RwiVf2EiCO1cTwz61PESt1MDvbldu1fj', '2024-11-08 10:52:42', '2024-11-08 10:52:42', 34, NULL, NULL),
(15, 'ce569oopf4faRPV4LEzHvuc1gvEPqs1MSi5al3JK', 'vtMjNQAAAAABupPwAAABkwtporI', 'P4ZauizOTi9ckM1qBQgs2KutHaqn56ls', '2024-11-08 10:54:52', '2024-11-08 10:54:52', 34, NULL, NULL),
(16, 'pdYNCV1fpgRsrKmUs4DjkPPbmmoQQguYaIfWzkb6', 'XLwiygAAAAABupPwAAABkwtroaw', 'hTVV0YKRZn36pf4F30dRAtzVyLCZhjeC', '2024-11-08 10:57:03', '2024-11-08 10:57:03', 34, NULL, NULL),
(17, 'lZp6WJmF8ivwmYM8dZKGlWu34UPj08cGGMK3lOlo', 'YvKgPQAAAAABupPwAAABkwx2sBg', 'OvTBxh1NogxPLZmg2VEkaCoSspfE6VoI', '2024-11-08 15:48:45', '2024-11-08 15:48:45', 34, NULL, NULL),
(18, 'Gv6k8iRLa4qWgOpAiW3yX0wUDOymY6ZpFpv9rQl5', 'IgPmgAAAAAABupPwAAABkw5-t8E', 'f7aw3IaJgCIuURGu06RGsFLfu5XemlcT', '2024-11-09 01:16:46', '2024-11-09 01:16:46', 34, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_confirmed` tinyint(1) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `is_activated` tinyint(1) DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `twitter_account_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_access_token_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_organization_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_access_token` text COLLATE utf8mb4_unicode_ci,
  `snapchat_refresh_token` text COLLATE utf8mb4_unicode_ci,
  `snapchat_display_name` text COLLATE utf8mb4_unicode_ci,
  `snapchat_member_status` text COLLATE utf8mb4_unicode_ci,
  `snapchat_username` text COLLATE utf8mb4_unicode_ci,
  `snapchat_token_expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `image`, `role`, `permissions`, `is_confirmed`, `confirmed_at`, `is_activated`, `activated_at`, `token`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `twitter_account_id`, `twitter_access_token`, `twitter_access_token_secret`, `tiktok_id`, `tiktok_token`, `snapchat_id`, `snapchat_email`, `snapchat_name`, `snapchat_avatar`, `snapchat_organization_id`, `snapchat_access_token`, `snapchat_refresh_token`, `snapchat_display_name`, `snapchat_member_status`, `snapchat_username`, `snapchat_token_expires_at`) VALUES
(1, 'admin', 'john@example.com', '1234567890', NULL, 'agency', 'all', 1, '2024-08-10 00:35:21', 1, '2024-08-10 00:35:21', 'Y5todCIVqfBKj0PJyo3wSDVeQWG2ofMWoCg1pmwI9XNHDJ85AxhKFaB65Zut', '2024-08-09 23:35:21', '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', 'xM18KrihJUH1HXHpshVg490D87leBjjdZUtAiFxKyZckAIp5R8MgGLBvlzKb', '2024-08-09 23:35:22', '2024-11-05 14:18:40', NULL, '1808473417277997056', '1808473417277997056-PUYHttO5nZA0wTJNQDXRrOw17RYWL1', 'r59Ex3M8bxDHinGhpW7XUeYNBjMlb8M00uyjqPMmOPkiC', '-000SS5ubxILPRX7aQQ5_W2TCp4Oox9aguKE', 'rft.fgmUr5dJSfNo1dlhDL3uixCEMxnaPCwtjS8CRxaJaO74MfQAASHW5h9tmErQ!5622.va', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'admin2', 'admin2@example.com', '1234567890', NULL, 'admin', 'all', 1, '2024-08-10 00:35:22', 1, '2024-08-10 00:35:22', 'H5znYfB97M9D9xyiwHcG5nD5PdSyTxB4EnNauXA58oSULVeWwe0QTjbGa078', '2024-08-09 23:35:22', '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', '9fSoS0Wd7x', '2024-08-09 23:35:22', '2024-08-19 23:48:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Editagency1', 'agency1@example.com', '1234567890', NULL, 'agent', 'all', 1, '2024-08-10 00:35:22', 1, '2024-08-10 00:35:22', NULL, '2024-08-09 23:35:22', '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', '9R37gcW3T4', '2024-08-09 23:35:22', '2024-08-19 17:30:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'agency2', 'agency2@example.com', 'yyyy111xxx', NULL, 'agency', 'all', 1, '2024-08-10 00:35:22', 1, '2024-08-10 00:35:22', NULL, '2024-08-09 23:35:22', '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', 'raOaM9Jrs2', '2024-08-09 23:35:22', '2024-08-19 17:45:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'agency3', 'agency3@example.com', NULL, NULL, 'agency', 'all', 1, '2024-08-10 00:35:22', 1, '2024-08-10 00:35:22', 'A09jUnl6BF6Q77PxUvMz8ngtiNFYkOSnWIyNoFu4IkVwSUp63Y6LjtqupOzx', '2024-08-09 23:35:22', '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', 'FkzytzpJAU', '2024-08-09 23:35:23', '2024-08-19 18:12:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'agent', 'agent@example.com', '1234567890', NULL, 'agency', 'all', 1, '2024-08-10 00:35:23', 1, '2024-08-10 00:35:23', 'CGtHXPHhWnBu5W254NVsKHGNZgbAzPGTbnXVz79qgE3Wya6cvQIBD1GqjmR2', '2024-08-09 23:35:23', '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', 'hSBNO3rZ9Z', '2024-08-09 23:35:23', '2024-08-19 17:02:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Yetta Bauer', 'boze@mailinator.com', NULL, NULL, 'agency', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-10 13:43:38', '2024-08-19 17:01:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'amir', 'amir@gmail.com', NULL, NULL, 'agency', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-19 17:52:13', '2024-08-19 17:55:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'khalid', 'khalid@gmail.com', NULL, NULL, 'agency', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-19 17:54:50', '2024-08-19 17:54:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'admin0000', 'ossama@advert.com', '123', 'profile.jpg', 'admin', 'all', 1, '2024-08-20 00:13:06', 1, '2024-08-20 00:13:06', 'THIqVQjxfYF8t42KPKiwUOb01BGAlMdGSdUn20q5QmjwYh3O2GQlI80ykTSG', '2024-08-19 23:13:06', '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', 'mQ2td3H5ypc3hiZMKUPJtHiiFKnH4t67Oq2CEepHFr4FxGpwvjUVm0nvFJVh', '2024-08-19 23:13:06', '2024-10-20 10:18:51', NULL, '1808473417277997056', '1808473417277997056-PUYHttO5nZA0wTJNQDXRrOw17RYWL1', 'r59Ex3M8bxDHinGhpW7XUeYNBjMlb8M00uyjqPMmOPkiC', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'brahim@fff.coi', 'brahim@fff.coi', '2121121221', NULL, 'agency', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-20 11:36:15', '2024-08-20 11:36:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'Mercedes Hewitt', 'buloryqeq@mailinator.com', '+1 (366) 569-7339', NULL, 'agency', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-20 11:38:51', '2024-08-20 11:38:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'Alec Woods', 'rypowu@mailinator.com', '+1 (606) 445-4187', NULL, 'agency', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-20 11:40:20', '2024-08-20 11:40:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'Mona Soto', 'sedym@mailinator.com', '+1 (489) 635-1649', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-20 11:41:38', '2024-08-20 11:41:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'bbbbbb', 'leqicib@mailinator.com', '+1 (772) 679-2664', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-20 11:41:47', '2024-08-20 11:50:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'Eleanor Chaney', 'virabagyfa@mailinator.com', '+1 (485) 511-6601', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-20 23:45:57', '2024-08-20 23:45:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'Amy Santos', 'xowe@mailinator.com', '+1 (485) 112-7556', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-20 23:51:22', '2024-08-21 00:09:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'Ingrid Bass14', 'rexawbih@mailinator.com', '+1 (923) 378-5056', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-20 23:51:54', '2024-08-21 00:10:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'Abra Mason', 'brahim@labdaa.com', '+1 (778) 961-7197', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-21 00:14:26', '2024-08-21 00:27:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'omari', 'omari@mailinator.com', '+1 (108) 242-4326', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-08-21 00:30:12', '2024-08-25 20:06:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'Osama A', 'contact@primetag.com', NULL, NULL, 'agency', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', NULL, '2024-10-04 18:07:33', '2024-11-08 10:52:40', NULL, NULL, NULL, NULL, NULL, NULL, 'e9678e98-f946-4a06-b6ae-fd7f60eb9746', 'diya@newnetwork.sa', 'New Network', NULL, '5c727774-b4f6-4e82-a6a3-eeb66cdbde9e', 'eyJpc3MiOiJodHRwczpcL1wvYWNjb3VudHMuc25hcGNoYXQuY29tXC9hY2NvdW50c1wvb2F1dGgyXC90b2tlbiIsInR5cCI6IkpXVCIsImVuYyI6IkExMjhDQkMtSFMyNTYiLCJhbGciOiJkaXIiLCJraWQiOiJhY2Nlc3MtdG9rZW4tYTEyOGNiYy1oczI1Ni4wIn0..ZWH6Dwj8mroT2icriMCYLw.JxxKN9KBc9FxCmblC2xaOO0UgDTpNhfspEaBQx15jKIgAuxSAWRT2fhbztVoCVk6s-igmUDG9jBrb78yaD-5jwcYzatAoTAkDPwOb-LRx_YyDnfJPDNIftnECfPEqfLladY2knF-hajd0JCzv4n9snm53eaDTzZ7X3tb3oXG1BQiqLnuzgIRgUCHYIi-mfcYV4EuT1lUZfORJnaHF65CMlVwkKLsUv4uj55qp-dOXqkA1WnXxQTQpE5sfsccJdeDfybWSPVryHZY9QxxMMffqy9yeYZ4e66x4GfIqmLRIKziwYIhbqliX9j-crv1rSskSyC-A8Mex8MOGWMBhiPoK_J0hPoS8N0djSr3vwXlL2KyQ8lL1fpTUFmfF6LG7SSOHJx8mVFp1mD6SEnusiwwkydcOeq2igGZ5lJiNwWOJknmrkYpvutTaREXlgPqO1WycXuhTD7ToJv0tJldnDPhr-DIA7NMz78QIJ6u7C3-lgYrpE3ayQhF6LJ7QAubObAUzbANdvLsWJfwSZddE0iQGDufZ1ptkF-Hzdj6kMXnJAhpLUPKHPRjm3aY5tqg2XtcPnm4wOWTqNFY15Y_unodnHOnZrk3BdImwa1MSl85dXC98Md6UlsZsjilXwH5jVggbQ-0jNovhT0z9zi_N6wv265bdwF6LPblpHQRgBFxP3rcS_nZ14GKaRciT30ils0r8PQUAkWMTKiLCTB1gd0b858YYUYm6mAG8QuUa7jbAu8.82fDi-4gKOVXc1VZ6WqRmg', 'hCgwKCjE3MjQ2OTUyMjESpQFk2gFwF0yEtg-TCRna95LkfiqammIxJB-2vnusbHfbd_7HlZTe5_tkVyVB3cWgevHRH5lfFK8xvKPpWsUYaT545ujWVhJoQXYoxLoeJw8RTZgpXsUzUzk7if-qK1sY8-T-CXt57sTSmP1dJRTDGNTzttdPzMhnBQSEKIl0yiOlptfDgikbdqB-OCV6t_NF9G47PuqDHeX9FBILSBoQBXEILngVvYw', 'New Network', 'MEMBER', 'newnetwork_ads', '2024-10-21 16:25:09'),
(35, 'Kyla Meyers', 'test@mailinator.com', '+1 (547) 114-3774', NULL, 'agency', NULL, 1, NULL, 1, NULL, NULL, NULL, 'THIqVQjxfYF8t42KPKiwUOb01BGAlMdGSdUn20q5QmjwYh3O2GQlI80ykTSG', NULL, '2024-10-05 05:03:07', '2024-10-05 06:30:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'Osama', 'office1@gmail.com', '+1 (579) 139-1384', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$QzbPqbx9HCyeYk4MKRghpeX41LU5w6lz0hT5xMxms9kgS1s9U5N7u', NULL, '2024-10-05 05:15:54', '2024-11-05 17:03:21', NULL, NULL, NULL, NULL, NULL, NULL, 'e9678e98-f946-4a06-b6ae-fd7f60eb9746', 'diya@newnetwork.sa', 'New Network', NULL, '5c727774-b4f6-4e82-a6a3-eeb66cdbde9e', 'eyJpc3MiOiJodHRwczpcL1wvYWNjb3VudHMuc25hcGNoYXQuY29tXC9hY2NvdW50c1wvb2F1dGgyXC90b2tlbiIsInR5cCI6IkpXVCIsImVuYyI6IkExMjhDQkMtSFMyNTYiLCJhbGciOiJkaXIiLCJraWQiOiJhY2Nlc3MtdG9rZW4tYTEyOGNiYy1oczI1Ni4wIn0..cvXkFm45AenUx_WdH6_gCA.ek-dKJb9bcVzCgaa3ckJa4dl0ASZPWRJr_l2MukheIN6ska--AWRbV3FiWva-e4_x_R5N98EO0oFR3mHaqVQf9Bqcwz5cnyRYIKY9HtUJT0l3SIcoYQVEYYZRDngODc9Kev_rlXhYol6KGUgU9d4x_rzBarzLcJySYQLjLdyG15vH3CIHtLKx5bcGMDFlqFu2JZtmBpv5M6VmJ-1KZNLhR78GEyj-lBhcDvxit8Wfy8WTOwVydPNGEPPUZfuCdX7FXSuZ5Bv6OVNeYA6iYPq1V_i0OQ9UGSXcOish_F5DmqsiSLGdXZrx0KCbLj6kd_baOKdcoGWNzBDCUXG0lA1DDsom91JXTnnpKmj0Hmf2rkpcUHBFavWdYPkFkAwcX7IUFWqeCzlOTcso350QdrktwJdJYJXP_QcKHCtl0I2GrGUZgTu-YbzUfM5gyg5Um-enrSi5v4qKkKW1C_T41f9aVKwyy7Fiu6_CGwbQY-t8XDL6ivHXDTtyDf3GjUY0HUL5usLDB8T4aCIvMK9Y0KsdESAZGR9ksf96je8UW27ZKwPRgzl3b0QxiiGDH-bnB96RZMtUcgfncRYa2y-8FgudNRbGdyx2hRwdYHXdE7UX_UCKSJkZV57c_H4NVqIe6nrtSkDUC5xpiy-OQtLUA0HmL1WTF0pDNFae4JnEp1jwrqGeicngj2LN05yEtiyDGLriaeBr08XBbOE6Hhk3UGSUbSpUa7EEQMSFZocbsN5hrQ.un9ONpNGAfSnVRRlbONMHA', 'hCgwKCjE3MjcxMTQ0MjESpQFwnkh26AE5bTtpeR_zptrZpATkgzI8as7LZXbjptK4GXaLzSKgO8usD9o9v_H4-McxG39V04DjQX4c4UkssfjkKCGlM4xp_1TH23iAB3MbgKFnZ5somlUIlqaHUPjV14OgRvQePYUj_fKg9y0OpsZMJRScJKFuYVSsVgHX3Jhra9WpaPBaHexJvMgmw1r8-3RiY6UF9THVWGd8nWUTxxqCn5E67P4', 'New Network', 'MEMBER', 'newnetwork_ads', '2024-11-05 18:03:21'),
(37, 'Nerea Becker', 'qocup@mailinator.com', '+1 (378) 978-4881', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$8Z4GE7pwubNoCHPcHuJ3xONgj.qVNJZesqadRKoEjWGZUWyAKQVgG', NULL, '2024-10-05 05:22:38', '2024-10-05 05:22:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'Owen Villarreal', 'tocyty@mailinator.com', '+1 (264) 781-3283', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$AVDTdur73GAEk/bR1rzbQe6uvNYfybPEIR3kR1QsUriBxbPW938WW', NULL, '2024-10-05 05:23:52', '2024-10-05 05:23:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'Kane Buck', 'wiqe@mailinator.com', '+1 (546) 737-1183', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$zyHq7az0zY2o.LYK9VzuWeQyrNdY/FcKLExq7Cceg.1jb07wVmjvq', NULL, '2024-10-05 05:28:46', '2024-10-05 05:28:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'eeeee', 'wiqe222@mailinator.com', '44353453', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$xRgdykgu10q6fHD3mi5OcOjI12tfisAOQPe0JaxdsqtmW0Xkze1u2', NULL, '2024-10-05 05:29:43', '2024-10-05 05:29:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'www', 'erwqr@example.com', '432334', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$BKjTRCJEtGDhr.tyotsq0uDDUR0bqh6PxG6mgr2.3iNzV5y6VzDo.', NULL, '2024-10-05 05:55:48', '2024-10-05 05:55:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'test', 'brahim@gmail.com', '34314143', NULL, 'agent', NULL, 1, NULL, 1, NULL, NULL, NULL, '$2y$12$Qj8hHPN2ZGa.mWtL..VgxebbvgQL6W7cu/kcxVi0yhjPWQ0xt0ntG', NULL, '2024-10-05 05:59:22', '2024-10-05 06:36:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(43, '6QBUPT', '2nFC7ZSGS5rpWecozEBbTZvwM3Y@ScH8V.com', NULL, NULL, 'agency', NULL, 0, NULL, NULL, NULL, NULL, NULL, '$2y$12$K4W1ntUccbjuYC7lk7o.R.DTG4VHfPaPeMy585rFkk.2j0dJs2SGW', NULL, '2024-10-12 08:46:18', '2024-11-05 17:20:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'Aspen French', 'giqury@mailinator.com', NULL, NULL, '	\nagency', NULL, 1, NULL, NULL, NULL, NULL, NULL, '$2y$12$t8vEyK1vP96Gftq1XHWhC.oHLauRcn65hOExW1euZn8J8id0oo/5G', NULL, '2024-10-20 20:16:36', '2024-11-05 14:54:44', NULL, NULL, NULL, NULL, NULL, NULL, 'e638842e-37f3-4db1-83c1-096ee2c590ba', 'brahimdev13@gmail.com', 'brahim labdaa', NULL, 'd5ba7edf-8b3c-4ae6-b318-98f180d774d9', 'eyJpc3MiOiJodHRwczpcL1wvYWNjb3VudHMuc25hcGNoYXQuY29tXC9hY2NvdW50c1wvb2F1dGgyXC90b2tlbiIsInR5cCI6IkpXVCIsImVuYyI6IkExMjhDQkMtSFMyNTYiLCJhbGciOiJkaXIiLCJraWQiOiJhY2Nlc3MtdG9rZW4tYTEyOGNiYy1oczI1Ni4wIn0..JU3Svr2rYcStls_34j-WXA.HOkki1_gvEMIizl7SaSjxIMuVSlnnZIMQPhG5FfDsMJbVM7Le_DmV92hcOCga1UKisaJbcMezusehYHq4nSzBpA0fxENR7LhU3HQDg0558def1MmveZJa4UnEFhNWz22i_aU9R2MbqDJiUGkrEeo5yKpvCPUYDcQgoC_9pJ83WRfbbsuRf5m4j3_Oq6S8ZKUHm6hO9Ai0aXgwelUjl0pyshOdlVNgPZo69FehGVIcaxvXUNBIRKaR6_DlT5ZHT-EkiGD3FGXtFhniQlCnM7sTg9HZxu6dA3Nmu6l4J2v982T8LbpD5TAkio95Oe5XrHntys1tQ-KJt-XIOb2xOOVd9m-qMmb7bolBQhKRbHCiv-WtDh-f4m7XrgYIFf15oMeBbIA4Zge0U5IXJNnVJyd6r-O2ez3mC6zGwlVvti6wBpb05pdmt_T7ktAGU1nRyXSLDAuIe8vZiOB90445zngbBUmQwIKQtLAFD3Dyc7ztbPtzlHD3RCrjXq2tEOfzjCCUyCe8iCeiPfV_r_B2Roiq8k05ztkodF5iS4epkAc9sfot9pGk4j3d-ktnStGBeZ5fb5eCDQIelw2JSroqI4lIkouVnzNLiHJoJBMUutwbqn0jhFqvEAFVKTPKNAwJGqtH7F9fTI7rkBjOJSXJAdAK4nwttRI3JxtSBQ9b4LVrwuIOIvr-6pHYKkA0HA4X01Wnp18x6bQqw3d8RREAZQZv1US9iLCgfvGJXQF0Emb-ds.ZZq5daMDM-fDTZvB6Kt_oA', 'hCgwKCjE3MjcxMTQ0MjESpQG3C0uSpBHNJBdeXehZusze1Dj5oOn-PAIw4KBlpg2o8ivSRY7o5Dh_f9tck_eTksfSHvRR_PVCD9nhY_4HR2o5OnlXlkDcLwfWQO-UK3QkffDZ-K61VgZj8e3khPwQOgEi94RTHhJzoamJ_bc16at4YboQ9iAZEgGys0E_VgD9ZzOUXWVwshmL-PHfKy-5ZRmGXvtOFIZOh3lq6UFfWqnQPWHCb_U', 'brahim labdaa', 'MEMBER', 'brahimdev13', '2024-11-05 15:54:44'),
(45, 'super_admin', 'super_admin@example.com', '1234567890', NULL, 'super_admin', 'all', 1, '2024-08-10 00:35:21', 1, '2024-08-10 00:35:21', 'Y5todCIVqfBKj0PJyo3wSDVeQWG2ofMWoCg1pmwI9XNHDJ85AxhKFaB65Zut', '2024-08-09 23:35:21', '$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.', 'JNrIfhBR1sIVR7kd6vR6oqDwBMfcgez2HUvxYH7oSxy6RoO6VEXp6TOGh1Il', '2024-08-09 23:35:22', '2024-10-16 21:41:01', NULL, '1808473417277997056', '1808473417277997056-PUYHttO5nZA0wTJNQDXRrOw17RYWL1', 'r59Ex3M8bxDHinGhpW7XUeYNBjMlb8M00uyjqPMmOPkiC', '-000SS5ubxILPRX7aQQ5_W2TCp4Oox9aguKE', 'rft.fgmUr5dJSfNo1dlhDL3uixCEMxnaPCwtjS8CRxaJaO74MfQAASHW5h9tmErQ!5622.va', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_account_id_unique` (`account_id`),
  ADD KEY `accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `accounts_x`
--
ALTER TABLE `accounts_x`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_x_account_id_unique` (`account_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_user_id_foreign` (`user_id`);

--
-- Indexes for table `ads_x_metrics`
--
ALTER TABLE `ads_x_metrics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ads_x_metrics_account_id_foreign` (`account_id`);

--
-- Indexes for table `ad_x_analytics`
--
ALTER TABLE `ad_x_analytics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agencies`
--
ALTER TABLE `agencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agencies_user_id_foreign` (`user_id`),
  ADD KEY `agencies_pack_id_foreign` (`pack_id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agents_agency_id_foreign` (`agency_id`),
  ADD KEY `agents_user_id_foreign` (`user_id`),
  ADD KEY `agents_pack_id_foreign` (`pack_id`);

--
-- Indexes for table `campaigns_x`
--
ALTER TABLE `campaigns_x`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `campaigns_x_campaign_id_unique` (`campaign_id`),
  ADD KEY `campaigns_x_account_id_foreign` (`account_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `line_items_x`
--
ALTER TABLE `line_items_x`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `line_items_x_line_item_id_unique` (`line_item_id`),
  ADD KEY `line_items_x_campaign_id_foreign` (`campaign_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_sender_id_foreign` (`sender_id`),
  ADD KEY `notifications_received_id_foreign` (`received_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `packs`
--
ALTER TABLE `packs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `promoted_tweets_x`
--
ALTER TABLE `promoted_tweets_x`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promoted_tweets_x_tweet_id_unique` (`tweet_id`),
  ADD KEY `promoted_tweets_x_line_item_id_foreign` (`line_item_id`);

--
-- Indexes for table `role_access`
--
ALTER TABLE `role_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `snapchat_accounts`
--
ALTER TABLE `snapchat_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `snapchat_accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `snapchat_ads`
--
ALTER TABLE `snapchat_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `snapchat_adsquads`
--
ALTER TABLE `snapchat_adsquads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `snapchat_adsquads_snapchat_campaign_id_foreign` (`snapchat_campaign_id`);

--
-- Indexes for table `snapchat_campaigns`
--
ALTER TABLE `snapchat_campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `snapchat_campaigns_snapchat_account_id_foreign` (`snapchat_account_id`);

--
-- Indexes for table `snap_ads`
--
ALTER TABLE `snap_ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `snap_ads_snapchat_adsquad_id_foreign` (`snapchat_adsquad_id`);

--
-- Indexes for table `twitter_states`
--
ALTER TABLE `twitter_states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `twitter_states_state_unique` (`state`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `accounts_x`
--
ALTER TABLE `accounts_x`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ads_x_metrics`
--
ALTER TABLE `ads_x_metrics`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ad_x_analytics`
--
ALTER TABLE `ad_x_analytics`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `agencies`
--
ALTER TABLE `agencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `campaigns_x`
--
ALTER TABLE `campaigns_x`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `line_items_x`
--
ALTER TABLE `line_items_x`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packs`
--
ALTER TABLE `packs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `promoted_tweets_x`
--
ALTER TABLE `promoted_tweets_x`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_access`
--
ALTER TABLE `role_access`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `snapchat_accounts`
--
ALTER TABLE `snapchat_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `snapchat_ads`
--
ALTER TABLE `snapchat_ads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `snapchat_adsquads`
--
ALTER TABLE `snapchat_adsquads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `snapchat_campaigns`
--
ALTER TABLE `snapchat_campaigns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1280;

--
-- AUTO_INCREMENT for table `snap_ads`
--
ALTER TABLE `snap_ads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `twitter_states`
--
ALTER TABLE `twitter_states`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ads_x_metrics`
--
ALTER TABLE `ads_x_metrics`
  ADD CONSTRAINT `ads_x_metrics_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `agencies`
--
ALTER TABLE `agencies`
  ADD CONSTRAINT `agencies_pack_id_foreign` FOREIGN KEY (`pack_id`) REFERENCES `packs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agencies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `agents_agency_id_foreign` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `agents_pack_id_foreign` FOREIGN KEY (`pack_id`) REFERENCES `packs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `campaigns_x`
--
ALTER TABLE `campaigns_x`
  ADD CONSTRAINT `campaigns_x_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts_x` (`id`);

--
-- Constraints for table `line_items_x`
--
ALTER TABLE `line_items_x`
  ADD CONSTRAINT `line_items_x_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns_x` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_received_id_foreign` FOREIGN KEY (`received_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `promoted_tweets_x`
--
ALTER TABLE `promoted_tweets_x`
  ADD CONSTRAINT `promoted_tweets_x_line_item_id_foreign` FOREIGN KEY (`line_item_id`) REFERENCES `line_items_x` (`id`);

--
-- Constraints for table `snapchat_accounts`
--
ALTER TABLE `snapchat_accounts`
  ADD CONSTRAINT `snapchat_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `snapchat_adsquads`
--
ALTER TABLE `snapchat_adsquads`
  ADD CONSTRAINT `snapchat_adsquads_snapchat_campaign_id_foreign` FOREIGN KEY (`snapchat_campaign_id`) REFERENCES `snapchat_campaigns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `snapchat_campaigns`
--
ALTER TABLE `snapchat_campaigns`
  ADD CONSTRAINT `snapchat_campaigns_snapchat_account_id_foreign` FOREIGN KEY (`snapchat_account_id`) REFERENCES `snapchat_accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `snap_ads`
--
ALTER TABLE `snap_ads`
  ADD CONSTRAINT `snap_ads_snapchat_adsquad_id_foreign` FOREIGN KEY (`snapchat_adsquad_id`) REFERENCES `snapchat_adsquads` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
