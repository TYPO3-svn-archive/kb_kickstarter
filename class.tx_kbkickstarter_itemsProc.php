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
 * Item processing methods for kb_kickstarter
 *
 * @author	Bernhard Kraft <kraftb@think-open.at>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 */



class tx_kbkickstarter_itemsProc {


	function tableFields(&$params, &$parentObj) {
		$field = $params['config']['foreignTableField'];
		$sorting = intval($params['config']['foreignSorting']);
		if ($sorting) {
			$labelASC = $GLOBALS['LANG']->sL($params['config']['labelASC']);
			$labelDESC = $GLOBALS['LANG']->sL($params['config']['labelDESC']);
		}
		if (($params['row']['type']!=='database_relation') && ($params['row']['type']!=='container') && ($params['row']['type']!=='inverse_db_relation')) return;
		$flexData = t3lib_div::xml2array($params['row']['flexconfig']);
		if (!is_array($flexData)) {
			return;
		}
		$allowed = $flexData['data']['sDEF']['lDEF'][$field]['vDEF'];
		list($table) = t3lib_div::trimExplode(',', $allowed, 1);
		if ($table && $GLOBALS['TCA'][$table]) {
			$items = $params['items'];
			t3lib_div::loadTCA($table);
			foreach ($GLOBALS['TCA'][$table]['columns'] as $field => $config) {
				$label = $GLOBALS['LANG']->sL($config['label']);
				if (substr($label, -1)===':') {
					$label = substr($label, 0, -1);
				}
				if ($sorting) {
					$items[] = array($labelASC.$label, $table.'.'.$field.' ASC');
					$items[] = array($labelDESC.$label, $table.'.'.$field.' DESC');
				} else {
					$items[] = array($label, $field);
				}
			}
			$params['items'] = $items;
		}
	}

	function removeNonSelected(&$params, &$parentObj) {
		$curValField = $params['config']['itemsProcFuncParams']['field'];
		$resolveFields = t3lib_div::trimExplode('|', $curValField);
		if (count($resolveFields) === 1) {
			$useRow = $params['row'];
			$valField = $curValField;
		} else {
			$miscObj = tx_kbkickstarter_misc::singleton();
			$result = $miscObj->resolveReferenceChain($resolveFields, $params['table'], $params['row']);
			$resVal = $miscObj->implodeRecursive(',', $result);
			$useRow = array(
				'result' => $resVal,
			);
			$valField = 'result';
		}
		if ($valField && isset($useRow[$valField])) {
			$allowValues = t3lib_div::intExplode(',', $useRow[$valField]);
			$allowValues[] = 0;
			foreach ($params['items'] as $itemIdx => $itemValue) {
				if (!in_array(abs(intval($itemValue[1])), $allowValues)) {
					unset($params['items'][$itemIdx]);
				}
			}
		}
	}


}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_itemsProc.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_itemsProc.php']);
}

?>
