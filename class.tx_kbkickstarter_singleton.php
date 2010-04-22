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
 * Base class implementing a singleton pattern
 *
 * @author	Bernhard Kraft <kraftb@think-open.at>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 */


class tx_kbkickstarter_singleton {
	// Hold instances of all singleton classes
	private static $instance = array();


	/**
	 * A private constructor. Prevents direct creation of object
	 *
	 * @return	void
	 */
	function __construct() {
		// Do Nothing
	}


	/**
	 * The singleton method. Returns reference to the created singleton.
	 *
	 * @return	object			Reference to singleton instance
	 */
	public static function singleton($class) {
		if (!isset(self::$instance[$class])) {
			self::$instance[$class] = new $class;
		}
		return self::$instance[$class];
	}


	/**
	 * Prevent users from cloning the singleton instance
	 *
	 * @return	void
	 */
	public function __clone() {
		trigger_error('Clone is not allowed for singletons!', E_USER_ERROR);
	}

}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickadmin/class.tx_kbkickstarter_singleton.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickadmin/class.tx_kbkickstarter_singleton.php']);
}

?>
