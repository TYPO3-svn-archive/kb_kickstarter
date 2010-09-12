<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
} 
define('PATH_kb_kickstarter', t3lib_extMgm::extPath($_EXTKEY));
define('RELPATH_kb_kickstarter', t3lib_extMgm::extRelPath($_EXTKEY));

$GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['aliasChars'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';

$_EXTCONF = unserialize($_EXTCONF);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['tablePrefix'] = trim($_EXTCONF['tablePrefix']);
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['fieldPrefix'] = trim($_EXTCONF['fieldPrefix']);
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['configExtension'] = trim($_EXTCONF['configExtension']);
require_once(PATH_kb_kickstarter.'ext_emconf.php');
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['version'] = $EM_CONF[$_EXTKEY]['version'];

require_once(PATH_kb_kickstarter.'class.tx_kbkickstarter_fieldTypes.php');
$fieldTyper = t3lib_div::makeInstance('tx_kbkickstarter_fieldTypes');
$fieldTyper->initFieldTypes();


$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tceforms.php']['getSingleFieldClass']['kb_kickstarter'] = 'EXT:kb_kickstarter/class.tx_kbkickstarter_fieldClone.php:tx_kbkickstarter_fieldClone';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['kb_kickstarter'] = 'EXT:kb_kickstarter/class.tx_kbkickstarter_fieldClone.php:tx_kbkickstarter_fieldClone';

?>
