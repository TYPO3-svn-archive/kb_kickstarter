<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['tx_kbkickstarter_tables'] = Array (
	'ctrl' => &$TCA['tx_kbkickstarter_tables']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'hidden, name, alias, no_prefix, icon_default, hasFields, typeField, typeConfig, labelFields, sortFields',
	),
	'feInterface' => &$TCA['tx_kbkickstarter_tables']['feInterface'],
	'columns' => Array (
		'hidden' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.hidden',
			'config' => Array (
				'type' => 'check',
				'default' => '0',
			),
		),
		'name' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.name',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			),
		),
		'alias' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.alias',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required,is_in',
				'is_in' => $GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['aliasChars'],
			),
		),
		'no_prefix' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.no_prefix',
			'config' => Array (
				'type' => 'check',
				'default' => '0',
			),
		),
		'icon_default' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.icon_default',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'gif,png,jpg',
				'disallowed' => 'php,php3',
				'max_size' => 1000,
				'uploadfolder' => 'uploads/tx_kbkickstarter',
				'show_thumbs' => 1,
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'hasFields' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.hasFields',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_kbkickstarter_fields',
				'foreign_table_where' => ' AND tx_kbkickstarter_fields.hidden=0 ORDER BY tx_kbkickstarter_fields.sorting',
 				'MM' => 'tx_kbkickstarter_tables_fields_mm',
				'size' => 8,
				'minitems' => 1,
				'maxitems' => 100,
				'autoSizeMax' => 20,
			),
		),
		'typeField' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.typeField',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_kbkickstarter_fields',
				'foreign_table_where' => ' AND tx_kbkickstarter_fields.hidden=0 ORDER BY tx_kbkickstarter_fields.sorting',
				'itemsProcFunc' => 'EXT:kb_kickstarter/class.tx_kbkickstarter_itemsProc.php:&tx_kbkickstarter_itemsProc->removeNonSelected',
				'itemsProcFuncParams' => Array(
					'field' => 'hasFields',
				),
				'items' => Array(
					array('LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.typeField.none', '0'),
				),
				'size' => 1,
			),
		),
		'typeConfig' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.typeConfig',
			'displayCond' => 'FIELD:typeField:REQ:true',
			'config' => Array (
				'type' => 'inline',
				'foreign_table' => 'tx_kbkickstarter_typeconfig',
				'appearance' => Array(
					'collapseAll' => 1,
					'newRecordLinkAddTitle' => 1,
					'newRecordLinkPosition' => 'bottom',
					'useSortable' => 1,
				),
				'foreign_field' => 'parentRecord',
				'size' => 1,
				'maxitems' => 50,
				'minitems' => 0,
			),
		),
		'labelFields' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.labelFields',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_kbkickstarter_fields',
				'foreign_table_where' => ' AND tx_kbkickstarter_fields.hidden=0',
				'itemsProcFunc' => 'EXT:kb_kickstarter/class.tx_kbkickstarter_itemsProc.php:&tx_kbkickstarter_itemsProc->removeNonSelected',
				'itemsProcFuncParams' => Array(
					'field' => 'hasFields',
				),
				'disableNoMatchingElement' => true,
				'MM' => 'tx_kbkickstarter_tables_labelFields_mm',
				'size' => 6,
				'minitems' => 0,
				'maxitems' => 5,
			),
		),
		'sortFields' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.sortFields',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_kbkickstarter_fields',
				'neg_foreign_table' => 'tx_kbkickstarter_fields',
				'foreign_table_where' => ' AND tx_kbkickstarter_fields.hidden=0',
				'neg_foreign_table_where' => ' AND tx_kbkickstarter_fields.hidden=0',
				'foreign_table_prefix' => 'ASC: ',
				'neg_foreign_table_prefix' => 'DESC: ',
/*
				'items' => array(
					array('LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.sortFields.crdate_asc', 'crdate_ASC'),
					array('LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.sortFields.crdate_desc', 'crdate_DESC'),
					array('LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.sortFields.tstamp_asc', 'tstamp_ASC'),
					array('LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.sortFields.tstamp_desc', 'tstamp_DESC'),
				),
*/
				'itemsProcFunc' => 'EXT:kb_kickstarter/class.tx_kbkickstarter_itemsProc.php:&tx_kbkickstarter_itemsProc->removeNonSelected',
				'itemsProcFuncParams' => Array(
					'field' => 'hasFields',
				),
				'disableNoMatchingElement' => true,
				'MM' => 'tx_kbkickstarter_tables_sortFields_mm',
				'size' => 6,
				'minitems' => 0,
				'maxitems' => 5,
			),
		),
		'standardPages' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.standardPages',
			'config' => Array (
				'type' => 'check',
			),
		),
		'enableHide' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.enableHide',
			'config' => Array (
				'type' => 'check',
			),
		),
		'enableStartStop' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.enableStartStop',
			'config' => Array (
				'type' => 'check',
			),
		),
		'enableAccessControl' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.enableAccessControl',
			'config' => Array (
				'type' => 'check',
			),
		),
		'enableLocalization' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.enableLocalization',
			'config' => Array (
				'type' => 'check',
				'default' => '1',
			),
		),
		'datetimeStartStop' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.datetimeStartStop',
			'config' => Array (
				'type' => 'check',
			),
		),
		'ownerField' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.ownerField',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_kbkickstarter_fields',
				'foreign_table_where' => ' AND tx_kbkickstarter_fields.hidden=0',
				'itemsProcFunc' => 'EXT:kb_kickstarter/class.tx_kbkickstarter_itemsProc.php:&tx_kbkickstarter_itemsProc->removeNonSelected',
				'itemsProcFuncParams' => Array(
					'field' => 'hasFields',
				),
				'items' => Array(
					Array('LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.ownerField.none', 0),
				),
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
	),
	'types' => Array (
		'0' => Array('showitem' => 'name, alias;;1, icon_default;;;;2-2-2, --div--;LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.tabFields, hasFields, labelFields, sortFields, --div--;LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.tabVisibility, standardPages, ownerField, enableHide;;;;3-3-3, enableStartStop;;2, enableAccessControl, enableLocalization, --div--;LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables.tabLayout, typeField, typeConfig'),
	),
	'palettes' => Array (
		'1' => Array('showitem' => 'hidden, no_prefix'),
		'2' => Array('showitem' => 'datetimeStartStop'),
	)
);


?>
