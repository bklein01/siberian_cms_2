<?php

$this->query("
    CREATE TABLE `api_provider` (
        `provider_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `code` varchar(30) NOT NULL,
        `name` varchar(60) NOT NULL,
        `icon` varchar(50) NULL DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`provider_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

    CREATE TABLE `api_key` (
        `key_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `provider_id` int(11) unsigned NOT NULL,
        `key` varchar(30) NULL DEFAULT NULL,
        `value` varchar(255) NULL DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`key_id`),
        KEY `KEY_PROVIDER_ID` (`provider_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `api_user` (
        `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `username` varchar(50) NOT NULL,
        `firstname` varchar(50) NULL DEFAULT NULL,
        `lastname` varchar(50) NULL DEFAULT NULL,
        `password` varchar(100) NOT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    ALTER TABLE `api_key`
        ADD FOREIGN KEY `FK_PROVIDER_ID` (`provider_id`) REFERENCES `api_provider` (`provider_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$apis = array(
    array(
        "code" => "instagram",
        "icon" => "fa-instagram",
        "keys" => array(
            "token",
            "client_id"
        )
    ),
    array(
        "code" => "facebook",
        "icon" => "fa-facebook-square",
        "keys" => array(
            "app_id",
            "secret_key"
        )
    ),
    array(
        "code" => "youtube",
        "icon" => "fa-youtube",
        "keys" => array(
            "api_key"
        )
    ),
    array(
        "code" => "soundcloud",
        "icon" => "fa-soundcloud",
        "keys" => array(
            "client_id",
            "secret_id"
        )
    )
);

foreach($apis as $provider_data) {

    $provider_name = ucfirst($provider_data["code"]);
    $provider = new Api_Model_Provider();

    $provider->setData(array(
        "code" => $provider_data["code"],
        "name" => $provider_name,
        "icon" => $provider_data["icon"]
    ))->save();

    foreach($provider_data["keys"] as $key) {
        $data = array(
            'provider_id' => $provider->getId(),
            'key' => $key
        );

        $key = new Api_Model_Key();
        $key->setData($data)->save();

    }

}
