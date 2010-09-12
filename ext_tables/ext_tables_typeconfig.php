<?php
if (!defined ('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['tx_kbkickstarter_typeconfig'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_typeconfig.xml:tx_kbkickstarter_typeconfig',
		'label' => 'parentRecord',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'dividers2tabs' => 0,
		'enablecolumns' => Array (
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => PATH_kb_kickstarter.'tca/tca_typeconfig.php',
		'iconfile' => RELPATH_kb_kickstarter.'icons/icon_typeconfig.png',
	),
	'feInterface' => Array (
		'fe_admin_fieldList' => 'hidden, parentRecord, typeFieldValue, hasFields',
	)
);

?>
