<?php
/**
 * The home manager controller for IdentifyX.
 */
class IdentifyXHomeManagerController extends IdentifyXManagerController {
	/* @var IdentifyX $identifyx */
	public $identifyx;

	/**
	 * @param array $scriptProperties
	 */
	public function process(array $scriptProperties = array()) {
	}

	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('identifyx:default');
	}

	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
		$this->addCss($this->identifyx->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
		$this->addCss($this->identifyx->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->identifyx->config['jsUrl'] . 'mgr/misc/utils.js');
		$this->addJavascript($this->identifyx->config['jsUrl'] . 'mgr/misc/combo.js');
		$this->addJavascript($this->identifyx->config['jsUrl'] . 'mgr/widgets/likes.grid.js');
		$this->addJavascript($this->identifyx->config['jsUrl'] . 'mgr/widgets/likes.windows.js');
		$this->addJavascript($this->identifyx->config['jsUrl'] . 'mgr/widgets/ips.grid.js');
		$this->addJavascript($this->identifyx->config['jsUrl'] . 'mgr/widgets/ips.windows.js');
		$this->addJavascript($this->identifyx->config['jsUrl'] . 'mgr/widgets/data.grid.js');
		$this->addJavascript($this->identifyx->config['jsUrl'] . 'mgr/widgets/data.windows.js');
		$this->addJavascript($this->identifyx->config['jsUrl'] . 'mgr/widgets/home.panel.js');
		$this->addJavascript($this->identifyx->config['jsUrl'] . 'mgr/sections/home.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "identifyx-page-home"});
		});
		</script>');
	}

	/**
	 * @return string
	 */
	public function getTemplateFile() {
		return $this->identifyx->config['templatesPath'] . 'home.tpl';
	}
}
