<?php
/**
 * A lightweight folder based gallery module for the CMS SilverStripe
 *
 * Contains global settings for the SilverStripe CMS foldergallery module.
 * 
 * LICENSE: GNU General Public License 3.0
 * 
 * @platform    CMS SilverStripe 3.1.x (or higher)
 * @package     cwsoft-foldergallery
 * @version     2.7.3
 * @author      cwsoft (http://cwsoft.de)
 * @copyright   cwsoft
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
*/

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// DO NOT CHANGE ANYTHING BELOW THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING :-)
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ensure module is stored in folder "cwsoft-foldergallery"
$moduleName = 'cwsoft-foldergallery';
$folderName = basename(dirname(__FILE__));

if ($folderName != $moduleName) {
	user_error(
		_t(
			'_config.WRONG_MODULE_FOLDER', 
			'Please rename the folder "{folderName}" into "{moduleName}" to get the {moduleName} module working properly.',
			array('moduleName' => $moduleName, 'folderName' => $folderName)
		),
		E_USER_ERROR
	);
}