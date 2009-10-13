<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2008 Bernhard Kraft (kraftb@kraftb.at)
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
 * Class '_tables' for the 'kb_kickstarter' extension.
 * This class is responsible for reading the table and field settings
 *
 * @author	Bernhard Kraft <kraftb@kraftb.at>
 */


// TODO: Add "hasHidden" flag to a table-definition record
// TODO: Add palettes generating to gentca and _basics/tca_template.tpl


class tx_kbkickstarter_tables {
	protected $parentObj = null;
	protected $rootObj = null;

	protected $tables = Array();
	protected $hiddenTables = Array();

	protected $miscObj = null;
	protected $configObj = null;
	protected $extension = '';




	/*************************
	 *
	 * Initialization methods
	 *
	 * The following method(s) are required for setting up this class
	 *
	 *************************/

	/**
	 * Load tables and their fields from database
	 *
	 * @return	array		An array containing all table information
	 */
	public function init(&$parentObj, &$rootObj) {
		$this->parentObj = &$parentObj;
		$this->rootObj = &$rootObj;
		$this->configObj = &$GLOBALS['T3_VARS']['kb_kickstarter_config'];
		$this->extension = $this->configObj->get_extension();
		$this->miscObj = tx_kbkickstarter_misc::singleton();
	}




	/*************************
	 *
	 * Table / Fields loading
	 *
	 * The following methods are responsible for loading the table and field definitions from database
	 * and bringing them to a sane state
	 *
	 *************************/

	/**
	 * Load tables and their fields from database
	 *
	 * @return	array		An array containing all table information
	 */
	public function loadTables()	{
		$tables_table = $this->configObj->getTable_TABLES();
		$fields_table = $this->configObj->getTable_FIELDS();
		$mm_table_fields = $this->configObj->getTable_FIELDS_IN_TABLES();
		$mm_table_labels = $this->configObj->getTable_LABELS_OF_TABLES();
		$mm_table_sorting = $this->configObj->getTable_SORTING_OF_TABLES();
		$tables_whereClause = t3lib_BEfunc::deleteClause($tables_table);
		$tableRows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', $tables_table, '1=1 '.$tables_whereClause, '', 'uid', '', 'uid');
		foreach ($tableRows as $tableIdx => $tableRow)	{
			$tableRows[$tableIdx]['fieldRows'] = $this->loadFields($mm_table_fields, intval($tableRow['uid']));
			$tableRows[$tableIdx]['labelFields'] = $this->loadFields($mm_table_labels, intval($tableRow['uid']));
			$tableRows[$tableIdx]['sortFields'] = $this->loadFields($mm_table_sorting, intval($tableRow['uid']));
			if ($tableRow['ownerField']) {
				$tableRows[$tableIdx]['ownerFieldRecord'] = t3lib_BEfunc::getRecord($fields_table, $tableRow['ownerField']);
			}
			$tableRows[$tableIdx] = $this->table_saneConfig($tableRows[$tableIdx]);
			if ($tableRows[$tableIdx]['hidden']) {
				$hiddenRows[$tableIdx] = &$tableRows[$tableIdx];
			}
		}
		$this->hiddenTables = $hiddenRows;
		$this->tables = $tableRows;
	}


	/**
	 * Load fields from database
	 *
	 * @param		string			The MM table containing the relation information between the tables-table and fields-table
	 * @param		integer			The uid of the table for which to load fields
	 * @return	array		An array containing all field definitions
	 */
	private function loadFields($mm_table, $uid) {
		$validRows = array();
		$tables_table = $this->configObj->getTable_TABLES();
		$fields_table = $this->configObj->getTable_FIELDS();
		$fields_whereClause = t3lib_BEfunc::deleteClause($fields_table);
		$mm_rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', $mm_table, 'uid_local='.$uid);
		$foreign_uids = array();
		foreach ($mm_rows as $mm_row) {
			$foreign_uids[] = abs($mm_row['uid_foreign']);
		}
		$foreign_str = implode(',', $foreign_uids);
		if ($foreign_str) {
			$tmp_fieldRows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', $fields_table, 'uid IN ('.$foreign_str.')'.$fields_whereClause, '', '', '', 'uid');
			$fieldRows = array();
			foreach ($mm_rows as $mm_row) {
				$abs_uid = abs($mm_row['uid_foreign']);
				$tmp_row = $tmp_fieldRows[$abs_uid];
				if ($mm_row['uid_foreign'] < 0) {
					$tmp_row['__negate'] = true;
				}
				$fieldRows[] = $tmp_row;
			}
			foreach ($fieldRows as $fieldIdx => $fieldRow) {
				list($type, $subtype) = explode('|', $fieldRow['type']);
				if ($type==='none') {
					continue;
				}
/*
				if ($type=='container') {
					die('Type "Container" not handled yet !');
				}
*/
				$validRows[] = $fieldRow;
			}
		}
		return $validRows;
	}

