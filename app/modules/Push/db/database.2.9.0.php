<?php

$this->query("
    UPDATE `application_option`
        SET `model` = 'Push_Model_Message'
        WHERE `code` = 'push_notification'
    ;
");