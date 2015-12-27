<?php

$editor_resource = new Acl_Model_Resource();
$editor_resource->find("editor", "code");

$resource_data = array(
    array(
        "code" => "editor_settings",
        "label" => "Access the settings from the editor",
        "children" => array(
            array(
                "code" => "editor_settings_tc",
                "label" => "Access the Terms & Conditions tab",
                "url" => "application/settings_tc/*",
            ), array(
                "code" => "editor_settings_facebook",
                "label" => "Access the Facebook tab",
                "url" => "application/settings_facebook/*",
            ), array(
                "code" => "editor_settings_domain",
                "label" => "Access the Domain tab",
                "url" => "application/settings_domain/*",
            ),
        )
    )
);

foreach($resource_data as $data) {
    $data["parent_id"] = $editor_resource->getId();
    $resource = new Acl_Model_Resource();
    $resource->setData($data)
        ->save()
    ;

    if(!empty($data["children"])) {

        foreach($data["children"] as $child_resource) {
            $child = new Acl_Model_Resource();
            $child->setData($child_resource)
                ->setParentId($resource->getId())
                ->save()
            ;
        }

    }

}