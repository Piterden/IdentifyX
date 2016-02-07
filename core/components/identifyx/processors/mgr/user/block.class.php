<?php
/**
 * Ban User
 */
require_once(MODX_PROCESSORS_PATH.'security/user/deactivatemultiple.class.php');
class idfxUserDeactivateMultipleProcessor extends modUserDeactivateMultipleProcessor {
	public $objectType = 'modUser';
	public $classKey = 'modUser';
	public $languageTopics = array('identifyx:default');
	public $permission = 'save_user';

	public function process() {
        $users = $this->getProperty('users');
        if (empty($users)) {
            return $this->failure($this->modx->lexicon('user_err_ns'));
        }
        $userIds = explode(',',$users);

        foreach ($userIds as $userId) {
            /** @var modUser $user */
            $user = $this->modx->getObject('modUser',$userId);
            $profile = $user->getOne('Profile');
            if ($user == null || $profile == null) continue;

            $profile->set('blocked',true);

            if ($user->save() === false) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,$this->modx->lexicon('user_err_save'));
            }
        }

        return $this->success();
    }
}

return 'idfxUserDeactivateMultipleProcessor';
