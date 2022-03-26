-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table gcart3.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(191) NOT NULL DEFAULT '0',
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shop_name` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gcart3.admins: ~4 rows (approximately)
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`id`, `name`, `email`, `phone`, `role_id`, `photo`, `password`, `status`, `remember_token`, `created_at`, `updated_at`, `shop_name`) VALUES
	(1, 'Admin', 'admin@gmail.com', '01629552892', 0, '1556780563user.png', '$2y$10$p35S2FczpEfpbe41CX4j4.XE548tHBtF5weGLPxZ56MX5dsOFtaCC', 1, 'mRzttvAl3hr9ODYAMrfYz4iy9gGMj7IqAZvpzuc2RM9vgcRI5j5p9U7DS12N', '2018-03-01 02:27:08', '2019-07-27 00:21:32', 'Genius Store'),
	(5, 'Mr Mamun', 'mamun@gmail.com', '34534534', 17, '1568803644User.png', '$2y$10$3AEjcvFBiQHECgtH9ivXTeQZfMf.rw318G820TtVBsYaCt7UNOwGC', 1, NULL, '2019-09-18 07:47:24', '2019-09-19 00:21:49', NULL),
	(6, 'Mr. Manik', 'manik@gmail.com', '5079956958', 18, '1568863361user-admin.png', '$2y$10$Z3Jx5jHjV2m4HtZHzeaKMuwxkLAKfJ1AX3Ed5MPACvFJLFkEWN9L.', 1, NULL, '2019-09-19 00:22:41', '2019-09-19 00:22:41', NULL),
	(7, 'Mr. Pratik', 'pratik@gmail.com', '34534534', 16, '1568863396user-admin.png', '$2y$10$u.93l4y6wOz6vq3BlAxvU.LuJ16/uBQ9s2yesRGTWUtLRiQSwoH1C', 1, 'iZPbEaxjSWBJMvncLqeMtAQsG7VoSirVMJ1EBfdJogvgXK2DM5mw236fBCOq', '2019-09-19 00:23:16', '2019-09-19 00:23:16', NULL);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;

-- Dumping structure for table gcart3.admin_languages
CREATE TABLE IF NOT EXISTS `admin_languages` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rtl` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.admin_languages: ~2 rows (approximately)
/*!40000 ALTER TABLE `admin_languages` DISABLE KEYS */;
INSERT INTO `admin_languages` (`id`, `is_default`, `language`, `file`, `name`, `rtl`) VALUES
	(1, 0, 'English', '1567232745AoOcvCtY.json', '1567232745AoOcvCtY', 0),
	(2, 1, 'العربية', 'Q91f6MtZ2x.json', 'Q91f6MtZ2x', 1);
/*!40000 ALTER TABLE `admin_languages` ENABLE KEYS */;

-- Dumping structure for table gcart3.admin_user_conversations
CREATE TABLE IF NOT EXISTS `admin_user_conversations` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(191) NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('Ticket','Dispute') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.admin_user_conversations: ~2 rows (approximately)
/*!40000 ALTER TABLE `admin_user_conversations` DISABLE KEYS */;
INSERT INTO `admin_user_conversations` (`id`, `subject`, `user_id`, `message`, `created_at`, `updated_at`, `type`, `order_number`) VALUES
	(1, 'Order Confirmation', 22, 'rfgdfgfd', '2020-01-21 04:18:38', '2020-01-21 04:18:38', 'Ticket', NULL),
	(2, 'نظام محاسبي متعدد الشركات - SAAS يدعم الفاتورة الالكترونية', 13, 'نظام محاسبي متعدد الشركات - SAAS يدعم الفاتورة الالكترونية', '2022-03-26 05:49:21', '2022-03-26 05:49:21', NULL, NULL);
/*!40000 ALTER TABLE `admin_user_conversations` ENABLE KEYS */;

-- Dumping structure for table gcart3.admin_user_messages
CREATE TABLE IF NOT EXISTS `admin_user_messages` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `conversation_id` int(191) NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.admin_user_messages: ~2 rows (approximately)
/*!40000 ALTER TABLE `admin_user_messages` DISABLE KEYS */;
INSERT INTO `admin_user_messages` (`id`, `conversation_id`, `message`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 'rfgdfgfd', 22, '2020-01-21 04:18:38', '2020-01-21 04:18:38'),
	(2, 2, 'نظام محاسبي متعدد الشركات - SAAS يدعم الفاتورة الالكترونية', NULL, '2022-03-26 05:49:21', '2022-03-26 05:49:21');
/*!40000 ALTER TABLE `admin_user_messages` ENABLE KEYS */;

-- Dumping structure for table gcart3.attributes
CREATE TABLE IF NOT EXISTS `attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attributable_id` int(11) DEFAULT NULL,
  `attributable_type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `input_name` varchar(255) DEFAULT NULL,
  `price_status` int(3) NOT NULL DEFAULT '1' COMMENT '0 - hide, 1- show	',
  `details_status` int(3) NOT NULL DEFAULT '1' COMMENT '0 - hide, 1- show	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.attributes: ~10 rows (approximately)
/*!40000 ALTER TABLE `attributes` DISABLE KEYS */;
INSERT INTO `attributes` (`id`, `attributable_id`, `attributable_type`, `name`, `input_name`, `price_status`, `details_status`, `created_at`, `updated_at`) VALUES
	(14, 5, 'App\\Models\\Category', 'Warranty Type', 'warranty_type', 1, 1, '2019-09-24 01:56:07', '2019-09-24 01:56:07'),
	(20, 4, 'App\\Models\\Category', 'Warranty Type', 'warranty_type', 1, 1, '2019-09-24 03:41:46', '2019-10-03 03:18:54'),
	(21, 4, 'App\\Models\\Category', 'Brand', 'brand', 1, 1, '2019-09-24 03:44:13', '2019-10-03 03:19:13'),
	(22, 2, 'App\\Models\\Subcategory', 'Color Family', 'color_family', 1, 1, '2019-09-24 03:45:45', '2019-09-24 03:45:45'),
	(24, 1, 'App\\Models\\Childcategory', 'Display Size', 'display_size', 1, 1, '2019-09-24 03:54:17', '2019-09-24 03:54:17'),
	(25, 12, 'App\\Models\\Subcategory', 'demo', 'demo', 1, 1, '2019-09-24 04:26:47', '2019-09-24 04:26:47'),
	(30, 3, 'App\\Models\\Subcategory', 'Interior Color', 'interior_color', 1, 1, '2019-09-24 07:31:44', '2019-09-24 07:31:44'),
	(31, 8, 'App\\Models\\Childcategory', 'Temperature', 'temperature', 1, 1, '2019-09-24 07:34:35', '2019-09-24 07:34:35'),
	(32, 18, 'App\\Models\\Category', 'Demo', 'demo', 1, 1, '2019-10-03 02:39:12', '2019-10-03 02:39:12'),
	(33, 4, 'App\\Models\\Category', 'RAM', 'ram', 1, 1, '2019-10-12 06:22:03', '2019-10-13 02:30:39');
/*!40000 ALTER TABLE `attributes` ENABLE KEYS */;

-- Dumping structure for table gcart3.attribute_options
CREATE TABLE IF NOT EXISTS `attribute_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.attribute_options: ~39 rows (approximately)
/*!40000 ALTER TABLE `attribute_options` DISABLE KEYS */;
INSERT INTO `attribute_options` (`id`, `attribute_id`, `name`, `created_at`, `updated_at`) VALUES
	(107, 14, 'No Warranty', '2019-09-24 01:56:07', '2019-09-24 01:56:07'),
	(108, 14, 'Local seller Warranty', '2019-09-24 01:56:07', '2019-09-24 01:56:07'),
	(109, 14, 'Non local warranty', '2019-09-24 01:56:07', '2019-09-24 01:56:07'),
	(110, 14, 'International Manufacturer Warranty', '2019-09-24 01:56:07', '2019-09-24 01:56:07'),
	(111, 14, 'International Seller Warranty', '2019-09-24 01:56:07', '2019-09-24 01:56:07'),
	(157, 22, 'Black', '2019-09-24 03:46:26', '2019-09-24 03:46:26'),
	(158, 22, 'White', '2019-09-24 03:46:26', '2019-09-24 03:46:26'),
	(159, 22, 'Sliver', '2019-09-24 03:46:26', '2019-09-24 03:46:26'),
	(160, 22, 'Red', '2019-09-24 03:46:26', '2019-09-24 03:46:26'),
	(161, 22, 'Dark Grey', '2019-09-24 03:46:26', '2019-09-24 03:46:26'),
	(162, 22, 'Dark Blue', '2019-09-24 03:46:26', '2019-09-24 03:46:26'),
	(163, 22, 'Brown', '2019-09-24 03:46:26', '2019-09-24 03:46:26'),
	(172, 24, '40', '2019-09-24 04:25:32', '2019-09-24 04:25:32'),
	(173, 24, '22', '2019-09-24 04:25:32', '2019-09-24 04:25:32'),
	(174, 24, '24', '2019-09-24 04:25:32', '2019-09-24 04:25:32'),
	(175, 24, '32', '2019-09-24 04:25:32', '2019-09-24 04:25:32'),
	(176, 24, '21', '2019-09-24 04:25:32', '2019-09-24 04:25:32'),
	(177, 25, 'demo 1', '2019-09-24 04:26:47', '2019-09-24 04:26:47'),
	(178, 25, 'demo 2', '2019-09-24 04:26:47', '2019-09-24 04:26:47'),
	(187, 30, 'Yellow', '2019-09-24 07:31:44', '2019-09-24 07:31:44'),
	(188, 30, 'White', '2019-09-24 07:31:44', '2019-09-24 07:31:44'),
	(189, 31, '22', '2019-09-24 07:34:35', '2019-09-24 07:34:35'),
	(190, 31, '34', '2019-09-24 07:34:35', '2019-09-24 07:34:35'),
	(191, 31, '45', '2019-09-24 07:34:35', '2019-09-24 07:34:35'),
	(195, 20, 'Local seller warranty', '2019-10-03 03:18:54', '2019-10-03 03:18:54'),
	(196, 20, 'No warranty', '2019-10-03 03:18:54', '2019-10-03 03:18:54'),
	(197, 20, 'international manufacturer warranty', '2019-10-03 03:18:54', '2019-10-03 03:18:54'),
	(198, 20, 'Non-local warranty', '2019-10-03 03:18:54', '2019-10-03 03:18:54'),
	(199, 21, 'Symphony', '2019-10-03 03:19:13', '2019-10-03 03:19:13'),
	(200, 21, 'Oppo', '2019-10-03 03:19:13', '2019-10-03 03:19:13'),
	(201, 21, 'EStore', '2019-10-03 03:19:13', '2019-10-03 03:19:13'),
	(202, 21, 'Infinix', '2019-10-03 03:19:13', '2019-10-03 03:19:13'),
	(203, 21, 'Apple', '2019-10-03 03:19:13', '2019-10-03 03:19:13'),
	(243, 33, '1 GB', '2019-10-13 02:30:39', '2019-10-13 02:30:39'),
	(244, 33, '2 GB', '2019-10-13 02:30:39', '2019-10-13 02:30:39'),
	(245, 33, '3 GB', '2019-10-13 02:30:39', '2019-10-13 02:30:39'),
	(253, 32, 'demo 1', '2019-10-13 06:18:04', '2019-10-13 06:18:04'),
	(254, 32, 'demo 2', '2019-10-13 06:18:04', '2019-10-13 06:18:04'),
	(255, 32, 'demo 3', '2019-10-13 06:18:04', '2019-10-13 06:18:04');
/*!40000 ALTER TABLE `attribute_options` ENABLE KEYS */;

