-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 14, 2018 at 02:53 PM
-- Server version: 5.7.22-0ubuntu18.04.1
-- PHP Version: 7.2.5-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blogn`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modul` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `sort` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `slug`, `title`, `modul`, `parent`, `sort`, `description`, `created_at`, `updated_at`) VALUES
(1, 'lorem', 'lorem', 'post', 0, 0, NULL, NULL, NULL),
(2, 'ipsum', 'ipsum', 'post', 1, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `site_title` varchar(100) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `address` text,
  `fb` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `gplus` varchar(100) DEFAULT NULL,
  `pinterest` varchar(100) DEFAULT NULL,
  `lng` varchar(100) DEFAULT NULL,
  `lat` varchar(100) DEFAULT NULL,
  `seo` text,
  `keyword` varchar(255) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `user_id`, `site_title`, `telp`, `address`, `fb`, `twitter`, `instagram`, `gplus`, `pinterest`, `lng`, `lat`, `seo`, `keyword`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'zain', '123', NULL, NULL, NULL, NULL, NULL, NULL, '131.044', '-25.363', 'share programing, tutorial komputer', 'laravel, php, linux', 'sSTVXuVFabgLEHSGvQr56KkSj0jLH0BW65oCg41v.png', NULL, '2018-06-14 00:43:29');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `parent` bigint(20) UNSIGNED DEFAULT '0',
  `sort` bigint(20) UNSIGNED DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `slug`, `title`, `description`, `parent`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'about-us', 'About Us', NULL, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2018_06_07_135540_create_posts_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `menu_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo` text COLLATE utf8mb4_unicode_ci,
  `keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `view` int(11) DEFAULT NULL,
  `plugin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `user_id`, `menu_id`, `title`, `content`, `image`, `seo`, `keyword`, `status`, `view`, `plugin`, `created_at`, `updated_at`) VALUES
(1, 'about-us', 1, '1', 'ABOUT US', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, justo eget posuere lacinia, sapien nisl aliquam sem, nec ornare velit erat id libero. Proin convallis eros molestie lectus gravida volutpat. Nam ut ex auctor dolor scelerisque viverra. Ut lacus diam, consectetur vel nisi a, mollis lobortis quam. Quisque nisi sapien, pharetra ut tristique non, scelerisque vel est. Aenean semper mi vel tempor dictum. Mauris condimentum lacus quis augue tincidunt, ut dignissim leo ultrices. Aenean viverra pharetra vestibulum. Maecenas tempor eu quam ut convallis. Phasellus ullamcorper ex pretium justo accumsan interdum. Pellentesque massa massa, facilisis et luctus a, tincidunt a lorem. Cras elit mi, tempus ut luctus interdum, convallis ac ipsum.</p>\r\n\r\n<p>Maecenas porttitor eros neque, a eleifend orci convallis lacinia. Duis iaculis eget diam et vestibulum. Nulla quam velit, imperdiet nec mollis nec, interdum sed leo. Etiam blandit nunc id dui placerat sollicitudin. Suspendisse vitae lacinia lectus, vitae facilisis tellus. Etiam at sagittis felis. Quisque id dui ac ex semper molestie vitae ut erat.</p>\r\n\r\n<p>Aliquam blandit turpis risus, eu dictum est auctor sed. Ut finibus eu eros eget dignissim. Aenean faucibus rhoncus placerat. Morbi lacinia sollicitudin sapien, id volutpat nunc elementum et. Cras egestas leo faucibus, tincidunt risus sed, aliquam elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec vitae malesuada nisl. Phasellus turpis ipsum, fermentum sit amet elementum et, elementum sit amet odio. Aliquam et commodo odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum nibh turpis, imperdiet mollis erat et, laoreet aliquam libero. Proin diam nunc, finibus sit amet imperdiet a, ultrices vitae odio. Donec posuere magna non felis luctus, id egestas mi consequat. Nullam quis justo nisl.</p>\r\n\r\n<p>Nam porta facilisis ipsum, quis eleifend orci cursus a. Ut vitae est in ipsum feugiat accumsan. Etiam non ipsum ligula. Sed vulputate pretium purus vitae dictum. Integer mattis blandit massa, in imperdiet arcu ultricies eget. Ut ut elementum dolor. Nullam lacinia egestas mi sit amet vestibulum. Vestibulum ornare non neque a dignissim. Suspendisse viverra ligula purus. Vivamus dictum risus ac felis consequat, vel consectetur nisi ullamcorper. Nam imperdiet quam a euismod egestas. Suspendisse ut maximus neque. Nam auctor velit eget arcu viverra, vel pharetra augue commodo.</p>\r\n\r\n<p>Morbi vitae elit mattis, facilisis sem at, tristique urna. Nunc et lacinia diam. Mauris neque tortor, eleifend ut vehicula mattis, semper sed leo. Ut et tristique velit, id sollicitudin nisi. Sed sit amet hendrerit sapien. Morbi non ex quis ex ultrices vehicula. In interdum accumsan vulputate. Morbi quis massa ac justo pharetra pretium vitae a turpis. Mauris nec ex sit amet purus tristique vestibulum eget a metus. Vivamus sem ipsum, euismod sit amet turpis quis, pharetra tempus massa.</p>', 'kafwd4fn8Fe3KuUjwbEIwed4OaWZs8AUcQERqPAo.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, justo eget posuere lacinia, sapien nisl aliquam sem, nec ornare velit...', 'ABOUT US', 1, NULL, NULL, '2018-06-14 00:35:08', '2018-06-14 00:35:08');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `category_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo` text COLLATE utf8mb4_unicode_ci,
  `keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `view` int(11) DEFAULT NULL,
  `plugin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `slug`, `user_id`, `category_id`, `title`, `content`, `image`, `seo`, `keyword`, `status`, `view`, `plugin`, `created_at`, `updated_at`) VALUES
