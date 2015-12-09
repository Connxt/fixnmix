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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.delivered_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `delivered_items` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.deliveries: ~0 rows (approximately)
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;
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

-- Dumping data for table fixnmix.items: ~4 rows (approximately)
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` (`id`, `description`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
	(1, 'yes', '17', 50, '2015-04-30 00:00:00', '2015-05-12 05:19:31'),
	(2, 'description', '0', 100, '2015-05-04 18:57:44', '2015-05-04 18:57:44'),
	(3, 'description', '0', 100, '2015-05-04 18:59:06', '2015-05-04 18:59:06'),
	(1992, 'yes', '23', 200, '2015-05-08 13:38:02', '2015-05-08 13:40:32');
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.returned_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `returned_items` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.returns: ~0 rows (approximately)
/*!40000 ALTER TABLE `returns` DISABLE KEYS */;
/*!40000 ALTER TABLE `returns` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table fixnmix.uncleared_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `uncleared_items` DISABLE KEYS */;
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
