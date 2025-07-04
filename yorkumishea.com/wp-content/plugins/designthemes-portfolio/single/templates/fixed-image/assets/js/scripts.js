jQuery.noConflict();
jQuery(document).ready(function($){

    "use strict";

	// Template Setup

		function templateSetup() {

			jQuery('.dtportfolio-fullwidth-wrapper').each(function () {

				var windowWidth    = jQuery(window).width();
				var fullwidth_next = jQuery(this).next('.dtportfolio-fullwidth-wrapper-fix');
				var offset         = 0 - fullwidth_next.offset().left;

				jQuery(this).css('width', windowWidth);
				jQuery(this).css('left', offset);

			});

			var winHeight    = jQuery(window).height();
			var headerHeight = jQuery('#header-wrapper').height();
			var footerHeight = jQuery('#footer').height();

			var height = parseInt((winHeight-headerHeight-footerHeight), 10);

			var fixed_height = parseInt(height, 10) - 10;

			jQuery('.fixed-featured-image').find('.dtportfolio-fixed-content').height(height).css('top', headerHeight);

		}

		jQuery(window).on("resize", function() {
			templateSetup();
		});
		templateSetup();

});