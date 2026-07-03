-- =====================================================
-- Database: IPsDB
-- Version: 2.2 (Combined Complete Database)
-- Date: 2025
-- Description: Complete database schema including all tables
--              including registration_requests table
-- =====================================================

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- =====================================================
-- CORE SYSTEM TABLES
-- =====================================================

--
-- Table structure for table `activity_log`
--
CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL DEFAULT 'none',
  `date` varchar(255) NOT NULL DEFAULT 'none',
  `status` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `IPs_information`
--
CREATE TABLE `IPs_information` (
  `id` varchar(255) NOT NULL,
  `IPs` varchar(255) NOT NULL DEFAULT 'none',
  `zone` varchar(255) NOT NULL DEFAULT 'none',
  `district` varchar(255) NOT NULL DEFAULT 'none',
  `address` varchar(255) NOT NULL DEFAULT 'none',
  `postal_address` varchar(255) NOT NULL DEFAULT 'none',
  `image` varchar(255) NOT NULL DEFAULT 'none',
  `image_path` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `a_i` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT 'none',
  `middle_name` varchar(255) NOT NULL DEFAULT 'none',
  `last_name` varchar(255) NOT NULL DEFAULT 'none',
  `username` varchar(255) NOT NULL DEFAULT 'none',
  `password` varchar(255) NOT NULL DEFAULT 'none',
  `user_type` varchar(255) NOT NULL DEFAULT 'none',
  `contact_number` varchar(255) NOT NULL DEFAULT 'none',
  `email` varchar(255) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(255) NOT NULL DEFAULT 'none',
  `image_path` varchar(255) NOT NULL DEFAULT 'none',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`a_i`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- RESIDENCE MANAGEMENT TABLES
-- =====================================================

--
-- Table structure for table `residence_information`
--
CREATE TABLE `residence_information` (
  `a_i` int(11) NOT NULL AUTO_INCREMENT,
  `residence_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT 'none',
  `middle_name` varchar(255) NOT NULL DEFAULT 'none',
  `last_name` varchar(255) NOT NULL DEFAULT 'none',
  `age` varchar(11) NOT NULL,
  `suffix` varchar(255) NOT NULL DEFAULT 'none',
  `alias` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL DEFAULT 'none',
  `civil_status` varchar(255) NOT NULL DEFAULT 'none',
  `religion` varchar(255) NOT NULL DEFAULT 'none',
  `nationality` varchar(255) NOT NULL DEFAULT 'none',
  `tribe` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) NOT NULL DEFAULT 'none',
  `email_address` varchar(255) NOT NULL DEFAULT 'none',
  `address` varchar(255) NOT NULL DEFAULT 'none',
  `birth_date` varchar(255) NOT NULL DEFAULT 'none',
  `birth_place` varchar(255) NOT NULL DEFAULT 'none',
  `municipality` varchar(255) NOT NULL DEFAULT 'none',
  `zip` varchar(255) NOT NULL DEFAULT 'none',
  `IPs` varchar(255) NOT NULL DEFAULT 'none',
  `house_number` varchar(255) NOT NULL DEFAULT 'none',
  `street` varchar(255) NOT NULL DEFAULT 'none',
  `fathers_name` varchar(255) NOT NULL DEFAULT 'none',
  `mothers_name` varchar(255) NOT NULL DEFAULT 'none',
  `guardian` varchar(255) NOT NULL DEFAULT 'none',
  `guardian_contact` varchar(255) NOT NULL DEFAULT 'none',
  `image` varchar(255) NOT NULL DEFAULT 'none',
  `image_path` varchar(255) NOT NULL DEFAULT 'none',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`a_i`),
  UNIQUE KEY `residence_id` (`residence_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `residence_status`
--
CREATE TABLE `residence_status` (
  `a_i` int(11) NOT NULL AUTO_INCREMENT,
  `residence_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'none',
  `is_approved` varchar(255) NOT NULL,
  `voters` varchar(255) NOT NULL DEFAULT 'none',
  `pwd` varchar(255) NOT NULL DEFAULT 'none',
  `pwd_info` varchar(255) NOT NULL DEFAULT 'none',
  `senior` varchar(255) NOT NULL DEFAULT 'none',
  `single_parent` varchar(255) NOT NULL DEFAULT 'none',
  `archive` varchar(255) NOT NULL DEFAULT 'none',
  `date_added` varchar(255) NOT NULL DEFAULT 'none',
  `date_archive` varchar(255) NOT NULL DEFAULT 'none',
  `date_unarchive` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`a_i`),
  KEY `residence_id` (`residence_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `registration_requests`
--
CREATE TABLE IF NOT EXISTS `registration_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` varchar(10) DEFAULT NULL,
  `tribe` varchar(255) DEFAULT NULL,
  `gender` varchar(50) NOT NULL,
  `civil_status` varchar(50) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `birth_place` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `IPs` varchar(255) DEFAULT NULL,
  `house_number` varchar(50) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `fathers_name` varchar(255) DEFAULT NULL,
  `mothers_name` varchar(255) DEFAULT NULL,
  `guardian` varchar(255) DEFAULT NULL,
  `guardian_contact` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `voters` varchar(10) DEFAULT NULL,
  `pwd` varchar(10) DEFAULT NULL,
  `pwd_info` varchar(255) DEFAULT NULL,
  `single_parent` varchar(10) DEFAULT NULL,
  `senior` varchar(10) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `date_requested` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_processed` datetime DEFAULT NULL,
  `processed_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `request_id` (`request_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- OFFICIAL MANAGEMENT TABLES
-- =====================================================

--
-- Table structure for table `official_information`
--
CREATE TABLE `official_information` (
  `a_i` int(11) NOT NULL AUTO_INCREMENT,
  `official_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT 'none',
  `middle_name` varchar(255) NOT NULL DEFAULT 'none',
  `last_name` varchar(255) NOT NULL DEFAULT 'none',
  `suffix` varchar(255) NOT NULL DEFAULT 'none',
  `birth_date` varchar(255) NOT NULL DEFAULT 'none',
  `birth_place` varchar(255) NOT NULL DEFAULT 'none',
  `gender` varchar(255) NOT NULL DEFAULT 'none',
  `age` varchar(255) NOT NULL DEFAULT 'none',
  `civil_status` varchar(255) NOT NULL DEFAULT 'none',
  `religion` varchar(255) NOT NULL DEFAULT 'none',
  `nationality` varchar(255) NOT NULL DEFAULT 'none',
  `municipality` varchar(255) NOT NULL DEFAULT 'none',
  `zip` varchar(255) NOT NULL DEFAULT 'none',
  `IPs` varchar(255) NOT NULL DEFAULT 'none',
  `house_number` varchar(255) NOT NULL DEFAULT 'none',
  `street` varchar(255) NOT NULL DEFAULT 'none',
  `address` varchar(255) NOT NULL DEFAULT 'none',
  `email_address` varchar(255) NOT NULL DEFAULT 'none',
  `contact_number` varchar(255) NOT NULL DEFAULT 'none',
  `fathers_name` varchar(255) NOT NULL DEFAULT 'none',
  `mothers_name` varchar(255) NOT NULL DEFAULT 'none',
  `guardian` varchar(255) NOT NULL DEFAULT 'none',
  `guardian_contact` varchar(255) NOT NULL DEFAULT 'none',
  `image` varchar(255) NOT NULL DEFAULT 'none',
  `image_path` varchar(255) NOT NULL DEFAULT 'none',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`a_i`),
  UNIQUE KEY `official_id` (`official_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `official_status`
--
CREATE TABLE `official_status` (
  `a_i` int(11) NOT NULL AUTO_INCREMENT,
  `official_id` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL DEFAULT 'none',
  `senior` varchar(255) NOT NULL DEFAULT 'none',
  `term_from` varchar(255) NOT NULL DEFAULT 'none',
  `term_to` varchar(255) NOT NULL DEFAULT 'none',
  `pwd` varchar(255) NOT NULL DEFAULT 'none',
  `pwd_info` varchar(255) NOT NULL DEFAULT 'none',
  `status` varchar(255) NOT NULL DEFAULT 'none',
  `voters` varchar(255) NOT NULL DEFAULT 'none',
  `single_parent` varchar(255) NOT NULL DEFAULT 'none',
  `date_added` varchar(255) NOT NULL DEFAULT 'none',
  `date_undeleted` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`a_i`),
  KEY `official_id` (`official_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- CERTIFICATE MANAGEMENT TABLES
-- =====================================================

--
-- Table structure for table `certificate_types`
--
CREATE TABLE `certificate_types` (
  `a_i` int(11) NOT NULL AUTO_INCREMENT,
  `certificate_type_id` varchar(255) NOT NULL,
  `certificate_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `validity_days` int(11) NOT NULL DEFAULT 365,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`a_i`),
  UNIQUE KEY `certificate_type_id` (`certificate_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `certificate_request`
--
CREATE TABLE `certificate_request` (
  `a_i` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(255) NOT NULL,
  `residence_id` varchar(255) NOT NULL,
  `certificate_type` varchar(255) NOT NULL DEFAULT 'none',
  `certificate_type_id` varchar(255) NOT NULL DEFAULT 'none',
  `certificate_name` varchar(255) NOT NULL DEFAULT 'none',
  `certificate_fee` decimal(10,2) DEFAULT 0.00,
  `certificate_validity_days` int(11) DEFAULT 365,
  `certificate_description` text DEFAULT NULL,
  `purpose` varchar(255) NOT NULL DEFAULT 'none',
  `message` varchar(255) NOT NULL DEFAULT 'none',
  `resident_message` text DEFAULT NULL,
  `gcash_payment` varchar(255) NOT NULL DEFAULT 'none',
  `gcash_number` varchar(20) DEFAULT NULL,
  `income` decimal(10,2) DEFAULT NULL,
  `reference_number` varchar(255) NOT NULL DEFAULT 'none',
  `gcash_transaction_id` varchar(255) DEFAULT NULL,
  `date_issued` varchar(255) NOT NULL DEFAULT 'none',
  `date_request` varchar(255) NOT NULL DEFAULT 'none',
  `date_expired` varchar(255) NOT NULL DEFAULT 'none',
  `status` varchar(255) NOT NULL DEFAULT 'none',
  `template_updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`a_i`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `reference_number` (`reference_number`),
  KEY `idx_residence_id` (`residence_id`),
  KEY `idx_status` (`status`),
  KEY `idx_certificate_type_id` (`certificate_type_id`),
  KEY `idx_gcash_transaction_id` (`gcash_transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- PAYMENT MANAGEMENT TABLES
-- =====================================================

--
-- Table structure for table `gcash_transactions`
--
CREATE TABLE `gcash_transactions` (
  `a_i` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `certificate_type` varchar(255) NOT NULL,
  `certificate_type_id` varchar(255) NOT NULL,
  `residence_id` varchar(255) NOT NULL,
  `certificate_request_id` varchar(255) NOT NULL,
  `status` enum('pending','completed','failed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) NOT NULL DEFAULT 'gcash',
  `gcash_number` varchar(20) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processed_date` timestamp NULL DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `completion_date` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`a_i`),
  UNIQUE KEY `transaction_id` (`transaction_id`),
  UNIQUE KEY `reference_number` (`reference_number`),
  KEY `idx_client_name` (`client_name`),
  KEY `idx_certificate_type` (`certificate_type`),
  KEY `idx_status` (`status`),
  KEY `idx_transaction_date` (`transaction_date`),
  KEY `idx_residence_id` (`residence_id`),
  KEY `idx_certificate_request_id` (`certificate_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- ORGANIZATIONAL STRUCTURE TABLES
-- =====================================================

--
-- Table structure for table `position`
--
CREATE TABLE `position` (
  `a_i` int(11) NOT NULL AUTO_INCREMENT,
  `position_id` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL DEFAULT 'none',
  `position_limit` varchar(255) NOT NULL DEFAULT 'none',
  `position_description` varchar(255) NOT NULL DEFAULT 'none',
  `color` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`a_i`),
  UNIQUE KEY `position_id` (`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- =====================================================
-- ARCHIVE TABLES
-- =====================================================

--
-- Table structure for table `inactive_official_information`
--
CREATE TABLE `inactive_official_information` (
  `official_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT 'none',
  `middle_name` varchar(255) NOT NULL DEFAULT 'none',
  `last_name` varchar(255) NOT NULL DEFAULT 'none',
  `suffix` varchar(255) NOT NULL DEFAULT 'none',
  `birth_date` varchar(255) NOT NULL DEFAULT 'none',
  `birth_place` varchar(255) NOT NULL DEFAULT 'none',
  `gender` varchar(255) NOT NULL DEFAULT 'none',
  `age` varchar(255) NOT NULL DEFAULT 'none',
  `civil_status` varchar(255) NOT NULL DEFAULT 'none',
  `religion` varchar(255) NOT NULL DEFAULT 'none',
  `nationality` varchar(255) NOT NULL DEFAULT 'none',
  `municipality` varchar(255) NOT NULL DEFAULT 'none',
  `zip` varchar(255) NOT NULL DEFAULT 'none',
  `IPs` varchar(255) NOT NULL DEFAULT 'none',
  `house_number` varchar(255) NOT NULL DEFAULT 'none',
  `street` varchar(255) NOT NULL DEFAULT 'none',
  `address` varchar(255) NOT NULL DEFAULT 'none',
  `email_address` varchar(255) NOT NULL DEFAULT 'none',
  `contact_number` varchar(255) NOT NULL DEFAULT 'none',
  `fathers_name` varchar(255) NOT NULL DEFAULT 'none',
  `mothers_name` varchar(255) NOT NULL DEFAULT 'none',
  `guardian` varchar(255) NOT NULL DEFAULT 'none',
  `guardian_contact` varchar(255) NOT NULL DEFAULT 'none',
  `image` varchar(255) NOT NULL DEFAULT 'none',
  `image_path` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`official_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `inactive_official_status`
--
CREATE TABLE `inactive_official_status` (
  `official_id` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL DEFAULT 'none',
  `senior` varchar(255) NOT NULL DEFAULT 'none',
  `term_from` varchar(255) NOT NULL DEFAULT 'none',
  `term_to` varchar(255) NOT NULL DEFAULT 'none',
  `pwd` varchar(255) NOT NULL DEFAULT 'none',
  `pwd_info` varchar(255) NOT NULL DEFAULT 'none',
  `single_parent` varchar(255) NOT NULL DEFAULT 'none',
  `status` varchar(255) NOT NULL DEFAULT 'none',
  `voters` varchar(255) NOT NULL DEFAULT 'none',
  `date_deleted` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`official_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- FOREIGN KEY CONSTRAINTS
-- =====================================================

-- Add foreign key constraint for certificate_request -> gcash_transactions
ALTER TABLE `certificate_request`
  ADD CONSTRAINT `fk_certificate_request_gcash` 
    FOREIGN KEY (`gcash_transaction_id`) 
    REFERENCES `gcash_transactions` (`transaction_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE;

-- Add foreign key constraint for certificate_request -> certificate_types
ALTER TABLE `certificate_request`
  ADD CONSTRAINT `fk_certificate_request_type` 
    FOREIGN KEY (`certificate_type_id`) 
    REFERENCES `certificate_types` (`certificate_type_id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE;

-- Add foreign key constraint for official_status -> official_information
ALTER TABLE `official_status`
  ADD CONSTRAINT `fk_official_status_info` 
    FOREIGN KEY (`official_id`) 
    REFERENCES `official_information` (`official_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE;

-- Add foreign key constraint for residence_status -> residence_information
ALTER TABLE `residence_status`
  ADD CONSTRAINT `fk_residence_status_info` 
    FOREIGN KEY (`residence_id`) 
    REFERENCES `residence_information` (`residence_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE;

-- =====================================================
-- PERFORMANCE INDEXES
-- =====================================================

-- Indexes for users table
CREATE INDEX `idx_users_user_type` ON `users` (`user_type`);
CREATE INDEX `idx_users_is_active` ON `users` (`is_active`);
CREATE INDEX `idx_users_last_login` ON `users` (`last_login`);

-- Indexes for residence_information table
CREATE INDEX `idx_residence_created_at` ON `residence_information` (`created_at`);
CREATE INDEX `idx_residence_gender` ON `residence_information` (`gender`);
CREATE INDEX `idx_residence_civil_status` ON `residence_information` (`civil_status`);

-- Indexes for official_information table
CREATE INDEX `idx_official_created_at` ON `official_information` (`created_at`);
CREATE INDEX `idx_official_gender` ON `official_information` (`gender`);

-- Indexes for certificate_request table
CREATE INDEX `idx_certificate_created_at` ON `certificate_request` (`created_at`);
CREATE INDEX `idx_certificate_date_request` ON `certificate_request` (`date_request`);

-- Indexes for registration_requests table
CREATE INDEX `idx_registration_status` ON `registration_requests` (`status`);
CREATE INDEX `idx_registration_date_requested` ON `registration_requests` (`date_requested`);

-- =====================================================
-- VIEWS FOR COMMON QUERIES (FIXED)
-- =====================================================

-- View for active residents
CREATE OR REPLACE VIEW `active_residents` AS
SELECT 
    ri.*,
    rs.status,
    rs.is_approved,
    rs.voters,
    rs.pwd,
    rs.single_parent,
    rs.date_added
FROM `residence_information` ri
LEFT JOIN `residence_status` rs ON ri.residence_id = rs.residence_id
WHERE rs.archive = 'none' OR rs.archive IS NULL;

-- View for active officials
CREATE OR REPLACE VIEW `active_officials` AS
SELECT 
    oi.*,
    os.position,
    os.term_from,
    os.term_to,
    os.status
FROM `official_information` oi
LEFT JOIN `official_status` os ON oi.official_id = os.official_id
WHERE os.status != 'inactive' OR os.status IS NULL;

-- View for certificate requests with details (FIXED - no duplicate columns)
CREATE OR REPLACE VIEW `certificate_requests_detailed` AS
SELECT 
    cr.a_i,
    cr.id,
    cr.residence_id,
    cr.certificate_type,
    cr.certificate_type_id,
    cr.certificate_name as request_certificate_name,
    cr.purpose,
    cr.message,
    cr.gcash_payment,
    cr.reference_number,
    cr.gcash_transaction_id,
    cr.date_issued,
    cr.date_request,
    cr.date_expired,
    cr.status,
    cr.created_at,
    cr.updated_at,
    ri.first_name,
    ri.last_name,
    ri.contact_number,
    ri.email_address,
    ct.certificate_name as type_certificate_name,
    ct.fee
FROM `certificate_request` cr
LEFT JOIN `residence_information` ri ON cr.residence_id = ri.residence_id
LEFT JOIN `certificate_types` ct ON cr.certificate_type_id = ct.certificate_type_id;


-- =====================================================
-- SAMPLE DATA INSERTIONS
-- =====================================================

--
-- Dumping data for table `activity_log`
--
INSERT INTO `activity_log` (`id`, `message`, `date`, `status`) VALUES
(1250, 'ADMIN: UPDATED OFFICIAL POSITION -  0401202511295839347 |  FROM CHAIRMANS TO CHAIRMAN', '1-4-2025 1:05 PM', 'update'),
(1251, 'ADMIN: DELETED POSITION -  77311317124789201092022180612765 | chairmans', '1-4-2025 7:05 AM', 'delete'),
(1252, 'ADMIN: ADDED RESIDENT - 23388956417195 |  Alexandra Kane Non commodi saepe se', '1-4-2025 1:06 PM', 'create'),
(1253, 'ADMIN: ADDED RESIDENT - 3188696235402 |  Alexandra Mooney In rem voluptatem E', '1-4-2025 1:06 PM', 'create'),
(1254, 'ADMIN: Admin Admin | LOGOUT', '1-4-2025 7:07 AM', 'logout'),
(1255, 'ADMIN: Admin Admin | LOGIN', '1-4-2025 1:09 PM', 'login'),
(1260, 'ADMIN: ADDED RESIDENT - 37404238492438 |  Miriam Frost Harum sit ut provide', '1-4-2025 1:10 PM', 'create'),
(1261, 'ADMIN: ADDED RESIDENT - 1086692484891 |  Jelani Ellison Dolorum qui qui id v', '1-4-2025 1:11 PM', 'create'),
(1262, 'ADMIN: ADDED RESIDENT - 12435095932673 |  Darrel Kline Quas perferendis aut', '1-4-2025 1:11 PM', 'create'),
(1263, 'ADMIN: ADDED RESIDENT - 34151365970057 |  Moana Burt Dolorum fugiat nisi', '1-4-2025 1:11 PM', 'create'),
(1264, 'ADMIN: ADDED OFFICIAL - 0401202513120186625 | KAGAWAD Branden Whitney Minim dolores velit | START 2021-12-17 END 1971-04-06', '1-4-2025 1:12 PM', 'create'),
(1265, 'ADMIN: Admin Admin | LOGOUT', '1-4-2025 7:12 AM', 'logout'),
(1266, 'ADMIN: Admin Admin | LOGIN', '1-4-2025 1:15 PM', 'login');

--
-- Dumping data for table `IPs_information`
--
INSERT INTO `IPs_information` (`id`, `IPs`, `zone`, `district`, `address`, `postal_address`, `image`, `image_path`) VALUES
('32432432432432432', 'IPs', 'Zone', 'District', 'City', 'Postal Address', '165897181867eb5acf2e8c4.jpg', '../assets/dist/img/165897181867eb5acf2e8c4.jpg');

--
-- Dumping data for table `certificate_types`
--
INSERT INTO `certificate_types` (`a_i`, `certificate_type_id`, `certificate_name`, `description`, `fee`, `validity_days`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'CT_001', 'Barangay Clearance', 'Certificate of residency and good moral character', 50.00, 30, 1, NOW(), NOW()),
(2, 'CT_002', 'IPs Clearance', 'Indigenous Peoples clearance certificate', 75.00, 60, 1, NOW(), NOW()),
(3, 'CT_003', 'Business Permit', 'Certificate for business operations', 200.00, 365, 1, NOW(), NOW()),
(4, 'CT_004', 'Cedula', 'Community tax certificate', 25.00, 365, 1, NOW(), NOW());

--
-- Dumping data for table `position`
--
INSERT INTO `position` (`a_i`, `position_id`, `position`, `position_limit`, `position_description`, `color`) VALUES
(22, '619131249471207208162022141229307', 'chairman', '1', '', '#4fb42e');



--
-- Dumping data for table `users`
--
INSERT INTO `users` (`a_i`, `id`, `first_name`, `middle_name`, `last_name`, `username`, `password`, `user_type`, `contact_number`, `email`, `is_active`, `image`, `image_path`) VALUES
(52, '1506135735699', 'Admin', 'Admin', 'Admin', 'admin123', 'admin123', 'admin', '11111111111', 'admin@ipsportal.com', 1, '182708071361a0f053c94fb.png', '../assets/dist/img/182708071361a0f053c94fb.png');

--
-- Sample data for gcash_transactions
--
INSERT INTO `gcash_transactions` (`transaction_id`, `client_name`, `reference_number`, `amount`, `certificate_type`, `certificate_type_id`, `residence_id`, `certificate_request_id`, `status`, `gcash_number`, `notes`) VALUES
('GC_001', 'Juan Dela Cruz', 'GC123456789', 50.00, 'Barangay Clearance', 'CT_001', 'RES_001', 'REQ_001', 'completed', '09171234567', 'Payment for barangay clearance'),
('GC_002', 'Maria Santos', 'GC987654321', 75.00, 'IPs Clearance', 'CT_002', 'RES_002', 'REQ_002', 'pending', '09187654321', 'Payment for IPs clearance'),
('GC_003', 'Pedro Garcia', 'GC456789123', 200.00, 'Business Permit', 'CT_003', 'RES_003', 'REQ_003', 'completed', '09123456789', 'Payment for business permit');

--
-- Table structure for table `messages`
--
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` varchar(255) NOT NULL,
  `sender_type` enum('admin','resident') NOT NULL,
  `receiver_id` varchar(255) NOT NULL,
  `receiver_type` enum('admin','resident') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_sender` (`sender_id`, `sender_type`),
  KEY `idx_receiver` (`receiver_id`, `receiver_type`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- AUTO_INCREMENT SETTINGS
-- =====================================================

ALTER TABLE `activity_log` AUTO_INCREMENT=1267;
ALTER TABLE `certificate_request` AUTO_INCREMENT=64;
ALTER TABLE `official_information` AUTO_INCREMENT=65;
ALTER TABLE `official_status` AUTO_INCREMENT=59;
ALTER TABLE `position` AUTO_INCREMENT=23;

ALTER TABLE `residence_information` AUTO_INCREMENT=182;
ALTER TABLE `residence_status` AUTO_INCREMENT=182;
ALTER TABLE `users` AUTO_INCREMENT=205;
ALTER TABLE `registration_requests` AUTO_INCREMENT=1;
ALTER TABLE `messages` AUTO_INCREMENT=1;

COMMIT;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- =====================================================
-- END OF COMBINED COMPLETE DATABASE
-- =====================================================
-- 
-- This database file includes ONLY tables actually used by the system:
-- 1. Core system tables (users, IPs_information, activity_log)
-- 2. Residence management tables (residence_information, residence_status, registration_requests)
-- 3. Official management tables (official_information, official_status)
-- 4. Certificate management tables (certificate_types, certificate_request)
-- 5. Payment management tables (gcash_transactions)
-- 6. Organizational structure tables (position)
-- 7. Archive tables (inactive_official_information, inactive_official_status)
-- 8. All foreign key constraints
-- 9. All indexes for performance
-- 10. Views for common queries
--
-- REMOVED UNUSED TABLES:
-- - certificate (not used in code)
-- - system_settings (not used in code)
-- - notifications (not used in code)
-- - system_logs (not used in code, system uses activity_log instead)
-- - file_uploads (not used in code)
-- - Stored procedures (not used in code)
-- - Triggers (not used in code)
-- 
-- Database Name: IPsDB
-- Version: 2.2 (Combined Complete Database)
-- =====================================================
