<?php

$this->query("
    CREATE TABLE `application_option_preview` (
      `preview_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `option_id` int(11) unsigned NOT NULL,
      PRIMARY KEY (`preview_id`),
      KEY option_id (`option_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
");

$this->query("
  ALTER TABLE `application_option_preview`
  ADD CONSTRAINT `FK_APPLICATION_OPTION_OPTION_ID` FOREIGN KEY (`option_id`) REFERENCES `application_option` (`option_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
  CREATE TABLE `application_option_preview_language` (
    `preview_id` int(11) unsigned NOT NULL,
    `library_id` int(11) unsigned NOT NULL,
    `language_code` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fr',
    `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `description` text COLLATE utf8_unicode_ci,
    KEY `library_id` (`library_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    ALTER TABLE `application_option_preview_language`
    ADD CONSTRAINT `FK_OPTION_PREVIEW_LANGUAGE_PREVIEW_ID` FOREIGN KEY (`preview_id`) REFERENCES `application_option_preview` (`preview_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `FK_OPTION_PREVIEW_LANGUAGE_LIBRARY_ID` FOREIGN KEY (`library_id`) REFERENCES `media_library` (`library_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");