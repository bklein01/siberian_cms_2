<?php

$this->query("
    CREATE TABLE `application` (
        `app_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `admin_id` INT(11) UNSIGNED NOT NULL,
        `layout_id` int(11) unsigned NOT NULL,
        `layout_visibility` VARCHAR(10) NOT NULL DEFAULT 'homepage',
        `design_id` INT(11) unsigned NULL DEFAULT NULL,
        `bundle_id` varchar(100) DEFAULT NULL,
        `locale` varchar(6) DEFAULT NULL,
        `tabbar_account_name` varchar(30) DEFAULT NULL,
        `tabbar_more_name` varchar(30) DEFAULT NULL,
        `country_code` varchar(5) DEFAULT NULL,
        `name` varchar(30) DEFAULT NULL,
        `description` longtext NULL DEFAULT NULL,
        `keywords` varchar(255) DEFAULT NULL,
        `main_category_id` tinyint(1) unsigned DEFAULT NULL,
        `secondary_category_id` tinyint(1) unsigned DEFAULT NULL,
        `font_family` varchar(30) DEFAULT NULL,
        `background_image` varchar(255) DEFAULT NULL,
        `background_image_hd` varchar(255) DEFAULT NULL,
        `background_image_tablet` varchar(255) DEFAULT NULL,
        `use_homepage_background_image_in_subpages` tinyint(1) NOT NULL DEFAULT '0',
        `ios_status_bar_is_hidden` boolean DEFAULT 0,
        `logo` varchar(255) DEFAULT NULL,
        `icon` varchar(255) DEFAULT NULL,
        `startup_image` varchar(255) DEFAULT NULL,
        `startup_image_retina` varchar(255) DEFAULT NULL,
        `startup_image_iphone_6` varchar(255) DEFAULT NULL,
        `startup_image_iphone_6_plus` varchar(255) DEFAULT NULL,
        `startup_image_ipad_retina` varchar(255) DEFAULT NULL,
        `homepage_slider_is_visible` boolean DEFAULT 0,
        `homepage_slider_duration` int DEFAULT 3,
        `homepage_slider_loop_at_beginning` boolean DEFAULT 0,
        `homepage_slider_library_id` int DEFAULT NULL,
        `domain` varchar(100) DEFAULT NULL,
        `subdomain` varchar(20) DEFAULT NULL,
        `subdomain_is_validated` tinyint(1) DEFAULT NULL,
        `facebook_id` VARCHAR(20) NULL DEFAULT NULL,
        `facebook_key` VARCHAR(50) NULL DEFAULT NULL,
        `facebook_token` varchar(255) DEFAULT NULL,
        `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
        `use_ads` TINYINT(1) NULL DEFAULT 0,
        `unlock_by` VARCHAR(50) NULL DEFAULT 'account',
        `unlock_code` VARCHAR(10) NULL DEFAULT NULL,
        `banner_title` VARCHAR(150) NULL DEFAULT NULL,
        `banner_author` VARCHAR(150) NULL DEFAULT NULL,
        `banner_button_label` VARCHAR(150) DEFAULT NULL,
        `require_to_be_logged_in` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
        `allow_all_customers_to_access_locked_features` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
        `is_locked` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
        `can_be_published` TINYINT(1) NOT NULL DEFAULT 1,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`app_id`),
        UNIQUE KEY `UNIQUE_KEY_SUBDOMAIN_DOMAIN` (`subdomain`,`domain`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `application_layout_homepage` (
        `layout_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `visibility` VARCHAR(10) NOT NULL DEFAULT 'homepage',
        `code` VARCHAR(10) NOT NULL,
        `name` varchar(50) NOT NULL,
        `preview` varchar(255) NOT NULL,
        `use_more_button` tinyint(1) NOT NULL DEFAULT '0',
        `use_horizontal_scroll` TINYINT(1) NOT NULL DEFAULT '0',
        `number_of_displayed_icons` tinyint(2) NULL DEFAULT NULL,
        `position` VARCHAR(10) NOT NULL DEFAULT 'bottom',
        `order` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
        `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
        PRIMARY KEY (`layout_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("

    CREATE TABLE `application_option` (
        `option_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `category_id` INT(11) UNSIGNED NOT NULL,
        `library_id` int(11) unsigned NOT NULL,
        `icon_id` int(11) NOT NULL,
        `code` varchar(20) NOT NULL,
        `name` varchar(25) NOT NULL,
        `model` varchar(100) NOT NULL,
        `desktop_uri` varchar(100) NOT NULL,
        `mobile_uri` varchar(100) NOT NULL,
        `mobile_view_uri` varchar(100) NULL DEFAULT NULL,
        `mobile_view_uri_parameter` varchar(100) NULL DEFAULT NULL,
        `only_once` tinyint(1) NOT NULL DEFAULT '0',
        `is_ajax` tinyint(1) NOT NULL DEFAULT '1',
        `position` tinyint(1) unsigned NOT NULL DEFAULT '0',
        `social_sharing_is_available` TINYINT(1) NOT NULL DEFAULT 0,
        PRIMARY KEY (`option_id`),
        KEY `KEY_LIBRARY_ID` (`library_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

$this->query("
    CREATE TABLE `application_option_value` (
        `value_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `app_id` INT(11) UNSIGNED NOT NULL,
        `option_id` int(11) unsigned NOT NULL,
        `layout_id` int(11) unsigned NOT NULL DEFAULT '1',
        `icon_id` int(11) DEFAULT NULL,
        `folder_id` int(11) unsigned DEFAULT NULL,
        `folder_category_id` int(11) unsigned DEFAULT NULL,
        `folder_category_position` int(11) unsigned DEFAULT NULL,
        `tabbar_name` varchar(30) DEFAULT NULL,
        `icon` varchar(255) DEFAULT NULL,
        `background_image` varchar(255) DEFAULT NULL,
        `is_visible` tinyint(1) NOT NULL DEFAULT '1',
        `position` tinyint(1) unsigned NOT NULL DEFAULT '0',
        `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
        `social_sharing_is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
        PRIMARY KEY (`value_id`),
        KEY `KEY_APP_ID` (`app_id`),
        KEY `KEY_OPTION_ID` (`option_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE IF NOT EXISTS `application_admin` (
        `app_id` INT(11) UNSIGNED NOT NULL,
        `admin_id` INT(11) UNSIGNED NOT NULL,
        `is_allowed_to_add_pages` TINYINT(1) NOT NULL DEFAULT 1,
        PRIMARY KEY (`app_id`,`admin_id`),
        KEY `sign_id_idxfk` (`admin_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `application_device` (
        `device_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `app_id` INT(11) UNSIGNED NOT NULL,
        `type_id` TINYINT(11) UNSIGNED NOT NULL,
        `status_id` TINYINT(11) UNSIGNED NULL DEFAULT 1,
        `admob_id` VARCHAR(50) NULL DEFAULT NULL,
        `admob_type` enum('banner','interstitial') NOT NULL DEFAULT 'banner',
        `version` VARCHAR(10) NOT NULL DEFAULT '0.0.1',
        `developer_account_username` VARCHAR(255) NULL DEFAULT NULL,
        `developer_account_password` VARCHAR(255) NULL DEFAULT NULL,
        `use_our_developer_account` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
        `store_url` VARCHAR(255) NULL DEFAULT NULL,
        `store_pass` VARCHAR(10) NULL DEFAULT NULL,
        `store_app_id` VARCHAR(150) NULL DEFAULT NULL,
        `banner_store_label` VARCHAR(150) NULL DEFAULT NULL,
        `banner_store_price` VARCHAR(150) NULL DEFAULT NULL,
        `key_pass` VARCHAR(10) NULL DEFAULT NULL,
        `alias` VARCHAR(50) NULL DEFAULT NULL,
        PRIMARY KEY (`device_id`),
        KEY `KEY_APP_ID` (`app_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `application_option_layout` (
        `layout_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `code` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
        `option_id` INT(11) UNSIGNED NOT NULL,
        `name` VARCHAR(50) NOT NULL,
        `preview` VARCHAR(255) NOT NULL,
        `position` TINYINT(1) NOT NULL DEFAULT 1,
        PRIMARY KEY (`layout_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `application_tc` (
        `tc_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `app_id` INT(11) UNSIGNED NOT NULL,
        `type` VARCHAR(50) NOT NULL,
        `text` LONGTEXT NULL DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`tc_id`),
        INDEX `IDX_TC_APPLICATION_APP_ID` (`app_id`),
        UNIQUE `UNIQUE_TC_APPLICATION_APP_ID_TYPE` (`app_id`, `type`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `application_acl_option` (
        `application_acl_option_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `app_id` int(11) unsigned NOT NULL,
        `admin_id` int(11) unsigned NOT NULL,
        `value_id` int(11) unsigned NOT NULL,
        `resource_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (`application_acl_option_id`),
        KEY value_id (`value_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `application_option_category` (
        `category_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `code` VARCHAR(50) NOT NULL DEFAULT 1,
        `name` VARCHAR(50) NOT NULL,
        `icon` VARCHAR(255) NOT NULL,
        `position` TINYINT(1) NOT NULL DEFAULT 1,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`category_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    ALTER TABLE application_acl_option
        ADD CONSTRAINT FK_APPLICATION_ACL_OPTION_VALUE_ID
            FOREIGN KEY (value_id) REFERENCES application_option_value (value_id) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("ALTER TABLE `application` ADD `key` VARCHAR(20) NOT NULL AFTER `bundle_id`;");

$this->query("ALTER TABLE `application` ADD UNIQUE `UNIQUE_APPLICATION_KEY` (`key`);");

$this->query("
    ALTER TABLE `application_option_value`
        ADD FOREIGN KEY (`app_id`) REFERENCES `application` (`app_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
    ALTER TABLE `application_option_value`
        ADD FOREIGN KEY `FK_OPTION_ID` (`option_id`) REFERENCES `application_option` (`option_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
    ALTER TABLE `application_admin`
        ADD FOREIGN KEY `FK_APPLICATION_APP_ID` (`app_id`) REFERENCES `application` (`app_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
    ALTER TABLE `application_device`
        ADD CONSTRAINT `APPLICATION_DEVICE_APP_ID`
            FOREIGN KEY (`app_id`) REFERENCES `application` (`app_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
    ALTER TABLE `application_tc`
        ADD CONSTRAINT `FK_APPLICATION_TC_APP_ID`
            FOREIGN KEY (`app_id`) REFERENCES `application` (`app_id`) ON UPDATE CASCADE ON DELETE CASCADE;
");

$this->query("
    ALTER TABLE `application_option`
        ADD CONSTRAINT `FK_APPLICATION_OPTION_CATEGORY_ID`
            FOREIGN KEY (`category_id`) REFERENCES `application_option_category` (`category_id`) ON UPDATE CASCADE ON DELETE CASCADE;
");

$this->query("ALTER TABLE `log` ADD FOREIGN KEY `FK_APPLICATION_APPLICATION_ID` (app_id) references `application` (`app_id`) ON UPDATE CASCADE ON DELETE CASCADE;");


$datas = array(
    array('name' => 'Layout 1',              'visibility' => Application_Model_Layout_Homepage::VISIBILITY_ALWAYS,   'code' => 'layout_1',   'preview' => '/customization/layout/homepage/layout_1.png',   'use_more_button' => 1, 'use_horizontal_scroll' => 0, 'number_of_displayed_icons' => 5,     'position' => "bottom", "order" => 1, "is_active" => 1),
    array('name' => 'Layout 2',              'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE, 'code' => 'layout_2',   'preview' => '/customization/layout/homepage/layout_2.png',   'use_more_button' => 1, 'use_horizontal_scroll' => 0, 'number_of_displayed_icons' => 10,    'position' => "bottom", "order" => 2, "is_active" => 1),
    array('name' => 'Layout 3',              'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE, 'code' => 'layout_3',   'preview' => '/customization/layout/homepage/layout_3.png',   'use_more_button' => 0, 'use_horizontal_scroll' => 0, 'number_of_displayed_icons' => null,  'position' => "bottom", "order" => 3, "is_active" => 1),
    array('name' => 'Layout 4',              'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE, 'code' => 'layout_4',   'preview' => '/customization/layout/homepage/layout_4.png',   'use_more_button' => 0, 'use_horizontal_scroll' => 0, 'number_of_displayed_icons' => null,  'position' => "bottom", "order" => 4, "is_active" => 1),
    array('name' => 'Layout 5',              'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE, 'code' => 'layout_5',   'preview' => '/customization/layout/homepage/layout_5.png',   'use_more_button' => 0, 'use_horizontal_scroll' => 0, 'number_of_displayed_icons' => null,  'position' => "bottom", "order" => 5, "is_active" => 1),
    array('name' => 'Layout 6',              'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE, 'code' => 'layout_6',   'preview' => '/customization/layout/homepage/layout_6.png',   'use_more_button' => 0, 'use_horizontal_scroll' => 0, 'number_of_displayed_icons' => null,  'position' => "bottom", "order" => 6, "is_active" => 1),
    array('name' => 'Layout 7',              'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE, 'code' => 'layout_7',   'preview' => '/customization/layout/homepage/layout_7.png',   'use_more_button' => 0, 'use_horizontal_scroll' => 0, 'number_of_displayed_icons' => null,  'position' => "bottom", "order" => 7, "is_active" => 1),
    array('name' => 'Layout 8',              'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE, 'code' => 'layout_8',   'preview' => '/customization/layout/homepage/layout_8.png',   'use_more_button' => 0, 'use_horizontal_scroll' => 0, 'number_of_displayed_icons' => null,  'position' => "bottom", "order" => 8, "is_active" => 0),
    array('name' => 'Layout 9',              'visibility' => Application_Model_Layout_Homepage::VISIBILITY_TOGGLE,   'code' => 'layout_9',   'preview' => '/customization/layout/homepage/layout_9.png',   'use_more_button' => 0, 'use_horizontal_scroll' => 0, 'number_of_displayed_icons' => null,  'position' => "left",   "order" => 9, "is_active" => 1),
    array('name' => 'Layout 3 - Horizontal', 'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE, 'code' => 'layout_3_h', 'preview' => '/customization/layout/homepage/layout_3-h.png', 'use_more_button' => 0, 'use_horizontal_scroll' => 0, "number_of_displayed_icons" => 6,     'position' => "bottom", "order" => 10, "is_active" => 1),
    array('name' => 'Layout 4 - Horizontal', 'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE, 'code' => 'layout_4_h', 'preview' => '/customization/layout/homepage/layout_4-h.png', 'use_more_button' => 0, 'use_horizontal_scroll' => 1, "number_of_displayed_icons" => 6,     'position' => "bottom", "order" => 11, "is_active" => 1),
    array('name' => 'Layout 5 - Horizontal', 'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE, 'code' => 'layout_5_h', 'preview' => '/customization/layout/homepage/layout_5-h.png', 'use_more_button' => 0, 'use_horizontal_scroll' => 1, "number_of_displayed_icons" => 4,     'position' => "bottom", "order" => 12, "is_active" => 1),
    array('name' => 'Layout 10',             'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE, 'code' => 'layout_10',  'preview' => '/customization/layout/homepage/layout_10.png',  'use_more_button' => 1, 'use_horizontal_scroll' => 0, 'number_of_displayed_icons' => 5,     'position' => 'bottom', "order" => 13, "is_active" => 1)
);

foreach($datas as $data) {
    $layout = new Application_Model_Layout_Homepage();
    $layout->setData($data)->save();
}


$categories = array(
    array("code" => "social",       "name" => "Social",         "icon" => "icon-share",     "position" => 10),
    array("code" => "media",        "name" => "Media",          "icon" => "icon-play",      "position" => 20),
    array("code" => "contact",      "name" => "Contact",        "icon" => "icon-phone",     "position" => 30),
    array("code" => "monetization", "name" => "Monetization",   "icon" => "icon-money",     "position" => 40),
    array("code" => "customization","name" => "Customization",  "icon" => "icon-edit",      "position" => 50),
    array("code" => "integration",  "name" => "Integration",    "icon" => "icon-globe",     "position" => 60),
    array("code" => "events",       "name" => "Events",         "icon" => "icon-calendar",  "position" => 70),
    array("code" => "misc",         "name" => "Misc",           "icon" => "icon-code",      "position" => 80)
);

foreach($categories as $category_data) {
    $category = new Application_Model_Option_Category();
    $category->setData($category_data)
        ->save()
    ;
    foreach($category_data["features"] as $feature_code) {
        $this->_db->update("application_option", array("category_id" => $category->getId()), array("code = ?" => $feature_code));
    }
}
