<?php

$this->query("
    CREATE TABLE `system_config` (
        `config_id` INT(11) unsigned NOT NULL AUTO_INCREMENT,
        `code` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
        `label` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
        `value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
        PRIMARY KEY (`config_id`),
        UNIQUE  `UNIQUE_CODE` ( `code`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");


$data = array(
    array(
        "code" => "platform_name",
        "label" => "Platform Name"
    ),

    array(
        "code" => "company_name",
        "label" => "Name"
    ),
    array(
        "code" => "company_phone",
        "label" => "Phone"
    ),
    array(
        "code" => "company_address",
        "label" => "Address"
    ),
    array(
        "code" => "company_country",
        "label" => "Country"
    ),
    array(
        "code" => "company_vat_number",
        "label" => "VAT Number"
    ),
    array(
        "code" => "system_territory",
        "label" => "Timezone"
    ),
    array(
        "code" => "system_timezone",
        "label" => "Timezone"
    ),
    array(
        "code" => "system_currency",
        "label" => "Currency"
    ),
    array(
        "code" => "system_default_language",
        "label" => "Default Languages"
    ),
    array(
        "code" => "system_publication_access_type",
        "label" => "Publication access type",
        "value" => in_array(Siberian_Version::TYPE, array("MAE", "SAE")) ? "sources" : "info"
    ),

    array(
        "code" => "support_email",
        "label" => "Support Email Address"
    ),
    array(
        "code" => "support_link",
        "label" => "Support Link"
    ),
    array(
        "code" => "support_name",
        "label" => "Name"
    ),
    array(
        "code" => "support_chat_code",
        "label" => "Online Chat"
    ),
    
    array(
        "code" => "logo",
        "label" => "Logo"
    ),
    array(
        "code" => "favicon",
        "label" => "Favicon"
    ),

    array(
        "code" => "application_try_apk",
        "label" => "Try to generate the apk when downloading the Android source"
    )
);

foreach($data as $configData) {
    $config = new System_Model_Config();
    $config->find($configData["code"], "code")
        ->setData($configData)
        ->save()
    ;
}