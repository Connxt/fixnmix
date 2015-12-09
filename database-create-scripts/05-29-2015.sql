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

-- Dumping data for table fixnmix.branches: ~3 rows (approximately)
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` (`id`, `description`) VALUES
	('KAB001', 'first branch in kabankalan'),
	('KAB002', 'second branch in kabankalan'),
	('KAB003', 'third branch in kabankalan');
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.delivered_items: ~6 rows (approximately)
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
	(17, 14, 2, 0);
/*!40000 ALTER TABLE `delivered_items` ENABLE KEYS */;


-- Dumping structure for table fixnmix.deliveries
CREATE TABLE IF NOT EXISTS `deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `delivered_items_branch_id_to_branches_id` (`branch_id`),
  CONSTRAINT `delivered_items_branch_id_to_branches_id` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.deliveries: ~3 rows (approximately)
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;
INSERT INTO `deliveries` (`id`, `branch_id`, `created_at`, `updated_at`) VALUES
	(1, 'KAB001', '2015-05-29 12:22:10', '2015-05-29 12:22:10'),
	(2, 'KAB001', '2015-05-29 12:22:12', '2015-05-29 12:22:12'),
	(3, 'KAB001', '2015-05-29 12:25:51', '2015-05-29 12:25:51'),
	(4, 'KAB001', '2015-05-29 14:06:01', '2015-05-29 14:06:01'),
	(5, 'KAB001', '2015-05-29 14:06:15', '2015-05-29 14:06:15'),
	(6, 'KAB001', '2015-05-29 14:12:40', '2015-05-29 14:12:40'),
	(7, 'KAB001', '2015-05-29 14:14:23', '2015-05-29 14:14:23'),
	(8, 'KAB001', '2015-05-29 14:16:58', '2015-05-29 14:16:58'),
	(9, 'KAB001', '2015-05-29 14:21:20', '2015-05-29 14:21:20'),
	(10, 'KAB001', '2015-05-29 14:22:46', '2015-05-29 14:22:46'),
	(11, 'KAB001', '2015-05-29 14:23:21', '2015-05-29 14:23:21'),
	(12, 'KAB001', '2015-05-29 14:24:07', '2015-05-29 14:24:07'),
	(13, 'KAB001', '2015-05-29 14:24:34', '2015-05-29 14:24:34'),
	(14, 'KAB001', '2015-05-29 14:25:59', '2015-05-29 14:25:59');
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

-- Dumping data for table fixnmix.items: ~9 rows (approximately)
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` (`id`, `description`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
	(2, 'asdasdasd', '0', 123123123, '2015-05-27 10:06:14', '2015-05-29 14:25:59'),
	(3, 'asdasdasd', '0', 111, '2015-05-27 10:06:19', '2015-05-29 12:25:51'),
	(4, 'asdasdasdasd', '0', 1111, '2015-05-27 10:06:26', '2015-05-27 10:06:26'),
	(5, 'asdasdasd', '0', 111, '2015-05-27 10:06:31', '2015-05-27 10:06:31'),
	(6, 'asdasdasd', '0', 1, '2015-05-27 10:06:35', '2015-05-27 10:06:35'),
	(7, 'asdasdasdasd', '0', 11, '2015-05-27 10:06:40', '2015-05-27 10:06:40'),
	(123, '123123123', '0', 123123, '2015-05-27 10:06:01', '2015-05-27 10:06:01'),
	(321321, 'asdasdasd', '0', 11111, '2015-05-27 09:51:45', '2015-05-27 09:51:45'),
	(1231232, '1asdasdasdasd', '0', 11, '2015-05-28 12:11:03', '2015-05-28 12:11:03');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.returned_items: ~10 rows (approximately)
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
	(26, 4, 6, 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.returns: ~1 rows (approximately)
/*!40000 ALTER TABLE `returns` DISABLE KEYS */;
INSERT INTO `returns` (`id`, `branch_id`, `return_id_from_branch`, `created_at`, `updated_at`) VALUES
	(4, 'KAB001', 10, '2015-05-28 16:25:21', '2015-05-28 16:25:21');
/*!40000 ALTER TABLE `returns` ENABLE KEYS */;


-- Dumping structure for table fixnmix.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `app_id` varchar(50) DEFAULT NULL,
  `default_save_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.settings: ~0 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`app_id`, `default_save_path`) VALUES
	('MAIN001', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.uncleared_items: ~6 rows (approximately)
/*!40000 ALTER TABLE `uncleared_items` DISABLE KEYS */;
INSERT INTO `uncleared_items` (`id`, `item_id`, `branch_id`, `quantity`, `created_at`, `updated_at`) VALUES
	(1, 2, 'KAB001', 9, '2015-05-28 22:21:23', '2015-05-29 14:25:59'),
	(2, 3, 'KAB001', 9, '2015-05-28 22:23:33', '2015-05-29 12:25:51'),
	(3, 4, 'KAB001', 9, '2015-05-28 22:23:35', '2015-05-28 16:25:22'),
	(4, 5, 'KAB001', 9, '2015-05-28 22:23:38', '2015-05-28 16:25:22'),
	(5, 6, 'KAB001', 9, '2015-05-28 22:23:40', '2015-05-28 16:25:22'),
	(6, 7, 'KAB001', 10, '2015-05-28 22:23:42', '2015-05-28 22:23:42');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.users: ~5 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `user_level_id`, `last_name`, `first_name`, `middle_name`, `created_at`, `updated_at`) VALUES
	(1, 'asd', 'asd', 1, 'Felipe', 'Jan Ryan', 'Malicay', '2015-05-04 21:39:28', '2015-05-04 21:39:30'),
	(2, '123', '123', 2, 'Gwapo', 'Si', 'Ryan', '2015-05-04 21:56:22', '2015-05-04 21:56:23'),
	(3, 'ryanskie', 'ryanskie', 2, 'Felipe', 'jan Ryan', 'malicat', '2015-05-14 06:46:32', '2015-05-14 06:46:33'),
	(4, 'klklklkl', 'klklklkl', 2, 'lklkl', 'klklk', 'lklkl', '2015-05-14 06:46:50', '2015-05-14 06:46:50'),
	(5, 'ssssssss', 'ssssssss', 2, 'sss', 'sss', 'sss', '2015-05-19 11:17:47', '2015-05-19 11:17:47');
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
