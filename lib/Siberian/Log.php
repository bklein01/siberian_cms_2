<?php

class Siberian_Log extends Zend_Log {

    protected $_filename;

    public function sendException($message, $log_prefix = "error_", $show_500_page = true) {

        $this->_writers = array();
        $filename = $log_prefix.uniqid().'.log';
        $writer = new Zend_Log_Writer_Stream(Core_Model_Directory::getBasePathTo('var/log/'.$filename));
        $this->addWriter($writer);
        $this->crit($message);

        if($show_500_page) {
            if (APPLICATION_ENV == "production") {
                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
                header("Location: /errors/500.php?log=" . $filename);
            } else {
                header("Content-Type: text/plain");
                echo "Error log: $filename" . PHP_EOL . PHP_EOL;
                echo "Stack Trace:" . PHP_EOL . PHP_EOL;
                print_r($message);
            }

            die;
        }

        return $this;
    }

    public function getFilename() {
        return $this->_filename;
    }

}
