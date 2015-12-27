<?php

$option = new Application_Model_Option();
$option->find("catalog", "code");
$option->setModel("Catalog_Model_Category")->save();