<?php

$this->query("
    CREATE TABLE `message_application` (
        `message_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `author_id` int(11) unsigned NOT NULL,
        `app_id` int(11) unsigned NOT NULL,
        `message` text COLLATE utf8_unicode_ci NOT NULL,
        `created_at` datetime NOT NULL,
        PRIMARY KEY (`message_id`),
        KEY `author_id` (`author_id`),
        KEY `app_id` (`app_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `message_application_file` (
        `file_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `message_id` int(11) unsigned NOT NULL,
        `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (`file_id`),
        KEY `message_id` (`message_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;
");

$this->query("
    ALTER TABLE `message_application`
        ADD CONSTRAINT `FK_MESSAGE_APPLICATION_APP_ID`
            FOREIGN KEY (`app_id`) REFERENCES `application` (`app_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
    ALTER TABLE `message_application_file`
        ADD CONSTRAINT `FK_MESSAGE_APPLICATION_FILE_MESSAGE_ID`
            FOREIGN KEY (`message_id`) REFERENCES `message_application` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");


$resource = new Acl_Model_Resource();
$resource->find("editor_settings", "code");

if($resource_id = $resource->getId()) {

    $data = array(
        "parent_id" => $resource_id,
        "code"      => "editor_settings_messages",
        "label"     => "Access the editor messages",
        "url"       => "message/application/*"
    );

    $resource = new Acl_Model_Resource();
    $resource->find("editor_settings_messages", "code");
    $resource->addData($data)->save();

}
