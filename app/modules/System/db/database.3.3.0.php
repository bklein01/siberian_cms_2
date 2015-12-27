<?php

$this->query("
    ALTER TABLE `system_config`
        CHANGE `code` `code` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
        CHANGE `label` `label` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
        CHANGE `value` `value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
    ;
");
