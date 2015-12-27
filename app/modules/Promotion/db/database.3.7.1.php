<?php

$this->query("ALTER TABLE `promotion` ADD `picture` VARCHAR(255) NULL DEFAULT NULL AFTER `title`");

$promotion = new Application_Model_Option();
$promotion->find("discount", "code");

$layouts = array(
    array(
        "code" => 1,
        "option_id" => $promotion->getId(),
        "name" => "Layout 1",
        "preview" => "/customization/layout/promotion/layout-1.png",
        "position" => 1
    ), array(
        "code" => 2,
        "option_id" => $promotion->getId(),
        "name" => "Layout 2",
        "preview" => "/customization/layout/promotion/layout-2.png",
        "position" => 2
));

foreach($layouts as $data) {
    $this->_db->insert("application_option_layout", $data);
}