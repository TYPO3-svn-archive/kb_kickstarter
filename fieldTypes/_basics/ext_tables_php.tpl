<?php
if (!defined('TYPO3_MODE')) {ldelim}
	die('Access denied.');
{rdelim}

//
// {$generatedComment}
// 

if (!is_object($GLOBALS['T3_VARS']['kb_kickstarter_config'])) {ldelim}
	require_once(PATH_kb_kickstarter.'class.tx_kbkickstarter_config.php');
	$GLOBALS['T3_VARS']['kb_kickstarter_config'] = t3lib_div::makeInstance('tx_kbkickstarter_config');
	$GLOBALS['T3_VARS']['kb_kickstarter_config']->init('kb_kickstarter');
{rdelim}
$basePath = $GLOBALS['T3_VARS']['kb_kickstarter_config']->get_configExtensionPath();

{foreach from=$tables key=tableIdx item=tableRow}
if (file_exists($basePath.'{$tableRow._extTables.relFile}')) require($basePath.'{$tableRow._extTables.relFile}');
{/foreach}

?>
