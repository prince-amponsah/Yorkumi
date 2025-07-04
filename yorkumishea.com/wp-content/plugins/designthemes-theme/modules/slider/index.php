<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesSlider' ) ) {
    class DesignThemesSlider {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            $this->frontend();
        }

        function load_modules() {
            include_once DT_THEME_DIR_PATH.'modules/slider/metabox/index.php';
        }

        function frontend() {
            add_action( 'savon_after_main_css', array( $this, 'enqueue_assets' ) );
            add_action( 'savon_slider', array( $this, 'load_template' ), 11 );
        }

        function enqueue_assets() {

            if ( is_singular( 'page') ) {
                $settings = get_post_meta( get_queried_object_id(), '_dt_slider_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();
                
                if( isset( $settings['show'] ) && isset( $settings['type']) ) {
                    wp_enqueue_style( 'site-slider', DT_THEME_DIR_URL . 'modules/slider/assets/css/dt-slider.css', false, DT_THEME_VERSION, 'all' );
                }
            }
        }

        function load_template() {

            if ( is_singular( 'page') ) {
                $settings = get_post_meta( get_queried_object_id(), '_dt_slider_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();
                
                if( isset( $settings['show'] ) && isset( $settings['type']) ) {
                    $type = $settings['type'];
                    $id   = isset( $settings[$type] ) ? $settings[$type] : '';
                    echo dt_theme_get_template_part( 'slider/layouts/'.$type, '/template', '', array( 'code' => $id ) );
                }
            }            
        }

    }
}

DesignThemesSlider::instance();