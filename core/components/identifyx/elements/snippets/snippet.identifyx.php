<?php
/** @var array $scriptProperties */
/** @var IdentifyX $identifyx */
if (!$identifyx = $modx->getService('identifyx', 'IdentifyX', $modx->getOption('identifyx_core_path', null, $modx->getOption('core_path') . 'components/identifyx/') . 'model/identifyx/', $scriptProperties)) {
	return 'Could not load IdentifyX class!';
}

// Do your snippet code here. This demo grabs 5 items from our custom table.
$tpl = $modx->getOption('tpl', $scriptProperties, 'data.tpl');
$sortby = $modx->getOption('sortby', $scriptProperties, 'user_id');
$sortdir = $modx->getOption('sortbir', $scriptProperties, 'ASC');
$limit = $modx->getOption('limit', $scriptProperties, 5);
$outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);

// Build query
$c = $modx->newQuery('idfxData');
$c->sortby($sortby, $sortdir);
$c->limit($limit);
$items = $modx->getIterator('idfxData', $c);

// Iterate through items
$list = array();
/** @var idfxData $item */
foreach ($items as $item) {
	$list[] = $modx->getChunk($tpl, $item->toArray());
}

// Output
$output = implode($outputSeparator, $list);
if (!empty($toPlaceholder)) {
	// If using a placeholder, output nothing and set output to specified placeholder
	$modx->setPlaceholder($toPlaceholder, $output);

	return '';
}
// By default just return output
return $output;
