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

if (tx_kbkickstarter_kickadmin_modBase::isModernEM()) {
	require_once(PATH_typo3.'sysext/em/classes/extensions/class.tx_em_extensions_list.php');
	require_once(PATH_typo3.'sysext/em/classes/install/class.tx_em_install.php');
}

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
			$this->genConfigObj = t3lib_div::makeInstance('tx_kbkickstarter_genConfig');
			$this->genConfigObj->init($this, $this->rootObj);
		}
		// Load all tables defined in database
		$this->genConfigObj->loadTables();
	}

	/**
	 * This is the OLD WAY (prior to 4.4 or 4.3)
	 * Initializes the extensionManager object instance for update/modification of database and installing of extension
	 *
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

	/**
	 * uses class.tx_em_extensions_list.php to get full extension list.
	 *
	 * @return	void
	 */
	function getInstalledExtensionsWrapper() {

		if (!$this->isModernEM()) {
			$this->initEMobj();
			$list = $this->EMobj->getInstalledExtensions();
		} else {
			$extensionList = $this->EMobj = t3lib_div::makeInstance('tx_em_Extensions_List');
			$list = $extensionList->getInstalledExtensions(false);
		}
		return $list;
	}

	/**
	 * uses class.tx_em_install.php to check for db update. fallback if older TYPO3
	 *
	 * @return	void
	 */
	function checkDBupdatesWrapper($configExt, $extInfo) {
		if (!$this->isModernEM()) {
			$this->initEMobj();
			$status = $this->EMobj->checkDBupdates($configExt, $extInfo, 1);
		} else {
			$install = t3lib_div::makeInstance('tx_em_Install');
			$status = $install->checkDBupdates($configExt, $extInfo, 1);
		}
		return $status;
	}

	/**
	 * uses class.tx_em_install.php to force db update. fallback if older TYPO3
	 *
	 * @return	void
	 */
	function forceDBupdatesWrapper($configExt, $extInfo){
		if (!$this->isModernEM()) {
			$this->initEMobj();
			$this->EMobj->forceDBupdates($configExt, $extInfo);
		} else {
			$install = $this->EMobj = t3lib_div::makeInstance('tx_em_Install');
			$status = $install->forceDBupdates($configExt, $extInfo);
		}
		return $status;
	}

	function installExtensionWrapper($extName) {
		if (!$this->isModernEM()) {
			$this->initEMobj();
			$this->EMobj->installExtension($configExt, $extInfo);
		} else {
			$install = t3lib_div::makeInstance('tx_em_Install');
			$status = $install->installExtension($extName);
		}
		return $status;
	}

	function isModernEM() {
		$version = explode('.', TYPO3_version);
		if ($version[0] < 4 || $version[1] < 4) {
			return false;
		} else {
			return true;
		}
	}
	

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/mod_kickadmin/submod/class.tx_kbkickstarter_kickadmin_modBase.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/mod_kickadmin/submod/class.tx_kbkickstarter_kickadmin_modBase.php']);
}

?>
