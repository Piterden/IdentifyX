<?php
/**
 * The base class for IdentifyX.
 */
class IdentifyX {
	/* @var modX $modx */
	public $modx;
	//public $fp;

	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('identifyx_core_path', $config, $this->modx->getOption('core_path') . 'components/identifyx/');
		$assetsUrl = $this->modx->getOption('identifyx_assets_url', $config, $this->modx->getOption('assets_url') . 'components/identifyx/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'assetsPath' => MODX_ASSETS_PATH .'components/identifyx/',
			'cssUrl' => $assetsUrl.'css/',
			'jsUrl' => $assetsUrl.'js/',
			'imagesUrl' => $assetsUrl.'images/',
			'connectorUrl' => $connectorUrl,

			'actionUrl' => $assetsUrl.'action.php',
			'controllersPath' => $corePath.'controllers/',
			'cachePath' => $corePath.'cache/',

			'corePath' => $corePath,
			'modelPath' => $corePath.'model/',
			'chunksPath' => $corePath.'elements/chunks/',
			'templatesPath' => $corePath.'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath.'elements/snippets/',
			'processorsPath' => $corePath.'processors/',
		), $config);

		$this->modx->addPackage('identifyx', $this->config['modelPath']);
		$this->modx->lexicon->load('identifyx:default');
	}

	public function checkFp(array $params) {
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] !!!!!!check start '.print_r($params, true));
		$user_id = $params['user_id'];
		$res_id = $params['res_id'];
		$fp_val = $params['fp'];
		if (empty($fp_val)) {
			if (empty($user_id)) {
				$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] check fp no set< '.print_r($fp_val, true));
				return array(
					'error' => 'fp_is_empty',
					'lang_error' => $this->modx->lexicon('identifyx_err_fp_lost'),
				);
			} else {
				return true;
			}
		}
		// if not in table - create new
		if (!$fp_obj = $this->getFp($fp_val, $user_id)) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] new fp '.print_r($params, true));
			$fp_obj = $this->addFp($fp_val, $user_id);
		}
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] fp '.print_r($fp_obj->toArray(), true));
		// if auth - back to likedislike
		if ($user_id > 0) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] authorized back '.print_r($user_id, true));
			return true;
		}

		$is_voted = $this->modx->getCount('idfxUserLikes', array(
			'finger' => $fp_obj->get('id'),
			'res_id' => $res_id,
		));
		if ($is_voted > 0) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] already voted send error '.print_r($fp_obj->toArray(), true));
			return array(
				'error' => 'fp_already_voted',
				'lang_error' => $this->modx->lexicon('identifyx_err_fp_blocked'),
			);
		}

		$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] check end ');
        return true;
	}

	public function idfxProcess(array $params) {
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] process start '.print_r($params, true));
		$user_id = $params['user_id'];
		$fp_val = $params['fp'];
		if (!$fp_obj = $this->getFp($fp_val, $user_id)) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] process not get $fp_obj '.print_r($fp_val, true).print_r($user_id, true));
			return true;
		}
		$fp_id = $fp_obj->get('id');
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] process start add like'.$fp_id.$params['res_id'].$user_id);
		$this->addLike($fp_id, $params['res_id'], $user_id);
		$this->calculateVotes($fp_obj, $user_id);
		if (!$this->getIp($fp_id, $params['ip'], $user_id)) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] process ip not found');
			$ip = $this->addIp($fp_id, $params['ip'], $user_id);
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] process new ip aded '.$ip);
		};


		$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] process finished ');
		return true;
	}

	public function calculateVotes($fp_obj, $user_id) {
		$fp_id = $fp_obj->get('id');
		$votes = $this->modx->getCount('idfxUserLikes', array(
			'finger' => $fp_id,
			'createdby' => $user_id,
		));
		$fp_obj->set('votes', $votes);
		if (!$fp_obj->save()) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] votes not calculated');
		}
		return $fp_obj->toArray();
	}

	public function getFp($fp, $user_id) {
		if ($fp_obj = $this->modx->getObject('idfxUserData', array(
			'fingerprint' => $fp,
			'user_id' => $user_id,
		))) {
			return $fp_obj;
		};
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] fp not get');
		return false;
	}

	public function addFp($fp_val, $user_id = 0) {
		$fp = $this->modx->newObject('idfxUserData');
		$fp->set('fingerprint', $fp_val);
		$fp->set('user_id', $user_id);
		$fp->set('votes', 0);
		if (!$fp->save()) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] fp not saved');
			return false;
		}
		return $fp;
	}

	public function getIp($fp_id, $ip, $user_id) {
		if (!$ip_obj = $this->modx->getObject('idfxUserIps', array(
			'finger' => $fp_id,
			'ip' => $ip,
			'user_id' => $user_id,
		))) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] ip not get');
			return false;
		};
		return $ip_obj->toArray();
	}

	public function addIp($fp_id, $ip, $user_id) {
		$ip_obj = $this->modx->newObject('idfxUserIps');
		$ip_obj->set('finger', $fp_id);
		$ip_obj->set('ip', $ip);
		$ip_obj->set('user_id', $user_id);
		if (!$ip_obj->save()) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] ip_obj not save');
			return false;
		};
		return $ip_obj->toArray();
	}

	public function getLike($fp_id, $res_id) {
		if (!$like = $this->modx->getObject('idfxUserLikes', array(
			'finger' => $fp_id,
			'res_id' => $res_id,
		))) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] like not get');
			return false;
		};
		return $like->toArray();
	}

	public function addLike($fp_id, $res_id, $user_id = 0) {
		$like = $this->modx->newObject('idfxUserLikes');
		$like->set('finger', $fp_id);
		$like->set('res_id', $res_id);
		$like->set('createdby', $user_id);
		$like->set('createdon', strftime('%Y-%m-%d %H:%M:%S'));
		if (!$like->save()) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] like not save');
			return false;
		};
		// $this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] like '.print_r($like->toArray(),true));
		return $like->toArray();
	}

}
