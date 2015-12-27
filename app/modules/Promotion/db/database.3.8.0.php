<?php

$media_library = new Media_Model_Library();
$media_library->find("Code Scan", "name");

$last_icon = count($media_library->getIcons())-1;
$icons = $media_library->getIcons();
$icon_id = $icons[$last_icon]->getId();

$option = new Application_Model_Option();
$all_options = $option->findAll("", "position DESC");

$option_data = array(
    "code" => "qr_discount",
    "name" => "QR Coupons",
    "model" => "Promotion_Model_Promotion",
    "library_id" => $media_library->getId(),
    "icon_id" => $icon_id,
    "desktop_uri" => "promotion/application/",
    "mobile_uri" => "promotion/mobile_list/",
    "position" => $all_options[0]->getPosition()+10
);
$option->setData($option_data)->save();

$this->query("
    ALTER TABLE `promotion`
      ADD `unlock_by` enum('account', 'qrcode') NOT NULL DEFAULT 'account' AFTER `owner`,
      ADD `unlock_code` VARCHAR(10) NULL AFTER `unlock_by`
    ;
");
