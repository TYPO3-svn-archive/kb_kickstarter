<?php
if (!defined('TYPO3_MODE')) {ldelim}
	die('Access denied.');
{rdelim}

//
// {$generatedComment}
// 

$basePath = $GLOBALS['T3_VARS']['kb_kickstarter_config']->get_configExtensionPath();

{foreach from=$tables key=tableIdx item=tableRow}
if (file_exists($basePath.'{$tableRow._extTables.relFile}')) require($basePath.'{$tableRow._extTables.relFile}');
{/foreach}

?>
