<?php

$this->query("
    ALTER TABLE `push_messages` ADD `type_id` INT(2) NOT NULL DEFAULT '1' AFTER `app_id`;
");

$this->query("
    ALTER TABLE `push_messages` ADD `cover` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `text`;
");