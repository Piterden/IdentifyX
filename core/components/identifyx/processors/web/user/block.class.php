<?php
/**
 * Ban modUser
 */
class idfxOfficeUserBlockProcessor extends modUserDeactivateMultipleProcessor {
	public $objectType = 'identifyx_user';
	public $classKey = 'modUser';
	public $languageTopics = array('identifyx:default');
	public $permission = 'save';

	/**
	 * @return array|string
	 */
	public function process() {
		if (!$this->checkPermissions()) {
			return $this->failure($this->modx->lexicon('access_denied'));
		}

		$ids = $this->modx->fromJSON($this->getProperty('ids'));
		if (empty($ids)) {
			return $this->failure($this->modx->lexicon('identifyx_user_err_ns'));
		}

		foreach ($ids as $id) {
			/** @var modUser $user */
			if (!$user = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('identifyx_user_err_nf').' №'.$id);
			}

			$profile = $user->getOne('Profile');
			$profile->set('blocked', 1);
			$user->save();
		}

		return $this->success();
	}
}

return 'idfxOfficeUserBlockProcessor';
