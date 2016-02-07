<?php
/**
 * Create an userData Item
 */
class idfxOfficeDataCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'identifyx_item';
	public $classKey = 'userData';
	public $languageTopics = array('identifyx:default');
	//public $permission = 'create';

	/**
	 * @return bool
	 */
	public function beforeSet() {
		$data = $this->getProperties();
		$user_id = $data['user_id'];
		$fp = $data['fingerprint'];

		if (empty($fp)) {
			$this->modx->error->addField('fp_error', $this->modx->lexicon('identifyx_item_err_fingerprint'));
		}
		elseif ($this->modx->getCount($this->classKey, array('user_id' => $user_id, 'fingerprint' => $fp))) {
			$this->modx->runProcessor('userDataUpdateProcessor', $data);
		}

		return parent::beforeSet();
	}

	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}

return 'idfxOfficeDataCreateProcessor';
