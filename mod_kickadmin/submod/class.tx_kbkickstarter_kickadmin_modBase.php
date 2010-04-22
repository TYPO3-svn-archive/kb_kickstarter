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
 * sub-module base for module 'Kick Admin' for the 'kb_kickstarter' extension.
 *
 * @author	Bernhard Kraft <kraftb@think-open.at>
 */

require_once(PATH_kb_kickstarter.'mod_kickadmin/interfaces/interface.tx_kbkickstarter_kickadmin_mod.php');

class tx_kbkickstarter_kickadmin_modBase {
	protected $parentObj = null;
	protected $rootObj = null;

	protected $configObj = null;
	protected $miscObj = null;
	protected $extension = '';

	protected $smarty = null;
	protected $genConfigObj = null;
	protected $EMobj = null;


	/**
	 * Initializes this object instance
	 *
	 * @param	object			A reference to the parent object instance
	 * @param	object			A reference to the root object instance
	 * @return	void
	 */
	public function init(&$parentObj, &$rootObj) {
		$this->parentObj = &$parentObj;
		$this->rootObj = &$rootObj;
		$this->configObj = &$GLOBALS['T3_VARS']['kb_kickstarter_config'];
		$this->miscObj = tx_kbkickstarter_misc::singleton();
		$this->extension = $this->configObj->get_extension();
		$this->smarty = &$this->parentObj->clone_smarty();
	}

	/**
	 * (Basically) initializes the TCA generating object instance
	 *
	 * @return	void
	 */
	protected function init_genConfigObj() {
		if (!is_object($this->genConfigObj)) {
			// Create object instance for generating TCA files
			require_once(PATH_kb_kickstarter.'class.tx_kbkickstarter_genConfig.php');
			$this->genConfigObj = t3lib_div::makeInstance('tx_kbkickstarter_genConfig');
			$this->genConfigObj->init($this, $this->rootObj);
		}
		// Load all tables defined in database
		$this->genConfigObj->loadTables();
	}

	/**
	 * Initializes the extensionManager object instance for update/modification of database and installing of extension
	 *
	 * @return	void
	 */
	function initEMobj() {
		if (!is_object($this->EMobj)) {
			require_once(PATH_typo3.'mod/tools/em/class.em_index.php');
			$this->EMobj = t3lib_div::makeInstance('SC_mod_tools_em_index');
			$this->EMobj->init();
		}
	}


}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/mod_kickadmin/submod/class.tx_kbkickstarter_kickadmin_modBase.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/mod_kickadmin/submod/class.tx_kbkickstarter_kickadmin_modBase.php']);
}

?>
