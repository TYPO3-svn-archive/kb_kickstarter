<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

require_once(PATH_kb_kickstarter.'class.tx_kbkickstarter_config.php');
$GLOBALS['T3_VARS']['kb_kickstarter_config'] = t3lib_div::makeInstance('tx_kbkickstarter_config');
$GLOBALS['T3_VARS']['kb_kickstarter_config']->init($_EXTKEY);

require_once(PATH_kb_kickstarter.'ext_tables/ext_tables_tables.php');
require_once(PATH_kb_kickstarter.'ext_tables/ext_tables_fields.php');

if (TYPO3_MODE=='BE') {
	t3lib_extMgm::addModule('tools','txkbkickstarterM1','',t3lib_extMgm::extPath($_EXTKEY).'mod_kickadmin/');
}

?>
