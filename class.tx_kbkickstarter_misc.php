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
 * "Misc" class with miscellaneous methods required throughout the extension
 *
 * @author	Bernhard Kraft <kraftb@kraftb.at>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 */

define('PATH_kb_kickstarter', '');
require_once(PATH_kb_kickstarter.'class.tx_kbkickstarter_singleton.php');


class tx_kbkickstarter_misc extends tx_kbkickstarter_singleton {
	
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

}

$instance = tx_kbkickstarter_misc::singleton();


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_misc.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_misc.php']);
}


?>
