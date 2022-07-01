<?php

namespace Juanitou\FolderGallery;

use PageController;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Folder;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Config\Config;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

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
 * @author      Juanitou (https://juanmolina.eu/)
 * @copyright   cwsoft
 * @copyright   Juanitou
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
*/

class FolderGalleryPageController extends PageController
{
    /**
     * Includes the CSS and Javascript files required by the foldergallery module
     *
     * @return void
     */

    protected function init()
    {
        parent::init();

        // include i18n Javascript library and lang files
        // TODO: Update these libraries
        // it doesn't work without the meta-tag (see http://open.silverstripe.org/ticket/7949)
        Requirements::insertHeadTags('<meta http-equiv="Content-language" content="' . i18n::get_locale() . '" />');
        Requirements::javascript('silverstripe/admin: client/dist/js/i18n.js');
        Requirements::add_i18n_javascript('juanitou/silverstripe-foldergallery: javascript/lang');

        // TODO: Why?
        // load foldergallery Javascript files into head
        //Requirements::set_write_js_to_body(false);

        // include required foldergallery CSS and Javascript files
        Requirements::css('juanitou/silverstripe-foldergallery: thirdparty/colorbox/colorbox.css');
        Requirements::css('juanitou/silverstripe-foldergallery: css/foldergallery.css');
        Requirements::javascript('juanitou/silverstripe-foldergallery: thirdparty/jquery/jquery.min.js');
        Requirements::javascript('juanitou/silverstripe-foldergallery: thirdparty/colorbox/jquery.colorbox-min.js');
        Requirements::javascript('juanitou/silverstripe-foldergallery: javascript/foldergallery.js');
    }

    /**
     * Creates paginated list of all album pages linked to the actual page via $AlbumFolderID.
     * Includes extras like album cover image, available album images and album page link.
     *
     * @return paginated list of folder objects
     */
    public function AlbumFolders()
    {
        // extract all subpage objects (album pages)
        $pages = $this->Children();
        if (! $pages->exists()) {
            return false;
        }

        // store subpage data in array for further usage
        $data = $pages->toNestedArray();

        // add additional information to $data array
        $albumData = new ArrayList();
        foreach ($data as $index => $pageData) {
            // extract number of assigned sub albums (child pages below actual page)
            $subAlbums = SiteTree::get()->filter('ID', $pageData['ID'])->First()->Children();
            $data[$index]['AlbumNumberSubAlbums'] = ($subAlbums) ? $subAlbums->Count() : 0;

            // extract all image objects matching $page->AlbumFolderID
            $albumImages = Image::get()->filter('ParentID', $pageData['AlbumFolderID']);

            // add extra information to data array
            $data[$index]['AlbumNumberImages'] = $albumImages->Count();
            $data[$index]['AlbumCoverImage'] = ($albumImages) ? $albumImages->First() : false;
            $data[$index]['AlbumURL'] = $pages[$index]->RelativeLink();

            // add modified subpage data to ArrayList object
            $albumData->push(new ArrayData($data[$index]));
        }
        // return paginated list of album pages
        $albumList = new PaginatedList($albumData, $this->request);

        // set page limit of displayed images to value defined in _config.php
        if ($albumList) {
            $albumsPerPage = (int) Config::inst()->get('Juanitou\FolderGallery', 'ALBUMS_PER_PAGE');
            $albumList->setPageLength($albumsPerPage);
        }

        return $albumList;
    }

    /**
     * Creates a paginated list of all image objects contained in page/album matching $AlbumFolderID
     *
     * @return paginated list with image objects of the actual album
     */
    public function AlbumImages()
    {
        // get album folder matching assigned albumFolderID
        if (! $albumFolder = Folder::get()->byID($this->AlbumFolderID)) {
            return false;
        }
        // fetch all images objects of actual folder and wrap it into paginated list
        $images = Image::get()->filter('ParentID', $albumFolder->ID)->sort($this->getImageSortOption(), $this->getImageSortOrder());
        $imageList = ($images->exists()) ? new PaginatedList($images, $this->request) : false;

        // set page limit of displayed images to value defined in _config.php
        if ($imageList) {
            $imagesPerPage = (int) Config::inst()->get('Juanitou\FolderGallery', 'IMAGES_PER_PAGE');
            $imageList->setPageLength($imagesPerPage);
        }

        return $imageList;
    }

    /**
     * Extracts maximum jQuery preview image size in pixel defined in _config/settings.yml
     *
     * @return integer Maximum preview image size in pixel
     */
    public static function getPreviewImageMaxSize()
    {
        return (int) Config::inst()->get('Juanitou\FolderGallery', 'PREVIEW_IMAGE_MAX_SIZE');
    }

    /**
     * Extracts breadcrumb settings defined in _config/settings.yml
     *
     * @return bool Flag indicating if breadcrumbs are displayed or not
     */
    public static function getShowBreadcrumbs()
    {
        return (bool) Config::inst()->get('Juanitou\FolderGallery', 'SHOW_BREADCRUMBS');
    }

    /**
     * Extracts thumbnail height in pixel defined in _config/settings.yml
     *
     * @return integer Thumbnail height in pixel
     */
    public static function getThumbnailHeight()
    {
        return (int) Config::inst()->get('Juanitou\FolderGallery', 'THUMBNAIL_IMAGE_HEIGHT');
    }

    /**
     * Extracts thumbnail width in pixel defined in _config/settings.yml
     *
     * @return integer Thumbnail width in pixel
     */
    public static function getThumbnailWidth()
    {
        return Config::inst()->get('Juanitou\FolderGallery', 'THUMBNAIL_IMAGE_WIDTH');
    }

    /**
     * Extracts the image sort option defined in _config/settings.yml
     *
     * @return string (Filename, Created, LastEdited, ExifDate)
     */
    public static function getImageSortOption()
    {
        $key = (int) Config::inst()->get('Juanitou\FolderGallery', 'IMAGE_SORT_OPTION');
        $sort_options = array(
            1 => 'FileFilename',
            2 => 'Created',
            3 => 'LastEdited',
            4 => 'ExifDate',
        );

        return (array_key_exists($key, $sort_options)) ? $sort_options[$key] : $sort_options[1];
    }

    /**
     * Extracts the image sort order defined in _config/settings.yml
     *
     * @return string (ASC, DESC)
     */
    public static function getImageSortOrder()
    {
        $key = (int) Config::inst()->get('Juanitou\FolderGallery', 'IMAGE_SORT_ORDER');
        $sort_order = array(
            1 => 'ASC',
            2 => 'DESC',
        );

        return (array_key_exists($key, $sort_order)) ? $sort_order[$key] : $sort_order[1];
    }
}
