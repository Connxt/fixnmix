-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.5.27 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for fixnmix
CREATE DATABASE IF NOT EXISTS `fixnmix` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `fixnmix`;


-- Dumping structure for table fixnmix.branches
CREATE TABLE IF NOT EXISTS `branches` (
  `id` varchar(50) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.branches: ~5 rows (approximately)
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` (`id`, `description`) VALUES
	('KAB001', 'first branch in kabankalan'),
	('KAB002', 'second branch in kabankalan'),
	('KAB003', 'third branch in kabankalan'),
	('KAB004', 'ALSDJALKSDJs'),
	('KAB005', 'ALSDKJALSKDJ');
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;


-- Dumping structure for table fixnmix.delivered_items
CREATE TABLE IF NOT EXISTS `delivered_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `delivered_items_delivery_id_to_deliveries_id` (`delivery_id`),
  KEY `delivered_items_item_id_to_items_id` (`item_id`),
  CONSTRAINT `delivered_items_delivery_id_to_deliveries_id` FOREIGN KEY (`delivery_id`) REFERENCES `deliveries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `delivered_items_item_id_to_items_id` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.delivered_items: ~182 rows (approximately)
/*!40000 ALTER TABLE `delivered_items` DISABLE KEYS */;
INSERT INTO `delivered_items` (`id`, `delivery_id`, `item_id`, `quantity`) VALUES
	(1, 1, 2, 0),
	(2, 1, 3, 0),
	(3, 2, 2, 0),
	(4, 2, 3, 0),
	(5, 3, 2, 0),
	(6, 3, 3, 0),
	(7, 4, 2, 0),
	(8, 5, 2, 0),
	(9, 6, 2, 0),
	(10, 7, 2, 0),
	(11, 8, 2, 0),
	(12, 9, 2, 0),
	(13, 10, 2, 0),
	(14, 11, 2, 0),
	(15, 12, 2, 0),
	(16, 13, 2, 0),
	(17, 14, 2, 0),
	(18, 15, 2, 0),
	(19, 15, 3, 0),
	(20, 16, 2, 0),
	(21, 16, 3, 0),
	(22, 17, 2, 0),
	(23, 17, 3, 0),
	(24, 18, 2, 0),
	(25, 18, 3, 0),
	(26, 18, 4, 0),
	(27, 18, 5, 0),
	(28, 19, 2, 0),
	(29, 19, 3, 0),
	(30, 19, 4, 0),
	(31, 19, 5, 0),
	(32, 20, 2, 0),
	(33, 20, 3, 0),
	(34, 20, 4, 0),
	(35, 20, 5, 0),
	(36, 21, 2, 0),
	(37, 21, 3, 0),
	(38, 21, 4, 0),
	(39, 21, 5, 0),
	(40, 22, 2, 0),
	(41, 22, 3, 0),
	(42, 22, 4, 0),
	(43, 22, 5, 0),
	(44, 23, 2, 0),
	(45, 23, 3, 0),
	(46, 23, 4, 0),
	(47, 23, 5, 0),
	(48, 24, 2, 0),
	(49, 24, 3, 0),
	(50, 24, 4, 0),
	(51, 24, 5, 0),
	(52, 25, 2, 0),
	(53, 25, 3, 0),
	(54, 25, 4, 0),
	(55, 25, 5, 0),
	(56, 26, 2, 0),
	(57, 26, 3, 0),
	(58, 27, 2, 0),
	(59, 27, 3, 0),
	(60, 28, 2, 0),
	(61, 28, 3, 0),
	(62, 29, 2, 0),
	(63, 29, 3, 0),
	(64, 30, 2, 0),
	(65, 30, 3, 0),
	(66, 31, 2, 0),
	(67, 31, 3, 0),
	(68, 32, 2, 0),
	(69, 32, 3, 0),
	(70, 33, 2, 0),
	(71, 33, 3, 0),
	(72, 34, 2, 0),
	(73, 34, 3, 0),
	(74, 35, 3, 0),
	(75, 35, 4, 0),
	(76, 36, 3, 0),
	(77, 36, 4, 0),
	(78, 37, 3, 0),
	(79, 37, 4, 0),
	(80, 38, 3, 0),
	(81, 38, 4, 0),
	(82, 39, 3, 0),
	(83, 39, 4, 0),
	(84, 40, 2, 0),
	(85, 40, 3, 0),
	(86, 41, 2, 0),
	(87, 41, 3, 0),
	(88, 42, 4, 0),
	(89, 42, 5, 0),
	(90, 42, 6, 0),
	(91, 43, 4, 0),
	(92, 43, 5, 0),
	(93, 43, 6, 0),
	(94, 44, 4, 0),
	(95, 44, 5, 0),
	(96, 44, 6, 0),
	(97, 45, 4, 0),
	(98, 45, 5, 0),
	(99, 45, 6, 0),
	(100, 46, 4, 0),
	(101, 46, 5, 0),
	(102, 46, 6, 0),
	(103, 47, 4, 0),
	(104, 47, 5, 0),
	(105, 47, 6, 0),
	(106, 48, 3, 0),
	(107, 48, 5, 0),
	(108, 49, 3, 0),
	(109, 49, 5, 0),
	(110, 50, 2, 0),
	(111, 50, 3, 0),
	(112, 50, 4, 0),
	(113, 51, 2, 0),
	(114, 51, 3, 0),
	(115, 51, 4, 0),
	(116, 52, 4, 0),
	(117, 52, 6, 0),
	(118, 52, 123, 0),
	(119, 53, 4, 0),
	(120, 53, 6, 0),
	(121, 53, 123, 0),
	(122, 54, 4, 0),
	(123, 54, 6, 0),
	(124, 54, 123, 0),
	(125, 55, 4, 0),
	(126, 55, 6, 0),
	(127, 55, 123, 0),
	(128, 56, 2, 0),
	(129, 56, 3, 0),
	(130, 57, 2, 0),
	(131, 57, 3, 0),
	(132, 57, 4, 0),
	(133, 58, 2, 0),
	(134, 58, 3, 0),
	(135, 59, 2, 0),
	(136, 59, 3, 0),
	(137, 60, 2, 0),
	(138, 60, 3, 0),
	(139, 61, 2, 0),
	(140, 62, 3, 0),
	(141, 62, 4, 0),
	(142, 63, 5, 0),
	(143, 64, 4, 0),
	(144, 65, 2, 0),
	(145, 66, 2, 0),
	(146, 67, 2, 0),
	(147, 68, 3, 0),
	(148, 69, 4, 0),
	(149, 70, 2, 0),
	(150, 71, 4, 0),
	(151, 72, 2, 0),
	(152, 73, 2, 0),
	(153, 74, 2, 0),
	(154, 75, 2, 0),
	(155, 76, 2, 0),
	(156, 77, 4, 0),
	(157, 78, 123, 0),
	(158, 79, 4, 0),
	(159, 80, 4, 0),
	(160, 81, 5, 0),
	(161, 82, 3, 0),
	(162, 83, 3, 0),
	(163, 84, 5, 0),
	(164, 85, 4, 0),
	(165, 86, 4, 0),
	(166, 87, 4, 0),
	(167, 88, 3, 0),
	(168, 89, 3, 0),
	(169, 90, 4, 0),
	(170, 91, 4, 0),
	(171, 92, 321321, 0),
	(172, 93, 5, 0),
	(173, 94, 6, 0),
	(174, 95, 2, 0),
	(175, 96, 4, 0),
	(176, 97, 3, 0),
	(177, 98, 4, 0),
	(178, 99, 2, 0),
	(179, 100, 3, 0),
	(180, 100, 4, 0),
	(181, 101, 4, 0),
	(182, 101, 1231232, 0);
/*!40000 ALTER TABLE `delivered_items` ENABLE KEYS */;


-- Dumping structure for table fixnmix.deliveries
CREATE TABLE IF NOT EXISTS `deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `delivered_items_branch_id_to_branches_id` (`branch_id`),
  CONSTRAINT `delivered_items_branch_id_to_branches_id` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.deliveries: ~101 rows (approximately)
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;
INSERT INTO `deliveries` (`id`, `branch_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'KAB001', 1, '2015-05-29 12:22:10', '2015-05-29 12:22:10'),
	(2, 'KAB001', 1, '2015-05-29 12:22:12', '2015-05-29 12:22:12'),
	(3, 'KAB001', 1, '2015-05-29 12:25:51', '2015-05-29 12:25:51'),
	(4, 'KAB001', 1, '2015-05-29 14:06:01', '2015-05-29 14:06:01'),
	(5, 'KAB001', 1, '2015-05-29 14:06:15', '2015-05-29 14:06:15'),
	(6, 'KAB001', NULL, '2015-05-29 14:12:40', '2015-05-29 14:12:40'),
	(7, 'KAB001', NULL, '2015-05-29 14:14:23', '2015-05-29 14:14:23'),
	(8, 'KAB001', NULL, '2015-05-29 14:16:58', '2015-05-29 14:16:58'),
	(9, 'KAB001', 1, '2015-05-29 14:21:20', '2015-05-29 14:21:20'),
	(10, 'KAB001', NULL, '2015-05-29 14:22:46', '2015-05-29 14:22:46'),
	(11, 'KAB001', NULL, '2015-05-29 14:23:21', '2015-05-29 14:23:21'),
	(12, 'KAB001', NULL, '2015-05-29 14:24:07', '2015-05-29 14:24:07'),
	(13, 'KAB001', NULL, '2015-05-29 14:24:34', '2015-05-29 14:24:34'),
	(14, 'KAB001', NULL, '2015-05-29 14:25:59', '2015-05-29 14:25:59'),
	(15, 'KAB001', NULL, '2015-05-30 10:05:59', '2015-05-30 10:05:59'),
	(16, 'KAB001', NULL, '2015-05-30 10:06:32', '2015-05-30 10:06:32'),
	(17, 'KAB001', NULL, '2015-05-30 10:07:24', '2015-05-30 10:07:24'),
	(18, 'KAB001', NULL, '2015-05-30 16:34:46', '2015-05-30 16:34:46'),
	(19, 'KAB001', NULL, '2015-05-30 16:34:56', '2015-05-30 16:34:56'),
	(20, 'KAB003', NULL, '2015-05-30 16:34:56', '2015-05-30 16:34:56'),
	(21, 'KAB001', NULL, '2015-05-30 16:35:08', '2015-05-30 16:35:08'),
	(22, 'KAB002', NULL, '2015-05-30 16:35:08', '2015-05-30 16:35:08'),
	(23, 'KAB003', NULL, '2015-05-30 16:35:09', '2015-05-30 16:35:09'),
	(24, 'KAB001', NULL, '2015-05-30 18:45:37', '2015-05-30 18:45:37'),
	(25, 'KAB001', NULL, '2015-05-30 19:02:22', '2015-05-30 19:02:22'),
	(26, 'KAB001', NULL, '2015-05-30 19:03:42', '2015-05-30 19:03:42'),
	(27, 'KAB001', NULL, '2015-05-30 19:03:52', '2015-05-30 19:03:52'),
	(28, 'KAB003', NULL, '2015-05-30 19:03:52', '2015-05-30 19:03:52'),
	(29, 'KAB002', NULL, '2015-05-30 19:33:42', '2015-05-30 19:33:42'),
	(30, 'KAB003', NULL, '2015-05-30 19:33:42', '2015-05-30 19:33:42'),
	(31, 'KAB002', NULL, '2015-05-30 19:34:33', '2015-05-30 19:34:33'),
	(32, 'KAB003', NULL, '2015-05-30 19:34:33', '2015-05-30 19:34:33'),
	(33, 'KAB003', NULL, '2015-05-30 19:34:37', '2015-05-30 19:34:37'),
	(34, 'KAB002', NULL, '2015-05-30 19:34:38', '2015-05-30 19:34:38'),
	(35, 'KAB001', NULL, '2015-05-30 19:34:46', '2015-05-30 19:34:46'),
	(36, 'KAB001', NULL, '2015-05-30 19:34:51', '2015-05-30 19:34:51'),
	(37, 'KAB003', NULL, '2015-05-30 19:34:51', '2015-05-30 19:34:51'),
	(38, 'KAB003', NULL, '2015-05-30 19:35:16', '2015-05-30 19:35:16'),
	(39, 'KAB001', NULL, '2015-05-30 19:35:16', '2015-05-30 19:35:16'),
	(40, 'KAB001', NULL, '2015-05-30 19:36:08', '2015-05-30 19:36:08'),
	(41, 'KAB003', NULL, '2015-05-30 19:36:08', '2015-05-30 19:36:08'),
	(42, 'KAB001', NULL, '2015-05-30 19:36:55', '2015-05-30 19:36:55'),
	(43, 'KAB003', NULL, '2015-05-30 19:36:55', '2015-05-30 19:36:55'),
	(44, 'KAB001', NULL, '2015-05-30 19:37:06', '2015-05-30 19:37:06'),
	(45, 'KAB003', NULL, '2015-05-30 19:37:06', '2015-05-30 19:37:06'),
	(46, 'KAB001', NULL, '2015-05-30 19:38:06', '2015-05-30 19:38:06'),
	(47, 'KAB003', NULL, '2015-05-30 19:38:06', '2015-05-30 19:38:06'),
	(48, 'KAB003', NULL, '2015-05-30 19:38:52', '2015-05-30 19:38:52'),
	(49, 'KAB001', NULL, '2015-05-30 19:38:52', '2015-05-30 19:38:52'),
	(50, 'KAB001', 1, '2015-05-31 08:45:06', '2015-05-31 08:45:07'),
	(51, 'KAB001', 1, '2015-05-31 08:45:14', '2015-05-31 08:45:14'),
	(52, 'KAB003', 0, '2015-05-31 09:17:21', '2015-05-31 09:17:21'),
	(53, 'KAB001', 0, '2015-05-31 09:17:21', '2015-05-31 09:17:21'),
	(54, 'KAB001', 0, '2015-05-31 09:17:28', '2015-05-31 09:17:28'),
	(55, 'KAB003', 0, '2015-05-31 09:17:28', '2015-05-31 09:17:28'),
	(56, 'KAB002', 0, '2015-05-31 09:29:57', '2015-05-31 09:29:57'),
	(57, 'KAB001', 0, '2015-05-31 09:41:03', '2015-05-31 09:41:03'),
	(58, 'KAB001', 0, '2015-05-31 09:43:35', '2015-05-31 09:43:35'),
	(59, 'KAB001', 0, '2015-05-31 09:44:52', '2015-05-31 09:44:52'),
	(60, 'KAB001', 0, '2015-05-31 09:45:36', '2015-05-31 09:45:36'),
	(61, 'KAB001', 0, '2015-05-31 09:46:05', '2015-05-31 09:46:05'),
	(62, 'KAB001', 0, '2015-05-31 09:47:25', '2015-05-31 09:47:25'),
	(63, 'KAB001', 0, '2015-05-31 09:47:40', '2015-05-31 09:47:40'),
	(64, 'KAB001', 0, '2015-05-31 09:48:06', '2015-05-31 09:48:06'),
	(65, 'KAB001', 0, '2015-05-31 09:48:24', '2015-05-31 09:48:24'),
	(66, 'KAB001', 0, '2015-05-31 09:48:58', '2015-05-31 09:48:58'),
	(67, 'KAB001', 0, '2015-05-31 09:49:27', '2015-05-31 09:49:27'),
	(68, 'KAB001', 0, '2015-05-31 09:50:40', '2015-05-31 09:50:40'),
	(69, 'KAB001', 0, '2015-05-31 09:53:08', '2015-05-31 09:53:08'),
	(70, 'KAB001', 0, '2015-05-31 09:53:46', '2015-05-31 09:53:46'),
	(71, 'KAB001', 0, '2015-05-31 09:54:37', '2015-05-31 09:54:37'),
	(72, 'KAB001', 0, '2015-05-31 09:54:54', '2015-05-31 09:54:54'),
	(73, 'KAB001', 0, '2015-05-31 09:55:20', '2015-05-31 09:55:20'),
	(74, 'KAB001', 0, '2015-05-31 09:58:09', '2015-05-31 09:58:09'),
	(75, 'KAB001', 0, '2015-05-31 09:59:09', '2015-05-31 09:59:09'),
	(76, 'KAB001', 0, '2015-05-31 09:59:37', '2015-05-31 09:59:37'),
	(77, 'KAB001', 0, '2015-05-31 10:00:02', '2015-05-31 10:00:02'),
	(78, 'KAB001', 0, '2015-05-31 10:07:09', '2015-05-31 10:07:09'),
	(79, 'KAB001', 0, '2015-05-31 10:07:49', '2015-05-31 10:07:49'),
	(80, 'KAB002', 0, '2015-05-31 10:08:05', '2015-05-31 10:08:05'),
	(81, 'KAB001', 0, '2015-05-31 10:08:46', '2015-05-31 10:08:46'),
	(82, 'KAB001', 0, '2015-05-31 10:10:48', '2015-05-31 10:10:48'),
	(83, 'KAB001', 0, '2015-05-31 10:11:04', '2015-05-31 10:11:04'),
	(84, 'KAB001', 0, '2015-05-31 10:11:56', '2015-05-31 10:11:56'),
	(85, 'KAB001', 1, '2015-05-31 10:14:21', '2015-05-31 10:14:21'),
	(86, 'KAB001', 1, '2015-05-31 10:17:14', '2015-05-31 10:17:14'),
	(87, 'KAB001', 0, '2015-05-31 10:18:26', '2015-05-31 10:18:26'),
	(88, 'KAB002', 0, '2015-05-31 10:20:15', '2015-05-31 10:20:15'),
	(89, 'KAB001', 0, '2015-05-31 10:28:03', '2015-05-31 10:28:03'),
	(90, 'KAB001', 0, '2015-05-31 10:28:21', '2015-05-31 10:28:21'),
	(91, 'KAB001', 0, '2015-05-31 10:29:10', '2015-05-31 10:29:10'),
	(92, 'KAB001', 0, '2015-05-31 10:30:26', '2015-05-31 10:30:26'),
	(93, 'KAB001', 0, '2015-05-31 10:30:43', '2015-05-31 10:30:43'),
	(94, 'KAB001', 1, '2015-05-31 10:31:08', '2015-05-31 10:31:08'),
	(95, 'KAB002', 1, '2015-05-31 10:53:19', '2015-05-31 10:53:19'),
	(96, 'KAB001', 1, '2015-05-31 11:32:51', '2015-05-31 11:32:51'),
	(97, 'KAB002', 1, '2015-05-31 12:26:04', '2015-05-31 12:26:04'),
	(98, 'KAB001', 1, '2015-05-31 13:28:55', '2015-05-31 13:28:55'),
	(99, 'KAB001', 1, '2015-05-31 13:29:15', '2015-05-31 13:29:15'),
	(100, 'KAB001', 1, '2015-06-01 14:41:06', '2015-06-01 14:41:06'),
	(101, 'KAB001', 1, '2015-06-02 09:08:20', '2015-06-02 09:08:20');
/*!40000 ALTER TABLE `deliveries` ENABLE KEYS */;


-- Dumping structure for table fixnmix.items
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.items: ~10 rows (approximately)
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` (`id`, `description`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
	(2, 'desc', '0', 100, '2015-05-27 10:06:14', '2015-05-31 13:29:15'),
	(3, 'asdasdasd', '0', 111, '2015-05-27 10:06:19', '2015-06-01 14:41:06'),
	(4, 'asdasdasdasd', '0', 1111, '2015-05-27 10:06:26', '2015-06-02 09:08:20'),
	(5, 'asdasdasd', '0', 111, '2015-05-27 10:06:31', '2015-05-31 10:30:43'),
	(6, 'asdasdasd', '0', 1, '2015-05-27 10:06:35', '2015-05-31 10:31:08'),
	(7, 'asdasdasdasd', '0', 11, '2015-05-27 10:06:40', '2015-05-27 10:06:40'),
	(123, '123123123', '0', 123123, '2015-05-27 10:06:01', '2015-05-31 10:07:09'),
	(1111, 'asdasdssss', '0', 111, '2015-05-31 11:45:05', '2015-05-31 11:45:05'),
	(321321, 'asdasdasd', '0', 11111, '2015-05-27 09:51:45', '2015-05-31 10:30:26'),
	(1231232, '1asdasdasdasd', '0', 11, '2015-05-28 12:11:03', '2015-06-02 09:08:20');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;


-- Dumping structure for table fixnmix.receipts
CREATE TABLE IF NOT EXISTS `receipts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` varchar(50) DEFAULT NULL,
  `receipt_id_from_branch` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `receipts_user_id_to_users_id` (`user_id`),
  KEY `receipts_branch_id_to_branches_id` (`branch_id`),
  CONSTRAINT `receipts_branch_id_to_branches_id` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `receipts_user_id_to_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.receipts: ~0 rows (approximately)
/*!40000 ALTER TABLE `receipts` DISABLE KEYS */;
/*!40000 ALTER TABLE `receipts` ENABLE KEYS */;


-- Dumping structure for table fixnmix.receipt_items
CREATE TABLE IF NOT EXISTS `receipt_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `receipt_id` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `receipt_items_item_id_to_items_id` (`item_id`),
  KEY `receipt_items_receipt_id_to_receipts_id` (`receipt_id`),
  CONSTRAINT `receipt_items_receipt_id_to_receipts_id` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `receipt_items_item_id_to_items_id` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.receipt_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `receipt_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `receipt_items` ENABLE KEYS */;


-- Dumping structure for table fixnmix.returned_items
CREATE TABLE IF NOT EXISTS `returned_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `return_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `returned_items_item_id_to_items_id` (`item_id`),
  KEY `returned_items_return_id_to_returns_id` (`return_id`),
  CONSTRAINT `returned_items_item_id_to_items_id` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `returned_items_return_id_to_returns_id` FOREIGN KEY (`return_id`) REFERENCES `returns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.returned_items: ~16 rows (approximately)
/*!40000 ALTER TABLE `returned_items` DISABLE KEYS */;
INSERT INTO `returned_items` (`id`, `return_id`, `item_id`, `quantity`) VALUES
	(17, 4, 2, 1),
	(18, 4, 3, 1),
	(19, 4, 4, 1),
	(20, 4, 5, 1),
	(21, 4, 6, 1),
	(22, 4, 2, 1),
	(23, 4, 3, 1),
	(24, 4, 4, 1),
	(25, 4, 5, 1),
	(26, 4, 6, 1),
	(28, 6, 2, 100),
	(29, 6, 3, 100),
	(30, 7, 2, 100),
	(31, 7, 3, 100),
	(32, 7, 2, 100),
	(33, 7, 3, 100);
/*!40000 ALTER TABLE `returned_items` ENABLE KEYS */;


-- Dumping structure for table fixnmix.returns
CREATE TABLE IF NOT EXISTS `returns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` varchar(50) DEFAULT NULL,
  `return_id_from_branch` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `returns_branch_id_to_branches_id` (`branch_id`),
  CONSTRAINT `returns_branch_id_to_branches_id` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.returns: ~4 rows (approximately)
/*!40000 ALTER TABLE `returns` DISABLE KEYS */;
INSERT INTO `returns` (`id`, `branch_id`, `return_id_from_branch`, `created_at`, `updated_at`) VALUES
	(4, 'KAB001', 10, '2015-05-28 16:25:21', '2015-05-28 16:25:21'),
	(5, 'KAB001', 1, '2015-05-31 13:59:42', '2015-05-31 13:59:42'),
	(6, 'KAB001', 2, '2015-05-31 14:02:18', '2015-05-31 14:02:18'),
	(7, 'KAB001', 3, '2015-05-31 14:03:30', '2015-05-31 14:03:30');
/*!40000 ALTER TABLE `returns` ENABLE KEYS */;


-- Dumping structure for table fixnmix.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `app_id` varchar(50) DEFAULT NULL,
  `default_save_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.settings: ~1 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`app_id`, `default_save_path`) VALUES
	('MAIN001', 'e:\\');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;


-- Dumping structure for table fixnmix.uncleared_items
CREATE TABLE IF NOT EXISTS `uncleared_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `branch_id` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uncleared_items_item_id_to_items_id` (`item_id`),
  KEY `branch_id_to_branches_id` (`branch_id`),
  CONSTRAINT `branch_id_to_branches_id` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.uncleared_items: ~18 rows (approximately)
/*!40000 ALTER TABLE `uncleared_items` DISABLE KEYS */;
INSERT INTO `uncleared_items` (`id`, `item_id`, `branch_id`, `quantity`, `created_at`, `updated_at`) VALUES
	(3, 4, 'KAB001', 9, '2015-05-28 22:23:35', '2015-06-02 09:08:20'),
	(4, 5, 'KAB001', 9, '2015-05-28 22:23:38', '2015-05-31 10:30:43'),
	(5, 6, 'KAB001', 9, '2015-05-28 22:23:40', '2015-05-31 10:31:08'),
	(6, 7, 'KAB001', 10, '2015-05-28 22:23:42', '2015-05-28 22:23:42'),
	(7, 2, 'KAB003', 0, '2015-05-30 16:34:56', '2015-05-30 19:36:08'),
	(8, 3, 'KAB003', 0, '2015-05-30 16:34:57', '2015-05-30 19:38:52'),
	(9, 4, 'KAB003', 0, '2015-05-30 16:34:57', '2015-05-31 09:17:28'),
	(10, 5, 'KAB003', 0, '2015-05-30 16:34:57', '2015-05-30 19:38:52'),
	(11, 2, 'KAB002', 0, '2015-05-30 16:35:08', '2015-05-31 10:53:19'),
	(12, 3, 'KAB002', 0, '2015-05-30 16:35:08', '2015-05-31 12:26:04'),
	(13, 4, 'KAB002', 0, '2015-05-30 16:35:09', '2015-05-31 10:08:06'),
	(14, 5, 'KAB002', 0, '2015-05-30 16:35:09', '2015-05-30 16:35:09'),
	(15, 6, 'KAB003', 0, '2015-05-30 19:36:55', '2015-05-31 09:17:28'),
	(16, 123, 'KAB003', 0, '2015-05-31 09:17:21', '2015-05-31 09:17:29'),
	(17, 123, 'KAB001', 0, '2015-05-31 09:17:22', '2015-05-31 10:07:09'),
	(18, 321321, 'KAB001', 0, '2015-05-31 10:30:26', '2015-05-31 10:30:26'),
	(19, 3, 'KAB001', 0, '2015-06-01 14:41:06', '2015-06-01 14:41:06'),
	(20, 1231232, 'KAB001', 0, '2015-06-02 09:08:20', '2015-06-02 09:08:20');
/*!40000 ALTER TABLE `uncleared_items` ENABLE KEYS */;


-- Dumping structure for table fixnmix.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(120) DEFAULT NULL,
  `user_level_id` int(11) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_user_level_id_to_user_levels_id` (`user_level_id`),
  CONSTRAINT `users_user_level_id_to_user_levels_id` FOREIGN KEY (`user_level_id`) REFERENCES `user_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.users: ~7 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `user_level_id`, `last_name`, `first_name`, `middle_name`, `created_at`, `updated_at`) VALUES
	(1, 'asd', 'asd', 1, 'Felipe', 'Jan Ryan', 'Malicay', '2015-05-04 21:39:28', '2015-05-04 21:39:30'),
	(2, '123', '123', 2, 'Gwapo', 'Si', 'Ryan', '2015-05-04 21:56:22', '2015-05-04 21:56:23'),
	(3, 'ryanskie', 'ryanskie', 2, 'Felipe', 'jan Ryan', 'malicat', '2015-05-14 06:46:32', '2015-05-14 06:46:33'),
	(4, 'klklklkl', 'klklklkl', 2, 'lklkl', 'klklk', 'lklkl', '2015-05-14 06:46:50', '2015-05-14 06:46:50'),
	(5, 'ssssssss', 'ssssssss', 2, 'sss', 'sss', 'sss', '2015-05-19 11:17:47', '2015-05-19 11:17:47'),
	(6, 'asdasdasd', 'asdasdasd', 2, '44', '44', '44', '2015-06-01 20:07:25', '2015-06-01 20:07:25'),
	(7, 'dsadsadsa', 'dsadsadsa', 1, 'dsadsadsa', 'dsadsadsa', 'dsadsadsa', '2015-06-01 20:08:17', '2015-06-01 20:08:17');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table fixnmix.user_levels
CREATE TABLE IF NOT EXISTS `user_levels` (
  `id` int(11) NOT NULL,
  `user_level` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.user_levels: ~2 rows (approximately)
/*!40000 ALTER TABLE `user_levels` DISABLE KEYS */;
INSERT INTO `user_levels` (`id`, `user_level`) VALUES
	(1, 'Administrator'),
	(2, 'Cashier');
/*!40000 ALTER TABLE `user_levels` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
