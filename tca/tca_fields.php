<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['tx_kbkickstarter_fields'] = Array (
	'ctrl' => &$TCA['tx_kbkickstarter_fields']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'hidden, name',
	),
	'feInterface' => &$TCA['tx_kbkickstarter_fields']['feInterface'],
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
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_fields.xml:tx_kbkickstarter_fields.name',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			),
		),
		'alias' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_fields.xml:tx_kbkickstarter_fields.alias',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required,is_in',
				'is_in' => $GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['aliasChars'],
			),
		),
		'exclude_field' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_fields.xml:tx_kbkickstarter_fields.exclude_field',
			'config' => Array (
				'type' => 'check',
				'default' => '1',
			),
		),
		'type' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_fields.xml:tx_kbkickstarter_fields.type',
			'config' => Array	(
				'type' => 'select',
				'size' => '1',
				'items' => &$GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['fieldTypes']['selectConfig'],
			),
		),
		'flexconfig' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_fields.xml:tx_kbkickstarter_fields.flexconfig',
			'config' => Array	(
				'type' => 'flex',
				'ds_pointerField' => 'type',
				'ds' => &$GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['fieldTypes']['flexDSfiles'],
			),
		),
	),
	'types' => Array (
		'0' => Array('showitem' => 'name, alias;;1, type;;;;1-1-1, flexconfig;;;;2-2-2'),
	),
	'palettes' => Array (
		'1' => Array('showitem' => 'hidden'),
	)
);


?>
