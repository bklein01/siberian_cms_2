<?php

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

$categories = array(
    array(
        "code" => "social",
        "name" => "Social",
        "icon" => "icon-share",
        "position" => 10,
        "features" => array(
            "newswall",
            "fanwall",
            "social_gaming",
            "facebook"
        )
    ), array(
        "code" => "media",
        "name" => "Media",
        "icon" => "icon-play",
        "position" => 20,
        "features" => array(
            "image_gallery",
            "video_gallery",
            "music_gallery",
            "radio",
            "rss_feed"
        )
    ), array(
        "code" => "contact",
        "name" => "Contact",
        "icon" => "icon-phone",
        "position" => 30,
        "features" => array(
            "contact",
            "push_notification",
            "inapp_messages",
            "topic",
            "booking",
            "form"
        )
    ), array(
        "code" => "monetization",
        "name" => "Monetization",
        "icon" => "icon-money",
        "position" => 40,
        "features" => array(
            "m_commerce",
            "discount",
            "catalog",
            "set_meal",
            "loyalty",
            "qr_discount"
        )
    ), array(
        "code" => "customization",
        "name" => "Customization",
        "icon" => "icon-edit",
        "position" => 50,
        "features" => array(
            "custom_page",
            "source_code"
        )
    ), array(
        "code" => "integration",
        "name" => "Integration",
        "icon" => "icon-globe",
        "position" => 60,
        "features" => array(
            "weblink_mono",
            "weblink_multi",
            "wordpress",
            "magento",
            "woocommerce",
            "volusion",
            "shopify",
            "prestashop"
        )
    ), array(
        "code" => "events",
        "name" => "Events",
        "icon" => "icon-calendar",
        "position" => 70,
        "features" => array(
            "calendar"
        )
    ), array(
        "code" => "misc",
        "name" => "Misc",
        "icon" => "icon-code",
        "position" => 80,
        "features" => array(
            "folder",
            "padlock",
            "places",
            "code_scan"
        )
    )
);

$this->query("ALTER TABLE `application_option` ADD `category_id` INT(11) UNSIGNED NOT NULL AFTER `option_id`;");

foreach($categories as $category_data) {
    $category = new Application_Model_Option_Category();
    $category->setData($category_data)
        ->save()
    ;
    foreach($category_data["features"] as $feature_code) {
        $this->_db->update("application_option", array("category_id" => $category->getId()), array("code = ?" => $feature_code));
    }
}


$option = new Application_Model_Option();
$options = $option->findAll(array("uncategorized" => new Zend_Db_Expr("category_id = 0")));
if($options->count() > 0) {
    $category = new Application_Model_Option_Category();
    $category->setData(array(
        "code" => "other",
        "name" => "Other",
        "icon" => "icon-circle",
        "position" => 1000
    ))->save();
    $this->_db->update("application_option", array("category_id" => $category->getId()), array("category_id = ?" => "0"));
}

$this->query("
    ALTER TABLE `application_option`
        ADD CONSTRAINT `FK_APPLICATION_OPTION_CATEGORY_ID`
            FOREIGN KEY (`category_id`) REFERENCES `application_option_category` (`category_id`) ON UPDATE CASCADE ON DELETE CASCADE;
");
