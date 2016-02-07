<?php
/**
 * The base class for IdentifyX.
 */
class IdentifyX {
	/* @var modX $modx */
	public $modx;

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
		$user_id = $params['user_id'];
		$res_id = $params['res_id'];
		$fp_val = $params['fp'];

		// if not in table - create new
		if (!$fp_obj = $this->getFp($fp_val)) {
			$fp_obj = $this->addFp($fp_val);
		} else {
			// if auth and back to likedislike
			if ($user_id > 0) {
				return true;
			}
		}

		// check vote
		if ($this->getLike($fp_obj->get('id'), $res_id) && $user_id == 0) {
			return array(
				'error' => 'fp_already_voted',
				'lang_error' => $this->modx->lexicon('identifyx_err_fp_blocked'),
			);
		}
        return true;

	}

	public function idfxProcess(array $params) {
		$user_id = $params['user_id'];
		$fp_val = $params['fp'];
		$fp_obj = $this->getFp($fp_val, $user_id);
		$fp_id = $fp_obj->get('id');

		$this->addLike($fp_id, $params['res_id'], $user_id);
		$this->calculateVotes($fp_obj, $user_id);
		if (!$this->getIp($fp_id, $params['ip'], $user_id)) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] params'.print_r($params, true));
			$this->addIp($fp_id, $params['ip'], $user_id);
		};
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
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] fp not calculated');
		}
		return $fp_obj->toArray();
	}

	public function getFp($fp, $user_id = 0) {
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



	// 	// The name of the array to retrieve the name of the category, it is easier sorting in admin panel
 //        $cat = explode('::',$name);
 //        // Attempt to create a new item
 //        $item->set('category',$cat[0]);
 //        $item->set('date',time());
 //        $item->set('closed',FALSE);
 //        $item->set('votes_up',0);
 //        $item->set('votes_down',0);
 //        if(!$item->save()){
 //            return FALSE;
 //        }
 //        return $item;

	/**
	 * Method loads custom controllers
	 * @var string $dir Directory for load controllers
	 * @return void
	 */
 	// public function loadController($name) {
 	// 	require_once 'controller.class.php';
 	// 	$name = strtolower(trim($name));
 	// 	$file = $this->config['controllersPath'] . $name . '/' . $name.'.class.php';
 	// 	if (!file_exists($file)) {$file = $this->config['controllersPath'] . $name.'.class.php';}
 	// 	if (file_exists($file)) {
 	// 		$class = include_once($file);
 	// 		if (!class_exists($class)) {
 	// 			$this->modx->log(modX::LOG_LEVEL_ERROR, '[Identifyx] Wrong controller at '.$file);
 	// 		}
 	// 		/* @var IdentifyXDefaultController $controller */
 	// 		else if ($controller = new $class($this, $this->config)) {
 	// 			if ($controller instanceof IdentifyXDefaultController && $controller->initialize()) {
 	// 				$this->controllers[strtolower($name)] = $controller;
 	// 			}
 	// 			else {
 	// 				$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] Could not load controller '.$file);
 	// 			}
 	// 		}
 	// 	}
 	// 	else {
 	// 		$this->modx->log(modX::LOG_LEVEL_ERROR, '[IdentifyX] Could not find controller '.$file);
 	// 	}
 	// }

 	// /**
 	//  * Loads given action, if exists, and transfers work to it
 	//  * @param $action
 	//  * @param array $scriptProperties
 	//  * @return bool
 	//  */
 	// public function loadAction($action, $scriptProperties = array()) {
 	// 	if (!empty($action)) {
 	// 		@list($name, $action) = explode('/', strtolower(trim($action)));
 	// 		if (!isset($this->controllers[$name])) {
 	// 			$this->loadController($name);
 	// 		}
 	// 		if (isset($this->controllers[$name])) {
 	// 			/* @var IdentifyXDefaultController $controller */
 	// 			$controller = $this->controllers[$name];
 	// 			$controller->setDefault($scriptProperties);
 	// 			if (empty($action)) {$action = $controller->getDefaultAction();}
 	// 			if (method_exists($controller, $action)) {
 	// 				return $controller->$action($scriptProperties);
 	// 			}
 	// 		}
 	// 		else {
 	// 			return 'Could not load controller "'.$name.'"';
 	// 		}
 	// 	}
 	// 	return false;
 	// }
 	// /**
 	//  * Shorthand for load and run an processor in this component
 	//  * @param string $action
 	//  * @param array $scriptProperties
 	//  * @return mixed
 	//  */
 	// function runProcessor($action = '', $scriptProperties = array()) {
 	// 	$this->modx->error->errors = $this->modx->error->message = null;
 	// 	return $this->modx->runProcessor($action, $scriptProperties, array(
 	// 			'processors_path' => $this->config['processorsPath']
 	// 		)
 	// 	);
 	// }

}
