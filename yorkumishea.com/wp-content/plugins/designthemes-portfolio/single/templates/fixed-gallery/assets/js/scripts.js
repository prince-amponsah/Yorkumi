jQuery.noConflict();
jQuery(document).ready(function($){

    "use strict";

	// Carousel

		var swiperFixedGallery = [];
		var swiperFixedGalleryIterator = 1;

		jQuery('.dtportfolio-fixed-gallery-container.swiper-container').each(function() {

			var $swiperItem = jQuery(this);
			var swiperUniqueId = 'swiperuniqueid-'+swiperFixedGalleryIterator;
			$swiperItem.attr('id', swiperUniqueId);


			var slidesperview = parseInt($swiperItem.attr('data-slidesperview'), 10);

			var pagination_class = '';
			var pagination_type = '';

			var pagination = ($swiperItem.attr('data-pagination') != '') ? $swiperItem.attr('data-pagination') : 'bullets';

			if(pagination == 'bullets') {
				var pagination_class = $swiperItem.find('.dtportfolio-swiper-bullet-pagination');
				var pagination_type = 'bullets';
			}

			if(pagination == 'fraction') {
				var pagination_class =  $swiperItem.find('.dtportfolio-swiper-fraction-pagination');
				var pagination_type = 'fraction';
			}

			if(pagination == 'progressbar') {
				var pagination_class =  $swiperItem.find('.dtportfolio-swiper-progress-pagination');
				var pagination_type = 'progressbar';
			}

			// Generate swiper
			swiperFixedGallery[swiperUniqueId] = new Swiper($swiperItem, {

				initialSlide: 0,
				simulateTouch: true,
				roundLengths: true,
				grabCursor: true,

				slidesPerView: slidesperview,
				mousewheel: true,
				direction: 'horizontal',

				pagination: {
					el: pagination_class,
					type: pagination_type,
					clickable: true
				}

			});

			// Arrow pagination
			if(pagination == 'arrow') {

				$swiperItem.find('.dtportfolio-swiper-arrow-pagination .dtportfolio-swiper-arrow-prev').on('click', function(e) {
					var swiperUniqueId = $swiperItem.attr('id');
					swiperFixedGallery[swiperUniqueId].slidePrev();
					e.preventDefault();
				});

				$swiperItem.find('.dtportfolio-swiper-arrow-pagination .dtportfolio-swiper-arrow-next').on('click', function(e) {
					var swiperUniqueId = $swiperItem.attr('id');
					swiperFixedGallery[swiperUniqueId].slideNext();
					e.preventDefault();
				});

			}

			swiperFixedGalleryIterator++;

		});


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

			jQuery('.fixed-gallery').find('.dtportfolio-fixed-content').height(height).css('top', headerHeight);
			jQuery('.fixed-gallery').find('.dtportfolio-fixed-content .dtportfolio-single-image-holder').height(height);
			jQuery('.fixed-gallery').find('.dtportfolio-details').height(fixed_height).niceScroll({zindex: 999999, cursorborder: '1px solid #424242' });

		}

		jQuery(window).on("resize", function() {
			templateSetup();
		});
		templateSetup();

});