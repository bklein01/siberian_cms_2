<?php

$this->query("
    CREATE TABLE `application_option_layout` (
        `layout_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `code` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
        `option_id` INT(11) UNSIGNED NOT NULL,
        `name` VARCHAR(50) NOT NULL,
        `preview` VARCHAR(255) NOT NULL,
        `position` TINYINT(1) NOT NULL DEFAULT 1,
        PRIMARY KEY (`layout_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `application_tc` (
        `tc_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `app_id` INT(11) UNSIGNED NOT NULL,
        `type` VARCHAR(50) NOT NULL,
        `text` LONGTEXT NULL DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`tc_id`),
        INDEX `IDX_TC_APPLICATION_APP_ID` (`app_id`),
        UNIQUE `UNIQUE_TC_APPLICATION_APP_ID_TYPE` (`app_id`, `type`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    ALTER TABLE `application_tc`
        ADD CONSTRAINT `FK_APPLICATION_TC_APP_ID`
            FOREIGN KEY (`app_id`) REFERENCES `application` (`app_id`) ON UPDATE CASCADE ON DELETE CASCADE;
");