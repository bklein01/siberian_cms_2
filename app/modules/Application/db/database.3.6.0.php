<?php

$this->query("
    ALTER TABLE application_option_value DROP social_sharing_is_available
");

$this->query("
  ALTER TABLE `application_option` ADD `social_sharing_is_available` TINYINT(1) NOT NULL DEFAULT '0';
");

$this->query("UPDATE `application_option` SET social_sharing_is_available = 1 WHERE code IN (
    'catalog','set_meal','custom_page','newswall','fanwall','calendar','m_commerce','places','discount','rss_feed','wordpress')
");