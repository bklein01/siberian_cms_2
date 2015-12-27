<?php
   $this->query("
        ALTER TABLE `application_option_preview_language` CHANGE `language_code` `language_code` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fr';
   ");