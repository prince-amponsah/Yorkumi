jQuery.noConflict();
jQuery(document).ready(function($) {

    "use strict";

    if(jQuery('.dtportfolio-parallax').length) {
        jQuery('.dtportfolio-parallax').each(function() {
            jQuery(this).jarallax({
                imgWidth: 1366,
                imgHeight: 768
            });
        });
    }

});