<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioFixedGallery' ) ) {
    class DesignThemesPortfolioFixedGallery {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'dtm_portfolio_styles', array( $this, 'add_meta_option' ) );
            add_filter( '_dt_portfolio_layout_settings', array( $this, 'additional_option' ) );
        }

        function add_meta_option( $options ) {
            $options['fixed-gallery'] = esc_html__('Fixed Gallery', 'designthemes-theme');
            return $options;
        }

        function additional_option( $options ) {
            $options[] = array(
                array(
                    'id'         => 'fixed_gallery_notice',
                    'type'       => 'notice',
                    'class'      => 'warning',
                    'content'    => esc_html__('Sidebar Layout not work for this post style.','designthemes-theme'),
                    'dependency' => array( 'layout', '==', 'fixed-gallery' )
                ),
                array(
                    'id'         => 'fixed_gallery_position',
                    'type'       => 'select',
                    'title'      => esc_html__('Gallery Position', 'designthemes-theme'),
                    'options'    => array(
                        'left'  => esc_html__('Left', 'designthemes-theme' ),
                        'right' => esc_html__('Right', 'designthemes-theme' )
                    ),
                    'default'    => 'left',
                    'attributes' => array( 'style'  => 'width: 75%;' ),
                    'dependency' => array( 'layout', '==', 'fixed-gallery' )
                ),
                array(
                    'id'         => 'fixed_gallery_header',
                    'type'       => 'switcher',
                    'title'      => esc_html__('Enable Transparent Header', 'designthemes-theme'),
                    'dependency' => array( 'layout', '==', 'fixed-gallery' )
                )
            );

            return $options;
        }
    }
}

DesignThemesPortfolioFixedGallery::instance();

/**
 * For Front end
 */
class DesignThemesPortfolioFixedGalleryFront {

    public $post_id;

    function __construct( $post_id ) {
        $this->post_id = $post_id;

        add_filter( 'body_class', array( $this, 'body_class' ) );
        add_action( 'savon_after_main_css', array( $this, 'enqueue_css' ) );
        add_action( 'savon_after_enqueue_js', array( $this, 'enqueue_js' ) );
        add_action( 'dtportfolio_single_images_swiper_slider', array( $this, 'dtportfolio_single_images_swiper_slider' ), 10, 1 );
    }

    function body_class( $classes ) {
        $classes[] = 'dtportfolio-fixed-items-page';

        $settings = get_post_meta( $this->post_id, '_dt_portfolio_layout_settings', true );
        $settings = is_array( $settings ) ? $settings : array();

        if( isset( $settings['fixed_gallery_header'] ) && $settings['fixed_gallery_header'] ) {
            $classes[] = 'dtportfolio-transparent-header';
        }

        return $classes;
    }

    function enqueue_css() {
        wp_enqueue_style( 'dtportfolio-fixed-gallery', DT_PORTFOLIO_DIR_URL . 'single/templates/fixed-gallery/assets/css/style.css', false, DT_PORTFOLIO_VERSION, 'all');
    }

    function enqueue_js() {
        wp_enqueue_script ( 'jquery-nicescroll', DT_PORTFOLIO_DIR_URL . 'single/assets/js/jquery.nicescroll.js', array ('jquery'), false, true );
        wp_enqueue_script ( 'dtportfolio-fixed-gallery', DT_PORTFOLIO_DIR_URL . 'single/templates/fixed-gallery/assets/js/scripts.js', array ('jquery'), false, true );
    }

    function dtportfolio_single_images_swiper_slider( $settings ) {

		$output = '';

        $images = array_filter( $settings['images'] );

        if(!empty( $images ) ) {

            $slides_per_view        = isset( $settings['slides_per_view'] ) ? $settings['slides_per_view']              : 1;
            $include_featured_image = isset( $settings['include_featured_image'] ) ? $settings['include_featured_image']: true;
            $use_as_bg              = isset( $settings['use_as_bg'] ) ? $settings['use_as_bg']                          : true;
            $pagination             = isset( $settings['pagination'] ) ? $settings['pagination']                        : 'bullets';

			$output .= '<div class="dtportfolio-image-gallery-holder">';

				$output .= '<div class="dtportfolio-image-gallery-container dtportfolio-fixed-gallery-container swiper-container" data-slidesperview="'.$slides_per_view.'" data-pagination="'.$pagination.'">';
				    $output .= '<div class="dtportfolio-image-gallery swiper-wrapper">';

                        if($include_featured_image == 'true') {

                            $settings = get_post_meta( $this->post_id, '_dt_feature_settings', true );
                            $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                            if( isset( $settings['image'] ) && !empty( $settings['image'] ) ) {

                                $output .= '<div class="swiper-slide">';
                                    if( isset( $use_as_bg ) && $use_as_bg ) {
                                        $image_details = wp_get_attachment_image_src($settings['image'], 'full');
                                        if( $image_details ) {
                                            $output .= '<div class="dtportfolio-single-image-holder" style="background-image:url('.esc_url($image_details[0]).');"></div>';
                                        }
                                    } else {
                                        $output .= dtportfolio_img_tag( $settings['image'] );
                                    }
                                $output .= '</div>';

                            }

                        }

                        foreach( $images as $image_id ) {
                            $output .= '<div class="swiper-slide">';
                                if( isset( $use_as_bg ) && $use_as_bg ) {
                                    $image_details = wp_get_attachment_image_src( $image_id, 'full' );
                                    if( $image_details ) {
                                        $output .= '<div class="dtportfolio-single-image-holder" style="background-image:url('.esc_url( $image_details[0] ).');"></div>';
                                    }
                                } else {
                                    $output .= dtportfolio_img_tag( $image_id );
                                }
                            $output .= '</div>';
                        }

		    		$output .= '</div>';

					$output .= '<div class="dtportfolio-swiper-pagination-holder">';

						if($pagination == 'bullets') {
							$output .= '<div class="dtportfolio-swiper-bullet-pagination"></div>';
						}

						if($pagination == 'progressbar') {
							$output .= '<div class="dtportfolio-swiper-progress-pagination"></div>';
						}

                        if($pagination == 'fraction') {
                            $output .= '<div class="dtportfolio-swiper-fraction-pagination"></div>';
                        }

                        if($pagination == 'arrow') {
                            $output .= '<div class="dtportfolio-swiper-arrow-pagination">';
                                $output .= '<a href="#" class="dtportfolio-swiper-arrow-prev">'.esc_html__('Prev', 'dtportfolio').'</a>';
                                $output .= '<a href="#" class="dtportfolio-swiper-arrow-next">'.esc_html__('Next', 'dtportfolio').'</a>';
                            $output .= '</div>';
                        }

					$output .= '</div>';

		   		$output .= '</div>';

            $output .= '</div>';

        }

        echo $output;

    }
}