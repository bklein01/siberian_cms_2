<?php

$features = array(
    'Magento' => array(
        'icon_path' => '/magento/magento1.png',
        'datas' => array(
            'code' => 'magento',
            'name' => 'Magento',
            'model' => 'Weblink_Model_Type_Mono',
            'desktop_uri' => 'weblink/application_magento/',
            'mobile_uri' => 'weblink/mobile_mono/',
            'only_once' => 0,
            'is_ajax' => 0,
            'position' => 155
        )
    ),
    'WooCommerce' => array(
        'icon_path' => '/woocommerce/woocommerce1.png',
        'datas' => array(
            'code' => 'woocommerce',
            'name' => 'WooCommerce',
            'model' => 'Weblink_Model_Type_Mono',
            'desktop_uri' => 'weblink/application_woocommerce/',
            'mobile_uri' => 'weblink/mobile_mono/',
            'only_once' => 0,
            'is_ajax' => 0,
            'position' => 155
        )
    ),
    'Prestashop' => array(
        'icon_path' => '/prestashop/prestashop1.png',
        'datas' => array(
            'code' => 'prestashop',
            'name' => 'Prestashop',
            'model' => 'Weblink_Model_Type_Mono',
            'desktop_uri' => 'weblink/application_prestashop/',
            'mobile_uri' => 'weblink/mobile_mono/',
            'only_once' => 0,
            'is_ajax' => 0,
            'position' => 155
        )
    ),
    'Volusion' => array(
        'icon_path' => '/volusion/volusion1.png',
        'datas' => array(
            'code' => 'volusion',
            'name' => 'Volusion',
            'model' => 'Weblink_Model_Type_Mono',
            'desktop_uri' => 'weblink/application_volusion/',
            'mobile_uri' => 'weblink/mobile_mono/',
            'only_once' => 0,
            'is_ajax' => 0,
            'position' => 155
        )
    ),
    'Shopify' => array(
        'icon_path' => '/shopify/shopify1.png',
        'datas' => array(
            'code' => 'shopify',
            'name' => 'Shopify',
            'model' => 'Weblink_Model_Type_Mono',
            'desktop_uri' => 'weblink/application_shopify/',
            'mobile_uri' => 'weblink/mobile_mono/',
            'only_once' => 0,
            'is_ajax' => 0,
            'position' => 155
        )
    )
);

$resource = new Acl_Model_Resource();
$resource->find("feature", "code");
$resource_id = $resource->getId();

foreach($features as $feature_name => $feature) {
    $library = new Media_Model_Library();
    $library->setName($feature_name)->save();

    $datas = array('library_id' => $library->getId(), 'link' => $feature['icon_path'], 'can_be_colorized' => 1);
    $image = new Media_Model_Library_Image();
    $image->setData($datas)->save();

    $icon_id = $image->getId();

    $datas = $feature['datas'];

    $datas['library_id'] = $library->getId();
    $datas['icon_id'] = $icon_id;

    $option = new Application_Model_Option();
    $option->setData($datas)->save();

    if($resource_id) {

        $data = array(
            "parent_id" => $resource_id,
            "code"      => "feature_" . $feature['datas']['code'],
            "label"     => $feature_name,
            "url"       => $feature['datas']['desktop_uri']
        );

        $resource = new Acl_Model_Resource();
        $resource->find("feature_" . $feature['datas']['code'], "code");
        $resource->addData($data)->save();

    }
}
