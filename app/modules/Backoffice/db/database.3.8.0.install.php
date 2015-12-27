<?php

$this->query("
    CREATE TABLE `backoffice_user` (
        `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
        `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `backoffice_notification` (
        `notification_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `original_notification_id` int(11) unsigned NOT NULL,
        `title` varchar(100) NOT NULL,
        `description` varchar(255) NOT NULL,
        `link` varchar(255) NULL DEFAULT NULL,
        `is_high_priority` tinyint(1) NOT NULL DEFAULT 0,
        `is_read` tinyint(1) NOT NULL DEFAULT 0,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`notification_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$message = "Welcome! First of all, let's configure your platform. <a href=\"/system/backoffice_config_general\"><u>Click here</u></a> to fill in your information or <a href=\"/system/backoffice_config_email\"><u>here</u></a> to configure your email address";

$notif = new Backoffice_Model_Notification();
$notif->setTitle("Welcome!")
    ->setDescription($message)
    ->setOriginalNotificationId(0)
    ->save()
;