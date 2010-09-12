<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2008-2010 Bernhard Kraft (kraftb@think-open.at)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
* 
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
* 
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/** 
 * Config class for kb_kickstarter module
 *
 * @author	Bernhard Kraft <kraftb@think-open.at>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 */


class tx_kbkickstarter_config {
	const configFileVersion = '0.0.1';

		// Tables containing the field and table definitions
	private $table_TABLES = 'tx_kbkickstarter_tables';
	private $table_FIELDS = 'tx_kbkickstarter_fields';
	private $table_TYPECONFIG = 'tx_kbkickstarter_typeconfig';
	private $table_FIELDS_IN_TABLES = 'tx_kbkickstarter_tables_fields_mm';
	private $table_LABELS_OF_TABLES = 'tx_kbkickstarter_tables_labelFields_mm';
	private $table_SORTING_OF_TABLES = 'tx_kbkickstarter_tables_sortFields_mm';
	private $table_FIELDS_IN_TYPECONFIG = 'tx_kbkickstarter_typeconfig_fields_mm';

		// Some fields defining relations between tables
	private $field_TYPECONFIG_PARENT = 'parentRecord';

	// The name of this extension
	private $extension;

	// The extension containing the TYPO3 TCA and ext_tables, etc. configuration
	private $configExtension;
	private $configExtensionPath;
	private $configExtensionError;
	private $configExtensionMark = 'kb_kickstarter_config.txt';

	// The global table and field prefix
	// TODO: Let each table-definition have two fields "overrideTablePrefix" and "overrideFieldPrefix" allowing to
	// set different table and field prefix. Probably each field-definition should also have an field "overrideFieldPrefix"
	// to override the global fieldPrefix. It is questionable how this interacts with the "noPrefix" flag, and wheter
	// it makes sense to have an "overrideFieldPrefix" flag for a field-definition when you could also use the "noPrefix"
	// flag and prepend the wanted prefix to the alias field directly.
//	private $tablePrefix;
//	private $fieldPrefix;

	// The configuration values from the EM configuration
	private $EMextConfig = array();
	private $generatedComment = 'This file was created by the "###EXTKEY###" extension (Version ###EXT_VERSION### / ###CONFIG_VERSION###)';

	private $configFiles = Array(
		'TCA' => Array(
			'key' => 'TCA',
			'template' => '_basics/dyn_tca_php.tpl',
			'filename' => 'dyn/tca_###ALIAS###.php',
		),
		'extTables' => Array(
			'key' => 'extTables',
			'template' => '_basics/dyn_ext_tables_php.tpl',
			'filename' => 'dyn/ext_tables_###ALIAS###.php',
		),
		'LLL' => Array(
			'key' => 'LLL',
			'template' => '_basics/llxml_locallang_xml.tpl',
			'filename' => 'llxml/locallang_###ALIAS###_db.xml',
		),
		'extTablesMain' => Array(
			'key' => 'extTablesMain',
			'template' => '_basics/ext_tables_php.tpl',
			'filename' => 'ext_tables.php',
		),
		'SQL' => Array(
			'key' => 'SQL',
			'template' => '_basics/ext_tables_sql.tpl',
			'filename' => 'ext_tables.sql',
		),
	);


