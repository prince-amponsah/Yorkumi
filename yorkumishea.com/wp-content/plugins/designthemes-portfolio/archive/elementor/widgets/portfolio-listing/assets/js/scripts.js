(function ($) {

    var iLightBoxScriptLoaded = isotopeScriptLoaded = false;

	var dtPortfolioListingCore = function($scope, $){

		jQuery(window).on('resize', function() {

			portfolioIsotope();

		});

        function portfolioAnimateItems() {
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
        portfolioAnimateItems();

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

        function portfolioiLightBox() {

            iLightBoxScriptLoaded = true;

            jQuery('.dtportfolio-item').each( function() {
                var ilightboxid = jQuery(this).find('.dtportfolio-image-overlay').attr('data-ilightboxid');
                if(jQuery('.'+ilightboxid).length) {
                    jQuery('.'+ilightboxid).iLightBox({
                        attr          : 'data-ilightboximg',
                        fullViewPort  : 'stretch',
                        controls      : {
                            mousewheel: true,
                            swipe     : true,
                            thumbnail : true
                        },
                        path          : 'horizontal',
                        infinite      : true
                    });
                }
            });

        }
        if(!iLightBoxScriptLoaded) {
            portfolioiLightBox();
        }

        function portfolioIsotope() {

			isotopeScriptLoaded = true;

		    jQuery('.apply-portfolio-isotope').each(function() {

                jQuery('.apply-portfolio-isotope').isotope({
                    itemSelector: '.dtportfolio-item',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.dtportfolio-grid-sizer'
                    }
                });

/*                 setTimeout(function(){
                    jQuery(window).trigger('resize');
                }, 800); */

			});

		}
		if(!isotopeScriptLoaded) {
			portfolioIsotope();
		}

		function portfolioIsotopeSorting() {

			jQuery('div.dtportfolio-sorting').each(function() {

				var pf_sorter = jQuery(this);
				pf_sorter.find('a').on('click', function() {

					var pf_sorter_item = jQuery(this);
					var selector = pf_sorter_item.attr('data-filter');

					pf_sorter_item.parents('.dtportfolio-sorting').find('a').removeClass('active-sort');
					pf_sorter_item.addClass('active-sort');

					pf_sorter_item.parents('.dtportfolio-container-wrapper').find('.dtportfolio-container .dtportfolio-column').removeClass('animate');
					pf_sorter_item.parents('.dtportfolio-container-wrapper').find('.dtportfolio-container').isotope({
						filter: selector,
						masonry: {  },
						animationEngine : 'jquery'
					});

					//jQuery(window).trigger('resize');

					return false;

				});

			});

        }
		portfolioIsotopeSorting();


        function portfolioAjaxCall() {

            jQuery('.dtportfolio-infinite-portfolio-load-more').each(function(){

                var $this_global = jQuery(this);
                var $ajaxcall_obj = $this_global.attr('data-ajaxcall-data');
                var $ajaxcall_json = jQuery.parseJSON($ajaxcall_obj);

                var $pagination_type = $ajaxcall_json['pagination_type'];
                var $paged = $ajaxcall_json['paged'];

                if($pagination_type == 'lazy-load') {

                    jQuery(window).scroll(function(){
                        if(jQuery(window).scrollTop() == jQuery(document).height() - jQuery(window).height()){

                            var $wrapper = $this_global.parents('.dtportfolio-infinite-portfolio-wrapper');

                            $paged++;
                            $ajaxcall_json['paged'] = $paged;
                            var $ajaxcall_object = JSON.stringify($ajaxcall_json);

                            jQuery.ajax({
                                type : 'post',
                                dataType : 'html',
                                url : dtportfoliofrontendobject.ajaxurl,
                                data : {
                                    action: 'dtportfolio_ajax_infinite_portfolios',
                                    ajaxcall_json: $ajaxcall_object
                                },
                                beforeSend: function(){
                                    $this_global.prepend( '<i class="dticon-spinner"></i>' );
                                },
                                success: function (data) {

                                    data = jQuery.trim(data);

                                    if (data.length > 0) {

/*                                         if ($wrapper.find('.dtportfolio-infinite-portfolio-container').hasClass('dtportfolio-container-parallax')) {

                                            $wrapper.find('.dtportfolio-infinite-portfolio-container').append($(data));

                                            // Parallax jquery
                                            if($wrapper.find('.dtportfolio-parallax').length) {
                                                $wrapper.find('.dtportfolio-parallax').each(function() {
                                                    if($(this).attr('data-jarallax') !== undefined) {
                                                        $(this).jarallax({
                                                            imgWidth: 1366,
                                                            imgHeight: 768
                                                        });
                                                    }
                                                });
                                            }

                                        } else { */

                                            $wrapper.find('.dtportfolio-infinite-portfolio-container').isotope('insert', jQuery(data));
                                            portfolioAnimateItems();
                                            setTimeout(function(){
                                                $wrapper.find('.dtportfolio-infinite-portfolio-container').isotope('layout');
                                            }, 1600);

                                        /* } */

                                    } else {

                                        $this_global.addClass('disable');
                                        $wrapper.find('.message').removeClass('hidden');
                                        setTimeout(function(){
                                            $wrapper.find('.message').addClass('hidden');
                                        }, 5000);

                                    }

                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                },
                                complete: function(){
                                    $this_global.find('i').remove();
                                }
                            });

                        }
                    });

                } else if( $pagination_type == 'load-more') {

                    $this_global.on('click', function(e){

                        e.preventDefault();

                        var $this = jQuery(this);
                        var $wrapper = $this.parents('.dtportfolio-infinite-portfolio-wrapper');

                        $paged++;
                        $ajaxcall_json['paged'] = $paged;
                        var $ajaxcall_object = JSON.stringify($ajaxcall_json);

                        jQuery.ajax({
                            type : 'post',
                            dataType : 'html',
                            url : dtportfoliofrontendobject.ajaxurl,
                            data : {
                                action: 'dtportfolio_ajax_infinite_portfolios',
                                ajaxcall_json: $ajaxcall_object
                            },
                            beforeSend: function(){
                                $this_global.prepend( '<i class="dticon-spinner"></i>' );
                            },
                            success: function (data) {

                                data = jQuery.trim(data);

                                if (data.length > 0) {

/*                                     if ($wrapper.find('.dtportfolio-infinite-portfolio-container').hasClass('dtportfolio-container-parallax')) {

                                        $wrapper.find('.dtportfolio-infinite-portfolio-container').append($(data));

                                        // Parallax jquery
                                        if($wrapper.find('.dtportfolio-parallax').length) {
                                            $wrapper.find('.dtportfolio-parallax').each(function() {
                                                if($(this).attr('data-jarallax') !== undefined) {
                                                    $(this).jarallax({
                                                        imgWidth: 1366,
                                                        imgHeight: 768
                                                    });
                                                }
                                            });
                                        }

                                    } else { */

                                        $wrapper.find('.dtportfolio-infinite-portfolio-container').isotope('insert', $(data));
                                        portfolioAnimateItems();
                                        setTimeout(function(){
                                            $wrapper.find('.dtportfolio-infinite-portfolio-container').isotope('layout');
                                        }, 1600);

                                    /* } */

                                } else {

                                    $this.addClass('disable');
                                    $wrapper.find('.message').removeClass('hidden');
                                    setTimeout(function(){
                                        $wrapper.find('.message').addClass('hidden');
                                    }, 5000);

                                }

                            },
                            complete: function(){
                                $this_global.find('i').remove();
                            }
                        });
                    });

                }

            });

        }
        portfolioAjaxCall();


        function portfolioTemplateFullWidth() {

			jQuery('.dtportfolio-fullwidth-wrapper').each(function () {

				var windowWidth = jQuery(window).width();
				$fullwidth_next = jQuery(this).next('.dtportfolio-fullwidth-wrapper-fix');
				var offset = 0 - $fullwidth_next.offset().left;

				jQuery(this).css('width', windowWidth);
				jQuery(this).css('left', offset);

			});

        }
        portfolioTemplateFullWidth();


        function portfolioCarousel() {

			var swiperGallery = [];
			var swiperGalleryOptions = [];
			var swiperIterator = 1;

			jQuery('.dtportfolio-swiper-container').each(function() {

				var $swiperItem = jQuery(this);
				var swiperUniqueId = 'swiperuniqueid-'+swiperIterator;

				swiperGalleryOptions[swiperUniqueId] = [];
                $swiperItem.attr('id', swiperUniqueId);


                var $setttings_obj = $swiperItem.find('.swiper-wrapper').attr('data-settings');
                var $setttings = jQuery.parseJSON($setttings_obj);


				// Get swiper options
				var effect = $setttings['carousel_effect'];
				var carouselnumberofrows = 1;
				if(effect == 'multirows') {
					var carouselnumberofrows = $setttings['carousel_number_of_rows'];
				}

				var autoheight = false;

				var playpausebutton = ($setttings['carousel_play_pause_button'] == 'true') ? true : false;

				var autoplay = parseInt($setttings['carousel_auto_play'], 10);
				if(autoplay > 0) {
					swiperGalleryOptions[swiperUniqueId]['autoplay_enable'] = true;
					autoplay_enable = true;
					if(playpausebutton) {
						swiperGalleryOptions[swiperUniqueId]['autoplay_enable'] = true;
					}
				} else {
					swiperGalleryOptions[swiperUniqueId]['autoplay_enable'] = false;
					autoplay_enable = false;
					if(playpausebutton) {
						autoplay = 2000;
						swiperGalleryOptions[swiperUniqueId]['autoplay_enable'] = false;
					}
				}

				var slidesperview = parseInt($setttings['carousel_slides_per_view'], 10);

				var loopmode = ($setttings['carousel_loop_mode'] == 'true') ? true : false;
				var mousewheelcontrol = ($setttings['carousel_mousewheel_control'] == 'true') ? true : false;
				var centermode = ($setttings['carousel_center_mode'] == 'true') ? true : false;
				var verticaldirection = ($setttings['carousel_vertical_direction'] == 'true') ? true : false;
				var direction = 'horizontal';
				if(verticaldirection) {
					direction = 'vertical';
				}

				var pagination_class = '';
				var pagination_type = '';

				var paginationtype = ($setttings['carousel_pagination_type'] != '') ? $setttings['carousel_pagination_type'] : '';

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


				var thumbnailpagination = ($setttings['carousel_thumbnail_pagination'] == 'true') ? true : false;
				if(thumbnailpagination) {
					swiperGalleryOptions[swiperUniqueId]['thumbnailpagination'] = true;
					loopmode = false;
				} else {
					swiperGalleryOptions[swiperUniqueId]['thumbnailpagination'] = false;
				}

				var scrollbar_class = '';
				var	scrollbar_hide = true;
				var carouselscrollbar = ($setttings['carousel_scrollbar'] == 'true') ? true : false;
				if(carouselscrollbar) {
					scrollbar_class = $swiperItem.find('.dtportfolio-swiper-scrollbar');
					scrollbar_hide = false;
				}

				var carouselarrowformousepointer = ($setttings['carousel_arrow_for_mouse_pointer'] == 'true') ? true : false;

				var spacebetween = parseInt($setttings['carousel_space_between'], 10);
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
			    swiperGallery[swiperUniqueId] = new Swiper($swiperItem, {

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
		    	var arrowpagination = ($setttings['carousel_arrow_pagination'] == 'true') ? true : false;

		    	if(arrowpagination) {

				    $swiperItem.find('.dtportfolio-swiper-arrow-pagination .dtportfolio-swiper-arrow-prev').on('click', function(e) {
				    	var swiperUniqueId = $swiperItem.attr('id');
				        swiperGallery[swiperUniqueId].slidePrev();
				        if(swiperGalleryOptions[swiperUniqueId]['autoplay_enable']) {
				        	swiperGallery[swiperUniqueId].autoplay.start();
				        }
				        e.preventDefault();
				    });

				    $swiperItem.find('.dtportfolio-swiper-arrow-pagination .dtportfolio-swiper-arrow-next').on('click', function(e) {
				    	var swiperUniqueId = $swiperItem.attr('id');
				        swiperGallery[swiperUniqueId].slideNext();
				        if(swiperGalleryOptions[swiperUniqueId]['autoplay_enable']) {
				        	swiperGallery[swiperUniqueId].autoplay.start();
				        }
				        e.preventDefault();
				    });

				}

				// Play pause button
		    	var playpausebutton = ($setttings['carousel_play_pause_button'] == 'true') ? true : false;

		    	if(playpausebutton) {

				    $swiperItem.find('.dtportfolio-swiper-playpause').on('click', function(e) {
				    	e.preventDefault();
				    	var swiperUniqueId = $swiperItem.attr('id');
				    	if(jQuery(this).hasClass('play')) {
				    		swiperGallery[swiperUniqueId].autoplay.start();
				    	} else {
				    		swiperGallery[swiperUniqueId].autoplay.stop();
				    	}
				    	jQuery(this).toggleClass('pause play');
				    	jQuery(this).find('span').toggleClass('dticon-pause dticon-play');
				    });

				}

				if(carouselarrowformousepointer) {

				    $swiperItem.find('.dtportfolio-swiper-arrow-click.left').on('click', function(e) {
				        var swiperUniqueId = $swiperItem.attr('id');
				        swiperGallery[swiperUniqueId].slidePrev();
				        if(swiperGalleryOptions[swiperUniqueId]['autoplay_enable'] > 0 || $swiperItem.find('.dtportfolio-swiper-pagination-holder').find('.dtportfolio-swiper-playpause').hasClass('pause')) {
				        	swiperGallery[swiperUniqueId].startAutoplay();
				        }
				    	e.preventDefault();
				    });

				    $swiperItem.find('.dtportfolio-swiper-arrow-click.right').on('click', function(e) {
				    	console.log('asdsad');
				    	var swiperUniqueId = $swiperItem.attr('id');
				        swiperGallery[swiperUniqueId].slideNext();
				        if(swiperGalleryOptions[swiperUniqueId]['autoplay_enable'] > 0 || $swiperItem.find('.dtportfolio-swiper-pagination-holder').find('.dtportfolio-swiper-playpause').hasClass('pause')) {
				        	 swiperGallery[swiperUniqueId].startAutoplay();
				        }
				    	e.preventDefault();
				    });

				}

			    swiperIterator++;

			});

			for(i = 1; i < swiperIterator; i++) {
				if(swiperGalleryOptions['swiperuniqueid-'+i]['thumbnailpagination']) {

					var swiperUniqueId = 'swiperuniqueid-'+i;

					var $swiper_gallerythumb_item = jQuery('#'+swiperUniqueId).find('.dtportfolio-swiper-thumbnail-container');

					if($swiper_gallerythumb_item.length > 0) {

					    var swiperGalleryThumbs = new Swiper($swiper_gallerythumb_item, {
					    	initialSlide     : 0,
					        spaceBetween  : 10,
					        centeredSlides: true,
					        slidesPerView : 'auto',
					        touchRatio    : 0.2,
					        slideToClickedSlide: true
					    });

					    swiperGallery[swiperUniqueId].controller.control = swiperGalleryThumbs;
					    swiperGalleryThumbs.controller.control = swiperGallery[swiperUniqueId];

				    }

				}
			}

        }
        portfolioCarousel();

	};

    $(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/dt-portfolio-listing.default', dtPortfolioListingCore);
	});

	if($('body').hasClass('tax-dt_portfolio_cats') || $('body').hasClass('tax-dt_portfolio_tags')) {
		dtPortfolioListingCore();
	}

})(jQuery);