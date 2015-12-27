<?php

$this->query("
    CREATE TABLE `module` (
        `module_id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
        `version` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`module_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

    CREATE TABLE `session` (
        `session_id` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
        `modified` int(11) DEFAULT NULL,
        `lifetime` int(11) DEFAULT NULL,
        `data` mediumtext COLLATE utf8_unicode_ci,
        PRIMARY KEY (`session_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `log` (
        `log_id` int(11) NOT NULL AUTO_INCREMENT,
        `app_id` int(11) UNSIGNED NOT NULL,
        `value_id` INT(11) UNSIGNED NOT NULL,
        `customer_id` int(11) DEFAULT NULL,
        `remote_addr` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
        `device_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
        `other` text COLLATE utf8_unicode_ci,
        `visited_at` datetime NOT NULL,
        PRIMARY KEY (`log_id`),
        INDEX `IDX_VALUE_ID` (`value_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");
