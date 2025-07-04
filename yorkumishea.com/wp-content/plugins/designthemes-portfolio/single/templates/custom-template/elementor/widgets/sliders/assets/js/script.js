(function ($) {

	var dtPortfolioSliderHandler = function($scope, $){

        var swiperSliderGallery = [];
        var swiperSliderGalleryOptions = [];
        var swiperSliderGalleryIterator = 1;

        jQuery('.dtportfolio-sliders-container.swiper-container').each(function() {

            var $swiperItem = jQuery(this);
            var swiperUniqueId = 'swiperuniqueid-'+swiperSliderGalleryIterator;

            swiperSliderGalleryOptions[swiperUniqueId] = [];
            $swiperItem.attr('id', swiperUniqueId);

            // Get swiper options
            var effect = $swiperItem.find('.swiper-wrapper').attr('data-carouseleffect');
            var carouselnumberofrows = 1;
            if(effect == 'multirows') {
                var carouselnumberofrows = ($swiperItem.find('.swiper-wrapper').attr('data-carouselnumberofrows') != '') ? $swiperItem.find('.swiper-wrapper').attr('data-carouselnumberofrows') : 1;
            }

            var autoheight = false;

            var playpausebutton = ($swiperItem.find('.swiper-wrapper').attr('data-carouselplaypausebutton') == 'true') ? true : false;

            var autoplay = parseInt($swiperItem.find('.swiper-wrapper').attr('data-carouselautoplay'), 10);
            if(autoplay > 0) {
                swiperSliderGalleryOptions[swiperUniqueId]['autoplay_enable'] = true;
                autoplay_enable = true;
                if(playpausebutton) {
                    swiperSliderGalleryOptions[swiperUniqueId]['autoplay_enable'] = true;
                }
            } else {
                swiperSliderGalleryOptions[swiperUniqueId]['autoplay_enable'] = false;
                autoplay_enable = false;
                if(playpausebutton) {
                    autoplay = 2000;
                    swiperSliderGalleryOptions[swiperUniqueId]['autoplay_enable'] = false;
                }
            }

            var slidesperview = parseInt($swiperItem.find('.swiper-wrapper').attr('data-carouselslidesperview'), 10);

            var loopmode = ($swiperItem.find('.swiper-wrapper').attr('data-carouselloopmode') == 'true') ? true : false;
            var mousewheelcontrol = ($swiperItem.find('.swiper-wrapper').attr('data-carouselmousewheelcontrol') == 'true') ? true : false;
            var centermode = ($swiperItem.find('.swiper-wrapper').attr('data-carouselcentermode') == 'true') ? true : false;
            var verticaldirection = ($swiperItem.find('.swiper-wrapper').attr('data-carouselverticaldirection') == 'true') ? true : false;
            var direction = 'horizontal';
            if(verticaldirection) {
                direction = 'vertical';
            }

            var pagination_class = '';
            var pagination_type = '';

            var paginationtype = ($swiperItem.find('.swiper-wrapper').attr('data-carouselpaginationtype') != '') ? $swiperItem.find('.swiper-wrapper').attr('data-carouselpaginationtype') : '';

            if(paginationtype == 'bullets') {
                var pagination_class = $swiperItem.find('.dtportfolio-swiper-bullet-pagination');
                var pagination_type = 'bullets';
            }

            if(paginationtype == 'fraction') {
                var pagination_class =  $swiperItem.find('.dtportfolio-swiper-fraction-pagination');
                var pagination_type = 'fraction';
            }

            if(paginationtype == 'progressbar') {
                var pagination_class =  $swiperItem.find('.dtportfolio-swiper-progress-pagination');
                var pagination_type = 'progressbar';
            }


            var thumbnailpagination = ($swiperItem.find('.swiper-wrapper').attr('data-carouselthumbnailpagination') == 'true') ? true : false;
            if(thumbnailpagination) {
                swiperSliderGalleryOptions[swiperUniqueId]['thumbnailpagination'] = true;
                loopmode = false;
            } else {
                swiperSliderGalleryOptions[swiperUniqueId]['thumbnailpagination'] = false;
            }

            var scrollbar_class = '';
            var	scrollbar_hide = true;
            var carouselscrollbar = ($swiperItem.find('.swiper-wrapper').attr('data-carouselscrollbar') == 'true') ? true : false;
            if(carouselscrollbar) {
                scrollbar_class = $swiperItem.find('.dtportfolio-swiper-scrollbar');
                scrollbar_hide = false;
            }

            var carouselarrowformousepointer = ($swiperItem.find('.swiper-wrapper').attr('data-carouselarrowformousepointer') == 'true') ? true : false;

            var spacebetween = parseInt($swiperItem.find('.swiper-wrapper').attr('data-carouselspacebetween'), 10);
            if(spacebetween) {
                spacebetween = spacebetween;
            } else {
                spacebetween = 0;
            }

            if(direction == 'vertical') {

                effect = '';

                if(slidesperview == 1) {
                    var breakpoint_slides_1 = breakpoint_slides_2 = breakpoint_slides_3 = breakpoint_slides_4 = 1;
                } else if(slidesperview == 2) {
                    var breakpoint_slides_1 = breakpoint_slides_2 = breakpoint_slides_3 = breakpoint_slides_4 = 2;;
                } else if(slidesperview == 3) {
                    var breakpoint_slides_1 = breakpoint_slides_2 = breakpoint_slides_3 = breakpoint_slides_4 = 3;
                } else if(slidesperview >= 4) {
                    var breakpoint_slides_1 = breakpoint_slides_2 = breakpoint_slides_3 = breakpoint_slides_4 = 4;
                }

            } else {

                if(slidesperview == 1) {
                    var breakpoint_slides_1 = breakpoint_slides_2 = breakpoint_slides_3 = breakpoint_slides_4 = 1;
                } else if(slidesperview == 2) {
                    var breakpoint_slides_1 = 2; var breakpoint_slides_2 = 2; var breakpoint_slides_3 = 2; var breakpoint_slides_4 = 1;
                } else if(slidesperview == 3) {
                    var breakpoint_slides_1 = 3; var breakpoint_slides_2 = 3; var breakpoint_slides_3 = 2; var breakpoint_slides_4 = 1;
                } else if(slidesperview >= 4) {
                    var breakpoint_slides_1 = 4; var breakpoint_slides_2 = 3; var breakpoint_slides_3 = 2; var breakpoint_slides_4 = 1;
                }

                if(effect == 'cube' || effect == 'fade' || effect == 'flip') {
                    var breakpoint_slides_1 = breakpoint_slides_2 = breakpoint_slides_3 = breakpoint_slides_4 = 1;
                }

            }

            // Generate swiper
            swiperSliderGallery[swiperUniqueId] = new Swiper($swiperItem, {

                 initialSlide: 0,
                simulateTouch: true,
                roundLengths: true,
                spaceBetween: spacebetween,
                keyboardControl: true,
                paginationClickable: true,
                autoHeight: autoheight,

                centeredSlides: centermode,
                grabCursor: false,
                autoplay: {
                            enabled: autoplay_enable,
                            delay: autoplay,
                        },
                slidesPerView: parseInt(slidesperview+'.2'),
                slidesPerColumn: carouselnumberofrows,
                loop:loopmode,
                mousewheel: mousewheelcontrol,
                direction: direction,

                pagination: {
                    el: pagination_class,
                    type: pagination_type,
                    clickable: true,
                    renderFraction: function (currentClass, totalClass) {
                        return '<span class="' + currentClass + '"></span>' +
                                '<span class="dtportfolio-separator"></span>' +
                                '<span class="' + totalClass + '"></span>';
                    }
                },

                scrollbar: {
                    el: scrollbar_class,
                    hide: scrollbar_hide,
                    draggable: true,
                },

                effect: effect,
                coverflowEffect: {
                    slideShadows: false,
                    rotate: 0,
                    stretch: 0,
                    depth: 200,
                    modifier: 1,
                },
                cubeEffect: {
                    slideShadows: true,
                    shadow: true,
                    shadowOffset: 20,
                    shadowScale: 0.94
                },

                breakpoints: {
                    0: {
                        slidesPerView: breakpoint_slides_4,
                    },
                    768: {
                        slidesPerView: breakpoint_slides_3,
                    },
                    1025: {
                        slidesPerView: breakpoint_slides_2,
                    },
                    1280: {
                        slidesPerView: breakpoint_slides_1,
                    }
                },

                on: {
                    init: function () {
                        if(carouselarrowformousepointer) {
                            $swiperItem.find('.dtportfolio-swiper-arrow-click').each(function() {
                                var arrow = jQuery(this);
                                jQuery(document).on('mousemove', function(event) {
                                    var arrow_parent = arrow.parent(),
                                        parent_offset = arrow_parent.offset(),
                                        pos_left = Math.min(event.pageX - parent_offset.left, arrow_parent.width()),
                                        pos_top = event.pageY - parent_offset.top;
                                    arrow.css({
                                        'left': pos_left,
                                        'top': pos_top
                                    });
                                });
                            });
                        }

                        $swiperItem.find('a[data-gal^="prettyPhoto[dtgallery]"], a[data-gal^="prettyPhoto[gallery-listing]"]').iLightBox({
                            attr: 'href',
                            fullViewPort: 'stretch',
                            controls: {
                              mousewheel: true,
                              swipe: true,
                              thumbnail: true
                            },
                            path: 'vertical',
                            infinite: true,
                        });

                    }
                },

            });


            // Arrow pagination
            var arrowpagination = ($swiperItem.find('.swiper-wrapper').attr('data-carouselarrowpagination') == 'true') ? true : false;

            if(arrowpagination) {

                $swiperItem.find('.dtportfolio-swiper-arrow-pagination .dtportfolio-swiper-arrow-prev').on('click', function(e) {
                    var swiperUniqueId = $swiperItem.attr('id');
                    swiperSliderGallery[swiperUniqueId].slidePrev();
                    if(swiperSliderGalleryOptions[swiperUniqueId]['autoplay_enable']) {
                        swiperSliderGallery[swiperUniqueId].autoplay.start();
                    }
                    e.preventDefault();
                });

                $swiperItem.find('.dtportfolio-swiper-arrow-pagination .dtportfolio-swiper-arrow-next').on('click', function(e) {
                    var swiperUniqueId = $swiperItem.attr('id');
                    swiperSliderGallery[swiperUniqueId].slideNext();
                    if(swiperSliderGalleryOptions[swiperUniqueId]['autoplay_enable']) {
                        swiperSliderGallery[swiperUniqueId].autoplay.start();
                    }
                    e.preventDefault();
                });

            }

            // Play pause button
            var playpausebutton = ($swiperItem.find('.swiper-wrapper').attr('data-carouselplaypausebutton') == 'true') ? true : false;

            if(playpausebutton) {

                $swiperItem.find('.dtportfolio-swiper-playpause').on('click', function(e) {
                    e.preventDefault();
                    var swiperUniqueId = $swiperItem.attr('id');
                    if(jQuery(this).hasClass('play')) {
                        swiperSliderGallery[swiperUniqueId].autoplay.start();
                    } else {
                        swiperSliderGallery[swiperUniqueId].autoplay.stop();
                    }
                    jQuery(this).toggleClass('pause play');
                    jQuery(this).find('span').toggleClass('dticon-pause dticon-play');
                });

            }

            if(carouselarrowformousepointer) {

                $swiperItem.find('.dtportfolio-swiper-arrow-click.left').on('click', function(e) {
                    var swiperUniqueId = $swiperItem.attr('id');
                    swiperSliderGallery[swiperUniqueId].slidePrev();
                    if(swiperSliderGalleryOptions[swiperUniqueId]['autoplay_enable'] > 0 || $swiperItem.find('.dtportfolio-swiper-pagination-holder').find('.dtportfolio-swiper-playpause').hasClass('pause')) {
                        swiperSliderGallery[swiperUniqueId].startAutoplay();
                    }
                    e.preventDefault();
                });

                $swiperItem.find('.dtportfolio-swiper-arrow-click.right').on('click', function(e) {
                    console.log('asdsad');
                    var swiperUniqueId = $swiperItem.attr('id');
                    swiperSliderGallery[swiperUniqueId].slideNext();
                    if(swiperSliderGalleryOptions[swiperUniqueId]['autoplay_enable'] > 0 || $swiperItem.find('.dtportfolio-swiper-pagination-holder').find('.dtportfolio-swiper-playpause').hasClass('pause')) {
                         swiperSliderGallery[swiperUniqueId].startAutoplay();
                    }
                    e.preventDefault();
                });

            }

            swiperSliderGalleryIterator++;

        });

        // Generate gallery thumb pagination
        for(i = 1; i < swiperSliderGalleryIterator; i++) {
            if(swiperSliderGalleryOptions['swiperuniqueid-'+i]['thumbnailpagination']) {

                var swiperUniqueId = 'swiperuniqueid-'+i;

                var $swiper_gallerythumb_item = jQuery('#'+swiperUniqueId).parents('.dtportfolio-image-gallery-holder').find('.dtportfolio-image-gallery-thumb-container');

                if($swiper_gallerythumb_item.length == 0) {
                    var $swiper_gallerythumb_item = jQuery('#'+swiperUniqueId).parents('.dtportfolio-container-wrapper').find('.dtportfolio-swiper-thumbnail-container');
                }

                if($swiper_gallerythumb_item.length > 0) {

                    var swiperSliderGalleryThumbs = new Swiper($swiper_gallerythumb_item, {
                        initialSlide: 0,
                        spaceBetween: 10,
                        centeredSlides: true,
                        slidesPerView: 'auto',
                        touchRatio: 0.2,
                        slideToClickedSlide: true
                    });

                    swiperSliderGallery[swiperUniqueId].controller.control = swiperSliderGalleryThumbs;
                    swiperSliderGalleryThumbs.controller.control = swiperSliderGallery[swiperUniqueId];

                }

            }
        }

	};


    $(window).on('elementor/frontend/init', function () {
    	elementorFrontend.hooks.addAction('frontend/element_ready/dt-portfolio-single-sliders.default', dtPortfolioSliderHandler);
    });

})(jQuery);