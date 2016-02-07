<?php
/**
 * @package IdentifyX
 * @subpackage resource.mysql
 */
class idfxResource extends modResource {
    function __construct(xPDO & $xpdo) {
        parent::__construct($xpdo);
        $this->set('class_key','idfxResource');
    }
}
