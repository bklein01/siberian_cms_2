<?php

$fields = array_keys($this->_db->describeTable("application_option"));
if(!in_array("mobile_view_uri", $fields)) {
    $this->query("
        ALTER TABLE `application_option` ADD `mobile_view_uri` varchar(100) NULL DEFAULT NULL AFTER `mobile_uri`;
        ALTER TABLE `application_option` ADD `mobile_view_uri_parameter` varchar(100) NULL DEFAULT NULL AFTER `mobile_view_uri`;
    ");
}

$mobile_view_uris = array(
    "booking" => array(
        "mobile_view_uri" => "booking/mobile_view/",
        "mobile_view_uri_parameter" => null
    ),
    "calendar" => array(
        "mobile_view_uri" => "event/mobile_view/",
        "mobile_view_uri_parameter" => "event_id"
    ),
    "catalog" => array(
        "mobile_view_uri" => "catalog/mobile_category_product_view/",
        "mobile_view_uri_parameter" => "product_id"
    ),
    "custom_page" => array(
        "mobile_view_uri" => "cms/mobile_page_view/",
        "mobile_view_uri_parameter" => null
    ),
    "discount" => array(
        "mobile_view_uri" => "promotion/mobile_view/",
        "mobile_view_uri_parameter" => "promotion_id"
    ),
    "fanwall" => array(
        "mobile_view_uri" => "comment/mobile_view/",
        "mobile_view_uri_parameter" => "comment_id"
    ),
    "image_gallery" => array(
        "mobile_view_uri" => "media/mobile_gallery_image_view/",
        "mobile_view_uri_parameter" => "gallery_id,offset/0"
    ),
    "m_commerce" => array(
        "mobile_view_uri" => "mcommerce/mobile_product/",
        "mobile_view_uri_parameter" => "product_id"
    ),
    "music_gallery" => array(
        "mobile_view_uri" => "media/mobile_api_music_playlist/",
        "mobile_view_uri_parameter" => "playlist_id"
    ),
    "newswall" => array(
        "mobile_view_uri" => "comment/mobile_view/",
        "mobile_view_uri_parameter" => "comment_id"
    ),
    "qr_discount" => array(
        "mobile_view_uri" => "promotion/mobile_view/",
        "mobile_view_uri_parameter" => "promotion_id"
    ),
    "rss_feed" => array(
        "mobile_view_uri" => "rss/mobile_feed_view/",
        "mobile_view_uri_parameter" => "feed_id"
    ),
    "set_meal" => array(
        "mobile_view_uri" => "catalog/mobile_setmeal_view/",
        "mobile_view_uri_parameter" => "set_meal_id"
    ),
    "video_gallery" => array(
        "mobile_view_uri" => "media/mobile_gallery_video_view/",
        "mobile_view_uri_parameter" => "gallery_id,offset/1"
    )

);

foreach($mobile_view_uris as $option_code => $option_uris) {

    $application_option = new Application_Model_Option();
    $application_option->find($option_code, "code");

    if($application_option->getId()) {
        $application_option->setMobileViewUri($option_uris["mobile_view_uri"]);
        $application_option->setMobileViewUriParameter($option_uris["mobile_view_uri_parameter"]);

        $application_option->save();
    }

}
