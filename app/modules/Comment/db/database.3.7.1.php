<?php

$fields = array_keys($this->_db->describeTable("comment"));
$field = in_array("customer_id", $fields) ? "customer_id" : "value_id";

$this->query("
    ALTER TABLE `comment`
        ADD `title` VARCHAR(100) NULL DEFAULT NULL AFTER `{$field}`,
        ADD `subtitle` VARCHAR(255) NULL DEFAULT NULL AFTER `title`,
        ADD `date` VARCHAR(100) NULL DEFAULT NULL AFTER `image`
    ;
");


$newswall = new Application_Model_Option();
$newswall->find("newswall", "code");

$layouts = array(
    array(
        "code" => 1,
        "option_id" => $newswall->getId(),
        "name" => "Layout 1",
        "preview" => "/customization/layout/newswall/layout-1.png",
        "position" => 1
    ), array(
        "code" => 2,
        "option_id" => $newswall->getId(),
        "name" => "Layout 2",
        "preview" => "/customization/layout/newswall/layout-2.png",
        "position" => 2
));

foreach($layouts as $data) {
    $this->_db->insert("application_option_layout", $data);
}