-- Dumping structure for table gcart3.banners
CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Large','TopSmall','BottomSmall') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.banners: ~6 rows (approximately)
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` (`id`, `photo`, `link`, `type`) VALUES
	(1, '1568889151top2.jpg', 'https://www.google.com/', 'TopSmall'),
	(2, '1568889146top1.jpg', NULL, 'TopSmall'),
	(3, '1568889164bottom1.jpg', 'https://www.google.com/', 'Large'),
	(4, '1564398600side-triple3.jpg', 'https://www.google.com/', 'BottomSmall'),
	(5, '1564398579side-triple2.jpg', 'https://www.google.com/', 'BottomSmall'),
	(6, '1564398571side-triple1.jpg', 'https://www.google.com/', 'BottomSmall');
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;

-- Dumping structure for table gcart3.blogs
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(191) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `meta_tag` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `tags` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gcart3.blogs: ~15 rows (approximately)
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` (`id`, `category_id`, `title`, `details`, `photo`, `source`, `views`, `status`, `meta_tag`, `meta_description`, `tags`, `created_at`) VALUES
	(9, 2, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a \r\ndrifting tone like that of a not-quite-tuned-in radio station \r\n                                        rises and for a while drowns out\r\n the patter. These are the sounds encountered by NASA’s Cassini \r\nspacecraft as it dove \r\n                                        the gap between Saturn and its \r\ninnermost ring on April 26, the first of 22 such encounters before it \r\nwill plunge into \r\n                                        atmosphere in September. What \r\nCassini did not detect were many of the collisions of dust particles \r\nhitting the spacecraft\r\n                                        it passed through the plane of \r\nthe ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify">How its Works ?</h3>\r\n                                    <p align="justify">\r\n                                        MIAMI — For decades, South \r\nFlorida schoolchildren and adults fascinated by far-off galaxies, \r\nearthly ecosystems, the proper\r\n                                        ties of light and sound and \r\nother wonders of science had only a quaint, antiquated museum here in \r\nwhich to explore their \r\n                                        interests. Now, with the \r\nlong-delayed opening of a vast new science museum downtown set for \r\nMonday, visitors will be able \r\n                                        to stand underneath a suspended,\r\n 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, \r\nmahi mahi, devil\r\n                                        rays and other creatures through\r\n a 60,000-pound oculus. <br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of\r\n a huge cocktail glass. And that’s just one of many\r\n                                        attractions and exhibits. \r\nOfficials at the $305 million Phillip and Patricia Frost Museum of \r\nScience promise that it will be a \r\n                                        vivid expression of modern \r\nscientific inquiry and exposition. Its opening follows a series of \r\nsetbacks and lawsuits and a \r\n                                        scramble to finish the \r\n250,000-square-foot structure. At one point, the project ran \r\nprecariously short of money. The museum\r\n                                        high-profile opening is \r\nespecially significant in a state s <br></p><p align="justify"><br></p><h3 align="justify">Top 5 reason to choose us</h3>\r\n                                    <p align="justify">\r\n                                        Mauna Loa, the biggest volcano \r\non Earth — and one of the most active — covers half the Island of \r\nHawaii. Just 35 miles to the \r\n                                        northeast, Mauna Kea, known to \r\nnative Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea \r\nlevel. To them it repre\r\n                                        sents a spiritual connection \r\nbetween our planet and the heavens above. These volcanoes, which have \r\nbeguiled millions of \r\n                                        tourists visiting the Hawaiian \r\nislands, have also plagued scientists with a long-running mystery: If \r\nthey are so close together, \r\n                                        how did they develop in two \r\nparallel tracks along the Hawaiian-Emperor chain formed over the same \r\nhot spot in the Pacific \r\n                                        Ocean — and why are their \r\nchemical compositions so different? "We knew this was related to \r\nsomething much deeper,\r\n                                        but we couldn’t see what,” said \r\nTim Jones.\r\n                                    </p>', '15542700986-min.jpg', 'www.geniusocean.com', 36, 1, 'b1,b2,b3', 'Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level.', 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-02-06 12:53:41'),
	(10, 3, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a \r\ndrifting tone like that of a not-quite-tuned-in radio station \r\n                                        rises and for a while drowns out\r\n the patter. These are the sounds encountered by NASA’s Cassini \r\nspacecraft as it dove \r\n                                        the gap between Saturn and its \r\ninnermost ring on April 26, the first of 22 such encounters before it \r\nwill plunge into \r\n                                        atmosphere in September. What \r\nCassini did not detect were many of the collisions of dust particles \r\nhitting the spacecraft\r\n                                        it passed through the plane of \r\nthe ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify">How its Works ?</h3>\r\n                                    <p align="justify">\r\n                                        MIAMI — For decades, South \r\nFlorida schoolchildren and adults fascinated by far-off galaxies, \r\nearthly ecosystems, the proper\r\n                                        ties of light and sound and \r\nother wonders of science had only a quaint, antiquated museum here in \r\nwhich to explore their \r\n                                        interests. Now, with the \r\nlong-delayed opening of a vast new science museum downtown set for \r\nMonday, visitors will be able \r\n                                        to stand underneath a suspended,\r\n 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, \r\nmahi mahi, devil\r\n                                        rays and other creatures through\r\n a 60,000-pound oculus. <br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of\r\n a huge cocktail glass. And that’s just one of many\r\n                                        attractions and exhibits. \r\nOfficials at the $305 million Phillip and Patricia Frost Museum of \r\nScience promise that it will be a \r\n                                        vivid expression of modern \r\nscientific inquiry and exposition. Its opening follows a series of \r\nsetbacks and lawsuits and a \r\n                                        scramble to finish the \r\n250,000-square-foot structure. At one point, the project ran \r\nprecariously short of money. The museum\r\n                                        high-profile opening is \r\nespecially significant in a state s <br></p><p align="justify"><br></p><h3 align="justify">Top 5 reason to choose us</h3>\r\n                                    <p align="justify">\r\n                                        Mauna Loa, the biggest volcano \r\non Earth — and one of the most active — covers half the Island of \r\nHawaii. Just 35 miles to the \r\n                                        northeast, Mauna Kea, known to \r\nnative Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea \r\nlevel. To them it repre\r\n                                        sents a spiritual connection \r\nbetween our planet and the heavens above. These volcanoes, which have \r\nbeguiled millions of \r\n                                        tourists visiting the Hawaiian \r\nislands, have also plagued scientists with a long-running mystery: If \r\nthey are so close together, \r\n                                        how did they develop in two \r\nparallel tracks along the Hawaiian-Emperor chain formed over the same \r\nhot spot in the Pacific \r\n                                        Ocean — and why are their \r\nchemical compositions so different? "We knew this was related to \r\nsomething much deeper,\r\n                                        but we couldn’t see what,” said \r\nTim Jones.\r\n                                    </p>', '15542700902-min.jpg', 'www.geniusocean.com', 14, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-03-06 12:54:21'),
	(12, 2, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a \r\ndrifting tone like that of a not-quite-tuned-in radio station \r\n                                        rises and for a while drowns out\r\n the patter. These are the sounds encountered by NASA’s Cassini \r\nspacecraft as it dove \r\n                                        the gap between Saturn and its \r\ninnermost ring on April 26, the first of 22 such encounters before it \r\nwill plunge into \r\n                                        atmosphere in September. What \r\nCassini did not detect were many of the collisions of dust particles \r\nhitting the spacecraft\r\n                                        it passed through the plane of \r\nthe ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify">How its Works ?</h3>\r\n                                    <p align="justify">\r\n                                        MIAMI — For decades, South \r\nFlorida schoolchildren and adults fascinated by far-off galaxies, \r\nearthly ecosystems, the proper\r\n                                        ties of light and sound and \r\nother wonders of science had only a quaint, antiquated museum here in \r\nwhich to explore their \r\n                                        interests. Now, with the \r\nlong-delayed opening of a vast new science museum downtown set for \r\nMonday, visitors will be able \r\n                                        to stand underneath a suspended,\r\n 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, \r\nmahi mahi, devil\r\n                                        rays and other creatures through\r\n a 60,000-pound oculus. <br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of\r\n a huge cocktail glass. And that’s just one of many\r\n                                        attractions and exhibits. \r\nOfficials at the $305 million Phillip and Patricia Frost Museum of \r\nScience promise that it will be a \r\n                                        vivid expression of modern \r\nscientific inquiry and exposition. Its opening follows a series of \r\nsetbacks and lawsuits and a \r\n                                        scramble to finish the \r\n250,000-square-foot structure. At one point, the project ran \r\nprecariously short of money. The museum\r\n                                        high-profile opening is \r\nespecially significant in a state s <br></p><p align="justify"><br></p><h3 align="justify">Top 5 reason to choose us</h3>\r\n                                    <p align="justify">\r\n                                        Mauna Loa, the biggest volcano \r\non Earth — and one of the most active — covers half the Island of \r\nHawaii. Just 35 miles to the \r\n                                        northeast, Mauna Kea, known to \r\nnative Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea \r\nlevel. To them it repre\r\n                                        sents a spiritual connection \r\nbetween our planet and the heavens above. These volcanoes, which have \r\nbeguiled millions of \r\n                                        tourists visiting the Hawaiian \r\nislands, have also plagued scientists with a long-running mystery: If \r\nthey are so close together, \r\n                                        how did they develop in two \r\nparallel tracks along the Hawaiian-Emperor chain formed over the same \r\nhot spot in the Pacific \r\n                                        Ocean — and why are their \r\nchemical compositions so different? "We knew this was related to \r\nsomething much deeper,\r\n                                        but we couldn’t see what,” said \r\nTim Jones.\r\n                                    </p>', '15542700821-min.jpg', 'www.geniusocean.com', 19, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-04-07 01:04:20'),
	(13, 3, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a \r\ndrifting tone like that of a not-quite-tuned-in radio station \r\n                                        rises and for a while drowns out\r\n the patter. These are the sounds encountered by NASA’s Cassini \r\nspacecraft as it dove \r\n                                        the gap between Saturn and its \r\ninnermost ring on April 26, the first of 22 such encounters before it \r\nwill plunge into \r\n                                        atmosphere in September. What \r\nCassini did not detect were many of the collisions of dust particles \r\nhitting the spacecraft\r\n                                        it passed through the plane of \r\nthe ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify">How its Works ?</h3>\r\n                                    <p align="justify">\r\n                                        MIAMI — For decades, South \r\nFlorida schoolchildren and adults fascinated by far-off galaxies, \r\nearthly ecosystems, the proper\r\n                                        ties of light and sound and \r\nother wonders of science had only a quaint, antiquated museum here in \r\nwhich to explore their \r\n                                        interests. Now, with the \r\nlong-delayed opening of a vast new science museum downtown set for \r\nMonday, visitors will be able \r\n                                        to stand underneath a suspended,\r\n 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, \r\nmahi mahi, devil\r\n                                        rays and other creatures through\r\n a 60,000-pound oculus. <br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of\r\n a huge cocktail glass. And that’s just one of many\r\n                                        attractions and exhibits. \r\nOfficials at the $305 million Phillip and Patricia Frost Museum of \r\nScience promise that it will be a \r\n                                        vivid expression of modern \r\nscientific inquiry and exposition. Its opening follows a series of \r\nsetbacks and lawsuits and a \r\n                                        scramble to finish the \r\n250,000-square-foot structure. At one point, the project ran \r\nprecariously short of money. The museum\r\n                                        high-profile opening is \r\nespecially significant in a state s <br></p><p align="justify"><br></p><h3 align="justify">Top 5 reason to choose us</h3>\r\n                                    <p align="justify">\r\n                                        Mauna Loa, the biggest volcano \r\non Earth — and one of the most active — covers half the Island of \r\nHawaii. Just 35 miles to the \r\n                                        northeast, Mauna Kea, known to \r\nnative Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea \r\nlevel. To them it repre\r\n                                        sents a spiritual connection \r\nbetween our planet and the heavens above. These volcanoes, which have \r\nbeguiled millions of \r\n                                        tourists visiting the Hawaiian \r\nislands, have also plagued scientists with a long-running mystery: If \r\nthey are so close together, \r\n                                        how did they develop in two \r\nparallel tracks along the Hawaiian-Emperor chain formed over the same \r\nhot spot in the Pacific \r\n                                        Ocean — and why are their \r\nchemical compositions so different? "We knew this was related to \r\nsomething much deeper,\r\n                                        but we couldn’t see what,” said \r\nTim Jones.\r\n                                    </p>', '15542700676-min.jpg', 'www.geniusocean.com', 57, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-05-07 01:04:36'),
	(14, 2, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a drifting tone like that of a not-quite-tuned-in radio station rises and for a while drowns out the patter. These are the sounds encountered by NASA’s Cassini spacecraft as it dove the gap between Saturn and its innermost ring on April 26, the first of 22 such encounters before it will plunge into atmosphere in September. What Cassini did not detect were many of the collisions of dust particles hitting the spacecraft it passed through the plane of the ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">How its Works ?</h3><p align="justify">MIAMI — For decades, South Florida schoolchildren and adults fascinated by far-off galaxies, earthly ecosystems, the proper ties of light and sound and other wonders of science had only a quaint, antiquated museum here in which to explore their interests. Now, with the long-delayed opening of a vast new science museum downtown set for Monday, visitors will be able to stand underneath a suspended, 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, mahi mahi, devil rays and other creatures through a 60,000-pound oculus.&nbsp;<br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of a huge cocktail glass. And that’s just one of many attractions and exhibits. Officials at the $305 million Phillip and Patricia Frost Museum of Science promise that it will be a vivid expression of modern scientific inquiry and exposition. Its opening follows a series of setbacks and lawsuits and a scramble to finish the 250,000-square-foot structure. At one point, the project ran precariously short of money. The museum high-profile opening is especially significant in a state s&nbsp;<br></p><p align="justify"><br></p><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">Top 5 reason to choose us</h3><p align="justify">Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level. To them it repre sents a spiritual connection between our planet and the heavens above. These volcanoes, which have beguiled millions of tourists visiting the Hawaiian islands, have also plagued scientists with a long-running mystery: If they are so close together, how did they develop in two parallel tracks along the Hawaiian-Emperor chain formed over the same hot spot in the Pacific Ocean — and why are their chemical compositions so different? "We knew this was related to something much deeper, but we couldn’t see what,” said Tim Jones.</p>', '15542700595-min.jpg', 'www.geniusocean.com', 3, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-06-03 09:02:30'),
	(15, 3, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a drifting tone like that of a not-quite-tuned-in radio station rises and for a while drowns out the patter. These are the sounds encountered by NASA’s Cassini spacecraft as it dove the gap between Saturn and its innermost ring on April 26, the first of 22 such encounters before it will plunge into atmosphere in September. What Cassini did not detect were many of the collisions of dust particles hitting the spacecraft it passed through the plane of the ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">How its Works ?</h3><p align="justify">MIAMI — For decades, South Florida schoolchildren and adults fascinated by far-off galaxies, earthly ecosystems, the proper ties of light and sound and other wonders of science had only a quaint, antiquated museum here in which to explore their interests. Now, with the long-delayed opening of a vast new science museum downtown set for Monday, visitors will be able to stand underneath a suspended, 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, mahi mahi, devil rays and other creatures through a 60,000-pound oculus.&nbsp;<br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of a huge cocktail glass. And that’s just one of many attractions and exhibits. Officials at the $305 million Phillip and Patricia Frost Museum of Science promise that it will be a vivid expression of modern scientific inquiry and exposition. Its opening follows a series of setbacks and lawsuits and a scramble to finish the 250,000-square-foot structure. At one point, the project ran precariously short of money. The museum high-profile opening is especially significant in a state s&nbsp;<br></p><p align="justify"><br></p><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">Top 5 reason to choose us</h3><p align="justify">Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level. To them it repre sents a spiritual connection between our planet and the heavens above. These volcanoes, which have beguiled millions of tourists visiting the Hawaiian islands, have also plagued scientists with a long-running mystery: If they are so close together, how did they develop in two parallel tracks along the Hawaiian-Emperor chain formed over the same hot spot in the Pacific Ocean — and why are their chemical compositions so different? "We knew this was related to something much deeper, but we couldn’t see what,” said Tim Jones.</p>', '15542700464-min.jpg', 'www.geniusocean.com', 6, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-07-03 09:02:53'),
	(16, 2, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a drifting tone like that of a not-quite-tuned-in radio station rises and for a while drowns out the patter. These are the sounds encountered by NASA’s Cassini spacecraft as it dove the gap between Saturn and its innermost ring on April 26, the first of 22 such encounters before it will plunge into atmosphere in September. What Cassini did not detect were many of the collisions of dust particles hitting the spacecraft it passed through the plane of the ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">How its Works ?</h3><p align="justify">MIAMI — For decades, South Florida schoolchildren and adults fascinated by far-off galaxies, earthly ecosystems, the proper ties of light and sound and other wonders of science had only a quaint, antiquated museum here in which to explore their interests. Now, with the long-delayed opening of a vast new science museum downtown set for Monday, visitors will be able to stand underneath a suspended, 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, mahi mahi, devil rays and other creatures through a 60,000-pound oculus.&nbsp;<br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of a huge cocktail glass. And that’s just one of many attractions and exhibits. Officials at the $305 million Phillip and Patricia Frost Museum of Science promise that it will be a vivid expression of modern scientific inquiry and exposition. Its opening follows a series of setbacks and lawsuits and a scramble to finish the 250,000-square-foot structure. At one point, the project ran precariously short of money. The museum high-profile opening is especially significant in a state s&nbsp;<br></p><p align="justify"><br></p><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">Top 5 reason to choose us</h3><p align="justify">Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level. To them it repre sents a spiritual connection between our planet and the heavens above. These volcanoes, which have beguiled millions of tourists visiting the Hawaiian islands, have also plagued scientists with a long-running mystery: If they are so close together, how did they develop in two parallel tracks along the Hawaiian-Emperor chain formed over the same hot spot in the Pacific Ocean — and why are their chemical compositions so different? "We knew this was related to something much deeper, but we couldn’t see what,” said Tim Jones.</p>', '15542700383-min.jpg', 'www.geniusocean.com', 5, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-08-03 09:03:14'),
	(17, 3, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a drifting tone like that of a not-quite-tuned-in radio station rises and for a while drowns out the patter. These are the sounds encountered by NASA’s Cassini spacecraft as it dove the gap between Saturn and its innermost ring on April 26, the first of 22 such encounters before it will plunge into atmosphere in September. What Cassini did not detect were many of the collisions of dust particles hitting the spacecraft it passed through the plane of the ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">How its Works ?</h3><p align="justify">MIAMI — For decades, South Florida schoolchildren and adults fascinated by far-off galaxies, earthly ecosystems, the proper ties of light and sound and other wonders of science had only a quaint, antiquated museum here in which to explore their interests. Now, with the long-delayed opening of a vast new science museum downtown set for Monday, visitors will be able to stand underneath a suspended, 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, mahi mahi, devil rays and other creatures through a 60,000-pound oculus.&nbsp;<br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of a huge cocktail glass. And that’s just one of many attractions and exhibits. Officials at the $305 million Phillip and Patricia Frost Museum of Science promise that it will be a vivid expression of modern scientific inquiry and exposition. Its opening follows a series of setbacks and lawsuits and a scramble to finish the 250,000-square-foot structure. At one point, the project ran precariously short of money. The museum high-profile opening is especially significant in a state s&nbsp;<br></p><p align="justify"><br></p><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">Top 5 reason to choose us</h3><p align="justify">Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level. To them it repre sents a spiritual connection between our planet and the heavens above. These volcanoes, which have beguiled millions of tourists visiting the Hawaiian islands, have also plagued scientists with a long-running mystery: If they are so close together, how did they develop in two parallel tracks along the Hawaiian-Emperor chain formed over the same hot spot in the Pacific Ocean — and why are their chemical compositions so different? "We knew this was related to something much deeper, but we couldn’t see what,” said Tim Jones.</p>', '15542700322-min.jpg', 'www.geniusocean.com', 50, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 09:03:37'),
	(18, 2, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a drifting tone like that of a not-quite-tuned-in radio station rises and for a while drowns out the patter. These are the sounds encountered by NASA’s Cassini spacecraft as it dove the gap between Saturn and its innermost ring on April 26, the first of 22 such encounters before it will plunge into atmosphere in September. What Cassini did not detect were many of the collisions of dust particles hitting the spacecraft it passed through the plane of the ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">How its Works ?</h3><p align="justify">MIAMI — For decades, South Florida schoolchildren and adults fascinated by far-off galaxies, earthly ecosystems, the proper ties of light and sound and other wonders of science had only a quaint, antiquated museum here in which to explore their interests. Now, with the long-delayed opening of a vast new science museum downtown set for Monday, visitors will be able to stand underneath a suspended, 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, mahi mahi, devil rays and other creatures through a 60,000-pound oculus.&nbsp;<br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of a huge cocktail glass. And that’s just one of many attractions and exhibits. Officials at the $305 million Phillip and Patricia Frost Museum of Science promise that it will be a vivid expression of modern scientific inquiry and exposition. Its opening follows a series of setbacks and lawsuits and a scramble to finish the 250,000-square-foot structure. At one point, the project ran precariously short of money. The museum high-profile opening is especially significant in a state s&nbsp;<br></p><p align="justify"><br></p><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">Top 5 reason to choose us</h3><p align="justify">Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level. To them it repre sents a spiritual connection between our planet and the heavens above. These volcanoes, which have beguiled millions of tourists visiting the Hawaiian islands, have also plagued scientists with a long-running mystery: If they are so close together, how did they develop in two parallel tracks along the Hawaiian-Emperor chain formed over the same hot spot in the Pacific Ocean — and why are their chemical compositions so different? "We knew this was related to something much deeper, but we couldn’t see what,” said Tim Jones.</p>', '15542700251-min.jpg', 'www.geniusocean.com', 151, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 09:03:59'),
	(20, 2, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a drifting tone like that of a not-quite-tuned-in radio station rises and for a while drowns out the patter. These are the sounds encountered by NASA’s Cassini spacecraft as it dove the gap between Saturn and its innermost ring on April 26, the first of 22 such encounters before it will plunge into atmosphere in September. What Cassini did not detect were many of the collisions of dust particles hitting the spacecraft it passed through the plane of the ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">How its Works ?</h3><p align="justify">MIAMI — For decades, South Florida schoolchildren and adults fascinated by far-off galaxies, earthly ecosystems, the proper ties of light and sound and other wonders of science had only a quaint, antiquated museum here in which to explore their interests. Now, with the long-delayed opening of a vast new science museum downtown set for Monday, visitors will be able to stand underneath a suspended, 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, mahi mahi, devil rays and other creatures through a 60,000-pound oculus.&nbsp;<br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of a huge cocktail glass. And that’s just one of many attractions and exhibits. Officials at the $305 million Phillip and Patricia Frost Museum of Science promise that it will be a vivid expression of modern scientific inquiry and exposition. Its opening follows a series of setbacks and lawsuits and a scramble to finish the 250,000-square-foot structure. At one point, the project ran precariously short of money. The museum high-profile opening is especially significant in a state s&nbsp;<br></p><p align="justify"><br></p><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">Top 5 reason to choose us</h3><p align="justify">Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level. To them it repre sents a spiritual connection between our planet and the heavens above. These volcanoes, which have beguiled millions of tourists visiting the Hawaiian islands, have also plagued scientists with a long-running mystery: If they are so close together, how did they develop in two parallel tracks along the Hawaiian-Emperor chain formed over the same hot spot in the Pacific Ocean — and why are their chemical compositions so different? "We knew this was related to something much deeper, but we couldn’t see what,” said Tim Jones.</p>', '15542699136-min.jpg', 'www.geniusocean.com', 10, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-08-03 09:03:14'),
	(21, 3, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a drifting tone like that of a not-quite-tuned-in radio station rises and for a while drowns out the patter. These are the sounds encountered by NASA’s Cassini spacecraft as it dove the gap between Saturn and its innermost ring on April 26, the first of 22 such encounters before it will plunge into atmosphere in September. What Cassini did not detect were many of the collisions of dust particles hitting the spacecraft it passed through the plane of the ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">How its Works ?</h3><p align="justify">MIAMI — For decades, South Florida schoolchildren and adults fascinated by far-off galaxies, earthly ecosystems, the proper ties of light and sound and other wonders of science had only a quaint, antiquated museum here in which to explore their interests. Now, with the long-delayed opening of a vast new science museum downtown set for Monday, visitors will be able to stand underneath a suspended, 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, mahi mahi, devil rays and other creatures through a 60,000-pound oculus.&nbsp;<br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of a huge cocktail glass. And that’s just one of many attractions and exhibits. Officials at the $305 million Phillip and Patricia Frost Museum of Science promise that it will be a vivid expression of modern scientific inquiry and exposition. Its opening follows a series of setbacks and lawsuits and a scramble to finish the 250,000-square-foot structure. At one point, the project ran precariously short of money. The museum high-profile opening is especially significant in a state s&nbsp;<br></p><p align="justify"><br></p><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">Top 5 reason to choose us</h3><p align="justify">Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level. To them it repre sents a spiritual connection between our planet and the heavens above. These volcanoes, which have beguiled millions of tourists visiting the Hawaiian islands, have also plagued scientists with a long-running mystery: If they are so close together, how did they develop in two parallel tracks along the Hawaiian-Emperor chain formed over the same hot spot in the Pacific Ocean — and why are their chemical compositions so different? "We knew this was related to something much deeper, but we couldn’t see what,” said Tim Jones.</p>', '15542699045-min.jpg', 'www.geniusocean.com', 36, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 09:03:37'),
	(22, 2, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a drifting tone like that of a not-quite-tuned-in radio station rises and for a while drowns out the patter. These are the sounds encountered by NASA’s Cassini spacecraft as it dove the gap between Saturn and its innermost ring on April 26, the first of 22 such encounters before it will plunge into atmosphere in September. What Cassini did not detect were many of the collisions of dust particles hitting the spacecraft it passed through the plane of the ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">How its Works ?</h3><p align="justify">MIAMI — For decades, South Florida schoolchildren and adults fascinated by far-off galaxies, earthly ecosystems, the proper ties of light and sound and other wonders of science had only a quaint, antiquated museum here in which to explore their interests. Now, with the long-delayed opening of a vast new science museum downtown set for Monday, visitors will be able to stand underneath a suspended, 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, mahi mahi, devil rays and other creatures through a 60,000-pound oculus.&nbsp;<br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of a huge cocktail glass. And that’s just one of many attractions and exhibits. Officials at the $305 million Phillip and Patricia Frost Museum of Science promise that it will be a vivid expression of modern scientific inquiry and exposition. Its opening follows a series of setbacks and lawsuits and a scramble to finish the 250,000-square-foot structure. At one point, the project ran precariously short of money. The museum high-profile opening is especially significant in a state s&nbsp;<br></p><p align="justify"><br></p><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">Top 5 reason to choose us</h3><p align="justify">Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level. To them it repre sents a spiritual connection between our planet and the heavens above. These volcanoes, which have beguiled millions of tourists visiting the Hawaiian islands, have also plagued scientists with a long-running mystery: If they are so close together, how did they develop in two parallel tracks along the Hawaiian-Emperor chain formed over the same hot spot in the Pacific Ocean — and why are their chemical compositions so different? "We knew this was related to something much deeper, but we couldn’t see what,” said Tim Jones.</p>', '15542698954-min.jpg', 'www.geniusocean.com', 68, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 09:03:59'),
	(23, 7, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a drifting tone like that of a not-quite-tuned-in radio station rises and for a while drowns out the patter. These are the sounds encountered by NASA’s Cassini spacecraft as it dove the gap between Saturn and its innermost ring on April 26, the first of 22 such encounters before it will plunge into atmosphere in September. What Cassini did not detect were many of the collisions of dust particles hitting the spacecraft it passed through the plane of the ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">How its Works ?</h3><p align="justify">MIAMI — For decades, South Florida schoolchildren and adults fascinated by far-off galaxies, earthly ecosystems, the proper ties of light and sound and other wonders of science had only a quaint, antiquated museum here in which to explore their interests. Now, with the long-delayed opening of a vast new science museum downtown set for Monday, visitors will be able to stand underneath a suspended, 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, mahi mahi, devil rays and other creatures through a 60,000-pound oculus.&nbsp;<br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of a huge cocktail glass. And that’s just one of many attractions and exhibits. Officials at the $305 million Phillip and Patricia Frost Museum of Science promise that it will be a vivid expression of modern scientific inquiry and exposition. Its opening follows a series of setbacks and lawsuits and a scramble to finish the 250,000-square-foot structure. At one point, the project ran precariously short of money. The museum high-profile opening is especially significant in a state s&nbsp;<br></p><p align="justify"><br></p><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">Top 5 reason to choose us</h3><p align="justify">Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level. To them it repre sents a spiritual connection between our planet and the heavens above. These volcanoes, which have beguiled millions of tourists visiting the Hawaiian islands, have also plagued scientists with a long-running mystery: If they are so close together, how did they develop in two parallel tracks along the Hawaiian-Emperor chain formed over the same hot spot in the Pacific Ocean — and why are their chemical compositions so different? "We knew this was related to something much deeper, but we couldn’t see what,” said Tim Jones.</p>', '15542698893-min.jpg', 'www.geniusocean.com', 5, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2018-08-03 09:03:14'),
	(24, 3, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a drifting tone like that of a not-quite-tuned-in radio station rises and for a while drowns out the patter. These are the sounds encountered by NASA’s Cassini spacecraft as it dove the gap between Saturn and its innermost ring on April 26, the first of 22 such encounters before it will plunge into atmosphere in September. What Cassini did not detect were many of the collisions of dust particles hitting the spacecraft it passed through the plane of the ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">How its Works ?</h3><p align="justify">MIAMI — For decades, South Florida schoolchildren and adults fascinated by far-off galaxies, earthly ecosystems, the proper ties of light and sound and other wonders of science had only a quaint, antiquated museum here in which to explore their interests. Now, with the long-delayed opening of a vast new science museum downtown set for Monday, visitors will be able to stand underneath a suspended, 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, mahi mahi, devil rays and other creatures through a 60,000-pound oculus.&nbsp;<br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of a huge cocktail glass. And that’s just one of many attractions and exhibits. Officials at the $305 million Phillip and Patricia Frost Museum of Science promise that it will be a vivid expression of modern scientific inquiry and exposition. Its opening follows a series of setbacks and lawsuits and a scramble to finish the 250,000-square-foot structure. At one point, the project ran precariously short of money. The museum high-profile opening is especially significant in a state s&nbsp;<br></p><p align="justify"><br></p><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">Top 5 reason to choose us</h3><p align="justify">Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level. To them it repre sents a spiritual connection between our planet and the heavens above. These volcanoes, which have beguiled millions of tourists visiting the Hawaiian islands, have also plagued scientists with a long-running mystery: If they are so close together, how did they develop in two parallel tracks along the Hawaiian-Emperor chain formed over the same hot spot in the Pacific Ocean — and why are their chemical compositions so different? "We knew this was related to something much deeper, but we couldn’t see what,” said Tim Jones.</p>', '15542698832-min.jpg', 'www.geniusocean.com', 34, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 09:03:37'),
	(25, 3, 'How to design effective arts?', '<div align="justify">The recording starts with the patter of a summer squall. Later, a drifting tone like that of a not-quite-tuned-in radio station rises and for a while drowns out the patter. These are the sounds encountered by NASA’s Cassini spacecraft as it dove the gap between Saturn and its innermost ring on April 26, the first of 22 such encounters before it will plunge into atmosphere in September. What Cassini did not detect were many of the collisions of dust particles hitting the spacecraft it passed through the plane of the ringsen the charged particles oscillate in unison.<br><br></div><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">How its Works ?</h3><p align="justify">MIAMI — For decades, South Florida schoolchildren and adults fascinated by far-off galaxies, earthly ecosystems, the proper ties of light and sound and other wonders of science had only a quaint, antiquated museum here in which to explore their interests. Now, with the long-delayed opening of a vast new science museum downtown set for Monday, visitors will be able to stand underneath a suspended, 500,000-gallon aquarium tank and gaze at hammerhead and tiger sharks, mahi mahi, devil rays and other creatures through a 60,000-pound oculus.&nbsp;<br></p><p align="justify">Lens that will give the impression of seeing the fish from the bottom of a huge cocktail glass. And that’s just one of many attractions and exhibits. Officials at the $305 million Phillip and Patricia Frost Museum of Science promise that it will be a vivid expression of modern scientific inquiry and exposition. Its opening follows a series of setbacks and lawsuits and a scramble to finish the 250,000-square-foot structure. At one point, the project ran precariously short of money. The museum high-profile opening is especially significant in a state s&nbsp;<br></p><p align="justify"><br></p><h3 align="justify" style="font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" color:="" rgb(51,="" 51,="" 51);"="">Top 5 reason to choose us</h3><p align="justify">Mauna Loa, the biggest volcano on Earth — and one of the most active — covers half the Island of Hawaii. Just 35 miles to the northeast, Mauna Kea, known to native Hawaiians as Mauna a Wakea, rises nearly 14,000 feet above sea level. To them it repre sents a spiritual connection between our planet and the heavens above. These volcanoes, which have beguiled millions of tourists visiting the Hawaiian islands, have also plagued scientists with a long-running mystery: If they are so close together, how did they develop in two parallel tracks along the Hawaiian-Emperor chain formed over the same hot spot in the Pacific Ocean — and why are their chemical compositions so different? "We knew this was related to something much deeper, but we couldn’t see what,” said Tim Jones.</p>', '15557542831-min.jpg', 'www.geniusocean.com', 40, 1, NULL, NULL, 'Business,Research,Mechanical,Process,Innovation,Engineering', '2019-01-03 09:03:59');
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;

-- Dumping structure for table gcart3.blog_categories
CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.blog_categories: ~7 rows (approximately)
/*!40000 ALTER TABLE `blog_categories` DISABLE KEYS */;
INSERT INTO `blog_categories` (`id`, `name`, `slug`) VALUES
	(2, 'Oil & gas', 'oil-and-gas'),
	(3, 'Manufacturing', 'manufacturing'),
	(4, 'Chemical Research', 'chemical_research'),
	(5, 'Agriculture', 'agriculture'),
	(6, 'Mechanical', 'mechanical'),
	(7, 'Entrepreneurs', 'entrepreneurs'),
	(8, 'Technology', 'technology');
/*!40000 ALTER TABLE `blog_categories` ENABLE KEYS */;

-- Dumping structure for table gcart3.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.categories: ~15 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `slug`, `status`, `photo`, `is_featured`, `image`) VALUES
	(4, 'Electronic', 'electric', 1, '1557807287light.png', 1, '1568709131f6.jpg'),
	(5, 'Fashion & Beauty', 'fashion-and-Beauty', 1, '1557807279fashion.png', 1, '1568709123f1.jpg'),
	(6, 'Camera & Photo', 'camera-and-photo', 1, '1557807264camera.png', 1, '1568709110f2.jpg'),
	(7, 'Smart Phone & Table', 'smart-phone-and-table', 1, '1557377810mobile.png', 1, '1568709597f4.jpg'),
	(8, 'Sport & Outdoor', 'sport-and-Outdoor', 1, '1557807258sports.png', 1, '1568709577f8.jpg'),
	(9, 'Jewelry & Watches', 'jewelry-and-watches', 1, '1557807252furniture.png', 1, '1568709077f7.jpg'),
	(10, 'Health & Beauty', 'health-and-beauty', 1, '1557807228trends.png', 1, '1568709067f3.jpg'),
	(11, 'Books & Office', 'books-and-office', 1, '1557377917bags.png', 1, '1568709050f8.jpg'),
	(12, 'Toys & Hobbies', 'toys-and-hobbies', 1, '1557807214sports.png', 1, '1568709042f9.jpg'),
	(13, 'Books', 'books', 1, '1557807208bags.png', 1, '1568709037f10.jpg'),
	(15, 'Automobiles & Motorcycles', 'automobiles-and-motorcycles', 1, '1568708648motor.car.png', 1, '1568709031f11.jpg'),
	(16, 'Home decoration & Appliance', 'Home-decoration-and-Appliance', 1, '1568708757home.png', 1, '1568709027f12.jpg'),
	(17, 'Portable & Personal Electronics', 'portable-and-personal-electronics', 1, '1568878538electronic.jpg', 0, NULL),
	(18, 'Outdoor, Recreation & Fitness', 'Outdoor-Recreation-and-Fitness', 1, '1568878596home.jpg', 0, NULL),
	(19, 'Surveillance Safety & Security', 'Surveillance-Safety-and-Security', 1, NULL, 0, NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table gcart3.childcategories
CREATE TABLE IF NOT EXISTS `childcategories` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `subcategory_id` int(191) NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.childcategories: ~16 rows (approximately)
/*!40000 ALTER TABLE `childcategories` DISABLE KEYS */;
INSERT INTO `childcategories` (`id`, `subcategory_id`, `name`, `slug`, `status`) VALUES
	(1, 2, 'LCD TV', 'lcd-tv', 1),
	(2, 2, 'LED TV', 'led-tv', 1),
	(3, 2, 'Curved TV', 'curved-tv', 1),
	(4, 2, 'Plasma TV', 'plasma-tv', 1),
	(5, 3, 'Top Freezer', 'top-freezer', 1),
	(6, 3, 'Side-by-Side', 'side-by-side', 1),
	(7, 3, 'Counter-Depth', 'counter-depth', 1),
	(8, 3, 'Mini Fridge', 'mini-fridge', 1),
	(9, 4, 'Front Loading', 'front-loading', 1),
	(10, 4, 'Top Loading', 'top-loading', 1),
	(11, 4, 'Washer Dryer Combo', 'washer-dryer-combo', 1),
	(12, 4, 'Laundry Center', 'laundry-center', 1),
	(13, 5, 'Central Air', 'central-air', 1),
	(14, 5, 'Window Air', 'window-air', 1),
	(15, 5, 'Portable Air', 'portable-air', 1),
	(16, 5, 'Hybrid Air', 'hybrid-air', 1);
/*!40000 ALTER TABLE `childcategories` ENABLE KEYS */;

-- Dumping structure for table gcart3.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) unsigned NOT NULL,
  `product_id` int(191) unsigned NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.comments: ~0 rows (approximately)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

-- Dumping structure for table gcart3.conversations
CREATE TABLE IF NOT EXISTS `conversations` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_user` int(191) NOT NULL,
  `recieved_user` int(191) NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.conversations: ~0 rows (approximately)
/*!40000 ALTER TABLE `conversations` DISABLE KEYS */;
/*!40000 ALTER TABLE `conversations` ENABLE KEYS */;

-- Dumping structure for table gcart3.counters
CREATE TABLE IF NOT EXISTS `counters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('referral','browser') NOT NULL DEFAULT 'referral',
  `referral` varchar(255) DEFAULT NULL,
  `total_count` int(11) NOT NULL DEFAULT '0',
  `todays_count` int(11) NOT NULL DEFAULT '0',
  `today` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.counters: ~18 rows (approximately)
/*!40000 ALTER TABLE `counters` DISABLE KEYS */;
INSERT INTO `counters` (`id`, `type`, `referral`, `total_count`, `todays_count`, `today`) VALUES
	(1, 'referral', 'www.facebook.com', 5, 0, NULL),
	(2, 'referral', 'geniusocean.com', 2, 0, NULL),
	(3, 'browser', 'Windows 10', 926, 0, NULL),
	(4, 'browser', 'Linux', 221, 0, NULL),
	(5, 'browser', 'Unknown OS Platform', 384, 0, NULL),
	(6, 'browser', 'Windows 7', 415, 0, NULL),
	(7, 'referral', 'yandex.ru', 15, 0, NULL),
	(8, 'browser', 'Windows 8.1', 536, 0, NULL),
	(9, 'referral', 'www.google.com', 6, 0, NULL),
	(10, 'browser', 'Android', 355, 0, NULL),
	(11, 'browser', 'Mac OS X', 502, 0, NULL),
	(12, 'referral', 'l.facebook.com', 1, 0, NULL),
	(13, 'referral', 'codecanyon.net', 6, 0, NULL),
	(14, 'browser', 'Windows XP', 2, 0, NULL),
	(15, 'browser', 'Windows 8', 1, 0, NULL),
	(16, 'browser', 'iPad', 4, 0, NULL),
	(17, 'browser', 'Ubuntu', 1, 0, NULL),
	(18, 'browser', 'iPhone', 4, 0, NULL);
/*!40000 ALTER TABLE `counters` ENABLE KEYS */;

-- Dumping structure for table gcart3.countries
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=247 DEFAULT CHARSET=utf8;

-- Dumping data for table gcart3.countries: 246 rows
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` (`id`, `country_code`, `country_name`) VALUES
	(1, 'AF', 'Afghanistan'),
	(2, 'AL', 'Albania'),
	(3, 'DZ', 'Algeria'),
	(4, 'DS', 'American Samoa'),
	(5, 'AD', 'Andorra'),
	(6, 'AO', 'Angola'),
	(7, 'AI', 'Anguilla'),
	(8, 'AQ', 'Antarctica'),
	(9, 'AG', 'Antigua and Barbuda'),
	(10, 'AR', 'Argentina'),
	(11, 'AM', 'Armenia'),
	(12, 'AW', 'Aruba'),
	(13, 'AU', 'Australia'),
	(14, 'AT', 'Austria'),
	(15, 'AZ', 'Azerbaijan'),
	(16, 'BS', 'Bahamas'),
	(17, 'BH', 'Bahrain'),
	(18, 'BD', 'Bangladesh'),
	(19, 'BB', 'Barbados'),
	(20, 'BY', 'Belarus'),
	(21, 'BE', 'Belgium'),
	(22, 'BZ', 'Belize'),
	(23, 'BJ', 'Benin'),
	(24, 'BM', 'Bermuda'),
	(25, 'BT', 'Bhutan'),
	(26, 'BO', 'Bolivia'),
	(27, 'BA', 'Bosnia and Herzegovina'),
	(28, 'BW', 'Botswana'),
	(29, 'BV', 'Bouvet Island'),
	(30, 'BR', 'Brazil'),
	(31, 'IO', 'British Indian Ocean Territory'),
	(32, 'BN', 'Brunei Darussalam'),
	(33, 'BG', 'Bulgaria'),
	(34, 'BF', 'Burkina Faso'),
	(35, 'BI', 'Burundi'),
	(36, 'KH', 'Cambodia'),
	(37, 'CM', 'Cameroon'),
	(38, 'CA', 'Canada'),
	(39, 'CV', 'Cape Verde'),
	(40, 'KY', 'Cayman Islands'),
	(41, 'CF', 'Central African Republic'),
	(42, 'TD', 'Chad'),
	(43, 'CL', 'Chile'),
	(44, 'CN', 'China'),
	(45, 'CX', 'Christmas Island'),
	(46, 'CC', 'Cocos (Keeling) Islands'),
	(47, 'CO', 'Colombia'),
	(48, 'KM', 'Comoros'),
	(49, 'CD', 'Democratic Republic of the Congo'),
	(50, 'CG', 'Republic of Congo'),
	(51, 'CK', 'Cook Islands'),
	(52, 'CR', 'Costa Rica'),
	(53, 'HR', 'Croatia (Hrvatska)'),
	(54, 'CU', 'Cuba'),
	(55, 'CY', 'Cyprus'),
	(56, 'CZ', 'Czech Republic'),
	(57, 'DK', 'Denmark'),
	(58, 'DJ', 'Djibouti'),
	(59, 'DM', 'Dominica'),
	(60, 'DO', 'Dominican Republic'),
	(61, 'TP', 'East Timor'),
	(62, 'EC', 'Ecuador'),
	(63, 'EG', 'Egypt'),
	(64, 'SV', 'El Salvador'),
	(65, 'GQ', 'Equatorial Guinea'),
	(66, 'ER', 'Eritrea'),
	(67, 'EE', 'Estonia'),
	(68, 'ET', 'Ethiopia'),
	(69, 'FK', 'Falkland Islands (Malvinas)'),
	(70, 'FO', 'Faroe Islands'),
	(71, 'FJ', 'Fiji'),
	(72, 'FI', 'Finland'),
	(73, 'FR', 'France'),
	(74, 'FX', 'France, Metropolitan'),
	(75, 'GF', 'French Guiana'),
	(76, 'PF', 'French Polynesia'),
	(77, 'TF', 'French Southern Territories'),
	(78, 'GA', 'Gabon'),
	(79, 'GM', 'Gambia'),
	(80, 'GE', 'Georgia'),
	(81, 'DE', 'Germany'),
	(82, 'GH', 'Ghana'),
	(83, 'GI', 'Gibraltar'),
	(84, 'GK', 'Guernsey'),
	(85, 'GR', 'Greece'),
	(86, 'GL', 'Greenland'),
	(87, 'GD', 'Grenada'),
	(88, 'GP', 'Guadeloupe'),
	(89, 'GU', 'Guam'),
	(90, 'GT', 'Guatemala'),
	(91, 'GN', 'Guinea'),
	(92, 'GW', 'Guinea-Bissau'),
	(93, 'GY', 'Guyana'),
	(94, 'HT', 'Haiti'),
	(95, 'HM', 'Heard and Mc Donald Islands'),
	(96, 'HN', 'Honduras'),
	(97, 'HK', 'Hong Kong'),
	(98, 'HU', 'Hungary'),
	(99, 'IS', 'Iceland'),
	(100, 'IN', 'India'),
	(101, 'IM', 'Isle of Man'),
	(102, 'ID', 'Indonesia'),
	(103, 'IR', 'Iran (Islamic Republic of)'),
	(104, 'IQ', 'Iraq'),
	(105, 'IE', 'Ireland'),
	(106, 'IL', 'Israel'),
	(107, 'IT', 'Italy'),
	(108, 'CI', 'Ivory Coast'),
	(109, 'JE', 'Jersey'),
	(110, 'JM', 'Jamaica'),
	(111, 'JP', 'Japan'),
	(112, 'JO', 'Jordan'),
	(113, 'KZ', 'Kazakhstan'),
	(114, 'KE', 'Kenya'),
	(115, 'KI', 'Kiribati'),
	(116, 'KP', 'Korea, Democratic People\'s Republic of'),
	(117, 'KR', 'Korea, Republic of'),
	(118, 'XK', 'Kosovo'),
	(119, 'KW', 'Kuwait'),
	(120, 'KG', 'Kyrgyzstan'),
	(121, 'LA', 'Lao People\'s Democratic Republic'),
	(122, 'LV', 'Latvia'),
	(123, 'LB', 'Lebanon'),
	(124, 'LS', 'Lesotho'),
	(125, 'LR', 'Liberia'),
	(126, 'LY', 'Libyan Arab Jamahiriya'),
	(127, 'LI', 'Liechtenstein'),
	(128, 'LT', 'Lithuania'),
	(129, 'LU', 'Luxembourg'),
	(130, 'MO', 'Macau'),
	(131, 'MK', 'North Macedonia'),
	(132, 'MG', 'Madagascar'),
	(133, 'MW', 'Malawi'),
	(134, 'MY', 'Malaysia'),
	(135, 'MV', 'Maldives'),
	(136, 'ML', 'Mali'),
	(137, 'MT', 'Malta'),
	(138, 'MH', 'Marshall Islands'),
	(139, 'MQ', 'Martinique'),
	(140, 'MR', 'Mauritania'),
	(141, 'MU', 'Mauritius'),
	(142, 'TY', 'Mayotte'),
	(143, 'MX', 'Mexico'),
	(144, 'FM', 'Micronesia, Federated States of'),
	(145, 'MD', 'Moldova, Republic of'),
	(146, 'MC', 'Monaco'),
	(147, 'MN', 'Mongolia'),
	(148, 'ME', 'Montenegro'),
	(149, 'MS', 'Montserrat'),
	(150, 'MA', 'Morocco'),
	(151, 'MZ', 'Mozambique'),
	(152, 'MM', 'Myanmar'),
	(153, 'NA', 'Namibia'),
	(154, 'NR', 'Nauru'),
	(155, 'NP', 'Nepal'),
	(156, 'NL', 'Netherlands'),
	(157, 'AN', 'Netherlands Antilles'),
	(158, 'NC', 'New Caledonia'),
	(159, 'NZ', 'New Zealand'),
	(160, 'NI', 'Nicaragua'),
	(161, 'NE', 'Niger'),
	(162, 'NG', 'Nigeria'),
	(163, 'NU', 'Niue'),
	(164, 'NF', 'Norfolk Island'),
	(165, 'MP', 'Northern Mariana Islands'),
	(166, 'NO', 'Norway'),
	(167, 'OM', 'Oman'),
	(168, 'PK', 'Pakistan'),
	(169, 'PW', 'Palau'),
	(170, 'PS', 'Palestine'),
	(171, 'PA', 'Panama'),
	(172, 'PG', 'Papua New Guinea'),
	(173, 'PY', 'Paraguay'),
	(174, 'PE', 'Peru'),
	(175, 'PH', 'Philippines'),
	(176, 'PN', 'Pitcairn'),
	(177, 'PL', 'Poland'),
	(178, 'PT', 'Portugal'),
	(179, 'PR', 'Puerto Rico'),
	(180, 'QA', 'Qatar'),
	(181, 'RE', 'Reunion'),
	(182, 'RO', 'Romania'),
	(183, 'RU', 'Russian Federation'),
	(184, 'RW', 'Rwanda'),
	(185, 'KN', 'Saint Kitts and Nevis'),
	(186, 'LC', 'Saint Lucia'),
	(187, 'VC', 'Saint Vincent and the Grenadines'),
	(188, 'WS', 'Samoa'),
	(189, 'SM', 'San Marino'),
	(190, 'ST', 'Sao Tome and Principe'),
	(191, 'SA', 'Saudi Arabia'),
	(192, 'SN', 'Senegal'),
	(193, 'RS', 'Serbia'),
	(194, 'SC', 'Seychelles'),
	(195, 'SL', 'Sierra Leone'),
	(196, 'SG', 'Singapore'),
	(197, 'SK', 'Slovakia'),
	(198, 'SI', 'Slovenia'),
	(199, 'SB', 'Solomon Islands'),
	(200, 'SO', 'Somalia'),
	(201, 'ZA', 'South Africa'),
	(202, 'GS', 'South Georgia South Sandwich Islands'),
	(203, 'SS', 'South Sudan'),
	(204, 'ES', 'Spain'),
	(205, 'LK', 'Sri Lanka'),
	(206, 'SH', 'St. Helena'),
	(207, 'PM', 'St. Pierre and Miquelon'),
	(208, 'SD', 'Sudan'),
	(209, 'SR', 'Suriname'),
	(210, 'SJ', 'Svalbard and Jan Mayen Islands'),
	(211, 'SZ', 'Swaziland'),
	(212, 'SE', 'Sweden'),
	(213, 'CH', 'Switzerland'),
	(214, 'SY', 'Syrian Arab Republic'),
	(215, 'TW', 'Taiwan'),
	(216, 'TJ', 'Tajikistan'),
	(217, 'TZ', 'Tanzania, United Republic of'),
	(218, 'TH', 'Thailand'),
	(219, 'TG', 'Togo'),
	(220, 'TK', 'Tokelau'),
	(221, 'TO', 'Tonga'),
	(222, 'TT', 'Trinidad and Tobago'),
	(223, 'TN', 'Tunisia'),
	(224, 'TR', 'Turkey'),
	(225, 'TM', 'Turkmenistan'),
	(226, 'TC', 'Turks and Caicos Islands'),
	(227, 'TV', 'Tuvalu'),
	(228, 'UG', 'Uganda'),
	(229, 'UA', 'Ukraine'),
	(230, 'AE', 'United Arab Emirates'),
	(231, 'GB', 'United Kingdom'),
	(232, 'US', 'United States'),
	(233, 'UM', 'United States minor outlying islands'),
	(234, 'UY', 'Uruguay'),
	(235, 'UZ', 'Uzbekistan'),
	(236, 'VU', 'Vanuatu'),
	(237, 'VA', 'Vatican City State'),
	(238, 'VE', 'Venezuela'),
	(239, 'VN', 'Vietnam'),
	(240, 'VG', 'Virgin Islands (British)'),
	(241, 'VI', 'Virgin Islands (U.S.)'),
	(242, 'WF', 'Wallis and Futuna Islands'),
	(243, 'EH', 'Western Sahara'),
	(244, 'YE', 'Yemen'),
	(245, 'ZM', 'Zambia'),
	(246, 'ZW', 'Zimbabwe');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;

-- Dumping structure for table gcart3.coupons
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL,
  `price` double NOT NULL,
  `times` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used` int(191) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.coupons: ~6 rows (approximately)
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` (`id`, `code`, `type`, `price`, `times`, `used`, `status`, `start_date`, `end_date`) VALUES
	(1, 'eqwe', 1, 12.22, '990', 18, 1, '2019-01-15', '2026-08-20'),
	(2, 'sdsdsasd', 0, 11, NULL, 2, 1, '2019-05-23', '2022-05-26'),
	(3, 'werwd', 0, 22, NULL, 3, 1, '2019-05-23', '2023-06-08'),
	(4, 'asdasd', 1, 23.5, NULL, 1, 1, '2019-05-23', '2020-05-28'),
	(5, 'kopakopakopa', 0, 40, NULL, 3, 1, '2019-05-23', '2032-05-20'),
	(6, 'rererere', 1, 9, '665', 1, 1, '2019-05-23', '2022-05-26');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;

-- Dumping structure for table gcart3.currencies
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.currencies: ~5 rows (approximately)
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` (`id`, `name`, `sign`, `value`, `is_default`) VALUES
	(1, 'USD', '$', 1, 1),
	(4, 'BDT', '৳', 84.63, 0),
	(6, 'EUR', '€', 0.89, 0),
	(8, 'INR', '₹', 68.95, 0),
	(9, 'NGN', '₦', 363.919, 0);
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;

-- Dumping structure for table gcart3.email_templates
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_subject` mediumtext COLLATE utf8_unicode_ci,
  `email_body` longtext COLLATE utf8_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table gcart3.email_templates: ~5 rows (approximately)
/*!40000 ALTER TABLE `email_templates` DISABLE KEYS */;
INSERT INTO `email_templates` (`id`, `email_type`, `email_subject`, `email_body`, `status`) VALUES
	(1, 'new_order', 'Your Order Placed Successfully', '<p>Hello {customer_name},<br>Your Order Number is {order_number}<br>Your order has been placed successfully</p>', 1),
	(2, 'new_registration', 'Welcome To Royal Commerce', '<p>Hello {customer_name},<br>You have successfully registered to {website_title}, We wish you will have a wonderful experience using our service.</p><p>Thank You<br></p>', 1),
	(3, 'vendor_accept', 'Your Vendor Account Activated', '<p>Hello {customer_name},<br>Your Vendor Account Activated Successfully. Please Login to your account and build your own shop.</p><p>Thank You<br></p>', 1),
	(4, 'subscription_warning', 'Your subscrption plan will end after five days', '<p>Hello {customer_name},<br>Your subscription plan duration will end after five days. Please renew your plan otherwise all of your products will be deactivated.</p><p>Thank You<br></p>', 1),
	(5, 'vendor_verification', 'Request for verification.', '<p>Hello {customer_name},<br>You are requested verify your account. Please send us photo of your passport.</p><p>Thank You<br></p>', 1);
/*!40000 ALTER TABLE `email_templates` ENABLE KEYS */;

-- Dumping structure for table gcart3.faqs
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gcart3.faqs: ~5 rows (approximately)
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` (`id`, `title`, `details`, `status`) VALUES
	(1, 'Right my front it wound cause fully', '<span style="color: rgb(70, 85, 65); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px;">Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.</span><br>', 1),
	(3, 'Man particular insensible celebrated', '<span style="color: rgb(70, 85, 65); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px;">Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.</span><br>', 1),
	(4, 'Civilly why how end viewing related', '<span style="color: rgb(70, 85, 65); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px;">Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.</span><br>', 0),
	(5, 'Six started far placing saw respect', '<span style="color: rgb(70, 85, 65); font-family: " open="" sans",="" sans-serif;="" font-size:="" 16px;"="">Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.</span><br>', 0),
	(6, 'She jointure goodness interest debat', '<div style="text-align: center;"><div style="text-align: center;"><br></div></div><div style="text-align: center;"><span style="color: rgb(70, 85, 65); font-family: " open="" sans",="" sans-serif;="" font-size:="" 16px;"="">Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.<br></span></div>', 0);
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;

-- Dumping structure for table gcart3.favorite_sellers
CREATE TABLE IF NOT EXISTS `favorite_sellers` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) NOT NULL,
  `vendor_id` int(191) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.favorite_sellers: ~1 rows (approximately)
/*!40000 ALTER TABLE `favorite_sellers` DISABLE KEYS */;
INSERT INTO `favorite_sellers` (`id`, `user_id`, `vendor_id`) VALUES
	(1, 22, 13);
/*!40000 ALTER TABLE `favorite_sellers` ENABLE KEYS */;

-- Dumping structure for table gcart3.galleries
CREATE TABLE IF NOT EXISTS `galleries` (
  `id` int(191) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(191) unsigned NOT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.galleries: ~135 rows (approximately)
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` (`id`, `product_id`, `photo`) VALUES
	(6, 93, '156801646314-min.jpg'),
	(7, 93, '156801646315-min.jpg'),
	(8, 93, '156801646316-min.jpg'),
	(22, 129, '15680254328Ei8T0MB.jpg'),
	(23, 129, '1568025432wRmpve8d.jpg'),
	(24, 129, '1568025432kkRYzLsF.jpg'),
	(25, 129, '1568025432zxQBe6Gk.jpg'),
	(26, 128, '1568025537sJbDPnFk.jpg'),
	(27, 128, '1568025537NBmHxJOz.jpg'),
	(28, 128, '1568025537hxqeFbS8.jpg'),
	(29, 128, '1568025538zK3tJpmL.jpg'),
	(34, 126, '1568025693kKLReNYO.jpg'),
	(35, 126, '1568025694Iv3pkz1q.jpg'),
	(36, 126, '1568025694T8HhdLVS.jpg'),
	(37, 126, '1568025695vTdg7ndt.jpg'),
	(38, 125, '15680257894Waz2tuN.jpg'),
	(39, 125, '1568025789vd0P4TBv.jpg'),
	(40, 125, '15680257899bih5sGh.jpg'),
	(41, 125, '156802578924sLIgzl.jpg'),
	(42, 124, '1568025825cC2Pmuit.jpg'),
	(43, 124, '1568025825EACzLFld.jpg'),
	(44, 124, '1568025825MfCyCqtD.jpg'),
	(45, 124, '15680258252yabMeAz.jpg'),
	(46, 123, '15680258512fKQla5g.jpg'),
	(47, 123, '1568025851pIjl0mWp.jpg'),
	(48, 123, '1568025851tQw7JXXG.jpg'),
	(49, 123, '1568025851ewjtSDkZ.jpg'),
	(50, 96, '1568025891wWAAbOjc.jpg'),
	(51, 96, '1568025891fyMNeXRy.jpg'),
	(52, 96, '1568025891OdV64Tw1.jpg'),
	(53, 96, '1568025891xQF7Zufe.jpg'),
	(62, 101, '1568026331Y6UMgMcI.jpg'),
	(63, 101, '1568026331xZbT4OWG.jpg'),
	(64, 101, '1568026331y7eIFJXZ.jpg'),
	(65, 101, '1568026331i2wH8RI0.jpg'),
	(66, 100, '1568026374xCTjQYZ8.jpg'),
	(67, 100, '1568026374DzmvqA9d.jpg'),
	(68, 100, '1568026374OEH73u5X.jpg'),
	(69, 100, '1568026374vZhqRv8c.jpg'),
	(70, 99, '15680264120LdBSU1v.jpg'),
	(71, 99, '1568026412eMjsI940.jpg'),
	(72, 99, '1568026412GFjvHiZv.jpg'),
	(73, 99, '15680264122fwGi20d.jpg'),
	(78, 97, '1568026469hSlmBpzE.jpg'),
	(79, 97, '15680264697AI8LicQ.jpg'),
	(80, 97, '15680264691xyFt5Y6.jpg'),
	(81, 97, '1568026469dC3hrMz0.jpg'),
	(86, 109, '1568026737EBGSE78G.jpg'),
	(87, 109, '1568026737B8hO1RRr.jpg'),
	(88, 109, '1568026737tf0rwVoz.jpg'),
	(89, 109, '1568026737GGIPSqYo.jpg'),
	(95, 107, '1568026797FFNrNPxK.jpg'),
	(96, 107, '1568026797UwY9ZLfQ.jpg'),
	(97, 107, '1568026797Kl6eZLx5.jpg'),
	(98, 107, '1568026797h3R48VaO.jpg'),
	(99, 107, '15680267989kXwH40I.jpg'),
	(100, 106, '1568026836ErM5FJxg.jpg'),
	(101, 106, '1568026836VLrxIk0u.jpg'),
	(102, 106, '1568026836lgLuMV6p.jpg'),
	(103, 106, '1568026836JBUTQX8v.jpg'),
	(104, 105, '1568026861YorsLvUa.jpg'),
	(105, 105, '1568026861PikoX1Qb.jpg'),
	(106, 105, '1568026861SBJqjw66.jpg'),
	(107, 105, '1568026861WYh54Arp.jpg'),
	(108, 104, '1568026885rmo0LDoo.jpg'),
	(109, 104, '15680268851m939o7O.jpg'),
	(110, 104, '1568026885fVXYCGKu.jpg'),
	(111, 104, '1568026885GDRL3thY.jpg'),
	(112, 103, '1568026903LbVQUxIr.jpg'),
	(113, 103, '1568026914IpRVYDV4.jpg'),
	(114, 103, '15680269141gKO8x5X.jpg'),
	(115, 103, '1568026914Q938xXM2.jpg'),
	(116, 93, '1568026950y7ihS4wE.jpg'),
	(125, 122, '1568027503rFK94cnU.jpg'),
	(126, 122, '1568027503i1X2FtIi.jpg'),
	(127, 122, '156802750316jxawoZ.jpg'),
	(128, 122, '1568027503QRBf290F.jpg'),
	(129, 121, '1568027539SQqUc8Bu.jpg'),
	(130, 121, '1568027539Zs5OTzjq.jpg'),
	(131, 121, '1568027539C45VRZq1.jpg'),
	(132, 121, '15680275398ovCzFnJ.jpg'),
	(133, 120, '1568027565bJgX744G.jpg'),
	(134, 120, '1568027565j0RPFUgX.jpg'),
	(135, 120, '1568027565QGi6Lhyo.jpg'),
	(136, 120, '15680275658MAY3VKp.jpg'),
	(137, 119, '1568027610p9R6ivC6.jpg'),
	(138, 119, '1568027610t2Aq7E5D.jpg'),
	(139, 119, '1568027611ikz4n0fx.jpg'),
	(140, 119, '15680276117BLgrCub.jpg'),
	(141, 118, '156802763634t0c8tG.jpg'),
	(142, 118, '1568027636fuJplSf3.jpg'),
	(143, 118, '1568027636MXcgCQHU.jpg'),
	(144, 118, '1568027636lfexGTpt.jpg'),
	(145, 117, '1568027665rFHWlsAJ.jpg'),
	(146, 117, '15680276655LPktA9k.jpg'),
	(147, 117, '1568027665vcNWWq3u.jpg'),
	(148, 117, '1568027665gQnqKhCw.jpg'),
	(149, 116, '1568027692FPQpwtWN.jpg'),
	(150, 116, '1568027692zBaGjOIC.jpg'),
	(151, 116, '1568027692UXpDx63F.jpg'),
	(152, 116, '1568027692KdIWbIGK.jpg'),
	(153, 95, '1568027743xS8gHocM.jpg'),
	(154, 95, '1568027743aVUOljdD.jpg'),
	(155, 95, '156802774327OOA1Zj.jpg'),
	(156, 95, '1568027743kGBx6mxa.jpg'),
	(172, 130, '1568029084hQT5ZO0j.jpg'),
	(173, 130, '1568029084ncGXxQzN.jpg'),
	(174, 130, '1568029084b0OonKFy.jpg'),
	(175, 130, '15680290857TD4iOWP.jpg'),
	(180, 114, '1568029158brS7xQCe.jpg'),
	(181, 114, '1568029158QlC0tg5a.jpg'),
	(182, 114, '1568029158RrN4AEtQ.jpg'),
	(187, 112, '1568029210JSAwjRPr.jpg'),
	(188, 112, '1568029210EiVUkcK6.jpg'),
	(189, 112, '1568029210fJSo5hya.jpg'),
	(190, 112, '15680292101vCcGfq8.jpg'),
	(191, 111, '1568029272lB0JETcn.jpg'),
	(192, 111, '1568029272wF3ldKgv.jpg'),
	(193, 111, '1568029272NI33ExCu.jpg'),
	(194, 111, '15680292724TXrpokz.jpg'),
	(197, 134, '15693932021.jpg'),
	(198, 134, '15693932022.jpg'),
	(199, 135, '15698200931.jpg'),
	(217, 159, '1570085246audi-automobile-car-909907.jpg'),
	(218, 159, '1570085246automobile-automotive-car-112460.jpg'),
	(219, 160, '1570085654asphalt-auto-automobile-575386.jpg'),
	(220, 160, '1570085654asphalt-auto-automobile-831475.jpg'),
	(221, 161, '1570086479audi-automobile-car-909907.jpg'),
	(222, 162, '1570255905asphalt-auto-automobile-831475.jpg'),
	(223, 162, '1570255905audi-automobile-car-909907.jpg'),
	(224, 167, '1570874976asphalt-auto-automobile-831475.jpg'),
	(225, 167, '1570874976audi-automobile-car-909907.jpg'),
	(226, 167, '1570874976automobile-automotive-car-112460.jpg'),
	(227, 168, '1570875445automobile-automotive-car-112460.jpg'),
	(228, 168, '1570875445automobile-automotive-car-358070.jpg');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;

-- Dumping structure for table gcart3.generalsettings
CREATE TABLE IF NOT EXISTS `generalsettings` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `header_email` text COLLATE utf8mb4_unicode_ci,
  `header_phone` text COLLATE utf8mb4_unicode_ci,
  `footer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `copyright` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `colors` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loader` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_loader` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_talkto` tinyint(1) NOT NULL DEFAULT '1',
  `talkto` text COLLATE utf8mb4_unicode_ci,
  `is_language` tinyint(1) NOT NULL DEFAULT '1',
  `is_loader` tinyint(1) NOT NULL DEFAULT '1',
  `map_key` text COLLATE utf8mb4_unicode_ci,
  `is_disqus` tinyint(1) NOT NULL DEFAULT '0',
  `disqus` longtext COLLATE utf8mb4_unicode_ci,
  `is_contact` tinyint(1) NOT NULL DEFAULT '0',
  `is_faq` tinyint(1) NOT NULL DEFAULT '0',
  `guest_checkout` tinyint(1) NOT NULL DEFAULT '0',
  `stripe_check` tinyint(1) NOT NULL DEFAULT '0',
  `cod_check` tinyint(1) NOT NULL DEFAULT '0',
  `stripe_key` text COLLATE utf8mb4_unicode_ci,
  `stripe_secret` text COLLATE utf8mb4_unicode_ci,
  `currency_format` tinyint(1) NOT NULL DEFAULT '0',
  `withdraw_fee` double NOT NULL DEFAULT '0',
  `withdraw_charge` double NOT NULL DEFAULT '0',
  `tax` double NOT NULL DEFAULT '0',
  `shipping_cost` double NOT NULL DEFAULT '0',
  `smtp_host` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_port` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_pass` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_smtp` tinyint(1) NOT NULL DEFAULT '0',
  `is_comment` tinyint(1) NOT NULL DEFAULT '1',
  `is_currency` tinyint(1) NOT NULL DEFAULT '1',
  `add_cart` text COLLATE utf8mb4_unicode_ci,
  `out_stock` text COLLATE utf8mb4_unicode_ci,
  `add_wish` text COLLATE utf8mb4_unicode_ci,
  `already_wish` text COLLATE utf8mb4_unicode_ci,
  `wish_remove` text COLLATE utf8mb4_unicode_ci,
  `add_compare` text COLLATE utf8mb4_unicode_ci,
  `already_compare` text COLLATE utf8mb4_unicode_ci,
  `compare_remove` text COLLATE utf8mb4_unicode_ci,
  `color_change` text COLLATE utf8mb4_unicode_ci,
  `coupon_found` text COLLATE utf8mb4_unicode_ci,
  `no_coupon` text COLLATE utf8mb4_unicode_ci,
  `already_coupon` text COLLATE utf8mb4_unicode_ci,
  `order_title` text COLLATE utf8mb4_unicode_ci,
  `order_text` text COLLATE utf8mb4_unicode_ci,
  `is_affilate` tinyint(1) NOT NULL DEFAULT '1',
  `affilate_charge` int(100) NOT NULL DEFAULT '0',
  `affilate_banner` text COLLATE utf8mb4_unicode_ci,
  `already_cart` text COLLATE utf8mb4_unicode_ci,
  `fixed_commission` double NOT NULL DEFAULT '0',
  `percentage_commission` double NOT NULL DEFAULT '0',
  `multiple_shipping` tinyint(1) NOT NULL DEFAULT '0',
  `multiple_packaging` tinyint(4) NOT NULL DEFAULT '0',
  `vendor_ship_info` tinyint(1) NOT NULL DEFAULT '0',
  `reg_vendor` tinyint(1) NOT NULL DEFAULT '0',
  `cod_text` text COLLATE utf8mb4_unicode_ci,
  `paypal_text` text COLLATE utf8mb4_unicode_ci,
  `stripe_text` text COLLATE utf8mb4_unicode_ci,
  `header_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copyright_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin_loader` tinyint(1) NOT NULL DEFAULT '0',
  `menu_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_hover_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_home` tinyint(1) NOT NULL DEFAULT '0',
  `is_verification_email` tinyint(1) NOT NULL DEFAULT '0',
  `instamojo_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instamojo_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instamojo_text` text COLLATE utf8mb4_unicode_ci,
  `is_instamojo` tinyint(1) NOT NULL DEFAULT '0',
  `instamojo_sandbox` tinyint(1) NOT NULL DEFAULT '0',
  `is_paystack` tinyint(1) NOT NULL DEFAULT '0',
  `paystack_key` text COLLATE utf8mb4_unicode_ci,
  `paystack_email` text COLLATE utf8mb4_unicode_ci,
  `paystack_text` text COLLATE utf8mb4_unicode_ci,
  `wholesell` int(191) NOT NULL DEFAULT '0',
  `is_capcha` tinyint(1) NOT NULL DEFAULT '0',
  `error_banner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_popup` tinyint(1) NOT NULL DEFAULT '0',
  `popup_title` text COLLATE utf8mb4_unicode_ci,
  `popup_text` text COLLATE utf8mb4_unicode_ci,
  `popup_background` text COLLATE utf8mb4_unicode_ci,
  `invoice_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_secure` tinyint(1) NOT NULL DEFAULT '0',
  `is_report` tinyint(1) NOT NULL,
  `paypal_check` tinyint(1) DEFAULT '0',
  `paypal_business` text COLLATE utf8mb4_unicode_ci,
  `footer_logo` text COLLATE utf8mb4_unicode_ci,
  `email_encryption` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paytm_merchant` text COLLATE utf8mb4_unicode_ci,
  `paytm_secret` text COLLATE utf8mb4_unicode_ci,
  `paytm_website` text COLLATE utf8mb4_unicode_ci,
  `paytm_industry` text COLLATE utf8mb4_unicode_ci,
  `is_paytm` int(11) NOT NULL DEFAULT '1',
  `paytm_text` text COLLATE utf8mb4_unicode_ci,
  `paytm_mode` enum('sandbox','live') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `is_molly` tinyint(1) NOT NULL DEFAULT '0',
  `molly_key` text COLLATE utf8mb4_unicode_ci,
  `molly_text` text COLLATE utf8mb4_unicode_ci,
  `is_razorpay` int(11) NOT NULL DEFAULT '1',
  `razorpay_key` text COLLATE utf8mb4_unicode_ci,
  `razorpay_secret` text COLLATE utf8mb4_unicode_ci,
  `razorpay_text` text COLLATE utf8mb4_unicode_ci,
  `show_stock` tinyint(1) NOT NULL DEFAULT '0',
  `is_maintain` tinyint(1) NOT NULL DEFAULT '0',
  `maintain_text` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gcart3.generalsettings: 1 rows
/*!40000 ALTER TABLE `generalsettings` DISABLE KEYS */;
INSERT INTO `generalsettings` (`id`, `logo`, `favicon`, `title`, `header_email`, `header_phone`, `footer`, `copyright`, `colors`, `loader`, `admin_loader`, `is_talkto`, `talkto`, `is_language`, `is_loader`, `map_key`, `is_disqus`, `disqus`, `is_contact`, `is_faq`, `guest_checkout`, `stripe_check`, `cod_check`, `stripe_key`, `stripe_secret`, `currency_format`, `withdraw_fee`, `withdraw_charge`, `tax`, `shipping_cost`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `from_email`, `from_name`, `is_smtp`, `is_comment`, `is_currency`, `add_cart`, `out_stock`, `add_wish`, `already_wish`, `wish_remove`, `add_compare`, `already_compare`, `compare_remove`, `color_change`, `coupon_found`, `no_coupon`, `already_coupon`, `order_title`, `order_text`, `is_affilate`, `affilate_charge`, `affilate_banner`, `already_cart`, `fixed_commission`, `percentage_commission`, `multiple_shipping`, `multiple_packaging`, `vendor_ship_info`, `reg_vendor`, `cod_text`, `paypal_text`, `stripe_text`, `header_color`, `footer_color`, `copyright_color`, `is_admin_loader`, `menu_color`, `menu_hover_color`, `is_home`, `is_verification_email`, `instamojo_key`, `instamojo_token`, `instamojo_text`, `is_instamojo`, `instamojo_sandbox`, `is_paystack`, `paystack_key`, `paystack_email`, `paystack_text`, `wholesell`, `is_capcha`, `error_banner`, `is_popup`, `popup_title`, `popup_text`, `popup_background`, `invoice_logo`, `user_image`, `vendor_color`, `is_secure`, `is_report`, `paypal_check`, `paypal_business`, `footer_logo`, `email_encryption`, `paytm_merchant`, `paytm_secret`, `paytm_website`, `paytm_industry`, `is_paytm`, `paytm_text`, `paytm_mode`, `is_molly`, `molly_key`, `molly_text`, `is_razorpay`, `razorpay_key`, `razorpay_secret`, `razorpay_text`, `show_stock`, `is_maintain`, `maintain_text`) VALUES
	(1, '1571567292logo.png', '1571567283favicon.png', 'Genius Cart', 'smtp', '0123 456789', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae', 'COPYRIGHT © 2019. All Rights Reserved By <a href="http://geniusocean.com/">GeniusOcean.com</a>', '#0f78f2', '1564224328loading3.gif', '1564224329loading3.gif', 0, '<script type="text/javascript">\r\nvar Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n(function(){\r\nvar s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];\r\ns1.async=true;\r\ns1.src=\'https://embed.tawk.to/5bc2019c61d0b77092512d03/default\';\r\ns1.charset=\'UTF-8\';\r\ns1.setAttribute(\'crossorigin\',\'*\');\r\ns0.parentNode.insertBefore(s1,s0);\r\n})();\r\n</script>', 1, 1, 'AIzaSyB1GpE4qeoJ__70UZxvX9CTMUTZRZNHcu8', 0, '<div id="disqus_thread">         \r\n    <script>\r\n    /**\r\n    *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.\r\n    *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/\r\n    /*\r\n    var disqus_config = function () {\r\n    this.page.url = PAGE_URL;  // Replace PAGE_URL with your page\'s canonical URL variable\r\n    this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page\'s unique identifier variable\r\n    };\r\n    */\r\n    (function() { // DON\'T EDIT BELOW THIS LINE\r\n    var d = document, s = d.createElement(\'script\');\r\n    s.src = \'https://junnun.disqus.com/embed.js\';\r\n    s.setAttribute(\'data-timestamp\', +new Date());\r\n    (d.head || d.body).appendChild(s);\r\n    })();\r\n    </script>\r\n    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>\r\n    </div>', 1, 1, 1, 1, 1, 'pk_test_UnU1Coi1p5qFGwtpjZMRMgJM', 'sk_test_QQcg3vGsKRPlW6T3dXcNJsor', 0, 0, 0, 0, 5, NULL, NULL, NULL, NULL, 'geniustest11@gmail.com', 'GeniusTest', 1, 1, 1, 'Successfully Added To Cart', 'Out Of Stock', 'Add To Wishlist', 'Already Added To Wishlist', 'Successfully Removed From The Wishlist', 'Successfully Added To Compare', 'Already Added To Compare', 'Successfully Removed From The Compare', 'Successfully Changed The Color', 'Coupon Found', 'No Coupon Found', 'Coupon Already Applied', 'THANK YOU FOR YOUR PURCHASE.', 'We\'ll email you an order confirmation with details and tracking info.', 1, 8, '15587771131554048228onepiece.jpeg', 'Already Added To Cart', 0, 0, 1, 1, 1, 1, 'Pay with cash upon delivery.', 'Pay via your PayPal account.', 'Pay via your Credit Card.', '#ffffff', '#143250', '#02020c', 1, '#ff5500', '#02020c', 0, 0, 'test_172371aa837ae5cad6047dc3052', 'test_4ac5a785e25fc596b67dbc5c267', 'Pay via your Instamojo account.', 1, 1, 1, 'pk_test_162a56d42131cbb01932ed0d2c48f9cb99d8e8e2', 'junnuns@gmail.com', 'Pay via your Paystack account.', 6, 1, '1566878455404.png', 1, 'NEWSLETTER', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita porro ipsa nulla, alias, ab minus.', '1584934329adv-banner.jpg', '1571567295logo.png', '1567655174profile.jpg', '#666666', 1, 1, 1, 'shaon143-facilitator-1@gmail.com', '1571567309footers.png', NULL, 'tkogux49985047638244', 'LhNGUUKE9xCQ9xY8', 'WEBSTAGING', 'Retail', 1, 'Pay via your Paytm account.', 'sandbox', 1, 'test_5HcWVs9qc5pzy36H9Tu9mwAyats33J', 'Pay with Molly Payment.', 1, 'rzp_test_xDH74d48cwl8DF', 'cr0H1BiQ20hVzhpHfHuNbGri', 'Pay via your Razorpay account.', 0, 0, '<div style="text-align: center;"><font size="5"><br></font></div><h1 style="text-align: center;"><font size="6">UNDER MAINTENANCE</font></h1>');
/*!40000 ALTER TABLE `generalsettings` ENABLE KEYS */;

-- Dumping structure for table gcart3.languages
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.languages: ~2 rows (approximately)
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` (`id`, `is_default`, `language`, `file`) VALUES
	(1, 1, 'English', '1579926860LzpDa1Y7.json'),
	(2, 0, 'RTL English', '1579927527QjLMUGyj.json');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;

-- Dumping structure for table gcart3.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `conversation_id` int(191) NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_user` int(191) DEFAULT NULL,
  `recieved_user` int(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.messages: ~0 rows (approximately)
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

-- Dumping structure for table gcart3.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `order_id` int(191) unsigned DEFAULT NULL,
  `user_id` int(191) DEFAULT NULL,
  `vendor_id` int(191) DEFAULT NULL,
  `product_id` int(191) DEFAULT NULL,
  `conversation_id` int(191) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.notifications: ~1 rows (approximately)
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` (`id`, `order_id`, `user_id`, `vendor_id`, `product_id`, `conversation_id`, `is_read`, `created_at`, `updated_at`) VALUES
	(33, 69, NULL, NULL, NULL, NULL, 1, '2021-10-10 07:54:18', '2022-03-26 05:44:44');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;

-- Dumping structure for table gcart3.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) DEFAULT NULL,
  `cart` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totalQty` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_amount` float NOT NULL,
  `txnid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `customer_country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `customer_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_zip` varchar(255) DEFAULT NULL,
  `shipping_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_zip` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `coupon_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_discount` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','processing','completed','declined','on delivery') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `affilate_user` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affilate_charge` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_sign` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_value` double NOT NULL,
  `shipping_cost` double NOT NULL,
  `packing_cost` double NOT NULL DEFAULT '0',
  `tax` double NOT NULL DEFAULT '0',
  `dp` tinyint(1) NOT NULL DEFAULT '0',
  `pay_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `vendor_shipping_id` int(191) NOT NULL DEFAULT '0',
  `vendor_packing_id` int(191) NOT NULL DEFAULT '0',
  `whole_discount` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.orders: ~0 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table gcart3.order_tracks
CREATE TABLE IF NOT EXISTS `order_tracks` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `order_id` int(191) NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.order_tracks: ~0 rows (approximately)
/*!40000 ALTER TABLE `order_tracks` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_tracks` ENABLE KEYS */;

-- Dumping structure for table gcart3.packages
CREATE TABLE IF NOT EXISTS `packages` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) NOT NULL DEFAULT '0',
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `subtitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.packages: ~2 rows (approximately)
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` (`id`, `user_id`, `title`, `subtitle`, `price`) VALUES
	(1, 0, 'Default Packaging', 'Default packaging by store', 0),
	(2, 0, 'Gift Packaging', 'Exclusive Gift packaging', 15);
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;

-- Dumping structure for table gcart3.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_tag` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `header` tinyint(1) NOT NULL DEFAULT '0',
  `footer` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.pages: ~3 rows (approximately)
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `title`, `slug`, `details`, `meta_tag`, `meta_description`, `header`, `footer`) VALUES
	(1, 'About Us', 'about', '<div helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><h2><font size="6">Title number 1</font><br></h2><p><span style="font-weight: 700;">Lorem Ipsum</span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><h2><font size="6">Title number 2</font><br></h2><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p></div><br helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><div helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><h2><font size="6">Title number 3</font><br></h2><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p></div><h2 helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-weight:="" 700;="" line-height:="" 1.1;="" color:="" rgb(51,="" 51,="" 51);="" margin:="" 0px="" 15px;="" font-size:="" 30px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"="" style="font-family: " 51);"=""><font size="6">Title number 9</font><br></h2><p helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"="">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', NULL, NULL, 1, 0),
	(2, 'Privacy & Policy', 'privacy', '<div helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><h2><img src="https://i.imgur.com/BobQuyA.jpg" width="591"></h2><h2><font size="6">Title number 1</font></h2><p><span style="font-weight: 700;">Lorem Ipsum</span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><h2><font size="6">Title number 2</font><br></h2><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p></div><br helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><div helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><h2><font size="6">Title number 3</font><br></h2><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p></div><h2 helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-weight:="" 700;="" line-height:="" 1.1;="" color:="" rgb(51,="" 51,="" 51);="" margin:="" 0px="" 15px;="" font-size:="" 30px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"="" 51);"="" style="font-family: "><font size="6">Title number 9</font><br></h2><p helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"="">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 'test,test1,test2,test3', 'Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 0, 1),
	(3, 'Terms & Condition', 'terms', '<div helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><h2><font size="6">Title number 1</font><br></h2><p><span style="font-weight: 700;">Lorem Ipsum</span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><h2><font size="6">Title number 2</font><br></h2><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p></div><br helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><div helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"=""><h2><font size="6">Title number 3</font><br></h2><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p></div><h2 helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-weight:="" 700;="" line-height:="" 1.1;="" color:="" rgb(51,="" 51,="" 51);="" margin:="" 0px="" 15px;="" font-size:="" 30px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"="" 51);"="" style="font-family: "><font size="6">Title number 9</font><br></h2><p helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 14px;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" background-color:="" rgb(255,="" 255,="" 255);="" text-decoration-style:="" initial;="" text-decoration-color:="" initial;"="">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 't1,t2,t3,t4', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 0, 1);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;

-- Dumping structure for table gcart3.pagesettings
CREATE TABLE IF NOT EXISTS `pagesettings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contact_success` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_title` text COLLATE utf8mb4_unicode_ci,
  `contact_text` text COLLATE utf8mb4_unicode_ci,
  `side_title` text COLLATE utf8mb4_unicode_ci,
  `side_text` text COLLATE utf8mb4_unicode_ci,
  `street` text COLLATE utf8mb4_unicode_ci,
  `phone` text COLLATE utf8mb4_unicode_ci,
  `fax` text COLLATE utf8mb4_unicode_ci,
  `email` text COLLATE utf8mb4_unicode_ci,
  `site` text COLLATE utf8mb4_unicode_ci,
  `slider` tinyint(1) NOT NULL DEFAULT '1',
  `service` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '1',
  `small_banner` tinyint(1) NOT NULL DEFAULT '1',
  `best` tinyint(1) NOT NULL DEFAULT '1',
  `top_rated` tinyint(1) NOT NULL DEFAULT '1',
  `large_banner` tinyint(1) NOT NULL DEFAULT '1',
  `big` tinyint(1) NOT NULL DEFAULT '1',
  `hot_sale` tinyint(1) NOT NULL DEFAULT '1',
  `partners` tinyint(1) NOT NULL DEFAULT '0',
  `review_blog` tinyint(1) NOT NULL DEFAULT '1',
  `best_seller_banner` text COLLATE utf8mb4_unicode_ci,
  `best_seller_banner_link` text COLLATE utf8mb4_unicode_ci,
  `big_save_banner` text COLLATE utf8mb4_unicode_ci,
  `big_save_banner_link` text COLLATE utf8mb4_unicode_ci,
  `bottom_small` tinyint(1) NOT NULL DEFAULT '0',
  `flash_deal` tinyint(1) NOT NULL DEFAULT '0',
  `best_seller_banner1` text COLLATE utf8mb4_unicode_ci,
  `best_seller_banner_link1` text COLLATE utf8mb4_unicode_ci,
  `big_save_banner1` text COLLATE utf8mb4_unicode_ci,
  `big_save_banner_link1` text COLLATE utf8mb4_unicode_ci,
  `featured_category` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gcart3.pagesettings: ~1 rows (approximately)
/*!40000 ALTER TABLE `pagesettings` DISABLE KEYS */;
INSERT INTO `pagesettings` (`id`, `contact_success`, `contact_email`, `contact_title`, `contact_text`, `side_title`, `side_text`, `street`, `phone`, `fax`, `email`, `site`, `slider`, `service`, `featured`, `small_banner`, `best`, `top_rated`, `large_banner`, `big`, `hot_sale`, `partners`, `review_blog`, `best_seller_banner`, `best_seller_banner_link`, `big_save_banner`, `big_save_banner_link`, `bottom_small`, `flash_deal`, `best_seller_banner1`, `best_seller_banner_link1`, `big_save_banner1`, `big_save_banner_link1`, `featured_category`) VALUES
	(1, 'Success! Thanks for contacting us, we will get back to you shortly.', 'admin@geniusocean.com', '<h4 class="subtitle" style="margin-bottom: 6px; font-weight: 600; line-height: 28px; font-size: 28px; text-transform: uppercase;">WE\'D LOVE TO</h4><h2 class="title" style="margin-bottom: 13px;font-weight: 600;line-height: 50px;font-size: 40px;color: #0f78f2;text-transform: uppercase;">HEAR FROM YOU</h2>', '<span style="color: rgb(119, 119, 119);">Send us a message and we\' ll respond as soon as possible</span><br>', '<h4 class="title" style="margin-bottom: 10px; font-weight: 600; line-height: 28px; font-size: 28px;">Let\'s Connect</h4>', '<span style="color: rgb(51, 51, 51);">Get in touch with us</span>', '3584 Hickory Heights Drive ,Hanover MD 21076, USA', '00 000 000 000', '00 000 000 000', 'admin@geniusocean.com', 'https://geniusocean.com/', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '1568889138banner1.jpg', 'http://google.com', '1565150264banner3.jpg', 'http://google.com', 1, 1, '1568889138banner2.jpg', 'http://google.com', '1565150264banner4.jpg', 'http://google.com', 1);
/*!40000 ALTER TABLE `pagesettings` ENABLE KEYS */;

-- Dumping structure for table gcart3.partners
CREATE TABLE IF NOT EXISTS `partners` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.partners: ~6 rows (approximately)
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` (`id`, `photo`, `link`) VALUES
	(1, '1563165366brand-1.png', 'https://www.google.com/'),
	(2, '1563165383brand-2.png', 'https://www.google.com/'),
	(3, '1563165393brand-3.png', 'https://www.google.com/'),
	(4, '1563165400brand-1.png', NULL),
	(5, '1563165411brand-2.png', NULL),
	(6, '1563165444brand-3.png', NULL);
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;

-- Dumping structure for table gcart3.payment_gateways
CREATE TABLE IF NOT EXISTS `payment_gateways` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `subtitle` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.payment_gateways: ~1 rows (approximately)
/*!40000 ALTER TABLE `payment_gateways` DISABLE KEYS */;
INSERT INTO `payment_gateways` (`id`, `subtitle`, `title`, `details`, `status`) VALUES
	(46, 'Pay via your Mobile Money.', 'Mobile Money', '<font size="3"><b style="">Mobile Money</b><b>&nbsp;No: 6528068515</b><br><br></font>', 1);
/*!40000 ALTER TABLE `payment_gateways` ENABLE KEYS */;

-- Dumping structure for table gcart3.pickups
CREATE TABLE IF NOT EXISTS `pickups` (
  `id` int(191) unsigned NOT NULL AUTO_INCREMENT,
  `location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.pickups: ~5 rows (approximately)
/*!40000 ALTER TABLE `pickups` DISABLE KEYS */;
INSERT INTO `pickups` (`id`, `location`) VALUES
	(2, 'Azampur'),
	(3, 'Dhaka'),
	(4, 'Kazipara'),
	(5, 'Kamarpara'),
	(6, 'Uttara');
/*!40000 ALTER TABLE `pickups` ENABLE KEYS */;

-- Dumping structure for table gcart3.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(191) unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(255) DEFAULT NULL,
  `product_type` enum('normal','affiliate') NOT NULL DEFAULT 'normal',
  `affiliate_link` text,
  `user_id` int(191) NOT NULL DEFAULT '0',
  `category_id` int(191) unsigned NOT NULL,
  `subcategory_id` int(191) unsigned DEFAULT NULL,
  `childcategory_id` int(191) unsigned DEFAULT NULL,
  `attributes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size_qty` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size_price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` double NOT NULL,
  `previous_price` double DEFAULT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `stock` int(191) DEFAULT NULL,
  `policy` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `views` int(191) unsigned NOT NULL DEFAULT '0',
  `tags` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` text,
  `colors` text,
  `product_condition` tinyint(1) NOT NULL DEFAULT '0',
  `ship` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_meta` tinyint(1) NOT NULL DEFAULT '0',
  `meta_tag` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `youtube` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Physical','Digital','License') NOT NULL,
  `license` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `license_qty` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `platform` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `licence_type` varchar(255) DEFAULT NULL,
  `measure` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `best` tinyint(10) unsigned NOT NULL DEFAULT '0',
  `top` tinyint(10) unsigned NOT NULL DEFAULT '0',
  `hot` tinyint(10) unsigned NOT NULL DEFAULT '0',
  `latest` tinyint(10) unsigned NOT NULL DEFAULT '0',
  `big` tinyint(10) unsigned NOT NULL DEFAULT '0',
  `trending` tinyint(1) NOT NULL DEFAULT '0',
  `sale` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_discount` tinyint(1) NOT NULL DEFAULT '0',
  `discount_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `whole_sell_qty` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `whole_sell_discount` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_catalog` tinyint(1) NOT NULL DEFAULT '0',
  `catalog_id` int(191) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `attributes` (`attributes`)
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.products: ~52 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `sku`, `product_type`, `affiliate_link`, `user_id`, `category_id`, `subcategory_id`, `childcategory_id`, `attributes`, `name`, `slug`, `photo`, `thumbnail`, `file`, `size`, `size_qty`, `size_price`, `color`, `price`, `previous_price`, `details`, `stock`, `policy`, `status`, `views`, `tags`, `features`, `colors`, `product_condition`, `ship`, `is_meta`, `meta_tag`, `meta_description`, `youtube`, `type`, `license`, `license_qty`, `link`, `platform`, `region`, `licence_type`, `measure`, `featured`, `best`, `top`, `hot`, `latest`, `big`, `trending`, `sale`, `created_at`, `updated_at`, `is_discount`, `discount_date`, `whole_sell_qty`, `whole_sell_discount`, `is_catalog`, `catalog_id`) VALUES
	(93, NULL, 'normal', NULL, 0, 11, NULL, NULL, NULL, 'Digital Product Title will Be Here by Name 1', 'digital-product-title-will-be-here-by-name-1-94l93dsn', '15680269303GYKjODW.png', '1568026930poclhyxJ.jpg', '1568016463minimal (16).zip', NULL, NULL, NULL, NULL, 50, 75, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 39, 'book,ebook', NULL, NULL, 0, NULL, 0, 'book,ebook', 'These are ebook from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Digital', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, '2019-09-09 10:07:43', '2019-11-14 05:31:36', 0, NULL, NULL, NULL, 0, 0),
	(95, 'pr495jsv', 'affiliate', 'https://www.amazon.com/Rolex-Master-Automatic-self-Wind-Certified-Pre-Owned/dp/B07MHJ8SVQ/ref=lp_13779934011_1_2?s=apparel&ie=UTF8&qid=1565186470&sr=1-2&nodeID=13779934011&psd=1', 13, 4, NULL, NULL, NULL, 'Affiliate Product Title will Be Here. Affiliate Product Title will Be Here 95', 'affiliate-product-title-will-be-here-affiliate-product-title-will-be-here-1-pr495jsv', '1568027732dTwHda8l.png', '1568027751AidGUyJv.jpg', NULL, NULL, NULL, NULL, '#000000,#a33333,#d90b0b,#209125', 50, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 55555, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 47, 'watch', NULL, NULL, 2, '5-7 days', 0, NULL, NULL, NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 1, '2019-09-09 10:36:06', '2019-11-14 00:30:42', 1, '09/08/2021', NULL, NULL, 0, 0),
	(96, 'pr601jsv', 'normal', NULL, 13, 5, 6, NULL, NULL, 'Top Rated product title will be here according to your wish 96', 'top-rated-product-title-will-be-here-according-to-your-wish-96-rdk96x5b', '1568025872cCRVsp2k.png', '1568025872thPsuRSJ.jpg', NULL, NULL, NULL, NULL, '#000000,#15a0bf,#f5cf07,#2b4cc2,#247d32,#d62727', 100, 500, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 13, 'fashion', NULL, NULL, 2, '5-7 days', 0, 'fashion', 'Fashion meta tag from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 1, 0, 0, 1, '2019-09-09 11:00:05', '2019-11-14 05:09:06', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 0),
	(97, 'pr602jsv', 'normal', NULL, 13, 5, 7, NULL, NULL, 'Physical Product Title Title will Be Here 97', 'physical-product-title-title-will-be-here-97-pr602jsv', '1568026462TxRJ07FG.png', '1568026462WBWcd7KZ.jpg', NULL, 'S,M,L', '2147483595,2147483597,2147483597', '20,30,40', '#000000,#851818,#ff0d0d,#1feb4c,#d620cf,#186ceb', 100, 200, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 68, 'clothing,bag', NULL, NULL, 2, '5-7 days', 0, 'clothing,bag', 'clothing, bag', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '2019-09-09 14:59:33', '2020-10-03 04:49:40', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 0),
	(99, 'pr604jsv', 'normal', NULL, 13, 5, 7, NULL, NULL, 'Physical Product Title Title will Be Here 99', 'physical-product-title-title-will-be-here-99-hjm99shr', '15680264040zpMCpmS.png', '1568026404Hm4kTmnP.jpg', NULL, 'S', '2147483633', '20', '#000000,#851818,#ff0d0d,#1feb4c,#d620cf,#186ceb', 100, 200, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 18, 'clothing,bag', NULL, NULL, 2, '5-7 days', 0, 'clothing,bag', 'clothing, bag', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '2019-09-09 14:59:33', '2020-10-11 03:24:04', 0, NULL, '10,20,30,40', '5,10,15,20', 1, 0),
	(100, 'pr605jsv', 'normal', NULL, 13, 5, 7, NULL, NULL, 'Physical Product Title Title will Be Here 100', 'physical-product-title-title-will-be-here-100-qqz100nzi', '1568026368qU5AILZo.png', '1568026368CzWwfWLG.jpg', NULL, 'S', '55555555555555537', '20', '#000000,#851818,#ff0d0d,#1feb4c,#d620cf,#186ceb', 100, 200, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 9, 'clothing,bag', NULL, NULL, 2, '5-7 days', 0, 'clothing,bag', 'clothing, bag', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, 0, 1, 1, '2019-09-09 14:59:33', '2021-10-10 07:54:18', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 0),
	(101, 'pr606jsv', 'normal', NULL, 13, 5, 7, NULL, NULL, 'Physical Product Title Title will Be Here 101', 'physical-product-title-title-will-be-here-101-8e1101lbq', '1568026326RDSwScJe.png', '1568026326vMlslLz4.jpg', NULL, 'S', '2147483641', '20', '#000000,#851818,#ff0d0d,#1feb4c,#d620cf,#186ceb', 100, 200, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 7, 'clothing,bag', NULL, NULL, 2, '5-7 days', 0, 'clothing,bag', 'clothing, bag', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 0, '2019-09-09 14:59:33', '2022-03-26 03:59:39', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 0),
	(103, NULL, 'normal', NULL, 13, 11, NULL, NULL, NULL, 'Digital Product Title will Be Here by Name 1', 'digital-product-title-will-be-here-by-name-1-laj1033wf', '1568026899SLhVRzQv.png', '15680268999fypNo3k.jpg', '1568016463minimal (16).zip', NULL, NULL, NULL, NULL, 50, 75, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 4, 'book,ebook', NULL, NULL, 0, NULL, 0, 'book,ebook', 'These are ebook from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Digital', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, '2019-09-09 15:07:43', '2019-10-03 04:16:24', 0, NULL, NULL, NULL, 0, 0),
	(104, NULL, 'normal', NULL, 13, 11, NULL, NULL, NULL, 'Digital Product Title will Be Here by Name 104', 'digital-product-title-will-be-here-by-name-104-ffv1047iv', '1568026881R8KnUyJv.png', '1568026881yy7vilmh.jpg', '1568016463minimal (16).zip', NULL, NULL, NULL, NULL, 50, 75, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 6, 'book,ebook', NULL, NULL, 0, NULL, 0, 'book,ebook', 'These are ebook from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Digital', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, '2019-09-09 15:07:43', '2019-09-10 11:21:46', 0, NULL, NULL, NULL, 0, 0),
	(105, NULL, 'normal', NULL, 13, 11, NULL, NULL, NULL, 'Digital Product Title will Be Here by Name 105', 'digital-product-title-will-be-here-by-name-105-xpt105lfz', '1568026853LMtcb9he.png', '1568026853ZnMf5AkF.jpg', '1568016463minimal (16).zip', NULL, NULL, NULL, NULL, 50, 75, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 3, 'book,ebook', NULL, NULL, 0, NULL, 0, 'book,ebook', 'These are ebook from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Digital', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, '2019-09-09 15:07:43', '2019-10-08 01:40:15', 0, NULL, NULL, NULL, 0, 0),
	(106, NULL, 'normal', NULL, 13, 11, NULL, NULL, NULL, 'Digital Product Title will Be Here by Name 106', 'digital-product-title-will-be-here-by-name-106-iq4106dr3', '1568026820NnXjzL5e.png', '1568026820j7QX4FZs.jpg', '1568016463minimal (16).zip', NULL, NULL, NULL, NULL, 50, 75, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 3, 'book,ebook', NULL, NULL, 0, NULL, 0, 'book,ebook', 'These are ebook from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Digital', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, '2019-09-09 15:07:43', '2019-10-08 01:40:14', 0, NULL, NULL, NULL, 0, 0),
	(107, NULL, 'normal', NULL, 13, 11, NULL, NULL, NULL, 'Digital Product Title will Be Here by Name 107', 'digital-product-title-will-be-here-by-name-107-4ll107cru', '1568026791NGCCXoMs.png', '1568026791O2FR26Va.jpg', '1568016463minimal (16).zip', NULL, NULL, NULL, NULL, 50, 75, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 4, 'book,ebook', NULL, NULL, 0, NULL, 0, 'book,ebook', 'These are ebook from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Digital', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, '2019-09-09 15:07:43', '2019-10-13 01:27:40', 0, NULL, NULL, NULL, 0, 0),
	(109, NULL, 'normal', NULL, 13, 11, NULL, NULL, NULL, 'Digital Product Title will Be Here by Name 109', 'digital-product-title-will-be-here-by-name-109-ext109m9m', '15680267308Mckygzw.png', '1568026730uz1TS02K.jpg', '1568016463minimal (16).zip', NULL, NULL, NULL, NULL, 50, 75, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 1, 'book,ebook', NULL, NULL, 0, NULL, 0, 'book,ebook', 'These are ebook from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Digital', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, 0, '2019-09-09 15:07:43', '2019-09-09 18:33:10', 0, NULL, NULL, NULL, 0, 0),
	(111, NULL, 'normal', NULL, 13, 8, NULL, NULL, NULL, 'License key title will be here according to your wish 111', 'license-key-title-will-be-here-according-to-your-wish-111-wb3111ubd', '1568029267UZnlkD97.png', '1568029267AY9MRYAQ.jpg', '156801752005.zip', NULL, NULL, NULL, NULL, 80, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 3, 'game', NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=HxNydN5tScI', 'License', '888888888888888888888888', '9999999999999999999999999', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 1, 1, 1, '2019-09-09 15:25:20', '2019-09-19 05:39:08', 0, NULL, NULL, NULL, 0, 0),
	(112, NULL, 'normal', NULL, 13, 8, NULL, NULL, NULL, 'License key title will be here according to your wish 1', 'license-key-title-will-be-here-according-to-your-wish-1-sct112k8z', '1568029203HHnZu8em.png', '1568029203eAzBjS8a.jpg', '156801752005.zip', NULL, NULL, NULL, NULL, 80, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 4, 'game', 'Keyword 2,Keyword1', '#e80707,#113fe0', 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=HxNydN5tScI', 'License', '888888888888888888888888', '9999999999999999999999999', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1, 1, 1, '2019-09-09 15:25:20', '2022-03-26 03:32:35', 0, NULL, NULL, NULL, 0, 0),
	(114, NULL, 'normal', NULL, 13, 8, NULL, NULL, NULL, 'License key title will be here according to your wish 1', 'license-key-title-will-be-here-according-to-your-wish-1-bbb114jm9', '1568029152hgFzyOZv.png', '1568029152PVeSE2Ct.jpg', '156801752005.zip', NULL, NULL, NULL, NULL, 80, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 1, 'game', NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=HxNydN5tScI', 'License', '888888888888888888888888', '9999999999999999999999999', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 1, 0, 1, '2019-09-09 15:25:20', '2019-10-02 02:34:27', 0, NULL, NULL, NULL, 0, 0),
	(116, 'pr496jsv', 'affiliate', 'https://www.amazon.com/Rolex-Master-Automatic-self-Wind-Certified-Pre-Owned/dp/B07MHJ8SVQ/ref=lp_13779934011_1_2?s=apparel&ie=UTF8&qid=1565186470&sr=1-2&nodeID=13779934011&psd=1', 13, 4, NULL, NULL, NULL, 'Affiliate Product Title will Be Here. Affiliate Product Title will Be Here 116', 'affiliate-product-title-will-be-here-affiliate-product-title-will-be-here-1-pr495jsv', '1568027684whVhJDrR.png', '1568027717gm0tFzeb.jpg', NULL, NULL, NULL, NULL, '#000000,#a33333,#d90b0b,#209125', 50, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 55555, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'watch', 'Keyword1,Keyword 2', '#ff1a1a,#0fbcd4', 2, '5-7 days', 0, NULL, NULL, NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-09-09 15:36:06', '2019-09-09 13:15:17', 1, '09/08/2021', NULL, NULL, 0, 0),
	(117, 'pr497jsv', 'affiliate', 'https://www.amazon.com/Rolex-Master-Automatic-self-Wind-Certified-Pre-Owned/dp/B07MHJ8SVQ/ref=lp_13779934011_1_2?s=apparel&ie=UTF8&qid=1565186470&sr=1-2&nodeID=13779934011&psd=1', 13, 4, NULL, NULL, NULL, 'Affiliate Product Title will Be Here. Affiliate Product Title will Be Here 117', 'affiliate-product-title-will-be-here-affiliate-product-title-will-be-here-1-pr495jsv', '1568027658Up0FIXsW.png', '1568027670dTA7gQml.jpg', NULL, NULL, NULL, NULL, '#000000,#a33333,#d90b0b,#209125', 50, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 55555, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'watch', NULL, NULL, 2, '5-7 days', 0, NULL, NULL, NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-09-09 15:36:06', '2019-09-09 13:14:30', 1, '09/08/2021', NULL, NULL, 0, 0),
	(118, 'pr498jsv', 'affiliate', 'https://www.amazon.com/Rolex-Master-Automatic-self-Wind-Certified-Pre-Owned/dp/B07MHJ8SVQ/ref=lp_13779934011_1_2?s=apparel&ie=UTF8&qid=1565186470&sr=1-2&nodeID=13779934011&psd=1', 13, 4, NULL, NULL, NULL, 'Affiliate Product Title will Be Here. Affiliate Product Title will Be Here 118', 'affiliate-product-title-will-be-here-affiliate-product-title-will-be-here-1-pr495jsv', '1568027631cnmEylRa.png', '1568027643PgYviwVK.jpg', NULL, NULL, NULL, NULL, '#000000,#a33333,#d90b0b,#209125', 50, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 55555, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'watch', NULL, NULL, 2, '5-7 days', 0, NULL, NULL, NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-09-09 15:36:06', '2019-09-09 13:14:03', 1, '09/08/2021', NULL, NULL, 0, 0),
	(119, 'pr499jsv', 'affiliate', 'https://www.amazon.com/Rolex-Master-Automatic-self-Wind-Certified-Pre-Owned/dp/B07MHJ8SVQ/ref=lp_13779934011_1_2?s=apparel&ie=UTF8&qid=1565186470&sr=1-2&nodeID=13779934011&psd=1', 13, 4, NULL, NULL, NULL, 'Affiliate Product Title will Be Here. Affiliate Product Title will Be Here 1', 'affiliate-product-title-will-be-here-affiliate-product-title-will-be-here-1-pr495jsv', '1568027603i5UAZiKB.png', '1568027616O1coe3aV.jpg', NULL, NULL, NULL, NULL, '#000000,#a33333,#d90b0b,#209125', 50, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 55555, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'watch', NULL, NULL, 2, '5-7 days', 0, NULL, NULL, NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-09-09 15:36:06', '2019-09-09 13:13:36', 1, '09/08/2021', NULL, NULL, 0, 0),
	(120, 'pr500jsv', 'affiliate', 'https://www.amazon.com/Rolex-Master-Automatic-self-Wind-Certified-Pre-Owned/dp/B07MHJ8SVQ/ref=lp_13779934011_1_2?s=apparel&ie=UTF8&qid=1565186470&sr=1-2&nodeID=13779934011&psd=1', 13, 4, NULL, NULL, NULL, 'Affiliate Product Title will Be Here. Affiliate Product Title will Be Here 120', 'affiliate-product-title-will-be-here-affiliate-product-title-will-be-here-1-pr495jsv', '1568027558gLSECTIh.png', '1568027591b1oUIo7Q.jpg', NULL, NULL, NULL, NULL, '#000000,#a33333,#d90b0b,#209125', 50, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 55555, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'watch', NULL, NULL, 2, '5-7 days', 0, NULL, NULL, NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 1, 0, '2019-09-09 15:36:06', '2019-09-09 13:53:33', 1, '09/08/2021', NULL, NULL, 0, 0),
	(121, 'pr501jsv', 'affiliate', 'https://www.amazon.com/Rolex-Master-Automatic-self-Wind-Certified-Pre-Owned/dp/B07MHJ8SVQ/ref=lp_13779934011_1_2?s=apparel&ie=UTF8&qid=1565186470&sr=1-2&nodeID=13779934011&psd=1', 13, 4, NULL, NULL, NULL, 'Affiliate Product Title will Be Here. Affiliate Product Title will Be Here 121', 'affiliate-product-title-will-be-here-affiliate-product-title-will-be-here-1-pr495jsv', '1568027534O1QEBPpR.png', '1568027543P8eoamtf.jpg', NULL, NULL, NULL, NULL, '#000000,#a33333,#d90b0b,#209125', 50, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 55555, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'watch', NULL, NULL, 2, '5-7 days', 0, NULL, NULL, NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-09-09 15:36:06', '2019-09-09 13:12:23', 1, '09/08/2021', NULL, NULL, 0, 0),
	(122, 'pr502jsv', 'affiliate', 'https://www.amazon.com/Rolex-Master-Automatic-self-Wind-Certified-Pre-Owned/dp/B07MHJ8SVQ/ref=lp_13779934011_1_2?s=apparel&ie=UTF8&qid=1565186470&sr=1-2&nodeID=13779934011&psd=1', 13, 4, NULL, NULL, NULL, 'Affiliate Product Title will Be Here. Affiliate Product Title will Be Here 122', 'affiliate-product-title-will-be-here-affiliate-product-title-will-be-here-1-pr495jsv', '1568027493eLqHNoZP.png', '1568027517LGq90luX.jpg', NULL, NULL, NULL, NULL, '#000000,#a33333,#d90b0b,#209125', 50, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 55555, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'watch', NULL, NULL, 2, '5-7 days', 0, NULL, NULL, NULL, 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-09-09 15:36:06', '2020-03-22 12:07:59', 1, '09/08/2021', NULL, NULL, 0, 0),
	(123, 'pr608jsv', 'normal', NULL, 13, 5, 6, NULL, NULL, 'Top Rated product title will be here according to your wish 123', 'top-rated-product-title-will-be-here-according-to-your-wish-123-0af12392v', '1568025845ksCVo0hg.png', '1568025845bvB0Q0RE.jpg', NULL, NULL, NULL, NULL, '#000000,#15a0bf,#f5cf07,#2b4cc2,#247d32,#d62727', 100, 500, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 7, 'fashion', NULL, NULL, 2, '5-7 days', 0, 'fashion', 'Fashion meta tag from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 1, 0, 0, 1, '2019-09-09 16:00:05', '2019-10-12 07:26:54', 0, NULL, '10,20,30,40', '5,10,15,20', 1, 0),
	(124, 'pr609jsv', 'normal', NULL, 13, 5, 6, NULL, NULL, 'Top Rated product title will be here according to your wish 124', 'top-rated-product-title-will-be-here-according-to-your-wish-124-hua12449x', '1568025818Iu033mHq.png', '1568025818tm9YHIHp.jpg', NULL, NULL, NULL, NULL, '#000000,#15a0bf,#f5cf07,#2b4cc2,#247d32,#d62727', 100, 500, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 3, 'fashion', NULL, NULL, 2, '5-7 days', 0, 'fashion', 'Fashion meta tag from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1, 1, 0, 1, 1, '2019-09-09 16:00:05', '2019-10-02 06:39:33', 0, NULL, '10,20,30,40', '5,10,15,20', 1, 0),
	(125, 'pr610jsv', 'normal', NULL, 13, 5, 6, NULL, NULL, 'Top Rated product title will be here according to your wish 125', 'top-rated-product-title-will-be-here-according-to-your-wish-125-lbp125hto', '1568025774B3MU5tJK.png', '1568025774ZsBKNuio.jpg', NULL, NULL, NULL, NULL, '#000000,#15a0bf,#f5cf07,#2b4cc2,#247d32,#d62727', 100, 500, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 1, 'fashion', NULL, NULL, 2, '5-7 days', 0, 'fashion', 'Fashion meta tag from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1, 0, 0, 0, 1, '2019-09-09 16:00:05', '2019-10-02 00:57:30', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 0),
	(126, 'pr611jsv', 'normal', NULL, 13, 5, 6, NULL, NULL, 'Top Rated product title will be here according to your wish 1', 'top-rated-product-title-will-be-here-according-to-your-wish-1-7uo96fft', '1568025683HenL6lSt.png', '1568025683ZYvDAf0q.jpg', NULL, NULL, NULL, NULL, '#000000,#15a0bf,#f5cf07,#2b4cc2,#247d32,#d62727', 100, 500, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; padding: 0px; text-align: justify;">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; padding: 0px; text-align: justify;">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 11, 'fashion', NULL, NULL, 2, '5-7 days', 0, 'fashion', 'Fashion meta tag from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, 0, 0, 0, '2019-09-09 16:00:05', '2020-01-05 07:35:36', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 0),
	(128, 'pr613jsv', 'normal', NULL, 13, 5, 6, NULL, NULL, 'Top Rated product title will be here according to your wish 102', 'top-rated-product-title-will-be-here-according-to-your-wish-102-rgr128igz', '1568025531RbQwgMZ5.png', '1568025531ckSl3TVR.jpg', NULL, NULL, NULL, NULL, '#000000,#15a0bf,#f5cf07,#2b4cc2,#247d32,#d62727', 100, 500, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 2, 'fashion', 'Keyword1,Keyword 2', '#42c406,#f00505', 2, '5-7 days', 0, 'fashion', 'Fashion meta tag from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1, 1, 0, 0, 1, '2019-09-09 16:00:05', '2019-10-02 01:13:52', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 0),
	(129, 'pr614jsv', 'normal', NULL, 13, 5, 6, NULL, NULL, 'Top Rated product title will be here according to your wish 101', 'top-rated-product-title-will-be-here-according-to-your-wish-101-nls129ico', '1568025423UQNFrvNh.png', '15680254230iXcasMb.jpg', NULL, NULL, NULL, NULL, '#000000,#15a0bf,#f5cf07,#2b4cc2,#247d32,#d62727', 100, 500, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 2, 'fashion', NULL, NULL, 2, '5-7 days', 0, 'fashion', 'Fashion meta tag from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1, 1, 0, 1, 1, '2019-09-09 16:00:05', '2019-10-02 06:39:25', 0, NULL, '10,20,30,40', '5,10,15,20', 1, 0),
	(130, NULL, 'normal', NULL, 13, 8, NULL, NULL, NULL, 'License key title will be here according to your wish 130', 'license-key-title-will-be-here-according-to-your-wish-130-nwn1300xx', '1568029076fUcMe2QP.png', '1568029076jgoAP4SR.jpg', '156801752005.zip', NULL, NULL, NULL, NULL, 80, 100, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 5, 'game', NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=HxNydN5tScI', 'License', '888888888888888888888888', '999', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 1, 1, '2019-09-09 15:25:20', '2019-10-02 00:57:07', 0, NULL, NULL, NULL, 0, 0),
	(134, 'OO42939gas', 'normal', NULL, 13, 4, 2, 1, NULL, 'Elite 24\'\' ELITE HD LED TV DN600D', 'elite-24-elite-hd-led-tv-dn600d-oo42939gas', '1570072567FiBwycha.png', '1570072567Cqr5iSzD.jpg', NULL, NULL, NULL, NULL, NULL, 300, 400, '<span style="color: rgb(0, 0, 0); font-family: Roboto, -apple-system, BlinkMacSystemFont, " helvetica="" neue",="" helvetica,="" sans-serif;"=""><font size="3">TVs always get the final say where the couch goes. We want to shake things up and give you the freedom to decorate the way you want to, not the way you have to. It’s fun, playful and unique, and it goes anywhere. It fits your lifestyle, not the other way around. Its smooth, clean design blends in anywhere, yet the playful color doesn’t get buried. Now, you have the freedom to tailor your TV to your own lifestyle. Finally, a TV that fits you. No messy wires. No unsightly air vents. Just one cord for a smooth back that looks great anywhere. This power consumption system will get 90% saving your electrical power.</font></span><br>', 992, '<span style="color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" text-align:="" justify;"=""><font size="3">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</font></span><br>', 1, 36, 'tv,television', NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=MIJBxqzazeM', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-09-25 03:33:22', '2019-10-12 09:20:27', 0, NULL, NULL, NULL, 1, 0),
	(135, '3uZ9903ofs', 'normal', NULL, 13, 4, 2, 1, NULL, '32 \'\'NAPCO D/GLASS ULTRA SLIM HD lED TV ES700E', '32-napco-dglass-ultra-slim-hd-led-tv-es700e-3uz9903ofs', '1570072554QTCZrnNj.png', '1570072555mZv9XiNP.jpg', NULL, NULL, NULL, NULL, NULL, 300, 500, '<span style="color: rgb(0, 0, 0); font-family: calibri, sans-serif;"><font size="4">NAPCO TV always get the final say where the couch goes. We want to shake things up and give you the freedom to decorate the way you want to, not the way you have to. It’s fun, playful and unique, and it goes anywhere. It fits your lifestyle, not the other way around. Its smooth, clean design blends in anywhere, yet the playful color doesn’t get buried. Now, you have the freedom to tailor your TV to your own lifestyle. Finally, a TV that fits you. No messy wires. No unsightly air vents. Just one cord for a smooth back that looks great anywhere. This power consumption system will get 90% saving your electrical power.</font></span><br>', 396, '<span style="color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;="" text-align:="" justify;"="">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><br>', 1, 80, 'lcd,tv,led', NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=LIqQNG_q2us', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-09-30 02:08:12', '2019-10-12 08:43:18', 0, NULL, NULL, NULL, 1, 0),
	(144, 'vrX2915O5c', 'normal', NULL, 13, 4, 2, 1, NULL, '32 \'\'NAPCO D/GLASS ULTRA SLIM HD lED TV ES700E', '32-napco-dglass-ultra-slim-hd-led-tv-es700e-vrx2915o5c', '1570072918cZGfHP4L.jpg', '1584942848B9z2jIvL.jpg', NULL, NULL, NULL, NULL, NULL, 300, 500, '<span style="color: rgb(0, 0, 0); font-family: calibri, sans-serif;"><font size="4">NAPCO TV always get the final say where the couch goes. We want to shake things up and give you the freedom to decorate the way you want to, not the way you have to. It’s fun, playful and unique, and it goes anywhere. It fits your lifestyle, not the other way around. Its smooth, clean design blends in anywhere, yet the playful color doesn’t get buried. Now, you have the freedom to tailor your TV to your own lifestyle. Finally, a TV that fits you. No messy wires. No unsightly air vents. Just one cord for a smooth back that looks great anywhere. This power consumption system will get 90% saving your electrical power.</font></span><br>', 396, '<span style="color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;="" text-align:="" justify;"="">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><br>', 1, 21, 'lcd,tv,led', NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=LIqQNG_q2us', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-03 00:21:58', '2020-03-23 02:54:08', 0, NULL, NULL, NULL, 0, 135),
	(159, 'zhv5144fRY', 'normal', NULL, 13, 4, 2, 1, NULL, 'Revel - Real Estate HTML Template', 'revel-real-estate-html-template-zhv5144fry', '1570085245XVFR2oBZ.png', '1570085246ZA1btIzg.jpg', NULL, NULL, NULL, NULL, NULL, 300, 346, 'dfh', 34634, 'dfh', 1, 8, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=MIJBxqzazeM', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-03 03:47:25', '2019-10-12 07:54:24', 0, NULL, NULL, NULL, 0, 0),
	(160, 'o1L5621DiS', 'normal', NULL, 13, 4, 2, 1, NULL, 'Zain - Digital Agency and Startup HTML Template', 'zain-digital-agency-and-startup-html-template-o1l5621dis', '1570085654jsXxCLyC.png', '1570085654jeAoOOo6.jpg', NULL, NULL, NULL, NULL, NULL, 346, 346, 'sgasdg', 34, 'dsgds', 1, 4, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=MIJBxqzazeM', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-03 03:54:14', '2019-10-12 07:54:27', 0, NULL, NULL, NULL, 0, 0),
	(161, 'D2e6433Yi0', 'normal', NULL, 13, 4, 2, 1, NULL, 'Revel - Real Estate HTML Template', 'revel-real-estate-html-template-d2e6433yi0', '1570086479WEPC1gt0.png', '1570086479kBZE8u1v.jpg', NULL, NULL, NULL, NULL, NULL, 300, 400, 'hdfhdf', 0, 'dfjdfj', 1, 24, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=MIJBxqzazeM', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-03 04:07:59', '2019-10-12 02:30:04', 0, NULL, NULL, NULL, 0, 0),
	(162, 'tOC5844N0t', 'normal', NULL, 13, 4, 2, 1, NULL, 'Zain - Digital Agency and Startup HTML Template', 'zain-digital-agency-and-startup-html-template-toc5844n0t', '1570255904FqR6FYd6.png', '1570255905GPr2HimK.jpg', NULL, 'S,Medium,Large', '100,100,100', '2,5,10', '#000000,#962f2f,#1c10a1,#1e9114,#701313', 400, 450, 'sdhds', 449, 'hdsh', 1, 124, 'dsf,hgf', 'Test,test1', '#000000,#d14141', 2, '24', 0, NULL, NULL, 'https://www.youtube.com/watch?v=MIJBxqzazeM', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-05 03:11:44', '2019-10-12 03:52:17', 0, NULL, '15,20,30,40,50', '10,15,20,25,30', 0, 0),
	(163, '1ui8665inp', 'normal', NULL, 13, 17, NULL, NULL, NULL, 'Zain - Digital Agency and Startup HTML Template', 'zain-digital-agency-and-startup-html-template-1ui8665inp', '1570258694VlEv5IWz.png', '1570258694DNAUV7hA.jpg', NULL, NULL, NULL, NULL, NULL, 300, 464, 'fhjd', 734, 'dfj', 1, 1, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=MIJBxqzazeM', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-05 03:58:14', '2019-10-05 03:58:29', 0, NULL, NULL, NULL, 0, 0),
	(164, 'RXp8737LeV', 'normal', NULL, 13, 5, 9, NULL, NULL, 'Zain - Digital Agency and Startup HTML Template', 'zain-digital-agency-and-startup-html-template-rxp8737lev', '157025877313GpXaVy.png', '15702587732fKHlv77.jpg', NULL, NULL, NULL, NULL, NULL, 300, 548, 'gfkj', 4588, 'fgk', 1, 3, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=MIJBxqzazeM', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-05 03:59:33', '2019-12-29 01:56:27', 0, NULL, NULL, NULL, 0, 0),
	(165, 'RXp8737Le', 'normal', NULL, 13, 5, 9, NULL, NULL, 'Zain - Digital Agency and Startup HTML Template', 'zain-digital-agency-and-startup-html-template-rxp8737le', '15702607258LEdVp5O.png', '1570260725Wze2eRN9.jpg', NULL, NULL, NULL, NULL, NULL, 300, 548, 'gfkj', 4588, 'fgk', 0, 2, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=MIJBxqzazeM', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-05 04:00:19', '2020-03-22 12:07:51', 0, NULL, NULL, NULL, 0, 0),
	(166, 'U1W3579L5k', 'normal', NULL, 0, 4, 2, 1, '{"warranty_type":{"values":["No warranty","Non-local warranty"],"prices":["0","30"],"details_status":1},"brand":{"values":["Oppo","Infinix"],"prices":["20","40"],"details_status":1},"ram":{"values":["3 GB"],"prices":["0"],"details_status":0},"color_family":{"values":["Black","White","Brown"],"prices":["0","20","0"],"details_status":1},"display_size":{"values":["40","21"],"prices":["12","20"],"details_status":1}}', 'Zain - Digital Agency and Startupuuuu', 'zain-digital-agency-and-startupuuuu-u1w3579l5k', '15708736755B0OtgVI.png', '1570873675mdibaSBp.jpg', NULL, NULL, NULL, NULL, NULL, 300, 436, 'shsdh', 346, 'sdhds', 1, 3, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=MIJBxqzazeM', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 06:47:55', '2019-10-17 06:22:21', 0, NULL, NULL, NULL, 0, 0),
	(167, 'kE84874xem', 'normal', NULL, 13, 4, 2, 1, NULL, 'Courses', 'courses-ke84874xem', '1570874976y1X2tWVr.png', '15708749764ioXjDWh.jpg', NULL, NULL, NULL, NULL, NULL, 250, 355, 'asgas', 345, 'agsas', 1, 4, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=MIJBxqzazeM', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 07:09:36', '2019-10-12 07:55:05', 0, NULL, NULL, NULL, 0, 0),
	(168, 'tbs53803yh', 'normal', NULL, 13, 4, 2, 1, '{"warranty_type":{"values":["Local seller warranty","international manufacturer warranty"],"prices":["78","45"],"details_status":1},"brand":{"values":["Symphony","Apple"],"prices":["0","0"],"details_status":1},"ram":{"values":["1 GB","3 GB"],"prices":["0","0"],"details_status":1},"color_family":{"values":["Sliver","Brown"],"prices":["67","5"],"details_status":1}}', 'Revel - Real Estate Huuu', 'revel-real-estate-huuu-tbs53803yh', '1570875445mpVQBH3x.png', '15708754456n2CU31X.jpg', NULL, NULL, NULL, NULL, NULL, 300, 345, 'dfshdfs', 5, 'sdgs', 1, 21, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 'https://www.youtube.com/watch?v=MIJBxqzazeM', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 07:17:25', '2020-01-21 04:24:02', 0, NULL, NULL, NULL, 0, 0),
	(169, 'TRg5938WNy', 'normal', NULL, 13, 5, 6, NULL, NULL, 'Top Rated product title will be here according to your wish 123', 'top-rated-product-title-will-be-here-according-to-your-wish-123-trg5938wny', '1570875978KD9cRleA.jpg', '15708759789N9Hm1QJ.jpg', NULL, NULL, NULL, NULL, 'Red,#000000,#15a0bf,#f5cf07,#2b4cc2,#247d32,#d62727', 100, 500, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 4, 'fashion', NULL, NULL, 2, '5-7 days', 0, 'fashion', 'Fashion meta tag from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 07:26:18', '2019-10-12 07:31:05', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 123),
	(170, '6Vb6172gWR', 'normal', NULL, 13, 5, 6, NULL, NULL, 'Top Rated product title will be here according to your wish 123', 'top-rated-product-title-will-be-here-according-to-your-wish-123-6vb6172gwr', '1570876195YsopRMZ0.jpg', '157087619598Nfs52R.jpg', NULL, NULL, NULL, NULL, 'Black,Red,#000000,#15a0bf,#f5cf07,#2b4cc2,#247d32,#d62727', 100, 500, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'fashion', NULL, NULL, 2, '5-7 days', 0, 'fashion', 'Fashion meta tag from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 07:29:55', '2019-10-12 07:29:55', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 123),
	(171, 'zia62030Vj', 'normal', NULL, 13, 5, 6, NULL, NULL, 'Top Rated product title will be here according to your wish 123', 'top-rated-product-title-will-be-here-according-to-your-wish-123-zia62030vj', '1570876207958wem8B.jpg', '1570876207Ri9VVzRq.jpg', NULL, NULL, NULL, NULL, '#000000,#15a0bf,#f5cf07,#2b4cc2,#247d32,#d62727', 100, 500, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" padding:="" 0px;="" text-align:="" justify;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 2, 'fashion', NULL, NULL, 2, '5-7 days', 0, 'fashion', 'Fashion meta tag from Demo store.', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 07:30:07', '2020-01-23 03:53:22', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 123),
	(173, 'b2Q6258iDf', 'normal', NULL, 13, 5, NULL, NULL, NULL, 'Physical Product Title Title will Be Here 0131 Test', 'physical-product-title-title-will-be-here-0131-test-b2q6258idf', '1570876281siGCkmvP.jpg', '1570876281Wt1wdK8O.jpg', NULL, 'S', '2147483643', '20', 'White,Red,#000000,#851818,#ff0d0d,#1feb4c,#d620cf,#186ceb', 120, 200, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'clothing,bag', 'Keyword1,Keyword 2', '#cf1d1d,#c92be3', 2, '5-7 days', 0, 'clothing,bag', 'clothing, bag', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 07:31:21', '2019-10-12 07:31:21', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 131),
	(174, 'bXf62830R9', 'normal', NULL, 13, 5, NULL, NULL, NULL, 'Physical Product Title Title will Be Here 0131 Test', 'physical-product-title-title-will-be-here-0131-test-bxf62830r9', '1570876303dcztUot8.jpg', '15708763046Vwtn82r.jpg', NULL, 'S', '2147483643', '20', 'White,Black,#000000,#851818,#ff0d0d,#1feb4c,#d620cf,#186ceb', 120, 200, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'clothing,bag', 'Keyword1,Keyword 2', '#cf1d1d,#c92be3', 2, '5-7 days', 0, 'clothing,bag', 'clothing, bag', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 07:31:43', '2019-10-12 07:31:44', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 131),
	(175, '9gn6494iUN', 'normal', NULL, 13, 5, 7, NULL, NULL, 'Physical Product Title Title will Be Here 102', 'physical-product-title-title-will-be-here-102-9gn6494iun', '1570876503CUOkgSFD.jpg', '1570876503XgLFnuQi.jpg', NULL, 'S', '55555555555555555', '20', '#ffffff,#000000,#000000,#851818,#ff0d0d,#1feb4c,#d620cf,#186ceb', 100, 200, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 1, 'clothing,bag', NULL, NULL, 1, '5-7 days', 0, 'clothing,bag', 'clothing, bag', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 07:35:03', '2020-03-23 00:34:59', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 102),
	(178, 'Tcv6794KXS', 'normal', NULL, 13, 5, 7, NULL, NULL, 'Physical Product Title Title will Be Here 99', 'physical-product-title-title-will-be-here-99-tcv6794kxs', '1570876820YXbcdnxW.jpg', '1570876820rpkj3Z6U.jpg', NULL, 'S', '2147483644', '20', 'White,Black,#000000,#851818,#ff0d0d,#1feb4c,#d620cf,#186ceb', 100, 200, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'clothing,bag', NULL, NULL, 2, '5-7 days', 0, 'clothing,bag', 'clothing, bag', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 07:40:20', '2019-10-12 07:40:20', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 99),
	(179, 'mf56823djs', 'normal', NULL, 13, 5, 7, NULL, NULL, 'Physical Product Title Title will Be Here 99', 'physical-product-title-title-will-be-here-99-mf56823djs', '1570877127ByWwIJUA.jpg', '1570877128HKed4vMT.jpg', NULL, 'S', '2147483644', '20', 'White,Red,#000000,#851818,#ff0d0d,#1feb4c,#d620cf,#186ceb', 100, 200, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 0, 'clothing,bag', NULL, NULL, 2, '5-7 days', 0, 'clothing,bag', 'clothing, bag', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 07:45:27', '2019-10-12 07:45:28', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 99),
	(180, 'myy7236gFD', 'normal', NULL, 13, 5, 7, NULL, NULL, 'Physical Product Title Title will Be Here 99u', 'physical-product-title-title-will-be-here-99u-myy7236gfd', '1570877254IpMreGOE.jpg', '1584942834BQBbShSE.jpg', NULL, 'S', '2147483644', '20', '#ffffff,#ff0000,#000000,#851818,#ff0d0d,#1feb4c,#d620cf,#186ceb', 100, 200, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', NULL, '<p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;"="">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, 2, 'clothing,bag', NULL, NULL, 2, '5-7 days', 0, 'clothing,bag', 'clothing, bag', 'https://www.youtube.com/watch?v=HxNydN5tScI', 'Physical', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, '2019-10-12 07:47:34', '2020-03-23 02:59:56', 0, NULL, '10,20,30,40', '5,10,15,20', 0, 99);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table gcart3.product_clicks
CREATE TABLE IF NOT EXISTS `product_clicks` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `product_id` int(191) NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.product_clicks: ~3 rows (approximately)
/*!40000 ALTER TABLE `product_clicks` DISABLE KEYS */;
INSERT INTO `product_clicks` (`id`, `product_id`, `date`) VALUES
	(20, 100, '2021-10-10'),
	(21, 112, '2022-03-26'),
	(22, 101, '2022-03-26');
/*!40000 ALTER TABLE `product_clicks` ENABLE KEYS */;

-- Dumping structure for table gcart3.ratings
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) NOT NULL,
  `product_id` int(191) NOT NULL,
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rating` tinyint(2) NOT NULL,
  `review_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.ratings: ~0 rows (approximately)
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;

-- Dumping structure for table gcart3.replies
CREATE TABLE IF NOT EXISTS `replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) unsigned NOT NULL,
  `comment_id` int(191) unsigned NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.replies: ~0 rows (approximately)
/*!40000 ALTER TABLE `replies` DISABLE KEYS */;
/*!40000 ALTER TABLE `replies` ENABLE KEYS */;

-- Dumping structure for table gcart3.reports
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) NOT NULL,
  `product_id` int(192) NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.reports: ~0 rows (approximately)
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;

-- Dumping structure for table gcart3.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `details` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gcart3.reviews: ~3 rows (approximately)
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` (`id`, `photo`, `title`, `subtitle`, `details`) VALUES
	(4, '1557343012img.jpg', 'Jhon Smith', 'CEO & Founder', 'Lorem ipsum dolor sit amet, consectetur elitad adipiscing Cras non placerat mi.'),
	(5, '1557343018img.jpg', 'Jhon Smith', 'CEO & Founder', 'Lorem ipsum dolor sit amet, consectetur elitad adipiscing Cras non placerat mi.'),
	(6, '1557343024img.jpg', 'Jhon Smith', 'CEO & Founder', 'Lorem ipsum dolor sit amet, consectetur elitad adipiscing Cras non placerat mi.');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;

-- Dumping structure for table gcart3.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.roles: ~3 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `section`) VALUES
	(16, 'Manager', 'orders , products , affilate_products , customers , vendors , vendor_subscription_plans , categories , bulk_product_upload , product_discussion , set_coupons , blog , messages , general_settings , home_page_settings , menu_page_settings , emails_settings , payment_settings , social_settings , language_settings , seo_tools , subscribers'),
	(17, 'Moderator', 'orders , products , customers , vendors , categories , blog , messages , home_page_settings , payment_settings , social_settings , language_settings , seo_tools , subscribers'),
	(18, 'Staff', 'orders , products , vendors , vendor_subscription_plans , categories , blog , home_page_settings , menu_page_settings , language_settings , seo_tools , subscribers');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table gcart3.seotools
CREATE TABLE IF NOT EXISTS `seotools` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `google_analytics` text COLLATE utf8mb4_unicode_ci,
  `meta_keys` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gcart3.seotools: ~1 rows (approximately)
/*!40000 ALTER TABLE `seotools` DISABLE KEYS */;
INSERT INTO `seotools` (`id`, `google_analytics`, `meta_keys`) VALUES
	(1, '<script>//Google Analytics Scriptfffffffffffffffffffffffssssfffffs</script>', 'Genius,Ocean,Sea,Etc,Genius,Ocean,SeaGenius,Ocean,Sea,Etc,Genius,Ocean,SeaGenius,Ocean,Sea,Etc,Genius,Ocean,Sea');
/*!40000 ALTER TABLE `seotools` ENABLE KEYS */;

-- Dumping structure for table gcart3.services
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) NOT NULL DEFAULT '0',
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.services: ~8 rows (approximately)
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` (`id`, `user_id`, `title`, `details`, `photo`) VALUES
	(2, 0, 'FREE SHIPPING', 'Free Shipping All Order', '1561348133service1.png'),
	(3, 0, 'PAYMENT METHOD', 'Secure Payment', '1561348138service2.png'),
	(4, 0, '30 DAY RETURNS', '30-Day Return Policy', '1561348143service3.png'),
	(5, 0, 'HELP CENTER', '24/7 Support System', '1561348147service4.png'),
	(6, 13, 'FREE SHIPPING', 'Free Shipping All Order', '1563247602brand1.png'),
	(7, 13, 'PAYMENT METHOD', 'Secure Payment', '1563247614brand2.png'),
	(8, 13, '30 DAY RETURNS', '30-Day Return Policy', '1563247620brand3.png'),
	(9, 13, 'HELP CENTER', '24/7 Support System', '1563247670brand4.png');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;

-- Dumping structure for table gcart3.shippings
CREATE TABLE IF NOT EXISTS `shippings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) NOT NULL DEFAULT '0',
  `title` text,
  `subtitle` text,
  `price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.shippings: ~2 rows (approximately)
/*!40000 ALTER TABLE `shippings` DISABLE KEYS */;
INSERT INTO `shippings` (`id`, `user_id`, `title`, `subtitle`, `price`) VALUES
	(1, 0, 'Free Shipping', '(10 - 12 days)', 0),
	(2, 0, 'Express Shipping', '(5 - 6 days)', 10);
/*!40000 ALTER TABLE `shippings` ENABLE KEYS */;

-- Dumping structure for table gcart3.sliders
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int(191) unsigned NOT NULL AUTO_INCREMENT,
  `subtitle_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `subtitle_size` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle_anime` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `title_size` varchar(50) DEFAULT NULL,
  `title_color` varchar(50) DEFAULT NULL,
  `title_anime` varchar(50) DEFAULT NULL,
  `details_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `details_size` varchar(50) DEFAULT NULL,
  `details_color` varchar(50) DEFAULT NULL,
  `details_anime` varchar(50) DEFAULT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.sliders: ~3 rows (approximately)
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` (`id`, `subtitle_text`, `subtitle_size`, `subtitle_color`, `subtitle_anime`, `title_text`, `title_size`, `title_color`, `title_anime`, `details_text`, `details_size`, `details_color`, `details_anime`, `photo`, `position`, `link`) VALUES
	(8, 'World Fashion', '24', '#ffffff', 'slideInUp', 'Get Up to 40% Off', '60', '#ffffff', 'slideInDown', 'Highlight your personality  and look with these fabulous and exquisite fashion.', '16', '#ffffff', 'slideInRight', '1564224870012.jpg', 'slide-three', 'https://www.google.com/'),
	(9, 'World Fashion', '24', '#ffffff', 'slideInUp', 'Get Up to 40% Off', '60', '#ffffff', 'slideInDown', 'Highlight your personality  and look with these fabulous and exquisite fashion.', '16', '#ffffff', 'slideInDown', '1564224753007.jpg', 'slide-one', 'https://www.google.com/'),
	(10, 'World Fashion', '24', '#c32d2d', 'slideInUp', 'Get Up to 40% Off', '60', '#bc2727', 'slideInDown', 'Highlight your personality  and look with these fabulous and exquisite fashion.', '16', '#c51d1d', 'slideInLeft', '156422490902.jpg', 'slide-one', 'https://www.google.com/');
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;

-- Dumping structure for table gcart3.socialsettings
CREATE TABLE IF NOT EXISTS `socialsettings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gplus` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `linkedin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dribble` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_status` tinyint(4) NOT NULL DEFAULT '1',
  `g_status` tinyint(4) NOT NULL DEFAULT '1',
  `t_status` tinyint(4) NOT NULL DEFAULT '1',
  `l_status` tinyint(4) NOT NULL DEFAULT '1',
  `d_status` tinyint(4) NOT NULL DEFAULT '1',
  `f_check` tinyint(10) DEFAULT NULL,
  `g_check` tinyint(10) DEFAULT NULL,
  `fclient_id` text COLLATE utf8mb4_unicode_ci,
  `fclient_secret` text COLLATE utf8mb4_unicode_ci,
  `fredirect` text COLLATE utf8mb4_unicode_ci,
  `gclient_id` text COLLATE utf8mb4_unicode_ci,
  `gclient_secret` text COLLATE utf8mb4_unicode_ci,
  `gredirect` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gcart3.socialsettings: ~1 rows (approximately)
/*!40000 ALTER TABLE `socialsettings` DISABLE KEYS */;
INSERT INTO `socialsettings` (`id`, `facebook`, `gplus`, `twitter`, `linkedin`, `dribble`, `f_status`, `g_status`, `t_status`, `l_status`, `d_status`, `f_check`, `g_check`, `fclient_id`, `fclient_secret`, `fredirect`, `gclient_id`, `gclient_secret`, `gredirect`) VALUES
	(1, 'https://www.facebook.com/', 'https://plus.google.com/', 'https://twitter.com/', 'https://www.linkedin.com/', 'https://dribbble.com/', 1, 1, 1, 1, 1, 1, 1, '503140663460329', 'f66cd670ec43d14209a2728af26dcc43', 'https://localhost/geniuscart1.7.4/auth/facebook/callback', '904681031719-sh1aolu42k7l93ik0bkiddcboghbpcfi.apps.googleusercontent.com', 'yGBWmUpPtn5yWhDAsXnswEX3', 'http://localhost/geniuscart1.7.4/auth/google/callback');
/*!40000 ALTER TABLE `socialsettings` ENABLE KEYS */;

-- Dumping structure for table gcart3.social_providers
CREATE TABLE IF NOT EXISTS `social_providers` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) NOT NULL,
  `provider_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.social_providers: ~0 rows (approximately)
/*!40000 ALTER TABLE `social_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_providers` ENABLE KEYS */;

-- Dumping structure for table gcart3.subcategories
CREATE TABLE IF NOT EXISTS `subcategories` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `category_id` int(191) NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.subcategories: ~16 rows (approximately)
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
INSERT INTO `subcategories` (`id`, `category_id`, `name`, `slug`, `status`) VALUES
	(2, 4, 'TELEVISION', 'television', 1),
	(3, 4, 'REFRIGERATOR', 'refrigerator', 1),
	(4, 4, 'WASHING MACHINE', 'washing-machine', 1),
	(5, 4, 'AIR CONDITIONERS', 'air-conditioners', 1),
	(6, 5, 'ACCESSORIES', 'accessories', 1),
	(7, 5, 'BAGS', 'bags', 1),
	(8, 5, 'CLOTHINGS', 'clothings', 1),
	(9, 5, 'SHOES', 'shoes', 1),
	(10, 7, 'APPLE', 'apple', 1),
	(11, 7, 'SAMSUNG', 'samsung', 1),
	(12, 7, 'LG', 'lg', 1),
	(13, 7, 'SONY', 'sony', 1),
	(14, 6, 'DSLR', 'dslr', 1),
	(15, 6, 'Camera Phone', 'camera-phone', 1),
	(16, 6, 'Action Camera', 'animation-camera', 1),
	(17, 6, 'Digital Camera', 'digital-camera', 1);
/*!40000 ALTER TABLE `subcategories` ENABLE KEYS */;

-- Dumping structure for table gcart3.subscribers
CREATE TABLE IF NOT EXISTS `subscribers` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.subscribers: ~0 rows (approximately)
/*!40000 ALTER TABLE `subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscribers` ENABLE KEYS */;

-- Dumping structure for table gcart3.subscriptions
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `days` int(11) NOT NULL,
  `allowed_products` int(11) NOT NULL DEFAULT '0',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.subscriptions: ~4 rows (approximately)
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` (`id`, `title`, `currency`, `currency_code`, `price`, `days`, `allowed_products`, `details`) VALUES
	(5, 'Standard', '$', 'USD', 60, 45, 25, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>'),
	(6, 'Premium', '$', 'USD', 120, 90, 90, '<span style="color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" text-align:="" justify;"="">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>'),
	(7, 'Unlimited', '$', 'USD', 250, 365, 0, '<span style="color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" text-align:="" justify;"="">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span><br>'),
	(8, 'Basic', '$', 'USD', 0, 30, 0, '<ol><li>Lorem ipsum dolor sit amet<br></li><li>Lorem ipsum dolor sit ame<br></li><li>Lorem ipsum dolor sit am<br></li></ol>');
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;

-- Dumping structure for table gcart3.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_provider` tinyint(10) NOT NULL DEFAULT '0',
  `status` tinyint(10) NOT NULL DEFAULT '0',
  `verification_link` text COLLATE utf8mb4_unicode_ci,
  `email_verified` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `affilate_code` text COLLATE utf8mb4_unicode_ci,
  `affilate_income` double NOT NULL DEFAULT '0',
  `shop_name` text COLLATE utf8mb4_unicode_ci,
  `owner_name` text COLLATE utf8mb4_unicode_ci,
  `shop_number` text COLLATE utf8mb4_unicode_ci,
  `shop_address` text COLLATE utf8mb4_unicode_ci,
  `reg_number` text COLLATE utf8mb4_unicode_ci,
  `shop_message` text COLLATE utf8mb4_unicode_ci,
  `shop_details` text COLLATE utf8mb4_unicode_ci,
  `shop_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_url` text COLLATE utf8mb4_unicode_ci,
  `g_url` text COLLATE utf8mb4_unicode_ci,
  `t_url` text COLLATE utf8mb4_unicode_ci,
  `l_url` text COLLATE utf8mb4_unicode_ci,
  `is_vendor` tinyint(1) NOT NULL DEFAULT '0',
  `f_check` tinyint(1) NOT NULL DEFAULT '0',
  `g_check` tinyint(1) NOT NULL DEFAULT '0',
  `t_check` tinyint(1) NOT NULL DEFAULT '0',
  `l_check` tinyint(1) NOT NULL DEFAULT '0',
  `mail_sent` tinyint(1) NOT NULL DEFAULT '0',
  `shipping_cost` double NOT NULL DEFAULT '0',
  `current_balance` double NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `ban` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table gcart3.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `photo`, `zip`, `city`, `country`, `address`, `phone`, `fax`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `is_provider`, `status`, `verification_link`, `email_verified`, `affilate_code`, `affilate_income`, `shop_name`, `owner_name`, `shop_number`, `shop_address`, `reg_number`, `shop_message`, `shop_details`, `shop_image`, `f_url`, `g_url`, `t_url`, `l_url`, `is_vendor`, `f_check`, `g_check`, `t_check`, `l_check`, `mail_sent`, `shipping_cost`, `current_balance`, `date`, `ban`) VALUES
	(13, 'Vendor', '1557677677bouquet_PNG62.png', '1234', 'Washington, DC', 'Algeria', 'Space Needle 400 Broad St, Seattles', '3453453345453411', '23123121', 'vendor@gmail.com', '$2y$10$.4NrvXAeyToa4x07EkFvS.XIUEc/aXGsxe1onkQ.Udms4Sl2W9ZYq', '7jQ0Nu7Xv1mHL5DveHEy6vwWINvNGhMWb5rWZwhW78GeMq5FcfVQtW8VcPSm', '2018-03-07 21:05:44', '2022-03-26 03:23:44', 0, 2, '$2y$10$oIf1at.0LwscVwaX/8h.WuSwMKEAAsn8EJ.9P7mWzNUFIcEBQs8ry', 'Yes', '$2y$10$oIf1at.0LwscVwaX/8h.WuSwMKEAAsn8EJ.9P7mWzNUFIcEBQs8rysdfsdfds', 5000, 'Test Stores', 'User', '43543534', 'Space Needle 400 Broad St, Seattles', 'asdasd', 'sdf', '<br>', NULL, NULL, NULL, NULL, NULL, 2, 0, 0, 0, 0, 0, 0, 4978.02, '2021-12-13', 0),
	(22, 'User', NULL, '1231', 'Test City', 'United States', 'Test Address', '34534534534', '34534534534', 'user@gmail.com', '$2y$10$.4NrvXAeyToa4x07EkFvS.XIUEc/aXGsxe1onkQ.Udms4Sl2W9ZYq', 'HnPu70ftuDdxdSeB2uW729b11aYlZtktfC5K1cx1Fl7K4DC5aTA5OCYjwArZ', '2019-06-20 15:26:24', '2022-03-26 03:23:38', 0, 0, '1edae93935fba69d9542192fb854a80a', 'Yes', '8f09b9691613ecb8c3f7e36e34b97b80', 4963.6900000000005, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, 0, 0, 0, 0, 0, 0, '2021-04-09', 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table gcart3.user_notifications
CREATE TABLE IF NOT EXISTS `user_notifications` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) NOT NULL,
  `order_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.user_notifications: ~1 rows (approximately)
/*!40000 ALTER TABLE `user_notifications` DISABLE KEYS */;
INSERT INTO `user_notifications` (`id`, `user_id`, `order_number`, `is_read`, `created_at`, `updated_at`) VALUES
	(23, 13, '2uQhPJ0SF1', 0, '2021-10-10 07:54:18', '2021-10-10 07:54:18');
/*!40000 ALTER TABLE `user_notifications` ENABLE KEYS */;

-- Dumping structure for table gcart3.user_subscriptions
CREATE TABLE IF NOT EXISTS `user_subscriptions` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) NOT NULL,
  `subscription_id` int(191) NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `days` int(11) NOT NULL,
  `allowed_products` int(11) NOT NULL DEFAULT '0',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Free',
  `txnid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `payment_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.user_subscriptions: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_subscriptions` ENABLE KEYS */;

-- Dumping structure for table gcart3.vendor_orders
CREATE TABLE IF NOT EXISTS `vendor_orders` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) NOT NULL,
  `order_id` int(191) NOT NULL,
  `qty` int(191) NOT NULL,
  `price` double NOT NULL,
  `order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','processing','completed','declined','on delivery') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.vendor_orders: ~0 rows (approximately)
/*!40000 ALTER TABLE `vendor_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendor_orders` ENABLE KEYS */;

-- Dumping structure for table gcart3.verifications
CREATE TABLE IF NOT EXISTS `verifications` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) NOT NULL,
  `attachments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('Pending','Verified','Declined') DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `admin_warning` tinyint(1) NOT NULL DEFAULT '0',
  `warning_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.verifications: ~1 rows (approximately)
/*!40000 ALTER TABLE `verifications` DISABLE KEYS */;
INSERT INTO `verifications` (`id`, `user_id`, `attachments`, `status`, `text`, `admin_warning`, `warning_reason`, `created_at`, `updated_at`) VALUES
	(4, 13, '1573723849Baby.tux-800x800.png,1573723849Baby.tux-800x800.png', 'Verified', 'TEst', 0, NULL, '2019-11-14 06:30:49', '2019-11-14 06:34:06');
/*!40000 ALTER TABLE `verifications` ENABLE KEYS */;

-- Dumping structure for table gcart3.wishlists
CREATE TABLE IF NOT EXISTS `wishlists` (
  `id` int(191) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(191) unsigned NOT NULL,
  `product_id` int(191) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.wishlists: ~13 rows (approximately)
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
INSERT INTO `wishlists` (`id`, `user_id`, `product_id`) VALUES
	(3, 22, 101),
	(4, 22, 100),
	(5, 22, 99),
	(6, 22, 97),
	(7, 22, 106),
	(8, 22, 105),
	(9, 22, 104),
	(10, 22, 107),
	(11, 22, 109),
	(12, 22, 119),
	(13, 22, 118),
	(14, 22, 117),
	(15, 22, 116);
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;

-- Dumping structure for table gcart3.withdraws
CREATE TABLE IF NOT EXISTS `withdraws` (
  `id` int(191) NOT NULL AUTO_INCREMENT,
  `user_id` int(191) DEFAULT NULL,
  `method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iban` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `swift` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `amount` float DEFAULT NULL,
  `fee` float DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('pending','completed','rejected') NOT NULL DEFAULT 'pending',
  `type` enum('user','vendor') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gcart3.withdraws: ~0 rows (approximately)
/*!40000 ALTER TABLE `withdraws` DISABLE KEYS */;
/*!40000 ALTER TABLE `withdraws` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
