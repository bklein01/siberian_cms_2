<?php

$resources = array(
    array(
        "code" => "feature_magento",
        "label" => "Magento",
        "url" => "weblink/application_magento/*",
    ), array(
        "code" => "feature_woocommerce",
        "label" => "WooCommerce",
        "url" => "weblink/application_woocommerce/*",
    ), array(
        "code" => "feature_prestashop",
        "label" => "Prestashop",
        "url" => "weblink/application_prestashop/*",
    ), array(
        "code" => "feature_volusion",
        "label" => "Volusion",
        "url" => "weblink/application_volusion/*",
    ),
    array(
        "code" => "feature_shopify",
        "label" => "Shopify",
        "url" => "weblink/application_shopify/*"
    )
);

$resource = new Acl_Model_Resource();
$resource->find("feature", "code");

if($resource_id = $resource->getId()) {

    foreach($resources as $data) {

        $resource = new Acl_Model_Resource();
        $resource->find($data["code"], "code");

        if(!$resource->getId()) {
            $data["parent_id"] = $resource_id;
            $resource->addData($data)->save();
        }

    }

}
