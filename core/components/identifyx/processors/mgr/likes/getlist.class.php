<?php
/**
 * Get a list of idfxUserLikes
 */
class idfxUserLikesGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'idfxUserLikes';
	public $classKey = 'idfxUserLikes';
	public $defaultSortField = 'createdon';
	public $defaultSortDirection = 'DESC';
	//public $permission = 'list';

	/**
	 * @param xPDOQuery $c
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$q = trim($this->getProperty('query'));

		$c->leftJoin('modUserProfile', 'modUserProfile', 'createdby = modUserProfile.internalKey');
		$c->leftJoin('modResource', 'modResource', 'res_id = modResource.id');
		$c->select($this->modx->getSelectColumns('idfxUserLikes', 'idfxUserLikes'));
		$c->select('modUserProfile.fullname as user_name, modResource.pagetitle as title');

		if ($q) {
			$c->where(array(
				'modUserProfile.fullname:LIKE' => "%{$q}%",
				'OR:modResource.pagetitle:LIKE' => "%{$q}%",
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

return 'idfxUserLikesGetListProcessor';
