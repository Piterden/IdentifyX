<?php
/**
 * Class IdentifyXManagerController
 */
abstract class IdentifyXManagerController extends modExtraManagerController {
	/** @var IdentifyX $identifyx */
	public $identifyx;

	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('identifyx_core_path', null, $this->modx->getOption('core_path') . 'components/identifyx/');
		require_once $corePath . 'model/identifyx/identifyx.class.php';

		$this->identifyx = new IdentifyX($this->modx);
		$this->addCss($this->identifyx->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->identifyx->config['jsUrl'] . 'mgr/identifyx.js');
		$this->addHtml('
		<script type="text/javascript">
			IdentifyX.config = ' . $this->modx->toJSON($this->identifyx->config) . ';
			IdentifyX.config.connector_url = "' . $this->identifyx->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}

	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('identifyx:default');
	}

	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}

/**
 * Class IndexManagerController
 */
class IndexManagerController extends IdentifyXManagerController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}
