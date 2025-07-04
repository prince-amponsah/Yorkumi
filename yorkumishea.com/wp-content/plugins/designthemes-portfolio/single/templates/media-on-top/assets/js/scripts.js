jQuery.noConflict();
jQuery(document).ready(function($){

    "use strict";

	// Template Setup

        function templateSetup() {

			jQuery('.dtportfolio-single-mediaontop-section-holder').each(function () {

				var currentWidth = window.innerWidth || document.documentElement.clientWidth;

				if(currentWidth > 767) {

					var mheight = jQuery(window).height();
					var windowWidth = jQuery(window).width();
					var fullwidth_next = jQuery(this).next('.dtportfolio-fullwidth-wrapper-fix');
					var offset = 0 - fullwidth_next.offset().left;

					jQuery(this).css('height', mheight);
					jQuery(this).css('width', windowWidth);
					jQuery(this).css('left', offset);

					jQuery(this).find('iframe').css('height', mheight);
					jQuery(this).find('iframe').css('width', windowWidth);
					jQuery(this).find('iframe').css('left', offset);

					jQuery(this).find('.wp-video').css('height', mheight);
					jQuery(this).find('.wp-video').css('width', windowWidth);
					jQuery(this).find('.wp-video').css('left', offset);

				} else {

					jQuery(this).css('width', '100%');
					jQuery(this).find('iframe').css('width', '100%');
					jQuery(this).find('.wp-video').css('width', '100%');

				}
            });
        }

        jQuery(window).on("resize", function() {
            templateSetup();
		});
		templateSetup();

});