<?php
$weather_resource = new Acl_Model_Resource();
$weather_resource->find("weather", "code");

if($weather_resource->getId()) {
    $weather_resource->setCode("feature_weather")
        ->setLabel("Weather")
        ->save();
}
