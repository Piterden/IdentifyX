<?php
// For debug
ini_set('display_errors', 1);
ini_set('error_reporting', -1);
// Load MODX config
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
	require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
}
else {
	require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';
$corePath = $modx->getOption('identifyx_core_path', null, $modx->getOption('core_path') . 'components/identifyx/');
require_once $corePath . 'model/identifyx/identifyx.class.php';
$modx->identifyx = new IdentifyX($modx);
$modx->lexicon->load('identifyx:default');
/* handle request */
$path = $modx->getOption('processorsPath', $modx->identifyx->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));

