( function( $ ) {

	var dtSingleGalleryListings = function($scope, $){

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
		}
		animateItems();


		function portfolioRepeatAnimation() {
			var divs = jQuery('.dtportfolio-container.repeat-animation .dtportfolio-item.animate');
			if(divs.length) {
				setTimeout(function() {
					var index = Math.floor(Math.random() * divs.length);
					divs.eq(index).removeClass(divs.eq(index).data('animationeffect'));
					setTimeout(function() {
						divs.eq(index).addClass(divs.eq(index).data('animationeffect'));
						portfolioRepeatAnimation();
					}, 200);
				}, ~~(Math.random()*(300-60+1)+2000));
			}
		}
		portfolioRepeatAnimation();

	};

    $(window).on('elementor/frontend/init', function(){
		elementorFrontend.hooks.addAction('frontend/element_ready/dt-portfolio-single-gallery-listing.default', dtSingleGalleryListings);
    });

} )( jQuery );