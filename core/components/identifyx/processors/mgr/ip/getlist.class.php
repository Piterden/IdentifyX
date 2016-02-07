<?php
/**
 * Get a list of Items
 */
class idfxUserIpsGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'idfxUserIps';
	public $classKey = 'idfxUserIps';
	public $defaultSortField = 'ip';
	public $defaultSortDirection = 'ASC';
	//public $permission = 'list';

	/**
	 * @param xPDOQuery $c
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {

		$c->leftJoin('modUserProfile', 'modUserProfile', 'user_id = modUserProfile.internalKey');
		$c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));
		$c->select('modUserProfile.blocked, modUserProfile.fullname as user_name');

		$q = trim($this->getProperty('query'));
		if ($q) {
			$c->where(array(
				'modUserProfile.fullname:LIKE' => "%{$q}%",
				'OR:ip:LIKE' => "%{$q}%",
			));
		}

		return $c;
	}

	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}

return 'idfxUserIpsGetListProcessor';
