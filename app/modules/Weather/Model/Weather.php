<?php
class Weather_Model_Weather extends Core_Model_Default {

    public function __construct($params = array()) {
        parent::__construct($params);
        $this->_db_table = 'Weather_Model_Db_Table_Weather';
        return $this;
    }

    public function copyTo($option) {

        $this->setId(null)->setValueId($option->getId())->save();
        return $this;

    }

}
