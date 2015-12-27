<?php

$this->query("
    CREATE TABLE `maps` (
      `maps_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `value_id` int(11) unsigned NOT NULL,
      `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
      `latitude` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
      `longitude` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
      PRIMARY KEY(`maps_id`),
      KEY `value_id` (`value_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

$this->query("
    ALTER TABLE `maps` ADD CONSTRAINT `FK_MAPS_VALUE_ID` FOREIGN KEY (`value_id`) REFERENCES `application_option_value`(`value_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
    ALTER TABLE `maps` ADD `unit` VARCHAR(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ;
");


// Create the gallery
$library = new Media_Model_Library();
$library->setName('Maps')->save();

// Create the icons
$icons = array(
    "/maps/maps1.png",
    "/maps/maps2.png",
    "/maps/maps3.png"
);

$icon_id = null;
foreach($icons as $icon) {
    $data = array('library_id' => $library->getId(), 'link' => $icon, 'can_be_colorized' => 1);
    $image = new Media_Model_Library_Image();
    $image->setData($data)->save();
    if(is_null($icon_id)) {
        $icon_id = $image->getId();
    }
}


$category = new Application_Model_Option_Category();
$category->find("misc","code");

$data = array(
    'category_id' => $category->getId(),
    'library_id' => $library->getId(),
    'icon_id' => $icon_id,
    'code' => 'maps',
    'name' => 'Maps',
    'model' => 'Maps_Model_Maps',
    'desktop_uri' => 'maps/application/',
    'mobile_uri' => 'maps/mobile_view/',
    'only_once' => 0,
    'is_ajax' => 1,
    'position' => 240
);

$option = new Application_Model_Option();
$option->setData($data)->save();
