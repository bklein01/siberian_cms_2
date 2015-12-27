<?php

$this->query("
    ALTER TABLE `application` ADD `can_be_published` TINYINT(1) NOT NULL DEFAULT '1' AFTER `is_locked`;
");

$this->query("
    ALTER TABLE `application`
        ADD `banner_title` VARCHAR(150) NULL AFTER `unlock_code`,
        ADD `banner_author` VARCHAR(150) NULL AFTER `banner_title`,
        ADD `banner_button_label` VARCHAR(150) NULL AFTER `banner_author`;
");

$this->query("
    ALTER TABLE `application_device`
        ADD `store_app_id` VARCHAR(150) NULL AFTER `store_pass`,
        ADD `banner_store_label` VARCHAR(150) NULL AFTER `store_app_id`,
        ADD `banner_store_price` VARCHAR(150) NULL AFTER `banner_store_label`;
");