	/**
	 * The initialization method
	 *
	 * @param	string		The name of this extension
	 * @return	void
	 */
	public function init($extkey) {
		$this->extension = $extkey;
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$this->extension])) {
			$this->EMextConfig = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$this->extension];
		}
		list($extMajor, $extMinor) = t3lib_div::intExplode('.', $GLOBALS['EM_CONF'][$this->extension]['version'], 1);
		$extVersion = $extMajor.'.'.$extMinor;
		$configExt = $this->EMextConfig['configExtension'];
		$this->generatedComment = str_replace('###EXTKEY###', $this->extension, $this->generatedComment);
		$this->generatedComment = str_replace('###EXT_VERSION###', $extVersion, $this->generatedComment);
		$this->generatedComment = str_replace('###CONFIG_VERSION###', self::configFileVersion, $this->generatedComment);
		if ($configExt) {
			if (t3lib_extMgm::isLoaded($configExt)) {
				$mark = $this->get_configExtensionMark();
				if (file_exists(t3lib_extMgm::extPath($configExt).$mark)) {
					$this->configExtension = $configExt;
				} else {
					$this->configExtensionError = 'Config extension is not a valid kb_kickstarter config extension ! "'.$mark.'" is missing!';
				}
			} else {
				$this->configExtensionError = 'Config extension set but not available or installed!';
			}
		} else {
			$this->configExtensionError = 'No Config extension set !';
		}
	}


	/**
	 * Returns the name of the configuration extension
	 *
	 * @return	string		The name of the configuration extension
	 */
	public function get_configExtension() {
		global $BE_USER;
		if (!$this->configExtension) {
			if ($BE_USER) {
				$BE_USER->simplelog($this->configExtensionError?$this->configExtensionError:'No config extension available! No error message set!', $this->extension, 1);
			}
			die('No config extension available! This means you have selected an config extension which is not valid, available or installed! (See system log for more information)');
		}
		return $this->configExtension;
	}


	/**
	 * Returns the name of the file which marks an extension as kb_kickstarter configuration container
	 *
	 * @return	string		The name of the file which marks an extension as kb_kickstarter configuration container
	 */
	public function get_configExtensionMark() {
		return $this->configExtensionMark;
	}


	/**
	 * Returns the comment inserted into the generated initialization files (ext_tables.php, ext_tables.sql)
	 *
	 * @return	string		The string/comment which gets inserted into initialization files
	 */
	public function get_generatedComment() {
		return $this->generatedComment;
	}


	/**
	 * Returns the (cached) path to the configuration extension.
	 *
	 * @return	string		The path to the configuration extension
	 */
	public function get_configExtensionPath() {
		if (!$this->configExtensionPath) {
			$this->configExtensionPath = t3lib_extMgm::extPath($this->get_configExtension());
		}
		return $this->configExtensionPath;
	}


	/**
	 * Returns the name of "this" extension
	 *
	 * @return	string		The name of this extension
	 */
	public function get_extension() {
		return $this->extension;
	}


	/**
	 * Returns the name of the table used for storing table definitions
	 *
	 * @return	string		The table used for storing table definitions
	 */
	public function getTable_TABLES() {
		return $this->table_TABLES;
	}


	/**
	 * Returns the name of the table used for storing field definitions
	 *
	 * @return	string		The table used for storing field definitions
	 */
	public function getTable_FIELDS() {
		return $this->table_FIELDS;
	}


	/**
	 * Returns the name of the type-config table
	 *
	 * @return	string		The table used for storing type configurations of tables
	 */
	public function getTable_TYPECONFIG() {
		return $this->table_TYPECONFIG;
	}


	/**
	 * Returns the name of the table which stores information about which fields are used in which table (MM table)
	 *
	 * @return	string		The table used for storing field/table relations
	 */
	public function getTable_FIELDS_IN_TABLES() {
		return $this->table_FIELDS_IN_TABLES;
	}


	/**
	 * Returns the name of the table which stores information about which tables use which fields as label (MM table)
	 *
	 * @return	string		The table used for storing field/table relations
	 */
	public function getTable_LABELS_OF_TABLES() {
		return $this->table_LABELS_OF_TABLES;
	}

	/**
	 * Returns the name of the table used for storing field definitions of type-config records
	 *
	 * @return	string		The table used for storing field/table relations
	 */
	public function getTable_FIELDS_IN_TYPECONFIG() {
		return $this->table_FIELDS_IN_TYPECONFIG;
	}

	/**
	 * Returns the name of the table which 
	 *
	 * @return	string		The table used for storing field/table relations
	 */
	public function getTable_SORTING_OF_TABLES() {
		return $this->table_SORTING_OF_TABLES;
	}

	/**
	 * Returns the field name of the parent record pointer in the typeconfig table
	 *
	 * @return	string		The table used for storing field/table relations
	 */
	public function getField_TYPECONFIG_PARENT() {
		return $this->field_TYPECONFIG_PARENT;
	}

	/**
	 * Returns the indexes or information of config file used for an extension
	 *
	 * @param	string		A configuration information key
	 * @return	array		Either a list of all config information keys, when no parameter is supplied. Or the requested config information key
	 */
	public function get_configFilesInfo($configKey = '') {
		if ($configKey) {
			return $this->configFiles[$configKey];
		} else {
			return array_keys($this->configFiles);
		}
	}


	/**
	 * Returns a parameter of the extensions EM configuration
	 *
	 * @param	string		The method name of the wrapper method requesting a parameter
	 * @return	string		The requested configuration parameter
	 */
	private function config__get($func) {
		list($prefix, $key) = explode('__', $func);
		return $this->EMextConfig[$key]?$this->EMextConfig[$key]:'';
	}


	/**
	 * Returns the configuration parameter "tablePrefix" of the extensions EM configuration
	 *
	 * @param	array		The table database definition for which to retrieve the tablePrefix
	 * @return	string		The table prefix for the requested table
	 */
	public function config__tablePrefix($table) {
		return $this->config__get(__METHOD__);
	}


	/**
	 * Returns the configuration parameter "fieldPrefix" of the extensions EM configuration
	 *
	 * @param	array		The table database definition for which to retrieve the fieldPrefix
	 * @param	array		The field database definition for which to retrieve the fieldPrefix
	 * @return	string		The field prefix for the requested table and field
	 */
	public function config__fieldPrefix($table, $field) {
		return $this->config__get(__METHOD__);
	}

	/**
	 * Returns the configuration parameter "____Prefix" depending on wheter a table or field prefix was requested
	 *
	 * @param	array		The table database definition for which to retrieve the tablePrefix or field Prefix
	 * @param	array		The field database definition for which to retrieve the fieldPrefix
	 * @return	string		The requested prefix for the requested table
	 */
	public function config__prefix($table, $field = false) {
		if ($field) {
			return $this->config__fieldPrefix($table, $field);
		} else {
			return $this->config__tablePrefix($table);
		}
	}

}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_config.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_config.php']);
}

?>
