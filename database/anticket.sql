-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table anticket.chats
CREATE TABLE IF NOT EXISTS `chats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ticket_id` int NOT NULL,
  `user_id` int NOT NULL,
  `is_read` enum('y','n') DEFAULT 'n',
  `is_read_user` enum('y','n') DEFAULT 'n',
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_ticket_chats` (`ticket_id`),
  KEY `fk_user_chats` (`user_id`),
  CONSTRAINT `fk_ticket_chats` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  CONSTRAINT `fk_user_chats` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table anticket.chats: ~0 rows (approximately)

-- Dumping structure for table anticket.documents
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ticket_id` int NOT NULL,
  `name_file` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_ticket_documents` (`ticket_id`),
  CONSTRAINT `fk_ticket_documents` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table anticket.documents: ~0 rows (approximately)

-- Dumping structure for procedure anticket.migrationAll
DELIMITER //
CREATE PROCEDURE `migrationAll`()
BEGIN 

	CREATE TABLE users (
	   id INT AUTO_INCREMENT PRIMARY KEY,
	   name VARCHAR(50) NOT NULL,
	   nik VARCHAR(25) NOT NULL UNIQUE,
	   role ENUM('worker', 'admin', 'supervisor', 'root') NOT NULL DEFAULT 'worker',
	   id_chat_telegram VARCHAR(255) NULL,
	   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	   updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	);

	CREATE TABLE systems (
		id INT AUTO_INCREMENT PRIMARY KEY,
		user_id INT NOT NULL,
		name VARCHAR(128) NOT NULL,
		status ENUM('listing','in progress','trial','golive') NOT NULL DEFAULT 'listing',
		dept VARCHAR(50) NOT NULL, 
		pic_name VARCHAR(50) NULL,
		pic_nik VARCHAR(25) NULL,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		CONSTRAINT fk_user_systems FOREIGN KEY (user_id) REFERENCES users(id)
	);
	
	CREATE TABLE tickets (
		id INT AUTO_INCREMENT PRIMARY KEY,
		system_id INT NOT NULL,
		no_ticket VARCHAR(50) NOT NULL UNIQUE,
		category ENUM('system','bug','feature','meeting') NOT NULL,
		urls VARCHAR(255) NULL,
		priority ENUM('hight','medium','low') NOT NULL DEFAULT 'low',
		status ENUM('waiting approval','approved','on progress','done','closed','reject'),
		description TEXT NOT NULL,
		deadline DATE NOT NULL,
		requestor_name VARCHAR(50) NOT NULL,
		requestor_nik VARCHAR(25) NOT NULL,
		requested_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		in_progress_name VARCHAR(50) NULL,
		in_progress_nik VARCHAR(25) NULL,
		in_progress_at TIMESTAMP NULL,
		done_name VARCHAR(50) NULL,
		done_nik VARCHAR(25) NULL,
		done_at TIMESTAMP NULL,
		closed_name VARCHAR(50) NULL,
		closed_nik VARCHAR(25) NULL,
		closed_at TIMESTAMP NULL,
		approve_name VARCHAR(50) NULL,
		approve_nik VARCHAR(25) NULL,
		approve_at TIMESTAMP NULL,
		reject_name VARCHAR(50) NULL,
		reject_nik VARCHAR(25) NULL,
		reject_at TIMESTAMP NULL,
		reject_reason TEXT NULL,
		date_meeting TIMESTAMP NULL,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		CONSTRAINT fk_system_tickets FOREIGN KEY (system_id) REFERENCES systems(id)
	);
	
	CREATE TABLE documents (
		id INT AUTO_INCREMENT PRIMARY KEY,
		ticket_id INT NOT NULL,
		name_file VARCHAR(255) NOT NULL,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		CONSTRAINT fk_ticket_documents FOREIGN KEY(ticket_id) REFERENCES tickets(id)
	);
	
	CREATE TABLE chats (
		id INT AUTO_INCREMENT PRIMARY KEY,
		ticket_id INT NOT NULL,
		user_id INT NOT NULL,
		is_read ENUM('y','n') DEFAULT 'n',
		is_read_user ENUM('y','n') DEFAULT 'n',
		message TEXT NOT NULL,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		CONSTRAINT fk_ticket_chats FOREIGN KEY (ticket_id) REFERENCES tickets(id),
		CONSTRAINT fk_user_chats FOREIGN KEY (user_id) REFERENCES users(id)
	);

END//
DELIMITER ;

-- Dumping structure for table anticket.systems
CREATE TABLE IF NOT EXISTS `systems` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(128) NOT NULL,
  `status` enum('listing','in progress','trial','golive') NOT NULL DEFAULT 'listing',
  `dept` varchar(50) NOT NULL,
  `pic_name` varchar(50) DEFAULT NULL,
  `pic_nik` varchar(25) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user_systems` (`user_id`),
  CONSTRAINT `fk_user_systems` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table anticket.systems: ~0 rows (approximately)

-- Dumping structure for table anticket.tickets
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `system_id` int NOT NULL,
  `no_ticket` varchar(50) NOT NULL,
  `category` enum('system','bug','feature','meeting') NOT NULL,
  `urls` varchar(255) DEFAULT NULL,
  `priority` enum('hight','medium','low') NOT NULL DEFAULT 'low',
  `status` enum('waiting approval','approved','on progress','done','closed','reject') DEFAULT NULL,
  `description` text NOT NULL,
  `deadline` date NOT NULL,
  `requestor_name` varchar(50) NOT NULL,
  `requestor_nik` varchar(25) NOT NULL,
  `requested_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `in_progress_name` varchar(50) DEFAULT NULL,
  `in_progress_nik` varchar(25) DEFAULT NULL,
  `in_progress_at` timestamp NULL DEFAULT NULL,
  `done_name` varchar(50) DEFAULT NULL,
  `done_nik` varchar(25) DEFAULT NULL,
  `done_at` timestamp NULL DEFAULT NULL,
  `closed_name` varchar(50) DEFAULT NULL,
  `closed_nik` varchar(25) DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `approve_name` varchar(50) DEFAULT NULL,
  `approve_nik` varchar(25) DEFAULT NULL,
  `approve_at` timestamp NULL DEFAULT NULL,
  `reject_name` varchar(50) DEFAULT NULL,
  `reject_nik` varchar(25) DEFAULT NULL,
  `reject_at` timestamp NULL DEFAULT NULL,
  `reject_reason` text,
  `date_meeting` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_ticket` (`no_ticket`),
  KEY `fk_system_tickets` (`system_id`),
  CONSTRAINT `fk_system_tickets` FOREIGN KEY (`system_id`) REFERENCES `systems` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table anticket.tickets: ~0 rows (approximately)

-- Dumping structure for table anticket.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `nik` varchar(25) NOT NULL,
  `role` enum('worker','admin','supervisor','root') NOT NULL DEFAULT 'worker',
  `id_chat_telegram` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nik` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table anticket.users: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
