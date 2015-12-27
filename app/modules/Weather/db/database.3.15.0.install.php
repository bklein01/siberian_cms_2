<?php

$this->query("
    CREATE TABLE `weather` (
      `weather_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `value_id` int(11) unsigned NOT NULL,
      `city` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
      `country_code` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
      `unit` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'f',
      `woeid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
      PRIMARY KEY(`weather_id`),
      KEY `value_id` (`value_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

$this->query("
    ALTER TABLE `weather` ADD CONSTRAINT `FK_WEATHER_VALUE_ID` FOREIGN KEY (`value_id`) REFERENCES `application_option_value`(`value_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");


// Create the gallery
$library = new Media_Model_Library();
$library->setName('Weather')->save();

// Create the icons
$icons = array(
    "/weather/weather1.png",
    "/weather/weather2.png",
    "/weather/weather3.png"
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

// Categorization
$category = new Application_Model_Option_Category();
$category->find("misc", "code");

$data = array(
    'category_id' => $category->getId(),
    'library_id' => $library->getId(),
    'icon_id' => $icon_id,
    'code' => 'weather',
    'name' => 'Weather',
    'model' => 'Weather_Model_Weather',
    'desktop_uri' => 'weather/application/',
    'mobile_uri' => 'weather/mobile_view/',
    'only_once' => 0,
    'is_ajax' => 1,
    'position' => 240,
);

$option = new Application_Model_Option();
$option->setData($data)->save();