	/**
	 * Sanitizes the table configuration
	 *
	 * @param	array		The database definition record going to be sanitized
	 * @return	array		The passed array in a sane form
	 */
	private function llxml_label($text) {
		return htmlspecialchars($GLOBALS['LANG']->csConvObj->utf8_encode($text, $GLOBALS['LANG']->charSet), ENT_NOQUOTES, 'UTF-8');
	}

	/**
	 * Sanitizes a table definition record
	 *
	 * @param	array		The database definition record going to be sanitized
	 * @return	array		The passed array in a sane form
	 */
	private function table_saneConfig($table) {
		$noFieldPrefix = false;
		$table = $this->saneAlias($table, $table);
		$table['LLL_name'] = $this->llxml_label($table['name']);
		$visibleRows = Array();
		$hiddenRows = Array();
		$tables_table = $this->configObj->getTable_TABLES();
		$fields_table = $this->configObj->getTable_FIELDS();


		// Question: Inherit table "no_prefix" flag for fields?
		// Explain: It is not clear wheter fields of an table shall have a prefix or not, depending on the table "no_prefix"
		// flag. If you "redefine" fe_users for example, you have to set the "no_prefix" flag for the fe_users table defined
		// by kb_kickstarter. In this case you would not want to have any of the contained fields an prefix. But it is probably
		// desired not to have to set the "no_prefix" flag for every field assigned to this table - so in this case it would make
		// sense to "inherit" the no_prefix flag of tables to their fields.
		// Another case could be you are extending a table. So the table get's the "no_prefix" flag, but the fields shoul have
		// a prefix, so the can get distinguished from the tables original fields.
		// TODO: Most probably there should be an "fields_no_prefix" or "inherit_no_prefix" flag in the table-definition record.
		// TODO: It would also make sense to have an "clear definition before" flag, so when redifining an table the old definition
		// gets unset.
/*
		if ($table['no_prefix']) {
			$noFieldPrefix = true;
		}
*/
		$table = $this->table_saneConfig_fields($table, 'fieldRows', $noFieldPrefix);
		$table = $this->table_saneConfig_fields($table, 'labelFields', $noFieldPrefix);
		$table = $this->table_saneConfig_fields($table, 'sortFields', $noFieldPrefix);
		if ($table['ownerField']) {
			$table['ownerFieldRecord'] = $this->table_saneConfig_field($table['ownerFieldRecord'], $table, $noFieldPrefix);
		}

		// TODO: Handle "altLabels" -- multiple fields as label
		$labelFieldKeys = array_keys($table['labelFields']);
		$primaryLabelKey = $labelFieldKeys[0];
		$primaryLabel = $table['labelFields'][$primaryLabelKey];
		$table['_labelField'] = $primaryLabel['full_alias'];
		$table['_altLabels'] = false;
		if (is_array($table['labelFields']) && (count($table['labelFields'])>1)) {
			$altLabels = array();
			foreach ($table['labelFields'] as $labelFieldKey => $labelFieldConf) {
				if ($labelFieldKey) {
					$altLabels[] = $labelFieldConf['full_alias'];
				}
			}
			$table['_altLabels'] = implode(',', $altLabels);
		}

		$sortFields = array();
		if (is_array($table['sortFields'])) {
			foreach ($table['sortFields'] AS $sortField) {
				$tmpSort = $sortField['full_alias'];
				$tmpSort .= $sortField['__negate']?' DESC':' ASC';
				$sortFields[] = $tmpSort;
			}
		}
		if (count($sortFields)) {
			$table['_sortFields'] = implode(', ', $sortFields);
		}

		$configKeys = $this->configObj->get_configFilesInfo();
		foreach ($configKeys as $configKey) {
			$key = '_'.$configKey;
			$table[$key]['relFile'] = $this->table_currentFile($table, $configKey, true, true);
			$table[$key]['absFile'] = $this->table_currentFile($table, $configKey, true);
		}

		return $table;
	}

