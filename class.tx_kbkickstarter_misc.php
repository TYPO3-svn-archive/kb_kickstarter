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
 * "Misc" class with miscellaneous methods required throughout the extension
 *
 * @author	Bernhard Kraft <kraftb@think-open.at>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 */

define('PATH_kb_kickstarter', '');
require_once(PATH_kb_kickstarter.'class.tx_kbkickstarter_singleton.php');


class tx_kbkickstarter_misc extends tx_kbkickstarter_singleton {
	protected $enableFields_cache = array();
	protected $commonTableFields = array('uid', 'pid', 'deleted', 'hidden', 'tstamp', 'crdate', 'cruser_id');
	
	/**
	 * Calls parent "singleton" method, which returns a reference to the singleton object
	 * Required cause there is no late static binding before PHP 5.3.x
	 *
	 * @return	object			A reference to the singleton object instance of this class
	 */
	public static function singleton() {
		return parent::singleton(__CLASS__);
	}


	/**
	 * Create a link to the current module and add supplied parameters
	 *
	 * @param	array		The parameters to add to the generated link
	 * @return	string		The created link
	 */
	function getLink($params) {
		$base = t3lib_div::getIndpEnv('SCRIPT_NAME');
		$paramStr = t3lib_div::implodeArrayForUrl('', $params);
		$paramStr = preg_replace('/^&/','?', $paramStr);
		return $base.$paramStr;
	}


	/**
	 * Simply returns an empty string
	 *
	 * @return	string		An empty string
	 */
	public static function emptyString() {
		return '';
	}

