jQuery.noConflict();
jQuery(document).ready(function($) {

    "use strict";

    var currentWidth = window.innerWidth || document.documentElement.clientWidth;

    jQuery('.dtportfolio-container-multiscroll').multiscroll({
        css3: true,
        scrollingSpeed: 800
    });

    jQuery('.dtportfolio-container-multiscroll').parents('.dtportfolio-container-wrapper').height(jQuery('.dtportfolio-container-multiscroll .dtportfolio-multiscroll').height());

    if(jQuery('.multiscroll-button').length) {
        jQuery('.multiscroll-button.down').on('click', function() {
            jQuery.fn.multiscroll.moveSectionDown();
        });
        jQuery('.multiscroll-button.up').on('click', function() {
            jQuery.fn.multiscroll.moveSectionUp();
        });
    }

    if(currentWidth <= 767) {

        var $holder = jQuery('.dtportfolio-container-multiscroll .dtportfolio-multiscroll');
        $holder.each(function( i, val ) {

            var $holder_class = jQuery(this).attr('class');
            var $holder_classes = $holder_class.split(' ');

            var $holder_modified_classes = new Array();
            jQuery.each( $holder_classes, function( j, value ) {

                if(value.indexOf('dtportfolio-hover-') == 0) {
                } else {
                    $holder_modified_classes.push(value);
                }

            });
            $holder_modified_classes.push('dtportfolio-hover-overlay');

            $holder_modified_classes = $holder_modified_classes.join(' ');
            jQuery(this).attr('class', $holder_modified_classes);

        });

    }

});