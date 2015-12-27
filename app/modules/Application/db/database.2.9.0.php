<?php

$this->query("ALTER TABLE `application_device` ADD `admob_id` VARCHAR(50) NULL DEFAULT NULL AFTER `status_id`");
$this->query("ALTER TABLE `application_device` ADD `admob_type` enum('banner','interstitial') NOT NULL DEFAULT 'banner' AFTER `admob_id`");
$this->query("ALTER TABLE `application` ADD `use_ads` TINYINT(1) NULL DEFAULT 0 AFTER `is_active`");