	/*
	 * This method gets passed the an array with field names and a table name and record and retrieves
	 * the value in the passed record from the field pointed to by the first argument of the field name array.
	 * 
	 * When the field name array contains additional values it will get checked wheter the field pointed to currently
	 * is some kind of database relation field (select/group) and if this is the case the referenced record will get
	 * retrieved and the method will call itself again recursive (via the "resolveReferenceChain_relation" method), with
	 * the parameters of the retrieved relation.
	 *
	 * So you can use this method to retrieve a foreign table record, and a foreign table record referenced by the primary record
	 * and a foreign table record referenced by the secondary record ... and so on.
	 *
	 * So it allows you to follow a reference chain.
	 *
	 * @param array The reference chain to follow
	 * @param string The name of the currently processed table
	 * @param array The record in which to look up the field designated by the first entry in the reference chain
	 * @return mixed The value which has been found at the end of the reference chain or NULL on error.
	 */
	public function resolveReferenceChain($resolveFields, $currentTable, $currentRecord) {
		if (count($resolveFields)) {
			t3lib_div::loadTCA($currentTable);
			$field = array_shift($resolveFields);
			if ($fieldConf = $GLOBALS['TCA'][$currentTable]['columns'][$field]) {
				$currentValue = $currentRecord[$field];
				if (!count($resolveFields)) {
					$result = array(
						$field => array($currentValue),
					);
				} else {
					$value = $this->resolveReferenceChain_relation($resolveFields, $field, $fieldConf, $currentRecord, $currentValue);
					$result = array(
						$field => $value,
					);
				}
				return $result;
			} elseif (in_array($field, $this->commonTableFields) && isset($currentRecord[$field]) && !count($resolveFields)) {
				$currentValue = $currentRecord[$field];
				$result = array(
					$field => array($currentValue),
				);
				return $result;
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}

	/*
	 * This method is called by the "resolveReferenceChain" it checks wheter the passed field configuration
	 * is a valid db-relation type. If this is the case it calls the "resolveReferenceChain" with appropriate
	 * parameters
	 *
	 * @param array The reference chain to follow
	 * @param string The current field
	 * @param array The configuration for the current field / value
	 * @param array The record being currently processed
	 * @param mixed The value of the field being currently processed
	 * @return mixed The value(s) retrieved from the end of the reference chain
	 */
	protected function resolveReferenceChain_relation($resolveFields, $field, $fieldConf, $currentRecord, $currentValue) {
		switch($fieldConf['config']['type']) {
			case 'select':
				if ($fieldConf['config']['foreign_table']) {
					$targetTable = $fieldConf['config']['foreign_table'];
				}
				if ($fieldConf['config']['MM']) {
					$MM_table = $fieldConf['config']['MM'];
				}
			break;
			case 'group':
				if ($fieldConf['config']['internal_type'] === 'db') {
					$targetTable = $fieldConf['config']['allowed'];
				}
				if ($fieldConf['config']['MM']) {
					$MM_table = $fieldConf['config']['MM'];
				}
			break;
			default:
				return NULL;
			break;
		}
			// The target table could also be a list of tables
		$targetTables = t3lib_div::trimExplode(',', $targetTable, 1);

		if ($MM_table) {
			$relations = $this->resolveReferenceChain_getRelatedMM($MM_table, $targetTables, $currentRecord['uid']);
		} else {
			$relations = $this->resolveReferenceChain_getRelated($targetTables, $currentValue);
		}
		$result = NULL;
		if (count($relations)) {
			foreach ($relations as $relation) {
				list($table, $uid) = $relation;
				if ($table && $uid) {
					$rec = t3lib_BEfunc::getRecord($table, $uid, '*', $this->enableFields($table));
					if (is_array($rec)) {
if ($this->debug) {
	$this->debug2 = true;
}
						$this->debug = true;
						$res = $this->resolveReferenceChain($resolveFields, $table, $rec);
						if ($res !== NULL) {
							$result[] = $res;
						}
					}
				}
			}
		}
		return $result;
	}

	/*
	 * This method will process all references for the passed comma separated list
	 *
	 * @param array The allowed tables
	 * @param string A comma separated values list of references. The "tablename_uid" syntax is also possible
	 * @return array Processed references 
	 */
	protected function resolveReferenceChain_getRelated($targetTables, $currentValue) {
		$targetTableCount = count($targetTables);
		$relations = array();
		if ($targetTableCount) {
			$keys = array_keys($targetTables);
			$firstKey = array_shift($keys);
			$firstTable = $targetTables[$firstKey];
			$tmp_relations = t3lib_div::trimExplode(',', $currentValue);
			foreach ($tmp_relations as $key => $value) {
				if (t3lib_div::testInt($value)) {
					if ($targetTableCount == 1) {
						$relations[] = array($firstTable, $value);
					}
				} else {
					$parts = explode('_', $value);
					if (count($parts) > 1) {
						$uid = array_pop($parts);
						$table = implode('_', $parts);
						$relations[] = array($table, $uid);
					}
				}
			}
		}
		return $relations;
	}

	/*
	 * This method will retrieve all MM references for the passed local uid
	 *
	 * @param string The name of the MM table for which to retrieve MM relation values
	 * @param array The allowed tables
	 * @param integer The UID of the local side of the MM table
	 * @return array The retrieved references
	 */
	protected function resolveReferenceChain_getRelatedMM($MM_table, $targetTables, $uidLocal) {
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', $MM_table, 'uid_local='.$uidLocal);
		$relations = array();
		$keys = array_keys($targetTables);
		$firstKey = array_shift($keys);
		$firstTable = $targetTables[$firstKey];
		$targetTableCount = count($targetTables);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$table = $row['tablenames'];
			if (!$table) {
				if ($targetTableCount == 1) {
					$table = $firstTable;
				}
			}
			if ($table) {
				$relations[] = array($table, $row['uid_foreign']);
			}
		}
		return $relations;
	}

	public function implodeRecursive($glue, $data) {
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$data[$key] = $this->implodeRecursive($glue, $value);
			}
		}
		return implode($glue, $data);
	}
	
	public function enableFields($table) {
		if (!$this->enableFields_cache[$table]) {
			$this->enableFields_cache[$table] = t3lib_BEfunc::BEenableFields($table);
		}
		return $this->enableFields_cache[$table];
	}


}

$instance = tx_kbkickstarter_misc::singleton();


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_misc.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_misc.php']);
}


?>
