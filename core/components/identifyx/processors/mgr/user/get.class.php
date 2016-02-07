<?php
/**
 * @package identifyx
 * Get a user
 *
 * @param integer $id The ID of the user
 *
 * @var modX $modx
 * @var array $scriptProperties
 *
 * @package modx
 * @subpackage processors.security.user
 */
class idfxUserGetProcessor extends modUserGetProcessor {
    public $objectType = 'user';
    public $classKey = 'modUser';
    public $permission = 'view_user';
}
return 'idfxUserGetProcessor';
