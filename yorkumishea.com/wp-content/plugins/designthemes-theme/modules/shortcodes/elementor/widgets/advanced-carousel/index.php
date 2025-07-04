<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesAdvancedCarouselWidget' ) ) {
    class DesignThemesAdvancedCarouselWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
            add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_widget_styles' ) );
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_widget_scripts' ) );
            add_action( 'elementor/preview/enqueue_styles', array( $this, 'register_preview_styles') );
        }

        function register_widgets( $widgets_manager ) {
            require DT_THEME_DIR_PATH. 'modules/shortcodes/elementor/widgets/advanced-carousel/class-widget-advanced-carousel.php';
            $widgets_manager->register( new \Elementor_Advanced_Carousel() );
        }

        function register_widget_styles() {
            wp_register_style( 'jquery-slick',
                DT_THEME_DIR_URL . 'modules/shortcodes/elementor/widgets/assets/css/slick.css', array(), DT_THEME_VERSION );
            wp_register_style( 'dt-advanced-carousel',
                DT_THEME_DIR_URL . 'modules/shortcodes/elementor/widgets/advanced-carousel/style.css', array(), DT_THEME_VERSION );
        }

        function register_widget_scripts() {
            wp_register_script( 'jquery-slick',
                DT_THEME_DIR_URL . 'modules/shortcodes/elementor/widgets/assets/js/slick.min.js', array('jquery'), DT_THEME_VERSION, true );
            wp_register_script( 'dt-advanced-carousel',
                DT_THEME_DIR_URL . 'modules/shortcodes/elementor/widgets/advanced-carousel/script.js', array(), DT_THEME_VERSION, true );
        }

        function register_preview_styles() {
            wp_enqueue_style( 'jquery-slick' );
            wp_enqueue_style( 'dt-advanced-carousel' );
            wp_enqueue_script( 'jquery-slick' );
            wp_enqueue_script( 'dt-advanced-carousel' );
        }
    }
}

DesignThemesAdvancedCarouselWidget::instance();