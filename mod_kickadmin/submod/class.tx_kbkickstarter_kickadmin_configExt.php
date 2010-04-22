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
 * sub-module "genTCA" for module 'Kick Admin' for the 'kb_kickstarter' extension.
 *
 * @author	Bernhard Kraft <kraftb@think-open.at>
 */

class tx_kbkickstarter_kickadmin_configExt extends tx_kbkickstarter_kickadmin_modBase implements tx_kbkickstarter_kickadmin_mod {
	private $current_configExtName = '';
	private $configExtensions = array();
	private $resultInfo = array();
	private $requiredFiles = array('ext_tables.php', 'ext_tables.sql');

	/**
	 * Render module content for sub-module "configuration extension" of kb_kickadmin
	 *
	 * @return	string			The content for this sub-module
	 */
	public function moduleContent() {
		$content = '';

		$this->smarty->assign('extension', $this->extension);
		$this->current_configExtName = $this->configObj->get_configExtension();

		// get a list of all available configuration extensions and assign them to smarty
		$this->init_genConfigObj();
		$this->lastMod = $this->genConfigObj->getLastMod();
		$this->configExtensions = $this->getAvailableConfigExtensions();

		$upd = $this->handleInstall();

		// If updates occured reload all relevant information
		if ($upd) {
			$this->current_configExtName = $this->configObj->get_configExtension();
			$this->configExtensions = $this->getAvailableConfigExtensions();
		}

		$this->smarty->assign('resultInfo', $this->resultInfo);
		$this->smarty->assign('configExtensions', $this->configExtensions);
		$this->smarty->assign('linkScript', $this->miscObj->getLink(array()));

		// Render assigned variables into template
		$content = $this->smarty->display('configExt/main.tpl');

		return $content;
	}


	/**
	 * Checks if an extension should get installed
	 *
	 * @return	string				The name of the installed extension or an empty string if nothing got installed
	 */
	function handleInstall() {
		$installExtName = $_GET['install'];
		if ($installExtName && ($installExt = $this->configExtensions[$installExtName])) {
			if (!$installExt['installed']) 	{
				if ($this->installExtension($installExtName)) {
					return $installExtName;
				}
			}
		}
		return '';
	}


	/**
	 * Installs the passed extension
	 *
	 * @param		string			The name of the extension to be installed
	 * @return	boolean			Wheter installing the extension was successfull
	 */
	function installExtension($extName) {
		if ($ext = $this->configExtensions[$extName]) {
			if (!$ext['installed']) 	{
				$this->initEMobj();
				$status = $this->EMobj->installExtension($extName);
				if (!$status[0]) {
					$this->resultInfo[] = $status[1];
				}
				return $status[0];
			}
		}
		return false;
	}


	/**
	 * Render module content for sub-module "configuration extension" of kb_kickadmin
	 *
	 * @return	array				An array of all available configuration extensions
	 */
	function getAvailableConfigExtensions() {
		$configExtensions = array();
		$localExtBase = PATH_typo3conf.'ext/';
		$localExtList = t3lib_div::get_dirs($localExtBase);
		$mark = $this->configObj->get_configExtensionMark();
		foreach ($localExtList as $localExt) {
			$extBase = $localExtBase.$localExt.'/';
			if (file_exists($extBase.$mark)) {
				$configExtensions[$localExt] = $this->getConfigExtensionInfo($localExt);
			}
		}
		return $configExtensions;
	}

	/**
	 * Creates an array containing information about configuration extensions
	 *
	 * @param		string			The name of the extension for which to generate the info array
	 * @return	array				An array with information about the configuration extensions
	 */
	function getConfigExtensionInfo($configExtName) {
		return array(
			'name' => $configExtName,
			'installed' => t3lib_extMgm::isLoaded($configExtName)?true:false,
			'current' => ($configExtName==$this->current_configExtName)?true:false,
			'installLink' => $this->miscObj->getLink(array('install' => $configExtName)),
		);
	}

	/**
	 * Returns the file name of a file in the extension directory
	 *
	 * @param		string			The name of the extension
	 * @param		string			The name of the file
	 * @return	string			The full file/path name of the file
	 */
	private function getRequiredFileName($extName, $file) {
		$extPath = PATH_typo3conf.'ext/'.$extName.'/';
		return $extPath.$file;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/mod_kickadmin/submod/class.tx_kbkickstarter_kickadmin_configExt.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/mod_kickadmin/submod/class.tx_kbkickstarter_kickadmin_configExt.php']);
}

?>
