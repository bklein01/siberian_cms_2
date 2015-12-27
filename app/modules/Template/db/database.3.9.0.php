<?php

$this->query("ALTER TABLE `template_block` ADD `type_id` TINYINT(1) UNSIGNED NULL DEFAULT NULL AFTER `block_id`;");

$this->_db->update("template_block", array("type_id" => 1), array());