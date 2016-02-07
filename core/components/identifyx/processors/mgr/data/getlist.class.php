<?php
/**
 * Get a list of Items
 */
class idfxUserDataGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'idfxUserData';
	public $classKey = 'idfxUserData';
	public $defaultSortField = 'user_id';
	public $defaultSortDirection = 'ASC';
	//public $permission = 'list';

	/**
	 * @param xPDOQuery $c
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {

		$q = trim($this->getProperty('query'));
		if ($q) {
			$c->where(array(
				'user_name:LIKE' => "%{$q}%",
			));
		}

		$c->leftJoin('modUserProfile', 'modUserProfile', 'user_id = modUserProfile.internalKey');
		$c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));
		$c->select('modUserProfile.blocked, modUserProfile.fullname as user_name');

		return $c;
	}

	/**
	 * @param xPDOObject $object
	 * @return array
	 */
	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();
		$array['actions'] = array();
		$array['blocked'] = false;

		$userProfile = $this->modx->getObject('modUserProfile', array(
			'internalKey' => $array['user_id']
		));
		if ($userProfile) {
			$array['blocked'] = (boolean)$userProfile->get('blocked');
		}

		if ($array['blocked']) {
			$array['actions'][] = array(
				'cls' => '',
				'icon' => 'icon icon-power-off action-green',
				'title' => $this->modx->lexicon('identifyx_user_enable'),
				'multiple' => $this->modx->lexicon('identifyx_users_enable'),
				'action' => 'unblockUser',
				'button' => true,
				'menu' => true,
			);
		}
		else {
			$array['actions'][] = array(
				'cls' => '',
				'icon' => 'icon icon-power-off action-gray',
				'title' => $this->modx->lexicon('identifyx_user_disable'),
				'multiple' => $this->modx->lexicon('identifyx_users_disable'),
				'action' => 'blockUser',
				'button' => true,
				'menu' => true,
			);
		}

		/*// Edit
		$array['actions'][] = array(
			'cls' => '',
			'icon' => 'icon icon-edit',
			'title' => $this->modx->lexicon('identifyx_item_update'),
			'multiple' => $this->modx->lexicon('identifyx_items_update'),
			'action' => 'updateData',
			'button' => true,
			'menu' => true,
		);

		// Remove
		$array['actions'][] = array(
			'cls' => '',
			'icon' => 'icon icon-trash-o action-red',
			'title' => $this->modx->lexicon('identifyx_item_remove'),
			'multiple' => $this->modx->lexicon('identifyx_items_remove'),
			'action' => 'removeData',
			'button' => true,
			'menu' => true,
		);*/

		return $array;
	}

	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}

return 'idfxUserDataGetListProcessor';
