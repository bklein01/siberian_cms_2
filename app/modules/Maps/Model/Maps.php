<?php
class Maps_Model_Maps extends Core_Model_Default {

    public function __construct($params = array()) {
        parent::__construct($params);
        $this->_db_table = 'Maps_Model_Db_Table_Maps';
        return $this;
    }

    public function copyTo($option) {

        $this->setId(null)->setValueId($option->getId())->save();
        return $this;

    }

}
