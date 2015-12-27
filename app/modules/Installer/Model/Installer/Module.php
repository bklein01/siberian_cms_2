<?php

class Installer_Model_Installer_Module extends Core_Model_Default
{

    const DEFAULT_VERSION = '0.0.1';

    protected $_name;

    protected $_lastVersion;

    protected $_dbFiles = array();

    protected $_isInstalled = false;

    protected $_basePath;

    public function __construct($config = array()) {
        $this->_db_table = 'Installer_Model_Db_Table_Installer_Module';
        parent::__construct($config);
    }

    public function prepare($name) {

        $this->_name = $name;
        $this->findByName($name);

        if(!$this->getId()) {
            $this->setName($name)
                ->setVersion(self::DEFAULT_VERSION)
            ;
            $this->_isInstalled = false;
        }
        else {
            $this->_isInstalled = true;
        }

        $this->_basePath = Core_Model_Directory::getBasePathTo("app/modules/{$name}");

        $versions = array();
        $installer = array("version" => "0.0.0");

        if(is_dir("$this->_basePath/db")) {

            $max_version = "0.0.0";
            $files = new DirectoryIterator("$this->_basePath/db");

            if(!$this->isInstalled()) {

                foreach($files as $file) {

                    if($file->isDot() OR !preg_match("/^(database)([0-9.]*)(install.php)$/", $file->getFilename())) continue;

                    $version = str_replace(array('database.', '.install.php'), '', $file);
                    if(version_compare($version, $installer["version"]) > 0) {
                        $installer = array(
                            "version" => $version,
                            "path" => $file->getPathName()
                        );

                    }

                }
            }

            foreach($files as $file) {

                if($file->isDot() OR !preg_match("/^(database)(([0-9.]*)|(.template\.))(php)$/", $file->getFilename())) continue;

                $version = str_replace(array('database.', '.php'), '', $file->getFilename());
                if(version_compare($version, $installer["version"]) > 0) {
                    $this->_dbFiles[$version] = $file->getPathName();
                    $versions[] = $version;
                }

            }

            if(!empty($installer["path"])) {
                $this->_dbFiles[$installer["version"]] = $installer["path"];
                $versions[] = $installer["version"];
            }

            uksort($this->_dbFiles, "version_compare");
            usort($versions, "version_compare");

        }

        $this->_lastVersion = !empty($versions) ? end($versions) : self::DEFAULT_VERSION;

        return $this;
    }

    public function reset() {
        $this->_lastVersion = null;
        $this->_dbFiles = array();
        $this->_isInstalled = false;
        $this->_basePath = null;
        return $this;

    }

    public function findByName($name) {

        if($this->getTable()->isInstalled()) {
            $this->find($name, 'Name');
        }

        return $this;
    }

    public function getName() {
        return $this->_name;
    }

    public function isInstalled() {
        return $this->_isInstalled;
    }

    public function canUpdate() {
        return version_compare($this->getVersion(), $this->_lastVersion, '<');
    }

    public function install() {
        
        foreach($this->_dbFiles as $version => $file) {
            if(version_compare($version, $this->getVersion(), '>')) {
                $this->_run($file, $version);
                $this->save();
            }
        }

    }

    protected function _run($file, $version) {

        try {
            $this->getTable()->install($this->getName(), $file, $version);
            $this->setVersion($version);
        }
        catch(Exception $e) {
            $logger = Zend_Registry::get("logger");
            $logger->sendException("Fatal Error When Connecting to The Database: \n".print_r($e, true));
        }
        return $this;
    }

}