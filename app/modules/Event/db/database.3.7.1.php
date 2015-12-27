<?php

$this->query("ALTER TABLE `event_custom` CHANGE `location` `address` VARCHAR(255) NULL DEFAULT NULL;");

$this->query("
    ALTER TABLE `event_custom` 
        ADD `subtitle` VARCHAR(50) NULL DEFAULT NULL AFTER `name`,
        CHANGE `description` `description` LONGTEXT NULL DEFAULT NULL,
        ADD `start_time_at` VARCHAR(50) NULL DEFAULT NULL AFTER `start_at`,
        ADD `ticket_shop_url` VARCHAR(255) NULL DEFAULT NULL AFTER `rsvp`,
        ADD `websites` TEXT NULL DEFAULT NULL AFTER `ticket_shop_url`,        
        ADD `location_label` VARCHAR(50) NULL DEFAULT NULL AFTER `address`,
        ADD `location_url` VARCHAR(50) NULL DEFAULT NULL AFTER `location_label`
    ;
");
