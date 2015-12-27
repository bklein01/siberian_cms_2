<?php

$this->query("
    ALTER TABLE `application_layout_homepage`
        ADD `use_horizontal_scroll` TINYINT(1) NOT NULL DEFAULT '0' AFTER `use_more_button`,
        ADD `order` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 AFTER `position`,
        ADD `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 AFTER `order`
    ;
");

$layout = new Application_Model_Layout_Homepage();
$layouts = $layout->findAll();
$position = 0;
$positions = array();
foreach($layouts as $layout) {

    $position += 10;
    $positions[$layout->getCode()] = $position;

    $layout->setOrder($position);


    if($layout->getCode() == "layout_8" AND !file_exists(Core_Model_Directory::getPathTo("app/design/mobile/angular/template/home/l8/view.phtml"))) {
        $layout->setIsActive(false);
    }

    $layout->save();

}

$layouts = array(
    array(
        'name' => 'Layout 3 - Horizontal',
        'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE,
        'code' => 'layout_3_h',
        'preview' => '/customization/layout/homepage/layout_3-h.png',
        'use_more_button' => 0,
        'use_horizontal_scroll' => 1,
        "number_of_displayed_icons" => 6,
        'position' => "bottom",
        "order" => $positions["layout_3"] + 5,
        "is_active" => 1
    ), array(
        'name' => 'Layout 4 - Horizontal',
        'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE,
        'code' => 'layout_4_h',
        'preview' => '/customization/layout/homepage/layout_4-h.png',
        'use_more_button' => 0,
        'use_horizontal_scroll' => 1,
        "number_of_displayed_icons" => 6,
        'position' => "bottom",
        "order" => $positions["layout_4"] + 5,
        "is_active" => 1
    ), array(
        'name' => 'Layout 5 - Horizontal',
        'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE,
        'code' => 'layout_5_h',
        'preview' => '/customization/layout/homepage/layout_5-h.png',
        'use_more_button' => 0,
        'use_horizontal_scroll' => 1,
        "number_of_displayed_icons" => 4,
        'position' => "bottom",
        "order" => $positions["layout_5"] + 5,
        "is_active" => 1
    )
);

foreach($layouts as $data) {
    $layout = new Application_Model_Layout_Homepage();
    $layout->setData($data)->save();
}
