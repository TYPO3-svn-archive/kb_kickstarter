<?php
{*
// TODO: labelField
// TODO:[label_alt]=subheader,bodytext

// TODO: [versioningWS]=2
// TODO: [versioning_followPages]=1
// TODO: [origUid]=t3_origuid
// TODO: 'versioningWS_alwaysAllowLiveEdit' => TRUE

// TODO: [type]=CType

// TODO: [transOrigPointerField]=l18n_parent
// TODO: [transOrigDiffSourceField]=l18n_diffsource
// TODO: [languageField]=sys_language_uid

// TODO:[prependAtCopy]=LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy

// TODO:[dividers2tabs]=1

// TODO: [copyAfterDuplFields]=colPos,sys_language_uid
// TODO: [useColumnsForDefaultValues]=colPos,sys_language_uid
// TODO: [shadowColumnsForNewPlaceholders]=colPos
// TODO: [typeicon_column]=CType
// TODO: [typeicons]
// TODO: 'type' => 'admin',
// TODO: [mainpalette]=15
// TODO: [thumbnail]=image
// TODO: [requestUpdate]=list_type,rte_enabled
*}
if (!defined('TYPO3_MODE')) {ldelim}
	die('Access denied.');
{rdelim}

//
// {$generatedComment}
//

$TCA['{$table.full_alias}'] = Array(
	'ctrl' => Array (
		'title' => 'LLL:EXT:{$configExtension}/llxml/locallang_{$table.alias}_db.xml:{$table.alias}',
		'label' => '{$table._labelField}',
{if $table._altLabels}
		'label_alt' => '{$table._altLabels}',
		'label_alt_force' => 1,
{/if}
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
{if $table._sortFields}
		'default_sortby' => 'ORDER BY {$table._sortFields}',
{else}
		'sortby' => 'sorting',
{/if}
{if !$table.realDelete}
		'delete' => 'deleted',
{/if}
{if $table.enableHide || $table.enableStartStop || $table.enableAccessControl}
		'enablecolumns' => Array (
{if $table.enableHide}
			'disabled' => 'hidden',
{/if}
{if $table.enableStartStop}
			'starttime' => 'starttime',
			'endtime' => 'endtime',
{/if}
{if $table.enableAccessControl}
			'fe_group' => 'fe_group',
{/if}
		),
{/if}
{if $table.rootLevel}
		'rootLevel' => 1,
{/if}
{if $table.adminOnly}
		'adminOnly' => 1,
{/if}
{if $table.ownerField}
		'fe_cruser_id' => '{$table.ownerFieldRecord.full_alias}',
{/if}
		'dynamicConfigFile' => t3lib_extMgm::extPath('{$configExtension}').'{$table._TCA.relFile}',
{if $table.icon_default}
		'iconfile' => '../uploads/tx_kbkickstarter/{$table.icon_default}',
{else}
		'iconfile' => RELPATH_kb_kickstarter.'icons/icon_unknown.png',
{/if}
	),
	'feInterface' => Array (
		'fe_admin_fieldList' => '{if $table.enableHide}hidden{/if}{strip}
{foreach from=$table.fieldRows key=property_key item=property name=fe_admin_fieldList_Iter}
	{if (!$smarty.foreach.fe_admin_fieldList_Iter.first) || $table.enableHide}, {/if}
	{$property.full_alias}
{/foreach}
{/strip}',
	),
);

{if $table.standardPages}
t3lib_extMgm::allowTableOnStandardPages('{$table.full_alias}');
{/if}

?>
