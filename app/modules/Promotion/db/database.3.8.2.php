<?php

$resource = new Acl_Model_Resource();
$resource->find("features", "code");

if($resource_id = $resource->getId()) {

    $data = array(
        "parent_id" => $resource_id,
        "code"      => "feature_qr_discount",
        "label"     => "QR Coupons",
        "url"       => "promotion/application/*"
    );

    $resource = new Acl_Model_Resource();
    $resource->find("feature_qr_discount", "code");
    $resource->addData($data)->save();

}
