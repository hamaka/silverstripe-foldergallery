<?php
/**
 * A lightweight folder based gallery module for the CMS SilverStripe
 *
 * Extends SilverStripe image object to provide Caption() and EXIF data.
 * 
 * LICENSE: GNU General Public License 3.0
 * 
 * @platform    CMS SilverStripe 3.1.x (or higher)
 * @package     cwsoft-foldergallery
 * @author      cwsoft (http://cwsoft.de)
 * @copyright   cwsoft
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
*/

class cwsFolderGalleryImageExtension extends DataExtension {
	// decorate Image object with additional ExifDate field
	private static $db = array('ExifDate' => 'SS_Datetime');

	/**
	 * Creates a nice looking image caption from an image filename.
	 * Optional order numbers and file extensions are stripped off.
	 * Example: "xxx-your-image-description.ext" ==> "Your image description"
	 *
	 * @return string Image caption created from filename
	 */
	public function Caption() {
		if (preg_match('#(\d*-)?(.+)\.(jpg|jpeg|gif|png|tif|tiff)#i', $this->owner->Title, $matches)) {
			return ucfirst(str_replace('-', ' ', $matches[2]));
		}
		return $this->owner->Title;
	}

	/**
	 * Returns EXIF info defined by $field from images (JPEG, TIFF) stored by the camera.
	 *
	 * @param string $field String with EXIF field to be returned
	 * @return EXIF data or null
	 */
	public function ExifData($field='DateTimeOriginal') {
		// only JPEG and TIFF files contain EXIF data
		$image_extension = strtolower($this->owner->Extension);
		if (! in_array($image_extension, array('jpg', 'jpeg', 'tif', 'tiff'))) {
			return null;
		}
		
		// extract requested EXIF field
		$image_path = Director::getAbsFile($this->owner->Filename);
		$exif_data = @exif_read_data($image_path, 'EXIF', false, false);
		$exif_field = isset($exif_data[$field]) ? $exif_data[$field] : null;
		return $exif_field;
	}

	/**
	 * Creates/updates the ExifDate database column of all image objects.
	 *
	 * @param integer $parentId (if set only image objects assigned to this ID are updated)
	 * @return void
	 */
	public static function writeExifDates($parentId=null) {
		// fetch all requested image objects
		if (is_numeric($parentId)) {
			$images = Image::get()->filter('ParentID', $parentId);
		} else {
			$images = Image::get();
		}
		
		if (! $images->exists()) return false;
		
		// write/update Image.ExifDate database columns
		foreach ($images as $image) {
			// get exif original storage date if available
			$exif_date = $image->ExifData($field='DateTimeOriginal');
			$exif_date = is_null($exif_date) ? $image->Created : $exif_date;
			
			// update database field
			$image->ExifDate = $exif_date;
			$image->write();
		}
	}
}