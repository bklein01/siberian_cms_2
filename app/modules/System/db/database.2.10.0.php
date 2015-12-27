<?php

$data = array(
    "code" => "chat_code_js",
    "label" => "Provider Chat code"
);

$config = new System_Model_Config();
$config->find($data["code"], "code")
    ->setData($data)
    ->save();

