<?php

$layouts = array();
$option = new Application_Model_Option();
$option->find("rss_feed", "code");

foreach(array(1, 2, 3) as $layout_code) {
    $layouts[] = array(
        "code" => $layout_code,
        "option_id" => $option->getId(),
        "name" => "Layout {$layout_code}",
        "preview" => "/customization/layout/rss-feed/layout-{$layout_code}.png",
        "position" => $layout_code
    );
}

foreach ($layouts as $data) {
    $this->_db->insert("application_option_layout", $data);
}
