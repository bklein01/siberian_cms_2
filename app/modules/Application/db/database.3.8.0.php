<?php

$this->query("
  ALTER TABLE `application`
    ADD `unlock_by` VARCHAR(50) NULL DEFAULT 'account' AFTER `use_ads`,
    ADD `unlock_code` VARCHAR(10) NULL AFTER `unlock_by`
");