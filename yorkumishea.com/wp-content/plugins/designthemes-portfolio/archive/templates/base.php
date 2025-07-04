<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioArchiveBase' ) ) {
    class DesignThemesPortfolioArchiveBase {

        public $portfolio_id;

        public $portfolio_title;

        public $portfolio_permalink;

        public $settings;

        public $item_listing_settings;

        public function __construct($portfolio_id, $settings) {
            $this->portfolio_id        = $portfolio_id;
            $this->portfolio_title     = get_the_title($portfolio_id);
            $this->portfolio_permalink = get_permalink($portfolio_id);
            $this->settings            = $settings;

            if($this->portfolio_id > 0) {
                $listing_settings            = get_post_meta( $this->portfolio_id, '_dt_listing_settings', true );
                $this->item_listing_settings = ( is_array( $listing_settings ) && !empty( $listing_settings ) ) ? array_filter( $listing_settings ) : array();
            }
        }


        /*
        * Container & Grid Sizer - Filters & Actions
        */

            function container_filters_and_actions() {

                add_filter( 'dtportfolio_container_wrapper_classes', array ( $this, 'container_wrapper_classes' ), 5, 1 );
                add_filter( 'dtportfolio_container_attributes', array ( $this, 'container_attributes' ), 5, 1 );
                add_filter( 'dtportfolio_grid_sizer_classes', array ( $this, 'item_column_class' ), 5, 1 );

                add_action( 'dtportfolio_listings_after_container_div', array ( $this, 'carousel_pagination' ), 5 );
                add_action( 'dtportfolio_listings_before_container_div', array ( $this, 'category_filter_list' ), 5 );

            }

            function container_wrapper_classes( $classes ) {

                extract($this->settings);

                // Default Core Class

                    if(in_array($pagination_type, array ('load-more', 'lazy-load'))) {

                        array_push( $classes, 'dtportfolio-infinite-portfolio-wrapper' );

                    } elseif($listing_display_style == 'carousel') {

                        array_push( $classes, 'dtportfolio-swiper-container' );
                        array_push( $classes, 'swiper-container' );

                    } else {

                        array_push( $classes, 'dtportfolio-container-wrapper' );

                    }


                // Fullwidth Class

                    $fullwidth_class = 'dtportfolio-without-fullwidth-wrapper';
                    if($enable_fullwidth == 'true') {
                        $fullwidth_class = 'dtportfolio-fullwidth-wrapper';
                    }
                    array_push( $classes, $fullwidth_class );


                // Additional Class

                    array_push( $classes, $class );


                return $classes;

            }

            function container_attributes( $attributes ) {

                extract($this->settings);

                if(is_array($this->settings) && !empty($this->settings)) {

                    if( $listing_display_style == 'carousel' ) {

                        $filtered_settings = array_filter(
                            $this->settings,
                            function($k) {
                                return preg_match('#carousel_#', $k);
                            },
                            ARRAY_FILTER_USE_KEY
                        );

                        array_push( $attributes, 'data-settings="'.esc_js(json_encode($filtered_settings)).'"' );

                    }

                }

                return $attributes;

            }

            function item_column_class( $classes ) {

                extract($this->settings);

                switch( $column ):
                    case 10:
                        $column_class = 'dtportfolio-one-tenth';
                    break;

                    case 9:
                        $column_class = 'dtportfolio-one-nineth';
                    break;

                    case 8:
                        $column_class = 'dtportfolio-one-eight';
                    break;

                    case 7:
                        $column_class = 'dtportfolio-one-seventh';
                    break;

                    case 6:
                        $column_class = 'dtportfolio-one-sixth';
                    break;

                    case 5:
                        $column_class = 'dtportfolio-one-fifth';
                    break;

                    default:
                    case 4:
                        $column_class = 'dtportfolio-one-fourth';
                    break;

                    case 3:
                        $column_class = 'dtportfolio-one-third';
                    break;

                    case 2:
                        $column_class = 'dtportfolio-one-half';
                    break;

                    case 1:
                        $column_class = 'dtportfolio-one-column';
                    break;
                endswitch;

                if( !in_array( 'dtportfolio-grid-sizer', $classes) ) {
                    $column_class = 'dtportfolio-column '.$column_class;
                }

                array_push( $classes, $column_class );

                return $classes;

            }

            function carousel_pagination() {

                extract($this->settings);

                $output = '';

                if( $listing_display_style == 'carousel' ) {

                    if($content_over_slider != '') {
                        $output .= '<div class="dtportfolio-content-over-slider">';
                            $output .= do_shortcode($content_over_slider);
                        $output .= '</div>';
                    }

                    $output .= '<div class="dtportfolio-swiper-pagination-holder '.$carousel_pagination_color_scheme.' '.$carousel_pagination_design_type.'">';

                        if($carousel_arrow_for_mouse_pointer == 'true') {

                            $output .= '<div class="dtportfolio-swiper-arrow-mouse-pointer">
                                            <div class="dtportfolio-swiper-arrow-left">
                                                <div class="dtportfolio-swiper-arrow-click left">
                                                    <div class="dtportfolio-swiper-arrow"></div>
                                                </div>
                                            </div>
                                            <div class="dtportfolio-swiper-arrow-middle">
                                                <div class="dtportfolio-swiper-arrow-click middle">
                                                    <div class="dtportfolio-swiper-arrow"></div>
                                                </div>
                                            </div>
                                            <div class="dtportfolio-swiper-arrow-right">
                                                <div class="dtportfolio-swiper-arrow-click right">
                                                    <div class="dtportfolio-swiper-arrow"></div>
                                                </div>
                                            </div>
                                        </div>';

                        }

                        if($carousel_pagination_type == 'bullets') {
                            $output .= '<div class="dtportfolio-swiper-bullet-pagination"></div>';
                        }

                        if($carousel_pagination_type == 'progressbar') {
                            $output .= '<div class="dtportfolio-swiper-progress-pagination"></div>';
                        }

                        if($carousel_scrollbar == 'true') {
                            $output .= '<div class="dtportfolio-swiper-scrollbar"></div>';
                        }

                        if(in_array($carousel_pagination_design_type, array ('type2', 'type3'))) {
                            $output .= '<div class="dtportfolio-swiper-pagination-wrapper">';
                        }

                            if($carousel_pagination_type == 'fraction') {
                                $output .= '<div class="dtportfolio-swiper-fraction-pagination"></div>';
                            }

                            if($carousel_arrow_pagination == 'true') {
                                $output .= '<div class="dtportfolio-swiper-arrow-pagination '.$carousel_arrow_pagination_type.'">';
                                    $output .= '<a href="#" class="dtportfolio-swiper-arrow-prev">'.esc_html__('Prev', 'dtportfolio').'</a>';
                                    $output .= '<a href="#" class="dtportfolio-swiper-arrow-next">'.esc_html__('Next', 'dtportfolio').'</a>';
                                $output .= '</div>';
                            }

                            if($carousel_play_pause_button == 'true') {
                                if($carousel_auto_play > 0) {
                                    $output .= '<a href="#" class="dtportfolio-swiper-playpause pause"><span class="dticon-pause"></span></a>';
                                } else {
                                    $output .= '<a href="#" class="dtportfolio-swiper-playpause play"><span class="dticon-play"></span></a>';
                                }
                            }

                        if(in_array($carousel_pagination_design_type, array ('type2', 'type3'))) {
                            $output .= '</div>';
                        }

                    $output .= '</div>';

                    if($carousel_thumbnail_pagination == 'true') {
                        $output .= '<div class="dtportfolio-swiper-thumbnail-container swiper-container">';
                            $output .= '<div class="dtportfolio-swiper-thumbnail swiper-wrapper">';
                                $output .= implode('', apply_filters('dtportfolio_listings_swiper_thumbnail_pagination', array ()));
                            $output .= '</div>';
                        $output .= '</div>';
                    }

                }

                echo $output;

            }

            function swiper_thumbnail_pagination( $html ) {

                array_push( $html, '<div class="swiper-slide" style="background-image:url('.$this->html_featured_image( 'thumbnail' ).')"></div>' );

                return $html;

            }

            function category_filter_list() {

                extract($this->settings);

                $output = '';

                if($filter == 'true') {

                    $cat_args = array (
                        'taxonomy'   => 'dt_portfolio_cats',
                        'hide_empty' => 1
                    );

                    if(!empty($categories)) {
                        $cat_args['include'] = $categories;
                    }

                    $categories = get_categories($cat_args);


                    if( count($categories) > 1 ) {

                        $output .= '<div class="dtportfolio-sorting '.esc_attr($post_style).' '.esc_attr($filter_design_type).'">';
                            $output .= ' <a href="#" class="active-sort" title="" data-filter=".all-sort">'.esc_html__('All','dtportfolio').'</a>';
                            foreach( $categories as $category ) {
                                $output .= '<a href="#" data-filter=".'.esc_attr($category->category_nicename).'-sort">'.esc_html($category->cat_name).'</a>';
                            }
                        $output .= '</div>';

                    }

                }

                echo $output;

            }



        /*
        * Reset All Filters & Actions - Container
        */

            function reset_all_container_filters_and_actions() {

                remove_all_filters( 'dtportfolio_container_wrapper_classes' );
                remove_all_filters( 'dtportfolio_container_classes' );
                remove_all_filters( 'dtportfolio_container_attributes' );
                remove_all_filters( 'dtportfolio_grid_sizer_classes' );

                remove_all_actions( 'dtportfolio_listings_after_container_div' );
                remove_all_actions( 'dtportfolio_listings_before_container_div' );

            }

        /*
        * Filters & Actions - Item
        */

            function item_grid_space_class( $classes ) {

                extract($this->settings);

                if($grid_space == 'true') {
                    array_push( $classes, 'with-space' );
                } else {
                    array_push( $classes, 'no-space' );
                }

                return $classes;

            }

            function item_category_filter_class( $classes ) {

                extract($this->settings);

                if($filter == 'true') {

                    array_push( $classes, 'all-sort' );

                    $item_categories = get_the_terms( $this->portfolio_id, 'dt_portfolio_cats' );
                    if(is_object($item_categories) || is_array($item_categories)) {
                        foreach ($item_categories as $category) {
                            array_push($classes, $category->slug.'-sort');
                        }
                    }

                }

                return $classes;

            }

            function item_common_class( $classes ) {

                extract($this->settings);

                // Show Details Image
                    if($details_position != '') {
                        array_push( $classes, $details_position );
                    }

                // Hover Style
                    if($column > 4 && $hover_style != 'art' && $hover_style != 'highlighter') {
                        array_push( $classes, 'dtportfolio-hover-overlay') ;
                    } else if($hover_style != '') {
                        array_push( $classes, 'dtportfolio-hover-'.$hover_style) ;
                    }

                // Cursor Hover Style
                    array_push( $classes, $cursor_hover_style );

                // Display Style
                    if( $listing_display_style == 'carousel' ) {
                        array_push( $classes, 'swiper-slide' );
                    }

                return $classes;

            }

            function item_misc_hover_state_class( $classes ) {

                extract($this->settings);

                if($disable_misc_options == 'true') {

                    if( $misc_hover_state == 'true' ) {
                        array_push( $classes, 'hover-state' );
                    }

                } else {

                    if( isset($this->item_listing_settings['hover_state']) && !empty($this->item_listing_settings['hover_state']) ) {
                        array_push( $classes, 'hover-state' );
                    }

                }

                return $classes;

            }

            function item_misc_masonry_size_class( $classes ) {

                extract($this->settings);

                if($masonry_size == 'true') {

                    if( isset($this->item_listing_settings['masonry_size']) && !empty($this->item_listing_settings['masonry_size']) ) {
                        array_push( $classes, $this->item_listing_settings['masonry_size'] );
                    }

                }

                return $classes;

            }

            function item_misc_animation_class( $classes ) {

                extract($this->settings);

                if($disable_misc_options == 'true') {

                    if( $misc_animation_effect != '' ) {
                        array_push( $classes, 'animate' );
                    }

                } else {

                    if( isset($this->item_listing_settings['animation_effect']) && !empty($this->item_listing_settings['animation_effect']) ) {
                        array_push( $classes, 'animate' );
                    }

                }


                return $classes;

            }

            function item_misc_animation_attributes( $attributes ) {

                extract($this->settings);

                if($disable_misc_options == 'true') {

                    // Animation
                        if( $misc_animation_effect != '' ) {
                            array_push( $attributes, 'data-animationeffect="'.$misc_animation_effect.'"' );
                            array_push( $attributes, 'data-animationdelay="'.$misc_animation_delay.'"' );
                        }

                } else {

                    // Animation
                        if( isset($this->item_listing_settings['animation_effect']) && !empty($this->item_listing_settings['animation_effect']) ) {
                            array_push( $attributes, 'data-animationeffect="'.$this->item_listing_settings['animation_effect'].'"' );
                            array_push( $attributes, 'data-animationdelay="'.$this->item_listing_settings['animation_delay'].'"' );
                        }

                }

                return $attributes;

            }


        /*
        * Reset All Filters & Actions - Item
        */

            function reset_all_item_filters_and_actions() {

                remove_all_filters( 'dtportfolio_item_classes' );
                remove_all_filters( 'dtportfolio_item_attributes' );

            }

        /*
        * Assets Load
        */

            function assets_load() {

                extract($this->settings);

                $css = '';

                $css_files = glob(DT_PORTFOLIO_DIR_PATH . 'archive/templates/'.$post_style.'/assets/css/*.css');
                if(is_array($css_files) && !empty($css_files)) {
                    $css .= '<style type="text/css">';
                    foreach($css_files as $css_file) {
                        if( file_exists ( $css_file ) ) {
                            ob_start();
                            include( $css_file );
                            $css .= "\n\n".ob_get_clean();
                        }
                    }
                    $css .= '</style>';
                }

                $js = '';

                $js_files = glob(DT_PORTFOLIO_DIR_PATH . 'archive/templates/'.$post_style.'/assets/js/*.js');
                if(is_array($js_files) && !empty($js_files)) {
                    $js .= '<script type="text/javascript">';
                    foreach($js_files as $js_file) {
                        if( file_exists ( $js_file ) ) {
                            ob_start();
                            include( $js_file );
                            $js .= "\n\n".ob_get_clean();
                        }
                    }
                    $js .= '</script>';
                }

                return $css.$js;

            }


        /*
        * HTML
        */

            // Title

            function html_title() {

                $output = '<h2><a href="'.esc_url($this->portfolio_permalink).'" title="'.esc_attr($this->portfolio_title).'">'.esc_html($this->portfolio_title).'</a></h2>';

                return $output;

            }

            // Terms

            function html_terms() {

                $output = get_the_term_list($this->portfolio_id, 'dt_portfolio_cats', '<p class="categories">', ', ', '</p>');

                return $output;

            }

            // Featured Image

            function html_featured_image( $image_size = 'full' ) {

                extract($this->settings);

                if($column > 6) {

                    $image_size = 'dtportfolio-750x650';
                    $image_src_url = 'http://place-hold.it/750x650.jpg&text='.$this->portfolio_title;

                } else {

                    if($image_size == 'thumbnail') {
                        $image_src_url = 'http://place-hold.it/150x150.jpg&text='.$this->portfolio_title;
                    } else if($image_size == 'dtportfolio-635x1100') {
                        $image_src_url = 'http://place-hold.it/635x1100.jpg&text='.$this->portfolio_title;
                    } else {
                        $image_src_url = 'http://place-hold.it/1170X902.jpg&text='.$this->portfolio_title;
                    }

                }

                $feature_settings = get_post_meta( $this->portfolio_id, '_dt_feature_settings', true );
                $feature_settings = is_array( $feature_settings ) ? array_filter( $feature_settings ): array();

                if( isset( $feature_settings['image'] ) && !empty( $feature_settings['image'] ) ) {

                    $image_src = wp_get_attachment_image_src( $feature_settings['image'], $image_size );
                    if( $image_src ) {
                        $image_src_url = $image_src[0];
                    }

                }

                return $image_src_url;

            }

    }
}