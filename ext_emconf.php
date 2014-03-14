<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'KB Kickstarter',
	'description' => 'A kickstarter storing all table/field information in database',
	'category' => 'be',
	'shy' => 0,
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'alpha',
	'uploadfolder' => 0,
	'createDirs' => 'uploads/tx_kbkickstarter/',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author' => 'Kraft Bernhard',
	'author_email' => 'kraftb@kraftb.at',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-4.7.99',
			'php' => '5.1.0-',
			'smarty' => '2.0.0-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'kb_config' => '0.1.0-',
		),
	),
	'_md5_values_when_last_written' => '',
);

?>
