<?php
/**
 * Create an idfxUserLikes Item
 */
class idfxUserLikesCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'identifyx_like';
	public $classKey = 'idfxUserLikes';
	public $languageTopics = array('identifyx:default');
	//public $permission = 'create';

	/**
	 * @return bool
	 */
	public function beforeSet() {
		$data = $this->getProperties();

		if (empty($data['ip'])) {
			$this->modx->error->addField('ip_error', $this->modx->lexicon('identifyx_ip_addr_err'));
		}
		elseif ($dataObj = $this->modx->getObject($this->classKey, array(
			'user_id' => $data['user_id'],
			'ip' => $data['ip']
		))) {
			return $this->modx->runProcessor('idfxUserLikesUpdateProcessor', array_merge($dataObj->toArray(), $data));
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

return 'idfxUserLikesCreateProcessor';
