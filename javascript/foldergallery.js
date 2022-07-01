/**
 * A lightweight folder based gallery module for the CMS SilverStripe
 *
 * Default settings for the jQuery colorbox plugin.
 *
 * LICENSE: GNU General Public License 3.0
 *
 * @platform    CMS SilverStripe 4 (or higher)
 * @package     juanitou-foldergallery
 * @author      cwsoft (http://cwsoft.de)
 * @author      Juanitou (https://juanmolina.eu/)
 * @copyright   cwsoft
 * @copyright   Juanitou
*/

(function($) {
	$(document).ready(function(){
		var gallery = $("a[rel='album']").colorbox({
			transition: 'fade', 	// fade, elastic, none
			speed: 300,
			maxWidth: '99%',
			maxHeight: '99%',
			current: '{current}/{total}',
			arrowKey: true,
			escKey: true,
			slideshow: false,
			slideshowSpeed: 3500,
			slideshowStart: ss.i18n._t('foldergallery.START_SLIDESHOW'),
			slideshowStop: ss.i18n._t('foldergallery.STOP_SLIDESHOW'),

			// add additional button to display a full-scale picture from jQuery preview
			title: function(){
				// check if displayed jQuery preview image was resized by SilverStripe
				var myregex = /__Fit.*\./i;
				var match = myregex.exec(this.href);
				if (match == null) {
					// jQuery shows original sized image, return image title
					return this.title;
				}

				// fetch URL to original image from resized image URL
				var originalImageUrl = this.href.replace(match, '.');

				// insert link to left side of the jQuery close button to display original image in new window
				$("#cboxClose").after('<a href="' + originalImageUrl + '" target="_blank" class="cboxFullSizeView" title="' + ss.i18n._t('foldergallery.FULL_SCALE') +'">' + ss.i18n._t('foldergallery.FULL_SCALE') + '</a>');

				// re-position the optional start/stop slideshow text to consider extra space of the inserted button
				$("#cboxSlideshow").css({"right": "52px", "text-transform": "none"});

                // add title to the slideshow button
                $("#cboxSlideshow").attr("title", ss.i18n._t('foldergallery.STOP_SLIDESHOW'));
                $("#cboxSlideshow").on("click", function(){
                    $(this).attr("title", ss.i18n._t('foldergallery.START_SLIDESHOW'));
                });

				// return default jQuery image title
				return this.title;
			},

			onClosed: function(){
				gallery.colorbox({slideshow: false});
			}
		});

		// make start slideshow text link visible and register callback to start slideshow
		$("a#cboxStartSlideShow").removeClass("hidden").on("click", function() {
			gallery.colorbox({slideshow: true}).eq(0).click();
		});
	});
}(jQuery));
