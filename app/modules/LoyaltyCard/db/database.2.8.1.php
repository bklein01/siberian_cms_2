<?php

$option = new Application_Model_Option();
$option->find("loyalty", "code");
$option->setOnlyOnce(0)->save();

$this->query("ALTER TABLE `loyalty_card` ADD use_once TINYINT(1) NOT NULL DEFAULT 0 AFTER `conditions`;");
