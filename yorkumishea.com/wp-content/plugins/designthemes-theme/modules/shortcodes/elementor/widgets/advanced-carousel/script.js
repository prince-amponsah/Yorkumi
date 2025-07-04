(function ($) {

	var dtAdvancedCarouselsWidgetHandler = function($scope, $){

        var carouselElement = $scope.find('.dt-advanced-carousel-wrapper').each(function(){
        	var $settings = $(this).data('settings');

        	var $nextArrow = $settings.nextArrow;
        	var $prevArrow = $settings.prevArrow;

        	$options = {
				'adaptiveHeight': $settings.adaptiveHeight,
				'arrows': $settings.arrows,     
				'autoplay': $settings.autoplay,     
				'autoplaySpeed': $settings.autoplaySpeed,     
				'dots': $settings.dots,     
				'draggable': $settings.draggable,     
				'swipe': $settings.swipe,     
				'infinite': $settings.infinite,     
				'pauseOnDotsHover': $settings.pauseOnDotsHover,     
				'pauseOnFocus': $settings.pauseOnFocus,     
				'pauseOnHover': $settings.pauseOnHover,
				'slidesToScroll' : $settings.slidesToScroll,     
				'slidesToShow': $settings.slidesToShow,
				'speed': $settings.speed,
				'touchMove': $settings.touchMove,     
				'vertical':$settings.vertical,
				'dotsClass':$settings.dotsClass,
				'responsive' : [
					{ 'breakpoint' : 1024, 'settings' : { 'slidesToShow': $settings.desktopSlidesToShow, 'slidesToScroll': $settings.desktopSlidesToScroll, 'infinite':$settings.infinite } },
					{ 'breakpoint' : 768, 'settings' : { 'slidesToShow': $settings.tabletSlidesToShow, 'tabletSlidesToScroll': $settings.desktopSlidesToScroll, } },
					{ 'breakpoint' : 640, 'settings' : { 'slidesToShow': $settings.mobileSlidesToShow, 'slidesToScroll': $settings.mobileSlidesToScroll, } },
					{ 'breakpoint' : 640, 'settings' : { 'slidesToShow': $settings.mobileSlidesToShow, 'slidesToScroll': $settings.mobileSlidesToScroll, } },
				]
        	};

        	if( $nextArrow !== 'undefined' ) {
        		$options.nextArrow = $nextArrow;
        	}

        	if( $prevArrow !== 'undefined' ) {
        		$options.prevArrow = $prevArrow;
        	}        	

        	$(this).slick( $options );
        });
	};

    //Elementor JS Hooks
    $(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/dt-advanced-carousel.default', dtAdvancedCarouselsWidgetHandler);
    });	
})(jQuery);