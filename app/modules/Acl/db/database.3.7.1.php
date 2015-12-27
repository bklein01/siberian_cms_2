<?php

$resource = new Acl_Model_Resource();
$resource->find("features", "code");
$resources = $resource->findAll(array("parent_id = ?" => $resource->getId()));

foreach($resources as $resource) {
    if(stripos($resource->getData("url"), "*") === false) {
        $resource->setUrl($resource->getData("url")."*")
            ->save()
        ;
    }
}
