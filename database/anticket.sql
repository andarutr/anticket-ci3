-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for anticket
CREATE DATABASE IF NOT EXISTS `anticket` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `anticket`;

-- Dumping structure for procedure anticket.migrationAll
DELIMITER //
CREATE PROCEDURE `migrationAll`()
BEGIN 

	CREATE TABLE users (
	   id INT AUTO_INCREMENT PRIMARY KEY,
	   name VARCHAR(50) NOT NULL,
	   nik VARCHAR(25) NOT NULL UNIQUE,
	   email VARCHAR(50) NOT NULL UNIQUE,
	   password VARCHAR(255) NOT NULL,
	   role ENUM('user','worker', 'admin', 'supervisor', 'root') NOT NULL DEFAULT 'worker',
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
		priority ENUM('high','medium','low') NOT NULL DEFAULT 'low',
		status ENUM('waiting approval','approved','assigned','on progress','done','closed','reject'),
		description TEXT NOT NULL,
		deadline DATE NULL,
		requestor_name VARCHAR(50) NOT NULL,
		requestor_nik VARCHAR(25) NOT NULL,
		requested_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		developer_name VARCHAR(50) NULL,
		developer_nik VARCHAR(50) NULL,
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

-- Dumping structure for procedure anticket.seedUser
DELIMITER //
CREATE PROCEDURE `seedUser`()
BEGIN

	INSERT INTO users (name, nik, email, role, password, created_at, updated_at)
	VALUES ('Root', 12345, 'root@example.com', 'root', '$2a$12$wdoEDXA7bol1FXBHcQS3X.bGFl3Iz6zob8edEpdIGkJvL3f9IvD6m', NOW(), NOW());

	INSERT INTO users (name, nik, email, role, password, created_at, updated_at)
	VALUES ('Worker', 67891, 'worker@example.com', 'worker', '$2a$12$wdoEDXA7bol1FXBHcQS3X.bGFl3Iz6zob8edEpdIGkJvL3f9IvD6m', NOW(), NOW());

	INSERT INTO users (name, nik, email, role, password, created_at, updated_at)
	VALUES ('Admin', 78910, 'admin@example.com', 'admin', '$2a$12$wdoEDXA7bol1FXBHcQS3X.bGFl3Iz6zob8edEpdIGkJvL3f9IvD6m', NOW(), NOW());
	
	INSERT INTO users (name, nik, email, role, password, created_at, updated_at)
	VALUES ('Supervisor', 89101, 'supervisor@example.com', 'supervisor', '$2a$12$wdoEDXA7bol1FXBHcQS3X.bGFl3Iz6zob8edEpdIGkJvL3f9IvD6m', NOW(), NOW());
	
	INSERT INTO users (name, nik, email, role, password, created_at, updated_at)
	VALUES ('User', 91011, 'user@example.com', 'user', '$2a$12$wdoEDXA7bol1FXBHcQS3X.bGFl3Iz6zob8edEpdIGkJvL3f9IvD6m', NOW(), NOW());
	
END//
DELIMITER ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
