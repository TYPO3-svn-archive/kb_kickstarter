<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['tx_kbkickstarter_fields'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_fields.xml:tx_kbkickstarter_fields',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'enablecolumns' => Array (
			'disabled' => 'hidden',
		),
		'requestUpdate' => 'type',
		'dynamicConfigFile' => PATH_kb_kickstarter.'tca/tca_fields.php',
		'iconfile' => RELPATH_kb_kickstarter.'icons/icon_fields.png',
	),
	'feInterface' => Array (
		'fe_admin_fieldList' => 'hidden, name, alias, type, flexconfig',
	)
);

?>
