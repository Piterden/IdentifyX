<?php
/**
 * Remove an userData Items
 */
class idfxOfficeDataRemoveProcessor extends modObjectProcessor {
	public $objectType = 'identifyx_item';
	public $classKey = 'userData';
	public $languageTopics = array('identifyx:default');
	//public $permission = 'remove';

	/**
	 * @return array|string
	 */
	public function process() {
		if (!$this->checkPermissions()) {
			return $this->failure($this->modx->lexicon('access_denied'));
		}

		$ids = $this->modx->fromJSON($this->getProperty('ids'));
		if (empty($ids)) {
			return $this->failure($this->modx->lexicon('identifyx_item_err_ns'));
		}

		foreach ($ids as $id) {
			/** @var userData $dataObj */
			if (!$dataObj = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('identifyx_item_err_nf'));
			}

			$dataObj->remove();
		}

		return $this->success();
	}
}

return 'idfxOfficeDataRemoveProcessor';
