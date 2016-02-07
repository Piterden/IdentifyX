<?php
/**
 * @package IdentifyX
 * @subpackage idfxuser.mysql
 */
class idfxUser extends modUser {
    function __construct(xPDO &$xpdo) {
        parent::__construct($xpdo);
        $this->set('class_key','idfxUser');
    }
}
