<?php

// Reset labels

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
        "label" => "Publication access type"
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
        "code" => Acl_Model_Role::DEFAULT_ADMIN_ROLE_CODE,
        "label" => "Default admin role"
    )
);

foreach($data as $configData) {
    $config = new System_Model_Config();
    $config->find($configData["code"], "code")
        ->setLabel($configData["label"])
        ->save()
    ;
}