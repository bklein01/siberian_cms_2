<?php

$resource = new Acl_Model_Resource();
$resource->find("features", "code");

if($resource->getId()) {
    $resource->setCode("feature")
        ->save()
    ;
}