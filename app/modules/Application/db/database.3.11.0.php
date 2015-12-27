<?php

$this->query("
    ALTER TABLE `application` ADD `ios_status_bar_is_hidden` boolean DEFAULT 0 AFTER `use_homepage_background_image_in_subpages`;
    ALTER TABLE `application` ADD `homepage_slider_is_visible` boolean DEFAULT 0 AFTER `startup_image_ipad_retina`;
    ALTER TABLE `application` ADD `homepage_slider_duration` int DEFAULT 3 AFTER `homepage_slider_is_visible`;
    ALTER TABLE `application` ADD `homepage_slider_loop_at_beginning` boolean DEFAULT 0 AFTER `homepage_slider_duration`;
    ALTER TABLE `application` ADD `homepage_slider_library_id` int DEFAULT NULL AFTER `homepage_slider_loop_at_beginning`;
");