	/**
	 * Sanitizes a field-definition record array of a table definition record
	 *
	 * @param		array			The table definition record containing the field-definitions
	 * @param		string		The array key of the above table-definition record which contains the fields to get sanitized
	 * @return	array			The passed array in a sane form
	 */
	private function table_saneConfig_fields($table, $fieldArrayKey, $noFieldPrefix = false) {
		$hiddenRows = array();
		$visibleRows = array();
		foreach ($table[$fieldArrayKey] as $fieldIdx => $fieldRow) {
			$fieldRow = $this->table_saneConfig_field($fieldRow, $table, $noFieldPrefix);
			if ($fieldRow['hidden']) {
				$hiddenRows[] = $fieldRow;
			} else {
				$visibleRows[] = $fieldRow;
			}
		}
		$table[$fieldArrayKey] = $visibleRows;
		$table['disabled_'.$fieldArrayKey] = $hiddenRows;
		return $table;
	}

	/**
	 * Sanitizes a single field-definition record of a table definition record
	 *
	 * @param	array		The field definition record
	 * @param	string		The table definition record which contains this field
	 * @param	boolean		If this is set, the field shall have no prefix
	 * @return	array		The passed field definition record in a sane form
	 */
	private function table_saneConfig_field($fieldRow, $table, $noFieldPrefix) {
		$fieldRow = $this->saneAlias($fieldRow, $table, $fieldRow, $noFieldPrefix);
		$fieldRow['LLL_name'] = $this->llxml_label($fieldRow['name']);
		$fieldRow = $this->field_loadFlexData($fieldRow);
		return $fieldRow;
	}

	/**
	 * Converts the content of the field flexform to an array - cached !
	 *
	 * @param		array			The field record for which the flex data values shall get loaded
	 * @return	array			The passed field record, with the variable "config" set to the loaded values
	 */
	function field_loadFlexData($fieldRow) {
		$fieldRow['config'] = array();
		$xml = $fieldRow['flexconfig'];
		if ($xml) {
			$md5 = md5($xml);
			// TODO: Caching !!!
			if ($fieldRow['flex_md5']==$md5) {
				$fieldRow['flex'] = unserialize($fieldRow['flex_serialized']);
			} else {
				$data = t3lib_div::xml2array($xml);
				if (is_array($data)) {
					$fieldRow['config'] = $this->field_getFlexValues($data);
				}
			}
		}
		return $fieldRow;
	}

	/**
	 * Converts an flexform-array into a flat array
	 *
	 * @param		array			An array like returned from t3lib_div::xml2array
	 * @return	array			The values of the above array, in a simple way. Just one level deep array with associative indexes
	 */
	function field_getFlexValues($data) {
		$values = array();
		if (is_array($data['data'])) {
			foreach ($data['data'] as $sheetName => $sheet) {
				if (is_array($sheet['lDEF'])) {
					foreach ($sheet['lDEF'] as $propName => $prop) {
						if (is_array($prop) && is_array($prop['el'])) {
							$values[$propName] = $this->field_getFlexValues_section($prop['el']);
						} else {
							$values[$propName] = $prop['vDEF'];
						}
					}
				}
			}
		}
		return $values;
	}

	/**
	 * Converts an flexform-array into a flat array
	 *
	 * @param		array			An array like returned from t3lib_div::xml2array
	 * @return	array			The values of the above array, in a simple way. Just one level deep array with associative indexes
	 */
	function field_getFlexValues_section($data) {
		$sectionValues = array();
		$cnt = 0;
		foreach ($data as $idx => $sectionElement) {
			$inc = 0;
			foreach ($sectionElement as $sectionItem) {
				if (is_array($sectionItem) && is_array($sectionItem['el'])) {
					$inc = 1;
					foreach ($sectionItem['el'] as $field => $value) {
						$sectionValues[$cnt][$field] = $value['vDEF'];
					}
				}
			}
			$cnt += $inc;
		}
		return $sectionValues;
	}

	/**
	 * Returns the passed string as valid alias
	 *
	 * @param	string		The value which shall get validated
	 * @return	string		The passed value, filtered for characters allowed for aliases
	 */
	private function validAlias($alias) {
		return preg_replace('/[^'.$GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['aliasChars'].']/', '', $alias);
	}


