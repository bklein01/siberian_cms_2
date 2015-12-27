<?php
/**
 * Siberian_Controller_Request_Http
 *
 * HTTP request object for use with Zend_Controller family.
 * Add set & getMediaUrl
 *
 * @uses Zend_Controller_Request_Abstract
 * @package Siberian_Controller
 * @subpackage Request
 */
class Siberian_Controller_Request_Http extends Zend_Controller_Request_Http
{

    protected $_is_application = false;
    protected $_language_code;
    protected $_force_language_code = false;
    protected $_is_native;
    protected $_use_application_key = false;
    protected $_white_label_editor;
    protected $_is_installing = false;
    protected $_mediaUrl;

    public function setPathInfo($pathInfo = null) {

        parent::setPathInfo($pathInfo);

        $path = $this->_pathInfo;
        $paths = explode('/', trim($path, '/'));
        $language = !empty($paths[0]) ? $paths[0] : '';

        if(in_array($language, Core_Model_Language::getLanguageCodes())) {
            $this->_language_code = $language;
            unset($paths[0]);
            $paths = array_values($paths);
        }

        if(!$this->isInstalling()) {
            $paths = $this->_initApplication($paths);

            if(!$this->isApplication()) {
                $this->_initWhiteLabelEditor();
            }

        }

        // $paths = array_diff($paths, Core_Model_Language::getLanguageCodes());
        $paths = array_values($paths);
        $this->_pathInfo = '/'.implode('/', $paths);

        $detector = new Mobile_Detect();
        $this->_is_native = $detector->isNative();

        return $this;
    }

    public function setMediaUrl($url) {
        $this->_mediaUrl = $url;
        return $this;
    }

    public function getMediaUrl() {
        $url = $this->_mediaUrl;
        if(!$url) {
            $url = $this->_baseUrl;
        }

        return $url;
    }

    public function getLanguageCode() {
        return $this->_language_code;
    }

    public function setLanguageCode($language_code) {
        $this->_language_code = $language_code;
        return $this;
    }

    public function addLanguageCode($language_code = null) {
        if(!is_null($language_code)) {
            $this->_force_language_code = true;
            $this->_language_code = $language_code;
            return $this;
        } else {
            return $this->_force_language_code;
        }
    }

    public function isApplication() {
        return $this->_is_application;
    }

    public function isWhiteLabelEditor() {
        return $this->getWhiteLabelEditor() && $this->getWhiteLabelEditor()->isActive();
    }

    public function isNative() {
        return $this->_is_native;
    }

    public function getApplication() {
        return Application_Model_Application::getInstance();
    }

    public function getWhiteLabelEditor() {
        return $this->_white_label_editor;
    }
    
    public function useApplicationKey($use_key = null) {
        if (is_bool($use_key)) {
            $this->_use_application_key = $use_key;
            return $this;
        }

        return $this->_use_application_key;
    }

    public function isInstalling($isInstalling = null) {
        if(!is_null($isInstalling)) {
            $this->_is_installing = $isInstalling;
            return $this;
        } else {
            return $this->_is_installing;
        }
    }

    public function getFilteredParams() {

        $params = $this->getParams();
        $replacements = array("module", "controller", "action");

        foreach($replacements as $replacement) {
            if(isset($params[$replacement])) unset($params[$replacement]);
        }

        return $params;

    }

    protected function _initApplication($paths) {

        if(!empty($paths[0]) AND $paths[0] == Application_Model_Application::OVERVIEW_PATH) {
            $this->_is_application = true;
            $this->_use_application_key = true;
            unset($paths[0]);
        } else if($this->getHttpHost() == Application_Model_Application::getInstance()->getDomain()) {
            $this->_is_application = true;
            $this->_use_application_key = false;
        }

        return $paths;

    }

    protected function _initWhiteLabelEditor() {

        try {
            if(Installer_Model_Installer::hasModule("whitelabel")) {
                $this->_white_label_editor = new Whitelabel_Model_Editor();
                $this->_white_label_editor->find($this->getHttpHost(), "host");
                if(!$this->_white_label_editor->isActive()) {
                    $this->_white_label_editor->unsData();
                }
            } else {
                $this->_white_label_editor = new Core_Model_Default(array("is_active" => false));
            }

        } catch(Exception $e) {}

        return $this;

    }

}
