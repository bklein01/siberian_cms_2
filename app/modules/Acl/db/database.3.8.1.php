<?php

$default_role = new System_Model_Config();
$default_role->find("default_role", "code");

$data = array(
    "code" => Acl_Model_Role::DEFAULT_ADMIN_ROLE_CODE,
    "label" => "Default admin role"
);

$default_role->addData($data)
    ->save()
;
