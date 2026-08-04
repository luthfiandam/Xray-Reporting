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


-- Dumping database structure for xray_reporting
CREATE DATABASE IF NOT EXISTS `xray_reporting` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `xray_reporting`;

-- Dumping structure for table xray_reporting.checklist_categories
CREATE TABLE IF NOT EXISTS `checklist_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sequence` smallint unsigned NOT NULL DEFAULT '100',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checklist_categories_code_unique` (`code`),
  UNIQUE KEY `checklist_categories_name_unique` (`name`),
  KEY `checklist_categories_sequence_index` (`sequence`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.checklist_categories: ~5 rows (approximately)
REPLACE INTO `checklist_categories` (`id`, `code`, `name`, `description`, `sequence`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'SAFETY', 'Keamanan', 'Pemeriksaan keamanan peralatan', 10, 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(2, 'MECHANICAL', 'Mekanik', 'Pemeriksaan komponen mekanik', 20, 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(3, 'ELECTRICAL', 'Elektrik', 'Pemeriksaan sistem kelistrikan', 30, 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(4, 'IMAGING', 'Pencitraan', 'Pemeriksaan kualitas citra', 40, 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(5, 'CALIBRATION', 'Kalibrasi', 'Pemeriksaan dan kalibrasi alat', 50, 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40');

-- Dumping structure for table xray_reporting.checklist_results
CREATE TABLE IF NOT EXISTS `checklist_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `work_order_id` bigint unsigned NOT NULL,
  `checklist_template_item_id` bigint unsigned DEFAULT NULL,
  `completed_by` bigint unsigned DEFAULT NULL,
  `item_code` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_type` enum('boolean','select','text','number','photo','multiselect') COLLATE utf8mb4_unicode_ci NOT NULL,
  `result_status` enum('ok','not_ok','not_applicable','not_checked') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_text` text COLLATE utf8mb4_unicode_ci,
  `value_number` decimal(18,6) DEFAULT NULL,
  `value_json` json DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `sequence` smallint unsigned NOT NULL DEFAULT '100',
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_checklist_result_item` (`work_order_id`,`checklist_template_item_id`),
  KEY `checklist_results_checklist_template_item_id_foreign` (`checklist_template_item_id`),
  KEY `checklist_results_completed_by_foreign` (`completed_by`),
  KEY `checklist_results_result_status_index` (`result_status`),
  CONSTRAINT `checklist_results_checklist_template_item_id_foreign` FOREIGN KEY (`checklist_template_item_id`) REFERENCES `checklist_template_items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `checklist_results_completed_by_foreign` FOREIGN KEY (`completed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `checklist_results_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.checklist_results: ~0 rows (approximately)

-- Dumping structure for table xray_reporting.checklist_templates
CREATE TABLE IF NOT EXISTS `checklist_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `equipment_type_id` bigint unsigned NOT NULL,
  `maintenance_frequency_id` bigint unsigned NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` smallint unsigned NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `effective_from` date DEFAULT NULL,
  `effective_until` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_checklist_template_version` (`equipment_type_id`,`maintenance_frequency_id`,`version`),
  UNIQUE KEY `checklist_templates_uuid_unique` (`uuid`),
  KEY `checklist_templates_maintenance_frequency_id_foreign` (`maintenance_frequency_id`),
  KEY `idx_checklist_template_lookup` (`equipment_type_id`,`maintenance_frequency_id`,`is_active`),
  CONSTRAINT `checklist_templates_equipment_type_id_foreign` FOREIGN KEY (`equipment_type_id`) REFERENCES `equipment_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `checklist_templates_maintenance_frequency_id_foreign` FOREIGN KEY (`maintenance_frequency_id`) REFERENCES `maintenance_frequencies` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.checklist_templates: ~0 rows (approximately)

-- Dumping structure for table xray_reporting.checklist_template_items
CREATE TABLE IF NOT EXISTS `checklist_template_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `checklist_template_id` bigint unsigned NOT NULL,
  `checklist_category_id` bigint unsigned DEFAULT NULL,
  `item_code` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_type` enum('boolean','select','text','number','photo','multiselect') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'boolean',
  `options_json` json DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '1',
  `sequence` smallint unsigned NOT NULL DEFAULT '100',
  `help_text` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_checklist_item_sequence` (`checklist_template_id`,`sequence`),
  KEY `checklist_template_items_checklist_category_id_foreign` (`checklist_category_id`),
  KEY `checklist_template_items_is_active_index` (`is_active`),
  CONSTRAINT `checklist_template_items_checklist_category_id_foreign` FOREIGN KEY (`checklist_category_id`) REFERENCES `checklist_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `checklist_template_items_checklist_template_id_foreign` FOREIGN KEY (`checklist_template_id`) REFERENCES `checklist_templates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.checklist_template_items: ~0 rows (approximately)

-- Dumping structure for table xray_reporting.equipments
CREATE TABLE IF NOT EXISTS `equipments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `equipment_type_id` bigint unsigned NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `equipment_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view_mode` enum('single_view','dual_view','not_applicable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_applicable',
  `serial_number` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generator_serial_a` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generator_serial_b` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detector_serial` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `software_version` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firmware_version` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `installation_date` date DEFAULT NULL,
  `status` enum('operational','maintenance','out_of_service','decommissioned','spare') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'operational',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `equipments_uuid_unique` (`uuid`),
  UNIQUE KEY `equipments_equipment_code_unique` (`equipment_code`),
  UNIQUE KEY `equipments_qr_code_unique` (`qr_code`),
  KEY `equipments_location_id_foreign` (`location_id`),
  KEY `equipments_status_index` (`status`),
  KEY `equipments_serial_number_index` (`serial_number`),
  KEY `equipments_equipment_type_id_location_id_index` (`equipment_type_id`,`location_id`),
  CONSTRAINT `equipments_equipment_type_id_foreign` FOREIGN KEY (`equipment_type_id`) REFERENCES `equipment_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `equipments_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.equipments: ~10 rows (approximately)
REPLACE INTO `equipments` (`id`, `uuid`, `equipment_type_id`, `location_id`, `equipment_code`, `name`, `brand`, `model`, `view_mode`, `serial_number`, `generator_serial_a`, `generator_serial_b`, `detector_serial`, `software_version`, `firmware_version`, `ip_address`, `qr_code`, `installation_date`, `status`, `notes`, `created_at`, `updated_at`) VALUES
	(1, 'da476428-0a6e-4647-b3e1-a21e4a52aad1', 2, 1, 'XRAY-001', 'X-Ray Unit SCP Line C', 'Siemens', 'AXIOM Artis dFC', 'single_view', 'XR-2022-001', 'GEN-A-001', NULL, 'DET-001', NULL, NULL, NULL, 'XRAY001QR', '2022-01-15', 'operational', NULL, '2026-08-03 04:03:41', '2026-08-03 04:03:41'),
	(2, 'ec933d00-c219-4b87-8169-653d9e48147d', 3, 1, 'XRAY-002', 'X-Ray Digital Unit 1', 'GE Healthcare', 'Optima XR240', 'not_applicable', 'XR-2023-001', NULL, NULL, 'DET-002', NULL, NULL, NULL, 'XRAY002QR', '2023-03-20', 'operational', NULL, '2026-08-03 04:03:41', '2026-08-03 04:03:41'),
	(3, 'e62b8981-030a-4fd7-9647-7bbf25d5461e', 2, 2, 'XRAY-003', 'X-Ray Unit VIP Room', 'Philips', 'DigitalDiagnost C90', 'dual_view', 'XR-2022-002', 'GEN-A-002', 'GEN-B-002', 'DET-003', NULL, NULL, NULL, 'XRAY003QR', '2022-06-10', 'operational', NULL, '2026-08-03 04:03:41', '2026-08-03 04:03:41'),
	(4, '224ba577-e061-4b71-ad6d-24af82a2f8cc', 3, 2, 'XRAY-004', 'X-Ray Digital Unit 2', 'Canon', 'CXDI Detector', 'not_applicable', 'XR-2023-002', NULL, NULL, 'DET-004', NULL, NULL, NULL, 'XRAY004QR', '2023-05-12', 'operational', NULL, '2026-08-03 04:03:41', '2026-08-03 04:03:41'),
	(5, '9b31cc9a-cdc4-42ac-916d-b4c29ae2e554', 2, 3, 'XRAY-005', 'X-Ray Unit Premium', 'Siemens', 'AXIOM Artis dFA', 'dual_view', 'XR-2022-003', 'GEN-A-003', 'GEN-B-003', 'DET-005', NULL, NULL, NULL, 'XRAY005QR', '2022-09-05', 'operational', NULL, '2026-08-03 04:03:41', '2026-08-03 04:03:41'),
	(6, 'a6e74e34-5c43-4337-a90b-d35be1fb6868', 4, 3, 'CT-001', 'CT Scan Unit Spiral', 'GE Healthcare', 'Optima CT660', 'not_applicable', 'CT-2023-001', NULL, NULL, 'DET-CT-001', NULL, NULL, NULL, 'CT001QR', '2023-02-14', 'operational', NULL, '2026-08-03 04:03:41', '2026-08-03 04:03:41'),
	(7, '627e8353-ff1d-4da7-acaf-ae4741526684', 1, 4, 'XRAY-PORT-001', 'X-Ray Mobile Unit 1', 'Philips', 'MobileDiagnost', 'single_view', 'XR-MOBILE-001', 'GEN-MOB-001', NULL, 'DET-MOB-001', NULL, NULL, NULL, 'XRAYPORT001QR', '2021-08-20', 'operational', NULL, '2026-08-03 04:03:41', '2026-08-03 04:03:41'),
	(8, '08cbfafd-dfb4-4b05-8f25-0dd9d2ad448c', 1, 4, 'XRAY-PORT-002', 'X-Ray Mobile Unit 2', 'GE Healthcare', 'Optima XR200', 'single_view', 'XR-MOBILE-002', 'GEN-MOB-002', NULL, 'DET-MOB-002', NULL, NULL, NULL, 'XRAYPORT002QR', '2022-11-08', 'operational', NULL, '2026-08-03 04:03:41', '2026-08-03 04:03:41'),
	(9, '122687e8-2392-4ebf-a213-da93758d0546', 3, 5, 'XRAY-LAB-001', 'X-Ray Lab Main Unit', 'Siemens', 'AXIOM Prime', 'not_applicable', 'XR-LAB-001', NULL, NULL, 'DET-LAB-001', NULL, NULL, NULL, 'XRAYLAB001QR', '2022-04-11', 'operational', NULL, '2026-08-03 04:03:41', '2026-08-03 04:03:41'),
	(10, '2394c4ff-bbe5-4f57-9305-c66bcd0ac0b0', 4, 5, 'CT-LAB-001', 'CT Scan Lab Unit', 'Philips', 'IQon Spectral CT', 'not_applicable', 'CT-LAB-001', NULL, NULL, 'DET-CT-LAB-001', NULL, NULL, NULL, 'CTLAB001QR', '2023-07-19', 'operational', NULL, '2026-08-03 04:03:41', '2026-08-03 04:03:41');

-- Dumping structure for table xray_reporting.equipment_types
CREATE TABLE IF NOT EXISTS `equipment_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `equipment_types_code_unique` (`code`),
  UNIQUE KEY `equipment_types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.equipment_types: ~4 rows (approximately)
REPLACE INTO `equipment_types` (`id`, `code`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'XRAY-MOBILE', 'X-Ray Mobile', 'X-Ray unit mobile untuk portable examination', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(2, 'XRAY-STATIONARY', 'X-Ray Stationary', 'X-Ray unit stationary di ruangan khusus', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(3, 'XRAY-DIGITAL', 'X-Ray Digital', 'X-Ray dengan teknologi digital imaging', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(4, 'CT-SCAN', 'CT Scan', 'Computed Tomography Scanner', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40');

-- Dumping structure for table xray_reporting.evidences
CREATE TABLE IF NOT EXISTS `evidences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_order_id` bigint unsigned NOT NULL,
  `uploaded_by` bigint unsigned NOT NULL,
  `evidence_type` enum('overview','nameplate','measurement','generator_test','before','after','error','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `original_path` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `watermarked_path` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail_path` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint unsigned DEFAULT NULL,
  `width` int unsigned DEFAULT NULL,
  `height` int unsigned DEFAULT NULL,
  `caption` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sequence` smallint unsigned NOT NULL DEFAULT '100',
  `taken_at` datetime DEFAULT NULL,
  `watermark_status` enum('pending','processed','failed','not_required') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `evidences_uuid_unique` (`uuid`),
  KEY `evidences_uploaded_by_foreign` (`uploaded_by`),
  KEY `idx_evidences_work_order_type` (`work_order_id`,`evidence_type`),
  KEY `idx_evidences_sequence` (`work_order_id`,`sequence`),
  CONSTRAINT `evidences_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `evidences_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.evidences: ~0 rows (approximately)

-- Dumping structure for table xray_reporting.locations
CREATE TABLE IF NOT EXISTS `locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint unsigned DEFAULT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `locations_code_unique` (`code`),
  KEY `locations_parent_id_foreign` (`parent_id`),
  KEY `locations_is_active_index` (`is_active`),
  CONSTRAINT `locations_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.locations: ~5 rows (approximately)
REPLACE INTO `locations` (`id`, `parent_id`, `code`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'LOC-001', 'Ruangan Radiologi Lantai 1', 'Departemen Radiologi - Lantai 1 Gedung A', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(2, NULL, 'LOC-002', 'Ruangan Radiologi Lantai 2', 'Departemen Radiologi - Lantai 2 Gedung A', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(3, NULL, 'LOC-003', 'Ruangan Radiologi Lantai 3', 'Departemen Radiologi - Lantai 3 Gedung B', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(4, NULL, 'LOC-004', 'Unit Portable Radiologi', 'Layanan portable X-Ray untuk ruang ICU dan kamar operasi', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(5, NULL, 'LOC-005', 'Laboratorium Imaging Utama', 'Pusat laboratorium imaging dan diagnostic center', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40');

-- Dumping structure for table xray_reporting.maintenance_frequencies
CREATE TABLE IF NOT EXISTS `maintenance_frequencies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `interval_days` smallint unsigned DEFAULT NULL,
  `sequence` smallint unsigned NOT NULL DEFAULT '100',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `maintenance_frequencies_code_unique` (`code`),
  UNIQUE KEY `maintenance_frequencies_name_unique` (`name`),
  KEY `maintenance_frequencies_sequence_index` (`sequence`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.maintenance_frequencies: ~6 rows (approximately)
REPLACE INTO `maintenance_frequencies` (`id`, `code`, `name`, `interval_days`, `sequence`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'DAILY', 'Harian', 1, 10, 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(2, 'WEEKLY', 'Mingguan', 7, 20, 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(3, 'MONTHLY', 'Bulanan', 30, 30, 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(4, 'QUARTERLY', 'Triwulan', 90, 40, 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(5, 'SEMI_ANNUAL', 'Semesteran', 180, 50, 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(6, 'ANNUAL', 'Tahunan', 365, 60, 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40');

-- Dumping structure for table xray_reporting.maintenance_types
CREATE TABLE IF NOT EXISTS `maintenance_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `maintenance_types_code_unique` (`code`),
  UNIQUE KEY `maintenance_types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.maintenance_types: ~3 rows (approximately)
REPLACE INTO `maintenance_types` (`id`, `code`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'PM', 'Preventive Maintenance', 'Maintenance rutin untuk pencegahan', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(2, 'CM', 'Corrective Maintenance', 'Maintenance untuk perbaikan kerusakan', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(3, 'INSPECTION', 'Inspection', 'Pemeriksaan berkala peralatan', 1, '2026-08-03 04:03:40', '2026-08-03 04:03:40');

-- Dumping structure for table xray_reporting.measurement_results
CREATE TABLE IF NOT EXISTS `measurement_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `work_order_id` bigint unsigned NOT NULL,
  `measurement_template_id` bigint unsigned DEFAULT NULL,
  `ocr_result_id` bigint unsigned DEFAULT NULL,
  `confirmed_by` bigint unsigned NOT NULL,
  `measurement_code` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `measurement_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `generator` enum('A','B','NA') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `unit` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ocr_value` decimal(18,6) DEFAULT NULL,
  `manual_value` decimal(18,6) DEFAULT NULL,
  `final_value` decimal(18,6) NOT NULL,
  `minimum_value` decimal(18,6) DEFAULT NULL,
  `maximum_value` decimal(18,6) DEFAULT NULL,
  `is_within_range` tinyint(1) DEFAULT NULL,
  `input_source` enum('manual','ocr','ocr_edited','device') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `confidence` decimal(5,2) DEFAULT NULL,
  `validation_status` enum('valid','warning','invalid','not_validated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_validated',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `confirmed_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_measurement_result_parameter` (`work_order_id`,`measurement_code`,`generator`),
  KEY `measurement_results_measurement_template_id_foreign` (`measurement_template_id`),
  KEY `measurement_results_ocr_result_id_foreign` (`ocr_result_id`),
  KEY `measurement_results_confirmed_by_foreign` (`confirmed_by`),
  KEY `measurement_results_input_source_index` (`input_source`),
  KEY `measurement_results_validation_status_index` (`validation_status`),
  CONSTRAINT `measurement_results_confirmed_by_foreign` FOREIGN KEY (`confirmed_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `measurement_results_measurement_template_id_foreign` FOREIGN KEY (`measurement_template_id`) REFERENCES `measurement_templates` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `measurement_results_ocr_result_id_foreign` FOREIGN KEY (`ocr_result_id`) REFERENCES `ocr_results` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `measurement_results_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.measurement_results: ~0 rows (approximately)

-- Dumping structure for table xray_reporting.measurement_templates
CREATE TABLE IF NOT EXISTS `measurement_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `equipment_type_id` bigint unsigned NOT NULL,
  `maintenance_frequency_id` bigint unsigned DEFAULT NULL,
  `code` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `generator` enum('A','B','NA') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `unit` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum_value` decimal(18,6) DEFAULT NULL,
  `maximum_value` decimal(18,6) DEFAULT NULL,
  `decimal_precision` tinyint unsigned NOT NULL DEFAULT '2',
  `sequence` smallint unsigned NOT NULL DEFAULT '100',
  `is_required` tinyint(1) NOT NULL DEFAULT '1',
  `is_ocr_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_measurement_template_parameter` (`equipment_type_id`,`maintenance_frequency_id`,`code`,`generator`),
  KEY `measurement_templates_maintenance_frequency_id_foreign` (`maintenance_frequency_id`),
  KEY `idx_measurement_template_lookup` (`equipment_type_id`,`maintenance_frequency_id`,`is_active`),
  KEY `measurement_templates_sequence_index` (`sequence`),
  CONSTRAINT `measurement_templates_equipment_type_id_foreign` FOREIGN KEY (`equipment_type_id`) REFERENCES `equipment_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `measurement_templates_maintenance_frequency_id_foreign` FOREIGN KEY (`maintenance_frequency_id`) REFERENCES `maintenance_frequencies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.measurement_templates: ~0 rows (approximately)

-- Dumping structure for table xray_reporting.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.migrations: ~0 rows (approximately)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2026_08_03_000001_create_roles_table', 1),
	(2, '2026_08_03_000002_create_users_table', 1),
	(3, '2026_08_03_000003_create_locations_table', 1),
	(4, '2026_08_03_000004_create_equipment_types_table', 1),
	(5, '2026_08_03_000005_create_maintenance_types_table', 1),
	(6, '2026_08_03_000006_create_maintenance_frequencies_table', 1),
	(7, '2026_08_03_000007_create_checklist_categories_table', 1),
	(8, '2026_08_03_000008_create_equipments_table', 1),
	(9, '2026_08_03_000009_create_checklist_templates_table', 1),
	(10, '2026_08_03_000010_create_checklist_template_items_table', 1),
	(11, '2026_08_03_000011_create_measurement_templates_table', 1),
	(12, '2026_08_03_000012_create_work_orders_table', 1),
	(13, '2026_08_03_000013_create_checklist_results_table', 1),
	(14, '2026_08_03_000014_create_evidences_table', 1),
	(15, '2026_08_03_000015_create_ocr_results_table', 1),
	(16, '2026_08_03_000016_create_measurement_results_table', 1),
	(17, '2026_08_03_000017_create_reports_table', 1);

-- Dumping structure for table xray_reporting.ocr_results
CREATE TABLE IF NOT EXISTS `ocr_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `work_order_id` bigint unsigned NOT NULL,
  `evidence_id` bigint unsigned NOT NULL,
  `reviewed_by` bigint unsigned DEFAULT NULL,
  `engine_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tesseract',
  `engine_version` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('queued','processing','completed','failed','reviewed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'queued',
  `raw_text` longtext COLLATE utf8mb4_unicode_ci,
  `parsed_values` json DEFAULT NULL,
  `confidence_json` json DEFAULT NULL,
  `average_confidence` decimal(5,2) DEFAULT NULL,
  `processing_time_ms` int unsigned DEFAULT NULL,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `reviewed_at` datetime DEFAULT NULL,
  `review_status` enum('pending','accepted','edited','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ocr_results_work_order_id_foreign` (`work_order_id`),
  KEY `ocr_results_evidence_id_foreign` (`evidence_id`),
  KEY `ocr_results_reviewed_by_foreign` (`reviewed_by`),
  KEY `ocr_results_status_index` (`status`),
  KEY `ocr_results_review_status_index` (`review_status`),
  CONSTRAINT `ocr_results_evidence_id_foreign` FOREIGN KEY (`evidence_id`) REFERENCES `evidences` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `ocr_results_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ocr_results_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.ocr_results: ~0 rows (approximately)

-- Dumping structure for table xray_reporting.reports
CREATE TABLE IF NOT EXISTS `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `work_order_id` bigint unsigned NOT NULL,
  `generated_by` bigint unsigned DEFAULT NULL,
  `report_type` enum('whatsapp','pdf','excel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('queued','processing','generated','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'queued',
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` smallint unsigned NOT NULL DEFAULT '1',
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `generated_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_report_version` (`work_order_id`,`report_type`,`version`),
  KEY `reports_generated_by_foreign` (`generated_by`),
  KEY `idx_reports_work_order_type` (`work_order_id`,`report_type`),
  KEY `reports_status_index` (`status`),
  KEY `reports_generated_at_index` (`generated_at`),
  CONSTRAINT `reports_generated_by_foreign` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `reports_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.reports: ~0 rows (approximately)

-- Dumping structure for table xray_reporting.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.roles: ~2 rows (approximately)
REPLACE INTO `roles` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 'Administrator sistem dengan akses penuh', 1, '2026-08-03 04:03:38', '2026-08-03 04:03:38'),
	(2, 'Teknisi', 'Teknisi maintenance X-Ray', 1, '2026-08-03 04:03:38', '2026-08-03 04:03:38'),
	(3, 'Supervisor', 'Supervisor maintenance', 1, '2026-08-03 04:03:38', '2026-08-03 04:03:38');

-- Dumping structure for table xray_reporting.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `technician_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_login_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_technician_code_unique` (`technician_code`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_status_index` (`status`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.users: ~9 rows (approximately)
REPLACE INTO `users` (`id`, `role_id`, `name`, `username`, `email`, `phone`, `password`, `technician_code`, `status`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Administrator', 'admin', 'admin@xray.local', '081234567890', '$2y$12$Wljq5fytfiT07v2/26JGneeRioyW/Js0Ndq1aS2ZAxXiJlKhbP5Hy', 'ADMIN-001', 'active', NULL, NULL, '2026-08-03 04:03:38', '2026-08-03 04:03:38'),
	(2, 2, 'Adi Gunawan', 'teknisi1', 'teknisi1@xray.local', '081234567800', '$2y$12$hcgO593YHluv2p8Kk/D.L.0EgDguiTM4F2OJBUsvCafTY5H89bqDu', 'TEK-001', 'active', NULL, NULL, '2026-08-03 04:03:38', '2026-08-03 04:03:38'),
	(3, 2, 'Budi Santoso', 'teknisi2', 'teknisi2@xray.local', '081234567801', '$2y$12$AOdIaUSFn0IIK0ltgBJkmOmGQz1jRJmkfK.VH4IW2eoNNK4HbsOT6', 'TEK-002', 'active', NULL, NULL, '2026-08-03 04:03:39', '2026-08-03 04:03:39'),
	(4, 2, 'Citra Dewi', 'teknisi3', 'teknisi3@xray.local', '081234567802', '$2y$12$I1sL5EjZKGzNtoYntnjOou8jQ761jf9RWRns/Pb/lLj47RZnA/Wsy', 'TEK-003', 'active', NULL, NULL, '2026-08-03 04:03:39', '2026-08-03 04:03:39'),
	(5, 2, 'Doni Sutrisno', 'teknisi4', 'teknisi4@xray.local', '081234567803', '$2y$12$.xJ8rkR5de6RpF1ClvH4T.VkZTNyRb4fO9uYP9o4AEFgYsI69k5/2', 'TEK-004', 'active', NULL, NULL, '2026-08-03 04:03:39', '2026-08-03 04:03:39'),
	(6, 2, 'Eka Putri', 'teknisi5', 'teknisi5@xray.local', '081234567804', '$2y$12$3c9CbX.njTES6ltvfsHmXOhx1Fkl2vDuEu5oR0kc1j5tMQb4Ne6oO', 'TEK-005', 'active', NULL, NULL, '2026-08-03 04:03:39', '2026-08-03 04:03:39'),
	(7, 3, 'Fauzan Malik', 'supervisor1', 'supervisor1@xray.local', '081234567900', '$2y$12$0W./0KrCd2HWHtR2ShA72O4Eo2LmMpKFMuuys8F7V8HTW6A9WDpKO', 'SUP-001', 'active', NULL, NULL, '2026-08-03 04:03:39', '2026-08-03 04:03:39'),
	(8, 3, 'Gita Chandra', 'supervisor2', 'supervisor2@xray.local', '081234567901', '$2y$12$LNLJX3UJqOOTyzmJIUvrXugrar9edJpm3vP0YA3ZwiAJG9QLBF/Xm', 'SUP-002', 'active', NULL, NULL, '2026-08-03 04:03:40', '2026-08-03 04:03:40'),
	(9, 3, 'Hendra Wijaya', 'supervisor3', 'supervisor3@xray.local', '081234567902', '$2y$12$T3s23n4S1JfcDgJuUOIC3.fRaOlOSjwtKJomq8i36aJrIPXqm1hqG', 'SUP-003', 'active', NULL, NULL, '2026-08-03 04:03:40', '2026-08-03 04:03:40');

-- Dumping structure for table xray_reporting.work_orders
CREATE TABLE IF NOT EXISTS `work_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `equipment_id` bigint unsigned NOT NULL,
  `maintenance_type_id` bigint unsigned NOT NULL,
  `maintenance_frequency_id` bigint unsigned DEFAULT NULL,
  `checklist_template_id` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `assigned_to` bigint unsigned NOT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `status` enum('draft','in_progress','ocr_review','ready_to_submit','submitted','approved','closed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `priority` enum('low','normal','high','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `scheduled_at` datetime DEFAULT NULL,
  `started_at` datetime DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `problem_description` text COLLATE utf8mb4_unicode_ci,
  `action_taken` text COLLATE utf8mb4_unicode_ci,
  `final_condition` enum('normal','limited','out_of_service','not_assessed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_assessed',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `ocr_reviewed` tinyint(1) NOT NULL DEFAULT '0',
  `sync_status` enum('synced','pending','conflict') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'synced',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `work_orders_uuid_unique` (`uuid`),
  UNIQUE KEY `work_orders_work_order_number_unique` (`work_order_number`),
  KEY `work_orders_checklist_template_id_foreign` (`checklist_template_id`),
  KEY `work_orders_created_by_foreign` (`created_by`),
  KEY `work_orders_approved_by_foreign` (`approved_by`),
  KEY `idx_work_orders_equipment_created` (`equipment_id`,`created_at`),
  KEY `idx_work_orders_assigned_status` (`assigned_to`,`status`),
  KEY `idx_work_orders_status_created` (`status`,`created_at`),
  KEY `work_orders_scheduled_at_index` (`scheduled_at`),
  KEY `work_orders_maintenance_type_id_index` (`maintenance_type_id`),
  KEY `work_orders_maintenance_frequency_id_index` (`maintenance_frequency_id`),
  CONSTRAINT `work_orders_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `work_orders_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `work_orders_checklist_template_id_foreign` FOREIGN KEY (`checklist_template_id`) REFERENCES `checklist_templates` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `work_orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `work_orders_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `work_orders_maintenance_frequency_id_foreign` FOREIGN KEY (`maintenance_frequency_id`) REFERENCES `maintenance_frequencies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `work_orders_maintenance_type_id_foreign` FOREIGN KEY (`maintenance_type_id`) REFERENCES `maintenance_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table xray_reporting.work_orders: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
