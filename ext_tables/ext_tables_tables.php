<?php
if (!defined ('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['tx_kbkickstarter_tables'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:kb_kickstarter/llxml/locallang_db_tables.xml:tx_kbkickstarter_tables',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'dividers2tabs' => 1,
		'enablecolumns' => Array (
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => PATH_kb_kickstarter.'tca/tca_tables.php',
		'iconfile' => RELPATH_kb_kickstarter.'icons/icon_tables.png',
	),
	'feInterface' => Array (
		'fe_admin_fieldList' => 'hidden, name, alias, no_prefix, element_icon, hasFields, enableHide, enableStartStop, datetimeStartStop, enableAccessControl, ownerField, sortFields, typeField, typeConfig, standardPages',
	)
);

?>
