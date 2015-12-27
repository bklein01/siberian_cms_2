<?php

$this->query("
    CREATE TABLE `promotion` (
        `promotion_id` int(11) NOT NULL AUTO_INCREMENT,
        `value_id` int(11) unsigned NOT NULL,
        `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `picture` VARCHAR(255) NULL DEFAULT NULL,
        `description` text COLLATE utf8_unicode_ci NOT NULL,
        `conditions` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        `is_unique` tinyint(1) NOT NULL DEFAULT '0',
        `end_at` date DEFAULT NULL,
        `force_validation` tinyint(1) unsigned NOT NULL DEFAULT '0',
        `is_active` tinyint(1) NOT NULL DEFAULT '1',
        `condition_type` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
        `condition_number_of_points` tinyint(2) DEFAULT NULL,
        `condition_period_number` tinyint(2) DEFAULT NULL,
        `condition_period_type` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
        `is_shared` tinyint(1) NOT NULL DEFAULT '0',
        `owner` tinyint(1) NOT NULL DEFAULT '1',
        `unlock_by` enum('account', 'qrcode') NOT NULL DEFAULT 'account',
        `unlock_code` VARCHAR(10) NULL DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`promotion_id`),
        KEY `KEY_VALUE_ID` (`value_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

    CREATE TABLE `promotion_customer` (
        `promotion_customer_id` int(11) NOT NULL AUTO_INCREMENT,
        `promotion_id` int(11) NOT NULL,
        `pos_id` int(11) DEFAULT NULL,
        `customer_id` int(11) UNSIGNED NOT NULL,
        `is_used` tinyint(1) unsigned NOT NULL DEFAULT '0',
        `number_of_error` tinyint(1) unsigned NOT NULL DEFAULT '0',
        `created_at` datetime NOT NULL,
        `last_error` datetime DEFAULT NULL,
        PRIMARY KEY (`promotion_customer_id`),
        KEY `KEY_PROMOTION_ID` (`promotion_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");


$this->query("
    ALTER TABLE `promotion`
        ADD FOREIGN KEY `FK_VALUE_ID` (`value_id`) REFERENCES `application_option_value` (`value_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
    ALTER TABLE `promotion_customer`
        ADD FOREIGN KEY `FK_PROMOTION_ID` (`promotion_id`) REFERENCES `promotion` (`promotion_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");


$library = new Media_Model_Library();
$library->setName("Discount")->save();

$icon_paths = array(
    "/discount/discount1.png",
    "/discount/discount2.png",
    "/discount/discount3.png",
    "/discount/discount4.png",
    "/discount/discount5.png",
    "/loyalty/loyalty6.png",
);

$icon_id = 0;
foreach($icon_paths as $key => $icon_path) {
    $data = array("library_id" => $library->getId(), "link" => $icon_path, "can_be_colorized" => 1);
    $image = new Media_Model_Library_Image();
    $image->setData($data)->save();

    if($key == 0) $icon_id = $image->getId();
}

$category = new Application_Model_Option_Category();
$category->find("monetization", "code");

$data = array(
    "category_id" => $category->getId(),
    "library_id" => $library->getId(),
    "icon_id" => $icon_id,
    "code" => "discount",
    "name" => "Discount",
    "model" => "Promotion_Model_Promotion",
    "desktop_uri" => "promotion/application/",
    "mobile_uri" => "promotion/mobile_list/",
    "mobile_view_uri" => "promotion/mobile_view/",
    "mobile_view_uri_parameter" => "promotion_id",
    "only_once" => 0,
    "is_ajax" => 1,
    "position" => 20,
    "social_sharing_is_available" => 1
);
$option = new Application_Model_Option();
$option->setData($data)->save();


$layouts = array(
    array(
        "code" => 1,
        "option_id" => $option->getId(),
        "name" => "Layout 1",
        "preview" => "/customization/layout/promotion/layout-1.png",
        "position" => 1
    ), array(
        "code" => 2,
        "option_id" => $option->getId(),
        "name" => "Layout 2",
        "preview" => "/customization/layout/promotion/layout-2.png",
        "position" => 2
    ));

foreach($layouts as $data) {
    $this->_db->insert("application_option_layout", $data);
}


$media_library = new Media_Model_Library();
$media_library->find("Code Scan", "name");

$last_icon = count($media_library->getIcons())-1;
$icons = $media_library->getIcons();
$icon_id = $icons[$last_icon]->getId();


$data = array(
    "category_id" => $category->getId(),
    "library_id" => $media_library->getId(),
    "icon_id" => $icon_id,
    "code" => "qr_discount",
    "name" => "QR Coupons",
    "model" => "Promotion_Model_Promotion",
    "desktop_uri" => "promotion/application/",
    "mobile_uri" => "promotion/mobile_list/",
    "mobile_view_uri" => "promotion/mobile_view/",
    "mobile_view_uri_parameter" => "promotion_id",
    "social_sharing_is_available" => 1,
    "position" => 25
);
$option = new Application_Model_Option();
$option->setData($data)->save();


$layouts = array();

foreach(array(3, 4) as $layout_code) {
    $layouts[] = array(
        "code" => $layout_code,
        "option_id" => $option->getId(),
        "name" => "Layout {$layout_code}",
        "preview" => "/customization/layout/promotion/layout-{$layout_code}.png",
        "position" => $layout_code
    );
}

foreach ($layouts as $data) {
    $this->_db->insert("application_option_layout", $data);
}
