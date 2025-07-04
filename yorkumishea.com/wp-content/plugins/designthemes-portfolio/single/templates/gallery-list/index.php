<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioGalleryList' ) ) {
    class DesignThemesPortfolioGalleryList {

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
            $options['gallery-list'] = esc_html__('Gallery List', 'designthemes-theme');
            return $options;
        }

        function additional_option( $options ) {
            $options[] = array(
                array(
                    'id'         => 'gallery_position',
                    'type'       => 'select',
                    'title'      => esc_html__('Gallery Position', 'designthemes-theme'),
                    'options'    => array(
                        'left'  => esc_html__('Left', 'designthemes-theme' ),
                        'right' => esc_html__('Right', 'designthemes-theme' )
                    ),
                    'default'    => 'left',
                    'attributes' => array( 'style'  => 'width: 75%;' ),
                    'dependency' => array( 'layout', '==', 'gallery-list' )
                ),
            );

            return $options;
        }
    }
}

DesignThemesPortfolioGalleryList::instance();

/**
 * For Front end
 */
class DesignThemesPortfolioGalleryListFront {

    public $post_id;

    function __construct( $post_id ) {
        $this->post_id = $post_id;
        add_filter( 'body_class', array( $this, 'body_class' ) );
        add_action( 'savon_after_main_css', array( $this, 'enqueue_css' ) );
        add_action( 'savon_after_enqueue_js', array( $this, 'enqueue_js' ) );
        add_action( 'dtportfolio_single_gallery_listing', array( $this, 'dtportfolio_single_gallery_listing' ), 10, 1 );
    }

    function body_class( $classes ) {
        $classes[] = 'dtportfolio-fixed-items-page';

        return $classes;
    }

    function enqueue_css() {
        wp_enqueue_style( 'dtportfolio-magnific-popup', DT_PORTFOLIO_DIR_URL . 'assets/css/magnific-popup.css', false, DT_PORTFOLIO_VERSION, 'all');
        wp_enqueue_style( 'dtportfolio-animation', DT_PORTFOLIO_DIR_URL . 'assets/css/animations.css', false, DT_PORTFOLIO_VERSION, 'all' );
        wp_enqueue_style( 'dtportfolio-gallery', DT_PORTFOLIO_DIR_URL . 'single/templates/gallery-list/assets/css/style.css', false, DT_PORTFOLIO_VERSION, 'all');
    }

    function enqueue_js() {
        wp_enqueue_script ( 'jquery-magnific-popup', DT_PORTFOLIO_DIR_URL . 'assets/js/jquery.inview.js', array(), false, true );
        wp_enqueue_script ( 'jquery-inview', DT_PORTFOLIO_DIR_URL . 'assets/js/jquery.inview.js', array ('jquery'), false, true );
        wp_enqueue_script ( 'jquery-nicescroll', DT_PORTFOLIO_DIR_URL . 'single/assets/js/jquery.nicescroll.js', array ('jquery'), false, true );
        wp_enqueue_script ( 'dtportfolio-gallery', DT_PORTFOLIO_DIR_URL . 'single/templates/gallery-list/assets/js/scripts.js', array ('jquery'), false, true );
    }

    function dtportfolio_single_gallery_listing( $settings ) {

		$output = '';

        $images = array_filter( $settings['images'] );

        if( !empty( $images ) ) {

            if( $settings['column'] == 1 ) {
                $column_class = 'dtportfolio-column dtportfolio-one-column';
            } elseif( $settings['column'] == 2 ) {
                $column_class = 'dtportfolio-column dtportfolio-one-half';
            } elseif( $settings['column'] == 3 ) {
                $column_class = 'dtportfolio-column dtportfolio-one-third';
            } elseif( $settings['column'] == 4 ) {
                $column_class = 'dtportfolio-column dtportfolio-one-fourth';
            } elseif( $settings['column'] == 5 ) {
                $column_class = 'dtportfolio-column dtportfolio-one-fifth';
            } elseif( $settings['column'] == 6 ) {
                $column_class = 'dtportfolio-column dtportfolio-one-sixth';
            } elseif( $settings['column'] == 7 ) {
                $column_class = 'dtportfolio-column dtportfolio-one-seventh';
            } elseif( $settings['column'] == 8 ) {
                $column_class = 'dtportfolio-column dtportfolio-one-eight';
            } elseif( $settings['column'] == 9 ) {
                $column_class = 'dtportfolio-column dtportfolio-one-nineth';
            } elseif( $settings['column'] == 10 ) {
                $column_class = 'dtportfolio-column dtportfolio-one-tenth';
            }

            $image_size = 'full';
            if($settings['column'] > 6) {
                $image_size = 'dtportfolio-420x420';
            }

            // Animation
            $animation_class = $animation_settings = '';
            if( $settings['animation_effect'] ) {
                $animation_class    = 'animate';
                $animation_settings = 'data-animationeffect="'.esc_attr( $settings['animation_effect'] ).'" data-animationdelay="'.esc_attr( $settings['animation_delay'] ).'"';
            }

            $mag_popup_class = 'magnific-popup';
            if( did_action( 'elementor/loaded' ) && get_option('elementor_global_image_lightbox') == 'yes' ) {
                $mag_popup_class = '';
            }

            $output .= '<div class="dtportfolio-container-wrapper">';
                $output .= '<div class="dtportfolio-container dtportfolio-single-container '.esc_attr( $settings['grid_space'] ).'">';

                    $grid_sizer_class = str_replace('dtportfolio-column ', '', $column_class);
                    $output .= '<div class="dtportfolio-grid-sizer '.$grid_sizer_class.'"></div>';

                    $i = 1;
                    foreach( $settings['images'] as $image_id ) {
                        $attachment = wp_get_attachment_image_src( $image_id, $image_size );
                        if( $attachment ) {

                            if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
                            if($i == $settings['column']) { $i = 1; } else { $i = $i + 1; }

                            $output .= '<div class="dtportfolio-item '.esc_attr( $column_class.' '.$first_class .' '.$animation_class.' '.$settings['grid_space'] ).'" '.$animation_settings.'>';
                                $output .= '<figure>';
                                    $output .= dtportfolio_img_tag( $image_id, $image_size );
                                    $output .= '<div class="dtportfolio-image-overlay">';
                                        $output .= '<div class="links">';
                                            $output .= '<a href="'.esc_url( $attachment[0] ).'" title="'.get_the_title( $this->post_id ).'" data-gal="prettyPhoto[gallery-listing]" class="'.esc_attr($mag_popup_class).'"><span class="dticon-search"></span></a>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                $output .= '</figure>';
                            $output .= '</div>';
                        }
                    }

                $output .= '</div>';
            $output .= '</div>';
        }

        echo $output;

    }
}