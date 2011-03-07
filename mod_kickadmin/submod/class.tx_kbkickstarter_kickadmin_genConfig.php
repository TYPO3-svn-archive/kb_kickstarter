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


class tx_kbkickstarter_kickadmin_genConfig extends tx_kbkickstarter_kickadmin_modBase implements tx_kbkickstarter_kickadmin_mod {


	/**
	 * Render module content for sub-module "generate TCA" of kb_kickadmin
	 *
	 * @return	string			The content for this sub-module
	 */
	public function moduleContent() {
		$content = '';


		// Initalize object instance for generating TCA files
		$this->init_genConfigObj();


		// TODO: Caching. Once a configuration has been created cache it. Only
		// regenerate it when modification timestamp of one of the table elements is newer
		// than timestamp of config files

		// Check for requested config updates
		$updated = $this->performConfigUpdates();
		if ($updated) {
			// If update occured reinitalize object instance for generating TCA files
			$this->init_genConfigObj();
		}

		// Check for requested database updates
		$this->performDatabaseUpdates();

		// Assign variables to cloned smarty template
		$this->genConfigObj->smarty_assignVars($this->smarty);
		$this->smarty->assign('links', $this->getLinks());
		$this->smarty->assign('updateResults', $this->genConfigObj->get_updateResults());
		$this->smarty->assign('db_update', $this->checkDBupdate());

		$this->smarty->assign('out_of_date__all', 0);
		$configFiles = $this->configObj->get_configFilesInfo();
		foreach ($configFiles as $configFileKey) {
			$this->smarty->assign('out_of_date__'.$configFileKey, 0);
		}

		// The icon for updating a table
		$icon_update = t3lib_iconWorks::skinImg($this->rootObj->doc->backPath, 'gfx/refresh_n.gif', '', 1);
		$this->smarty->assign('icon_update', $icon_update);

		// Render assigned variables into template
		$content = $this->smarty->display('genConfig/main.tpl');

		return $content;
	}

	/**
	 * Returns all hrefs for the global and config-file specific table update links
	 *
	 * @return		array				An array containin all links not related to a table
	 */
	function getLinks() {
		$configFiles = $this->configObj->get_configFilesInfo();
		$links = array();
		foreach ($configFiles as $configFileKey) {
			$links[$configFileKey] = $this->getLinks_file($configFileKey);
		}
		$links['all'] = $this->getLinks_file('all');
		return $links;
	}

	/**
	 * Returns two hrefs for update links. A normal update link and a link forcing update.
	 *
	 * @return		array				An array containin two links to update a config file type
	 */
	function getLinks_file($key) {
		return array(
			'update' => $this->miscObj->getLink(array('table' => -1, 'key' => $key, 'update' => 'default')),
			'update_force' => $this->miscObj->getLink(array('table' => -1, 'key' => $key, 'update' => 'force')),
		);
	}

	/**
	 * Extended "init_genConfigObj" perfoming tasks required for creating new configuration
	 *
	 * @return		void
	 */
	protected function init_genConfigObj() {
		// Basic initialization
		parent::init_genConfigObj();
		// Create table configuration 
		$this->genConfigObj->aquireDisplayInfo();
	}

	/**
	 * Updates the config files requested via _GET parameters
	 *
	 * @return		void
	 */
	private function performConfigUpdates() {
		$updated = 0;
		if (($update = $_GET['update']) && ($key = $_GET['key'])) {
			$table = intval($_GET['table']);
			$update_table = 0;
			$force = false;
			switch ($update) {
				case 'force':
					$force = true;
				case 'default':
					$update_table = $table;
				break;
				case 'all_force':
					$force = true;
				case 'all':
					$update_table = -1;
				break;
			}
			$configFileParams = $this->configObj->get_configFilesInfo($key);
			if ($update_table && is_array($configFileParams)) {
				$updated += $this->genConfigObj->updateTable($update_table, $force, $key)?1:0;
				if ($key=='extTables') {
					$updated += $this->genConfigObj->updateTable($update_table, $force, 'extTablesMain')?1:0;
				}
			} elseif ($update_table && ($key=='all')) {
				$updated += $this->genConfigObj->updateTable($update_table, $force)?1:0;
			}
		}
		return $updated;
	}

	/**
	 * Updates the database if requested via _GET parameters
	 *
	 * @return		void
	 */
	private function performDatabaseUpdates() {
		$do_update = false;
		$force = false;
		if ($update = $_GET['update']) {
			switch ($update) {
				case 'db_force':
					$force = true;
				case 'db':
					$do_update = true;
			}
			if ($do_update) {
				$this->updateDB($force);
			}
		}
		return $do_update;
	}

	/**
	 * Updates the database
	 *
	 * @param			boolean				If update should get forced
	 * @return		void
	 */
	function updateDB($force = false) {
		//$this->initEMobj();
		list($list,) = $this->getInstalledExtensionsWrapper();
		$configExt = $this->configObj->get_configExtension();
		$extInfo = $list[$configExt];
		$db_update = $this->checkDBupdate();
		if ($db_update['required']) {
			$this->forceDBupdatesWrapper($configExt, $extInfo);
		} elseif ($force) {
			$this->forceDBupdatesWrapper($configExt, $extInfo);
		}
	}

	/**
	 * Checks wheter the database requires an update
	 *
	 * @return		array				Information if update is required and links for updating the database
	 */
	function checkDBupdate() {
		//$this->initEMobj();
		list($list,) = $this->getInstalledExtensionsWrapper();
		$configExt = $this->configObj->get_configExtension();
		$extInfo = $list[$configExt];
		$dbStatus = $this->checkDBupdatesWrapper($configExt, $extInfo);
		$dbStatus = $dbStatus['structure']['diff'];
		$required = false;
		if ($dbStatus['extra'] && count($dbStatus['extra'])) {
			$required = true;
		}
		if ($dbStatus['diff'] && count($dbStatus['diff'])) {
			$required = true;
		}
		return array(
			'required' => $required,
			'link' => $this->miscObj->getLink(array('update' => 'db')),
			'link_force' => $this->miscObj->getLink(array('update' => 'db_force')),
		);
	}


}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/mod_kickadmin/submod/class.tx_kbkickstarter_kickadmin_genTCA.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/mod_kickadmin/submod/class.tx_kbkickstarter_kickadmin_genTCA.php']);
}

?>
