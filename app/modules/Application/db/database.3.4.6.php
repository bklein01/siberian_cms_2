<?php

$this->query("
    ALTER TABLE `application_device`
        ADD `developer_account_username` VARCHAR(255) NULL DEFAULT NULL AFTER `version`,
        ADD `developer_account_password` VARCHAR(255) NULL DEFAULT NULL AFTER `developer_account_username`,
        ADD `use_our_developer_account` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `developer_account_password`
    ;
");