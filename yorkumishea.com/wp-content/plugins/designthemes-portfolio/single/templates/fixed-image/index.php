<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesPortfolioFixedFeaturedImage' ) ) {
    class DesignThemesPortfolioFixedFeaturedImage {

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
            $options['fixed-image'] = esc_html__('Fixed Featured Image', 'designthemes-theme');
            return $options;
        }

        function additional_option( $options ) {
            $options[] = array(
                array(
                    'id'         => 'fixed_image_notice',
                    'type'       => 'notice',
                    'class'      => 'warning',
                    'content'    => esc_html__('Sidebar Layout not work for this post style.','designthemes-theme'),
                    'dependency' => array( 'layout', '==', 'fixed-image' )
                ),
                array(
                    'id'         => 'fixed_image_position',
                    'type'       => 'select',
                    'title'      => esc_html__('Image Position', 'designthemes-theme'),
                    'options'    => array( 
                        'left'  => esc_html__('Left', 'designthemes-theme' ),
                        'right' => esc_html__('Right', 'designthemes-theme' )
                    ),
                    'default'    => 'left',
                    'attributes' => array( 'style'  => 'width: 75%;' ),
                    'dependency' => array( 'layout', '==', 'fixed-image' )
                ),
                array(
                    'id'         => 'fixed_image_header',
                    'type'       => 'switcher',
                    'title'      => esc_html__('Enable Transparent Header', 'designthemes-theme'),
                    'dependency' => array( 'layout', '==', 'fixed-image' )
                )
            );
            return $options;
        }       
    }
}

DesignThemesPortfolioFixedFeaturedImage::instance();

/**
 * For Front end 
 */
class DesignThemesPortfolioFixedImageFront {

    public $post_id;

    function __construct( $post_id ) {
        $this->post_id = $post_id;
        add_filter( 'body_class', array( $this, 'body_class' ) );
        add_action( 'savon_after_main_css', array( $this, 'enqueue_css' ) );
        add_action( 'savon_after_enqueue_js', array( $this, 'enqueue_js' ) );
    }

    function body_class( $classes ) {
        $classes[] = 'dtportfolio-fixed-items-page';

        $settings = get_post_meta( $this->post_id, '_dt_portfolio_layout_settings', true );
        $settings = is_array( $settings ) ? $settings : array();

        if( isset( $settings['fixed_image_header'] ) && $settings['fixed_image_header'] ) {
            $classes[] = 'dtportfolio-transparent-header';
        }

        return $classes;
    }

    function enqueue_css() {
        wp_enqueue_style( 'dtportfolio-fixed-image', DT_PORTFOLIO_DIR_URL . 'single/templates/fixed-image/assets/css/style.css', false, DT_PORTFOLIO_VERSION, 'all');
    }

    function enqueue_js() {
        wp_enqueue_script ( 'jquery-nicescroll', DT_PORTFOLIO_DIR_URL . 'single/assets/js/jquery.nicescroll.js', array ('jquery'), false, true );
        wp_enqueue_script ( 'dtportfolio-fixed-image', DT_PORTFOLIO_DIR_URL . 'single/templates/fixed-image/assets/js/scripts.js', array ('jquery'), false, true );
    }

}