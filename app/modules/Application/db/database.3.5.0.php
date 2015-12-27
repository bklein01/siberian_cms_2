<?php

$this->query("ALTER TABLE `application_option_value` ADD `social_sharing_is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER `is_active`;");
$this->query("ALTER TABLE `application_option_value` ADD `social_sharing_is_available` TINYINT(1) NOT NULL DEFAULT '0' AFTER `social_sharing_is_active`;");

//Social sharing availability by feature
$this->query("UPDATE `application_option_value` SET social_sharing_is_available = 1 WHERE option_id IN (
    SELECT option_id FROM `application_option` WHERE code IN ('catalog','set_meal','custom_page','newswall','fanwall','calendar','m_commerce','places','discount','rss_feed','wordpress')
);");