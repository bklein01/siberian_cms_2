<?php

$application_option = new Application_Model_Option();
$application_option->find("topic", "code");
$application_option->setMobileUri("topic/mobile_list/")->save();
