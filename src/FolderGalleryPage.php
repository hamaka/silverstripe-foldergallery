<?php

namespace Juanitou\FolderGallery;

use Page;
use SilverStripe\Assets\Folder;
use SilverStripe\Forms\TreeDropdownField;

/**
 * A lightweight folder based gallery module for the CMS SilverStripe
 *
 * Implements the main functionality of the foldergallery module.
 *
 * LICENSE: GNU General Public License 3.0
 *
 * @platform    CMS SilverStripe 4 (or higher)
 * @package     juanitou-foldergallery
 * @author      cwsoft (http://cwsoft.de)
 * @author      Juanitou (http://juanmolina.eu)
 * @copyright   cwsoft
 * @copyright   Juanitou
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
*/

class FolderGalleryPage extends Page {
    private static $allowed_children = [FolderGalleryPage::class];
    private static $db = ['AlbumFolderID' => 'Int'];
    private static $icon = 'juanitou/silverstripe-foldergallery: images/page-tree-icon.gif';
    private static $plural_name = 'FolderGalleries';
    private static $singular_name = 'FolderGallery';
    private static $description = 'Folder-based gallery';
    private static $table_name = 'FolderGallery';

    /**
     * Adds dropdown field for album folders (subfolders inside assets/foldergallery)
     *
     * @return modified backend fields
     */
    function getCMSFields() {
        // create folder assets/foldergallery if not already exists
        Folder::find_or_make('foldergallery');

        // get default CMS fields
        $fields = parent::getCMSFields();

        // get "foldergallery" folder object
        $album = Folder::get()->filter('Name', 'foldergallery')->First();
        if (! $album) return $fields;

        // add dropdown field with album folders (subfolders of assets/foldergallery)
        $tree = new TreeDropdownField(
            'AlbumFolderID',
            _t(
                __CLASS__ . '.CHOOSE_IMAGE_FOLDER',
                'Choose image folder (subfolder assets/foldergallery/)'
            ),
            Folder::class
        );
        // TODO: Bug pending
        //$tree->setTreeBaseID((int) $album->ID);
        $fields->addFieldToTab('Root.Main', $tree, 'Content');

        return $fields;
    }

    /**
     * Updates the Image.ExifDate database column of image objects when page is saved
     * TODO: This functions prevents adding a base folder to the gallery
     * @return void
     */
    /*function onAfterWrite() {
        parent::onAfterWrite();

        // update Image.ExifDate database fields of all images assigned to actual page if image sort option is set "4:ExifDate"
        // Todo: execute DB update on URL request instead page write to avoid timing issues when dealing with lots of big images
        if (FolderGalleryPageController::getImageSortOption() == "ExifDate") {
            FolderGalleryImageExtension::writeExifDates($this->AlbumFolderID);
        }
    }*/
}
