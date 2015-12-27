<?php

$this->query("
    UPDATE `application_option`
        SET `model` = 'Socialgaming_Model_Game'
        WHERE `code` = 'social_gaming'
    ;
");