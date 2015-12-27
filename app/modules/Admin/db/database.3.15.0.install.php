<?php

$this->query("
    CREATE TABLE `admin` (
        `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `parent_id` INT(11) UNSIGNED NULL DEFAULT NULL,
        `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        `is_allowed_to_add_pages` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
        `publication_access_type` ENUM('sources', 'info') NULL DEFAULT NULL,
        `company` VARCHAR(100) NULL DEFAULT NULL,
        `firstname` VARCHAR(100) NULL DEFAULT NULL,
        `lastname` VARCHAR(100) NULL DEFAULT NULL,
        `address` TEXT NULL DEFAULT NULL,
        `address2` VARCHAR(255) NULL DEFAULT NULL,
        `city` VARCHAR(255) NULL DEFAULT NULL,
        `zip_code` VARCHAR(255) NULL DEFAULT NULL,
        `region_code` VARCHAR(255) NULL DEFAULT NULL,
        `region` VARCHAR(255) NULL DEFAULT NULL,
        `country_code` VARCHAR(10) NULL DEFAULT NULL,
        `country` VARCHAR(100) NULL DEFAULT NULL,
        `phone` VARCHAR(20) NULL DEFAULT NULL,
        `vat_number` VARCHAR(20) NULL DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        KEY `KEY_PARENT_ID` (`parent_id`),
        PRIMARY KEY (`admin_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

$this->query("
    ALTER TABLE `application_admin`
        ADD CONSTRAINT `FK_APPLICATION_ADMIN_ADMIN_ID` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
