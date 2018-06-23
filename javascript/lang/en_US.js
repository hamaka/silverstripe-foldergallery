if (typeof(ss) == 'undefined' || typeof(ss.i18n) == 'undefined') {
    if (typeof(console) != 'undefined') console.error('Class ss.i18n not defined');

} else {
    ss.i18n.addDictionary('en_US', {
        'foldergallery.FULL_SCALE': 'Full-scale',
        'foldergallery.START_SLIDESHOW': 'start slideshow',
        'foldergallery.STOP_SLIDESHOW': 'stop slideshow'
    });
}
