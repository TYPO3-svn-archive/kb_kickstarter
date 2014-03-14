<?php
// namespace thinkopen_at\kbDisplay\Hooks\Smarty
// @todo: Uncomment after upgrade to 6.2

/***************************************************************
*  Copyright notice
*  
*  (c) 2008-2014 Bernhard Kraft (kraftb@think-open.at)
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
 * Smarty plugin function for creating a directory
 * This was necessary as the {php} function isn't available anymore
 * since smarty 3.1
 *
 * @author	Bernhard Kraft <kraftb@think-open.at>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 */

// @todo: Uncomment/comment after upgrade to 6.2
// use TYPO3\CMS\Core\Utility\GeneralUtility;
use t3lib_div as GeneralUtility;

// @todo: Uncomment/comment after upgrade to 6.2
// class CreateDirectory {
class tx_kbkickstarter_Hooks_Smarty_CreateDirectory {

	/**
	 * Smarty plugin
	 * -------------------------------------------------------------
	 * File:     CreateDirectory.php
	 * Type:     function
	 * Name:     createDirectory
	 * Purpose:  Creates a directory in PATH_site
	 * -------------------------------------------------------------
	 */
	public static function createDirectory($params, Smarty_Internal_Template $template) {
		if (!(isset($params['base']) && isset($params['directory']))) {
			return '';
		}
		$basePath = PATH_site.$params['base'];
		GeneralUtility::mkdir_deep($basePath, $params['directory']);
		return '';
	}

}

