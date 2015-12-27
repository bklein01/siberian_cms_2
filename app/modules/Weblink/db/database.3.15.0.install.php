<?php

$this->query("
    CREATE TABLE `weblink` (
        `weblink_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `value_id` int(11) unsigned NOT NULL,
        `type_id` tinyint(1) unsigned NOT NULL DEFAULT '1',
        `cover` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`weblink_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

    CREATE TABLE `weblink_link` (
        `link_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `weblink_id` int(11) unsigned NOT NULL,
        `picto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `title` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
        `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `position` tinyint(1) unsigned NOT NULL DEFAULT '0',
        PRIMARY KEY (`link_id`),
        KEY `KEY_WEBLINK_ID` (`weblink_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");


$this->query("
    ALTER TABLE `weblink_link`
        ADD FOREIGN KEY `FK_WEBLINK_ID` (`weblink_id`) REFERENCES `weblink` (`weblink_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");


$library = new Media_Model_Library();
$library->setName('Weblink')->save();

$icon_paths = array(
    '/weblink/link1.png',
    '/weblink/link2.png',
    '/weblink/link3.png'
);

$icon_id = 0;
foreach($icon_paths as $key => $icon_path) {
    $data = array('library_id' => $library->getId(), 'link' => $icon_path, 'can_be_colorized' => 1);
    $image = new Media_Model_Library_Image();
    $image->setData($data)->save();

    if($key == 0) $icon_id = $image->getId();
}

$category = new Application_Model_Option_Category();
$category->find("integration", "code");

$data = array(
    'category_id' => $category->getId(),
    'library_id' => $library->getId(),
    'icon_id' => $icon_id,
    'code' => "weblink_mono",
    'name' => "Link",
    'model' => "Weblink_Model_Type_Mono",
    'desktop_uri' => "weblink/application_mono/",
    'mobile_uri' => "weblink/mobile_mono/",
    'only_once' => 0,
    'is_ajax' => 0,
    'position' => 150
);
$option = new Application_Model_Option();
$option->setData($data)->save();

$data = array(
    'category_id' => $category->getId(),
    'library_id' => $library->getId(),
    'icon_id' => $icon_id,
    'code' => "weblink_multi",
    'name' => "Links",
    'model' => "Weblink_Model_Type_Multi",
    'desktop_uri' => "weblink/application_multi/",
    'mobile_uri' => "weblink/mobile_multi/",
    'only_once' => 0,
    'is_ajax' => 1,
    'position' => 160
);
$option = new Application_Model_Option();
$option->setData($data)->save();


$features = array(
    'Magento' => array(
        'icon_path' => '/magento/magento1.png',
        'datas' => array(
            'code' => 'magento',
            'name' => 'Magento',
            'model' => 'Weblink_Model_Type_Mono',
            'desktop_uri' => 'weblink/application_magento/',
            'mobile_uri' => 'weblink/mobile_mono/'
        )
    ),
    'WooCommerce' => array(
        'icon_path' => '/woocommerce/woocommerce1.png',
        'datas' => array(
            'code' => 'woocommerce',
            'name' => 'WooCommerce',
            'model' => 'Weblink_Model_Type_Mono',
            'desktop_uri' => 'weblink/application_woocommerce/',
            'mobile_uri' => 'weblink/mobile_mono/'
        )
    ),
    'Prestashop' => array(
        'icon_path' => '/prestashop/prestashop1.png',
        'datas' => array(
            'code' => 'prestashop',
            'name' => 'Prestashop',
            'model' => 'Weblink_Model_Type_Mono',
            'desktop_uri' => 'weblink/application_prestashop/',
            'mobile_uri' => 'weblink/mobile_mono/'
        )
    ),
    'Volusion' => array(
        'icon_path' => '/volusion/volusion1.png',
        'datas' => array(
            'code' => 'volusion',
            'name' => 'Volusion',
            'model' => 'Weblink_Model_Type_Mono',
            'desktop_uri' => 'weblink/application_volusion/',
            'mobile_uri' => 'weblink/mobile_mono/'
        )
    ),
    'Shopify' => array(
        'icon_path' => '/shopify/shopify1.png',
        'datas' => array(
            'code' => 'shopify',
            'name' => 'Shopify',
            'model' => 'Weblink_Model_Type_Mono',
            'desktop_uri' => 'weblink/application_shopify/',
            'mobile_uri' => 'weblink/mobile_mono/'
        )
    )
);

foreach($features as $feature_name => $feature) {

    $library = new Media_Model_Library();
    $library->setName($feature_name)->save();

    $data = array('library_id' => $library->getId(), 'link' => $feature['icon_path'], 'can_be_colorized' => 1);
    $image = new Media_Model_Library_Image();
    $image->setData($data)->save();

    $data = array_merge($feature['datas'], array(
        'category_id' => $category->getId(),
        'library_id' => $library->getId(),
        'icon_id' => $image->getId(),
        'only_once' => 0,
        'is_ajax' => 0,
        'position' => 155
    ));

    $option = new Application_Model_Option();
    $option->setData($data)->save();

}
