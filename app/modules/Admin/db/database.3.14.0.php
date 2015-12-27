<?php

$fields = array_keys($this->_db->describeTable("admin"));

if(!in_array("address2", $fields)) {
    $this->query("ALTER TABLE `admin` ADD `address2` VARCHAR(255) NULL AFTER `address`");
}

if(!in_array("city", $fields)) {
    $this->query("ALTER TABLE `admin` ADD `city` VARCHAR(255) NULL AFTER `address2`");
}

if(!in_array("zip_code", $fields)) {
    $this->query("ALTER TABLE `admin` ADD `zip_code` VARCHAR(255) NULL AFTER `city`");
}

if(!in_array("region_code", $fields)) {
    $this->query("ALTER TABLE `admin` ADD `region_code` VARCHAR(255) NULL AFTER `zip_code`");
}

if(!in_array("region", $fields)) {
    $this->query("ALTER TABLE `admin` ADD `region` VARCHAR(255) NULL AFTER `region_code`");
}
