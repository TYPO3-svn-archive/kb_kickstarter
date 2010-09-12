<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2010 Bernhard Kraft (kraftb@think-open.at)
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
 * TCA user-type field "clone"
 *
 * @author	Bernhard Kraft <kraftb@think-open.at>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 */



class tx_kbkickstarter_fieldClone {

	public function tx_kbkickstarter_fieldClone() {
		$this->configObj = &$GLOBALS['T3_VARS']['kb_kickstarter_config'];
		$this->tableObject = t3lib_div::makeInstance('tx_kbkickstarter_tables');
		$this->miscObj = tx_kbkickstarter_misc::singleton();
	}

	public function getSingleField_preProcess($table, $field, $row, $altName, $palette, $extra, $pal, &$parentObject) {
		t3lib_div::loadTCA($table);
		$this->config = $GLOBALS['TCA'][$table]['columns'][$field]['config'];
		if ($this->config['type'] === 'clone') {
			$this->currentTable = $table;
			$this->currentField = $field;
			$this->currentRecord = $row;
			$this->parentObject = &$parentObject;
			$this->tableObject->init($this, $this->parentObject);
//			$this->debug = false;
			$this->cloneFieldConfig();
		}
	}

	public function processDatamap_preProcessFieldArray($incomingFieldArray, $table, $id, &$parentObject) {
		t3lib_div::loadTCA($table);
		foreach ($incomingFieldArray as $field => $value) {
			$this->config = $GLOBALS['TCA'][$table]['columns'][$field]['config'];
			if ($this->config['type'] === 'clone') {
				$this->currentTable = $table;
				$this->currentField = $field;
				if (t3lib_div::testInt($id)) {
					$fieldRecord = t3lib_BEfunc::getRecord($table, $id, '*', $this->miscObj->enableFields($table));
					$fieldRecord = array_merge($fieldRecord, $incomingFieldArray);
					$this->currentRecord = $fieldRecord;
				} else {
					$this->currentRecord = $incomingFieldArray;
				}
				$this->parentObject = &$parentObject;
				$this->tableObject->init($this, $this->parentObject);
//				$this->debug = true;
				$this->cloneFieldConfig();
			}
		}
	}

	protected function cloneFieldConfig() {
		$cloneTable = $this->config['cloneTable'];
		$cloneField = $this->config['cloneField'];
		if (!$cloneField && ($cloneFieldPointer = $this->config['cloneFieldPointer'])) {
			$cloneField = $this->resolveFieldPointer($cloneFieldPointer);
		}
		if (!$cloneTable && ($cloneTablePointer = $this->config['cloneTablePointer'])) {
			$cloneTable = $this->resolveTablePointer($cloneTablePointer);
		}
		if ($cloneTable && $cloneField) {
			return $this->cloneField($cloneTable, $cloneField);
		}
	}


	protected function resolvePointer($pointer) {
		$resolveFields = t3lib_div::trimExplode('|', $pointer);
		$currentTable = $this->currentTable;
		$currentRecord = $this->currentRecord;
//		$debug_fd = fopen('/tmp/debug.log', 'ab');
//		fwrite($debug_fd, print_r($currentRecord, 1)."\n\n");
//		fclose($debug_fd);
// DEBUG
//		$currentRecord['parentRecord'] = 8;
		$result = $this->miscObj->resolveReferenceChain($resolveFields, $currentTable, $currentRecord);
		return $this->miscObj->implodeRecursive(',', $result);
	}

	protected function resolveFieldPointer($fieldPointer) {
		$field = $this->resolvePointer($fieldPointer);
		$fieldName = '';
		if (t3lib_div::testInt($field)) {
			$fieldsTable = $this->configObj->getTable_FIELDS();
			$fieldRecord = t3lib_BEfunc::getRecord($fieldsTable, $field, '*', $this->miscObj->enableFields($fieldsTable));
			$fieldRecord = $this->tableObject->saneAlias($fieldRecord, array(), $fieldRecord);
			$fieldName = $fieldRecord['full_alias'];
		} else {
			$fieldName = $field;
		}
		return $fieldName;
	}

	protected function resolveTablePointer($tablePointer) {
		$table = $this->resolvePointer($tablePointer);
		$tableName = '';
		if (t3lib_div::testInt($table)) {
			$tablesTable = $this->configObj->getTable_TABLES();
			$tableRecord = t3lib_BEfunc::getRecord($tablesTable, $table, '*', $this->miscObj->enableFields($tablesTable));
			$tableRecord = $this->tableObject->saneAlias($tableRecord, $tableRecord);
			$tableName = $tableRecord['full_alias'];
		} else {
			$tableName = $tablePointer;
		}
		return $tableName;
	}

	protected function cloneField($cloneTable, $cloneField) {
		t3lib_div::loadTCA($cloneTable);
		$clonedConfig = $GLOBALS['TCA'][$cloneTable]['columns'][$cloneField]['config'];
		$GLOBALS['TCA'][$this->currentTable]['columns'][$this->currentField]['config'] = $clonedConfig;
	}

}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_fieldClone.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_fieldClone.php']);
}

?>
