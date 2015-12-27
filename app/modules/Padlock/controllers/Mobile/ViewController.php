<?php

class Padlock_Mobile_ViewController extends Application_Controller_Mobile_Default {

    public function findAction() {

        $unlock_by = explode("|", $this->getApplication()->getUnlockBy());

        $unlock_by_account = $unlock_by_qrcode = 0;
        foreach($unlock_by as $value) {
            if($value == "account") {
                $unlock_by_account = 1;
            } else if($value == "qrcode") {
                $unlock_by_qrcode = 1;
            }
        }

        $html = array(
            "page_title" => $this->getCurrentOptionValue()->getTabbarName()
        );

        $this->_sendHtml($html);
    }
    public function findunlocktypesAction() {

        $unlock_by = explode("|", $this->getApplication()->getUnlockBy());

        $unlock_by_account = $unlock_by_qrcode = 0;
        foreach($unlock_by as $value) {
            if($value == "account") {
                $unlock_by_account = 1;
            } else if($value == "qrcode") {
                $unlock_by_qrcode = 1;
            }
        }

        $html = array(
            "unlock_by_account" => $unlock_by_account,
            "unlock_by_qrcode" => $unlock_by_qrcode
        );

        $this->_sendHtml($html);
    }

    public function unlockbyqrcodeAction() {

        try {

            if ($data = Zend_Json::decode($this->getRequest()->getRawBody())) {

                if($this->getApplication()->getUnlockCode() != $data["qrcode"]) {
                    throw new Exception($this->_("This code is unrecognized"));
                }

                $html = array(
                    "success" => 1,
                );

            }
        } catch(Exception $e) {
            $html = array(
                "error" => 1,
                "message" => $e->getMessage()
            );
        }

        $this->_sendHtml($html);
    }
}