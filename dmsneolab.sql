-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 17, 2017 at 04:55 PM
-- Server version: 10.0.29-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dmsneolab`
--

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_id` int(10) UNSIGNED NOT NULL,
  `os_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `manufatory_id` int(10) UNSIGNED NOT NULL,
  `version_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `name`, `device_code`, `image`, `description`, `type_id`, `os_id`, `model_id`, `status_id`, `manufatory_id`, `version_id`, `created_at`, `updated_at`) VALUES
(17, 'PC PhiLips', '03PC', '2017-02-17-09-13-18-logo_img.png', 'Echo device description', 1, 1, 1, 1, 1, 1, '2017-02-17 02:13:18', '2017-02-17 02:13:18'),
(18, 'PC PhiLips', '03PCw', '2017-02-17-09-13-56-logo.png', 'Echo device description', 1, 1, 1, 1, 1, 1, '2017-02-17 02:13:27', '2017-02-17 02:13:56');

-- --------------------------------------------------------

--
-- Table structure for table `device_infomations`
--

CREATE TABLE `device_infomations` (
  `id` int(10) UNSIGNED NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `device_id` int(10) UNSIGNED NOT NULL,
  `infomation_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_status`
--

CREATE TABLE `device_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `device_status`
--

INSERT INTO `device_status` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Available', 'icon-available.png', NULL, NULL),
(2, 'Unavailable', 'icon-repair.png', NULL, NULL),
(3, 'Broken', 'icon-remove.png', NULL, NULL),
(4, 'Lost', 'icon-lost.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` int(10) UNSIGNED NOT NULL,
  `start_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `end_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_status`
--

CREATE TABLE `history_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `history_status`
--

INSERT INTO `history_status` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Requesting', 'icon-request.png', NULL, NULL),
(2, 'Borrowed', 'icon-unavailable.png', NULL, NULL),
(3, 'Warning', 'icon-warning.png', NULL, NULL),
(4, 'Returned', 'icon-available.png', NULL, NULL),
(5, 'Lost', 'icon-lost.png', NULL, NULL),
(6, 'Canceled', 'icon-remove.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `informations`
--

CREATE TABLE `informations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manufactories`
--

CREATE TABLE `manufactories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `manufactories`
--

INSERT INTO `manufactories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Apple', '2017-02-17 00:53:12', '2017-02-17 00:53:12'),
(2, 'Apple1', '2017-02-17 00:53:32', '2017-02-17 00:53:32'),
(3, 'Apple2', '2017-02-17 00:53:40', '2017-02-17 00:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_11_30_075900_create_history_status_table', 1),
(4, '2016_11_30_075930_create_roles_table', 1),
(5, '2016_11_30_075950_create_os_table', 1),
(6, '2016_11_30_080006_create_device_status_table', 1),
(7, '2016_11_30_080027_create_types_table', 1),
(8, '2016_11_30_080108_create_devices_table', 1),
(9, '2016_12_01_032447_create_models_table', 1),
(10, '2016_12_01_032851_create_versions_table', 1),
(11, '2016_12_01_032939_create_manufactories_table', 1),
(12, '2016_12_01_042820_create_informations_table', 1),
(13, '2016_12_01_062524_create_device_infomations_table', 1),
(14, '2017_02_13_023016_create_histories_table', 1),
(15, '2017_02_13_023704_add_role_id_to_users_table', 1),
(16, '2017_02_13_024339_add_device_id_to_device_infomations_table', 1),
(17, '2017_02_13_024355_add_infomation_id_to_device_infomations_table', 1),
(18, '2017_02_13_025153_add_type_id_to_devices_table', 1),
(19, '2017_02_13_025245_add_os_id_to_devices_table', 1),
(20, '2017_02_13_025253_add_model_id_to_devices_table', 1),
(21, '2017_02_13_025343_add_status_id_to_devices_table', 1),
(22, '2017_02_13_030135_add_device_id_to_histories_table', 1),
(23, '2017_02_13_030152_add_status_id_to_histories_table', 1),
(24, '2017_02_13_030205_add_user_id_to_histories_table', 1),
(25, '2017_02_13_030945_add_image_to_device_status_table', 1),
(26, '2017_02_13_031006_add_image_to_history_status_table', 1),
(27, '2017_02_13_034554_add_manufatory_id_to_devices', 1),
(28, '2017_02_13_034825_add_version_id_to_devices', 1),
(29, '2017_02_14_090542_add_alias_to_roles', 1);

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Moderm', '2017-02-17 00:53:12', '2017-02-17 00:53:12'),
(2, 'Moderm1', '2017-02-17 00:53:31', '2017-02-17 00:53:31'),
(3, 'Moderm2', '2017-02-17 00:53:40', '2017-02-17 00:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `os`
--

CREATE TABLE `os` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `os`
--

INSERT INTO `os` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'IOS', '2017-02-17 00:53:12', '2017-02-17 00:53:12'),
(2, 'IOS1', '2017-02-17 00:53:31', '2017-02-17 00:53:31'),
(3, 'IOS2', '2017-02-17 00:53:40', '2017-02-17 00:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `alias`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin_master', NULL, NULL),
(2, 'member', 'user_member', NULL, NULL),
(3, 'manager', 'user_manager', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'PC', '2017-02-17 00:53:12', '2017-02-17 00:53:12'),
(2, 'PC1', '2017-02-17 00:53:31', '2017-02-17 00:53:31'),
(3, 'PC2', '2017-02-17 00:53:40', '2017-02-17 00:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'dmsAdmin', 'dmsAdmin', 'dmsadmin@gmail.com', '$2y$10$wrp1FnHLeljIkoraBHVRIuF6hVsZ2JQTDuPgMQigESIyTV2mpaIbm', 1, 'kZ4EK7HHss4lAlRx7O5RV6qXbxlUCSBUh1EgSdjRVOIJ5ABOn7DQ86UKnKdT', NULL, '2017-02-17 02:21:31'),
(2, 'admin', 'admin', 'admin@gmail.com', '$2y$10$U8/nZXAii9ylgQp3HcjkUe0NVx9btAU0cL78RehC4SXLmxrgrXEri', 2, 'Zhot0WSXj5Ba8koFHRwORogemaTMitV090mmuwh6cm6DRlV2Qbr4RUYbfgjD', '2017-02-17 01:02:44', '2017-02-17 02:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `versions`
--

CREATE TABLE `versions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `versions`
--

INSERT INTO `versions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '9.1', '2017-02-17 00:53:12', '2017-02-17 00:53:12'),
(2, '9.11', '2017-02-17 00:53:32', '2017-02-17 00:53:32'),
(3, '9.12', '2017-02-17 00:53:40', '2017-02-17 00:53:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devices_type_id_foreign` (`type_id`),
  ADD KEY `devices_os_id_foreign` (`os_id`),
  ADD KEY `devices_model_id_foreign` (`model_id`),
  ADD KEY `devices_status_id_foreign` (`status_id`),
  ADD KEY `devices_manufatory_id_foreign` (`manufatory_id`),
  ADD KEY `devices_version_id_foreign` (`version_id`);

--
-- Indexes for table `device_infomations`
--
ALTER TABLE `device_infomations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_infomations_device_id_foreign` (`device_id`),
  ADD KEY `device_infomations_infomation_id_foreign` (`infomation_id`);

--
-- Indexes for table `device_status`
--
ALTER TABLE `device_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `histories_device_id_foreign` (`device_id`),
  ADD KEY `histories_status_id_foreign` (`status_id`),
  ADD KEY `histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `history_status`
--
ALTER TABLE `history_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufactories`
--
ALTER TABLE `manufactories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `os`
--
ALTER TABLE `os`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_full_name_unique` (`full_name`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `versions`
--
ALTER TABLE `versions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `device_infomations`
--
ALTER TABLE `device_infomations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `device_status`
--
ALTER TABLE `device_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `history_status`
--
ALTER TABLE `history_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `informations`
--
ALTER TABLE `informations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `manufactories`
--
ALTER TABLE `manufactories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `os`
--
ALTER TABLE `os`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `versions`
--
ALTER TABLE `versions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_manufatory_id_foreign` FOREIGN KEY (`manufatory_id`) REFERENCES `manufactories` (`id`),
  ADD CONSTRAINT `devices_model_id_foreign` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`),
  ADD CONSTRAINT `devices_os_id_foreign` FOREIGN KEY (`os_id`) REFERENCES `os` (`id`),
  ADD CONSTRAINT `devices_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `device_status` (`id`),
  ADD CONSTRAINT `devices_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`),
  ADD CONSTRAINT `devices_version_id_foreign` FOREIGN KEY (`version_id`) REFERENCES `versions` (`id`);

--
-- Constraints for table `device_infomations`
--
ALTER TABLE `device_infomations`
  ADD CONSTRAINT `device_infomations_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`),
  ADD CONSTRAINT `device_infomations_infomation_id_foreign` FOREIGN KEY (`infomation_id`) REFERENCES `informations` (`id`);

--
-- Constraints for table `histories`
--
ALTER TABLE `histories`
  ADD CONSTRAINT `histories_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `histories_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `history_status` (`id`),
  ADD CONSTRAINT `histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
