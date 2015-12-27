<?php

$this->query("
    CREATE TABLE application_acl_option (
      application_acl_option_id int(11) unsigned NOT NULL AUTO_INCREMENT,
      app_id int(11) unsigned NOT NULL,
      admin_id int(11) unsigned NOT NULL,
      value_id int(11) unsigned NOT NULL,
      resource_code varchar(50) COLLATE utf8_unicode_ci NOT NULL,
      PRIMARY KEY (application_acl_option_id),
      KEY value_id (value_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    ALTER TABLE application_acl_option
        ADD CONSTRAINT FK_APPLICATION_ACL_OPTION_VALUE_ID FOREIGN KEY (value_id) REFERENCES application_option_value (value_id) ON DELETE CASCADE ON UPDATE CASCADE;
");

$datas = array(
    array(
        'visibility' => Application_Model_Layout_Homepage::VISIBILITY_HOMEPAGE,
        'code' => 'layout_10',
        'name' => 'Layout 10',
        'preview' => '/customization/layout/homepage/layout_10.png',
        'use_more_button' => 1,
        'number_of_displayed_icons' => 5,
        'position' => 'bottom'
    )
);

foreach($datas as $data) {
    $layout = new Application_Model_Layout_Homepage();
    $layout->setData($data)->save();
}