	/**
	 * Sanitizes the alias and sets the full alias containing the prefix
	 *
	 * @param		string		The value which shall get validated
	 * @return	string		The passed value, filtered for characters allowed for aliases
	 */
	private function saneAlias($row, $table, $field = false, $noPrefix = false) {
		$row['alias'] = $this->validAlias($row['alias']);
		if ($row['no_prefix'] || $noPrefix) {
			$row['full_alias'] = $row['alias'];
		} else {
			$row['full_alias'] = $this->configObj->config__prefix($table, $field).$row['alias'];
		}
		return $row;
	}




	/*************************
	 *
	 * Supporting methods
	 *
	 * Methods mostly called from other classes/instances
	 *
	 *************************/

	/**
	 * Returns a timestamp of the latest modification of any of the defined tables or fields
	 *
	 * @return	integer			Timestamp of last modification
	 */
	public function getLastMod() {
		$tstamp = 0;
		foreach ($this->tables as $tableIdx => $tableRow)	{
			if ($tableRow['tstamp']>$tstamp) {
				$tstamp = $tableRow['tstamp'];
			}
			foreach ($tableRow['fieldRows'] as $fieldRow) {
				if ($fieldRow['tstamp']>$tstamp) {
					$tstamp = $fieldRow['tstamp'];
				}
			}
		}
		return $tstamp;
	}

	/**
	 * Get location of one of the current config files for passed table
	 *
	 * @param		array				A table definition record
	 * @param		string			A string defining which of the configuration files you wish to retrieve the name of
	 * @param		boolean			Do not check if the file exists
	 * @param		boolean			Return relative path
	 * @return	string			Location of requested config file for passed table or empty string if file doesn't exist when check is enabled
	 */
	private function table_currentFile($table, $key, $doNotCheck = false, $relative = false) {
		$params = $this->configObj->get_configFilesInfo($key);
		$file = $params['filename'];
		if (!$file) {
			return '';
		}
		$file = str_replace('###ALIAS###', $table['alias'], $file);
		if ($relative) {
			return $file;
		}
		$configExt = $this->configObj->get_configExtension();
		$currentFile = t3lib_div::getFileAbsFileName('EXT:'.$configExt.'/'.$file);
		if (file_exists($currentFile) || $doNotCheck) {
			return $currentFile;
		}
		return '';
	}

	/**
	 * Assign variables for generating configuration files or BE module to passed smarty object
	 *
	 * @param	object		An instance of the T3 smarty class
	 * @return	void
	 */
	public function smarty_assignVars(&$smarty) {
		$smarty->assign('tables', $this->tables);
		$smarty->assign('hiddenTables', $this->hiddenTables);
	}


	/**
	 * Iterate over all table definition records and pass table parameters to call object/method
	 *
	 * @param		object		An object instace of which to call a method
	 * @param		string		The method of object instance from parameter #1 to call
	 * @param		array			Parameters to pass to the called method
	 * @return	void
	 */
	public function tables_iterate($callObj, $callMethod, $params, $force = false) {
		$ok = 0;
		foreach ($this->tables as $tableIdx => $tableRow) {
			$ok += $this->table_action($tableIdx, $callObj, $callMethod, $params, $force);
		}
		return $ok;
	}

	/**
	 * Call object/method passed as arguments and pass specified table-definition record
	 *
	 * @param		integer		The key/index of the table to perform an action on
	 * @param		object		An object instace of which to call a method
	 * @param		string		The method of object instance from parameter #1 to call
	 * @param		array			Parameters to pass to the called method
	 * @return	void
	 */
	public function table_action($tableIdx, $callObj, $callMethod, $params, $force = false) {
		$tableRow = &$this->tables[$tableIdx];
		$currentPart = &$tableRow['_'.$params['key']];
		if (isset($currentPart['new']['md5']) && isset($currentPart['current']['md5']) && ($currentPart['new']['md5']==$currentPart['current']['md5']) && !$force) {
			return 0;
		}
		list($result, $success) = $callObj->$callMethod($tableRow, $params);
		$this->tables[$tableIdx] = $result;
		return $success;
	}

}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickadmin/class.tx_kbkickstarter_tables.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickadmin/class.tx_kbkickstarter_tables.php']);
}

?>
