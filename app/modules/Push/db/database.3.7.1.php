<?php
$resource = new Acl_Model_Resource();
$resource->find("features", "code");

if($resource_id = $resource->getId()) {

    $data = array(
        "parent_id" => $resource_id,
        "code"      => "feature_inapp_messages",
        "label"     => "In-App Messages",
        "url"       => "push/application/*"
    );

    $resource = new Acl_Model_Resource();
    $resource->find("feature_inapp_messages", "code");
    $resource->addData($data)->save();

}
$this->query("
    UPDATE `application_option` SET `model` = 'Push_Model_Message', `name` = 'In-App Messages' WHERE `code` = 'inapp_messages';
");

