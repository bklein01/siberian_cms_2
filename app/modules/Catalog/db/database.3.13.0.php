<?php

$layout_data = array(
    array("code" => "catalog", "image_path" => "/customization/layout/catalog"),
    array("code" => "set_meal", "image_path" => "/customization/layout/set-meal")
);

foreach($layout_data as $data) {

    $layouts = array();
    $option = new Application_Model_Option();
    $option->find($data["code"], "code");

    foreach(array(1, 2, 3) as $layout_code) {
        $layouts[] = array(
            "code" => $layout_code,
            "option_id" => $option->getId(),
            "name" => "Layout {$layout_code}",
            "preview" => "{$data["image_path"]}/layout-{$layout_code}.png",
            "position" => $layout_code
        );
    }

    foreach ($layouts as $data) {
        $this->_db->insert("application_option_layout", $data);
    }

}