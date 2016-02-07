<?php
/**
 * Update an userData Item
 */
class idfxOfficeDataUpdateProcessor extends modObjectUpdateProcessor {
	public $objectType = 'identifyx_item';
	public $classKey = 'userData';
	public $languageTopics = array('identifyx:default');
	//public $permission = 'save';

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

		if ($userData = $this->modx->getObject($this->classKey, array('user_id' => $data['user_id'], 'fingerprint' => $data['fingerprint']))) {
			$this->setProperty('votes')++;
		} else {
			// $this->modx->runProcessor('userDataCreateProcessor', $data);
		}

		return parent::beforeSet();
	}
}

return 'idfxOfficeDataUpdateProcessor';
