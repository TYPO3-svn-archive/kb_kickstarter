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
 * This class is responsible for creating configuration files out of loaded table/field definitions
 *
 * @author	Bernhard Kraft <kraftb@think-open.at>
 */


// TODO: Add "hasHidden" flag to a table-definition record
// TODO: Add palettes generating to gentca and _basics/tca_template.tpl

require_once(PATH_kb_kickstarter.'class.tx_kbkickstarter_tables.php');

class tx_kbkickstarter_genConfig {
	protected $parentObj = null;
	protected $rootObj = null;

	protected $tablesObj = null;

	protected $miscObj = null;
	protected $configObj = null;
	protected $extension = '';

	protected $updateResults = Array();

	// This array defines the operations/actions which can get performed on the table definition records.
	// These get used in method "tables_action"
	//
	// generateConfig  ... Generates the config file specified as second parameter to "tables_action"
	// currentChecksum ... Calculates the checksum for the currently writen config files specified in the second parmeter to "tables_action"
	// createLinks     ... Creates links for updating config files of tables (used in mod_kickadmin)
	// writeConfig     ... Writes the configuration file specified and passed table to the configuration file on disk
	protected $actions = Array(
		'display' => Array('generateConfig', 'currentChecksum', 'createLinks'),
		'update' => Array('generateConfig', 'writeConfig'),
		'_all' => Array('generateConfig', 'currentChecksum', 'createLinks', 'writeConfig'),
	);




	/*************************
	 *
	 * Initialization methods
	 *
	 * The following method(s) are required for setting up this class
	 *
	 *************************/

	/**
	 * Initialization method
	 *
	 * @param		object			The parent object
	 * @param		object			The root object
	 * @return	void
	 */
	public function init(&$parentObj, &$rootObj) {
		$this->parentObj = &$parentObj;
		$this->rootObj = &$rootObj;
		$this->configObj = &$GLOBALS['T3_VARS']['kb_kickstarter_config'];
		$this->extension = $this->configObj->get_extension();
		$this->miscObj = tx_kbkickstarter_misc::singleton();
		$this->tablesObj = t3lib_div::makeInstance('tx_kbkickstarter_tables');
		$this->tablesObj->init($this, $this->rootObj);
	}




	/*************************
	 *
	 * Iteration methods
	 *
	 * This methods iterate over all tables and perform their operations on each table
	 *
	 *************************/

	/**
	 * Performs the passed action on all tables
	 *
	 * @param		string			Specifies which operation to perform on the tables (one of the values in $this->operations)
	 * @param		string			A key, defining which configuration file content to create (data is kept in memory)
	 * @return	void
	 */
	private function tables_action($whichOperation, $whichConfigFile) {
		if (in_array($whichOperation, $this->actions['_all'])) {
			$params = $this->configObj->get_configFilesInfo($whichConfigFile);
			if (is_array($params)) {
				$this->tablesObj->tables_iterate($this, 'table_'.$whichOperation, $params);
			}
		}
	}




	/*************************
	 *
	 * Methods called from iterator
	 *
	 * This methods get called for each table. They perform the action specified by
	 *
	 *************************/

	/**
	 * Generate configuration file content for passed table ($table) and configuration file ($params)
	 *
	 * @param		array				The database setting for the table being rendered
	 * @param		integer			The index (UID) of the table for which config is being generated
	 * @param		array				A params array, defining which config file to generate
	 * @return	string			The TCA content for the passed table as in tca.php
	 */
	public function table_generateConfig($tableRow, $params) {
		$key = '_'.$params['key'];
		$smarty = $this->get_localSmarty($tableRow);
		$this->tablesObj->smarty_assignVars($smarty);
		$result = $smarty->display($params['template']);
		$tableRow[$key]['new']['content'] = trim($result);
		$tableRow[$key]['new']['md5'] = md5($tableRow[$key]['new']['content']);
		return array($tableRow, true);
	}

	/**
	 * Get checksum for specified configuration file of passed table
	 *
	 * @param		array				A table definition record
	 * @param		integer			The index (UID) of the table for which a checksum is being calculated
	 * @param		array				A params array, defining which checksum to calculate
	 * @return	array				The passed table definition record with filled in MD5 sums
	 */
	public function table_currentChecksum($tableRow, $params) {
		$key = '_'.$params['key'];
		$relFile = $tableRow[$key]['relFile'];
		$absFile = $tableRow[$key]['absFile'];
		$tableRow[$key]['current']['md5'] = '';
		if ($absFile && file_exists($absFile)) {
			$tableRow[$key]['current']['content'] = t3lib_div::getURL($absFile);
			$tableRow[$key]['current']['md5'] = md5_file($absFile);
		}
		return array($tableRow, true);
	}


	/**
	 * Create links for a single table
	 *
	 * @param		array			The table definition record for which to generate links
	 * @param		integer		The index (UID) of the table for which to generate links
	 * @param		array			A params array, defining which links to generate
	 * @return	array			The passed table definition record with the links set
	 */
	public function table_createLinks($tableRow, $params) {
		$key = '_'.$params['key'];
		$tableRow['_links'][$key] = array(
			'update' => $this->miscObj->getLink(array('table' => $tableRow['uid'], 'key' => $params['key'], 'update' => 'default')),
			'update_force' => $this->miscObj->getLink(array('table' => $tableRow['uid'], 'key' => $params['key'], 'update' => 'force')),
		);
		if (!$tableRow['_links']['_all']) {
			$tableRow['_links']['_all'] = array(
				'update' => $this->miscObj->getLink(array('table' => $tableRow['uid'], 'key' => 'all', 'update' => 'default')),
				'update_force' => $this->miscObj->getLink(array('table' => $tableRow['uid'], 'key' => 'all', 'update' => 'force')),
			);
		}
		return array($tableRow, true);
	}


