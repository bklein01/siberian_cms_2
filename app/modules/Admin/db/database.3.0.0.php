<?php

$this->query("ALTER TABLE `admin` ADD `publication_access_type` ENUM('sources', 'info') NULL DEFAULT NULL AFTER `password`");
