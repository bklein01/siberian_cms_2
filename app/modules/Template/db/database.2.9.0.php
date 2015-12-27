<?php

$this->query("
    ALTER TABLE `template_design`
        ADD `layout_visibility` VARCHAR(10) NOT NULL DEFAULT 'homepage' AFTER `layout_id`,
        CHANGE `background_image_retina` `background_image_hd` VARCHAR(255),
        ADD `background_image_tablet` VARCHAR(255) NOT NULL AFTER `background_image_hd`,
        ADD `icon` VARCHAR(255) DEFAULT NULL AFTER `background_image_tablet`,
        ADD `startup_image` VARCHAR(255) DEFAULT NULL AFTER `icon`,
        ADD `startup_image_retina` VARCHAR(255) DEFAULT NULL AFTER `startup_image`,
        ADD `startup_image_iphone_6` VARCHAR(255) DEFAULT NULL AFTER `startup_image_retina`,
        ADD `startup_image_iphone_6_plus` VARCHAR(255) DEFAULT NULL AFTER `startup_image_iphone_6`,
        ADD `startup_image_ipad_retina` VARCHAR(255) DEFAULT NULL AFTER `startup_image_iphone_6_plus`
    ;
");
$this->query("ALTER TABLE `template_design_block` CHANGE `background_color` `background_color` VARCHAR(11) NULL DEFAULT NULL");

// Creating 'template_category' table
$this->query("
    CREATE TABLE `template_category` (
        `category_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(50) NOT NULL,
        `code` VARCHAR(20) NOT NULL,
        PRIMARY KEY (`category_id`)
    )
");

// Creating 'template_design_category table
$this->query("
    CREATE TABLE `template_design_category` (
        `design_category_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `design_id` INT(11) UNSIGNED NOT NULL,
        `category_id` INT(11) UNSIGNED NOT NULL,
        PRIMARY KEY (`design_category_id`),
        KEY (`design_id`),
        KEY (`category_id`)
    )
");

// Creating 'template_design_content' table
$this->query("
    CREATE TABLE `template_design_content` (
        `content_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `design_id` INT(11) UNSIGNED NOT NULL,
        `option_id` INT(11) UNSIGNED NOT NULL,
        `option_tabbar_name` VARCHAR(30) NULL DEFAULT NULL,
        `option_icon` VARCHAR(30) NULL DEFAULT NULL,
        `option_background_image` VARCHAR(255) NULL DEFAULT NULL,
        PRIMARY KEY (`content_id`),
        KEY (`design_id`),
        KEY (`option_id`)
    )
");

$this->query("
    ALTER TABLE `template_design_content`
        ADD CONSTRAINT `FK_TEMPLATE_DESIGN_CONTENT_DESIGN_ID` FOREIGN KEY (`design_id`) REFERENCES `template_design` (`design_id`)
            ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
    ALTER TABLE `template_design_content`
        ADD CONSTRAINT `FK_TEMPLATE_DESIGN_CONTENT_OPTION_ID` FOREIGN KEY (`option_id`) REFERENCES `application_option` (`option_id`)
            ON DELETE CASCADE ON UPDATE CASCADE;
");

// Inserting categories in 'template_category' table
$categories = array(
    "City",
    "Education",
    "Entertainment",
    "Hotels",
    "Fashion",
    "Health & Beauty",
    "Local Business",
    "Music",
    "Organizations",
    "Real Estate",
    "Sports"
);

foreach($categories as $category_name) {
    $category_data = array();
    $category_data['name'] = $category_name;
    $category_data['code'] = preg_replace('/[&\s]+/', "_", strtolower($category_name));

    $category = new Template_Model_Category();
    $category->setData($category_data)
        ->save()
    ;
}

// Listing all layouts
$layouts = array();
$layout = new Application_Model_Layout_Homepage();

foreach($layout->findAll() as $layout) {
    $layouts[$layout->getCode()] = $layout;
}

// Listings all block ids
$block_ids = array();
$block = new Template_Model_Block();
foreach($block->findAll() as $block) {
    $block_ids[$block->getCode()] = $block->getId();
}

// Inserting designs with blocks
$designs = array(
    "publisher" => array(
        "layout_id" => $layouts["layout_1"]->getId(),
        "name" => "Publisher",
        "overview" => "/publisher/overview.png",
        "background_image" => "/../../images/templates/publisher/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/publisher/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/publisher/1536x2048.jpg",
        "icon" => "/../../images/templates/publisher/180x180.png",
        "startup_image" => "/../../images/templates/publisher/640x960.png",
        "startup_image_retina" => "/../../images/templates/publisher/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/publisher/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/publisher/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/publisher/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#ddc57b",
                "background_color" => "#29344e"
            ),
            "subheader" => array(
                "color" => "#29344e",
                "background_color" => "#ddc57b"
            ),
            "connect_button" => array(
                "color" => "#ddc57b",
                "background_color" => "#29344e"
            ),
            "background" => array(
                "color" => "#29344e",
                "background_color" => "#ddc57b"
            ),
            "discount" => array(
                "color" => "#29344e",
                "background_color" => "#ddc57b"
            ),
            "button" => array(
                "color" => "#ddc57b",
                "background_color" => "#29344e"
            ),
            "news" => array(
                "color" => "#ddc57b",
                "background_color" => "#29344e"
            ),
            "comments" => array(
                "color" => "#29344e",
                "background_color" => "#ddc57b"
            ),
            "tabbar" => array(
                "color" => "#29344e",
                "background_color" => "#ddc57b",
                "image_color" => "#29344e"
            )
        )
    ),
    "big_company" => array(
        "layout_id" => $layouts["layout_2"]->getId(),
        "name" => "Big Company",
        "overview" => "/big_company/overview.png",
        "background_image" => "/../../images/templates/big_company/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/big_company/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/big_company/1536x2048.jpg",
        "icon" => "/../../images/templates/big_company/180x180.png",
        "startup_image" => "/../../images/templates/big_company/640x960.png",
        "startup_image_retina" => "/../../images/templates/big_company/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/big_company/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/big_company/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/big_company/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#ffffff",
                "background_color" => "#56718e"
            ),
            "subheader" => array(
                "color" => "#56718e",
                "background_color" => "#ffffff"
            ),
            "connect_button" => array(
                "color" => "#ffffff",
                "background_color" => "#56718e"
            ),
            "background" => array(
                "color" => "#ffffff",
                "background_color" => "#56718e"
            ),
            "discount" => array(
                "color" => "#ffffff",
                "background_color" => "#56718e"
            ),
            "button" => array(
                "color" => "#ffffff",
                "background_color" => "#56718e"
            ),
            "news" => array(
                "color" => "#ffffff",
                "background_color" => "#56718e"
            ),
            "comments" => array(
                "color" => "#56718e",
                "background_color" => "#ffffff"
            ),
            "tabbar" => array(
                "color" => "#ffffff",
                "background_color" => "transparent",
                "image_color" => "#ffffff"
            )
        )
    ),
    "real_estate_one" => array(
        "layout_id" => $layouts["layout_4"]->getId(),
        "name" => "Real Estate One",
        "overview" => "/real_estate_one/overview.png",
        "background_image" => "/../../images/templates/real_estate_one/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/real_estate_one/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/real_estate_one/1536x2048.jpg",
        "icon" => "/../../images/templates/real_estate_one/180x180.png",
        "startup_image" => "/../../images/templates/real_estate_one/640x960.png",
        "startup_image_retina" => "/../../images/templates/real_estate_one/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/real_estate_one/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/real_estate_one/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/real_estate_one/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#ffffff",
                "background_color" => "#e60041"
            ),
            "subheader" => array(
                "color" => "#000000",
                "background_color" => "#ffffff"
            ),
            "connect_button" => array(
                "color" => "#ffffff",
                "background_color" => "#e60041"
            ),
            "background" => array(
                "color" => "#000000",
                "background_color" => "#ffffff"
            ),
            "discount" => array(
                "color" => "#000000",
                "background_color" => "#e60041"
            ),
            "button" => array(
                "color" => "#ffffff",
                "background_color" => "#e60041"
            ),
            "news" => array(
                "color" => "#000000",
                "background_color" => "#ffffff"
            ),
            "comments" => array(
                "color" => "#ffffff",
                "background_color" => "#e60041"
            ),
            "tabbar" => array(
                "color" => "#e60041",
                "background_color" => "transparent",
                "image_color" => "#e60041"
            )
        )
    ),
    "fairground" => array(
        "layout_id" => $layouts["layout_3"]->getId(),
        "name" => "Fairground",
        "overview" => "/fairground/overview.png",
        "background_image" => "/../../images/templates/fairground/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/fairground/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/fairground/1536x2048.jpg",
        "icon" => "/../../images/templates/fairground/180x180.png",
        "startup_image" => "/../../images/templates/fairground/640x960.png",
        "startup_image_retina" => "/../../images/templates/fairground/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/fairground/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/fairground/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/fairground/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#323b40",
                "background_color" => "#ee4b63"
            ),
            "subheader" => array(
                "color" => "#323b40",
                "background_color" => "#fdc32f"
            ),
            "connect_button" => array(
                "color" => "#323b40",
                "background_color" => "#6fb7b1"
            ),
            "background" => array(
                "color" => "#323b40",
                "background_color" => "#f9e4d1"
            ),
            "discount" => array(
                "color" => "#ee4b63",
                "background_color" => "#f9e4d1"
            ),
            "button" => array(
                "color" => "#323b40",
                "background_color" => "#6fb7b1"
            ),
            "news" => array(
                "color" => "#323b40",
                "background_color" => "#f9e4d1"
            ),
            "comments" => array(
                "color" => "#",
                "background_color" => "#fdc32f"
            ),
            "tabbar" => array(
                "color" => "#ee4b63",
                "background_color" => "transparent",
                "image_color" => "#ee4b63"
            )
        )
    ),
    "grande_palace" => array(
        "layout_id" => $layouts["layout_5"]->getId(),
        "name" => "Grande Palace",
        "overview" => "/grande_palace/overview.png",
        "background_image" => "/../../images/templates/grande_palace/640x1136.png",
        "background_image_hd" => "/../../images/templates/grande_palace/1242x2208.png",
        "background_image_tablet" => "/../../images/templates/grande_palace/1536x2048.png",
        "icon" => "/../../images/templates/grande_palace/180x180.png",
        "startup_image" => "/../../images/templates/grande_palace/640x960.png",
        "startup_image_retina" => "/../../images/templates/grande_palace/640x1136.png",
        "startup_image_iphone_6" => "/../../images/templates/grande_palace/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/grande_palace/1242x2208.png",
        "startup_image_ipad_retina" => "/../../images/templates/grande_palace/1536x2048.png",
        "blocks" => array(
            "header" => array(
                "color" => "#000000",
                "background_color" => "#ffffff"
            ),
            "subheader" => array(
                "color" => "#ffffff",
                "background_color" => "#000000"
            ),
            "connect_button" => array(
                "color" => "#000000",
                "background_color" => "#ffffff"
            ),
            "background" => array(
                "color" => "#ffffff",
                "background_color" => "#000000"
            ),
            "discount" => array(
                "color" => "#ffffff",
                "background_color" => "#000000"
            ),
            "button" => array(
                "color" => "#ffffff",
                "background_color" => "#000000"
            ),
            "news" => array(
                "color" => "#ffffff",
                "background_color" => "#000000"
            ),
            "comments" => array(
                "color" => "#000000",
                "background_color" => "#ffffff"
            ),
            "tabbar" => array(
                "color" => "#ffffff",
                "background_color" => "#ffffff",
                "image_color" => "#ffffff"
            )
        )
    ),
    "pizza" => array(
        "layout_id" => $layouts["layout_9"]->getId(),
        "layout_visibility" => "toggle",
        "name" => "Pizza",
        "overview" => "/pizza/overview.png",
        "background_image" => "/../../images/templates/pizza/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/pizza/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/pizza/1536x2048.jpg",
        "icon" => "/../../images/templates/pizza/180x180.png",
        "startup_image" => "/../../images/templates/pizza/640x960.png",
        "startup_image_retina" => "/../../images/templates/pizza/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/pizza/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/pizza/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/pizza/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#ffffff",
                "background_color" => "#00a72d"
            ),
            "subheader" => array(
                "color" => "#ffffff",
                "background_color" => "#e50017"
            ),
            "connect_button" => array(
                "color" => "#ffffff",
                "background_color" => "#00a72d"
            ),
            "background" => array(
                "color" => "#00a72d",
                "background_color" => "#ffffff"
            ),
            "discount" => array(
                "color" => "#ffffff",
                "background_color" => "#e50017"
            ),
            "button" => array(
                "color" => "#ffffff",
                "background_color" => "#00a72d"
            ),
            "news" => array(
                "color" => "#00a72d",
                "background_color" => "#ffffff"
            ),
            "comments" => array(
                "color" => "#ffffff",
                "background_color" => "#00a72d"
            ),
            "tabbar" => array(
                "color" => "#00a72d",
                "background_color" => "#ffffff",
                "image_color" => "#00a72d"
            )
        )
    ),
    "rush_cafe" => array(
        "layout_id" => $layouts["layout_7"]->getId(),
        "name" => "Rush Cafe",
        "overview" => "/rush_cafe/overview.png",
        "background_image" => "/../../images/templates/rush_cafe/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/rush_cafe/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/rush_cafe/1536x2048.jpg",
        "icon" => "/../../images/templates/rush_cafe/180x180.png",
        "startup_image" => "/../../images/templates/rush_cafe/640x960.png",
        "startup_image_retina" => "/../../images/templates/rush_cafe/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/rush_cafe/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/rush_cafe/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/rush_cafe/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#43352a",
                "background_color" => "#ffffff"
            ),
            "subheader" => array(
                "color" => "#ffffff",
                "background_color" => "#43352a"
            ),
            "connect_button" => array(
                "color" => "#ffffff",
                "background_color" => "#9e6031"
            ),
            "background" => array(
                "color" => "#43352a",
                "background_color" => "#ffffff"
            ),
            "discount" => array(
                "color" => "#ffffff",
                "background_color" => "#43352a"
            ),
            "button" => array(
                "color" => "#ffffff",
                "background_color" => "#43352a"
            ),
            "news" => array(
                "color" => "#ffffff",
                "background_color" => "#6e5948"
            ),
            "comments" => array(
                "color" => "#ffffff",
                "background_color" => "#43352a"
            ),
            "tabbar" => array(
                "color" => "#ffffff",
                "background_color" => "#43352a",
                "image_color" => "#ffffff"
            )
        )
    ),
    "university" => array(
        "layout_id" => $layouts["layout_7"]->getId(),
        "name" => "University",
        "overview" => "/university/overview.png",
        "background_image" => "/../../images/templates/university/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/university/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/university/1536x2048.jpg",
        "icon" => "/../../images/templates/university/180x180.png",
        "startup_image" => "/../../images/templates/university/640x960.png",
        "startup_image_retina" => "/../../images/templates/university/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/university/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/university/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/university/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#0a0d14",
                "background_color" => "#73bfeb"
            ),
            "subheader" => array(
                "color" => "#73bfeb",
                "background_color" => "#ffffff"
            ),
            "connect_button" => array(
                "color" => "#0a0d14",
                "background_color" => "#73bfeb"
            ),
            "background" => array(
                "color" => "#0a0d14",
                "background_color" => "#f0f0f0"
            ),
            "discount" => array(
                "color" => "#0a0d14",
                "background_color" => "#73bfeb"
            ),
            "button" => array(
                "color" => "#ffffff",
                "background_color" => "#73bfeb"
            ),
            "news" => array(
                "color" => "#0a0d14",
                "background_color" => "#ffffff"
            ),
            "comments" => array(
                "color" => "#ffffff",
                "background_color" => "#73bfeb"
            ),
            "tabbar" => array(
                "color" => "#73bfeb",
                "background_color" => "#ffffff",
                "image_color" => "#73bfeb"
            )
        )
    ),
    "jewellery" => array(
        "layout_id" => $layouts["layout_1"]->getId(),
        "name" => "Jewellery",
        "overview" => "/jewellery/overview.png",
        "background_image" => "/../../images/templates/jewellery/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/jewellery/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/jewellery/1536x2048.jpg",
        "icon" => "/../../images/templates/jewellery/180x180.png",
        "startup_image" => "/../../images/templates/jewellery/640x960.png",
        "startup_image_retina" => "/../../images/templates/jewellery/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/jewellery/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/jewellery/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/jewellery/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#ffffff",
                "background_color" => "#4f5261"
            ),
            "subheader" => array(
                "color" => "#4f5261",
                "background_color" => "#ffffff"
            ),
            "connect_button" => array(
                "color" => "#ffffff",
                "background_color" => "#cb0051"
            ),
            "background" => array(
                "color" => "#ffffff",
                "background_color" => "#4f5261"
            ),
            "discount" => array(
                "color" => "#ffffff",
                "background_color" => "#cb0051"
            ),
            "button" => array(
                "color" => "#ffffff",
                "background_color" => "#cb0051"
            ),
            "news" => array(
                "color" => "#ffffff",
                "background_color" => "#4f5261"
            ),
            "comments" => array(
                "color" => "#4f5261",
                "background_color" => "#ffffff"
            ),
            "tabbar" => array(
                "color" => "#cb0051",
                "background_color" => "#4f5261",
                "image_color" => "#cb0051"
            )
        )
    ),
    "dj" => array(
        "layout_id" => $layouts["layout_2"]->getId(),
        "name" => "DJ",
        "overview" => "/dj/overview.png",
        "background_image" => "/../../images/templates/dj/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/dj/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/dj/1536x2048.jpg",
        "icon" => "/../../images/templates/dj/180x180.png",
        "startup_image" => "/../../images/templates/dj/640x960.png",
        "startup_image_retina" => "/../../images/templates/dj/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/dj/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/dj/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/dj/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#404040",
                "background_color" => "#e0c341"
            ),
            "subheader" => array(
                "color" => "#404040",
                "background_color" => "#f0d970"
            ),
            "connect_button" => array(
                "color" => "#404040",
                "background_color" => "#e0c341"
            ),
            "background" => array(
                "color" => "#f0d970",
                "background_color" => "#b65c12"
            ),
            "discount" => array(
                "color" => "#404040",
                "background_color" => "#e0c341"
            ),
            "button" => array(
                "color" => "#b65c12",
                "background_color" => "#e0c341"
            ),
            "news" => array(
                "color" => "#f0d970",
                "background_color" => "#b65c12"
            ),
            "comments" => array(
                "color" => "#404040",
                "background_color" => "#e0c341"
            ),
            "tabbar" => array(
                "color" => "#e0c341",
                "background_color" => "transparent",
                "image_color" => "#e0c341"
            )
        )
    ),
    "surgery" => array(
        "layout_id" => $layouts["layout_4"]->getId(),
        "name" => "Surgery",
        "overview" => "/surgery/overview.png",
        "background_image" => "/../../images/templates/surgery/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/surgery/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/surgery/1536x2048.jpg",
        "icon" => "/../../images/templates/surgery/180x180.png",
        "startup_image" => "/../../images/templates/surgery/640x960.png",
        "startup_image_retina" => "/../../images/templates/surgery/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/surgery/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/surgery/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/surgery/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#ffffff",
                "background_color" => "#30a6d8"
            ),
            "subheader" => array(
                "color" => "#30a6d8",
                "background_color" => "#f5f3f2"
            ),
            "connect_button" => array(
                "color" => "#0a0a0a",
                "background_color" => "#30a6d8"
            ),
            "background" => array(
                "color" => "#30a6d8",
                "background_color" => "#f5f3f2"
            ),
            "discount" => array(
                "color" => "#ffffff",
                "background_color" => "#30a6d8"
            ),
            "button" => array(
                "color" => "#ffffff",
                "background_color" => "#30a6d8"
            ),
            "news" => array(
                "color" => "#30a6d8",
                "background_color" => "#ffffff"
            ),
            "comments" => array(
                "color" => "#0a0a0a",
                "background_color" => "#f5f3f2"
            ),
            "tabbar" => array(
                "color" => "#f5f3f2",
                "background_color" => "#f5f3f2",
                "image_color" => "#30a6d8"
            )
        )
    ),
    "fitness" => array(
        "layout_id" => $layouts["layout_6"]->getId(),
        "name" => "Fitness",
        "overview" => "/fitness/overview.png",
        "background_image" => "/../../images/templates/fitness/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/fitness/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/fitness/1536x2048.jpg",
        "icon" => "/../../images/templates/fitness/180x180.png",
        "startup_image" => "/../../images/templates/fitness/640x960.png",
        "startup_image_retina" => "/../../images/templates/fitness/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/fitness/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/fitness/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/fitness/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#4eaee6",
                "background_color" => "#afe494"
            ),
            "subheader" => array(
                "color" => "#4eaee6",
                "background_color" => "#afe494"
            ),
            "connect_button" => array(
                "color" => "#ffffff",
                "background_color" => "#4eaee6"
            ),
            "background" => array(
                "color" => "#4eaee6",
                "background_color" => "#ffffff"
            ),
            "discount" => array(
                "color" => "#4eaee6",
                "background_color" => "#afe494"
            ),
            "button" => array(
                "color" => "#ffffff",
                "background_color" => "#4eaee6"
            ),
            "news" => array(
                "color" => "#4eaee6",
                "background_color" => "#ffffff"
            ),
            "comments" => array(
                "color" => "#4eaee6",
                "background_color" => "#afe494"
            ),
            "tabbar" => array(
                "color" => "#afe494",
                "background_color" => "#008dde",
                "image_color" => "#afe494"
            )
        )
    ),
    "paris" => array(
        "layout_id" => $layouts["layout_2"]->getId(),
        "name" => "Paris",
        "overview" => "/paris/overview.png",
        "background_image" => "/../../images/templates/paris/640x1136.jpg",
        "background_image_hd" => "/../../images/templates/paris/1242x2208.jpg",
        "background_image_tablet" => "/../../images/templates/paris/1536x2048.jpg",
        "icon" => "/../../images/templates/paris/180x180.png",
        "startup_image" => "/../../images/templates/paris/640x960.png",
        "startup_image_retina" => "/../../images/templates/paris/640x1136.jpg",
        "startup_image_iphone_6" => "/../../images/templates/paris/750x1334.png",
        "startup_image_iphone_6_plus" => "/../../images/templates/paris/1242x2208.jpg",
        "startup_image_ipad_retina" => "/../../images/templates/paris/1536x2048.jpg",
        "blocks" => array(
            "header" => array(
                "color" => "#54627a",
                "background_color" => "#b89379"
            ),
            "subheader" => array(
                "color" => "#b89379",
                "background_color" => "#ffffff"
            ),
            "connect_button" => array(
                "color" => "#dcc3b2",
                "background_color" => "#54627a"
            ),
            "background" => array(
                "color" => "#ffffff",
                "background_color" => "#dcc3b2"
            ),
            "discount" => array(
                "color" => "#ffffff",
                "background_color" => "#54627a"
            ),
            "button" => array(
                "color" => "#54627a",
                "background_color" => "#dcc3b2"
            ),
            "news" => array(
                "color" => "#ffffff",
                "background_color" => "#54627a"
            ),
            "comments" => array(
                "color" => "#54627a",
                "background_color" => "#ffffff"
            ),
            "tabbar" => array(
                "color" => "#54627a",
                "background_color" => "#dcc3b2",
                "image_color" => "#54627a"
            )
        )
    ),
    "blank" => array(
        "layout_id" => $layouts["layout_1"]->getId(),
        "name" => "Blank",
        "overview" => "/blank/overview.png",
        "background_image" => "/../../images/application/placeholder/no-background.jpg",
        "background_image_hd" => "/../../images/application/placeholder/no-background-hd.jpg",
        "background_image_tablet" => "/../../images/application/placeholder/no-background-tablet.jpg",
        "icon" => "/../../images/application/placeholder/no-image.png",
        "startup_image" => "/../../images/application/placeholder/no-startupimage.png",
        "startup_image_retina" => "/../../images/application/placeholder/no-startupimage-retina.png",
        "startup_image_iphone_6" => "/../../images/application/placeholder/no-startupimage-iphone-6.png",
        "startup_image_iphone_6_plus" => "/../../images/application/placeholder/no-startupimage-iphone-6-plus.png",
        "startup_image_ipad_retina" => "/../../images/application/placeholder/no-startupimage-tablet.png"
    ),
);

foreach($designs as $code => $data) {
    $design = new Template_Model_Design();
    $design->setData($data)
        ->setCode($code)
        ->save()
    ;

    if(!empty($data["blocks"])) {
        foreach($data["blocks"] as $block_code => $block_data) {
            $block_data["design_id"] = $design->getId();
            $block_data["block_id"] = $block_ids[$block_code];
            $this->_db->insert("template_design_block", $block_data);
        }
    }

}

// Assigning designs to categories
$categories_designs = array(
    "organizations" => array(
        "publisher",
        "big_company"
    ),
    "real_estate" => array(
        "real_estate_one"
    ),
    "entertainment" => array(
        "fairground"
    ),
    "local_business" => array(
        "pizza",
        "rush_cafe"
    ),
    "education" => array(
        "university"
    ),
    "hotels" => array(
        "grande_palace"
    ),
    "fashion" => array(
        "jewellery"
    ),
    "music" => array(
        "dj"
    ),
    "health_beauty" => array(
        "surgery"
    ),
    "sports" => array(
        "fitness"
    ),
    "city" => array(
        "paris"
    )
);

// Listing all design ids
$design_ids = array();
$design = new Template_Model_Design();
foreach ($design->findAll() as $design_data) {
    $design_ids[$design_data->getCode()] = $design_data->getId();
}

// Listing all category ids
$category_ids = array();
$category = new Template_Model_Category();
foreach ($category->findAll() as $category_data) {
    $category_ids[$category_data->getCode()] = $category_data->getId();
}

foreach ($categories_designs as $category_code => $design_codes) {
    $categories_designs_data = array("category_id" => $category_ids[$category_code]);

    foreach ($design_codes as $design_code) {
        $categories_designs_data["design_id"] = $design_ids[$design_code];
        $this->_db->insert("template_design_category", $categories_designs_data);
    }

}

// Assigning features to designs
$design_codes = array(
    "big_company" => array(
        "custom_page" => array("name" => "Company"),
        "newswall" => array(),
        "push_notification" => array("name" => "Push", "icon" => "/push_notifications/push4.png"),
        "folder" => array("name" => "Products", "icon" => "/booking/booking4.png"),
        "places" => array("name" => "Locations"),
        "video_gallery" => array(),
        "contact" => array(),
        "facebook" => array(),
        "weblink_multi" => array(),
        "form" => array()
    ),
    "dj" => array(
        "newswall" => array("icon" => "/newswall/newswall2.png"),
        "music_gallery" => array("name" => "Playlists"),
        "push_notification" => array("name" => "Messages", "icon" => "/push_notifications/push2.png"),
        "image_gallery" => array("icon" => "/images/image5.png"),
        "facebook" => array(),
        "calendar" => array("icon" => "/calendar/calendar2.png"),
        "video_gallery" => array("icon" => "/videos/video2.png"),
        "custom_page" => array("name" => "About me"),
        "booking" => array("icon" => "/booking/booking4.png")
    ),
    "fairground" => array(
        "fanwall" => array("icon" => "/../../images/templates/fairground/icons/fanwall.png"),
        "loyalty" => array("name" => "Loyalty", "icon" => "/loyalty/loyalty4.png"),
        "social_gaming" => array("icon" => "/contest/contest4.png"),
        "discount" => array("name" => "Coupons", "icon" => "/discount/discount5.png"),
        "calendar" => array("icon" => "/calendar/calendar2.png"),
        "image_gallery" => array("icon" => "/images/image7.png"),
        "push_notification" => array("name" => "Push", "icon" => "/push_notifications/push3.png"),
        "video_gallery" => array(),
        "newswall" => array("name" => "News"),
        "facebook" => array()
    ),
    "fitness" => array(
        "newswall" => array("icon" => "/fanwall/fanwall2.png"),
        "loyalty" => array("icon" => "/loyalty/loyalty2.png"),
        "push_notification" => array("name" => "Push Notifications", "icon" => "/push_notifications/push5.png"),
        "discount" => array("name" => "Coupons", "icon" => "/discount/discount4.png"),
        "facebook" => array(),
        "fanwall" => array("name" => "Activity", "icon" => "/fanwall/fanwall4.png"),
        "custom_page" => array("name" => "About us"),
        "source_code" => array("name" => "BMI", "icon" => "/booking/booking4.png"),
        "image_gallery" => array("icon" => "/images/image4.png"),
        "video_gallery" => array("icon" => "/videos/video2.png"),
        "contact" => array()
    ),
    "grande_palace" => array(
        "newswall" => array("background_image" => "/../../images/templates/grande_palace/content/bg.png"),
        "discount" => array("icon" => "/discount/discount4.png", "background_image" => "/../../images/templates/grande_palace/content/bg.png"),
        "loyalty" => array("icon" => "/loyalty/loyalty5.png", "background_image" => "/../../images/templates/grande_palace/content/bg.png"),
        "folder" => array("name" => "Infos", "icon" => "/../../images/templates/grande_palace/icons/infos.png", "background_image" => "/../../images/templates/grande_palace/content/bg.png"),
        "booking" => array("background_image" => "/../../images/templates/grande_palace/content/bg.png"),
        "form" => array("name" => "Feedbacks", "icon" => "/form/form3.png", "background_image" => "/../../images/templates/grande_palace/content/bg.png"),
        "push_notification" => array("icon" => "/push_notifications/push5.png", "background_image" => "/../../images/templates/grande_palace/content/bg.png"),
        "contact" => array()
    ),
    "jewellery" => array(
        "m_commerce" => array("name" => "Shop", "icon" => "/../../images/templates/jewellery/icons/shop.png"),
        "discount" => array("name" => "Coupons", "icon" => "/discount/discount3.png"),
        "form" => array("name" => "Pre-order"),
        "image_gallery" => array("name" => "Gallery", "icon" => "/images/image3.png"),
        "places" => array("name" => "Locations"),
        "custom_page" => array("name" => "About")
    ),
    "paris" => array(
        "custom_page" => array("name" => "The City"),
        "video_gallery" => array("icon" => "/videos/video5.png"),
        "calendar" => array(),
        "places" => array(),
        "fanwall" => array("name" => "Activity Wall", "icon" => "/fanwall/fanwall2.png"),
        "push_notification" => array("name" => "Messages", "icon" => "/push_notifications/push3.png"),
        "image_gallery" => array("icon" => "/images/image5.png"),
        "radio" => array(),
        "weblink_multi" => array(),
        "folder" => array("icon" => "/folders/folder5.png")
    ),
    "pizza" => array(
        "m_commerce" => array("name" => "Orders"),
        "loyalty" => array("name" => "Loyalty"),
        "social_gaming" => array(),
        "discount" => array(),
        "facebook" => array(),
        "contact" => array()
    ),
    "publisher" => array(
        "newswall" => array(),
        "image_gallery" => array("name" => "Portfolio", "icon" => "/images/image5.png"),
        "catalog" => array("icon" => "/../../images/templates/publisher/icons/catalog.png"),
        "push_notification" => array("name" => "Push"),
        "custom_page" => array("name" => "Custom"),
        "rss_feed" => array(),
        "facebook" => array(),
        "form" => array(),
        "contact" => array()
    ),
    "real_estate_one" => array(
        "custom_page" => array("name" => "About", "icon" => "/../../images/templates/real_estate_one/icons/about.png"),
        "newswall" => array("name" => "New Rentals", "icon" => "/newswall/newswall2.png"),
        "push_notification" => array("name" => "Push", "icon" => "/push_notifications/push5.png"),
        "form" => array("name" => "Your needs", "icon" => "/form/form2.png"),
        "booking" => array("name" => "Appointment"),
        "image_gallery" => array("name" => "Properties", "icon" => "/images/image3.png"),
        "contact" => array(),
        "facebook" => array()
    ),
    "rush_cafe" => array(
        "newswall" => array(),
        "loyalty" => array("icon" => "/loyalty/loyalty6.png"),
        "push_notification" => array("name" => "Notifications", "icon" => "/push_notifications/push2.png"),
        "catalog" => array(),
        "set_meal" => array(),
        "discount" => array("name" => "Coupons"),
        "facebook" => array(),
        "fanwall" => array(),
        "form" => array("icon" => "/form/form3.png"),
        "places" => array(),
        "contact" => array()
    ),
    "surgery" => array(
        "custom_page" => array("name" => "About us"),
        "discount" => array("name" => "Specials", "icon" => "/discount/discount3.png"),
        "form" => array("name" => "Requests", "icon" => "/form/form2.png"),
        "image_gallery" => array("name" => "Galleries", "icon" => "/images/image7.png"),
        "padlock" => array("name" => "Restricted"),
        "places" => array("name" => "Locations"),
        "booking" => array(),
        "contact" => array()
    ),
    "university" => array(
        "custom_page" => array("name" => "Studies", "icon" => "/newswall/newswall4.png"),
        "newswall" => array(),
        "rss_feed" => array(),
        "radio" => array(),
        "calendar" => array("icon" => "/calendar/calendar3.png"),
        "folder" => array("icon" => "/folders/folder4.png"),
        "push_notification" => array("name" => "Notifications"),
        "facebook" => array(),
        "fanwall" => array("icon" => "/fanwall/fanwall2.png"),
        "image_gallery" => array("icon" => "/images/image4.png"),
        "video_gallery" => array("icon" => "/videos/video5.png"),
        "form" => array("name" => "Requests", "icon" => "/form/form2.png")
    )
);

foreach ($design_codes as $design_code => $option_codes) {
    foreach ($option_codes as $option_code => $option_infos) {

        $design = new Template_Model_Design();
        $design->find($design_code, "code");

        $option = new Application_Model_Option();
        $options = $option->findAll(array("code IN (?)" => $option_code));

        foreach($options as $option) {

            $icon_id = NULL;
            if(isset($option_infos["icon"])) {
                $icon = new Media_Model_Library_Image();
                $icon->find($option_infos["icon"], "link");

                if (!$icon->getData()) {
                    $icon->setLibraryId($option->getLibraryId())
                        ->setLink($option_infos["icon"])
                        ->setOptionId($option->getId())
                        ->setCanBeColorized(1)
                        ->setPosition(0)
                        ->save()
                    ;
                }

                $icon_id = $icon->getId();
            }

            $data = array(
                "design_id" => $design->getId(),
                "option_id" => $option->getId(),
                "option_tabbar_name" => isset($option_infos["name"]) ? $option_infos["name"] : NULL,
                "option_icon" => $icon_id,
                "option_background_image" => isset($option_infos["background_image"]) ? $option_infos["background_image"] : NULL
            );

            $this->_db->insert("template_design_content", $data);
        }
    }

}

$design_codes = array("zenstitut", "hairdresser", "fall_wedding", "purple_croco", "grand_palace", "white_shadow", "side_brown");
foreach($design_codes as $design_code) {
    $design = new Template_Model_Design();
    $design->find($design_code, "code")->delete();
}