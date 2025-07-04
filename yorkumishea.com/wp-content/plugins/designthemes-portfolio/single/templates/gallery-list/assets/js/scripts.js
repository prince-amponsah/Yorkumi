jQuery.noConflict();
jQuery(document).ready(function($){

    "use strict";


	// Template Setup

		function animateItems() {
			jQuery('.dtportfolio-item.animate').each(function(){
				jQuery(this).one('inview', function (event, visible) {
					if (visible == true) {
						var $this = jQuery(this),
						$animation = ( $this.data('animationeffect') !== undefined ) ? $this.data('animationeffect') : 'slideUp';
						var	$delay = ( $this.data('animationdelay') !== undefined ) ? $this.data('animationdelay') : 400;
						setTimeout(function() { $this.addClass($animation);	},$delay);
					}
				});
			});
			jQuery(window).scroll();
		}

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

			jQuery('.gallery-list').find('.dtportfolio-fixed-content').height(height).css('top', headerHeight);
			jQuery('.gallery-list').find('.dtportfolio-fixed-content .dtportfolio-single-image-holder').height(height);
			jQuery('.gallery-list').find('.dtportfolio-details').height(fixed_height).niceScroll({zindex: 999999, cursorborder: '1px solid #424242' });


		}

		function customMagnificPopup() {

			if( jQuery('.dtportfolio-single-container .dtportfolio-item a.magnific-popup').length ) {
				jQuery('.dtportfolio-single-container .dtportfolio-item a.magnific-popup').magnificPopup({
					type: 'image'
				});
			}

		}

		jQuery(window).on("resize", function() {
			templateSetup();
		});
		templateSetup();
		animateItems();
		customMagnificPopup();

});