	/**
	 * Update the TYPO3 configuration file for the passed table and file
	 *
	 * @param		array				The table definition record for which to write configuration 
	 * @param		integer			The index (UID) of the table for which to write configuration
	 * @param		array				A params array, defining which configuration file to write
	 * @return	boolean			Wheter update was successfull
	 */
	public function table_writeConfig($tableRow, $params) {
		$key = '_'.$params['key'];
		$baseDir = $this->configObj->get_configExtensionPath();
		$relFile = $tableRow[$key]['relFile'];
		$absFile = $tableRow[$key]['absFile'];
		$dir = dirname($relFile).'/';
		if ($dir && ($dir != '.')) {
			t3lib_div::mkdir_deep($baseDir, $dir);
		}
		$ok = t3lib_div::writeFile($absFile, $tableRow[$key]['new']['content']);
		if ($ok) {
			$this->updateResults[] = 'Configuration file "'.$params['key'].'" for table "'.$tableRow['alias'].'" written! ('.strlen($tableRow[$key]['new']['content']).' / '.filesize($absFile).')';
		} else {
			$this->updateResults[] = 'Error writing configuration file "'.$params['key'].'" for table "'.$tableRow['alias'].'" !';
		}
		return array($tableRow, $ok?true:false);
	}




	/*************************
	 *
	 * Wrapper methods
	 *
	 * Methods which directly act on the underlying "tablesObj"
	 *
	 *************************/

	/**
	 * Let the sub-object "tablesObj" load the database definition of all tables/fields
	 *
	 * @return	void
	 */
	public function loadTables() {
		if (is_object($this->tablesObj)) {
			$this->tablesObj->loadTables();
		}
	}

	/**
	 * Let the sub-object "tablesObj" return a timestamp of last modification
	 *
	 * @return	void
	 */
	public function getLastMod() {
		if (is_object($this->tablesObj)) {
			return $this->tablesObj->getLastMod();
		}
	}

	/**
	 * Let the sub-object "tablesObj" assign all required values to the passed smarty object
	 *
	 * @param	object		The smarty object instance rendering the page-module template
	 * @return	void
	 */
	public function smarty_assignVars(&$smartyObj) {
		if (is_object($this->tablesObj)) {
			$this->tablesObj->smarty_assignVars($smartyObj);
		}
	}



	/*************************
	 *
	 * Support methods
	 *
	 * These are additional methods required through this class
	 *
	 *************************/

	/**
	 * Return the results of the calls to the update method
	 *
	 * @return		array					The results of calls to the update method
	 */
	public function get_updateResults() {
		return $this->updateResults;
	}

	/**
	 * Returns a local version of smarty - with (mostly) all required parameters assigned
	 *
	 * @return		object			A local version of a smarty instance
	 */
	private function get_localSmarty($table) {
		$smarty = $this->rootObj->clone_smarty();
		$smarty->setSmartyVar('template_dir','EXT:'.$this->extension.'/fieldTypes');
		$smarty->assign('table', $table);
		$smarty->assign('configObj', $this->configObj);
		$smarty->assign('configExtension', $this->configObj->get_configExtension());
		$smarty->assign('generatedComment', $this->configObj->get_generatedComment());
		return $smarty;
	}

	/**
	 * Performs the task passed as argument on all or a specified table and config file
	 *
	 * @return		string			The task which to perform
	 * @return		integer			The key/index of the table on which to perform an action
	 * @return		boolean			Wheter to force the requestd action. If the table seems up-to-date the task will not get executed
	 * @return		array				A list of config-file keys for which the requested task shall get executed
	 * @return		integer			The number of actions succeding
	 */
	private function tables_task($task, $tableIdx = false, $force = false, $configFiles = false) {
		$actions = $this->actions[$task];
		if (!is_array($configFiles)) {
			$configFiles = $this->configObj->get_configFilesInfo();
		}
		$ok = 0;
		if (is_array($actions) && count($actions)) {
			foreach ($actions as $action) {
				foreach ($configFiles as $whichConfigFile) {
					$params = $this->configObj->get_configFilesInfo($whichConfigFile);
					if (is_array($params)) {
						if ($tableIdx) {
							$ok += $this->tablesObj->table_action($tableIdx, $this, 'table_'.$action, $params, $force);
						} else {
							$ok += $this->tablesObj->tables_iterate($this, 'table_'.$action, $params, $force);
						}
					}
				}
			}
		}
		return $ok;
	}

	/**
	 * Executes the task "display" on all tables and all config files. This is required for displaying the actual status
	 *
	 * @return		integer			The number of actions performed
	 */
	public function aquireDisplayInfo() {
		return $this->tables_task('display');
	}

	/**
	 * Executes the "update" task on the specified (or all) table(s)
	 *
	 * @param			integer			The key/index of the table to update, or -1 for all
	 * @param			boolean			Wheter to force the update even if md5 checksums of newly generated content and current files are the same
	 * @param			string			If set to a valid config-file-key only the passed configuration file gets updated
	 * @return		integer			The number of actions performed
	 */
	public function updateTable($table, $force = false, $configFile = '') {
		$cfArray = false;
		if ($configFile) {
			$cfArray = array($configFile);
		}
		if ($table<0) {
			return $this->tables_task('update', false, $force, $cfArray);
		} else {
			return $this->tables_task('update', $table, $force, $cfArray);
		}
	}

}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickadmin/class.tx_kbkickstarter_gentca.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickadmin/class.tx_kbkickstarter_gentca.php']);
}

?>
