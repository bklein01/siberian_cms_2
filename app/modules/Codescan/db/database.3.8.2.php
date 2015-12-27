<?php

$resource = new Acl_Model_Resource();
$resource->find("features", "code");

if($resource_id = $resource->getId()) {

    $data = array(
        "parent_id" => $resource_id,
        "code"      => "feature_code_scan",
        "label"     => "Code Scan",
        "url"       => "codescan/application/*"
    );

    $resource = new Acl_Model_Resource();
    $resource->find("feature_code_scan", "code");
    $resource->addData($data)->save();

}
