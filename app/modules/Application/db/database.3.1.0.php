<?php

$this->query("
    ALTER TABLE `application`
        ADD `facebook_id` VARCHAR(20) NULL DEFAULT NULL AFTER `subdomain_is_validated`,
        ADD `facebook_key` VARCHAR(50) NULL DEFAULT NULL AFTER `facebook_id`
    ;
");
