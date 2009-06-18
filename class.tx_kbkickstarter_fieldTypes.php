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
 * Methods for handling available field types
 *
 * @author	Bernhard Kraft <kraftb@kraftb.at>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 */



class tx_kbkickstarter_fieldTypes {


	/**
	 * Method for initializing fields (field directories)
	 *
	 * @param	string		The path containing the field template directories
	 * @return	void
	 */
	public function initFieldTypes($basePath = '') {
		// TODO: CACHE
		if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['fieldTypes'])) {
			$GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['fieldTypes'] = Array();
		}
		if (!$GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['fieldTypes']['flexDSfiles']['default']) {
			$GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['fieldTypes']['flexDSfiles']['default'] = 'EXT:kb_kickstarter/fieldTypes/_basics/field_props_default.xml';
		}
		if (!$basePath) {
			$basePath = 'EXT:kb_kickstarter/fieldTypes/';
		}
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['fieldTypes']['selectConfig']['_empty_'] = array(
			'LLL:EXT:kb_kickstarter/llxml/locallang_db_fields.xml:tx_kbkickstarter_fields.type.none',
			'none',
		);
		$absPath = t3lib_div::getFileAbsFileName($basePath);
		$subdirs = t3lib_div::get_dirs($absPath);
		if (is_array($subdirs))	{
			foreach ($subdirs as $subdir) {
				if (substr($subdir, 0, strlen('todo_'))=='todo_') {
					continue;
				}
				if (substr($subdir, 0, 1)=='_') {
					continue;
				}
				$this->addFieldType($basePath, $subdir);
			}
		}
	}


	/**
	 * Add a field to internal array of available fields
	 *
	 * @param	string		A TYPO3 path definition to the field template directory (i.e: "EXT:kb_extrafields/fieldTypes/")
	 * @param	string		The name to a field template sub-directory
	 * @return	void
	 */
	public function addFieldType($basePath, $subdir) {
		// TODO: Log errors instead of "die()"
		if (substr($basePath, -1)!='/') {
			$basePath .= '/';
		}
		$absPath = t3lib_div::getFileAbsFileName($basePath);
		$path = $absPath.$subdir.'/';
		if (@file_exists($path) && is_dir($path)) {
			$out_path = $path;
			$config_data = t3lib_div::getURL($path.'field_config.xml');
			$config = t3lib_div::xml2tree($config_data);
			if (is_array($config) && is_array($config['kb_kickstarter'][0]['ch'])) {
				$fieldConfig = $config['kb_kickstarter'][0]['ch'];
				list($configName, $configArray) = $this->getConfigItem($fieldConfig);
				if ($configName && is_array($configArray)) {
					if ((count($configArray)==2) || (count($configArray)==3)) {
						$flexXMLpath = 'FILE:'.$basePath.$subdir.'/field_props.xml';
						if ($configName!=='none') {
							$GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['fieldTypes']['selectConfig'][$configName] = $configArray;
						}
						$GLOBALS['TYPO3_CONF_VARS']['EXT']['kb_kickstarter']['fieldTypes']['flexDSfiles'][$configName] = $flexXMLpath;
					} else {
						// TODO: Log error instead of die() call
						die('Config array at location "'.$out_path.'" has invalid number of values !');
					}
				} else	{
					// TODO: Log error instead of die() call
					die('Config array at location "'.$out_path.'" has invalid types !');
				}
			}
		}
	}


	/**
	 * Return the field setup info for the passed field config (from XML)
	 *
	 * @param	array		Field setup info from XML
	 * @return	array		The setup info as sane array
	 */
	private function getConfigItem($config) {
		$item = array(
			$config['propertyName'][0]['values'][0],
			$config['propertyValue'][0]['values'][0],
			$config['propertyIcon'][0]['values'][0],
		);
		return array($config['propertyValue'][0]['values'][0], $item);
	}


}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_fieldTypes.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kb_kickstarter/class.tx_kbkickstarter_fieldTypes.php']);
}

?>
