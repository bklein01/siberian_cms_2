<?php

$this->query("
    CREATE TABLE `api_user` (
        `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `username` varchar(50) NOT NULL,
        `firstname` varchar(50) NULL DEFAULT NULL,
        `lastname` varchar(50) NULL DEFAULT NULL,
        `password` varchar(100) NOT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");
