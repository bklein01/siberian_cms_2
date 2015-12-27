<?php

$this->query("
      CREATE TABLE `acl_resource` (
          `resource_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `parent_id` int(11) unsigned DEFAULT NULL,
          `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
          `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
          PRIMARY KEY (resource_id)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
      CREATE TABLE `acl_role` (
        `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
        `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY(role_id)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    INSERT INTO `acl_role` (`code`, `label`) VALUES ('Admin', 'Administrator : full access');
");

$this->query("
      CREATE TABLE `acl_resource_role` (
        `resource_id` int(11) unsigned NOT NULL,
        `role_id` int(11) unsigned NOT NULL,
        PRIMARY KEY(resource_id,role_id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
      ALTER TABLE `acl_resource_role`
          ADD CONSTRAINT `FK_RESOURCE_ROLE_RESOURCE_ID` FOREIGN KEY (`resource_id`) REFERENCES `acl_resource` (`resource_id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `FK_RESOURCE_ROLE_ROLE_ID` FOREIGN KEY (`role_id`) REFERENCES `acl_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
    ALTER TABLE `admin` 
        ADD `role_id` INT(11) UNSIGNED NOT NULL DEFAULT '1' AFTER `parent_id`, 
        ADD INDEX (`role_id`);
");


$resource_data = array(
    array(
        "code" => "application",
        "label" => "Manage applications",
        "children" => array(
            array(
                "code" => "application_create",
                "label" => "Create an application",
                "url" => "admin/application/createpost",
            ),
            array(
                "code" => "application_delete",
                "label" => "Delete an application",
                "url" => "admin/application/delete",
            )
        )
    ),
    array(
        "code" => "editor",
        "label" => "Access the application editor",
        "children" => array(
            array(
                "code" => "editor_design",
                "label" => "Access the Design tab",
                "url" => "application/customization_design_style/edit",
            ),
            array(
                "code" => "editor_colors",
                "label" => "Access the Colors tab",
                "url" => "application/customization_design_colors/edit",
            ),
            array(
                "code" => "editor_features",
                "label" => "Access the Features tab",
                "url" => "application/customization_features/list",
            ),
            array(
                "code" => "editor_application",
                "label" => "Access the Application tab",
                "url" => "application/customization_publication_app/index",
            ),
            array(
                "code" => "editor_publication",
                "label" => "Access the Publication tab",
                "url" => "application/customization_publication_infos/index",
            ),

            array(
                "code" => "editor_settings",
                "label" => "Access the settings from the editor",
                "children" => array(
                    array(
                        "code" => "editor_settings_tc",
                        "label" => "Access the Terms & Conditions tab",
                        "url" => "application/settings_tc/*",
                    ), array(
                        "code" => "editor_settings_facebook",
                        "label" => "Access the Facebook tab",
                        "url" => "application/settings_facebook/*",
                    ), array(
                        "code" => "editor_settings_domain",
                        "label" => "Access the Domain tab",
                        "url" => "application/settings_domain/*",
                    ),
                )
            )
        )
    ),
    array(
        "code" => "admin_access_management",
        "label" => "Manage the editor users",
        "url" => "admin/access_management/*"
    ),
    array(
        "code" => "analytics",
        "label" => "Analytics page",
        "url" => "application/settings_facebook/*"
    ),
    array(
        "code" => "promote",
        "label" => "Promote page",
        "url" => "application/promote/*"
    ),
    array(
        "code" => "users",
        "label" => "Users page",
        "url" => "customer/application/list"
    ),
    array(
        "code" => "support",
        "label" => "Support"
    )
);

if(Siberian_Version::TYPE == "PE") {
    $resource_data[] = array(
        "code" => "sales_invoice",
        "label" => "List, open and print the invoices",
        "url" => "sales/admin_invoice/*"
    );
}


$option = new Application_Model_Option();
$options = $option->findAll();

$features_resources = array(
    "code" => "feature",
    "label" => "Features",
    "children" => array()
);

foreach($options as $option) {
    $features_resources["children"][] = array(
        "code" => "feature_".$option->getCode(),
        "label" => $option->getname(),
        "url" => $option->getDesktopUri()."*"
    );
}

$resource_data[] = $features_resources;

foreach($resource_data as $data) {
    $resource = new Acl_Model_Resource();
    $resource->setData($data)
        ->save()
    ;

    if(!empty($data["children"])) {

        foreach($data["children"] as $child_resource) {
            $child = new Acl_Model_Resource();
            $child->setData($child_resource)
                ->setParentId($resource->getId())
                ->save()
            ;

            if(!empty($child_resource["children"])) {

                foreach($child_resource["children"] as $child_child_resource) {
                    $child_child = new Acl_Model_Resource();
                    $child_child->setData($child_child_resource)
                        ->setParentId($child->getId())
                        ->save()
                    ;
                }
            }

        }

    }

}
