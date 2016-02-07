<?php
/**
 * Get a list of idfxUserLikes
 */
class idfxUserLikesGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'idfxUserLikes';
	public $classKey = 'idfxUserLikes';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'ASC';
	//public $permission = 'list';

	/**
	 * @param xPDOQuery $c
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$q = trim($this->getProperty('query'));

		$c->innerJoin('modUser', 'User', 'User.id = idfxUserLikes.user_id');
		$c->innerJoin('modResource', 'Resource', 'Resource.id = idfxUserLikes.res_id');
		$c->select($this->modx->getSelectColumns('idfxUserLikes', 'idfxUserLikes'));
		$c->select('User.fullname as user_name, Resource.pagetitle as title');

		if ($q) {
			$c->where(array(
				'user_name:LIKE' => "%{$q}%",
				'OR:title:LIKE' => "%{$q}%",
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
