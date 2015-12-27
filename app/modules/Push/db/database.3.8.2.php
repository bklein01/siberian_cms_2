<?php

$this->query("
    ALTER TABLE `push_messages` ADD `action_value` VARCHAR(255) DEFAULT NULL AFTER `cover`;
");