(1, 'lorem-ipsum-dolor', 1, '1', 'Lorem ipsum dolor', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, justo eget posuere lacinia, sapien nisl aliquam sem, nec ornare velit erat id libero. Proin convallis eros molestie lectus gravida volutpat. Nam ut ex auctor dolor scelerisque viverra. Ut lacus diam, consectetur vel nisi a, mollis lobortis quam. Quisque nisi sapien, pharetra ut tristique non, scelerisque vel est. Aenean semper mi vel tempor dictum. Mauris condimentum lacus quis augue tincidunt, ut dignissim leo ultrices. Aenean viverra pharetra vestibulum. Maecenas tempor eu quam ut convallis. Phasellus ullamcorper ex pretium justo accumsan interdum. Pellentesque massa massa, facilisis et luctus a, tincidunt a lorem. Cras elit mi, tempus ut luctus interdum, convallis ac ipsum.</p>\r\n\r\n<p>Maecenas porttitor eros neque, a eleifend orci convallis lacinia. Duis iaculis eget diam et vestibulum. Nulla quam velit, imperdiet nec mollis nec, interdum sed leo. Etiam blandit nunc id dui placerat sollicitudin. Suspendisse vitae lacinia lectus, vitae facilisis tellus. Etiam at sagittis felis. Quisque id dui ac ex semper molestie vitae ut erat.</p>\r\n\r\n<p>Aliquam blandit turpis risus, eu dictum est auctor sed. Ut finibus eu eros eget dignissim. Aenean faucibus rhoncus placerat. Morbi lacinia sollicitudin sapien, id volutpat nunc elementum et. Cras egestas leo faucibus, tincidunt risus sed, aliquam elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec vitae malesuada nisl. Phasellus turpis ipsum, fermentum sit amet elementum et, elementum sit amet odio. Aliquam et commodo odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum nibh turpis, imperdiet mollis erat et, laoreet aliquam libero. Proin diam nunc, finibus sit amet imperdiet a, ultrices vitae odio. Donec posuere magna non felis luctus, id egestas mi consequat. Nullam quis justo nisl.</p>\r\n\r\n<p>Nam porta facilisis ipsum, quis eleifend orci cursus a. Ut vitae est in ipsum feugiat accumsan. Etiam non ipsum ligula. Sed vulputate pretium purus vitae dictum. Integer mattis blandit massa, in imperdiet arcu ultricies eget. Ut ut elementum dolor. Nullam lacinia egestas mi sit amet vestibulum. Vestibulum ornare non neque a dignissim. Suspendisse viverra ligula purus. Vivamus dictum risus ac felis consequat, vel consectetur nisi ullamcorper. Nam imperdiet quam a euismod egestas. Suspendisse ut maximus neque. Nam auctor velit eget arcu viverra, vel pharetra augue commodo.</p>\r\n\r\n<p>Morbi vitae elit mattis, facilisis sem at, tristique urna. Nunc et lacinia diam. Mauris neque tortor, eleifend ut vehicula mattis, semper sed leo. Ut et tristique velit, id sollicitudin nisi. Sed sit amet hendrerit sapien. Morbi non ex quis ex ultrices vehicula. In interdum accumsan vulputate. Morbi quis massa ac justo pharetra pretium vitae a turpis. Mauris nec ex sit amet purus tristique vestibulum eget a metus. Vivamus sem ipsum, euismod sit amet turpis quis, pharetra tempus massa.</p>', 'eIAbTtYZHbp4FXBaSz889hCV6s60mNjlcgO9PQuD.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, justo eget posuere lacinia, sapien nisl aliquam sem, nec ornare velit...', 'Lorem ipsum dolor', 1, 2, NULL, '2018-06-14 00:30:14', '2018-06-14 00:30:14'),
(2, 'sit-amet', 1, '2', 'sit amet', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, justo eget posuere lacinia, sapien nisl aliquam sem, nec ornare velit erat id libero. Proin convallis eros molestie lectus gravida volutpat. Nam ut ex auctor dolor scelerisque viverra. Ut lacus diam, consectetur vel nisi a, mollis lobortis quam. Quisque nisi sapien, pharetra ut tristique non, scelerisque vel est. Aenean semper mi vel tempor dictum. Mauris condimentum lacus quis augue tincidunt, ut dignissim leo ultrices. Aenean viverra pharetra vestibulum. Maecenas tempor eu quam ut convallis. Phasellus ullamcorper ex pretium justo accumsan interdum. Pellentesque massa massa, facilisis et luctus a, tincidunt a lorem. Cras elit mi, tempus ut luctus interdum, convallis ac ipsum.</p>\r\n\r\n<p>Maecenas porttitor eros neque, a eleifend orci convallis lacinia. Duis iaculis eget diam et vestibulum. Nulla quam velit, imperdiet nec mollis nec, interdum sed leo. Etiam blandit nunc id dui placerat sollicitudin. Suspendisse vitae lacinia lectus, vitae facilisis tellus. Etiam at sagittis felis. Quisque id dui ac ex semper molestie vitae ut erat.</p>\r\n\r\n<p>Aliquam blandit turpis risus, eu dictum est auctor sed. Ut finibus eu eros eget dignissim. Aenean faucibus rhoncus placerat. Morbi lacinia sollicitudin sapien, id volutpat nunc elementum et. Cras egestas leo faucibus, tincidunt risus sed, aliquam elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec vitae malesuada nisl. Phasellus turpis ipsum, fermentum sit amet elementum et, elementum sit amet odio. Aliquam et commodo odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum nibh turpis, imperdiet mollis erat et, laoreet aliquam libero. Proin diam nunc, finibus sit amet imperdiet a, ultrices vitae odio. Donec posuere magna non felis luctus, id egestas mi consequat. Nullam quis justo nisl.</p>\r\n\r\n<p>Nam porta facilisis ipsum, quis eleifend orci cursus a. Ut vitae est in ipsum feugiat accumsan. Etiam non ipsum ligula. Sed vulputate pretium purus vitae dictum. Integer mattis blandit massa, in imperdiet arcu ultricies eget. Ut ut elementum dolor. Nullam lacinia egestas mi sit amet vestibulum. Vestibulum ornare non neque a dignissim. Suspendisse viverra ligula purus. Vivamus dictum risus ac felis consequat, vel consectetur nisi ullamcorper. Nam imperdiet quam a euismod egestas. Suspendisse ut maximus neque. Nam auctor velit eget arcu viverra, vel pharetra augue commodo.</p>\r\n\r\n<p>Morbi vitae elit mattis, facilisis sem at, tristique urna. Nunc et lacinia diam. Mauris neque tortor, eleifend ut vehicula mattis, semper sed leo. Ut et tristique velit, id sollicitudin nisi. Sed sit amet hendrerit sapien. Morbi non ex quis ex ultrices vehicula. In interdum accumsan vulputate. Morbi quis massa ac justo pharetra pretium vitae a turpis. Mauris nec ex sit amet purus tristique vestibulum eget a metus. Vivamus sem ipsum, euismod sit amet turpis quis, pharetra tempus massa.</p>', 'WTMefZvzaBKQ9eEsT4IvtQX05OEqqXt2F44gBrI0.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, justo eget posuere lacinia, sapien nisl aliquam sem, nec ornare velit...', 'sit amet', 1, NULL, NULL, '2018-06-14 00:32:31', '2018-06-14 00:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` bigint(20) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` longtext,
  `image` varchar(50) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `title`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, 'slide', NULL, '6ICOtObgktx1iU82MnXxicUK6oUwWlt0kDopCIMm.jpeg', 1, '2018-06-13 09:14:58', '2018-06-14 00:40:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'zain', 'admin@admin.com', '$2y$10$5ubeZIWh5Hltw5Ziumo0OO9775h/koixU26d0sorz7s2uT2QE/B2m', 'jCe4Fw6IRvyNLR9Os5U1YNcAmOdca8ZymYF4NSXXSRp1OFrFpm9vIH7BtDNX', '2018-06-06 05:46:09', '2018-06-06 05:46:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
