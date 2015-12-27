<?php

if(in_array(Siberian_Version::TYPE, array("MAE", "SAE"))) {
    $value = "sources";
} else {
    $value = "info";
}

$data = array(
    "code" => "system_publication_access_type",
    "label" => "Publication access type",
    "value" => $value
);

$this->_db->insert("system_config", $data);
