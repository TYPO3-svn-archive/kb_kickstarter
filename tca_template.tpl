<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['{$table.full_alias}'] = Array(
	'ctrl' => &$TCA['{$table.full_alias}']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => '{$tmp}',
	),
	'feInterface' => &$TCA['{$table.full_alias}']['feInterface'],
	'columns' => Array (
{foreach from=$table.fieldRows key=property_key item=property}
	{include file=""}
{/foreach}
	),	
	'types' => Array (
		'0' => Array('showitem' => 'name, alias;;1, icon_default;;;;2-2-2, fields'),
	),
	'palettes' => Array (
		'1' => Array('showitem' => 'hidden, no_prefix'),
	)
);

?>
