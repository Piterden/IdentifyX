<?php
/**
 * Gets a list of users
 *
 * @param string $username (optional) Will filter the grid by searching for this
 * username
 * @param integer $start (optional) The record to start at. Defaults to 0.
 * @param integer $limit (optional) The number of records to limit to. Defaults
 * to 10.
 * @param string $sort (optional) The column to sort by. Defaults to name.
 * @param string $dir (optional) The direction of the sort. Defaults to ASC.
 *
 * @package modx
 * @subpackage processors.security.user
 */
class modUserGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'modUser';
    public $languageTopics = array('user');
    //public $permission = 'view_user';
    public $defaultSortField = 'id';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->leftJoin('modUserProfile','Profile', 'modUser.id=Profile.internalKey');
        $c->select('Profile.fullname, Profile.email, modUser.username, modUser.id');

        $query = $this->getProperty('query','');
        if (!empty($query)) {
            $c->where(array(
                'modUser.username:LIKE' => '%'.$query.'%',
                'OR:Profile.fullname:LIKE' => '%'.$query.'%',
                'OR:Profile.email:LIKE' => '%'.$query.'%',
            ));
        }

        $user_ids = $this->getProperty('user_ids');
        if (!empty($user_ids)) {
    		$id_arr = explode(',', $user_ids);
    		foreach ($id_arr as $id) {
	    		$c->where(array(
	    			'id' => $user_ids,
	    		));
    		}
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
return 'modUserGetListProcessor';
