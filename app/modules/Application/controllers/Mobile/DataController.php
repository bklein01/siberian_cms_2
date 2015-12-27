<?php

class Application_Mobile_DataController extends Application_Controller_Mobile_Default {

    public function findallAction() {

        $pages = $this->getApplication()->getOptions();
        $paths = array();

        try {
            foreach ($pages as $page) {

                if (!$page->isActive() OR (!$page->getIsAjax() AND $page->getObject()->getLink())) continue;

                $model = $page->getModel();
                $object = new $model();

                if(!$object->isCachable()) continue;

                $features = $object->findAll(array("value_id" => $page->getId()));

                foreach ($features as $feature) {
                    $paths = array_merge($paths, $feature->getFeaturePaths($page));
                }

            }

            $paths = array_merge($paths, $this->getApplication()->getAllPictos());
            $paths = array_unique($paths);

        } catch(Exception $e) {
            die();
        }

        $this->_sendHtml($paths);
    }

}
