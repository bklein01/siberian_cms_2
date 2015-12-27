<?php
$resource = new Acl_Model_Resource();
$resource->find("features", "code");

if($resource_id = $resource->getId()) {

    $data = array(
        "parent_id" => $resource_id,
        "code"      => "feature_topic",
        "label"     => "Topics",
        "url"       => "topic/application/*"
    );

    $resource = new Acl_Model_Resource();
    $resource->find("feature_topic", "code");
    $resource->addData($data)->save();

}

