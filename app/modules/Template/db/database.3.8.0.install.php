<?php

$this->query("

    CREATE TABLE `template_design` (
        `design_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `layout_id` int(11) unsigned NOT NULL,
        `layout_visibility` VARCHAR(10) NOT NULL DEFAULT 'homepage',
        `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
        `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
        `overview` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `background_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `background_image_hd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `background_image_tablet` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
        `icon` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `startup_image` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `startup_image_retina` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `startup_image_iphone_6` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `startup_image_iphone_6_plus` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `startup_image_ipad_retina` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        PRIMARY KEY (`design_id`),
        KEY `KEY_LAYOUT_ID` (`layout_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

    CREATE TABLE `template_block` (
        `block_id` int(11) NOT NULL AUTO_INCREMENT,
        `code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
        `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `color` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
        `background_color` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
        `image_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `position` smallint(5) NOT NULL DEFAULT '0',
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`block_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `template_block_app` (
        `block_id` int(11) NOT NULL,
        `app_id` int(11) unsigned NOT NULL,
        `color` varchar(10) NOT NULL,
        `background_color` VARCHAR(11) NOT NULL,
        `image_color` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`block_id`, `app_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
");

$this->query("
    CREATE TABLE `template_design_block` (
        `design_block_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `design_id` int(11) unsigned NOT NULL,
        `block_id` int(11) NOT NULL,
        `background_color` VARCHAR(11) COLLATE utf8_unicode_ci DEFAULT NULL,
        `color` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
        `image_color` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
        PRIMARY KEY (`design_block_id`),
        KEY `KEY_DESIGN_ID` (`design_id`),
        KEY `KEY_BLOCK_ID` (`block_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");


$this->query("
    ALTER TABLE `template_design`
        ADD FOREIGN KEY `FK_LAYOUT_ID` (`layout_id`) REFERENCES `application_layout_homepage` (`layout_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->query("
    ALTER TABLE `template_design_block`
        ADD FOREIGN KEY `FK_DESIGN_ID` (`design_id`) REFERENCES `template_design` (`design_id`) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD FOREIGN KEY `FK_BLOCK_ID` (`block_id`) REFERENCES `template_block` (`block_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");


$this->query("
    ALTER TABLE `template_block_app`
        ADD FOREIGN KEY `FK_TEMPLATE_BLOCK_BLOCK_ID` (`block_id`) REFERENCES `template_block` (`block_id`) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD FOREIGN KEY `FK_APPLICATION_APP_ID` (`app_id`) REFERENCES `application` (`app_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");


$datas = array(
    array('code' => 'header', 'name' => 'Header', 'use_color' => 1, 'color' => '#00377a', 'use_background_color' => 1, 'background_color' => '#739c03', 'position' => 10),
    array('code' => 'subheader', 'name' => 'Subheader', 'use_color' => 1, 'color' => '#00377a', 'use_background_color' => 1, 'background_color' => '#739c03', 'position' => 20),
    array('code' => 'connect_button', 'name' => 'Connect Button', 'use_color' => 1, 'color' => '#233799', 'use_background_color' => 1, 'background_color' => '#f2f2f2', 'position' => 30),
    array('code' => 'background', 'name' => 'Background', 'use_color' => 1, 'color' => '#ffffff', 'use_background_color' => 1, 'background_color' => '#0c6ec4', 'position' => 40),
    array('code' => 'discount', 'name' => 'Discount Zone', 'use_color' => 1, 'color' => '#fcfcfc', 'use_background_color' => 1, 'background_color' => '#739c03', 'position' => 50),
    array('code' => 'button', 'name' => 'Button', 'use_color' => 1, 'color' => '#fcfcfc', 'use_background_color' => 1, 'background_color' => '#00377a', 'position' => 60),
    array('code' => 'news', 'name' => 'News', 'use_color' => 1, 'color' => '#fcfcfc', 'use_background_color' => 1, 'background_color' => '#00377a', 'position' => 70),
    array('code' => 'comments', 'name' => 'Comments', 'use_color' => 1, 'color' => '#ffffff', 'use_background_color' => 1, 'background_color' => '#4d5d8a', 'position' => 80),
    array('code' => 'tabbar', 'name' => 'Tabbar', 'use_color' => 1, 'color' => '#ffffff', 'use_background_color' => 1, 'background_color' => '#739c03', 'image_color' => '#ffffff', 'position' => 90)
);

foreach($datas as $data) {
    $block = new Template_Model_Block();
    $block->setData($data)->save();
}

/** ADDING 3 TEMPLATES **/

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
        KEY (`category_id`),
        UNIQUE `UNIQUE_TEMPLATE_DESIGN_CATEGORY_DESIGN_ID_CATEGORY_ID` (`design_id`, `category_id`)
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
    "Entertainment",
    "Local Business",
    "Music"
);

foreach($categories as $category_name) {
    $category_data = array();
    $category_data['name'] = $category_name;
    $category_data['code'] = preg_replace('/[&\s]+/', "_", strtolower($category_name));

    $category = new Template_Model_Category();
    $category->find($category_data['code'], "code");

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
    )
);

foreach($designs as $code => $data) {
    $design = new Template_Model_Design();
    $design->find($code, "code");

    if(!$design->getId()) {
        $design->setData($data)
            ->setCode($code)
            ->save();

        if (!empty($data["blocks"])) {
            foreach ($data["blocks"] as $block_code => $block_data) {
                $block_data["design_id"] = $design->getId();
                $block_data["block_id"] = $block_ids[$block_code];
                $this->_db->insert("template_design_block", $block_data);
            }
        }
    }

}

// Assigning designs to categories
$categories_designs = array(
    "entertainment" => array(
        "fairground"
    ),
    "local_business" => array(
        "pizza"
    ),
    "music" => array(
        "dj"
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
    "pizza" => array(
        "m_commerce" => array("name" => "Orders"),
        "loyalty" => array("name" => "Loyalty"),
        "social_gaming" => array(),
        "discount" => array(),
        "facebook" => array(),
        "contact" => array()
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

            $design_content = new Template_Model_Design_Content();
            $design_content->setData($data)->save();
        }
    }
}
