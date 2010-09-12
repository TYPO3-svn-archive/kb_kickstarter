<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['tx_kbkickstarter_typeconfig'] = Array (
	'ctrl' => &$TCA['tx_kbkickstarter_typeconfig']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'hidden, parentRecord, typeFieldValue, hasFields',
	),
	'feInterface' => &$TCA['tx_kbkickstarter_typeconfig']['feInterface'],
	'columns' => Array (
		'hidden' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.hidden',
			'config' => Array (
				'type' => 'check',
				'default' => '0',
			),
		),
		'parentRecord' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_typeconfig.xml:tx_kbkickstarter_typeconfig.parentRecord',
			'readOnly' => 'true',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_kbkickstarter_tables',
				'size' => 1,
				'minitems' => 1,
				'maxitems' => 1,
				'readOnly' => true,
			),
		),
		'typeFieldValue' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_typeconfig.xml:tx_kbkickstarter_typeconfig.typeFieldValue',
			'config' => Array (
				'type' => 'clone',
				'cloneTablePointer' => 'parentRecord',
				'cloneFieldPointer' => 'parentRecord|typeField',
			),
		),
		'hasFields' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_typeconfig.xml:tx_kbkickstarter_typeconfig.hasFields',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_kbkickstarter_fields',
				'foreign_table_where' => ' AND tx_kbkickstarter_fields.hidden=0 ORDER BY tx_kbkickstarter_fields.sorting',
 				'MM' => 'tx_kbkickstarter_typeconfig_fields_mm',
				'size' => 8,
				'minitems' => 0,
				'maxitems' => 100,
				'autoSizeMax' => 20,
				'itemsProcFunc' => 'EXT:kb_kickstarter/class.tx_kbkickstarter_itemsProc.php:&tx_kbkickstarter_itemsProc->removeNonSelected',
				'itemsProcFuncParams' => Array(
					'field' => 'parentRecord|hasFields|uid',
				),
			),
		),
	),
	'types' => Array (
		'0' => Array('showitem' => 'hidden, parentRecord, typeFieldValue, hasFields'),
	),
	'palettes' => Array (
	)
);


?>
