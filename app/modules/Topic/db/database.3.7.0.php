<?php

$this->query("
    CREATE TABLE topic (
          `topic_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `value_id` int(11) unsigned NOT NULL,
          `app_id` int(11) unsigned NOT NULL,
          `description` VARCHAR(250) COLLATE utf8_unicode_ci NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL,
          PRIMARY KEY (`topic_id`),
          KEY KEY_VALUE_ID (value_id),
          KEY option_value (value_id),
          KEY app_id (app_id)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    ALTER TABLE topic
    ADD CONSTRAINT FK_TOPIC_APP_ID FOREIGN KEY (`app_id`) REFERENCES `application` (`app_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT FK_TOPIC_VALUE_ID FOREIGN KEY (`value_id`) REFERENCES `application_option_value` (`value_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$library = new Media_Model_Library();
$library->setName('Topics')->save();

$icon_paths = array(
    '/topic/topics1.png',
    '/topic/topics2.png',
    '/topic/topics3.png',
    '/topic/topics4.png',
);

$icon_id = 0;
foreach($icon_paths as $key => $icon_path) {
    $datas = array('library_id' => $library->getId(), 'link' => $icon_path, 'can_be_colorized' => 1);
    $image = new Media_Model_Library_Image();
    $image->setData($datas)->save();

    if($key == 0) $icon_id = $image->getId();
}

$datas = array(
    'library_id' => $library->getId(),
    'icon_id' => $icon_id,
    'code' => 'topic',
    'name' => 'Topics',
    'model' => 'Topic_Model_Topic',
    'desktop_uri' => 'topic/application/',
    'mobile_uri' => 'topic/mobile_view/',
    'only_once' => 1,
    'is_ajax' => 1,
    'position' => 241
);
$option = new Application_Model_Option();
$option->setData($datas)->save();

$this->query("
  ALTER TABLE `push_messages` ADD `send_to_all` TINYINT(1) NOT NULL AFTER `radius`;
");

$this->query("
    CREATE TABLE `topic_category` (
      `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `topic_id` int(11) unsigned NOT NULL,
      `parent_id` int(11) unsigned DEFAULT NULL,
      `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
      `description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
      `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
      `position` int(11) NOT NULL,
      `created_at` datetime NOT NULL,
      `updated_at` datetime NOT NULL,
      PRIMARY KEY (`category_id`),
      KEY `topic_id` (`topic_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    ALTER TABLE `topic_category`
    ADD CONSTRAINT `FK_TOPIC_CATEGORY_TOPIC_ID` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
    CREATE TABLE `topic_category_message` (
      `category_message_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `category_id` int(11) unsigned NOT NULL,
      `message_id` int(11) unsigned NOT NULL,
      PRIMARY KEY (`category_message_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `topic_subscription` (
      `subscription_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `category_id` int(11) unsigned NOT NULL,
      `device_uid` text COLLATE utf8_unicode_ci NOT NULL,
      PRIMARY KEY (`subscription_id`),
      KEY `category_id` (`category_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    ALTER TABLE `topic_subscription`
    ADD CONSTRAINT `FK_TOPIC_SUBSCRIPTION_CATEGORY_ID` FOREIGN KEY (`category_id`) REFERENCES `topic_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");