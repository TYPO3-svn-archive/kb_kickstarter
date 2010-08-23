<?php
if (!defined('TYPO3_MODE')) {ldelim}
	die('Access denied.');
{rdelim}

//
// {$generatedComment}
//

$TCA['{$table.full_alias}'] = Array(
	'ctrl' => &$TCA['{$table.full_alias}']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => '{$tmp}',
	),
	'feInterface' => &$TCA['{$table.full_alias}']['feInterface'],
	'columns' => Array (
{if $table.enableHide}
{include file="_basics/dyn_tca_php/prop_hidden.tpl"}
{/if}
{if $table.enableStartStop}
{include file="_basics/dyn_tca_php/prop_startstop.tpl"}
{/if}
{if $table.enableLocalization}
{include file="_basics/dyn_tca_php/prop_localization.tpl"}
{/if}
{if $table.enableAccessControl}
{include file="_basics/dyn_tca_php/prop_fe_group.tpl"}
{/if}
{foreach from=$table.fieldRows key=property_key item=property}
{include file="`$property.type`/tca_template.tpl"}
{/foreach}
	),	
	'types' => Array (
{include file="_basics/dyn_tca_php/typesList.tpl"}
	),
	'palettes' => Array (
	)
);

?>
